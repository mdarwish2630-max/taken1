<?php
/**
 * CMS Platform - Blog Controller
 * متحكم المدونة
 */

class BlogController extends Controller
{
    private $blogModel;
    private $tenantModel;

    public function __construct()
    {
        parent::__construct();
        
        require_once ROOT_PATH . '/app/models/BlogPost.php';
        $this->blogModel = new BlogPost();
        $this->tenantModel = $this->model('Tenant');
    }

    /**
     * قائمة المقالات (داشبورد)
     */
    public function index()
    {
        $this->requireAuth();
        $this->setLayout('dashboard');
        $tenant = Auth::tenant();
        $posts = $this->blogModel->getTenantPosts($tenant->id);

        $this->view('dashboard/blog/index', [
            'title' => lang('blog_posts'),
            'posts' => $posts,
            'tenant' => $tenant
        ]);
    }

    /**
     * نموذج إضافة مقال (داشبورد)
     */
    public function add()
    {
        $this->requireAuth();
        $this->setLayout('dashboard');
        $tenant = Auth::tenant();
        $categories = $this->blogModel->getCategories($tenant->id);

        $this->view('dashboard/blog/form', [
            'title' => lang('add_post'),
            'post' => null,
            'categories' => $categories,
            'tenant' => $tenant
        ]);
    }

    /**
     * حفظ مقال جديد
     */
    public function store()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        $data = [
            'tenant_id' => $tenant->id,
            'title' => $this->input('title'),
            'slug' => $this->input('slug'),
            'excerpt' => $this->input('excerpt'),
            'content' => $this->input('content'),
            'category' => $this->input('category'),
            'tags' => json_encode($this->input('tags', [])),
            'author_name' => Auth::user()->full_name,
            'meta_title' => $this->input('meta_title'),
            'meta_description' => $this->input('meta_description'),
            'status' => $this->input('status', 'draft'),
            'show_on_home' => $this->input('show_on_home') ? 1 : 0
        ];

