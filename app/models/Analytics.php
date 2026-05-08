<?php
/**
 * CMS Platform - Analytics Model
 * نموذج الإحصائيات والتحليلات
 */

class Analytics extends Model
{
    protected $table = 'analytics';
    protected $primaryKey = 'id';

    /**
     * تسجيل زيارة جديدة
     */
    public function trackVisit($tenantId, $data)
    {
        $visitorId = $this->generateVisitorId($data['ip_address'] ?? '', $data['user_agent'] ?? '');
        
        // تسجيل في جدول analytics
        $this->db->query(
            "INSERT INTO {$this->table} 
             (tenant_id, visitor_id, session_id, page_url, page_title, referrer, 
              user_agent, ip_address, country, city, device_type, browser, os)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $tenantId,
                $visitorId,
                $data['session_id'] ?? session_id(),
                $data['page_url'],
                $data['page_title'] ?? '',
                $data['referrer'] ?? null,
                $data['user_agent'] ?? null,
                $data['ip_address'] ?? null,
                $data['country'] ?? null,
                $data['city'] ?? null,
                $data['device_type'] ?? 'desktop',
                $data['browser'] ?? null,
                $data['os'] ?? null
            ]
        );

        // تحديث ملخص المشاهدات اليومية
        $this->updatePageViews($tenantId, $data['page_slug'] ?? '', $visitorId);

