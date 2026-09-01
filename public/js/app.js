const themeToggle = document.querySelector('[data-theme-toggle]');
const yearButtons = Array.from(document.querySelectorAll('.year-switcher button[data-year]'));
const spotlight = document.querySelector('.spotlight');
const yearTitle = document.querySelector('[data-year-title]');
const yearCopy = document.querySelector('[data-year-copy]');
const yearBadges = document.querySelector('[data-year-badges]');

const yearContent = {
  2024: {
    title: 'sample year 2024',
    copy: 'test sample text for year 2024 content.',
    badges: [
      ['sample item', 'test'],
      ['sample item', 'test'],
    ],
  },
  2025: {
    title: 'sample year 2025',
    copy: 'test sample text for year 2025 content.',
    badges: [
      ['sample item', 'test'],
      ['sample item', 'test'],
    ],
  },
  2026: {
    title: 'sample year 2026',
    copy: 'test sample text for year 2026 content.',
    badges: [
      ['sample item', 'test'],
      ['sample item', 'test'],
    ],
  },
};

function setTheme(theme) {
  const nextTheme = theme === 'dark' ? 'dark' : 'light';
  document.documentElement.setAttribute('data-theme', nextTheme);

  if (themeToggle) {
    themeToggle.setAttribute('aria-label', nextTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
    themeToggle.title = nextTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode';
  }

  localStorage.setItem('spp-theme', nextTheme);
}

function clearYearSelection() {
  yearButtons.forEach((button) => {
    button.classList.remove('active');
    button.removeAttribute('aria-pressed');
  });

  if (spotlight) {
    spotlight.removeAttribute('data-year');
    spotlight.dataset.empty = 'true';
  }

  if (yearTitle) {
    yearTitle.textContent = 'sample title';
  }

  if (yearCopy) {
    yearCopy.textContent = 'test sample text.';
  }

  if (yearBadges) {
    yearBadges.innerHTML = `
      <div class="spot-badge">
        <div>
          <strong>sample item</strong>
          <span>test</span>
        </div>
        <span>test</span>
      </div>
      <div class="spot-badge">
        <div>
          <strong>sample item</strong>
          <span>test</span>
        </div>
        <span>test</span>
      </div>
    `;
  }
}

function renderYear(year) {
  const content = yearContent[year];

  yearButtons.forEach((button) => {
    const isActive = button.dataset.year === year;
    button.classList.toggle('active', isActive);
    button.setAttribute('aria-pressed', String(isActive));
  });

  if (!content || !spotlight || !yearTitle || !yearCopy || !yearBadges) {
    return;
  }

  spotlight.dataset.year = year;
  delete spotlight.dataset.empty;
  yearTitle.textContent = content.title;
  yearCopy.textContent = content.copy;
  yearBadges.innerHTML = content.badges
    .map(
      ([label, value]) => `
      <div class="spot-badge">
        <div>
          <strong>${label}</strong>
          <span>test</span>
        </div>
        <span>${value}</span>
      </div>
    `,
    )
    .join('');
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

const NEWS_PAGE_SIZE = 6;
let currentNewsPage = 1;

function renderPublicNews(page = 1) {
  const newsGrid = document.getElementById('news-grid');
  const paginationEl = document.getElementById('news-pagination');
  if (!newsGrid) return;

  if (typeof getVisiblePostsByType !== 'function') {
    newsGrid.innerHTML = '<div class="news-empty-state">Unable to load news module.</div>';
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
      const detailUrl = `news.html?slug=${encodeURIComponent(slug)}`;

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

const savedTheme = localStorage.getItem('spp-theme');
const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
setTheme(savedTheme || (prefersDark ? 'dark' : 'light'));
clearYearSelection();

themeToggle?.addEventListener('click', () => {
  const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
  setTheme(isDark ? 'light' : 'dark');
});

yearButtons.forEach((button) => {
  button.addEventListener('click', () => renderYear(button.dataset.year));
});

document.getElementById('news-pagination')?.addEventListener('click', handlePaginationClick);

document.addEventListener('DOMContentLoaded', () => {
  renderPublicNews(1);
});
