<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';

$q = $_GET['q'] ?? '';
?>
<!doctype html>
<html lang="fa" dir="rtl" class="dark:bg-neutral-950 bg-white">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>جستجو | فیلمارون</title>
  <meta name="description" content="نتایج جستجو در فیلمارون">
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>(function(){const saved=localStorage.getItem('theme'); if(saved==='dark') document.documentElement.classList.add('dark');})();</script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="/filmaron/public/assets/css/style.css">
  <style>
    /* استایل‌های اختصاصی برای صفحه جستجو */
    .glass {
      background: rgba(255,255,255,0.6);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }
    .dark .glass {
      background: rgba(17,17,17,0.5);
    }
    .alert {
      border: 1px solid rgba(255,0,0,0.12);
      box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    }
  </style>
</head>
<body class="min-h-screen text-neutral-900 dark:text-neutral-50 bg-white dark:bg-neutral-950">

<!-- Header -->
<header class="bg-white dark:bg-neutral-900 shadow-md fixed w-full top-0 z-50">
  <div class="container mx-auto px-4 flex items-center justify-between h-16">
    <a href="index.php" class="text-xl font-bold text-blue-600 dark:text-blue-400">فیلمارون</a>
    <nav class="hidden md:flex gap-6 text-sm font-medium">
      <a href="index.php" class="hover:text-blue-500">خانه</a>
      <a href="movies.php" class="hover:text-blue-500">فیلم‌ها</a>
      <a href="series.php" class="hover:text-blue-500">سریال‌ها</a>
    </nav>
    <form action="search.php" method="get" class="flex gap-2">
      <input type="text" name="q" placeholder="جستجوی فیلم یا سریال..."
             class="w-full px-3 py-2 rounded-lg border dark:border-neutral-700 dark:bg-neutral-900 focus:ring-2 focus:ring-blue-500"
             value="<?php echo htmlspecialchars($q); ?>" required>
      <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">جستجو</button>
    </form>
  </div>
</header>

<!-- Main -->
<main class="max-w-7xl mx-auto px-4 mt-24">
  <h1 class="text-xl font-bold mb-6">نتایج جستجو</h1>
  <?php
  if ($q) {
    $stmt = $pdo->prepare("SELECT * FROM titles WHERE title_fa LIKE :q LIMIT 20");
    $stmt->execute(['q' => "%$q%"]);
    $rows = $stmt->fetchAll();
    if ($rows) {
      echo '<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">';
      foreach ($rows as $title) {
        $genres = $pdo->query("SELECT g.* FROM genres g 
                               JOIN title_genres tg ON g.id=tg.genre_id 
                               WHERE tg.title_id={$title['id']}")->fetchAll();
        include __DIR__ . '/components/card.php';
      }
      echo '</div>';
    } else {
      echo '<p class="alert p-4 rounded-lg">هیچ نتیجه‌ای یافت نشد.</p>';
    }
  } else {
    echo '<p class="alert p-4 rounded-lg">لطفاً عبارتی برای جستجو وارد کنید.</p>';
  }
  ?>
</main>

<!-- Footer -->
<footer class="mt-20 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
  <p>© <?php echo date('Y'); ?> فیلمارون — همه حقوق محفوظ است.</p>
</footer>

<script src="/filmaron/public/assets/js/main.js"></script>
</body>
</html>
