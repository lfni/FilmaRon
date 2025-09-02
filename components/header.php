<?php
// header.php
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>فیلمارون</title>

  <!-- CSS -->
  <link rel="stylesheet" href="/filmaron/public/assets/css/style.css">
  <script src="https://kit.fontawesome.com/0ebc5070c5.js" crossorigin="anonymous"></script>
</head>
<body>

<header class="bg-white dark:bg-neutral-900 shadow-md fixed w-full top-0 z-50">
  <div class="container mx-auto px-4 flex items-center justify-between h-16">
    
    <!-- Logo -->
    <a href="index.php" class="text-xl font-bold text-blue-600 dark:text-blue-400">
      فیلمارون
    </a>

    <!-- Menu -->
    <nav class="hidden md:flex gap-6 text-sm font-medium">
      <a href="index.php" class="hover:text-blue-500">خانه</a>
      <a href="movies.php" class="hover:text-blue-500">فیلم‌ها</a>
      <a href="series.php" class="hover:text-blue-500">سریال‌ها</a>
          <div class="relative">
      <button id="searchToggle" class="text-gray-600 dark:text-gray-300 hover:text-blue-500">
        <i class="fa-solid fa-magnifying-glass"></i>
      </button>
      <div id="searchBox" class="absolute left-0 mt-2 hidden w-64 bg-white dark:bg-neutral-800 shadow-lg rounded-lg p-3">
        <form action="/filmaron/search.php" method="get" class="flex gap-2">
          <input 
            type="text" 
            name="q" 
            placeholder="جستجوی فیلم یا سریال..." 
            class="w-full px-3 py-2 rounded-lg border dark:border-neutral-700 dark:bg-neutral-900 focus:ring-2 focus:ring-blue-500"
            required
          />
          <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">جستجو</button>
        </form>
      </div>
    </div>
    </nav>

    <!-- Search -->


    <!-- Auth Buttons -->
    <div>
      <?php if(isset($_SESSION['user'])): ?>
        <a href="/filmaron/auth/logout.php" class="text-sm text-red-500">خروج</a>
      <?php else: ?>
        <a href="/filmaron/auth/login.php" class="px-3 py-2 text-sm rounded-xl bg-black text-white dark:bg-white dark:text-black hover:opacity-90">ورود/عضویت</a>
      <?php endif; ?>
    </div>
  </div>
</header>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const toggle = document.getElementById("searchToggle");
    const box = document.getElementById("searchBox");
    toggle.addEventListener("click", () => {
      box.classList.toggle("hidden");
    });
  });
</script>
