<?php
/**
 * CMS Platform - Theme Content Model
 * نموذج محتوى القوالب - نصوص وأقسام قابلة للتخصيص من الأدمن
 * يتيح للأدمن تعديل محتوى كل ثيم (عناوين، وصف، خدمات، آراء عملاء...)
 */

class ThemeContent extends Model
{
    protected $table = 'theme_contents';
    protected $primaryKey = 'id';
    protected $fillable = [
        'theme_id', 'section_type', 'content_key',
        'content_ar', 'content_en',
        'sort_order', 'is_active'
    ];

    /**
     * الحصول على كل محتوى ثيم معين (مجمّع حسب القسم)
     */
    public function getThemeContent($themeId)
    {
        $rows = $this->where('theme_id = ? AND is_active = ?', [$themeId, 1], 'section_type ASC, sort_order ASC');
        
        $content = [];
        foreach ($rows as $row) {
            $section = $row->section_type;
            if (!isset($content[$section])) {
                $content[$section] = [];
            }
            $content[$section][$row->content_key] = $row;
        }
        
        return $content;
    }

    /**
     * الحصول على محتوى قسم معين من ثيم
     */
    public function getSectionContent($themeId, $sectionType)
    {
        return $this->where(
            'theme_id = ? AND section_type = ? AND is_active = ?',
            [$themeId, $sectionType, 1],
            'sort_order ASC'
        );
    }

    /**
     * الحصول على قيمة محتوى واحدة
     */
    public function getContentValue($themeId, $sectionType, $contentKey, $lang = 'ar')
    {
        $row = $this->db->query(
            "SELECT * FROM {$this->table} 
             WHERE theme_id = ? AND section_type = ? AND content_key = ? AND is_active = 1
             LIMIT 1",
            [$themeId, $sectionType, $contentKey]
        )->first();

        if (!$row) return null;

        $field = $lang === 'en' ? 'content_en' : 'content_ar';
        return $row->$field;
    }

