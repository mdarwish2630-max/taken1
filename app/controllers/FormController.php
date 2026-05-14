<?php
/**
 * CMS Platform - Form Controller
 * متحكم النماذج المخصصة
 */

class FormController extends Controller
{
    private $formModel;

    public function __construct()
    {
        parent::__construct();
        
        require_once ROOT_PATH . '/app/models/CustomForm.php';
        $this->formModel = new CustomForm();
    }

    /**
     * قائمة النماذج (لوحة التحكم)
     */
    public function index()
    {
        $this->requireAuth();
        $this->view->setLayout('dashboard');
        
        $tenant = Auth::tenant();
        $forms = $this->formModel->getTenantForms($tenant->id);

        $this->view('dashboard/forms/index', [
            'title' => lang('custom_forms'),
            'forms' => $forms,
            'tenant' => $tenant
        ]);
    }

    /**
     * نموذج إنشاء نموذج جديد
     */
    public function add()
    {
        $this->requireAuth();
        $this->view->setLayout('dashboard');
        
        $tenant = Auth::tenant();

        $this->view('dashboard/forms/form-builder', [
            'title' => lang('create_form'),
            'form' => null,
            'tenant' => $tenant
        ]);
    }

    /**
     * حفظ نموذج جديد
     */
    public function store()
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();

        $data = [
            'tenant_id' => $tenant->id,
            'name' => $this->input('name'),
            'slug' => $this->input('slug'),
            'description' => $this->input('description'),
            'fields' => $this->input('fields', []),
            'submit_button_text' => $this->input('submit_button_text', 'إرسال'),
            'success_message' => $this->input('success_message', 'تم الإرسال بنجاح'),
            'redirect_url' => $this->input('redirect_url'),
            'send_email_notification' => $this->input('send_email_notification') ? 1 : 0,
            'email_recipients' => $this->input('email_recipients', []),
            'status' => $this->input('status', 'active')
        ];

        if ($this->formModel->createForm($data)) {
            Session::success(lang('form_created'));
            $this->redirect('/dashboard/forms');
        }

