<?php
/**
 * Admin Theme Content Editor View - PROFESSIONAL EDITION
 * محرر محتوى القوالب الاحترافي - نصوص، صور، بنرات، شعارات، صور خدمات
 */

$dir = Language::direction();
$lang = Language::current();

// مساعدات لاستخراج البيانات
$content = $theme_content;
$media = $theme_media;

function getContentVal($content, $section, $key, $field = 'content_ar', $default = '') {
    if (isset($content[$section][$key][$field])) {
        return $content[$section][$key][$field];
    }
    return $default;
}

function getDecoded($content, $section, $key) {
    if (isset($content[$section][$key]) && $content[$section][$key]['is_json']) {
        return $content[$section][$key]['decoded'];
    }
    return null;
}

function getServiceImage($media, $serviceKey) {
    foreach ($media as $type => $items) {
        foreach ($items as $item) {
            if ($item->section_ref === $serviceKey && ($item->media_type === 'service_image' || $item->media_type === 'gallery')) {
                return $item;
            }
        }
    }
    return null;
}

// استخراج البيانات الحالية
$heroTitleAr = getContentVal($content, 'hero', 'hero_title');
$heroTitleEn = getContentVal($content, 'hero', 'hero_title', 'content_en');
$heroSubAr = getContentVal($content, 'hero', 'hero_subtitle');
$heroSubEn = getContentVal($content, 'hero', 'hero_subtitle', 'content_en');
$heroDescAr = getContentVal($content, 'hero', 'hero_description');
$heroDescEn = getContentVal($content, 'hero', 'hero_description', 'content_en');
$heroBtnAr = getContentVal($content, 'hero', 'hero_button_text');
$heroBtnEn = getContentVal($content, 'hero', 'hero_button_text', 'content_en');

$aboutTitleAr = getContentVal($content, 'about', 'about_title');
$aboutTitleEn = getContentVal($content, 'about', 'about_title', 'content_en');
$aboutTextAr = getContentVal($content, 'about', 'about_text');
$aboutTextEn = getContentVal($content, 'about', 'about_text', 'content_en');

// استخراج الخدمات
$services = [];
if (!empty($content['services'])) {
    foreach ($content['services'] as $key => $item) {
        $services[] = $item;
    }
}

// استخراج آراء العملاء
$testimonials = [];
if (!empty($content['testimonials'])) {
    foreach ($content['testimonials'] as $key => $item) {
        $testimonials[] = $item;
    }
}

// استخراج بيانات التواصل
$contactData = getDecoded($content, 'contact', 'contact_info');
$contactPhone = $contactData['phone'] ?? '';
$contactEmail = $contactData['email'] ?? '';
$contactWhatsapp = $contactData['whatsapp'] ?? '';
$contactAddress = $contactData['address'] ?? '';
$contactAddressEn = $contactData['address_en'] ?? '';

// استخراج الوسائط
$logoMedia = $media['logo'][0] ?? null;
$bannerMedia = $media['banner'][0] ?? null;
$galleryMedia = $media['gallery'] ?? [];

$themeColors = [
    'maintenance' => ['#ea580c', '#1e3a5f'],
    'decor' => ['#d4af37', '#722F37'],
    'electric' => ['#fbbf24', '#d97706'],
    'plumbing' => ['#0891b2', '#0e7490'],
    'cleaning' => ['#0ea5e9', '#0284c7'],
    'general' => ['#2563eb', '#1e40af'],
    'medical' => ['#059669', '#064e3b'],
    'realestate' => ['#7c3aed', '#4c1d95'],
    'restaurant' => ['#dc2626', '#991b1b'],
    'education' => ['#2563eb', '#1e40af'],
    'fitness' => ['#e11d48', '#9f1239'],
    'legal' => ['#1e40af', '#1e3a5f'],
];
$themeIcons = [
    'maintenance' => 'fa-wrench', 'decor' => 'fa-paint-brush', 'electric' => 'fa-bolt',
    'plumbing' => 'fa-faucet', 'cleaning' => 'fa-spray-can', 'general' => 'fa-cube',
    'medical' => 'fa-heartbeat', 'realestate' => 'fa-building', 'restaurant' => 'fa-utensils',
    'education' => 'fa-graduation-cap', 'fitness' => 'fa-dumbbell', 'legal' => 'fa-balance-scale',
];
$colors = $themeColors[$theme->slug] ?? ['#2563eb', '#1e40af'];
$icon = $themeIcons[$theme->slug] ?? 'fa-cube';
?>

<!-- Page Header with Preview -->
<div class="tc-header" style="background: linear-gradient(135deg, <?= $colors[0] ?> 0%, <?= $colors[1] ?> 100%); border-radius: 16px; padding: 1.5rem 2rem; margin-bottom: 1.5rem; color: #fff; position: relative; overflow: hidden;">
    <div style="position:absolute; top:-40px; <?= $dir === 'rtl' ? 'left' : 'right' ?>:-40px; width:200px; height:200px; background:rgba(255,255,255,0.06); border-radius:50%;"></div>
    <div style="position:absolute; bottom:-60px; <?= $dir === 'rtl' ? 'right' : 'left' ?>:-60px; width:250px; height:250px; background:rgba(255,255,255,0.04); border-radius:50%;"></div>
    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; position:relative; z-index:1;">
        <div>
            <a href="<?= url('/admin/themes') ?>" style="color:rgba(255,255,255,0.7); text-decoration:none; font-size:0.85rem; display:inline-flex; align-items:center; gap:0.4rem; margin-bottom:0.5rem;">
                <i class="fas fa-arrow-<?= $dir === 'rtl' ? 'right' : 'left' ?>"></i>
                الرجوع للقوالب
            </a>
            <h1 style="margin:0; font-size:1.4rem; font-weight:700;">
                <i class="fas fa-edit"></i>
                محتوى القالب: <?= $this->e($theme->name) ?>
                <?php if (!empty($theme->name_en)): ?>
                    <span style="font-weight:400; opacity:0.8; font-size:1rem;"> (<?= $this->e($theme->name_en) ?>)</span>
                <?php endif; ?>
            </h1>
            <p style="margin:0.3rem 0 0; opacity:0.8; font-size:0.85rem;">
                عدّل محتوى هذا القالب - نصوص، صور، بنرات، خدمات مع صور احترافية
            </p>
        </div>
        <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
            <?php $totalSections = array_sum($section_counts); $totalMedia = array_sum($media_counts); ?>
            <span style="background:rgba(255,255,255,0.2); padding:0.3rem 0.8rem; border-radius:20px; font-size:0.8rem; font-weight:600;">
                <i class="fas fa-file-alt"></i> <?= $totalSections ?> قسم
            </span>
            <span style="background:rgba(255,255,255,0.2); padding:0.3rem 0.8rem; border-radius:20px; font-size:0.8rem; font-weight:600;">
                <i class="fas fa-image"></i> <?= $totalMedia ?> ملف
            </span>
            <?php if (!empty($theme->preview_image)): ?>
            <a href="<?= upload($theme->preview_image) ?>" target="_blank" style="background:rgba(255,255,255,0.2); padding:0.3rem 0.8rem; border-radius:20px; font-size:0.8rem; font-weight:600; color:#fff; text-decoration:none;">
                <i class="fas fa-external-link-alt"></i> معاينة
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Theme Preview Strip -->
<?php if (!empty($theme->preview_image)): ?>
<div class="tc-preview-strip" style="margin-bottom:1.5rem; border-radius:16px; overflow:hidden; border:2px solid #e5e7eb; position:relative; height:200px;">
    <img src="<?= upload($theme->preview_image) ?>" alt="<?= $this->e($theme->name) ?>" style="width:100%; height:100%; object-fit:cover;">
    <div style="position:absolute; bottom:0; left:0; right:0; padding:1rem 1.5rem; background:linear-gradient(to top, rgba(0,0,0,0.7), transparent); color:#fff;">
        <div style="display:flex; align-items:center; gap:0.75rem;">
            <div style="width:40px; height:40px; background:linear-gradient(135deg, <?= $colors[0] ?>, <?= $colors[1] ?>); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                <i class="fas <?= $icon ?>"></i>
            </div>
            <div>
                <strong style="font-size:0.95rem;"><?= $this->e($theme->name) ?></strong>
                <div style="font-size:0.8rem; opacity:0.85;">معاينة القالب كما يظهر للعملاء</div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Tabs Navigation -->
