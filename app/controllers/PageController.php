<?php
/**
 * Page Controller
 * متحكم الصفحات
 */

class PageController extends Controller
{
    private $pageModel;
    private $tenantModel;
    private $planModel;

    public function __construct()
    {
        parent::__construct();
        $this->requireAuth();

        // منع المدير من الوصول
        if (Auth::isAdmin()) {
            Session::error('هذه الصفحة متاحة للعملاء فقط');
            $this->redirect('/admin');
        }

        // تعيين layout الداشبورد
        $this->setLayout('dashboard');
        
        $this->pageModel = $this->model('Page');
        $this->tenantModel = $this->model('Tenant');
        $this->planModel = $this->model('SubscriptionPlan');
    }

    /**
     * قائمة الصفحات
     */
    public function index()
    {
        $tenant = Auth::tenant();
        $pages = $this->pageModel->getTenantPages($tenant->id);

        $this->view('dashboard/pages', [
            'title' => lang('pages'),
            'pages' => $pages,
            'tenant' => $tenant
        ]);
    }

    /**
     * نموذج إضافة صفحة
     */
    public function add()
    {
        $tenant = Auth::tenant();

        $this->view('dashboard/page-form', [
            'title' => lang('add_page'),
            'page' => null,
            'tenant' => $tenant
        ]);
    }

    /**
     * حفظ صفحة جديدة
     */
    public function store()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        // فحص حدود الخطة
        $limit = $this->planModel->checkLimit($tenant->id, 'pages');
        if (!$limit['allowed']) {
            Session::error('لقد وصلت للحد الأقصى للصفحات في خطتك (' . $limit['limit'] . ' صفحات). قم بترقية خطتك لإضافة المزيد.');
            $this->back();
        }

        $data = [
            'tenant_id' => $tenant->id,
            'title' => $this->input('title'),
            'content' => $this->input('content'),
            'meta_title' => $this->input('meta_title'),
            'meta_description' => $this->input('meta_description'),
            'template' => $this->validateTemplateName($this->input('template')),
            'show_in_menu' => $this->input('show_in_menu') ? 1 : 0,
            'status' => $this->input('status') ?: 'published',
            'title_en' => $this->input('title_en') ?: null,
            'content_en' => $this->input('content_en') ?: null
        ];

        // التحقق
        if (empty($data['title'])) {
            Session::error(lang('required_field'));
            $this->back();
        }

        if ($this->pageModel->createPage($data)) {
            Session::success(lang('page_added'));
            $this->redirect('/dashboard/pages');
        }

        Session::error(lang('error'));
        $this->back();
    }

    /**
     * نموذج تعديل صفحة
     */
    public function edit($id)
    {
        $tenant = Auth::tenant();
        $page = $this->pageModel->find($id);

        if (!$page || $page->tenant_id != $tenant->id) {
            Session::error(lang('page_not_found'));
            $this->redirect('/dashboard/pages');
        }

        $this->view('dashboard/page-form', [
            'title' => lang('edit_page'),
            'page' => $page,
            'tenant' => $tenant
        ]);
    }

    /**
     * تحديث صفحة
     */
    public function update($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $page = $this->pageModel->find($id);

        if (!$page || $page->tenant_id != $tenant->id) {
            Session::error(lang('page_not_found'));
            $this->redirect('/dashboard/pages');
        }

        $data = [
            'title' => $this->input('title'),
            'content' => $this->input('content'),
            'meta_title' => $this->input('meta_title'),
            'meta_description' => $this->input('meta_description'),
            'template' => $this->validateTemplateName($this->input('template')),
            'show_in_menu' => $this->input('show_in_menu') ? 1 : 0,
            'status' => $this->input('status') ?: 'published',
            'title_en' => $this->input('title_en') ?: null,
            'content_en' => $this->input('content_en') ?: null
        ];

        if ($this->pageModel->updatePage($id, $data)) {
            Session::success(lang('page_updated'));
        } else {
            Session::error(lang('error'));
        }

        $this->redirect('/dashboard/pages');
    }

    /**
     * حذف صفحة
     */
    public function delete($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $page = $this->pageModel->find($id);

        if (!$page || $page->tenant_id != $tenant->id) {
            $this->jsonError(lang('page_not_found'), [], 404);
        }

        // لا يمكن حذف الصفحة الرئيسية
        if ($page->is_home) {
            $this->jsonError(lang('cannot_delete_home'));
        }

        if ($this->pageModel->delete($id)) {
            $this->jsonSuccess([], lang('page_deleted'));
        }

        $this->jsonError(lang('error'));
    }

    /**
     * [FIX-19] التحقق من اسم القالب لمنع Directory Traversal
     */
    private function validateTemplateName($template)
    {
        if (empty($template)) {
            return 'default';
        }
        // السماح فقط بأحرف أبجدية وأرقام وشرطة
        $template = basename($template);
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $template)) {
            return 'default';
        }
        return $template;
    }
}
