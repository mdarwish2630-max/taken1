<?php
/**
 * CMS Platform - Notification Model
 * نموذج الإشعارات
 */

class Notification extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';

    /**
     * إنشاء إشعار جديد
     */
    public function add($userId, $type, $title, $message, $link = null, $data = null)
    {
        return $this->db->query(
            "INSERT INTO {$this->table} (user_id, type, title, message, link, data, is_read, created_at)
             VALUES (?, ?, ?, ?, ?, ?, 0, NOW())",
            [
                $userId,
                $type,
                $title,
                $message,
                $link,
                $data ? json_encode($data) : null
            ]
        )->lastInsertId();
    }

    /**
     * الحصول على إشعارات المستخدم
     */
    public function getUserNotifications($userId, $limit = 20, $offset = 0)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table}
             WHERE user_id = ?
             ORDER BY is_read ASC, created_at DESC
             LIMIT ? OFFSET ?",
            [$userId, $limit, $offset]
        )->results();
    }

    /**
     * الحصول على الإشعارات غير المقروءة
     */
    public function getUnreadCount($userId)
    {
        $result = $this->db->query(
            "SELECT COUNT(*) as count FROM {$this->table}
             WHERE user_id = ? AND is_read = 0",
            [$userId]
        )->first();

        return $result ? (int)$result->count : 0;
    }

    /**
     * الحصول على آخر الإشعارات (للعرض في الهيدر)
     */
    public function getRecentNotifications($userId, $limit = 5)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table}
             WHERE user_id = ?
             ORDER BY created_at DESC
             LIMIT ?",
            [$userId, $limit]
        )->results();
    }

    /**
     * تحديد إشعار كمقروء
     */
    public function markAsRead($notificationId, $userId)
    {
        return $this->db->query(
            "UPDATE {$this->table} SET is_read = 1 WHERE id = ? AND user_id = ?",
            [$notificationId, $userId]
        )->count() > 0;
    }

    /**
     * تحديد كل الإشعارات كمقروءة
     */
    public function markAllAsRead($userId)
    {
        return $this->db->query(
            "UPDATE {$this->table} SET is_read = 1 WHERE user_id = ? AND is_read = 0",
            [$userId]
        )->count();
    }

    /**
     * حذف إشعار
     */
    public function deleteNotification($notificationId, $userId)
    {
        return $this->db->query(
            "DELETE FROM {$this->table} WHERE id = ? AND user_id = ?",
            [$notificationId, $userId]
        )->count() > 0;
    }

    /**
     * حذف الإشعارات القديمة (أقدم من X يوم)
     */
    public function cleanOldNotifications($daysOld = 90)
    {
        return $this->db->query(
            "DELETE FROM {$this->table}
             WHERE created_at < DATE_SUB(NOW(), INTERVAL ? DAY)",
            [$daysOld]
        )->count();
    }

    /**
     * إنشاء إشعار اشتراك جديد
     */
    public function notifySubscriptionCreated($userId, $planName, $link = null)
    {
        $title = 'اشتراك جديد';
        $message = "تم إنشاء اشتراك جديد بخطة \"{$planName}\" بنجاح";
        return $this->add($userId, 'subscription', $title, $message, $link);
    }

    /**
     * إنشاء إشعار قبول طلب الاشتراك
     */
    public function notifySubscriptionApproved($userId, $planName, $link = null)
    {
        $title = 'تم قبول طلب الاشتراك';
        $message = "تم قبول طلب الاشتراك بخطة \"{$planName}\". موقعك الآن نشط";
        return $this->add($userId, 'subscription', $title, $message, $link);
    }

    /**
     * إنشاء إشعار رفض طلب الاشتراك
     */
    public function notifySubscriptionRejected($userId, $planName, $adminNotes = null, $link = null)
    {
        $title = 'تم رفض طلب الاشتراك';
        $message = "تم رفض طلب الاشتراك بخطة \"{$planName}\"";
        if ($adminNotes) {
            $message .= ". السبب: {$adminNotes}";
        }
        return $this->add($userId, 'subscription', $title, $message, $link);
    }

    /**
     * إنشاء إشعار اقتراب انتهاء الاشتراك
     */
    public function notifySubscriptionExpiring($userId, $daysLeft, $link = null)
    {
        $title = 'تنبيه: اشتراكك على وشك الانتهاء';
        $message = "تبقى {$daysLeft} يوم على انتهاء اشتراكك. قم بالتجديد لتجنب انقطاع الخدمة";
        return $this->add($userId, 'subscription', $title, $message, $link);
    }

    /**
     * إنشاء إشعار رسالة تواصل جديدة
     */
    public function notifyNewMessage($userId, $senderName, $link = null)
    {
        $title = 'رسالة تواصل جديدة';
        $message = "استلمت رسالة جديدة من \"{$senderName}\"";
        return $this->add($userId, 'message', $title, $message, $link);
    }

    /**
     * إنشاء إشعار نموذج جديد
     */
    public function notifyNewFormSubmission($userId, $formName, $link = null)
    {
        $title = 'استجابة نموذج جديدة';
        $message = "تم استلام استجابة جديدة للنموذج \"{$formName}\"";
        return $this->add($userId, 'form', $title, $message, $link);
    }

    /**
     * إنشاء إشعار شراء خدمة
     */
    public function notifyServicePurchased($userId, $serviceName, $link = null)
    {
        $title = 'شراء خدمة جديدة';
        $message = "تم شراء الخدمة \"{$serviceName}\" بنجاح";
        return $this->add($userId, 'payment', $title, $message, $link);
    }

    /**
     * إنشاء إشعار نظام
     */
    public function notifySystem($userId, $title, $message, $link = null)
    {
        return $this->add($userId, 'system', $title, $message, $link);
    }

    /**
     * إرسال إشعار لجميع المستأجرين (للأدمن)
     */
    public function notifyAllTenants($title, $message, $type = 'system', $link = null)
    {
        // جلب كل المستخدمين أصحاب المواقع
        $users = $this->db->query(
            "SELECT DISTINCT user_id FROM tenants WHERE site_status = 'published'"
        )->results();

        $count = 0;
        foreach ($users as $user) {
            $this->add($user->user_id, $type, $title, $message, $link);
            $count++;
        }

        return $count;
    }
}

/**
 * دالة مساعدة لإنشاء إشعار
 */
function notify($userId, $type, $title, $message, $link = null, $data = null)
{
    static $notificationModel = null;
    if ($notificationModel === null) {
        require_once ROOT_PATH . '/app/models/Notification.php';
        $notificationModel = new Notification();
    }
    return $notificationModel->add($userId, $type, $title, $message, $link, $data);
}
