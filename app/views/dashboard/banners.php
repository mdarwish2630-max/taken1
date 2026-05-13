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
                        <th style="width: 140px;"><?= lang('actions') ?? 'الإجراءات' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($banners as $banner): ?>
                    <tr id="banner-row-<?= $banner->id ?>">
                        <td>
                            <?php if (!empty($banner->image)): ?>
                            <img src="<?= upload($banner->image) ?>" 
                                 alt="<?= htmlspecialchars($banner->title ?? '') ?>" 
                                 style="width: 70px; height: 40px; object-fit: cover; border-radius: 6px;">
                            <?php else: ?>
                            <div style="width: 70px; height: 40px; background: var(--light); border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image" style="color: #94a3b8;"></i>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?= htmlspecialchars($banner->title ?? '') ?></strong>
                        </td>
                        <td>
                            <?= htmlspecialchars($banner->subtitle ?? '') ?>
                        </td>
                        <td>
                            <span class="badge badge-info"><?= $banner->display_order ?? '-' ?></span>
                        </td>
                        <td>
                            <span class="badge <?= ($banner->status ?? '') === 'active' ? 'badge-success' : 'badge-secondary' ?>">
                                <?= ($banner->status ?? '') === 'active' ? (lang('active') ?? 'نشط') : (lang('inactive') ?? 'غير نشط') ?>
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.4rem;">
                                <button type="button" class="btn btn-sm btn-warning" 
                                        onclick="editBanner(<?= $banner->id ?>)"
                                        title="<?= lang('edit') ?? 'تعديل' ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" 
                                        data-delete="<?= url('/dashboard/banners/delete/' . $banner->id) ?>"
                                        data-confirm="<?= lang('confirm_delete') ?? 'هل أنت متأكد من حذف هذا البانر؟' ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Banner Modal (Add / Edit) -->
<div class="modal fade" id="bannerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bannerModalTitle"><?= lang('add_banner') ?? 'إضافة بانر جديد' ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="bannerForm" method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="banner_id" id="bannerId" value="">
                <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
                
                <div class="modal-body">
                    <!-- Current image preview (edit mode only) -->
                    <div id="currentImagePreview" style="display: none; margin-bottom: 1rem;">
                        <label class="form-label"><?= lang('current_image') ?? 'الصورة الحالية' ?></label>
                        <div style="position: relative; display: inline-block;">
                            <img id="currentImage" src="" alt="" style="max-width: 100%; max-height: 150px; border-radius: 8px; border: 2px solid var(--border, #e2e8f0);">
                        </div>
                    </div>

                    <!-- Arabic Fields -->
                    <div class="lang-section-header">
                        <span class="lang-badge">🇸🇦 العربية</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label"><?= lang('banner_title') ?? 'عنوان البانر' ?> (العربية) *</label>
                            <input type="text" name="title" id="bannerTitle" class="form-control" dir="rtl" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?= lang('banner_subtitle') ?? 'العنوان الفرعي' ?> (العربية)</label>
                            <input type="text" name="subtitle" id="bannerSubtitle" class="form-control" dir="rtl">
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label"><?= lang('banner_description') ?? 'وصف البانر' ?> (العربية)</label>
                        <textarea name="description" id="bannerDescription" class="form-control" rows="2" dir="rtl"></textarea>
                    </div>

                    <!-- English Fields -->
                    <div class="lang-section-header" style="margin-top: 1.5rem;">
                        <span class="lang-badge">🇬🇧 English</span>
                        <span class="form-hint" style="margin-right: auto;">(اختياري / Optional)</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Banner Title (English)</label>
                            <input type="text" name="title_en" id="bannerTitleEn" class="form-control" dir="ltr" placeholder="Banner title in English">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Subtitle (English)</label>
                            <input type="text" name="subtitle_en" id="bannerSubtitleEn" class="form-control" dir="ltr" placeholder="Subtitle in English">
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label">Description (English)</label>
                        <textarea name="description_en" id="bannerDescriptionEn" class="form-control" rows="2" dir="ltr" placeholder="Description in English"></textarea>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;" class="mt-2">
                        <div class="form-group">
                            <label class="form-label">Button Text (English)</label>
                            <input type="text" name="button_text_en" id="bannerButtonTextEn" class="form-control" dir="ltr" placeholder="Button text in English">
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?= lang('banner_button') ?? 'نص الزر' ?> (العربية)</label>
                            <input type="text" name="button_text" id="bannerButtonText" class="form-control" dir="rtl">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;" class="mt-2">
                        <div class="form-group">
                            <label class="form-label"><?= lang('banner_link') ?? 'رابط البانر' ?></label>
                            <input type="text" name="link" id="bannerLink" class="form-control" placeholder="#contact">
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?= lang('position') ?? 'الموضع' ?></label>
                            <select name="position" id="bannerPosition" class="form-control">
                                <option value="hero">Hero (الرئيسي)</option>
                                <option value="top">Top (أعلى)</option>
                                <option value="sidebar">Sidebar (الشريط الجانبي)</option>
                                <option value="bottom">Bottom (أسفل)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <label class="form-label"><?= lang('banner_image') ?? 'صورة البانر' ?> <span id="imageRequired">*</span></label>
                        <input type="file" name="image" id="bannerImage" class="form-control" accept="image/*">
                        <span class="form-hint" id="imageHint">الحجم المقترح: 1920×600px</span>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-bs-dismiss="modal"><?= lang('cancel') ?? 'إلغاء' ?></button>
                    <button type="submit" class="btn btn-primary" id="bannerSubmitBtn">
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
    // Reset form to Add mode
    document.getElementById('bannerForm').reset();
    document.getElementById('bannerId').value = '';
    document.getElementById('bannerForm').action = '<?= url('/dashboard/banners') ?>';
    document.getElementById('bannerModalTitle').textContent = '<?= lang('add_banner') ?? 'إضافة بانر جديد' ?>';
    document.getElementById('bannerImage').required = true;
    document.getElementById('imageRequired').style.display = 'inline';
    document.getElementById('imageHint').textContent = 'الحجم المقترح: 1920×600px';
    document.getElementById('currentImagePreview').style.display = 'none';
}

