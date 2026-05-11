<?php
/**
 * CMS Platform - Subscription Controller
 * متحكم الاشتراكات - إدارة خطط الاشتراك والترقية
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
     * عرض صفحة الاشتراك الرئيسية
     */
    public function overview()
    {
        $tenant = Auth::tenant();

        $stats = (object)[];
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
        if ($currentSubscription && !empty($currentSubscription->plan_id)) {
            $currentPlan = $this->planModel->find($currentSubscription->plan_id);
        }

        // التحقق من وجود طلب اشتراك معلق (فقط طلبات تغيير الخطة)
        $pendingRequest = null;
        try {
            $db = Database::getInstance();
            $pendingCount = $db->query(
                "SELECT COUNT(*) as c FROM subscription_requests WHERE tenant_id = ? AND status = 'pending'",
                [$tenant->id]
            )->first();

            if ($pendingCount && intval($pendingCount->c) > 0) {
                $pendingRequest = $this->getPendingRequest($tenant->id);
            }
        } catch (\Exception $e) {
            $pendingRequest = null;
        }

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

        $db = Database::getInstance();
        $plans = $db->query(
            "SELECT * FROM subscription_plans WHERE is_active = 1 ORDER BY price_monthly ASC"
        )->results();

        // التحقق من وجود طلب اشتراك معلق
        $pendingRequest = $this->getPendingRequest($tenant->id);
        if ($pendingRequest) {
            Session::error(lang('pending_request_exists') ?? 'لديك طلب معلق بالفعل، انتظر مراجعة الإدارة');
            $this->redirect('/dashboard/subscription');
        }

        $this->view('dashboard/subscription-plans', [
            'title' => lang('subscription_plans') ?? 'خطط الاشتراك',
            'tenant' => $tenant,
            'plans' => $plans
        ]);
    }

    /**
     * اختيار خطة اشتراك
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

        // التحقق من وجود طلب اشتراك معلق
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
            if (!empty($currentSubscription->plan_id) && $currentSubscription->plan_id == $planId) {
                $requestType = 'renew';
 } else {
                // مقارنة السعر: دعم price_monthly و price
                $newPrice = floatval($plan->price_monthly ?? $plan->price ?? 0);
                $curPrice = floatval($currentSubscription->price ?? $currentSubscription->amount ?? 0);
                if ($newPrice > $curPrice) {
                    $requestType = 'upgrade';
                } else {
                    $requestType = 'new';
                }
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

        // التحقق من وجود طلب اشتراك معلق
        $pendingRequest = $this->getPendingRequest($tenant->id);
        if ($pendingRequest) {
            Session::error(lang('pending_request_exists') ?? 'لديك طلب معلق بالفعل');
            $this->redirect('/dashboard/subscription');
        }

        // تحديد نوع الطلب تلقائياً
        $currentSubscription = $this->getCurrentSubscription($tenant->id);
        if ($currentSubscription && $requestType === 'new') {
            if (!empty($currentSubscription->plan_id) && $currentSubscription->plan_id == $planId) {
                $requestType = 'renew';
            } else {
                $requestType = 'upgrade';
            }
        }

        $db = Database::getInstance();

        // التحقق من وجود العمود request_type في الجدول
        $hasRequestType = $this->columnExists('subscription_requests', 'request_type');

        // إنشاء طلب اشتراك جديد بحالة "معلق"
        if ($hasRequestType) {
            $db->query(
                "INSERT INTO subscription_requests 
                (tenant_id, plan_id, request_type, status, notes, created_at) 
                VALUES (?, ?, ?, 'pending', ?, NOW())",
                [$tenant->id, $planId, $requestType, $notes]
            );
        } else {
            $db->query(
                "INSERT INTO subscription_requests 
                (tenant_id, plan_id, status, notes, created_at) 
                VALUES (?, ?, 'pending', ?, NOW())",
                [$tenant->id, $planId, $notes]
            );
        }

        unset($_SESSION['selected_plan_id']);

        Session::success(lang('request_submitted') ?? 'تم إرسال طلبك بنجاح، سيتم مراجعته من قبل الإدارة');
        $this->redirect('/dashboard/subscription');
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
            "SELECT * FROM subscription_plans WHERE is_active = 1 ORDER BY price_monthly ASC"
        )->results();

        // التحقق من وجود طلب اشتراك معلق
        $pendingRequest = $this->getPendingRequest($tenant->id);
        if ($pendingRequest) {
            Session::error(lang('pending_request_exists') ?? 'لديك طلب معلق بالفعل');
            $this->redirect('/dashboard/subscription');
        }

        $_SESSION['selected_plan_id'] = $current->plan_id ?? null;
        $this->redirect('/dashboard/subscription/payment');
    }

    /**
     * عرض الفواتير وسجل الطلبات
     */
    public function invoices()
    {
        $tenant = Auth::tenant();

        $db = Database::getInstance();

        // سجل الاشتراكات
        $subscriptions = [];
        try {
            $subscriptions = $db->query(
                "SELECT s.id, s.tenant_id, s.plan_id, s.plan_name, s.amount, s.currency,
                        s.start_date, s.end_date, s.status, s.created_at,
                        sp.name as plan_name, sp.price as plan_price
                 FROM subscriptions s
                 LEFT JOIN subscription_plans sp ON s.plan_id = sp.id
                 WHERE s.tenant_id = ?
                 ORDER BY s.created_at DESC",
                [$tenant->id]
            )->results();
        } catch (\Exception $e) {}

        // سجل طلبات الاشتراك (فقط طلبات تغيير الخطة)
        $requests = [];
        $hasRequestType = $this->columnExists('subscription_requests', 'request_type');
        try {
            if ($hasRequestType) {
                $requests = $db->query(
                    "SELECT sr.id, sr.tenant_id, sr.plan_id, sr.request_type, sr.status,
                            sr.notes, sr.admin_notes, sr.created_at,
                            sp.name as plan_name
                     FROM subscription_requests sr
                     LEFT JOIN subscription_plans sp ON sr.plan_id = sp.id
                     WHERE sr.tenant_id = ?
                     ORDER BY sr.created_at DESC",
                    [$tenant->id]
                )->results();
            } else {
                $requests = $db->query(
                    "SELECT sr.id, sr.tenant_id, sr.plan_id, sr.status,
                            sr.notes, sr.admin_notes, sr.created_at,
                            sp.name as plan_name
                     FROM subscription_requests sr
                     LEFT JOIN subscription_plans sp ON sr.plan_id = sp.id
                     WHERE sr.tenant_id = ?
                     ORDER BY sr.created_at DESC",
                    [$tenant->id]
                )->results();
            }
        } catch (\Exception $e) {}

        $this->view('dashboard/invoices', [
            'title' => lang('invoices') ?? 'الفواتير والطلبات',
            'tenant' => $tenant,
            'subscriptions' => $subscriptions,
            'requests' => $requests
        ]);
    }

    /**
     * التحقق من وجود عمود في جدول
     */
    private function columnExists($table, $column)
    {
        try {
            $db = Database::getInstance();
            $result = $db->query(
                "SELECT COUNT(*) as c FROM information_schema.COLUMNS 
                 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?",
                [$table, $column]
            )->first();
            return $result && $result->c > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * الحصول على الاشتراك النشط الحالي
     */
    private function getCurrentSubscription($tenantId)
    {
        try {
            $db = Database::getInstance();
            return $db->query(
                "SELECT s.id, s.tenant_id, s.plan_id, s.plan_name, s.amount, s.currency,
                        s.start_date, s.end_date, s.status, s.created_at,
                        sp.name as plan_name, sp.price, sp.duration, sp.features,
                        sp.max_services, sp.max_gallery, sp.max_pages, sp.max_banners,
                        sp.allow_custom_domain, sp.is_free
                 FROM subscriptions s
                 LEFT JOIN subscription_plans sp ON s.plan_id = sp.id
                 WHERE s.tenant_id = ? AND s.status = 'active'
                 ORDER BY s.created_at DESC LIMIT 1",
                [$tenantId]
            )->first();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * الحصول على طلب اشتراك معلق
     * مهم: هذا يتحقق فقط من طلبات تغيير الخطة (subscription_requests)
     * وليس من مشتريات الخدمات (tenant_purchases) - هالاثنين أنظمة منفصلة
     */
    private function getPendingRequest($tenantId)
    {
        try {
            $db = Database::getInstance();

            // التحقق من وجود الجدول
            $tableCheck = $db->query("SELECT COUNT(*) as c FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'subscription_requests'")->first();
            if (!$tableCheck || $tableCheck->c == 0) {
                return null; // الجدول مو موجود
            }

            // فحص مباشر: هل في طلبات pending لهذا المستأجر؟
            $countCheck = $db->query(
                "SELECT COUNT(*) as c FROM subscription_requests WHERE tenant_id = ? AND status = 'pending'",
                [$tenantId]
            )->first();

            if (!$countCheck || $countCheck->c == 0) {
                return null; // ما في طلبات معلقة
            }

            // التحقق من وجود العمود request_type
            $hasRequestType = $this->columnExists('subscription_requests', 'request_type');

            if ($hasRequestType) {
                $result = $db->query(
                    "SELECT sr.id, sr.tenant_id, sr.plan_id, sr.request_type, sr.status,
                            sr.notes, sr.admin_notes, sr.reviewed_by, sr.reviewed_at,
                            sr.created_at, sp.name as plan_name, sp.price as plan_price
                     FROM subscription_requests sr
                     LEFT JOIN subscription_plans sp ON sr.plan_id = sp.id
                     WHERE sr.tenant_id = ? AND sr.status = 'pending'
                     ORDER BY sr.created_at DESC LIMIT 1",
                    [$tenantId]
                )->first();
            } else {
                $result = $db->query(
                    "SELECT sr.id, sr.tenant_id, sr.plan_id, sr.status,
                            sr.notes, sr.admin_notes, sr.reviewed_by, sr.reviewed_at,
                            sr.created_at, sp.name as plan_name, sp.price as plan_price
                     FROM subscription_requests sr
                     LEFT JOIN subscription_plans sp ON sr.plan_id = sp.id
                     WHERE sr.tenant_id = ? AND sr.status = 'pending'
                     ORDER BY sr.created_at DESC LIMIT 1",
                    [$tenantId]
                )->first();
            }

            // التأكد إن النتيجة تحتوي على id حقيقي
            if ($result && !empty($result->id)) {
                return $result;
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
