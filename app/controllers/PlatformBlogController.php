<?php
/**
 * CMS Platform - Platform Blog Controller
 * متحكم مدونة المنصة الرئيسية
 */

class PlatformBlogController extends Controller
{
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
    }

    /**
     * Helper: generate slug from Arabic/English text
     */
    private function generateSlug($text, $excludeId = null)
    {
        $slug = preg_replace('/[^\p{L}\p{N}]+/u', '-', $text);
        $slug = trim($slug, '-');
        $slug = strtolower($slug);

        $query = "SELECT id FROM platform_blog_posts WHERE slug = ?";
        $params = [$slug];
        if ($excludeId) {
            $query .= " AND id != ?";
            $params[] = $excludeId;
        }

        $exists = $this->db->query($query, $params)->first();
        if ($exists) {
            $slug .= '-' . time();
        }

        return $slug;
    }

    // ========================================
    // PUBLIC METHODS
    // ========================================

    /**
     * Public listing of published blog posts
     */
    public function index()
    {
        $page = (int)($this->input('page', 1));
        $perPage = 12;
        $offset = ($page - 1) * $perPage;

        $total = $this->db->query("SELECT COUNT(*) as c FROM platform_blog_posts WHERE status = 'published'")->first()->c ?? 0;
        $posts = $this->db->query(
            "SELECT * FROM platform_blog_posts WHERE status = 'published' ORDER BY published_at DESC LIMIT ? OFFSET ?",
            [$perPage, $offset]
        )->results();

        $totalPages = ceil($total / $perPage);

        $lang = Language::current();

        $this->view('platform/blog', [
            'title' => ($lang === 'en' ? 'Blog' : 'المدونة') . ' - ' . (defined('SITE_NAME') ? SITE_NAME : 'TakweenWeb'),
            'posts' => $posts,
            'page' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
            'lang' => $lang
        ]);
    }

    /**
     * Public single post view
     */
    public function show($slug)
    {
        $post = $this->db->query("SELECT * FROM platform_blog_posts WHERE slug = ? AND status = 'published'", [$slug])->first();

        if (!$post) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        // Increment views
        $this->db->query("UPDATE platform_blog_posts SET views = views + 1 WHERE id = ?", [$post->id]);

        // Get related posts (same category, exclude current)
        $related = [];
        if (!empty($post->category)) {
            $related = $this->db->query(
                "SELECT * FROM platform_blog_posts WHERE status = 'published' AND category = ? AND id != ? ORDER BY published_at DESC LIMIT 3",
                [$post->category, $post->id]
            )->results();
        }

        $lang = Language::current();
        $siteUrl = defined('BASE_URL') ? BASE_URL : (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];

        $metaTitle = $post->meta_title ?: $post->title;
        $metaDesc = $post->meta_description ?: ($post->excerpt ?? '');

        $this->view('platform/blog-post', [
            'title' => htmlspecialchars($metaTitle),
            'post' => $post,
            'related' => $related,
            'metaDesc' => htmlspecialchars($metaDesc),
            'siteUrl' => $siteUrl,
            'lang' => $lang
        ]);
    }

    // ========================================
    // ADMIN METHODS
    // ========================================

    /**
     * Admin listing - all posts
     */
    public function adminIndex()
    {
        $this->requireAdmin();
        $this->setLayout('admin');

        $posts = $this->db->query("SELECT * FROM platform_blog_posts ORDER BY created_at DESC")->results();

        $this->view('admin/platform-blog', [
            'title' => 'إدارة المدونة - لوحة تحكم المدير',
            'posts' => $posts
        ]);
    }

    /**
     * Admin create form
     */
    public function adminCreate()
    {
        $this->requireAdmin();
        $this->setLayout('admin');

        $this->view('admin/platform-blog-form', [
            'title' => 'إضافة مقال جديد - لوحة تحكم المدير',
            'post' => null
        ]);
    }

    /**
     * Admin save new post
     */
    public function adminStore()
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $title = $this->input('title');
        $slug = $this->input('slug');
        if (empty($slug)) {
            $slug = $this->generateSlug($title);
        } else {
            $slug = $this->generateSlug($slug);
        }

        $status = $this->input('status', 'draft');
        $publishedAt = null;
        if ($status === 'published') {
            $publishedAt = date('Y-m-d H:i:s');
        }

        $data = [
            $title,
            $slug,
            $this->input('excerpt'),
            $this->input('content'),
            null, // featured_image, set below if uploaded
            $this->input('category'),
            $this->input('tags'),
            $this->input('meta_title'),
            $this->input('meta_description'),
            $status,
            $publishedAt,
            Auth::user()->id ?? null
        ];

        // Handle image upload
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $result = $this->uploadFile($_FILES['featured_image'], 'platform-blog', ALLOWED_IMAGE_TYPES);
            if (!isset($result['error'])) {
                $data[4] = $result['path'];
            }
        }

        $sql = "INSERT INTO platform_blog_posts 
            (title, slug, excerpt, content, featured_image, category, tags, meta_title, meta_description, status, published_at, author_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $this->db->query($sql, $data);

        Session::success('تم إضافة المقال بنجاح');
        $this->redirect('/admin/blog');
    }

    /**
     * Admin edit form
     */
    public function adminEdit($id)
    {
        $this->requireAdmin();
        $this->setLayout('admin');

        $post = $this->db->query("SELECT * FROM platform_blog_posts WHERE id = ?", [$id])->first();

        if (!$post) {
            Session::error('المقال غير موجود');
            $this->redirect('/admin/blog');
            return;
        }

        $this->view('admin/platform-blog-form', [
            'title' => 'تعديل المقال - لوحة تحكم المدير',
            'post' => $post
        ]);
    }

    /**
     * Admin update post
     */
    public function adminUpdate($id)
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $post = $this->db->query("SELECT * FROM platform_blog_posts WHERE id = ?", [$id])->first();

        if (!$post) {
            Session::error('المقال غير موجود');
            $this->redirect('/admin/blog');
            return;
        }

        $title = $this->input('title');
        $slug = $this->input('slug');
        if (empty($slug)) {
            $slug = $this->generateSlug($title, $id);
        } else {
            $slug = $this->generateSlug($slug, $id);
        }

        $status = $this->input('status', $post->status);
        $publishedAt = $post->published_at;
        if ($status === 'published' && $post->status !== 'published') {
            $publishedAt = date('Y-m-d H:i:s');
        } elseif ($status === 'draft') {
            $publishedAt = null;
        }

        $data = [
            $title,
            $slug,
            $this->input('excerpt'),
            $this->input('content'),
            $this->input('category'),
            $this->input('tags'),
            $this->input('meta_title'),
            $this->input('meta_description'),
            $status,
            $publishedAt
        ];

        // Handle image upload
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $result = $this->uploadFile($_FILES['featured_image'], 'platform-blog', ALLOWED_IMAGE_TYPES);
            if (!isset($result['error'])) {
                // Delete old image
                if ($post->featured_image) {
                    $this->deleteFile($post->featured_image);
                }
                $data[] = $result['path'];
            } else {
                $data[] = $post->featured_image;
            }
        } else {
            $data[] = $post->featured_image;
        }

        $sql = "UPDATE platform_blog_posts SET 
            title = ?, slug = ?, excerpt = ?, content = ?, 
            category = ?, tags = ?, meta_title = ?, meta_description = ?, 
            status = ?, published_at = ?, featured_image = ? 
            WHERE id = ?";

        $data[] = $id;

        $this->db->query($sql, $data);

        Session::success('تم تحديث المقال بنجاح');
        $this->redirect('/admin/blog');
    }

    /**
     * Admin delete post
     */
    public function adminDelete($id)
    {
        $this->requireAdmin();
        $this->verifyCsrf();

        $post = $this->db->query("SELECT * FROM platform_blog_posts WHERE id = ?", [$id])->first();

        if (!$post) {
            $this->jsonError('المقال غير موجود', [], 404);
            return;
        }

        // Delete image
        if ($post->featured_image) {
            $this->deleteFile($post->featured_image);
        }

        $this->db->query("DELETE FROM platform_blog_posts WHERE id = ?", [$id]);

        $this->jsonSuccess([], 'تم حذف المقال بنجاح');
    }
}
