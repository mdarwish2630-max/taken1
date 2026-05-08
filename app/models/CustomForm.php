<?php
/**
 * CMS Platform - Custom Form Model
 * نموذج النماذج المخصصة
 */

class CustomForm extends Model
{
    protected $table = 'custom_forms';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tenant_id', 'name', 'slug', 'description', 'fields',
        'submit_button_text', 'success_message', 'redirect_url',
        'send_email_notification', 'email_recipients', 'status'
    ];

    /**
     * إنشاء نموذج جديد
     */
    public function createForm($data)
    {
        // تحويل الحقول إلى JSON
        if (isset($data['fields']) && is_array($data['fields'])) {
            $data['fields'] = json_encode($data['fields'], JSON_UNESCAPED_UNICODE);
        }

        // تحويل المستلمين إلى JSON
        if (isset($data['email_recipients']) && is_array($data['email_recipients'])) {
            $data['email_recipients'] = json_encode($data['email_recipients'], JSON_UNESCAPED_UNICODE);
        }

        return $this->create($data);
    }

    /**
     * الحصول على نماذج موقع معين
     */
    public function getTenantForms($tenantId)
    {
        return $this->db->query(
            "SELECT f.*, 
                    (SELECT COUNT(*) FROM form_submissions WHERE form_id = f.id) as submissions_count
             FROM {$this->table} f 
             WHERE f.tenant_id = ? 
             ORDER BY f.created_at DESC",
            [$tenantId]
        )->results();
    }

    /**
     * الحصول على النماذج النشطة
     */
    public function getActiveForms($tenantId)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} 
             WHERE tenant_id = ? AND status = 'active'",
            [$tenantId]
        )->results();
    }

    /**
     * الحصول على نموذج بواسطة Slug
     */
    public function findBySlug($slug, $tenantId)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE slug = ? AND tenant_id = ?",
            [$slug, $tenantId]
        )->first();
    }

    /**
     * الحصول على حقول النموذج كمصفوفة
     */
    public function getFields($formId)
    {
        $form = $this->find($formId);
        if (!$form || !$form->fields) {
            return [];
        }

        return json_decode($form->fields, true);
    }

    /**
     * الحصول على المستلمين كمصفوفة
     */
    public function getRecipients($formId)
    {
        $form = $this->find($formId);
        if (!$form || !$form->email_recipients) {
            return [];
        }

        return json_decode($form->email_recipients, true);
    }

    /**
     * حفظ استجابة النموذج
     */
    public function saveSubmission($formId, $tenantId, $data, $ipAddress = null, $userAgent = null)
    {
        return $this->db->query(
            "INSERT INTO form_submissions (form_id, tenant_id, data, ip_address, user_agent) 
             VALUES (?, ?, ?, ?, ?)",
            [
                $formId,
                $tenantId,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                $ipAddress,
                $userAgent
            ]
        );
    }

    /**
     * الحصول على استجابات النموذج
     */
    public function getSubmissions($formId, $limit = 50, $offset = 0)
    {
        return $this->db->query(
            "SELECT * FROM form_submissions 
             WHERE form_id = ? 
             ORDER BY created_at DESC 
             LIMIT {$limit} OFFSET {$offset}",
            [$formId]
        )->results();
    }

    /**
     * الحصول على جميع استجابات الموقع
     */
    public function getAllSubmissions($tenantId, $limit = 50)
    {
        return $this->db->query(
            "SELECT s.*, f.name as form_name 
             FROM form_submissions s
             JOIN {$this->table} f ON s.form_id = f.id
             WHERE s.tenant_id = ? 
             ORDER BY s.created_at DESC 
             LIMIT {$limit}",
            [$tenantId]
        )->results();
    }

    /**
     * تحديد الاستجابة كمقروءة
     */
    public function markSubmissionRead($submissionId)
    {
        return $this->db->query(
            "UPDATE form_submissions SET is_read = 1 WHERE id = ?",
            [$submissionId]
        );
    }

    /**
     * عدد الاستجابات غير المقروءة
     */
    public function countUnreadSubmissions($tenantId)
    {
        $result = $this->db->query(
            "SELECT COUNT(*) as count FROM form_submissions 
             WHERE tenant_id = ? AND is_read = 0",
            [$tenantId]
        )->first();

        return $result ? $result->count : 0;
    }

    /**
     * حذف الاستجابات القديمة
     */
    public function deleteOldSubmissions($daysOld = 90)
    {
        return $this->db->query(
            "DELETE FROM form_submissions 
             WHERE created_at < DATE_SUB(NOW(), INTERVAL ? DAY)",
            [$daysOld]
        );
    }

    /**
     * إنشاء HTML للنموذج
     */
    public function renderForm($formId, $actionUrl = '')
    {
        $form = $this->find($formId);
        if (!$form) {
            return '';
        }

        $fields = $this->getFields($formId);
        $html = '<form class="custom-form" method="POST" action="' . $actionUrl . '">';
        $html .= '<input type="hidden" name="form_id" value="' . $formId . '">';
        $html .= Security::csrfField();

        foreach ($fields as $field) {
            $html .= $this->renderField($field);
        }

        $html .= '<button type="submit" class="btn btn-primary">';
        $html .= htmlspecialchars($form->submit_button_text ?: 'إرسال');
        $html .= '</button></form>';

        return $html;
    }

    /**
     * إنشاء HTML لحقل واحد
     */
    private function renderField($field)
    {
        $type = $field['type'] ?? 'text';
        $name = $field['name'] ?? '';
        $label = $field['label'] ?? $name;
        $required = isset($field['required']) && $field['required'] ? 'required' : '';
        $placeholder = $field['placeholder'] ?? '';
        $options = $field['options'] ?? [];

        $html = '<div class="form-group mb-3">';
        $html .= '<label class="form-label">' . htmlspecialchars($label);
        if ($required) {
            $html .= ' <span class="text-danger">*</span>';
        }
        $html .= '</label>';

        switch ($type) {
            case 'textarea':
                $html .= '<textarea name="' . $name . '" class="form-control" 
                          placeholder="' . htmlspecialchars($placeholder) . '" ' . $required . ' rows="4"></textarea>';
                break;

            case 'select':
                $html .= '<select name="' . $name . '" class="form-select" ' . $required . '>';
                $html .= '<option value="">اختر...</option>';
                foreach ($options as $value => $label) {
                    $html .= '<option value="' . htmlspecialchars($value) . '">' . htmlspecialchars($label) . '</option>';
                }
                $html .= '</select>';
                break;

            case 'checkbox':
                $html .= '<div class="form-check">';
                $html .= '<input type="checkbox" name="' . $name . '" class="form-check-input" ' . $required . '>';
                $html .= '<label class="form-check-label">' . htmlspecialchars($label) . '</label>';
                $html .= '</div>';
                break;

            case 'radio':
                foreach ($options as $value => $label) {
                    $html .= '<div class="form-check">';
                    $html .= '<input type="radio" name="' . $name . '" value="' . htmlspecialchars($value) . '" class="form-check-input">';
                    $html .= '<label class="form-check-label">' . htmlspecialchars($label) . '</label>';
                    $html .= '</div>';
                }
                break;

            case 'email':
            case 'tel':
            case 'number':
            case 'date':
                $html .= '<input type="' . $type . '" name="' . $name . '" class="form-control" 
                          placeholder="' . htmlspecialchars($placeholder) . '" ' . $required . '>';
                break;

            default:
                $html .= '<input type="text" name="' . $name . '" class="form-control" 
                          placeholder="' . htmlspecialchars($placeholder) . '" ' . $required . '>';
        }

        $html .= '</div>';
        return $html;
    }
}
