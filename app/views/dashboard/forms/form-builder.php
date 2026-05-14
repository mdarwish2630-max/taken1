<?php
/**
 * Form Builder View
 * منشئ النماذج المرئي
 */

$tenant = Auth::tenant();
$isEdit = !empty($form);
?>

<div class="page-header">
    <h1 class="h3 mb-0">
        <i class="fas fa-<?= $isEdit ? 'edit' : 'plus' ?> me-2"></i>
        <?= $isEdit ? lang('edit_form') : lang('create_form') ?>
    </h1>
</div>

<form method="POST" action="<?= $isEdit ? url('/dashboard/forms/edit/' . $form->id) : url('/dashboard/forms/add') ?>" 
      id="formBuilder">
    <?= $this->csrf() ?>
    
    <div class="row">
        <!-- Main Settings -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold"><?= lang('form_name') ?> <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" 
                                       value="<?= $isEdit ? htmlspecialchars($form->name) : '' ?>" required
                                       placeholder="<?= lang('form_name_placeholder') ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold"><?= lang('status') ?></label>
                                <select name="status" class="form-select">
                                    <option value="active" <?= ($isEdit && $form->status === 'active') ? 'selected' : '' ?>>
                                        <?= lang('active') ?>
                                    </option>
                                    <option value="inactive" <?= ($isEdit && $form->status === 'inactive') ? 'selected' : '' ?>>
                                        <?= lang('inactive') ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><?= lang('description') ?></label>
                        <textarea name="description" class="form-control" rows="2" 
                                  placeholder="<?= lang('form_description_placeholder') ?>"><?= $isEdit ? htmlspecialchars($form->description ?? '') : '' ?></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Fields Builder -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list-ul me-2"></i>
                        <?= lang('form_fields') ?>
                    </h5>
                    <button type="button" class="btn btn-primary btn-sm" onclick="addField()">
                        <i class="fas fa-plus me-1"></i>
                        <?= lang('add_field') ?>
                    </button>
                </div>
                <div class="card-body">
                    <div id="fieldsContainer" class="sortable">
                        <!-- Fields will be added here -->
                    </div>
                    
                    <div id="noFieldsMessage" class="text-center py-5">
                        <i class="fas fa-list fa-3x text-muted mb-3"></i>
                        <p class="text-muted"><?= lang('no_fields_yet') ?></p>
                        <button type="button" class="btn btn-outline-primary" onclick="addField()">
                            <i class="fas fa-plus me-1"></i>
                            <?= lang('add_first_field') ?>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Submit Settings -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cog me-2"></i>
                        <?= lang('submission_settings') ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><?= lang('submit_button_text') ?></label>
                                <input type="text" name="submit_button_text" class="form-control" 
                                       value="<?= $isEdit ? ($form->submit_button_text ?? lang('submit')) : lang('submit') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><?= lang('redirect_url') ?></label>
                                <input type="url" name="redirect_url" class="form-control" 
                                       value="<?= $isEdit ? ($form->redirect_url ?? '') : '' ?>"
                                       placeholder="https://...">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><?= lang('success_message') ?></label>
                        <textarea name="success_message" class="form-control" rows="2" 
                                  placeholder="<?= lang('success_message_placeholder') ?>"><?= $isEdit ? ($form->success_message ?? '') : '' ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Field Types -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-th me-2"></i>
                        <?= lang('field_types') ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-secondary w-100 text-start" 
                                    onclick="addField('text')">
                                <i class="fas fa-font me-2"></i>
                                <?= lang('text_field') ?>
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-secondary w-100 text-start" 
                                    onclick="addField('email')">
                                <i class="fas fa-envelope me-2"></i>
                                <?= lang('email_field') ?>
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-secondary w-100 text-start" 
                                    onclick="addField('phone')">
                                <i class="fas fa-phone me-2"></i>
                                <?= lang('phone_field') ?>
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-secondary w-100 text-start" 
                                    onclick="addField('textarea')">
                                <i class="fas fa-align-left me-2"></i>
                                <?= lang('textarea_field') ?>
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-secondary w-100 text-start" 
                                    onclick="addField('select')">
                                <i class="fas fa-list me-2"></i>
                                <?= lang('select_field') ?>
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-secondary w-100 text-start" 
                                    onclick="addField('checkbox')">
                                <i class="fas fa-check-square me-2"></i>
                                <?= lang('checkbox_field') ?>
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-secondary w-100 text-start" 
                                    onclick="addField('radio')">
                                <i class="fas fa-dot-circle me-2"></i>
                                <?= lang('radio_field') ?>
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-secondary w-100 text-start" 
                                    onclick="addField('date')">
                                <i class="fas fa-calendar me-2"></i>
                                <?= lang('date_field') ?>
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-secondary w-100 text-start" 
                                    onclick="addField('file')">
                                <i class="fas fa-upload me-2"></i>
                                <?= lang('file_field') ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Email Notifications -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bell me-2"></i>
                        <?= lang('notifications') ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="send_email_notification" 
                               id="sendEmail" value="1" <?= ($isEdit && $form->send_email_notification) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="sendEmail">
                            <?= lang('send_email_notification') ?>
                        </label>
                    </div>
                    
                    <div class="mb-3" id="emailRecipients">
                        <label class="form-label"><?= lang('notification_recipients') ?></label>
                        <textarea name="email_recipients" class="form-control" rows="3" 
                                  placeholder="email1@example.com
