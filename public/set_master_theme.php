<?php
/**
 * ============================================================================
 *  Takween CMS — Master Theme: FULL Demo Data Seeder
 *  Fills ALL theme content, settings, media, tenant data, and sections.
 * ============================================================================
 *  Usage:  php set_master_theme.php   (CLI or browser via /public/)
 * ============================================================================
 */

$host = 'localhost'; $dbname = 'takween'; $user = 'root'; $pass = '';
try {
    $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $user, $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false]);
    echo "<p style='color:green'>&#10003; Connected to `{$dbname}`</p>\n";
} catch (PDOException $e) {
    die("<p style='color:red'>&#10007; DB error: " . $e->getMessage() . "</p>");
}

$now = date('Y-m-d H:i:s');
$totalRows = 0;

/**
 * Helper: ensure a column exists in a table, add it if missing
 */
function ensureColumn($pdo, $table, $column, $type) {
    $cols = array_column($pdo->query("SHOW COLUMNS FROM `{$table}`")->fetchAll(PDO::FETCH_ASSOC), 'Field');
    if (!in_array($column, $cols)) {
        $pdo->exec("ALTER TABLE `{$table}` ADD COLUMN `{$column}` {$type}");
        return true;
    }
    return false;
}

try {
    // ════════════════════════════════════════════════════════════════
    // Step 0: Ensure ALL required columns exist (Model compatibility)
    // ════════════════════════════════════════════════════════════════
    $addedCols = 0;

    // theme_contents columns needed by ThemeContent model
    $tcRequired = [
        'theme_id'     => 'INT UNSIGNED NOT NULL DEFAULT 0',
        'section_type' => "VARCHAR(100) NOT NULL DEFAULT ''",
        'content_key'  => "VARCHAR(255) NOT NULL DEFAULT ''",
        'content_ar'   => 'LONGTEXT DEFAULT NULL',
        'content_en'   => 'LONGTEXT DEFAULT NULL',
        'sort_order'   => 'INT NOT NULL DEFAULT 0',
        'is_active'    => 'TINYINT(1) NOT NULL DEFAULT 1',
        'created_at'   => 'DATETIME DEFAULT NULL',
        'updated_at'   => 'DATETIME DEFAULT NULL',
    ];
    $tcTable = $pdo->query("SHOW TABLES LIKE 'theme_contents'")->fetchAll();
    if (!empty($tcTable)) {
        foreach ($tcRequired as $col => $type) {
            if (ensureColumn($pdo, 'theme_contents', $col, $type)) $addedCols++;
        }
    }

    // theme_media columns needed by ThemeMedia model
    $tmRequired = [
        'theme_id'    => 'INT UNSIGNED NOT NULL DEFAULT 0',
        'media_type'  => "VARCHAR(50) NOT NULL DEFAULT ''",
        'file_path'   => "VARCHAR(500) NOT NULL DEFAULT ''",
        'file_name'   => "VARCHAR(255) NOT NULL DEFAULT ''",
        'alt_text_ar' => "VARCHAR(500) DEFAULT NULL",
        'alt_text_en' => "VARCHAR(500) DEFAULT NULL",
        'section_ref' => "VARCHAR(100) DEFAULT NULL",
        'sort_order'  => 'INT NOT NULL DEFAULT 0',
        'is_active'   => 'TINYINT(1) NOT NULL DEFAULT 1',
        'created_at'  => 'DATETIME DEFAULT NULL',
        'updated_at'  => 'DATETIME DEFAULT NULL',
    ];
    $tmTable = $pdo->query("SHOW TABLES LIKE 'theme_media'")->fetchAll();
    if (!empty($tmTable)) {
        foreach ($tmRequired as $col => $type) {
            if (ensureColumn($pdo, 'theme_media', $col, $type)) $addedCols++;
        }
    }

    // theme_settings columns
    $tsRequired = [
        'tenant_id'   => 'INT UNSIGNED NOT NULL DEFAULT 0',
        'created_at'  => 'DATETIME DEFAULT NULL',
        'updated_at'  => 'DATETIME DEFAULT NULL',
    ];
    $tsTable = $pdo->query("SHOW TABLES LIKE 'theme_settings'")->fetchAll();
    if (!empty($tsTable)) {
        foreach ($tsRequired as $col => $type) {
            if (ensureColumn($pdo, 'theme_settings', $col, $type)) $addedCols++;
        }
    }

    if ($addedCols > 0) {
        echo "<p style='color:orange'>&#9888; Added {$addedCols} missing columns to tables</p>\n";
    }

    // ════════════════════════════════════════════════════════════════
    // Step 1: Delete ALL old theme data
    // ════════════════════════════════════════════════════════════════
    foreach (['theme_media', 'theme_contents', 'theme_settings'] as $tbl) {
        $t = $pdo->query("SHOW TABLES LIKE '{$tbl}'")->fetchAll();
        if (!empty($t)) { $pdo->exec("DELETE FROM {$tbl}"); echo "<p style='color:green'>&#10003; Cleared {$tbl}</p>\n"; }
    }
    $pdo->exec("DELETE FROM themes");
    echo "<p style='color:green'>&#10003; Cleared themes</p>\n";

    // ════════════════════════════════════════════════════════════════
    // Step 2: Create the Master theme
    // ════════════════════════════════════════════════════════════════
    {
        $thCols = array_column($pdo->query("SHOW COLUMNS FROM themes")->fetchAll(PDO::FETCH_ASSOC), 'Field');
        $thSet = array_flip($thCols);
        $thColsInsert = ['id', 'name', 'name_en', 'slug', 'description', 'category', 'is_active', 'is_paid'];
        if (isset($thSet['created_at'])) $thColsInsert[] = 'created_at';
        if (isset($thSet['updated_at'])) $thColsInsert[] = 'updated_at';

        $thValues = [1, 'ماستر فيكس', 'Master Fix', 'master',
            'ثيم احترافي عصري — خلفية داكنة مع لون سيان — مثالي لشركات الصيانة والخدمات',
            'maintenance', 1, 0];
        if (isset($thSet['created_at'])) $thValues[] = $now;
        if (isset($thSet['updated_at'])) $thValues[] = $now;

        $thPlaceholders = implode(', ', array_fill(0, count($thColsInsert), '?'));
        $thSql = "INSERT INTO themes (`" . implode('`, `', $thColsInsert) . "`) VALUES ({$thPlaceholders})";
        $pdo->prepare($thSql)->execute($thValues);
    }
    echo "<p style='color:green'>&#10003; Created 'master' theme (ID: 1)</p>\n";

    // ════════════════════════════════════════════════════════════════
    // Step 3: theme_settings per tenant (ALL 25+ columns)
    // ════════════════════════════════════════════════════════════════
    $tenantIds = $pdo->query("SELECT id FROM tenants")->fetchAll(PDO::FETCH_COLUMN);

    if (!empty($tenantIds)) {
        $colRows = $pdo->query("SHOW COLUMNS FROM theme_settings")->fetchAll(PDO::FETCH_ASSOC);
        $colSet = [];
        foreach ($colRows as $row) { $colSet[$row['Field']] = true; }

        // COMPLETE mapping: all 25+ settings columns
        $map = [
            // Typography
            'primary_font'        => 'Tajawal',
            'secondary_font'      => 'Tajawal',
            'base_font_size'      => '16',
            'heading_font_weight' => '800',
            'body_font_weight'    => '400',
            // Colors — Master dark theme
            'primary_color'       => '#06b6d4',
            'secondary_color'     => '#0f172a',
            'accent_color'        => '#22d3ee',
            'text_color'          => '#ffffff',
            'text_muted_color'    => '#94a3b8',
            'background_color'    => '#0f172a',
            'card_background'     => '#111827',
            'border_color'        => 'rgba(255,255,255,0.08)',
            // Border / Radius
            'border_radius'       => '16',
            'button_radius'       => '16',
            'card_radius'         => '24',
            // Style variants
            'header_style'        => 'default',
            'hero_style'          => 'split',
            'button_style'        => 'rounded',
            'button_shadow'       => '1',
            'card_style'          => 'bordered',
            'card_hover_effect'   => 'glow',
            // Animation
            'enable_animations'   => '1',
            'animation_type'      => 'fade',
            // Layout
            'container_width'     => '1200',
            'header_fixed'        => '1',
            'sidebar_position'    => 'none',
            'footer_style'        => 'default',
            // Custom
            'custom_css'          => '',
            'custom_js'           => '',
        ];

        // Build INSERT dynamically based on existing columns
        $names = [];
        $vals  = [];
        foreach ($map as $col => $val) {
            if (isset($colSet[$col])) {
                $names[] = $col;
                $vals[]  = $val;
            }
        }

        if (!empty($names)) {
            $colList  = '`tenant_id`, ' . implode(', ', array_map(fn($c) => '`' . $c . '`', $names));
            $valsBase = $vals;
            if (isset($colSet['created_at'])) { $colList .= ', `created_at`'; $valsBase[] = $now; }
            if (isset($colSet['updated_at'])) { $colList .= ', `updated_at`'; $valsBase[] = $now; }
            $holders  = implode(', ', array_fill(0, count($names) + 1 + (isset($colSet['created_at']) ? 1 : 0) + (isset($colSet['updated_at']) ? 1 : 0), '?'));
            $sql      = "INSERT INTO theme_settings ({$colList}) VALUES ({$holders})";
            $stmt     = $pdo->prepare($sql);

            foreach ($tenantIds as $tid) {
                $params = array_merge([(int)$tid], $valsBase);
                $stmt->execute($params);
            }
            echo "<p style='color:green'>&#10003; Created theme_settings for " . count($tenantIds) . " tenants (" . count($names) . " settings columns)</p>\n";
        }
    } else {
        echo "<p style='color:orange'>&#9888; No tenants found — skipping theme_settings</p>\n";
    }

    // ════════════════════════════════════════════════════════════════
    // Step 4: Seed theme_contents — COMPREHENSIVE demo data
    // ════════════════════════════════════════════════════════════════
    $tc = $pdo->query("SHOW TABLES LIKE 'theme_contents'")->fetchAll();
    $contentRows = [];

    if (!empty($tc)) {

        // ──── HERO ────
        $contentRows[] = ['hero', 'hero_title',
            'خدمات <span style="color:#06b6d4">الصيانة</span> الحديثة باحترافية عالية',
            'Professional <span style="color:#06b6d4">Maintenance</span> Services with Excellence', 1];
        $contentRows[] = ['hero', 'hero_subtitle',
            'أكثر من 5000 عميل يثق بنا',
            'Trusted by over 5,000 clients', 2];
        $contentRows[] = ['hero', 'hero_description',
            'نقدم حلول صيانة متكاملة للمنازل والشركات بأحدث التقنيات، سرعة استجابة، وفريق متخصص لضمان أفضل النتائج. نعمل على مدار الساعة لتوفير خدمات موثوقة تلبي جميع احتياجاتكم.',
            'We deliver integrated maintenance solutions for homes and companies with the latest technologies, fast response, and a specialized team to ensure the best results. We operate around the clock to provide reliable services.',
            3];
        $contentRows[] = ['hero', 'hero_button_text',
            'احجز خدمة',
            'Book Now', 4];

        // ──── SERVICES (6 services with prices) ────
        $services = [
            ['svc_electric', 'صيانة الكهرباء', 'Electrical Services',
             'تمديدات كهربائية، صيانة، تركيب وفحص كامل للمنازل والمكاتب. فريق معتمد بخبرة تتجاوز 10 سنوات في جميع أنواع الأعمال الكهربائية.',
             'Electrical wiring, maintenance, installation and full inspection for homes and offices. Certified team with 10+ years of experience.',
             'fas fa-bolt', '150 ₺', '150 TL'],
            ['svc_plumbing', 'خدمات السباكة', 'Plumbing Services',
             'إصلاح التسريبات وصيانة وتركيب الأنابيب بأحدث التقنيات. نقدم خدمات طوارئ على مدار الساعة مع ضمان على جميع أعمالنا.',
             'Leak repair, pipe maintenance and installation with latest technology. 24/7 emergency service with warranty on all work.',
             'fas fa-faucet-drip', '100 ₺', '100 TL'],
            ['svc_ac', 'التكييف والتبريد', 'AC & Cooling',
             'صيانة التكييف وحلول تبريد ذكية. تشمل الخدمة التنظيف، تعبئة الغاز، فحص الضغط، وتركيب الأجهزة الجديدة.',
             'AC maintenance and smart cooling solutions. Services include cleaning, gas refill, pressure testing, and new unit installation.',
             'fas fa-snowflake', '200 ₺', '200 TL'],
            ['svc_home', 'إصلاح المنازل', 'Home Repair',
             'خدمات احترافية لمعالجة جميع أعطال المنزل من دهان ونجارة وبلاط وأعمال سباكة خفيفة. فريق شامل تحت سقف واحد.',
             'Professional services for all home repairs including painting, carpentry, tiling, and light plumbing. Complete team under one roof.',
             'fas fa-house-chimney', '80 ₺', '80 TL'],
            ['svc_painting', 'الدهانات والديكور', 'Painting & Decor',
             'دهانات داخلية وخارجية بأفضل أنواع الطلاء. تشمل الخدمة التحضير والتنظيف والتشطيب مع ضمان نظافة المكان.',
             'Interior and exterior painting with premium materials. Includes surface preparation, cleaning, and finishing with site cleanliness guarantee.',
             'fas fa-paint-roller', '120 ₺', '120 TL'],
            ['svc_lock', 'أقفال وأبواب', 'Locks & Doors',
             'تركيب وإصلاح الأقفال والأبواب بكل أنواعها. نتعامل مع جميع الماركات العالمية ونوفر قطع الغيار الأصلية.',
             'Installation and repair of all lock and door types. We work with all major brands and provide genuine spare parts.',
             'fas fa-lock', '90 ₺', '90 TL'],
        ];
        foreach ($services as $i => $svc) {
            $jsonAr = json_encode([
                'title_ar' => $svc[1], 'title_en' => $svc[2],
                'description_ar' => $svc[3], 'description_en' => $svc[4],
                'icon' => $svc[5], 'price' => $svc[6], 'price_text' => $svc[6],
                'show_on_home' => 1,
            ], JSON_UNESCAPED_UNICODE);
            $jsonEn = json_encode(['title_en' => $svc[2], 'description_en' => $svc[4], 'price' => $svc[7]], JSON_UNESCAPED_UNICODE);
            $contentRows[] = ['services', $svc[0], $jsonAr, $jsonEn, $i + 1];
        }

        // ──── TESTIMONIALS (4) ────
        $testimonials = [
            ['أحمد محمد', 'Ahmed Mohammed', 'مدير شركة', 'Company Manager',
             'خدمة ممتازة وسريعة. الفريق محترف جداً وأنصح الجميع بالتعامل معهم. وصلوا خلال ساعة وخلصوا الشغل بإتقان.',
             'Excellent and fast service. Very professional team, I recommend them to everyone. Arrived within an hour and completed the work perfectly.', 5],
            ['سارة عبدالله', 'Sara Abdullah', 'ربة منزل', 'Homeowner',
             'تجربة رائعة من البداية للنهاية. العمل تم بإتقان ونظافة عالية. السعر كان معقول جداً مقارنة بالجودة المقدمة.',
             'Amazing experience from start to finish. The work was done with perfection and high cleanliness. Very reasonable price for the quality.', 5],
            ['خالد العمري', 'Khaled Al-Omari', 'مؤسس', 'Founder',
             'تعاملت معهم عدة مرات وفي كل مرة أكون سعيد بالنتائج. أسعار منافسة وجودة عالية. أنصح بهم لأي مشروع صيانة.',
             'Dealt with them multiple times, always happy with results. Competitive prices and high quality. I recommend them for any maintenance project.', 5],
            ['نورة السعيد', 'Noura Al-Saeed', 'مهندسة', 'Engineer',
             'احترافية عالية والتزام بالمواعيد. فريق عمل منظم ونظيف. النتيجة فاقت توقعاتي وسأكرر التجربة بالتأكيد.',
             'Highly professional and punctual. Organized and clean team. Results exceeded my expectations and I will definitely use them again.', 5],
        ];
        foreach ($testimonials as $i => $t) {
            $jsonAr = json_encode([
                'client_name' => $t[0], 'client_name_en' => $t[1],
                'client_title' => $t[2], 'client_title_en' => $t[3],
                'content' => $t[4], 'content_en' => $t[5], 'rating' => $t[6],
            ], JSON_UNESCAPED_UNICODE);
            $jsonEn = json_encode(['client_name' => $t[1], 'client_title' => $t[3], 'content' => $t[5], 'rating' => $t[6]], JSON_UNESCAPED_UNICODE);
            $contentRows[] = ['testimonials', 'testimonial_' . ($i + 1), $jsonAr, $jsonEn, $i + 1];
        }

        // ──── FEATURES / WHY US (4) ────
        $features = [
            ['استجابة سريعة ودعم طوارئ', 'Fast Response & Emergency',
             'نصل إليكم بسرعة مع فريق مجهز وجاهز لأي حالة طوارئ. متاحون على مدار الساعة 7 أيام في الأسبوع.',
             'Quick arrival with equipped team for any emergency. Available 24/7, 7 days a week.',
             'fas fa-bolt'],
            ['فنيون محترفون ومعتمدون', 'Expert Certified Technicians',
             'فريق معتمد بخبرة عملية واسعة في جميع المجالات. جميع الفنيين حاصلون على شهادات معتمدة.',
             'Certified team with extensive practical experience in all fields. All technicians hold accredited certificates.',
             'fas fa-id-badge'],
            ['أسعار مناسبة وجودة عالية', 'Competitive Prices & High Quality',
             'جودة عالية بأسعار مناسبة للجميع مع ضمان الخدمة. أسعار شفافة بدون مفاجآت.',
             'High quality at affordable prices with service guarantee. Transparent pricing with no surprises.',
             'fas fa-tags'],
            ['معدات حديثة وفحص ذكي', 'Modern Equipment & Smart Inspection',
             'نستخدم أحدث الأدوات والتقنيات مع فحص ذكي شامل بعد كل خدمة. تقرير مفصل بالحالة.',
             'Latest tools and technology with comprehensive smart inspection after each service. Detailed status report.',
             'fas fa-tools'],
        ];
        foreach ($features as $i => $f) {
            $jsonAr = json_encode(['title_ar' => $f[0], 'title_en' => $f[1], 'description_ar' => $f[2], 'description_en' => $f[3], 'icon' => $f[4]], JSON_UNESCAPED_UNICODE);
            $jsonEn = json_encode(['title_en' => $f[1], 'description_en' => $f[3]], JSON_UNESCAPED_UNICODE);
            $contentRows[] = ['features', 'feature_' . ($i + 1), $jsonAr, $jsonEn, $i + 1];
        }

        // ──── STATS (4) ────
        $stats = [
            ['10+ سنوات خبرة', '10+ Years Exp.', '10+', 'fas fa-clock'],
            ['500+ مشروع منجز', '500+ Projects Done', '500+', 'fas fa-project-diagram'],
            ['5,000+ عميل سعيد', '5,000+ Happy Clients', '5K+', 'fas fa-users'],
            ['98% نسبة الرضا', '98% Satisfaction', '98%', 'fas fa-chart-line'],
        ];
        foreach ($stats as $i => $s) {
            $jsonAr = json_encode(['label_ar' => $s[0], 'label_en' => $s[1], 'value' => $s[2], 'icon' => $s[3]], JSON_UNESCAPED_UNICODE);
            $jsonEn = json_encode(['label_en' => $s[1], 'value' => $s[2]], JSON_UNESCAPED_UNICODE);
            $contentRows[] = ['stats', 'stat_' . ($i + 1), $jsonAr, $jsonEn, $i + 1];
        }

        // ──── FAQ (6 items across 4 categories) ────
        $faqs = [
            ['ما هي خدماتكم؟', 'What are your services?',
             'نقدم خدمات صيانة شاملة تشمل الكهرباء، السباكة، التكييف، الدهانات، إصلاح المنازل، والأقفال والأبواب. كل خدمة يقدمها فني متخصص ومعتمد.',
             'We offer comprehensive maintenance including electrical, plumbing, AC, painting, home repair, and locks & doors. Each service is provided by a specialized certified technician.',
             'services'],
            ['ما هي أوقات العمل؟', 'What are your working hours?',
             'فريقنا متاح 24/7 للطوارئ، وخدمات المواعيد العادية من السبت إلى الخميس من 8 صباحاً حتى 8 مساءً. الجمعة عطلة رسمية.',
             'Our team is available 24/7 for emergencies. Regular appointments: Saturday to Thursday, 8 AM to 8 PM. Friday is an official day off.',
             'general'],
            ['كيف أحجز موعد؟', 'How do I book an appointment?',
             'يمكنك الحجز عبر الموقع من صفحة "احجز الآن"، أو الاتصال المباشر على الرقم +90 555 000 000، أو الواتساب. سيتواصل معك فريقنا خلال 15 دقيقة لتأكيد الموعد.',
             'You can book via our website "Book Now" page, direct call at +90 555 000 000, or WhatsApp. Our team will contact you within 15 minutes to confirm.',
             'booking'],
            ['هل تقدمون ضماناً على الخدمات؟', 'Do you offer service warranty?',
             'نعم، نقدم ضماناً على جميع أعمال الصيانة لمدة تصل إلى 6 أشهر حسب نوع الخدمة. في حالة تكرار العطل يتم الإصلاح مجاناً خلال فترة الضمان.',
             'Yes, we provide warranty on all maintenance work for up to 6 months depending on service type. Recurring issues are fixed for free during warranty.',
             'services'],
            ['ما هي مناطق التغطية؟', 'What are your coverage areas?',
             'نغطي جميع مناطق إسطنبول وضواحيها. بالنسبة للمناطق البعيدة يرجى التواصل معنا للتأكد من إمكانية الوصول والتكلفة.',
             'We cover all areas of Istanbul and suburbs. For remote areas, please contact us to confirm availability and any additional travel costs.',
             'general'],
            ['كيف يتم تسعير الخدمات؟', 'How are services priced?',
             'نعمل على أساس تسعير عادل وشفاف. بعد الفحص الأولي المجاني يتم إبلاغك بالتكلفة النهائية قبل بدء العمل بدون أي رسوم مخفية أو مفاجآت.',
             'We work on fair and transparent pricing. After a free initial inspection, you will be informed of the final cost before work starts with no hidden fees.',
             'pricing'],
        ];
        foreach ($faqs as $i => $f) {
            $jsonAr = json_encode(['question_ar' => $f[0], 'question_en' => $f[1], 'answer_ar' => $f[2], 'answer_en' => $f[3], 'category' => $f[4]], JSON_UNESCAPED_UNICODE);
            $jsonEn = json_encode(['question_en' => $f[1], 'answer_en' => $f[3], 'category' => $f[4]], JSON_UNESCAPED_UNICODE);
            $contentRows[] = ['faq', 'faq_' . ($i + 1), $jsonAr, $jsonEn, $i + 1];
        }

        // ──── ABOUT ────
        $contentRows[] = ['about', 'about_content',
            '<p>نحن فريق محترف متخصص في تقديم أعلى مستويات الخدمة في مجال الصيانة المنزلية والتجارية. بخبرة تتجاوز 10 سنوات في السوق التركي، وشغف مستمر بالتميز والابتكار.</p>'
            . '<p>نعمل بأحدث المعدات والتقنيات المتطورة لضمان نتائج تفوق التوقعات في كل مرة. فريقنا المكون من أكثر من 25 فنياً معتمداً جاهز لخدمتكم على مدار الساعة، في أي وقت وفي أي مكان.</p>'
            . '<p>نؤمن بأن الجودة ليست خياراً بل معياراً أساسياً لكل عمل نقوم به. لذلك نقدم ضماناً شاملاً على جميع خدماتنا ونسعى دائماً لبناء علاقات طويلة الأمد مع عملائنا المميزين.</p>',
            '<p>We are a professional team dedicated to providing top-quality home and commercial maintenance services. With over 10 years of experience in the Turkish market and a passion for excellence and innovation.</p>'
            . '<p>We use the latest equipment and cutting-edge technology to ensure results that exceed expectations every time. Our team of 25+ certified technicians is ready to serve you 24/7, anytime, anywhere.</p>'
            . '<p>We believe quality is not an option but a fundamental standard for every job we do. That is why we offer comprehensive warranty on all our services and strive to build lasting relationships with our valued clients.</p>',
            1];

        // ──── CONTACT ────
        $contactAr = json_encode([
            'phone' => '+90 555 000 000',
            'email' => 'info@masterfix.com',
            'whatsapp' => '+90 555 000 000',
            'address' => 'إسطنبول - تركيا، شارع الاستقلال، مبنى الأعمال، الطابق 3',
            'working_hours' => "السبت - الخميس: 8 صباحاً - 8 مساءً\nالجمعة: مغلق\nالطوارئ: 24/7",
        ], JSON_UNESCAPED_UNICODE);
        $contactEn = json_encode([
            'phone' => '+90 555 000 000',
            'email' => 'info@masterfix.com',
            'whatsapp' => '+90 555 000 000',
            'address' => 'Istanbul, Turkey, Istiklal Street, Business Building, Floor 3',
            'working_hours' => "Sat - Thu: 8 AM - 8 PM\nFriday: Closed\nEmergency: 24/7",
        ], JSON_UNESCAPED_UNICODE);
        $contentRows[] = ['contact', 'contact_info', $contactAr, $contactEn, 1];

        // ──── PARTNERS (6) ────
        $partners = [
            ['شركة الأبنية المتقدمة', 'Advanced Buildings Co.', 'https://advanced-buildings.com'],
            ['مؤسسة الطاقة الذكية', 'Smart Energy Corp.', 'https://smart-energy.com'],
            ['شركة الديكور الملكي', 'Royal Decor Co.', 'https://royal-decor.com'],
            ['مجموعة الأمن والحماية', 'Security Group', 'https://security-group.com'],
            ['شركة الأنابيب الأولى', 'First Pipes Co.', 'https://first-pipes.com'],
            ['مؤسسة التبريد المتطور', 'Advanced Cooling Corp.', 'https://advanced-cooling.com'],
        ];
        foreach ($partners as $i => $p) {
            $jsonAr = json_encode(['name_ar' => $p[0], 'name_en' => $p[1], 'website' => $p[2], 'icon' => 'fas fa-building'], JSON_UNESCAPED_UNICODE);
            $jsonEn = json_encode(['name_en' => $p[1], 'website' => $p[2]], JSON_UNESCAPED_UNICODE);
            $contentRows[] = ['partners', 'partner_' . ($i + 1), $jsonAr, $jsonEn, $i + 1];
        }

        // ──── BOOKING PAGE ────
        $contentRows[] = ['booking', 'booking_title',
            'احجز موعدك بسهولة',
            'Book Your Appointment Easily',
            1];
        $contentRows[] = ['booking', 'booking_description',
            'اختر الخدمة المناسبة لك واحجز موعدك في الوقت المفضل. فريقنا المحترف سيتواصل معك لتأكيد الحجز خلال 15 دقيقة.',
            'Choose the right service and book your appointment at your preferred time. Our professional team will contact you to confirm within 15 minutes.',
            2];

        // Dynamic INSERT — detect which columns actually exist
        $tcCols = array_column($pdo->query("SHOW COLUMNS FROM theme_contents")->fetchAll(PDO::FETCH_ASSOC), 'Field');
        $tcColSet = array_flip($tcCols);

        // Base columns we always want to use (if they exist)
        $tcInsertCols = [];
        $tcInsertVals = [];
        foreach (['theme_id', 'section_type', 'content_key', 'content_ar', 'content_en', 'sort_order', 'is_active'] as $col) {
            if (isset($tcColSet[$col])) {
                $tcInsertCols[] = '`' . $col . '`';
            }
        }
        // Optional timestamp columns
        foreach (['created_at', 'updated_at'] as $col) {
            if (isset($tcColSet[$col])) {
                $tcInsertCols[] = '`' . $col . '`';
                $tcInsertVals[] = $now; // will be appended per row
            }
        }

        $tcPlaceholders = implode(', ', array_fill(0, count($tcInsertCols), '?'));
        $tcSql = "INSERT INTO theme_contents (" . implode(', ', $tcInsertCols) . ") VALUES ({$tcPlaceholders})";
        $stmt = $pdo->prepare($tcSql);

        $hasTcTimestamps = isset($tcColSet['created_at']);
        foreach ($contentRows as $row) {
            $params = [1, $row[0], $row[1], $row[2], $row[3], $row[4], 1];
            if ($hasTcTimestamps) {
                $params[] = $now; // created_at
                $params[] = $now; // updated_at
            }
            $stmt->execute($params);
            $totalRows++;
        }
        echo "<p style='color:green'>&#10003; Seeded {$totalRows} theme_content rows (" . count($tcInsertCols) . " columns)</p>\n";
    }

    // ════════════════════════════════════════════════════════════════
    // Step 5: Seed theme_media — with categories for gallery
    // ════════════════════════════════════════════════════════════════
    $tm = $pdo->query("SHOW TABLES LIKE 'theme_media'")->fetchAll();
    $mediaTotal = 0;

    if (!empty($tm)) {
        $tmCols = array_column($pdo->query("SHOW COLUMNS FROM theme_media")->fetchAll(PDO::FETCH_ASSOC), 'Field');
        $hasSectionRef = in_array('section_ref', $tmCols);

        $mediaRows = [
            // Banner
            ['banner', 'banners/maintenance-hero.jpg', 'maintenance-hero.jpg', 'صيانة احترافية', 'Professional Maintenance', 'hero', 1],
            // Logo
            ['logo', 'logos/maintenance-logo.png', 'maintenance-logo.png', 'ماستر فيكس', 'Master Fix', null, 1],
        ];

        // Service images (with section_ref linking to content keys)
        $svcImages = [
            ['service_image', 'services/electrical-wiring.jpg', 'electrical-wiring.jpg', 'صيانة كهرباء', 'Electrical Services', 'svc_electric', 1],
            ['service_image', 'services/plumbing-repair.jpg', 'plumbing-repair.jpg', 'السباكة', 'Plumbing', 'svc_plumbing', 2],
            ['service_image', 'services/ac-repair.jpg', 'ac-repair.jpg', 'التكييف', 'AC Repair', 'svc_ac', 3],
            ['service_image', 'services/interior-design.jpg', 'interior-design.jpg', 'إصلاح المنازل', 'Home Repair', 'svc_home', 4],
            ['service_image', 'services/painting-service.jpg', 'painting-service.jpg', 'الدهانات', 'Painting', 'svc_painting', 5],
            ['service_image', 'services/deep-cleaning.jpg', 'deep-cleaning.jpg', 'أقفال وأبواب', 'Locks & Doors', 'svc_lock', 6],
        ];
        $mediaRows = array_merge($mediaRows, $svcImages);

        // Gallery images — with CATEGORIES in section_ref
        $galleryCategories = ['كهرباء', 'سباكة', 'تبريد', 'ديكور'];
        $galleryCatsEn     = ['Electrical', 'Plumbing', 'Cooling', 'Decor'];
        $galleryImages = [
            ['gallery', 'banners/maintenance-hero.jpg', 'maintenance-hero.jpg', 'مشروع صيانة كهرباء شامل', 'Full electrical maintenance project', $galleryCategories[0], 1],
            ['gallery', 'services/electrical-wiring.jpg', 'electrical-wiring.jpg', 'تمديدات كهربائية حديثة', 'Modern electrical wiring', $galleryCategories[0], 2],
            ['gallery', 'services/plumbing-repair.jpg', 'plumbing-repair.jpg', 'إصلاح تسريب مياه', 'Water leak repair', $galleryCategories[1], 3],
            ['gallery', 'services/ac-repair.jpg', 'ac-repair.jpg', 'صيانة مكيف مركزي', 'Central AC maintenance', $galleryCategories[2], 4],
            ['gallery', 'services/interior-design.jpg', 'interior-design.jpg', 'تشطيب داخلي فاخر', 'Luxury interior finishing', $galleryCategories[3], 5],
            ['gallery', 'services/painting-service.jpg', 'painting-service.jpg', 'دهان واجهات خارجية', 'Exterior painting', $galleryCategories[3], 6],
            ['gallery', 'services/deep-cleaning.jpg', 'deep-cleaning.jpg', 'تركيب أقفال ذكية', 'Smart lock installation', $galleryCategories[0], 7],
            ['gallery', 'banners/maintenance-hero.jpg', 'maintenance-hero-2.jpg', 'مشروع سباكة كامل', 'Complete plumbing project', $galleryCategories[1], 8],
            ['gallery', 'services/electrical-wiring.jpg', 'electrical-2.jpg', 'لوحة تحكم كهربائية', 'Electrical control panel', $galleryCategories[0], 9],
            ['gallery', 'services/ac-repair.jpg', 'ac-2.jpg', 'تركيب وحدة تكييف جديدة', 'New AC unit installation', $galleryCategories[2], 10],
        ];
        $mediaRows = array_merge($mediaRows, $galleryImages);

        // Partner logos
        $partnerLogos = [
            ['partner', 'logos/maintenance-logo.png', 'advanced-buildings.png', 'شركة الأبنية المتقدمة', 'Advanced Buildings Co.', 'partner_1', 1],
            ['partner', 'logos/cleaning-logo.png', 'smart-energy.png', 'مؤسسة الطاقة الذكية', 'Smart Energy Corp.', 'partner_2', 2],
            ['partner', 'logos/electric-logo.png', 'royal-decor.png', 'شركة الديكور الملكي', 'Royal Decor Co.', 'partner_3', 3],
            ['partner', 'logos/general-logo.png', 'security-group.png', 'مجموعة الأمن والحماية', 'Security Group', 'partner_4', 4],
            ['partner', 'logos/maintenance-logo.png', 'first-pipes.png', 'شركة الأنابيب الأولى', 'First Pipes Co.', 'partner_5', 5],
            ['partner', 'logos/cleaning-logo.png', 'advanced-cooling.png', 'مؤسسة التبريد المتطور', 'Advanced Cooling Corp.', 'partner_6', 6],
        ];
        $mediaRows = array_merge($mediaRows, $partnerLogos);

        // Build dynamic INSERT based on actual columns
        $hasTmCreated  = in_array('created_at', $tmCols);
        $hasTmUpdated  = in_array('updated_at', $tmCols);

        $tmInsertCols = ['`theme_id`', '`media_type`', '`file_path`', '`file_name`', '`alt_text_ar`', '`alt_text_en`'];
        if ($hasSectionRef) $tmInsertCols[] = '`section_ref`';
        $tmInsertCols[] = '`sort_order`';
        $tmInsertCols[] = '`is_active`';
        if ($hasTmCreated) $tmInsertCols[] = '`created_at`';
        if ($hasTmUpdated) $tmInsertCols[] = '`updated_at`';

        $tmPlaceholders = implode(', ', array_fill(0, count($tmInsertCols), '?'));
        $tmSql = "INSERT INTO theme_media (" . implode(', ', $tmInsertCols) . ") VALUES ({$tmPlaceholders})";
        $stmt = $pdo->prepare($tmSql);

        foreach ($mediaRows as $mr) {
            $params = [$mr['theme_id'] ?? 1, $mr[0], $mr[1], $mr[2], $mr[3], $mr[4]];
            if ($hasSectionRef) $params[] = $mr[5];
            $params[] = $mr[6];
            $params[] = 1;
            if ($hasTmCreated) $params[] = $now;
            if ($hasTmUpdated) $params[] = $now;
            $stmt->execute($params);
            $mediaTotal++;
        }
        echo "<p style='color:green'>&#10003; Seeded {$mediaTotal} theme_media rows (banner, 6 services, 10 gallery with categories, 6 partners, logo)</p>\n";
    }

    // ════════════════════════════════════════════════════════════════
    // Step 6: Update ALL tenants — full profile data
    // ════════════════════════════════════════════════════════════════
    $tCols = array_column($pdo->query("SHOW COLUMNS FROM tenants")->fetchAll(PDO::FETCH_ASSOC), 'Field');

    if (!empty($tenantIds)) {
        // Dynamic UPDATE — only update columns that exist
        $tenantUpdates = [
            'theme_slug'       => 'master',
            'theme_id'         => 1,
            'site_name'        => 'ماستر فيكس',
            'site_name_en'     => 'Master Fix',
            'default_language' => 'ar',
            'contact_phone'    => '+90 555 000 000',
            'contact_email'    => 'info@masterfix.com',
            'contact_whatsapp' => '+90 555 000 000',
            'address'          => 'إسطنبول - تركيا، شارع الاستقلال، مبنى الأعمال، الطابق 3',
            'working_hours'    => "السبت - الخميس: 8 صباحاً - 8 مساءً | الجمعة: مغلق | الطوارئ: 24/7",
            'facebook'         => 'https://facebook.com/masterfix',
            'instagram'        => 'https://instagram.com/masterfix',
            'twitter'          => 'https://twitter.com/masterfix',
            'youtube'          => 'https://youtube.com/@masterfix',
            'linkedin'         => 'https://linkedin.com/company/masterfix',
            'tiktok'           => 'https://tiktok.com/@masterfix',
            'meta_title'       => 'ماستر فيكس — خدمات صيانة احترافية',
            'meta_description' => 'نقدم خدمات صيانة متكاملة للمنازل والشركات في إسطنبول — كهرباء، سباكة، تكييف، دهانات، وأكثر. فريق محترف على مدار الساعة.',
            'meta_keywords'    => 'صيانة, كهرباء, سباكة, تكييف, تركيب, إصلاح, إسطنبول, تركيا',
            // CTA fields (even if no UI — available for theme)
            'cta_title'        => 'تحتاج إلى صيانة احترافية؟',
            'cta_title_en'     => 'Need Professional Maintenance?',
            'cta_text'         => 'تواصل مع فريقنا الآن واحصل على خدمات سريعة واحترافية بأعلى جودة لمنزلك أو شركتك.',
            'cta_text_en'      => 'Contact our team now and get fast, professional services with the highest quality.',
            'cta_button_text'  => 'اطلب الخدمة الآن',
            'cta_button_text_en' => 'Request Service Now',
            'cta_button_link'  => '/site/demo/contact',
            'cta_is_active'    => 1,
        ];

        $setClauses = [];
        $setVals    = [];
        foreach ($tenantUpdates as $col => $val) {
            if (in_array($col, $tCols)) {
                $setClauses[] = "`{$col}` = ?";
                $setVals[]    = $val;
            }
        }

        if (!empty($setClauses)) {
            $sql = "UPDATE tenants SET " . implode(', ', $setClauses) . " WHERE 1=1";
            $r = $pdo->prepare($sql)->execute($setVals);
            echo "<p style='color:green'>&#10003; Updated " . count($tenantIds) . " tenants with full profile (" . count($setClauses) . " fields)</p>\n";
        }
    }

    // ════════════════════════════════════════════════════════════════
    // Step 7: Summary
    // ════════════════════════════════════════════════════════════════
    echo "<hr>";
    echo "<h2 style='color:cyan'>&#10003; Master Theme Seeded Successfully!</h2>\n";
    echo "<table style='color:#ccc;font-size:14px;border-collapse:collapse;margin:16px 0'>\n";
    echo "<tr style='border-bottom:1px solid #333'><td style='padding:6px 12px;color:#888'>Theme</td><td style='padding:6px 12px'>master (ماستر فيكس)</td></tr>\n";
    echo "<tr style='border-bottom:1px solid #333'><td style='padding:6px 12px;color:#888'>Theme Settings</td><td style='padding:6px 12px'>25+ columns per tenant</td></tr>\n";
    echo "<tr style='border-bottom:1px solid #333'><td style='padding:6px 12px;color:#888'>Hero Content</td><td style='padding:6px 12px'>Title, Subtitle, Description, Button</td></tr>\n";
    echo "<tr style='border-bottom:1px solid #333'><td style='padding:6px 12px;color:#888'>Services</td><td style='padding:6px 12px'>6 services with prices</td></tr>\n";
    echo "<tr style='border-bottom:1px solid #333'><td style='padding:6px 12px;color:#888'>Testimonials</td><td style='padding:6px 12px'>4 reviews (5 stars)</td></tr>\n";
    echo "<tr style='border-bottom:1px solid #333'><td style='padding:6px 12px;color:#888'>Features (Why Us)</td><td style='padding:6px 12px'>4 features with icons</td></tr>\n";
    echo "<tr style='border-bottom:1px solid #333'><td style='padding:6px 12px;color:#888'>Stats</td><td style='padding:6px 12px'>4 stats with values</td></tr>\n";
    echo "<tr style='border-bottom:1px solid #333'><td style='padding:6px 12px;color:#888'>FAQ</td><td style='padding:6px 12px'>6 items (4 categories: general, services, booking, pricing)</td></tr>\n";
    echo "<tr style='border-bottom:1px solid #333'><td style='padding:6px 12px;color:#888'>About</td><td style='padding:6px 12px'>Rich HTML content (3 paragraphs)</td></tr>\n";
    echo "<tr style='border-bottom:1px solid #333'><td style='padding:6px 12px;color:#888'>Contact</td><td style='padding:6px 12px'>Phone, Email, WhatsApp, Address, Working Hours</td></tr>\n";
    echo "<tr style='border-bottom:1px solid #333'><td style='padding:6px 12px;color:#888'>Partners</td><td style='padding:6px 12px'>6 partners with websites</td></tr>\n";
    echo "<tr style='border-bottom:1px solid #333'><td style='padding:6px 12px;color:#888'>Gallery</td><td style='padding:6px 12px'>10 images (4 categories: كهرباء, سباكة, تبريد, ديكور)</td></tr>\n";
    echo "<tr style='border-bottom:1px solid #333'><td style='padding:6px 12px;color:#888'>Media</td><td style='padding:6px 12px'>{$mediaTotal} items (logo, banner, services, gallery, partners)</td></tr>\n";
    echo "<tr style='border-bottom:1px solid #333'><td style='padding:6px 12px;color:#888'>Tenant Profile</td><td style='padding:6px 12px'>Full: contact, social, SEO, CTA, language</td></tr>\n";
    echo "<tr><td style='padding:6px 12px;color:#888'>Pages</td><td style='padding:6px 12px'>8 templates: default, about, services, contact, gallery, faq, partners, booking</td></tr>\n";
    echo "</table>\n";

    echo "<p style='margin-top:12px'>Preview: <a href='/theme-preview/master' target='_blank' style='color:cyan;text-decoration:underline;font-weight:bold'>/theme-preview/master</a></p>\n";
    echo "<p style='margin-top:4px'>Sub-pages:</p>\n";
    echo "<ul style='color:#aaa;font-size:13px;direction:ltr'>\n";
    foreach (['', '/about', '/services', '/contact', '/gallery', '/faq', '/partners', '/booking'] as $sub) {
        $label = $sub ?: '(Home)';
        echo "<li><a href='/theme-preview/master{$sub}' target='_blank' style='color:cyan'>/theme-preview/master{$sub}</a> — {$label}</li>\n";
    }
    echo "</ul>\n";

} catch (PDOException $e) {
    echo "<p style='color:red'>&#10007; Error: " . htmlspecialchars($e->getMessage()) . "</p>\n";
}
