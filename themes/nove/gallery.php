<?php require_once __DIR__ . '/_head.php'; require_once __DIR__ . '/_navbar.php'; ?>

<!-- ==================== HERO BANNER ==================== -->
<section class="relative bg-[#111] pt-32 pb-24 overflow-hidden">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="absolute top-10 right-10 w-48 h-48 bg-[#ff7a00]/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-20 text-center fade-up">
        <div class="orange-bar mx-auto mb-6"></div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white mb-5 uppercase">معرض الصور</h1>
        <p class="text-white/70 text-lg max-w-2xl mx-auto">شاهد نتائج أعمالنا الاحترافية واكتشف جودة خدماتنا من خلال الصور</p>

        <nav class="mt-8 flex items-center justify-center gap-2 text-sm text-white/50">
            <a href="<?php echo htmlspecialchars($siteBase); ?>" class="hover:text-[#ff7a00] transition-colors">الرئيسية</a>
            <i class="fas fa-chevron-left text-[10px]"></i>
            <span class="text-[#ff7a00] font-bold">معرض الصور</span>
        </nav>
    </div>
</section>

<!-- ==================== GALLERY ==================== -->
<section class="bg-[#f4f4f4] py-24 px-6 lg:px-20">
    <div class="max-w-7xl mx-auto">
        <?php if (!empty($gallery)): ?>
            <!-- Category Filters -->
            <?php
            $galleryCategories = [];
            foreach ($gallery as $item) {
                $cat = $item->category ?? $item->type ?? '';
                if ($cat && !in_array($cat, $galleryCategories)) {
                    $galleryCategories[] = $cat;
                }
            }
            ?>
            <?php if (!empty($galleryCategories)): ?>
            <div class="flex flex-wrap justify-center gap-3 mb-12 fade-up" id="gallery-filters">
                <button onclick="filterGallery('all')"
                        class="gallery-filter-btn active bg-[#ff7a00] text-white font-black px-6 py-2.5 transition-all duration-300 text-sm"
                        data-filter="all">الكل</button>
                <?php foreach ($galleryCategories as $cat): ?>
                <button onclick="filterGallery('<?php echo htmlspecialchars($cat); ?>')"
                        class="gallery-filter-btn bg-white text-[#282828] font-black px-6 py-2.5 transition-all duration-300 hover:bg-[#ff7a00] hover:text-white text-sm"
                        data-filter="<?php echo htmlspecialchars($cat); ?>">
                    <?php echo htmlspecialchars($cat); ?>
                </button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Image Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="gallery-grid">
                <?php foreach ($gallery as $index => $item): ?>
                <div class="gallery-item group relative overflow-hidden cursor-pointer shadow-sm hover:shadow-xl transition-all duration-500 fade-up"
                     data-category="<?php echo htmlspecialchars($item->category ?? $item->type ?? 'all'); ?>"
                     onclick="openLightbox(<?php echo $index; ?>)">
                    <?php if (!empty($item->image ?? $item->url ?? $item->src)): ?>
                    <img src="<?php echo htmlspecialchars($item->image ?? $item->url ?? $item->src); ?>"
                         alt="<?php echo htmlspecialchars($item->title ?? $item->caption ?? 'صورة'); ?>"
                         class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                    <?php else: ?>
                    <div class="w-full h-64 bg-gradient-to-br from-[#ff7a00]/20 to-[#f4f4f4] flex items-center justify-center">
                        <i class="fas fa-image text-5xl text-[#ff7a00]/30"></i>
                    </div>
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-[#151515]/0 group-hover:bg-[#151515]/60 transition-all duration-500 flex items-center justify-center">
                        <div class="opacity-0 group-hover:opacity-100 transition-all duration-500 text-center text-white transform translate-y-4 group-hover:translate-y-0">
                            <div class="w-14 h-14 bg-white/20 backdrop-blur-sm flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-search-plus text-xl"></i>
                            </div>
                            <?php if (!empty($item->title ?? $item->caption)): ?>
                            <p class="text-sm font-black"><?php echo htmlspecialchars($item->title ?? $item->caption); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
        <div class="text-center py-20 fade-up">
            <div class="text-7xl mb-6"><i class="fas fa-images text-[#ff7a00]/40"></i></div>
            <h3 class="text-2xl font-black text-[#282828] mb-3">لا توجد صور حالياً</h3>
            <p class="text-gray-500 mb-8">سيتم إضافة صور أعمالنا قريباً</p>
            <a href="<?php echo htmlspecialchars($siteBase); ?>/services" class="bg-[#ff7a00] text-white font-black px-8 py-4 hover:bg-[#282828] transition-all duration-300 inline-block">
                تصفح خدماتنا
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ==================== LIGHTBOX ==================== -->
<?php if (!empty($gallery)): ?>
<div id="lightbox-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/90 backdrop-blur-sm p-4" onclick="closeLightbox(event)">
    <button onclick="closeLightbox(event)" class="absolute top-6 left-6 z-10 w-12 h-12 bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors text-white">
        <i class="fas fa-xmark text-xl"></i>
    </button>
    <button onclick="navigateLightbox(1, event)" class="absolute right-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors text-white">
        <i class="fas fa-chevron-right"></i>
    </button>
    <button onclick="navigateLightbox(-1, event)" class="absolute left-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors text-white">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="max-w-5xl max-h-[85vh] w-full flex items-center justify-center">
        <img id="lightbox-image" src="" alt="" class="max-w-full max-h-[85vh] object-contain shadow-2xl">
    </div>
    <div id="lightbox-caption" class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white text-center">
        <p id="lightbox-title" class="font-black text-lg"></p>
        <p id="lightbox-counter" class="text-white/60 text-sm mt-1"></p>
    </div>
</div>

<script>
const galleryData = [
    <?php foreach ($gallery as $item): ?>
    { src: '<?php echo htmlspecialchars(addslashes($item->image ?? $item->url ?? $item->src ?? '')); ?>', title: '<?php echo htmlspecialchars(addslashes($item->title ?? $item->caption ?? '')); ?>' },
    <?php endforeach; ?>
];
let currentImageIndex = 0;
const lightboxModal = document.getElementById('lightbox-modal');

function openLightbox(index) {
    currentImageIndex = index; updateLightbox();
    lightboxModal.classList.remove('hidden'); lightboxModal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeLightbox(e) {
    if (e.target === lightboxModal || e.currentTarget.tagName === 'BUTTON') {
        lightboxModal.classList.add('hidden'); lightboxModal.classList.remove('flex');
        document.body.style.overflow = '';
    }
}
function navigateLightbox(dir, e) {
    e.stopPropagation();
    currentImageIndex = (currentImageIndex + dir + galleryData.length) % galleryData.length;
    updateLightbox();
}
function updateLightbox() {
    const item = galleryData[currentImageIndex];
    document.getElementById('lightbox-image').src = item.src;
    document.getElementById('lightbox-title').textContent = item.title;
    document.getElementById('lightbox-counter').textContent = (currentImageIndex + 1) + ' / ' + galleryData.length;
}
document.addEventListener('keydown', function(e) {
    if (lightboxModal.classList.contains('hidden')) return;
    if (e.key === 'Escape') { lightboxModal.classList.add('hidden'); lightboxModal.classList.remove('flex'); document.body.style.overflow = ''; }
    if (e.key === 'ArrowLeft') navigateLightbox(-1, e);
    if (e.key === 'ArrowRight') navigateLightbox(1, e);
});
function filterGallery(category) {
    const items = document.querySelectorAll('.gallery-item');
    const buttons = document.querySelectorAll('.gallery-filter-btn');
    buttons.forEach(btn => {
        if (btn.dataset.filter === category) { btn.classList.remove('bg-white','text-[#282828]'); btn.classList.add('bg-[#ff7a00]','text-white','active'); }
        else { btn.classList.remove('bg-[#ff7a00]','text-white','active'); btn.classList.add('bg-white','text-[#282828]'); }
    });
    items.forEach(item => {
        if (category === 'all' || item.dataset.category === category) { item.style.display = ''; item.style.animation = 'fadeIn 0.5s ease forwards'; }
        else { item.style.display = 'none'; }
    });
}
</script>
<style>@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }</style>
<?php endif; ?>

<?php require_once __DIR__ . '/_footer.php'; require_once __DIR__ . '/_scripts.php'; ?>
