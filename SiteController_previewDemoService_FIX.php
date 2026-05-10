<?php
/**
 * ============================================================
 * SiteController FIX - previewDemoService Method
 * ============================================================
 * 
 * HOW TO USE THIS FILE:
 * 1. Open your file: C:\xampp\htdocs\takweenweb\public\SiteController.php
 * 2. Find the class SiteController { ... }
 * 3. ADD the method below inside the class, after the existing methods
 * 4. Save the file
 * 
 * This method fixes the error:
 *   "Invalid handler: SiteController@previewDemoService"
 *   which causes 500 error on all service detail pages
 * ============================================================
 */

/**
 * Preview a specific service detail page
 * Route: /theme-preview/{slug}/service/{serviceSlug}
 * 
 * @param string $slug - Theme slug (e.g. 'rakaz', 'nove')
 * @param string $serviceSlug - Service slug from URL
 */
public function previewDemoService($slug, $serviceSlug)
{
    // Reuse the same database connection pattern from other preview methods
    $pdo = $this->db ?? $this->getDatabaseConnection();
    
    // Get theme by slug
    $theme = $pdo->prepare("SELECT * FROM themes WHERE name = ? AND is_active = 1 LIMIT 1");
    $theme->execute([$slug]);
    $theme = $theme->fetch(PDO::FETCH_ASSOC);
    
    if (!$theme) {
        http_response_code(404);
        echo "Theme not found: " . htmlspecialchars($slug);
        return;
    }
    
    $themeId = $theme['id'];
    $tenantId = $theme['tenant_id'];
    
    // Get theme settings
    $settings = $pdo->prepare("SELECT * FROM theme_settings WHERE theme_id = ? LIMIT 1");
    $settings->execute([$themeId]);
    $settings = $settings->fetch(PDO::FETCH_ASSOC);
    
    // Get the specific service by slug
    $service = $pdo->prepare("SELECT * FROM theme_contents WHERE theme_id = ? AND slug = ? AND status = 'published' LIMIT 1");
    $service->execute([$themeId, $serviceSlug]);
    $service = $service->fetch(PDO::FETCH_ASSOC);
    
    if (!$service) {
        http_response_code(404);
        echo "Service not found: " . htmlspecialchars($serviceSlug);
        return;
    }
    
    // Get all published services (for sidebar/navigation)
    $allServices = $pdo->prepare("SELECT * FROM theme_contents WHERE theme_id = ? AND page_key = 'service' AND status = 'published' ORDER BY sort_order ASC");
    $allServices->execute([$themeId]);
    $services = $allServices->fetchAll(PDO::FETCH_ASSOC);
    
    // Get menu items
    $menu = $pdo->prepare("SELECT * FROM theme_contents WHERE theme_id = ? AND page_key IN ('home','services','about','contact','gallery','faq','partners','booking') AND status = 'published' ORDER BY sort_order ASC");
    $menu->execute([$themeId]);
    $menu = $menu->fetchAll(PDO::FETCH_ASSOC);
    
    // Get testimonials
    $testimonials = $pdo->prepare("SELECT * FROM theme_contents WHERE theme_id = ? AND page_key = 'testimonial' AND status = 'published' ORDER BY sort_order ASC");
    $testimonials->execute([$themeId]);
    $testimonials = $testimonials->fetchAll(PDO::FETCH_ASSOC);
    
    // Get stats
    $siteStats = $pdo->prepare("SELECT * FROM theme_contents WHERE theme_id = ? AND page_key = 'stat' AND status = 'published' ORDER BY sort_order ASC");
    $siteStats->execute([$themeId]);
    $siteStats = $siteStats->fetchAll(PDO::FETCH_ASSOC);
    
    // Get features
    $siteFeatures = $pdo->prepare("SELECT * FROM theme_contents WHERE theme_id = ? AND page_key = 'feature' AND status = 'published' ORDER BY sort_order ASC");
    $siteFeatures->execute([$themeId]);
    $siteFeatures = $siteFeatures->fetchAll(PDO::FETCH_ASSOC);
    
    // Get gallery items
    $gallery = $pdo->prepare("SELECT * FROM theme_contents WHERE theme_id = ? AND page_key = 'gallery_item' AND status = 'published' ORDER BY sort_order ASC");
    $gallery->execute([$themeId]);
    $gallery = $gallery->fetchAll(PDO::FETCH_ASSOC);
    
    // Get FAQ items
    $faqItems = $pdo->prepare("SELECT * FROM theme_contents WHERE theme_id = ? AND page_key = 'faq_item' AND status = 'published' ORDER BY sort_order ASC");
    $faqItems->execute([$themeId]);
    $faqItems = $faqItems->fetchAll(PDO::FETCH_ASSOC);
    
    // Get partner items
    $partnerItems = $pdo->prepare("SELECT * FROM theme_contents WHERE theme_id = ? AND page_key = 'partner' AND status = 'published' ORDER BY sort_order ASC");
    $partnerItems->execute([$themeId]);
    $partnerItems = $partnerItems->fetchAll(PDO::FETCH_ASSOC);
    
    // Get media
    $media = $pdo->prepare("SELECT * FROM theme_media WHERE theme_id = ? ORDER BY sort_order ASC");
    $media->execute([$themeId]);
    $media = $media->fetchAll(PDO::FETCH_ASSOC);
    
    // Get banners
    $banners = $pdo->prepare("SELECT * FROM theme_contents WHERE theme_id = ? AND page_key = 'banner' AND status = 'published' ORDER BY sort_order ASC");
    $banners->execute([$themeId]);
    $banners = $banners->fetchAll(PDO::FETCH_ASSOC);
    
    // Get FAQ categories
    $faqCategories = $pdo->prepare("SELECT DISTINCT title FROM theme_contents WHERE theme_id = ? AND page_key = 'faq_item' AND status = 'published'");
    $faqCategories->execute([$themeId]);
    $faqCategories = $faqCategories->fetchAll(PDO::FETCH_ASSOC);
    
    // Get tenant info
    $tenant = $pdo->prepare("SELECT * FROM tenants WHERE id = ? LIMIT 1");
    $tenant->execute([$tenantId]);
    $tenant = $tenant->fetch(PDO::FETCH_ASSOC);
    
    // Build the data array - matching the pattern from previewDemo and previewDemoPage
    $data = [
        'tenant'       => $tenant,
        'theme'        => $theme,
        'settings'     => $settings,
        'page'         => $service,
        'menu'         => $menu,
        'services'     => $services,
        'service'      => $service,
        'gallery'      => $gallery,
        'testimonials' => $testimonials,
        'faqItems'     => $faqItems,
        'faqCategories'=> $faqCategories,
        'siteStats'    => $siteStats,
        'siteFeatures' => $siteFeatures,
        'partnerItems' => $partnerItems,
        'banners'      => $banners,
        'media'        => $media,
        'title'        => $service['title'] . ' - ' . ($settings['site_name'] ?? 'Site'),
        'is_preview'   => true,
        'siteBase'     => '/theme-preview/' . $slug,
        'lang'         => 'ar',
        'dir'          => 'rtl',
        'sectionsConfig' => []
    ];
    
    // Merge settings into data so they're directly accessible as variables
    if ($settings) {
        foreach ($settings as $key => $value) {
            if (!isset($data[$key])) {
                $data[$key] = $value;
            }
        }
    }
    
    // Render the service.php template from the theme folder
    $themePath = __DIR__ . '/../themes/' . $slug . '/service.php';
    
    if (!file_exists($themePath)) {
        http_response_code(404);
        echo "Service template not found for theme: " . htmlspecialchars($slug);
        return;
    }
    
    // Extract all variables for use in the template
    extract($data);
    
    // Include the template
    include $themePath;
}
