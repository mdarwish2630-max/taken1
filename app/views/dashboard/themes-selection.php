<?php
/**
 * Dashboard - Themes Selection
 * لوحة التحكم - اختيار القالب (مع دعم الثيمات المدفوعة)
 * تصميم احترافي مع صور بريفيو حقيقية
 */

$lang = Language::current();
$dir = Language::direction();

// بناء خريطة حالة طلبات الثيمات
$requestStatusMap = [];
$paymentLinksMap = [];
if (!empty($themeRequests)) {
    foreach ($themeRequests as $req) {
        $requestStatusMap[$req->theme_id] = $req->status;
        if (!empty($req->payment_link) && $req->status === 'pending') {
            $paymentLinksMap[$req->theme_id] = $req->payment_link;
        }
    }
}

// أيقونات لكل ثيم
$themeIcons = [
    'maintenance' => 'fa-wrench',
    'decor' => 'fa-paint-brush',
    'electric' => 'fa-bolt',
    'plumbing' => 'fa-faucet',
    'cleaning' => 'fa-spray-can',
    'general' => 'fa-cube',
    'medical' => 'fa-heartbeat',
    'realestate' => 'fa-building',
    'restaurant' => 'fa-utensils',
    'education' => 'fa-graduation-cap',
    'fitness' => 'fa-dumbbell',
    'legal' => 'fa-balance-scale',
];

$statusLabels = [
    'pending' => '<span style="background:#fef3c7; color:#92400e; padding:0.2rem 0.6rem; border-radius:20px; font-size:0.72rem; font-weight:600; display:inline-flex; align-items:center; gap:0.3rem;"><i class="fas fa-clock"></i> قيد المراجعة</span>',
    'approved' => '<span style="background:#dcfce7; color:#166534; padding:0.2rem 0.6rem; border-radius:20px; font-size:0.72rem; font-weight:600; display:inline-flex; align-items:center; gap:0.3rem;"><i class="fas fa-check-circle"></i> موافق عليه</span>',
    'rejected' => '<span style="background:#fecaca; color:#991b1b; padding:0.2rem 0.6rem; border-radius:20px; font-size:0.72rem; font-weight:600; display:inline-flex; align-items:center; gap:0.3rem;"><i class="fas fa-times-circle"></i> مرفوض</span>',
    'cancelled' => '<span style="background:#f1f5f9; color:#475569; padding:0.2rem 0.6rem; border-radius:20px; font-size:0.72rem; font-weight:600; display:inline-flex; align-items:center; gap:0.3rem;"><i class="fas fa-ban"></i> ملغي</span>',
];
?>