function editBanner(id) {
    var btn = event.currentTarget;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    // Fetch banner data via AJAX
    $.ajax({
        url: '<?= url('/dashboard/banners/edit') ?>/' + id,
        method: 'GET',
        data: {
            <?= CSRF_TOKEN_NAME ?>: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success && response.data && response.data.banner) {
                var b = response.data.banner;

                // Switch to Edit mode
                document.getElementById('bannerId').value = b.id;
                document.getElementById('bannerForm').action = '<?= url('/dashboard/banners/edit') ?>/' + b.id;
                document.getElementById('bannerModalTitle').textContent = '<?= lang('edit_banner') ?? 'تعديل البانر' ?>';
                document.getElementById('bannerImage').required = false;
                document.getElementById('imageRequired').style.display = 'none';
                document.getElementById('imageHint').textContent = '<?= lang('leave_empty_keep') ?? 'اتركه فارغاً للإبقاء على الصورة الحالية' ?>';

                // Fill Arabic fields
                document.getElementById('bannerTitle').value = b.title || '';
                document.getElementById('bannerSubtitle').value = b.subtitle || '';
                document.getElementById('bannerDescription').value = b.description || '';
                document.getElementById('bannerButtonText').value = b.button_text || '';
                document.getElementById('bannerLink').value = b.link || '';
                document.getElementById('bannerPosition').value = b.position || 'hero';

                // Fill English fields
                document.getElementById('bannerTitleEn').value = b.title_en || '';
                document.getElementById('bannerSubtitleEn').value = b.subtitle_en || '';
                document.getElementById('bannerDescriptionEn').value = b.description_en || '';
                document.getElementById('bannerButtonTextEn').value = b.button_text_en || '';

                // Show current image
                if (b.image) {
                    document.getElementById('currentImage').src = '<?= url('/uploads') ?>/' + b.image;
                    document.getElementById('currentImagePreview').style.display = 'block';
                } else {
                    document.getElementById('currentImagePreview').style.display = 'none';
                }

                // Open modal
                var modal = new bootstrap.Modal(document.getElementById('bannerModal'));
                modal.show();
            } else {
                showToast('error', response.message || '<?= lang('error_loading_banner') ?? 'حدث خطأ أثناء تحميل بيانات البانر' ?>');
            }
        },
        error: function() {
            showToast('error', '<?= lang('error_loading_banner') ?? 'حدث خطأ أثناء تحميل بيانات البانر' ?>');
        },
        complete: function() {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-edit"></i>';
        }
    });
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
