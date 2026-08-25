const KNOWN_YEARS = ['2024', '2025', '2026'];
const params = new URLSearchParams(window.location.search);
const year = KNOWN_YEARS.includes(params.get('year')) ? params.get('year') : KNOWN_YEARS[0];

document.title = `SPP ${year} | Samahang Pisika ng Pilipinas`;

const metaDesc = document.querySelector('meta[name="description"]');
if (metaDesc) {
  metaDesc.setAttribute(
    'content',
    `SPP ${year} conference year page \u2014 Samahang Pisika ng Pilipinas.`
  );
}

const desktopActiveLink = document.getElementById(`nav-year-${year}`);
if (desktopActiveLink) {
  desktopActiveLink.classList.add('active');
  desktopActiveLink.setAttribute('aria-current', 'page');
}

const mobileActiveLink = document.getElementById(`mobile-nav-year-${year}`);
if (mobileActiveLink) {
  mobileActiveLink.classList.add('active');
  mobileActiveLink.setAttribute('aria-current', 'page');
}

const themeToggle = document.querySelector('[data-theme-toggle]');

function setTheme(theme) {
  const nextTheme = theme === 'dark' ? 'dark' : 'light';
  document.documentElement.setAttribute('data-theme', nextTheme);

  if (themeToggle) {
    themeToggle.setAttribute(
      'aria-label',
      nextTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'
    );
  }

  localStorage.setItem('spp-theme', nextTheme);
}

const savedTheme = localStorage.getItem('spp-theme');
const prefersDark =
  window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
setTheme(savedTheme || (prefersDark ? 'dark' : 'light'));

themeToggle?.addEventListener('click', () => {
  const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
  setTheme(isDark ? 'light' : 'dark');
});
