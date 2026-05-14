<?php
/**
 * Blog Post Form View
 * نموذج إضافة/تعديل مقال
 */

$tenant = Auth::tenant();
$isEdit = !empty($post);
?>

<div class="page-header">
    <h1 class="h3 mb-0">
        <i class="fas fa-<?= $isEdit ? 'edit' : 'plus' ?> me-2"></i>
        <?= $isEdit ? lang('edit_post') : lang('add_post') ?>
    </h1>
</div>

<form method="POST" action="<?= $isEdit ? url('/dashboard/blog/edit/' . $post->id) : url('/dashboard/blog/add') ?>" 
      enctype="multipart/form-data" id="postForm">
    <?= $this->csrf() ?>
    
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Title -->
                    <div class="mb-4">
                        <label class="form-label fw-bold"><?= lang('post_title') ?> <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg" 
                               value="<?= $isEdit ? htmlspecialchars($post->title) : '' ?>" 
                               placeholder="<?= lang('post_title_placeholder') ?>" required
                               oninput="generateSlug(this.value)">
                    </div>
                    
                    <!-- Slug -->
                    <div class="mb-4">
                        <label class="form-label"><?= lang('post_slug') ?></label>
                        <div class="input-group">
                            <span class="input-group-text"><?= url('/' . $tenant->slug . '/blog/') ?></span>
                            <input type="text" name="slug" class="form-control" id="postSlug"
                                   value="<?= $isEdit ? htmlspecialchars($post->slug) : '' ?>"
                                   placeholder="post-url-slug">
                        </div>
                        <small class="text-muted"><?= lang('slug_hint') ?></small>
                    </div>
                    
                    <!-- Excerpt -->
                    <div class="mb-4">
                        <label class="form-label fw-bold"><?= lang('post_excerpt') ?></label>
                        <textarea name="excerpt" class="form-control" rows="2" 
                                  placeholder="<?= lang('excerpt_placeholder') ?>"><?= $isEdit ? htmlspecialchars($post->excerpt ?? '') : '' ?></textarea>
                        <small class="text-muted"><?= lang('excerpt_hint') ?></small>
                    </div>
                    
                    <!-- Content -->
                    <div class="mb-4">
                        <label class="form-label fw-bold"><?= lang('post_content') ?> <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control" id="postContent" rows="15" 
                                  placeholder="<?= lang('content_placeholder') ?>" required><?= $isEdit ? htmlspecialchars($post->content ?? '') : '' ?></textarea>
                    </div>
                    
                    <!-- Tags -->
                    <div class="mb-4">
                        <label class="form-label"><?= lang('post_tags') ?></label>
                        <input type="text" name="tags" class="form-control" id="postTags"
                               value="<?= $isEdit ? implode(', ', json_decode($post->tags ?? '[]', true) ?: []) : '' ?>"
                               placeholder="<?= lang('tags_placeholder') ?>">
                        <small class="text-muted"><?= lang('tags_hint') ?></small>
                    </div>
                </div>
            </div>
            
            <!-- SEO Settings -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-search me-2"></i>
                        <?= lang('seo_settings') ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label"><?= lang('meta_title') ?></label>
                        <input type="text" name="meta_title" class="form-control"
                               value="<?= $isEdit ? htmlspecialchars($post->meta_title ?? '') : '' ?>"
                               placeholder="<?= lang('meta_title_placeholder') ?>">
                        <small class="text-muted"><?= lang('meta_title_hint') ?></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?= lang('meta_description') ?></label>
                        <textarea name="meta_description" class="form-control" rows="2" 
                                  placeholder="<?= lang('meta_description_placeholder') ?>"><?= $isEdit ? htmlspecialchars($post->meta_description ?? '') : '' ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Publish Box -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-paper-plane me-2"></i>
                        <?= lang('publish') ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold"><?= lang('status') ?></label>
                        <select name="status" class="form-select" id="postStatus">
                            <option value="draft" <?= ($isEdit && $post->status === 'draft') ? 'selected' : '' ?>>
                                <?= lang('draft') ?>
                            </option>
                            <option value="published" <?= ($isEdit && $post->status === 'published') ? 'selected' : '' ?>>
                                <?= lang('published') ?>
                            </option>
                            <option value="scheduled" <?= ($isEdit && $post->status === 'scheduled') ? 'selected' : '' ?>>
                                <?= lang('scheduled') ?>
                            </option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="publishDateField" style="display: none;">
                        <label class="form-label"><?= lang('publish_date') ?></label>
                        <input type="datetime-local" name="published_at" class="form-control"
                               value="<?= $isEdit && $post->published_at ? date('Y-m-d\TH:i', strtotime($post->published_at)) : '' ?>">
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="show_on_home" id="showOnHome" value="1"
                               <?= ($isEdit && $post->show_on_home) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="showOnHome">
                            <?= lang('show_on_home') ?>
                        </label>
                    </div>
                    
                    <hr>
                    
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-save me-2"></i>
                        <?= lang('save') ?>
                    </button>
                    
                    <?php if ($isEdit): ?>
                        <a href="<?= url('/dashboard/blog') ?>" class="btn btn-outline-secondary w-100">
                            <?= lang('cancel') ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Featured Image -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-image me-2"></i>
                        <?= lang('featured_image') ?>
                    </h5>
                </div>
                <div class="card-body">
                    <?php if ($isEdit && $post->featured_image): ?>
                        <div class="mb-3" id="currentImage">
                            <img src="<?= upload($post->featured_image) ?>" 
                                 alt="Featured" class="img-fluid rounded mb-2">
                            <button type="button" class="btn btn-outline-danger btn-sm w-100" 
                                    onclick="removeImage()">
                                <i class="fas fa-trash me-1"></i> <?= lang('remove') ?>
                            </button>
                        </div>
                    <?php endif; ?>
                    
                    <div class="upload-zone" id="imageUpload">
                        <input type="file" name="featured_image" id="featuredImage" 
                               class="d-none" accept="image/*">
                        <label for="featuredImage" class="w-100 text-center d-block py-4">
                            <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                            <p class="mb-0"><?= lang('click_to_upload') ?></p>
                            <small class="text-muted">JPG, PNG, WebP</small>
                        </label>
                    </div>
                    
                    <div id="imagePreview" class="mt-3" style="display: none;">
                        <img src="" alt="Preview" class="img-fluid rounded" id="previewImg">
                    </div>
                </div>
            </div>
            
            <!-- Category -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-folder me-2"></i>
                        <?= lang('post_category') ?>
                    </h5>
                </div>
                <div class="card-body">
                    <select name="category" class="form-select">
                        <option value=""><?= lang('select_category') ?></option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category ?>" <?= ($isEdit && $post->category === $category) ? 'selected' : '' ?>>
                                <?= $category ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <div class="mt-3">
                        <input type="text" class="form-control form-control-sm" id="newCategory" 
                               placeholder="<?= lang('add_new_category') ?>">
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2 w-100"
                                onclick="addCategory()">
                            <i class="fas fa-plus me-1"></i> <?= lang('add') ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
