<?php
/**
 * Admin - Platform Blog Form
 * نموذج إضافة/تعديل مقال في مدونة المنصة
 */

$dir = Language::direction();
$post = $post ?? null;
$isEdit = !empty($post);
?>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-<?= $isEdit ? 'edit' : 'plus' ?>"></i>
        <?= $isEdit ? 'تعديل المقال' : 'إضافة مقال جديد' ?>
    </h1>
    <a href="<?= url('/admin/blog') ?>" class="btn btn-outline">
        <i class="fas fa-arrow-<?= $dir === 'rtl' ? 'right' : 'left' ?>"></i>
        العودة للقائمة
    </a>
</div>

<form method="POST" action="<?= $isEdit ? url('/admin/blog/edit/' . $post->id) : url('/admin/blog/create') ?>" enctype="multipart/form-data">
    <?= $this->csrf() ?>

    <div style="display:flex;gap:20px;flex-wrap:wrap;">
        <!-- Main Content -->
        <div style="flex:2;min-width:400px;">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-file-alt"></i> المحتوى</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">عنوان المقال *</label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($post->title ?? '') ?>" required placeholder="أدخل عنوان المقال">
                    </div>

                    <div class="form-group">
                        <label class="form-label">الرابط (Slug)</label>
                        <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($post->slug ?? '') ?>" placeholder="يتم إنشاؤه تلقائياً">
                        <span class="form-hint">يتم إنشاؤه تلقائياً من العنوان إذا تركته فارغاً</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">التصنيف</label>
                        <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($post->category ?? '') ?>" placeholder="مثال: تقنية، تصميم، تسويق">
                    </div>

                    <div class="form-group">
                        <label class="form-label">الملخص</label>
                        <textarea name="excerpt" class="form-control" rows="3" placeholder="ملخص مختصر للمقال"><?= htmlspecialchars($post->excerpt ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">المحتوى *</label>
                        <textarea name="content" class="form-control" rows="12" required placeholder="اكتب محتوى المقال هنا (يدعم HTML)"><?= htmlspecialchars($post->content ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div style="flex:1;min-width:280px;">
            <!-- Image -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-image"></i> الصورة البارزة</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <input type="file" name="featured_image" accept="image/*" class="form-control">
                        <?php if (!empty($post->featured_image)): ?>
                        <img src="<?= htmlspecialchars($post->featured_image) ?>" alt="" style="width:100%;max-height:200px;object-fit:cover;border-radius:8px;margin-top:8px;">
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- SEO -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-search"></i> SEO</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">عنوان SEO</label>
                        <input type="text" name="meta_title" class="form-control" value="<?= htmlspecialchars($post->meta_title ?? '') ?>" placeholder="عنوان محركات البحث">
                    </div>
                    <div class="form-group">
                        <label class="form-label">وصف SEO</label>
                        <textarea name="meta_description" class="form-control" rows="3" placeholder="وصف قصير لمحركات البحث"><?= htmlspecialchars($post->meta_description ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Settings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-cog"></i> الإعدادات</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">الوسوم (Tag)</label>
                        <input type="text" name="tags" class="form-control" value="<?= htmlspecialchars($post->tags ?? '') ?>" placeholder="وسوم1، وسوم2">
                    </div>
                    <div class="form-group">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-control">
                            <option value="draft" <?= ($post->status ?? 'draft') === 'draft' ? 'selected' : '' ?>>مسودة</option>
                            <option value="published" <?= ($post->status ?? 'draft') === 'published' ? 'selected' : '' ?>>منشور</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-top:20px;">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            <?= $isEdit ? 'حفظ التعديلات' : 'نشر المقال' ?>
        </button>
        <a href="<?= url('/admin/blog') ?>" class="btn btn-outline">
            إلغاء
        </a>
    </div>
</form>

<style>
.form-group { margin-bottom: 1rem; }
.form-label { display: block; margin-bottom: 0.4rem; font-weight: 600; font-size: 0.9rem; color: var(--dark); }
.form-control {
    width: 100%; padding: 0.6rem 0.85rem; border: 1px solid var(--border, #e2e8f0);
    border-radius: 0.5rem; font-size: 0.9rem; font-family: var(--font);
    transition: border-color 0.2s;
}
.form-control:focus { border-color: var(--primary, #6366f1); outline: none; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
.form-hint { font-size: 0.78rem; color: #64748b; margin-top: 0.25rem; }
textarea.form-control { resize: vertical; }
</style>
