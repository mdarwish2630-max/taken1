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
    private $menuModel;

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
        $this->menuModel = $this->model('MenuModel');
    }

    /**
     * الحصول على عناصر المنو لموقع معين
     * تستخدم site_menu أولاً، إذا فاضية ترجع من pages
     */
    private function getMenuForSite($tenantId, $siteBase)
    {
        $menuItems = $this->menuModel->getActiveMenuItems($tenantId, $siteBase);
        if (!empty($menuItems)) {
            return $menuItems;
        }
        // Fallback: إذا ما في عناصر منو (جدول فاضي أو قديم)
        $pages = $this->pageModel->getMenuPages($tenantId);
        $result = [];
        foreach ($pages as $p) {
            $result[] = [
                'id'        => $p->id,
                'label'     => $p->title,
                'label_en'  => $p->title_en,
                'url'       => $p->is_home ? $siteBase : $siteBase . '/' . $p->slug,
                'is_home'   => (int)$p->is_home,
                'open_in_new_tab' => 0,
                'icon'      => 'fa-file-alt',
                'item_type' => 'page',
                'section_key' => null,
                'menu_order'=> (int)($p->menu_order ?? 0),
            ];
        }
        return $result;
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

        // استخدام الثيم المحدد من الموقع
        $themeSlug = !empty($tenant->theme_slug) ? $tenant->theme_slug : 'cleanpro';

        // Determine current language for templates
        $currentLang  = function_exists('lang') ? lang() : ($tenant->default_language ?? 'ar');
        $currentDir   = ($currentLang === 'en') ? 'ltr' : 'rtl';

        // Load theme settings for custom CSS/fonts
        require_once ROOT_PATH . '/app/models/ThemeSettings.php';
        $themeSettingsModel = new ThemeSettings();
        $themeSettings = $themeSettingsModel->getTenantSettings($tenant->id);
        $themeCustomCSS = $themeSettingsModel->generateCustomCSS($tenant->id, $tenant);
        $themeFontsUrl = $themeSettingsModel->getGoogleFontsUrl($tenant->id);

        $data = [
            'tenant' => $tenant,
            'page' => $page,
            'menu' => $this->getMenuForSite($tenant->id, BASE_PATH . '/site/' . $tenant->slug),
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
            'lang'  => $currentLang,
            'dir'   => $currentDir,
            'siteBase' => BASE_PATH . '/site/' . $tenant->slug,
            'themeSettings' => $themeSettings,
            'themeCustomCSS' => $themeCustomCSS,
            'themeFontsUrl' => $themeFontsUrl,
        ];

        // تحميل الثيم
        $this->renderTheme($themeSlug, $page->template ?: 'default', $data);
    }

    /**
     * ✅ بناء بيانات المعاينة التجريبية للثيم (مشترك بين كل صفحات المعاينة)
     */
    private function buildPreviewData($theme, $themeSlug, $template)
    {
        // تحميل محتوى الثيم التجريبي
        require_once ROOT_PATH . '/app/models/ThemeContent.php';
        require_once ROOT_PATH . '/app/models/ThemeMedia.php';
        $contentModel = new ThemeContent();
        $mediaModel = new ThemeMedia();

        $content = $contentModel->getContentForEditor($theme->id);
        $media = $mediaModel->getThemeMediaGrouped($theme->id);

        // بناء كائن tenant وهمي
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
                    $tenantDemo->working_hours = $contact['working_hours'] ?? '';
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
                    'price' => $svcData['price'] ?? null,
                    'price_text' => $svcData['price_text'] ?? null,
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
                    'category' => $img->section_ref ?? '',
                    'category_en' => $img->section_ref ?? '',
                ];
            }
        }

        // بناء الأسئلة الشائعة من محتوى الثيم
        $faqItemsDemo = [];
        if (!empty($content['faq'])) {
            foreach ($content['faq'] as $fKey => $fVal) {
                $faqData = $fVal['decoded'] ?? json_decode($fVal['content_ar'], true) ?? [];
                if (empty($faqData)) continue;
                $faqItemsDemo[] = (object)[
                    'id' => 0,
                    'question' => $faqData['question_ar'] ?? '',
                    'question_en' => $faqData['question_en'] ?? '',
                    'answer' => $faqData['answer_ar'] ?? '',
                    'answer_en' => $faqData['answer_en'] ?? '',
                    'category' => $faqData['category'] ?? '',
                    'sort_order' => 0,
                    'status' => 'active',
                ];
            }
        }

        // بناء شركاء من محتوى الثيم
        $partnerItemsDemo = [];
        if (!empty($media['partner'])) {
            foreach ($media['partner'] as $pItem) {
                $partnerItemsDemo[] = (object)[
                    'id' => 0,
                    'name' => $pItem->alt_text_ar ?? '',
                    'name_en' => $pItem->alt_text_en ?? '',
                    'logo' => $pItem->file_path,
                    'website' => '',
                    'status' => 'active',
                ];
            }
        }

        // بناء إحصائيات من محتوى الثيم
        $siteStatsDemo = [];
        if (!empty($content['stats'])) {
            foreach ($content['stats'] as $sKey => $sVal) {
                $statData = $sVal['decoded'] ?? json_decode($sVal['content_ar'], true) ?? [];
                if (empty($statData)) continue;
                $siteStatsDemo[] = (object)[
                    'id' => 0,
                    'label' => $statData['label_ar'] ?? '',
                    'label_en' => $statData['label_en'] ?? '',
                    'value' => $statData['value'] ?? '0',
                    'icon' => $statData['icon'] ?? 'fas fa-chart-line',
                    'status' => 'active',
                ];
            }
        }

        // بناء مميزات "لماذا نحن" من محتوى الثيم
        $siteFeaturesDemo = [];
        if (!empty($content['features'])) {
            foreach ($content['features'] as $fKey => $fVal) {
                $featData = $fVal['decoded'] ?? json_decode($fVal['content_ar'], true) ?? [];
                if (empty($featData)) continue;
                $siteFeaturesDemo[] = (object)[
                    'id' => 0,
                    'title' => $featData['title_ar'] ?? '',
                    'title_en' => $featData['title_en'] ?? '',
                    'description' => $featData['description_ar'] ?? '',
                    'description_en' => $featData['description_en'] ?? '',
                    'icon' => $featData['icon'] ?? 'fas fa-check',
                    'status' => 'active',
                ];
            }
        }

        // بناء قائمة صفحات وهمية (روابط المعاينة)
        $menuDemo = [
            (object)['id' => 0, 'slug' => '', 'title' => 'الرئيسية', 'title_en' => 'Home', 'is_home' => 1],
            (object)['id' => 0, 'slug' => 'about', 'title' => 'من نحن', 'title_en' => 'About Us', 'is_home' => 0],
            (object)['id' => 0, 'slug' => 'services', 'title' => 'خدماتنا', 'title_en' => 'Our Services', 'is_home' => 0],
            (object)['id' => 0, 'slug' => 'gallery', 'title' => 'المعرض', 'title_en' => 'Gallery', 'is_home' => 0],
            (object)['id' => 0, 'slug' => 'contact', 'title' => 'اتصل بنا', 'title_en' => 'Contact Us', 'is_home' => 0],
        ];
        if (!empty($faqItemsDemo)) {
            $menuDemo[] = (object)['id' => 0, 'slug' => 'faq', 'title' => 'الأسئلة الشائعة', 'title_en' => 'FAQ', 'is_home' => 0];
        }
        if (!empty($partnerItemsDemo)) {
            $menuDemo[] = (object)['id' => 0, 'slug' => 'partners', 'title' => 'شركاؤنا', 'title_en' => 'Partners', 'is_home' => 0];
        }

        // عناوين الصفحات حسب القالب
        $pageTitles = [
            'default'    => ['ar' => $theme->name, 'en' => $theme->name_en ?? ''],
            'about'      => ['ar' => 'من نحن', 'en' => 'About Us'],
            'services'   => ['ar' => 'خدماتنا', 'en' => 'Our Services'],
            'contact'    => ['ar' => 'اتصل بنا', 'en' => 'Contact Us'],
            'gallery'    => ['ar' => 'المعرض', 'en' => 'Gallery'],
            'faq'        => ['ar' => 'الأسئلة الشائعة', 'en' => 'FAQ'],
            'partners'   => ['ar' => 'شركاؤنا', 'en' => 'Our Partners'],
            'booking'    => ['ar' => 'حجز موعد', 'en' => 'Book Appointment'],
        ];
        $pt = $pageTitles[$template] ?? $pageTitles['default'];

        $pageDemo = (object)[
            'id' => 0,
            'slug' => $template === 'default' ? '' : $template,
            'title' => $pt['ar'],
            'title_en' => $pt['en'],
            'content' => $content['about']['about_content']['content_ar'] ?? '',
            'content_en' => $content['about']['about_content']['content_en'] ?? '',
            'template' => $template,
            'meta_title' => $pt['ar'] . ' - ' . $theme->name,
            'meta_description' => $theme->description ?? '',
            'is_home' => ($template === 'default') ? 1 : 0,
        ];

        // Build faqCategories from faqItems (grouped)
        $faqCategoriesDemo = [];
        if (!empty($faqItemsDemo)) {
            foreach ($faqItemsDemo as $faq) {
                $cat = $faq->category ?? 'general';
                if (!isset($faqCategoriesDemo[$cat])) {
                    $faqCategoriesDemo[$cat] = [];
                }
                $faqCategoriesDemo[$cat][] = $faq;
            }
        }

        $data = [
            'tenant' => $tenantDemo,
            'page' => $pageDemo,
            'menu' => $menuDemo,
            'banners' => $bannersDemo,
            'services' => $servicesDemo,
            'gallery' => $galleryDemo,
            'testimonials' => $testimonialsDemo,
            'faqItems' => $faqItemsDemo,
            'faqCategories' => $faqCategoriesDemo,
            'siteStats' => $siteStatsDemo,
            'siteFeatures' => $siteFeaturesDemo,
            'partnerItems' => $partnerItemsDemo,
            'sectionsConfig' => [
                'hero' => true,
                'services' => true,
                'gallery' => !empty($galleryDemo),
                'testimonials' => !empty($testimonialsDemo),
                'contact' => true,
                'stats' => !empty($siteStatsDemo),
                'features' => !empty($siteFeaturesDemo),
                'partners' => !empty($partnerItemsDemo),
                'faq' => !empty($faqItemsDemo),
                'why_us' => !empty($siteFeaturesDemo),
            ],
            'title' => $pt['ar'] . ' - ' . $theme->name . ' (معاينة)',
            'meta_description' => $theme->description ?? '',
            'is_preview' => true,
            'siteBase' => '/theme-preview/' . $themeSlug,
            'lang'  => 'ar',
            'dir'   => 'rtl',
            'themeSettings' => (object)['primary_color' => '#0f172a'],
            'themeCustomCSS' => '',
            'themeFontsUrl' => 'https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap',
        ];

        return $data;
    }

    /**
     * ✅ صفحة معاينة ديمو للثيم - الرئيسية
     */
    public function previewDemo($themeSlug)
    {
        $themeModel = $this->model('Theme');
        $theme = $themeModel->findBySlug($themeSlug);
        if (!$theme) { $this->redirect('/'); return; }

        $data = $this->buildPreviewData($theme, $themeSlug, 'default');
        $this->renderTheme($themeSlug, 'default', $data);
    }

    /**
     * ✅ صفحة معاينة ديمو - من نحن
     */
    public function previewDemoAbout($themeSlug)
    {
        $themeModel = $this->model('Theme');
        $theme = $themeModel->findBySlug($themeSlug);
        if (!$theme) { $this->redirect('/'); return; }

        $data = $this->buildPreviewData($theme, $themeSlug, 'about');
        $this->renderTheme($themeSlug, 'about', $data);
    }

    /**
     * ✅ صفحة معاينة ديمو - خدماتنا
     */
    public function previewDemoServices($themeSlug)
    {
        $themeModel = $this->model('Theme');
        $theme = $themeModel->findBySlug($themeSlug);
        if (!$theme) { $this->redirect('/'); return; }

        $data = $this->buildPreviewData($theme, $themeSlug, 'services');
        $this->renderTheme($themeSlug, 'services', $data);
    }

    /**
     * ✅ صفحة معاينة ديمو - اتصل بنا
     */
    public function previewDemoContact($themeSlug)
    {
        $themeModel = $this->model('Theme');
        $theme = $themeModel->findBySlug($themeSlug);
        if (!$theme) { $this->redirect('/'); return; }

        $data = $this->buildPreviewData($theme, $themeSlug, 'contact');
        $this->renderTheme($themeSlug, 'contact', $data);
    }

    /**
     * ✅ صفحة معاينة ديمو - المعرض
     */
    public function previewDemoGallery($themeSlug)
    {
        $themeModel = $this->model('Theme');
        $theme = $themeModel->findBySlug($themeSlug);
        if (!$theme) { $this->redirect('/'); return; }

        $data = $this->buildPreviewData($theme, $themeSlug, 'gallery');
        $this->renderTheme($themeSlug, 'gallery', $data);
    }

    /**
     * ✅ صفحة معاينة ديمو - الأسئلة الشائعة
     */
    public function previewDemoFaq($themeSlug)
    {
        $themeModel = $this->model('Theme');
        $theme = $themeModel->findBySlug($themeSlug);
        if (!$theme) { $this->redirect('/'); return; }

        $data = $this->buildPreviewData($theme, $themeSlug, 'faq');
        $this->renderTheme($themeSlug, 'faq', $data);
    }

    /**
     * ✅ صفحة معاينة ديمو - شركاؤنا
     */
    public function previewDemoPartners($themeSlug)
    {
        $themeModel = $this->model('Theme');
        $theme = $themeModel->findBySlug($themeSlug);
        if (!$theme) { $this->redirect('/'); return; }

        $data = $this->buildPreviewData($theme, $themeSlug, 'partners');
        $this->renderTheme($themeSlug, 'partners', $data);
    }

    /**
     * ✅ صفحة معاينة ديمو - حجز موعد
     */
    public function previewDemoBooking($themeSlug)
    {
        $themeModel = $this->model('Theme');
        $theme = $themeModel->findBySlug($themeSlug);
        if (!$theme) { $this->redirect('/'); return; }

        $data = $this->buildPreviewData($theme, $themeSlug, 'booking');
        $this->renderTheme($themeSlug, 'booking', $data);
    }

    /**
 * ✅ صفحة معاينة ديمو - تفاصيل خدمة واحدة
 */
