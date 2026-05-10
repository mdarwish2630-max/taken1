<?php
/**
 * CMS Platform - Theme Model
 * نموذج القوالب - مع دعم التحكم الكامل من الأدمن
 */

class Theme extends Model
{
    protected $table = 'themes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'name_en', 'slug', 'description', 'description_en', 'category',
        'preview_image', 'is_active', 'is_premium', 'is_paid',
        'price', 'currency', 'payment_link', 'sort_order',
        'version', 'settings_schema'
    ];

    /**
     * الحصول على القوالب النشطة (التي فعلها الأدمن)
     */
    public function getActive()
    {
        return $this->where('is_active = ?', [1], $this->safeOrderBy('sort_order ASC, name ASC'));
    }

    /**
     * الحصول على جميع القوالب (للأدمن)
     */
    public function getAll()
    {
        return $this->all($this->safeOrderBy('sort_order ASC, name ASC'));
    }

    /**
     * الحصول على القوالب حسب الفئة
     */
    public function getByCategory($category)
    {
        return $this->where('category = ? AND is_active = ?', [$category, 1], $this->safeOrderBy('sort_order ASC, name ASC'));
    }

    /**
     * البحث بواسطة Slug
     */
    public function findBySlug($slug)
    {
        return $this->findBy('slug', $slug);
    }

    /**
     * الحصول على القوالب المجانية النشطة
     */
    public function getFree()
    {
        return $this->where('is_active = ? AND is_paid = ?', [1, 0], $this->safeOrderBy('sort_order ASC, name ASC'));
    }

    /**
     * الحصول على القوالب المدفوعة النشطة
     */
    public function getPaid()
    {
        return $this->where('is_active = ? AND is_paid = ?', [1, 1], $this->safeOrderBy('sort_order ASC, name ASC'));
    }

    /**
     * الحصول على القوالب المميزة
     */
    public function getPremium()
    {
        return $this->where('is_active = ? AND is_premium = ?', [1, 1], $this->safeOrderBy('sort_order ASC, name ASC'));
    }

    /**
     * التحقق من وجود عمود في الجدول وترتيب بأمان
     */
    private function safeOrderBy($orderBy)
    {
        try {
            $columns = $this->db->query("SHOW COLUMNS FROM {$this->table}")->results();
            $colNames = array_map(function($col) { return $col->Field; }, $columns);
            
            // استخراج أسماء الأعمدة من ORDER BY
            $parts = explode(',', $orderBy);
            $safeParts = [];
            foreach ($parts as $part) {
                $part = trim($part);
                $tokens = preg_split('/\s+/', $part);
                $col = $tokens[0];
                $dir = strtoupper($tokens[1] ?? 'ASC');
                if (in_array($col, $colNames)) {
                    $safeParts[] = "{$col} {$dir}";
                }
            }
            if (!empty($safeParts)) {
                return implode(', ', $safeParts);
            }
        } catch (\Exception $e) {}
        return 'name ASC';
    }

    /**
     * تفعيل/تعطيل قالب
     */
    public function toggleActive($themeId)
    {
        $theme = $this->find($themeId);
        if (!$theme) return false;

        $newStatus = $theme->is_active ? 0 : 1;
        return $this->update($themeId, ['is_active' => $newStatus]);
    }

    /**
     * تعيين القالب كمدفوع/مجاني
     */
    public function setPaidStatus($themeId, $isPaid)
    {
        return $this->update($themeId, ['is_paid' => $isPaid ? 1 : 0]);
    }

    /**
     * تحديث معلومات التسعير للقالب المدفوع
     */
    public function updatePricing($themeId, $data)
    {
        $updateData = [];
        if (isset($data['price'])) $updateData['price'] = $data['price'];
        if (isset($data['currency'])) $updateData['currency'] = $data['currency'];
        if (isset($data['payment_link'])) $updateData['payment_link'] = $data['payment_link'];

        if (!empty($updateData)) {
            return $this->update($themeId, $updateData);
        }
        return false;
    }

    /**
     * الحصول على مسار القالب
     */
    public function getThemePath($slug)
    {
        return THEMES_PATH . '/' . $slug;
    }

    /**
     * التحقق من وجود القالب
     */
    public function themeExists($slug)
    {
        return is_dir($this->getThemePath($slug));
    }

    /**
     * الحصول على اسم القالب ثنائي اللغة
     */
    public function getLocalizedName($theme)
    {
        $lang = Language::current();
        if ($lang === 'en' && !empty($theme->name_en)) {
            return $theme->name_en;
        }
        return $theme->name;
    }

    /**
     * الحصول على وصف القالب ثنائي اللغة
     */
    public function getLocalizedDescription($theme)
    {
        $lang = Language::current();
        if ($lang === 'en' && !empty($theme->description_en)) {
            return $theme->description_en;
        }
        return $theme->description;
    }

    /**
     * التحقق مما إذا كان المستأجر يمتلك القالب (اشترى ثيم مدفوع وموافق عليه)
     */
    public function tenantOwnsTheme($tenantId, $themeId)
    {
        $db = Database::getInstance();
        $count = $db->query(
            "SELECT COUNT(*) as count FROM theme_requests 
             WHERE tenant_id = ? AND theme_id = ? AND status = 'approved'",
            [$tenantId, $themeId]
        )->first();

        return $count && $count->count > 0;
    }

    /**
     * التحقق مما إذا كان هناك طلب معلق لنفس القالب
     */
    public function hasPendingRequest($tenantId, $themeId)
    {
        $db = Database::getInstance();
        $count = $db->query(
            "SELECT COUNT(*) as count FROM theme_requests 
             WHERE tenant_id = ? AND theme_id = ? AND status = 'pending'",
            [$tenantId, $themeId]
        )->first();

        return $count && $count->count > 0;
    }

    /**
     * الحصول على القوالب الافتراضية (إذا لم تكن موجودة في قاعدة البيانات)
     */
    public function getDefaultThemes()
    {
        return [];
    }
}