.upload-zone {
    border: 2px dashed var(--border);
    border-radius: 0.5rem;
    cursor: pointer;
    transition: border-color 0.3s;
}

.upload-zone:hover {
    border-color: var(--primary);
}
</style>

<script>
// Generate slug from title
function generateSlug(title) {
    const slug = title.toLowerCase()
        .replace(/[^\w\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim();
    document.getElementById('postSlug').value = slug;
}

// Handle status change
document.getElementById('postStatus').addEventListener('change', function() {
    document.getElementById('publishDateField').style.display = 
        this.value === 'scheduled' ? 'block' : 'none';
});

// Initialize
if (document.getElementById('postStatus').value === 'scheduled') {
    document.getElementById('publishDateField').style.display = 'block';
}

// Image preview
document.getElementById('featuredImage').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});

// Remove image
function removeImage() {
    document.getElementById('currentImage').style.display = 'none';
}

// Add category
function addCategory() {
    const newCat = document.getElementById('newCategory').value.trim();
    if (newCat) {
        const select = document.querySelector('select[name="category"]');
        const option = document.createElement('option');
        option.value = newCat;
        option.textContent = newCat;
        option.selected = true;
        select.appendChild(option);
        document.getElementById('newCategory').value = '';
    }
}

// Tags input
document.getElementById('postTags').addEventListener('input', function(e) {
    // Simple tags handling
});
</script>
