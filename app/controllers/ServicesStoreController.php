<?php
/**
 * CMS Platform - Services Store Controller
 * متحكم متجر الخدمات - لوحة تحكم العميل
 */

class ServicesStoreController extends Controller
{
    private $serviceModel;
    private $purchaseModel;
    private $tenantModel;

    public function __construct()
    {
        parent::__construct();
        $this->requireAuth();

        if (Auth::isAdmin()) {
            Session::error('هذه الصفحة متاحة للعملاء فقط');
            $this->redirect('/admin');
        }

        $this->setLayout('dashboard');

        $this->serviceModel = $this->model('PaidService');
        $this->purchaseModel = $this->model('TenantPurchase');
        $this->tenantModel = $this->model('Tenant');
    }

    /**
     * صفحة المتجر - عرض الخدمات المتاحة
     */
    public function index()
    {
        $tenant = Auth::tenant();
        $services = $this->serviceModel->getActiveGrouped();
        $myPurchases = $this->purchaseModel->getActivePurchases($tenant->id);

        // بناء مصفوفة الخدمات المشتراة للتحقق السريع
        $purchasedIds = [];
        $purchasedCounts = [];
        foreach ($myPurchases as $p) {
            $purchasedIds[$p->service_id] = true;
            $purchasedCounts[$p->service_id] = ($purchasedCounts[$p->service_id] ?? 0) + 1;
        }

        $this->view('dashboard/services-store', [
            'title' => 'متجر الخدمات',
            'tenant' => $tenant,
            'services' => $services,
            'purchasedIds' => $purchasedIds,
            'purchasedCounts' => $purchasedCounts,
            'myPurchases' => $myPurchases
        ]);
    }

    /**
     * طلب شراء خدمة
     */
    public function purchase($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $service = $this->serviceModel->find($id);

        if (!$service || !$service->is_active) {
            Session::error('الخدمة غير موجودة أو غير متاحة');
            $this->redirect('/dashboard/services-store');
        }

        // فحص الحد الأقصى للشراء
        $currentCount = $this->purchaseModel->getPurchaseCount($tenant->id, $service->id);
        if ($currentCount >= $service->max_quantity) {
            Session::error('لقد وصلت للحد الأقصى المسموح لهذه الخدمة');
            $this->redirect('/dashboard/services-store');
        }

        // كل الطلبات تكون معلقة أولاً حتى يوافق عليها الادمن
        $status = 'pending';
        $purchasedAt = date('Y-m-d H:i:s');
        $approvedAt = null;

        // حساب تاريخ الانتهاء للخدمات الدورية
        $expiresAt = null;
        if ($service->is_recurring && $service->recurring_period) {
            $periods = [
                'monthly' => '+1 month',
                'yearly' => '+1 year',
            ];
            if (isset($periods[$service->recurring_period])) {
                $expiresAt = date('Y-m-d H:i:s', strtotime($periods[$service->recurring_period]));
            }
        }

        // إنشاء عملية الشراء
        $purchaseId = $this->purchaseModel->createPurchase([
            'tenant_id' => $tenant->id,
            'service_id' => $service->id,
            'quantity' => 1,
            'amount' => $service->price,
            'currency' => $service->currency,
            'status' => $status,
            'purchased_at' => $purchasedAt,
            'expires_at' => $expiresAt,
            'approved_at' => $approvedAt,
        ]);

        if ($purchaseId) {
            // إرسال إشعار للادمن بوجود طلب جديد
            try {
                $db = Database::getInstance();
                $admin = $db->query("SELECT * FROM users WHERE role = 'admin' LIMIT 1")->first();
                if ($admin) {
                    $email = EmailService::getInstance();
                    $email->sendNewPurchaseNotification(
                        (object)['id' => $purchaseId, 'amount' => $service->price, 'created_at' => date('Y-m-d H:i:s')],
                        $tenant,
                        $service
                    );
                }
            } catch (\Exception $e) {}

            // توجيه لرابط الدفع إذا كان موجود
            if ($service->payment_link) {
                Session::success('تم تسجيل طلبك بنجاح - سيتم توجيهك لصفحة الدفع');
                $this->redirect($service->payment_link);
            } else {
                Session::success('تم إرسال طلبك بنجاح وسيتم مراجعته من قبل الإدارة');
                $this->redirect('/dashboard/my-purchases');
            }
        } else {
            Session::error('حدث خطأ أثناء تسجيل الطلب');
            $this->redirect('/dashboard/services-store');
        }
    }

    /**
     * صفحة مشترياتي
     */
    public function myPurchases()
    {
        $tenant = Auth::tenant();
        $purchases = $this->purchaseModel->getTenantPurchases($tenant->id);

        // تجميع حسب الحالة
        $grouped = [
            'active' => [],
            'pending' => [],
            'expired' => [],
            'cancelled' => []
        ];

        foreach ($purchases as $p) {
            if (in_array($p->status, ['paid', 'approved'])) {
                if ($p->expires_at && strtotime($p->expires_at) < time()) {
                    $grouped['expired'][] = $p;
                } else {
                    $grouped['active'][] = $p;
                }
            } elseif ($p->status === 'pending') {
                $grouped['pending'][] = $p;
            } else {
                $grouped['cancelled'][] = $p;
            }
        }

        $this->view('dashboard/my-purchases', [
            'title' => 'مشترياتي',
            'tenant' => $tenant,
            'purchases' => $purchases,
            'grouped' => $grouped
        ]);
    }
}
