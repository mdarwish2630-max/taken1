<?php
/**
 * CleanPro Theme — Footer Partial
 * 4-column footer with dark navy background
 */
$siteBase = $siteBase ?? (BASE_PATH . '/site/' . $tenant->slug);
$lang     = $lang ?? 'ar';
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);
$phone    = $tenant->contact_phone ?? '';
$email    = $tenant->contact_email ?? '';
$address  = $tenant->address ?? '';
$facebook = $tenant->facebook ?? '';
$instagram = $tenant->instagram ?? '';
$twitter  = $tenant->twitter ?? '';
$youtube  = $tenant->youtube ?? '';
$siteName = htmlspecialchars($tenant->site_name ?? 'كلين برو');
?>
<!-- Footer -->
<footer class="cpro-footer">
    <div class="cpro-container">
        <div class="cpro-footer-grid">
            <div>
                <h3><?= $siteName ?></h3>
                <p><?= htmlspecialchars($tenant->meta_description) ?: ($lang === 'en'
                    ? 'Professional carpet cleaning company providing high-quality services for homes and businesses.'
                    : 'شركة تنظيف سجاد احترافية تقدم خدمات عالية الجودة للمنازل والشركات.') ?></p>
                <?php if (!empty($facebook) || !empty($instagram) || !empty($twitter) || !empty($youtube) || !empty($tenant->linkedin) || !empty($tenant->tiktok)): ?>
                    <div style="display:flex;gap:12px;margin-top:16px">
                        <?php if ($facebook): ?><a href="<?= htmlspecialchars($facebook) ?>" target="_blank" style="color:#fff;font-size:20px"><i class="fab fa-facebook"></i></a><?php endif; ?>
                        <?php if ($instagram): ?><a href="<?= htmlspecialchars($instagram) ?>" target="_blank" style="color:#fff;font-size:20px"><i class="fab fa-instagram"></i></a><?php endif; ?>
                        <?php if ($twitter): ?><a href="<?= htmlspecialchars($twitter) ?>" target="_blank" style="color:#fff;font-size:20px"><i class="fab fa-twitter"></i></a><?php endif; ?>
                        <?php if ($youtube): ?><a href="<?= htmlspecialchars($youtube) ?>" target="_blank" style="color:#fff;font-size:20px"><i class="fab fa-youtube"></i></a><?php endif; ?>
                        <?php if (!empty($tenant->linkedin)): ?><a href="<?= htmlspecialchars($tenant->linkedin) ?>" target="_blank" style="color:#fff;font-size:20px"><i class="fab fa-linkedin"></i></a><?php endif; ?>
                        <?php if (!empty($tenant->tiktok)): ?><a href="<?= htmlspecialchars($tenant->tiktok) ?>" target="_blank" style="color:#fff;font-size:20px"><i class="fab fa-tiktok"></i></a><?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div>
                <h4><?= $lang === 'en' ? 'Quick Links' : 'روابط سريعة' ?></h4>
                <ul>
                    <?php if (!empty($menu)): foreach (array_slice($menu, 0, 6) as $item):
                        $nHref = $siteBase;
                        $nSlug = strtolower($item->slug ?? '');
                        if ($item->is_home != 1 && !empty($nSlug)) { $nHref = $siteBase . '/' . $nSlug; }
                        $nLabel = $lang === 'en' && !empty($item->title_en) ? $item->title_en : ($item->title ?? '');
                    ?>
                        <li><a href="<?= url($nHref) ?>"><?= htmlspecialchars($nLabel) ?></a></li>
                    <?php endforeach; endif; ?>
                </ul>
            </div>
            <div>
                <h4><?= $lang === 'en' ? 'Contact Info' : 'معلومات التواصل' ?></h4>
                <ul>
                    <?php if ($phone): ?><li><i class="fas fa-phone-alt" style="color:var(--blue);margin-inline-end:8px"></i><?= htmlspecialchars($phone) ?></li><?php endif; ?>
                    <?php if ($email): ?><li><i class="fas fa-envelope" style="color:var(--blue);margin-inline-end:8px"></i><?= htmlspecialchars($email) ?></li><?php endif; ?>
                    <?php if ($address): ?><li><i class="fas fa-map-marker-alt" style="color:var(--blue);margin-inline-end:8px"></i><?= htmlspecialchars($address) ?></li><?php endif; ?>
                </ul>
            </div>
            <div>
                <h4><?= $lang === 'en' ? 'Newsletter' : 'النشرة البريدية' ?></h4>
                <p><?= $lang === 'en' ? 'Subscribe to get the latest updates and offers.' : 'اشترك للحصول على آخر العروض والتحديثات.' ?></p>
                <div class="cpro-newsletter">
                    <input type="email" placeholder="Email">
                    <button class="cpro-btn" style="padding:13px 18px">OK</button>
                </div>
            </div>
        </div>
    </div>
    <div class="cpro-container cpro-copyright">
        Copyright &copy; <?= date('Y') ?> <?= $siteName ?>. <?= $lang === 'en' ? 'All rights reserved.' : 'جميع الحقوق محفوظة.' ?>
    </div>
</footer>