        Session::error(lang('error_occurred'));
        $this->redirect('/dashboard/forms/add');
    }

    /**
     * تعديل نموذج
     */
    public function edit($id)
    {
        $this->requireAuth();
        $this->view->setLayout('dashboard');
        
        $tenant = Auth::tenant();
        $form = $this->formModel->find($id);

        if (!$form || $form->tenant_id != $tenant->id) {
            Session::error(lang('form_not_found'));
            $this->redirect('/dashboard/forms');
        }

        $this->view('dashboard/forms/form-builder', [
            'title' => lang('edit_form'),
            'form' => $form,
            'tenant' => $tenant
        ]);
    }

    /**
     * تحديث نموذج
     */
    public function update($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $form = $this->formModel->find($id);

        if (!$form || $form->tenant_id != $tenant->id) {
            $this->jsonError(lang('form_not_found'), [], 404);
        }

        $data = [
            'name' => $this->input('name'),
            'slug' => $this->input('slug'),
            'description' => $this->input('description'),
            'fields' => $this->input('fields', []),
            'submit_button_text' => $this->input('submit_button_text'),
            'success_message' => $this->input('success_message'),
            'redirect_url' => $this->input('redirect_url'),
            'send_email_notification' => $this->input('send_email_notification') ? 1 : 0,
            'email_recipients' => $this->input('email_recipients', []),
            'status' => $this->input('status')
        ];

        $this->formModel->update($id, $data);

        Session::success(lang('form_updated'));
        $this->redirect('/dashboard/forms');
    }

    /**
     * حذف نموذج
     */
    public function delete($id)
    {
        $this->verifyCsrf();

        $tenant = Auth::tenant();
        $form = $this->formModel->find($id);

        if (!$form || $form->tenant_id != $tenant->id) {
            $this->jsonError(lang('form_not_found'), [], 404);
        }

        if ($this->formModel->delete($id)) {
            $this->jsonSuccess([], lang('form_deleted'));
        }

        $this->jsonError(lang('error_occurred'));
    }

    /**
     * عرض استجابات النموذج
     */
    public function submissions($formId)
    {
        $this->requireAuth();
        $this->view->setLayout('dashboard');
        
        $tenant = Auth::tenant();
        $form = $this->formModel->find($formId);

        if (!$form || $form->tenant_id != $tenant->id) {
            Session::error(lang('form_not_found'));
            $this->redirect('/dashboard/forms');
        }

        $submissions = $this->formModel->getSubmissions($formId, 50);

        $this->view('dashboard/forms/submissions', [
            'title' => lang('form_submissions'),
            'form' => $form,
            'submissions' => $submissions,
            'tenant' => $tenant
        ]);
    }

    /**
     * استقبال بيانات النموذج (واجهة عامة)
     */
    public function submit()
    {
        // التحقق من CSRF
        $this->verifyCsrf();

        // [FIX-21] Rate Limiting لمنع Spam
        $clientIp = Security::getClientIp();
        if (!Security::rateLimit('form_submit_' . $clientIp, 10, 1)) {
            $this->jsonError('تم تجاوز الحد الأقصى للإرسال. يرجى المحاولة لاحقاً');
        }

        $formId = $this->input('form_id');
        $tenantSlug = $this->input('tenant_slug');

        // البحث عن الموقع
        require_once ROOT_PATH . '/app/models/Tenant.php';
        $tenantModel = new Tenant();
        $tenant = $tenantModel->findBySlug($tenantSlug);

        if (!$tenant) {
            $this->jsonError(lang('site_not_found'), [], 404);
        }

        // البحث عن النموذج
        $form = $this->formModel->find($formId);

        if (!$form || $form->tenant_id != $tenant->id || $form->status !== 'active') {
            $this->jsonError(lang('form_not_found'), [], 404);
        }

        // جمع البيانات
        $data = [];
        $fields = $this->formModel->getFields($formId);
        
        foreach ($fields as $field) {
            $fieldName = $field['name'];
            $data[$fieldName] = $this->input($fieldName);
        }

        // حفظ الاستجابة
        $this->formModel->saveSubmission(
            $formId,
            $tenant->id,
            $data,
            $_SERVER['REMOTE_ADDR'] ?? null,
            $_SERVER['HTTP_USER_AGENT'] ?? null
        );

        // إرسال إشعار بالبريد
        if ($form->send_email_notification) {
            $recipients = $this->formModel->getRecipients($formId);
            if (empty($recipients)) {
                $recipients = [$tenant->contact_email];
            }
            
            $subject = "استجابة جديدة - " . preg_replace('/[\r\n]/', '', htmlspecialchars($form->name, ENT_QUOTES, 'UTF-8'));
            $body = $this->formatEmailBody($data, $fields);
            
            foreach ($recipients as $email) {
                sendMail($email, $subject, $body);
            }
        }

        // الرد
        if ($form->redirect_url) {
            $this->jsonSuccess(['redirect' => $form->redirect_url], $form->success_message);
        }

        $this->jsonSuccess([], $form->success_message ?: lang('form_submitted'));
    }

    /**
     * تنسيق نص البريد
     */
    private function formatEmailBody($data, $fields)
    {
        $body = "<h3>استجابة جديدة للنموذج</h3><table border='1' cellpadding='10'>";

        foreach ($fields as $field) {
            $name = $field['name'];
            $label = $field['label'] ?? $name;
            $value = $data[$name] ?? '-';
            
            $body .= "<tr><td><strong>" . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . "</strong></td><td>" . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . "</td></tr>";
        }

        $body .= "</table>";
        return $body;
    }

    /**
     * عرض نموذج (للتضمين)
     */
    public function embed($slug)
    {
        $form = $this->formModel->findBySlug($slug, $this->input('tenant_id'));

        if (!$form || $form->status !== 'active') {
            return '<p>النموذج غير متاح</p>';
        }

        return $this->formModel->renderForm($form->id);
    }
}
