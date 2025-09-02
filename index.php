<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/auth.php';
?>
<!doctype html>
<html lang="fa" dir="rtl" class="dark:bg-neutral-950 bg-white">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>فیلمارون</title>
  <link rel="alternate" hrefLang="fa" href="<?php echo base_url(); ?>" />
  <meta name="description" content="جایی برای دانلود فیلم و سریال ها">
  <meta property="og:title" content="فیلمارون"><meta property="og:description" content="نمونه رابط کاربری با PHP + Tailwind">
  <meta property="og:type" content="website"><meta property="og:url" content="<?php echo base_url(); ?>">
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>(function(){const saved=localStorage.getItem('theme'); if(saved==='dark') document.documentElement.classList.add('dark');})();</script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="/public/assets/css/styles.css">
</head>
<body class="min-h-screen text-neutral-900 dark:text-neutral-50 bg-white dark:bg-neutral-950" style="background-color: rgba(13, 21, 34, 0.49);">
<?php include __DIR__ . '/components/header.php'; ?>
<main class="max-w-7xl mx-auto px-4">

<div class="mt-4 mb-6 glass rounded-2xl p-4 flex items-center justify-between" role="status" aria-live="polite">
  <p>به تلگرام ما بپیوندید <a href="https://t.me/filmaron" class="underline" target="_blank"><span class="sr-only">تلگرام فیلمارون</span><lucide-telegram></a></p>
  <button class="px-3 py-2 rounded-xl border border-black/10" onclick="this.closest('.glass').remove()">بستن</button>
</div>
<section aria-label="محتوای داغ" class="space-y-3">
  <div class="flex items-center justify-between"><h2 class="text-lg font-bold">پرطرفدارها</h2></div>
  <div class="overflow-x-auto no-scrollbar" role="region" aria-roledescription="اسلایدر">
    <div class="flex gap-3 min-w-max pb-2">
      <?php require_once __DIR__ . '/includes/db.php';
        $rows = $pdo->query("SELECT * FROM titles ORDER BY score DESC LIMIT 10")->fetchAll();
        foreach($rows as $title){ $genres = $pdo->query("SELECT g.* FROM genres g JOIN title_genres tg ON g.id=tg.genre_id WHERE tg.title_id={$title['id']}")->fetchAll(); include __DIR__ . '/components/card.php'; } ?>
    </div>
  </div>
</section>
<section class="mt-10 space-y-3">
  <div class="flex items-center justify-between"><h2 class="text-lg font-bold">تازه‌ها</h2><a class="text-sm underline" href="/filmaron/series.php">مشاهده همه</a></div>
  <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
    <?php $rows = $pdo->query("SELECT * FROM titles ORDER BY created_at DESC LIMIT 12")->fetchAll();
      foreach($rows as $title){ $genres = $pdo->query("SELECT g.* FROM genres g JOIN title_genres tg ON g.id=tg.genre_id WHERE tg.title_id={$title['id']}")->fetchAll(); include __DIR__ . '/components/card.php'; } ?>
  </div>
</section>
<section class="mt-12">
  <div class="glass rounded-3xl p-6 flex flex-col md:flex-row items-center justify-between gap-4">
    <div class="space-y-2"><h3 class="text-xl font-bold">اپلیکیشن دراما دی‌ال</h3><p class="text-sm text-black/70 dark:text-white/70">دانلود سریع‌تر، اعلان بروزرسانی‌ها و پخش آنلاین در موبایل.</p></div>
    <a href="#" class="px-4 py-3 rounded-2xl bg-black text-white dark:bg-white dark:text-black">دانلود اپ</a>
  </div>
</section>

</main>
<?php include __DIR__ . '/components/footer.php'; ?>
<script src="/public/assets/js/main.js"></script>
</body></html>
