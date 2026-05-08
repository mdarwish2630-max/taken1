<?php
/**
 * CMS Platform - Language Controller
 * متحكم تغيير اللغة
 */

class LanguageController extends Controller
{
    /**
     * تغيير لغة المنصة (للمستخدم)
     */
    public function change($lang)
    {
        if (!in_array($lang, SUPPORTED_LANGS)) {
            $lang = DEFAULT_LANG;
        }
        
        Language::setLocale($lang);
        
        // العودة للصفحة السابقة
        $this->back();
    }

    /**
     * تغيير لغة الموقع (من الداشبورد)
     */
    public function changeSiteLanguage()
    {
        $this->verifyCsrf();
        
        $lang = $this->input('language');
        
        if (!in_array($lang, SUPPORTED_LANGS)) {
            $this->jsonError('لغة غير مدعومة');
        }
        
        $tenant = Auth::tenant();
        
        if (!$tenant) {
            $this->jsonError('الموقع غير موجود');
        }
        
        $tenantModel = $this->model('Tenant');
        
        if ($tenantModel->updateLanguage($tenant->id, $lang)) {
            // تحديث لغة الجلسة
            Language::setTenantLang($lang);
            
            $this->jsonSuccess([], lang('settings_saved'));
        }
        
        $this->jsonError('حدث خطأ');
    }

    /**
     * الحصول على اللغة الحالية
     */
    public function current()
    {
        $this->json([
            'lang' => Language::current(),
            'direction' => Language::direction(),
            'name' => Language::name()
        ]);
    }
}
