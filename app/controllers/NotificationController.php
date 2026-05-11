<?php
/**
 * CMS Platform - Notification Controller
 * متحكم الإشعارات
 */

class NotificationController extends Controller
{
    private $notificationModel;

    public function __construct()
    {
        parent::__construct();

        require_once ROOT_PATH . '/app/models/Notification.php';
        $this->notificationModel = new Notification();
    }

    /**
     * الحصول على عدد الإشعارات غير المقروءة (API)
     */
    public function unreadCount()
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            $this->jsonSuccess(['count' => 0]);
            return;
        }

        $count = $this->notificationModel->getUnreadCount($userId);
        $this->jsonSuccess(['count' => $count]);
    }

    /**
     * الحصول على قائمة الإشعارات (API)
     */
    public function list()
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            $this->jsonSuccess(['notifications' => []]);
            return;
        }

        $limit = (int)$this->input('limit', 20);
        $offset = (int)$this->input('offset', 0);
        $limit = min(max($limit, 1), 100);

        $notifications = $this->notificationModel->getUserNotifications($userId, $limit, $offset);
        $unreadCount = $this->notificationModel->getUnreadCount($userId);

        // تنسيق التاريخ
        foreach ($notifications as $n) {
            $n->time_ago = $this->timeAgo($n->created_at);
        }

        $this->jsonSuccess([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * تحديد إشعار كمقروء
     */
    public function markRead($id)
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'] ?? null;

        if ($this->notificationModel->markAsRead($id, $userId)) {
            $unreadCount = $this->notificationModel->getUnreadCount($userId);
            $this->jsonSuccess(['unread_count' => $unreadCount]);
        } else {
            $this->jsonError('فشل تحديث الإشعار', [], 404);
        }
    }

    /**
     * تحديد كل الإشعارات كمقروءة
     */
    public function markAllRead()
    {
        $this->requireAuth();
        $userId = $_SESSION['user_id'] ?? null;

        $count = $this->notificationModel->markAllAsRead($userId);
        $this->jsonSuccess(['marked_count' => $count]);
    }

    /**
     * حذف إشعار
     */
    public function delete($id)
    {
        $this->verifyCsrf();
        $this->requireAuth();
        $userId = $_SESSION['user_id'] ?? null;

        if ($this->notificationModel->deleteNotification($id, $userId)) {
            $this->jsonSuccess([], 'تم حذف الإشعار');
        } else {
            $this->jsonError('فشل حذف الإشعار', [], 404);
        }
    }

    /**
     * حساب الوقت النسبي
     */
    private function timeAgo($datetime)
    {
        $now = new DateTime();
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        if ($diff->y > 0) return $diff->y . ' سنة';
        if ($diff->m > 0) return $diff->m . ' شهر';
        if ($diff->d > 0) return $diff->d . ' يوم';
        if ($diff->h > 0) return $diff->h . ' ساعة';
        if ($diff->i > 0) return $diff->i . ' دقيقة';
        return 'الآن';
    }
}
