<?php
/**
 * SEO Settings View
 * صفحة إعدادات SEO
 */


$tenant = $tenant ?? Auth::tenant();
?>

<div class="page-header">
    <h1 class="h3 mb-0">
        <i class="fas fa-search me-2"></i>
        <?= lang('seo_settings') ?>
    </h1>
</div>

<form method="POST" action="<?= url('/dashboard/seo') ?>" enctype="multipart/form-data" id="seoForm">
    <?= $this->csrf() ?>
    
    <!-- Basic SEO -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-tag me-2"></i>
                <?= lang('basic_seo') ?>
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold"><?= lang('meta_title') ?></label>
                        <input type="text" name="meta_title" class="form-control" 
                               value="<?= htmlspecialchars($seo->meta_title ?? '') ?>"
                               placeholder="<?= lang('meta_title_placeholder') ?>"
                               maxlength="60">
                        <small class="text-muted"><?= lang('meta_title_hint') ?></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold"><?= lang('meta_keywords') ?></label>
                        <input type="text" name="meta_keywords" class="form-control" 
                               value="<?= htmlspecialchars($seo->meta_keywords ?? '') ?>"
                               placeholder="<?= lang('keywords_placeholder') ?>">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold"><?= lang('meta_description') ?></label>
                <textarea name="meta_description" class="form-control" rows="3" 
                          maxlength="160"
                          placeholder="<?= lang('meta_description_placeholder') ?>"><?= htmlspecialchars($seo->meta_description ?? '') ?></textarea>
                <small class="text-muted"><?= lang('meta_description_hint') ?></small>
            </div>
            
            <div class="mb-3">
                <label class="form-label"><?= lang('canonical_url') ?></label>
                <input type="url" name="canonical_url" class="form-control" 
                       value="<?= htmlspecialchars($seo->canonical_url ?? '') ?>"
                       placeholder="https://example.com">
            </div>
        </div>
    </div>
    
    <!-- Open Graph -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fab fa-facebook me-2"></i>
                Open Graph / <?= lang('social_media') ?>
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><?= lang('og_title') ?> (Facebook)</label>
                        <input type="text" name="og_title" class="form-control" 
                               value="<?= htmlspecialchars($seo->og_title ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><?= lang('twitter_card') ?></label>
                        <select name="twitter_card" class="form-select">
                            <option value="summary" <?= ($seo->twitter_card ?? '') === 'summary' ? 'selected' : '' ?>>
                                Summary
                            </option>
                            <option value="summary_large_image" <?= ($seo->twitter_card ?? '') === 'summary_large_image' ? 'selected' : '' ?>>
                                Summary Large Image
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label"><?= lang('og_description') ?></label>
                <textarea name="og_description" class="form-control" rows="2"><?= htmlspecialchars($seo->og_description ?? '') ?></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label"><?= lang('og_image') ?></label>
                <?php if (!empty($seo->og_image)): ?>
                    <div class="mb-2">
                        <img src="<?= upload($seo->og_image) ?>" alt="OG Image" 
                             style="max-width: 300px; border-radius: 0.5rem;">
                    </div>
                <?php endif; ?>
                <input type="file" name="og_image_file" class="form-control" accept="image/*">
                <small class="text-muted"><?= lang('og_image_hint') ?></small>
            </div>
        </div>
    </div>
    
    <!-- Analytics & Tracking -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-chart-bar me-2"></i>
                <?= lang('tracking_codes') ?>
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fab fa-google text-danger me-1"></i>
                            Google Analytics ID
                        </label>
                        <input type="text" name="google_analytics_id" class="form-control font-monospace" 
                               value="<?= htmlspecialchars($seo->google_analytics_id ?? '') ?>"
                               placeholder="G-XXXXXXXXXX">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fab fa-google text-primary me-1"></i>
                            Google Tag Manager ID
                        </label>
                        <input type="text" name="google_tag_manager_id" class="form-control font-monospace" 
                               value="<?= htmlspecialchars($seo->google_tag_manager_id ?? '') ?>"
                               placeholder="GTM-XXXXXX">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fab fa-facebook text-primary me-1"></i>
                            Facebook Pixel ID
                        </label>
                        <input type="text" name="facebook_pixel_id" class="form-control font-monospace" 
                               value="<?= htmlspecialchars($seo->facebook_pixel_id ?? '') ?>"
                               placeholder="123456789012345">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Site Verification -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-check-circle me-2"></i>
                <?= lang('site_verification') ?>
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fab fa-google me-1"></i>
                            Google Site Verification
                        </label>
                        <input type="text" name="google_site_verification" class="form-control" 
                               value="<?= htmlspecialchars($seo->google_site_verification ?? '') ?>"
                               placeholder="verification code">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Bing Site Verification</label>
                        <input type="text" name="bing_site_verification" class="form-control" 
                               value="<?= htmlspecialchars($seo->bing_site_verification ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Schema Markup -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-code me-2"></i>
                Schema.org <?= lang('markup') ?>
            </h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label"><?= lang('schema_type') ?></label>
                <select name="schema_type" class="form-select">
                    <option value="LocalBusiness" <?= ($seo->schema_type ?? '') === 'LocalBusiness' ? 'selected' : '' ?>>
                        Local Business
                    </option>
                    <option value="ProfessionalService" <?= ($seo->schema_type ?? '') === 'ProfessionalService' ? 'selected' : '' ?>>
                        Professional Service
                    </option>
                    <option value="HomeAndConstructionBusiness" <?= ($seo->schema_type ?? '') === 'HomeAndConstructionBusiness' ? 'selected' : '' ?>>
                        Home & Construction Business
                    </option>
                    <option value="Organization" <?= ($seo->schema_type ?? '') === 'Organization' ? 'selected' : '' ?>>
                        Organization
                    </option>
                </select>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><?= lang('business_name') ?></label>
                        <input type="text" name="schema_name" class="form-control" 
                               value="<?= htmlspecialchars(json_decode($seo->schema_data ?? '{}', true)['name'] ?? $tenant->site_name) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><?= lang('phone') ?></label>
                        <input type="text" name="schema_telephone" class="form-control" 
                               value="<?= htmlspecialchars(json_decode($seo->schema_data ?? '{}', true)['telephone'] ?? $tenant->contact_phone) ?>">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label"><?= lang('address') ?></label>
                <input type="text" name="schema_address" class="form-control" 
                       value="<?= htmlspecialchars(json_decode($seo->schema_data ?? '{}', true)['address'] ?? $tenant->address) ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label"><?= lang('price_range') ?></label>
                <select name="schema_price_range" class="form-select">
                    <option value="$" <?= (json_decode($seo->schema_data ?? '{}', true)['price_range'] ?? '') === '$' ? 'selected' : '' ?>>$ (اقتصادي)</option>
                    <option value="$$" <?= (json_decode($seo->schema_data ?? '{}', true)['price_range'] ?? '') === '$$' ? 'selected' : '' ?>>$$ (متوسط)</option>
                    <option value="$$$" <?= (json_decode($seo->schema_data ?? '{}', true)['price_range'] ?? '') === '$$$' ? 'selected' : '' ?>>$$$ (مرتفع)</option>
                </select>
            </div>
        </div>
    </div>
    
    <!-- Robots & Indexing -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-robot me-2"></i>
                Robots & Indexing
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="noindex" id="noindex" value="1"
                               <?= ($seo->noindex ?? 0) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="noindex">
                            <strong>Noindex</strong> - <?= lang('noindex_desc') ?>
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="nofollow" id="nofollow" value="1"
                               <?= ($seo->nofollow ?? 0) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="nofollow">
                            <strong>Nofollow</strong> - <?= lang('nofollow_desc') ?>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="enable_sitemap" id="enableSitemap" value="1"
                       <?= ($seo->enable_sitemap ?? 1) ? 'checked' : '' ?>>
                <label class="form-check-label" for="enableSitemap">
                    <strong><?= lang('enable_sitemap') ?></strong>
                </label>
            </div>
            
            <div class="mb-3">
                <label class="form-label">robots.txt</label>
                <textarea name="robots_txt" class="form-control font-monospace" rows="4"><?= htmlspecialchars($seo->robots_txt ?? "User-agent: *\nAllow: /") ?></textarea>
            </div>
        </div>
    </div>
    
    <!-- Actions -->
    <div class="card">
        <div class="card-body">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>
                <?= lang('save_changes') ?>
            </button>
            
            <button type="button" class="btn btn-outline-secondary ms-2" onclick="generateSitemap()">
                <i class="fas fa-sync me-2"></i>
                <?= lang('generate_sitemap') ?>
            </button>
        </div>
    </div>
</form>

<script>
function generateSitemap() {
    fetch('<?= url('/dashboard/seo/generate-sitemap') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('<?= lang('sitemap_generated') ?>');
        } else {
            alert(data.message || 'Error');
        }
    });
}
</script>
