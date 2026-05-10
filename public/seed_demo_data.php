<?php
/**
 * ============================================================================
 *  Takween CMS — Demo Data Seeder (All 12 Themes, Self-Contained)
 * ============================================================================
 *  Usage:  php seed_demo_data.php   (CLI or browser)
 * ============================================================================
 */
declare(strict_types=1);

function green(string $m): void  { echo "\033[32m{$m}\033[0m\n"; }
function red(string $m): void    { echo "\033[31m{$m}\033[0m\n"; }
function cyan(string $m): void   { echo "\033[36m{$m}\033[0m\n"; }
function bold(string $m): void   { echo "\033[1m{$m}\033[0m\n"; }

$host='localhost'; $dbname='takween'; $user='root'; $pass='';
try {
    $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4",$user,$pass,
        [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES=>false]);
    green("✓ Connected to `{$dbname}`.");
} catch (PDOException $e) { red("✗ DB error: ".$e->getMessage()); exit(1); }

try {
    $pdo->exec("DELETE FROM theme_media");   green("✓ Cleared theme_media.");
    $pdo->exec("DELETE FROM theme_contents"); green("✓ Cleared theme_contents.");
} catch (PDOException $e) { red("✗ Clean error: ".$e->getMessage()); exit(1); }

$totalC=0; $totalM=0; $now=date('Y-m-d H:i:s');

$stmtC = $pdo->prepare("INSERT INTO theme_contents (theme_id,section_type,content_key,content_ar,content_en,sort_order,is_active,created_at,updated_at) VALUES (?,?,?,?,?,?,1,?,?)");
$stmtM = $pdo->prepare("INSERT INTO theme_media (theme_id,media_type,file_path,file_name,alt_text_ar,alt_text_en,section_ref,sort_order,is_active,created_at) VALUES (?,?,?,?,?,?,?,?,1,?)");

function insText(int $t,string $s,string $k,string $ar,string $en,int $o=0):void {
    global $stmtC,$totalC,$now; $stmtC->execute([$t,$s,$k,$ar,$en,$o,$now,$now]); $totalC++;
}
function insJson(int $t,string $s,string $k,array $d,int $o=0):void {
    global $stmtC,$totalC,$now; $j=json_encode($d,JSON_UNESCAPED_UNICODE);
    $stmtC->execute([$t,$s,$k,$j,$j,$o,$now,$now]); $totalC++;
}
function insMedia(int $t,string $tp,string $fp,string $fn,string $aa,string $ae,?string $sr,int $o=0):void {
    global $stmtM,$totalM,$now; $stmtM->execute([$t,$tp,$fp,$fn,$aa,$ae,$sr,$o,$now]); $totalM++;
}

function seedTheme(int $tid, array $t): void {
    $slug=$t['slug'];
    insText($tid,'hero','hero_title',$t['hero_title'],$t['hero_title_en'],1);
    insText($tid,'hero','hero_subtitle',$t['hero_subtitle'],$t['hero_subtitle_en'],2);
    insText($tid,'hero','hero_description',$t['hero_description'],$t['hero_description_en'],3);
    insText($tid,'hero','hero_button_text',$t['hero_button_text'],$t['hero_button_text_en'],4);
    insText($tid,'about','about_title',$t['about_title'],$t['about_title_en'],1);
    insText($tid,'about','about_content',$t['about_content'],$t['about_content_en'],2);
    foreach($t['services'] as $i=>$s) insJson($tid,'services','service_'.($i+1),$s,$i+1);
    foreach($t['testimonials'] as $i=>$x) insJson($tid,'testimonials','testimonial_'.($i+1),$x,$i+1);
    insJson($tid,'contact','contact_info',$t['contact'],1);
    foreach($t['features'] as $i=>$f) insJson($tid,'features','feature_'.($i+1),$f,$i+1);
    foreach($t['stats'] as $i=>$s) insJson($tid,'stats','stat_'.($i+1),$s,$i+1);
    foreach($t['faq'] as $i=>$q) insJson($tid,'faq','faq_'.($i+1),$q,$i+1);
    // Media
    insMedia($tid,'logo',"themes/{$slug}/assets/images/logo.png",'logo.png',$t['name_ar'].' - شعار',$t['name_en'].' Logo','hero',1);
    insMedia($tid,'banner',"themes/{$slug}/assets/images/hero-banner.jpg",'hero-banner.jpg',$t['name_ar'].' - بنر',$t['name_en'].' Banner','hero',2);
    for($i=0;$i<6;$i++){
        $n=$i+1; $lb=urlencode($t['services'][$i]['title_ar']??'Service '.$n);
        insMedia($tid,'service_image',"https://placehold.co/600x400/e2e8f0/475569?text={$lb}","service-{$n}.jpg",
            ($t['services'][$i]['title_ar']??"خدمة {$n}"),($t['services'][$i]['title_en']??"Service {$n}"),'service_'.$n,$n);
    }
    $gc=$t['gallery_color'];
    for($i=0;$i<6;$i++){$n=$i+1; insMedia($tid,'gallery',"https://placehold.co/600x400/{$gc}/ffffff?text=Gallery+{$n}","gallery-{$n}.jpg","معرض صور {$n}","Gallery {$n}",null,$n);}
    for($i=0;$i<4;$i++){$n=$i+1; insMedia($tid,'partner',"https://placehold.co/200x80/f1f5f9/64748b?text=Partner+{$n}","partner-{$n}.png","شريك {$n}","Partner {$n}",null,$n);}
}

