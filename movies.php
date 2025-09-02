<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/auth.php';
?>
<!doctype html>
<html lang="fa" dir="rtl" class="dark:bg-neutral-950 bg-white">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>دراما دی‌ال</title>
  <link rel="alternate" hrefLang="fa" href="<?php echo base_url(); ?>" />
  <meta name="description" content="دانلود و تماشای آنلاین فیلم و سریال — طراحی نمونه.">
  <meta property="og:title" content="دراما دی‌ال"><meta property="og:description" content="نمونه رابط کاربری با PHP + Tailwind">
  <meta property="og:type" content="website"><meta property="og:url" content="<?php echo base_url(); ?>">
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>(function(){const saved=localStorage.getItem('theme'); if(saved==='dark') document.documentElement.classList.add('dark');})();</script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="/public/assets/css/styles.css">
</head>
<body class="min-h-screen text-neutral-900 dark:text-neutral-50 bg-white dark:bg-neutral-950">
<?php include __DIR__ . '/components/header.php'; ?>
<main class="max-w-7xl mx-auto px-4">

  <section class="mt-6 space-y-4" id="search">
    <h1 class="text-xl font-bold">فیلم‌ها</h1>
    <form class="glass rounded-2xl p-4 grid grid-cols-1 md:grid-cols-4 gap-3" method="get">
      <input type="hidden" name="type" value="movie"/>
      <input name="q" placeholder="جستجو..." value="<?php echo h($_GET['q'] ?? ''); ?>" class="px-3 py-2 rounded-xl border border-black/10 dark:border-white/10 bg-white/60 dark:bg-neutral-900/60"/>
      <input name="genre" placeholder="ژانر (مثلاً درام)" value="<?php echo h($_GET['genre'] ?? ''); ?>" class="px-3 py-2 rounded-xl border"/>
      <input name="country" placeholder="کشور (کد مثل KR)" value="<?php echo h($_GET['country'] ?? ''); ?>" class="px-3 py-2 rounded-xl border"/>
      <select name="mpaa" class="px-3 py-2 rounded-xl border">
        <option value="">رده سنی</option>
        <?php foreach(['G','PG','PG-13','R','NC-17'] as $m): ?>
          <option value="<?php echo $m; ?>" <?php echo (($_GET['mpaa'] ?? '')==$m)?'selected':''; ?>><?php echo $m; ?></option>
        <?php endforeach; ?>
      </select>
      <label class="flex items-center gap-2"><input type="checkbox" name="dub" value="1" <?php echo isset($_GET['dub'])?'checked':''; ?>/> دوبله</label>
      <label class="flex items-center gap-2"><input type="checkbox" name="sub" value="1" <?php echo isset($_GET['sub'])?'checked':''; ?>/> زیرنویس</label>
      <label class="flex items-center gap-2"><input type="checkbox" name="online" value="1" <?php echo isset($_GET['online'])?'checked':''; ?>/> پخش آنلاین</label>
      <div class="flex items-center gap-2">
        <input name="yfrom" placeholder="از سال" value="<?php echo h($_GET['yfrom'] ?? ''); ?>" class="px-3 py-2 rounded-xl border w-full"/>
        <input name="yto" placeholder="تا سال" value="<?php echo h($_GET['yto'] ?? ''); ?>" class="px-3 py-2 rounded-xl border w-full"/>
      </div>
      <div class="md:col-span-4 flex justify-end gap-2">
        <a href="?reset=1" class="px-3 py-2 rounded-xl border">حذف فیلترها</a>
        <button class="px-4 py-2 rounded-2xl bg-black text-white dark:bg-white dark:text-black">جستجو</button>
      </div>
    </form>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
      <?php require_once __DIR__ . '/filters.php';
        list($sql,$params)=build_filters_and_query($_GET, 'movie');
        $stmt=$pdo->prepare($sql); $stmt->execute($params);
        foreach($stmt as $title){ $genres = $pdo->query("SELECT g.* FROM genres g JOIN title_genres tg ON g.id=tg.genre_id WHERE tg.title_id={$title['id']}")->fetchAll(); include __DIR__ . '/components/card.php'; } ?>
    </div>
  </section>

</main>
<?php include __DIR__ . '/components/footer.php'; ?>
<script src="/public/assets/js/main.js"></script>
</body></html>
