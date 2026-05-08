<?php
/**
 * Banners Management View
 * إدارة البانرات - لوحة تحكم المستأجر
 */
?>

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="page-title">
            <i class="fas fa-images"></i>
            <?= lang('banners') ?? 'البانرات' ?>
        </h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bannerModal" onclick="openBannerModal()">
            <i class="fas fa-plus"></i>
            <?= lang('add_banner') ?? 'إضافة بانر' ?>
        </button>
    </div>
</div>

<?php if (Session::has('success')): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <?= Session::getSuccess() ?>
</div>
<?php endif; ?>

<?php if (Session::has('error')): ?>
<div class="alert alert-danger">
    <i class="fas fa-exclamation-circle"></i>
    <?= Session::getError() ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <?php if (empty($banners)): ?>
        <div style="text-align: center; padding: 3rem; color: var(--secondary);">
            <i class="fas fa-images" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.3; display: block;"></i>
            <h5><?= lang('no_banners') ?? 'لا توجد بانرات' ?></h5>
            <p style="margin-top: 0.5rem;"><?= lang('add_banner') ?? 'أضف بانر جديد لعرضه في موقعك' ?></p>
            <button type="button" class="btn btn-primary" style="margin-top: 1rem;" data-bs-toggle="modal" data-bs-target="#bannerModal" onclick="openBannerModal()">
                <i class="fas fa-plus"></i>
                <?= lang('add_banner') ?? 'إضافة بانر' ?>
            </button>
        </div>
        <?php else: ?>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 80px;"><?= lang('image') ?? 'الصورة' ?></th>
                        <th><?= lang('title') ?? 'العنوان' ?></th>
                        <th><?= lang('subtitle') ?? 'العنوان الفرعي' ?></th>
                        <th style="width: 80px;"><?= lang('order') ?? 'الترتيب' ?></th>
                        <th style="width: 80px;"><?= lang('status') ?? 'الحالة' ?></th>
                        <th style="width: 100px;"><?= lang('actions') ?? 'الإجراءات' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($banners as $banner): ?>
                    <tr>
                        <td>
                            <?php if (!empty($banner->image)): ?>
                            <img src="<?= upload($banner->image) ?>" 
                                 alt="<?= $this->e($banner->title ?? '') ?>" 
                                 style="width: 70px; height: 40px; object-fit: cover; border-radius: 6px;">
                            <?php else: ?>
                            <div style="width: 70px; height: 40px; background: var(--light); border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image" style="color: #94a3b8;"></i>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?= $this->e($banner->title ?? '') ?></strong>
                        </td>
                        <td>
                            <?= $this->e($banner->subtitle ?? '') ?>
                        </td>
                        <td>
                            <span class="badge badge-info"><?= $banner->display_order ?? $banner->position ?? '-' ?></span>
                        </td>
                        <td>
                            <span class="badge <?= ($banner->status ?? '') === 'active' ? 'badge-success' : 'badge-secondary' ?>">
                                <?= ($banner->status ?? '') === 'active' ? (lang('active') ?? 'نشط') : (lang('inactive') ?? 'غير نشط') ?>
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" 
                                    onclick="deleteBanner(<?= $banner->id ?>, this)"
                                    title="<?= lang('delete') ?? 'حذف' ?>">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Add Banner Modal -->
<div class="modal fade" id="bannerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bannerModalTitle"><?= lang('add_banner') ?? 'إضافة بانر جديد' ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="bannerForm" method="POST" action="<?= url('/dashboard/banners') ?>" enctype="multipart/form-data">
                <?= $this->csrf() ?>
                
                <div class="modal-body">
                    <!-- Arabic Fields -->
                    <div class="lang-section-header">
                        <span class="lang-badge">🇸🇦 العربية</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label"><?= lang('banner_title') ?? 'عنوان البانر' ?> (العربية) *</label>
                            <input type="text" name="title" class="form-control" dir="rtl" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?= lang('banner_subtitle') ?? 'العنوان الفرعي' ?> (العربية)</label>
                            <input type="text" name="subtitle" class="form-control" dir="rtl">
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label"><?= lang('banner_description') ?? 'وصف البانر' ?> (العربية)</label>
                        <textarea name="description" class="form-control" rows="2" dir="rtl"></textarea>
                    </div>

                    <!-- English Fields -->
                    <div class="lang-section-header" style="margin-top: 1.5rem;">
                        <span class="lang-badge">🇬🇧 English</span>
                        <span class="form-hint" style="margin-right: auto;">(اختياري / Optional)</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Banner Title (English)</label>
                            <input type="text" name="title_en" class="form-control" dir="ltr" placeholder="Banner title in English">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Subtitle (English)</label>
                            <input type="text" name="subtitle_en" class="form-control" dir="ltr" placeholder="Subtitle in English">
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label">Description (English)</label>
                        <textarea name="description_en" class="form-control" rows="2" dir="ltr" placeholder="Description in English"></textarea>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;" class="mt-2">
                        <div class="form-group">
                            <label class="form-label">Button Text (English)</label>
                            <input type="text" name="button_text_en" class="form-control" dir="ltr" placeholder="Button text in English">
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?= lang('banner_button') ?? 'نص الزر' ?> (العربية)</label>
                            <input type="text" name="button_text" class="form-control" dir="rtl">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;" class="mt-2">
                        <div class="form-group">
                            <label class="form-label"><?= lang('banner_link') ?? 'رابط البانر' ?></label>
                            <input type="text" name="link" class="form-control" placeholder="#contact">
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <label class="form-label"><?= lang('banner_image') ?? 'صورة البانر' ?> *</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <span class="form-hint">الحجم المقترح: 1920×600px</span>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-bs-dismiss="modal"><?= lang('cancel') ?? 'إلغاء' ?></button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        <?= lang('save') ?? 'حفظ' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openBannerModal() {
    document.getElementById('bannerForm').reset();
    document.getElementById('bannerModalTitle').textContent = '<?= lang('add_banner') ?? 'إضافة بانر جديد' ?>';
}

function deleteBanner(id, btn) {
    if (confirm('<?= lang('confirm_delete') ?? 'هل أنت متأكد من الحذف؟' ?>')) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= url('/dashboard/banners/delete') ?>/' + id;
        
        var csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = 'csrf_token';
        csrfInput.value = '<?= Security::csrfToken() ?>';
        form.appendChild(csrfInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<style>
.lang-section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding-bottom: 0.5rem;
    margin-bottom: 0.75rem;
    border-bottom: 2px solid var(--border, #e2e8f0);
}
.lang-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: var(--primary, #4f46e5);
    color: #fff;
    padding: 0.35rem 1rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
}
</style>
