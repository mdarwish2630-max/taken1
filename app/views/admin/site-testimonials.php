<?php
/**
 * Admin - Site Testimonials View
 * شهادات الموقع الرئيسي
 */

?>

<div class="page-header">
    <h1 class="page-title"><?= lang('site_testimonials') ?? 'شهادات الموقع' ?></h1>
</div>

<?php if (Session::has('success')): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <?= Session::getSuccess() ?>
</div>
<?php endif; ?>

<!-- Add Testimonial Form -->
<div class="card mb-3">
    <div class="card-header">
        <h3 class="card-title"><?= lang('add_testimonial') ?? 'إضافة شهادة جديدة' ?></h3>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= url('/admin/site-testimonials') ?>" enctype="multipart/form-data">
            <?= $this->csrf() ?>
            
            <div class="d-flex gap-2">
                <div class="form-group" style="flex: 1;">
                    <label class="form-label"><?= lang('client_name') ?? 'اسم العميل' ?> *</label>
                    <input type="text" name="client_name" class="form-control" required>
                </div>
                
                <div class="form-group" style="flex: 1;">
                    <label class="form-label"><?= lang('company') ?? 'الشركة' ?></label>
                    <input type="text" name="client_company" class="form-control">
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <div class="form-group" style="flex: 1;">
                    <label class="form-label"><?= lang('client_title') ?? 'المنصب' ?></label>
                    <input type="text" name="client_title" class="form-control">
                </div>
                
                <div class="form-group" style="width: 120px;">
                    <label class="form-label"><?= lang('rating') ?? 'التقييم' ?></label>
                    <select name="rating" class="form-control">
                        <option value="5">★★★★★</option>
                        <option value="4">★★★★</option>
                        <option value="3">★★★</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label"><?= lang('content') ?? 'محتوى الشهادة' ?> *</label>
                <textarea name="content" class="form-control" rows="3" required></textarea>
            </div>
            
            <div class="d-flex gap-2">
                <div class="form-group" style="flex: 1;">
                    <label class="form-label"><?= lang('client_image') ?? 'صورة العميل' ?></label>
                    <input type="file" name="client_image" class="form-control" accept="image/*">
                </div>
                
                <div class="form-group" style="display: flex; align-items: flex-end;">
                    <label class="checkbox-label">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span><?= lang('is_active') ?? 'نشط' ?></span>
                    </label>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <?= lang('add_testimonial') ?? 'إضافة شهادة' ?>
            </button>
        </form>
    </div>
</div>

<!-- Testimonials List -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= lang('current_testimonials') ?? 'الشهادات الحالية' ?></h3>
    </div>
    <div class="card-body">
    <?php if (empty($testimonials)): ?>
    <p style="color: #64748b; text-align: center; padding: 2rem;">
            <?= lang('no_testimonials') ?? 'لا توجد شهادات. أضف شهادة جديدة.' ?>
        </p>
    <?php else: ?>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th><?= lang('client') ?? 'العميل' ?></th>
                        <th><?= lang('content') ?? 'المحتوى' ?></th>
                        <th><?= lang('rating') ?? 'التقييم' ?></th>
                        <th><?= lang('status') ?? 'الحالة' ?></th>
                        <th><?= lang('actions') ?? 'الإجراءات' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($testimonials as $testimonial): ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <?php if ($testimonial->client_image): ?>
                                <img src="<?= upload($testimonial->client_image) ?>" 
                                     style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                <?php endif; ?>
                                <div>
                                    <strong><?= htmlspecialchars($testimonial->client_name) ?></strong>
                                    <?php if ($testimonial->client_company): ?>
                                    <div style="font-size: 0.75rem; color: #64748b;">
                                        <?= htmlspecialchars($testimonial->client_company) ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis;">
                            <?= mb_strlen($testimonial->content) > 100 
                                ? mb_substr(htmlspecialchars($testimonial->content), 0, 100) . '...'
                                : htmlspecialchars($testimonial->content) ?>
                        </td>
                        <td>
                            <span style="color: #f59e0b;">
                                <?php for ($i = 0; $i < $testimonial->rating; $i++): ?>
                                    <i class="fas fa-star"></i>
                                <?php endfor; ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge <?= $testimonial->is_active ? 'badge-success' : 'badge-secondary' ?>">
                                <?= $testimonial->is_active ? (lang('active') ?? 'نشط') : (lang('inactive') ?? 'غير نشط') ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST" 
                                  action="<?= url('/admin/site-testimonials/delete/' . $testimonial->id) ?>"
                                  onsubmit="return confirm('<?= lang('confirm_delete') ?? 'هل أنت متأكد؟' ?>');">
                                <?= $this->csrf() ?>
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