public function previewDemoService($themeSlug, $serviceSlug)
{
    $themeModel = $this->model('Theme');
    $theme = $themeModel->findBySlug($themeSlug);
    if (!$theme) { $this->redirect('/'); return; }

    $data = $this->buildPreviewData($theme, $themeSlug, 'services');

    // البحث عن الخدمة المطلوبة من قائمة الخدمات التجريبية
    $foundService = null;

    if (!empty($data['services'])) {
        foreach ($data['services'] as $svc) {
            if (($svc->slug ?? '') === $serviceSlug) {
                $foundService = $svc;
                break;
            }
        }
    }

    // ← إذا ما لقناها بالـ slug، نجرب نطابق بالرقم
    // (مثلاً service-2 → الخدمة الثانية في المصفوفة)
    if (!$foundService && !empty($data['services'])) {
        $idx = (int) preg_replace('/[^0-9]/', '', $serviceSlug) - 1;
        if ($idx >= 0 && isset($data['services'][$idx])) {
            $foundService = $data['services'][$idx];
        }
    }

    // ← إذا ما في خدمات أبداً (ثيم جديد بدون محتوى بالداتا بيز)
    // نعمل خدمة وهمية عشان القالب ما يخرب
    if (!$foundService) {
        $svcIdx = (int) preg_replace('/[^0-9]/', '', $serviceSlug);
        if ($svcIdx < 1) { $svcIdx = 1; }

        $defaultTitles = [
            1 => ['ar' => 'خدمة احترافية',   'en' => 'Professional Service'],
            2 => ['ar' => 'حلول متكاملة',     'en' => 'Integrated Solutions'],
            3 => ['ar' => 'صيانة ودعم',       'en' => 'Maintenance & Support'],
            4 => ['ar' => 'استشارات تقنية',    'en' => 'Tech Consulting'],
            5 => ['ar' => 'التطوير والبرمجة',  'en' => 'Development & Programming'],
            6 => ['ar' => 'الحماية والأمان',   'en' => 'Security & Protection'],
        ];
        $t = $defaultTitles[$svcIdx] ?? $defaultTitles[1];

        $foundService = (object)[
            'id'             => 0,
            'slug'           => $serviceSlug,
            'title'          => $t['ar'],
            'title_en'       => $t['en'],
            'description'    => 'نقدم خدمات احترافية متكاملة بأحدث التقنيات وأعلى معايير الجودة. فريقنا المتخصص جاهز لخدمتكم على مدار الساعة.',
            'description_en' => 'We provide comprehensive professional services with the latest technology and highest quality standards. Our team is ready to serve you 24/7.',
            'icon'           => 'fas fa-star',
            'image'          => '',
            'price'          => '',
            'price_text'     => '',
            'show_on_home'   => 1,
            'status'         => 'active',
        ];
    }

    $data['service'] = $foundService;

    // تحديث بيانات الصفحة
    $svcTitle = $foundService->title ?? 'تفاصيل الخدمة';
    $data['page'] = (object)[
        'id'          => 0,
        'slug'        => 'service',
        'title'       => $svcTitle,
        'title_en'    => $foundService->title_en ?? 'Service Details',
        'content'     => $foundService->description ?? '',
        'content_en'  => $foundService->description_en ?? '',
        'template'    => 'service',
        'is_home'     => 0,
    ];
    $data['title'] = $svcTitle . ' - ' . $theme->name . ' (معاينة)';

    $this->renderTheme($themeSlug, 'service', $data);
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

        $currentLang = function_exists('lang') ? lang() : ($tenant->default_language ?? 'ar');
        $currentDir  = ($currentLang === 'en') ? 'ltr' : 'rtl';

        $data = [
            'tenant' => $tenant,
            'service' => $service,
            'menu' => $this->getMenuForSite($tenant->id, BASE_PATH . '/site/' . $tenant->slug),
            'title' => $service->title . ' - ' . $tenant->site_name,
            'related_services' => $this->serviceModel->getTenantServices($tenant->id),
            'lang'  => $currentLang,
            'dir'   => $currentDir,
            'siteBase' => BASE_PATH . '/site/' . $tenant->slug,
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

        $currentLang = function_exists('lang') ? lang() : ($tenant->default_language ?? 'ar');
        $currentDir  = ($currentLang === 'en') ? 'ltr' : 'rtl';

        // Get the "services" page content
        $servicesPage = $this->pageModel->findBySlug('services', $tenant->id);
        if (!$servicesPage) {
            $servicesPage = (object)[
                'content' => '',
                'content_en' => '',
                'title' => 'خدماتنا',
                'title_en' => 'Our Services'
            ];
        }

        $data = [
            'tenant' => $tenant,
            'page' => $servicesPage,
            'services' => $this->serviceModel->getTenantServices($tenant->id),
            'menu' => $this->getMenuForSite($tenant->id, BASE_PATH . '/site/' . $tenant->slug),
            'banners' => $this->bannerModel->getHeroBanners($tenant->id),
            'sectionsConfig' => $this->tenantModel->getSectionsConfig($tenant->id),
            'siteStats' => $this->siteStatModel->getTenantStats($tenant->id, true),
            'siteFeatures' => $this->siteFeatureModel->getSiteFeatures($tenant->id),
            'testimonials' => $this->testimonialModel->getHomeTestimonials($tenant->id, 6),
            'title' => lang('our_services') . ' - ' . $tenant->site_name,
            'lang'  => $currentLang,
            'dir'   => $currentDir,
            'siteBase' => BASE_PATH . '/site/' . $tenant->slug,
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

        $currentLang = function_exists('lang') ? lang() : ($tenant->default_language ?? 'ar');
        $currentDir  = ($currentLang === 'en') ? 'ltr' : 'rtl';

        $data = [
            'tenant' => $tenant,
            'gallery' => $this->galleryModel->getActiveGallery($tenant->id),
            'menu' => $this->getMenuForSite($tenant->id, BASE_PATH . '/site/' . $tenant->slug),
            'banners' => $this->bannerModel->getHeroBanners($tenant->id),
            'sectionsConfig' => $this->tenantModel->getSectionsConfig($tenant->id),
            'services' => $this->serviceModel->getHomeServices($tenant->id, 6),
            'testimonials' => $this->testimonialModel->getHomeTestimonials($tenant->id, 6),
            'title' => lang('our_gallery') . ' - ' . $tenant->site_name,
            'lang'  => $currentLang,
            'dir'   => $currentDir,
            'siteBase' => BASE_PATH . '/site/' . $tenant->slug,
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

        $currentLang = function_exists('lang') ? lang() : ($tenant->default_language ?? 'ar');
        $currentDir  = ($currentLang === 'en') ? 'ltr' : 'rtl';

        $data = [
            'tenant' => $tenant,
            'menu' => $this->getMenuForSite($tenant->id, BASE_PATH . '/site/' . $tenant->slug),
            'banners' => $this->bannerModel->getHeroBanners($tenant->id),
            'sectionsConfig' => $this->tenantModel->getSectionsConfig($tenant->id),
            'services' => $this->serviceModel->getHomeServices($tenant->id, 6),
            'siteStats' => $this->siteStatModel->getTenantStats($tenant->id, true),
            'siteFeatures' => $this->siteFeatureModel->getSiteFeatures($tenant->id),
            'faqItems' => $this->faqModel->getTenantFaqs($tenant->id, true),
            'faqCategories' => $this->faqModel->getTenantFaqsGroupedByCategory($tenant->id, true),
            'title' => lang('contact_us') . ' - ' . $tenant->site_name,
            'lang'  => $currentLang,
            'dir'   => $currentDir,
            'siteBase' => BASE_PATH . '/site/' . $tenant->slug,
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

        $currentLang = function_exists('lang') ? lang() : ($tenant->default_language ?? 'ar');
        $currentDir  = ($currentLang === 'en') ? 'ltr' : 'rtl';

        // Get the "about" page content for the dynamic mission/vision section
        $aboutPage = $this->pageModel->findBySlug('about', $tenant->id);
        if (!$aboutPage) {
            $aboutPage = (object)[
                'content' => '',
                'content_en' => '',
                'title' => 'من نحن',
                'title_en' => 'About Us'
            ];
        }

        $data = [
            'tenant' => $tenant,
            'page' => $aboutPage,
            'services' => $this->serviceModel->getHomeServices($tenant->id, 6),
            'testimonials' => $this->testimonialModel->getHomeTestimonials($tenant->id, 6),
            'gallery' => $this->galleryModel->getActiveGallery($tenant->id, 6),
            'menu' => $this->getMenuForSite($tenant->id, BASE_PATH . '/site/' . $tenant->slug),
            'banners' => $this->bannerModel->getHeroBanners($tenant->id),
            'sectionsConfig' => $this->tenantModel->getSectionsConfig($tenant->id),
            'faqItems' => $this->faqModel->getTenantFaqs($tenant->id, true),
            'siteStats' => $this->siteStatModel->getTenantStats($tenant->id, true),
            'siteFeatures' => $this->siteFeatureModel->getSiteFeatures($tenant->id),
            'partnerItems' => $this->partnerModel->getTenantPartners($tenant->id, true),
            'title' => lang('about_us') . ' - ' . $tenant->site_name,
            'lang'  => $currentLang,
            'dir'   => $currentDir,
            'siteBase' => BASE_PATH . '/site/' . $tenant->slug,
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
            // إرسال إشعار داخلي لصاحب الموقع
            try {
                require_once ROOT_PATH . '/app/models/Notification.php';
                $notification = new Notification();
                if ($tenant->user_id) {
                    $notification->notifyNewMessage(
                        $tenant->user_id,
                        $data['name'],
                        '/dashboard/messages'
                    );
                }
            } catch (\Exception $e) {}

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
        $themeSlug = !empty($tenant->theme_slug) ? $tenant->theme_slug : 'cleanpro';
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
            'menu' => $this->getMenuForSite($tenant->id, BASE_PATH . '/site/' . $tenant->slug),
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
            'title' => lang('faq') . ' - ' . $tenant->site_name,
            'meta_description' => $tenant->meta_description,
            'lang'  => function_exists('lang') ? lang() : ($tenant->default_language ?? 'ar'),
            'dir'   => (function_exists('lang') && lang() === 'en') ? 'ltr' : 'rtl',
            'siteBase' => BASE_PATH . '/site/' . $tenant->slug,
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
        $themeSlug = !empty($tenant->theme_slug) ? $tenant->theme_slug : 'cleanpro';
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
            'menu' => $this->getMenuForSite($tenant->id, BASE_PATH . '/site/' . $tenant->slug),
            'banners' => $this->bannerModel->getHeroBanners($tenant->id),
            'services' => $this->serviceModel->getHomeServices($tenant->id, 6),
            'gallery' => $this->galleryModel->getActiveGallery($tenant->id, 8),
            'testimonials' => $this->testimonialModel->getHomeTestimonials($tenant->id, 6),
            'sectionsConfig' => $this->tenantModel->getSectionsConfig($tenant->id),
            'partnerItems' => $this->partnerModel->getTenantPartners($tenant->id, true),
            'siteStats' => $this->siteStatModel->getTenantStats($tenant->id, true),
            'siteFeatures' => $this->siteFeatureModel->getSiteFeatures($tenant->id),
            'title' => lang('partners') . ' - ' . $tenant->site_name,
            'meta_description' => $tenant->meta_description,
            'lang'  => function_exists('lang') ? lang() : ($tenant->default_language ?? 'ar'),
            'dir'   => (function_exists('lang') && lang() === 'en') ? 'ltr' : 'rtl',
            'siteBase' => BASE_PATH . '/site/' . $tenant->slug,
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
        $themeSlug = !empty($tenant->theme_slug) ? $tenant->theme_slug : 'cleanpro';
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
            'menu' => $this->getMenuForSite($tenant->id, BASE_PATH . '/site/' . $tenant->slug),
            'banners' => $this->bannerModel->getHeroBanners($tenant->id),
            'services' => $this->serviceModel->getHomeServices($tenant->id, 20),
            'gallery' => $this->galleryModel->getActiveGallery($tenant->id, 8),
            'testimonials' => $this->testimonialModel->getHomeTestimonials($tenant->id, 6),
            'sectionsConfig' => $this->tenantModel->getSectionsConfig($tenant->id),
            'siteStats' => $this->siteStatModel->getTenantStats($tenant->id, true),
            'siteFeatures' => $this->siteFeatureModel->getSiteFeatures($tenant->id),
            'faqItems' => $this->faqModel->getTenantFaqs($tenant->id, true),
            'partnerItems' => $this->partnerModel->getTenantPartners($tenant->id, true),
            'title' => lang('booking') . ' - ' . $tenant->site_name,
            'meta_description' => $tenant->meta_description,
            'lang'  => function_exists('lang') ? lang() : ($tenant->default_language ?? 'ar'),
            'dir'   => (function_exists('lang') && lang() === 'en') ? 'ltr' : 'rtl',
            'siteBase' => BASE_PATH . '/site/' . $tenant->slug,
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
            $defaultPath = THEMES_PATH . '/cleanpro/' . $template . '.php';
            if (file_exists($defaultPath)) {
                extract($data);
                require $defaultPath;
            } else {
                echo "Template not found: {$template}";
            }
        }
    }
}
