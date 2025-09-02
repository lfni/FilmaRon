<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';

// دریافت اطلاعات عنوان و اپیزودها
$slug = $_GET['slug'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM titles WHERE slug=:s LIMIT 1");
$stmt->execute(['s'=>$slug]);
$title = $stmt->fetch();

if(!$title){
    http_response_code(404);
    echo "<div class='py-24 text-center'>عنوان یافت نشد.</div>";
    exit;
}

$genres = $pdo->query("SELECT g.* FROM genres g JOIN title_genres tg ON g.id=tg.genre_id WHERE tg.title_id={$title['id']}")->fetchAll();
$countries = $pdo->query("SELECT c.* FROM countries c JOIN title_countries tc ON c.id=tc.country_id WHERE tc.title_id={$title['id']}")->fetchAll();
$episodes = $pdo->prepare("SELECT * FROM episodes WHERE title_id=:id ORDER BY season, episode");
$episodes->execute(['id'=>$title['id']]);

$user = current_user();
?>
<!doctype html>
<html lang="fa" dir="rtl" class="dark:bg-neutral-950 bg-white">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>فیلمارون</title>
<link rel="alternate" hrefLang="fa" href="<?php echo base_url(); ?>" />
<meta name="description" content="دانلود و تماشای آنلاین فیلم و سریال — فیلمارون.">
<meta property="og:title" content="فیلمارون">
<meta property="og:description" content="نمونه رابط کاربری با PHP + Tailwind">
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo base_url(); ?>">
<script src="https://unpkg.com/lucide@latest"></script>
<script>
(function(){
  const saved = localStorage.getItem('theme'); 
  if(saved==='dark') document.documentElement.classList.add('dark');
})();
</script>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="/public/assets/css/styles.css">
</head>
<body class="min-h-screen text-neutral-900 dark:text-neutral-50 bg-white dark:bg-neutral-950">
<?php include __DIR__ . '/components/header.php'; ?>
<main class="max-w-7xl mx-auto px-4">

<article class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 space-y-4">
    <div class="flex gap-4">
      <div class="w-40 shrink-0 rounded-2xl overflow-hidden shadow border border-black/5 dark:border-white/5">
        <img src="<?php echo h($title['poster']); ?>" alt="<?php echo h($title['title_fa']); ?>" class="w-full h-full object-cover">
      </div>
      <div class="space-y-2" dir="rtl">
        <h1 class="text-2xl font-black"><?php echo h($title['title_fa']); ?></h1>
        <?php if($title['title_en']): ?><p class="text-sm text-black/60 dark:text-white/60"><?php echo h($title['title_en']); ?></p><?php endif; ?>
        <div class="flex flex-wrap gap-2 text-sm">
          <?php foreach($genres as $g): ?><span class="px-2 py-1 rounded-xl bg-black/5 dark:bg-white/10"><?php echo h($g['name']); ?></span><?php endforeach; ?>
        </div>
        <div class="flex gap-3 text-sm text-black/70 dark:text-white/70">
          <?php if($title['year']): ?><span>سال: <?php echo h($title['year']); ?></span><?php endif; ?>
          <?php if($title['mpaa']): ?><span>رده سنی: <?php echo h($title['mpaa']); ?></span><?php endif; ?>
          <?php if($title['imdb']): ?><span>IMDb: <?php echo h($title['imdb']); ?></span><?php endif; ?>
          <?php if($title['score']): ?><span>رضایت: <?php echo h($title['score']); ?>%</span><?php endif; ?>
        </div>
        <?php if($title['updated_note']): ?><div class="text-sm px-3 py-2 rounded-xl bg-blue-100 text-blue-800 dark:bg-blue-400/10 dark:text-blue-300 inline-block"><?php echo h($title['updated_note']); ?></div><?php endif; ?>
      </div>
    </div>
    <section class="space-y-3">
      <h2 class="text-lg font-bold">قسمت‌ها / دانلود</h2>
      <div class="space-y-2">
        <?php foreach($episodes as $ep): ?>
        <div class="p-3 rounded-2xl border border-black/5 dark:border-white/5 flex items-center justify-between gap-2" dir="rtl">
          <div class="space-y-0.5">
            <div class="font-bold">فصل <?php echo (int)$ep['season']; ?> - قسمت <?php echo (int)$ep['episode']; ?><?php if($ep['name']) echo ' — '.h($ep['name']); ?></div>
            <div class="text-xs text-black/60 dark:text-white/60">همه دکمه های دانلود با کیفیت 720 میباشد</div>
          </div>
          <div class="flex items-center gap-2">
            <?php if(!$user): ?>
              <div class="alert glass rounded-2xl p-3 text-sm" role="alert">
                <div>برای دانلود/تماشای آنلاین، ابتدا <strong>ثبت‌نام</strong> یا <strong>وارد</strong> شوید.</div>
                <div class="mt-2 flex gap-2">
                  <a class="px-3 py-2 rounded-xl bg-black text-white dark:bg-white dark:text-black" href="<?php echo base_url('auth/login.php'); ?>">ورود</a>
                  <a class="px-3 py-2 rounded-xl border" href="<?php echo base_url('auth/register.php'); ?>">ثبت‌نام</a>
                </div>
              </div>
            <?php else: ?>
              <a class="px-3 py-2 rounded-xl bg-emerald-600 text-white hover:opacity-90" href="<?php echo h($ep['download_url']); ?>">دانلود</a>
                <a class="px-3 py-2 rounded-2xl bg-indigo-600 text-white hover:opacity-90" href="<?php echo h($ep['stream_url']); ?>">تماشای آنلاین</a>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </section>
  </div>
  <aside class="space-y-4">
    <div class="glass rounded-2xl p-4">
      <h3 class="font-bold mb-2">اطلاعات</h3>
      <ul class="text-sm space-y-1 text-black/70 dark:text-white/70">
        <li>وضعیت: <?php $map=['hardsub'=>'هاردساب','softsub'=>'سافت‌ساب','subtitle'=>'زیرنویس','complete'=>'کامل','ongoing'=>'درحال پخش']; echo h($map[$title['status']] ?? $title['status']); ?></li>
        <li>کشورها: <?php echo implode('، ', array_map(fn($c)=>h($c['name']), $countries)); ?></li>
      </ul>
    </div>
    <div class="glass rounded-2xl p-4">
      <h3 class="font-bold mb-2">ژانرها</h3>
      <div class="flex flex-wrap gap-2">
        <?php foreach($genres as $g): ?>
          <a class="px-2 py-1 rounded-xl border text-sm" href="<?php echo base_url(($title['type']==='movie'?'filmaron/movies.php':'filmaron/series.php') . '?genre=' . urlencode($g['name'])); ?>"><?php echo h($g['name']); ?></a>
        <?php endforeach; ?>
      </div>
    </div>
  </aside>
</article>

</main>
<?php include __DIR__ . '/components/footer.php'; ?>
<script src="/public/assets/js/main.js"></script>
</body></html>
