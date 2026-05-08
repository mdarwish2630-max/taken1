<?php
/**
 * Subscription Controller
 * متحكم الاشتراكات - مع نظام طلبات الأدمن
 */
class SubscriptionController extends Controller
{
    private $planModel;
    private $tenantModel;

    public function __construct()
    {
        parent::__construct();
        if (Auth::isAdmin()) {
            Session::error('هذه الصفحة متاحة للعملاء فقط');
            $this->redirect('/admin');
        }
        $this->requireAuth();
        $this->setLayout('dashboard');
        $this->planModel = $this->model('SubscriptionPlan');
        $this->tenantModel = $this->model('Tenant');
    }

    /**
     * عرض صفحة الاشتراك الرئيسية (Overview)
     */
    public function overview()
    {
        $tenant = Auth::tenant();

        // إحصائيات الاستخدام
        $stats = (object) [];
        try {
            $db = Database::getInstance();
            $stats->services_count = $db->query("SELECT COUNT(*) as c FROM services WHERE tenant_id = ?", [$tenant->id])->first()->c ?? 0;
            $stats->gallery_count = $db->query("SELECT COUNT(*) as c FROM gallery WHERE tenant_id = ?", [$tenant->id])->first()->c ?? 0;
            $stats->banners_count = $db->query("SELECT COUNT(*) as c FROM banners WHERE tenant_id = ?", [$tenant->id])->first()->c ?? 0;
            $stats->pages_count = $db->query("SELECT COUNT(*) as c FROM pages WHERE tenant_id = ?", [$tenant->id])->first()->c ?? 0;
        } catch (\Exception $e) {
            $stats = (object) ['services_count' => 0, 'gallery_count' => 0, 'banners_count' => 0, 'pages_count' => 0];
        }

        $currentSubscription = $this->getCurrentSubscription($tenant->id);
        $currentPlan = null;
        if ($currentSubscription) {
            $currentPlan = $this->planModel->find($currentSubscription->plan_id);
        }

        // التحقق من وجود طلب معلق
        $pendingRequest = $this->getPendingRequest($tenant->id);

        $this->view('dashboard/subscription', [
            'title' => lang('subscription') ?? 'الاشتراك',
            'tenant' => $tenant,
            'stats' => $stats,
            'currentSubscription' => $currentSubscription,
            'currentPlan' => $currentPlan,
            'pendingRequest' => $pendingRequest
        ]);
    }

    /**
     * عرض خطط الاشتراك المتاحة
     */
    public function plans()
    {
        $tenant = Auth::tenant();
        $plans = $this->planModel->getActivePlans();
        $currentSubscription = $this->getCurrentSubscription($tenant->id);

        $this->view('dashboard/subscription-plans', [
            'title' => lang('subscription_plans') ?? 'خطط الاشتراك',
            'tenant' => $tenant,
            'plans' => $plans,
            'currentPlan' => $currentSubscription
        ]);
    }

    /**
     * اختيار خطة - التوجيه لصفحة الدفع
     */
    public function selectPlan($planId)
    {
        $this->verifyCsrf();
        $tenant = Auth::tenant();
        $plan = $this->planModel->find($planId);

        if (!$plan) {
            Session::error(lang('plan_not_found') ?? 'الخطة غير موجودة');
            $this->redirect('/dashboard/subscription-plans');
        }

        // التحقق من وجود طلب معلق
        $pendingRequest = $this->getPendingRequest($tenant->id);
        if ($pendingRequest) {
            Session::error(lang('pending_request_exists') ?? 'لديك طلب معلق بالفعل، انتظر مراجعة الإدارة');
            $this->redirect('/dashboard/subscription');
        }

        $_SESSION['selected_plan_id'] = $planId;
        $this->redirect('/dashboard/subscription/payment');
    }

