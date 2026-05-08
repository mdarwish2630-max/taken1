<?php
/**
 * CMS Platform - Page Model
 * نموذج الصفحات
 */

class Page extends Model
{
    protected $table = 'pages';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tenant_id', 'title', 'slug', 'content', 'meta_title', 'meta_description',
        'template', 'is_home', 'show_in_menu', 'menu_order', 'status',
        'title_en', 'content_en'
    ];

    /**
     * الحصول على صفحات موقع معين
     */
    public function getTenantPages($tenantId)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE tenant_id = ? ORDER BY menu_order ASC",
            [$tenantId]
        )->results();
    }

    /**
     * الحصول على صفحات القائمة
     */
    public function getMenuPages($tenantId)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE tenant_id = ? AND show_in_menu = 1 AND status = 'published' ORDER BY menu_order ASC",
            [$tenantId]
        )->results();
    }

    /**
     * الحصول على الصفحة الرئيسية
     */
    public function getHomePage($tenantId)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE tenant_id = ? AND is_home = 1",
            [$tenantId]
        )->first();
    }

    /**
     * إنشاء صفحة جديدة
     */
    public function createPage($data)
    {
        // توليد slug فريد
        $data['slug'] = generateUniqueSlug(
            $data['title'], 
            $this->table, 
            'slug',
            $data['id'] ?? null
        );
        
        // تعيين الترتيب
        if (!isset($data['menu_order'])) {
            $maxOrder = $this->db->query(
                "SELECT COALESCE(MAX(menu_order), 0) as max_order FROM {$this->table} WHERE tenant_id = ?",
                [$data['tenant_id']]
            )->first()->max_order;
            
            $data['menu_order'] = $maxOrder + 1;
        }
        
        return $this->create($data);
    }

    /**
     * تحديث صفحة
     */
    public function updatePage($id, $data)
    {
        if (isset($data['title']) && !isset($data['slug'])) {
            $data['slug'] = generateUniqueSlug(
                $data['title'], 
                $this->table, 
                'slug',
                $id
            );
        }
        
        return $this->update($id, $data);
    }

    /**
     * عدد صفحات مستأجر
     */
    public function countByTenant($tenantId)
    {
        $result = $this->db->query(
            "SELECT COUNT(*) as count FROM {$this->table} WHERE tenant_id = ?",
            [$tenantId]
        )->first();
        return $result ? $result->count : 0;
    }

    /**
     * البحث بواسطة Slug والموقع
     */
    public function findBySlug($slug, $tenantId)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE slug = ? AND tenant_id = ?",
            [$slug, $tenantId]
        )->first();
    }

    /**
     * تحديث ترتيب القائمة
     */
    public function updateMenuOrder($id, $order)
    {
        return $this->update($id, ['menu_order' => $order]);
    }

    /**
     * إخفاء/إظهار في القائمة
     */
    public function toggleMenuVisibility($id)
    {
        $page = $this->find($id);
        
        if (!$page) {
            return false;
        }
        
        $newValue = $page->show_in_menu ? 0 : 1;
        return $this->update($id, ['show_in_menu' => $newValue]);
    }

    /**
     * نشر/إلغاء نشر صفحة
     */
    public function toggleStatus($id)
    {
        $page = $this->find($id);
        
        if (!$page) {
            return false;
        }
        
        $newStatus = $page->status === 'published' ? 'draft' : 'published';
        return $this->update($id, ['status' => $newStatus]);
    }
}
