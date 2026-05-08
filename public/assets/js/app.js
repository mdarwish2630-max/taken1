/**
 * CMS Platform - Main JavaScript
 * ملف جافاسكريبت الرئيسي
 */

$(document).ready(function() {
    
    // ==================== Sidebar Toggle ====================
    $('#toggleSidebar').on('click', function() {
        $('#sidebar').toggleClass('open');
    });
    
    // Close sidebar on outside click (mobile)
    $(document).on('click', function(e) {
        if ($(window).width() <= 768) {
            if (!$(e.target).closest('#sidebar, #toggleSidebar').length) {
                $('#sidebar').removeClass('open');
            }
        }
    });
    
    // ==================== User Menu Dropdown ====================
    $('#userMenu').on('click', function(e) {
        e.stopPropagation();
        $(this).toggleClass('open');
    });
    
    // ==================== Form Validation ====================
    $('form[data-validate]').on('submit', function(e) {
        let isValid = true;
        const $form = $(this);
        
        // Check required fields
        $form.find('[required]').each(function() {
            if (!$(this).val().trim()) {
                isValid = false;
                $(this).addClass('error');
                $(this).siblings('.form-error').text('هذا الحقل مطلوب').show();
            } else {
                $(this).removeClass('error');
                $(this).siblings('.form-error').hide();
            }
        });
        
        // Check email fields
        $form.find('[type="email"]').each(function() {
            const email = $(this).val();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                isValid = false;
                $(this).addClass('error');
                $(this).siblings('.form-error').text('البريد الإلكتروني غير صالح').show();
            }
        });
        
        if (!isValid) {
            e.preventDefault();
        }
    });
    
    // ==================== Delete Confirmation ====================
    $('[data-confirm]').on('click', function(e) {
        const message = $(this).data('confirm') || 'هل أنت متأكد؟';
        
        if (!confirm(message)) {
            e.preventDefault();
            return false;
        }
    });
    
    // ==================== AJAX Delete ====================
    $('[data-delete]').on('click', function(e) {
        e.preventDefault();
        
        const $btn = $(this);
        const url = $btn.data('delete');
        const message = $btn.data('confirm') || 'هل أنت متأكد من الحذف؟';
        
        if (!confirm(message)) return;
        
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                [CSRF_TOKEN_NAME]: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Remove item from DOM
                    $btn.closest('tr, .item').fadeOut(300, function() {
                        $(this).remove();
                    });
                    showToast('success', response.message);
                } else {
                    showToast('error', response.message);
                }
            },
            error: function() {
                showToast('error', 'حدث خطأ أثناء الحذف');
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="fas fa-trash"></i>');
            }
        });
    });
    
    // ==================== File Upload Preview ====================
    $('input[type="file"]').on('change', function(e) {
        const $input = $(this);
        const $preview = $input.siblings('.preview');
        const file = e.target.files[0];
        
        if (file && $preview.length) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $preview.attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        }
    });
    
    // ==================== Color Picker ====================
    $('input[type="color"]').on('input', function() {
        const $input = $(this);
        $input.siblings('.color-hex').text($input.val());
    });
    
    // ==================== Theme Selection ====================
    $('.theme-card').on('click', function() {
        const $card = $(this);
        const themeId = $card.data('theme-id');
        
        // Remove selected from all
        $('.theme-card').removeClass('selected');
        
        // Add selected to clicked
        $card.addClass('selected');
        
        // Update hidden input
        $('input[name="theme_id"]').val(themeId);
    });
    
    // ==================== Image Upload Zone ====================
    $('.upload-zone').on('click', function() {
        $(this).siblings('input[type="file"]').click();
    });
    
    $('.upload-zone').on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('dragover');
    });
    
    $('.upload-zone').on('dragleave', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
    });
    
    $('.upload-zone').on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
        
        const files = e.originalEvent.dataTransfer.files;
        const $input = $(this).siblings('input[type="file"]');
        
        $input[0].files = files;
        $input.trigger('change');
    });
    
    // ==================== Toast Notifications ====================
    window.showToast = function(type, message) {
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };
        
        const $toast = $(`
            <div class="toast toast-${type}">
                <i class="fas ${icons[type]}"></i>
                <span>${message}</span>
            </div>
        `);
        
        $('body').append($toast);
        
        setTimeout(() => $toast.addClass('show'), 10);
        
        setTimeout(() => {
            $toast.removeClass('show');
            setTimeout(() => $toast.remove(), 300);
        }, 3000);
    };
    
    // ==================== Form Submit with AJAX ====================
    $('form[data-ajax]').on('submit', function(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $btn = $form.find('[type="submit"]');
        const originalBtnText = $btn.html();
        
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...');
        
        $.ajax({
            url: $form.attr('action'),
            method: $form.attr('method') || 'POST',
            data: new FormData($form[0]),
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showToast('success', response.message);
                    
                    // Redirect if needed
                    if (response.redirect) {
                        setTimeout(() => {
                            window.location.href = response.redirect;
                        }, 1000);
                    }
                    
                    // Reset form if needed
                    if ($form.data('reset')) {
                        $form[0].reset();
                    }
                } else {
                    showToast('error', response.message);
                    
                    // Show validation errors
                    if (response.errors) {
                        $.each(response.errors, function(field, error) {
                            $(`[name="${field}"]`).addClass('error')
                                .siblings('.form-error').text(error).show();
                        });
                    }
                }
            },
            error: function() {
                showToast('error', 'حدث خطأ. يرجى المحاولة مرة أخرى');
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalBtnText);
            }
        });
    });
    
    // ==================== Sortable Items ====================
    if ($.ui && $.ui.sortable) {
        $('.sortable').sortable({
            handle: '.drag-handle',
            update: function(event, ui) {
                const $list = $(this);
                const items = $list.sortable('toArray', { attribute: 'data-id' });
                const updateUrl = $list.data('update-url');
                
                if (updateUrl) {
                    $.post(updateUrl, { order: items });
                }
            }
        });
    }
    
    // ==================== Toggle Status ====================
    $('[data-toggle-status]').on('change', function() {
        const $input = $(this);
        const url = $input.data('toggle-status');
        const id = $input.data('id');
        
        $.post(url, {
            id: id,
            status: $input.is(':checked') ? 'active' : 'inactive',
            [CSRF_TOKEN_NAME]: $('meta[name="csrf-token"]').attr('content')
        });
    });
    
});

// Global CSRF Token (will be set in layout)
var CSRF_TOKEN_NAME = 'csrf_token';
