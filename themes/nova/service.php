<?php
/**
 * Theme: Nova - Single Service Page
 */
$lang = Language::current(); $dir = Language::direction(); $isRtl = $dir === 'rtl';
$themePrimary = $tenant->primary_color ?? '#6366f1';
$themeSecondary = $tenant->secondary_color ?? '#4f46e5';
$siteBase = '/site/' . $tenant->slug;
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= localized($service, 'title') ?: $service->title ?? '' ?> - <?= $tenant->site_name ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap<?= $isRtl ? '.rtl' : '' ?>.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=<?= $isRtl ? 'Cairo:wght@300;400;500;600;700;800;900' : 'Poppins:wght@300;400;500;600;700;800;900' ?>&display=swap" rel="stylesheet">
    <style>
        :root{--primary:<?=$themePrimary?>;--primary-dark:<?=$themeSecondary?>;--gradient:linear-gradient(135deg,var(--primary) 0%,var(--primary-dark) 100%);--radius:12px;--radius-lg:20px;--text:#1a1a2e;--text-secondary:#4a4a6a;--bg-alt:#f8f9fc;--border-light:#f0f1f7;--shadow:0 4px 20px rgba(0,0,0,.07);--shadow-lg:0 16px 48px rgba(0,0,0,.12);--shadow-primary:0 8px 32px color-mix(in srgb,var(--primary) 25%,transparent);--primary-50:color-mix(in srgb,var(--primary) 6%,white);--font:'<?= $isRtl?'Cairo':'Poppins'?>',system-ui,sans-serif;--transition:all .35s cubic-bezier(.4,0,.2,1)}
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}html{scroll-behavior:smooth}body{font-family:var(--font);color:var(--text);background:#fff;line-height:1.7}a{text-decoration:none;color:inherit;transition:var(--transition)}img{max-width:100%;height:auto;display:block}ul{list-style:none}.container{max-width:1200px;margin:0 auto;padding:0 1.5rem}
        .nova-navbar{background:rgba(255,255,255,.78);backdrop-filter:blur(24px);position:fixed;width:100%;top:0;z-index:1050;border-bottom:1px solid var(--border-light)}.nova-navbar .container{display:flex;align-items:center;justify-content:space-between;height:76px}.nav-brand{display:flex;align-items:center;gap:.65rem;font-weight:800;font-size:1.2rem;color:var(--primary)}.nav-brand img{height:44px;border-radius:8px}.nav-brand .brand-icon{width:42px;height:42px;background:var(--gradient);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.15rem}.nav-links{display:flex;align-items:center;gap:.1rem}.nav-links>li>a{padding:.5rem .85rem;border-radius:8px;font-weight:500;font-size:.9rem;color:var(--text-secondary)}.nav-links>li>a:hover{color:var(--primary);background:var(--primary-50)}.nav-cta{background:var(--primary)!important;color:#fff!important;font-weight:600!important;padding:.55rem 1.4rem!important;border-radius:var(--radius)!important}.lang-switch{display:inline-flex;align-items:center;gap:.35rem;padding:.45rem .85rem!important;border:1.5px solid var(--border-light)!important;border-radius:8px!important;font-size:.8rem!important;font-weight:600!important;color:var(--text-secondary)!important}.mobile-btn{display:none;background:none;border:none;font-size:1.35rem;cursor:pointer;color:var(--text);width:42px;height:42px}@media(max-width:992px){.mobile-btn{display:flex;align-items:center;justify-content:center}.nav-links{display:none;position:absolute;top:100%;left:0;right:0;background:#fff;flex-direction:column;padding:.75rem;box-shadow:var(--shadow-lg)}.nav-links.open{display:flex}}
        .page-hero{background:var(--gradient);padding:8rem 1.5rem 4rem;text-align:center}.page-hero h1{color:#fff;font-size:clamp(2rem,4vw,3rem);font-weight:800;margin-bottom:.75rem}.page-hero p{color:rgba(255,255,255,.8);font-size:1.1rem;max-width:600px;margin:0 auto}.breadcrumb{display:flex;justify-content:center;gap:.5rem;margin-top:1.5rem}.breadcrumb a{color:rgba(255,255,255,.7);font-size:.88rem}.breadcrumb span{color:rgba(255,255,255,.5);font-size:.88rem}.breadcrumb .current{color:#fff;font-weight:600;font-size:.88rem}
        .service-detail{padding:5rem 1.5rem}.service-detail-grid{display:grid;grid-template-columns:1.5fr 1fr;gap:3rem;align-items:start}@media(max-width:768px){.service-detail-grid{grid-template-columns:1fr}}.service-detail h2{font-size:1.8rem;font-weight:800;margin-bottom:1rem}.service-detail p{color:var(--text-secondary);font-size:.95rem;line-height:1.85;margin-bottom:1.25rem}.service-detail-img{border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow-lg);position:sticky;top:100px}.service-detail-img img{width:100%;height:400px;object-fit:cover}.service-sidebar{background:var(--bg-alt);border-radius:var(--radius-lg);padding:2rem;border:1px solid var(--border-light)}.sidebar-item{display:flex;align-items:center;gap:.75rem;padding:1rem 0;border-bottom:1px solid var(--border-light)}.sidebar-item:last-child{border-bottom:none}.sidebar-icon{width:40px;height:40px;min-width:40px;background:var(--primary-50);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:.9rem}
        .related-services{padding:3rem 1.5rem 5rem}.related-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem}.related-card{background:var(--bg-alt);border-radius:var(--radius-lg);padding:1.75rem;border:1px solid var(--border-light);transition:var(--transition)}.related-card:hover{transform:translateY(-5px);box-shadow:var(--shadow);border-color:transparent}.related-card h3{font-size:1rem;font-weight:700;margin-bottom:.5rem}.related-card p{color:var(--text-secondary);font-size:.88rem;line-height:1.7}.related-card .link-btn{display:inline-flex;align-items:center;gap:.4rem;color:var(--primary);font-weight:600;font-size:.88rem;margin-top:.75rem}
        .nova-footer{background:#0f172a;color:rgba(255,255,255,.7);padding:3rem 1.5rem 1.5rem}.footer-bottom{border-top:1px solid rgba(255,255,255,.08);padding-top:1.5rem;text-align:center;font-size:.82rem}.footer-grid{display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr;gap:2.5rem;margin-bottom:3rem}@media(max-width:768px){.footer-grid{grid-template-columns:1fr;text-align:center}}.footer-brand{display:flex;align-items:center;gap:.65rem;margin-bottom:1rem}.footer-brand img{height:40px}.footer-brand .brand-icon{width:38px;height:38px;background:var(--gradient);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1rem}.footer-brand span{font-weight:700;color:#fff;font-size:1.1rem}.footer-desc{font-size:.88rem;line-height:1.8;margin-bottom:1.5rem}.footer-col h4{color:#fff;font-weight:700;font-size:1rem;margin-bottom:1.25rem}.footer-col ul li{margin-bottom:.65rem}.footer-col ul li a{font-size:.88rem;color:rgba(255,255,255,.6)}.footer-col ul li a:hover{color:#fff}.whatsapp-float{position:fixed;bottom:24px;<?=$isRtl?'left':'right'?>:24px;z-index:1000;width:56px;height:56px;background:#25d366;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.6rem;box-shadow:0 4px 24px rgba(37,211,102,.4)}
    @media (max-width: 480px) { .footer-grid { gap: 1.5rem; } }
    </style>
</head>
<body>
<nav class="nova-navbar"><div class="container">
    <a href="<?=url($siteBase)?>" class="nav-brand"><?php if(!empty($tenant->logo)):?><img src="<?=upload($tenant->logo)?>" alt=""><?php else:?><div class="brand-icon"><i class="fas fa-gem"></i></div><?php endif;?><span><?=htmlspecialchars($tenant->site_name)?></span></a>
    <ul class="nav-links" id="navLinks"><?php if(!empty($menu)):foreach($menu as$item):?><?php $navHref=$siteBase;$s=strtolower($item->slug??'');$slugRaw=$item->slug??'';if($item->is_home==1)$navHref=$siteBase;elseif(strpos($s,'about')!==false||strpos($slugRaw,'من نحن')!==false||strpos($slugRaw,'حول')!==false||strpos($slugRaw,'عن')!==false)$navHref=$siteBase.'/about';elseif(strpos($s,'service')!==false||strpos($slugRaw,'خدمات')!==false)$navHref=$siteBase.'/services';elseif(strpos($s,'gallery')!==false||strpos($slugRaw,'معرض')!==false)$navHref=$siteBase.'/gallery';elseif(strpos($s,'contact')!==false||strpos($slugRaw,'اتصل')!==false)$navHref=$siteBase.'/contact';elseif(strpos($s,'faq')!==false||strpos($slugRaw,'سؤال')!==false)$navHref=$siteBase.'/faq';elseif(strpos($s,'partner')!==false||strpos($slugRaw,'شريك')!==false)$navHref=$siteBase.'/partners';elseif(strpos($s,'book')!==false||strpos($slugRaw,'حجز')!==false)$navHref=$siteBase.'/booking';elseif(strpos($s,'blog')!==false||strpos($slugRaw,'مدونة')!==false)$navHref=$siteBase.'/blog';else $navHref=$siteBase.'/'.$item->slug;?><li><a href="<?=url($navHref)?>"><?=htmlspecialchars(localized($item, 'title') ?: $item->title ?? '')?></a></li><?php endforeach;endif;?></ul>
    <div style="display:flex;align-items:center;gap:.5rem;"><a href="<?=url($siteBase.'?lang='.Language::opposite())?>" class="lang-switch"><i class="fas fa-globe"></i> <?=Language::opposite()==='en'?'EN':'عربي'?></a><button class="mobile-btn" id="mobileBtn"><i class="fas fa-bars"></i></button></div>
</div></nav>

<div class="page-hero">
    <h1><?=htmlspecialchars(localized($service, 'title') ?: $service->title ?? '')?></h1>
    <p><?=htmlspecialchars(localized($service, 'description') ?: $service->description ?? '')?></p>
    <div class="breadcrumb"><a href="<?=url($siteBase)?>"><?=lang('home')?></a><span>/</span><a href="<?=url($siteBase.'/services')?>"><?=lang('our_services')?></a><span>/</span><span class="current"><?=htmlspecialchars(localized($service, 'title') ?: $service->title ?? '')?></span></div>
</div>

<div class="service-detail">
    <div class="container">
        <div class="service-detail-grid">
            <div>
                <h2><?=htmlspecialchars(localized($service, 'title') ?: $service->title ?? '')?></h2>
                <?php if(!empty($service->price)||!empty($service->price_text)):?>
                <p style="font-size:1.2rem;font-weight:700;color:var(--primary);margin-bottom:1.5rem;"><?=htmlspecialchars($service->price_text??$service->price??'')?></p>
                <?php endif;?>
                <p><?=nl2br(htmlspecialchars(localized($service, 'description') ?: $service->description ?? ''))?></p>
                <div style="margin-top:2rem;"><a href="<?=url($siteBase.'/contact')?>" style="display:inline-flex;align-items:center;gap:.5rem;padding:.85rem 2rem;background:var(--gradient);color:#fff;border-radius:var(--radius);font-weight:700;font-family:var(--font);box-shadow:var(--shadow-primary);"><i class="fas fa-paper-plane"></i> <?=lang('contact_us')?></a></div>
            </div>
            <div>
                <?php if(!empty($service->image)):?>
                <div class="service-detail-img"><img src="<?=upload($service->image)?>" alt="<?=htmlspecialchars(localized($service, 'title') ?: $service->title ?? '')?>"></div>
                <?php else:?>
                <div class="service-sidebar">
                    <div class="sidebar-item"><div class="sidebar-icon"><i class="fas fa-phone"></i></div><div><strong><?=lang('phone')?></strong><br><?=htmlspecialchars($tenant->contact_phone??'')?></div></div>
                    <div class="sidebar-item"><div class="sidebar-icon"><i class="fas fa-envelope"></i></div><div><strong><?=lang('email')?></strong><br><?=htmlspecialchars($tenant->contact_email??'')?></div></div>
                    <div class="sidebar-item"><div class="sidebar-icon"><i class="fas fa-clock"></i></div><div><strong><?=lang('working_hours')?></strong><br><?=htmlspecialchars($tenant->working_hours??'')?></div></div>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>

<?php if(!empty($related_services)):?>
<div class="related-services">
    <div class="container">
        <h2 style="text-align:center;font-weight:800;margin-bottom:2.5rem;font-size:1.6rem;"><?=lang('related_services')?></h2>
        <div class="related-grid">
            <?php foreach(array_slice($related_services,0,3) as$rs):?>
            <div class="related-card">
                <h3><?=htmlspecialchars(localized($rs, 'title') ?: $rs->title ?? '')?></h3>
                <p><?=htmlspecialchars(mb_substr(localized($rs, 'description') ?: $rs->description ?? '',0,120))?></p>
                <?php if(!empty($rs->slug)):?><a href="<?=url($siteBase.'/service/'.$rs->slug)?>" class="link-btn"><?=lang('read_more')?> <i class="fas fa-arrow-<?= $isRtl ? 'left' : 'right' ?>"></i></a><?php endif;?>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<?php endif;?>

<footer class="nova-footer"><div class="container">
    <div class="footer-grid">
        <div><div class="footer-brand"><?php if(!empty($tenant->logo)):?><img src="<?=upload($tenant->logo)?>" alt=""><?php else:?><div class="brand-icon"><i class="fas fa-gem"></i></div><?php endif;?><span><?=htmlspecialchars($tenant->site_name)?></span></div><p class="footer-desc"><?=htmlspecialchars($tenant->meta_description)?></p></div>
        <div class="footer-col"><h4><?=lang('quick_links')?></h4><ul><li><a href="<?=url($siteBase)?>"><?=lang('home')?></a></li><li><a href="<?=url($siteBase.'/about')?>"><?=lang('about_us')?></a></li><li><a href="<?=url($siteBase.'/services')?>"><?=lang('our_services')?></a></li></ul></div>
        <div class="footer-col"><h4><?=lang('more_pages')?></h4><ul><li><a href="<?=url($siteBase.'/gallery')?>"><?=lang('gallery')?></a></li><li><a href="<?=url($siteBase.'/faq')?>"><?=lang('faq')?></a></li><li><a href="<?=url($siteBase.'/contact')?>"><?=lang('contact_us')?></a></li></ul></div>
        <div class="footer-col"><h4><?=lang('contact_info')?></h4><ul><?php if(!empty($tenant->contact_phone)):?><li><a href="tel:<?=$tenant->contact_phone?>" dir="ltr"><?=$tenant->contact_phone?></a></li><?php endif;?><li><a href="mailto:<?=htmlspecialchars($tenant->contact_email??'')?>"><?=htmlspecialchars($tenant->contact_email??'')?></a></li></ul></div>
    </div>
    <div class="footer-bottom"><p>&copy; <?=date('Y')?> <?=htmlspecialchars($tenant->site_name)?>. <?=lang('all_rights_reserved')?></p></div>
</div></footer>
<?php if(!empty($tenant->contact_whatsapp)):?><a href="https://wa.me/<?=preg_replace('/[^0-9]/','',$tenant->contact_whatsapp)?>" class="whatsapp-float" target="_blank"><i class="fab fa-whatsapp"></i></a><?php endif;?>
<script>document.getElementById('mobileBtn').addEventListener('click',function(){document.getElementById('navLinks').classList.toggle('open');this.querySelector('i').classList.toggle('fa-bars');this.querySelector('i').classList.toggle('fa-times');});</script>
</body>
</html>