<div class="tc-tabs" style="display:flex; gap:0.25rem; margin-bottom:1.5rem; background:#f1f5f9; padding:0.35rem; border-radius:12px; flex-wrap:wrap;">
    <button class="tc-tab active" onclick="switchTab('hero', this)">
        <i class="fas fa-home"></i> البانر الرئيسي
    </button>
    <button class="tc-tab" onclick="switchTab('about', this)">
        <i class="fas fa-info-circle"></i> عن القالب
    </button>
    <button class="tc-tab" onclick="switchTab('services', this)">
        <i class="fas fa-concierge-bell"></i> الخدمات
        <?php if (!empty($content['services'])): ?>
        <span class="tc-tab-badge"><?= count($content['services']) ?></span>
        <?php endif; ?>
    </button>
    <button class="tc-tab" onclick="switchTab('testimonials', this)">
        <i class="fas fa-quote-right"></i> آراء العملاء
        <?php if (!empty($content['testimonials'])): ?>
        <span class="tc-tab-badge"><?= count($content['testimonials']) ?></span>
        <?php endif; ?>
    </button>
    <button class="tc-tab" onclick="switchTab('contact', this)">
        <i class="fas fa-phone-alt"></i> التواصل
    </button>
    <button class="tc-tab" onclick="switchTab('media', this)">
        <i class="fas fa-images"></i> الصور والوسائط
        <?php if ($totalMedia > 0): ?>
        <span class="tc-tab-badge"><?= $totalMedia ?></span>
        <?php endif; ?>
    </button>
</div>

