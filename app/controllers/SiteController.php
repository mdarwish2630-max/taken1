<?php
/**
 * CMS Platform - Site Controller
 * متحكم المواقع (الواجهة الأمامية للمواقع المنشأة)
 */

class SiteController extends Controller
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

    public function __construct()
    {
        parent::__construct();
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
    }

    /**
     * عرض الموقع الرئيسي (صفحة الهبوط)
     */
    public function index()
    {
        $this->view('home', [
            'title' => SITE_NAME . ' - أنشئ موقعك الإلكتروني بسهولة'
        ]);
    }

    /**
     * تحديد لغة الموقع وتهيئتها
     */
    private function setSiteLanguage($tenant, $slug)
    {
        // 1. من معامل URL ?lang=en
        if (isset($_GET['lang']) && in_array($_GET['lang'], ['ar', 'en'], true)) {
            $lang = $_GET['lang'];
            Language::setLocale($lang);
            // [FIX-24] إضافة HttpOnly و SameSite لكوكي اللغة
            setcookie('site_lang_' . $slug, $lang, [
                'expires' => time() + (86400 * 90),
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
            return;
        }

        // 2. من كوكي الموقع
        if (isset($_COOKIE['site_lang_' . $slug]) && in_array($_COOKIE['site_lang_' . $slug], ['ar', 'en'])) {
            Language::setLocale($_COOKIE['site_lang_' . $slug]);
            return;
        }

        // 3. من إعدادات الموقع الافتراضية
        if (!empty($tenant->default_language) && in_array($tenant->default_language, ['ar', 'en'])) {
            Language::setLocale($tenant->default_language);
        }
    }

    /**
     * عرض موقع عميل (مع دعم المعاينة preview_theme)
     */
    public function show($slug, $pageSlug = null)
    {
        // البحث عن الموقع
        $tenant = $this->tenantModel->findBySlug($slug);

        if (!$tenant) {
            $this->redirect('/');
        }

        // تحديد لغة الموقع
        $this->setSiteLanguage($tenant, $slug);

        // التحقق من حالة الموقع
        if ($tenant->site_status === 'maintenance' && !Auth::isAdmin()) {
            $this->view('site/maintenance', [
                'tenant' => $tenant
            ]);
            return;
        }

        // تحديد الصفحة المطلوبة
        $page = null;
        if ($pageSlug) {
            $page = $this->pageModel->findBySlug($pageSlug, $tenant->id);
        } else {
            $page = $this->pageModel->getHomePage($tenant->id);
        }

        if (!$page) {
            // صفحة 404 للموقع
            $this->view('site/404', [
                'tenant' => $tenant
            ]);
            return;
        }

        // قالب واحد فقط - نوفا
        $themeSlug = 'nova';

        $data = [
            'tenant' => $tenant,
            'page' => $page,
            'menu' => $this->pageModel->getMenuPages($tenant->id),
            'banners' => $this->bannerModel->getHeroBanners($tenant->id),
            'services' => $this->serviceModel->getHomeServices($tenant->id, 6),
            'gallery' => $this->galleryModel->getActiveGallery($tenant->id, 8),
            'testimonials' => $this->testimonialModel->getHomeTestimonials($tenant->id, 6),
            'sectionsConfig' => $this->tenantModel->getSectionsConfig($tenant->id),
            'faqItems' => $this->faqModel->getTenantFaqs($tenant->id, true),
            'faqCategories' => $this->faqModel->getTenantFaqsGroupedByCategory($tenant->id, true),
            'siteStats' => $this->siteStatModel->getTenantStats($tenant->id, true),
            'siteFeatures' => $this->siteFeatureModel->getSiteFeatures($tenant->id),
            'partnerItems' => $this->partnerModel->getTenantPartners($tenant->id, true),
            'title' => $page->meta_title ?: $page->title . ' - ' . $tenant->site_name,
            'meta_description' => $page->meta_description ?: $tenant->meta_description,
        ];

        // تحميل الثيم
        $this->renderTheme($themeSlug, $page->template ?: 'default', $data);
    }

    /**
     * ✅ صفحة معاينة ديمو للثيم (بدون مستأجر)
     * تعرض الثيم بمحتواه التجريبي الكامل من theme_contents و theme_media
     */
    public function previewDemo($themeSlug)
    {
        $themeModel = $this->model('Theme');
        $theme = $themeModel->findBySlug($themeSlug);

        if (!$theme) {
            $this->redirect('/');
            return;
        }

        // تحميل محتوى الثيم التجريبي
        require_once ROOT_PATH . '/app/models/ThemeContent.php';
        require_once ROOT_PATH . '/app/models/ThemeMedia.php';
        $contentModel = new ThemeContent();
        $mediaModel = new ThemeMedia();

        $content = $contentModel->getContentForEditor($theme->id);
        $media = $mediaModel->getThemeMediaGrouped($theme->id);

        // بناء كائن tenant وهمي من محتوى الثيم
        $lang = Language::current();

        $tenantDemo = (object)[
            'id' => 0,
            'slug' => 'demo',
            'site_name' => $theme->name,
            'site_name_en' => $theme->name_en ?? $theme->name,
            'logo' => ($media['logo'][0]->file_path ?? null),
            'theme_slug' => $themeSlug,
            'meta_description' => $theme->description ?? '',
            'meta_keywords' => '',
            'default_language' => 'ar',
            'contact_phone' => '',
            'contact_email' => '',
            'contact_whatsapp' => '',
            'address' => '',
            'working_hours' => '',
            'facebook' => '',
            'instagram' => '',
            'twitter' => '',
            'youtube' => '',
        ];

        // استخراج بيانات التواصل من المحتوى
        if (!empty($content['contact'])) {
            foreach ($content['contact'] as $ck => $cv) {
                $contact = $cv['decoded'] ?? json_decode($cv['content_ar'], true) ?? [];
                if ($contact) {
                    $tenantDemo->contact_phone = $contact['phone'] ?? '';
                    $tenantDemo->contact_email = $contact['email'] ?? '';
                    $tenantDemo->contact_whatsapp = $contact['whatsapp'] ?? '';
                    $tenantDemo->address = $contact['address'] ?? '';
                    break;
                }
            }
        }

        // بناء بنر من hero content + banner media
        $heroTitle = $content['hero']['hero_title']['content_ar'] ?? ($theme->name);
        $heroSub = $content['hero']['hero_subtitle']['content_ar'] ?? '';
        $heroDesc = $content['hero']['hero_description']['content_ar'] ?? '';
        $heroBtn = $content['hero']['hero_button_text']['content_ar'] ?? 'تواصل معنا';
        $bannerPath = $media['banner'][0]->file_path ?? null;

        $bannersDemo = [];
        if ($bannerPath || $heroTitle) {
            $bannersDemo[] = (object)[
                'id' => 0,
                'title' => $heroTitle,
                'title_en' => $content['hero']['hero_title']['content_en'] ?? '',
                'subtitle' => $heroSub,
                'subtitle_en' => $content['hero']['hero_subtitle']['content_en'] ?? '',
                'description' => $heroDesc,
                'button_text' => $heroBtn,
                'button_text_en' => $content['hero']['hero_button_text']['content_en'] ?? '',
                'image' => $bannerPath,
                'link' => '#contact',
                'position' => 'hero',
                'status' => 'active',
            ];
        }

        // بناء خدمات من services content + service_image media
        $servicesDemo = [];
        if (!empty($content['services'])) {
            $idx = 0;
            foreach ($content['services'] as $sKey => $sVal) {
                $svcData = $sVal['decoded'] ?? json_decode($sVal['content_ar'], true) ?? [];
                if (empty($svcData)) continue;

                // البحث عن صورة الخدمة
                $svcImage = null;
                foreach ($media as $mType => $mItems) {
                    foreach ($mItems as $mItem) {
                        if ($mItem->section_ref === $sKey && $mItem->media_type === 'service_image') {
                            $svcImage = $mItem->file_path;
                            break 2;
                        }
                    }
                }

                $svcEn = $sVal['decoded'] ?? json_decode($sVal['content_en'] ?? '{}', true) ?? [];

                $servicesDemo[] = (object)[
                    'id' => 0,
                    'title' => $svcData['title_ar'] ?? '',
                    'title_en' => $svcData['title_en'] ?? $svcEn['title_en'] ?? '',
                    'description' => $svcData['description_ar'] ?? '',
                    'description_en' => $svcData['description_en'] ?? $svcEn['description_en'] ?? '',
                    'icon' => $svcData['icon'] ?? 'fas fa-star',
                    'image' => $svcImage,
                    'price' => null,
                    'price_text' => null,
                    'slug' => 'service-' . ($idx + 1),
                    'show_on_home' => $svcData['show_on_home'] ?? 1,
                    'status' => 'active',
                ];
                $idx++;
            }
        }

        // بناء آراء العملاء
        $testimonialsDemo = [];
        if (!empty($content['testimonials'])) {
            foreach ($content['testimonials'] as $tKey => $tVal) {
                $tstData = $tVal['decoded'] ?? json_decode($tVal['content_ar'], true) ?? [];
                if (empty($tstData)) continue;

                $testimonialsDemo[] = (object)[
                    'id' => 0,
                    'client_name' => $tstData['client_name'] ?? '',
                    'client_title' => $tstData['client_title'] ?? '',
                    'client_title_en' => $tstData['client_title_en'] ?? '',
                    'content' => $tstData['content'] ?? '',
                    'content_en' => $tstData['content_en'] ?? '',
                    'rating' => $tstData['rating'] ?? 5,
                    'client_image' => null,
                    'show_on_home' => 1,
                    'status' => 'active',
                ];
            }
        }

        // بناء معرض الصور
        $galleryDemo = [];
        if (!empty($media['gallery'])) {
            foreach ($media['gallery'] as $img) {
                $galleryDemo[] = (object)[
                    'id' => 0,
                    'image' => $img->file_path,
                    'title' => $img->alt_text_ar ?? '',
                    'title_en' => $img->alt_text_en ?? '',
                ];
            }
        }

        // بناء قائمة صفحات وهمية
        $menuDemo = [
            (object)['id' => 0, 'slug' => '', 'title' => 'الرئيسية', 'title_en' => 'Home', 'is_home' => 1],
            (object)['id' => 0, 'slug' => 'about', 'title' => 'من نحن', 'title_en' => 'About Us', 'is_home' => 0],
            (object)['id' => 0, 'slug' => 'services', 'title' => 'خدماتنا', 'title_en' => 'Our Services', 'is_home' => 0],
            (object)['id' => 0, 'slug' => 'gallery', 'title' => 'المعرض', 'title_en' => 'Gallery', 'is_home' => 0],
            (object)['id' => 0, 'slug' => 'contact', 'title' => 'اتصل بنا', 'title_en' => 'Contact Us', 'is_home' => 0],
        ];

        // صفحة وهمية
        $pageDemo = (object)[
            'id' => 0,
            'slug' => '',
            'title' => $theme->name,
            'title_en' => $theme->name_en ?? '',
            'content' => '',
            'content_en' => '',
            'template' => 'default',
            'meta_title' => $theme->name . ' - معاينة القالب',
            'meta_description' => $theme->description ?? '',
            'is_home' => 1,
        ];

        $data = [
            'tenant' => $tenantDemo,
            'page' => $pageDemo,
            'menu' => $menuDemo,
            'banners' => $bannersDemo,
            'services' => $servicesDemo,
            'gallery' => $galleryDemo,
            'testimonials' => $testimonialsDemo,
            'sectionsConfig' => [
                'hero' => true,
                'services' => true,
                'gallery' => !empty($galleryDemo),
                'testimonials' => !empty($testimonialsDemo),
                'contact' => true,
            ],
            'title' => $theme->name . ' - معاينة القالب',
            'meta_description' => $theme->description ?? '',
            'is_preview' => true,
        ];

        // تحميل الثيم
        $this->renderTheme($themeSlug, 'default', $data);
    }

    /**
     * عرض صفحة خدمة
     */
    public function service($slug, $serviceSlug)
    {
        $tenant = $this->tenantModel->findBySlug($slug);

        if (!$tenant) {
            $this->redirect('/');
        }

        // تحديد لغة الموقع
        $this->setSiteLanguage($tenant, $slug);

        $service = $this->serviceModel->findBySlug($serviceSlug, $tenant->id);

        if (!$service) {
            $this->view('site/404', ['tenant' => $tenant]);
            return;
        }

        $data = [
            'tenant' => $tenant,
            'service' => $service,
            'menu' => $this->pageModel->getMenuPages($tenant->id),
            'title' => $service->title . ' - ' . $tenant->site_name,
            'related_services' => $this->serviceModel->getTenantServices($tenant->id)
        ];

        $this->renderTheme($tenant->theme_slug, 'service', $data);
    }

    /**
     * عرض صفحة الخدمات
     */
    public function services($slug)
    {
        $tenant = $this->tenantModel->findBySlug($slug);

        if (!$tenant) {
            $this->redirect('/');
        }

        // تحديد لغة الموقع
        $this->setSiteLanguage($tenant, $slug);

        $data = [
            'tenant' => $tenant,
            'services' => $this->serviceModel->getTenantServices($tenant->id),
            'menu' => $this->pageModel->getMenuPages($tenant->id),
            'banners' => $this->bannerModel->getHeroBanners($tenant->id),
            'title' => lang('our_services') . ' - ' . $tenant->site_name
        ];

        $this->renderTheme($tenant->theme_slug, 'services', $data);
    }

    /**
     * عرض صفحة المعرض
     */
    public function gallery($slug)
    {
        $tenant = $this->tenantModel->findBySlug($slug);

        if (!$tenant) {
            $this->redirect('/');
        }

        // تحديد لغة الموقع
        $this->setSiteLanguage($tenant, $slug);

        $data = [
            'tenant' => $tenant,
            'gallery' => $this->galleryModel->getActiveGallery($tenant->id),
            'menu' => $this->pageModel->getMenuPages($tenant->id),
            'banners' => $this->bannerModel->getHeroBanners($tenant->id),
            'title' => lang('our_gallery') . ' - ' . $tenant->site_name
        ];

        $this->renderTheme($tenant->theme_slug, 'gallery', $data);
    }

    /**
     * عرض صفحة اتصل بنا
     */
    public function contactPage($slug)
    {
        $tenant = $this->tenantModel->findBySlug($slug);

        if (!$tenant) {
            $this->redirect('/');
        }

        // تحديد لغة الموقع
        $this->setSiteLanguage($tenant, $slug);

        $data = [
            'tenant' => $tenant,
            'menu' => $this->pageModel->getMenuPages($tenant->id),
            'banners' => $this->bannerModel->getHeroBanners($tenant->id),
            'title' => lang('contact_us') . ' - ' . $tenant->site_name
        ];

        $this->renderTheme($tenant->theme_slug, 'contact', $data);
    }

    /**
     * عرض صفحة من نحن
     */
    public function about($slug)
    {
        $tenant = $this->tenantModel->findBySlug($slug);

        if (!$tenant) {
            $this->redirect('/');
        }

        // تحديد لغة الموقع
        $this->setSiteLanguage($tenant, $slug);

        $data = [
            'tenant' => $tenant,
            'services' => $this->serviceModel->getHomeServices($tenant->id, 6),
            'testimonials' => $this->testimonialModel->getHomeTestimonials($tenant->id, 6),
            'gallery' => $this->galleryModel->getActiveGallery($tenant->id, 6),
            'menu' => $this->pageModel->getMenuPages($tenant->id),
            'banners' => $this->bannerModel->getHeroBanners($tenant->id),
            'title' => lang('about_us') . ' - ' . $tenant->site_name
        ];

        $this->renderTheme($tenant->theme_slug, 'about', $data);
    }

    /**
     * إرسال رسالة تواصل
     */
    public function contact($slug)
    {
        $this->verifyCsrf();

        $tenant = $this->tenantModel->findBySlug($slug);

        if (!$tenant) {
            $this->jsonError('الموقع غير موجود', [], 404);
        }

        $data = [
            'tenant_id' => $tenant->id,
            'name' => $this->input('name'),
            'email' => $this->input('email'),
            'phone' => $this->input('phone'),
            'subject' => $this->input('subject'),
            'message' => $this->input('message')
        ];

        // التحقق من البيانات
        $errors = $this->validate($data, [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'message' => ['required']
        ]);

        if (!empty($errors)) {
            $this->jsonError('يرجى ملء جميع الحقول المطلوبة', $errors);
        }

        // حفظ الرسالة
        $db = Database::getInstance();
        $saved = $db->query(
            "INSERT INTO contact_messages (tenant_id, name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?, ?)",
            [$data['tenant_id'], $data['name'], $data['email'], $data['phone'], $data['subject'], $data['message']]
        );

        if (!$db->error()) {
            // إرسال إشعار للعميل
            // sendMail($tenant->contact_email, 'رسالة جديدة', $data['message']);
            
            $this->jsonSuccess([], 'تم إرسال رسالتك بنجاح');
        }

        $this->jsonError('حدث خطأ أثناء إرسال الرسالة');
    }

    public function faq($slug)
    {
        $tenant = $this->tenantModel->findBySlug($slug);
        if (!$tenant) { $this->redirect('/'); }
        $this->setSiteLanguage($tenant, $slug);
        if ($tenant->site_status === 'maintenance' && !Auth::isAdmin()) {
            $this->view('site/maintenance', ['tenant' => $tenant]);
            return;
        }
        // قالب واحد فقط - نوفا
        $themeSlug = 'nova';
        $page = $this->pageModel->findBySlug('faq', $tenant->id);
        if (!$page) {
            $page = (object) [
                'title' => 'الأسئلة الشائعة',
                'title_en' => 'FAQ',
                'slug' => 'faq',
                'meta_title' => 'الأسئلة الشائعة',
                'meta_description' => '',
                'is_home' => false,
                'template' => 'faq'
            ];
        } else {
            $page->template = 'faq';
        }
        $data = [
            'tenant' => $tenant, 'page' => $page,
            'menu' => $this->pageModel->getMenuPages($tenant->id),
            'banners' => $this->bannerModel->getHeroBanners($tenant->id),
            'services' => $this->serviceModel->getHomeServices($tenant->id, 6),
            'gallery' => $this->galleryModel->getActiveGallery($tenant->id, 8),
            'testimonials' => $this->testimonialModel->getHomeTestimonials($tenant->id, 6),
            'sectionsConfig' => $this->tenantModel->getSectionsConfig($tenant->id),
            'faqItems' => $this->faqModel->getTenantFaqs($tenant->id, true),
            'faqCategories' => $this->faqModel->getTenantFaqsGroupedByCategory($tenant->id, true),
            'siteStats' => $this->siteStatModel->getTenantStats($tenant->id, true),
            'title' => lang('faq') . ' - ' . $tenant->site_name,
            'meta_description' => $tenant->meta_description,
        ];
        $this->renderTheme($themeSlug, 'faq', $data);
    }

    public function partners($slug)
    {
        $tenant = $this->tenantModel->findBySlug($slug);
        if (!$tenant) { $this->redirect('/'); }
        $this->setSiteLanguage($tenant, $slug);
        if ($tenant->site_status === 'maintenance' && !Auth::isAdmin()) {
            $this->view('site/maintenance', ['tenant' => $tenant]);
            return;
        }
        // قالب واحد فقط - نوفا
        $themeSlug = 'nova';
        $page = $this->pageModel->findBySlug('partners', $tenant->id);
        if (!$page) {
            $page = (object) [
                'title' => 'شركاؤنا',
                'title_en' => 'Our Partners',
                'slug' => 'partners',
                'meta_title' => 'شركاؤنا',
                'meta_description' => '',
                'is_home' => false,
                'template' => 'partners'
            ];
        } else {
            $page->template = 'partners';
        }
        $data = [
            'tenant' => $tenant, 'page' => $page,
            'menu' => $this->pageModel->getMenuPages($tenant->id),
            'banners' => $this->bannerModel->getHeroBanners($tenant->id),
            'services' => $this->serviceModel->getHomeServices($tenant->id, 6),
            'gallery' => $this->galleryModel->getActiveGallery($tenant->id, 8),
            'testimonials' => $this->testimonialModel->getHomeTestimonials($tenant->id, 6),
            'sectionsConfig' => $this->tenantModel->getSectionsConfig($tenant->id),
            'partnerItems' => $this->partnerModel->getTenantPartners($tenant->id, true),
            'title' => lang('partners') . ' - ' . $tenant->site_name,
            'meta_description' => $tenant->meta_description,
        ];
        $this->renderTheme($themeSlug, 'partners', $data);
    }

    public function booking($slug)
    {
        $tenant = $this->tenantModel->findBySlug($slug);
        if (!$tenant) { $this->redirect('/'); }
        $this->setSiteLanguage($tenant, $slug);
        if ($tenant->site_status === 'maintenance' && !Auth::isAdmin()) {
            $this->view('site/maintenance', ['tenant' => $tenant]);
            return;
        }
        // قالب واحد فقط - نوفا
        $themeSlug = 'nova';
        $page = $this->pageModel->findBySlug('booking', $tenant->id);
        if (!$page) {
            $page = (object) [
                'title' => 'حجز موعد',
                'title_en' => 'Book Appointment',
                'slug' => 'booking',
                'meta_title' => 'حجز موعد',
                'meta_description' => '',
                'is_home' => false,
                'template' => 'booking'
            ];
        } else {
            $page->template = 'booking';
        }
        $data = [
            'tenant' => $tenant, 'page' => $page,
            'menu' => $this->pageModel->getMenuPages($tenant->id),
            'banners' => $this->bannerModel->getHeroBanners($tenant->id),
            'services' => $this->serviceModel->getHomeServices($tenant->id, 20),
            'gallery' => $this->galleryModel->getActiveGallery($tenant->id, 8),
            'testimonials' => $this->testimonialModel->getHomeTestimonials($tenant->id, 6),
            'sectionsConfig' => $this->tenantModel->getSectionsConfig($tenant->id),
            'title' => lang('booking') . ' - ' . $tenant->site_name,
            'meta_description' => $tenant->meta_description,
        ];
        $this->renderTheme($themeSlug, 'booking', $data);
    }

    /**
     * تحميل ثيم الموقع
     */
    private function renderTheme($themeSlug, $template, $data)
    {
        $themePath = THEMES_PATH . '/' . $themeSlug . '/' . $template . '.php';

        if (file_exists($themePath)) {
            extract($data);
            require $themePath;
        } else {
            // استخدام الثيم الافتراضي
            $defaultPath = THEMES_PATH . '/nova/' . $template . '.php';
            if (file_exists($defaultPath)) {
                extract($data);
                require $defaultPath;
            } else {
                echo "Template not found: {$template}";
            }
        }
    }
}
