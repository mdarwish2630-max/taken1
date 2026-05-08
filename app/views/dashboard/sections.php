<?php
/**
 * Sections Management View
 * صفحة إدارة أقسام الموقع - تفعيل/تعطيل/ترتيب
 */
$sections = $sections ?? [];
$tenant = $tenant ?? null;
$lang = Language::current();
$dir = Language::direction();
$isRtl = $dir === 'rtl';
?>

<div class="card">
    <div class="card-header" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 class="card-title" style="display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-layer-group" style="color: var(--primary, #4f46e5);"></i>
                <?= lang('sections_management') ?>
            </h3>
            <p class="text-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">
                <?= lang('sections_desc') ?>
            </p>
        </div>
        <a href="<?= url('/dashboard') ?>" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-<?= $isRtl ? 'right' : 'left' ?>"></i>
            <?= lang('back') ?>
        </a>
    </div>
    <div class="card-body">

        <!-- Section Controls Info -->
        <div style="background: var(--bg-alt, #f8fafc); border: 1px solid var(--border, #e2e8f0); border-radius: 12px; padding: 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--primary, #4f46e5);">
                <i class="fas fa-info-circle"></i>
                <strong style="font-size: 0.9rem;"><?= lang('sections_info') ?></strong>
            </div>
            <p style="font-size: 0.83rem; color: var(--text-secondary, #64748b); flex: 1; min-width: 200px;">
                <?= $isRtl ? 'يمكنك التحكم في عرض الأقسام في موقعك. القسم المفعل سيظهر للزوار، والمعطل سيكون مخفياً. اسحب الأقسام لإعادة ترتيبها.' 
                       : 'You can control which sections appear on your website. Enabled sections will be visible to visitors. Drag sections to reorder them.' ?>
            </p>
        </div>

        <form id="sectionsForm" method="POST" action="<?= url('/dashboard/sections/save') ?>">
            <?= $this->csrf() ?>

            <!-- Sections List -->
            <div id="sectionsList" style="display: flex; flex-direction: column; gap: 0.75rem;">
                <?php foreach ($sections as $index => $section): ?>
                <div class="section-control-item" 
                     data-section-key="<?= $section->section_key ?>"
                     style="display: flex; align-items: center; gap: 1rem; padding: 1rem 1.25rem; 
                            background: #fff; border: 2px solid var(--border, #e2e8f0); border-radius: 12px;
                            transition: all 0.3s ease; cursor: grab; position: relative;"
                     onmouseenter="this.style.borderColor='var(--primary, #4f46e5)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.06)'"
                     onmouseleave="this.style.borderColor='var(--border, #e2e8f0)'; this.style.boxShadow='none'">
                    
                    <!-- Drag Handle -->
                    <div style="color: var(--text-light, #94a3b8); font-size: 1.1rem; cursor: grab; padding: 0.25rem;">
                        <i class="fas fa-grip-vertical"></i>
                    </div>

                    <!-- Section Number -->
                    <div style="width: 36px; height: 36px; min-width: 36px; border-radius: 10px; 
                                background: <?= $section->is_enabled ? 'var(--primary, #4f46e5)' : 'var(--bg-alt, #f1f5f9)' ?>;
                                color: #fff; display: flex; align-items: center; justify-content: center;
                                font-weight: 700; font-size: 0.9rem; transition: background 0.3s ease;">
                        <?= $index + 1 ?>
                    </div>

                    <!-- Section Icon -->
                    <div style="width: 44px; height: 44px; min-width: 44px; border-radius: 12px;
                                background: var(--bg-alt, #f8fafc); display: flex; align-items: center; justify-content: center;
                                font-size: 1.15rem; color: var(--primary, #4f46e5); transition: all 0.3s ease;">
                        <i class="<?= $section->section_icon ?? 'fas fa-puzzle-piece' ?>"></i>
                    </div>

                    <!-- Section Info -->
                    <div style="flex: 1; min-width: 150px;">
                        <div style="font-weight: 600; font-size: 0.95rem; color: var(--text, #1e293b);">
                            <?= $isRtl ? $section->section_label_ar : $section->section_label_en ?>
                        </div>
                        <div style="font-size: 0.8rem; color: var(--text-light, #94a3b8); margin-top: 0.15rem;">
                            <code style="background: var(--bg-alt, #f1f5f9); padding: 0.1rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">
                                <?= $section->section_key ?>
                            </code>
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="sections[<?= $index ?>][section_key]" value="<?= $section->section_key ?>">
                    <input type="hidden" name="sections[<?= $index ?>][display_order]" value="<?= $section->display_order ?>" class="section-order">

                    <!-- Toggle Switch -->
                    <label class="toggle-switch" style="position: relative; display: inline-block; width: 52px; height: 28px; flex-shrink: 0;">
                        <input type="checkbox" name="sections[<?= $index ?>][is_enabled]" value="1" 
                               <?= $section->is_enabled ? 'checked' : '' ?>
                               onchange="updateSectionVisual(this)"
                               style="opacity: 0; width: 0; height: 0;">
                        <span style="position: absolute; cursor: pointer; inset: 0; 
                                    background: <?= $section->is_enabled ? 'var(--primary, #4f46e5)' : '#cbd5e1' ?>;
                                    border-radius: 28px; transition: all 0.3s ease;">
                            <span class="toggle-dot" style="position: absolute; content: ''; height: 22px; width: 22px; 
                                    <?= $isRtl ? 'right' : 'left' ?>: 3px; bottom: 3px; background: #fff;
                                    border-radius: 50%; transition: all 0.3s ease;
                                    <?= $section->is_enabled ? ($isRtl ? 'right: 27px; left: auto' : 'left: 27px') : '' ?>;
                                    box-shadow: 0 2px 6px rgba(0,0,0,0.15);"></span>
                        </span>
                    </label>

                    <!-- Status Text -->
                    <div class="section-status-text" style="font-size: 0.8rem; font-weight: 600; min-width: 65px; text-align: center;
                                padding: 0.3rem 0.75rem; border-radius: 20px;
                                background: <?= $section->is_enabled ? 'rgba(16,185,129,0.1)' : 'rgba(100,116,139,0.1)' ?>;
                                color: <?= $section->is_enabled ? '#059669' : '#64748b' ?>;">
                        <?= $section->is_enabled ? ($isRtl ? 'مفعّل' : 'Active') : ($isRtl ? 'معطّل' : 'Disabled') ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Save Button -->
            <div style="margin-top: 1.75rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                <p style="font-size: 0.82rem; color: var(--text-light, #94a3b8);">
                    <i class="fas fa-lightbulb" style="color: var(--accent, #f59e0b);"></i>
                    <?= $isRtl ? 'تغييراتك ستظهر مباشرة في الموقع بعد الحفظ' : 'Changes will appear on your website after saving' ?>
                </p>
                <button type="submit" class="btn btn-primary" style="padding: 0.65rem 2rem; font-size: 0.95rem;">
                    <i class="fas fa-save"></i>
                    <?= lang('save_changes') ?>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.toggle-switch input:checked + span {
    background: var(--primary, #4f46e5) !important;
}
.toggle-switch input:checked + span .toggle-dot {
    <?= $isRtl ? 'right: 27px !important; left: auto !important;' : 'left: 27px !important;' ?>
}
.section-control-item[draggable="true"]:active {
    cursor: grabbing;
    opacity: 0.8;
}
</style>

<script>
// Toggle visual update
function updateSectionVisual(checkbox) {
    const item = checkbox.closest('.section-control-item');
    const dot = item.querySelector('.toggle-dot');
    const statusText = item.querySelector('.section-status-text');
    const numberBadge = item.querySelector('div[style*="border-radius: 10px"]');
    const isRtl = '<?= $dir ?>' === 'rtl';
    
    if (checkbox.checked) {
        dot.style[isRtl ? 'right' : 'left'] = '27px';
        statusText.style.background = 'rgba(16,185,129,0.1)';
        statusText.style.color = '#059669';
        statusText.textContent = isRtl ? 'مفعّل' : 'Active';
        numberBadge.style.background = 'var(--primary, #4f46e5)';
    } else {
        dot.style[isRtl ? 'right' : 'left'] = '3px';
        statusText.style.background = 'rgba(100,116,139,0.1)';
        statusText.style.color = '#64748b';
        statusText.textContent = isRtl ? 'معطّل' : 'Disabled';
        numberBadge.style.background = 'var(--bg-alt, #f1f5f9)';
    }
}

// Drag and Drop Reorder
document.addEventListener('DOMContentLoaded', function() {
    const list = document.getElementById('sectionsList');
    if (!list) return;
    
    let dragItem = null;
    
    list.querySelectorAll('.section-control-item').forEach(item => {
        item.setAttribute('draggable', 'true');
        
        item.addEventListener('dragstart', function(e) {
            dragItem = this;
            this.style.opacity = '0.5';
            e.dataTransfer.effectAllowed = 'move';
        });
        
        item.addEventListener('dragend', function() {
            this.style.opacity = '1';
            list.querySelectorAll('.section-control-item').forEach(i => {
                i.style.borderTop = '';
                i.style.borderBottom = '';
            });
            updateOrderValues();
        });
        
        item.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            this.style.borderTop = '3px solid var(--primary, #4f46e5)';
        });
        
        item.addEventListener('dragleave', function() {
            this.style.borderTop = '';
        });
        
        item.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderTop = '';
            if (dragItem !== this) {
                const items = [...list.querySelectorAll('.section-control-item')];
                const dragIndex = items.indexOf(dragItem);
                const dropIndex = items.indexOf(this);
                
                if (dragIndex < dropIndex) {
                    this.parentNode.insertBefore(dragItem, this.nextSibling);
                } else {
                    this.parentNode.insertBefore(dragItem, this);
                }
            }
        });
    });
});

function updateOrderValues() {
    const items = document.querySelectorAll('#sectionsList .section-control-item');
    items.forEach((item, index) => {
        const orderInput = item.querySelector('.section-order');
        if (orderInput) orderInput.value = index + 1;
        
        // Update number badge
        const numberBadge = item.querySelector('div[style*="border-radius: 10px"]');
        if (numberBadge) numberBadge.textContent = index + 1;
    });
}
</script>
