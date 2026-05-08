<?php
/**
 * Gallery View
 * صفحة المعرض
 */

?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= lang('gallery') ?></h3>
    </div>
    <div class="card-body">
        <!-- Upload Form -->
        <form method="POST" action="<?= url('/dashboard/gallery') ?>" enctype="multipart/form-data" id="uploadForm">
            <?= $this->csrf() ?>
            
            <div class="upload-zone" id="dropZone" onclick="document.getElementById('fileInput').click()">
                <i class="fas fa-cloud-upload-alt"></i>
                <p><?= lang('upload_images') ?></p>
                <input type="file" name="images[]" id="fileInput" multiple accept="image/*" style="display: none;">
            </div>
            
            <div class="d-flex gap-3" style="flex-wrap: wrap;">
                <div class="form-group mt-3" style="flex: 1; min-width: 200px;">
                    <label class="form-label"><?= lang('image_category') ?> (العربية)</label>
                    <input type="text" name="category" class="form-control" dir="rtl" placeholder="<?= lang('image_category') ?>">
                </div>
            </div>
        </form>
        
        <?php if (!empty($gallery)): ?>
        <div class="gallery-grid mt-4">
            <?php foreach ($gallery as $image): ?>
            <div class="gallery-item-wrapper">
                <div class="gallery-item">
                    <img src="<?= upload($image->image) ?>" alt="<?= $image->title ?>">
                    <div class="gallery-overlay">
                        <div class="gallery-overlay-text">
                            <span class="gallery-title-ar"><?= $image->title ?></span>
                            <?php if ($image->title_en): ?>
                            <span class="gallery-title-en"><?= $image->title_en ?></span>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm gallery-delete-btn"
                                data-delete="<?= url('/dashboard/gallery/delete/' . $image->id) ?>"
                                data-confirm="<?= lang('confirm_delete') ?>">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <!-- Inline edit titles -->
                <div class="gallery-edit-fields" style="display: none; padding: 0.5rem; background: var(--light, #f8fafc); border-radius: 0 0 8px 8px;">
                    <input type="text" name="title_<?= $image->id ?>" value="<?= $this->e($image->title ?? '') ?>" 
                           class="form-control form-control-sm mb-1" dir="rtl" placeholder="عنوان بالعربي"
                           onchange="updateGalleryTitle(<?= $image->id ?>, 'title', this.value)">
                    <input type="text" name="title_en_<?= $image->id ?>" value="<?= $this->e($image->title_en ?? '') ?>" 
                           class="form-control form-control-sm mb-1" dir="ltr" placeholder="Title in English"
                           onchange="updateGalleryTitle(<?= $image->id ?>, 'title_en', this.value)">
                    <button type="button" class="btn btn-primary btn-sm btn-block" onclick="saveGalleryTitles(<?= $image->id ?>)">
                        <i class="fas fa-save"></i> حفظ
                    </button>
                </div>
                <button type="button" class="btn btn-outline btn-sm btn-block gallery-edit-btn"
                        onclick="this.previousElementSibling.style.display = 'block'; this.style.display = 'none';">
                    <i class="fas fa-edit"></i> تعديل العنوان
                </button>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center mt-4" style="padding: 3rem; color: var(--secondary);">
            <i class="fas fa-images" style="font-size: 3rem; margin-bottom: 1rem;"></i>
            <p><?= lang('no_images') ?></p>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem; }
.gallery-item { position: relative; aspect-ratio: 1; border-radius: 8px; overflow: hidden; }
.gallery-item img { width: 100%; height: 100%; object-fit: cover; }
.gallery-overlay { 
    position: absolute; inset: 0; background: rgba(0,0,0,0.6); display: flex; flex-direction: column; 
    align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s; gap: 0.5rem; padding: 0.5rem; 
}
.gallery-item:hover .gallery-overlay { opacity: 1; }
.gallery-overlay-text { text-align: center; color: #fff; }
.gallery-title-ar { font-size: 0.85rem; font-weight: 600; display: block; }
.gallery-title-en { font-size: 0.75rem; opacity: 0.8; display: block; }
.gallery-delete-btn { 
    position: absolute; top: 6px; right: 6px; width: 28px; height: 28px; padding: 0; 
    display: flex; align-items: center; justify-content: center; font-size: 0.75rem;
}
.gallery-edit-btn { margin-top: 0.25rem; font-size: 0.75rem; }
.gallery-item-wrapper .gallery-edit-fields input { font-size: 0.8rem; }
</style>

<script>
document.getElementById('fileInput').addEventListener('change', function() {
    document.getElementById('uploadForm').submit();
});

function updateGalleryTitle(imageId, field, value) {
    // Will be saved when save button is clicked
}

function saveGalleryTitles(imageId) {
    const title = document.querySelector(`input[name="title_${imageId}"]`).value;
    const titleEn = document.querySelector(`input[name="title_en_${imageId}"]`).value;
    
    const formData = new FormData();
    formData.append('csrf_token', '<?= Security::csrfToken() ?>');
    formData.append('title', title);
    formData.append('title_en', titleEn);
    
    fetch('<?= url("/dashboard/gallery/edit") ?>/' + imageId, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('تم حفظ العناوين بنجاح');
            location.reload();
        } else {
            alert('حدث خطأ: ' + (data.message || ''));
        }
    })
    .catch(() => alert('حدث خطأ في الاتصال'));
}
</script>