<div class="themes-page">
    <div class="themes-header">
        <div>
            <h1><?= lang('choose_theme') ?></h1>
            <p style="color: var(--secondary); margin-top: 0.5rem; font-size:0.92rem;">
                <?= lang('choose_theme_desc') ?>
            </p>
        </div>
    </div>

    <div class="themes-grid">
        <?php foreach ($themes as $theme):
            $isCurrentTheme = $tenant->theme_slug === $theme->slug || $tenant->theme_id == $theme->id;
            $isPaid = !empty($theme->is_paid);
            $requestStatus = isset($requestStatusMap[$theme->id]) ? $requestStatusMap[$theme->id] : null;
            $ownsTheme = ($requestStatus === 'approved') || $isCurrentTheme;
            $hasPreview = !empty($theme->preview_image);
            $previewUrl = $hasPreview ? upload($theme->preview_image) : '';
            $icon = $themeIcons[$theme->slug] ?? 'fa-cube';
        ?>
        <div class="theme-card <?= $isCurrentTheme ? 'active' : '' ?> <?= $isPaid ? 'theme-card-paid' : '' ?>">
            <div class="theme-preview" id="cust-preview-<?= $theme->id ?>">
                <?php if ($hasPreview): ?>
                <img src="<?= $previewUrl ?>" alt="<?= $this->e($theme->name) ?>" class="theme-preview-img" loading="lazy">
                <div class="theme-preview-overlay"></div>
                <?php else: ?>
                <div class="theme-preview-fallback">
                    <i class="fas <?= $icon ?>"></i>
                </div>
                <?php endif; ?>

                <!-- شارة الحالة -->
                <?php if ($isPaid): ?>
                <div class="theme-paid-badge-top">
                    <i class="fas fa-crown"></i> Premium
                </div>
                <?php else: ?>
                <div class="theme-free-badge-top">
                    <i class="fas fa-check-circle"></i> مجاني
                </div>
                <?php endif; ?>

                <!-- شارة القالب الحالي -->
                <?php if ($isCurrentTheme): ?>
                <div class="theme-current-badge-top">
                    <i class="fas fa-check"></i> قالبك الحالي
                </div>
                <?php endif; ?>

                <!-- أيقونة القالب -->
                <div class="theme-icon-float">
                    <i class="fas <?= $icon ?>"></i>
                </div>
            </div>

            <div class="theme-info">
                <h3 class="theme-name">
                    <?= $theme->name ?>
                    <?php if ($isCurrentTheme): ?>
                        <span class="current-badge"><?= lang('current_theme') ?></span>
                    <?php endif; ?>
                </h3>
                <?php if (!empty($theme->name_en)): ?>
                <p class="theme-name-en-sm"><?= $this->e($theme->name_en) ?></p>
                <?php endif; ?>
                <p class="theme-description"><?= $theme->description ?></p>

                <?php if ($isPaid): ?>
                <div class="theme-price-display">
                    <i class="fas fa-tag"></i>
                    <?= number_format($theme->price, 2) ?> <?= $theme->currency ?? 'SAR' ?>
                </div>
                <?php endif; ?>

                <div class="theme-meta">
                    <span><i class="fas fa-folder"></i> <?= $theme->category ?? 'عام' ?></span>
                    <?php if ($isPaid): ?>
                        <span class="premium-badge"><i class="fas fa-crown"></i> Premium</span>
                    <?php endif; ?>
                </div>

                <!-- حالة الطلب إذا كان مدفوع -->
                <?php if ($isPaid && $requestStatus): ?>
                <div style="margin-top: 0.75rem;">
                    <?= $statusLabels[$requestStatus] ?? '' ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="theme-actions">
                <?php if ($isCurrentTheme): ?>
                    <button class="btn btn-current" disabled>
                        <i class="fas fa-check"></i>
                        <?= lang('current_theme') ?>
                    </button>
                <?php elseif ($isPaid && !$ownsTheme): ?>
                    <?php if ($requestStatus === 'pending'): ?>
                        <button class="btn btn-pending" disabled>
                            <i class="fas fa-clock"></i> قيد المراجعة
                        </button>
                        <?php if (!empty($theme->payment_link)): ?>
                        <a href="<?= $this->e($theme->payment_link) ?>" target="_blank" class="btn btn-payment">
                            <i class="fas fa-credit-card"></i> ادفع
                        </a>
                        <?php endif; ?>
                    <?php elseif ($requestStatus === 'rejected'): ?>
                        <button class="btn btn-request" onclick="openRequestModal(<?= $theme->id ?>, '<?= $this->e(addslashes($theme->name)) ?>', '<?= $this->e(addslashes($theme->payment_link ?? '')) ?>')">
                            <i class="fas fa-redo"></i> أعد الطلب
                        </button>
                        <a href="<?= url('/' . $tenant->slug . '?preview_theme=' . $theme->slug) ?>" target="_blank" class="btn btn-outline btn-preview">
                            <i class="fas fa-eye"></i> معاينة
                        </a>
                    <?php elseif ($requestStatus === 'cancelled'): ?>
                        <button class="btn btn-request" onclick="openRequestModal(<?= $theme->id ?>, '<?= $this->e(addslashes($theme->name)) ?>', '<?= $this->e(addslashes($theme->payment_link ?? '')) ?>')">
                            <i class="fas fa-paper-plane"></i> طلب التفعيل
                        </button>
                        <a href="<?= url('/' . $tenant->slug . '?preview_theme=' . $theme->slug) ?>" target="_blank" class="btn btn-outline btn-preview">
                            <i class="fas fa-eye"></i> معاينة
                        </a>
                    <?php else: ?>
                        <button class="btn btn-request" onclick="openRequestModal(<?= $theme->id ?>, '<?= $this->e(addslashes($theme->name)) ?>', '<?= $this->e(addslashes($theme->payment_link ?? '')) ?>')">
                            <i class="fas fa-paper-plane"></i> طلب التفعيل
                        </button>
                        <a href="<?= url('/' . $tenant->slug . '?preview_theme=' . $theme->slug) ?>" target="_blank" class="btn btn-outline btn-preview">
                            <i class="fas fa-eye"></i> معاينة
                        </a>
                    <?php endif; ?>
                <?php elseif ($ownsTheme && $isPaid && !$isCurrentTheme): ?>
                    <form method="POST" action="<?= url('/dashboard/settings/theme') ?>">
                        <?= $this->csrf() ?>
                        <input type="hidden" name="theme_slug" value="<?= $theme->slug ?>">
                        <button type="submit" class="btn btn-primary btn-apply">
                            <i class="fas fa-check"></i>
                            <?= lang('apply_theme') ?>
                        </button>
                    </form>
                    <a href="<?= url('/' . $tenant->slug . '?preview_theme=' . $theme->slug) ?>" target="_blank" class="btn btn-outline btn-preview">
                        <i class="fas fa-eye"></i> معاينة
                    </a>
                <?php else: ?>
                    <form method="POST" action="<?= url('/dashboard/settings/theme') ?>">
                        <?= $this->csrf() ?>
                        <input type="hidden" name="theme_slug" value="<?= $theme->slug ?>">
                        <button type="submit" class="btn btn-primary btn-apply">
                            <i class="fas fa-check"></i>
                            <?= lang('apply_theme') ?>
                        </button>
                    </form>
                    <a href="<?= url('/' . $tenant->slug . '?preview_theme=' . $theme->slug) ?>" target="_blank" class="btn btn-outline btn-preview">
                        <i class="fas fa-eye"></i>
                        <?= lang('preview') ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal طلب تفعيل ثيم مدفوع -->