// ══════════════════════════════════════════════════════════════════════
//  ALL 12 THEMES DATA
// ══════════════════════════════════════════════════════════════════════
$themes = [

// ─── Theme 1: General ─────────────────────────────────────────────
1 => [
'slug'=>'general','name_ar'=>'خدمات عامة','name_en'=>'General Services','gallery_color'=>'6366f1',
'hero_title'=>'حلول متكاملة لجميع احتياجاتك','hero_title_en'=>'Integrated Solutions for All Your Needs',
'hero_subtitle'=>'شريكك الموثوق في تقديم الخدمات المهنية','hero_subtitle_en'=>'Your Trusted Professional Services Partner',
'hero_description'=>'نقدم مجموعة واسعة من الخدمات المهنية عالية الجودة التي تلبي احتياجات الأفراد والشركات على حد سواء. فريقنا من الخبراء يعمل بشغف لتحقيق رضاكم التام.','hero_description_en'=>'We offer a wide range of high-quality professional services for individuals and businesses alike. Our experts work passionately to achieve your complete satisfaction.',
'hero_button_text'=>'تواصل معنا','hero_button_text_en'=>'Contact Us',
'about_title'=>'من نحن','about_title_en'=>'About Us',
'about_content'=>'تأسست شركة خدمات عامة عام ٢٠١٥ على يد نخبة من المتخصصين في مجالات متعددة، بهدف تقديم خدمات احترافية متكاملة تلبي تطلعات العملاء في السوق السعودي. نؤمن بأن النجاح يبدأ من الثقة والالتزام بأعلى معايير الجودة. فريقنا المكون من أكثر من ١٠٠ متخصص يعمل بتناغم لتقديم حلول مبتكرة تتجاوز توقعات عملائنا.','about_content_en'=>'Founded in 2015 by a group of specialists, our company aims to provide integrated professional services in the Saudi market. We believe success starts with trust and commitment to quality. Our 100+ specialists work in harmony to deliver innovative solutions.',
'services'=>[
['title_ar'=>'استشارات الأعمال','title_en'=>'Business Consulting','description_ar'=>'نقدم استشارات استراتيجية شاملة تساعد الشركات على اتخاذ قرارات مدروسة لتحقيق النمو المستدام. يعمل خبراؤنا على تحليل السوق وتقييم الفرص وتطوير خطط العمل.','description_en'=>'We provide comprehensive strategic consulting helping companies make informed decisions for sustainable growth through market analysis and business planning.','icon'=>'fas fa-briefcase','show_on_home'=>1],
['title_ar'=>'إدارة المشاريع','title_en'=>'Project Management','description_ar'=>'نتولى إدارة مشاريعكم من التخطيط وحتى التنفيذ بكفاءة واحترافية عالية. نضمن إنجاز المشاريع في الوقت المحدد وضمن الميزانية المعتمدة.','description_en'=>'We manage your projects from planning to execution with high efficiency and professionalism, ensuring timely delivery within budget.','icon'=>'fas fa-clipboard-check','show_on_home'=>1],
['title_ar'=>'التسويق الرقمي','title_en'=>'Digital Marketing','description_ar'=>'نساعدكم على بناء حضور رقمي قوي وزيادة الوصول إلى جمهوركم المستهدف عبر استراتيجيات تسويقية متكاملة ومبتكرة قائمة على البيانات.','description_en'=>'We help build a strong digital presence and reach your target audience through integrated, data-driven marketing strategies.','icon'=>'fas fa-chart-line','show_on_home'=>1],
['title_ar'=>'التدريب والتطوير','title_en'=>'Training & Development','description_ar'=>'نقدم برامج تدريبية متخصصة صُممت لتطوير مهارات فرق العمل ورفع كفاءتهم المهنية بما يتماشى مع متطلبات السوق المتغيرة.','description_en'=>'Specialized training programs designed to develop team skills and enhance professional competencies aligned with evolving market needs.','icon'=>'fas fa-users','show_on_home'=>1],
['title_ar'=>'خدمات الدعم الفني','title_en'=>'Technical Support','description_ar'=>'فريق دعم فني متخصص جاهز لمساعدتكم على مدار الساعة لحل جميع المشكلات التقنية وتقديم الحلول الفورية والفعالة.','description_en'=>'A specialized technical support team available 24/7 to resolve all technical issues with immediate effective solutions.','icon'=>'fas fa-headset','show_on_home'=>1],
['title_ar'=>'إدارة الموارد البشرية','title_en'=>'HR Management','description_ar'=>'نوفر حلول متكاملة لإدارة الموارد البشرية تشمل التوظيف والتدريب وتقييم الأداء وتطوير السياسات التنظيمية للشركات.','description_en'=>'Comprehensive HR solutions including recruitment, training, performance evaluation, and organizational policy development.','icon'=>'fas fa-handshake','show_on_home'=>1],
],
'testimonials'=>[
['client_name'=>'محمد العتيبي','client_title'=>'مدير تنفيذي','client_title_en'=>'CEO','content'=>'تعاملت مع شركة خدمات عامة في عدة مشاريع وكانت النتائج مبهرة. فريق محترف وملتزم بالمواعيد والجودة العالية.','content_en'=>'Impressive results across multiple projects. Professional team committed to deadlines and high quality.','rating'=>5],
['client_name'=>'سارة الشمري','client_title'=>'مديرة التسويق','client_title_en'=>'Marketing Director','content'=>'استراتيجية التسويق الرقمي التي قدموها ساهمت في زيادة مبيعاتنا بنسبة ٤٠٪ خلال ثلاثة أشهر فقط.','content_en'=>'Their digital marketing strategy increased our sales by 40% in just three months.','rating'=>5],
['client_name'=>'خالد الدوسري','client_title'=>'رائد أعمال','client_title_en'=>'Entrepreneur','content'=>'أنصح بشدة بالتعاقد معهم. ساعدوني في تأسيس شركتي من الصفر وأرشدوني إلى الطريق الصحيح.','content_en'=>'Highly recommended. They helped me establish my company from scratch.','rating'=>5],
['client_name'=>'نورة القحطاني','client_title'=>'مديرة عمليات','client_title_en'=>'Operations Manager','content'=>'خدمة ممتازة ونتائج تفوق التوقعات. الفريق يتميز بالخبرة والاحترافية العالية في جميع التعاملات.','content_en'=>'Excellent service exceeding expectations. Highly experienced and professional team.','rating'=>5],
],
'contact'=>['phone'=>'+966501234567','whatsapp'=>'+966501234567','email'=>'info@generalservices.sa','address'=>'الرياض، حي العليا، المملكة العربية السعودية','working_hours'=>'السبت - الخميس: 8 صباحاً - 6 مساءً'],
'features'=>[
['title_ar'=>'خبرة واسعة','title_en'=>'Extensive Experience','description_ar'=>'أكثر من ٨ سنوات من الخبرة المتراكمة في تقديم الخدمات المهنية المتنوعة للقطاعين العام والخاص.','description_en'=>'Over 8 years of accumulated experience delivering diverse professional services to public and private sectors.','icon'=>'fas fa-trophy'],
['title_ar'=>'فريق متخصص','title_en'=>'Specialized Team','description_ar'=>'فريق من أكثر من ١٠٠ متخصص في مختلف المجالات المهنية يجمعون بين الخبرة والابتكار.','description_en'=>'A team of over 100 specialists across various fields combining experience with innovation.','icon'=>'fas fa-users'],
['title_ar'=>'حلول مبتكرة','title_en'=>'Innovative Solutions','description_ar'=>'نستخدم أحدث الأساليب والتقنيات لتقديم حلول إبداعية وفعالة تواكب التطورات العالمية.','description_en'=>'Latest methods and technologies for creative solutions aligned with global developments.','icon'=>'fas fa-cogs'],
['title_ar'=>'التزام بالمواعيد','title_en'=>'Deadline Commitment','description_ar'=>'نحترم المواعيد المحددة ونلتزم بتسليم المشاريع في وقتها دون أي تأخير.','description_en'=>'We respect deadlines and deliver projects on time without any delays.','icon'=>'fas fa-clock'],
['title_ar'=>'أسعار تنافسية','title_en'=>'Competitive Prices','description_ar'=>'خدمات عالية الجودة بأسعار تنافسية تناسب جميع الميزانيات مع خطط مرنة للدفع.','description_en'=>'High-quality services at competitive prices with flexible payment plans.','icon'=>'fas fa-medal'],
['title_ar'=>'دعم متواصل','title_en'=>'Continuous Support','description_ar'=>'دعم فني ومهني متواصل لعملائنا حتى بعد انتهاء المشروع لضمان النجاح والاستمرارية.','description_en'=>'Continuous technical and professional support even after project completion.','icon'=>'fas fa-headset'],
],
'stats'=>[
['label_ar'=>'عميل سعيد','label_en'=>'Happy Clients','value'=>'+500','icon'=>'fas fa-users'],
['label_ar'=>'مشروع منجز','label_en'=>'Projects Done','value'=>'+1,200','icon'=>'fas fa-clipboard-check'],
['label_ar'=>'سنة خبرة','label_en'=>'Years Experience','value'=>'+8','icon'=>'fas fa-clock'],
['label_ar'=>'متخصص','label_en'=>'Specialists','value'=>'+100','icon'=>'fas fa-star'],
],
'faq'=>[
['question_ar'=>'ما هي الخدمات التي تقدمونها؟','question_en'=>'What services do you offer?','answer_ar'=>'نقدم مجموعة شاملة تشمل استشارات الأعمال، إدارة المشاريع، التسويق الرقمي، التدريب والتطوير، الدعم الفني، وإدارة الموارد البشرية.','answer_en'=>'We offer business consulting, project management, digital marketing, training, tech support, and HR management.','category'=>'عام'],
['question_ar'=>'كيف يمكنني طلب خدمة؟','question_en'=>'How can I request a service?','answer_ar'=>'تواصلوا معنا عبر نموذج الاتصال أو الهاتف أو البريد الإلكتروني وسيقوم فريقنا بالرد خلال ٢٤ ساعة.','answer_en'=>'Contact us via the form, phone, or email. Our team responds within 24 hours.','category'=>'عام'],
['question_ar'=>'هل تقدمون خدمات عن بُعد؟','question_en'=>'Do you offer remote services?','answer_ar'=>'نعم، نقدم الاستشارات والتسويق الرقمي والدعم الفني والتدريب الإلكتروني عن بُعد.','answer_en'=>'Yes, we offer remote consulting, digital marketing, tech support, and e-training.','category'=>'عام'],
['question_ar'=>'ما هي سياسة التسعير لديكم؟','question_en'=>'What is your pricing policy?','answer_ar'=>'أسعار تنافسية ومخصصة حسب طبيعة كل مشروع مع عرض سعر تفصيلي بعد دراسة المتطلبات.','answer_en'=>'Competitive customized pricing with a detailed quote after studying requirements.','category'=>'عام'],
['question_ar'=>'هل توفرون ضماناً على الخدمات؟','question_en'=>'Do you guarantee your services?','answer_ar'=>'نعم، ضمان شامل على جميع خدماتنا مع فترة دعم مجانية بعد التسليم.','answer_en'=>'Yes, comprehensive guarantee with a free post-delivery support period.','category'=>'عام'],
['question_ar'=>'كم يستغرق تنفيذ المشروع؟','question_en'=>'How long does a project take?','answer_ar'=>'تختلف المدة حسب حجم المشروع. نضع جدولاً زمنياً واضحاً قبل البدء بالتنفيذ.','answer_en'=>'Duration varies by project size. We set a clear timeline before starting.','category'=>'عام'],
],
],

// ─── Theme 2: Electric ────────────────────────────────────────────
2 => [
'slug'=>'electric','name_ar'=>'كهرباء الموثوق','name_en'=>'Reliable Electric','gallery_color'=>'eab308',
'hero_title'=>'حلول كهربائية متقدمة وموثوقة','hero_title_en'=>'Advanced & Reliable Electrical Solutions',
'hero_subtitle'=>'خبرة تُنير مستقبلك','hero_subtitle_en'=>'Experience That Lights Up Your Future',
'hero_description'=>'شركة رائدة في مجال الخدمات الكهربائية بفريق هندسي متخصص يقدم حلولاً مبتكرة للمنشآت السكنية والتجارية والصناعية بأعلى معايير السلامة.','hero_description_en'=>'A leading electrical services company with a specialized engineering team delivering innovative solutions for residential, commercial, and industrial facilities with the highest safety standards.',
'hero_button_text'=>'احجز موعد الآن','hero_button_text_en'=>'Book Now',
'about_title'=>'من نحن','about_title_en'=>'About Us',
'about_content'=>'تأسست كهرباء الموثوق عام ٢٠١٢ على يد مهندسين متخصصين في الأنظمة الكهربائية. نمتلك رخصة تصنيف متقدمة من الجهات المختصة ونعمل وفق أحدث المعايير الفنية الدولية. فريقنا يضم نخبة من المهندسين والفنيين المعتمدين ذوي الخبرة الواسعة في تصميم وتنفيذ وصيانة الأنظمة الكهربائية المعقدة مما جعلنا الخيار الأول لأكبر المشاريع في المملكة.','about_content_en'=>'Founded in 2012 by electrical engineering specialists. We hold an advanced classification license and work according to the latest international standards. Our team of certified engineers and technicians has extensive experience in complex electrical systems.',
'services'=>[
['title_ar'=>'التمديدات الكهربائية','title_en'=>'Electrical Wiring','description_ar'=>'خدمات تمديدات كهربائية احترافية للمنازل والمباني التجارية والصناعية وفق أحدث المواصفات الفنية وبروتوكولات السلامة المعتمدة دولياً.','description_en'=>'Professional electrical wiring for residential, commercial, and industrial buildings per latest international safety protocols.','icon'=>'fas fa-plug','show_on_home'=>1],
['title_ar'=>'لوحات التحكم والتوزيع','title_en'=>'Control Panels','description_ar'=>'تصميم وتركيب وصيانة لوحات التحكم والتوزيع الكهربائية بكفاءة عالية باستخدام مكونات عالمية معتمدة.','description_en'=>'Design, installation and maintenance of electrical control panels using certified global components.','icon'=>'fas fa-bolt','show_on_home'=>1],
['title_ar'=>'أنظمة الإضاءة الذكية','title_en'=>'Smart Lighting','description_ar'=>'أنظمة إضاءة ذكية متطورة تدمج بين التوفير في استهلاك الطاقة والجماليات المعمارية مع إمكانية التحكم عن بُعد.','description_en'=>'Advanced smart lighting combining energy efficiency with architectural aesthetics and remote control capabilities.','icon'=>'fas fa-lightbulb','show_on_home'=>1],
['title_ar'=>'أنظمة الطاقة الشمسية','title_en'=>'Solar Energy','description_ar'=>'تركيب وصيانة أنظمة الطاقة الشمسية المتكاملة لتقليل فواتير الكهرباء والمساهمة في الاستدامة البيئية.','description_en'=>'Integrated solar energy installation and maintenance to reduce electricity bills and support environmental sustainability.','icon'=>'fas fa-solar-panel','show_on_home'=>1],
['title_ar'=>'الكشف عن الأعطال','title_en'=>'Fault Detection','description_ar'=>'تشخيص وإصلاح الأعطال الكهربائية باستخدام أحدث الأجهزة والتقنيات لضمان حل جذري وسريع ومنع التكرار.','description_en'=>'Fault diagnosis and repair using latest technologies for root-cause resolution and prevention.','icon'=>'fas fa-tools','show_on_home'=>1],
['title_ar'=>'الحماية من الصواعق','title_en'=>'Lightning Protection','description_ar'=>'تصميم وتنفيذ أنظمة حماية متكاملة من الصواعق والارتفاعات المفاجئة لحماية المنشآت والمعدات.','description_en'=>'Comprehensive lightning and surge protection system design to safeguard facilities and equipment.','icon'=>'fas fa-shield-halved','show_on_home'=>1],
],
'testimonials'=>[
['client_name'=>'فهد المطيري','client_title'=>'مالك مجمع تجاري','client_title_en'=>'Commercial Complex Owner','content'=>'تنفيذ التمديدات الكهربائية للمجمع بشكل ممتاز. العمل دقيق والنتائج تفوق التوقعات بمراحل.','content_en'=>'Excellent electrical wiring execution. Precise work far exceeding expectations.','rating'=>5],
['client_name'=>'عبدالله الحربي','client_title'=>'مدير مصنع','client_title_en'=>'Factory Manager','content'=>'أنظمة الطاقة الشمسية خفضت فاتورة الكهرباء بنسبة ٣٥٪. استثمار ممتاز حقق عائد سريع.','content_en'=>'Solar systems reduced our electricity bill by 35%. Excellent investment with quick returns.','rating'=>5],
['client_name'=>'منى السبيعي','client_title'=>'مصممة داخلي','client_title_en'=>'Interior Designer','content'=>'تعاون مميز مع فريق الإضاءة الذكية. ساعدونا في تحقيق رؤيتنا التصميمية بشكل احترافي.','content_en'=>'Great collaboration with the smart lighting team. They professionally realized our design vision.','rating'=>5],
['client_name'=>'سلطان العنزي','client_title'=>'مهندس مدني','client_title_en'=>'Civil Engineer','content'=>'من أفضل شركات الكهرباء التي تعاملت معها. احترافية عالية والتزام صارم بالمعايير والمواعيد.','content_en'=>'One of the best electrical companies. High professionalism and strict adherence to standards.','rating'=>5],
],
'contact'=>['phone'=>'+966509876543','whatsapp'=>'+966509876543','email'=>'info@reliablelectric.sa','address'=>'الرياض، حي الملقا، المملكة العربية السعودية','working_hours'=>'السبت - الخميس: 7 صباحاً - 8 مساءً'],
'features'=>[
['title_ar'=>'فريق هندسي معتمد','title_en'=>'Certified Engineers','description_ar'=>'مهندسون وفنيون معتمدون من الجهات الرسمية بخبرة واسعة في أحدث الأنظمة الكهربائية الحديثة.','description_en'=>'Officially certified engineers and technicians with extensive experience in modern electrical systems.','icon'=>'fas fa-certificate'],
['title_ar'=>'معايير سلامة عالمية','title_en'=>'Global Safety Standards','description_ar'=>'نلتزم بتطبيق أعلى معايير السلامة العالمية في جميع أعمالنا الكهربائية دون استثناء.','description_en'=>'We adhere to the highest international safety standards in all electrical work without exception.','icon'=>'fas fa-shield-halved'],
['title_ar'=>'ضمان شامل','title_en'=>'Comprehensive Warranty','description_ar'=>'ضمان شامل على جميع الأعمال يصل إلى ٥ سنوات مع خدمة صيانة دورية منتظمة مجانية.','description_en'=>'Warranty up to 5 years with free regular scheduled maintenance service.','icon'=>'fas fa-check-circle'],
['title_ar'=>'خدمة طوارئ ٢٤/٧','title_en'=>'24/7 Emergency','description_ar'=>'فريق طوارئ متخصص جاهز للتدخل الفوري في أي وقت للتعامل مع الأعطال الكهربائية الطارئة.','description_en'=>'Specialized emergency team ready for immediate intervention for urgent electrical faults.','icon'=>'fas fa-clock'],
['title_ar'=>'أسعار شفافة','title_en'=>'Transparent Pricing','description_ar'=>'عروض أسعار تفصيلية وشفافة بدون رسوم خفية أو تكاليف إضافية غير متوقعة.','description_en'=>'Detailed transparent quotes with no hidden fees or unexpected additional costs.','icon'=>'fas fa-file-contract'],
['title_ar'=>'مكونات عالمية','title_en'=>'Premium Components','description_ar'=>'نستخدم مكونات من أرقى العلامات التجارية العالمية لضمان المتانة والكفاءة طويلة الأمد.','description_en'=>'Components from the finest global brands ensuring long-term durability and efficiency.','icon'=>'fas fa-star'],
],
'stats'=>[
['label_ar'=>'مشروع كهربائي','label_en'=>'Electrical Projects','value'=>'+2,500','icon'=>'fas fa-bolt'],
['label_ar'=>'عميل راضٍ','label_en'=>'Satisfied Clients','value'=>'+800','icon'=>'fas fa-users'],
['label_ar'=>'مهندس معتمد','label_en'=>'Certified Engineers','value'=>'+60','icon'=>'fas fa-certificate'],
['label_ar'=>'سنة خبرة','label_en'=>'Years Experience','value'=>'+12','icon'=>'fas fa-trophy'],
],
'faq'=>[
['question_ar'=>'هل تمتلكون ترخيصاً من البلدية؟','question_en'=>'Do you have a municipal license?','answer_ar'=>'نعم، نمتلك ترخيصاً من وزارة الشؤون البلدية بتصنيف متقدم في الأعمال الكهربائية.','answer_en'=>'Yes, licensed by the Ministry of Municipal Affairs with advanced electrical classification.','category'=>'تراخيص'],
['question_ar'=>'هل تقدمون خدمات طوارئ كهربائية؟','question_en'=>'Do you offer emergency services?','answer_ar'=>'نعم، لدينا فريق طوارئ يعمل على مدار الساعة طوال أيام الأسبوع للتعامل مع الحالات الطارئة.','answer_en'=>'Yes, our 24/7 emergency team handles all urgent situations.','category'=>'خدمات'],
['question_ar'=>'ما أنواع المنشآت التي تخدمونها؟','question_en'=>'What types of facilities do you serve?','answer_ar'=>'نخدم منشآت سكنية وتجارية وصناعية وحكومية وتربوية وصحية بأحجام مختلفة.','answer_en'=>'We serve residential, commercial, industrial, governmental, educational, and healthcare facilities.','category'=>'عام'],
['question_ar'=>'هل توفرون صيانة دورية؟','question_en'=>'Do you offer regular maintenance?','answer_ar'=>'نعم، نقدم عقود صيانة دورية شاملة تشمل الفحص والتفتيش والصيانة الوقائية.','answer_en'=>'Yes, comprehensive maintenance contracts with inspection and preventive care.','category'=>'صيانة'],
['question_ar'=>'ما مدة الضمان على الأعمال؟','question_en'=>'What is the warranty period?','answer_ar'=>'ضمان يصل إلى ٥ سنوات على جميع الأعمال الكهربائية مع إمكانية تمديد فترة الضمان.','answer_en'=>'Warranty up to 5 years with extension option available.','category'=>'ضمان'],
['question_ar'=>'هل يمكنكم تصميم أنظمة مخصصة؟','question_en'=>'Can you design custom systems?','answer_ar'=>'نعم، لدينا قسم هندسي متخصص يحول متطلباتكم إلى أنظمة كهربائية مخصصة وفعالة.','answer_en'=>'Yes, our specialized engineering department designs customized electrical systems.','category'=>'تصميم'],
],
],

// ─── Theme 3: Cleaning ────────────────────────────────────────────
3 => [
'slug'=>'cleaning','name_ar'=>'نضارة','name_en'=>'Nadara Cleaning','gallery_color'=>'22c55e',
'hero_title'=>'نظافة لا مثيل لها لمنزلك ومكتبك','hero_title_en'=>'Unmatched Cleanliness for Your Home & Office',
'hero_subtitle'=>'نحن نجعل النظافة فناً','hero_subtitle_en'=>'We Make Cleaning an Art',
'hero_description'=>'شركة نضارة المتخصصة في تقديم خدمات التنظيف الاحترافية باستخدام أحدث المعدات ومنظفات صديقة للبيئة لضمان بيئة نظيفة وصحية.','hero_description_en'=>'Nadara specializes in professional cleaning services using the latest equipment and eco-friendly products to ensure a clean and healthy environment.',
'hero_button_text'=>'احجز خدمة الآن','hero_button_text_en'=>'Book Service Now',
'about_title'=>'من نحن','about_title_en'=>'About Us',
'about_content'=>'تأسست نضارة عام ٢٠١٤ لتقديم حلول تنظيف متكاملة ترتقي بمعايير النظافة في المملكة. نؤمن بأن البيئة النظيفة أساس الصحة والإنتاجية. نستخدم أحدث المعدات ومنظفات آمنة وصديقة للبيئة. فريقنا المدرب يضمن نتائج استثنائية في كل مرة وقد حصلنا على ثقة أكبر الشركات والمستشفيات والفنادق.','about_content_en'=>'Founded in 2014 to provide integrated cleaning solutions elevating hygiene standards in the Kingdom. We believe a clean environment is the foundation of health and productivity. Our trained team guarantees exceptional results every time.',
'services'=>[
['title_ar'=>'تنظيف المنازل','title_en'=>'Home Cleaning','description_ar'=>'تنظيف شامل للمنازل يشمل الغرف والمطابخ والحمامات باستخدام أحدث المعدات ومنظفات آمنة على صحة الأسرة.','description_en'=>'Comprehensive home cleaning covering rooms, kitchens, and bathrooms with family-safe products.','icon'=>'fas fa-home','show_on_home'=>1],
['title_ar'=>'تنظيف المكاتب','title_en'=>'Office Cleaning','description_ar'=>'تنظيف احترافي للمكاتب والمراكز التجارية يحافظ على بيئة عمل نظيفة وصحية تعزز الإنتاجية اليومية.','description_en'=>'Professional office cleaning maintaining a healthy work environment that boosts daily productivity.','icon'=>'fas fa-building','show_on_home'=>1],
['title_ar'=>'تنظيف السجاد والموكيت','title_en'=>'Carpet Cleaning','description_ar'=>'تقنيات البخار والشفط العميق لإزالة البقع والأوساخ والروائح من جميع أنواع السجاد والموكيت.','description_en'=>'Steam and deep-vacuum technologies to remove stains, dirt, and odors from all carpet types.','icon'=>'fas fa-broom','show_on_home'=>1],
['title_ar'=>'تنظيف الواجهات والزجاج','title_en'=>'Glass & Facade Cleaning','description_ar'=>'تنظيف محترف للزجاج والواجهات الخارجية بتقنيات التسلق الآمنة ومواد تنظيف متخصصة.','description_en'=>'Professional glass and facade cleaning using safe climbing techniques and specialized products.','icon'=>'fas fa-spray-can','show_on_home'=>1],
['title_ar'=>'تنظيف ما بعد البناء','title_en'=>'Post-Construction Cleaning','description_ar'=>'تنظيف متخصص بعد البناء والتشطيبات لإعداد المكان للاستخدام الفوري بشكل نظيف ومعقم بالكامل.','description_en'=>'Specialized post-construction cleaning to prepare spaces for immediate use, clean and fully sanitized.','icon'=>'fas fa-hard-hat','show_on_home'=>1],
['title_ar'=>'التعقيم ومكافحة الحشرات','title_en'=>'Disinfection & Pest Control','description_ar'=>'تعقيم شامل ومكافحة حشرات بمبيدات آمنة ومعتمدة لحماية المنزل والصحة العامة.','description_en'=>'Comprehensive disinfection and pest control using safe, approved products for health protection.','icon'=>'fas fa-shield-halved','show_on_home'=>1],
],
'testimonials'=>[
['client_name'=>'لمياء الزهراني','client_title'=>'ربة منزل','client_title_en'=>'Homemaker','content'=>'خدمة تنظيف المنزل ممتازة! الفريق منظم ومحترف والنتائج مذهلة. أنصح بهم بشدة لكل بيت.','content_en'=>'Excellent home cleaning! Organized, professional team with amazing results. Highly recommended.','rating'=>5],
['client_name'=>'تركي الغامدي','client_title'=>'مدير شركة','client_title_en'=>'Company Manager','content'=>'نعتمد على نضارة لتنظيف مكاتبنا أسبوعياً. خدمة موثوقة ونظافة عالية واتساق في الجودة.','content_en'=>'We rely on Nadara for weekly office cleaning. Reliable service with consistently high quality.','rating'=>5],
['client_name'=>'هند القرني','client_title'=>'مديرة فندق','client_title_en'=>'Hotel Manager','content'=>'بعد تجربة عدة شركات، وجدنا في نضارة الشريك المثالي. جودة عمل استثنائية واحترافية عالية.','content_en'=>'After trying several companies, Nadara is our ideal partner. Exceptional work quality.','rating'=>5],
['client_name'=>'أحمد المالكي','client_title'=>'مهندس معماري','client_title_en'=>'Architect','content'=>'تنظيف ما بعد البناء كان مذهلاً. حولوا الفوضى إلى مكان نظيف وجاهز للاستخدام الفوري.','content_en'=>'Post-construction cleaning was amazing. Transformed chaos into a clean, ready space.','rating'=>5],
],
'contact'=>['phone'=>'+966505551234','whatsapp'=>'+966505551234','email'=>'info@nadara.sa','address'=>'الرياض، حي النرجس، المملكة العربية السعودية','working_hours'=>'السبت - الخميس: 6 صباحاً - 10 مساءً'],
'features'=>[
['title_ar'=>'منظفات آمنة','title_en'=>'Safe Products','description_ar'=>'نستخدم منظفات صديقة للبيئة وآمنة على صحة الأطفال والحيوانات الأليفة ومعتمدة عالمياً.','description_en'=>'Eco-friendly, globally certified products safe for children and pets.','icon'=>'fas fa-leaf'],
['title_ar'=>'فريق مدرب','title_en'=>'Trained Team','description_ar'=>'فريق عمل مدرب على أحدث تقنيات التنظيف بمعايير عالمية مع مراجعة جودة مستمرة.','description_en'=>'Team trained on latest cleaning techniques with continuous quality reviews.','icon'=>'fas fa-users'],
['title_ar'=>'معدات متطورة','title_en'=>'Advanced Equipment','description_ar'=>'نستخدم أحدث المعدات والتقنيات العالمية في جميع خدماتنا لضمان أفضل النتائج.','description_en'=>'Latest global equipment and technologies ensuring optimal results.','icon'=>'fas fa-cogs'],
['title_ar'=>'مرونة في المواعيد','title_en'=>'Flexible Scheduling','description_ar'=>'نوفر مرونة كاملة في تحديد المواعيد بما يناسب جدولكم مع خدمة في نفس اليوم.','description_en'=>'Full scheduling flexibility including same-day service availability.','icon'=>'fas fa-clock'],
['title_ar'=>'أسعار منافسة','title_en'=>'Competitive Rates','description_ar'=>'خدمات تنظيف بأسعار تنافسية دون التنازل عن الجودة مع عروض خاصة للعقود.','description_en'=>'Competitive prices without compromising quality, with contract specials.','icon'=>'fas fa-medal'],
['title_ar'=>'ضمان الرضا','title_en'=>'Satisfaction Guarantee','description_ar'=>'نضمن رضاكم التام عن الخدمة وإلا نعيد التنظيف مجاناً خلال ٢٤ ساعة.','description_en'=>'Full satisfaction guarantee or we re-clean free within 24 hours.','icon'=>'fas fa-check-circle'],
],
'stats'=>[
['label_ar'=>'منزل تم تنظيفه','label_en'=>'Homes Cleaned','value'=>'+3,000','icon'=>'fas fa-home'],
['label_ar'=>'عميل سعيد','label_en'=>'Happy Clients','value'=>'+1,500','icon'=>'fas fa-users'],
['label_ar'=>'سنة خبرة','label_en'=>'Years Experience','value'=>'+10','icon'=>'fas fa-clock'],
['label_ar'=>'فني مدرب','label_en'=>'Trained Staff','value'=>'+80','icon'=>'fas fa-star'],
],
'faq'=>[
['question_ar'=>'ما المنظفات التي تستخدمونها؟','question_en'=>'What products do you use?','answer_ar'=>'نستخدم منظفات عالمية معتمدة صديقة للبيئة وآمنة على صحة الأسرة والحيوانات الأليفة.','answer_en'=>'We use certified eco-friendly products safe for the entire family and pets.','category'=>'عام'],
['question_ar'=>'هل يمكن حجز خدمة في نفس اليوم؟','question_en'=>'Can I book same-day service?','answer_ar'=>'نعم، نوفر خدمة الطوارئ مع إمكانية الحجز في نفس اليوم حسب التوفر.','answer_en'=>'Yes, emergency service with same-day booking based on availability.','category'=>'حجز'],
['question_ar'=>'كم تستغرق خدمة تنظيف المنزل؟','question_en'=>'How long does home cleaning take?','answer_ar'=>'تختلف المدة حسب المساحة. شقة عادية تستغرق ٣-٥ ساعات بعمل كامل.','answer_en'=>'Duration varies by size. A typical apartment takes 3-5 hours.','category'=>'عام'],
['question_ar'=>'هل تقدمون عقود تنظيف شهرية؟','question_en'=>'Do you offer monthly contracts?','answer_ar'=>'نعم، نقدم عقود شهرية وسنوية بأسعار خاصة وخصومات مميزة تصل إلى ٢٠٪.','answer_en'=>'Yes, monthly and yearly contracts with special prices and up to 20% discounts.','category'=>'أسعار'],
['question_ar'=>'هل يعملون أثناء وجودنا في المنزل؟','question_en'=>'Do they work while we are home?','answer_ar'=>'بالتأكيد، فريقنا محترف ويمكنه العمل بحضوركم أو بدون حسب رغبتكم.','answer_en'=>'Absolutely, our professional team can work with or without you present.','category'=>'عام'],
['question_ar'=>'هل تتعاملون مع المنشآت الكبيرة؟','question_en'=>'Do you handle large facilities?','answer_ar'=>'نعم، لدينا فرق متخصصة للفنادق والمستشفيات والمراكز التجارية والمصانع.','answer_en'=>'Yes, we have specialized teams for hotels, hospitals, malls, and factories.','category'=>'خدمات'],
],
],

// ─── Theme 4: Decor ──────────────────────────────────────────────
4 => [
'slug'=>'decor','name_ar'=>'أثر الديكور','name_en'=>'Athar Decor','gallery_color'=>'f97316',
'hero_title'=>'نحوّل مساحاتك إلى تحف فنية','hero_title_en'=>'Transform Your Spaces into Masterpieces',
'hero_subtitle'=>'حيث يلتقي الفن بالوظيفة','hero_subtitle_en'=>'Where Art Meets Function',
'hero_description'=>'شركة أثر الديكور الرائدة في تصميم وتنفيذ الديكورات الداخلية والخارجية بلمسات عصرية فاخرة تعكس ذوقكم الرفيع.','hero_description_en'=>'Athar Decor leads in interior and exterior design with luxurious modern touches reflecting your refined taste.',
'hero_button_text'=>'استشر مصممنا','hero_button_text_en'=>'Consult Our Designer',
'about_title'=>'من نحن','about_title_en'=>'About Us',
'about_content'=>'تأسست شركة أثر الديكور عام ٢٠١٣ على يد مصممين سعوديين مبدعين جمعوا بين الأصالة العربية والحداثة العالمية. نقدم حلولاً ديكورية متكاملة تشمل التصميم الداخلي والخارجي وتنسيق الحدائق والأثاث المخصص. فريقنا يضم أكثر من ٥٠ مصمماً ومهندساً ونفخر بتنفيذ أكثر من ٨٠٠ مشروع في جميع أنحاء المملكة.','about_content_en'=>'Founded in 2013 by creative Saudi designers blending Arabic authenticity with global modernity. Our 50+ designers and engineers have completed over 800 projects across the Kingdom.',
'services'=>[
['title_ar'=>'التصميم الداخلي','title_en'=>'Interior Design','description_ar'=>'تصميم داخلي مبتكر يجمع بين الجماليات والوظيفة. نقدم نماذج ثلاثية الأبعاد ومخططات تنفيذية مفصلة.','description_en'=>'Innovative interior design with 3D models and detailed execution plans.','icon'=>'fas fa-paint-roller','show_on_home'=>1],
['title_ar'=>'التصميم الخارجي','title_en'=>'Exterior Design','description_ar'=>'تصاميم خارجية عصرية تمنح منشأتكم هوية معمارية فريدة وتتناغم مع البيئة المحيطة.','description_en'=>'Modern exterior designs giving your property a unique architectural identity.','icon'=>'fas fa-building','show_on_home'=>1],
['title_ar'=>'تنسيق الحدائق','title_en'=>'Landscaping','description_ar'=>'تصميم وتنفيذ حدائق ومساحات خضراء خلابة تضيف لمسة طبيعية وجمالية لمنشأتكم.','description_en'=>'Design and execution of stunning gardens and green spaces.','icon'=>'fas fa-leaf','show_on_home'=>1],
['title_ar'=>'الأثاث المخصص','title_en'=>'Custom Furniture','description_ar'=>'تصميم وتصنيع أثاث فريد حسب طلبكم بأعلى جودة من الخشب الطبيعي والمواد الفاخرة.','description_en'=>'Bespoke furniture design and manufacturing with premium natural materials.','icon'=>'fas fa-couch','show_on_home'=>1],
['title_ar'=>'إدارة المشاريع الديكورية','title_en'=>'Project Management','description_ar'=>'إدارة شاملة لجميع مراحل المشروع من التصميم حتى التسليم مع الالتزام بالميزانية والجدول الزمني.','description_en'=>'Full project management from design to delivery within budget and timeline.','icon'=>'fas fa-clipboard-check','show_on_home'=>1],
['title_ar'=>'تجديد وترميم','title_en'=>'Renovation','description_ar'=>'خدمات تجديد وترميم المساحات القائمة لتحويلها إلى بيئات عصرية ومريحة وعملية.','description_en'=>'Renovation services transforming existing spaces into modern, comfortable environments.','icon'=>'fas fa-tools','show_on_home'=>1],
],
'testimonials'=>[
['client_name'=>'ريم العبدالله','client_title'=>'سيدة أعمال','client_title_en'=>'Businesswoman','content'=>'حولوا فيلتي إلى قصر حلم. كل التفاصيل كانت مدروسة بعناية فائقة. عمل فني بكل المقاييس.','content_en'=>'They transformed my villa into a dream palace. Every detail meticulously planned.','rating'=>5],
['client_name'=>'بندر السعيد','client_title'=>'مالك سلسلة مطاعم','client_title_en'=>'Restaurant Chain Owner','content'=>'تصميم المطاعم كان مذهلاً وزاد من عدد الزوار بنسبة كبيرة. احترافية لا مثيل لها.','content_en'=>'Stunning restaurant design that significantly increased visitors. Unmatched professionalism.','rating'=>5],
['client_name'=>'مشاعل الحميد','client_title'=>'طبيبة','client_title_en'=>'Doctor','content'=>'أحببت كيف جمعوا بين الطابع العربي والعصري في تصميم عيادتي. شكراً لفريق أثر الديكور.','content_en'=>'Loved how they blended Arabic and modern styles in my clinic design.','rating'=>5],
['client_name'=>'ناصر الفيصل','client_title'=>'رجل أعمال','client_title_en'=>'Businessman','content'=>'تجربة مميزة من البداية للنهاية. الإدارة المنظمة والإبداع في التصميم جعلانا سعداء.','content_en'=>'Exceptional experience from start to finish. Organized management and creative design.','rating'=>5],
],
'contact'=>['phone'=>'+966503336677','whatsapp'=>'+966503336677','email'=>'info@athardecor.sa','address'=>'الرياض، حي الملز، المملكة العربية السعودية','working_hours'=>'السبت - الخميس: 9 صباحاً - 7 مساءً'],
'features'=>[
['title_ar'=>'مصممون مبدعون','title_en'=>'Creative Designers','description_ar'=>'فريق من أكثر من ٥٠ مصمماً ومهندساً ذوي خبرة وإبداع في التصميم الداخلي والخارجي.','description_en'=>'50+ designers and engineers with expertise in interior and exterior design.','icon'=>'fas fa-palette'],
['title_ar'=>'مواد فاخرة','title_en'=>'Premium Materials','description_ar'=>'نستخدم أرقى المواد من أفضل المصادر العالمية لضمان جودة ومتانة لا مثيل لها.','description_en'=>'Finest materials from top global sources for unmatched quality and durability.','icon'=>'fas fa-gem'],
['title_ar'=>'نماذج ثلاثية الأبعاد','title_en'=>'3D Visualization','description_ar'=>'نقدم نماذج ثلاثية الأبعاد دقيقة قبل البدء بالتنفيذ لتتمكنوا من تصور النتيجة النهائية.','description_en'=>'Accurate 3D models before execution so you can visualize the final result.','icon'=>'fas fa-cube'],
['title_ar'=>'التزام بالميزانية','title_en'=>'Budget Commitment','description_ar'=>'نلتزم بالميزانية المحددة دون أي تكاليف مخفية مع شفافية كاملة في التعامل.','description_en'=>'Committed to the agreed budget with full transparency and no hidden costs.','icon'=>'fas fa-file-invoice-dollar'],
['title_ar'=>'ضمان الجودة','title_en'=>'Quality Guarantee','description_ar'=>'ضمان شامل على جميع أعمال الديكور والتنفيذ مع متابعة ما بعد التسليم.','description_en'=>'Comprehensive warranty on all decoration work with post-delivery follow-up.','icon'=>'fas fa-check-circle'],
['title_ar'=>'تسليم بالمفتاح','title_en'=>'Turnkey Delivery','description_ar'=>'نتولى جميع مراحل المشروع من التصميم حتى التسليم النهائي الجاهز للاستخدام.','description_en'=>'We handle all project phases from design to final turnkey delivery.','icon'=>'fas fa-key'],
],
'stats'=>[
['label_ar'=>'مشروع منجز','label_en'=>'Projects Completed','value'=>'+800','icon'=>'fas fa-clipboard-check'],
['label_ar'=>'عميل سعيد','label_en'=>'Happy Clients','value'=>'+600','icon'=>'fas fa-users'],
['label_ar'=>'مصمم ومهندس','label_en'=>'Designers & Engineers','value'=>'+50','icon'=>'fas fa-drafting-compass'],
['label_ar'=>'سنة خبرة','label_en'=>'Years Experience','value'=>'+11','icon'=>'fas fa-trophy'],
],
'faq'=>[
['question_ar'=>'كم تستغرق عملية التصميم الداخلي؟','question_en'=>'How long does interior design take?','answer_ar'=>'تختلف المدة حسب حجم المشروع. عادة من ٢-٤ أسابيع للتصميم ومن ١-٣ أشهر للتنفيذ.','answer_en'=>'Duration varies by project size. Typically 2-4 weeks for design and 1-3 months for execution.','category'=>'عام'],
['question_ar'=>'هل تقدمون استشارات مجانية؟','question_en'=>'Do you offer free consultations?','answer_ar'=>'نعم، نقدم استشارة أولية مجانية مع زيارة الموقع لفهم متطلباتكم ورؤيتكم.','answer_en'=>'Yes, a free initial consultation with site visit to understand your requirements.','category'=>'استشارات'],
['question_ar'=>'هل يمكنكم العمل ضمن ميزانية محددة؟','question_en'=>'Can you work within a set budget?','answer_ar'=>'بالتأكيد، نقدم حلولاً مرنة تناسب مختلف الميزانيات مع الحفاظ على الجودة العالية.','answer_en'=>'Absolutely, we offer flexible solutions for different budgets while maintaining quality.','category'=>'أسعار'],
['question_ar'=>'هل تتعاملون مع المشاريع خارج الرياض؟','question_en'=>'Do you work outside Riyadh?','answer_ar'=>'نعم، ننفذ مشاريع في جميع مناطق المملكة العربية السعودية.','answer_en'=>'Yes, we execute projects across all regions of Saudi Arabia.','category'=>'خدمات'],
['question_ar'=>'ما المواد التي تستخدمونها؟','question_en'=>'What materials do you use?','answer_ar'=>'نستخدم مواد فاخرة من أفضل المصادر العالمية مع شهادات جودة ومعايير بيئية.','answer_en'=>'Premium materials from top global sources with quality certifications.','category'=>'مواد'],
['question_ar'=>'هل توفرون خدمة صيانة بعد التسليم؟','question_en'=>'Do you offer post-delivery maintenance?','answer_ar'=>'نعم، نوفر خدمة صيانة وتحديث دورية لضمان استمرارية جودة الديكور.','answer_en'=>'Yes, we provide regular maintenance and update services for lasting quality.','category'=>'صيانة'],
],
],

// ─── Theme 5: Maintenance ────────────────────────────────────────
5 => [
'slug'=>'maintenance','name_ar'=>'صيانة المستقبل','name_en'=>'Future Maintenance','gallery_color'=>'0ea5e9',
'hero_title'=>'صيانة احترافية لكل ما تملك','hero_title_en'=>'Professional Maintenance for Everything You Own',
'hero_subtitle'=>'حماية استثماراتك بخبرة واحترافية','hero_subtitle_en'=>'Protecting Your Investments with Expertise',
'hero_description'=>'شركة صيانة المستقبل المتخصصة في تقديم خدمات الصيانة الشاملة للمنشآت السكنية والتجارية بفريق فني متعدد التخصصات وأحدث المعدات.','hero_description_en'=>'Future Maintenance specializes in comprehensive maintenance services for residential and commercial properties with a multi-specialty technical team.',
'hero_button_text'=>'اطلب صيانة الآن','hero_button_text_en'=>'Request Maintenance',
'about_title'=>'من نحن','about_title_en'=>'About Us',
'about_content'=>'تأسست شركة صيانة المستقبل عام ٢٠١٦ لتكون الوجهة الأولى لخدمات الصيانة المتكاملة في المملكة. نمتلك فريقاً من أكثر من ٢٠٠ فني متخصص في مختلف مجالات الصيانة. نستخدم أحدث المعدات والتقنيات لنضمن تقديم خدمات عالية الجودة وسريعة. نخدم آلاف العملاء من الأفراد والشركات والمؤسسات الحكومية ونسعى دائماً للتميز.','about_content_en'=>'Founded in 2016 to be the premier destination for integrated maintenance services. Our 200+ specialized technicians use the latest equipment and technology to deliver fast, high-quality service to thousands of clients.',
'services'=>[
['title_ar'=>'صيانة المكيفات','title_en'=>'AC Maintenance','description_ar'=>'صيانة وتنظيف وإصلاح جميع أنواع المكيفات والأنظمة المبردة بالكامل مع ضمان على قطع الغيار والأداء.','description_en'=>'Full service, cleaning, and repair for all AC types with parts and performance warranty.','icon'=>'fas fa-fan','show_on_home'=>1],
['title_ar'=>'صيانة السباكة','title_en'=>'Plumbing Services','description_ar'=>'كشف وإصلاح التسربات وتركيب الأنابيب والصنابير وأعطال المجاري بأسعار منافسة وضمان شامل.','description_en'=>'Leak detection, pipe installation, faucet and drain repair at competitive prices with warranty.','icon'=>'fas fa-faucet-drip','show_on_home'=>1],
['title_ar'=>'صيانة الكهرباء','title_en'=>'Electrical Services','description_ar'=>'فحص وصيانة جميع الأنظمة الكهربائية وإصلاح الأعطال وتركيب الإضاءة والتمديدات الجديدة.','description_en'=>'Inspection and maintenance of all electrical systems, fault repair, and new installations.','icon'=>'fas fa-bolt','show_on_home'=>1],
['title_ar'=>'أعمال الدهان','title_en'=>'Painting Services','description_ar'=>'دهان داخلي وخارجي بجميع أنواع الطلاء مع تجهيز الجدران واختيار الألوان المناسبة.','description_en'=>'Interior and exterior painting with all paint types, wall preparation, and color selection.','icon'=>'fas fa-paint-roller','show_on_home'=>1],
['title_ar'=>'أعمال النجارة','title_en'=>'Carpentry Services','description_ar'=>'تصنيع وتركيب الأبواب والخزائن والأثاث وإصلاح الأثاث الموجود بكفاءة عالية ومهارة.','description_en'=>'Door, cabinet, and furniture manufacturing, installation, and repair with high skill.','icon'=>'fas fa-hammer','show_on_home'=>1],
['title_ar'=>'صيانة عامة','title_en'=>'General Maintenance','description_ar'=>'خدمات صيانة شاملة تشمل إصلاح الأبواب والنوافذ والأقفال وتركيب الرفوف والأعمال المتنوعة.','description_en'=>'Comprehensive maintenance including door/window repair, lock installation, and various tasks.','icon'=>'fas fa-tools','show_on_home'=>1],
],
'testimonials'=>[
['client_name'=>'عمر السلمي','client_title'=>'مالك فيلا','client_title_en'=>'Villa Owner','content'=>'خدمة صيانة ممتازة وسريعة. فريق متخصص حل جميع مشاكل المكيفات والسباكة في زيارة واحدة.','content_en'=>'Excellent and fast maintenance. Specialized team solved all AC and plumbing issues in one visit.','rating'=>5],
['client_name'=>'مها العنزي','client_title'=>'مديرة مدرسة','client_title_en'=>'School Principal','content'=>'نعتمد على صيانة المستقبل لصيانة مدرستنا بشكل دوري. احترافية عالية ونتائج مذهلة.','content_en'=>'We rely on Future Maintenance for regular school maintenance. Highly professional with amazing results.','rating'=>5],
['client_name'=>'يوسف الشمري','client_title'=>'مدير شركة','client_title_en'=>'Company Director','content'=>'عقد صيانة شامل لمكاتبنا. وفرنا الكثير من الوقت والجهد مع ضمان جودة عالية.','content_en'=>'Comprehensive maintenance contract for our offices. Saved time and effort with high quality.','rating'=>5],
['client_name'=>'لطيفة الحربي','client_title'=>'ربة منزل','client_title_en'=>'Homemaker','content'=>'سرعة الاستجابة ممتازة والفني محترف ونظيف. أنصح بهم لجميع أعمال الصيانة.','content_en'=>'Excellent response time, professional and clean technician. Recommended for all maintenance work.','rating'=>5],
],
'contact'=>['phone'=>'+966506678899','whatsapp'=>'+966506678899','email'=>'info@futuremaintenance.sa','address'=>'جدة، حي الحمراء، المملكة العربية السعودية','working_hours'=>'السبت - الخميس: 7 صباحاً - 9 مساءً'],
'features'=>[
['title_ar'=>'استجابة سريعة','title_en'=>'Fast Response','description_ar'=>'نصل إليكم خلال ساعتين من طلب الخدمة مع فريق مجهز وجاهز للعمل الفوري.','description_en'=>'We arrive within 2 hours of your request with a fully equipped team.','icon'=>'fas fa-clock'],
['title_ar'=>'فنيون معتمدون','title_en'=>'Certified Technicians','description_ar'=>'جميع فنيينا حاصلون على شهادات معتمدة وخبرة عملية لا تقل عن ٥ سنوات.','description_en'=>'All technicians are certified with a minimum of 5 years of practical experience.','icon'=>'fas fa-id-badge'],
['title_ar'=>'ضمان شامل','title_en'=>'Comprehensive Warranty','description_ar'=>'ضمان على جميع أعمال الصيانة والإصلاح مع إمكانية إعادة الخدمة مجاناً عند الحاجة.','description_en'=>'Warranty on all maintenance and repair work with free re-service if needed.','icon'=>'fas fa-check-circle'],
['title_ar'=>'أسعار شفافة','title_en'=>'Transparent Pricing','description_ar'=>'أسعار ثابتة ومعروفة مسبقاً بدون مفاجآت أو رسوم إضافية غير متوقعة.','description_en'=>'Fixed, known prices upfront with no surprises or hidden additional fees.','icon'=>'fas fa-file-contract'],
['title_ar'=>'خدمة ٢٤/٧','title_en'=>'24/7 Service','description_ar'=>'خدمة طوارئ متاحة على مدار الساعة للأعطال العاجلة والحرجة.','description_en'=>'24/7 emergency service available for urgent and critical faults.','icon'=>'fas fa-headset'],
['title_ar'=>'معدات حديثة','title_en'=>'Modern Equipment','description_ar'=>'نستخدم أحدث المعدات والأدوات المتطورة لضمان سرعة ودقة وجودة العمل.','description_en'=>'Latest advanced equipment and tools ensuring speed, accuracy, and quality.','icon'=>'fas fa-cogs'],
],
'stats'=>[
['label_ar'=>'خدمة منجزة','label_en'=>'Services Completed','value'=>'+10,000','icon'=>'fas fa-wrench'],
['label_ar'=>'عميل سعيد','label_en'=>'Happy Clients','value'=>'+3,000','icon'=>'fas fa-users'],
['label_ar'=>'فني متخصص','label_en'=>'Specialized Technicians','value'=>'+200','icon'=>'fas fa-id-badge'],
['label_ar'=>'سنة خبرة','label_en'=>'Years Experience','value'=>'+8','icon'=>'fas fa-trophy'],
],
'faq'=>[
['question_ar'=>'ما هي أنواع الصيانة التي تقدمونها؟','question_en'=>'What maintenance types do you offer?','answer_ar'=>'نقدم صيانة مكيفات وسباكة وكهرباء ودهان ونجارة وصيانة عامة شاملة للمنشآت.','answer_en'=>'We offer AC, plumbing, electrical, painting, carpentry, and general maintenance services.','category'=>'عام'],
['question_ar'=>'كم تستغرق عملية إصلاح المكيف؟','question_en'=>'How long does AC repair take?','answer_ar'=>'عادة من ١-٣ ساعات حسب نوع العطل. نحاول دائماً الإنهاء في أسرع وقت ممكن.','answer_en'=>'Usually 1-3 hours depending on the fault. We always aim for the fastest resolution.','category'=>'صيانة'],
['question_ar'=>'هل تقدمون عقود صيانة دورية؟','question_en'=>'Do you offer periodic maintenance contracts?','answer_ar'=>'نعم، عقود شهرية وسنوية بأسعار خاصة تشمل زيارات مجدولة وفحص شامل.','answer_en'=>'Yes, monthly and yearly contracts with scheduled visits and comprehensive inspection.','category'=>'أسعار'],
['question_ar'=>'هل تقدمون خدمة طوارئ؟','question_en'=>'Do you offer emergency service?','answer_ar'=>'نعم، خدمة طوارئ ٢٤/٧ مع وصول الفني خلال ساعتين في معظم الحالات.','answer_en'=>'Yes, 24/7 emergency service with technician arrival within 2 hours in most cases.','category'=>'خدمات'],
['question_ar'=>'هل قطع الغيار أصلية؟','question_en'=>'Are spare parts original?','answer_ar'=>'نعم، نستخدم قطع غيار أصلية ومعتمدة مع ضمان على جميع القطع المركبة.','answer_en'=>'Yes, we use original, certified parts with warranty on all installed components.','category'=>'ضمان'],
['question_ar'=>'كيف يمكنني طلب خدمة؟','question_en'=>'How can I request service?','answer_ar'=>'يمكنكم الاتصال أو إرسال واتساب أو ملء نموذج الطلب في الموقع وسنرد فوراً.','answer_en'=>'Call, WhatsApp, or fill the request form on our website and we respond immediately.','category'=>'حجز'],
],
],

// ─── Theme 6: Plumbing ───────────────────────────────────────────
6 => [
'slug'=>'plumbing','name_ar'=>'سباكة الاحتراف','name_en'=>'Pro Plumbing','gallery_color'=>'0891b2',
'hero_title'=>'حلول سباكة موثوقة وسريعة','hero_title_en'=>'Reliable & Fast Plumbing Solutions',
'hero_subtitle'=>'خبرة طويلة في عالم السباكة','hero_subtitle_en'=>'Decades of Plumbing Expertise',
'hero_description'=>'سباكة الاحتراف هي شركتكم الأولى لحل جميع مشاكل السباكة بفريق من الفنيين المعتمدين وأحدث الأدوات والتقنيات مع ضمان شامل.','hero_description_en'=>'Pro Plumbing is your first choice for all plumbing issues with certified technicians, latest tools, and comprehensive warranty.',
'hero_button_text'=>'احجز فني الآن','hero_button_text_en'=>'Book a Plumber Now',
'about_title'=>'من نحن','about_title_en'=>'About Us',
'about_content'=>'سباكة الاحتراف شركة رائدة في مجال الخدمات الصحية تأسست عام ٢٠١٠ بخبرة تمتد لأكثر من ١٥ عاماً. نمتلك فريقاً من أمهر الفنيين والسباكين المعتمدين المدربين على أحدث التقنيات. نقدم حلولاً شاملة لجميع المشاكل الصحية من الكشف عن التسربات وتركيب الأنابيب إلى تصميم أنظمة الصرف الصحي الكاملة. نلتزم بأعلى معايير الجودة والسلامة.','about_content_en'=>'Pro Plumbing is a leading sanitary services company established in 2010 with over 15 years of experience. Our certified technicians are trained on the latest technologies for all plumbing solutions.',
'services'=>[
['title_ar'=>'كشف وإصلاح التسربات','title_en'=>'Leak Detection & Repair','description_ar'=>'خدمات كشف متقدمة عن التسربات المائية باستخدام أجهزة حديثة دقيقة مع إصلاح جذري وضمان عدم التكرار.','description_en'=>'Advanced leak detection using precise modern devices with root-cause repair and guarantee.','icon'=>'fas fa-search','show_on_home'=>1],
['title_ar'=>'تركيب الأنابيب','title_en'=>'Pipe Installation','description_ar'=>'تركيب جميع أنواع الأنابيب البلاستيكية والمعدنية للتمديدات المائية والصرف الصحي وفق المواصفات.','description_en'=>'Installation of all plastic and metal pipes for water supply and drainage per specifications.','icon'=>'fas fa-faucet-drip','show_on_home'=>1],
['title_ar'=>'صيانة سخانات المياه','title_en'=>'Water Heater Service','description_ar'=>'تركيب وصيانة وإصلاح جميع أنواع سخانات المياه الكهربائية والغازية والشماسية.','description_en'=>'Installation, maintenance, and repair of all electric, gas, and solar water heaters.','icon'=>'fas fa-temperature-high','show_on_home'=>1],
['title_ar'=>'تنظيف المجاري','title_en'=>'Drain Cleaning','description_ar'=>'تنظيف وانسداد المجاري والأنابيب بتقنيات الضغط العالي والكاميرا الحرارية للتشخيص الدقيق.','description_en'=>'Drain and pipe cleaning using high-pressure techniques and thermal camera diagnosis.','icon'=>'fas fa-water','show_on_home'=>1],
['title_ar'=>'ترميم الحمامات','title_en'=>'Bathroom Renovation','description_ar'=>'تجديد وترميم كامل للحمامات يشمل تغيير السيراميك والسباكة والأدوات الصحية بتصاميم عصرية.','description_en'=>'Complete bathroom renovation including tiles, plumbing, and sanitary fixtures with modern designs.','icon'=>'fas fa-bath','show_on_home'=>1],
['title_ar'=>'سباكة طوارئ','title_en'=>'Emergency Plumbing','description_ar'=>'خدمة سباكة طوارئ على مدار الساعة للتعامل مع الأعطال الحرجة كانفجار الأنابيب والفيضانات.','description_en'=>'24/7 emergency plumbing for critical issues like burst pipes and flooding.','icon'=>'fas fa-exclamation-triangle','show_on_home'=>1],
],
'testimonials'=>[
['client_name'=>'سلطان العتيبي','client_title'=>'مهندس مدني','client_title_en'=>'Civil Engineer','content'=>'كشفوا عن تسرب مائي مخفي باستخدام أجهزة حديثة وصلحوه بدقة عالية. عمل احترافي بكل المقاييس.','content_en'=>'Detected hidden water leak with modern devices and repaired it precisely. Professional work.','rating'=>5],
['client_name'=>'هند المالكي','client_title'=>'ربة منزل','client_title_en'=>'Homemaker','content'=>'فريق سباكة ممتاز حضر بسرعة وأنهى العمل باحترافية ونظافة. أنصح بهم بشدة.','content_en'=>'Excellent plumbing team arrived quickly and completed work professionally and cleanly.','rating'=>5],
['client_name'=>'فهد القرني','client_title'=>'مالك عمارة','client_title_en'=>'Building Owner','content'=>'تعاقدت معهم لصيانة السباكة في عمارتي بشكل دوري. وفرت عليّ الكثير من المشاكل.','content_en'=>'Hired them for periodic plumbing maintenance in my building. Saved me many problems.','rating'=>5],
['client_name'=>'نوف السبيعي','client_title'=>'مديرة فندق','client_title_en'=>'Hotel Manager','content'=>'خدمة طوارئ سريعة وموثوقة. حلوا مشكلة الفيضان في غرفة خلال ساعة واحدة فقط.','content_en'=>'Fast, reliable emergency service. Solved a room flooding issue in just one hour.','rating'=>5],
],
'contact'=>['phone'=>'+966507788990','whatsapp'=>'+966507788990','email'=>'info@proplumbing.sa','address'=>'الدمام، حي الشاطئ، المملكة العربية السعودية','working_hours'=>'السبت - الخميس: 7 صباحاً - 10 مساءً'],
'features'=>[
['title_ar'=>'فنيون معتمدون','title_en'=>'Certified Plumbers','description_ar'=>'جميع فنيينا حاصلون على شهادات فنية معتمدة وخبرة عملية تزيد عن ١٠ سنوات.','description_en'=>'All plumbers hold certified technical qualifications with 10+ years experience.','icon'=>'fas fa-id-badge'],
['title_ar'=>'تقنيات حديثة','title_en'=>'Modern Technology','description_ar'=>'نستخدم أحدث أجهزة الكشف عن التسربات وتنظيف المجاري بالكاميرا والضغط العالي.','description_en'=>'Latest leak detection and camera-based drain cleaning technology.','icon'=>'fas fa-microscope'],
['title_ar'=>'ضمان شامل','title_en'=>'Full Warranty','description_ar'=>'ضمان يصل إلى ٣ سنوات على جميع أعمال السباكة مع خدمة ما بعد البيع.','description_en'=>'Up to 3-year warranty on all plumbing work with after-sales service.','icon'=>'fas fa-check-circle'],
['title_ar'=>'استجابة فورية','title_en'=>'Instant Response','description_ar'=>'نصل إليكم خلال ٦٠ دقيقة من الاتصال لخدمات الطوارئ في جميع الأوقات.','description_en'=>'We arrive within 60 minutes for emergency calls at any time.','icon'=>'fas fa-clock'],
['title_ar'=>'أسعار واضحة','title_en'=>'Clear Pricing','description_ar'=>'أسعار محددة مسبقاً قبل البدء بالعمل مع شفافية كاملة وبدون رسوم خفية.','description_en'=>'Prices set before starting work with full transparency and no hidden fees.','icon'=>'fas fa-file-invoice-dollar'],
['title_ar'=>'مواد عالية الجودة','title_en'=>'Quality Materials','description_ar'=>'نستخدم مواد سباكة من أرقى العلامات التجارية لضمان المتانة والأداء طويل الأمد.','description_en'=>'Premium brand plumbing materials for long-lasting durability and performance.','icon'=>'fas fa-star'],
],
'stats'=>[
['label_ar'=>'عملية إصلاح','label_en'=>'Repairs Done','value'=>'+5,000','icon'=>'fas fa-wrench'],
['label_ar'=>'عميل راضٍ','label_en'=>'Satisfied Clients','value'=>'+2,000','icon'=>'fas fa-users'],
['label_ar'=>'فني سباكة','label_en'=>'Licensed Plumbers','value'=>'+80','icon'=>'fas fa-id-badge'],
['label_ar'=>'سنة خبرة','label_en'=>'Years Experience','value'=>'+14','icon'=>'fas fa-trophy'],
],
'faq'=>[
['question_ar'=>'هل تقدمون خدمة طوارئ على مدار الساعة؟','question_en'=>'Do you offer 24/7 emergency service?','answer_ar'=>'نعم، خدمة طوارئ متاحة على مدار الساعة مع وصول الفني خلال ٦٠ دقيقة.','answer_en'=>'Yes, 24/7 emergency service with technician arrival within 60 minutes.','category'=>'خدمات'],
['question_ar'=>'كيف تكشفون عن التسربات المخفية؟','question_en'=>'How do you detect hidden leaks?','answer_ar'=>'نستخدم أجهزة كشف صوتية وحرارية متطورة لتحديد مكان التسرب بدقة دون تكسير.','answer_en'=>'We use advanced acoustic and thermal detection devices to pinpoint leaks without breaking.','category'=>'تقنيات'],
['question_ar'=>'ما أنواع الأنابيب التي تركبوها؟','question_en'=>'What pipe types do you install?','answer_ar'=>'نركب جميع أنواع الأنابيب: البولي إيثيلين والـبي في سي والنحاس والمدجن والجالفن.','answer_en'=>'We install all pipe types: PEX, PVC, copper, MDPE, and galvanized steel.','category'=>'خدمات'],
['question_ar'=>'هل تقدمون ضماناً على الإصلاحات؟','question_en'=>'Do you warranty repairs?','answer_ar'=>'نعم، ضمان يصل إلى ٣ سنوات على جميع أعمال السباكة والإصلاح.','answer_en'=>'Yes, up to 3-year warranty on all plumbing work and repairs.','category'=>'ضمان'],
['question_ar'=>'كم تكلفة كشف التسربات؟','question_en'=>'How much does leak detection cost?','answer_ar'=>'أسعار تنافسية تبدأ من ٢٠٠ ريال وتختلف حسب المساحة وطبيعة المشكلة.','answer_en'=>'Competitive prices starting from 200 SAR, varying by area and issue complexity.','category'=>'أسعار'],
['question_ar'=>'هل تتعاملون مع المشاريع الكبيرة؟','question_en'=>'Do you handle large projects?','answer_ar'=>'نعم، ننفذ مشاريع سباكة كاملة للعمائر والمجمعات التجارية والمصانع.','answer_en'=>'Yes, we execute complete plumbing projects for buildings, complexes, and factories.','category'=>'مشاريع'],
],
],

// ─── Theme 7: Medical ────────────────────────────────────────────
7 => [
'slug'=>'medical','name_ar'=>'صحة بلس','name_en'=>'Sehha Plus','gallery_color'=>'ef4444',
'hero_title'=>'رعاية صحية استثنائية لكم ولعائلتكم','hero_title_en'=>'Exceptional Healthcare for You & Your Family',
'hero_subtitle'=>'صحتكم أولويتنا الأولى','hero_subtitle_en'=>'Your Health Is Our Priority',
'hero_description'=>'مركز صحة بلس الطبي المتكامل يقدم خدمات صحية شاملة بأحدث التقنيات الطبية وفريق من الأطباء المتخصصين في جميع التخصصات.','hero_description_en'=>'Sehha Plus Medical Center provides comprehensive healthcare with the latest medical technologies and specialized doctors across all disciplines.',
'hero_button_text'=>'احجز موعد طبي','hero_button_text_en'=>'Book Appointment',
'about_title'=>'من نحن','about_title_en'=>'About Us',
'about_content'=>'تأسس مركز صحة بلس عام ٢٠١٠ ليكون مركزاً طبياً متكاملاً يقدم أعلى مستويات الرعاية الصحية في المملكة. يضم المركز أكثر من ٥٠ طبيباً متخصصاً في مختلف التخصصات الطبية مع أحدث الأجهزة والتقنيات الطبية. نحرص على تقديم تجربة علاجية مريحة وآمنة مع التزام تام بمعايير الجودة والسلامة العالمية. نسعى لأن نكون الخيار الصحي الأول لجميع أفراد الأسرة.','about_content_en'=>'Founded in 2010, Sehha Plus Medical Center offers the highest healthcare standards with 50+ specialist doctors, latest medical equipment, and commitment to global quality and safety standards.',
'services'=>[
['title_ar'=>'الطب العام','title_en'=>'General Medicine','description_ar'=>'عيادات طب عامة متخصصة في تشخيص وعلاج الأمراض الشائعة والمزمنة مع متابعة دورية شاملة للحالة الصحية.','description_en'=>'Specialized general medicine clinics for diagnosing and treating common and chronic diseases with comprehensive follow-up.','icon'=>'fas fa-stethoscope','show_on_home'=>1],
['title_ar'=>'طب الأسنان','title_en'=>'Dental Care','description_ar'=>'خدمات طب أسنان شاملة تشمل التجميل والزراعة والتعقيم وعلاج الجذور بأحدث التقنيات والمواد.','description_en'=>'Comprehensive dental services including cosmetic dentistry, implants, and root canal treatment.','icon'=>'fas fa-tooth','show_on_home'=>1],
['title_ar'=>'الجلدية والتجميل','title_en'=>'Dermatology & Cosmetics','description_ar'=>'عيادة جلدية متقدمة تقدم علاجات الأمراض الجلدية والإجراءات التجميلية بأحدث الليزر والتقنيات.','description_en'=>'Advanced dermatology clinic treating skin conditions and cosmetic procedures with latest laser technology.','icon'=>'fas fa-hand-sparkles','show_on_home'=>1],
['title_ar'=>'المختبر والتحاليل','title_en'=>'Laboratory','description_ar'=>'مختبر طبي متطور مزود بأحدث الأجهزة لإجراء جميع التحاليل الطبية والفحوصات بدقة وسرعة عالية.','description_en'=>'Advanced medical laboratory with latest equipment for all tests and screenings with high accuracy.','icon'=>'fas fa-flask','show_on_home'=>1],
['title_ar'=>'الأشعة التشخيصية','title_en'=>'Radiology','description_ar'=>'قسم أشعة متكامل يقدم خدمات التصوير بالرنين المغناطيسي والطبقي والموجات فوق الصوتية.','description_en'=>'Complete radiology department offering MRI, CT scan, and ultrasound imaging services.','icon'=>'fas fa-x-ray','show_on_home'=>1],
['title_ar'=>'العلاج الطبيعي','title_en'=>'Physiotherapy','description_ar'=>'برامج علاج طبيعي متخصصة لإعادة التأهيل والعلاج من الإصابات وأمراض العظام والمفاصل.','description_en'=>'Specialized physiotherapy programs for rehabilitation, injuries, and musculoskeletal conditions.','icon'=>'fas fa-dumbbell','show_on_home'=>1],
],
'testimonials'=>[
['client_name'=>'د. عبدالرحمن العمري','client_title'=>'استشاري قلب','client_title_en'=>'Cardiology Consultant','content'=>'مركز صحة بلس يمتلك بنية تحتية طبية ممتازة وفريق طبي متميز. أنصح به بقوة.','content_en'=>'Excellent medical infrastructure and distinguished medical team. Highly recommended.','rating'=>5],
['client_name'=>'مريم الحارثي','client_title'=>'مريضة','client_title_en'=>'Patient','content'=>'تجربة علاجية رائعة من لحظة الدخول حتى الخروج. الطبيب متعاون والفريق الممرضين محترف.','content_en'=>'Wonderful experience from arrival to discharge. Cooperative doctor and professional nursing staff.','rating'=>5],
['client_name'=>'سلطان الدوسري','client_title'=>'رياضي محترف','client_title_en'=>'Professional Athlete','content'=>'برنامج العلاج الطبيعي ساعدني في التعافي من إصابتي بسرعة والعودة للمنافسة.','content_en'=>'The physiotherapy program helped me recover quickly and return to competition.','rating'=>5],
['client_name'=>'نورة الشهري','client_title'=>'أم لثلاثة أطفال','client_title_en'=>'Mother of Three','content'=>'مركز موثوق لعائلتنا بالكامل. خدمة متميزة وأطباء متخصصون في جميع المجالات.','content_en'=>'Trusted center for our entire family. Excellent service and specialized doctors.','rating'=>5],
],
'contact'=>['phone'=>'+966509001122','whatsapp'=>'+966509001122','email'=>'info@sehhaplus.sa','address'=>'الرياض، حي الياسمين، المملكة العربية السعودية','working_hours'=>'السبت - الخميس: 8 صباحاً - 10 مساءً'],
'features'=>[
['title_ar'=>'أطباء متخصصون','title_en'=>'Specialized Doctors','description_ar'=>'فريق من أكثر من ٥٠ طبيباً استشارياً وأخصائياً في مختلف التخصصات الطبية المعتمدة.','description_en'=>'50+ consultant and specialist doctors across all medical specialties.','icon'=>'fas fa-user-md'],
['title_ar'=>'أجهزة حديثة','title_en'=>'Modern Equipment','description_ar'=>'أحدث الأجهزة الطبية والتقنيات التشخيصية والعلاجية المتطورة لضمان أفضل النتائج.','description_en'=>'Latest medical and diagnostic technology for optimal treatment outcomes.','icon'=>'fas fa-microscope'],
['title_ar'=>'سجلات إلكترونية','title_en'=>'Electronic Records','description_ar'=>'نظام سجلات صحية إلكترونية متكامل يسهل الوصول للتاريخ المرضي ومتابعة العلاج.','description_en'=>'Integrated electronic health records for easy access to medical history.','icon'=>'fas fa-laptop-medical'],
['title_ar'=>'تأمين طبي','title_en'=>'Health Insurance','description_ar'=>'نتعامل مع أكبر شركات التأمين الصحي في المملكة لتسهيل عملية العلاج والدفع.','description_en'=>'We work with major health insurance companies for easy treatment and payment.','icon'=>'fas fa-file-medical'],
['title_ar'=>'خصوصية وسرية','title_en'=>'Privacy & Confidentiality','description_ar'=>'نحافظ على سرية وخصوصية جميع المعلومات الطبية للمرضى وفق أعلى المعايير.','description_en'=>'We maintain patient medical information privacy per the highest standards.','icon'=>'fas fa-lock'],
['title_ar'=>'بيئة مريحة','title_en'=>'Comfortable Environment','description_ar'=>'مركز مصمم براحة المريض في الاعتبار مع صالات انتظار مريحة وتجهيزات حديثة.','description_en'=>'Patient-centered design with comfortable waiting areas and modern facilities.','icon'=>'fas fa-hospital'],
],
'stats'=>[
['label_ar'=>'مريض تم علاجه','label_en'=>'Patients Treated','value'=>'+50,000','icon'=>'fas fa-procedures'],
['label_ar'=>'طبيب متخصص','label_en'=>'Specialist Doctors','value'=>'+50','icon'=>'fas fa-user-md'],
['label_ar'=>'تخصص طبي','label_en'=>'Medical Specialties','value'=>'+15','icon'=>'fas fa-star'],
['label_ar'=>'سنة خبرة','label_en'=>'Years Experience','value'=>'+14','icon'=>'fas fa-trophy'],
],
'faq'=>[
['question_ar'=>'كيف يمكنني حجز موعد؟','question_en'=>'How can I book an appointment?','answer_ar'=>'يمكنكم الحجز عبر الموقع أو الهاتف أو الواتساب أو التطبيق مع إمكانية اختيار الطبيب والموعد.','answer_en'=>'Book via website, phone, WhatsApp, or app with doctor and time selection.','category'=>'حجز'],
['question_ar'=>'هل تقبلون التأمين الصحي؟','question_en'=>'Do you accept health insurance?','answer_ar'=>'نعم، نتعامل مع جميع شركات التأمين الصحي المعتمدة في المملكة العربية السعودية.','answer_en'=>'Yes, we work with all licensed health insurance companies in Saudi Arabia.','category'=>'تأمين'],
['question_ar'=>'ما التخصصات المتاحة في المركز؟','question_en'=>'What specialties are available?','answer_ar'=>'طب عام، أسنان، جلدية، مختبر، أشعة، علاج طبيعي، أنف وأذن وحنجرة، عيون، أطفال.','answer_en'=>'General medicine, dental, dermatology, lab, radiology, physiotherapy, ENT, ophthalmology, pediatrics.','category'=>'تخصصات'],
['question_ar'=>'هل يوجد خدمة طوارئ؟','question_en'=>'Do you have emergency services?','answer_ar'=>'نعم، عيادة طوارئ تعمل على مدار الساعة مع طبيب متخصص ومعدات إنعاش كاملة.','answer_en'=>'Yes, 24/7 emergency clinic with specialist doctor and full resuscitation equipment.','category'=>'خدمات'],
['question_ar'=>'كم تستغرق نتائج التحاليل؟','question_en'=>'How long do lab results take?','answer_ar'=>'معظم التحاليل خلال ٢٤ ساعة مع خدمة إرسال النتائج عبر الرسائل النصية أو التطبيق.','answer_en'=>'Most results within 24 hours, sent via SMS or app.','category'=>'مختبر'],
['question_ar'=>'هل يمكنني استشارة طبيب عن بُعد؟','question_en'=>'Can I consult a doctor remotely?','answer_ar'=>'نعم، نوفر خدمة الاستشارة الطبية عن بُعد عبر الفيديو مع أطبائنا المتخصصين.','answer_en'=>'Yes, we offer remote video consultations with our specialist doctors.','category'=>'تقنيات'],
],
],

// ─── Theme 8: Real Estate ────────────────────────────────────────
8 => [
'slug'=>'realestate','name_ar'=>'دار العقار','name_en'=>'Dar Real Estate','gallery_color'=>'a855f7',
'hero_title'=>'اعثر على بيت أحلامك معنا','hero_title_en'=>'Find Your Dream Home With Us',
'hero_subtitle'=>'شريككم الموثوق في عالم العقارات','hero_subtitle_en'=>'Your Trusted Real Estate Partner',
'hero_description'=>'دار العقار الرائدة في تقديم خدمات الوساطة العقارية وإدارة الأملاك مع فريق من الخبراء المتخصصين في سوق العقارات السعودي.','hero_description_en'=>'Dar Real Estate leads in property brokerage and management with a team of Saudi real estate market experts.',
'hero_button_text'=>'تصفح العقارات','hero_button_text_en'=>'Browse Properties',
'about_title'=>'من نحن','about_title_en'=>'About Us',
'about_content'=>'تأسست دار العقار عام ٢٠١١ لتكون من الشركات الرائدة في قطاع الوساطة العقارية في المملكة. نمتلك فريقاً من أمهر الوكلاء العقاريين والخبراء في التقييم العقاري. نقدم خدمات شاملة تشمل البيع والشراء والتأجير وإدارة الأملاك والاستشارات الاستثمارية. ساعدنا آلاف العملاء في العثور على العقار المثالي واستثمار أموالهم بذكاء في السوق العقاري السعودي.','about_content_en'=>'Founded in 2011 as a leading real estate brokerage firm. Our expert agents and valuers help thousands find ideal properties and invest wisely in the Saudi real estate market.',
'services'=>[
['title_ar'=>'بيع وشراء العقارات','title_en'=>'Buy & Sell Properties','description_ar'=>'نساعدكم في بيع أو شراء العقارات بأسعار عادلة مع إجراءات قانونية سلسة وشفافة من البداية حتى التسليم.','description_en'=>'We help you sell or buy properties at fair prices with smooth, transparent legal procedures.','icon'=>'fas fa-building','show_on_home'=>1],
['title_ar'=>'تأجير العقارات','title_en'=>'Property Rental','description_ar'=>'خدمات تأجير شاملة للمنازل والشقق والمكاتب التجارية مع عقود إيجار واضحة ومجهزة قانونياً.','description_en'=>'Comprehensive rental services for homes, apartments, and offices with clear legal contracts.','icon'=>'fas fa-key','show_on_home'=>1],
['title_ar'=>'إدارة الأملاك','title_en'=>'Property Management','description_ar'=>'إدارة شاملة للعقارات تشمل جمع الإيجارات وصيانة الممتلكات ومتابعة المستأجرين نيابة عن المالك.','description_en'=>'Full property management including rent collection, maintenance, and tenant follow-up.','icon'=>'fas fa-tasks','show_on_home'=>1],
['title_ar'=>'الاستشارات الاستثمارية','title_en'=>'Investment Consulting','description_ar'=>'استشارات عقارية استثمارية متخصصة تساعدكم في اتخاذ قرارات استثمارية ذكية ومربحة.','description_en'=>'Specialized real estate investment consulting for smart, profitable decisions.','icon'=>'fas fa-chart-line','show_on_home'=>1],
['title_ar'=>'التقييم العقاري','title_en'=>'Property Valuation','description_ar'=>'تقييم عقاري دقيق ومعتمد باستخدام أحدث الأساليب والبيانات السوقية لتحديد القيمة العادلة.','description_en'=>'Accurate certified property valuation using latest methods and market data.','icon'=>'fas fa-file-contract','show_on_home'=>1],
['title_ar'=>'الدعم القانوني العقاري','title_en'=>'Legal Support','description_ar'=>'دعم قانوني متخصص في المعاملات العقارية يشمل صياغة العقود والتوثيق وحل النزاعات.','description_en'=>'Specialized legal support for property transactions including contracts and dispute resolution.','icon'=>'fas fa-gavel','show_on_home'=>1],
],
'testimonials'=>[
['client_name'=>'خالد الزهراني','client_title'=>'رجل أعمال','client_title_en'=>'Businessman','content'=>'ساعدتني دار العقار في شراء عقار استثماري ممتاز بعائد ممتاز. فريق محترف وذو خبرة عالية.','content_en'=>'Dar Real Estate helped me buy an excellent investment property with great returns. Professional and experienced.','rating'=>5],
['client_name'=>'سارة المطيري','client_title'=>'مهندسة معمارية','client_title_en'=>'Architect','content'=>'وجدت شقتي المثالية بفضل فريقهم المتعاون. العملية كانت سلسة وسريعة وأسعار عادلة.','content_en'=>'Found my ideal apartment thanks to their cooperative team. Smooth, fast process with fair prices.','rating'=>5],
['client_name'=>'عبدالله القرني','client_title'=>'مستثمر','client_title_en'=>'Investor','content'=>'استشاراتهم الاستثمارية ساعدتني في بناء محفظة عقارية متنوعة ومربحة. أنصح بهم بشدة.','content_en'=>'Their investment consulting helped me build a diversified, profitable real estate portfolio.','rating'=>5],
['client_name'=>'نوف العتيبي','client_title'=>'ربة منزل','client_title_en'=>'Homemaker','content'=>'تجربة تأجير ممتازة. أداروا عقاري باحترافية وسهّلوا عليّ الكثير من المتاعب.','content_en'=>'Excellent rental experience. They managed my property professionally and eased my burdens.','rating'=>5],
],
'contact'=>['phone'=>'+966508899001','whatsapp'=>'+966508899001','email'=>'info@darrealestate.sa','address'=>'جدة، حي الروضة، المملكة العربية السعودية','working_hours'=>'السبت - الخميس: 9 صباحاً - 9 مساءً'],
'features'=>[
['title_ar'=>'شبكة عقارات واسعة','title_en'=>'Wide Property Network','description_ar'=>'قاعدة بيانات شاملة تضم آلاف العقارات المتاحة للبيع والإيجار في جميع مناطق المملكة.','description_en'=>'Comprehensive database with thousands of properties available across the Kingdom.','icon'=>'fas fa-database'],
['title_ar'=>'وكلاء معتمدون','title_en'=>'Licensed Agents','description_ar'=>'جميع وكلاؤنا العقاريون مرخصون ومعتمدون من وزارة الإسكان بخبرة عملية واسعة.','description_en'=>'All agents licensed by the Ministry of Housing with extensive practical experience.','icon'=>'fas fa-id-badge'],
['title_ar'=>'أسعار شفافة','title_en'=>'Transparent Prices','description_ar'=>'أسعار عقارية واضحة وعادلة مع إفصاح كامل عن الرسوم والتكاليف دون رسوم خفية.','description_en'=>'Clear, fair property prices with full disclosure of fees and costs.','icon'=>'fas fa-file-invoice-dollar'],
['title_ar'=>'دعم قانوني','title_en'=>'Legal Support','description_ar'=>'فريق قانوني متخصص يرافق جميع المعاملات العقارية لضمان حقوق جميع الأطراف.','description_en'=>'Specialized legal team accompanying all transactions to protect all parties rights.','icon'=>'fas fa-gavel'],
['title_ar'=>'خدمة ما بعد البيع','title_en'=>'After-Sale Service','description_ar'=>'متابعة مستمرة بعد إتمام الصفقة لضمان رضا العميل وحل أي مشكلات محتملة.','description_en'=>'Continuous follow-up after closing to ensure client satisfaction and resolve any issues.','icon'=>'fas fa-headset'],
['title_ar'=>'تقييم دقيق','title_en'=>'Accurate Valuation','description_ar'=>'تقييم عقاري مهني دقيق باستخدام أحدث الأدوات والبيانات السوقية الموثوقة.','description_en'=>'Professional valuation using latest tools and reliable market data.','icon'=>'fas fa-chart-bar'],
],
'stats'=>[
['label_ar'=>'عقار تم بيعه','label_en'=>'Properties Sold','value'=>'+3,000','icon'=>'fas fa-building'],
['label_ar'=>'عميل راضٍ','label_en'=>'Happy Clients','value'=>'+2,500','icon'=>'fas fa-users'],
['label_ar'=>'عقار لإيجار','label_en'=>'Rental Properties','value'=>'+1,000','icon'=>'fas fa-key'],
['label_ar'=>'سنة خبرة','label_en'=>'Years Experience','value'=>'+13','icon'=>'fas fa-trophy'],
],
'faq'=>[
['question_ar'=>'ما المناطق التي تغطونها؟','question_en'=>'What areas do you cover?','answer_ar'=>'نغطي جميع مناطق المملكة: الرياض، جدة، الدمام، مكة المكرمة، المدينة المنورة، وأبها.','answer_en'=>'We cover all regions: Riyadh, Jeddah, Dammam, Makkah, Madinah, and Abha.','category'=>'خدمات'],
['question_ar'=>'كيف أبدأ البحث عن عقار؟','question_en'=>'How do I start searching?','answer_ar'=>'يمكنكم تصفح العقارات عبر موقعنا أو التواصل مع وكلائنا لمساعدتكم في العثور على المناسب.','answer_en'=>'Browse properties on our website or contact our agents for personalized help.','category'=>'بحث'],
['question_ar'=>'ما هي رسوم الوساطة العقارية؟','question_en'=>'What are the brokerage fees?','answer_ar'=>'رسوم الوساطة معتدلة ومتوافقة مع الأنظمة. نقدم عروضاً خاصة للعملاء الدائمين.','answer_en'=>'Moderate fees compliant with regulations. Special offers for loyal clients.','category'=>'أسعار'],
['question_ar'=>'هل تقدمون تمويلاً عقارياً؟','question_en'=>'Do you offer mortgage services?','answer_ar'=>'نساعدكم في الحصول على تمويل عقاري من أفضل البنوك الشريكة مع شروط تنافسية.','answer_en'=>'We help secure mortgage financing from partner banks at competitive terms.','category'=>'تمويل'],
['question_ar'=>'هل تديرون العقارات نيابة عن المالك؟','question_en'=>'Do you manage properties on behalf of owners?','answer_ar'=>'نعم، نقدم خدمة إدارة أملاك شاملة تشمل الصيانة وجمع الإيجارات ومتابعة المستأجرين.','answer_en'=>'Yes, full property management including maintenance, rent collection, and tenant follow-up.','category'=>'خدمات'],
['question_ar'=>'كم يستغرق إتمام عملية البيع؟','question_en'=>'How long does a sale take?','answer_ar'=>'عادة من ٢-٤ أسابيع من الاتفاق حتى التسليم حسب إجراءات التوثيق والتمويل.','answer_en'=>'Usually 2-4 weeks from agreement to handover, depending on documentation and financing.','category'=>'عام'],
],
],

// ─── Theme 9: Restaurant ─────────────────────────────────────────
9 => [
'slug'=>'restaurant','name_ar'=>'مذاق','name_en'=>'Mazaq Restaurant','gallery_color'=>'dc2626',
'hero_title'=>'رحلة طعام لا تُنسى في كل قضمة','hero_title_en'=>'An Unforgettable Culinary Journey in Every Bite',
'hero_subtitle'=>'نقدم لكم أشهى المأكولات العربية والعالمية','hero_subtitle_en'=>'The Finest Arabic & International Cuisine',
'hero_description'=>'مطعم مذاق يقدم تجربة طعام استثنائية تجمع بين الأصالة العربية والمذاقات العالمية بأيدي طهاة محترفين ومكونات طازجة يومياً.','hero_description_en'=>'Mazaq Restaurant offers an exceptional dining experience blending Arabic authenticity with international flavors by professional chefs using daily fresh ingredients.',
'hero_button_text'=>'احجز طاولة','hero_button_text_en'=>'Reserve a Table',
'about_title'=>'من نحن','about_title_en'=>'About Us',
'about_content'=>'تأسس مطعم مذاق عام ٢٠١٧ برؤية تقديم تجربة طعام عربية أصيلة مع لمسة عالمية عصرية. يضم فريقنا نخبة من الطهاة المتخصصين في المأكولات العربية والبحر المتوسط والعالمية. نحرص على اختيار أجود المكونات الطازجة يومياً من المزارعات المحلية والموردين المعتمدين. صالة المطعم مصممة بأسلوب عصري أنيق يوفر أجواء مريحة للعائلات والمناسبات الخاصة.','about_content_en'=>'Founded in 2017, Mazaq offers authentic Arabic cuisine with a modern international twist. Our team of specialty chefs uses the finest daily fresh ingredients in an elegantly designed family-friendly space.',
'services'=>[
['title_ar'=>'الطعام العربي الأصيل','title_en'=>'Authentic Arabic Cuisine','description_ar'=>'تشكيلة واسعة من الأطباق العربية التقليدية المحضرة بوصفات أصيلة ومكونات طازجة عالية الجودة.','description_en'=>'Wide selection of traditional Arabic dishes prepared with authentic recipes and premium fresh ingredients.','icon'=>'fas fa-utensils','show_on_home'=>1],
['title_ar'=>'خدمات التموين والتموين','title_en'=>'Catering Services','description_ar'=>'خدمات تموين احترافية للمناسبات والحفلات والمؤتمرات بقوائم طعام متنوعة وأسعار تنافسية.','description_en'=>'Professional catering for events, parties, and conferences with diverse menus at competitive prices.','icon'=>'fas fa-concierge-bell','show_on_home'=>1],
['title_ar'=>'خدمة التوصيل','title_en'=>'Delivery Service','description_ar'=>'خدمة توصيل سريعة لجميع الأطباق مع التغليف الاحترافي الذي يحافظ على جودة الطعام.','description_en'=>'Fast delivery of all dishes with professional packaging that maintains food quality.','icon'=>'fas fa-motorcycle','show_on_home'=>1],
['title_ar'=>'استضافة المناسبات','title_en'=>'Event Hosting','description_ar'=>'قاعات فاخرة ومجهزة لاستضافة المناسبات الخاصة وحفلات الزفاف والتجمعات العائلية.','description_en'=>'Luxurious equipped halls for private events, weddings, and family gatherings.','icon'=>'fas fa-glass-cheers','show_on_home'=>1],
['title_ar'=>'المناسبات الخاصة','title_en'=>'Private Dining','description_ar'=>'تجربة طعام خاصة في جناح منفصل مع طاهٍ مخصص وقائمة طعام حسب الطلب.','description_en'=>'Private dining experience in a separate suite with a dedicated chef and custom menu.','icon'=>'fas fa-user-friends','show_on_home'=>1],
['title_ar'=>'دورات الطبخ','title_en'=>'Cooking Classes','description_ar'=>'دورات طبخ تفاعلية يقدمها طهاة المطعم لتعلم أسرار المأكولات العربية والعالمية.','description_en'=>'Interactive cooking classes by our chefs to learn Arabic and international cuisine secrets.','icon'=>'fas fa-hat-chef','show_on_home'=>1],
],
'testimonials'=>[
['client_name'=>'محمد الراشد','client_title'=>'ناقد مطاعم','client_title_en'=>'Food Critic','content'=>'تجربة طعام استثنائية. المذاقات متنوعة ومتوازنة والجودة عالية. من أفضل المطاعم في المدينة.','content_en'=>'Exceptional dining experience. Diverse, balanced flavors with high quality. Among the best restaurants.','rating'=>5],
['client_name'=>'ريم الفهمي','client_title'=>'منظمة حفلات','client_title_en'=>'Event Organizer','content'=>'خدمة التموين كانت ممتازة. الطعام شهي والعرض احترافي وضيوفنا سعداء جداً.','content_en'=>'Excellent catering service. Delicious food and professional presentation. Guests were very happy.','rating'=>5],
['client_name'=>'خالد السبيعي','client_title'=>'عائلة','client_title_en'=>'Family Customer','content'=>'مكان مثالي للعائلات. الأجواء مريحة والأكل لذيذ والخدمة سريعة ومتعاونة.','content_en'=>'Perfect family spot. Comfortable atmosphere, delicious food, and cooperative service.','rating'=>5],
['client_name'=>'لينا الحربي','client_title'=>'مدونة طعام','client_title_en'=>'Food Blogger','content'=>'طبق المندي كان الأفضل الذي تذوقته. الحفاظ على النكهة الأصلية مع لمسة إبداعية رائعة.','content_en'=>'Best Mandi dish I have ever tasted. Preserving original flavor with a wonderful creative touch.','rating'=>5],
],
'contact'=>['phone'=>'+966501122334','whatsapp'=>'+966501122334','email'=>'info@mazaq.sa','address'=>'الرياض، حي الصفا، المملكة العربية السعودية','working_hours'=>'يومياً: 11 صباحاً - 12 منتصف الليل'],
'features'=>[
['title_ar'=>'طهاة محترفون','title_en'=>'Professional Chefs','description_ar'=>'فريق من الطهاة المتخصصين ذوي الخبرة الواسعة في المأكولات العربية والعالمية.','description_en'=>'Team of specialist chefs with extensive expertise in Arabic and international cuisine.','icon'=>'fas fa-hat-chef'],
['title_ar'=>'مكونات طازجة','title_en'=>'Fresh Ingredients','description_ar'=>'نستخدم مكونات طازجة يومياً من أفضل المزارعات والموردين المحليين المعتمدين.','description_en'=>'Daily fresh ingredients from the finest local farms and certified suppliers.','icon'=>'fas fa-leaf'],
['title_ar'=>'أجواء عصرية','title_en'=>'Modern Ambiance','description_ar'=>'تصميم داخلي عصري وأنيق يوفر أجواء مريحة ومميزة لجميع الزوار.','description_en'=>'Modern, elegant interior design providing a comfortable, unique atmosphere.','icon'=>'fas fa-couch'],
['title_ar'=>'قوائم متنوعة','title_en'=>'Diverse Menus','description_ar'=>'قوائم طعام غنية ومتنوعة تلبي جميع الأذواق مع خيارات صحية ونباتية.','description_en'=>'Rich, diverse menus catering to all tastes including healthy and vegetarian options.','icon'=>'fas fa-book-open'],
['title_ar'=>'خدمة متميزة','title_en'=>'Excellent Service','description_ar'=>'فريق خدمة محترف ومرح يضمن تجربة تناول طعام مريحة ومميزة للجميع.','description_en'=>'Professional, welcoming service team ensuring a comfortable dining experience.','icon'=>'fas fa-concierge-bell'],
['title_ar'=>'نظافة صارمة','title_en'=>'Strict Hygiene','description_ar'=>'نلتزم بأعلى معايير النظافة والسلامة الغذائية في المطبخ وبيئة المطعم بالكامل.','description_en'=>'We adhere to the highest hygiene and food safety standards throughout.','icon'=>'fas fa-shield-halved'],
],
'stats'=>[
['label_ar'=>'طبق تم تقديمه','label_en'=>'Dishes Served','value'=>'+100,000','icon'=>'fas fa-utensils'],
['label_ar'=>'عميل سعيد','label_en'=>'Happy Customers','value'=>'+15,000','icon'=>'fas fa-users'],
['label_ar'=>'مناسبة تم استضافتها','label_en'=>'Events Hosted','value'=>'+500','icon'=>'fas fa-glass-cheers'],
['label_ar'=>'سنة خبرة','label_en'=>'Years Experience','value'=>'+7','icon'=>'fas fa-trophy'],
],
'faq'=>[
['question_ar'=>'هل يمكنني حجز طاولة مسبقاً؟','question_en'=>'Can I reserve a table in advance?','answer_ar'=>'نعم، يمكنكم الحجز عبر الهاتف أو الموقع أو التطبيق مع تحديد عدد الأشخاص والموعد المفضل.','answer_en'=>'Yes, book via phone, website, or app specifying number of guests and preferred time.','category'=>'حجز'],
['question_ar'=>'هل تقدمون خدمة تموين للمناسبات؟','question_en'=>'Do you offer event catering?','answer_ar'=>'نعم، نقدم خدمات تموين احترافية لجميع أنواع المناسبات مع قوائم طعام قابلة للتخصيص.','answer_en'=>'Yes, professional catering for all event types with customizable menus.','category'=>'خدمات'],
['question_ar'=>'هل يوجد مواقف سيارات؟','question_en'=>'Is parking available?','answer_ar'=>'نعم، يوجد موقف سيارات واسع ومجاني لجميع الزوار بتسهيلات لكبار السن.','answer_en'=>'Yes, free spacious parking with senior-friendly facilities.','category'=>'عام'],
['question_ar'=>'هل المطعم مناسب للعائلات؟','question_en'=>'Is the restaurant family-friendly?','answer_ar'=>'بالتأكيد، لدينا جناح عائلي منفصل وأجواء مناسبة لجميع الأعمار مع كراسي أطفال.','answer_en'=>'Absolutely, separate family section, all-ages atmosphere, and child seats available.','category'=>'عام'],
['question_ar'=>'ما طرق الدفع المتاحة؟','question_en'=>'What payment methods are accepted?','answer_ar'=>'نقبل الدفع النقدي وبطاقات الائتمان والأبل باي والمدى وأكبر المنصات الإلكترونية.','answer_en'=>'We accept cash, credit cards, Apple Pay, Mada, and major e-wallets.','category'=>'دفع'],
['question_ar'=>'هل تقدمون خيارات صحية أو نباتية؟','question_en'=>'Do you offer healthy or vegetarian options?','answer_ar'=>'نعم، قائمتنا تضم خيارات صحية ونباتية ومخصصة للحمية مع توضيح القيم الغذائية.','answer_en'=>'Yes, our menu includes healthy, vegetarian, and diet-specific options with nutritional info.','category'=>'قائمة'],
],
],

// ─── Theme 10: Education ─────────────────────────────────────────
10 => [
'slug'=>'education','name_ar'=>'أكاديمية المعرفة','name_en'=>'Knowledge Academy','gallery_color'=>'2563eb',
'hero_title'=>'نصنع مستقبلكم بالتعليم والتدريب','hero_title_en'=>'Shaping Your Future Through Education & Training',
'hero_subtitle'=>'التعليم هو المفتاح للنجاح','hero_subtitle_en'=>'Education Is the Key to Success',
'hero_description'=>'أكاديمية المعرفة المتخصصة في تقديم برامج تعليمية وتدريبية متميزة تساعد المتعلمين على تطوير مهاراتهم وتحقيق أهدافهم المهنية والأكاديمية.','hero_description_en'=>'Knowledge Academy offers distinguished educational and training programs helping learners develop skills and achieve their professional and academic goals.',
'hero_button_text'=>'تصفح الدورات','hero_button_text_en'=>'Browse Courses',
'about_title'=>'من نحن','about_title_en'=>'About Us',
'about_content'=>'تأسست أكاديمية المعرفة عام ٢٠١٦ لتكون صرحاً تعليمياً رائداً يقدم برامج تدريبية وأكاديمية عالية الجودة. نمتلك فريقاً من أكثر من ١٠٠ مدرب ومعلم متخصص في مختلف المجالات. نقدم برامج تعليمية متنوعة تشمل الدورات المهنية واللغات والتطوير الشخصي والتعليم عن بُعد. حصلنا على اعتمادات من جهات تعليمية رائدة ونفخر بتخريج أكثر من ٢٠ ألف متعلم.','about_content_en'=>'Founded in 2016, Knowledge Academy is a leading educational institution with 100+ trainers, diverse programs, and accreditations from leading educational bodies. Over 20,000 graduates.',
'services'=>[
['title_ar'=>'الدورات المهنية','title_en'=>'Professional Courses','description_ar'=>'دورات تدريبية مهنية متخصصة في الإدارة والتسويق والمالية وتقنية المعلومات بشهادات معتمدة.','description_en'=>'Specialized professional courses in management, marketing, finance, and IT with certified credentials.','icon'=>'fas fa-graduation-cap','show_on_home'=>1],
['title_ar'=>'دورات اللغات','title_en'=>'Language Courses','description_ar'=>'دورات تعلم اللغات الإنجليزية والفرنسية والإسبانية والصينية بمستويات مختلفة ومعلمين متحدثين أصليين.','description_en'=>'English, French, Spanish, and Chinese language courses at various levels with native speakers.','icon'=>'fas fa-language','show_on_home'=>1],
['title_ar'=>'التعليم عن بُعد','title_en'=>'Online Learning','description_ar'=>'منصة تعليمية إلكترونية متكاملة تقدم دورات تفاعلية حية ومسجلة مع شهادات إتمام رقمية.','description_en'=>'Integrated e-learning platform with live and recorded interactive courses and digital certificates.','icon'=>'fas fa-laptop','show_on_home'=>1],
['title_ar'=>'التدريب الخاص','title_en'=>'Private Tutoring','description_ar'=>'جلسات تدريب خاصة فردية أو جماعية مصممة حسب احتياجات المتعلم ووتيرة التعلم المناسبة.','description_en'=>'Individual or group private sessions customized to learner needs and pace.','icon'=>'fas fa-chalkboard-teacher','show_on_home'=>1],
['title_ar'=>'التطوير الشخصي','title_en'=>'Personal Development','description_ar'=>'برامج تطوير المهارات الشخصية والقيادية والاتصال الفعال وإدارة الوقت والتفكير الإبداعي.','description_en'=>'Programs developing personal, leadership, communication, time management, and creative thinking skills.','icon'=>'fas fa-brain','show_on_home'=>1],
['title_ar'=>'تدريب الشركات','title_en'=>'Corporate Training','description_ar'=>'برامج تدريبية مخصصة للشركات والمؤسسات لتطوير مهارات فرق العمل ورفع الكفاءة التنظيمية.','description_en'=>'Customized corporate training programs to develop team skills and organizational efficiency.','icon'=>'fas fa-building','show_on_home'=>1],
],
'testimonials'=>[
['client_name'=>'د. فاطمة الزهراني','client_title'=>'عميدة كلية','client_title_en'=>'College Dean','content'=>'التعاون مع أكاديمية المعرفة أثمر عن برامج تدريبية ممتازة لطلابنا. جودة عالية ومحتوى محدث.','content_en'=>'Excellent training programs for our students. High quality and updated content.','rating'=>5],
['client_name'=>'أحمد الغامدي','client_title'=>'مدير موارد بشرية','client_title_en'=>'HR Manager','content'=>'برنامج تدريب الشركات الذي قدموه لفريقنا كان مؤثراً جداً في تحسين الأداء العام.','content_en'=>'Their corporate training program significantly improved our team performance.','rating'=>5],
['client_name'=>'نورة القرني','client_title'=>'طالبة','client_title_en'=>'Student','content'=>'تعلمت اللغة الإنجليزية بفضل دوراتهم الممتازة. المعلمون رائعون والبيئة التعليمية محفزة.','content_en'=>'Learned English through their excellent courses. Amazing teachers and motivating environment.','rating'=>5],
['client_name'=>'سلطان المالكي','client_title'=>'رائد أعمال','client_title_en'=>'Entrepreneur','content'=>'دورة إدارة المشاريع ساعدتني في تنظيم عملي وتطوير مهاراتي القيادية بشكل كبير.','content_en'=>'The project management course helped me organize my work and develop leadership skills.','rating'=>5],
],
'contact'=>['phone'=>'+966502233445','whatsapp'=>'+966502233445','email'=>'info@knowledgeacademy.sa','address'=>'الرياض، حي النخيل، المملكة العربية السعودية','working_hours'=>'السبت - الخميس: 8 صباحاً - 9 مساءً'],
'features'=>[
['title_ar'=>'مدربون خبراء','title_en'=>'Expert Trainers','description_ar'=>'فريق من أكثر من ١٠٠ مدرب ومعلم معتمد بخبرة عملية واسعة في مجالاتهم.','description_en'=>'100+ certified trainers with extensive practical experience in their fields.','icon'=>'fas fa-chalkboard-teacher'],
['title_ar'=>'شهادات معتمدة','title_en'=>'Certified Programs','description_ar'=>'جميع برامجنا معتمدة من جهات تعليمية ومهنية رائدة محلياً ودولياً.','description_en'=>'All programs accredited by leading local and international educational bodies.','icon'=>'fas fa-certificate'],
['title_ar'=>'تعليم تفاعلي','title_en'=>'Interactive Learning','description_ar'=>'منهجية تعليمية تفاعلية تجمع بين النظرية والتطبيق العملي والمشاريع الحقيقية.','description_en'=>'Interactive methodology combining theory, practice, and real-world projects.','icon'=>'fas fa-hands-helping'],
['title_ar'=>'مرونة في الجدول','title_en'=>'Flexible Schedule','description_ar'=>'جداول مرنة تناسب مختلف الاحتياجات مع خيارات الصباحي والمسائي والتعليم عن بُعد.','description_en'=>'Flexible schedules with morning, evening, and online learning options.','icon'=>'fas fa-clock'],
['title_ar'=>'منصة رقمية','title_en'=>'Digital Platform','description_ar'=>'منصة تعليمية رقمية متكاملة للمحتوى والاختبارات والتواصل مع المدربين والزملاء.','description_en'=>'Integrated digital platform for content, tests, and trainer communication.','icon'=>'fas fa-laptop'],
['title_ar'=>'دعم وظيفي','title_en'=>'Career Support','description_ar'=>'خدمة دعم وظيفي تشمل التوجيه المهني وإعداد السيرة الذاتية والتواصل مع أصحاب العمل.','description_en'=>'Career support including mentoring, resume building, and employer networking.','icon'=>'fas fa-briefcase'],
],
'stats'=>[
['label_ar'=>'متخرج','label_en'=>'Graduates','value'=>'+20,000','icon'=>'fas fa-user-graduate'],
['label_ar'=>'دورة تدريبية','label_en'=>'Training Courses','value'=>'+300','icon'=>'fas fa-book'],
['label_ar'=>'مدرب معتمد','label_en'=>'Certified Trainers','value'=>'+100','icon'=>'fas fa-chalkboard-teacher'],
['label_ar'=>'سنة خبرة','label_en'=>'Years Experience','value'=>'+8','icon'=>'fas fa-trophy'],
],
'faq'=>[
['question_ar'=>'كيف يمكنني التسجيل في دورة؟','question_en'=>'How do I enroll in a course?','answer_ar'=>'يمكنكم التسجيل عبر الموقع أو زيارة الأكاديمية أو التواصل عبر الهاتف مع اختيار الدورة المناسبة.','answer_en'=>'Register via website, visit the academy, or call to choose your course.','category'=>'تسجيل'],
['question_ar'=>'هل الشهادات معتمدة؟','question_en'=>'Are the certificates accredited?','answer_ar'=>'نعم، جميع شهاداتنا معتمدة من جهات تعليمية ومهنية رائدة ومعترف بها محلياً ودولياً.','answer_en'=>'Yes, all certificates are accredited by leading educational and professional bodies.','category'=>'شهادات'],
['question_ar'=>'هل يمكنني الدراسة عن بُعد؟','question_en'=>'Can I study online?','answer_ar'=>'نعم، نقدم خيار التعليم عن بُعد لمعظم الدورات عبر منصتنا الرقمية التفاعلية.','answer_en'=>'Yes, online learning option available for most courses via our interactive platform.','category'=>'تعليم'],
['question_ar'=>'ما تكلفة الدورات؟','question_en'=>'How much do courses cost?','answer_ar'=>'أسعار تنافسية تختلف حسب نوع الدورة ومدتها. نوفر خطط تقسيط مرنة وخاصمات للطلاب.','answer_en'=>'Competitive prices vary by course type and duration. Flexible payment plans and student discounts available.','category'=>'أسعار'],
['question_ar'=>'هل تقدمون دورات للشركات؟','question_en'=>'Do you offer corporate courses?','answer_ar'=>'نعم، برامج تدريب مؤسسي مخصصة حسب احتياجات الشركة مع خصومات للجماعات.','answer_en'=>'Yes, customized corporate training programs with group discounts.','category'=>'شركات'],
['question_ar'=>'هل يوجد حد أقصى لعدد المتعلمين؟','question_en'=>'Is there a class size limit?','answer_ar'=>'نعم، نحافظ على أعداد صغيرة لضمان جودة التعليم والتفاعل بين المدرب والمتعلمين.','answer_en'=>'Yes, we maintain small class sizes to ensure quality and interaction.','category'=>'عام'],
],
],

// ─── Theme 11: Legal ─────────────────────────────────────────────
11 => [
'slug'=>'legal','name_ar'=>'مكتب العدل للمحاماة','name_en'=>'Al Adl Law Firm','gallery_color'=>'475569',
'hero_title'=>'حماية حقوقكم قانونياً هو أولويتنا','hero_title_en'=>'Legally Protecting Your Rights Is Our Priority',
'hero_subtitle'=>'خبرة قانونية موثوقة منذ أكثر من ٢٥ عاماً','hero_subtitle_en'=>'Trusted Legal Expertise for Over 25 Years',
'hero_description'=>'مكتب العدل للمحاماة والاستشارات القانونية يقدم خدمات قانونية شاملة بأعلى مستويات الاحترافية والسرية لعملائه من الأفراد والشركات والمؤسسات.','hero_description_en'=>'Al Adl Law Firm provides comprehensive legal services with the highest professionalism and confidentiality for individuals, companies, and institutions.',
'hero_button_text'=>'استشر محامياً','hero_button_text_en'=>'Consult a Lawyer',
'about_title'=>'من نحن','about_title_en'=>'About Us',
'about_content'=>'مكتب العدل للمحاماة تأسس عام ١٩٩٨ على يد نخبة من المحامين والمستشارين القانونيين المتميزين. نمتلك فريقاً من أكثر من ٣٠ محامياً ومستشاراً قانونياً متخصصاً في مختلف فروع القانون. نقدم خدماتنا وفق أعلى معايير المهنة القانونية مع التزام تام بالسرية والأمانة. تمتد خبرتنا في التعامل مع آلاف القضايا والمعاملات القانونية المعقدة في جميع المحاكم السعودية.','about_content_en'=>'Al Adl Law Firm, established in 1998, has 30+ specialized lawyers handling thousands of complex cases with the highest legal profession standards and full confidentiality.',
'services'=>[
['title_ar'=>'الاستشارات القانونية','title_en'=>'Legal Consulting','description_ar'=>'استشارات قانونية متخصصة من محامين خبراء تساعدكم في فهم حقوقكم والتزاماتكم واتخاذ القرارات القانونية الصحيحة.','description_en'=>'Expert legal consultations helping you understand rights, obligations, and make correct legal decisions.','icon'=>'fas fa-balance-scale','show_on_home'=>1],
['title_ar'=>'التمثيل القضائي','title_en'=>'Court Representation','description_ar'=>'تمثيل قانوني كامل أمام جميع المحاكم والهيئات القضائية في الدعاوى المدنية والتجارية والجنائية.','description_en'=>'Full legal representation before all courts in civil, commercial, and criminal cases.','icon'=>'fas fa-gavel','show_on_home'=>1],
['title_ar'=>'قانون الشركات','title_en'=>'Corporate Law','description_ar'=>'خدمات قانونية شاملة للشركات تشمل التأسيس والدمج والاستحواذ وحوكمة الشركات والامتثال التنظيمي.','description_en'=>'Comprehensive corporate legal services including formation, merger, acquisition, and compliance.','icon'=>'fas fa-building','show_on_home'=>1],
['title_ar'=>'قانون العقارات','title_en'=>'Real Estate Law','description_ar'=>'خدمات قانونية عقارية تشمل صياغة العقود ومراجعة صفقات البيع والشراء وحل النزاعات العقارية.','description_en'=>'Real estate legal services including contract drafting, transaction review, and dispute resolution.','icon'=>'fas fa-file-contract','show_on_home'=>1],
['title_ar'=>'قانون الأسرة','title_en'=>'Family Law','description_ar'=>'قضايا الأحوال الشخصية والأسرة بما يشمل الطلاق والحضانة والنفقة والميراث والتوكيلات الشرعية.','description_en'=>'Personal status and family cases including divorce, custody, alimony, inheritance, and legal powers.','icon'=>'fas fa-users','show_on_home'=>1],
['title_ar'=>'التحكيم وتسوية النزاعات','title_en'=>'Arbitration & Mediation','description_ar'=>'خدمات التحكيم والتوفيق وتسوية النزاعات البديلة بطرق سريعة ومحفوفة بالسرية للعلاقات التجارية.','description_en'=>'Arbitration, mediation, and alternative dispute resolution for commercial relationships.','icon'=>'fas fa-handshake','show_on_home'=>1],
],
'testimonials'=>[
['client_name'=>'عبدالرحمن السبيعي','client_title'=>'رجل أعمال','client_title_en'=>'Businessman','content'=>'مكتب محاماة محترف ساعدني في تسوية نزاع تجاري معقد. خبرة قانونية عالية ونتائج ممتازة.','content_en'=>'Professional law firm that helped settle a complex commercial dispute. Excellent legal expertise and results.','rating'=>5],
['client_name'=>'سارة القرني','client_title'=>'سيدة أعمال','client_title_en'=>'Businesswoman','content'=>'استشاراتهم القانونية في تأسيس شركتي كانت قيمة جداً. فريق متميز وملتزم بالسرية التامة.','content_en'=>'Their legal consulting for company formation was invaluable. Distinguished team with full confidentiality.','rating'=>5],
['client_name'=>'فهد المطيري','client_title'=>'مدير تنفيذي','client_title_en'=>'CEO','content'=>'يمثلون شركتنا في جميع القضايا القانونية باحترافية عالية. نسبة نجاح ممتازة في القضايا.','content_en'=>'They represent our company in all legal matters professionally. Excellent success rate.','rating'=>5],
['client_name'=>'نورة العتيبي','client_title'=>'عميلة','client_title_en'=>'Client','content'=>'تعاملوا مع قضيتي بعناية فائقة وأنهوها بسرعة. محامون ذوو خبرة وكفاءة عالية.','content_en'=>'Handled my case with great care and resolved it quickly. Experienced, highly competent lawyers.','rating'=>5],
],
'contact'=>['phone'=>'+966503344556','whatsapp'=>'+966503344556','email'=>'info@aladllaw.sa','address'=>'الرياض، حي العليا، برج العدل، المملكة العربية السعودية','working_hours'=>'السبت - الخميس: 8 صباحاً - 6 مساءً'],
'features'=>[
['title_ar'=>'خبرة قانونية واسعة','title_en'=>'Vast Legal Experience','description_ar'=>'أكثر من ٢٥ عاماً من الخبرة في جميع فروع القانون السعودي والمعاملات الدولية.','description_en'=>'25+ years of experience in all branches of Saudi law and international transactions.','icon'=>'fas fa-gavel'],
['title_ar'=>'سرية تامة','title_en'=>'Full Confidentiality','description_ar'=>'نلتزم بأعلى معايير السرية والأمانة في جميع المعاملات والقضايا دون استثناء.','description_en'=>'We adhere to the highest confidentiality and integrity standards without exception.','icon'=>'fas fa-lock'],
['title_ar'=>'فريق متخصص','title_en'=>'Specialized Team','description_ar'=>'فريق من أكثر من ٣٠ محامياً ومستشاراً قانونياً متخصصاً في مختلف فروع القانون.','description_en'=>'30+ lawyers and legal advisors specialized in various law branches.','icon'=>'fas fa-users'],
['title_ar'=>'نتائج مثبتة','title_en'=>'Proven Results','description_ar'=>'سجل حافل بالنجاحات في أكثر من ٥٠٠٠ قضية بنتائج إيجابية لعملائنا.','description_en'=>'Track record of success in 5,000+ cases with positive outcomes for clients.','icon'=>'fas fa-check-circle'],
['title_ar'=>'دعم متواصل','title_en'=>'Ongoing Support','description_ar'=>'متابعة مستمرة للقضايا والمعاملات مع تحديثات دورية للعملاء حول تطوراتها.','description_en'=>'Continuous case follow-up with regular client updates on developments.','icon'=>'fas fa-headset'],
['title_ar'=>'أسعار عادلة','title_en'=>'Fair Fees','description_ar'=>'أتعاب قانونية شفافة وعادلة مع عروض أسعار واضحة مسبقاً قبل البدء.','description_en'=>'Transparent, fair legal fees with clear quotes provided before starting.','icon'=>'fas fa-file-invoice-dollar'],
],
'stats'=>[
['label_ar'=>'قضية ناجحة','label_en'=>'Successful Cases','value'=>'+5,000','icon'=>'fas fa-gavel'],
['label_ar'=>'عميل موثوق','label_en'=>'Trusted Clients','value'=>'+3,000','icon'=>'fas fa-users'],
['label_ar'=>'محامٍ متخصص','label_en'=>'Specialist Lawyers','value'=>'+30','icon'=>'fas fa-briefcase'],
['label_ar'=>'سنة خبرة','label_en'=>'Years Experience','value'=>'+25','icon'=>'fas fa-trophy'],
],
'faq'=>[
['question_ar'=>'كيف يمكنني حجز استشارة قانونية؟','question_en'=>'How can I book a legal consultation?','answer_ar'=>'يمكنكم الحجز عبر الهاتف أو الموقع أو زيارة المكتب. نوفر استشارة أولية مجانية لفهم القضية.','answer_en'=>'Book via phone, website, or office visit. Free initial consultation available.','category'=>'استشارات'],
['question_ar'=>'ما مجالات القانون التي تتخصصون فيها؟','question_en'=>'What law areas do you specialize in?','answer_ar'=>'نعمل في جميع فروع القانون: مدني، تجاري، جنائي، عقاري، أحوال شخصية، إداري، عمالي.','answer_en'=>'All law branches: civil, commercial, criminal, real estate, personal status, administrative, labor.','category'=>'تخصصات'],
['question_ar'=>'هل تتعاملون مع القضايا الدولية؟','question_en'=>'Do you handle international cases?','answer_ar'=>'نعم، لدينا فريق متخصص في القانون الدولي والمعاملات العابرة للحدود والتحكيم الدولي.','answer_en'=>'Yes, we have a team for international law, cross-border transactions, and international arbitration.','category'=>'خدمات'],
['question_ar'=>'ما سياسة الأتعاب لديكم؟','question_en'=>'What is your fee policy?','answer_ar'=>'أتعاب شفافة معروفة مسبقاً. نقدم خيارات الدفع بالساعة أو بنسبية حسب نوع القضية.','answer_en'=>'Transparent fees known in advance. Hourly or contingency options depending on case type.','category'=>'أسعار'],
['question_ar'=>'هل تضمنون سرية المعلومات؟','question_en'=>'Do you guarantee information confidentiality?','answer_ar'=>'بالتأكيد، السرية التامة هي من أسس عملنا مع التزام قانوني وأخلاقي صارم.','answer_en'=>'Absolutely, full confidentiality is a core principle with strict legal and ethical commitment.','category'=>'سرية'],
['question_ar'=>'هل تقدمون خدمات عن بُعد؟','question_en'=>'Do you offer remote services?','answer_ar'=>'نعم، نقدم استشارات ومتابعات عن بُعد عبر الفيديو والبريد الإلكتروني والتطبيق.','answer_en'=>'Yes, remote consultations and follow-ups via video, email, and app.','category'=>'خدمات'],
],
],

// ─── Theme 12: Fitness ───────────────────────────────────────────
12 => [
'slug'=>'fitness','name_ar'=>'أبطال الصحة','name_en'=>'Health Champions','gallery_color'=>'16a34a',
'hero_title'=>'اصنع أجسادكم مع أبطال الصحة','hero_title_en'=>'Build Your Body with Health Champions',
'hero_subtitle'=>'لياقتكم هي أثمن ما تملكون','hero_subtitle_en'=>'Your Fitness Is Your Most Valuable Asset',
'hero_description'=>'نادي أبطال الصحة الرياضي المتكامل يقدم برامج لياقة بدنية شخصية وجماعية بإشراف مدربين محترفين مع أحدث الأجهزة الرياضية.','hero_description_en'=>'Health Champions Sports Club offers personalized and group fitness programs supervised by professional trainers with the latest sports equipment.',
'hero_button_text'=>'ابدأ رحلتك','hero_button_text_en'=>'Start Your Journey',
'about_title'=>'من نحن','about_title_en'=>'About Us',
'about_content'=>'تأسس نادي أبطال الصحة عام ٢٠١٧ ليكون الوجهة الأولى لعشاق اللياقة البدنية والصحة في المملكة. نمتلك مساحة تزيد عن ٣٠٠٠ متر مربع مجهزة بأحدث الأجهزة والتجهيزات الرياضية العالمية. فريقنا يضم أكثر من ٤٠ مدرباً معتمداً من جهات رياضية دولية. نقدم برامج متنوعة تشمل التمارين الشخصية والجماعية والتغذية والعلاج الطبيعي ونفخر بضم أكثر من ١٠ آلاف عضو.','about_content_en'=>'Founded in 2017, Health Champions is a 3,000+ sqm facility with 40+ internationally certified trainers, offering personal training, group classes, nutrition, and physiotherapy to 10,000+ members.',
'services'=>[
['title_ar'=>'التدريب الشخصي','title_en'=>'Personal Training','description_ar'=>'جلسات تدريب شخصية مخصصة مع مدرب معتمد يضع خطة تدريب فردية حسب أهدافكم وقدراتكم البدنية.','description_en'=>'Custom personal training sessions with a certified trainer designing individual plans based on your goals.','icon'=>'fas fa-dumbbell','show_on_home'=>1],
['title_ar'=>'التمارين الجماعية','title_en'=>'Group Classes','description_ar'=>'فصول جماعية متنوعة تشمل اليوغا والبيلاتس وكروسفيت وزومبا والكيك بوكسينج بجداول يومية.','description_en'=>'Diverse group classes including yoga, Pilates, CrossFit, Zumba, and kickboxing with daily schedules.','icon'=>'fas fa-users','show_on_home'=>1],
['title_ar'=>'التغذية الصحية','title_en'=>'Nutrition Planning','description_ar'=>'خطط غذائية مخصصة من أخصائيين تغذية معتمدين تتوافق مع أهداف اللياقة والصحة العامة.','description_en'=>'Custom nutrition plans from certified dietitians aligned with your fitness and health goals.','icon'=>'fas fa-apple-alt','show_on_home'=>1],
['title_ar'=>'العلاج الطبيعي الرياضي','title_en'=>'Sports Physiotherapy','description_ar'=>'جلسات علاج طبيعي متخصصة للإصابات الرياضية وإعادة التأهيل بأساليب حديثة ومعتمدة.','description_en'=>'Specialized physiotherapy for sports injuries and rehabilitation using modern approved methods.','icon'=>'fas fa-hand-holding-medical','show_on_home'=>1],
['title_ar'=>'برامج إنقاص الوزن','title_en'=>'Weight Loss Programs','description_ar'=>'برامج شاملة لإنقاص الوزن تجمع بين التمارين الموجهة والتغذية السليمة والمتابعة الدورية.','description_en'=>'Comprehensive weight loss programs combining guided exercise, proper nutrition, and follow-up.','icon'=>'fas fa-weight','show_on_home'=>1],
['title_ar'=>'بناء العضلات','title_en'=>'Muscle Building','description_ar'=>'برامج متخصصة لبناء وتقوية العضلات مع خطط تدريبية مكثفة ونصائح غذائية للمكملات.','description_en'=>'Specialized muscle building programs with intensive training plans and supplement nutrition advice.','icon'=>'fas fa-fire','show_on_home'=>1],
],
'testimonials'=>[
['client_name'=>'ماجد الشمري','client_title'=>'لاعب كرة قدم','client_title_en'=>'Football Player','content'=>'التدريب الشخصي ساعدني في تحسين أدائي الرياضي بشكل كبير. مدربون محترفون وذوو خبرة.','content_en'=>'Personal training greatly improved my athletic performance. Professional, experienced trainers.','rating'=>5],
['client_name'=>'ريم القرني','client_title'=>'محاسبة','client_title_en'=>'Accountant','content'=>'خسرت ١٥ كيلو خلال ٣ أشهر بفضل برامجهم المتكاملة. التغذية والتدريب كانا ممتازين.','content_en'=>'Lost 15 kg in 3 months with their integrated programs. Nutrition and training were excellent.','rating'=>5],
['client_name'=>'سلطان الدوسري','client_title'=>'مهندس برمجيات','client_title_en'=>'Software Engineer','content'=>'الجو في النادي محفز والأجهزة حديثة ونظيفة. أفضل نادي رياضي زرته في الرياض.','content_en'=>'Motivating atmosphere, modern clean equipment. Best gym I have visited in Riyadh.','rating'=>5],
['client_name'=>'لمياء العنزي','client_title'=>'مدربة يوغا','client_title_en'=>'Yoga Instructor','content'=>'فصول اليوغا مذهلة والمدربة متعاونة. المكان مريح والإضاءة والتهوية ممتازتان.','content_en'=>'Amazing yoga classes with a cooperative instructor. Comfortable space with excellent lighting and ventilation.','rating'=>5],
],
'contact'=>['phone'=>'+966504455667','whatsapp'=>'+966504455667','email'=>'info@healthchampions.sa','address'=>'الرياض، حي الصحافة، المملكة العربية السعودية','working_hours'=>'يومياً: 5 صباحاً - 12 منتصف الليل'],
'features'=>[
['title_ar'=>'مدربون معتمدون','title_en'=>'Certified Trainers','description_ar'=>'أكثر من ٤٠ مدرباً حاصلين على شهادات دولية في التدريب الرياضي والعلاج الطبيعي.','description_en'=>'40+ trainers with international sports training and physiotherapy certifications.','icon'=>'fas fa-award'],
['title_ar'=>'أجهزة حديثة','title_en'=>'Modern Equipment','description_ar'=>'أكثر من ٢٠٠ جهاز رياضي من أحدث الماركات العالمية بصيانة دورية مستمرة.','description_en'=>'200+ machines from top global brands with regular ongoing maintenance.','icon'=>'fas fa-dumbbell'],
['title_ar'=>'مساحة واسعة','title_en'=>'Spacious Facility','description_ar'=>'مساحة تزيد عن ٣٠٠٠ متر مربع تشمل صالة أوزان وصالات جماعية ومسبح وساونا.','description_en'=>'3,000+ sqm including weights area, group halls, pool, and sauna.','icon'=>'fas fa-expand-arrows-alt'],
['title_ar'=>'برامج مخصصة','title_en'=>'Customized Programs','description_ar'=>'برامج تدريبية وتغذية مصممة خصيصاً لكل عضو حسب أهدافه وقدراته البدنية.','description_en'=>'Training and nutrition programs custom-designed for each member based on goals and abilities.','icon'=>'fas fa-clipboard-list'],
['title_ar'=>'جلسات مرنة','title_en'=>'Flexible Hours','description_ar'=>'نفتح أبوابنا يومياً من ٥ صباحاً حتى منتصف الليل لتتناسب مع جميع الجداول.','description_en'=>'Open daily 5 AM to midnight to fit all schedules.','icon'=>'fas fa-clock'],
['title_ar'=>'بيئة نظيفة','title_en'=>'Clean Environment','description_ar'=>'نلتزم بأعلى معايير النظافة والتعقيم في جميع المرافق والأجهزة بشكل يومي.','description_en'=>'Highest hygiene and sanitization standards maintained daily across all facilities and equipment.','icon'=>'fas fa-shield-halved'],
],
'stats'=>[
['label_ar'=>'عضو نشط','label_en'=>'Active Members','value'=>'+10,000','icon'=>'fas fa-users'],
['label_ar'=>'مدرب معتمد','label_en'=>'Certified Trainers','value'=>'+40','icon'=>'fas fa-award'],
['label_ar'=>'جهاز رياضي','label_en'=>'Equipment Pieces','value'=>'+200','icon'=>'fas fa-dumbbell'],
['label_ar'=>'سنة خبرة','label_en'=>'Years Experience','value'=>'+7','icon'=>'fas fa-trophy'],
],
'faq'=>[
['question_ar'=>'كيف يمكنني الاشتراك في النادي؟','question_en'=>'How can I join the club?','answer_ar'=>'يمكنكم الاشتراك عبر الموقع أو زيارة النادي مع اختيار الباقة المناسبة: شهرية أو سنوية.','answer_en'=>'Subscribe via website or visit the club. Monthly and annual packages available.','category'=>'اشتراك'],
['question_ar'=>'هل يوجد اشتراك تجريبي؟','question_en'=>'Is there a trial membership?','answer_ar'=>'نعم، نوفر يوم تجريبي مجاني لتجربة جميع المرافق والفصول قبل الاشتراك.','answer_en'=>'Yes, a free trial day to experience all facilities and classes before subscribing.','category'=>'اشتراك'],
['question_ar'=>'ما أنواع الفصول المتاحة؟','question_en'=>'What classes are available?','answer_ar'=>'يوغا، بيلاتس، كروسفيت، زومبا، كيك بوكسينج، سباحة، دورات مياه، وتدريب دائري.','answer_en'=>'Yoga, Pilates, CrossFit, Zumba, kickboxing, swimming, aqua, and circuit training.','category'=>'برامج'],
['question_ar'=>'هل يوجد مدربون للسيدات؟','question_en'=>'Are there female trainers?','answer_ar'=>'نعم، لدينا قسم مستقل للسيدات مع مدربات معتمدات وجدول فصول خاص.','answer_en'=>'Yes, separate women section with certified female trainers and dedicated class schedule.','category'=>'نسائي'],
['question_ar'=>'ما تكلفة الاشتراك الشهري؟','question_en'=>'How much is the monthly membership?','answer_ar'=>'أسعار تبدأ من ٢٠٠ ريال شهرياً مع خصومات على الاشتراكات السنوية.','answer_en'=>'Prices start from 200 SAR/month with discounts on annual memberships.','category'=>'أسعار'],
['question_ar'=>'هل يوجد مسبح وساونا؟','question_en'=>'Is there a pool and sauna?','answer_ar'=>'نعم، مسبح أولمبي ومسبح للأطفال وساونا وجاكوزي متاحة لجميع الأعضاء.','answer_en'=>'Yes, Olympic pool, children pool, sauna, and jacuzzi available for all members.','category'=>'مرافق'],
],
],

];

// ══════════════════════════════════════════════════════════════════════
//  Seed all themes
// ══════════════════════════════════════════════════════════════════════
bold("\n━━━ Seeding all 12 themes ━━━\n");
foreach ($themes as $id => $t) {
    try {
        seedTheme($id, $t);
        green("  ✓ {$t['slug']} — {$t['name_ar']} ... SUCCESS");
    } catch (PDOException $e) {
        red("  ✗ {$t['slug']} ... FAILED — ".$e->getMessage());
    }
}

bold("\n━━━ Summary ━━━");
$themeCount = count($themes);
$expectedC = $themeCount * 33; // 4 hero + 2 about + 6 services + 4 testimonials + 1 contact + 6 features + 4 stats + 6 faq
$expectedM = $themeCount * 18; // 1 logo + 1 banner + 6 service + 6 gallery + 4 partner
cyan("  Themes seeded:    {$themeCount}");
cyan("  Content rows:     {$totalC} (expected ~{$expectedC})");
cyan("  Media rows:       {$totalM} (expected ~{$expectedM})");
if ($totalC >= $expectedC && $totalM >= $expectedM) {
    green("  ✓ All rows inserted successfully!");
} else {
    red("  ✗ Warning: Row count mismatch — please review.");
}
echo "\n";
