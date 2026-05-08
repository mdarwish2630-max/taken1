<?php
/**
 * FAQ Dashboard View
 * صفحة إدارة الأسئلة الشائعة
 */

$categoryLabels = [
    'general' => 'أسئلة عامة',
    'pricing' => 'الأسعار',
    'services' => 'الخدمات',
    'technical' => 'أسئلة تقنية',
    'other' => 'أخرى'
];
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-question-circle"></i>
            الأسئلة الشائعة (FAQ)
        </h3>
        <span class="badge bg-primary"><?= count($faqs) ?> سؤال</span>
    </div>
    <div class="card-body">

        <!-- إضافة سؤال جديد -->
        <div style="background: var(--light); padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem;">
            <h5 style="font-weight: 700; margin-bottom: 1rem;">
                <i class="fas fa-plus-circle" style="color: var(--primary);"></i>
                إضافة سؤال جديد
            </h5>
            <form method="POST" action="<?= url('/dashboard/faq') ?>">
                <?= $this->csrf() ?>

                <!-- اختيار التصنيف -->
                <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div class="form-group">
                        <label class="form-label">التصنيف</label>
                        <select name="category" class="form-control">
                            <?php foreach ($categoryLabels as $key => $label): ?>
                            <option value="<?= $key ?>" <?= ($key === 'general') ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">الحالة</label>
                        <select name="is_active" class="form-control">
                            <option value="1" selected>مفعّل</option>
                            <option value="0">معطّل</option>
                        </select>
                    </div>
                </div>

                <!-- حقل السؤال بالعربية -->
                <div class="lang-section-header">
                    <span class="lang-badge">🇸🇦 العربية</span>
                </div>

                <div class="form-group">
                    <label class="form-label">السؤال *</label>
                    <input type="text" name="question" class="form-control" dir="rtl" placeholder="اكتب السؤال بالعربية" required>
                </div>
                <div class="form-group">
                    <label class="form-label">الإجابة *</label>
                    <textarea name="answer" class="form-control" rows="3" dir="rtl" placeholder="اكتب الإجابة بالعربية" required></textarea>
                </div>

                <!-- حقل السؤال بالإنجليزية -->
                <div class="lang-section-header" style="margin-top: 1rem;">
                    <span class="lang-badge">🇬🇧 English</span>
                    <span class="form-hint" style="margin-right: auto;">(اختياري / Optional)</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Question (English)</label>
                    <input type="text" name="question_en" class="form-control" dir="ltr" placeholder="Type the question in English">
                </div>
                <div class="form-group">
                    <label class="form-label">Answer (English)</label>
                    <textarea name="answer_en" class="form-control" rows="3" dir="ltr" placeholder="Type the answer in English"></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">
                    <i class="fas fa-plus"></i> إضافة السؤال
                </button>
            </form>
        </div>

        <!-- قائمة الأسئلة -->
        <?php if (!empty($faqs)): ?>
        <h5 style="font-weight: 700; margin-bottom: 1rem;">
            <i class="fas fa-list" style="color: var(--primary);"></i>
            الأسئلة المضافة
        </h5>

        <?php
        // تجميع الأسئلة حسب التصنيف
        $groupedFaqs = [];
        foreach ($faqs as $f) {
            $cat = $f->category ?: 'general';
            if (!isset($groupedFaqs[$cat])) $groupedFaqs[$cat] = [];
            $groupedFaqs[$cat][] = $f;
        }
        ?>

        <?php foreach ($groupedFaqs as $cat => $catFaqs): ?>
        <div class="faq-category-block" style="margin-bottom: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                <span style="background: var(--primary); color: #fff; padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600;">
                    <?= $categoryLabels[$cat] ?? $cat ?>
                </span>
                <span style="color: #94a3b8; font-size: 0.8rem;">(<?= count($catFaqs) ?> سؤال)</span>
            </div>

            <?php foreach ($catFaqs as $faq): ?>
            <div class="faq-manage-item" id="faq-item-<?= $faq->id ?>" style="display: flex; gap: 1rem; padding: 1rem; background: #fff; border: 1px solid var(--border); border-radius: 10px; margin-bottom: 0.75rem; transition: all 0.2s; <?= !$faq->is_active ? 'opacity: 0.5;' : '' ?>">
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                        <strong style="font-size: 0.95rem;"><?= htmlspecialchars($faq->question) ?></strong>
                        <?php if (!$faq->is_active): ?>
                        <span class="badge bg-secondary" style="font-size: 0.7rem;">معطّل</span>
                        <?php endif; ?>
                    </div>
                    <?php if ($faq->question_en): ?>
                    <div style="font-size: 0.85rem; color: #64748b; margin-bottom: 0.25rem;">EN: <?= htmlspecialchars($faq->question_en) ?></div>
                    <?php endif; ?>
                    <div style="font-size: 0.9rem; color: #475569; margin-bottom: 0.25rem;"><?= htmlspecialchars(mb_substr($faq->answer, 0, 150)) ?><?= mb_strlen($faq->answer) > 150 ? '...' : '' ?></div>
                    <?php if ($faq->answer_en): ?>
                    <div style="font-size: 0.85rem; color: #94a3b8; font-style: italic;">EN: <?= htmlspecialchars(mb_substr($faq->answer_en, 0, 100)) ?><?= mb_strlen($faq->answer_en) > 100 ? '...' : '' ?></div>
                    <?php endif; ?>
                </div>

                <div style="display: flex; gap: 0.5rem; flex-shrink: 0; align-items: start;">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="editFaq(<?= $faq->id ?>)" title="تعديل">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-<?= $faq->is_active ? 'warning' : 'success' ?>"
                            onclick="toggleFaqStatus(<?= $faq->id ?>)"
                            title="<?= $faq->is_active ? 'تعطيل' : 'تفعيل' ?>">
                        <i class="fas fa-<?= $faq->is_active ? 'eye-slash' : 'eye' ?>"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger"
                            onclick="deleteFaqItem(<?= $faq->id ?>)"
                            title="حذف">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>

        <?php else: ?>
        <div style="text-align: center; padding: 3rem; color: #94a3b8;">
            <i class="fas fa-question-circle" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
            <p>لا توجد أسئلة شائعة بعد. أضف أول سؤال من النموذج أعلاه.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- مودال تعديل السؤال -->
