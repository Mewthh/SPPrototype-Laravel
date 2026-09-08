/**
 * Samahang Pisika ng Pilipinas (SPP) Unified Client Application
 * Handles theme initialization, public views, content utilities, and dashboard logic.
 */

// ─── Theme Management ────────────────────────────────────────────────────────
function initTheme() {
  const savedTheme = localStorage.getItem('spp-theme');
  const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
  const nextTheme = savedTheme || (prefersDark ? 'dark' : 'light');
  document.documentElement.setAttribute('data-theme', nextTheme);
  if (nextTheme === 'dark') {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }

  const themeToggle = document.querySelector('[data-theme-toggle]');
  if (themeToggle) {
    themeToggle.setAttribute('aria-label', nextTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
    themeToggle.title = nextTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode';
  }
}

function toggleTheme() {
  const isDark = document.documentElement.getAttribute('data-theme') === 'dark' || document.documentElement.classList.contains('dark');
  const nextTheme = isDark ? 'light' : 'dark';
  document.documentElement.setAttribute('data-theme', nextTheme);
  if (nextTheme === 'dark') {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }
  localStorage.setItem('spp-theme', nextTheme);

  const themeToggle = document.querySelector('[data-theme-toggle]');
  if (themeToggle) {
    themeToggle.setAttribute('aria-label', nextTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
    themeToggle.title = nextTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode';
  }
}

initTheme();

// ─── Content Utilities & Storage ──────────────────────────────────────────────
const SPP_STORAGE_KEY = 'spp-admin-posts-v3';

const DEFAULT_POSTS_DATA = [
  { id: 'post-n1', type: 'announcement', title: 'sample text', slug: 'sample-text-n1', section: 'News', status: 'published', publishDate: '2026-08-19', summary: 'sample text.', body: 'sample text.', featured: true },
  { id: 'post-n2', type: 'announcement', title: 'sample text', slug: 'sample-text-n2', section: 'News', status: 'scheduled', publishDate: '2026-08-25', summary: 'sample text.', body: 'sample text.', featured: true },
  { id: 'post-n3', type: 'announcement', title: 'sample text', slug: 'sample-text-n3', section: 'News', status: 'draft', publishDate: '2026-08-10', summary: 'sample text.', body: 'sample text.', featured: false },
  { id: 'post-n4', type: 'announcement', title: 'sample text', slug: 'sample-text-n4', section: 'News', status: 'archived', publishDate: '2026-07-20', summary: 'sample text.', body: 'sample text.', featured: false },
  { id: 'post-n5', type: 'announcement', title: 'sample text', slug: 'sample-text-n5', section: 'News', status: 'published', publishDate: '2026-08-01', summary: 'sample text.', body: 'sample text.', featured: false },
  { id: 'post-n6', type: 'announcement', title: 'sample text', slug: 'sample-text-n6', section: 'News', status: 'draft', publishDate: '2026-07-28', summary: 'sample text.', body: 'sample text.', featured: false },
  { id: 'post-n7', type: 'announcement', title: 'sample text', slug: 'sample-text-n7', section: 'News', status: 'archived', publishDate: '2026-06-15', summary: 'sample text.', body: 'sample text.', featured: false },
  { id: 'post-a1', type: 'event', title: 'sample text', slug: 'sample-text-a1', section: 'Activities', status: 'scheduled', publishDate: '2026-08-28', summary: 'sample text.', body: 'sample text.', featured: true },
  { id: 'post-a2', type: 'event', title: 'sample text', slug: 'sample-text-a2', section: 'Activities', status: 'published', publishDate: '2026-08-22', summary: 'sample text.', body: 'sample text.', featured: true },
  { id: 'post-a3', type: 'event', title: 'sample text', slug: 'sample-text-a3', section: 'Activities', status: 'draft', publishDate: '2026-08-16', summary: 'sample text.', body: 'sample text.', featured: false },
  { id: 'post-a4', type: 'event', title: 'sample text', slug: 'sample-text-a4', section: 'Activities', status: 'archived', publishDate: '2026-07-10', summary: 'sample text.', body: 'sample text.', featured: false },
  { id: 'post-a5', type: 'event', title: 'sample text', slug: 'sample-text-a5', section: 'Activities', status: 'scheduled', publishDate: '2026-08-04', summary: 'sample text.', body: 'sample text.', featured: false },
  { id: 'post-a6', type: 'event', title: 'sample text', slug: 'sample-text-a6', section: 'Activities', status: 'published', publishDate: '2026-07-25', summary: 'sample text.', body: 'sample text.', featured: false },
  { id: 'post-a7', type: 'event', title: 'sample text', slug: 'sample-text-a7', section: 'Activities', status: 'archived', publishDate: '2026-06-01', summary: 'sample text.', body: 'sample text.', featured: false }
];

function generateSlug(text) {
  if (!text) return '';
  return String(text)
    .toLowerCase()
    .trim()
    .replace(/[^\w\s-]/g, '')
    .replace(/[\s_-]+/g, '-')
    .replace(/^-+|-+$/g, '');
}

function getItemSlug(item) {
  if (!item) return '';
  if (item.slug && String(item.slug).trim()) return String(item.slug).trim();
  const fromTitle = generateSlug(item.title);
  if (fromTitle) return fromTitle;
  return item.id || '';
}

function isContentVisible(item) {
  if (!item) return false;
  const status = item.status || 'draft';
  if (status === 'published') return true;
  if (status === 'scheduled') {
    const rawDate = item.published_at || item.publishDate;
    if (!rawDate) return false;
    const pubTime = new Date(rawDate).getTime();
    return !isNaN(pubTime) && pubTime <= Date.now();
  }
  return false;
}

function formatDate(rawDate) {
  if (!rawDate) return 'Recent';
  const date = new Date(rawDate);
  if (isNaN(date.getTime())) return rawDate;
  return new Intl.DateTimeFormat('en-US', { month: 'short', day: 'numeric', year: 'numeric' }).format(date);
}

function getItemExcerpt(item, maxLength = 140) {
  if (!item) return '';
  const excerpt = item.excerpt || item.summary;
  if (excerpt && String(excerpt).trim()) return String(excerpt).trim();
  const content = item.content || item.body || '';
  const plainText = String(content).replace(/<[^>]*>/g, '').trim();
  if (!plainText) return '';
  if (plainText.length <= maxLength) return plainText;
  return plainText.slice(0, maxLength).trim() + '...';
}

function getAllPosts() {
  return [];
}

function getVisiblePostsByType(type, sectionName) {
  const all = getAllPosts();
  return all
    .filter((item) => {
      const matchType = type ? item.type === type : true;
      const matchSection = sectionName ? item.section === sectionName : true;
      return (matchType || matchSection) && isContentVisible(item);
    })
    .sort((a, b) => {
      const dateA = new Date(a.published_at || a.publishDate || a.created_at || 0).getTime();
      const dateB = new Date(b.published_at || b.publishDate || b.created_at || 0).getTime();
      if (dateB !== dateA) {
        return dateB - dateA;
      }
      const createdA = new Date(a.created_at || 0).getTime();
      const createdB = new Date(b.created_at || 0).getTime();
      if (createdB !== createdA) {
        return createdB - createdA;
      }
      const idA = Number(a.id) || 0;
      const idB = Number(b.id) || 0;
      return idB - idA;
    });
}

function findVisiblePostBySlug(slug, type, sectionName) {
  if (!slug) return null;
  const decoded = decodeURIComponent(slug).toLowerCase().trim();
  const visible = getVisiblePostsByType(type, sectionName);
  return (
    visible.find((item) => {
      const itemSlug = getItemSlug(item).toLowerCase();
      const itemId = String(item.id || '').toLowerCase();
      return itemSlug === decoded || itemId === decoded;
    }) || null
  );
}

function paginateItems(items, page = 1, pageSize = 6) {
  const total = items.length;
  const totalPages = Math.max(1, Math.ceil(total / pageSize));
  const currentPage = Math.min(Math.max(1, page), totalPages);
  const start = (currentPage - 1) * pageSize;
  const end = start + pageSize;
  const pageItems = items.slice(start, end);
  return {
    items: pageItems,
    currentPage,
    totalPages,
    totalItems: total,
    pageSize,
    hasNext: currentPage < totalPages,
    hasPrev: currentPage > 1
  };
}

function getDefaultImageSvg(title = 'SPP') {
  const safeTitle = String(title).slice(0, 20);
  return `data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 520'><rect width='800' height='520' rx='24' fill='%23e5e7eb'/><rect x='32' y='32' width='736' height='456' rx='18' fill='%23f8fafc' stroke='%23cbd5e1'/><text x='50%25' y='50%25' text-anchor='middle' dominant-baseline='middle' fill='%236b7280' font-family='Segoe UI,Arial,sans-serif' font-size='32'>${encodeURIComponent(safeTitle)}</text></svg>`;
}

function escapeHtml(str) {
  if (!str) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

// ─── Public News & Year Interactivity ─────────────────────────────────────────
const NEWS_PAGE_SIZE = 6;
let currentNewsPage = 1;

function renderPublicNews(page = 1) {
  const newsGrid = document.getElementById('news-grid');
  const paginationEl = document.getElementById('news-pagination');
  if (!newsGrid) return;

  if (newsGrid.dataset.serverRendered === 'true') {
    return;
  }

  const visibleNews = getVisiblePostsByType('announcement', 'News');

  if (!visibleNews.length) {
    newsGrid.innerHTML = `
      <div class="news-empty-state">
        <p>No published news or announcements at this time.</p>
      </div>
    `;
    if (paginationEl) paginationEl.style.display = 'none';
    return;
  }

  const paginated = paginateItems(visibleNews, page, NEWS_PAGE_SIZE);
  currentNewsPage = paginated.currentPage;

  newsGrid.innerHTML = paginated.items
    .map((post) => {
      const slug = getItemSlug(post);
      const title = escapeHtml(post.title);
      const excerpt = escapeHtml(getItemExcerpt(post, 130));
      const dateFormatted = formatDate(post.published_at || post.publishDate);
      const imageSrc = post.image_url || post.coverImage || post.image || getDefaultImageSvg(post.title);
      const detailUrl = `/news?slug=${encodeURIComponent(slug)}`;

      return `
        <article class="content-card news-card-item" data-slug="${escapeHtml(slug)}">
          <a href="${detailUrl}" class="card-image-link" tabindex="-1" aria-hidden="true">
            <img src="${imageSrc}" alt="${title}" loading="lazy" />
          </a>
          <div class="card-body">
            <span class="card-chip">News</span>
            <p class="card-meta-line">${dateFormatted}</p>
            <h3><a href="${detailUrl}" class="card-title-link">${title}</a></h3>
            <p>${excerpt}</p>
            <a class="text-button" href="${detailUrl}">Read More &rarr;</a>
          </div>
        </article>
      `;
    })
    .join('');

  if (paginationEl) {
    if (paginated.totalPages > 1) {
      paginationEl.style.display = 'flex';
      let buttonsHtml = '';

      if (paginated.hasPrev) {
        buttonsHtml += `<button type="button" class="pagination-btn" data-page="${paginated.currentPage - 1}">Previous</button>`;
      } else {
        buttonsHtml += `<button type="button" class="pagination-btn" disabled>Previous</button>`;
      }

      for (let i = 1; i <= paginated.totalPages; i++) {
        const isActive = i === paginated.currentPage;
        buttonsHtml += `
          <button type="button" class="pagination-btn ${isActive ? 'active' : ''}" data-page="${i}" ${isActive ? 'aria-current="page"' : ''}>
            ${i}
          </button>
        `;
      }

      if (paginated.hasNext) {
        buttonsHtml += `<button type="button" class="pagination-btn" data-page="${paginated.currentPage + 1}">Next</button>`;
      } else {
        buttonsHtml += `<button type="button" class="pagination-btn" disabled>Next</button>`;
      }

      paginationEl.innerHTML = buttonsHtml;
    } else {
      paginationEl.style.display = 'none';
      paginationEl.innerHTML = '';
    }
  }
}

function handlePaginationClick(event) {
  const btn = event.target.closest('[data-page]');
  if (!btn || btn.disabled) return;

  const targetPage = parseInt(btn.dataset.page, 10);
  if (!isNaN(targetPage) && targetPage !== currentNewsPage) {
    renderPublicNews(targetPage);
    const section = document.getElementById('news');
    if (section) {
      section.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }
}

// ─── News Article Detail Renderer ─────────────────────────────────────────────
function renderArticle() {
  const root = document.getElementById('article-root');
  if (!root) return;

  if (root.dataset.serverRendered === 'true') {
    return;
  }

  const urlParams = new URLSearchParams(window.location.search);
  const slug = urlParams.get('slug');

  if (!slug) {
    root.innerHTML = `
      <div class="article-not-found">
        <h2>No Article Specified</h2>
        <p>Please select an article from the news listing.</p>
        <a href="/#news" class="button button-primary">&larr; View All News</a>
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
        <a href="/#news" class="button button-primary">&larr; Back to News</a>
      </div>
    `;
    return;
  }

  document.title = `${post.title} | Samahang Pisika ng Pilipinas`;
  const dateFormatted = formatDate(post.published_at || post.publishDate);
  const imageSrc = post.image_url || post.coverImage || post.image || getDefaultImageSvg(post.title);
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
        <a href="/#news" class="button button-secondary">&larr; Back to News</a>
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
        <a href="/#news" class="button button-secondary">&larr; Back to News</a>
      </footer>
    </article>
  `;
}

// ─── SPP Conference Year Portal ───────────────────────────────────────────────
function initSppConference() {
  const main = document.getElementById('spp-conference-main');
  if (!main) return;

  const KNOWN_YEARS = ['2024', '2025', '2026'];
  const params = new URLSearchParams(window.location.search);
  const year = KNOWN_YEARS.includes(params.get('year')) ? params.get('year') : KNOWN_YEARS[0];

  document.title = `SPP ${year} | Samahang Pisika ng Pilipinas`;

  const desktopActiveLink = document.getElementById(`nav-year-${year}`);
  if (desktopActiveLink) {
    desktopActiveLink.classList.add('active');
    desktopActiveLink.setAttribute('aria-current', 'page');
  }

  const mobileActiveLink = document.getElementById(`mob-year-btn-${year}`) || document.getElementById(`mobile-nav-year-${year}`);
  if (mobileActiveLink) {
    mobileActiveLink.classList.add('active');
    mobileActiveLink.setAttribute('aria-current', 'page');
  }
}

function initUserLoadingScreen() {
  const userLoader = document.getElementById('user-loading-screen');
  console.log('[SPP Loader Debug] Checking #user-loading-screen:', {
    elementFound: Boolean(userLoader),
    readyState: document.readyState,
    classList: userLoader ? Array.from(userLoader.classList) : null,
    computedDisplay: userLoader ? window.getComputedStyle(userLoader).display : null,
    computedVisibility: userLoader ? window.getComputedStyle(userLoader).visibility : null,
    computedOpacity: userLoader ? window.getComputedStyle(userLoader).opacity : null,
  });

  if (!userLoader) {
    console.warn('[SPP Loader Debug] #user-loading-screen not found on page.');
    return;
  }

  let isDismissed = false;
  function hideLoader(trigger = 'unspecified') {
    if (isDismissed) return;
    isDismissed = true;
    console.log(`[SPP Loader Debug] Hiding user loading screen. Trigger: "${trigger}". readyState: "${document.readyState}"`);
    userLoader.classList.add('fade-out');
    setTimeout(() => {
      userLoader.classList.add('is-hidden');
      console.log('[SPP Loader Debug] User loading screen is now hidden (classes: is-hidden, fade-out).');
    }, 450);
  }

  if (document.readyState === 'complete') {
    console.log('[SPP Loader Debug] document.readyState is already complete when script ran.');
    hideLoader('readyState:complete');
  } else {
    console.log('[SPP Loader Debug] Waiting for window load event or timeout...');
    window.addEventListener('load', () => hideLoader('window.onload'), { once: true });
    setTimeout(() => hideLoader('fallback-timeout-2000ms'), 2000);
  }
}

// ─── DOM Initialization ───────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  initTheme();
  initUserLoadingScreen();

  if (!window.__sppThemeListenerAttached) {
    window.__sppThemeListenerAttached = true;
    document.addEventListener('click', (e) => {
      const toggleBtn = e.target.closest('[data-theme-toggle]');
      if (toggleBtn) {
        e.preventDefault();
        toggleTheme();
      }
    });
  }

  const newsGrid = document.getElementById('news-grid');
  if (newsGrid) {
    if (newsGrid.dataset.serverRendered !== 'true') {
      renderPublicNews(1);
      document.getElementById('news-pagination')?.addEventListener('click', handlePaginationClick);
    } else {
      const showMoreBtn = document.getElementById('news-show-more-btn');
      const showLessBtn = document.getElementById('news-show-less-btn');
      const allCards = () => Array.from(newsGrid.querySelectorAll('.content-card.news-card-item'));

      function syncButtons() {
        const hidden = allCards().filter((c) => c.style.display === 'none');
        const hasHidden = hidden.length > 0;
        const hasExtras = allCards().filter((c) => c.style.display !== 'none').length > 4;

        if (showMoreBtn) { showMoreBtn.style.display = hasHidden ? '' : 'none'; }
        if (showLessBtn) { showLessBtn.style.display = hasExtras ? '' : 'none'; }
      }

      if (showMoreBtn) {
        showMoreBtn.addEventListener('click', () => {
          let revealed = 0;
          allCards().forEach((card) => {
            if (card.style.display === 'none' && revealed < 4) {
              card.style.display = '';
              card.classList.remove('news-item-hidden');
              revealed++;
            }
          });
          syncButtons();
        });
      }

      if (showLessBtn) {
        showLessBtn.addEventListener('click', () => {
          allCards().forEach((card, index) => {
            if (index >= 4) {
              card.style.display = 'none';
              card.classList.add('news-item-hidden');
            }
          });
          syncButtons();
          // Scroll up to the news section header
          document.getElementById('news')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
      }

      syncButtons();
    }
  }

  const activityGrid = document.getElementById('activity-grid');
  if (activityGrid) {
    const showMoreBtn = document.getElementById('activity-show-more-btn');
    const showLessBtn = document.getElementById('activity-show-less-btn');
    const allCards = () => Array.from(activityGrid.querySelectorAll('.content-card.activity-card-item'));

    function syncActivityButtons() {
      const hidden = allCards().filter((c) => c.style.display === 'none');
      const hasHidden = hidden.length > 0;
      const hasExtras = allCards().filter((c) => c.style.display !== 'none').length > 4;

      if (showMoreBtn) { showMoreBtn.style.display = hasHidden ? '' : 'none'; }
      if (showLessBtn) { showLessBtn.style.display = hasExtras ? '' : 'none'; }
    }

    if (showMoreBtn) {
      showMoreBtn.addEventListener('click', () => {
        let revealed = 0;
        allCards().forEach((card) => {
          if (card.style.display === 'none' && revealed < 4) {
            card.style.display = '';
            card.classList.remove('activity-item-hidden');
            revealed++;
          }
        });
        syncActivityButtons();
      });
    }

    if (showLessBtn) {
      showLessBtn.addEventListener('click', () => {
        allCards().forEach((card, index) => {
          if (index >= 4) {
            card.style.display = 'none';
            card.classList.add('activity-item-hidden');
          }
        });
        syncActivityButtons();
        document.getElementById('activities')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    }

    syncActivityButtons();
  }

  if (document.getElementById('article-root')) {
    renderArticle();
  }

  if (document.getElementById('spp-conference-main')) {
    initSppConference();
  }

  // ─── Downloads Modal Handling ───────────────────────────────────────────────
  const downloadsModal = document.getElementById('downloads-modal');
  function openDownloadsModal() {
    if (downloadsModal) {
      downloadsModal.classList.remove('is-hidden');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeDownloadsModal() {
    if (downloadsModal) {
      downloadsModal.classList.add('is-hidden');
      document.body.style.overflow = '';
    }
  }

  document.addEventListener('click', (e) => {
    const openBtn = e.target.closest('[data-open-downloads-modal]');
    if (openBtn) {
      e.preventDefault();
      openDownloadsModal();
      return;
    }

    const closeBtn = e.target.closest('[data-close-downloads-modal]');
    if (closeBtn) {
      e.preventDefault();
      closeDownloadsModal();
      return;
    }
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && downloadsModal && !downloadsModal.classList.contains('is-hidden')) {
      closeDownloadsModal();
    }
  });

  window.openDownloadsModal = openDownloadsModal;
  window.closeDownloadsModal = closeDownloadsModal;
});

// Export functions to global scope for backward-compatibility
window.initSppTheme = initTheme;
window.toggleSppTheme = toggleTheme;
window.getVisiblePostsByType = getVisiblePostsByType;
window.findVisiblePostBySlug = findVisiblePostBySlug;
window.getItemSlug = getItemSlug;
window.formatDate = formatDate;
window.getItemExcerpt = getItemExcerpt;
window.paginateItems = paginateItems;
window.getDefaultImageSvg = getDefaultImageSvg;
