<?php
 $toArray = function($v) { return is_object($v) ? (array) $v : $v; };
if (isset($page) && is_object($page)) $page = (array) $page;
if (isset($service) && is_object($service)) $service = (array) $service;
if (isset($tenant) && is_object($tenant)) $tenant = (array) $tenant;
if (isset($settings) && is_object($settings)) $settings = (array) $settings;
if (isset($menu) && is_array($menu)) $menu = array_map($toArray, $menu);
if (isset($services) && is_array($services)) $services = array_map($toArray, $services);
if (isset($testimonials) && is_array($testimonials)) $testimonials = array_map($toArray, $testimonials);
if (isset($faqItems) && is_array($faqItems)) $faqItems = array_map($toArray, $faqItems);
if (isset($faqCategories) && is_array($faqCategories)) $faqCategories = array_map($toArray, $faqCategories);
if (isset($siteStats) && is_array($siteStats)) $siteStats = array_map($toArray, $siteStats);
if (isset($siteFeatures) && is_array($siteFeatures)) $siteFeatures = array_map($toArray, $siteFeatures);
if (isset($partnerItems) && is_array($partnerItems)) $partnerItems = array_map($toArray, $partnerItems);
if (isset($gallery) && is_array($gallery)) $gallery = array_map($toArray, $gallery);
if (isset($banners) && is_array($banners)) $banners = array_map($toArray, $banners);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title ?? ($site_name ?? 'ركاز للصيانة')); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($site_description ?? 'شركة ركاز للصيانة'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '<?php echo $primary_color ?? "#c97b47"; ?>',
                        secondary: '<?php echo $secondary_color ?? "#2d2520"; ?>',
                        accent: '<?php echo $accent_color ?? "#e8a96f"; ?>',
                        warm: {
                            50: '#fdfcfa', 100: '#f8f5f1', 200: '#f0ebe4',
                            300: '#e4d9cc', 400: '#d4c3af', 500: '#c97b47',
                            600: '#b56a3a', 700: '#9a5830', 800: '#2d2520', 900: '#1a1614',
                        }
                    },
                    fontFamily: { cairo: ['Cairo', 'sans-serif'] },
                    borderRadius: { 'card': '<?php echo $border_radius ?? "35px"; ?>' }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Cairo', sans-serif; }
        body { background-color: #f8f5f1; }
        .hero-gradient { background: linear-gradient(135deg, #2d2520 0%, #4a3728 50%, #c97b47 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(201, 123, 71, 0.2); }
        .btn-primary { background: linear-gradient(135deg, #c97b47, #e8a96f); transition: all 0.3s ease; }
        .btn-primary:hover { background: linear-gradient(135deg, #b56a3a, #c97b47); transform: translateY(-2px); box-shadow: 0 8px 20px rgba(201, 123, 71, 0.4); }
        .section-divider { width: 80px; height: 4px; background: linear-gradient(90deg, #c97b47, #e8a96f); border-radius: 2px; }
        .stat-card { background: linear-gradient(135deg, #2d2520, #4a3728); }
        .faq-item { border: 1px solid rgba(201, 123, 71, 0.2); transition: all 0.3s ease; }
        .faq-item:hover { border-color: #c97b47; }
        .scroll-smooth { scroll-behavior: smooth; }
        .service-icon-wrapper { background: linear-gradient(135deg, rgba(201,123,71,0.1), rgba(232,169,111,0.1)); }
    </style>
</head>
<body class="scroll-smooth text-secondary">