email2@example.com"><?= $isEdit ? implode("\n", json_decode($form->email_recipients ?? '[]', true) ?: []) : '' ?></textarea>
                        <small class="text-muted"><?= lang('one_email_per_line') ?></small>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-save me-2"></i>
                        <?= lang('save_form') ?>
                    </button>
                    <a href="<?= url('/dashboard/forms') ?>" class="btn btn-outline-secondary w-100">
                        <?= lang('cancel') ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Field Template -->
<template id="fieldTemplate">
    <div class="field-item card mb-3" data-field-id="">
        <div class="card-header d-flex justify-content-between align-items-center py-2">
            <div class="d-flex align-items-center">
                <i class="fas fa-grip-vertical text-muted me-2 cursor-move"></i>
                <span class="field-type-icon me-2"></span>
                <strong class="field-name"></strong>
            </div>
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-primary" onclick="editField(this)">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-outline-danger" onclick="removeField(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="card-body py-2 field-options" style="display: none;">
            <!-- Field options will be loaded here -->
        </div>
        <input type="hidden" name="fields[][type]" class="field-type">
        <input type="hidden" name="fields[][name]" class="field-name-input">
        <input type="hidden" name="fields[][label]" class="field-label-input">
        <input type="hidden" name="fields[][required]" class="field-required">
        <input type="hidden" name="fields[][options]" class="field-options-input">
    </div>
</template>

<!-- Field Edit Modal -->
<div class="modal fade" id="fieldModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= lang('edit_field') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label"><?= lang('field_label') ?></label>
                    <input type="text" class="form-control" id="editFieldLabel">
                </div>
                <div class="mb-3">
                    <label class="form-label"><?= lang('field_name') ?></label>
                    <input type="text" class="form-control" id="editFieldName">
                    <small class="text-muted"><?= lang('field_name_hint') ?></small>
                </div>
                <div class="mb-3">
                    <label class="form-label"><?= lang('field_placeholder') ?></label>
                    <input type="text" class="form-control" id="editFieldPlaceholder">
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="editFieldRequired">
                    <label class="form-check-label" for="editFieldRequired">
                        <?= lang('field_required') ?>
                    </label>
                </div>
                <div class="mb-3" id="optionsContainer" style="display: none;">
                    <label class="form-label"><?= lang('options') ?></label>
                    <textarea class="form-control" id="editFieldOptions" rows="4" 
                              placeholder="Option 1
Option 2
Option 3"></textarea>
                    <small class="text-muted"><?= lang('one_option_per_line') ?></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <?= lang('cancel') ?>
                </button>
                <button type="button" class="btn btn-primary" onclick="saveFieldChanges()">
                    <?= lang('save') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.cursor-move {
    cursor: move;
}
.sortable-ghost {
    opacity: 0.4;
}
</style>

<script>
let fieldCounter = 0;
let currentFieldItem = null;