        return true;
    }

    /**
     * تحديث ملخص المشاهدات
     */
    private function updatePageViews($tenantId, $pageSlug, $visitorId)
    {
        $today = date('Y-m-d');
        
        // التحقق من وجود سجل اليوم
        $existing = $this->db->query(
            "SELECT id FROM page_views 
             WHERE tenant_id = ? AND page_slug = ? AND view_date = ?",
            [$tenantId, $pageSlug, $today]
        )->first();

        if ($existing) {
            // تحديث السجل
            $this->db->query(
                "UPDATE page_views 
                 SET views = views + 1 
                 WHERE id = ?",
                [$existing->id]
            );
        } else {
            // إنشاء سجل جديد
            $this->db->query(
                "INSERT INTO page_views (tenant_id, page_slug, view_date, views, unique_visitors) 
                 VALUES (?, ?, ?, 1, 1)",
                [$tenantId, $pageSlug, $today]
            );
        }
    }

    /**
     * توليد معرف زائر مجهول
     */
    private function generateVisitorId($ip, $userAgent)
    {
        return hash('sha256', $ip . $userAgent . date('Y-m'));
    }

    /**
     * الحصول على إحصائيات الموقع
     */
    public function getSiteStats($tenantId, $days = 30)
    {
        // إجمالي المشاهدات
        $totalViews = $this->db->query(
            "SELECT COUNT(*) as count FROM {$this->table} 
             WHERE tenant_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)",
            [$tenantId, $days]
        )->first()->count;

        // الزوار الفريدين
        $uniqueVisitors = $this->db->query(
            "SELECT COUNT(DISTINCT visitor_id) as count FROM {$this->table} 
             WHERE tenant_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)",
            [$tenantId, $days]
        )->first()->count;

        // متوسط مدة الجلسة
        $avgTime = $this->db->query(
            "SELECT AVG(time_spent) as avg_time FROM {$this->table} 
             WHERE tenant_id = ? AND time_spent > 0 
             AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)",
            [$tenantId, $days]
        )->first()->avg_time ?? 0;

        // معدل الارتداد (صفحة واحدة فقط)
        $bounceRate = $this->db->query(
            "SELECT 
                (SELECT COUNT(*) FROM (
                    SELECT visitor_id FROM {$this->table} 
                    WHERE tenant_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
                    GROUP BY visitor_id HAVING COUNT(*) = 1
                ) as bounced) / 
                (SELECT COUNT(DISTINCT visitor_id) FROM {$this->table} 
                 WHERE tenant_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)) * 100 as rate",
            [$tenantId, $days, $tenantId, $days]
        )->first()->rate ?? 0;

        return [
            'total_views' => $totalViews,
            'unique_visitors' => $uniqueVisitors,
            'avg_time' => round($avgTime, 1),
            'bounce_rate' => round($bounceRate, 1)
        ];
    }

    /**
     * الحصول على المشاهدات اليومية
     */
    public function getDailyViews($tenantId, $days = 30)
    {
        return $this->db->query(
            "SELECT view_date, SUM(views) as views, SUM(unique_visitors) as visitors
             FROM page_views 
             WHERE tenant_id = ? AND view_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
             GROUP BY view_date 
             ORDER BY view_date ASC",
            [$tenantId, $days]
        )->results();
    }

    /**
     * الصفحات الأكثر زيارة
     */
    public function getTopPages($tenantId, $limit = 10, $days = 30)
    {
        return $this->db->query(
            "SELECT page_url, page_title, COUNT(*) as views
             FROM {$this->table} 
             WHERE tenant_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
             GROUP BY page_url, page_title
             ORDER BY views DESC
             LIMIT {$limit}",
            [$tenantId, $days]
        )->results();
    }

    /**
     * مصادر الزيارات
     */
    public function getTrafficSources($tenantId, $days = 30)
    {
        return $this->db->query(
            "SELECT 
                CASE 
                    WHEN referrer IS NULL OR referrer = '' THEN 'direct'
                    WHEN referrer LIKE '%google%' THEN 'google'
                    WHEN referrer LIKE '%facebook%' THEN 'facebook'
                    WHEN referrer LIKE '%twitter%' THEN 'twitter'
                    WHEN referrer LIKE '%instagram%' THEN 'instagram'
                    ELSE 'other'
                END as source,
                COUNT(*) as count
             FROM {$this->table} 
             WHERE tenant_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
             GROUP BY source
             ORDER BY count DESC",
            [$tenantId, $days]
        )->results();
    }

    /**
     * الأجهزة والمتصفحات
     */
    public function getDeviceStats($tenantId, $days = 30)
    {
        // توزيع الأجهزة
        $devices = $this->db->query(
            "SELECT device_type, COUNT(*) as count
             FROM {$this->table} 
             WHERE tenant_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
             GROUP BY device_type
             ORDER BY count DESC",
            [$tenantId, $days]
        )->results();

        // توزيع المتصفحات
        $browsers = $this->db->query(
            "SELECT browser, COUNT(*) as count
             FROM {$this->table} 
             WHERE tenant_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
             AND browser IS NOT NULL
             GROUP BY browser
             ORDER BY count DESC
             LIMIT 5",
            [$tenantId, $days]
        )->results();

        // توزيع أنظمة التشغيل
        $os = $this->db->query(
            "SELECT os, COUNT(*) as count
             FROM {$this->table} 
             WHERE tenant_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
             AND os IS NOT NULL
             GROUP BY os
             ORDER BY count DESC
             LIMIT 5",
            [$tenantId, $days]
        )->results();

        return [
            'devices' => $devices,
            'browsers' => $browsers,
            'os' => $os
        ];
    }

    /**
     * الدول والمدن
     */
    public function getLocationStats($tenantId, $days = 30)
    {
        return $this->db->query(
            "SELECT country, city, COUNT(*) as count
             FROM {$this->table} 
             WHERE tenant_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
             AND country IS NOT NULL
             GROUP BY country, city
             ORDER BY count DESC
             LIMIT 10",
            [$tenantId, $days]
        )->results();
    }

    /**
     * تنظيف البيانات القديمة
     */
    public function cleanOldData($daysOld = 365)
    {
        return $this->db->query(
            "DELETE FROM {$this->table} 
             WHERE created_at < DATE_SUB(NOW(), INTERVAL ? DAY)",
            [$daysOld]
        );
    }

    /**
     * تحديث وقت البقاء في الصفحة
     */
    public function updateTimeSpent($sessionId, $pageUrl, $timeSpent)
    {
        return $this->db->query(
            "UPDATE {$this->table} 
             SET time_spent = ? 
             WHERE session_id = ? AND page_url = ?
             ORDER BY created_at DESC LIMIT 1",
            [$timeSpent, $sessionId, $pageUrl]
        );
    }
}
