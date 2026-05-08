<?php
/**
 * CMS Platform - SEO Settings Model
 * نموذج إعدادات SEO
 */

class SeoSettings extends Model
{
    protected $table = 'seo_settings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tenant_id', 'google_analytics_id', 'google_tag_manager_id',
        'facebook_pixel_id', 'google_site_verification', 'bing_site_verification',
        'robots_txt', 'schema_org', 'canonical_url', 'og_image', 'twitter_card_type'
    ];

    /**
     * الحصول على إعدادات SEO لموقع
     */
    public function getTenantSettings($tenantId)
    {
        $settings = $this->db->query(
            "SELECT * FROM {$this->table} WHERE tenant_id = ?",
            [$tenantId]
        )->first();

        if (!$settings) {
            // إنشاء إعدادات افتراضية
            $this->create(['tenant_id' => $tenantId]);
            return $this->getTenantSettings($tenantId);
        }

        return $settings;
    }

    /**
     * تحديث الإعدادات
     */
    public function updateSettings($tenantId, $data)
    {
        $settings = $this->getTenantSettings($tenantId);
        
        return $this->update($settings->id, $data);
    }

    /**
     * إنشاء Google Analytics Script
     */
    public function getAnalyticsScript($tenantId)
    {
        $settings = $this->getTenantSettings($tenantId);
        $scripts = [];

        // Google Analytics
        if ($settings->google_analytics_id) {
            $scripts[] = <<<HTML
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={$settings->google_analytics_id}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{$settings->google_analytics_id}');
</script>
HTML;
        }

        // Google Tag Manager
        if ($settings->google_tag_manager_id) {
            $scripts[] = <<<HTML
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{$settings->google_tag_manager_id}');</script>
HTML;
        }

        // Facebook Pixel
        if ($settings->facebook_pixel_id) {
            $scripts[] = <<<HTML
<!-- Facebook Pixel -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '{$settings->facebook_pixel_id}');
  fbq('track', 'PageView');
</script>
HTML;
        }

        return implode("\n", $scripts);
    }

    /**
     * إنشاء Meta Tags للتحقق
     */
    public function getVerificationTags($tenantId)
    {
        $settings = $this->getTenantSettings($tenantId);
        $tags = [];

        if ($settings->google_site_verification) {
            $tags[] = '<meta name="google-site-verification" content="' . htmlspecialchars($settings->google_site_verification) . '">';
        }

        if ($settings->bing_site_verification) {
            $tags[] = '<meta name="msvalidate.01" content="' . htmlspecialchars($settings->bing_site_verification) . '">';
        }

        return implode("\n", $tags);
    }

    /**
     * إنشاء Schema.org JSON-LD
     */
    public function getSchemaScript($tenantId, $tenantData)
    {
        $settings = $this->getTenantSettings($tenantId);

        // إذا كان هناك schema مخصص
        if ($settings->schema_org) {
            return '<script type="application/ld+json">' . $settings->schema_org . '</script>';
        }

        // إنشاء schema افتراضي للمؤسسة
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $tenantData->site_name,
            'url' => SITE_URL . '/' . $tenantData->slug,
        ];

        if ($tenantData->logo) {
            $schema['image'] = upload($tenantData->logo);
        }

        if ($tenantData->contact_phone) {
            $schema['telephone'] = $tenantData->contact_phone;
        }

        if ($tenantData->contact_email) {
            $schema['email'] = $tenantData->contact_email;
        }

        if ($tenantData->address) {
            $schema['address'] = [
                '@type' => 'PostalAddress',
                'streetAddress' => $tenantData->address
            ];
        }

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE) . '</script>';
    }

    /**
     * إنشاء Robots.txt
     */
    public function getRobotsTxt($tenantId)
    {
        $settings = $this->getTenantSettings($tenantId);

        if ($settings->robots_txt) {
            return $settings->robots_txt;
        }

        // robots.txt افتراضي
        return <<<TXT
User-agent: *
Allow: /
Disallow: /admin/
Disallow: /dashboard/
Sitemap: {SITE_URL}/sitemap.xml
TXT;
    }
}