<div id="requestThemeModal" class="modal-overlay" style="display:none;">
    <div class="modal-container" style="max-width:480px;">
        <div class="modal-header">
            <h3><i class="fas fa-crown" style="color:#f59e0b;"></i> طلب تفعيل قالب مدفوع</h3>
            <button class="modal-close" onclick="closeRequestModal()">&times;</button>
        </div>
        <form id="requestThemeForm" method="POST" action="<?= url('/dashboard/themes/request-paid') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="theme_id" id="req_theme_id">

            <div class="modal-body">
                <div style="background:#fffbeb; border:1px solid #fde68a; border-radius:12px; padding:1.25rem; margin-bottom:1rem; text-align:center;">
                    <i class="fas fa-crown" style="color:#f59e0b; font-size:1.5rem; margin-bottom:0.5rem; display:block;"></i>
                    <p style="margin:0; font-size:0.95rem; color:#92400e; font-weight:700;" id="req_theme_name"></p>
                    <p style="margin:0.5rem 0 0; font-size:0.82rem; color:#78716c;">
                        سيتم مراجعة طلبك من قبل الإدارة والموافقة عليه أو رفضه
                    </p>
                </div>

                <div class="form-group">
                    <label for="req_notes">ملاحظات (اختياري)</label>
                    <textarea name="notes" id="req_notes" rows="3" placeholder="أضف أي ملاحظات تود إيضاحها..."></textarea>
                </div>

                <div id="req_payment_link_box" style="display:none; background:#ecfdf5; border:1px solid #a7f3d0; border-radius:12px; padding:1.25rem; text-align:center;">
                    <i class="fas fa-credit-card" style="color:#059669; font-size:1.1rem; margin-bottom:0.5rem; display:block;"></i>
                    <p style="margin:0 0 0.75rem; font-size:0.85rem; color:#065f46; font-weight:600;">
                        بعد تقديم الطلب، يمكنك الدفع من خلال الرابط التالي:
                    </p>
                    <a id="req_payment_link" href="#" target="_blank" style="display:inline-flex; align-items:center; gap:0.5rem; background:#059669; color:#fff; padding:0.6rem 1.5rem; border-radius:10px; font-size:0.85rem; font-weight:600; text-decoration:none;">
                        <i class="fas fa-external-link-alt"></i> الانتقال للدفع
                    </a>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeRequestModal()">
                    <i class="fas fa-times"></i> إلغاء
                </button>
                <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg, #f59e0b, #d97706);">
                    <i class="fas fa-paper-plane"></i> تقديم الطلب
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.themes-page { padding: 0; }
.themes-header { margin-bottom: 2rem; }
.themes-header h1 { font-size: 1.5rem; font-weight: 700; color: var(--dark); }

