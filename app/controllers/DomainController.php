<?php
class DomainController extends Controller
{
    private $tenantModel;
    private $planModel;

    public function __construct()
    {
        parent::__construct();
        if (Auth::isAdmin()) {
            Session::error('هذه الصفحة متاحة للعملاء فقط');
            $this->redirect('/admin');
        }
        $this->requireAuth();
        $this->setLayout('dashboard');
        $this->tenantModel = $this->model('Tenant');
        $this->planModel = $this->model('SubscriptionPlan');
    }

    public function index()
    {
        $tenant = Auth::tenant();
        if (!$tenant) {
            $this->redirect('/site/create');
        }

        // Get current plan
        $plan = null;
        try {
            $db = Database::getInstance();
            $subscription = $db->query(
                "SELECT sp.* FROM subscriptions s
                 JOIN subscription_plans sp ON s.plan_id = sp.id
                 WHERE s.tenant_id = ? AND s.status = 'active'
                 ORDER BY s.created_at DESC LIMIT 1",
                [$tenant->id]
            )->first();
            if ($subscription) {
                $plan = $subscription;
            }
        } catch (\Exception $e) {}

        // Get domain history
        $domainHistory = [];
        try {
            $db = Database::getInstance();
            $domainHistory = $db->query(
                "SELECT * FROM domain_history WHERE tenant_id = ? ORDER BY created_at DESC LIMIT 20",
                [$tenant->id]
            )->results();
        } catch (\Exception $e) {}

        $this->view('dashboard/domains', [
            'title' => lang('domain_management'),
            'tenant' => $tenant,
            'plan' => $plan,
            'domainHistory' => $domainHistory,
            'mainDomain' => 'takweenweb.com'
        ]);
    }

    public function updateSubdomain()
    {
        $this->verifyCsrf();
        $tenant = Auth::tenant();
        $subdomain = strtolower(trim($this->input('subdomain')));

        if (empty($subdomain) || strlen($subdomain) < 3) {
            $this->jsonError('النطاق الفرعي يجب أن يكون 3 أحرف على الأقل');
        }

        if (!preg_match('/^[a-z0-9][a-z0-9-]*[a-z0-9]$/', $subdomain)) {
            $this->jsonError('النطاق الفرعي يحتوي على أحرف غير صالحة');
        }

        // Check availability
        $db = Database::getInstance();
        $existing = $db->query(
            "SELECT id FROM tenants WHERE subdomain = ? AND id != ?",
            [$subdomain, $tenant->id]
        )->first();

        if ($existing) {
            $this->jsonError('هذا النطاق الفرعي مستخدم بالفعل');
        }

        $oldSubdomain = $tenant->subdomain;
        $this->tenantModel->update($tenant->id, ['subdomain' => $subdomain]);
        Auth::refreshTenant();

        // Log history
        try {
            $db->query(
                "INSERT INTO domain_history (tenant_id, domain_type, old_value, new_value, status) VALUES (?, 'subdomain', ?, ?, 'added')",
                [$tenant->id, $oldSubdomain, $subdomain]
            );
        } catch (\Exception $e) {}

        $this->jsonSuccess([], 'تم حفظ النطاق الفرعي بنجاح');
    }

    public function addCustomDomain()
    {
        $this->verifyCsrf();
        $tenant = Auth::tenant();
        $domain = strtolower(trim($this->input('domain')));

        if (empty($domain)) {
            $this->jsonError('يرجى إدخال اسم النطاق');
        }

        // [FIX-25] التحقق من صيغة النطاق
        if (!preg_match('/^(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/', $domain)) {
            $this->jsonError('صيغة النطاق غير صالحة. مثال: example.com');
        }

        // Check plan allows custom domain
        $plan = $this->getCurrentPlan($tenant->id);
        if (!$plan || !isset($plan->allow_custom_domain) || !$plan->allow_custom_domain) {
            $this->jsonError('خطتك الحالية لا تدعم النطاقات المخصصة. قم بترقية خطتك.');
        }

        $verificationToken = bin2hex(random_bytes(16));

        $this->tenantModel->update($tenant->id, [
            'custom_domain' => $domain,
            'custom_domain_verified' => 0,
            'custom_domain_verification_token' => $verificationToken
        ]);
        Auth::refreshTenant();

        $this->jsonSuccess([], 'تم إضافة النطاق المخصص. يرجى إعداد سجلات DNS والتحقق.');
    }

    public function verifyDomain()
    {
        $this->verifyCsrf();
        $tenant = Auth::tenant();

        if (!$tenant->custom_domain) {
            $this->jsonError('لا يوجد نطاق مخصص للتحقق');
        }

        // [FIX-26] التحقق الفعلي من سجلات DNS
        $domain = $tenant->custom_domain;
        $expectedToken = $tenant->custom_domain_verification_token;
        $verified = false;

        try {
            $dnsRecords = @dns_get_record('_verify.' . $domain, DNS_TXT);
            if ($dnsRecords !== false) {
                foreach ($dnsRecords as $record) {
                    if (isset($record['txt']) && $record['txt'] === $expectedToken) {
                        $verified = true;
                        break;
                    }
                }
            }

            // أيضاً التحقق من سجل CNAME
            if (!$verified) {
                $cnameRecords = @dns_get_record($domain, DNS_CNAME);
                if ($cnameRecords !== false) {
                    foreach ($cnameRecords as $record) {
                        if (isset($record['target']) && strpos($record['target'], 'takweenweb.com') !== false) {
                            $verified = true;
                            break;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $verified = false;
        }

        if ($verified) {
            $this->tenantModel->update($tenant->id, ['custom_domain_verified' => 1]);
            Auth::refreshTenant();

            try {
                $db = Database::getInstance();
                $db->query(
                    "INSERT INTO domain_history (tenant_id, domain_type, old_value, new_value, status) VALUES (?, 'custom', ?, ?, 'verified')",
                    [$tenant->id, $tenant->custom_domain, $tenant->custom_domain]
                );
            } catch (\Exception $e) {}

            $this->jsonSuccess([], 'تم التحقق من النطاق بنجاح');
        }

        $this->jsonError('فشل التحقق. يرجى التأكد من سجلات DNS والمحاولة لاحقاً.');
    }

    public function removeCustomDomain()
    {
        $this->verifyCsrf();
        $tenant = Auth::tenant();

        $oldDomain = $tenant->custom_domain;
        $this->tenantModel->update($tenant->id, [
            'custom_domain' => null,
            'custom_domain_verified' => 0,
            'custom_domain_verification_token' => null
        ]);
        Auth::refreshTenant();

        try {
            $db = Database::getInstance();
            $db->query(
                "INSERT INTO domain_history (tenant_id, domain_type, old_value, new_value, status) VALUES (?, 'custom', ?, '', 'removed')",
                [$tenant->id, $oldDomain]
            );
        } catch (\Exception $e) {}

        $this->jsonSuccess([], 'تم إزالة النطاق المخصص');
    }

    private function getCurrentPlan($tenantId)
    {
        try {
            $db = Database::getInstance();
            return $db->query(
                "SELECT sp.* FROM subscriptions s
                 JOIN subscription_plans sp ON s.plan_id = sp.id
                 WHERE s.tenant_id = ? AND s.status = 'active'
                 ORDER BY s.created_at DESC LIMIT 1",
                [$tenantId]
            )->first();
        } catch (\Exception $e) {
            return null;
        }
    }
}
