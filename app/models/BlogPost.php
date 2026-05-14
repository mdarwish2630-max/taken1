<?php
/**
 * CMS Platform - Blog Post Model
 * نموذج مقالات المدونة
 */

class BlogPost extends Model
{
    protected $table = 'blog_posts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tenant_id', 'title', 'slug', 'excerpt', 'content', 'featured_image',
        'category', 'tags', 'author_name', 'meta_title', 'meta_description',
        'status', 'published_at', 'views', 'show_on_home'
    ];

    /**
     * إنشاء مقال جديد
     */
    public function createPost($data)
    {
        // توليد slug فريد
        if (empty($data['slug'])) {
            $data['slug'] = generateUniqueSlug($data['title'], $this->table, 'slug');
        }

        // تعيين تاريخ النشر
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }

        return $this->create($data);
    }

    /**
     * الحصول على مقالات موقع معين
     */
    public function getTenantPosts($tenantId, $limit = null, $status = null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE tenant_id = ?";
        $params = [$tenantId];

        if ($status) {
            $sql .= " AND status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY created_at DESC";

        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }

        return $this->db->query($sql, $params)->results();
    }

    /**
     * الحصول على المقالات المنشورة
     */
    public function getPublishedPosts($tenantId, $limit = null)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE tenant_id = ? AND status = 'published' 
                AND (published_at IS NULL OR published_at <= NOW())
                ORDER BY published_at DESC";

        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }

        return $this->db->query($sql, [$tenantId])->results();
    }

    /**
     * الحصول على مقال بواسطة Slug
     */
    public function findBySlug($slug, $tenantId = null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE slug = ?";
        $params = [$slug];

        if ($tenantId) {
            $sql .= " AND tenant_id = ?";
            $params[] = $tenantId;
        }

        return $this->db->query($sql, $params)->first();
    }

    /**
     * الحصول على مقالات للصفحة الرئيسية
     */
    public function getHomePosts($tenantId, $limit = 3)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} 
             WHERE tenant_id = ? AND status = 'published' AND show_on_home = 1 
             AND (published_at IS NULL OR published_at <= NOW())
             ORDER BY published_at DESC LIMIT " . (int)$limit,
            [$tenantId]
        )->results();
    }

    /**
     * الحصول على المقالات حسب التصنيف
     */
    public function getByCategory($tenantId, $category, $limit = null)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE tenant_id = ? AND category = ? AND status = 'published'
                ORDER BY published_at DESC";

        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }

        return $this->db->query($sql, [$tenantId, $category])->results();
    }

    /**
     * زيادة عدد المشاهدات
     */
    public function incrementViews($postId)
    {
        return $this->db->query(
            "UPDATE {$this->table} SET views = views + 1 WHERE id = ?",
            [$postId]
        );
    }

    /**
     * الحصول على التصنيفات
     */
    public function getCategories($tenantId)
    {
        return $this->db->query(
            "SELECT DISTINCT category FROM {$this->table} 
             WHERE tenant_id = ? AND category IS NOT NULL AND category != ''
             ORDER BY category ASC",
            [$tenantId]
        )->results();
    }

    /**
     * الحصول على المقالات ذات الصلة
     */
    public function getRelated($tenantId, $postId, $category, $limit = 3)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} 
             WHERE tenant_id = ? AND id != ? AND category = ? AND status = 'published'
             ORDER BY published_at DESC LIMIT " . (int)$limit,
            [$tenantId, $postId, $category]
        )->results();
    }

    /**
     * البحث في المقالات
     */
    public function search($tenantId, $query, $limit = 10)
    {
        $escaped = Security::escapeLike($query);
        $searchTerm = "%{$escaped}%";
        return $this->db->query(
            "SELECT * FROM {$this->table} 
             WHERE tenant_id = ? AND status = 'published'
             AND (title LIKE ? OR content LIKE ? OR excerpt LIKE ?)
             ORDER BY published_at DESC LIMIT " . (int)$limit,
            [$tenantId, $searchTerm, $searchTerm, $searchTerm]
        )->results();
    }

    /**
     * الحصول على أرشيف شهري
     */
    public function getArchive($tenantId)
    {
        return $this->db->query(
            "SELECT DATE_FORMAT(published_at, '%Y-%m') as month, COUNT(*) as count
             FROM {$this->table} 
             WHERE tenant_id = ? AND status = 'published' AND published_at IS NOT NULL
             GROUP BY DATE_FORMAT(published_at, '%Y-%m')
             ORDER BY month DESC",
            [$tenantId]
        )->results();
    }
}
