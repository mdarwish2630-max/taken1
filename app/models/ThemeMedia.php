<?php
/**
 * CMS Platform - Theme Media Model
 * نموذج وسائط القوالب - صور، بنرات، شعارات
 * يتيح للأدمن رفع وإدارة الوسائط لكل ثيم
 */

class ThemeMedia extends Model
{
    protected $table = 'theme_media';
    protected $primaryKey = 'id';
    protected $fillable = [
        'theme_id', 'media_type', 'file_path', 'file_name',
        'alt_text_ar', 'alt_text_en', 'section_ref',
        'sort_order', 'is_active'
    ];

    /** أنواع الوسائط المدعومة */
    const MEDIA_TYPES = [
        'logo' => 'شعار',
        'banner' => 'بانر',
        'service_icon' => 'أيقونة خدمة',
        'gallery' => 'معرض صور',
        'favicon' => 'أيقونة الموقع',
        'og_image' => 'صورة المشاركة',
    ];

    const SECTION_REFS = [
        'hero' => 'البانر الرئيسي',
        'about' => 'عن الثيم',
        'services' => 'الخدمات',
        'testimonials' => 'آراء العملاء',
        'contact' => 'تواصل',
        'footer' => 'التذييل',
        'general' => 'عام',
    ];

    /**
     * الحصول على كل وسائط ثيم معين
     */
    public function getThemeMedia($themeId, $mediaType = null)
    {
        $conditions = 'theme_id = ? AND is_active = 1';
        $params = [$themeId];

        if ($mediaType) {
            $conditions .= ' AND media_type = ?';
            $params[] = $mediaType;
        }

        return $this->where($conditions, $params, 'media_type ASC, sort_order ASC');
    }

    /**
     * الحصول على وسائط مجمّعة حسب النوع
     */
    public function getThemeMediaGrouped($themeId)
    {
        $allMedia = $this->getThemeMedia($themeId);
        
        $grouped = [];
        foreach ($allMedia as $media) {
            $type = $media->media_type;
            if (!isset($grouped[$type])) {
                $grouped[$type] = [];
            }
            $grouped[$type][] = $media;
        }
        
        return $grouped;
    }

    /**
     * الحصول على وسائط نوع معين
     */
    public function getByType($themeId, $mediaType)
    {
        return $this->getThemeMedia($themeId, $mediaType);
    }

    /**
     * الحصول على الشعار
     */
    public function getLogo($themeId)
    {
        $result = $this->db->query(
            "SELECT * FROM {$this->table} 
             WHERE theme_id = ? AND media_type = 'logo' AND is_active = 1
             ORDER BY sort_order ASC LIMIT 1",
            [$themeId]
        )->first();
        return $result;
    }

    /**
     * الحصول على البانر
     */
    public function getBanner($themeId)
    {
        $result = $this->db->query(
            "SELECT * FROM {$this->table} 
             WHERE theme_id = ? AND media_type = 'banner' AND is_active = 1
             ORDER BY sort_order ASC LIMIT 1",
            [$themeId]
        )->first();
        return $result;
    }

    /**
     * الحصول على معرض صور ثيم
     */
    public function getGallery($themeId)
    {
        return $this->getByType($themeId, 'gallery');
    }

    /**
     * إضافة وسيط جديد
     */
    public function addMedia($data)
    {
        $data['is_active'] = 1;
        
        // ترتيب تلقائي
        $maxOrder = $this->db->query(
            "SELECT COALESCE(MAX(sort_order), 0) + 1 as next_order 
             FROM {$this->table} 
             WHERE theme_id = ? AND media_type = ?",
            [$data['theme_id'], $data['media_type']]
        )->first();

        $data['sort_order'] = $maxOrder ? (int)$maxOrder->next_order : 1;

        return $this->create($data);
    }

    /**
     * تحديث وسيط
     */
    public function updateMedia($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * حذف وسيط مع حذف الملف
     */
    public function deleteMedia($id)
    {
        $media = $this->find($id);
        if (!$media) return false;

        // حذف الملف من القرص
        if ($media->file_path) {
            $fullPath = UPLOAD_PATH . '/' . $media->file_path;
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }

        return $this->delete($id);
    }

    /**
     * حذف كل وسائط ثيم معين (عند حذف الثيم)
     */
    public function deleteAllThemeMedia($themeId)
    {
        $mediaItems = $this->getThemeMedia($themeId);
        foreach ($mediaItems as $media) {
            if ($media->file_path) {
                $fullPath = UPLOAD_PATH . '/' . $media->file_path;
                if (file_exists($fullPath)) {
                    @unlink($fullPath);
                }
            }
        }
        return $this->db->query(
            "DELETE FROM {$this->table} WHERE theme_id = ?",
            [$themeId]
        );
    }

    /**
     * نسخ وسائط ثيم إلى مستأجر (عند تفعيل الثيم)
     * يتم نسخ الملفات الفعلية وإنشاء سجلات جديدة
     */
    public function copyMediaToTenant($themeId, $tenantId)
    {
        $mediaItems = $this->getThemeMedia($themeId);
        if (empty($mediaItems)) return true;

        try {
            foreach ($mediaItems as $media) {
                // نسخ الملف الفعلي
                $sourcePath = UPLOAD_PATH . '/' . $media->file_path;
                if (file_exists($sourcePath)) {
                    // إنشاء اسم ملف جديد للمستأجر
                    $ext = pathinfo($media->file_path, PATHINFO_EXTENSION);
                    $newFileName = 'tenant_' . $tenantId . '_' . $media->media_type . '_' . time() . '_' . rand(100, 999) . '.' . $ext;
                    $destFolder = UPLOAD_PATH . '/' . $media->media_type;
                    
                    if (!is_dir($destFolder)) {
                        mkdir($destFolder, 0755, true);
                    }
                    
                    $destPath = $destFolder . '/' . $newFileName;
                    
                    if (copy($sourcePath, $destPath)) {
                        // تحديث مسار الشعار/البانر للمستأجر
                        $newPath = $media->media_type . '/' . $newFileName;
                        
                        if ($media->media_type === 'logo') {
                            $this->db->query(
                                "UPDATE tenants SET logo = ? WHERE id = ?",
                                [$newPath, $tenantId]
                            );
                        } elseif ($media->media_type === 'banner') {
                            // ربط البانر بالخدمة/الموقع
                        }
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            error_log("Copy media to tenant error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * عدد وسائط ثيم معين
     */
    public function countMedia($themeId)
    {
        return $this->count('theme_id = ? AND is_active = 1', [$themeId]);
    }

    /**
     * عدد وسائط لكل نوع
     */
    public function getMediaTypeCounts($themeId)
    {
        $result = $this->db->query(
            "SELECT media_type, COUNT(*) as count FROM {$this->table} 
             WHERE theme_id = ? AND is_active = 1
             GROUP BY media_type",
            [$themeId]
        )->results();
        
        $counts = [];
        foreach ($result as $row) {
            $counts[$row->media_type] = (int)$row->count;
        }
        return $counts;
    }
}