    /**
     * حفظ/تحديث محتوى ثيم (معاملة واحدة لكل الأقسام)
     */
    public function saveThemeContent($themeId, $sectionsData)
    {
        try {
            foreach ($sectionsData as $sectionType => $items) {
                foreach ($items as $contentKey => $data) {
                    // البحث عن سجل موجود
                    $existing = $this->db->query(
                        "SELECT id FROM {$this->table} 
                         WHERE theme_id = ? AND section_type = ? AND content_key = ?
                         LIMIT 1",
                        [$themeId, $sectionType, $contentKey]
                    )->first();

                    $saveData = [
                        'theme_id' => $themeId,
                        'section_type' => $sectionType,
                        'content_key' => $contentKey,
                        'content_ar' => $data['content_ar'] ?? null,
                        'content_en' => $data['content_en'] ?? null,
                        'is_active' => 1,
                    ];

                    if (isset($data['sort_order'])) {
                        $saveData['sort_order'] = (int)$data['sort_order'];
                    }

                    if ($existing) {
                        $this->update($existing->id, $saveData);
                    } else {
                        $this->create($saveData);
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            error_log("Save theme content error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * حذف محتوى قسم معين
     */
    public function deleteSectionContent($themeId, $sectionType, $contentKey = null)
    {
        if ($contentKey) {
            return $this->db->query(
                "DELETE FROM {$this->table} WHERE theme_id = ? AND section_type = ? AND content_key = ?",
                [$themeId, $sectionType, $contentKey]
            );
        }
        return $this->db->query(
            "DELETE FROM {$this->table} WHERE theme_id = ? AND section_type = ?",
            [$themeId, $sectionType]
        );
    }

    /**
     * نسخ محتوى ثيم إلى مستأجر (للبيانات التجريبية)
     * يُستدعى عند تفعيل الثيم للعميل أو عند استيراد البيانات التجريبية
     */
    public function copyContentToTenant($themeId, $tenantId)
    {
        $content = $this->getThemeContent($themeId);
        if (empty($content)) return false;

        try {
            // استيراد الخدمات
            if (!empty($content['services'])) {
                require_once ROOT_PATH . '/app/models/Service.php';
                $serviceModel = new Service();
                $index = 0;
                
                foreach ($content['services'] as $key => $item) {
                    $jsonData = json_decode($item->content_ar, true);
                    if (!$jsonData) continue;
                    
                    $serviceModel->createService([
                        'tenant_id' => $tenantId,
                        'title' => $jsonData['title_ar'] ?? '',
                        'description' => $jsonData['description_ar'] ?? '',
                        'icon' => $jsonData['icon'] ?? 'fas fa-star',
                        'show_on_home' => $jsonData['show_on_home'] ?? 1,
                        'display_order' => $index + 1,
                        'status' => 'active'
                    ]);
                    $index++;
                }
            }

            // استيراد آراء العملاء
            if (!empty($content['testimonials'])) {
                require_once ROOT_PATH . '/app/models/Testimonial.php';
                $testimonialModel = new Testimonial();
                
                foreach ($content['testimonials'] as $key => $item) {
                    $jsonData = json_decode($item->content_ar, true);
                    if (!$jsonData) continue;
                    
                    $testimonialModel->createTestimonial([
                        'tenant_id' => $tenantId,
                        'client_name' => $jsonData['client_name'] ?? '',
                        'client_title' => $jsonData['client_title'] ?? '',
                        'content' => $jsonData['content'] ?? '',
                        'rating' => $jsonData['rating'] ?? 5,
                        'show_on_home' => 1,
                        'status' => 'active'
                    ]);
                }
            }

            // استيراد البانر الرئيسي
            if (!empty($content['hero'])) {
                require_once ROOT_PATH . '/app/models/Banner.php';
                $bannerModel = new Banner();
                
                $heroData = [];
                foreach ($content['hero'] as $key => $item) {
                    $heroData[$key] = $item->content_ar;
                }
                
                if (!empty($heroData)) {
                    $bannerModel->createBanner([
                        'tenant_id' => $tenantId,
                        'title' => $heroData['hero_title'] ?? '',
                        'subtitle' => $heroData['hero_subtitle'] ?? '',
                        'description' => $heroData['hero_description'] ?? '',
                        'position' => 'hero',
                        'button_text' => $heroData['hero_button_text'] ?? '',
                        'status' => 'active'
                    ]);
                }
            }

            // استيراد معلومات التواصل
            if (!empty($content['contact'])) {
                foreach ($content['contact'] as $key => $item) {
                    $jsonData = json_decode($item->content_ar, true);
                    if (!$jsonData) continue;
                    
                    $tenantUpdate = [];
                    if (!empty($jsonData['phone'])) $tenantUpdate['phone'] = $jsonData['phone'];
                    if (!empty($jsonData['email'])) $tenantUpdate['email'] = $jsonData['email'];
                    if (!empty($jsonData['address'])) $tenantUpdate['address'] = $jsonData['address'];
                    if (!empty($jsonData['whatsapp'])) $tenantUpdate['whatsapp'] = $jsonData['whatsapp'];
                    
                    if (!empty($tenantUpdate)) {
                        require_once ROOT_PATH . '/app/models/Tenant.php';
                        $tenantModel = new Tenant();
                        $tenantModel->update($tenantId, $tenantUpdate);
                    }
                    break; // فقط أول سجل
                }
            }

            return true;
        } catch (Exception $e) {
            error_log("Copy content to tenant error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * الحصول على المحتوى بصيغة JSON للاستخدام في واجهة الأدمن
     */
    public function getContentForEditor($themeId)
    {
        $content = $this->getThemeContent($themeId);
        
        $editorData = [];
        foreach ($content as $sectionType => $items) {
            $editorData[$sectionType] = [];
            foreach ($items as $contentKey => $item) {
                $value_ar = $item->content_ar;
                $value_en = $item->content_en;
                
                // محاولة فك JSON
                $decoded = json_decode($value_ar, true);
                
                $editorData[$sectionType][$contentKey] = [
                    'id' => $item->id,
                    'content_ar' => $value_ar,
                    'content_en' => $value_en,
                    'sort_order' => $item->sort_order,
                    'is_json' => ($decoded !== null && json_last_error() === JSON_ERROR_NONE),
                    'decoded' => $decoded
                ];
            }
        }
        
        return $editorData;
    }

    /**
     * عدد أقسام المحتوى لثيم معين
     */
    public function countSections($themeId)
    {
        $result = $this->db->query(
            "SELECT COUNT(DISTINCT section_type) as count FROM {$this->table} 
             WHERE theme_id = ? AND is_active = 1",
            [$themeId]
        )->first();
        
        return $result ? (int)$result->count : 0;
    }

    /**
     * الحصول على عدد العناصر لكل قسم
     */
    public function getSectionCounts($themeId)
    {
        $result = $this->db->query(
            "SELECT section_type, COUNT(*) as count FROM {$this->table} 
             WHERE theme_id = ? AND is_active = 1
             GROUP BY section_type",
            [$themeId]
        )->results();
        
        $counts = [];
        foreach ($result as $row) {
            $counts[$row->section_type] = (int)$row->count;
        }
        return $counts;
    }
}
