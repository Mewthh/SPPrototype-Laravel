function escapeHtml(str) {
  if (!str) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

function getSlugFromUrl() {
  const urlParams = new URLSearchParams(window.location.search);
  const querySlug = urlParams.get('slug');
  if (querySlug) return querySlug;

  const path = window.location.pathname;
  const match = path.match(/\/news\/([^/?#]+)/i);
  if (match && match[1]) {
    return match[1];
  }
  return '';
}

function renderArticle() {
  const root = document.getElementById('article-root');
  if (!root) return;

  if (root.dataset.serverRendered === 'true') {
    return;
  }

  const slug = getSlugFromUrl();

  if (!slug) {
    root.innerHTML = `
      <div class="article-not-found">
        <h2>No Article Specified</h2>
        <p>Please select an article from the news listing.</p>
        <a href="index.html#news" class="button button-primary">← View All News</a>
      </div>
    `;
    return;
  }

  const post = findVisiblePostBySlug(slug, 'announcement', 'News');

  if (!post) {
    document.title = 'Article Not Found | Samahang Pisika ng Pilipinas';
    root.innerHTML = `
      <div class="article-not-found">
        <h2>Article Not Found</h2>
        <p>This article is not available, has been archived, or is not yet published.</p>
        <a href="index.html#news" class="button button-primary">← Back to News</a>
      </div>
    `;
    return;
  }

  document.title = `${post.title} | Samahang Pisika ng Pilipinas`;
  const metaDesc = document.querySelector('meta[name="description"]');
  if (metaDesc) {
    metaDesc.setAttribute('content', getItemExcerpt(post, 150));
  }

  const dateFormatted = formatDate(post.published_at || post.publishDate);
  const imageSrc = post.coverImage || post.image || getDefaultImageSvg(post.title);
  const fullContent = post.content || post.body || '';

  const paragraphs = fullContent
    .split(/\n\s*\n/)
    .map((p) => p.trim())
    .filter(Boolean)
    .map((p) => `<p>${escapeHtml(p)}</p>`)
    .join('');

  root.innerHTML = `
    <article class="article-container">
      <div class="article-top-nav">
        <a href="index.html#news" class="button button-secondary">← Back to News</a>
      </div>

      <header class="article-header">
        <div class="article-meta-row">
          <span class="card-chip">News</span>
          <time class="card-meta-line" datetime="${escapeHtml(post.published_at || post.publishDate || '')}">
            Published on ${dateFormatted}
          </time>
        </div>
        <h1 class="article-title">${escapeHtml(post.title)}</h1>
      </header>

      <div class="article-hero-media">
        <img src="${imageSrc}" alt="${escapeHtml(post.title)}" />
      </div>

      <div class="article-body">
        ${paragraphs || `<p>${escapeHtml(fullContent)}</p>`}
      </div>

      <footer class="article-footer">
        <a href="index.html#news" class="button button-secondary">← Back to News</a>
      </footer>
    </article>
  `;
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
    themeToggle.title = nextTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode';
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

document.addEventListener('DOMContentLoaded', renderArticle);
