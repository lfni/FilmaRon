<?php
?>
<a href="<?php echo base_url('filmaron/title.php?slug=' . urlencode($title['slug'])); ?>" class="group relative block rounded-2xl overflow-hidden shadow-sm border border-black/5 dark:border-white/5 bg-white dark:bg-neutral-900">
  <div class="aspect-[2/3] overflow-hidden bg-neutral-100 dark:bg-neutral-800">
    <img src="<?php echo h($title['poster']); ?>" alt="<?php echo h($title['title_fa']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
  </div>
  <div class="p-3 space-y-2" dir="rtl">
    <div class="flex items-center justify-between gap-2">
      <h3 class="font-bold truncate"><?php echo h($title['title_fa']); ?></h3>
      <div class="flex items-center gap-1 text-xs">
        <?php if($title['imdb']): ?><span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 dark:bg-amber-400/10 dark:text-amber-300">IMDb <?php echo h($title['imdb']); ?></span><?php endif; ?>
        <?php if($title['score']): ?><span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-400/10 dark:text-emerald-300"><?php echo h($title['score']); ?>%</span><?php endif; ?>
      </div>
    </div>
    <div class="flex flex-wrap gap-1">
      <?php if($title['status']): ?>
        <span class="px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-400/10 dark:text-blue-300">
          <?php $map = ['hardsub'=>'هاردساب','softsub'=>'سافت‌ساب','subtitle'=>'زیرنویس','complete'=>'کامل','ongoing'=>'درحال پخش']; echo h($map[$title['status']] ?? $title['status']); ?>
        </span>
      <?php endif; ?>
      <?php foreach(($genres ?? []) as $g): ?><span class="px-2 py-0.5 text-xs rounded-full bg-black/5 dark:bg-white/10"><?php echo h($g['name']); ?></span><?php endforeach; ?>
    </div>
  </div>
  <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/0 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
  <div class="absolute inset-x-3 bottom-3 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
    <button class="px-3 py-2 text-xs rounded-xl bg-gray/90 backdrop-blur hover:bg-gray" aria-label="جزئیات">جزئیات</button>
    <button class="px-3 py-2 text-xs rounded-xl bg-gray/90 backdrop-blur hover:bg-gray" aria-label="افزودن به لیست">افزودن</button>
    <?php if($title['online_play']): ?><button class="px-3 py-2 text-xs rounded-xl bg-gray/90 backdrop-blur hover:bg-gray" aria-label="پخش">پخش</button><?php endif; ?>
  </div>
</a>
