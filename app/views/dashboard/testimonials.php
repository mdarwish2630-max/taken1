<?php
/**
 * Testimonials View
 * صفحة آراء العملاء
 */
?>

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="page-title">
            <i class="fas fa-quote-right"></i>
            <?= lang('testimonials') ?? 'آراء العملاء' ?>
        </h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#testimonialModal" onclick="openTestimonialModal()">
            <i class="fas fa-plus"></i>
            <?= lang('add') ?? 'إضافة' ?>
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
        <?php if (empty($testimonials)): ?>
        <div style="text-align: center; padding: 3rem; color: var(--secondary);">
            <i class="fas fa-quote-right" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.3; display: block;"></i>
            <h5><?= lang('no_testimonials') ?? 'لا توجد آراء بعد' ?></h5>
            <p style="margin-top: 0.5rem;"><?= lang('add_first_testimonial') ?? 'أضف أول رأي لعرضه في موقعك' ?></p>
            <button type="button" class="btn btn-primary" style="margin-top: 1rem;" data-bs-toggle="modal" data-bs-target="#testimonialModal" onclick="openTestimonialModal()">
                <i class="fas fa-plus"></i>
                <?= lang('add') ?? 'إضافة' ?>
            </button>
        </div>
        <?php else: ?>
        <div class="testimonials-list">
            <?php foreach ($testimonials as $testimonial): ?>
            <div class="testimonial-item" id="testimonial-row-<?= $testimonial->id ?>" style="display: flex; gap: 1rem; padding: 1rem; background: var(--light); border-radius: 8px; margin-bottom: 1rem; align-items: start;">
                <div class="testimonial-avatar" style="width: 60px; height: 60px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 600; font-size: 1.25rem; flex-shrink: 0;">
                    <?php if ($testimonial->client_image): ?>
                    <img src="<?= upload($testimonial->client_image) ?>" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                    <?php else: ?>
                    <?= mb_substr($testimonial->client_name, 0, 1) ?>
                    <?php endif; ?>
                </div>
                
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <strong><?= htmlspecialchars($testimonial->client_name) ?></strong>
                            <?php if ($testimonial->client_title): ?>
                            <br><small style="color: var(--secondary);"><?= htmlspecialchars($testimonial->client_title) ?></small>
                            <?php endif; ?>
                            <?php if ($testimonial->client_title_en): ?>
                            <br><small style="color: var(--secondary);"><?= htmlspecialchars($testimonial->client_title_en) ?></small>
                            <?php endif; ?>
                        </div>
                        <div style="color: var(--accent);">
                            <?php for($i = 0; $i < $testimonial->rating; $i++) echo '⭐'; ?>
                        </div>
                    </div>
                    <p style="margin-top: 0.5rem; color: #666;"><?= htmlspecialchars($testimonial->content) ?></p>
                    <?php if ($testimonial->content_en): ?>
                    <p style="margin-top: 0.25rem; color: #999; font-style: italic; font-size: 0.9rem;">EN: <?= htmlspecialchars($testimonial->content_en) ?></p>
                    <?php endif; ?>
                </div>
                
                <div style="display: flex; gap: 0.4rem;">
                    <button type="button" class="btn btn-sm btn-warning" 
                            onclick="editTestimonial(<?= $testimonial->id ?>)"
                            title="<?= lang('edit') ?? 'تعديل' ?>">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" 
                            data-delete="<?= url('/dashboard/testimonials/delete/' . $testimonial->id) ?>"
                            data-confirm="<?= lang('confirm_delete') ?? 'هل أنت متأكد من حذف هذا الرأي؟' ?>">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Testimonial Modal (Add / Edit) -->
