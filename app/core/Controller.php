<?php
/**
 * CMS Platform - Base Controller Class
 * الكلاس الأساسي للمتحكمات
 */

abstract class Controller
{
    protected $view;
    protected $model;
    protected $layout = null;

    public function __construct()
    {
        $this->view = new View();
    }

    /**
     * تعيين الـ layout للمتحكم
     */
    protected function setLayout($layout)
    {
        $this->layout = $layout;
        $this->view->setLayout($layout);
        return $this;
    }

    /**
     * إلغاء الـ layout
     */
    protected function noLayout()
    {
        $this->layout = null;
        $this->view->noLayout();
        return $this;
    }

    /**
     * تحميل نموذج
     */
    protected function model($modelName)
    {
        $modelFile = ROOT_PATH . '/app/models/' . $modelName . '.php';
        
        if (file_exists($modelFile)) {
            require_once $modelFile;
            
            if (class_exists($modelName)) {
                return new $modelName();
            }
        }
        
        return null;
    }

    /**
     * عرض صفحة
     */
    protected function view($view, $data = [])
    {
        // تطبيق الـ layout المحفوظ إذا كان موجود
        if ($this->layout) {
            $this->view->setLayout($this->layout);
        }
        $this->view->render($view, $data);
    }

    /**
     * إعادة التوجيه
     */
    protected function redirect($url)
    {
        header('Location: ' . SITE_URL . $url);
        exit;
    }

    /**
     * إعادة التوجيه مع رسالة
     */
    protected function redirectWithMessage($url, $type, $message)
    {
        Session::flash($type, $message);
        $this->redirect($url);
    }

