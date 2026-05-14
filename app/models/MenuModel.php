<?php
/**
 * CMS Platform - Menu Model
 * نموذج إدارة المنو
 */

class MenuModel extends Model
{
    protected $table = 'site_menu';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tenant_id', 'item_type', 'section_key', 'page_id',
        'label', 'label_en', 'url', 'icon',
        'is_active', 'menu_order', 'open_in_new_tab'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->ensureTableExists();
    }

    /**
     * التأكد من وجود الجدول - يُنشئه تلقائياً إذا لم يكن موجوداً
     */
    private function ensureTableExists()
    {
        try {
            $this->db->getPdo()->query("SELECT 1 FROM `site_menu` LIMIT 1");
        } catch (\Exception $e) {
            // الجدول غير موجود - إنشاؤه
            $this->db->getPdo()->exec("
                CREATE TABLE IF NOT EXISTS `site_menu` (
                    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    `tenant_id` INT UNSIGNED NOT NULL,
                    `item_type` ENUM('section','page','external') NOT NULL DEFAULT 'section',
                    `section_key` VARCHAR(50) DEFAULT NULL,
                    `page_id` INT UNSIGNED DEFAULT NULL,
                    `label` VARCHAR(100) NOT NULL,
                    `label_en` VARCHAR(100) DEFAULT NULL,
                    `url` VARCHAR(255) DEFAULT NULL,
                    `icon` VARCHAR(50) DEFAULT NULL,
                    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
                    `menu_order` INT NOT NULL DEFAULT 0,
                    `open_in_new_tab` TINYINT(1) NOT NULL DEFAULT 0,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    INDEX `idx_tenant_active` (`tenant_id`, `is_active`, `menu_order`),
                    INDEX `idx_tenant_type` (`tenant_id`, `item_type`),
                    FOREIGN KEY (`tenant_id`) REFERENCES `tenants`(`id`) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
        }
    }

    /**
     * الأقسام المتاحة (built-in sections)
     */
    public static function getAvailableSections()
    {
        return [
            'home'     => ['label' => 'الرئيسية', 'label_en' => 'Home', 'icon' => 'fa-home', 'url_pattern' => ''],
            'about'    => ['label' => 'من نحن', 'label_en' => 'About Us', 'icon' => 'fa-building', 'url_pattern' => '/about'],
            'services' => ['label' => 'خدماتنا', 'label_en' => 'Our Services', 'icon' => 'fa-concierge-bell', 'url_pattern' => '/services'],
            'gallery'  => ['label' => 'معرض الأعمال', 'label_en' => 'Gallery', 'icon' => 'fa-photo-video', 'url_pattern' => '/gallery'],
            'faq'      => ['label' => 'الأسئلة الشائعة', 'label_en' => 'FAQ', 'icon' => 'fa-question-circle', 'url_pattern' => '/faq'],
            'partners' => ['label' => 'شركاؤنا', 'label_en' => 'Our Partners', 'icon' => 'fa-handshake', 'url_pattern' => '/partners'],
            'blog'     => ['label' => 'المدونة', 'label_en' => 'Blog', 'icon' => 'fa-blog', 'url_pattern' => '/blog'],
            'contact'  => ['label' => 'اتصل بنا', 'label_en' => 'Contact Us', 'icon' => 'fa-envelope', 'url_pattern' => '/contact'],
            'booking'  => ['label' => 'حجز موعد', 'label_en' => 'Book Now', 'icon' => 'fa-calendar-check', 'url_pattern' => '/booking'],
        ];
    }

    /**
     * الحصول على كل عناصر المنو لمستأجر (مرتبة)
     */
    public function getTenantMenu($tenantId)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE tenant_id = ? ORDER BY menu_order ASC, id ASC",
            [$tenantId]
        )->results();
    }

    /**
     * الحصول على عناصر المنو النشطة فقط (لعرضها في الموقع)
     * يرجع مصفوفة فيها: label, label_en, url, is_active, open_in_new_tab, icon
     */
    public function getActiveMenuItems($tenantId, $siteBase)
    {
        $items = $this->db->query(
            "SELECT * FROM {$this->table} WHERE tenant_id = ? AND is_active = 1 ORDER BY menu_order ASC, id ASC",
            [$tenantId]
        )->results();

        $sections = self::getAvailableSections();
        $result = [];

        foreach ($items as $item) {
            $url = '';
            $isHome = false;

            if ($item->item_type === 'section' && isset($sections[$item->section_key])) {
                $url = $siteBase . $sections[$item->section_key]['url_pattern'];
                if ($item->section_key === 'home') {
                    $url = $siteBase;
                    $isHome = true;
                }
            } elseif ($item->item_type === 'page' && $item->page_id) {
                $page = $this->db->query(
                    "SELECT slug FROM pages WHERE id = ? AND tenant_id = ?",
                    [$item->page_id, $tenantId]
                )->first();
                if ($page) {
                    $url = $siteBase . '/' . $page->slug;
                    $isHome = !empty($page->is_home);
                }
            } elseif ($item->item_type === 'external') {
                $url = $item->url;
            }

            $result[] = [
                'id'             => $item->id,
                'label'          => $item->label,
                'label_en'       => $item->label_en,
                'url'            => $url,
                'icon'           => $item->icon,
                'is_active'      => (int)$item->is_active,
                'is_home'        => $isHome,
                'open_in_new_tab'=> (int)$item->open_in_new_tab,
                'item_type'      => $item->item_type,
                'section_key'    => $item->section_key,
                'page_id'        => $item->page_id,
                'menu_order'     => (int)$item->menu_order,
            ];
        }

        return $result;
    }

    /**
     * إضافة قسم جديد للمنو
     */
    public function addSection($tenantId, $sectionKey)
    {
        $sections = self::getAvailableSections();
        if (!isset($sections[$sectionKey])) {
            return false;
        }

        // التحقق من عدم وجوده مسبقاً
        $exists = $this->db->query(
            "SELECT COUNT(*) as cnt FROM {$this->table} WHERE tenant_id = ? AND section_key = ? AND item_type = 'section'",
            [$tenantId, $sectionKey]
        )->first();

        if ($exists->cnt > 0) {
            return true; // موجود مسبقاً
        }

        $maxOrder = $this->db->query(
            "SELECT COALESCE(MAX(menu_order), 0) as max_order FROM {$this->table} WHERE tenant_id = ?",
            [$tenantId]
        )->first()->max_order;

        $section = $sections[$sectionKey];

        return $this->create([
            'tenant_id'   => $tenantId,
            'item_type'   => 'section',
            'section_key' => $sectionKey,
            'label'       => $section['label'],
            'label_en'    => $section['label_en'],
            'icon'        => $section['icon'],
            'is_active'   => 1,
            'menu_order'  => $maxOrder + 1,
        ]);
    }

    /**
     * إضافة صفحة مخصصة للمنو
     */
    public function addPageToMenu($tenantId, $pageId, $label = null, $labelEn = null)
    {
        $page = $this->db->query(
            "SELECT id, title, title_en, slug FROM pages WHERE id = ? AND tenant_id = ?",
            [$pageId, $tenantId]
        )->first();

        if (!$page) {
            return false;
        }

        // التحقق من عدم وجودها مسبقاً
        $exists = $this->db->query(
            "SELECT COUNT(*) as cnt FROM {$this->table} WHERE tenant_id = ? AND page_id = ? AND item_type = 'page'",
            [$tenantId, $pageId]
        )->first();

        if ($exists->cnt > 0) {
            return true;
        }

        $maxOrder = $this->db->query(
            "SELECT COALESCE(MAX(menu_order), 0) as max_order FROM {$this->table} WHERE tenant_id = ?",
            [$tenantId]
        )->first()->max_order;

        return $this->create([
            'tenant_id'   => $tenantId,
            'item_type'   => 'page',
            'page_id'     => $pageId,
            'label'       => $label ?: $page->title,
            'label_en'    => $labelEn ?: $page->title_en,
            'icon'        => 'fa-file-alt',
            'is_active'   => 1,
            'menu_order'  => $maxOrder + 1,
        ]);
    }

    /**
     * إضافة رابط خارجي للمنو
     */
    public function addExternalLink($tenantId, $label, $url, $labelEn = null, $icon = null, $openInNewTab = 1)
    {
        $maxOrder = $this->db->query(
            "SELECT COALESCE(MAX(menu_order), 0) as max_order FROM {$this->table} WHERE tenant_id = ?",
            [$tenantId]
        )->first()->max_order;

        return $this->create([
            'tenant_id'      => $tenantId,
            'item_type'      => 'external',
            'label'          => $label,
            'label_en'       => $labelEn,
            'url'            => $url,
            'icon'           => $icon ?: 'fa-external-link-alt',
            'is_active'      => 1,
            'menu_order'     => $maxOrder + 1,
            'open_in_new_tab'=> $openInNewTab ? 1 : 0,
        ]);
    }

    /**
     * تحديث ترتيب العناصر (batch)
     */
    public function updateOrder($tenantId, $orders)
    {
        if (!is_array($orders) || empty($orders)) {
            return false;
        }

        foreach ($orders as $id => $order) {
            $id = (int)$id;
            $order = (int)$order;
            $this->db->query(
                "UPDATE {$this->table} SET menu_order = ? WHERE id = ? AND tenant_id = ?",
                [$order, $id, $tenantId]
            );
        }

        return true;
    }

    /**
     * تبديل التفعيل/الإخفاء
     */
    public function toggleActive($id, $tenantId)
    {
        $item = $this->find($id);
        if (!$item || $item->tenant_id != $tenantId) {
            return false;
        }

        $newVal = $item->is_active ? 0 : 1;
        return $this->update($id, ['is_active' => $newVal]);
    }

    /**
     * حذف عنصر من المنو
     */
    public function removeItem($id, $tenantId)
    {
        $item = $this->find($id);
        if (!$item || $item->tenant_id != $tenantId) {
            return false;
        }

        return $this->delete($id);
    }

    /**
     * تحديث تسمية عنصر
     */
    public function updateLabels($id, $tenantId, $label, $labelEn)
    {
        $item = $this->find($id);
        if (!$item || $item->tenant_id != $tenantId) {
            return false;
        }

        return $this->update($id, [
            'label'    => $label,
            'label_en' => $labelEn ?: null,
        ]);
    }

    /**
     * الحصول على الأقسام غير المضافة للمنو
     */
    public function getMissingSections($tenantId)
    {
        $sections = self::getAvailableSections();
        $existing = $this->db->query(
            "SELECT section_key FROM {$this->table} WHERE tenant_id = ? AND item_type = 'section'",
            [$tenantId]
        )->results();

        $existingKeys = array_column($existing, 'section_key');
        $missing = [];

        foreach ($sections as $key => $info) {
            if (!in_array($key, $existingKeys)) {
                $missing[$key] = $info;
            }
        }

        return $missing;
    }

    /**
     * الحصول على الصفحات غير المضافة للمنو
     */
    public function getMissingPages($tenantId)
    {
        $existing = $this->db->query(
            "SELECT page_id FROM {$this->table} WHERE tenant_id = ? AND item_type = 'page'",
            [$tenantId]
        )->results();

        $existingIds = array_filter(array_column($existing, 'page_id'));
        $placeholders = empty($existingIds) ? '' : ' AND id NOT IN (' . implode(',', array_map('intval', $existingIds)) . ')';

        return $this->db->query(
            "SELECT id, title, title_en, slug FROM pages WHERE tenant_id = ? AND status = 'published'{$placeholders} ORDER BY title ASC",
            [$tenantId]
        )->results();
    }
}
