<?php
/**
 * CMS Platform - Admin Services Store Controller
 * متحكم الأدمن - إدارة الخدمات المدفوعة
 */

class AdminServicesController extends Controller
{
    private $serviceModel;
    private $purchaseModel;

    public function __construct()
    {
        parent::__construct();
        $this->requireAdmin();
        $this->setLayout('admin');

        $this->serviceModel = $this->model('PaidService');
        $this->purchaseModel = $this->model('TenantPurchase');
    }

    /**
     * قائمة الخدمات المدفوعة
     */
    public function services()
    {
        $services = $this->serviceModel->getAll();

        $this->view('admin/services-store', [
            'title' => 'الخدمات المدفوعة',
            'services' => $services,
            'categories' => $this->serviceModel->getCategories()
        ]);
    }

    /**
     * نموذج إضافة خدمة
     */
    public function addService()
    {
        $this->view('admin/service-store-form', [
            'title' => 'إضافة خدمة مدفوعة',
            'service' => null,
            'categories' => $this->serviceModel->getCategories()
        ]);
    }

    /**
     * حفظ خدمة جديدة
     */
    public function storeService()
    {
        $this->verifyCsrf();

        $data = [
            'title' => $this->input('title'),
            'slug' => $this->input('slug'),
            'description' => $this->input('description'),
            'price' => $this->input('price') ?: 0,
            'currency' => $this->input('currency') ?: 'SAR',
            'icon' => $this->input('icon') ?: 'fa-cube',
            'category' => $this->input('category') ?: 'general',
            'payment_link' => $this->input('payment_link'),
            'is_recurring' => $this->input('is_recurring') ? 1 : 0,
            'recurring_period' => $this->input('recurring_period') ?: 'onetime',
            'is_active' => $this->input('is_active') ? 1 : 0,
            'sort_order' => $this->input('sort_order') ?: 0,
            'max_quantity' => $this->input('max_quantity') ?: 1,
            'requires_approval' => $this->input('requires_approval') ? 1 : 0,
        ];

        if (empty($data['title'])) {
            Session::error('يجب إدخال عنوان الخدمة');
            $this->back();
        }

        if ($this->serviceModel->createService($data)) {
            Session::success('تم إضافة الخدمة بنجاح');
            $this->redirect('/admin/services-store');
        }

        Session::error('حدث خطأ أثناء إضافة الخدمة');
        $this->back();
    }

    /**
     * نموذج تعديل خدمة
     */
    public function editService($id)
    {
        $service = $this->serviceModel->find($id);

        if (!$service) {
            Session::error('الخدمة غير موجودة');
            $this->redirect('/admin/services-store');
        }

        $this->view('admin/service-store-form', [
            'title' => 'تعديل خدمة مدفوعة',
            'service' => $service,
            'categories' => $this->serviceModel->getCategories()
        ]);
    }

    /**
     * تحديث خدمة
     */
    public function updateService($id)
    {
        $this->verifyCsrf();

        $data = [
            'title' => $this->input('title'),
            'description' => $this->input('description'),
            'price' => $this->input('price') ?: 0,
            'currency' => $this->input('currency') ?: 'SAR',
            'icon' => $this->input('icon') ?: 'fa-cube',
            'category' => $this->input('category') ?: 'general',
            'payment_link' => $this->input('payment_link'),
            'is_recurring' => $this->input('is_recurring') ? 1 : 0,
            'recurring_period' => $this->input('recurring_period') ?: 'onetime',
            'is_active' => $this->input('is_active') ? 1 : 0,
            'sort_order' => $this->input('sort_order') ?: 0,
            'max_quantity' => $this->input('max_quantity') ?: 1,
            'requires_approval' => $this->input('requires_approval') ? 1 : 0,
        ];

        if ($this->serviceModel->update($id, $data)) {
            Session::success('تم تحديث الخدمة بنجاح');
        } else {
            Session::error('حدث خطأ أثناء التحديث');
        }

        $this->redirect('/admin/services-store');
    }

    /**
     * حذف خدمة
     */
    public function deleteService($id)
    {
        $this->verifyCsrf();
        if ($this->serviceModel->delete($id)) {
            Session::success('تم حذف الخدمة بنجاح');
        } else {
            Session::error('حدث خطأ أثناء حذف الخدمة');
        }
        $this->redirect('/admin/services-store');
    }

    /**
     * قائمة المشتريات
     */
    public function purchases()
    {
        $status = $this->input('status');
        $purchases = $this->purchaseModel->getAllPurchases($status);
        $stats = $this->purchaseModel->getStats();

        $this->view('admin/purchases', [
            'title' => 'إدارة المشتريات',
            'purchases' => $purchases,
            'stats' => $stats,
            'currentStatus' => $status
        ]);
    }

    /**
     * الموافقة على شراء
     */
    public function approvePurchase($id)
    {
        $this->verifyCsrf();

        $purchase = $this->purchaseModel->find($id);
        if (!$purchase) {
            $this->jsonError('الشراء غير موجود', [], 404);
        }

        $adminNotes = $this->input('admin_notes', '');

        if ($this->purchaseModel->approve($id, $adminNotes)) {
            // إرسال إشعار للعميل
            try {
                $service = $this->serviceModel->find($purchase->service_id);
                $db = Database::getInstance();
                $tenant = $db->query("SELECT t.*, u.full_name, u.email FROM tenants t JOIN users u ON t.user_id = u.id WHERE t.id = ?", [$purchase->tenant_id])->first();
                if ($tenant && $service) {
                    $email = EmailService::getInstance();
                    $email->sendPurchaseStatusEmail(
                        (object)['full_name' => $tenant->full_name, 'email' => $tenant->email],
                        $service->title,
                        'approved',
                        $adminNotes
                    );
                }
            } catch (\Exception $e) {}

            $this->jsonSuccess([], 'تمت الموافقة على الشراء');
        }

        $this->jsonError('حدث خطأ أثناء الموافقة');
    }

    /**
     * رفض شراء
     */
    public function rejectPurchase($id)
    {
        $this->verifyCsrf();

        $purchase = $this->purchaseModel->find($id);
        if (!$purchase) {
            $this->jsonError('الشراء غير موجود', [], 404);
        }

        $adminNotes = $this->input('admin_notes', '');

        if ($this->purchaseModel->reject($id, $adminNotes)) {
            // إرسال إشعار للعميل
            try {
                $service = $this->serviceModel->find($purchase->service_id);
                $db = Database::getInstance();
                $tenant = $db->query("SELECT t.*, u.full_name, u.email FROM tenants t JOIN users u ON t.user_id = u.id WHERE t.id = ?", [$purchase->tenant_id])->first();
                if ($tenant && $service) {
                    $email = EmailService::getInstance();
                    $email->sendPurchaseStatusEmail(
                        (object)['full_name' => $tenant->full_name, 'email' => $tenant->email],
                        $service->title,
                        'cancelled',
                        $adminNotes
                    );
                }
            } catch (\Exception $e) {}

            $this->jsonSuccess([], 'تم رفض الشراء');
        }

        $this->jsonError('حدث خطأ أثناء الرفض');
    }
}
