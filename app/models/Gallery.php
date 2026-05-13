<?php
/**
 * CMS Platform - Gallery Model
 * نموذج معرض الصور
 */

class Gallery extends Model
{
    protected $table = 'gallery';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tenant_id', 'title', 'description', 'image', 'category',
        'display_order', 'status', 'title_en'
    ];

    /**
     * الحصول على صور موقع معين
     */
    public function getTenantGallery($tenantId, $status = null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE tenant_id = ?";
        $params = [$tenantId];
        
        if ($status) {
            $sql .= " AND status = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY display_order ASC, created_at DESC";
        
        return $this->db->query($sql, $params)->results();
    }

    /**
     * الحصول على الصور النشطة
     */
    public function getActiveGallery($tenantId, $limit = null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE tenant_id = ? AND status = 'active' ORDER BY display_order ASC";
        
        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }
        
        return $this->db->query($sql, [$tenantId])->results();
    }

    /**
     * الحصول على الصور حسب الفئة
     */
    public function getByCategory($tenantId, $category)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE tenant_id = ? AND category = ? AND status = 'active' ORDER BY display_order ASC",
            [$tenantId, $category]
        )->results();
    }

    /**
     * الحصول على الفئات المتاحة
     */
    public function getCategories($tenantId)
    {
        return $this->db->query(
            "SELECT DISTINCT category FROM {$this->table} WHERE tenant_id = ? AND category IS NOT NULL ORDER BY category ASC",
            [$tenantId]
        )->results();
    }

    /**
     * إنشاء صورة جديدة
     */
    public function createImage($data)
    {
        if (!isset($data['display_order'])) {
            $maxOrder = $this->db->query(
                "SELECT COALESCE(MAX(display_order), 0) as max_order FROM {$this->table} WHERE tenant_id = ?",
                [$data['tenant_id']]
            )->first()->max_order;
            
            $data['display_order'] = $maxOrder + 1;
        }
        
        return $this->create($data);
    }

    /**
     * عدد صور مستأجر
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
     * تبديل الحالة
     */
    public function toggleStatus($id)
    {
        $image = $this->find($id);
        
        if (!$image) {
            return false;
        }
        
        $newStatus = $image->status === 'active' ? 'inactive' : 'active';
        return $this->update($id, ['status' => $newStatus]);
    }

    /**
     * حذف صورة مع الملف
     */
    public function deleteWithFile($id)
    {
        $image = $this->find($id);
        
        if (!$image) {
            return false;
        }
        
        // حذف الملف
        if ($image->image) {
            $filePath = UPLOAD_PATH . '/' . $image->image;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        return $this->delete($id);
    }

    /**
     * رفع صور متعددة
     */
    public function uploadMultiple($tenantId, $files, $category = null)
    {
        $uploaded = [];
        
        foreach ($files['name'] as $key => $name) {
            if ($files['error'][$key] === UPLOAD_ERR_OK) {
                $file = [
                    'name' => $name,
                    'type' => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error' => $files['error'][$key],
                    'size' => $files['size'][$key]
                ];
                
                // التحقق من نوع الصورة (الامتداد + MIME)
                if (!Security::isAllowedImageType($name)) {
                    continue;
                }
                
                // التحقق من MIME type الفعلي
                $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $detectedMime = $finfo->file($file['tmp_name']);
                if (!in_array($detectedMime, $allowedMimes)) {
                    continue;
                }
                
                // التحقق من حجم الملف (5MB max)
                if ($file['size'] > 5 * 1024 * 1024) {
                    continue;
                }
                
                // إنشاء اسم آمن
                $filename = Security::generateSafeFilename($name);
                $uploadDir = UPLOAD_PATH . '/' . $tenantId . '/gallery';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $filepath = $uploadDir . '/' . $filename;
                
                if (move_uploaded_file($file['tmp_name'], $filepath)) {
                    $imageId = $this->createImage([
                        'tenant_id' => $tenantId,
                        'title' => pathinfo($name, PATHINFO_FILENAME),
                        'image' => $tenantId . '/gallery/' . $filename,
                        'category' => $category,
                        'status' => 'active'
                    ]);
                    
                    if ($imageId) {
                        $uploaded[] = $imageId;
                    }
                }
            }
        }
        
        return $uploaded;
    }
}