<!-- Main Form -->
<form method="POST" action="<?= url('/admin/themes/content/' . $theme->id) ?>" id="themeContentForm">
    <?= csrf_field() ?>

    <!-- ==================== Tab: Hero ==================== -->
    <div class="tc-panel" id="tab-hero">
        <!-- Hero Banner Preview -->
        <div class="tc-card" style="margin-bottom:1rem;">
            <div class="tc-card-header">
                <h3><i class="fas fa-eye"></i> معاينة البانر الرئيسي</h3>
                <small>شكل البانر كما سيظهر للعميل</small>
            </div>
            <div class="tc-card-body" style="padding:0;">
                <div id="heroPreview" class="tc-hero-preview" style="position:relative; min-height:280px; overflow:hidden; background:linear-gradient(135deg, <?= $colors[0] ?>22, <?= $colors[1] ?>22); border-radius:0 0 12px 12px;">
                    <?php if ($bannerMedia): ?>
                    <img src="<?= upload($bannerMedia->file_path) ?>" alt="" style="position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover; opacity:0.35;">
                    <?php endif; ?>
                    <div style="position:absolute; top:0; left:0; right:0; bottom:0; display:flex; flex-direction:column; justify-content:center; align-items:center; text-align:center; padding:2rem; z-index:1;">
                        <?php if ($logoMedia): ?>
                        <img src="<?= upload($logoMedia->file_path) ?>" alt="Logo" style="width:60px; height:60px; border-radius:12px; margin-bottom:1rem; border:3px solid rgba(255,255,255,0.3); object-fit:contain; background:#fff;">
                        <?php endif; ?>
                        <h2 id="heroPreviewTitle" style="color:#fff; font-size:1.8rem; font-weight:800; text-shadow:0 2px 10px rgba(0,0,0,0.3); margin:0 0 0.5rem;">
                            <?= $this->e($heroTitleAr) ?: 'عنوان البانر الرئيسي' ?>
                        </h2>
                        <p id="heroPreviewSub" style="color:rgba(255,255,255,0.9); font-size:1rem; margin:0 0 1rem; text-shadow:0 1px 5px rgba(0,0,0,0.2);">
                            <?= $this->e($heroSubAr) ?: 'العنوان الفرعي' ?>
                        </p>
                        <p id="heroPreviewDesc" style="color:rgba(255,255,255,0.8); font-size:0.85rem; max-width:500px; margin:0 0 1.2rem; line-height:1.6;">
                            <?= $this->e($heroDescAr) ?: 'وصف مختصر عن القالب' ?>
                        </p>
                        <span id="heroPreviewBtn" style="background:rgba(255,255,255,0.2); color:#fff; padding:0.5rem 1.5rem; border-radius:25px; font-size:0.85rem; font-weight:600; border:2px solid rgba(255,255,255,0.4); backdrop-filter:blur(8px);">
                            <?= $this->e($heroBtnAr) ?: 'تواصل معنا' ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="tc-card">
            <div class="tc-card-header">
                <h3><i class="fas fa-edit"></i> تعديل نصوص البانر</h3>
                <small>النصوص التي تظهر في أعلى صفحة الموقع</small>
            </div>
            <div class="tc-card-body">
                <div class="tc-lang-group">
                    <div class="tc-lang-fields">
                        <div class="form-group">
                            <label><span class="tc-lang-flag">🇸🇦</span> العنوان الرئيسي (عربي)</label>
                            <input type="text" name="hero_title_ar" value="<?= $this->e($heroTitleAr) ?>" placeholder="مثال: خدمات صيانة احترافية" oninput="updateHeroPreview()">
                        </div>
                        <div class="form-group">
                            <label><span class="tc-lang-flag">🇬🇧</span> العنوان الرئيسي (إنجليزي)</label>
                            <input type="text" name="hero_title_en" value="<?= $this->e($heroTitleEn) ?>" placeholder="Professional Maintenance Services">
                        </div>
                    </div>
                </div>

                <div class="tc-lang-group">
                    <div class="tc-lang-fields">
                        <div class="form-group">
                            <label><span class="tc-lang-flag">🇸🇦</span> العنوان الفرعي (عربي)</label>
                            <input type="text" name="hero_subtitle_ar" value="<?= $this->e($heroSubAr) ?>" placeholder="نحن هنا لخدمتكم" oninput="updateHeroPreview()">
                        </div>
                        <div class="form-group">
                            <label><span class="tc-lang-flag">🇬🇧</span> العنوان الفرعي (إنجليزي)</label>
                            <input type="text" name="hero_subtitle_en" value="<?= $this->e($heroSubEn) ?>" placeholder="We are here to serve you">
                        </div>
                    </div>
                </div>

                <div class="tc-lang-group">
                    <div class="tc-lang-fields">
                        <div class="form-group">
                            <label><span class="tc-lang-flag">🇸🇦</span> الوصف (عربي)</label>
                            <textarea name="hero_description_ar" rows="3" placeholder="وصف مختصر عن الخدمة..." oninput="updateHeroPreview()"><?= $this->e($heroDescAr) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label><span class="tc-lang-flag">🇬🇧</span> الوصف (إنجليزي)</label>
                            <textarea name="hero_description_en" rows="3" placeholder="Brief description..."><?= $this->e($heroDescEn) ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="tc-lang-group">
                    <div class="tc-lang-fields">
                        <div class="form-group">
                            <label><span class="tc-lang-flag">🇸🇦</span> نص الزر (عربي)</label>
                            <input type="text" name="hero_button_text_ar" value="<?= $this->e($heroBtnAr) ?>" placeholder="تواصل معنا" oninput="updateHeroPreview()">
                        </div>
                        <div class="form-group">
                            <label><span class="tc-lang-flag">🇬🇧</span> نص الزر (إنجليزي)</label>
                            <input type="text" name="hero_button_text_en" value="<?= $this->e($heroBtnEn) ?>" placeholder="Contact Us">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== Tab: About ==================== -->
    <div class="tc-panel" id="tab-about" style="display:none;">
        <div class="tc-card">
            <div class="tc-card-header">
                <h3><i class="fas fa-info-circle"></i> عن القالب (About Section)</h3>
                <small>نص تعريفي يظهر في قسم "عن الموقع"</small>
            </div>
            <div class="tc-card-body">
                <div class="tc-lang-group">
                    <div class="tc-lang-fields">
                        <div class="form-group">
                            <label><span class="tc-lang-flag">🇸🇦</span> عنوان القسم (عربي)</label>
                            <input type="text" name="about_title_ar" value="<?= $this->e($aboutTitleAr) ?>" placeholder="من نحن">
                        </div>
                        <div class="form-group">
                            <label><span class="tc-lang-flag">🇬🇧</span> عنوان القسم (إنجليزي)</label>
                            <input type="text" name="about_title_en" value="<?= $this->e($aboutTitleEn) ?>" placeholder="About Us">
                        </div>
                    </div>
                </div>
                <div class="tc-lang-group">
                    <div class="tc-lang-fields">
                        <div class="form-group">
                            <label><span class="tc-lang-flag">🇸🇦</span> نص التعريف (عربي)</label>
                            <textarea name="about_text_ar" rows="6" placeholder="اكتب نصاً تعريفياً عن الخدمة..."><?= $this->e($aboutTextAr) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label><span class="tc-lang-flag">🇬🇧</span> نص التعريف (إنجليزي)</label>
                            <textarea name="about_text_en" rows="6" placeholder="Write a description..."><?= $this->e($aboutTextEn) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== Tab: Services ==================== -->
    <div class="tc-panel" id="tab-services" style="display:none;">
        <div class="tc-card">
            <div class="tc-card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.5rem;">
                <div>
                    <h3><i class="fas fa-concierge-bell"></i> الخدمات التجريبية (مع صور)</h3>
                    <small>كل خدمة تحتوي على صورة احترافية + نصوص عربي وإنجليزي</small>
                </div>
                <button type="button" class="btn-add-item" onclick="addServiceItem()">
                    <i class="fas fa-plus"></i> إضافة خدمة جديدة
                </button>
            </div>
            <div class="tc-card-body">
                <div id="servicesContainer">
                    <?php if (!empty($services)): ?>
                        <?php foreach ($services as $idx => $svc): ?>
                            <?php
                            $svcData = $svc['decoded'] ?? json_decode($svc['content_ar'], true) ?? [];
                            $svcEn = !empty($svc['content_en']) ? (json_decode($svc['content_en'], true) ?? []) : [];
                            $svcKey = 'service_' . ($idx + 1);
                            $svcImage = getServiceImage($media, $svcKey);
                            ?>
                            <div class="tc-service-card" data-index="<?= $idx ?>" data-key="<?= $svcKey ?>">
                                <!-- Service Header -->
                                <div class="tc-item-header">
                                    <span class="tc-item-number"><?= $idx + 1 ?></span>
                                    <div style="flex:1; display:flex; align-items:center; gap:0.75rem;">
                                        <?php if ($svcImage): ?>
                                        <img src="<?= upload($svcImage->file_path) ?>" alt="" style="width:36px; height:36px; border-radius:8px; object-fit:cover; border:2px solid #e5e7eb;">
                                        <?php else: ?>
                                        <div style="width:36px; height:36px; border-radius:8px; background:#f1f5f9; display:flex; align-items:center; justify-content:center;">
                                            <i class="fas <?= $svcData['icon'] ?? 'fas fa-star' ?>" style="color:#94a3b8; font-size:0.85rem;"></i>
                                        </div>
                                        <?php endif; ?>
                                        <strong style="font-size:0.88rem; color:#334155;"><?= $this->e($svcData['title_ar'] ?? 'خدمة ' . ($idx+1)) ?></strong>
                                    </div>
                                    <button type="button" class="tc-item-remove" onclick="removeItem(this)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>

                                <div class="tc-item-body">
                                    <!-- Service Image Upload -->
                                    <div class="tc-service-image-section">
                                        <div class="tc-service-image-area">
                                            <?php if ($svcImage): ?>
                                            <div class="tc-service-image-preview">
                                                <img src="<?= upload($svcImage->file_path) ?>" alt="<?= $this->e($svcImage->alt_text_ar ?? '') ?>">
                                                <div class="tc-service-image-overlay">
                                                    <button type="button" class="tc-service-image-btn" onclick="document.getElementById('svcImg_<?= $idx ?>').click();">
                                                        <i class="fas fa-camera"></i> تغيير الصورة
                                                    </button>
                                                    <button type="button" class="tc-service-image-btn tc-btn-danger" onclick="deleteMedia(<?= $svcImage->id ?>, this.closest('.tc-service-image-preview'))">
                                                        <i class="fas fa-trash-alt"></i> حذف
                                                    </button>
                                                </div>
                                            </div>
                                            <?php else: ?>
                                            <div class="tc-service-image-placeholder" onclick="document.getElementById('svcImg_<?= $idx ?>').click();">
                                                <div class="tc-service-image-placeholder-inner">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                    <span>اضغط لرفع صورة الخدمة</span>
                                                    <small>PNG, JPG, WebP - 1024x1024</small>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <input type="file" id="svcImg_<?= $idx ?>" accept="image/*" style="display:none;" onchange="uploadServiceImage(<?= $theme->id ?>, '<?= $svcKey ?>', this, <?= $idx ?>)">
                                        </div>
                                    </div>

                                    <!-- Service Text Fields -->
                                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;">
                                        <div class="form-group">
                                            <label><span class="tc-lang-flag">🇸🇦</span> اسم الخدمة (عربي)</label>
                                            <input type="text" name="services_ar[<?= $idx ?>][title_ar]" value="<?= $this->e($svcData['title_ar'] ?? '') ?>">
                                        </div>
                                        <div class="form-group">
                                            <label><span class="tc-lang-flag">🇬🇧</span> اسم الخدمة (إنجليزي)</label>
                                            <input type="text" name="services_en[<?= $idx ?>][title_en]" value="<?= $this->e($svcEn['title_en'] ?? '') ?>">
                                        </div>
                                        <div class="form-group" style="grid-column:1/-1;">
                                            <label><span class="tc-lang-flag">🇸🇦</span> وصف الخدمة (عربي)</label>
                                            <textarea name="services_ar[<?= $idx ?>][description_ar]" rows="2"><?= $this->e($svcData['description_ar'] ?? '') ?></textarea>
                                        </div>
                                        <div class="form-group" style="grid-column:1/-1;">
                                            <label><span class="tc-lang-flag">🇬🇧</span> وصف الخدمة (إنجليزي)</label>
                                            <textarea name="services_en[<?= $idx ?>][description_en]" rows="2"><?= $this->e($svcEn['description_en'] ?? '') ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label><i class="fas fa-icons" style="color:var(--primary, #4f46e5);"></i> أيقونة (Font Awesome)</label>
                                            <input type="text" name="services_ar[<?= $idx ?>][icon]" value="<?= $this->e($svcData['icon'] ?? 'fas fa-star') ?>" placeholder="fas fa-star">
                                            <small style="color:#78716c;">من موقع <a href="https://fontawesome.com/icons" target="_blank" style="color:#2563eb;">fontawesome.com</a></small>
                                        </div>
                                        <div class="form-group">
                                            <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; margin-top:1.5rem;">
                                                <input type="checkbox" name="services_ar[<?= $idx ?>][show_on_home]" value="1" <?= ($svcData['show_on_home'] ?? 1) ? 'checked' : '' ?>>
                                                عرض في الصفحة الرئيسية
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="tc-empty-state">
                            <div style="width:80px; height:80px; margin:0 auto 1rem; background:linear-gradient(135deg, #eff6ff, #f0fdf4); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-concierge-bell" style="font-size:2rem; color:#4f46e5;"></i>
                            </div>
                            <p style="font-size:0.95rem; color:#64748b;">لا توجد خدمات بعد</p>
                            <p style="font-size:0.82rem; color:#94a3b8; margin-bottom:1rem;">أضف خدمات مع صور احترافية لجعل القالب جذاباً</p>
                            <button type="button" class="btn-add-item" onclick="addServiceItem()">
                                <i class="fas fa-plus"></i> إضافة خدمة جديدة
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== Tab: Testimonials ==================== -->
    <div class="tc-panel" id="tab-testimonials" style="display:none;">
        <div class="tc-card">
            <div class="tc-card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.5rem;">
                <div>
                    <h3><i class="fas fa-quote-right"></i> آراء العملاء التجريبية</h3>
                    <small>شهادات العملاء التي ستظهر كبيانات تجريبية</small>
                </div>
                <button type="button" class="btn-add-item" onclick="addTestimonialItem()">
                    <i class="fas fa-plus"></i> إضافة شهادة
                </button>
            </div>
            <div class="tc-card-body">
                <div id="testimonialsContainer">
                    <?php if (!empty($testimonials)): ?>
                        <?php foreach ($testimonials as $idx => $tst): ?>
                            <?php $tstData = $tst['decoded'] ?? json_decode($tst['content_ar'], true) ?? []; ?>
                            <div class="tc-repeatable-item" data-index="<?= $idx ?>">
                                <div class="tc-item-header">
                                    <span class="tc-item-number"><?= $idx + 1 ?></span>
                                    <div style="flex:1; display:flex; align-items:center; gap:0.5rem;">
                                        <div style="width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg, #fbbf24, #f59e0b); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:0.75rem;">
                                            <?= mb_substr($tstData['client_name'] ?? '?', 0, 1) ?>
                                        </div>
                                        <strong style="font-size:0.88rem; color:#334155;"><?= $this->e($tstData['client_name'] ?? 'شهادة ' . ($idx+1)) ?></strong>
                                    </div>
                                    <button type="button" class="tc-item-remove" onclick="removeItem(this)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                <div class="tc-item-body">
                                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;">
                                        <div class="form-group">
                                            <label>اسم العميل (عربي)</label>
                                            <input type="text" name="testimonials_ar[<?= $idx ?>][client_name]" value="<?= $this->e($tstData['client_name'] ?? '') ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>المسمى الوظيفي (عربي)</label>
                                            <input type="text" name="testimonials_ar[<?= $idx ?>][client_title]" value="<?= $this->e($tstData['client_title'] ?? '') ?>">
                                        </div>
                                        <div class="form-group" style="grid-column:1/-1;">
                                            <label>نص الشهادة (عربي)</label>
                                            <textarea name="testimonials_ar[<?= $idx ?>][content]" rows="2"><?= $this->e($tstData['content'] ?? '') ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>التقييم</label>
                                            <select name="testimonials_ar[<?= $idx ?>][rating]" style="width:auto;">
                                                <?php for ($r = 1; $r <= 5; $r++): ?>
                                                <option value="<?= $r ?>" <?= ($tstData['rating'] ?? 5) == $r ? 'selected' : '' ?>>
                                                    <?= str_repeat('★', $r) ?> <?= $r ?>/5
                                                </option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="tc-empty-state">
                            <div style="width:80px; height:80px; margin:0 auto 1rem; background:linear-gradient(135deg, #fffbeb, #fef3c7); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-quote-right" style="font-size:2rem; color:#f59e0b;"></i>
                            </div>
                            <p style="font-size:0.95rem; color:#64748b;">لا توجد شهادات بعد</p>
                            <p style="font-size:0.82rem; color:#94a3b8; margin-bottom:1rem;">أضف آراء عملاء لتعزيز مصداقية القالب</p>
                            <button type="button" class="btn-add-item" onclick="addTestimonialItem()">
                                <i class="fas fa-plus"></i> إضافة شهادة جديدة
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== Tab: Contact ==================== -->
    <div class="tc-panel" id="tab-contact" style="display:none;">
        <div class="tc-card">
            <div class="tc-card-header">
                <h3><i class="fas fa-phone-alt"></i> معلومات التواصل</h3>
                <small>بيانات التواصل التجريبية التي ستظهر للعميل</small>
            </div>
            <div class="tc-card-body">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div class="form-group tc-contact-field">
                        <label><i class="fas fa-phone" style="color:#22c55e;"></i> رقم الهاتف</label>
                        <input type="text" name="contact_phone" value="<?= $this->e($contactPhone) ?>" placeholder="966500000000">
                    </div>
                    <div class="form-group tc-contact-field">
                        <label><i class="fab fa-whatsapp" style="color:#25d366;"></i> واتساب</label>
                        <input type="text" name="contact_whatsapp" value="<?= $this->e($contactWhatsapp) ?>" placeholder="966500000000">
                    </div>
                    <div class="form-group tc-contact-field">
                        <label><i class="fas fa-envelope" style="color:#3b82f6;"></i> البريد الإلكتروني</label>
                        <input type="email" name="contact_email" value="<?= $this->e($contactEmail) ?>" placeholder="info@example.com">
                    </div>
                    <div class="form-group tc-contact-field">
                        <label><i class="fas fa-map-marker-alt" style="color:#ef4444;"></i> العنوان (عربي)</label>
                        <input type="text" name="contact_address" value="<?= $this->e($contactAddress) ?>" placeholder="الرياض - المملكة العربية السعودية">
                    </div>
                    <div class="form-group tc-contact-field" style="grid-column:1/-1;">
                        <label><i class="fas fa-map-marker-alt" style="color:#ef4444;"></i> العنوان (إنجليزي)</label>
                        <input type="text" name="contact_address_en" value="<?= $this->e($contactAddressEn) ?>" placeholder="Riyadh - Saudi Arabia">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== Tab: Media ==================== -->
    <div class="tc-panel" id="tab-media" style="display:none;">
        <!-- شعار القالب -->
        <div class="tc-card tc-media-card" style="margin-bottom:1rem;">
            <div class="tc-card-header">
                <h3><i class="fas fa-image" style="color:#7c3aed;"></i> شعار القالب (Logo)</h3>
                <small>الشعار الافتراضي الذي سيظهر للعميل عند التفعيل</small>
            </div>
            <div class="tc-card-body">
                <?php if ($logoMedia): ?>
                <div class="tc-media-preview">
                    <div class="tc-media-thumb" style="background:linear-gradient(135deg, #f5f3ff, #ede9fe); border-radius:12px; padding:0.75rem;">
                        <img src="<?= upload($logoMedia->file_path) ?>" alt="<?= $this->e($logoMedia->alt_text_ar) ?>" style="max-height:80px; border-radius:8px; object-fit:contain;">
                    </div>
                    <div class="tc-media-info">
                        <strong>الشعار الحالي</strong>
                        <small><?= $this->e($logoMedia->file_name) ?></small>
                    </div>
                    <button type="button" class="tc-media-delete" onclick="deleteMedia(<?= $logoMedia->id ?>, this.closest('.tc-media-preview'))" title="حذف">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
                <?php else: ?>
                <div class="tc-empty-media">
                    <div style="width:60px; height:60px; margin:0 auto 0.75rem; background:linear-gradient(135deg, #f5f3ff, #ede9fe); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-cloud-upload-alt" style="font-size:1.5rem; color:#7c3aed;"></i>
                    </div>
                    <p>لم يتم رفع شعار بعد</p>
                </div>
                <?php endif; ?>
                <div style="margin-top:1rem; display:flex; gap:0.75rem; align-items:center; flex-wrap:wrap;">
                    <input type="file" id="logoFile" accept="image/*" style="display:none;" onchange="uploadMedia(<?= $theme->id ?>, 'logo', 'hero')">
                    <button type="button" class="btn-upload-media" onclick="document.getElementById('logoFile').click()">
                        <i class="fas fa-upload"></i> رفع شعار
                    </button>
                    <small style="color:#78716c;">PNG, JPG, SVG - الحد الأقصى 2MB</small>
                </div>
            </div>
        </div>

        <!-- بانر القالب -->
        <div class="tc-card tc-media-card" style="margin-bottom:1rem;">
            <div class="tc-card-header">
                <h3><i class="fas fa-panorama" style="color:#2563eb;"></i> صورة البانر (Hero Banner)</h3>
                <small>الصورة الرئيسية التي تظهر في أعلى الموقع</small>
            </div>
            <div class="tc-card-body">
                <?php if ($bannerMedia): ?>
                <div class="tc-media-preview" style="flex-direction:column; align-items:stretch;">
                    <div style="position:relative; border-radius:12px; overflow:hidden; margin-bottom:0.75rem;">
                        <img src="<?= upload($bannerMedia->file_path) ?>" alt="<?= $this->e($bannerMedia->alt_text_ar) ?>" style="width:100%; max-height:200px; object-fit:cover; border-radius:12px;">
                        <button type="button" class="tc-media-delete" onclick="deleteMedia(<?= $bannerMedia->id ?>, this.closest('.tc-media-preview'))" title="حذف" style="position:absolute; top:8px; <?= $dir === 'rtl' ? 'left' : 'right' ?>:8px;">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                    <div class="tc-media-info">
                        <strong><i class="fas fa-image"></i> البانر الحالي</strong>
                        <small><?= $this->e($bannerMedia->file_name) ?></small>
                    </div>
                </div>
                <?php else: ?>
                <div class="tc-empty-media" style="min-height:150px;">
                    <div style="width:60px; height:60px; margin:0 auto 0.75rem; background:linear-gradient(135deg, #eff6ff, #dbeafe); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-panorama" style="font-size:1.5rem; color:#2563eb;"></i>
                    </div>
                    <p>لم يتم رفع بانر بعد</p>
                    <small style="color:#94a3b8;">البنر هو الصورة الكبيرة في أعلى الموقع</small>
                </div>
                <?php endif; ?>
                <div style="margin-top:1rem; display:flex; gap:0.75rem; align-items:center; flex-wrap:wrap;">
                    <input type="file" id="bannerFile" accept="image/*" style="display:none;" onchange="uploadMedia(<?= $theme->id ?>, 'banner', 'hero')">
                    <button type="button" class="btn-upload-media" onclick="document.getElementById('bannerFile').click()">
                        <i class="fas fa-upload"></i> رفع بانر
                    </button>
                    <small style="color:#78716c;">PNG, JPG, WebP - يُفضل 1344x768</small>
                </div>
            </div>
        </div>

        <!-- معرض صور -->
        <div class="tc-card tc-media-card">
            <div class="tc-card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.5rem;">
                <div>
                    <h3><i class="fas fa-images" style="color:#e11d48;"></i> معرض الصور</h3>
                    <small>صور إضافية تظهر في معرض الموقع</small>
                </div>
                <div style="display:flex; gap:0.75rem; align-items:center;">
                    <input type="file" id="galleryFile" accept="image/*" multiple style="display:none;" onchange="uploadGalleryMedia(<?= $theme->id ?>)">
                    <button type="button" class="btn-add-item" onclick="document.getElementById('galleryFile').click()">
                        <i class="fas fa-upload"></i> رفع صور متعددة
                    </button>
                </div>
            </div>
            <div class="tc-card-body">
                <?php if (!empty($galleryMedia)): ?>
                <div class="tc-gallery-grid">
                    <?php foreach ($galleryMedia as $img): ?>
                    <div class="tc-gallery-item">
                        <img src="<?= upload($img->file_path) ?>" alt="<?= $this->e($img->alt_text_ar) ?>">
                        <div class="tc-gallery-overlay">
                            <button type="button" class="tc-gallery-delete" onclick="deleteMedia(<?= $img->id ?>, this.closest('.tc-gallery-item'))" title="حذف">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="tc-empty-media" style="min-height:120px;">
                    <div style="width:60px; height:60px; margin:0 auto 0.75rem; background:linear-gradient(135deg, #fff1f2, #ffe4e6); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-images" style="font-size:1.5rem; color:#e11d48;"></i>
                    </div>
                    <p>لم يتم رفع صور بعد</p>
                    <small style="color:#94a3b8;">يمكنك رفع عدة صور دفعة واحدة</small>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="tc-save-bar">
        <button type="submit" class="tc-save-btn" id="saveAllBtn">
            <i class="fas fa-save"></i> حفظ جميع التغييرات
        </button>
        <button type="button" class="tc-reset-btn" onclick="if(confirm('هل أنت متأكد؟ سيتم التراجع عن جميع التغييرات')) location.reload();">
            <i class="fas fa-undo"></i> تراجع
        </button>
    </div>
