<?php
/**
 * CMS Platform - Router Class
 * كلاس التوجيه
 */

class Router
{
    private static $routes = [];
    private static $middlewares = [];
    private static $currentMiddleware = null;

    /**
     * إضافة مسار GET
     */
    public static function get($uri, $handler)
    {
        self::addRoute('GET', $uri, $handler);
    }

    /**
     * إضافة مسار POST
     */
    public static function post($uri, $handler)
    {
        self::addRoute('POST', $uri, $handler);
    }

    /**
     * إضافة مسار PUT
     */
    public static function put($uri, $handler)
    {
        self::addRoute('PUT', $uri, $handler);
    }

    /**
     * إضافة مسار DELETE
     */
    public static function delete($uri, $handler)
    {
        self::addRoute('DELETE', $uri, $handler);
    }

    /**
     * إضافة مسار لأي طريقة
     */
    public static function any($uri, $handler)
    {
        foreach (['GET', 'POST', 'PUT', 'DELETE'] as $method) {
            self::addRoute($method, $uri, $handler);
        }
    }

    /**
     * إضافة مجموعة مسارات
     */
    public static function group($options, $callback)
    {
        if (isset($options['middleware'])) {
            self::$currentMiddleware = $options['middleware'];
        }
        
        $callback();
        
        self::$currentMiddleware = null;
    }

    /**
     * إضافة مسار للمصادقة
     */
    public static function auth($uri, $handler)
    {
        self::$currentMiddleware = 'auth';
        self::addRoute('GET', $uri, $handler);
        self::$currentMiddleware = null;
    }

    /**
     * إضافة مسار للمدير
     */
    public static function admin($uri, $handler)
    {
        self::$currentMiddleware = 'admin';
        self::addRoute('GET', $uri, $handler);
        self::$currentMiddleware = null;
    }

    /**
     * إضافة مسار للقائمة
     */
    private static function addRoute($method, $uri, $handler)
    {
        // تنظيف URI
        $uri = '/' . trim($uri, '/');
        
        self::$routes[$method][$uri] = [
            'handler' => $handler,
            'middleware' => self::$currentMiddleware
        ];
    }

    /**
     * تنفيذ التوجيه
     */
    public static function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // إزالة المسار الأساسي - يتم تحديده تلقائياً
        // يمكن تعريفه في config.php أو استنتاجه من REQUEST_URI
        $basePath = defined('BASE_PATH') ? BASE_PATH : '';
        if (!empty($basePath) && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        
        $uri = $uri ?: '/';
        
        // التحقق من وجود المسار
        $route = self::matchRoute($method, $uri);
        
        if (!$route) {
            self::handle404();
            return;
        }
        
        // تنفيذ الـ middleware
        if ($route['middleware']) {
            if (!self::runMiddleware($route['middleware'])) {
                return;
            }
        }
        
        // تنفيذ الـ handler
        self::runHandler($route['handler'], $route['params'] ?? []);
    }

    /**
     * مطابقة المسار
     */
    private static function matchRoute($method, $uri)
    {
        if (!isset(self::$routes[$method])) {
            return null;
        }
        
        // تنظيف URI
        $uri = '/' . trim($uri, '/');
        
        // البحث عن تطابق مباشر
        if (isset(self::$routes[$method][$uri])) {
            return self::$routes[$method][$uri];
        }
        
        // ترتيب المسارات: المسارات الثابتة أولاً ثم الديناميكية
        $staticRoutes = [];
        $dynamicRoutes = [];
        
        foreach (self::$routes[$method] as $pattern => $route) {
            if (strpos($pattern, '{') !== false) {
                $dynamicRoutes[$pattern] = $route;
            } else {
                $staticRoutes[$pattern] = $route;
            }
        }
        
        // البحث في المسارات الثابتة أولاً
        foreach ($staticRoutes as $pattern => $route) {
            if ($pattern === $uri) {
                return $route;
            }
        }
        
        // البحث في المسارات الديناميكية
        foreach ($dynamicRoutes as $pattern => $route) {
            $params = self::matchPattern($pattern, $uri);
            if ($params !== false) {
                $route['params'] = $params;
                return $route;
            }
        }
        
        return null;
    }

