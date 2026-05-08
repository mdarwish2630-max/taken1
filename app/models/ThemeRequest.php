<?php
/**
 * CMS Platform - ThemeRequest Model
 * نموذج طلبات تفعيل الثيمات المدفوعة
 */

class ThemeRequest extends Model
{
    protected $table = 'theme_requests';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tenant_id', 'theme_id', 'status', 'amount', 'currency',
        'payment_method', 'payment_ref',
        'admin_notes', 'tenant_notes',
        'approved_at', 'rejected_at'
    ];

    /**
     * إنشاء طلب تفعيل ثيم مدفوع
     */
    public function createRequest($data)
    {
        $data['status'] = 'pending';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $this->db->query(
            "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})",
            array_values($data)
        );

        return $this->db->lastInsertId();
    }

    /**
     * الموافقة على طلب تفعيل ثيم + تطبيقه على الموقع
     * يتضمن نسخ البيانات التجريبية (محتوى الثيم + الوسائط) للمستأجر
     */
    public function approve($id, $adminNotes = '')
    {
        $request = $this->find($id);
        if (!$request || $request->status !== 'pending') {
            return false;
        }

        // تحديث حالة الطلب
        $this->update($id, [
            'status' => 'approved',
            'admin_notes' => $adminNotes,
            'approved_at' => date('Y-m-d H:i:s')
        ]);

        // تفعيل الثيم للمستأجر
        $tenantModel = new Tenant();
        $tenantModel->update($request->tenant_id, ['theme_id' => $request->theme_id]);

        // نسخ محتوى الثيم التجريبي للمستأجر (خدمات، آراء عملاء، بنرات)
        try {
            require_once ROOT_PATH . '/app/models/ThemeContent.php';
            $contentModel = new ThemeContent();
            $contentModel->copyContentToTenant($request->theme_id, $request->tenant_id);
        } catch (Exception $e) {
            error_log("Theme content copy on approve error: " . $e->getMessage());
        }

        // نسخ وسائط الثيم للمستأجر (شعار، بنرات)
        try {
            require_once ROOT_PATH . '/app/models/ThemeMedia.php';
            $mediaModel = new ThemeMedia();
            $mediaModel->copyMediaToTenant($request->theme_id, $request->tenant_id);
        } catch (Exception $e) {
            error_log("Theme media copy on approve error: " . $e->getMessage());
        }

        return true;
    }

    /**
     * رفض طلب تفعيل ثيم
     */
    public function reject($id, $adminNotes = '')
    {
        $request = $this->find($id);
        if (!$request || $request->status !== 'pending') {
            return false;
        }

        return $this->update($id, [
            'status' => 'rejected',
            'admin_notes' => $adminNotes,
            'rejected_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * إلغاء طلب (من المشترك)
     */
    public function cancel($id, $tenantId)
    {
        $request = $this->find($id);
        if (!$request || $request->tenant_id != $tenantId || $request->status !== 'pending') {
            return false;
        }

        return $this->update($id, ['status' => 'cancelled']);
    }

    /**
     * الحصول على جميع الطلبات (للأدمن) مع معلومات المستأجر والثيم
     */
    public function getAllRequests($status = null)
    {
        $sql = "SELECT tr.*, 
                       th.name as theme_name, th.slug as theme_slug, th.price as theme_price,
                       t.site_name, t.slug as tenant_slug,
                       u.full_name as customer_name, u.email as customer_email
                FROM {$this->table} tr
                JOIN themes th ON tr.theme_id = th.id
                JOIN tenants t ON tr.tenant_id = t.id
                JOIN users u ON t.user_id = u.id";

        $params = [];
        if ($status) {
            $sql .= " WHERE tr.status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY tr.created_at DESC";
        return $this->db->query($sql, $params)->results();
    }

    /**
     * الحصول على طلبات مستأجر معين
     */
    public function getTenantRequests($tenantId)
    {
        $sql = "SELECT tr.*, 
                       th.name as theme_name, th.slug as theme_slug, th.price as theme_price,
                       th.payment_link
                FROM {$this->table} tr
                JOIN themes th ON tr.theme_id = th.id
                WHERE tr.tenant_id = ?
                ORDER BY tr.created_at DESC";
        return $this->db->query($sql, [$tenantId])->results();
    }

    /**
     * الحصول على الطلبات المعلقة
     */
    public function getPendingRequests()
    {
        return $this->getAllRequests('pending');
    }

    /**
     * عدد الطلبات بحالة معينة
     */
    public function countByStatus($status)
    {
        $result = $this->db->query(
            "SELECT COUNT(*) as count FROM {$this->table} WHERE status = ?",
            [$status]
        )->first();

        return $result ? (int)$result->count : 0;
    }

    /**
     * التحقق من وجود طلب معلق لنفس الثيم
     */
    public function hasPendingRequest($tenantId, $themeId)
    {
        $result = $this->db->query(
            "SELECT COUNT(*) as count FROM {$this->table} 
             WHERE tenant_id = ? AND theme_id = ? AND status = 'pending'",
            [$tenantId, $themeId]
        )->first();

        return $result && $result->count > 0;
    }

    /**
     * الحصول على طلب محدد مع التحقق من المستأجر
     */
    public function findForTenant($id, $tenantId)
    {
        $result = $this->db->query(
            "SELECT tr.*, th.name as theme_name, th.slug as theme_slug
             FROM {$this->table} tr
             JOIN themes th ON tr.theme_id = th.id
             WHERE tr.id = ? AND tr.tenant_id = ?",
            [$id, $tenantId]
        )->first();

        return $result;
    }
}
