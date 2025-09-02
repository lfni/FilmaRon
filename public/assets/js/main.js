
document.addEventListener('DOMContentLoaded', () => {
  if (window.lucide) lucide.createIcons();
  const themeToggle = document.getElementById('themeToggle');
  themeToggle?.addEventListener('click', () => {
    const html = document.documentElement;
    const next = html.classList.contains('dark') ? 'light' : 'dark';
    html.classList.toggle('dark');
    localStorage.setItem('theme', next);
  });
  const saved = localStorage.getItem('theme');
  if(saved === 'dark'){ document.documentElement.classList.add('dark'); }
  else if(saved === 'light'){ document.documentElement.classList.remove('dark'); }

  const menuBtn = document.getElementById('menuBtn');
  const mobileNav = document.getElementById('mobileNav');
  menuBtn?.addEventListener('click', ()=> mobileNav?.classList.toggle('hidden'));
});