    /**
     * مطابقة النمط
     */
    private static function matchPattern($pattern, $uri)
    {
        // تحويل النمط إلى regex
        $regex = preg_replace('/\{([a-zA-Z_]+)\}/', '([^/]+)', $pattern);
        $regex = '#^' . $regex . '$#';
        
        if (preg_match($regex, $uri, $matches)) {
            array_shift($matches);
            
            // استخراج أسماء المعاملات
            preg_match_all('/\{([a-zA-Z_]+)\}/', $pattern, $paramNames);
            
            $params = [];
            foreach ($paramNames[1] as $index => $name) {
                $params[$name] = $matches[$index] ?? null;
            }
            
            return $params;
        }
        
        return false;
    }

    /**
     * تنفيذ الـ middleware
     */
    private static function runMiddleware($middleware)
    {
        switch ($middleware) {
            case 'customer':
                // التحقق أولاً من تسجيل الدخول
                if (Auth::guest()) {
                    Session::error('يجب تسجيل الدخول أولاً');
                    header('Location: ' . SITE_URL . '/login');
                    exit;
                }
                // التحقق من أن المستخدم ليس مدير
                if (Auth::isAdmin()) {
                    Session::error('هذه الصفحة متاحة للعملاء فقط');
                    header('Location: ' . SITE_URL . '/admin');
                    exit;
                }
                // التحقق من تأكيد البريد الإلكتروني
                $user = Auth::user();
                if ($user && !$user->email_verified) {
                    Session::error('يجب تأكيد بريدك الإلكتروني أولاً للوصول للوحة التحكم');
                    header('Location: ' . SITE_URL . '/verification-pending?email=' . urlencode($user->email));
                    exit;
                }
                break;
                
            case 'auth':
                if (Auth::guest()) {
                    Session::error('يجب تسجيل الدخول أولاً');
                    header('Location: ' . SITE_URL . '/login');
                    exit;
                }
                break;
                
            case 'admin':
                // التحقق أولاً من تسجيل الدخول
                if (Auth::guest()) {
                    Session::error('يجب تسجيل الدخول أولاً');
                    header('Location: ' . SITE_URL . '/login');
                    exit;
                }
                // ثم التحقق من صلاحية المدير
                if (!Auth::isAdmin()) {
                    Session::error('ليس لديك صلاحية للوصول لهذه الصفحة');
                    header('Location: ' . SITE_URL . '/');
                    exit;
                }
                break;
                
            case 'subscription':
                if (!Auth::hasActiveSubscription()) {
                    Session::error('اشتراكك منتهي');
                    header('Location: ' . SITE_URL . '/subscription');
                    exit;
                }
                break;
        }
        
        return true;
    }

    /**
     * تنفيذ الـ handler
     */
    private static function runHandler($handler, $params = [])
    {
        try {
            if (is_callable($handler)) {
                call_user_func_array($handler, $params);
                return;
            }
            
            if (is_string($handler) && strpos($handler, '@') !== false) {
                list($controller, $method) = explode('@', $handler);
                
                $controllerFile = ROOT_PATH . '/app/controllers/' . $controller . '.php';
                
                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    
                    if (class_exists($controller)) {
                        $controllerInstance = new $controller();

                        if (method_exists($controllerInstance, $method)) {
                            call_user_func_array([$controllerInstance, $method], array_values($params));
                            return;
                        }
                    }
                }
            }
            
            self::handle500("Invalid handler: {$handler}");
        } catch (\Error $e) {
            error_log("Handler Fatal Error: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());
            error_log("Stack Trace: " . $e->getTraceAsString());
            self::handle500($e->getMessage());
        } catch (\Exception $e) {
            error_log("Handler Error: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());
            self::handle500($e->getMessage());
        }
    }

    /**
     * معالجة صفحة 404
     */
    private static function handle404()
    {
        http_response_code(404);
        
        $view = new View();
        $view->render('errors/404');
    }

    /**
     * معالجة صفحة 500
     */
    private static function handle500($message = 'Internal Server Error')
    {
        http_response_code(500);
        
        if (DEBUG_MODE) {
            echo "<h1>500 - Internal Server Error</h1>";
            echo "<p>" . htmlspecialchars($message) . "</p>";
        } else {
            try {
                $view = new View();
                $view->noLayout();
                $view->render('errors/500');
            } catch (\Throwable $e) {
                echo "<h1>500 - Server Error</h1><p>Please try again later.</p>";
            }
        }
    }

    /**
     * الحصول على الرابط الحالي
     */
    public static function currentUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * التحقق من المسار الحالي
     */
    public static function is($pattern)
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return strpos($uri, $pattern) !== false;
    }
}