.themes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

.theme-card {
    background: var(--white, #fff);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    border: 2px solid var(--border, #e5e7eb);
    transition: all 0.3s ease;
}

.theme-card:hover {
    box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    transform: translateY(-3px);
}

.theme-card.active {
    border-color: var(--success, #10b981);
    box-shadow: 0 0 0 3px rgba(16,185,129,0.15);
}

.theme-card-paid {
    border-color: #fbbf24;
}

.theme-card-paid:hover {
    border-color: #f59e0b;
}

.theme-preview {
    height: 190px;
    position: relative;
    overflow: hidden;
    background: #f1f5f9;
}

.theme-preview-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    transition: transform 0.4s ease;
}

.theme-card:hover .theme-preview-img {
    transform: scale(1.03);
}

.theme-preview-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: linear-gradient(to top, rgba(0,0,0,0.4), transparent);
    pointer-events: none;
}

.theme-preview-fallback {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--primary, #2563eb), var(--secondary, #1e40af));
    display: flex;
    align-items: center;
    justify-content: center;
}

.theme-preview-fallback i {
    font-size: 2.5rem;
    color: rgba(255,255,255,0.9);
}

.theme-icon-float {
    position: absolute;
    bottom: 10px;
    <?= $dir === 'rtl' ? 'right' : 'left' ?>: 10px;
    width: 38px;
    height: 38px;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 0.85rem;
    border: 1.5px solid rgba(255,255,255,0.3);
}

.theme-paid-badge-top {
    position: absolute; top: 10px; left: 10px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff; padding: 0.25rem 0.75rem; border-radius: 20px;
    font-size: 0.72rem; font-weight: 700;
    box-shadow: 0 2px 10px rgba(245,158,11,0.5);
    backdrop-filter: blur(8px);
}

.theme-free-badge-top {
    position: absolute; top: 10px; left: 10px;
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff; padding: 0.25rem 0.75rem; border-radius: 20px;
    font-size: 0.72rem; font-weight: 700;
    box-shadow: 0 2px 10px rgba(16,185,129,0.5);
}

.theme-current-badge-top {
    position: absolute; top: 10px;
    <?= $dir === 'rtl' ? 'right' : 'left' ?>: 10px;
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff; padding: 0.25rem 0.75rem; border-radius: 20px;
    font-size: 0.72rem; font-weight: 700;
    box-shadow: 0 2px 10px rgba(16,185,129,0.5);
}

.theme-info { padding: 1.25rem; }

.theme-name {
    font-size: 1.1rem; font-weight: 700; margin-bottom: 0.25rem;
    display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;
    color: #1e293b;
}

