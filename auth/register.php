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

<?php if(is_post()){ require_once __DIR__ . '/includes/db.php';
  $u = trim($_POST['username'] ?? ''); $e = trim($_POST['email'] ?? ''); $p = $_POST['password'] ?? '';
  if(!$u || !$e || !$p){ $error='همه فیلدها الزامی است.'; }
  else { try{ $id = create_user($u,$e,$p); $user = find_user_by_username_or_email($u); login_user($user); header('Location: ' . base_url()); exit; } catch(Exception $ex){ $error='نام کاربری یا ایمیل تکراری است.'; } } }
?>
<section class="mt-12 max-w-md mx-auto glass rounded-2xl p-6" dir="rtl">
  <h1 class="text-xl font-bold mb-4">ثبت‌نام</h1>
  <?php if(!empty($error)): ?><div class="alert glass rounded-xl p-3 mb-3 text-sm"><?php echo h($error); ?></div><?php endif; ?>
  <form method="post" class="space-y-3">
    <input name="username" required placeholder="نام کاربری" class="w-full px-3 py-2 rounded-xl border border-black/10 dark:border-white/10 bg-white/60 dark:bg-neutral-900/60"/>
    <input name="email" type="email" required placeholder="ایمیل" class="w-full px-3 py-2 rounded-xl border border-black/10 dark:border-white/10 bg-white/60 dark:bg-neutral-900/60"/>
    <input name="password" type="password" required placeholder="رمز عبور" class="w-full px-3 py-2 rounded-xl border border-black/10 dark:border-white/10 bg-white/60 dark:bg-neutral-900/60"/>
    <button class="w-full px-4 py-2 rounded-2xl bg-black text-white dark:bg-white dark:text-black">ثبت‌نام</button>
  </form>
  <p class="mt-3 text-sm">حساب دارید؟ <a class="underline" href="<?php echo base_url('/filmaron/auth/login.php'); ?>">ورود</a></p>
</section>

</main>
<?php include __DIR__ . '/components/footer.php'; ?>
<script src="/public/assets/js/main.js"></script>
</body></html>
