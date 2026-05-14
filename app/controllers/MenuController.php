<?php
/**
 * CMS Platform - Menu Controller
 * متحكم إدارة المنو
 */

class MenuController extends Controller
{
    private $menuModel;
    private $pageModel;

    public function __construct()
    {
        parent::__construct();
        $this->requireAuth();

        // منع المدير من الوصول
        if (Auth::isAdmin()) {
            Session::error('هذه الصفحة متاحة للعملاء فقط');
            $this->redirect('/admin');
        }

        $this->setLayout('dashboard');
        $this->menuModel = $this->model('MenuModel');
        $this->pageModel = $this->model('Page');
    }

    /**
     * صفحة إدارة المنو
     */
    public function index()
    {
        $tenant = Auth::tenant();
        $menuItems = $this->menuModel->getTenantMenu($tenant->id);
        $missingSections = $this->menuModel->getMissingSections($tenant->id);
        $missingPages = $this->menuModel->getMissingPages($tenant->id);

        $this->view('dashboard/menu', [
            'title'           => 'إدارة المنو',
            'menuItems'       => $menuItems,
            'missingSections' => $missingSections,
            'missingPages'    => $missingPages,
            'availableSections' => MenuModel::getAvailableSections(),
            'tenant'          => $tenant,
        ]);
    }

    /**
     * إضافة قسم للمنو (AJAX)
     */
    public function addSection()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        // استخدام rawInput لأن section_key هو مفتاح نصي بسيط لا يحتاج تنقية HTML
        $sectionKey = $this->rawInput('section_key');

        if (!$sectionKey) {
            $this->jsonError('يجب تحديد القسم', [], 400);
        }

        try {
            $result = $this->menuModel->addSection($tenant->id, $sectionKey);
            if ($result) {
                $items = $this->menuModel->getTenantMenu($tenant->id);
                $this->jsonSuccess(['items' => $items], 'تم إضافة القسم للمنو');
            } else {
                // تحديد السبب الدقيق للفشل
                $sections = MenuModel::getAvailableSections();
                if (!isset($sections[$sectionKey])) {
                    $this->jsonError('مفتاح القسم غير صالح: ' . $sectionKey);
                } else {
                    $dbErr = $this->menuModel->error();
                    $this->jsonError('فشل في إضافة القسم' . ($dbErr ? ' (خطأ في قاعدة البيانات)' : ''));
                }
            }
        } catch (\Exception $e) {
            $this->jsonError('حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * إضافة صفحة للمنو (AJAX)
     */
    public function addPage()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        // استخدام rawInput لأن page_id هو رقم لا يحتاج تنقية HTML
        $pageId = $this->rawInput('page_id');

        if (!$pageId) {
            $this->jsonError('يجب تحديد الصفحة', [], 400);
        }

        try {
            $result = $this->menuModel->addPageToMenu($tenant->id, (int)$pageId);
            if ($result) {
                $items = $this->menuModel->getTenantMenu($tenant->id);
                $this->jsonSuccess(['items' => $items], 'تم إضافة الصفحة للمنو');
            } else {
                // تحديد السبب الدقيق للفشل
                $dbErr = $this->menuModel->error();
                $this->jsonError('فشل في إضافة الصفحة' . ($dbErr ? ' (خطأ في قاعدة البيانات)' : ''));
            }
        } catch (\Exception $e) {
            $this->jsonError('حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * إضافة رابط خارجي (AJAX)
     */
    public function addExternal()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $label = $this->input('label');
        $url = $this->input('url');

        if (empty($label) || empty($url)) {
            $this->jsonError('يجب إدخال العنوان والرابط', [], 400);
        }

        $result = $this->menuModel->addExternalLink(
            $tenant->id,
            $label,
            $url,
            $this->input('label_en'),
            $this->input('icon'),
            $this->input('open_in_new_tab')
        );

        if ($result) {
            $items = $this->menuModel->getTenantMenu($tenant->id);
            $this->jsonSuccess(['items' => $items], 'تم إضافة الرابط للمنو');
        } else {
            $this->jsonError('حدث خطأ أثناء الإضافة');
        }
    }

    /**
     * تحديث الترتيب (AJAX)
     */
    public function updateOrder()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $orders = $this->input('orders');

        if ($this->menuModel->updateOrder($tenant->id, $orders)) {
            $this->jsonSuccess([], 'تم تحديث الترتيب');
        } else {
            $this->jsonError('حدث خطأ أثناء تحديث الترتيب');
        }
    }

    /**
     * تفعيل/إخفاء عنصر (AJAX)
     */
    public function toggle()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $id = $this->input('id');

        if (!$id) {
            $this->jsonError('معرف العنصر غير صالح', [], 400);
        }

        if ($this->menuModel->toggleActive($id, $tenant->id)) {
            $items = $this->menuModel->getTenantMenu($tenant->id);
            $this->jsonSuccess(['items' => $items], 'تم تحديث الحالة');
        } else {
            $this->jsonError('العنصر غير موجود');
        }
    }

    /**
     * حذف عنصر (AJAX)
     */
    public function remove()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $id = $this->input('id');

        if (!$id) {
            $this->jsonError('معرف العنصر غير صالح', [], 400);
        }

        if ($this->menuModel->removeItem($id, $tenant->id)) {
            $items = $this->menuModel->getTenantMenu($tenant->id);
            $this->jsonSuccess(['items' => $items], 'تم حذف العنصر');
        } else {
            $this->jsonError('العنصر غير موجود');
        }
    }

    /**
     * تحديث التسمية (AJAX)
     */
    public function updateLabels()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $id = $this->input('id');
        $label = $this->input('label');

        if (!$id || empty($label)) {
            $this->jsonError('البيانات غير مكتملة', [], 400);
        }

        if ($this->menuModel->updateLabels($id, $tenant->id, $label, $this->input('label_en'))) {
            $items = $this->menuModel->getTenantMenu($tenant->id);
            $this->jsonSuccess(['items' => $items], 'تم تحديث التسمية');
        } else {
            $this->jsonError('العنصر غير موجود');
        }
    }
}
