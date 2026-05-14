<?php
/**
 * CMS Platform - Image Handler Helper
 * معالج الصور - رفع وحذف وتغيير حجم الصور
 */

class ImageHandler
{
    private $uploadPath;
    private $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    private $maxSize = 5242880; // 5MB

    public function __construct()
    {
        $this->uploadPath = UPLOAD_PATH;
    }

    /**
     * رفع صورة
     */
    public function upload($file, $subdir = '')
    {
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'لم يتم اختيار ملف صالح'];
        }

        if ($file['size'] > $this->maxSize) {
            return ['success' => false, 'error' => 'حجم الملف يتجاوز الحد المسموح (5MB)'];
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $this->allowedTypes)) {
            return ['success' => false, 'error' => 'نوع الملف غير مسموح. الأنواع المسموحة: ' . implode(', ', $this->allowedTypes)];
        }

        // التحقق من MIME type
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, $allowedMimes)) {
            return ['success' => false, 'error' => 'نوع الملف غير مسموح'];
        }

        $dir = $this->uploadPath;
        if ($subdir) {
            // [SEC-FIX-19] Sanitize subdir to prevent path traversal
            $subdir = preg_replace('#[^a-zA-Z0-9_/]#', '', trim($subdir, '/'));
            $dir .= '/' . $subdir;
        }
        // [SEC-FIX-19] Ensure resolved path is within upload directory
        $realDir = realpath($dir);
        $realUploadPath = realpath($this->uploadPath);
        if ($realUploadPath && ($realDir === false || strpos($realDir, $realUploadPath) !== 0)) {
            return ['success' => false, 'error' => 'مسار الرفع غير صالح'];
        }

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = $this->generateFilename($ext);
        $filepath = $dir . '/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            $relativePath = $subdir ? $subdir . '/' . $filename : $filename;
            return [
                'success' => true,
                'filename' => $relativePath,
                'filepath' => $filepath,
                'full_path' => $relativePath
            ];
        }

        return ['success' => false, 'error' => 'فشل في رفع الملف'];
    }

    /**
     * حذف صورة
     */
    public function delete($path)
    {
        if (empty($path)) return false;

        // [SEC-FIX-19] Prevent path traversal in delete
        $path = str_replace(['../', '..\\'], '', $path);
        $filepath = $this->uploadPath . '/' . ltrim($path, '/');
        $realPath = realpath($filepath);
        $realUploadPath = realpath($this->uploadPath);

        if ($realPath === false || $realUploadPath === false) {
            return false;
        }
        if (strpos($realPath, $realUploadPath) !== 0) {
            return false;
        }

        if (is_file($realPath)) {
            return unlink($realPath);
        }

        return false;
    }

    /**
     * تغيير حجم الصورة
     */
    public function resize($filepath, $maxWidth, $maxHeight, $quality = 85)
    {
        if (!file_exists($filepath)) return false;

        $info = getimagesize($filepath);
        if (!$info) return false;

        $width = $info[0];
        $height = $info[1];
        $type = $info[2];

        // حساب الأبعاد الجديدة مع الحفاظ على النسبة
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        if ($ratio >= 1) return true; // الصورة أصغر من الحد

        $newWidth = (int)($width * $ratio);
        $newHeight = (int)($height * $ratio);

        $canvas = imagecreatetruecolor($newWidth, $newHeight);

        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($filepath);
                imagecopyresampled($canvas, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagejpeg($canvas, $filepath, $quality);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($filepath);
                imagealphablending($canvas, false);
                imagesavealpha($canvas, true);
                imagecopyresampled($canvas, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagepng($canvas, $filepath, 9);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($filepath);
                imagecopyresampled($canvas, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagegif($canvas, $filepath);
                break;
            case IMAGETYPE_WEBP:
                if (function_exists('imagewebp')) {
                    $source = imagecreatefromwebp($filepath);
                    imagecopyresampled($canvas, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                    imagewebp($canvas, $filepath, $quality);
                }
                break;
            default:
                imagedestroy($canvas);
                return false;
        }

        imagedestroy($canvas);
        if (isset($source)) imagedestroy($source);

        return true;
    }

    /**
     * توليد اسم ملف فريد
     */
    private function generateFilename($ext)
    {
        return date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    }
}
