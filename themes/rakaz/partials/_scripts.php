<!-- Rakaz Theme - Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- AOS Animate on Scroll -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 600,
        easing: 'ease-out-cubic',
        once: true,
        offset: 50
    });
</script>

<!-- Simple FAQ Toggle -->
<script>
document.querySelectorAll('.faq-question').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var answer = this.nextElementSibling;
        var icon = this.querySelector('.faq-icon');
        var isOpen = !answer.classList.contains('hidden');
        
        // Close all others
        document.querySelectorAll('.faq-answer').forEach(function(a) { a.classList.add('hidden'); });
        document.querySelectorAll('.faq-icon').forEach(function(i) { i.style.transform = 'rotate(0deg)'; });
        
        if (!isOpen) {
            answer.classList.remove('hidden');
            if (icon) icon.style.transform = 'rotate(180deg)';
        }
    });
});
</script>

<!-- Simple Contact Form Handler -->
<script>
document.querySelectorAll('form[data-ajax]').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var btn = this.querySelector('button[type="submit"]');
        var originalText = btn.textContent;
        btn.textContent = 'جاري الإرسال...';
        btn.disabled = true;
        
        fetch(this.action || '<?php echo $siteBase ?? "/"; ?>/contact', {
            method: 'POST',
            body: formData
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.success) {
                alert('تم الإرسال بنجاح! سنتواصل معك قريباً.');
                form.reset();
            } else {
                alert(data.message || 'حدث خطأ، يرجى المحاولة مرة أخرى.');
            }
        })
        .catch(function() {
            alert('حدث خطأ في الاتصال، يرجى المحاولة مرة أخرى.');
        })
        .finally(function() {
            btn.textContent = originalText;
            btn.disabled = false;
        });
    });
});
</script>

<!-- Smooth scroll for anchor links -->
<script>
document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
    anchor.addEventListener('click', function(e) {
        var target = document.querySelector(this.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});
</script>
