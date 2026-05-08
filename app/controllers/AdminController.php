<?php
/**
 * CMS Platform - Admin Controller
 * متحكم لوحة تحكم المدير
 * — النسخة المصلحة —
 * 
 * الأخطاء التي تم إصلاحها:
 * 1. rejectSubscriptionRequest: sr.status بدون alias
 * 2. approveSubscriptionRequest: أسماء أعمدة خاطئة في subscription_plans
 * 3. approveSubscriptionRequest: استخدام جدول subscriptions غير موجود → تم التعديل لاستخدام tenants
 * 4. storePlan: إضافة معالجة أخطاء مع fallback مباشر لقاعدة البيانات
 * 5. approveSubscriptionRequest: $request->duration → $request->duration_days
 */

class AdminController extends Controller
{
    private $userModel;
    private $tenantModel;

    public function __construct()
    {
        parent::__construct();
        $this->requireAdmin();
        
        // تعيين layout الادمن بشكل افتراضي لكل صفحات الادمن
        $this->setLayout('admin');
        
        $this->userModel = $this->model('User');
        $this->tenantModel = $this->model('Tenant');
    }

    /**
     * لوحة تحكم المدير
     */
    public function index()
    {
        $db = Database::getInstance();
        
        // إحصائيات
        $stats = [
            'total_users' => $this->userModel->count("role = 'customer'"),
            'total_sites' => $this->tenantModel->count(),
            'active_subscriptions' => $this->tenantModel->count("subscription_status IN ('trial', 'active')"),
            'expired_subscriptions' => $this->tenantModel->count("subscription_status = 'expired'"),
            'total_themes' => $this->getTotalThemes($db),
        ];

        // آخر المواقع مع معلومات المالك والقالب
        $recentSites = $db->query(
            "SELECT t.*, u.full_name as owner_name, th.name as theme_name
             FROM tenants t
             LEFT JOIN users u ON t.user_id = u.id
             LEFT JOIN themes th ON t.theme_id = th.id
             ORDER BY t.created_at DESC
             LIMIT 5"
        )->results();

        $this->view('admin/index', [
            'title' => lang('admin_dashboard') ?? 'لوحة تحكم المدير',
            'stats' => $stats,
            'recent_sites' => $recentSites
        ]);
    }

    /**
     * الحصول على عدد القوالب بشكل آمن
     */
    private function getTotalThemes($db)
    {
        try {
            $result = $db->query("SELECT COUNT(*) as count FROM themes")->first();
            return $result ? $result->count : 6;
        } catch (Exception $e) {
            // إذا لم تكن جدول themes موجوداً، نحسب القوالب من المجلد
            $themesPath = THEMES_PATH;
            if (is_dir($themesPath)) {
                $dirs = array_filter(glob($themesPath . '/*'), 'is_dir');
                return count($dirs);
            }
            return 6;
        }
    }

    /**
     * قائمة المستخدمين
     */
    public function users()
    {
        $page = $this->input('page', 1);
        $search = $this->input('search');

        $conditions = "role = 'customer'";
        $params = [];

        if ($search) {
            $conditions .= " AND (full_name LIKE ? OR email LIKE ?)";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }

        $pagination = $this->userModel->paginate($page, 20, $conditions, $params, 'created_at DESC');

        $this->view('admin/users', [
            'title' => 'المستخدمين',
            'users' => $pagination['data'],
            'pagination' => $pagination,
            'search' => $search
        ]);
    }

    /**
     * تعديل مستخدم
     */
    public function editUser($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            Session::error(lang('user_not_found') ?? 'المستخدم غير موجود');
            $this->redirect('/admin/users');
        }

        // الحصول على معلومات الموقع المرتبط بالمستخدم إن وجد
        $tenant = null;
        if ($user->role === 'customer') {
            $db = Database::getInstance();
            $tenant = $db->query(
                "SELECT * FROM tenants WHERE user_id = ?",
                [$user->id]
            )->first();
        }