<div class="modal fade" id="editFaqModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit"></i> تعديل السؤال</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editFaqForm">
                    <input type="hidden" name="faq_id" id="editFaqId">
                    <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div class="form-group">
                            <label class="form-label">التصنيف</label>
                            <select name="category" id="editFaqCategory" class="form-control">
                                <?php foreach ($categoryLabels as $key => $label): ?>
                                <option value="<?= $key ?>"><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="lang-section-header">
                        <span class="lang-badge">🇸🇦 العربية</span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">السؤال *</label>
                        <input type="text" name="question" id="editFaqQuestion" class="form-control" dir="rtl" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">الإجابة *</label>
                        <textarea name="answer" id="editFaqAnswer" class="form-control" rows="3" dir="rtl" required></textarea>
                    </div>

                    <div class="lang-section-header" style="margin-top: 1rem;">
                        <span class="lang-badge">🇬🇧 English</span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Question (English)</label>
                        <input type="text" name="question_en" id="editFaqQuestionEn" class="form-control" dir="ltr">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Answer (English)</label>
                        <textarea name="answer_en" id="editFaqAnswerEn" class="form-control" rows="3" dir="ltr"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" onclick="saveFaqEdit()">
                    <i class="fas fa-save"></i> حفظ التعديلات
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.lang-section-header {
    display: flex; align-items: center; gap: 0.75rem;
    padding-bottom: 0.5rem; margin-bottom: 0.75rem;
    border-bottom: 2px solid var(--border, #e2e8f0);
}
.lang-badge {
    display: inline-flex; align-items: center; gap: 0.4rem;
    background: var(--primary, #4f46e5); color: #fff;
    padding: 0.35rem 1rem; border-radius: 50px;
    font-size: 0.85rem; font-weight: 600;
}
.form-hint { font-size: 0.8rem; color: #94a3b8; }
</style>

<script>
// تعديل السؤال
function editFaq(id) {
    // جمع بيانات السؤال من DOM
    const item = document.getElementById('faq-item-' + id);
    if (!item) return;

    // البحث عن بيانات السؤال في قائمة الأسئلة
    const questions = item.querySelectorAll('strong');
    const answers = item.querySelectorAll('[style*="color: #475569"]');
    const questionsEn = item.querySelectorAll('[style*="color: #64748b"]');
    const answersEn = item.querySelectorAll('[style*="font-style: italic"]');

    document.getElementById('editFaqId').value = id;
    if (questions[0]) document.getElementById('editFaqQuestion').value = questions[0].textContent.trim();
    if (answers[0]) document.getElementById('editFaqAnswer').value = '';
    if (questionsEn[0]) document.getElementById('editFaqQuestionEn').value = questionsEn[0].textContent.replace('EN: ', '').trim();
    if (answersEn[0]) document.getElementById('editFaqAnswerEn').value = answersEn[0].textContent.replace('EN: ', '').trim();

    new bootstrap.Modal(document.getElementById('editFaqModal')).show();
}

// حفظ التعديل
function saveFaqEdit() {
    const id = document.getElementById('editFaqId').value;
    const form = document.getElementById('editFaqForm');
    const formData = new FormData(form);

    formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

    fetch('<?= url("/dashboard/faq/edit/") ?>' + id, {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('editFaqModal')).hide();
            location.reload();
        } else {
            alert(data.message || 'حدث خطأ');
        }
    })
    .catch(() => alert('حدث خطأ في الاتصال'));
}

// تبديل حالة التفعيل
function toggleFaqStatus(id) {
    if (!confirm('هل تريد تغيير حالة هذا السؤال؟')) return;

    const formData = new FormData();
    formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

    fetch('<?= url("/dashboard/faq/toggle/") ?>' + id, {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) location.reload();
        else alert(data.message || 'حدث خطأ');
    })
    .catch(() => alert('حدث خطأ في الاتصال'));
}

// حذف السؤال
function deleteFaqItem(id) {
    if (!confirm('هل أنت متأكد من حذف هذا السؤال؟')) return;

    const formData = new FormData();
    formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

    fetch('<?= url("/dashboard/faq/delete/") ?>' + id, {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const item = document.getElementById('faq-item-' + id);
            if (item) {
                item.style.transition = 'all 0.3s';
                item.style.opacity = '0';
                item.style.transform = 'translateX(20px)';
                setTimeout(() => item.remove(), 300);
            }
            setTimeout(() => location.reload(), 500);
        } else {
            alert(data.message || 'حدث خطأ');
        }
    })
    .catch(() => alert('حدث خطأ في الاتصال'));
}
</script>
