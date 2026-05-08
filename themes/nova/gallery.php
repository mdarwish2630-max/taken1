<?php
/**
 * Theme: Nova - Gallery Page
 */
$lang = Language::current(); $dir = Language::direction(); $isRtl = $dir === 'rtl';
$themePrimary = $tenant->primary_color ?? '#6366f1';
$themeSecondary = $tenant->secondary_color ?? '#4f46e5';
$siteBase = '/site/' . $tenant->slug;
$galleryCategories = [];
if (!empty($gallery)) { foreach ($gallery as $g) { $cat = $g->category ?? 'general'; if (!in_array($cat, $galleryCategories)) $galleryCategories[] = $cat; } }
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? lang('gallery') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap<?= $isRtl ? '.rtl' : '' ?>.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=<?= $isRtl ? 'Cairo:wght@300;400;500;600;700;800;900' : 'Poppins:wght@300;400;500;600;700;800;900' ?>&display=swap" rel="stylesheet">
    <style>
        :root{--primary:<?=$themePrimary?>;--primary-dark:<?=$themeSecondary?>;--gradient:linear-gradient(135deg,var(--primary) 0%,var(--primary-dark) 100%);--radius:12px;--radius-lg:20px;--text:#1a1a2e;--text-secondary:#4a4a6a;--bg-alt:#f8f9fc;--border-light:#f0f1f7;--shadow:0 4px 20px rgba(0,0,0,.07);--shadow-lg:0 16px 48px rgba(0,0,0,.12);--primary-50:color-mix(in srgb,var(--primary) 6%,white);--font:'<?= $isRtl?'Cairo':'Poppins'?>',system-ui,sans-serif;--transition:all .35s cubic-bezier(.4,0,.2,1)}
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}html{scroll-behavior:smooth}body{font-family:var(--font);color:var(--text);background:#fff;line-height:1.7}a{text-decoration:none;color:inherit;transition:var(--transition)}img{max-width:100%;height:auto;display:block}ul{list-style:none}.container{max-width:1200px;margin:0 auto;padding:0 1.5rem}
        .nova-navbar{background:rgba(255,255,255,.78);backdrop-filter:blur(24px);position:fixed;width:100%;top:0;z-index:1050;border-bottom:1px solid var(--border-light)}.nova-navbar .container{display:flex;align-items:center;justify-content:space-between;height:76px}.nav-brand{display:flex;align-items:center;gap:.65rem;font-weight:800;font-size:1.2rem;color:var(--primary)}.nav-brand img{height:44px;border-radius:8px}.nav-brand .brand-icon{width:42px;height:42px;background:var(--gradient);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.15rem}.nav-links{display:flex;align-items:center;gap:.1rem}.nav-links>li>a{padding:.5rem .85rem;border-radius:8px;font-weight:500;font-size:.9rem;color:var(--text-secondary)}.nav-links>li>a:hover{color:var(--primary);background:var(--primary-50)}.lang-switch{display:inline-flex;align-items:center;gap:.35rem;padding:.45rem .85rem!important;border:1.5px solid var(--border-light)!important;border-radius:8px!important;font-size:.8rem!important;font-weight:600!important;color:var(--text-secondary)!important}.mobile-btn{display:none;background:none;border:none;font-size:1.35rem;cursor:pointer;color:var(--text);width:42px;height:42px}@media(max-width:992px){.mobile-btn{display:flex;align-items:center;justify-content:center}.nav-links{display:none;position:absolute;top:100%;left:0;right:0;background:#fff;flex-direction:column;padding:.75rem;box-shadow:var(--shadow-lg)}.nav-links.open{display:flex}}
        .page-hero{background:var(--gradient);padding:8rem 1.5rem 4rem;text-align:center}.page-hero h1{color:#fff;font-size:clamp(2rem,4vw,3rem);font-weight:800;margin-bottom:.75rem}.page-hero p{color:rgba(255,255,255,.8);font-size:1.1rem;max-width:600px;margin:0 auto}.breadcrumb{display:flex;justify-content:center;gap:.5rem;margin-top:1.5rem}.breadcrumb a{color:rgba(255,255,255,.7);font-size:.88rem}.breadcrumb span{color:rgba(255,255,255,.5);font-size:.88rem}.breadcrumb .current{color:#fff;font-weight:600;font-size:.88rem}
        .gallery-section{padding:5rem 1.5rem}.gallery-filters{display:flex;justify-content:center;gap:.5rem;margin-bottom:2.5rem;flex-wrap:wrap}.gallery-filter-btn{padding:.5rem 1.25rem;border-radius:9999px;border:1.5px solid var(--border-light);background:#fff;color:var(--text-secondary);font-size:.85rem;font-weight:600;font-family:var(--font);cursor:pointer;transition:var(--transition)}.gallery-filter-btn:hover{border-color:var(--primary);color:var(--primary);background:var(--primary-50)}.gallery-filter-btn.active{background:var(--primary);color:#fff;border-color:var(--primary)}
        .gallery-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.25rem}.gallery-item{position:relative;overflow:hidden;border-radius:var(--radius);aspect-ratio:4/3;cursor:pointer;box-shadow:0 2px 8px rgba(0,0,0,.05);transition:var(--transition)}.gallery-item.hidden-item{display:none}.gallery-item:hover{transform:translateY(-5px);box-shadow:var(--shadow-lg)}.gallery-item img{width:100%;height:100%;object-fit:cover;transition:transform .6s ease}.gallery-item:hover img{transform:scale(1.12)}.gallery-hover{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.72) 0%,rgba(0,0,0,.1) 40%,transparent 100%);opacity:0;transition:opacity .35s ease;display:flex;align-items:flex-end;padding:1.5rem}.gallery-item:hover .gallery-hover{opacity:1}.gallery-hover-info span{color:#fff;font-size:.92rem;font-weight:600}.gallery-zoom{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%) scale(.7);width:48px;height:48px;background:rgba(255,255,255,.2);backdrop-filter:blur(10px);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.05rem;transition:transform .35s ease}.gallery-item:hover .gallery-zoom{transform:translate(-50%,-50%) scale(1)}
        .nova-footer{background:#0f172a;color:rgba(255,255,255,.7);padding:3rem 1.5rem 1.5rem}.footer-bottom{border-top:1px solid rgba(255,255,255,.08);padding-top:1.5rem;text-align:center;font-size:.82rem}.footer-grid{display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr;gap:2.5rem;margin-bottom:3rem}@media(max-width:768px){.footer-grid{grid-template-columns:1fr;text-align:center}}.footer-brand{display:flex;align-items:center;gap:.65rem;margin-bottom:1rem}.footer-brand img{height:40px}.footer-brand .brand-icon{width:38px;height:38px;background:var(--gradient);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1rem}.footer-brand span{font-weight:700;color:#fff;font-size:1.1rem}.footer-col h4{color:#fff;font-weight:700;font-size:1rem;margin-bottom:1.25rem}.footer-col ul li{margin-bottom:.65rem}.footer-col ul li a{font-size:.88rem;color:rgba(255,255,255,.6)}.footer-col ul li a:hover{color:#fff}.whatsapp-float{position:fixed;bottom:24px;<?=$isRtl?'left':'right'?>:24px;z-index:1000;width:56px;height:56px;background:#25d366;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.6rem;box-shadow:0 4px 24px rgba(37,211,102,.4)}
    @media (max-width: 480px) { .footer-grid { gap: 1.5rem; } }
    </style>
</head>
<body>
<nav class="nova-navbar"><div class="container">
    <a href="<?=url($siteBase)?>" class="nav-brand"><?php if(!empty($tenant->logo)):?><img src="<?=upload($tenant->logo)?>" alt=""><?php else:?><div class="brand-icon"><i class="fas fa-gem"></i></div><?php endif;?><span><?=htmlspecialchars($tenant->site_name)?></span></a>
    <ul class="nav-links" id="navLinks"><?php if(!empty($menu)):foreach($menu as$item):?><?php $navHref=$siteBase;$s=strtolower($item->slug??'');if($item->is_home==1)$navHref=$siteBase;elseif(strpos($s,'about')!==false)$navHref=$siteBase.'/about';elseif(strpos($s,'service')!==false)$navHref=$siteBase.'/services';elseif(strpos($s,'gallery')!==false)$navHref=$siteBase.'/gallery';elseif(strpos($s,'contact')!==false)$navHref=$siteBase.'/contact';elseif(strpos($s,'faq')!==false)$navHref=$siteBase.'/faq';elseif(strpos($s,'partner')!==false)$navHref=$siteBase.'/partners';elseif(strpos($s,'book')!==false)$navHref=$siteBase.'/booking';elseif(strpos($s,'blog')!==false)$navHref=$siteBase.'/blog';else $navHref=$siteBase.'/'.$item->slug;?><li><a href="<?=url($navHref)?>"><?=htmlspecialchars(localized($item, 'title') ?: $item->title ?? '')?></a></li><?php endforeach;endif;?></ul>
    <div style="display:flex;align-items:center;gap:.5rem;"><a href="<?=url($siteBase.'?lang='.Language::opposite())?>" class="lang-switch"><i class="fas fa-globe"></i> <?=Language::opposite()==='en'?'EN':'عربي'?></a><button class="mobile-btn" id="mobileBtn"><i class="fas fa-bars"></i></button></div>
</div></nav>
<div class="page-hero"><h1><?=lang('gallery')?></h1><p><?=lang('gallery_subtitle')?></p><div class="breadcrumb"><a href="<?=url($siteBase)?>"><?=lang('home')?></a><span>/</span><span class="current"><?=lang('gallery')?></span></div></div>
<div class="gallery-section"><div class="container">
    <?php if(count($galleryCategories)>1):?>
    <div class="gallery-filters">
        <button class="gallery-filter-btn active" data-filter="all"><?=lang('all')?></button>
        <?php foreach($galleryCategories as$cat):?><button class="gallery-filter-btn" data-filter="<?=htmlspecialchars($cat)?>"><?=htmlspecialchars($cat)?></button><?php endforeach;?>
    </div>
    <?php endif;?>
    <?php if(!empty($gallery)):?>
    <div class="gallery-grid"><?php foreach($gallery as$g):?>
        <div class="gallery-item" data-category="<?=htmlspecialchars($g->category??'general')?>">
            <img src="<?=upload($g->image)?>" alt="<?=htmlspecialchars(localized($g, 'title') ?: $g->title ?? '')?>" loading="lazy">
            <div class="gallery-hover"><div class="gallery-zoom"><i class="fas fa-search-plus"></i></div><div class="gallery-hover-info"><span><?=htmlspecialchars(localized($g, 'title') ?: $g->title ?? '')?></span></div></div>
        </div>
    <?php endforeach;?></div>
    <?php else:?><div style="text-align:center;padding:4rem 0;color:var(--text-secondary);"><i class="fas fa-images" style="font-size:3rem;margin-bottom:1rem;color:var(--primary-50);"></i><p><?=lang('no_gallery')?></p></div><?php endif;?>
</div></div>
<footer class="nova-footer"><div class="container"><div class="footer-grid">
    <div><div class="footer-brand"><?php if(!empty($tenant->logo)):?><img src="<?=upload($tenant->logo)?>" alt=""><?php else:?><div class="brand-icon"><i class="fas fa-gem"></i></div><?php endif;?><span><?=htmlspecialchars($tenant->site_name)?></span></div></div>
    <div class="footer-col"><h4><?=lang('quick_links')?></h4><ul><li><a href="<?=url($siteBase)?>"><?=lang('home')?></a></li><li><a href="<?=url($siteBase.'/about')?>"><?=lang('about_us')?></a></li><li><a href="<?=url($siteBase.'/services')?>"><?=lang('our_services')?></a></li></ul></div>
    <div class="footer-col"><h4><?=lang('more_pages')?></h4><ul><li><a href="<?=url($siteBase.'/faq')?>"><?=lang('faq')?></a></li><li><a href="<?=url($siteBase.'/contact')?>"><?=lang('contact_us')?></a></li></ul></div>
    <div class="footer-col"><h4><?=lang('contact_info')?></h4><ul><?php if(!empty($tenant->contact_phone)):?><li><a href="tel:<?=$tenant->contact_phone?>" dir="ltr"><?=$tenant->contact_phone?></a></li><?php endif;?></ul></div>
</div><div class="footer-bottom"><p>&copy; <?=date('Y')?> <?=htmlspecialchars($tenant->site_name)?>. <?=lang('all_rights_reserved')?></p></div></div></footer>
<?php if(!empty($tenant->contact_whatsapp)):?><a href="https://wa.me/<?=preg_replace('/[^0-9]/','',$tenant->contact_whatsapp)?>" class="whatsapp-float" target="_blank"><i class="fab fa-whatsapp"></i></a><?php endif;?>
<script>document.getElementById('mobileBtn').addEventListener('click',function(){document.getElementById('navLinks').classList.toggle('open');this.querySelector('i').classList.toggle('fa-bars');this.querySelector('i').classList.toggle('fa-times');});document.querySelectorAll('.gallery-filter-btn').forEach(function(b){b.addEventListener('click',function(){document.querySelectorAll('.gallery-filter-btn').forEach(function(x){x.classList.remove('active')});this.classList.add('active');var f=this.dataset.filter;document.querySelectorAll('.gallery-item').forEach(function(i){if(f==='all'||i.dataset.category===f)i.classList.remove('hidden-item');else i.classList.add('hidden-item');});});});</script>
</body>
</html>