</form>

<style>
/* ===== Language Flag Badge ===== */
.tc-lang-flag {
    font-size: 0.85rem;
    margin-<?= $dir === 'rtl' ? 'left' : 'right' ?>: 0.3rem;
}

/* ===== Tabs ===== */
.tc-tabs { background: #f1f5f9; padding: 0.35rem; border-radius: 12px; display: flex; gap: 0.25rem; flex-wrap: wrap; }
.tc-tab { padding: 0.6rem 1.1rem; border: none; background: transparent; color: #64748b; font-size: 0.85rem; font-weight: 600; border-radius: 10px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 0.4rem; font-family: inherit; }
.tc-tab:hover { background: #e2e8f0; color: #334155; }
.tc-tab.active { background: #fff; color: #1e293b; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
.tc-tab-badge { background: linear-gradient(135deg, #4f46e5, #7c3aed); color: #fff; font-size: 0.65rem; padding: 1px 6px; border-radius: 10px; font-weight: 700; }

/* ===== Cards ===== */
.tc-card { background: #fff; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden; margin-bottom: 1rem; transition: box-shadow 0.2s; }
.tc-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.04); }
.tc-card-header { padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; background: #fafbfc; }
.tc-card-header h3 { margin: 0; font-size: 1rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 0.5rem; }
.tc-card-header small { color: #94a3b8; font-size: 0.8rem; display: block; margin-top: 0.15rem; }
.tc-card-body { padding: 1.25rem; }

/* ===== Hero Preview ===== */
.tc-hero-preview { position: relative; min-height: 280px; display: flex; flex-direction: column; justify-content: center; align-items: center; }
.tc-hero-preview img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.35; }

/* ===== Form Groups ===== */
.form-group { margin-bottom: 1rem; }
.form-group label { display: block; font-size: 0.82rem; font-weight: 600; color: #475569; margin-bottom: 0.35rem; display: flex; align-items: center; gap: 0.3rem; }
.form-group input[type="text"], .form-group input[type="email"], .form-group input[type="number"], .form-group textarea, .form-group select {
    width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 0.88rem; font-family: inherit; transition: all 0.2s; box-sizing: border-box; background: #fff;
}
.form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.08); }
.form-group textarea { resize: vertical; min-height: 60px; }

/* ===== Service Image Section ===== */
.tc-service-image-section { margin-bottom: 1rem; }
.tc-service-image-area { position: relative; }
.tc-service-image-preview {
    position: relative; width: 100%; max-width: 400px; aspect-ratio: 16/10; border-radius: 12px; overflow: hidden;
    border: 2px solid #e5e7eb; cursor: pointer;
}
.tc-service-image-preview img { width: 100%; height: 100%; object-fit: cover; }
.tc-service-image-overlay {
    position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5);
    display: flex; align-items: center; justify-content: center; gap: 0.5rem; opacity: 0; transition: opacity 0.2s;
}
.tc-service-image-preview:hover .tc-service-image-overlay { opacity: 1; }
.tc-service-image-btn {
    padding: 0.4rem 0.8rem; background: rgba(255,255,255,0.9); color: #334155; border: none; border-radius: 8px;
    font-size: 0.78rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.3rem; font-family: inherit;
}
.tc-service-image-btn:hover { background: #fff; }
.tc-btn-danger { background: rgba(239,68,68,0.9); color: #fff; }
.tc-btn-danger:hover { background: #ef4444; }
.tc-service-image-placeholder {
    width: 100%; max-width: 400px; aspect-ratio: 16/10; border: 2px dashed #d1d5db; border-radius: 12px;
    display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
}
.tc-service-image-placeholder:hover { border-color: #4f46e5; background: #eef2ff; }
.tc-service-image-placeholder-inner { text-align: center; color: #94a3b8; }
.tc-service-image-placeholder-inner i { font-size: 1.5rem; margin-bottom: 0.3rem; display: block; color: #64748b; }
.tc-service-image-placeholder-inner span { font-size: 0.82rem; font-weight: 600; color: #64748b; display: block; }
.tc-service-image-placeholder-inner small { font-size: 0.72rem; color: #94a3b8; }

/* ===== Service Card ===== */
.tc-service-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; margin-bottom: 1rem; overflow: hidden; transition: all 0.2s; }
.tc-service-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); border-color: #c7d2fe; }

/* ===== Repeatable Items ===== */
.tc-repeatable-item { background: #fafbfc; border: 1px solid #e5e7eb; border-radius: 10px; margin-bottom: 1rem; overflow: hidden; transition: box-shadow 0.2s; }
.tc-repeatable-item:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
.tc-item-header { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; background: linear-gradient(135deg, #f8fafc, #f1f5f9); border-bottom: 1px solid #e5e7eb; }
.tc-item-number { width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; flex-shrink: 0; }
.tc-item-remove { width: 32px; height: 32px; border-radius: 8px; border: none; background: #fef2f2; color: #dc2626; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s; flex-shrink: 0; }
.tc-item-remove:hover { background: #fee2e2; }
.tc-item-body { padding: 1rem; }

/* ===== Add Item Button ===== */
.btn-add-item { padding: 0.5rem 1rem; border: 2px dashed #4f46e5; background: #eef2ff; color: #4f46e5; border-radius: 8px; font-size: 0.82rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.4rem; transition: all 0.2s; font-family: inherit; }
.btn-add-item:hover { background: #e0e7ff; border-color: #4338ca; }

/* ===== Empty State ===== */
.tc-empty-state { text-align: center; padding: 2.5rem 1rem; color: #94a3b8; }
.tc-empty-state p { margin: 0; }

/* ===== Media ===== */
.tc-media-preview { display: flex; align-items: center; gap: 1rem; padding: 1rem; background: #f8fafc; border-radius: 10px; border: 1px solid #e5e7eb; }
.tc-media-thumb { flex-shrink: 0; }
.tc-media-info { flex: 1; }
.tc-media-info strong { display: block; font-size: 0.88rem; color: #334155; display: flex; align-items: center; gap: 0.3rem; }
.tc-media-info small { color: #94a3b8; font-size: 0.78rem; }
.tc-media-delete { width: 36px; height: 36px; border-radius: 8px; border: none; background: #fef2f2; color: #dc2626; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s; flex-shrink: 0; }
.tc-media-delete:hover { background: #fee2e2; }
.tc-empty-media { text-align: center; padding: 2rem; background: #f8fafc; border: 2px dashed #e2e8f0; border-radius: 10px; color: #94a3b8; display: flex; flex-direction: column; align-items: center; justify-content: center; }
.tc-empty-media p { margin: 0; font-weight: 600; color: #64748b; }

/* ===== Upload Button ===== */
.btn-upload-media { padding: 0.5rem 1rem; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: #fff; border: none; border-radius: 8px; font-size: 0.82rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.4rem; transition: all 0.2s; font-family: inherit; }
.btn-upload-media:hover { box-shadow: 0 4px 12px rgba(79,70,229,0.3); }

/* ===== Gallery ===== */
.tc-gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 0.75rem; }
.tc-gallery-item { position: relative; border-radius: 10px; overflow: hidden; aspect-ratio: 1; border: 1px solid #e5e7eb; transition: all 0.2s; }
.tc-gallery-item:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
.tc-gallery-item img { width: 100%; height: 100%; object-fit: cover; }
.tc-gallery-overlay { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); display: flex; align-items: flex-start; justify-content: flex-end; padding: 6px; opacity: 0; transition: opacity 0.2s; }
.tc-gallery-item:hover .tc-gallery-overlay { opacity: 1; }
.tc-gallery-delete { width: 28px; height: 28px; border-radius: 50%; border: none; background: rgba(239,68,68,0.9); color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; transition: all 0.2s; }
.tc-gallery-delete:hover { background: #dc2626; }

/* ===== Contact Fields ===== */
.tc-contact-field { background: #f8fafc; padding: 1rem; border-radius: 10px; border: 1px solid #e5e7eb; }
.tc-contact-field input { background: #fff !important; }

/* ===== Save Bar ===== */
.tc-save-bar { position: sticky; bottom: 0; background: rgba(255,255,255,0.95); backdrop-filter: blur(12px); padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb; border-radius: 0 0 16px 16px; display: flex; justify-content: flex-end; gap: 0.75rem; box-shadow: 0 -4px 15px rgba(0,0,0,0.05); z-index: 10; margin: 0 -1rem; }
.tc-save-btn { padding: 0.7rem 2rem; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: #fff; border: none; border-radius: 10px; font-size: 0.95rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; transition: all 0.2s; font-family: inherit; }
.tc-save-btn:hover { box-shadow: 0 4px 15px rgba(79,70,229,0.4); transform: translateY(-1px); }
.tc-reset-btn { padding: 0.7rem 1.5rem; background: #f1f5f9; color: #64748b; border: 1px solid #e5e7eb; border-radius: 10px; font-size: 0.88rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.4rem; transition: all 0.2s; font-family: inherit; }
.tc-reset-btn:hover { background: #e2e8f0; }

/* ===== Preview Strip ===== */
.tc-preview-strip { border: 2px solid #e5e7eb; }

/* ===== Toast Notification ===== */
.tc-toast { position: fixed; top: 20px; <?= $dir === 'rtl' ? 'left' : 'right' ?>: 20px; padding: 0.75rem 1.25rem; border-radius: 10px; color: #fff; font-size: 0.88rem; font-weight: 600; z-index: 99999; display: flex; align-items: center; gap: 0.5rem; animation: tcSlideIn 0.3s ease; box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
.tc-toast-success { background: linear-gradient(135deg, #059669, #047857); }
.tc-toast-error { background: linear-gradient(135deg, #dc2626, #b91c1c); }
@keyframes tcSlideIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

@media (max-width: 768px) {
    .tc-tabs { flex-direction: column; }
    .tc-tab { width: 100%; justify-content: center; }
    .tc-lang-fields { grid-template-columns: 1fr !important; }
    .tc-save-bar { flex-direction: column; }
    .tc-save-btn, .tc-reset-btn { width: 100%; justify-content: center; }
    .tc-service-image-preview, .tc-service-image-placeholder { max-width: 100%; }
}
</style>

<script>
// Toast notification helper
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = 'tc-toast tc-toast-' + type;
    toast.innerHTML = '<i class="fas fa-' + (type === 'success' ? 'check-circle' : 'exclamation-circle') + '"></i> ' + message;
    document.body.appendChild(toast);
    setTimeout(() => { toast.style.opacity = '0'; toast.style.transition = 'opacity 0.3s'; setTimeout(() => toast.remove(), 300); }, 3000);
}

// Tab switching
function switchTab(tabName, btn) {
    document.querySelectorAll('.tc-panel').forEach(p => p.style.display = 'none');
    document.querySelectorAll('.tc-tab').forEach(t => t.classList.remove('active'));
    const panel = document.getElementById('tab-' + tabName);
    if (panel) panel.style.display = 'block';
    if (btn) btn.classList.add('active');
}

// Hero live preview
function updateHeroPreview() {
    const title = document.querySelector('[name="hero_title_ar"]');
    const sub = document.querySelector('[name="hero_subtitle_ar"]');
    const desc = document.querySelector('[name="hero_description_ar"]');
    const btn = document.querySelector('[name="hero_button_text_ar"]');
    if (title) document.getElementById('heroPreviewTitle').textContent = title.value || 'عنوان البانر الرئيسي';
    if (sub) document.getElementById('heroPreviewSub').textContent = sub.value || 'العنوان الفرعي';
    if (desc) document.getElementById('heroPreviewDesc').textContent = desc.value || 'وصف مختصر عن القالب';
    if (btn) document.getElementById('heroPreviewBtn').textContent = btn.value || 'تواصل معنا';
}

// Add service item
let serviceCounter = <?= count($services) ?>;
function addServiceItem() {
    const container = document.getElementById('servicesContainer');
    const emptyState = container.querySelector('.tc-empty-state');
    if (emptyState) emptyState.remove();
    
    const key = 'service_' + (serviceCounter + 1);
    const html = `
    <div class="tc-service-card" data-index="${serviceCounter}" data-key="${key}">
        <div class="tc-item-header">
            <span class="tc-item-number">${serviceCounter + 1}</span>
            <div style="flex:1; display:flex; align-items:center; gap:0.75rem;">
                <div style="width:36px; height:36px; border-radius:8px; background:#f1f5f9; display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-star" style="color:#94a3b8; font-size:0.85rem;"></i>
                </div>
                <strong style="font-size:0.88rem; color:#334155;">خدمة جديدة</strong>
            </div>
            <button type="button" class="tc-item-remove" onclick="removeItem(this)">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
        <div class="tc-item-body">
            <div class="tc-service-image-section">
                <div class="tc-service-image-area">
                    <div class="tc-service-image-placeholder" onclick="document.getElementById('svcImg_${serviceCounter}').click();">
                        <div class="tc-service-image-placeholder-inner">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>اضغط لرفع صورة الخدمة</span>
                            <small>PNG, JPG, WebP - 1024x1024</small>
                        </div>
                    </div>
                    <input type="file" id="svcImg_${serviceCounter}" accept="image/*" style="display:none;" onchange="uploadServiceImage(<?= $theme->id ?>, '${key}', this, ${serviceCounter})">
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;">
                <div class="form-group">
                    <label><span class="tc-lang-flag">🇸🇦</span> اسم الخدمة (عربي)</label>
                    <input type="text" name="services_ar[${serviceCounter}][title_ar]" placeholder="اسم الخدمة">
                </div>
                <div class="form-group">
                    <label><span class="tc-lang-flag">🇬🇧</span> اسم الخدمة (إنجليزي)</label>
                    <input type="text" name="services_en[${serviceCounter}][title_en]" placeholder="Service Name">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label><span class="tc-lang-flag">🇸🇦</span> وصف الخدمة (عربي)</label>
                    <textarea name="services_ar[${serviceCounter}][description_ar]" rows="2" placeholder="وصف الخدمة..."></textarea>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label><span class="tc-lang-flag">🇬🇧</span> وصف الخدمة (إنجليزي)</label>
                    <textarea name="services_en[${serviceCounter}][description_en]" rows="2" placeholder="Service description..."></textarea>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-icons" style="color:#4f46e5;"></i> أيقونة (Font Awesome)</label>
                    <input type="text" name="services_ar[${serviceCounter}][icon]" value="fas fa-star" placeholder="fas fa-star">
                </div>
                <div class="form-group">
                    <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; margin-top:1.5rem;">
                        <input type="checkbox" name="services_ar[${serviceCounter}][show_on_home]" value="1" checked>
                        عرض في الصفحة الرئيسية
                    </label>
                </div>
            </div>
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
    serviceCounter++;
}

// Add testimonial item
let testimonialCounter = <?= count($testimonials) ?>;
function addTestimonialItem() {
    const container = document.getElementById('testimonialsContainer');
    const emptyState = container.querySelector('.tc-empty-state');
    if (emptyState) emptyState.remove();

    const html = `
    <div class="tc-repeatable-item" data-index="${testimonialCounter}">
        <div class="tc-item-header">
            <span class="tc-item-number">${testimonialCounter + 1}</span>
            <div style="flex:1; display:flex; align-items:center; gap:0.5rem;">
                <div style="width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg, #fbbf24, #f59e0b); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:0.75rem;">?</div>
                <strong style="font-size:0.88rem; color:#334155;">شهادة جديدة</strong>
            </div>
            <button type="button" class="tc-item-remove" onclick="removeItem(this)">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
        <div class="tc-item-body">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem;">
                <div class="form-group">
                    <label>اسم العميل (عربي)</label>
                    <input type="text" name="testimonials_ar[${testimonialCounter}][client_name]" placeholder="اسم العميل">
                </div>
                <div class="form-group">
                    <label>المسمى الوظيفي (عربي)</label>
                    <input type="text" name="testimonials_ar[${testimonialCounter}][client_title]" placeholder="المسمى الوظيفي">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label>نص الشهادة (عربي)</label>
                    <textarea name="testimonials_ar[${testimonialCounter}][content]" rows="2" placeholder="نص الشهادة..."></textarea>
                </div>
                <div class="form-group">
                    <label>التقييم</label>
                    <select name="testimonials_ar[${testimonialCounter}][rating]" style="width:auto;">
                        <option value="5">★★★★★ 5/5</option>
                        <option value="4">★★★★ 4/5</option>
                        <option value="3">★★★ 3/5</option>
                        <option value="2">★★ 2/5</option>
                        <option value="1">★ 1/5</option>
                    </select>
                </div>
            </div>
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
    testimonialCounter++;
}

// Remove item
function removeItem(btn) {
    if (!confirm('هل أنت متأكد من حذف هذا العنصر؟')) return;
    const item = btn.closest('.tc-service-card, .tc-repeatable-item');
    if (item) item.remove();
}

// Upload service image
function uploadServiceImage(themeId, serviceKey, input, index) {
    const file = input.files[0];
    if (!file) return;
    
    const formData = new FormData();
    formData.append('media_file', file);
    formData.append('media_type', 'service_image');
    formData.append('section_ref', serviceKey);
    formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

    fetch('<?= url("/admin/themes/media/upload") ?>/' + themeId, {
        method: 'POST', body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast('تم رفع صورة الخدمة بنجاح');
            setTimeout(() => location.reload(), 800);
        } else {
            showToast(data.message || 'حدث خطأ أثناء الرفع', 'error');
        }
    })
    .catch(() => showToast('حدث خطأ في الاتصال', 'error'));
}

// Upload general media
function uploadMedia(themeId, mediaType, sectionRef) {
    const fileInput = event.target;
    const file = fileInput.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('media_file', file);
    formData.append('media_type', mediaType);
    formData.append('section_ref', sectionRef);
    formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

    fetch('<?= url("/admin/themes/media/upload") ?>/' + themeId, {
        method: 'POST', body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast('تم رفع ' + (mediaType === 'logo' ? 'الشعار' : 'البانر') + ' بنجاح');
            setTimeout(() => location.reload(), 800);
        } else {
            showToast(data.message || 'حدث خطأ أثناء الرفع', 'error');
        }
    })
    .catch(() => showToast('حدث خطأ في الاتصال', 'error'));
}

// Upload gallery media (multiple)
function uploadGalleryMedia(themeId) {
    const fileInput = document.getElementById('galleryFile');
    const files = fileInput.files;
    if (!files.length) return;

    let uploaded = 0;
    Array.from(files).forEach(file => {
        const formData = new FormData();
        formData.append('media_file', file);
        formData.append('media_type', 'gallery');
        formData.append('section_ref', 'general');
        formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

        fetch('<?= url("/admin/themes/media/upload") ?>/' + themeId, {
            method: 'POST', body: formData
        })
        .then(r => r.json())
        .then(data => {
            uploaded++;
            if (uploaded === files.length) {
                showToast('تم رفع ' + files.length + ' صور بنجاح');
                setTimeout(() => location.reload(), 800);
            }
        })
        .catch(() => showToast('حدث خطأ في الاتصال', 'error'));
    });
}

// Delete media
function deleteMedia(mediaId, element) {
    if (!confirm('هل أنت متأكد من حذف هذه الصورة؟')) return;

    const formData = new FormData();
    formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

    fetch('<?= url("/admin/themes/media/delete") ?>/' + mediaId, {
        method: 'POST', body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast('تم حذف الصورة بنجاح');
            if (element) element.remove();
            setTimeout(() => location.reload(), 800);
        } else {
            showToast(data.message || 'حدث خطأ أثناء الحذف', 'error');
        }
    })
    .catch(() => showToast('حدث خطأ في الاتصال', 'error'));
}

// Save form with loading state
document.getElementById('themeContentForm').addEventListener('submit', function() {
    const btn = document.getElementById('saveAllBtn');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...';
    btn.disabled = true;
});
</script>