    /**
     * إعادة التوجيه للخلف
     */
    protected function back()
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? SITE_URL;
        // Validate referer is from our own site
        $parsed = parse_url($referer);
        $siteParsed = parse_url(SITE_URL);
        if ($parsed && isset($parsed['host']) && $parsed['host'] === $siteParsed['host']) {
            header('Location: ' . $referer);
        } else {
            header('Location: ' . SITE_URL);
        }
        exit;
    }

    /**
     * التحقق من تسجيل الدخول
     */
    protected function requireAuth()
    {
        if (Auth::guest()) {
            Session::error('يجب تسجيل الدخول أولاً');
            $this->redirect('/login');
        }
    }

    /**
     * التحقق من صلاحيات المدير
     */
    protected function requireAdmin()
    {
        $this->requireAuth();
        
        if (!Auth::isAdmin()) {
            Session::error('ليس لديك صلاحية للوصول لهذه الصفحة');
            $this->redirect('/');
        }
    }

    /**
     * التحقق من الاشتراك النشط
     */
    protected function requireActiveSubscription()
    {
        $this->requireAuth();
        
        if (!Auth::hasActiveSubscription()) {
            Session::error('اشتراكك منتهي. يرجى التجديد للمتابعة');
            $this->redirect('/subscription');
        }
    }

    /**
     * الحصول على البيانات المرسلة
     */
    protected function input($key = null, $default = null)
    {
        $data = array_merge($_GET, $_POST);
        
        if ($key === null) {
            return Security::sanitize($data);
        }
        
        return Security::sanitize($data[$key] ?? $default);
    }

    /**
     * التحقق من طلب AJAX
     */
    protected function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * إرسال استجابة JSON
     */
    protected function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * إرسال استجابة نجاح JSON
     */
    protected function jsonSuccess($data = [], $message = 'تم بنجاح')
    {
        $this->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * إرسال استجابة خطأ JSON
     */
    protected function jsonError($message = 'حدث خطأ', $errors = [], $statusCode = 400)
    {
        $this->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    /**
     * التحقق من رمز CSRF
     */
    protected function verifyCsrf()
    {
        $token = $this->input(CSRF_TOKEN_NAME);
        
        if (!Security::verifyCsrfToken($token)) {
            if ($this->isAjax()) {
                $this->jsonError('رمز الأمان غير صالح', [], 403);
            } else {
                Session::error('رمز الأمان غير صالح. يرجى المحاولة مرة أخرى');
                $this->back();
            }
        }
    }

    /**
     * التحقق من صحة البيانات
     */
    protected function validate($data, $rules)
    {
        $errors = [];
        
        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;
            
            foreach ($fieldRules as $rule) {
                $error = $this->validateRule($field, $value, $rule, $data);
                
                if ($error) {
                    $errors[$field] = $error;
                    break;
                }
            }
        }
        
        return $errors;
    }

    /**
     * التحقق من قاعدة واحدة
     */
    private function validateRule($field, $value, $rule, $data)
    {
        $fieldName = $this->getFieldName($field);
        
        // القاعدة بدون معاملات
        if ($rule === 'required') {
            if (empty($value) && $value !== '0') {
                return "حقل {$fieldName} مطلوب";
            }
        }
        
        // القاعدة مع معاملات
        if (strpos($rule, ':') !== false) {
            list($ruleName, $param) = explode(':', $rule, 2);
            
            switch ($ruleName) {
                case 'min':
                    if (strlen($value) < $param) {
                        return "حقل {$fieldName} يجب أن يكون على الأقل {$param} أحرف";
                    }
                    break;
                    
                case 'max':
                    if (strlen($value) > $param) {
                        return "حقل {$fieldName} يجب ألا يتجاوز {$param} حرف";
                    }
                    break;
                    
                case 'email':
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        return "حقل {$fieldName} يجب أن يكون بريد إلكتروني صحيح";
                    }
                    break;
                    
                case 'match':
                    if ($value !== ($data[$param] ?? '')) {
                        $matchField = $this->getFieldName($param);
                        return "حقل {$fieldName} يجب أن يطابق حقل {$matchField}";
                    }
                    break;
                    
                case 'unique':
                    $model = $this->model($param);
                    if ($model && $model->findBy($field, $value)) {
                        return "القيمة المدخلة في حقل {$fieldName} موجودة مسبقاً";
                    }
                    break;
            }
        }
        
        return null;
    }

    /**
     * الحصول على اسم الحقل بالعربية
     */
    private function getFieldName($field)
    {
        $names = [
            'email' => 'البريد الإلكتروني',
            'password' => 'كلمة المرور',
            'full_name' => 'الاسم الكامل',
            'site_name' => 'اسم الموقع',
            'slug' => 'الرابط',
            'phone' => 'رقم الهاتف',
            'title' => 'العنوان',
            'content' => 'المحتوى',
            'description' => 'الوصف',
        ];
        
        return $names[$field] ?? $field;
    }

    /**
     * رفع ملف
     */
    protected function uploadFile($file, $folder = '', $allowedTypes = null)
    {
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return ['error' => 'لم يتم اختيار ملف'];
        }
        
        // التحقق من الأخطاء
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['error' => 'حدث خطأ أثناء رفع الملف'];
        }
        
        // التحقق من الحجم
        if (!Security::isValidFileSize($file['size'])) {
            return ['error' => 'حجم الملف كبير جداً. الحد الأقصى ' . (MAX_UPLOAD_SIZE / 1024 / 1024) . 'MB'];
        }
        
        // التحقق من النوع
        if ($allowedTypes && !in_array(strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)), $allowedTypes)) {
            return ['error' => 'نوع الملف غير مسموح به'];
        }

        // Validate MIME type
        if ($allowedTypes && !empty($file['tmp_name'])) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($file['tmp_name']);
            $allowedMimes = [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'webp' => 'image/webp',
                'pdf' => 'application/pdf',
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ];
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (isset($allowedMimes[$extension]) && $mimeType !== $allowedMimes[$extension]) {
                return ['error' => 'نوع الملف غير مسموح به'];
            }
        }

        // إنشاء اسم آمن
        $filename = Security::generateSafeFilename($file['name']);
        
        // إنشاء المجلد
        $uploadDir = UPLOAD_PATH . '/' . $folder;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // نقل الملف
        $filepath = $uploadDir . '/' . $filename;
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return [
                'success' => true,
                'filename' => $filename,
                'path' => $folder . '/' . $filename,
                'full_path' => $filepath
            ];
        }
        
        return ['error' => 'فشل في حفظ الملف'];
    }

    /**
     * حذف ملف
     */
    protected function deleteFile($path)
    {
        $fullPath = UPLOAD_PATH . '/' . $path;
        
        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }
        
        return false;
    }
}