        // رفع الصورة البارزة
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $result = $this->uploadFile($_FILES['featured_image'], $tenant->id . '/blog', ALLOWED_IMAGE_TYPES);
            if (!isset($result['error'])) {
                $data['featured_image'] = $result['path'];
            }
        }

        // تاريخ النشر
        if ($data['status'] === 'published') {
            $data['published_at'] = date('Y-m-d H:i:s');
        } elseif ($data['status'] === 'scheduled') {
            $publishedAt = $this->input('published_at');
            if ($publishedAt && strtotime($publishedAt) !== false) {
                $data['published_at'] = date('Y-m-d H:i:s', strtotime($publishedAt));
            } else {
                Session::error('تاريخ النشر غير صالح');
                $this->redirect('/dashboard/blog/add');
            }
        }

        if ($this->blogModel->createPost($data)) {
            Session::success(lang('post_added'));
            $this->redirect('/dashboard/blog');
        }

        Session::error(lang('error_occurred'));
        $this->redirect('/dashboard/blog/add');
    }

    /**
     * نموذج تعديل مقال (داشبورد)
     */
    public function edit($id)
    {
        $this->requireAuth();
        $this->setLayout('dashboard');
        $tenant = Auth::tenant();
        $post = $this->blogModel->find($id);

        if (!$post || $post->tenant_id != $tenant->id) {
            Session::error(lang('post_not_found'));
            $this->redirect('/dashboard/blog');
        }

        $categories = $this->blogModel->getCategories($tenant->id);

        $this->view('dashboard/blog/form', [
            'title' => lang('edit_post'),
            'post' => $post,
            'categories' => $categories,
            'tenant' => $tenant
        ]);
    }

    /**
     * تحديث مقال
     */
    public function update($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $post = $this->blogModel->find($id);

        if (!$post || $post->tenant_id != $tenant->id) {
            $this->jsonError(lang('post_not_found'), [], 404);
        }

        $data = [
            'title' => $this->input('title'),
            'slug' => $this->input('slug'),
            'excerpt' => $this->input('excerpt'),
            'content' => $this->input('content'),
            'category' => $this->input('category'),
            'tags' => json_encode($this->input('tags', [])),
            'meta_title' => $this->input('meta_title'),
            'meta_description' => $this->input('meta_description'),
            'status' => $this->input('status'),
            'show_on_home' => $this->input('show_on_home') ? 1 : 0
        ];

        // رفع صورة جديدة
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $result = $this->uploadFile($_FILES['featured_image'], $tenant->id . '/blog', ALLOWED_IMAGE_TYPES);
            if (!isset($result['error'])) {
                if ($post->featured_image) {
                    $this->deleteFile($post->featured_image);
                }
                $data['featured_image'] = $result['path'];
            }
        }

        // تحديث تاريخ النشر عند النشر لأول مرة
        if ($data['status'] === 'published' && $post->status !== 'published') {
            $data['published_at'] = date('Y-m-d H:i:s');
        }

        $this->blogModel->update($id, $data);

        Session::success(lang('post_updated'));
        $this->redirect('/dashboard/blog');
    }

    /**
     * حذف مقال
     */
    public function delete($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $post = $this->blogModel->find($id);

        if (!$post || $post->tenant_id != $tenant->id) {
            $this->jsonError(lang('post_not_found'), [], 404);
        }

        // حذف الصورة
        if ($post->featured_image) {
            $this->deleteFile($post->featured_image);
        }

        if ($this->blogModel->delete($id)) {
            $this->jsonSuccess([], lang('post_deleted'));
        }

        $this->jsonError(lang('error_occurred'));
    }

    /**
     * تجهيز البيانات المشتركة لكل صفحات الموقع العام
     * (نفس البيانات اللي SiteController يجهزها)
     */
    private function prepareSiteData($tenant, $slug, $extra = [])
    {
        // تحديد لغة الموقع
        if (method_exists($this, 'setSiteLanguage')) {
            $this->setSiteLanguage($tenant, $slug);
        } elseif (isset($_GET['lang']) && in_array($_GET['lang'], ['ar', 'en'], true)) {
            if (function_exists('Language::setLocale')) Language::setLocale($_GET['lang']);
        } elseif (isset($_COOKIE['site_lang_' . $slug]) && in_array($_COOKIE['site_lang_' . $slug], ['ar', 'en'])) {
            if (function_exists('Language::setLocale')) Language::setLocale($_COOKIE['site_lang_' . $slug]);
        } elseif (!empty($tenant->default_language) && in_array($tenant->default_language, ['ar', 'en'])) {
            if (function_exists('Language::setLocale')) Language::setLocale($tenant->default_language);
        }

        $currentLang = function_exists('lang') ? lang() : ($tenant->default_language ?? 'ar');
        $currentDir  = ($currentLang === 'en') ? 'ltr' : 'rtl';
        $siteBase = BASE_PATH . '/site/' . $tenant->slug;

        // تحميل إعدادات الثيم
        $themeSettings = (object)['primary_color' => '#0f172a'];
        $themeCustomCSS = '';
        $themeFontsUrl = '';
        if (file_exists(ROOT_PATH . '/app/models/ThemeSettings.php')) {
            require_once ROOT_PATH . '/app/models/ThemeSettings.php';
            $tsModel = new \ThemeSettings();
            $themeSettings = $tsModel->getTenantSettings($tenant->id);
            $themeCustomCSS = $tsModel->generateCustomCSS($tenant->id, $tenant);
            $themeFontsUrl = $tsModel->getGoogleFontsUrl($tenant->id);
        }

        // تحميل المنو من site_menu
        $menu = [];
        if (file_exists(ROOT_PATH . '/app/models/MenuModel.php')) {
            require_once ROOT_PATH . '/app/models/MenuModel.php';
            $menuModel = new \MenuModel();
            $menu = $menuModel->getActiveMenuItems($tenant->id, $siteBase);
        }

        return array_merge([
            'tenant' => $tenant,
            'menu' => $menu,
            'lang' => $currentLang,
            'dir' => $currentDir,
            'siteBase' => $siteBase,
            'themeSettings' => $themeSettings,
            'themeCustomCSS' => $themeCustomCSS,
            'themeFontsUrl' => $themeFontsUrl,
        ], $extra);
    }

    /**
     * عرض مقال على الموقع (صفحة عامة)
     */
    public function show($slug, $postSlug)
    {
        $tenant = $this->tenantModel->findBySlug($slug);

        if (!$tenant) {
            $this->redirect('/');
        }

        $post = $this->blogModel->findBySlug($postSlug, $tenant->id);

        if (!$post || $post->status !== 'published') {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        // زيادة المشاهدات
        $this->blogModel->incrementViews($post->id);

        // المقالات ذات الصلة
        $relatedPosts = $this->blogModel->getRelated($tenant->id, $post->id, $post->category, 3);

        $data = $this->prepareSiteData($tenant, $slug, [
            'post' => $post,
            'related_posts' => $relatedPosts,
            'title' => $post->title . ' - ' . $tenant->site_name,
            'meta_description' => $post->meta_description ?: $post->excerpt,
        ]);

        $themeSlug = !empty($tenant->theme_slug) ? $tenant->theme_slug : 'cleanpro';
        $themePath = THEMES_PATH . '/' . $themeSlug . '/blog-post.php';

        if (file_exists($themePath)) {
            extract($data);
            require $themePath;
        } else {
            // عرض افتراضي
            $this->view('site/blog-post', $data);
        }
    }

    /**
     * قائمة المدونة على الموقع (صفحة عامة)
     */
    public function list($slug)
    {
        $tenant = $this->tenantModel->findBySlug($slug);

        if (!$tenant) {
            $this->redirect('/');
        }

        $page = $this->input('page', 1);
        $category = $this->input('category');

        if ($category) {
            $posts = $this->blogModel->getByCategory($tenant->id, $category, 10);
        } else {
            $posts = $this->blogModel->getPublishedPosts($tenant->id, 10);
        }

        $categories = $this->blogModel->getCategories($tenant->id);

        $data = $this->prepareSiteData($tenant, $slug, [
            'posts' => $posts,
            'categories' => $categories,
            'current_category' => $category,
            'page' => (object)[
                'slug' => 'blog',
                'title' => lang('blog'),
                'title_en' => 'Blog',
                'template' => 'blog',
                'is_home' => 0,
            ],
            'title' => lang('blog') . ' - ' . $tenant->site_name,
        ]);

        $themeSlug = !empty($tenant->theme_slug) ? $tenant->theme_slug : 'cleanpro';
        $themePath = THEMES_PATH . '/' . $themeSlug . '/blog.php';

        if (file_exists($themePath)) {
            extract($data);
            require $themePath;
        } else {
            $this->view('site/blog', $data);
        }
    }
}
