<?php
/**
 * CMS Platform - View Class
 * كلاس عرض الصفحات
 */

class View
{
    protected $layout = 'main';
    protected $sections = [];
    protected $currentSection = null;

    /**
     * عرض صفحة
     */
    public function render($view, $data = [])
    {
        // استخراج البيانات للاستخدام في الـ view
        extract($data);
        
        // تحديد مسار ملف العرض
        $viewFile = ROOT_PATH . '/app/views/' . $view . '.php';
        
        if (!file_exists($viewFile)) {
            error_log("View file not found: {$viewFile}");
            echo "<h1>Error</h1><p>View file not found: " . htmlspecialchars($view) . "</p>";
            return;
        }
        
        // بدء التخزين المؤقت
        ob_start();
        
        try {
            // تضمين ملف العرض
            require $viewFile;
        } catch (\Exception $e) {
            ob_end_clean();
            error_log("View render error in {$view}: " . $e->getMessage());
            if (defined('DEBUG_MODE') && DEBUG_MODE) {
                echo "<h1>Error in view: {$view}</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
            } else {
                echo "<h1>Server Error</h1><p>An error occurred while loading this page.</p>";
            }
            return;
        } catch (\Error $e) {
            ob_end_clean();
            error_log("View Fatal Error in {$view}: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());
            if (defined('DEBUG_MODE') && DEBUG_MODE) {
                echo "<h1>Fatal Error in view: {$view}</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
            } else {
                echo "<h1>Server Error</h1><p>An error occurred while loading this page.</p>";
            }
            return;
        }
        
        // الحصول على المحتوى
        $content = ob_get_clean();
        
        // إذا كان هناك layout
        if ($this->layout) {
            $this->renderLayout($content, $data);
        } else {
            echo $content;
        }
    }

    /**
     * عرض الـ layout
     */
    protected function renderLayout($content, $data = [])
    {
        // حفظ المحتوى قبل extract عشان ما يتم الكتابة فوقه
        $yieldContent = $content;
        
        extract($data);
        
        $layoutFile = ROOT_PATH . '/app/views/layouts/' . $this->layout . '.php';
        
        if (!file_exists($layoutFile)) {
            error_log("Layout file not found: {$layoutFile}");
            echo $yieldContent;
            return;
        }
        
        try {
            require $layoutFile;
        } catch (\Exception $e) {
            error_log("Layout render error: " . $e->getMessage());
            echo $yieldContent;
        }
    }

    /**
     * تعيين الـ layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * إلغاء الـ layout
     */
    public function noLayout()
    {
        $this->layout = null;
        return $this;
    }

    /**
     * تضمين ملف جزئي
     */
    public function partial($partial, $data = [])
    {
        extract($data);
        
        $partialFile = ROOT_PATH . '/app/views/partials/' . $partial . '.php';
        
        if (file_exists($partialFile)) {
            require $partialFile;
        }
    }

    /**
     * بدء قسم
     */
    public function startSection($name)
    {
        $this->currentSection = $name;
        ob_start();
    }

    /**
     * إنهاء قسم
     */
    public function endSection()
    {
        if ($this->currentSection) {
            $this->sections[$this->currentSection] = ob_get_clean();
            $this->currentSection = null;
        }
    }

    /**
     * عرض قسم
     */
    public function yieldSection($name, $default = '')
    {
        return $this->sections[$name] ?? $default;
    }

    /**
     * إخراج قيمة بشكل آمن
     */
    public function e($value)
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }

    /**
     * إخراج محتوى بدون تنظيف
     */
    public function raw($value)
    {
        return $value;
    }

    /**
     * تضمين مورد (CSS/JS)
     */
    public function asset($path)
    {
        return SITE_URL . '/public/assets/' . $path;
    }

    /**
     * رفع صورة المستخدم
     */
    public function upload($path)
    {
        if (!$path) {
            return $this->asset('images/placeholder.png');
        }
        return SITE_URL . '/uploads/' . $path;
    }

    /**
     * الحصول على عنوان URL
     */
    public function url($path = '')
    {
        return SITE_URL . ($path ? '/' . ltrim($path, '/') : '');
    }

    /**
     * الحصول على URL الموقع الفرعي
     */
    public function siteUrl($slug, $path = '')
    {
        return SITE_URL . '/site/' . $slug . ($path ? '/' . ltrim($path, '/') : '');
    }

    /**
     * إنشاء رابط نشط
     */
    public function isActive($path)
    {
        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return strpos($currentPath, $path) === 0 ? 'active' : '';
    }

    /**
     * تنسيق التاريخ
     */
    public function formatDate($date, $format = 'd/m/Y')
    {
        if (!$date) return '';
        
        $timestamp = is_string($date) ? strtotime($date) : $date;
        return date($format, $timestamp);
    }

    /**
     * تنسيق التاريخ بالعربية
     */
    public function formatDateAr($date)
    {
        if (!$date) return '';
        
        $months = [
            1 => 'يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو',
            'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'
        ];
        
        $timestamp = is_string($date) ? strtotime($date) : $date;
        $day = date('d', $timestamp);
        $month = $months[(int)date('m', $timestamp)];
        $year = date('Y', $timestamp);
        
        return "{$day} {$month} {$year}";
    }

    /**
     * اقتطاع نص
     */
    public function truncate($text, $length = 100, $suffix = '...')
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        
        return substr($text, 0, $length) . $suffix;
    }

    /**
     * إنشاء حقل CSRF
     */
    public function csrf()
    {
        return Security::csrfField();
    }

    /**
     * عرض رسائل الفلاش
     */
    public function messages()
    {
        $messages = Session::getMessages();
        
        if (empty($messages)) {
            return '';
        }
        
        $html = '';
        foreach ($messages as $type => $message) {
            $alertClass = $this->getAlertClass($type);
            $icon = $this->getAlertIcon($type);
            
            $html .= <<<HTML
            <div class="alert {$alertClass} alert-dismissible fade show" role="alert">
                <i class="{$icon}"></i> {$this->e($message)}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
HTML;
        }
        
        return $html;
    }

    /**
     * الحصول على كلاس التنبيه
     */
    private function getAlertClass($type)
    {
        $classes = [
            'success' => 'alert-success',
            'error' => 'alert-danger',
            'warning' => 'alert-warning',
            'info' => 'alert-info',
        ];
        return $classes[$type] ?? 'alert-secondary';
    }

    /**
     * الحصول على أيقونة التنبيه
     */
    private function getAlertIcon($type)
    {
        $icons = [
            'success' => 'fas fa-check-circle',
            'error' => 'fas fa-exclamation-circle',
            'warning' => 'fas fa-exclamation-triangle',
            'info' => 'fas fa-info-circle',
        ];
        return $icons[$type] ?? 'fas fa-bell';
    }
}
