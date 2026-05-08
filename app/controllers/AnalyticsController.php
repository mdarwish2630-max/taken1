<?php
/**
 * CMS Platform - Analytics Controller
 * متحكم الإحصائيات
 */

class AnalyticsController extends Controller
{
    private $analyticsModel;
    private $tenantModel;

    public function __construct()
    {
        parent::__construct();
        $this->requireAuth();
        
        $this->view->setLayout('dashboard');
        
        require_once ROOT_PATH . '/app/models/Analytics.php';
        $this->analyticsModel = new Analytics();
        $this->tenantModel = $this->model('Tenant');
    }

    /**
     * لوحة الإحصائيات الرئيسية
     */
    public function index()
    {
        $tenant = Auth::tenant();
        $days = $this->input('days', 30);

        // الإحصائيات العامة
        $stats = $this->analyticsModel->getSiteStats($tenant->id, $days);
        
        // المشاهدات اليومية
        $dailyViews = $this->analyticsModel->getDailyViews($tenant->id, $days);
        
        // الصفحات الأكثر زيارة
        $topPages = $this->analyticsModel->getTopPages($tenant->id, 10, $days);
        
        // مصادر الزيارات
        $trafficSources = $this->analyticsModel->getTrafficSources($tenant->id, $days);
        
        // إحصائيات الأجهزة
        $deviceStats = $this->analyticsModel->getDeviceStats($tenant->id, $days);

        $this->view('dashboard/analytics', [
            'title' => __('analytics'),
            'tenant' => $tenant,
            'stats' => $stats,
            'daily_views' => $dailyViews,
            'top_pages' => $topPages,
            'traffic_sources' => $trafficSources,
            'device_stats' => $deviceStats,
            'days' => $days
        ]);
    }

    /**
     * تتبع زيارة (API للواجهة الأمامية)
     */
    public function track()
    {
        // [FIX-22] Rate Limiting لمنع Spam
        $clientIp = Security::getClientIp();
        if (!Security::rateLimit('analytics_track_' . $clientIp, 30, 1)) {
            $this->jsonError('Rate limit exceeded');
            return;
        }

        $tenantId = (int)$this->input('tenant_id');
        $pageUrl = $this->input('page_url');
        
        if (!$tenantId || !$pageUrl) {
            $this->jsonError('Missing data');
            return;
        }

        // [FIX-22] التحقق من صلاحية URL
        $parsedUrl = parse_url($pageUrl);
        if ($parsedUrl === false || !isset($parsedUrl['host'])) {
            $this->jsonError('Invalid URL');
            return;
        }

        // [FIX-22] تحديد طول البيانات لمنع Database Overflow
        $data = [
            'page_url' => mb_substr($pageUrl, 0, 2048),
            'page_title' => mb_substr($this->input('page_title'), 0, 500),
            'page_slug' => mb_substr($parsedUrl['path'] ?? '', 0, 255),
            'referrer' => mb_substr($this->input('referrer'), 0, 2048),
            'user_agent' => mb_substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500),
            'ip_address' => filter_var($_SERVER['REMOTE_ADDR'] ?? '', FILTER_VALIDATE_IP) ?: null,
            'session_id' => session_id(),
            'device_type' => $this->detectDevice($_SERVER['HTTP_USER_AGENT'] ?? ''),
            'browser' => $this->detectBrowser($_SERVER['HTTP_USER_AGENT'] ?? ''),
            'os' => $this->detectOS($_SERVER['HTTP_USER_AGENT'] ?? '')
        ];

        $this->analyticsModel->trackVisit($tenantId, $data);

        $this->jsonSuccess(['tracked' => true]);
    }

    /**
     * كشف نوع الجهاز
     */
    private function detectDevice($userAgent)
    {
        if (preg_match('/tablet|ipad/i', $userAgent)) return 'tablet';
        if (preg_match('/mobile|android|iphone/i', $userAgent)) return 'mobile';
        return 'desktop';
    }

    /**
     * كشف المتصفح
     */
    private function detectBrowser($userAgent)
    {
        if (preg_match('/chrome/i', $userAgent)) return 'Chrome';
        if (preg_match('/firefox/i', $userAgent)) return 'Firefox';
        if (preg_match('/safari/i', $userAgent)) return 'Safari';
        if (preg_match('/edge/i', $userAgent)) return 'Edge';
        return 'Other';
    }

    /**
     * كشف نظام التشغيل
     */
    private function detectOS($userAgent)
    {
        if (preg_match('/windows/i', $userAgent)) return 'Windows';
        if (preg_match('/mac/i', $userAgent)) return 'Mac OS';
        if (preg_match('/linux/i', $userAgent)) return 'Linux';
        if (preg_match('/android/i', $userAgent)) return 'Android';
        if (preg_match('/iphone|ipad/i', $userAgent)) return 'iOS';
        return 'Other';
    }
}