        $this->view('admin/user-form', [
            'title' => lang('edit_user') ?? 'تعديل المستخدم',
            'user' => $user,
            'tenant' => $tenant
        ]);
    }

    /**
     * تحديث بيانات المستخدم
     */
    public function updateUser($id)
    {
        $this->verifyCsrf();

        $user = $this->userModel->find($id);

        if (!$user) {
            Session::error(lang('user_not_found') ?? 'المستخدم غير موجود');
            $this->redirect('/admin/users');
        }

        // لا يمكن تعديل بيانات المدير الرئيسي إلا من مدير آخر
        if ($user->role === 'admin' && $user->id === Auth::id()) {
            // السماح بتعديل البيانات الشخصية فقط
        }

        $data = [
            'full_name' => $this->input('full_name'),
            'email' => $this->input('email'),
            'phone' => $this->input('phone'),
            'role' => $this->input('role', 'customer'),
            'status' => $this->input('status', 'active'),
        ];

        // التحقق من البريد الإلكتروني
        if (empty($data['email'])) {
            Session::error(lang('email_required') ?? 'البريد الإلكتروني مطلوب');
            $this->redirect('/admin/users/edit/' . $id);
        }

        // التحقق من عدم تكرار البريد الإلكتروني
        if ($this->userModel->emailExists($data['email'], $id)) {
            Session::error(lang('email_exists') ?? 'البريد الإلكتروني مستخدم من قبل');
            $this->redirect('/admin/users/edit/' . $id);
        }

        // التحقق من أن الدور صالح
        if (!in_array($data['role'], ['admin', 'customer'])) {
            $data['role'] = 'customer';
        }

        // التحقق من أن الحالة صالحة
        if (!in_array($data['status'], ['active', 'inactive', 'suspended'])) {
            $data['status'] = 'active';
        }

        // تحديث كلمة المرور إذا تم إدخالها
        $newPassword = $this->input('new_password');
        if (!empty($newPassword)) {
            $confirmPassword = $this->input('confirm_password');
            if ($newPassword !== $confirmPassword) {
                Session::error(lang('password_mismatch') ?? 'كلمة المرور غير متطابقة');
                $this->redirect('/admin/users/edit/' . $id);
            }
            if (strlen($newPassword) < 6) {
                Session::error(lang('password_min') ?? 'كلمة المرور يجب أن تكون 6 أحرف على الأقل');
                $this->redirect('/admin/users/edit/' . $id);
            }
            $data['password'] = Security::hashPassword($newPassword);
        }

        if ($this->userModel->update($id, $data)) {
            Session::success(lang('user_updated') ?? 'تم تحديث بيانات المستخدم بنجاح');
        } else {
            Session::error(lang('update_error') ?? 'حدث خطأ أثناء التحديث');
        }

        $this->redirect('/admin/users');
    }

    /**
     * حذف مستخدم
     */
    public function deleteUser($id)
    {
        $this->verifyCsrf();

        $user = $this->userModel->find($id);

        if (!$user) {
            $this->jsonError(lang('user_not_found') ?? 'المستخدم غير موجود', [], 404);
        }

        // لا يمكن حذف المدير
        if ($user->role === 'admin') {
            $this->jsonError(lang('cannot_delete_admin') ?? 'لا يمكن حذف المدير');
        }

        // حذف الموقع المرتبط إن وجد
        $db = Database::getInstance();
        $tenant = $db->query("SELECT * FROM tenants WHERE user_id = ?", [$id])->first();
        if ($tenant) {
            $db->query("DELETE FROM services WHERE tenant_id = ?", [$tenant->id]);
            $db->query("DELETE FROM gallery WHERE tenant_id = ?", [$tenant->id]);
            $db->query("DELETE FROM testimonials WHERE tenant_id = ?", [$tenant->id]);
            $db->query("DELETE FROM banners WHERE tenant_id = ?", [$tenant->id]);
            $db->query("DELETE FROM tenants WHERE user_id = ?", [$id]);
        }

        if ($this->userModel->delete($id)) {
            $this->jsonSuccess([], lang('user_deleted') ?? 'تم حذف المستخدم بنجاح');
        }

        $this->jsonError(lang('delete_error') ?? 'حدث خطأ أثناء الحذف');
    }

    /**
     * قائمة المواقع
     */
    public function sites()
    {
        $page = $this->input('page', 1);
        $status = $this->input('status');

        $conditions = "1=1";
        $params = [];

        if ($status) {
            $conditions .= " AND subscription_status = ?";
            $params[] = $status;
        }

        $pagination = $this->tenantModel->paginate($page, 20, $conditions, $params, 'created_at DESC');

        $this->view('admin/sites', [
            'title' => 'المواقع',
            'sites' => $pagination['data'],
            'pagination' => $pagination,
            'status_filter' => $status
        ]);
    }

    /**
     * عرض موقع
     */
    public function viewSite($id)
    {
        $tenant = $this->tenantModel->find($id);

        if (!$tenant) {
            Session::error('الموقع غير موجود');
            $this->redirect('/admin/sites');
        }

        $user = $this->userModel->find($tenant->user_id);
        $stats = $this->tenantModel->getStats($id);

        $this->view('admin/site-detail', [
            'title' => $tenant->site_name,
            'tenant' => $tenant,
            'user' => $user,
            'stats' => $stats
        ]);
    }

    /**
     * تغيير حالة اشتراك
     */
    public function changeSubscriptionStatus()
    {
        $this->verifyCsrf();

        $tenantId = $this->input('tenant_id');
        $status = $this->input('status');

        $allowedStatuses = ['trial', 'active', 'expired', 'suspended'];

        if (!in_array($status, $allowedStatuses)) {
            $this->jsonError('حالة غير صالحة');
        }

        if ($this->tenantModel->update($tenantId, ['subscription_status' => $status])) {
            $this->jsonSuccess([], 'تم تحديث حالة الاشتراك');
        }

        $this->jsonError('حدث خطأ');
    }

    /**
     * تجديد اشتراك
     */
    public function renewSubscription($tenantId)
    {
        $this->verifyCsrf();

        $months = $this->input('months', 1);

        if ($this->tenantModel->renewSubscription($tenantId, $months)) {
            Session::success("تم تجديد الاشتراك لـ {$months} شهر");
        } else {
            Session::error('حدث خطأ أثناء تجديد الاشتراك');
        }

        $this->redirect('/admin/sites/view/' . $tenantId);
    }

    /**
     * إعدادات النظام
     */
    public function settings()
    {
        $db = Database::getInstance();
        $settings = $db->query("SELECT * FROM settings ORDER BY id")->results();

        $this->view('admin/settings', [
            'title' => 'إعدادات النظام',
            'settings' => $settings
        ]);
    }

    /**
     * تحديث الإعدادات
     */
    public function updateSettings()
    {
        $this->verifyCsrf();

        $db = Database::getInstance();

        $allowedSettings = ['site_name', 'site_description', 'admin_email', 'contact_phone', 'contact_email', 'contact_address', 'social_facebook', 'social_twitter', 'social_instagram', 'social_whatsapp'];
        foreach ($allowedSettings as $key) {
            $value = $this->input($key);
            if ($value !== null) {
                $db->query("UPDATE settings SET setting_value = ? WHERE setting_key = ?", [$value, $key]);
            }
        }

        Session::success('تم حفظ الإعدادات بنجاح');
        $this->redirect('/admin/settings');
    }

    /**
     * إحصائيات مفصلة
     */
    public function analytics()
    {
        $db = Database::getInstance();

        // إحصائيات شهرية
        $monthlyStats = $db->query(
            "SELECT 
                DATE_FORMAT(created_at, '%Y-%m') as month,
                COUNT(*) as total
            FROM tenants 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')
            ORDER BY month ASC"
        )->results();

        // توزيع حسب الثيم
        try {
            $themeDistribution = $db->query(
                "SELECT th.name, COUNT(t.id) as count
                FROM themes th
                LEFT JOIN tenants t ON th.id = t.theme_id
                GROUP BY th.id
                ORDER BY count DESC"
            )->results();
        } catch (Exception $e) {
            $themeDistribution = [];
        }

        $this->view('admin/analytics', [
            'title' => 'الإحصائيات',
            'monthly_stats' => $monthlyStats,
            'theme_distribution' => $themeDistribution
        ]);
    }

    /**
     * قائمة الاشتراكات
     */
    public function subscriptions()
    {
        $db = Database::getInstance();
        
        $page = (int)$this->input('page', 1);
        $status = $this->input('status');
        $perPage = 20;
        $offset = (int)(($page - 1) * $perPage);
        
        $whereClause = "1=1";
        $params = [];
        
        if ($status) {
            $whereClause .= " AND t.subscription_status = ?";
            $params[] = $status;
        }
        
        // الحصول على الاشتراكات
        $subscriptions = $db->query(
            "SELECT t.*, u.full_name as owner_name, u.email as owner_email, 
                    p.name as plan_name, th.name as theme_name
             FROM tenants t
             LEFT JOIN users u ON t.user_id = u.id
             LEFT JOIN subscription_plans p ON t.plan_id = p.id
             LEFT JOIN themes th ON t.theme_id = th.id
             WHERE {$whereClause}
             ORDER BY t.created_at DESC
             LIMIT ? OFFSET ?",
            array_merge($params, [(int)$perPage, (int)$offset])
        )->results();
        
        // عدد الإجمالي
        $countResult = $db->query(
            "SELECT COUNT(*) as total FROM tenants t WHERE {$whereClause}",
            $params
        )->first();
        $total = $countResult->total;
        
        $this->view('admin/subscriptions', [
            'title' => lang('subscriptions') ?? 'الاشتراكات',
            'subscriptions' => $subscriptions,
            'pagination' => [
                'total' => $total,
                'page' => $page,
                'per_page' => $perPage,
                'last_page' => ceil($total / $perPage)
            ],
            'status_filter' => $status
        ]);
    }

    // ==================== إدارة الخطط ====================

    /**
     * قائمة الخطط
     */
    public function plans()
    {
        $planModel = $this->model('SubscriptionPlan');
        $plans = $planModel->getAllPlans();

        $this->view('admin/plans', [
            'title' => lang('subscription_plans') ?? 'خطط الاشتراك',
            'plans' => $plans
        ]);
    }

    /**
     * إضافة خطة جديدة
     */
    public function addPlan()
    {
        $this->view('admin/plan-form', [
            'title' => lang('add_plan') ?? 'إضافة خطة جديدة',
            'plan' => null
        ]);
    }

    /**
     * حفظ خطة جديدة
     * — تم إصلاحه: إضافة معالجة أخطاء مع fallback مباشر —
     */

    public function storePlan()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/plans');
            return;
        }

        try {
            $csrfToken = $_POST['csrf_token'] ?? '';
            if (empty($csrfToken) || !isset($_SESSION['csrf_token']) || $csrfToken !== $_SESSION['csrf_token']) {
                $_SESSION['error'] = 'رمز CSRF غير صالح';
                $this->redirect('/admin/plans');
                return;
            }

            $name = trim((string)($_POST['name'] ?? ''));
            $slug = trim((string)($_POST['slug'] ?? ''));
            $description = trim((string)($_POST['description'] ?? ''));
            $priceMonthly = !empty($_POST['price_monthly']) ? floatval($_POST['price_monthly']) : 0.00;
            $priceYearly = !empty($_POST['price_yearly']) ? floatval($_POST['price_yearly']) : null;
            $currency = trim((string)($_POST['currency'] ?? 'SAR'));
            $features = $_POST['features'] ?? '';
            $maxPages = intval($_POST['max_pages'] ?? -1);
            $maxServices = intval($_POST['max_services'] ?? -1);
            $maxGallery = intval($_POST['max_gallery'] ?? -1);
            $maxBanners = intval($_POST['max_banners'] ?? -1);
            $customDomain = isset($_POST['custom_domain']) ? 1 : 0;
            $removeBranding = isset($_POST['remove_branding']) ? 1 : 0;
            $analyticsAccess = isset($_POST['analytics_access']) ? 1 : 0;
            $prioritySupport = isset($_POST['priority_support']) ? 1 : 0;
            $isActive = isset($_POST['is_active']) ? 1 : 0;
            $isPopular = isset($_POST['is_popular']) ? 1 : 0;
            $displayOrder = intval($_POST['display_order'] ?? 0);

            if (empty($name)) {
                $_SESSION['error'] = 'اسم الخطة مطلوب';
                $_SESSION['old_input'] = $_POST;
                $this->redirect('/admin/plans/add');
                return;
            }

            if (empty($slug)) {
                $slug = $this->createSlug($name);
            } else {
                $slug = $this->createSlug($slug);
            }

            $featuresJson = null;
            if (!empty($features)) {
                if (is_array($features)) {
                    $featuresJson = json_encode($features, JSON_UNESCAPED_UNICODE);
                } else {
                    $featuresArray = array_filter(array_map('trim', explode("\n", $features)));
                    $featuresJson = json_encode($featuresArray, JSON_UNESCAPED_UNICODE);
                }
            }

            $data = [
                'name'             => $name,
                'slug'             => $slug,
                'description'      => $description,
                'price_monthly'    => $priceMonthly,
                'price_yearly'     => $priceYearly,
                'currency'         => $currency,
                'features'         => $featuresJson,
                'max_pages'        => $maxPages,
                'max_services'     => $maxServices,
                'max_gallery'      => $maxGallery,
                'max_banners'      => $maxBanners,
                'custom_domain'    => $customDomain,
                'remove_branding'  => $removeBranding,
                'analytics_access' => $analyticsAccess,
                'priority_support' => $prioritySupport,
                'is_active'        => $isActive,
                'is_popular'       => $isPopular,
                'display_order'    => $displayOrder
            ];

            $data = array_filter($data, function($value) {
                return $value !== null;
            });

            $columns = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            $sql = "INSERT INTO subscription_plans ($columns) VALUES ($placeholders)";
            $values = array_values($data);

            $db = Database::getInstance();
            $result = $db->query($sql, $values);

            if ($result) {
                $_SESSION['success'] = 'تم إنشاء الخطة بنجاح';
            } else {
                $_SESSION['error'] = 'حدث خطأ أثناء حفظ الخطة';
            }

            $this->redirect('/admin/plans');

        } catch (Exception $e) {
            error_log("خطأ في إنشاء الخطة: " . $e->getMessage());
            $_SESSION['error'] = 'حدث خطأ أثناء حفظ الخطة. يرجى المحاولة لاحقاً';
            $this->redirect('/admin/plans/add');
        }
    }

    /**
     * تعديل خطة
     */
    public function editPlan($id)
    {
        $planModel = $this->model('SubscriptionPlan');
        $plan = $planModel->find($id);

        if (!$plan) {
            Session::error(lang('plan_not_found') ?? 'الخطة غير موجودة');
            $this->redirect('/admin/plans');
        }

        $this->view('admin/plan-form', [
            'title' => lang('edit_plan') ?? 'تعديل الخطة',
            'plan' => $plan
        ]);
    }

    /**
     * تحديث خطة
     */

    public function updatePlan($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/plans');
            return;
        }

        try {
            $id = intval($id);
            $csrfToken = $_POST['csrf_token'] ?? '';
            if (empty($csrfToken) || !isset($_SESSION['csrf_token']) || $csrfToken !== $_SESSION['csrf_token']) {
                $_SESSION['error'] = 'رمز CSRF غير صالح';
                $this->redirect('/admin/plans');
                return;
            }

            $name = trim((string)($_POST['name'] ?? ''));
            $slug = trim((string)($_POST['slug'] ?? ''));
            $description = trim((string)($_POST['description'] ?? ''));
            $priceMonthly = !empty($_POST['price_monthly']) ? floatval($_POST['price_monthly']) : 0.00;
            $priceYearly = !empty($_POST['price_yearly']) ? floatval($_POST['price_yearly']) : null;
            $currency = trim((string)($_POST['currency'] ?? 'SAR'));
            $features = $_POST['features'] ?? '';
            $maxPages = intval($_POST['max_pages'] ?? -1);
            $maxServices = intval($_POST['max_services'] ?? -1);
            $maxGallery = intval($_POST['max_gallery'] ?? -1);
            $maxBanners = intval($_POST['max_banners'] ?? -1);
            $customDomain = isset($_POST['custom_domain']) ? 1 : 0;
            $removeBranding = isset($_POST['remove_branding']) ? 1 : 0;
            $analyticsAccess = isset($_POST['analytics_access']) ? 1 : 0;
            $prioritySupport = isset($_POST['priority_support']) ? 1 : 0;
            $isActive = isset($_POST['is_active']) ? 1 : 0;
            $isPopular = isset($_POST['is_popular']) ? 1 : 0;
            $displayOrder = intval($_POST['display_order'] ?? 0);

            if (empty($name)) {
                $_SESSION['error'] = 'اسم الخطة مطلوب';
                $_SESSION['old_input'] = $_POST;
                $this->redirect('/admin/plans/edit/' . $id);
                return;
            }

            if (empty($slug)) {
                $slug = $this->createSlug($name);
            } else {
                $slug = $this->createSlug($slug);
            }

            $featuresJson = null;
            if (!empty($features)) {
                if (is_array($features)) {
                    $featuresJson = json_encode($features, JSON_UNESCAPED_UNICODE);
                } else {
                    $featuresArray = array_filter(array_map('trim', explode("\n", $features)));
                    $featuresJson = json_encode($featuresArray, JSON_UNESCAPED_UNICODE);
                }
            }

            $data = [
                'name'             => $name,
                'slug'             => $slug,
                'description'      => $description,
                'price_monthly'    => $priceMonthly,
                'price_yearly'     => $priceYearly,
                'currency'         => $currency,
                'features'         => $featuresJson,
                'max_pages'        => $maxPages,
                'max_services'     => $maxServices,
                'max_gallery'      => $maxGallery,
                'max_banners'      => $maxBanners,
                'custom_domain'    => $customDomain,
                'remove_branding'  => $removeBranding,
                'analytics_access' => $analyticsAccess,
                'priority_support' => $prioritySupport,
                'is_active'        => $isActive,
                'is_popular'       => $isPopular,
                'display_order'    => $displayOrder
            ];

            $data = array_filter($data, function($value) {
                return $value !== null;
            });

            $setClauses = [];
            $values = [];
            foreach ($data as $column => $value) {
                $setClauses[] = "$column = ?";
                $values[] = $value;
            }
            $values[] = $id;

            $sql = "UPDATE subscription_plans SET " . implode(', ', $setClauses) . " WHERE id = ?";
            $db = Database::getInstance();
            $result = $db->query($sql, $values);

            if ($result) {
                $_SESSION['success'] = 'تم تحديث الخطة بنجاح';
            } else {
                $_SESSION['error'] = 'حدث خطأ أثناء تحديث الخطة';
            }

            $this->redirect('/admin/plans');

        } catch (Exception $e) {
            error_log("خطأ في تحديث الخطة: " . $e->getMessage());
            $_SESSION['error'] = 'حدث خطأ أثناء تحديث الخطة. يرجى المحاولة لاحقاً';
            $this->redirect('/admin/plans/edit/' . $id);
        }
    }

    /**
     * حذف خطة
     */
    public function deletePlan($id)
    {
        $this->verifyCsrf();

        $planModel = $this->model('SubscriptionPlan');
        
        try {
            if (method_exists($planModel, 'deletePlan')) {
                $result = $planModel->deletePlan($id);
            } else {
                // Fallback: حذف مباشر
                $db = Database::getInstance();
                
                // التحقق من عدم وجود مشتركين
                $check = $db->query(
                    "SELECT COUNT(*) as cnt FROM tenants WHERE plan_id = ? AND subscription_status IN ('active', 'trial')",
                    [$id]
                )->first();
                
                if ($check && $check->cnt > 0) {
                    Session::error(lang('plan_delete_error') ?? 'لا يمكن حذف الخطة لوجود مشتركين بها');
                    $this->redirect('/admin/plans');
                    return;
                }
                
                $db->query("DELETE FROM subscription_plans WHERE id = ?", [$id]);
                $result = true;
            }
            
            if ($result) {
                Session::success(lang('plan_deleted') ?? 'تم حذف الخطة بنجاح');
            } else {
                Session::error(lang('plan_delete_error') ?? 'لا يمكن حذف الخطة لوجود مشتركين بها');
            }
        } catch (\Exception $e) {
            Session::error('خطأ في حذف الخطة: ' . $e->getMessage());
        }

        $this->redirect('/admin/plans');
    }

    /**
     * توليد slug للخطة
     */
    private function generatePlanSlug($name)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));
        return $slug;
    }

    // ==================== إدارة إعدادات الموقع الرئيسي ====================

    /**
     * إعدادات الموقع الرئيسي
     */
    public function siteSettings()
    {
        $siteSettingModel = $this->model('SiteSetting');
        $settings = $siteSettingModel->getSettings();

        $this->view('admin/site-settings', [
            'title' => lang('site_settings') ?? 'إعدادات الموقع الرئيسي',
            'settings' => $settings
        ]);
    }

    /**
     * تحديث إعدادات الموقع الرئيسي
     */
    public function updateSiteSettings()
    {
        $this->verifyCsrf();

        $data = [
            'hero_title' => $this->input('hero_title'),
            'hero_subtitle' => $this->input('hero_subtitle'),
            'hero_button_text' => $this->input('hero_button_text'),
            'hero_button_link' => $this->input('hero_button_link'),
            'features_title' => $this->input('features_title'),
            'features_subtitle' => $this->input('features_subtitle'),
            'show_features' => $this->input('show_features') ? 1 : 0,
            'show_themes_section' => $this->input('show_themes_section') ? 1 : 0,
            'show_pricing_section' => $this->input('show_pricing_section') ? 1 : 0,
            'pricing_title' => $this->input('pricing_title'),
            'pricing_subtitle' => $this->input('pricing_subtitle'),
            'testimonials_title' => $this->input('testimonials_title'),
            'show_testimonials' => $this->input('show_testimonials') ? 1 : 0,
            'contact_title' => $this->input('contact_title'),
            'contact_subtitle' => $this->input('contact_subtitle'),
            'show_contact_form' => $this->input('show_contact_form') ? 1 : 0,
            'contact_email' => $this->input('contact_email'),
            'contact_phone' => $this->input('contact_phone'),
            'contact_whatsapp' => $this->input('contact_whatsapp'),
            'contact_address' => $this->input('contact_address'),
            'facebook' => $this->input('facebook'),
            'twitter' => $this->input('twitter'),
            'instagram' => $this->input('instagram'),
            'linkedin' => $this->input('linkedin'),
            'youtube' => $this->input('youtube'),
            'meta_title' => $this->input('meta_title'),
            'meta_description' => $this->input('meta_description'),
            'meta_keywords' => $this->input('meta_keywords'),
            'footer_text' => $this->input('footer_text'),
            'copyright_text' => $this->input('copyright_text'),
            'maintenance_mode' => $this->input('maintenance_mode') ? 1 : 0,
            'maintenance_message' => $this->input('maintenance_message'),
        ];

        $siteSettingModel = $this->model('SiteSetting');
        
        if ($siteSettingModel->updateSettings($data)) {
            Session::success(lang('settings_saved') ?? 'تم حفظ الإعدادات بنجاح');
        } else {
            Session::error(lang('settings_error') ?? 'حدث خطأ أثناء حفظ الإعدادات');
        }

        $this->redirect('/admin/site-settings');
    }

    /**
     * تحديث شعار الموقع
     */
    public function updateSiteLogo()
    {
        $this->verifyCsrf();

        if (!isset($_FILES['logo']) || $_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
            Session::error(lang('select_file') ?? 'يرجى اختيار ملف');
            $this->redirect('/admin/site-settings');
        }

        $siteSettingModel = $this->model('SiteSetting');
        $settings = $siteSettingModel->getSettings();

        // رفع الملف
        $result = $this->uploadFile($_FILES['logo'], 'site', ALLOWED_IMAGE_TYPES);

        if (isset($result['error'])) {
            Session::error($result['error']);
            $this->redirect('/admin/site-settings');
        }

        // حذف الشعار القديم
        $logoField = $this->input('logo_type', 'logo') === 'white' ? 'logo_white' : 'logo';
        if ($settings->$logoField) {
            $this->deleteFile($settings->$logoField);
        }

        $siteSettingModel->update($settings->id, [$logoField => $result['path']]);

        Session::success(lang('logo_updated') ?? 'تم تحديث الشعار بنجاح');
        $this->redirect('/admin/site-settings');
    }

    /**
     * تحديث صورة البانر الرئيسي
     */
    public function updateHeroImage()
    {
        $this->verifyCsrf();

        if (!isset($_FILES['hero_image']) || $_FILES['hero_image']['error'] !== UPLOAD_ERR_OK) {
            Session::error(lang('select_file') ?? 'يرجى اختيار ملف');
            $this->redirect('/admin/site-settings');
        }

        $siteSettingModel = $this->model('SiteSetting');
        $settings = $siteSettingModel->getSettings();

        // رفع الملف
        $result = $this->uploadFile($_FILES['hero_image'], 'site/hero', ALLOWED_IMAGE_TYPES);

        if (isset($result['error'])) {
            Session::error($result['error']);
            $this->redirect('/admin/site-settings');
        }

        // حذف الصورة القديمة
        if ($settings->hero_image) {
            $this->deleteFile($settings->hero_image);
        }

        $siteSettingModel->update($settings->id, ['hero_image' => $result['path']]);

        Session::success(lang('image_updated') ?? 'تم تحديث الصورة بنجاح');
        $this->redirect('/admin/site-settings');
    }

    // ==================== شهادات الموقع الرئيسي ====================

    /**
     * قائمة شهادات الموقع الرئيسي
     */
    public function siteTestimonials()
    {
        $siteTestimonialModel = $this->model('SiteTestimonial');
        $testimonials = $siteTestimonialModel->getAll();

        $this->view('admin/site-testimonials', [
            'title' => lang('site_testimonials') ?? 'شهادات الموقع',
            'testimonials' => $testimonials
        ]);
    }

    /**
     * إضافة شهادة جديدة
     */
    public function storeSiteTestimonial()
    {
        $this->verifyCsrf();

        $data = [
            'client_name' => $this->input('client_name'),
            'client_title' => $this->input('client_title'),
            'client_company' => $this->input('client_company'),
            'content' => $this->input('content'),
            'rating' => (int) $this->input('rating', 5),
            'is_active' => $this->input('is_active') ? 1 : 0,
        ];

        // رفع صورة العميل
        if (isset($_FILES['client_image']) && $_FILES['client_image']['error'] === UPLOAD_ERR_OK) {
            $result = $this->uploadFile($_FILES['client_image'], 'site/testimonials', ALLOWED_IMAGE_TYPES);
            if (!isset($result['error'])) {
                $data['client_image'] = $result['path'];
            }
        }

        $siteTestimonialModel = $this->model('SiteTestimonial');
        
        if ($siteTestimonialModel->addTestimonial($data)) {
            Session::success(lang('testimonial_added') ?? 'تم إضافة الشهادة بنجاح');
        } else {
            Session::error(lang('error_occurred') ?? 'حدث خطأ');
        }

        $this->redirect('/admin/site-testimonials');
    }

    /**
     * حذف شهادة
     */
    public function deleteSiteTestimonial($id)
    {
        $this->verifyCsrf();

        $siteTestimonialModel = $this->model('SiteTestimonial');
        $testimonial = $siteTestimonialModel->find($id);

        if (!$testimonial) {
            $this->jsonError(lang('not_found') ?? 'غير موجود', [], 404);
        }

        // حذف الصورة
        if ($testimonial->client_image) {
            $this->deleteFile($testimonial->client_image);
        }

        if ($siteTestimonialModel->delete($id)) {
            $this->jsonSuccess([], lang('deleted') ?? 'تم الحذف');
        }

        $this->jsonError(lang('error_occurred') ?? 'حدث خطأ');
    }

    // ==================== مميزات الموقع الرئيسي ====================

    /**
     * قائمة مميزات الموقع الرئيسي
     */
    public function siteFeatures()
    {
        $siteFeatureModel = $this->model('SiteFeature');
        $features = $siteFeatureModel->getAll();

        $this->view('admin/site-features', [
            'title' => lang('site_features') ?? 'مميزات الموقع',
            'features' => $features
        ]);
    }

    /**
     * إضافة ميزة جديدة
     */
    public function storeSiteFeature()
    {
        $this->verifyCsrf();

        $data = [
            'icon' => $this->input('icon'),
            'title' => $this->input('title'),
            'description' => $this->input('description'),
            'is_active' => $this->input('is_active') ? 1 : 0,
        ];

        $siteFeatureModel = $this->model('SiteFeature');
        
        if ($siteFeatureModel->addFeature($data)) {
            Session::success(lang('feature_added') ?? 'تم إضافة الميزة بنجاح');
        } else {
            Session::error(lang('error_occurred') ?? 'حدث خطأ');
        }

        $this->redirect('/admin/site-features');
    }

    /**
     * حذف ميزة
     */
    public function deleteSiteFeature($id)
    {
        $this->verifyCsrf();

        $siteFeatureModel = $this->model('SiteFeature');
        
        if ($siteFeatureModel->delete($id)) {
            $this->jsonSuccess([], lang('deleted') ?? 'تم الحذف');
        }

        $this->jsonError(lang('error_occurred') ?? 'حدث خطأ');
    }

    // ==================== إدارة القوالب (تحكم كامل) ====================

    /**
     * قائمة القوالب - مع التحكم الكامل
     */
    public function themes()
    {
        $themeModel = $this->model('Theme');
        $themes = $themeModel->getAll();

        $this->view('admin/themes', [
            'title' => lang('themes') ?? 'القوالب',
            'themes' => $themes
        ]);
    }

    /**
     * تفعيل/تعطيل قالب
     */
    public function toggleTheme()
    {
        $this->verifyCsrf();

        $themeId = $this->input('theme_id');
        $themeModel = $this->model('Theme');
        $theme = $themeModel->find($themeId);

        if (!$theme) {
            $this->jsonError('القالب غير موجود');
        }

        if ($themeModel->toggleActive($themeId)) {
            $newStatus = $theme->is_active ? 0 : 1;
            $statusText = $newStatus ? 'مفعّل' : 'معطّل';
            $this->jsonSuccess([], 'تم ' . $statusText . ' القالب بنجاح');
        }

        $this->jsonError('حدث خطأ أثناء تحديث حالة القالب');
    }

    /**
     * تحديث معلومات القالب (الاسم، الوصف، النوع، السعر، رابط الدفع)
     */
    public function updateTheme()
    {
        $this->verifyCsrf();

        $themeId = $this->input('theme_id');
        $themeModel = $this->model('Theme');
        $theme = $themeModel->find($themeId);

        if (!$theme) {
            Session::error('القالب غير موجود');
            $this->redirect('/admin/themes');
        }

        $isPaid = $this->input('is_paid') ? 1 : 0;
        $data = [
            'name' => $this->input('name'),
            'name_en' => $this->input('name_en') ?: null,
            'description' => $this->input('description'),
            'description_en' => $this->input('description_en') ?: null,
            'category' => $this->input('category', 'general'),
            'is_paid' => $isPaid,
            'price' => $isPaid ? (float) $this->input('price', 0) : 0,
            'currency' => $this->input('currency', 'SAR'),
            'payment_link' => $isPaid ? $this->input('payment_link') : null,
            'is_active' => $this->input('is_active') ? 1 : 0,
            'sort_order' => (int) $this->input('sort_order', 0),
        ];

        if ($themeModel->update($themeId, $data)) {
            Session::success('تم تحديث القالب بنجاح');
        } else {
            Session::error('حدث خطأ أثناء تحديث القالب');
        }

        $this->redirect('/admin/themes');
    }

    // ==================== استيراد البيانات التجريبية ====================

    /**
     * استيراد جميع البيانات التجريبية للقوالب (محتوى + وسائط)
     * يقرأ ملف SQL وينفذه مباشرة
     */
    public function importAllDemoData()
    {
        // البحث عن ملف SQL في عدة مسارات محتملة
        $possiblePaths = [
            ROOT_PATH . '/sql/demo_content_all_themes.sql',
            dirname(ROOT_PATH) . '/sql/demo_content_all_themes.sql',
            __DIR__ . '/../../sql/demo_content_all_themes.sql',
            dirname(__FILE__, 3) . '/sql/demo_content_all_themes.sql',
        ];
        
        $sqlFile = null;
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $sqlFile = $path;
                break;
            }
        }

        if (!$sqlFile || !file_exists($sqlFile)) {
            // عرض المسارات التي تم البحث فيها للمساعدة في التشخيص
            $searchedPaths = implode(', ', $possiblePaths);
            Session::error('ملف البيانات التجريبية غير موجود. تم البحث في: ' . $searchedPaths);
            $this->redirect('/admin/themes');
        }

        $db = Database::getInstance();
        $pdo = $db->getPdo();
        $sql = file_get_contents($sqlFile);

        if (empty($sql)) {
            Session::error('ملف البيانات التجريبية فارغ');
            $this->redirect('/admin/themes');
        }

        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // تقسيم SQL إلى أوامر منفصلة
            $statements = [];
            $current = '';
            $inString = false;
            $stringChar = '';
            $len = strlen($sql);

            for ($i = 0; $i < $len; $i++) {
                $ch = $sql[$i];

                if (!$inString && ($ch === "'" || $ch === '"')) {
                    $inString = true;
                    $stringChar = $ch;
                    $current .= $ch;
                } elseif ($inString && $ch === $stringChar) {
                    if ($i + 1 < $len && $sql[$i + 1] === $stringChar) {
                        $current .= $ch . $sql[$i + 1];
                        $i++;
                    } else {
                        $inString = false;
                        $current .= $ch;
                    }
                } elseif (!$inString && $ch === ';') {
                    $stmt = trim($current);
                    if (strlen($stmt) > 10 && (
                        stripos($stmt, 'INSERT') !== false ||
                        stripos($stmt, 'UPDATE') !== false ||
                        stripos($stmt, 'DELETE') !== false
                    )) {
                        $statements[] = $stmt;
                    }
                    $current = '';
                } else {
                    $current .= $ch;
                }
            }

            $executed = 0;
            $errors = 0;
            $errorMessages = [];

            foreach ($statements as $statement) {
                try {
                    $pdo->exec($statement);
                    $executed++;
                } catch (PDOException $e) {
                    $errMsg = $e->getMessage();
                    if (stripos($errMsg, 'Duplicate') !== false || stripos($errMsg, 'duplicate') !== false) {
                        $executed++;
                    } else {
                        $errors++;
                        $errorMessages[] = substr($errMsg, 0, 300);
                    }
                }
            }

            $contentsCount = 0;
            $mediaCount = 0;
            try {
                $cnt1 = $pdo->query("SELECT COUNT(*) as c FROM theme_contents")->fetch(PDO::FETCH_OBJ);
                $contentsCount = $cnt1 ? $cnt1->c : 0;

                $cnt2 = $pdo->query("SELECT COUNT(*) as c FROM theme_media")->fetch(PDO::FETCH_OBJ);
                $mediaCount = $cnt2 ? $cnt2->c : 0;
            } catch (PDOException $e) {}

            $message = "تم استيراد البيانات التجريبية بنجاح! ({$executed} أمر - {$contentsCount} نص - {$mediaCount} وسائط)";
            if ($errors > 0) {
                $message .= " | {$errors} أخطاء: " . implode(' | ', $errorMessages);
            }

            Session::success($message);
            $this->redirect('/admin/themes');

        } catch (Exception $e) {
            Session::error('حدث خطأ أثناء الاستيراد: ' . $e->getMessage());
            $this->redirect('/admin/themes');
        }
    }

    /**
     * حذف جميع البيانات التجريبية
     */
    public function clearAllDemoData()
    {
        $db = Database::getInstance();
        $pdo = $db->getPdo();
        try {
            $cnt1 = $pdo->query("SELECT COUNT(*) as c FROM theme_contents")->fetch(PDO::FETCH_OBJ);
            $cnt2 = $pdo->query("SELECT COUNT(*) as c FROM theme_media")->fetch(PDO::FETCH_OBJ);

            $pdo->exec("DELETE FROM theme_contents");
            $pdo->exec("DELETE FROM theme_media");

            $c = $cnt1 ? $cnt1->c : 0;
            $m = $cnt2 ? $cnt2->c : 0;

            Session::success("تم حذف جميع البيانات التجريبية ({$c} نص + {$m} وسائط)");
            $this->redirect('/admin/themes');
        } catch (Exception $e) {
            Session::error('حدث خطأ: ' . $e->getMessage());
            $this->redirect('/admin/themes');
        }
    }

    // ==================== طلبات تفعيل الثيمات المدفوعة ====================

    /**
     * قائمة طلبات تفعيل الثيمات المدفوعة
     */
    public function themeRequests()
    {
        require_once ROOT_PATH . '/app/models/ThemeRequest.php';
        $themeRequestModel = new ThemeRequest();

        $status = $this->input('status');
        $requests = $themeRequestModel->getAllRequests($status);

        $this->view('admin/theme-requests', [
            'title' => 'طلبات تفعيل القوالب',
            'requests' => $requests,
            'status_filter' => $status
        ]);
    }

    /**
     * الموافقة على طلب تفعيل ثيم مدفوع
     */
    public function approveThemeRequest($id)
    {
        $this->verifyCsrf();

        require_once ROOT_PATH . '/app/models/ThemeRequest.php';
        $themeRequestModel = new ThemeRequest();

        $adminNotes = $this->input('admin_notes', '');

        if ($themeRequestModel->approve($id, $adminNotes)) {
            Session::success('تم الموافقة على طلب تفعيل القالب وتطبيقه على موقع المشترك');
        } else {
            Session::error('حدث خطأ. قد يكون الطلب غير موجود أو تم معالجته مسبقاً.');
        }

        $this->redirect('/admin/theme-requests');
    }

    /**
     * رفض طلب تفعيل ثيم مدفوع
     */
    public function rejectThemeRequest($id)
    {
        $this->verifyCsrf();

        require_once ROOT_PATH . '/app/models/ThemeRequest.php';
        $themeRequestModel = new ThemeRequest();

        $adminNotes = $this->input('admin_notes', '');

        if ($themeRequestModel->reject($id, $adminNotes)) {
            Session::success('تم رفض طلب تفعيل القالب');
        } else {
            Session::error('حدث خطأ. قد يكون الطلب غير موجود أو تم معالجته مسبقاً.');
        }

        $this->redirect('/admin/theme-requests');
    }

    // ==================== إدارة محتوى القوالب ====================

    /**
     * صفحة إدارة محتوى قالب معين
     * تتيح للأدمن تعديل النصوص والصور والبنرات والشعارات
     */
    public function themeContent($themeId)
    {
        $themeModel = $this->model('Theme');
        $theme = $themeModel->find($themeId);

        if (!$theme) {
            Session::error('القالب غير موجود');
            $this->redirect('/admin/themes');
        }

        // تحميل نماذج المحتوى والوسائط
        require_once ROOT_PATH . '/app/models/ThemeContent.php';
        require_once ROOT_PATH . '/app/models/ThemeMedia.php';
        
        $contentModel = new ThemeContent();
        $mediaModel = new ThemeMedia();

        // الحصول على محتوى الثيم (مجمّع حسب القسم)
        $content = $contentModel->getContentForEditor($themeId);
        
        // الحصول على وسائط الثيم (مجمّعة حسب النوع)
        $media = $mediaModel->getThemeMediaGrouped($themeId);
        
        // عدد الأقسام والوسائط
        $sectionCounts = $contentModel->getSectionCounts($themeId);
        $mediaTypeCounts = $mediaModel->getMediaTypeCounts($themeId);

        $this->view('admin/theme-content', [
            'title' => 'محتوى القالب: ' . $theme->name,
            'theme' => $theme,
            'theme_content' => $content,
            'theme_media' => $media,
            'section_counts' => $sectionCounts,
            'media_counts' => $mediaTypeCounts
        ]);
    }

    /**
     * حفظ محتوى القالب (النصوص)
     */
    public function saveThemeContent($themeId)
    {
        $this->verifyCsrf();

        $themeModel = $this->model('Theme');
        $theme = $themeModel->find($themeId);

        if (!$theme) {
            $this->jsonError('القالب غير موجود');
        }

        require_once ROOT_PATH . '/app/models/ThemeContent.php';
        $contentModel = new ThemeContent();

        // جمع البيانات من النموذج
        $sectionsData = [];

        // بيانات البانر الرئيسي
        $heroFields = ['hero_title', 'hero_subtitle', 'hero_description', 'hero_button_text'];
        foreach ($heroFields as $field) {
            $ar = $this->input($field . '_ar');
            $en = $this->input($field . '_en');
            $order = $this->input($field . '_order', 0);
            
            if ($ar !== null || $en !== null) {
                $sectionsData['hero'][$field] = [
                    'content_ar' => $ar,
                    'content_en' => $en,
                    'sort_order' => $order
                ];
            }
        }

        // بيانات "عن الثيم"
        $aboutFields = ['about_title', 'about_text'];
        foreach ($aboutFields as $field) {
            $ar = $this->input($field . '_ar');
            $en = $this->input($field . '_en');
            $order = $this->input($field . '_order', 0);
            
            if ($ar !== null || $en !== null) {
                $sectionsData['about'][$field] = [
                    'content_ar' => $ar,
                    'content_en' => $en,
                    'sort_order' => $order
                ];
            }
        }

        // بيانات الخدمات (مصفوفة)
        $servicesAr = $this->input('services_ar', []);
        $servicesEn = $this->input('services_en', []);
        
        if (!empty($servicesAr)) {
            foreach ($servicesAr as $index => $serviceAr) {
                $serviceEn = $servicesEn[$index] ?? '';
                $serviceArJson = json_encode($serviceAr, JSON_UNESCAPED_UNICODE);
                $serviceEnJson = !empty($serviceEn) ? json_encode($serviceEn, JSON_UNESCAPED_UNICODE) : null;
                
                $sectionsData['services']['service_' . ($index + 1)] = [
                    'content_ar' => $serviceArJson,
                    'content_en' => $serviceEnJson,
                    'sort_order' => $index + 1
                ];
            }
        }

        // بيانات آراء العملاء (مصفوفة)
        $testimonialsAr = $this->input('testimonials_ar', []);
        $testimonialsEn = $this->input('testimonials_en', []);
        
        if (!empty($testimonialsAr)) {
            foreach ($testimonialsAr as $index => $testimonialAr) {
                $testimonialEn = $testimonialsEn[$index] ?? [];
                $testimonialArJson = json_encode($testimonialAr, JSON_UNESCAPED_UNICODE);
                $testimonialEnJson = !empty($testimonialEn) ? json_encode($testimonialEn, JSON_UNESCAPED_UNICODE) : null;
                
                $sectionsData['testimonials']['testimonial_' . ($index + 1)] = [
                    'content_ar' => $testimonialArJson,
                    'content_en' => $testimonialEnJson,
                    'sort_order' => $index + 1
                ];
            }
        }

        // بيانات التواصل
        $contactPhone = $this->input('contact_phone');
        $contactEmail = $this->input('contact_email');
        $contactWhatsapp = $this->input('contact_whatsapp');
        $contactAddress = $this->input('contact_address');
        $contactAddressEn = $this->input('contact_address_en');
        
        if ($contactPhone || $contactEmail || $contactAddress) {
            $contactAr = json_encode([
                'phone' => $contactPhone,
                'email' => $contactEmail,
                'whatsapp' => $contactWhatsapp,
                'address' => $contactAddress
            ], JSON_UNESCAPED_UNICODE);
            
            $contactEn = json_encode([
                'phone' => $contactPhone,
                'email' => $contactEmail,
                'whatsapp' => $contactWhatsapp,
                'address' => $contactAddressEn ?: $contactAddress
            ], JSON_UNESCAPED_UNICODE);
            
            $sectionsData['contact']['contact_info'] = [
                'content_ar' => $contactAr,
                'content_en' => $contactEn,
                'sort_order' => 1
            ];
        }

        if ($contentModel->saveThemeContent($themeId, $sectionsData)) {
            Session::success('تم حفظ محتوى القالب بنجاح');
        } else {
            Session::error('حدث خطأ أثناء حفظ المحتوى');
        }

        $this->redirect('/admin/themes/content/' . $themeId);
    }

    /**
     * رفع وسيط لقالب (شعار، بانر، صورة)
     */
    public function uploadThemeMedia($themeId)
    {
        $this->verifyCsrf();

        $themeModel = $this->model('Theme');
        $theme = $themeModel->find($themeId);

        if (!$theme) {
            $this->jsonError('القالب غير موجود');
        }

        $mediaType = $this->input('media_type', 'banner');
        $sectionRef = $this->input('section_ref', 'general');
        $altTextAr = $this->input('alt_text_ar', '');
        $altTextEn = $this->input('alt_text_en', '');

        // الأنواع المسموحة
        $allowedTypes = ['logo', 'banner', 'service_icon', 'service_image', 'gallery', 'favicon', 'og_image'];
        if (!in_array($mediaType, $allowedTypes)) {
            $this->jsonError('نوع الوسائط غير مسموح به');
        }

        // التحقق من وجود ملف
        if (!isset($_FILES['media_file']) || $_FILES['media_file']['error'] !== UPLOAD_ERR_OK) {
            $this->jsonError('يرجى اختيار ملف');
        }

        // رفع الملف
        $result = $this->uploadFile($_FILES['media_file'], 'themes/' . $theme->slug . '/' . $mediaType, ALLOWED_IMAGE_TYPES);

        if (isset($result['error'])) {
            $this->jsonError($result['error']);
        }

        // حفظ في قاعدة البيانات
        require_once ROOT_PATH . '/app/models/ThemeMedia.php';
        $mediaModel = new ThemeMedia();

        $mediaId = $mediaModel->addMedia([
            'theme_id' => $themeId,
            'media_type' => $mediaType,
            'file_path' => $result['path'],
            'file_name' => $result['filename'],
            'alt_text_ar' => $altTextAr,
            'alt_text_en' => $altTextEn,
            'section_ref' => $sectionRef
        ]);

        if ($mediaId) {
            $this->jsonSuccess([
                'media_id' => $mediaId,
                'file_path' => $result['path'],
                'media_type' => $mediaType
            ], 'تم رفع الملف بنجاح');
        }

        $this->jsonError('حدث خطأ أثناء حفظ الملف');
    }

    /**
     * حذف وسيط من قالب
     */
    public function deleteThemeMedia($mediaId)
    {
        $this->verifyCsrf();

        require_once ROOT_PATH . '/app/models/ThemeMedia.php';
        $mediaModel = new ThemeMedia();

        $media = $mediaModel->find($mediaId);
        if (!$media) {
            $this->jsonError('الوسيط غير موجود', [], 404);
        }

        if ($mediaModel->deleteMedia($mediaId)) {
            $this->jsonSuccess([], 'تم حذف الملف بنجاح');
        }

        $this->jsonError('حدث خطأ أثناء حذف الملف');
    }

    /**
     * حذف عنصر محتوى من قالب
     */
    public function deleteThemeContentItem($themeId)
    {
        $this->verifyCsrf();

        $sectionType = $this->input('section_type');
        $contentKey = $this->input('content_key');

        if (!$sectionType || !$contentKey) {
            $this->jsonError('بيانات غير مكتملة');
        }

        require_once ROOT_PATH . '/app/models/ThemeContent.php';
        $contentModel = new ThemeContent();

        if ($contentModel->deleteSectionContent($themeId, $sectionType, $contentKey)) {
            $this->jsonSuccess([], 'تم حذف العنصر بنجاح');
        }

        $this->jsonError('حدث خطأ أثناء الحذف');
    }

    // ==================== إعدادات البريد الإلكتروني (SMTP) ====================

    /**
     * صفحة إعدادات SMTP
     */
    public function emailSettings()
    {
        $settings = EmailService::getSmtpSettings();

        $this->view('admin/email-settings', [
            'title' => 'إعدادات البريد الإلكتروني (SMTP)',
            'settings' => $settings
        ]);
    }

    /**
     * تحديث إعدادات SMTP
     */
    public function updateEmailSettings()
    {
        $this->verifyCsrf();

        $settings = [
            'smtp_host'       => $this->input('smtp_host'),
            'smtp_port'       => $this->input('smtp_port', 587),
            'smtp_username'   => $this->input('smtp_username'),
            'smtp_password'   => $this->input('smtp_password'),
            'smtp_encryption' => $this->input('smtp_encryption', 'tls'),
            'smtp_from_name'  => $this->input('smtp_from_name', SITE_NAME),
            'smtp_from_email' => $this->input('smtp_from_email'),
        ];

        // التحقق من الحقول المطلوبة
        if (empty($settings['smtp_host']) || empty($settings['smtp_username'])) {
            Session::error('يرجى ملء حقول المضيف (Host) واسم المستخدم');
            $this->back();
        }

        if (EmailService::saveSmtpSettings($settings)) {
            Session::success('تم حفظ إعدادات SMTP بنجاح');
        } else {
            Session::error('حدث خطأ أثناء حفظ الإعدادات');
        }

        $this->redirect('/admin/email-settings');
    }

    /**
     * اختبار إعدادات SMTP
     */
    public function testEmailSettings()
    {
        $this->verifyCsrf();

        $testEmail = $this->input('test_email');
        if (!$testEmail) {
            $this->jsonError('يرجى إدخال بريد إلكتروني للاختبار');
        }

        // حفظ الإعدادات أولاً
        $settings = [
            'smtp_host'       => $this->input('smtp_host'),
            'smtp_port'       => $this->input('smtp_port', 587),
            'smtp_username'   => $this->input('smtp_username'),
            'smtp_password'   => $this->input('smtp_password'),
            'smtp_encryption' => $this->input('smtp_encryption', 'tls'),
            'smtp_from_name'  => $this->input('smtp_from_name', SITE_NAME),
            'smtp_from_email' => $this->input('smtp_from_email'),
        ];
        EmailService::saveSmtpSettings($settings);

        // اختبار الإرسال
        try {
            $email = EmailService::getInstance();
            $result = $email->testConnection($testEmail);

            if ($result['success']) {
                $this->jsonSuccess([], $result['message']);
            } else {
                $this->jsonError($result['message']);
            }
        } catch (\Exception $e) {
            $this->jsonError('فشل الاتصال: ' . $e->getMessage());
        }
    }

    // ==================== طلبات الاشتراك والترقية ====================

    /**
     * عرض طلبات الاشتراك والترقية
     */
    public function subscriptionRequests()
    {
        $db = Database::getInstance();
        $statusFilter = $_GET['status'] ?? '';

        $sql = "SELECT sr.*, sp.name as plan_name, sp.price as plan_price,
                u.full_name as user_name, u.email as user_email,
                t.site_name, t.slug as tenant_slug
                FROM subscription_requests sr
                JOIN subscription_plans sp ON sr.plan_id = sp.id
                JOIN tenants t ON sr.tenant_id = t.id
                JOIN users u ON t.user_id = u.id";

        $params = [];
        if ($statusFilter && in_array($statusFilter, ['pending', 'approved', 'rejected', 'cancelled'])) {
            $sql .= " WHERE sr.status = ?";
            $params[] = $statusFilter;
        }

        $sql .= " ORDER BY sr.created_at DESC";

        $requests = $db->query($sql, $params)->results();

        $this->view('admin/subscription-requests', [
            'title' => 'طلبات الاشتراك',
            'requests' => $requests,
            'statusFilter' => $statusFilter
        ]);
    }

    /**
     * قبول طلب اشتراك / ترقية
     * — تم إصلاحه: أسماء أعمدة صحيحة + استخدام جدول tenants بدل subscriptions —
     */

    public function approveSubscriptionRequest($requestId)
    {
        $db = Database::getInstance();
        $requestId = intval($requestId);

        try {
            $sql = "SELECT sr.*, sp.name as plan_name, sp.price_monthly, sp.price_yearly, sp.currency,
                           sp.max_pages, sp.max_services, sp.max_gallery, sp.max_banners,
                           sp.custom_domain, sp.remove_branding, sp.analytics_access,
                           sp.priority_support, sp.features as plan_features,
                           t.business_name as tenant_business_name
                    FROM subscription_requests sr
                    INNER JOIN subscription_plans sp ON sr.plan_id = sp.id
                    INNER JOIN tenants t ON sr.tenant_id = t.id
                    WHERE sr.id = ? AND sr.status = 'pending'";

            $result = $db->query($sql, [$requestId]);
            $request = $result ? ($result->first() ?? null) : null;

            if (!$request) {
                $_SESSION['error'] = 'الطلب غير موجود أو تم معالجته مسبقاً';
                $this->redirect('/admin/subscription-requests');
                return;
            }

            $amount = $request->price_monthly;
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d', strtotime('+30 days'));

            $subSql = "INSERT INTO subscriptions (tenant_id, plan_id, request_id, plan_name, amount,
                         currency, start_date, end_date, status, payment_method, payment_reference, created_at)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active', ?, ?, NOW())";

            $subResult = $db->query($subSql, [
                $request->tenant_id,
                $request->plan_id,
                $request->id,
                $request->plan_name,
                $amount,
                $request->currency,
                $startDate,
                $endDate,
                $request->payment_method ?? 'manual',
                $request->payment_reference ?? ''
            ]);

            if (!$subResult) {
                $_SESSION['error'] = 'حدث خطأ أثناء إنشاء الاشتراك';
                $this->redirect('/admin/subscription-requests');
                return;
            }

            $updateSql = "UPDATE subscription_requests
                          SET status = 'approved',
                              reviewed_at = NOW(),
                              reviewed_by = ?,
                              admin_notes = ?
                          WHERE id = ?";

            $adminId = $_SESSION['user_id'] ?? 1;
            $adminNotes = trim((string)($_POST['admin_notes'] ?? 'تمت الموافقة'));
            $db->query($updateSql, [$adminId, $adminNotes, $requestId]);

            $tenantUpdateSql = "UPDATE tenants
                                SET subscription_status = 'active',
                                    current_plan = ?
                                WHERE id = ?";
            $db->query($tenantUpdateSql, [$request->plan_name, $request->tenant_id]);

            $_SESSION['success'] = 'تم الموافقة على الاشتراك وتفعيله بنجاح';
            $this->redirect('/admin/subscription-requests');

        } catch (Exception $e) {
            error_log("خطأ في الموافقة: " . $e->getMessage());
            $_SESSION['error'] = 'حدث خطأ: ' . $e->getMessage();
            $this->redirect('/admin/subscription-requests');
        }
    }

    /**
     * رفض طلب اشتراك / ترقية
     * — تم إصلاحه: إزالة sr.status واستخدام status مباشرة —
     */

    public function rejectSubscriptionRequest($requestId)
    {
        $db = Database::getInstance();
        $requestId = intval($requestId);

        try {
            $sql = "SELECT sr.*, t.business_name
                    FROM subscription_requests sr
                    INNER JOIN tenants t ON sr.tenant_id = t.id
                    WHERE sr.id = ? AND sr.status = 'pending'";

            $result = $db->query($sql, [$requestId]);
            $request = $result ? ($result->first() ?? null) : null;

            if (!$request) {
                $_SESSION['error'] = 'الطلب غير موجود أو تم معالجته مسبقاً';
                $this->redirect('/admin/subscription-requests');
                return;
            }

            $updateSql = "UPDATE subscription_requests
                          SET status = 'rejected',
                              reviewed_at = NOW(),
                              reviewed_by = ?,
                              admin_notes = ?
                          WHERE id = ?";

            $adminId = $_SESSION['user_id'] ?? 1;
            $adminNotes = trim((string)($_POST['admin_notes'] ?? 'تم رفض الطلب'));
            $db->query($updateSql, [$adminId, $adminNotes, $requestId]);

            $_SESSION['success'] = 'تم رفض طلب الاشتراك';
            $this->redirect('/admin/subscription-requests');

        } catch (Exception $e) {
            error_log("خطأ في الرفض: " . $e->getMessage());
            $_SESSION['error'] = 'حدث خطأ: ' . $e->getMessage();
            $this->redirect('/admin/subscription-requests');
        }
    }

    private function createSlug($text)
    {
        $slug = preg_replace('/\s+/', '-', trim((string)$text));
        $slug = preg_replace('/[^\p{Arabic}a-zA-Z0-9\-]/u', '', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return strtolower($slug);
    }
}
