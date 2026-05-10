<?php
/**
 * Rakaz Theme Seeder (theme_id=2) - FIXED VERSION
 * Maintenance Company Theme - Warm Copper Design
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

    $theme_id = 2;
    $theme_name = 'rakaz';

    echo "=== Rakaz Theme Seeder (Fixed) ===\n";

    // Step 1: Get tenant_id dynamically
    $tenant = $pdo->query("SELECT id FROM tenants LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    if (!$tenant) {
        // Fallback: try to find any tenant
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
        'display_name' => 'Rakaz - صيانة',
        'description' => 'ثيم احترافي بألوان نحاسية دافئة لشركات الصيانة والخدمات المنزلية',
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
        'site_name' => 'شركة ركاز للصيانة',
        'site_description' => 'شركة ركاز المتخصصة في خدمات الصيانة المنزلية والتجارية. نقدم خدمات موثوقة بأعلى جودة.',
        'site_logo' => '',
        'site_favicon' => '',
        'primary_color' => '#c97b47',
        'secondary_color' => '#2d2520',
        'accent_color' => '#e8a96f',
        'text_color' => '#2d2520',
        'light_text' => '#f8f5f1',
        'bg_color' => '#f8f5f1',
        'card_bg' => '#ffffff',
        'font_family' => 'Cairo, Tajawal, sans-serif',
        'heading_font' => 'Cairo, sans-serif',
        'border_radius' => '35px',
        'contact_email' => 'info@rakaz-maintenance.com',
        'contact_phone' => '+966 50 123 4567',
        'contact_address' => 'الرياض، المملكة العربية السعودية',
        'social_facebook' => 'https://facebook.com/rakaz',
        'social_twitter' => 'https://twitter.com/rakaz',
        'social_instagram' => 'https://instagram.com/rakaz',
        'social_whatsapp' => 'https://wa.me/966501234567',
        'footer_text' => '© 2025 شركة ركاز للصيانة. جميع الحقوق محفوظة.',
        'created_at' => date('Y-m-d H:i:s')
    ]);
    echo "Settings inserted.\n";

    // Step 5: Insert theme contents (pages)
    echo "Inserting page contents...\n";

    $pages = [
        [
            'page_key' => 'home',
            'title' => 'الرئيسية',
            'heading' => 'حلول صيانة موثوقة لمنزلك',
            'subheading' => 'نقدم خدمات صيانة شاملة بأيدي فنيين محترفين وبأسعار تنافسية',
            'content' => '<p>شركة ركاز للصيانة هي الشريك الأمثل لجميع احتياجاتك من الصيانة المنزلية والتجارية. نعمل بأحدث التقنيات وأعلى معايير الجودة لنضمن رضاكم الكامل.</p>',
            'hero_image' => '',
            'status' => 'published',
            'sort_order' => 1
        ],
        [
            'page_key' => 'services',
            'title' => 'خدماتنا',
            'heading' => 'خدماتنا المتميزة',
            'subheading' => 'نقدم مجموعة واسعة من خدمات الصيانة المتخصصة',
            'content' => '<p>نوفر لكم مجموعة شاملة من خدمات الصيانة التي تغطي جميع احتياجاتكم المنزلية والتجارية.</p>',
            'hero_image' => '',
            'status' => 'published',
            'sort_order' => 2
        ],
        [
            'page_key' => 'about',
            'title' => 'من نحن',
            'heading' => 'عن شركة ركاز',
            'subheading' => 'خبرة تتجاوز 15 عاماً في عالم الصيانة',
            'content' => '<p>تأسست شركة ركاز للصيانة عام 2010 بهدف تقديم خدمات صيانة احترافية وموثوقة. نمتلك فريقاً من الفنيين المتخصصين والحاصلين على أعلى الشهادات المهنية.</p><p>نؤمن بأن الصيانة الجيدة هي أساس الراحة والسلامة في المنزل والمكتب. لذلك نحرص على تقديم خدمات عالية الجودة مع ضمان شامل على جميع أعمالنا.</p>',
            'hero_image' => '',
            'status' => 'published',
            'sort_order' => 3
        ],
        [
            'page_key' => 'contact',
            'title' => 'اتصل بنا',
            'heading' => 'تواصل معنا',
            'subheading' => 'نحن هنا لمساعدتك. تواصل معنا في أي وقت',
            'content' => '<p>لا تتردد في التواصل معنا لأي استفسار أو طلب خدمة. فريقنا جاهز لخدمتك على مدار الساعة.</p>',
            'hero_image' => '',
            'status' => 'published',
            'sort_order' => 4
        ],
        [
            'page_key' => 'gallery',
            'title' => 'أعمالنا',
            'heading' => 'معرض أعمالنا',
            'subheading' => 'نماذج من مشاريعنا المكتملة بنجاح',
            'content' => '<p>اطلع على مجموعة من أعمالنا السابقة التي نفتخر بها.</p>',
            'hero_image' => '',
            'status' => 'published',
            'sort_order' => 5
        ],
        [
            'page_key' => 'faq',
            'title' => 'الأسئلة الشائعة',
            'heading' => 'الأسئلة المتكررة',
            'subheading' => 'إجابات على أكثر الأسئلة شيوعاً حول خدماتنا',
            'content' => '<p>هنا تجد إجابات على الأسئلة الأكثر شيوعاً حول خدماتنا وعملياتنا.</p>',
            'hero_image' => '',
            'status' => 'published',
            'sort_order' => 6
        ],
        [
            'page_key' => 'partners',
            'title' => 'شركاؤنا',
            'heading' => 'شركاء النجاح',
            'subheading' => 'نفتخر بشراكتنا مع نخبة من الشركات والمؤسسات الرائدة',
            'content' => '<p>نعمل مع أفضل الشركات والمؤسسات لتقديم خدمات متميزة.</p>',
            'hero_image' => '',
            'status' => 'published',
            'sort_order' => 7
        ],
        [
            'page_key' => 'booking',
            'title' => 'حجز موعد',
            'heading' => 'احجز موعدك الآن',
            'subheading' => 'احجز موعد لخدمة الصيانة بسهولة وسرعة',
            'content' => '<p>يمكنك حجز موعد لخدمة الصيانة بكل سهولة. املأ النموذج وسنتواصل معك في أقرب وقت.</p>',
            'hero_image' => '',
            'status' => 'published',
            'sort_order' => 8
        ]
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
        ['title' => 'صيانة المكيفات', 'slug' => 'ac-maintenance', 'description' => '<p>خدمة صيانة وتنظيف المكيفات بأنواعها المختلفة. نقوم بالكشف عن الأعطال وإصلاحها، وتنظيف الفلاتر والفريون، وضمان كفاءة التبريد.</p>', 'icon' => 'fas fa-snowflake', 'sort_order' => 1],
        ['title' => 'سباكة منزلية', 'slug' => 'plumbing', 'description' => '<p>حلول سباكة متكاملة تشمل إصلاح التسريبات، تركيب الأنابيب، صيانة الحمامات والمطابخ، وتنظيف المجاري.</p>', 'icon' => 'fas fa-wrench', 'sort_order' => 2],
        ['title' => 'كهرباء المنازل', 'slug' => 'electrical', 'description' => '<p>خدمات كهربائية شاملة: تمديدات كهربائية، إصلاح الأعطال، تركيب الإضاءة، وصيانة لوحات التوزيع.</p>', 'icon' => 'fas fa-bolt', 'sort_order' => 3],
        ['title' => 'دهانات وتشطيبات', 'slug' => 'painting', 'description' => '<p>خدمات دهان احترافية للمنازل والمكاتب. نستخدم أجود أنواع الدهانات مع فريق فنيين متخصصين لضمان نتيجة مثالية.</p>', 'icon' => 'fas fa-paint-roller', 'sort_order' => 4],
        ['title' => 'أعمال النجارة', 'slug' => 'carpentry', 'description' => '<p>خدمات نجارة متخصصة تشمل إصلاح الأثاث، تركيب الأبواب والنوافذ، وصناعة المطابخ والأرفف حسب الطلب.</p>', 'icon' => 'fas fa-hammer', 'sort_order' => 5],
        ['title' => 'تنظيف شامل', 'slug' => 'cleaning', 'description' => '<p>خدمات تنظيف شاملة للمنازل والمكاتب. نقدم تنظيف يومي، أسبوعي، أو شهرية بأحدث المعدات والمواد الآمنة.</p>', 'icon' => 'fas fa-broom', 'sort_order' => 6],
        ['title' => 'صيانة عامة', 'slug' => 'general-maintenance', 'description' => '<p>خدمة صيانة عامة تشمل إصلاح الأبواب، النوافذ، الأثاث، والأجهزة المنزلية. فريقنا جاهز لأي طلب.</p>', 'icon' => 'fas fa-tools', 'sort_order' => 7],
        ['title' => 'تركيبات ونجارة دقيقة', 'slug' => 'installations', 'description' => '<p>خدمات تركيب احترافية للأجهزة المنزلية، الستائر، المرايا، والأرفف. نضمن التركيب الدقيق والآمن.</p>', 'icon' => 'fas fa-cog', 'sort_order' => 8]
    ];

    foreach ($services as $svc) {
        dynamicInsert($pdo, 'theme_contents', [
            'theme_id' => $theme_id,
            'tenant_id' => $tenant_id,
            'page_key' => 'service',
            'title' => $svc['title'],
            'slug' => $svc['slug'],
            'heading' => $svc['title'],
            'subheading' => 'خدمة احترافية من فريق ركاز',
            'content' => $svc['description'],
            'icon' => $svc['icon'],
            'status' => 'published',
            'sort_order' => $svc['sort_order'],
            'lang' => 'ar',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    echo count($services) . " services inserted.\n";

    // Step 7: Insert testimonials
    echo "Inserting testimonials...\n";

    $testimonials = [
        ['title' => 'أحمد الراشد', 'content' => 'خدمة ممتازة وسريعة. فريق ركاز محترف جداً وأنصح الجميع بالتعامل معهم.', 'icon' => 'fas fa-user-circle'],
        ['title' => 'فاطمة العمري', 'content' => 'تعاملت معهم في صيانة المكيفات وكنت سعيدة بالنتيجة. أسعار معقولة وجودة عالية.', 'icon' => 'fas fa-user-circle'],
        ['title' => 'خالد السعيد', 'content' => 'صيانة كهرباء احترافية. الفريق وصل في الوقت المحدد وأنهى العمل بكفاءة عالية.', 'icon' => 'fas fa-user-circle'],
        ['title' => 'نورة الحربي', 'content' => 'خدمة تنظيف شاملة ممتازة. المنزل أصبح نظيفاً كأنه جديد. شكراً لكم يا ركاز.', 'icon' => 'fas fa-user-circle']
    ];

    foreach ($testimonials as $idx => $test) {
        dynamicInsert($pdo, 'theme_contents', [
            'theme_id' => $theme_id,
            'tenant_id' => $tenant_id,
            'page_key' => 'testimonial',
            'title' => $test['title'],
            'content' => $test['content'],
            'icon' => $test['icon'],
            'sort_order' => $idx + 1,
            'status' => 'published',
            'lang' => 'ar',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    echo count($testimonials) . " testimonials inserted.\n";

    // Step 8: Insert FAQ items
    echo "Inserting FAQs...\n";

    $faqs = [
        ['title' => 'ما هي المناطق التي تغطونها؟', 'content' => '<p>نغطي جميع مناطق الرياض والمناطق المحيطة بها. يمكنكم الاستفسار عن تغطية منطقتكم عبر الاتصال بنا.</p>', 'sort_order' => 1],
        ['title' => 'هل تقدمون ضماناً على الخدمات؟', 'content' => '<p>نعم، نقدم ضماناً شاملاً لمدة 3 أشهر على جميع خدمات الصيانة. يشمل الضمان إصلاح أي عيوب في العمل المنجز.</p>', 'sort_order' => 2],
        ['title' => 'كيف يمكنني حجز موعد؟', 'content' => '<p>يمكنكم حجز موعد عبر نموذج الحجز في موقعنا، أو الاتصال المباشر على الرقم 966501234567+، أو عبر الواتساب.</p>', 'sort_order' => 3],
        ['title' => 'ما هي طرق الدفع المتاحة؟', 'content' => '<p>نقبل الدفع النقدي، التحويل البنكي، وشبكة مدى. يمكن الاتفاق على خطة دفع مرنة للمشاريع الكبيرة.</p>', 'sort_order' => 4],
        ['title' => 'هل تقدمون خدمات طارئة؟', 'content' => '<p>نعم، لدينا خدمة صيانة طارئة متاحة على مدار الساعة. يمكنكم الاتصال بنا مباشرة للحالات الطارئة.</p>', 'sort_order' => 5]
    ];

    foreach ($faqs as $faq) {
        dynamicInsert($pdo, 'theme_contents', [
            'theme_id' => $theme_id,
            'tenant_id' => $tenant_id,
            'page_key' => 'faq_item',
            'title' => $faq['title'],
            'content' => $faq['content'],
            'sort_order' => $faq['sort_order'],
            'status' => 'published',
            'lang' => 'ar',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    echo count($faqs) . " FAQs inserted.\n";

    // Step 9: Insert stats
    echo "Inserting site stats...\n";

    $stats = [
        ['title' => '+15', 'content' => 'سنة خبرة', 'icon' => 'fas fa-calendar-alt'],
        ['title' => '+5000', 'content' => 'عميل سعيد', 'icon' => 'fas fa-smile'],
        ['title' => '+12000', 'content' => 'خدمة مكتملة', 'icon' => 'fas fa-check-circle'],
        ['title' => '+50', 'content' => 'فني متخصص', 'icon' => 'fas fa-user-tie']
    ];

    foreach ($stats as $idx => $stat) {
        dynamicInsert($pdo, 'theme_contents', [
            'theme_id' => $theme_id,
            'tenant_id' => $tenant_id,
            'page_key' => 'stat',
            'title' => $stat['title'],
            'content' => $stat['content'],
            'icon' => $stat['icon'],
            'sort_order' => $idx + 1,
            'status' => 'published',
            'lang' => 'ar',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    echo count($stats) . " stats inserted.\n";

    // Step 10: Insert features
    echo "Inserting features...\n";

    $features = [
        ['title' => 'فنيون معتمدون', 'content' => 'جميع فنيينا حاصلون على شهادات مهنية معتمدة وخبرة واسعة.', 'icon' => 'fas fa-certificate'],
        ['title' => 'أسعار تنافسية', 'content' => 'نقدم أسعاراً منافسة مع شفافية كاملة في التكاليف.', 'icon' => 'fas fa-tags'],
        ['title' => 'ضمان شامل', 'content' => 'ضمان 3 أشهر على جميع أعمال الصيانة مع خدمة متابعة.', 'icon' => 'fas fa-shield-alt'],
        ['title' => 'خدمة 24/7', 'content' => 'فريق الدعم والخدمة الطارئة متاح على مدار الساعة.', 'icon' => 'fas fa-clock'],
        ['title' => 'مواد أصلية', 'content' => 'نستخدم قطع غيار ومواد أصلية من أفضل الشركات المصنعة.', 'icon' => 'fas fa-gem'],
        ['title' => 'التزام بالمواعيد', 'content' => 'نحترم وقتكم ونلتزم بالمواعيد المحددة بدقة.', 'icon' => 'fas fa-calendar-check']
    ];

    foreach ($features as $idx => $feat) {
        dynamicInsert($pdo, 'theme_contents', [
            'theme_id' => $theme_id,
            'tenant_id' => $tenant_id,
            'page_key' => 'feature',
            'title' => $feat['title'],
            'content' => $feat['content'],
            'icon' => $feat['icon'],
            'sort_order' => $idx + 1,
            'status' => 'published',
            'lang' => 'ar',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    echo count($features) . " features inserted.\n";

    // Step 11: Insert partner items
    echo "Inserting partners...\n";

    $partners = [
        ['title' => 'شركة الأفق للعقارات', 'icon' => 'fas fa-building'],
        ['title' => 'مجموعة الرياض للتطوير', 'icon' => 'fas fa-city'],
        ['title' => 'شركة النور للمقاولات', 'icon' => 'fas fa-hard-hat'],
        ['title' => 'مؤسسة السلامة للخدمات', 'icon' => 'fas fa-hands-helping'],
        ['title' => 'شركة الإبداع للتصميم', 'icon' => 'fas fa-pencil-ruler']
    ];

    foreach ($partners as $idx => $partner) {
        dynamicInsert($pdo, 'theme_contents', [
            'theme_id' => $theme_id,
            'tenant_id' => $tenant_id,
            'page_key' => 'partner',
            'title' => $partner['title'],
            'icon' => $partner['icon'],
            'sort_order' => $idx + 1,
            'status' => 'published',
            'lang' => 'ar',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    echo count($partners) . " partners inserted.\n";

    echo "\n=== SUCCESS: Rakaz theme seeded successfully! ===\n";
    echo "Theme ID: $theme_id\n";
    echo "Preview URL: /theme-preview/rakaz\n";

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
