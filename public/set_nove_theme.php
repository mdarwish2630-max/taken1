<?php
/**
 * Nove Theme Seeder (theme_id=4) - FIXED VERSION
 * Cleaning Company Theme - Orange Design
 * Fix: DELETE before INSERT to prevent duplicate key errors
 */
require_once __DIR__ . '/../app/config/config.php';

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER,
        DB_PASS
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $theme_id = 4;
    $theme_name = 'nove';

    echo "=== Nove Theme Seeder (Fixed) ===\n";

    // Step 1: Get tenant_id dynamically
    $tenant = $pdo->query("SELECT id FROM tenants LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    if (!$tenant) {
        $tenant = $pdo->query("SELECT id FROM tenants ORDER BY id ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    }
    $tenant_id = $tenant ? $tenant['id'] : 1;
    echo "Using tenant_id: $tenant_id\n";

    // Step 2: CLEAN EXISTING DATA FIRST - prevents duplicate key errors
    echo "Cleaning existing data...\n";
    $pdo->exec("SET FOREIGN_KEY_CHECKS=0");
    $pdo->exec("DELETE FROM theme_settings WHERE theme_id = " . (int)$theme_id);
    $pdo->exec("DELETE FROM theme_contents WHERE theme_id = " . (int)$theme_id);
    $pdo->exec("DELETE FROM theme_media WHERE theme_id = " . (int)$theme_id);
    $pdo->exec("DELETE FROM themes WHERE id = " . (int)$theme_id);
    $pdo->exec("SET FOREIGN_KEY_CHECKS=1");
    echo "Old data cleaned.\n";

    // Dynamic INSERT function
    function dynamicInsert($pdo, $table, $data) {
        $columns = [];
        $placeholders = [];
        $values = [];
        foreach ($data as $key => $value) {
            $columns[] = "`" . str_replace('`', '``', $key) . "`";
            $placeholders[] = "?";
            $values[] = $value;
        }
        $sql = "INSERT INTO `$table` (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($values);
        return $pdo->lastInsertId();
    }

    // Step 3: Insert theme record
    echo "Inserting theme...\n";
    dynamicInsert($pdo, 'themes', [
        'id' => $theme_id,
        'name' => $theme_name,
        'display_name' => 'Nove - تنظيف',
        'description' => 'ثيم عصري بألوان برتقالية لشركات التنظيف وخدمات المنازل',
        'version' => '1.0.0',
        'is_active' => 1,
        'tenant_id' => $tenant_id,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ]);
    echo "Theme inserted (ID: $theme_id)\n";

    // Step 4: Insert theme settings
    echo "Inserting settings...\n";
    dynamicInsert($pdo, 'theme_settings', [
        'theme_id' => $theme_id,
        'tenant_id' => $tenant_id,
        'site_name' => 'شركة نوف للتنظيف',
        'site_description' => 'شركة نوف المتخصصة في خدمات التنظيف المنزلية والتجارية بأحدث المعدات',
        'site_logo' => '',
        'site_favicon' => '',
        'primary_color' => '#ff6b2c',
        'secondary_color' => '#1a1a2e',
        'accent_color' => '#ff9a56',
        'text_color' => '#333333',
        'light_text' => '#ffffff',
        'bg_color' => '#ffffff',
        'card_bg' => '#f8f9fa',
        'font_family' => 'Cairo, Tajawal, sans-serif',
        'heading_font' => 'Cairo, sans-serif',
        'border_radius' => '16px',
        'contact_email' => 'info@nove-cleaning.com',
        'contact_phone' => '+966 55 987 6543',
        'contact_address' => 'جدة، المملكة العربية السعودية',
        'social_facebook' => 'https://facebook.com/nove',
        'social_twitter' => 'https://twitter.com/nove',
        'social_instagram' => 'https://instagram.com/nove',
        'social_whatsapp' => 'https://wa.me/966559876543',
        'footer_text' => '© 2025 شركة نوف للتنظيف. جميع الحقوق محفوظة.',
        'created_at' => date('Y-m-d H:i:s')
    ]);
    echo "Settings inserted.\n";

    // Step 5: Insert pages
    echo "Inserting page contents...\n";

    $pages = [
        ['page_key' => 'home', 'title' => 'الرئيسية', 'heading' => 'منزلك نظيف بلمسة محترفين', 'subheading' => 'خدمات تنظيف احترافية تجعل منزلك يتألق', 'content' => '<p>شركة نوف للتنظيف تقدم خدمات تنظيف منزلية وتجارية بمعايير عالمية. نستخدم أحدث المعدات والمواد الآمنة لضمان نظافة مثالية.</p>', 'status' => 'published', 'sort_order' => 1],
        ['page_key' => 'services', 'title' => 'خدماتنا', 'heading' => 'خدماتنا المتنوعة', 'subheading' => 'نقدم مجموعة شاملة من خدمات التنظيف المتخصصة', 'content' => '<p>اكتشف مجموعتنا الواسعة من خدمات التنظيف المصممة لتلبية جميع احتياجاتكم.</p>', 'status' => 'published', 'sort_order' => 2],
        ['page_key' => 'about', 'title' => 'من نحن', 'heading' => 'عن نوف', 'subheading' => 'نظافة احترافية منذ 2015', 'content' => '<p>شركة نوف للتنظيف تأسست عام 2015 بهدف تقديم خدمات تنظيف عالية الجودة. نعمل بأحدث التقنيات وفريق مدرب على أعلى مستوى.</p>', 'status' => 'published', 'sort_order' => 3],
        ['page_key' => 'contact', 'title' => 'اتصل بنا', 'heading' => 'تواصل معنا', 'subheading' => 'نسعد بتواصلكم معنا', 'content' => '<p>تواصلوا معنا للاستفسار عن خدماتنا أو لحجز موعد.</p>', 'status' => 'published', 'sort_order' => 4],
        ['page_key' => 'gallery', 'title' => 'أعمالنا', 'heading' => 'معرض أعمالنا', 'subheading' => 'نماذج من أعمالنا المتميزة', 'content' => '<p>شاهد نتائج عملنا المتميز في مجال التنظيف.</p>', 'status' => 'published', 'sort_order' => 5],
        ['page_key' => 'faq', 'title' => 'الأسئلة الشائعة', 'heading' => 'أسئلة متكررة', 'subheading' => 'إجابات على أكثر الأسئلة شيوعاً', 'content' => '<p>إجابات على الأسئلة الأكثر شيوعاً حول خدماتنا.</p>', 'status' => 'published', 'sort_order' => 6],
        ['page_key' => 'partners', 'title' => 'شركاؤنا', 'heading' => 'شركاء نجاحنا', 'subheading' => 'نفتخر بشراكتنا مع أفضل الشركات', 'content' => '<p>تعاوننا مع نخبة من الشركات الرائدة في المملكة.</p>', 'status' => 'published', 'sort_order' => 7],
        ['page_key' => 'booking', 'title' => 'حجز موعد', 'heading' => 'احجز موعدك', 'subheading' => 'احجز خدمة التنظيف بكل سهولة', 'content' => '<p>احجز موعد لخدمة التنظيف بسهولة عبر نموذج الحجز.</p>', 'status' => 'published', 'sort_order' => 8]
    ];

    foreach ($pages as $page) {
        dynamicInsert($pdo, 'theme_contents', array_merge($page, [
            'theme_id' => $theme_id,
            'tenant_id' => $tenant_id,
            'lang' => 'ar',
            'created_at' => date('Y-m-d H:i:s')
        ]));
    }
    echo count($pages) . " pages inserted.\n";

    // Step 6: Insert services
    echo "Inserting services...\n";

    $services = [
        ['title' => 'تنظيف المنازل', 'slug' => 'home-cleaning', 'description' => '<p>خدمة تنظيف شاملة للمنازل تشمل الغرف والمطابخ والحمامات بمعايير عالية الجودة.</p>', 'icon' => 'fas fa-home', 'sort_order' => 1],
        ['title' => 'تنظيف المكاتب', 'slug' => 'office-cleaning', 'description' => '<p>خدمة تنظيف احترافية للمكاتب والمقرات التجارية مع الحفاظ على بيئة عمل نظيفة وصحية.</p>', 'icon' => 'fas fa-building', 'sort_order' => 2],
        ['title' => 'تنظيف السجاد والموكيت', 'slug' => 'carpet-cleaning', 'description' => '<p>خدمة تنظيف متخصصة للسجاد والموكيت بأحدث الأجهزة والمواد المنظفة.</p>', 'icon' => 'fas fa-rug', 'sort_order' => 3],
        ['title' => 'تنظيف الفلل', 'slug' => 'villa-cleaning', 'description' => '<p>خدمة تنظيف شاملة للفلل والقصور تشمل الداخل والخارج والحدائق.</p>', 'icon' => 'fas fa-house-user', 'sort_order' => 4],
        ['title' => 'تنظيف المجالس', 'slug' => ' majlis-cleaning', 'description' => '<p>خدمة تنظيف متخصصة للمجالس والاستراحات مع العناية بالتفاصيل.</p>', 'icon' => 'fas fa-couch', 'sort_order' => 5],
        ['title' => 'تنظيف بعد البناء', 'slug' => 'post-construction', 'description' => '<p>خدمة تنظيف شاملة بعد أعمال البناء والتشطيبات لإزالة الغبار والأتربة.</p>', 'icon' => 'fas fa-hard-hat', 'sort_order' => 6]
    ];

    foreach ($services as $svc) {
        dynamicInsert($pdo, 'theme_contents', [
            'theme_id' => $theme_id,
            'tenant_id' => $tenant_id,
            'page_key' => 'service',
            'title' => $svc['title'],
            'slug' => $svc['slug'],
            'heading' => $svc['title'],
            'subheading' => 'خدمة احترافية من نوف',
            'content' => $svc['description'],
            'icon' => $svc['icon'],
            'status' => 'published',
            'sort_order' => $svc['sort_order'],
            'lang' => 'ar',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    echo count($services) . " services inserted.\n";

    echo "\n=== SUCCESS: Nove theme seeded successfully! ===\n";
    echo "Theme ID: $theme_id\n";
    echo "Preview URL: /theme-preview/nove\n";

} catch (PDOException $e) {
    echo "\n=== ERROR ===\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "\n=== ERROR ===\n";
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