<div class="modal fade" id="testimonialModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testimonialModalTitle"><?= lang('add_testimonial') ?? 'إضافة رأي جديد' ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="testimonialForm" method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="testimonial_id" id="testimonialId" value="">
                <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
                
                <div class="modal-body">
                    <!-- Current image preview (edit mode only) -->
                    <div id="currentClientImagePreview" style="display: none; margin-bottom: 1rem; text-align: center;">
                        <label class="form-label"><?= lang('current_image') ?? 'الصورة الحالية' ?></label>
                        <div style="display: inline-block;">
                            <img id="currentClientImage" src="" alt="" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid var(--border, #e2e8f0);">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><?= lang('client_name') ?> *</label>
                        <input type="text" name="client_name" id="clientName" class="form-control" required>
                    </div>

                    <!-- Arabic Fields -->
                    <div class="lang-section-header">
                        <span class="lang-badge">🇸🇦 العربية</span>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label"><?= lang('client_title') ?> (العربية)</label>
                            <input type="text" name="client_title" id="clientTitle" class="form-control" dir="rtl" placeholder="مثال: مدير شركة ABC">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label"><?= lang('rating') ?></label>
                            <select name="rating" id="clientRating" class="form-control">
                                <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                                <option value="4">⭐⭐⭐⭐ (4)</option>
                                <option value="3">⭐⭐⭐ (3)</option>
                                <option value="2">⭐⭐ (2)</option>
                                <option value="1">⭐ (1)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label"><?= lang('testimonial_content') ?> (العربية) *</label>
                        <textarea name="content" id="testimonialContent" class="form-control" rows="3" dir="rtl" required></textarea>
                    </div>

                    <!-- English Fields -->
                    <div class="lang-section-header" style="margin-top: 1.5rem;">
                        <span class="lang-badge">🇬🇧 English</span>
                        <span class="form-hint" style="margin-right: auto;">(اختياري / Optional)</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Client Title (English)</label>
                        <input type="text" name="client_title_en" id="clientTitleEn" class="form-control" dir="ltr" placeholder="e.g. CEO at ABC Company">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Testimonial Content (English)</label>
                        <textarea name="content_en" id="testimonialContentEn" class="form-control" rows="3" dir="ltr" placeholder="Client testimonial in English"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label"><?= lang('client_image') ?></label>
                        <input type="file" name="client_image" id="clientImage" class="form-control" accept="image/*">
                        <span class="form-hint" id="imageHint"><?= lang('optional_image') ?? 'صورة العميل (اختياري)' ?></span>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-group">
                            <input type="checkbox" name="show_on_home" id="showOnHome" value="1" checked>
                            <span><?= lang('show_on_home') ?? 'عرض في الصفحة الرئيسية' ?></span>
                        </label>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-bs-dismiss="modal"><?= lang('cancel') ?? 'إلغاء' ?></button>
                    <button type="submit" class="btn btn-primary" id="testimonialSubmitBtn">
                        <i class="fas fa-save"></i>
                        <?= lang('save') ?? 'حفظ' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openTestimonialModal() {
    // Reset form to Add mode
    document.getElementById('testimonialForm').reset();
    document.getElementById('testimonialId').value = '';
    document.getElementById('testimonialForm').action = '<?= url('/dashboard/testimonials') ?>';
    document.getElementById('testimonialModalTitle').textContent = '<?= lang('add_testimonial') ?? 'إضافة رأي جديد' ?>';
    document.getElementById('showOnHome').checked = true;
    document.getElementById('currentClientImagePreview').style.display = 'none';
    document.getElementById('imageHint').textContent = '<?= lang('optional_image') ?? 'صورة العميل (اختياري)' ?>';
}

function editTestimonial(id) {
    var btn = event.currentTarget;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    // Fetch testimonial data via AJAX
    $.ajax({
        url: '<?= url('/dashboard/testimonials/edit') ?>/' + id,
        method: 'GET',
        data: {
            <?= CSRF_TOKEN_NAME ?>: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success && response.data && response.data.testimonial) {
                var t = response.data.testimonial;

                // Switch to Edit mode
                document.getElementById('testimonialId').value = t.id;
                document.getElementById('testimonialForm').action = '<?= url('/dashboard/testimonials/edit') ?>/' + t.id;
                document.getElementById('testimonialModalTitle').textContent = '<?= lang('edit_testimonial') ?? 'تعديل الرأي' ?>';

                // Fill fields
                document.getElementById('clientName').value = t.client_name || '';
                document.getElementById('clientTitle').value = t.client_title || '';
                document.getElementById('clientRating').value = t.rating || 5;
                document.getElementById('testimonialContent').value = t.content || '';
                document.getElementById('clientTitleEn').value = t.client_title_en || '';
                document.getElementById('testimonialContentEn').value = t.content_en || '';
                document.getElementById('showOnHome').checked = t.show_on_home == 1;

                // Show current image
                if (t.client_image) {
                    document.getElementById('currentClientImage').src = '<?= url('/uploads') ?>/' + t.client_image;
                    document.getElementById('currentClientImagePreview').style.display = 'block';
                    document.getElementById('imageHint').textContent = '<?= lang('leave_empty_keep') ?? 'اتركه فارغاً للإبقاء على الصورة الحالية' ?>';
                } else {
                    document.getElementById('currentClientImagePreview').style.display = 'none';
                    document.getElementById('imageHint').textContent = '<?= lang('optional_image') ?? 'صورة العميل (اختياري)' ?>';
                }

                // Open modal
                var modal = new bootstrap.Modal(document.getElementById('testimonialModal'));
                modal.show();
            } else {
                showToast('error', response.message || 'حدث خطأ أثناء تحميل بيانات الرأي');
            }
        },
        error: function() {
            showToast('error', 'حدث خطأ أثناء تحميل بيانات الرأي');
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
