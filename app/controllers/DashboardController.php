<?php
/**
 * CMS Platform - Dashboard Controller
 * متحكم لوحة التحكم
 */

class DashboardController extends Controller
{
    private $tenantModel;
    private $pageModel;
    private $serviceModel;
    private $bannerModel;
    private $galleryModel;
    private $testimonialModel;
    private $faqModel;
    private $siteStatModel;
    private $siteFeatureModel;
    private $partnerModel;
    private $demoDataModel;
    private $planModel;

    public function __construct()
    {
        parent::__construct();
        // منع المدير من الوصول للوحة تحكم العميل
        if (Auth::isAdmin()) {
            Session::error('هذه الصفحة متاحة للعملاء فقط');
            $this->redirect('/admin');
        }
        $this->requireAuth();
        
        // تعيين layout الداشبورد بشكل افتراضي لكل صفحات العميل
        $this->setLayout('dashboard');
        
        $this->tenantModel = $this->model('Tenant');
        $this->pageModel = $this->model('Page');
        $this->serviceModel = $this->model('Service');
        $this->bannerModel = $this->model('Banner');
        $this->galleryModel = $this->model('Gallery');
        $this->testimonialModel = $this->model('Testimonial');
        $this->faqModel = $this->model('Faq');
        $this->siteStatModel = $this->model('SiteStat');
        $this->siteFeatureModel = $this->model('SiteFeature');
        $this->partnerModel = $this->model('Partner');
        $this->demoDataModel = $this->model('DemoData');
        $this->planModel = $this->model('SubscriptionPlan');
    }

    /**
     * عرض لوحة التحكم الرئيسية
     */
    public function index()
    {
        $tenant = Auth::tenant();

        if (!$tenant) {
            // إذا لم يكن لديه موقع، توجيه لإنشاء موقع
            $this->redirect('/site/create');
        }

        $stats = $this->tenantModel->getStats($tenant->id);

        $this->view('dashboard/index', [
            'title' => 'لوحة التحكم',
            'tenant' => $tenant,
            'stats' => $stats,
            'recent_messages' => $this->getRecentMessages($tenant->id)
        ]);
    }

    /**
     * الحصول على الرسائل الأخيرة
     */
    private function getRecentMessages($tenantId, $limit = 5)
    {
        $db = Database::getInstance();
        return $db->query(
            "SELECT * FROM contact_messages WHERE tenant_id = ? ORDER BY created_at DESC LIMIT ?",
            [$tenantId, $limit]
        )->results();
    }

    /**
     * عرض صفحة الإعدادات
     */
    public function settings()
    {
        $tenant = Auth::tenant();
        $themeModel = $this->model('Theme');
        $themes = $themeModel->getActive();
        
        // الحصول على إعدادات الأقسام
        $sectionsConfig = $this->tenantModel->getSectionsConfig($tenant->id);

        $this->view('dashboard/settings', [
            'title' => 'إعدادات الموقع',
            'tenant' => $tenant,
            'themes' => $themes,
            'sectionsConfig' => $sectionsConfig
        ]);
    }

    /**
     * تحديث إعدادات الموقع
     */
    public function updateSettings()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $tenantId = $tenant->id;

        // تحديث معلومات أساسية
        $basicData = [
            'site_name' => $this->input('site_name'),
            'contact_email' => $this->input('contact_email'),
            'contact_phone' => $this->input('contact_phone'),
            'contact_phone2' => $this->input('contact_phone2'),
            'contact_whatsapp' => $this->input('contact_whatsapp'),
            'address' => $this->input('address'),
            'working_hours' => $this->input('working_hours'),
            'site_name_en' => $this->input('site_name_en') ?: null,
            'default_language' => $this->input('default_language') ?: 'ar',
        ];

        $this->tenantModel->update($tenantId, $basicData);

        // تحديث السوشال ميديا
        $socialData = [
            'facebook' => $this->input('facebook'),
            'twitter' => $this->input('twitter'),
            'instagram' => $this->input('instagram'),
            'linkedin' => $this->input('linkedin'),
            'youtube' => $this->input('youtube'),
            'tiktok' => $this->input('tiktok'),
        ];

        $this->tenantModel->updateSocial($tenantId, $socialData);

        // تحديث SEO
        $seoData = [
            'meta_title' => $this->input('meta_title'),
            'meta_description' => $this->input('meta_description'),
            'meta_keywords' => $this->input('meta_keywords'),
            'meta_description_en' => $this->input('meta_description_en') ?: null,
        ];

        $this->tenantModel->updateSeo($tenantId, $seoData);