    /**
     * صفحة الدفع / تأكيد الطلب
     */
    public function payment()
    {
        $tenant = Auth::tenant();
        $planId = $_SESSION['selected_plan_id'] ?? null;

        if (!$planId) {
            $this->redirect('/dashboard/subscription-plans');
        }

        $plan = $this->planModel->find($planId);

        // تحديد نوع الطلب (اشتراك جديد أم ترقية)
        $currentSubscription = $this->getCurrentSubscription($tenant->id);
        $requestType = 'new';
        if ($currentSubscription) {
            if ($currentSubscription->plan_id == $planId) {
                $requestType = 'renew';
            } elseif (isset($plan->price) && isset($currentSubscription->price) && $plan->price > $currentSubscription->price) {
                $requestType = 'upgrade';
            } else {
                $requestType = 'new';
            }
        }

        $this->view('dashboard/subscription-payment', [
            'title' => lang('subscription_payment') ?? 'إتمام الطلب',
            'tenant' => $tenant,
            'plan' => $plan,
            'requestType' => $requestType,
            'currentSubscription' => $currentSubscription
        ]);
    }

    /**
     * إرسال طلب الاشتراك/الترقية للإدارة (بدل التفعيل المباشر)
     */
    public function processPayment()
    {
        $this->verifyCsrf();
        $tenant = Auth::tenant();
        $planId = $_SESSION['selected_plan_id'] ?? $this->input('plan_id');
        $notes = $this->input('notes');
        $requestType = $this->input('request_type', 'new');

        if (!$planId) {
            Session::error(lang('select_plan') ?? 'يرجى اختيار خطة');
            $this->redirect('/dashboard/subscription-plans');
        }

        $plan = $this->planModel->find($planId);
        if (!$plan) {
            Session::error(lang('plan_not_found') ?? 'الخطة غير موجودة');
            $this->redirect('/dashboard/subscription-plans');
        }

        // التحقق من وجود طلب معلق
        $pendingRequest = $this->getPendingRequest($tenant->id);
        if ($pendingRequest) {
            Session::error(lang('pending_request_exists') ?? 'لديك طلب معلق بالفعل');
            $this->redirect('/dashboard/subscription');
        }

        // تحديد نوع الطلب تلقائياً
        $currentSubscription = $this->getCurrentSubscription($tenant->id);
        if ($currentSubscription && $requestType === 'new') {
            if ($currentSubscription->plan_id == $planId) {
                $requestType = 'renew';
            } else {
                $requestType = 'upgrade';
            }
        }

        $db = Database::getInstance();

        // إنشاء طلب اشتراك جديد بحالة "معلق"
        $db->query(
            "INSERT INTO subscription_requests 
            (tenant_id, plan_id, request_type, status, notes, created_at) 
            VALUES (?, ?, ?, 'pending', ?, NOW())",
            [$tenant->id, $planId, $requestType, $notes]
        );

        unset($_SESSION['selected_plan_id']);

        if ($requestType === 'upgrade') {
            Session::success(lang('upgrade_request_sent') ?? 'تم إرسال طلب الترقية بنجاح، سيتم مراجعته من قبل الإدارة');
        } elseif ($requestType === 'renew') {
            Session::success(lang('renew_request_sent') ?? 'تم إرسال طلب التجديد بنجاح، سيتم مراجعته من قبل الإدارة');
        } else {
            Session::success(lang('subscription_request_sent') ?? 'تم إرسال طلب الاشتراك بنجاح، سيتم مراجعته من قبل الإدارة');
        }

        $this->redirect('/dashboard/subscription');
    }

    /**
     * تجديد الاشتراك الحالي
     */
    public function renew()
    {
        $this->verifyCsrf();
        $tenant = Auth::tenant();
        $current = $this->getCurrentSubscription($tenant->id);

        if (!$current) {
            Session::error(lang('no_active_subscription') ?? 'لا يوجد اشتراك نشط للتجديد');
            $this->redirect('/dashboard/subscription');
        }

        // التحقق من وجود طلب معلق
        $pendingRequest = $this->getPendingRequest($tenant->id);
        if ($pendingRequest) {
            Session::error(lang('pending_request_exists') ?? 'لديك طلب معلق بالفعل');
            $this->redirect('/dashboard/subscription');
        }

        $_SESSION['selected_plan_id'] = $current->plan_id;
        $this->redirect('/dashboard/subscription/payment');
    }