.theme-name-en-sm { font-size: 0.8rem; color: #64748b; margin: 0 0 0.5rem; }

.current-badge {
    font-size: 0.72rem; font-weight: 600;
    background: rgba(16,185,129,0.1); color: var(--success, #10b981);
    padding: 0.2rem 0.65rem; border-radius: 9999px;
    border: 1px solid rgba(16,185,129,0.2);
}

.theme-description {
    font-size: 0.85rem; color: var(--secondary, #64748b);
    margin-bottom: 0.75rem; line-height: 1.6;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}

.theme-price-display {
    display: inline-flex; align-items: center; gap: 0.4rem;
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e; padding: 0.35rem 0.85rem; border-radius: 10px;
    font-size: 0.9rem; font-weight: 700; margin-bottom: 0.75rem;
    border: 1px solid #fcd34d;
}

.theme-meta {
    display: flex; align-items: center; gap: 1rem;
    font-size: 0.8rem; color: var(--secondary, #64748b);
}

.premium-badge { color: #f59e0b; font-weight: 600; }

.theme-actions {
    padding: 1rem 1.25rem;
    background: var(--light, #f8fafc);
    display: flex; gap: 0.75rem;
    border-top: 1px solid var(--border, #e5e7eb);
}

.btn-apply, .btn-current, .btn-request, .btn-pending, .btn-payment { flex: 1; }

.btn-current {
    background: var(--success, #10b981); color: #fff; cursor: default;
}

.btn-request {
    background: linear-gradient(135deg, #f59e0b, #d97706) !important;
    color: #fff !important; cursor: pointer;
}

.btn-request:hover { box-shadow: 0 4px 12px rgba(245,158,11,0.4); }

.btn-pending { background: #fbbf24; color: #78350f; cursor: default; }

.btn-payment {
    background: #059669; color: #fff;
    display: flex; align-items: center; justify-content: center;
    gap: 0.4rem; text-decoration: none; font-weight: 600; font-size: 0.85rem;
}

.btn-payment:hover { background: #047857; color: #fff; }
.btn-preview { flex: 0 0 auto; }

/* Modal */
.modal-overlay {
    position: fixed; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);
    z-index: 9999; display: flex; align-items: center;
    justify-content: center; padding: 1rem;
}

.modal-container {
    background: #fff; border-radius: 16px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.3);
    width: 100%; animation: modalIn 0.3s ease;
}

@keyframes modalIn {
    from { opacity: 0; transform: scale(0.95) translateY(10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}

.modal-header {
    display: flex; justify-content: space-between; align-items: center;
    padding: 1.25rem 1.5rem; border-bottom: 1px solid #e5e7eb;
    background: #f8fafc; border-radius: 16px 16px 0 0;
}

.modal-header h3 {
    margin: 0; font-size: 1.05rem; font-weight: 700; color: #1e293b;
    display: flex; align-items: center; gap: 0.5rem;
}

.modal-close {
    width: 32px; height: 32px; border: none;
    background: #e2e8f0; border-radius: 50%;
    cursor: pointer; font-size: 1.2rem;
    display: flex; align-items: center; justify-content: center;
    color: #475569; transition: all 0.2s;
}

.modal-close:hover { background: #fca5a5; color: #dc2626; }
.modal-body { padding: 1.5rem; }

.modal-footer {
    display: flex; justify-content: flex-end; gap: 0.75rem;
    padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb;
    background: #f8fafc; border-radius: 0 0 16px 16px;
}

.form-group { margin-bottom: 1rem; }

.form-group label {
    display: block; font-size: 0.85rem; font-weight: 600;
    color: #334155; margin-bottom: 0.4rem;
}

.form-group textarea {
    width: 100%; padding: 0.6rem 0.85rem;
    border: 1.5px solid #d1d5db; border-radius: 10px;
    font-size: 0.9rem; font-family: inherit;
    box-sizing: border-box; resize: vertical;
}

.form-group textarea:focus {
    outline: none; border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}

.btn {
    padding: 0.6rem 1.2rem; border-radius: 10px;
    font-size: 0.85rem; font-weight: 600;
    cursor: pointer; border: none;
    display: inline-flex; align-items: center; gap: 0.4rem;
    transition: all 0.2s; font-family: inherit; text-decoration: none;
    box-sizing: border-box;
}

.btn-primary {
    background: linear-gradient(135deg, #4f46e5, #7c3aed); color: #fff;
}

.btn-primary:hover {
    box-shadow: 0 4px 12px rgba(79,70,229,0.4);
    transform: translateY(-1px);
}

.btn-outline {
    background: transparent; color: #475569;
    border: 1.5px solid #d1d5db;
}

.btn-outline:hover { background: #f1f5f9; }

@media (max-width: 768px) {
    .themes-grid { grid-template-columns: 1fr; }
    .theme-preview { height: 160px; }
    .theme-actions { flex-direction: column; }
    .btn-preview { flex: 1; }
}
</style>

<script>
function openRequestModal(themeId, themeName, paymentLink) {
    document.getElementById('req_theme_id').value = themeId;
    document.getElementById('req_theme_name').textContent = 'القالب: ' + themeName;
    document.getElementById('req_notes').value = '';

    if (paymentLink && paymentLink.trim() !== '') {
        document.getElementById('req_payment_link').href = paymentLink;
        document.getElementById('req_payment_link_box').style.display = 'block';
    } else {
        document.getElementById('req_payment_link_box').style.display = 'none';
    }

    document.getElementById('requestThemeModal').style.display = 'flex';
}

function closeRequestModal() {
    document.getElementById('requestThemeModal').style.display = 'none';
}

document.getElementById('requestThemeModal').addEventListener('click', function(e) {
    if (e.target === this) closeRequestModal();
});
</script>