// Initialize with existing fields
<?php if ($isEdit && !empty($form->fields)): ?>
const existingFields = <?= json_encode(json_decode($form->fields ?? '[]', true) ?: [], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
existingFields.forEach(field => addExistingField(field));
<?php endif; ?>

function addExistingField(field) {
    const template = document.getElementById('fieldTemplate');
    const clone = template.content.cloneNode(true);
    const item = clone.querySelector('.field-item');
    
    item.dataset.fieldId = ++fieldCounter;
    item.querySelector('.field-type').value = field.type;
    item.querySelector('.field-name-input').value = field.name;
    item.querySelector('.field-label-input').value = field.label;
    item.querySelector('.field-required').value = field.required ? 1 : 0;
    item.querySelector('.field-options-input').value = JSON.stringify(field.options || []);
    
    item.querySelector('.field-name').textContent = field.label;
    setFieldIcon(item.querySelector('.field-type-icon'), field.type);
    
    document.getElementById('fieldsContainer').appendChild(item);
    updateNoFieldsMessage();
}

function addField(type = 'text') {
    const template = document.getElementById('fieldTemplate');
    const clone = template.content.cloneNode(true);
    const item = clone.querySelector('.field-item');
    
    item.dataset.fieldId = ++fieldCounter;
    
    const fieldNames = {
        text: '<?= lang('text_field') ?>',
        email: '<?= lang('email_field') ?>',
        phone: '<?= lang('phone_field') ?>',
        textarea: '<?= lang('textarea_field') ?>',
        select: '<?= lang('select_field') ?>',
        checkbox: '<?= lang('checkbox_field') ?>',
        radio: '<?= lang('radio_field') ?>',
        date: '<?= lang('date_field') ?>',
        file: '<?= lang('file_field') ?>'
    };
    
    item.querySelector('.field-type').value = type;
    item.querySelector('.field-name-input').value = 'field_' + fieldCounter;
    item.querySelector('.field-label-input').value = fieldNames[type] || type;
    item.querySelector('.field-name').textContent = fieldNames[type] || type;
    
    setFieldIcon(item.querySelector('.field-type-icon'), type);
    
    document.getElementById('fieldsContainer').appendChild(item);
    updateNoFieldsMessage();
    
    // Open edit modal
    editField(item.querySelector('.btn-outline-primary'));
}

function setFieldIcon(el, type) {
    const icons = {
        text: 'fa-font',
        email: 'fa-envelope',
        phone: 'fa-phone',
        textarea: 'fa-align-left',
        select: 'fa-list',
        checkbox: 'fa-check-square',
        radio: 'fa-dot-circle',
        date: 'fa-calendar',
        file: 'fa-upload'
    };
    el.className = 'fas ' + (icons[type] || 'fa-question') + ' me-2';
}

function editField(btn) {
    currentFieldItem = btn.closest('.field-item');
    
    document.getElementById('editFieldLabel').value = 
        currentFieldItem.querySelector('.field-label-input').value;
    document.getElementById('editFieldName').value = 
        currentFieldItem.querySelector('.field-name-input').value;
    document.getElementById('editFieldRequired').checked = 
        currentFieldItem.querySelector('.field-required').value == 1;
    
    const type = currentFieldItem.querySelector('.field-type').value;
    const showOptions = ['select', 'radio', 'checkbox'].includes(type);
    document.getElementById('optionsContainer').style.display = showOptions ? 'block' : 'none';
    
    if (showOptions) {
        const options = JSON.parse(currentFieldItem.querySelector('.field-options-input').value || '[]');
        document.getElementById('editFieldOptions').value = options.join('\n');
    }
    
    new bootstrap.Modal(document.getElementById('fieldModal')).show();
}

function saveFieldChanges() {
    currentFieldItem.querySelector('.field-label-input').value = 
        document.getElementById('editFieldLabel').value;
    currentFieldItem.querySelector('.field-name-input').value = 
        document.getElementById('editFieldName').value;
    currentFieldItem.querySelector('.field-required').value = 
        document.getElementById('editFieldRequired').checked ? 1 : 0;
    
    currentFieldItem.querySelector('.field-name').textContent = 
        document.getElementById('editFieldLabel').value;
    
    const type = currentFieldItem.querySelector('.field-type').value;
    if (['select', 'radio', 'checkbox'].includes(type)) {
        const options = document.getElementById('editFieldOptions').value
            .split('\n')
            .map(o => o.trim())
            .filter(o => o);
        currentFieldItem.querySelector('.field-options-input').value = JSON.stringify(options);
    }
    
    bootstrap.Modal.getInstance(document.getElementById('fieldModal')).hide();
}

function removeField(btn) {
    if (confirm('<?= lang('confirm_delete') ?>')) {
        btn.closest('.field-item').remove();
        updateNoFieldsMessage();
    }
}

function updateNoFieldsMessage() {
    const hasFields = document.getElementById('fieldsContainer').children.length > 0;
    document.getElementById('noFieldsMessage').style.display = hasFields ? 'none' : 'block';
}

// Make fields sortable
new Sortable(document.getElementById('fieldsContainer'), {
    animation: 150,
    handle: '.fa-grip-vertical',
    ghostClass: 'sortable-ghost'
});

// Toggle email recipients
document.getElementById('sendEmail').addEventListener('change', function() {
    document.getElementById('emailRecipients').style.display = this.checked ? 'block' : 'none';
});
</script>
