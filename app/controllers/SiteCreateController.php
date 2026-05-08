<?php
/**
 * Site Create Controller
 * متحكم إنشاء الموقع الأول
 */

class SiteCreateController extends Controller
{
    private $tenantModel;
    private $themeModel;

    public function __construct()
    {
        parent::__construct();
        $this->tenantModel = $this->model('Tenant');
        $this->themeModel = $this->model('Theme');
    }

    /**
     * عرض صفحة إنشاء الموقع
     */
    public function index()
    {
        $this->requireAuth();

        // التحقق من وجود موقع
        $tenant = Auth::tenant();
        if ($tenant) {
            $this->redirect('/dashboard');
        }

        // الحصول على الثيمات
        $themes = $this->themeModel->getActive();

        $this->view('site/create', [
            'title' => lang('create_site'),
            'themes' => $themes
        ]);
    }

    /**
     * إنشاء الموقع
     */
    public function store()
    {
        $this->requireAuth();
        $this->verifyCsrf();

        // التحقق من وجود موقع
        if (Auth::tenant()) {
            $this->jsonError('لديك موقع بالفعل');
        }

        $data = [
            'site_name' => $this->input('site_name'),
            'theme_id' => $this->input('theme_id') ?: 1,
            'user_id' => Auth::id(),
            'contact_email' => Auth::user()->email,
            'contact_phone' => Auth::user()->phone,
        ];

        // التحقق من البيانات
        $errors = $this->validate($data, [
            'site_name' => ['required', 'min:3'],
            'theme_id' => ['required']
        ]);

        if (!empty($errors)) {
            Session::error(array_values($errors)[0]);
            $this->back();
        }

        // التحقق من الثيم أو استخدام الافتراضي (نوفا)
        if (empty($data['theme_id'])) {
            $data['theme_id'] = 1;
        }
        $theme = $this->themeModel->find($data['theme_id']);
        if (!$theme) {
            // البحث عن قالب نوفا
            $theme = $this->themeModel->findBySlug('nova');
            if (!$theme) {
                $theme = $this->themeModel->find(1);
            }
            if ($theme) {
                $data['theme_id'] = $theme->id;
            }
        }

        // إنشاء الموقع
        $tenantId = $this->tenantModel->createSite($data);

        if ($tenantId) {
            // تحديث بيانات المستخدم في الجلسة
            $tenant = $this->tenantModel->find($tenantId);
            Session::put('tenant_id', $tenantId);
            Session::put('tenant_slug', $tenant->slug);

            // استيراد البيانات التجريبية للموقع الجديد
            $demoModel = new DemoData();
            $demoModel->importForTenant($tenantId, $theme->slug);

            Session::success(lang('site_created'));
            $this->redirect('/dashboard');
        }

        Session::error('حدث خطأ أثناء إنشاء الموقع');
        $this->back();
    }
}
