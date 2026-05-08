<?php
/**
 * CMS Platform - SEO Controller
 * متحكم إعدادات SEO
 */

class SeoController extends Controller
{
    private $seoModel;
    private $tenantModel;

    public function __construct()
    {
        parent::__construct();
        $this->requireAuth();
        
        $this->view->setLayout('dashboard');
        
        require_once ROOT_PATH . '/app/models/SeoSettings.php';
        $this->seoModel = new SeoSettings();
        $this->tenantModel = $this->model('Tenant');
    }

    /**
     * عرض صفحة إعدادات SEO
     */
    public function index()
    {
        $tenant = Auth::tenant();
        $seoSettings = $this->seoModel->getTenantSettings($tenant->id);

        if (!$seoSettings) {
            // إنشاء إعدادات افتراضية
            $this->seoModel->createDefault($tenant->id);
            $seoSettings = $this->seoModel->getTenantSettings($tenant->id);
        }

        $this->view('dashboard/seo', [
            'title' => lang('seo_settings'),
            'tenant' => $tenant,
            'seo' => $seoSettings
        ]);
    }

    /**
     * تحديث إعدادات SEO
     */
    public function update()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        $data = [
            'meta_title' => $this->input('meta_title'),
            'meta_description' => $this->input('meta_description'),
            'meta_keywords' => $this->input('meta_keywords'),
            'og_title' => $this->input('og_title'),
            'og_description' => $this->input('og_description'),
            'og_image' => $this->input('og_image'),
            'twitter_card' => $this->input('twitter_card', 'summary_large_image'),
            'canonical_url' => $this->validateUrl($this->input('canonical_url')),
            'google_analytics_id' => $this->input('google_analytics_id'),
            'google_tag_manager_id' => $this->input('google_tag_manager_id'),
            'facebook_pixel_id' => $this->input('facebook_pixel_id'),
            'google_site_verification' => $this->input('google_site_verification'),
            'bing_site_verification' => $this->input('bing_site_verification'),
            'schema_type' => $this->input('schema_type', 'LocalBusiness'),
            'schema_data' => json_encode([
                'name' => $this->input('schema_name'),
                'description' => $this->input('schema_description'),
                'telephone' => $this->input('schema_telephone'),
                'address' => $this->input('schema_address'),
                'price_range' => $this->input('schema_price_range'),
            ]),
            'robots_txt' => $this->sanitizeRobotsTxt($this->input('robots_txt')),
            'enable_sitemap' => $this->input('enable_sitemap') ? 1 : 0,
            'noindex' => $this->input('noindex') ? 1 : 0,
            'nofollow' => $this->input('nofollow') ? 1 : 0,
        ];

        // رفع صورة Open Graph
        if (isset($_FILES['og_image_file']) && $_FILES['og_image_file']['error'] === UPLOAD_ERR_OK) {
            $result = $this->uploadFile($_FILES['og_image_file'], $tenant->id . '/seo', ALLOWED_IMAGE_TYPES);
            if (!isset($result['error'])) {
                $data['og_image'] = $result['path'];
            }
        }

        if ($this->seoModel->updateSettings($tenant->id, $data)) {
            Session::success(lang('settings_saved'));
        } else {
            Session::error(lang('error_occurred'));
        }

        $this->redirect('/dashboard/seo');
    }

    /**
     * إنشاء ملف sitemap.xml
     */
    public function generateSitemap()
    {
        $tenant = Auth::tenant();
        
        $sitemap = $this->seoModel->generateSitemap($tenant->id);
        
        if ($sitemap) {
            Session::success(lang('sitemap_generated'));
        } else {
            Session::error(lang('error_occurred'));
        }

        $this->redirect('/dashboard/seo');
    }

    /**
     * تحديث ملف robots.txt
     */
    public function updateRobots()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $content = $this->sanitizeRobotsTxt($this->input('robots_content'));

        if ($this->seoModel->updateRobotsTxt($tenant->id, $content)) {
            Session::success(lang('robots_updated'));
        } else {
            Session::error(lang('error_occurred'));
        }

        $this->redirect('/dashboard/seo');
    }

    /**
     * [FIX-27] التحقق من صلاحية URL
     */
    private function validateUrl($url)
    {
        if (empty($url)) {
            return null;
        }
        $url = filter_var($url, FILTER_SANITIZE_URL);
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return null;
        }
        return $url;
    }

    /**
     * [FIX-27/28] تطهير محتوى robots.txt
     */
    private function sanitizeRobotsTxt($content)
    {
        if (empty($content)) {
            return '';
        }
        // السماح فقط بسطور robots.txt الصالحة
        $lines = explode("\n", $content);
        $sanitized = [];
        $allowedDirectives = ['User-agent', 'Disallow', 'Allow', 'Sitemap', 'Crawl-delay', 'Robots-tag'];
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || strpos($line, '#') === 0) {
                $sanitized[] = $line;
                continue;
            }
            $parts = explode(':', $line, 2);
            if (count($parts) >= 2 && in_array(trim($parts[0]), $allowedDirectives)) {
                $sanitized[] = $line;
            }
        }
        return implode("\n", $sanitized);
    }
}