    /**
     * إلغاء الاشتراك الحالي
     */
    public function cancel()
    {
        $this->verifyCsrf();
        $tenant = Auth::tenant();

        $db = Database::getInstance();
        $db->query(
            "UPDATE subscriptions SET status = 'cancelled' WHERE tenant_id = ? AND status = 'active'",
            [$tenant->id]
        );

        Session::success(lang('subscription_cancelled') ?? 'تم إلغاء الاشتراك');
        $this->redirect('/dashboard/subscription');
    }

    /**
     * عرض صفحة ترقية الاشتراك
     */
    public function upgrade()
    {
        $tenant = Auth::tenant();
        $current = $this->getCurrentSubscription($tenant->id);

        $db = Database::getInstance();
        $plans = $db->query(
            "SELECT * FROM subscription_plans WHERE is_active = 1 ORDER BY price ASC"
        )->results();

        // عرض الخطط الأعلى سعراً فقط
        $upgradePlans = [];
        if ($current) {
            $currentPlan = $this->planModel->find($current->plan_id);
            $currentPrice = $currentPlan->price ?? 0;
            foreach ($plans as $p) {
                if ($p->id != $current->plan_id && (!$p->is_free) && $p->price > $currentPrice) {
                    $upgradePlans[] = $p;
                }
            }
        } else {
            foreach ($plans as $p) {
                if (!$p->is_free) {
                    $upgradePlans[] = $p;
                }
            }
        }

        $this->view('dashboard/subscription-upgrade', [
            'title' => lang('upgrade_plan') ?? 'ترقية الخطة',
            'tenant' => $tenant,
            'currentPlan' => $current,
            'plans' => $upgradePlans
        ]);
    }

    /**
     * عرض الفواتير / سجل الاشتراكات
     */
    public function invoices()
    {
        $tenant = Auth::tenant();

        $db = Database::getInstance();

        // سجل الاشتراكات
        $subscriptions = $db->query(
            "SELECT s.*, sp.name as plan_name, sp.price as plan_price
             FROM subscriptions s
             JOIN subscription_plans sp ON s.plan_id = sp.id
             WHERE s.tenant_id = ?
             ORDER BY s.created_at DESC",
            [$tenant->id]
        )->results();

        // سجل الطلبات
        $requests = $db->query(
            "SELECT sr.*, sp.name as plan_name
             FROM subscription_requests sr
             JOIN subscription_plans sp ON sr.plan_id = sp.id
             WHERE sr.tenant_id = ?
             ORDER BY sr.created_at DESC",
            [$tenant->id]
        )->results();

        $this->view('dashboard/invoices', [
            'title' => lang('invoices') ?? 'الفواتير والطلبات',
            'tenant' => $tenant,
            'subscriptions' => $subscriptions,
            'requests' => $requests
        ]);
    }

    /**
     * الحصول على الاشتراك النشط الحالي
     */
    private function getCurrentSubscription($tenantId)
    {
        try {
            $db = Database::getInstance();
            return $db->query(
                "SELECT s.*, sp.name as plan_name, sp.price, sp.duration, sp.features,
                        sp.max_services, sp.max_gallery, sp.max_pages, sp.max_banners,
                        sp.allow_custom_domain, sp.is_free
                 FROM subscriptions s
                 JOIN subscription_plans sp ON s.plan_id = sp.id
                 WHERE s.tenant_id = ? AND s.status = 'active'
                 ORDER BY s.created_at DESC LIMIT 1",
                [$tenantId]
            )->first();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * الحصول على طلب معلق
     */
    private function getPendingRequest($tenantId)
    {
        try {
            $db = Database::getInstance();
            return $db->query(
                "SELECT sr.*, sp.name as plan_name, sp.price as plan_price
                 FROM subscription_requests sr
                 JOIN subscription_plans sp ON sr.plan_id = sp.id
                 WHERE sr.tenant_id = ? AND sr.status = 'pending'
                 ORDER BY sr.created_at DESC LIMIT 1",
                [$tenantId]
            )->first();
        } catch (\Exception $e) {
            return null;
        }
    }
}
