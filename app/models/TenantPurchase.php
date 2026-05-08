<?php
/**
 * CMS Platform - TenantPurchase Model
 * نموذج مشتريات المستأجرين
 */

class TenantPurchase extends Model
{
    protected $table = 'tenant_purchases';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tenant_id', 'service_id', 'quantity', 'amount', 'currency',
        'status', 'payment_method', 'payment_ref',
        'admin_notes', 'tenant_notes',
        'purchased_at', 'expires_at', 'approved_at'
    ];

    /**
     * الحصول على مشتريات مستأجر
     */
    public function getTenantPurchases($tenantId)
    {
        return $this->db->query(
            "SELECT tp.*, ps.title as service_title, ps.icon as service_icon, 
                    ps.category, ps.description as service_description,
                    ps.payment_link, ps.is_recurring, ps.recurring_period,
                    ps.requires_approval
             FROM {$this->table} tp
             JOIN paid_services ps ON tp.service_id = ps.id
             WHERE tp.tenant_id = ?
             ORDER BY tp.created_at DESC",
            [$tenantId]
        )->results();
    }

    /**
     * الحصول على المشتريات النشطة لمستأجر
     */
    public function getActivePurchases($tenantId)
    {
        return $this->db->query(
            "SELECT tp.*, ps.title as service_title, ps.icon as service_icon, ps.category
             FROM {$this->table} tp
             JOIN paid_services ps ON tp.service_id = ps.id
             WHERE tp.tenant_id = ? AND tp.status IN ('paid','approved')
             AND (tp.expires_at IS NULL OR tp.expires_at > NOW())
             ORDER BY tp.created_at DESC",
            [$tenantId]
        )->results();
    }

    /**
     * التحقق من شراء خدمة معينة
     */
    public function hasPurchased($tenantId, $serviceId)
    {
        $count = $this->db->query(
            "SELECT COUNT(*) as count FROM {$this->table} 
             WHERE tenant_id = ? AND service_id = ? AND status IN ('paid','approved')
             AND (expires_at IS NULL OR expires_at > NOW())",
            [$tenantId, $serviceId]
        )->first();

        return $count ? $count->count > 0 : false;
    }

    /**
     * الحصول على عدد مشتريات خدمة لمستأجر
     */
    public function getPurchaseCount($tenantId, $serviceId)
    {
        $result = $this->db->query(
            "SELECT COUNT(*) as count FROM {$this->table} 
             WHERE tenant_id = ? AND service_id = ? AND status IN ('paid','approved')
             AND (expires_at IS NULL OR expires_at > NOW())",
            [$tenantId, $serviceId]
        )->first();

        return $result ? $result->count : 0;
    }

    /**
     * الحصول على جميع المشتريات (للأدمن)
     */
    public function getAllPurchases($status = null)
    {
        $sql = "SELECT tp.*, ps.title as service_title, ps.icon as service_icon, ps.category,
                       t.site_name, t.slug as tenant_slug, u.full_name as customer_name, u.email
                FROM {$this->table} tp
                JOIN paid_services ps ON tp.service_id = ps.id
                JOIN tenants t ON tp.tenant_id = t.id
                JOIN users u ON t.user_id = u.id";

        $params = [];
        if ($status) {
            $sql .= " WHERE tp.status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY tp.created_at DESC";
        return $this->db->query($sql, $params)->results();
    }

    /**
     * الحصول على المشتريات المعلقة
     */
    public function getPendingPurchases()
    {
        return $this->getAllPurchases('pending');
    }

    /**
     * الموافقة على شراء
     */
    public function approve($id, $adminNotes = '')
    {
        return $this->update($id, [
            'status' => 'approved',
            'approved_at' => date('Y-m-d H:i:s'),
            'admin_notes' => $adminNotes
        ]);
    }

    /**
     * رفض شراء
     */
    public function reject($id, $adminNotes = '')
    {
        return $this->update($id, [
            'status' => 'cancelled',
            'admin_notes' => $adminNotes
        ]);
    }

    /**
     * إنشاء عملية شراء جديدة
     */
    public function createPurchase($data)
    {
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
     * عدد المشتريات بحالة معينة
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
     * الحصول على إحصائيات المبيعات
     */
    public function getStats()
    {
        $stats = $this->db->query(
            "SELECT 
                COUNT(*) as total_purchases,
                SUM(CASE WHEN status IN ('paid','approved') THEN amount ELSE 0 END) as total_revenue,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count,
                SUM(CASE WHEN status IN ('paid','approved') THEN 1 ELSE 0 END) as completed_count,
                SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled_count
             FROM {$this->table}"
        )->first();

        return $stats;
    }
}