        Session::success('تم حفظ الإعدادات بنجاح');
        $this->redirect('/dashboard/settings');
    }

    /**
     * تحديث الألوان
     */
    public function updateColors()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        // [FIX-29] التحقق من صيغة ألوان Hex
        $colors = [
            'primary_color' => $this->sanitizeHexColor($this->input('primary_color')),
            'secondary_color' => $this->sanitizeHexColor($this->input('secondary_color')),
            'accent_color' => $this->sanitizeHexColor($this->input('accent_color')),
            'text_color' => $this->sanitizeHexColor($this->input('text_color')),
            'background_color' => $this->sanitizeHexColor($this->input('background_color')),
        ];

        if ($this->tenantModel->updateColors($tenant->id, $colors)) {
            Session::success('تم تحديث الألوان بنجاح');
        } else {
            Session::error('حدث خطأ أثناء تحديث الألوان');
        }

        $this->redirect('/dashboard/settings');
    }

    /**
     * تحديث الشعار
     */
    public function updateLogo()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        if (!isset($_FILES['logo']) || $_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
            Session::error('يرجى اختيار صورة');
            $this->redirect('/dashboard/settings');
        }

        $result = $this->uploadFile($_FILES['logo'], $tenant->id, ALLOWED_IMAGE_TYPES);

        if (isset($result['error'])) {
            Session::error($result['error']);
            $this->redirect('/dashboard/settings');
        }

        // حذف الشعار القديم
        if ($tenant->logo) {
            $this->deleteFile($tenant->logo);
        }

        $this->tenantModel->updateLogo($tenant->id, $result['path']);

        Session::success('تم تحديث الشعار بنجاح');
        $this->redirect('/dashboard/settings');
    }

    /**
     * تغيير الثيم
     */
    public function changeTheme()
    {
        $this->verifyCsrf();
        $tenant = Auth::tenant();
        $themeSlug = $this->input('theme_slug');

        if (!$themeSlug) {
            Session::error('يرجى اختيار قالب');
            $this->redirect('/dashboard/themes');
        }

        $themeModel = $this->model('Theme');
        $theme = $themeModel->findBySlug($themeSlug);

        if (!$theme) {
            Session::error('القالب غير موجود');
            $this->redirect('/dashboard/themes');
        }

        // Check if paid theme and not owned
        if (!empty($theme->is_paid)) {
            $ownsTheme = $themeModel->tenantOwnsTheme($tenant->id, $theme->id);
            if (!$ownsTheme) {
                Session::error('هذا القالب مدفوع. يرجى تقديم طلب تفعيل أولاً.');
                $this->redirect('/dashboard/themes');
            }
        }

        // Update tenant theme
        $this->tenantModel->update($tenant->id, [
            'theme_id' => $theme->id,
            'theme_slug' => $theme->slug
        ]);

        Session::success('تم تغيير القالب بنجاح إلى: ' . $theme->name);
        $this->redirect('/dashboard/themes');
    }

    /**
     * طلب تفعيل ثيم مدفوع
     */
    public function requestPaidTheme()
    {
        $this->verifyCsrf();
        $tenant = Auth::tenant();
        $themeId = $this->input('theme_id');

        if (!$themeId) {
            $this->redirect('/dashboard/themes');
        }

        $themeModel = $this->model('Theme');
        $theme = $themeModel->find($themeId);

        if (!$theme || empty($theme->is_paid)) {
            Session::error('القالب غير موجود أو غير مدفوع');
            $this->redirect('/dashboard/themes');
        }

        // Check if already has pending request
        if ($themeModel->hasPendingRequest($tenant->id, $themeId)) {
            Session::error('لديك طلب معلق بالفعل لهذا القالب');
            $this->redirect('/dashboard/themes');
        }

        // Check if already approved
        if ($themeModel->tenantOwnsTheme($tenant->id, $themeId)) {
            Session::error('لديك بالفعل هذا القالب. يمكنك تفعيله مباشرة.');
            $this->redirect('/dashboard/themes');
        }

        // Create request
        require_once ROOT_PATH . '/app/models/ThemeRequest.php';
        $requestModel = new ThemeRequest();
        $requestModel->create([
            'tenant_id' => $tenant->id,
            'theme_id' => $themeId,
            'status' => 'pending',
            'amount' => $theme->price,
            'currency' => $theme->currency ?? 'SAR',
            'tenant_notes' => $this->input('notes')
        ]);

        Session::success('تم تقديم طلب تفعيل القالب بنجاح. سيتم مراجعة الطلب من قبل الإدارة.');
        $this->redirect('/dashboard/themes');
    }

    /**
     * عرض صفحة اختيار الثيمات
     */
    public function themes()
    {
        $tenant = Auth::tenant();
        $themeModel = $this->model('Theme');
        $themes = $themeModel->getActive();

        // Get tenant's theme requests
        $db = Database::getInstance();
        $themeRequests = $db->query(
            "SELECT * FROM theme_requests WHERE tenant_id = ?",
            [$tenant->id]
        )->results();

        $this->view('dashboard/themes-selection', [
            'title' => lang('choose_theme') ?? 'اختيار القالب',
            'tenant' => $tenant,
            'themes' => $themes,
            'themeRequests' => $themeRequests
        ]);
    }

    /**
     * نشر الموقع
     */
    public function publish()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        if ($this->tenantModel->update($tenant->id, ['site_status' => 'published'])) {
            Session::success('تم نشر الموقع بنجاح');
        } else {
            Session::error('حدث خطأ أثناء نشر الموقع');
        }

        $this->redirect('/dashboard');
    }

    // ==================== الخدمات ====================

    /**
     * عرض قائمة الخدمات
     */
    public function services()
    {
        $tenant = Auth::tenant();
        $services = $this->serviceModel->getTenantServices($tenant->id);

        $this->view('dashboard/services', [
            'title' => 'الخدمات',
            'tenant' => $tenant,
            'services' => $services
        ]);
    }

    /**
     * عرض نموذج إضافة خدمة
     */
    public function addService()
    {
        $tenant = Auth::tenant();

        $this->view('dashboard/service-form', [
            'title' => 'إضافة خدمة جديدة',
            'tenant' => $tenant,
            'service' => null
        ]);
    }

    /**
     * حفظ خدمة جديدة
     */
    public function storeService()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        // فحص حدود الخطة
        $limit = $this->planModel->checkLimit($tenant->id, 'services');
        if (!$limit['allowed']) {
            Session::error('لقد وصلت للحد الأقصى للخدمات في خطتك (' . $limit['limit'] . ' خدمات). قم بترقية خطتك لإضافة المزيد.');
            $this->redirect('/dashboard/services/add');
        }

        $data = [
            'tenant_id' => $tenant->id,
            'title' => $this->input('title'),
            // [SEC-FIX-03] تنقية HTML الغني قبل الحفظ لمنع Stored XSS
            'description' => function_exists('sanitizeHTML') ? sanitizeHTML($this->rawInput('description')) : $this->input('description'),
            'content' => function_exists('sanitizeHTML') ? sanitizeHTML($this->rawInput('content')) : $this->input('content'),
            'icon' => $this->input('icon'),
            'price' => $this->input('price') ?: null,
            'price_text' => $this->input('price_text'),
            'show_on_home' => $this->input('show_on_home') ? 1 : 0,
            'status' => $this->input('status') ?: 'active',
            'title_en' => $this->input('title_en') ?: null,
            'description_en' => function_exists('sanitizeHTML') ? sanitizeHTML($this->rawInput('description_en')) : $this->input('description_en'),
            'content_en' => function_exists('sanitizeHTML') ? sanitizeHTML($this->rawInput('content_en')) : $this->input('content_en')
        ];

        // رفع الصورة
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $result = $this->uploadFile($_FILES['image'], $tenant->id . '/services', ALLOWED_IMAGE_TYPES);
            if (!isset($result['error'])) {
                $data['image'] = $result['path'];
            }
        }

        if ($this->serviceModel->createService($data)) {
            Session::success('تم إضافة الخدمة بنجاح');
            $this->redirect('/dashboard/services');
        }

        Session::error('حدث خطأ أثناء إضافة الخدمة');
        $this->redirect('/dashboard/services/add');
    }

    /**
     * عرض نموذج تعديل خدمة
     */
    public function editService($id)
    {
        $tenant = Auth::tenant();
        $service = $this->serviceModel->find($id);

        if (!$service || $service->tenant_id != $tenant->id) {
            Session::error('الخدمة غير موجودة');
            $this->redirect('/dashboard/services');
        }

        $this->view('dashboard/service-form', [
            'title' => 'تعديل الخدمة',
            'tenant' => $tenant,
            'service' => $service
        ]);
    }

    /**
     * تحديث خدمة
     */
    public function updateService($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $service = $this->serviceModel->find($id);

        if (!$service || $service->tenant_id != $tenant->id) {
            Session::error('الخدمة غير موجودة');
            $this->redirect('/dashboard/services');
        }

        $data = [
            'title' => $this->input('title'),
            // [SEC-FIX-03] تنقية HTML الغني قبل الحفظ
            'description' => function_exists('sanitizeHTML') ? sanitizeHTML($this->rawInput('description')) : $this->input('description'),
            'content' => function_exists('sanitizeHTML') ? sanitizeHTML($this->rawInput('content')) : $this->input('content'),
            'icon' => $this->input('icon'),
            'price' => $this->input('price') ?: null,
            'price_text' => $this->input('price_text'),
            'show_on_home' => $this->input('show_on_home') ? 1 : 0,
            'status' => $this->input('status') ?: 'active',
            'title_en' => $this->input('title_en') ?: null,
            'description_en' => function_exists('sanitizeHTML') ? sanitizeHTML($this->rawInput('description_en')) : $this->input('description_en'),
            'content_en' => function_exists('sanitizeHTML') ? sanitizeHTML($this->rawInput('content_en')) : $this->input('content_en')
        ];

        // رفع صورة جديدة
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $result = $this->uploadFile($_FILES['image'], $tenant->id . '/services', ALLOWED_IMAGE_TYPES);
            if (!isset($result['error'])) {
                // حذف الصورة القديمة
                if ($service->image) {
                    $this->deleteFile($service->image);
                }
                $data['image'] = $result['path'];
            }
        }

        if ($this->serviceModel->updateService($id, $data)) {
            Session::success('تم تحديث الخدمة بنجاح');
        } else {
            Session::error('حدث خطأ أثناء تحديث الخدمة');
        }

        $this->redirect('/dashboard/services');
    }

    /**
     * حذف خدمة
     */
    public function deleteService($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $service = $this->serviceModel->find($id);

        if (!$service || $service->tenant_id != $tenant->id) {
            $this->jsonError('الخدمة غير موجودة', [], 404);
        }

        // حذف الصورة
        if ($service->image) {
            $this->deleteFile($service->image);
        }

        if ($this->serviceModel->delete($id)) {
            $this->jsonSuccess([], 'تم حذف الخدمة بنجاح');
        }

        $this->jsonError('حدث خطأ أثناء حذف الخدمة');
    }

    // ==================== البانرات ====================

    /**
     * عرض قائمة البانرات
     */
    public function banners()
    {
        $tenant = Auth::tenant();
        $banners = $this->bannerModel->getTenantBanners($tenant->id);

        $this->view('dashboard/banners', [
            'title' => 'البانرات',
            'tenant' => $tenant,
            'banners' => $banners
        ]);
    }

    /**
     * إضافة بانر جديد
     */
    public function storeBanner()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        // فحص حدود الخطة
        $limit = $this->planModel->checkLimit($tenant->id, 'banners');
        if (!$limit['allowed']) {
            Session::error('لقد وصلت للحد الأقصى للبانرات في خطتك (' . $limit['limit'] . ' بانرات). قم بترقية خطتك لإضافة المزيد.');
            $this->redirect('/dashboard/banners');
        }

        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            Session::error('يرجى اختيار صورة');
            $this->redirect('/dashboard/banners');
        }

        $result = $this->uploadFile($_FILES['image'], $tenant->id . '/banners', ALLOWED_IMAGE_TYPES);

        if (isset($result['error'])) {
            Session::error($result['error']);
            $this->redirect('/dashboard/banners');
        }

        $data = [
            'tenant_id' => $tenant->id,
            'title' => $this->input('title'),
            'subtitle' => $this->input('subtitle'),
            'description' => $this->input('description'),
            'image' => $result['path'],
            'link' => $this->input('link'),
            'button_text' => $this->input('button_text'),
            'position' => $this->input('position') ?: 'hero',
            'status' => 'active',
            'title_en' => $this->input('title_en') ?: null,
            'subtitle_en' => $this->input('subtitle_en') ?: null,
            'description_en' => $this->input('description_en') ?: null,
            'button_text_en' => $this->input('button_text_en') ?: null
        ];

        if ($this->bannerModel->createBanner($data)) {
            Session::success('تم إضافة البانر بنجاح');
        } else {
            Session::error('حدث خطأ أثناء إضافة البانر');
        }

        $this->redirect('/dashboard/banners');
    }

    /**
     * حذف بانر
     */
    public function deleteBanner($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        $banner = $this->bannerModel->find($id);

        if (!$banner || $banner->tenant_id != $tenant->id) {
            $this->jsonError('البانر غير موجود', [], 404);
        }

        if ($this->bannerModel->deleteWithImage($id)) {
            $this->jsonSuccess([], 'تم حذف البانر بنجاح');
        }

        $this->jsonError('حدث خطأ أثناء حذف البانر');
    }

    /**
     * تعديل بانر (GET لتحميل البيانات + POST للحفظ)
     */
    public function updateBanner($id)
    {
        $tenant = Auth::tenant();
        $banner = $this->bannerModel->find($id);

        if (!$banner || $banner->tenant_id != $tenant->id) {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->jsonError('البانر غير موجود', [], 404);
            }
            Session::error('البانر غير موجود');
            $this->redirect('/dashboard/banners');
            return;
        }

        // طلب GET: تحميل بيانات البانر للتعديل (AJAX)
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->jsonSuccess(['banner' => $banner]);
            return;
        }

        // طلب POST: حفظ التعديلات
        $this->verifyCsrf();

        $data = [
            'title'       => $this->input('title'),
            'subtitle'    => $this->input('subtitle'),
            'description' => $this->input('description'),
            'link'        => $this->input('link'),
            'button_text' => $this->input('button_text'),
            'position'    => $this->input('position') ?: 'hero',
            'title_en'       => $this->input('title_en') ?: null,
            'subtitle_en'    => $this->input('subtitle_en') ?: null,
            'description_en' => $this->input('description_en') ?: null,
            'button_text_en' => $this->input('button_text_en') ?: null,
        ];

        // معالجة رفع صورة جديدة
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $result = $this->uploadFile($_FILES['image'], $tenant->id . '/banners', ALLOWED_IMAGE_TYPES);
            if (isset($result['error'])) {
                Session::error($result['error']);
                $this->redirect('/dashboard/banners');
            }
            // حذف الصورة القديمة
            if (!empty($banner->image)) {
                $oldImagePath = UPLOAD_PATH . '/' . $banner->image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $data['image'] = $result['path'];
        }

        if ($this->bannerModel->update($id, $data)) {
            Session::success('تم تحديث البانر بنجاح');
        } else {
            Session::error('حدث خطأ أثناء تحديث البانر');
        }

        $this->redirect('/dashboard/banners');
    }

    // ==================== المعرض ====================

    /**
     * عرض المعرض
     */
    public function gallery()
    {
        $tenant = Auth::tenant();
        $gallery = $this->galleryModel->getTenantGallery($tenant->id);
        $categories = $this->galleryModel->getCategories($tenant->id);

        $this->view('dashboard/gallery', [
            'title' => 'معرض الصور',
            'tenant' => $tenant,
            'gallery' => $gallery,
            'categories' => $categories
        ]);
    }

    /**
     * رفع صور للمعرض
     */
    public function uploadGallery()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        if (!isset($_FILES['images'])) {
            $this->jsonError('لم يتم اختيار صور');
        }

        // فحص حدود الخطة للمعرض
        $limit = $this->planModel->checkLimit($tenant->id, 'gallery');
        $currentCount = $limit['current'];
        $maxAllowed = $limit['limit'];
        $newImagesCount = is_array($_FILES['images']['name']) ? count($_FILES['images']['name']) : 1;

        if (!$limit['allowed'] && $maxAllowed != -1) {
            $remaining = $maxAllowed - $currentCount;
            if ($remaining <= 0) {
                $this->jsonError('لقد وصلت للحد الأقصى للصور في خطتك (' . $maxAllowed . ' صور). قم بترقية خطتك لإضافة المزيد.');
            }
        }

        $uploaded = $this->galleryModel->uploadMultiple(
            $tenant->id,
            $_FILES['images'],
            $this->input('category')
        );

        if (count($uploaded) > 0) {
            $this->jsonSuccess(['count' => count($uploaded)], 'تم رفع ' . count($uploaded) . ' صور بنجاح');
        }

        $this->jsonError('فشل في رفع الصور');
    }

    /**
     * حذف صورة من المعرض
     */
    public function deleteGalleryImage($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $image = $this->galleryModel->find($id);

        if (!$image || $image->tenant_id != $tenant->id) {
            $this->jsonError('الصورة غير موجودة', [], 404);
        }

        if ($this->galleryModel->deleteWithFile($id)) {
            $this->jsonSuccess([], 'تم حذف الصورة بنجاح');
        }

        $this->jsonError('حدث خطأ أثناء حذف الصورة');
    }

    /**
     * تعديل عنوان صورة من المعرض
     */
    public function editGalleryImage($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $image = $this->galleryModel->find($id);

        if (!$image || $image->tenant_id != $tenant->id) {
            $this->jsonError('الصورة غير موجودة', [], 404);
        }

        $data = [
            'title' => $this->input('title') ?: $image->title,
            'title_en' => $this->input('title_en') ?: null
        ];

        if ($this->galleryModel->update($id, $data)) {
            $this->jsonSuccess([], 'تم تحديث العنوان بنجاح');
        }

        $this->jsonError('حدث خطأ أثناء تحديث العنوان');
    }

    // ==================== آراء العملاء ====================

    /**
     * عرض قائمة الآراء
     */
    public function testimonials()
    {
        $tenant = Auth::tenant();
        $testimonials = $this->testimonialModel->getTenantTestimonials($tenant->id);

        $this->view('dashboard/testimonials', [
            'title' => 'آراء العملاء',
            'tenant' => $tenant,
            'testimonials' => $testimonials
        ]);
    }

    /**
     * إضافة رأي جديد
     */
    public function storeTestimonial()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        // فحص حدود الخطة
        $limit = $this->planModel->checkLimit($tenant->id, 'testimonials');
        if (!$limit['allowed']) {
            Session::error('لقد وصلت للحد الأقصى لآراء العملاء في خطتك (' . $limit['limit'] . ' آراء). قم بترقية خطتك لإضافة المزيد.');
            $this->redirect('/dashboard/testimonials');
        }

        $data = [
            'tenant_id' => $tenant->id,
            'client_name' => $this->input('client_name'),
            'client_title' => $this->input('client_title'),
            'content' => function_exists('sanitizeHTML') ? sanitizeHTML($this->rawInput('content')) : $this->input('content'),
            'rating' => $this->input('rating') ?: 5,
            'show_on_home' => $this->input('show_on_home') ? 1 : 0,
            'status' => 'active',
            'content_en' => function_exists('sanitizeHTML') ? sanitizeHTML($this->rawInput('content_en')) : $this->input('content_en'),
            'client_title_en' => $this->input('client_title_en') ?: null
        ];

        // رفع صورة العميل
        if (isset($_FILES['client_image']) && $_FILES['client_image']['error'] === UPLOAD_ERR_OK) {
            $result = $this->uploadFile($_FILES['client_image'], $tenant->id . '/testimonials', ALLOWED_IMAGE_TYPES);
            if (!isset($result['error'])) {
                $data['client_image'] = $result['path'];
            }
        }

        if ($this->testimonialModel->createTestimonial($data)) {
            Session::success('تم إضافة الرأي بنجاح');
        } else {
            Session::error('حدث خطأ أثناء إضافة الرأي');
        }

        $this->redirect('/dashboard/testimonials');
    }

    /**
     * حذف رأي
     */
    public function deleteTestimonial($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $testimonial = $this->testimonialModel->find($id);

        if (!$testimonial || $testimonial->tenant_id != $tenant->id) {
            $this->jsonError('الرأي غير موجود', [], 404);
        }

        if ($this->testimonialModel->deleteWithImage($id)) {
            $this->jsonSuccess([], 'تم حذف الرأي بنجاح');
        }

        $this->jsonError('حدث خطأ أثناء حذف الرأي');
    }

    /**
     * تعديل رأي (GET لتحميل البيانات + POST للحفظ)
     */
    public function updateTestimonial($id)
    {
        $tenant = Auth::tenant();
        $testimonial = $this->testimonialModel->find($id);

        if (!$testimonial || $testimonial->tenant_id != $tenant->id) {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->jsonError('الرأي غير موجود', [], 404);
            }
            Session::error('الرأي غير موجود');
            $this->redirect('/dashboard/testimonials');
            return;
        }

        // طلب GET: تحميل بيانات الرأي للتعديل (AJAX)
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->jsonSuccess(['testimonial' => $testimonial]);
            return;
        }

        // طلب POST: حفظ التعديلات
        $this->verifyCsrf();

        $data = [
            'client_name'   => $this->input('client_name'),
            'client_title'  => $this->input('client_title'),
            'content'       => function_exists('sanitizeHTML') ? sanitizeHTML($this->rawInput('content')) : $this->input('content'),
            'rating'        => $this->input('rating') ?: 5,
            'show_on_home'  => $this->input('show_on_home') ? 1 : 0,
            'content_en'      => function_exists('sanitizeHTML') ? sanitizeHTML($this->rawInput('content_en')) : $this->input('content_en'),
            'client_title_en' => $this->input('client_title_en') ?: null,
        ];

        // رفع صورة جديدة
        if (isset($_FILES['client_image']) && $_FILES['client_image']['error'] === UPLOAD_ERR_OK) {
            $result = $this->uploadFile($_FILES['client_image'], $tenant->id . '/testimonials', ALLOWED_IMAGE_TYPES);
            if (isset($result['error'])) {
                Session::error($result['error']);
                $this->redirect('/dashboard/testimonials');
            }
            // حذف الصورة القديمة
            if (!empty($testimonial->client_image)) {
                $oldImagePath = UPLOAD_PATH . '/' . $testimonial->client_image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $data['client_image'] = $result['path'];
        }

        if ($this->testimonialModel->update($id, $data)) {
            Session::success('تم تحديث الرأي بنجاح');
        } else {
            Session::error('حدث خطأ أثناء تحديث الرأي');
        }

        $this->redirect('/dashboard/testimonials');
    }

    // ==================== الرسائل ====================

    /**
     * عرض الرسائل
     */
    public function messages()
    {
        $tenant = Auth::tenant();

        $db = Database::getInstance();
        $messages = $db->query(
            "SELECT * FROM contact_messages WHERE tenant_id = ? ORDER BY created_at DESC",
            [$tenant->id]
        )->results();

        $this->view('dashboard/messages', [
            'title' => 'الرسائل',
            'tenant' => $tenant,
            'messages' => $messages
        ]);
    }

    /**
     * تحديد رسالة كمقروءة
     */
    public function markMessageRead($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        $db = Database::getInstance();
        $db->query(
            "UPDATE contact_messages SET is_read = 1 WHERE id = ? AND tenant_id = ?",
            [$id, $tenant->id]
        );

        $this->jsonSuccess([], 'تم تحديد الرسالة كمقروءة');
    }

    // ==================== الاشتراك ====================

    /**
     * عرض صفحة الاشتراك
     */
    public function subscription()
    {
        $tenant = Auth::tenant();

        // الحصول على إحصائيات الاستخدام
        $stats = (object) [
            'services_count' => $this->serviceModel->countByTenant($tenant->id),
            'gallery_count' => $this->galleryModel->countByTenant($tenant->id),
            'banners_count' => $this->bannerModel->countByTenant($tenant->id),
            'pages_count' => $this->pageModel->countByTenant($tenant->id)
        ];

        $this->view('dashboard/subscription', [
            'title' => lang('subscription'),
            'tenant' => $tenant,
            'stats' => $stats
        ]);
    }

    /**
     * استيراد البيانات التجريبية
     * يستخدم theme_contents و theme_media بدلاً من البيانات الثابتة
     */
    public function importDemo()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        
        // الحصول على الثيم الحالي
        $themeModel = $this->model('Theme');
        $theme = $themeModel->find($tenant->theme_id);
        
        if (!$theme) {
            Session::error('القالب غير موجود');
            $this->redirect('/dashboard/settings');
        }

        // ✅ استخدام theme_contents و theme_media الجديدة
        require_once ROOT_PATH . '/app/models/ThemeContent.php';
        require_once ROOT_PATH . '/app/models/ThemeMedia.php';
        
        $contentModel = new ThemeContent();
        $mediaModel = new ThemeMedia();

        $success = true;

        // 1. نسخ النصوص (خدمات، آراء عملاء، بانر، تواصل)
        if (!$contentModel->copyContentToTenant($theme->id, $tenant->id)) {
            $success = false;
        }

        // 2. نسخ الوسائط (شعار، بانر، صور خدمات، معرض)
        if (!$mediaModel->copyMediaToTenant($theme->id, $tenant->id)) {
            // لا نمنع النجاح إذا فشل نسخ الوسائط فقط
        }

        if ($success) {
            Session::success('تم استيراد البيانات التجريبية بنجاح - تم نسخ المحتوى والصور');
        } else {
            Session::error('حدث خطأ أثناء استيراد البيانات');
        }

        $this->redirect('/dashboard/settings');
    }

    // ==================== الأسئلة الشائعة ====================

    /**
     * عرض صفحة الأسئلة الشائعة
     */
    public function faq()
    {
        $tenant = Auth::tenant();
        $faqs = $this->faqModel->getTenantFaqs($tenant->id);
        $categories = $this->faqModel->getCategories($tenant->id);

        $this->view('dashboard/faq', [
            'title' => 'الأسئلة الشائعة',
            'tenant' => $tenant,
            'faqs' => $faqs,
            'categories' => $categories
        ]);
    }

    /**
     * إضافة سؤال جديد
     */
    public function storeFaq()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        $data = [
            'tenant_id' => $tenant->id,
            'question' => $this->input('question'),
            'answer' => $this->input('answer'),
            'category' => $this->input('category') ?: 'general',
            'is_active' => $this->input('is_active') ? 1 : 0,
            'question_en' => $this->input('question_en') ?: null,
            'answer_en' => $this->input('answer_en') ?: null
        ];

        if (empty($data['question']) || empty($data['answer'])) {
            Session::error('يرجى ملء حقل السؤال والإجابة');
            $this->redirect('/dashboard/faq');
        }

        if ($this->faqModel->createFaq($data)) {
            Session::success('تم إضافة السؤال بنجاح');
        } else {
            Session::error('حدث خطأ أثناء إضافة السؤال');
        }

        $this->redirect('/dashboard/faq');
    }

    /**
     * تحديث سؤال
     */
    public function updateFaq($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $faq = $this->faqModel->find($id);

        if (!$faq || $faq->tenant_id != $tenant->id) {
            $this->jsonError('السؤال غير موجود', [], 404);
        }

        $data = [
            'question' => $this->input('question'),
            'answer' => $this->input('answer'),
            'category' => $this->input('category') ?: 'general',
            'question_en' => $this->input('question_en') ?: null,
            'answer_en' => $this->input('answer_en') ?: null
        ];

        if ($this->faqModel->updateFaq($id, $data)) {
            $this->jsonSuccess([], 'تم تحديث السؤال بنجاح');
        }

        $this->jsonError('حدث خطأ أثناء تحديث السؤال');
    }

    /**
     * حذف سؤال
     */
    public function deleteFaq($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $faq = $this->faqModel->find($id);

        if (!$faq || $faq->tenant_id != $tenant->id) {
            $this->jsonError('السؤال غير موجود', [], 404);
        }

        if ($this->faqModel->deleteFaq($id)) {
            $this->jsonSuccess([], 'تم حذف السؤال بنجاح');
        }

        $this->jsonError('حدث خطأ أثناء حذف السؤال');
    }

    /**
     * تبديل حالة تفعيل السؤال
     */
    public function toggleFaq($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $faq = $this->faqModel->find($id);

        if (!$faq || $faq->tenant_id != $tenant->id) {
            $this->jsonError('السؤال غير موجود', [], 404);
        }

        if ($this->faqModel->toggleActive($id)) {
            $this->jsonSuccess([], 'تم تغيير حالة السؤال بنجاح');
        }

        $this->jsonError('حدث خطأ');
    }

    // ==================== الإحصائيات (العداد) ====================

    /**
     * عرض صفحة الإحصائيات
     */
    public function stats()
    {
        $tenant = Auth::tenant();
        $stats = $this->siteStatModel->getTenantStats($tenant->id);

        $this->view('dashboard/stats', [
            'title' => 'إحصائيات الموقع',
            'tenant' => $tenant,
            'stats' => $stats
        ]);
    }

    /**
     * إضافة إحصائية جديدة
     */
    public function storeStat()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        $data = [
            'tenant_id' => $tenant->id,
            'label' => $this->input('label'),
            'value' => $this->input('value'),
            'suffix' => $this->input('suffix') ?: '+',
            'icon' => $this->input('icon') ?: 'fas fa-star',
            'is_active' => $this->input('is_active') ? 1 : 0,
            'label_en' => $this->input('label_en') ?: null
        ];

        if (empty($data['label']) || empty($data['value'])) {
            Session::error('يرجى ملء حقل الوصف والقيمة');
            $this->redirect('/dashboard/stats');
        }

        if ($this->siteStatModel->createStat($data)) {
            Session::success('تم إضافة الإحصائية بنجاح');
        } else {
            Session::error('حدث خطأ أثناء إضافة الإحصائية');
        }

        $this->redirect('/dashboard/stats');
    }

    /**
     * تحديث إحصائية
     */
    public function updateStat($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $stat = $this->siteStatModel->find($id);

        if (!$stat || $stat->tenant_id != $tenant->id) {
            $this->jsonError('الإحصائية غير موجودة', [], 404);
        }

        $data = [
            'label' => $this->input('label'),
            'value' => $this->input('value'),
            'suffix' => $this->input('suffix') ?: '+',
            'icon' => $this->input('icon') ?: 'fas fa-star',
            'label_en' => $this->input('label_en') ?: null
        ];

        if ($this->siteStatModel->updateStat($id, $data)) {
            $this->jsonSuccess([], 'تم تحديث الإحصائية بنجاح');
        }

        $this->jsonError('حدث خطأ أثناء تحديث الإحصائية');
    }

    /**
     * حذف إحصائية
     */
    public function deleteStat($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $stat = $this->siteStatModel->find($id);

        if (!$stat || $stat->tenant_id != $tenant->id) {
            $this->jsonError('الإحصائية غير موجودة', [], 404);
        }

        if ($this->siteStatModel->deleteStat($id)) {
            $this->jsonSuccess([], 'تم حذف الإحصائية بنجاح');
        }

        $this->jsonError('حدث خطأ أثناء حذف الإحصائية');
    }

    /**
     * تبديل حالة تفعيل الإحصائية
     */
    public function toggleStat($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $stat = $this->siteStatModel->find($id);

        if (!$stat || $stat->tenant_id != $tenant->id) {
            $this->jsonError('الإحصائية غير موجودة', [], 404);
        }

        if ($this->siteStatModel->toggleActive($id)) {
            $this->jsonSuccess([], 'تم تغيير حالة الإحصائية بنجاح');
        }

        $this->jsonError('حدث خطأ');
    }

    /**
     * تحديث إعدادات الأقسام
     */
    public function updateSections()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        
        $sections = $this->input('sections', []);
        
        if ($this->tenantModel->updateSectionsConfig($tenant->id, $sections)) {
            Session::success('تم تحديث إعدادات الأقسام بنجاح');
        } else {
            Session::error('حدث خطأ أثناء تحديث الإعدادات');
        }

        $this->redirect('/dashboard/settings');
    }

    // ============================================================
    // إدارة مميزات "لماذا نحن" (Site Features)
    // ============================================================

    /**
     * عرض صفحة مميزات الموقع
     */
    public function features()
    {
        $tenant = Auth::tenant();
        try {
            $features = $this->siteFeatureModel->getTenantFeatures($tenant->id, false);
        } catch (\Exception $e) {
            $features = [];
        }

        $this->view('dashboard/features', [
            'tenant' => $tenant,
            'features' => $features
        ]);
    }

    /**
     * إضافة ميزة جديدة
     */
    public function storeFeature()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        $data = [
            'tenant_id' => $tenant->id,
            'icon' => $this->input('icon', 'fas fa-star'),
            'title' => $this->input('title'),
            'title_en' => $this->input('title_en'),
            'description' => $this->input('description'),
            'description_en' => $this->input('description_en'),
            'is_active' => 1
        ];

        if (empty($data['title']) || empty($data['description'])) {
            $this->jsonError('العنوان والوصف مطلوبان');
        }

        if ($this->siteFeatureModel->addFeature($data)) {
            $this->jsonSuccess([], 'تم إضافة الميزة بنجاح');
        }

        $this->jsonError('حدث خطأ أثناء الإضافة');
    }

    /**
     * تعديل ميزة (AJAX)
     */
    public function updateFeature($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $feature = $this->siteFeatureModel->findById($id);

        if (!$feature || (isset($feature->tenant_id) && $feature->tenant_id != $tenant->id)) {
            $this->jsonError('الميزة غير موجودة', [], 404);
        }

        // إذا كان طلب GET (تحميل بيانات للتعديل)
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->jsonSuccess(['feature' => $feature]);
            return;
        }

        // إذا كان طلب POST (حفظ التعديلات)
        $data = [];
        if ($this->hasInput('icon')) $data['icon'] = $this->input('icon');
        if ($this->hasInput('title')) $data['title'] = $this->input('title');
        if ($this->hasInput('title_en')) $data['title_en'] = $this->input('title_en');
        if ($this->hasInput('description')) $data['description'] = $this->input('description');
        if ($this->hasInput('description_en')) $data['description_en'] = $this->input('description_en');

        if ($this->siteFeatureModel->updateFeature($id, $data)) {
            $this->jsonSuccess([], 'تم تحديث الميزة بنجاح');
        }

        $this->jsonError('حدث خطأ أثناء التحديث');
    }

    /**
     * حذف ميزة (AJAX)
     */
    public function deleteFeature($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $feature = $this->siteFeatureModel->findById($id);

        if (!$feature || (isset($feature->tenant_id) && $feature->tenant_id != $tenant->id)) {
            $this->jsonError('الميزة غير موجودة', [], 404);
        }

        if ($this->siteFeatureModel->deleteFeature($id)) {
            $this->jsonSuccess([], 'تم حذف الميزة بنجاح');
        }

        $this->jsonError('حدث خطأ أثناء الحذف');
    }

    /**
     * تفعيل/تعطيل ميزة (AJAX)
     */
    public function toggleFeature($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $feature = $this->siteFeatureModel->findById($id);

        if (!$feature || (isset($feature->tenant_id) && $feature->tenant_id != $tenant->id)) {
            $this->jsonError('الميزة غير موجودة', [], 404);
        }

        if ($this->siteFeatureModel->toggleActive($id)) {
            $this->jsonSuccess([], 'تم تغيير حالة الميزة بنجاح');
        }

        $this->jsonError('حدث خطأ');
    }

    // ============================================================
    // إدارة قسم CTA
    // ============================================================

    /**
     * حفظ إعدادات CTA
     */
    public function updateCta()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        $data = [
            'cta_title' => $this->input('cta_title'),
            'cta_title_en' => $this->input('cta_title_en'),
            'cta_text' => $this->input('cta_text'),
            'cta_text_en' => $this->input('cta_text_en'),
            'cta_button_text' => $this->input('cta_button_text'),
            'cta_button_text_en' => $this->input('cta_button_text_en'),
            'cta_button_link' => $this->input('cta_button_link'),
            'cta_is_active' => $this->input('cta_is_active') ? 1 : 0,
        ];

        if ($this->tenantModel->update($tenant->id, $data)) {
            Session::success('تم تحديث إعدادات CTA بنجاح');
        } else {
            Session::error('حدث خطأ أثناء التحديث');
        }

        $this->redirect('/dashboard/settings');
    }

    // ============================================================
    // إدارة الشركاء (Partners)
    // ============================================================

    /**
     * عرض صفحة إدارة الشركاء
     */
    public function partners()
    {
        $tenant = Auth::tenant();
        $partners = $this->partnerModel->getTenantPartners($tenant->id, false);

        $this->view('dashboard/partners', [
            'tenant' => $tenant,
            'partners' => $partners
        ]);
    }

    /**
     * إضافة شريك جديد
     */
    public function storePartner()
    {
        $this->verifyCsrf();
        $tenant = Auth::tenant();

        $data = [
            'tenant_id' => $tenant->id,
            'name' => $this->input('name'),
            'name_en' => $this->input('name_en'),
            'link' => $this->input('link', '#'),
            'is_active' => 1
        ];

        if (empty($data['name'])) {
            $this->jsonError('اسم الشريك مطلوب');
        }

        // رفع شعار الشريك
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $result = $this->uploadFile($_FILES['logo'], $tenant->id . '/partners', ALLOWED_IMAGE_TYPES);
            if (!isset($result['error'])) {
                $data['logo'] = $result['path'];
            }
        }

        if ($this->partnerModel->createPartner($data)) {
            $this->jsonSuccess([], 'تم إضافة الشريك بنجاح');
        }
        $this->jsonError('حدث خطأ أثناء الإضافة');
    }

    /**
     * تعديل شريك (AJAX)
     */
    public function updatePartner($id)
    {
        $this->verifyCsrf();
        $tenant = Auth::tenant();
        $partner = $this->partnerModel->findById($id);

        if (!$partner || $partner->tenant_id != $tenant->id) {
            $this->jsonError('الشريك غير موجود', [], 404);
        }

        $data = [];
        if ($this->hasInput('name')) $data['name'] = $this->input('name');
        if ($this->hasInput('name_en')) $data['name_en'] = $this->input('name_en');
        if ($this->hasInput('link')) $data['link'] = $this->input('link');

        // رفع شعار جديد
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $result = $this->uploadFile($_FILES['logo'], $tenant->id . '/partners', ALLOWED_IMAGE_TYPES);
            if (!isset($result['error'])) {
                if ($partner->logo) {
                    $this->deleteFile($partner->logo);
                }
                $data['logo'] = $result['path'];
            }
        }

        if ($this->partnerModel->updatePartner($id, $data)) {
            $this->jsonSuccess([], 'تم تحديث الشريك بنجاح');
        }
        $this->jsonError('حدث خطأ أثناء التحديث');
    }

    /**
     * حذف شريك (AJAX)
     */
    public function deletePartner($id)
    {
        $this->verifyCsrf();
        $tenant = Auth::tenant();
        $partner = $this->partnerModel->findById($id);

        if (!$partner || $partner->tenant_id != $tenant->id) {
            $this->jsonError('الشريك غير موجود', [], 404);
        }

        if ($this->partnerModel->deletePartner($id)) {
            $this->jsonSuccess([], 'تم حذف الشريك بنجاح');
        }
        $this->jsonError('حدث خطأ أثناء الحذف');
    }

    /**
     * تفعيل/تعطيل شريك (AJAX)
     */
    public function togglePartner($id)
    {
        $this->verifyCsrf();
        $tenant = Auth::tenant();
        $partner = $this->partnerModel->findById($id);

        if (!$partner || $partner->tenant_id != $tenant->id) {
            $this->jsonError('الشريك غير موجود', [], 404);
        }

        if ($this->partnerModel->toggleActive($id)) {
            $this->jsonSuccess([], 'تم تغيير حالة الشريك بنجاح');
        }
        $this->jsonError('حدث خطأ');
    }

    /**
     * [FIX-29] التحقق من صيغة لون Hex
     */
    private function sanitizeHexColor($color)
    {
        if (empty($color)) {
            return null;
        }
        // السماح بصيغ #RRGGBB أو #RGB
        $color = trim($color);
        if (preg_match('/^#([a-fA-F0-9]{3}){1,2}$/', $color)) {
            return $color;
        }
        if (preg_match('/^([a-fA-F0-9]{3}){1,2}$/', $color)) {
            return '#' . $color;
        }
        return null;
    }
}
