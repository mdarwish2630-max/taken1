<?php
/**
 * CMS Platform - User Model
 * نموذج المستخدمين
 */

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'email', 'password', 'full_name', 'phone', 'role', 'status',
        'email_verified', 'verification_token', 'reset_token', 'reset_token_expires',
        'last_login'
    ];

    /**
     * البحث بواسطة البريد الإلكتروني
     */
    public function findByEmail($email)
    {
        return $this->findBy('email', $email);
    }

    /**
     * إنشاء مستخدم جديد
     */
    public function register($data)
    {
        // تشفير كلمة المرور
        $data['password'] = Security::hashPassword($data['password']);
        
        // تعيين الدور الافتراضي
        $data['role'] = $data['role'] ?? 'customer';
        
        // إنشاء رمز التحقق
        $data['verification_token'] = Security::generateVerificationToken();
        
        return $this->create($data);
    }

    /**
     * التحقق من كلمة المرور
     */
    public function verifyPassword($password, $hash)
    {
        return Security::verifyPassword($password, $hash);
    }

    /**
     * تحديث آخر تسجيل دخول
     */
    public function updateLastLogin($userId)
    {
        return $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }

    /**
     * إنشاء رمز إعادة تعيين كلمة المرور
     */
    public function createResetToken($email)
    {
        $user = $this->findByEmail($email);
        
        if (!$user) {
            return false;
        }
        
        $token = Security::generateVerificationToken();
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $this->update($user->id, [
            'reset_token' => $token,
            'reset_token_expires' => $expires
        ]);
        
        return $token;
    }

    /**
     * التحقق من رمز إعادة التعيين
     */
    public function verifyResetToken($token)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE reset_token = ? AND reset_token_expires > NOW() AND status = 'active'",
            [$token]
        )->first();
    }

    /**
     * إعادة تعيين كلمة المرور
     */
    public function resetPassword($token, $newPassword)
    {
        $user = $this->verifyResetToken($token);
        
        if (!$user) {
            return false;
        }
        
        return $this->update($user->id, [
            'password' => Security::hashPassword($newPassword),
            'reset_token' => null,
            'reset_token_expires' => null
        ]);
    }

    /**
     * التحقق من البريد الإلكتروني
     */
    public function verifyEmail($token)
    {
        $user = $this->db->query(
            "SELECT * FROM {$this->table} WHERE verification_token = ?",
            [$token]
        )->first();
        
        if (!$user) {
            return false;
        }
        
        return $this->update($user->id, [
            'email_verified' => 1,
            'verification_token' => null
        ]);
    }

    /**
     * الحصول على المستخدمين العملاء
     */
    public function getCustomers($limit = null)
    {
        $sql = "SELECT u.*, t.site_name, t.subscription_status 
                FROM {$this->table} u 
                LEFT JOIN tenants t ON u.id = t.user_id 
                WHERE u.role = 'customer' 
                ORDER BY u.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)->results();
    }

    /**
     * الحصول على عدد المستخدمين الجدد
     */
    public function getNewUsersCount($days = 30)
    {
        return $this->count(
            "role = 'customer' AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)",
            [$days]
        );
    }

    /**
     * تغيير حالة المستخدم
     */
    public function changeStatus($userId, $status)
    {
        return $this->update($userId, ['status' => $status]);
    }

    /**
     * التحقق من وجود بريد إلكتروني
     */
    public function emailExists($email, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE email = ?";
        $params = [$email];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $result = $this->db->query($sql, $params)->first();
        return $result->count > 0;
    }
}
