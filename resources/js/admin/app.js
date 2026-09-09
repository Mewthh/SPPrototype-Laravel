const themeToggle = document.querySelector('[data-theme-toggle]');

const newsForm = document.querySelector('[data-news-form]');
const activityForm = document.querySelector('[data-activity-form]');

const newsViews = {
  editor: document.querySelector('[data-news-view="editor"]'),
  posts: document.querySelector('[data-news-view="posts"]'),
};

const activityViews = {
  editor: document.querySelector('[data-activity-view="editor"]'),
  posts: document.querySelector('[data-activity-view="posts"]'),
};

const newsList = document.querySelector('[data-news-list]');
const activityList = document.querySelector('[data-activity-list]');

const newsPagination = document.querySelector('[data-news-pagination]');
const newsPaginationInfo = document.querySelector('[data-news-pagination-info]');
const newsLoadMoreBtn = document.querySelector('[data-news-load-more]');
const newsShowLessBtn = document.querySelector('[data-news-show-less]');

const activityPagination = document.querySelector('[data-activity-pagination]');
const activityPaginationInfo = document.querySelector('[data-activity-pagination-info]');
const activityLoadMoreBtn = document.querySelector('[data-activity-load-more]');
const activityShowLessBtn = document.querySelector('[data-activity-show-less]');

const newsBanner = document.querySelector('[data-news-banner]');
const newsBannerText = document.querySelector('[data-news-banner-text]');
const newsCancelEdit = document.querySelector('[data-news-cancel-edit]');
const newsSubmitPrimary = document.querySelector('[data-news-submit-primary]');
const newsSubmitSecondary = document.querySelector('[data-news-submit-secondary]');

const activityBanner = document.querySelector('[data-activity-banner]');
const activityBannerText = document.querySelector('[data-activity-banner-text]');
const activityCancelEdit = document.querySelector('[data-activity-cancel-edit]');
const activitySubmitPrimary = document.querySelector('[data-activity-submit-primary]');
const activitySubmitSecondary = document.querySelector('[data-activity-submit-secondary]');

const newsCountBadges = document.querySelectorAll('[data-news-count-badge]');
const activityCountBadges = document.querySelectorAll('[data-activity-count-badge]');

const localStorageKey = 'spp-admin-posts-v3';
const themeKey = 'spp-theme';
const PAGE_SIZE = 3;

const imageState = {
  news: null,
  activity: null,
};

const defaultPosts = [
  {
    id: 'post-n1',
    type: 'announcement',
    title: 'sample text',
    section: 'News',
    status: 'published',
    publishDate: '2026-08-19',
    summary: 'sample text.',
    body: 'sample text.',
    featured: true,
  },
  {
    id: 'post-n2',
    type: 'announcement',
    title: 'sample text',
    section: 'News',
    status: 'scheduled',
    publishDate: '2026-08-25',
    summary: 'sample text.',
    body: 'sample text.',
    featured: true,
  },
  {
    id: 'post-n3',
    type: 'announcement',
    title: 'sample text',
    section: 'News',
    status: 'draft',
    publishDate: '2026-08-10',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false,
  },
  {
    id: 'post-n4',
    type: 'announcement',
    title: 'sample text',
    section: 'News',
    status: 'archived',
    publishDate: '2026-07-20',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false,
  },
  {
    id: 'post-n5',
    type: 'announcement',
    title: 'sample text',
    section: 'News',
    status: 'published',
    publishDate: '2026-08-01',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false,
  },
  {
    id: 'post-n6',
    type: 'announcement',
    title: 'sample text',
    section: 'News',
    status: 'draft',
    publishDate: '2026-07-28',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false,
  },
  {
    id: 'post-n7',
    type: 'announcement',
    title: 'sample text',
    section: 'News',
    status: 'archived',
    publishDate: '2026-06-15',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false,
  },
  {
    id: 'post-a1',
    type: 'event',
    title: 'sample text',
    section: 'Activities',
    status: 'scheduled',
    publishDate: '2026-08-28',
    summary: 'sample text.',
    body: 'sample text.',
    featured: true,
  },
  {
    id: 'post-a2',
    type: 'event',
    title: 'sample text',
    section: 'Activities',
    status: 'published',
    publishDate: '2026-08-22',
    summary: 'sample text.',
    body: 'sample text.',
    featured: true,
  },
  {
    id: 'post-a3',
    type: 'event',
    title: 'sample text',
    section: 'Activities',
    status: 'draft',
    publishDate: '2026-08-16',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false,
  },
  {
    id: 'post-a4',
    type: 'event',
    title: 'sample text',
    section: 'Activities',
    status: 'archived',
    publishDate: '2026-07-10',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false,
  },
  {
    id: 'post-a5',
    type: 'event',
    title: 'sample text',
    section: 'Activities',
    status: 'scheduled',
    publishDate: '2026-08-04',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false,
  },
  {
    id: 'post-a6',
    type: 'event',
    title: 'sample text',
    section: 'Activities',
    status: 'published',
    publishDate: '2026-07-25',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false,
  },
  {
    id: 'post-a7',
    type: 'event',
    title: 'sample text',
    section: 'Activities',
    status: 'archived',
    publishDate: '2026-06-01',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false,
  },
];

const state = {
  posts: loadPosts(),
  newsFilter: 'all',
  activityFilter: 'all',
  newsVisibleCount: PAGE_SIZE,
  activityVisibleCount: PAGE_SIZE,
  editingNewsId: null,
  editingActivityId: null,
};

function loadPosts() {
  return [];
}

function savePosts() {
  // Database persists changes; bypass localStorage write
}

function setTheme(theme) {
  const nextTheme = theme === 'dark' ? 'dark' : 'light';
  document.documentElement.setAttribute('data-theme', nextTheme);

  if (themeToggle) {
    themeToggle.setAttribute('aria-label', nextTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
    themeToggle.title = nextTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode';
  }

  localStorage.setItem(themeKey, nextTheme);
}

function formatDate(value) {
  if (!value) {
    return 'No date set';
  }
  const date = new Date(value);
  if (Number.isNaN(date.getTime())) {
    return value;
  }
  return new Intl.DateTimeFormat('en', { month: 'short', day: 'numeric', year: 'numeric' }).format(date);
}

function statusLabel(status) {
  if (status === 'scheduled') return 'Scheduled';
  if (status === 'published') return 'Published';
  if (status === 'archived') return 'Archived';
  return 'Draft';
}

function setNewsView(view) {
  if (newsViews.editor && newsViews.posts) {
    newsViews.editor.classList.toggle('is-hidden', view !== 'editor');
    newsViews.posts.classList.toggle('is-hidden', view !== 'posts');
    if (view === 'posts') {
      state.newsVisibleCount = PAGE_SIZE;
      renderNewsQueue();
    }
  }
}

function setActivityView(view) {
  if (activityViews.editor && activityViews.posts) {
    activityViews.editor.classList.toggle('is-hidden', view !== 'editor');
    activityViews.posts.classList.toggle('is-hidden', view !== 'posts');
    if (view === 'posts') {
      state.activityVisibleCount = PAGE_SIZE;
      renderActivityQueue();
    }
  }
}

function renderMetrics() {
  const newsCount = state.posts.filter((p) => p.type === 'announcement').length;
  const activityCount = state.posts.filter((p) => p.type === 'event').length;

  newsCountBadges.forEach((b) => (b.textContent = String(newsCount)));
  activityCountBadges.forEach((b) => (b.textContent = String(activityCount)));

  const newsAll = newsCount;
  const newsPublished = state.posts.filter((p) => p.type === 'announcement' && p.status === 'published').length;
  const newsScheduled = state.posts.filter((p) => p.type === 'announcement' && p.status === 'scheduled').length;
  const newsDraft = state.posts.filter((p) => p.type === 'announcement' && p.status === 'draft').length;
  const newsArchived = state.posts.filter((p) => p.type === 'announcement' && p.status === 'archived').length;

  const elNewsAll = document.querySelector('[data-news-filter-all-count]');
  const elNewsPub = document.querySelector('[data-news-filter-published-count]');
  const elNewsSch = document.querySelector('[data-news-filter-scheduled-count]');
  const elNewsDraft = document.querySelector('[data-news-filter-draft-count]');
  const elNewsArch = document.querySelector('[data-news-filter-archived-count]');

  if (elNewsAll) elNewsAll.textContent = String(newsAll);
  if (elNewsPub) elNewsPub.textContent = String(newsPublished);
  if (elNewsSch) elNewsSch.textContent = String(newsScheduled);
  if (elNewsDraft) elNewsDraft.textContent = String(newsDraft);
  if (elNewsArch) elNewsArch.textContent = String(newsArchived);

  const actAll = activityCount;
  const actPublished = state.posts.filter((p) => p.type === 'event' && p.status === 'published').length;
  const actScheduled = state.posts.filter((p) => p.type === 'event' && p.status === 'scheduled').length;
  const actDraft = state.posts.filter((p) => p.type === 'event' && p.status === 'draft').length;
  const actArchived = state.posts.filter((p) => p.type === 'event' && p.status === 'archived').length;

  const elActAll = document.querySelector('[data-activity-filter-all-count]');
  const elActPub = document.querySelector('[data-activity-filter-published-count]');
  const elActSch = document.querySelector('[data-activity-filter-scheduled-count]');
  const elActDraft = document.querySelector('[data-activity-filter-draft-count]');
  const elActArch = document.querySelector('[data-activity-filter-archived-count]');

  if (elActAll) elActAll.textContent = String(actAll);
  if (elActPub) elActPub.textContent = String(actPublished);
  if (elActSch) elActSch.textContent = String(actScheduled);
  if (elActDraft) elActDraft.textContent = String(actDraft);
  if (elActArch) elActArch.textContent = String(actArchived);
}

function renderNewsQueue() {
  if (!newsList) return;

  const newsItems = state.posts.filter((p) => p.type === 'announcement');
  const filtered =
    state.newsFilter === 'all'
      ? newsItems
      : newsItems.filter((p) => p.status === state.newsFilter);

  if (!filtered.length) {
    newsList.innerHTML = '<div class="empty-state">sample text.</div>';
    if (newsPagination) newsPagination.style.display = 'none';
    return;
  }

  const visibleItems = filtered.slice(0, state.newsVisibleCount);

  newsList.innerHTML = visibleItems
    .map((post) => {
      let quickAction = '';
      if (post.status === 'published') {
        quickAction = '<button type="button" class="item-action" data-news-action="archive">Archive</button>';
      } else if (post.status === 'archived') {
        quickAction = '<button type="button" class="item-action primary" data-news-action="publish">Unarchive</button>';
      } else {
        quickAction = '<button type="button" class="item-action primary" data-news-action="publish">Publish</button>';
      }

      return `
        <article class="queue-row ${state.editingNewsId === post.id ? 'is-editing' : ''}" data-post-id="${post.id}">
          <div class="queue-cell queue-title">
            <strong>${post.title}</strong>
            <span>${post.summary || post.body || 'sample text.'}</span>
          </div>
          <div class="queue-cell queue-status">
            <span class="post-tag" data-status="${post.status}">${statusLabel(post.status)}</span>
          </div>
          <div class="queue-cell queue-date">${formatDate(post.publishDate)}</div>
          <div class="queue-cell queue-actions">
            <button type="button" class="item-action" data-news-action="edit">Edit</button>
            ${quickAction}
            <button type="button" class="item-action danger" data-news-action="delete">Delete</button>
          </div>
        </article>
      `;
    })
    .join('');

  if (newsPagination) {
    if (filtered.length > PAGE_SIZE) {
      newsPagination.style.display = 'flex';
      const countShown = Math.min(state.newsVisibleCount, filtered.length);
      if (newsPaginationInfo) {
        newsPaginationInfo.textContent = `Showing ${countShown} of ${filtered.length} posts`;
      }
      if (newsLoadMoreBtn) {
        if (state.newsVisibleCount >= filtered.length) {
          newsLoadMoreBtn.style.display = 'none';
        } else {
          newsLoadMoreBtn.style.display = 'inline-flex';
          newsLoadMoreBtn.textContent = 'Show More';
        }
      }
      if (newsShowLessBtn) {
        if (state.newsVisibleCount > PAGE_SIZE) {
          newsShowLessBtn.style.display = 'inline-flex';
          newsShowLessBtn.textContent = 'Show Less';
        } else {
          newsShowLessBtn.style.display = 'none';
        }
      }
    } else {
      newsPagination.style.display = 'none';
    }
  }
}

function renderActivityQueue() {
  if (!activityList) return;

  const actItems = state.posts.filter((p) => p.type === 'event');
  const filtered =
    state.activityFilter === 'all'
      ? actItems
      : actItems.filter((p) => p.status === state.activityFilter);

  if (!filtered.length) {
    activityList.innerHTML = '<div class="empty-state">sample text.</div>';
    if (activityPagination) activityPagination.style.display = 'none';
    return;
  }

  const visibleItems = filtered.slice(0, state.activityVisibleCount);

  activityList.innerHTML = visibleItems
    .map((post) => {
      let quickAction = '';
      if (post.status === 'published') {
        quickAction = '<button type="button" class="item-action" data-activity-action="archive">Archive</button>';
      } else if (post.status === 'archived') {
        quickAction = '<button type="button" class="item-action primary" data-activity-action="publish">Unarchive</button>';
      } else {
        quickAction = '<button type="button" class="item-action primary" data-activity-action="publish">Publish</button>';
      }

      return `
        <article class="queue-row ${state.editingActivityId === post.id ? 'is-editing' : ''}" data-post-id="${post.id}">
          <div class="queue-cell queue-title">
            <strong>${post.title}</strong>
            <span>${post.summary || post.body || 'sample text.'}</span>
          </div>
          <div class="queue-cell queue-status">
            <span class="post-tag" data-status="${post.status}">${statusLabel(post.status)}</span>
          </div>
          <div class="queue-cell queue-date">${formatDate(post.publishDate)}</div>
          <div class="queue-cell queue-actions">
            <button type="button" class="item-action" data-activity-action="edit">Edit</button>
            ${quickAction}
            <button type="button" class="item-action danger" data-activity-action="delete">Delete</button>
          </div>
        </article>
      `;
    })
    .join('');

  if (activityPagination) {
    if (filtered.length > PAGE_SIZE) {
      activityPagination.style.display = 'flex';
      const countShown = Math.min(state.activityVisibleCount, filtered.length);
      if (activityPaginationInfo) {
        activityPaginationInfo.textContent = `Showing ${countShown} of ${filtered.length} activities`;
      }
      if (activityLoadMoreBtn) {
        if (state.activityVisibleCount >= filtered.length) {
          activityLoadMoreBtn.style.display = 'none';
        } else {
          activityLoadMoreBtn.style.display = 'inline-flex';
          activityLoadMoreBtn.textContent = 'Show More';
        }
      }
      if (activityShowLessBtn) {
        if (state.activityVisibleCount > PAGE_SIZE) {
          activityShowLessBtn.style.display = 'inline-flex';
          activityShowLessBtn.textContent = 'Show Less';
        } else {
          activityShowLessBtn.style.display = 'none';
        }
      }
    } else {
      activityPagination.style.display = 'none';
    }
  }
}

function updateNewsEditorUI() {
  if (!newsForm) return;

  if (state.editingNewsId) {
    const post = state.posts.find((p) => p.id === state.editingNewsId);
    if (newsBanner) newsBanner.classList.add('is-editing');
    if (newsBannerText) newsBannerText.textContent = post ? `Editing: "${post.title}"` : 'Editing News Post';
    if (newsCancelEdit) newsCancelEdit.style.display = 'inline-flex';
    if (newsSubmitPrimary) newsSubmitPrimary.textContent = 'Update Post';
    if (newsSubmitSecondary) newsSubmitSecondary.textContent = 'Save as Draft';
  } else {
    if (newsBanner) newsBanner.classList.remove('is-editing');
    if (newsBannerText) newsBannerText.textContent = 'Create New News Post';
    if (newsCancelEdit) newsCancelEdit.style.display = 'none';
    if (newsSubmitPrimary) newsSubmitPrimary.textContent = 'Save & Publish';
    if (newsSubmitSecondary) newsSubmitSecondary.textContent = 'Save as Draft';
  }
}

function updateActivityEditorUI() {
  if (!activityForm) return;

  if (state.editingActivityId) {
    const post = state.posts.find((p) => p.id === state.editingActivityId);
    if (activityBanner) activityBanner.classList.add('is-editing');
    if (activityBannerText) activityBannerText.textContent = post ? `Editing: "${post.title}"` : 'Editing Activity';
    if (activityCancelEdit) activityCancelEdit.style.display = 'inline-flex';
    if (activitySubmitPrimary) activitySubmitPrimary.textContent = 'Update Activity';
    if (activitySubmitSecondary) activitySubmitSecondary.textContent = 'Save as Scheduled';
  } else {
    if (activityBanner) activityBanner.classList.remove('is-editing');
    if (activityBannerText) activityBannerText.textContent = 'Create New Activity';
    if (activityCancelEdit) activityCancelEdit.style.display = 'none';
    if (activitySubmitPrimary) activitySubmitPrimary.textContent = 'Save & Publish';
    if (activitySubmitSecondary) activitySubmitSecondary.textContent = 'Save as Scheduled';
  }
}

function renderAll() {
  renderMetrics();
  renderNewsQueue();
  renderActivityQueue();
  updateNewsEditorUI();
  updateActivityEditorUI();
}

function setupImageUpload(key) {
  const zone = document.querySelector(`[data-upload-zone="${key}"]`);
  const input = document.querySelector(`[data-upload-input="${key}"]`);
  const preview = document.querySelector(`[data-upload-preview="${key}"]`);
  const placeholder = document.querySelector(`[data-upload-placeholder="${key}"]`);
  const actions = document.querySelector(`[data-upload-actions="${key}"]`);
  const filename = document.querySelector(`[data-upload-filename="${key}"]`);
  const clearBtn = document.querySelector(`[data-upload-clear="${key}"]`);

  if (!zone || !input) return;

  function applyImage(dataURL, name) {
    imageState[key] = dataURL;
    if (preview) {
      preview.src = dataURL;
      preview.classList.remove('is-hidden');
    }
    if (placeholder) placeholder.classList.add('is-hidden');
    if (actions) actions.classList.remove('is-hidden');
    if (filename) filename.textContent = name || 'Uploaded image';
  }

  function clearImage() {
    imageState[key] = null;
    if (preview) {
      preview.src = '';
      preview.classList.add('is-hidden');
    }
    if (placeholder) placeholder.classList.remove('is-hidden');
    if (actions) actions.classList.add('is-hidden');
    if (filename) filename.textContent = '';
    if (input) input.value = '';
  }

  function handleFile(file) {
    if (!file || !file.type.startsWith('image/')) {
      alert('Please select a valid image file (PNG, JPG, GIF, WebP).');
      return;
    }
    if (file.size > 5 * 1024 * 1024) {
      alert('Image is too large. Maximum allowed size is 5 MB.');
      return;
    }
    const reader = new FileReader();
    reader.onload = (e) => applyImage(e.target.result, file.name);
    reader.readAsDataURL(file);
  }

  zone.addEventListener('click', (e) => {
    if (e.target === clearBtn) return;
    input.click();
  });

  zone.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      input.click();
    }
  });

  input.addEventListener('change', () => {
    if (input.files && input.files[0]) handleFile(input.files[0]);
  });

  zone.addEventListener('dragover', (e) => {
    e.preventDefault();
    zone.classList.add('is-drag-over');
  });
  zone.addEventListener('dragleave', () => zone.classList.remove('is-drag-over'));
  zone.addEventListener('drop', (e) => {
    e.preventDefault();
    zone.classList.remove('is-drag-over');
    const file = e.dataTransfer.files[0];
    if (file) handleFile(file);
  });

  clearBtn?.addEventListener('click', (e) => {
    e.stopPropagation();
    clearImage();
  });

  zone._clearImage = clearImage;
  zone._applyImage = applyImage;
}

/* ─── Media Upload & Markdown Toolbar Engine ────────────────────────────── */
async function uploadMediaAsset(file) {
  const formData = new FormData();
  formData.append('image', file);

  const token = document.querySelector('meta[name="csrf-token"]')?.content;
  const res = await fetch('/admin/api/media/upload', {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': token || '',
      'Accept': 'application/json',
    },
    body: formData,
  });

  const data = await res.json();
  if (!res.ok) {
    throw new Error(data.message || 'Upload failed');
  }

  return data;
}

function handleEditorImageUpload(textarea) {
  const fileInput = document.createElement('input');
  fileInput.type = 'file';
  fileInput.accept = 'image/png, image/jpeg, image/gif, image/webp, image/svg+xml';
  fileInput.style.display = 'none';
  document.body.appendChild(fileInput);

  fileInput.addEventListener('change', async () => {
    if (!fileInput.files || !fileInput.files[0]) {
      fileInput.remove();
      return;
    }
    const file = fileInput.files[0];
    fileInput.remove();

    try {
      const data = await uploadMediaAsset(file);
      const alt = file.name.replace(/\.[^/.]+$/, '');
      const markdownSnippet = `![${alt}](${data.url})`;

      const start = textarea.selectionStart ?? textarea.value.length;
      const end = textarea.selectionEnd ?? textarea.value.length;
      const val = textarea.value || '';
      textarea.value = val.substring(0, start) + markdownSnippet + val.substring(end);
      textarea.dispatchEvent(new Event('input', { bubbles: true }));
    } catch (err) {
      alert('Failed to upload image: ' + err.message);
    }
  });

  fileInput.click();
}

/* ─── Lightweight Markdown → HTML Renderer ─────────────────────────────── */
function markdownToHtml(md) {
  if (!md) return '';
  let html = md;

  // Fenced code blocks
  html = html.replace(/```([\s\S]*?)```/g, (_, code) => `<pre><code>${escapeHtmlPreview(code.trim())}</code></pre>`);

  // Tables (GFM)
  html = html.replace(/^(\|.+\|[ \t]*\n)(\|[-| :]+\|[ \t]*\n)((?:\|.+\|[ \t]*\n?)*)/gm, (match, header, _sep, body) => {
    const parseRow = (row) => row.trim().replace(/^\|/, '').replace(/\|$/, '').split('|').map((c) => c.trim());
    const headers = parseRow(header);
    const rows = body.trim() ? body.trim().split('\n').map(parseRow) : [];
    const thead = `<thead><tr>${headers.map((h) => `<th>${inlineMarkdown(h)}</th>`).join('')}</tr></thead>`;
    const tbody = rows.length ? `<tbody>${rows.map((r) => `<tr>${r.map((c) => `<td>${inlineMarkdown(c)}</td>`).join('')}</tr>`).join('')}</tbody>` : '';
    return `<table class="md-table">${thead}${tbody}</table>`;
  });

  // Headings
  html = html.replace(/^######\s+(.+)$/gm, '<h6>$1</h6>');
  html = html.replace(/^#####\s+(.+)$/gm, '<h5>$1</h5>');
  html = html.replace(/^####\s+(.+)$/gm, '<h4>$1</h4>');
  html = html.replace(/^###\s+(.+)$/gm, '<h3>$1</h3>');
  html = html.replace(/^##\s+(.+)$/gm, '<h2>$1</h2>');
  html = html.replace(/^#\s+(.+)$/gm, '<h1>$1</h1>');

  // Horizontal rules
  html = html.replace(/^---+$/gm, '<hr>');

  // Blockquotes
  html = html.replace(/^>\s?(.+)$/gm, '<blockquote>$1</blockquote>');

  // Unordered lists
  html = html.replace(/((?:^[-*+]\s+.+\n?)+)/gm, (block) => {
    const items = block.trim().split('\n').map((l) => `<li>${inlineMarkdown(l.replace(/^[-*+]\s+/, ''))}</li>`);
    return `<ul>${items.join('')}</ul>`;
  });

  // Ordered lists
  html = html.replace(/((?:^\d+\.\s+.+\n?)+)/gm, (block) => {
    const items = block.trim().split('\n').map((l) => `<li>${inlineMarkdown(l.replace(/^\d+\.\s+/, ''))}</li>`);
    return `<ol>${items.join('')}</ol>`;
  });

  // Paragraphs (lines not already wrapped in a block-level tag)
  const blockTags = ['<h', '<ul', '<ol', '<li', '<blockquote', '<pre', '<table', '<hr', '<p'];
  const lines = html.split('\n');
  const result = [];
  let i = 0;
  while (i < lines.length) {
    const line = lines[i];
    const trimmed = line.trim();
    if (!trimmed) { i++; continue; }
    const isBlock = blockTags.some((t) => trimmed.startsWith(t));
    if (isBlock) {
      result.push(line);
    } else {
      result.push(`<p>${inlineMarkdown(trimmed)}</p>`);
    }
    i++;
  }
  return result.join('\n');
}

function inlineMarkdown(text) {
  if (!text) return '';
  let s = text;
  // Images before links
  s = s.replace(/!\[([^\]]*?)\]\(([^)]+?)\)/g, '<img src="$2" alt="$1" style="max-width:100%">');
  // Links
  s = s.replace(/\[([^\]]+?)\]\(([^)]+?)\)/g, '<a href="$2" target="_blank" rel="noopener">$1</a>');
  // Bold+italic
  s = s.replace(/\*\*\*(.+?)\*\*\*/g, '<strong><em>$1</em></strong>');
  // Bold
  s = s.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
  // Italic
  s = s.replace(/\*(.+?)\*/g, '<em>$1</em>');
  // Underline <u>
  s = s.replace(/<u>(.+?)<\/u>/g, '<u>$1</u>');
  // Underline ++
  s = s.replace(/\+\+(.+?)\+\+/g, '<u>$1</u>');
  // Highlight
  s = s.replace(/==(.+?)==/g, '<mark>$1</mark>');
  // Subscript
  s = s.replace(/~(.+?)~/g, '<sub>$1</sub>');
  // Superscript
  s = s.replace(/\^(.+?)\^/g, '<sup>$1</sup>');
  // Inline code
  s = s.replace(/`(.+?)`/g, '<code>$1</code>');
  // Footnote refs
  s = s.replace(/\[\^(\d+)\]/g, '<sup class="footnote-ref">[$1]</sup>');
  return s;
}

function escapeHtmlPreview(str) {
  return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

function applyMarkdownFormat(inputOrTextarea, format) {
  if (!inputOrTextarea) return;
  const el = inputOrTextarea;
  el.focus();

  const start = (el.selectionStart !== null && el.selectionStart !== undefined) ? el.selectionStart : el.value.length;
  const end = (el.selectionEnd !== null && el.selectionEnd !== undefined) ? el.selectionEnd : el.value.length;
  const val = el.value || '';
  const selected = val.substring(start, end);

  // ── Inline wrap helpers ─────────────────────────────────────────────────
  function wrapInline(open, close, placeholder) {
    const cls = close || open;
    if (selected.startsWith(open) && selected.endsWith(cls) && selected.length > open.length + cls.length) {
      const inner = selected.slice(open.length, -cls.length);
      el.value = val.substring(0, start) + inner + val.substring(end);
      el.setSelectionRange(start, start + inner.length);
    } else {
      const text = selected || placeholder;
      const wrapped = open + text + cls;
      el.value = val.substring(0, start) + wrapped + val.substring(end);
      el.setSelectionRange(start + open.length, start + open.length + text.length);
    }
    el.dispatchEvent(new Event('input', { bubbles: true }));
  }

  // ── Line-level prefix helpers ────────────────────────────────────────────
  function prefixLines(prefix, isActive, removeFn) {
    const lineStart = val.lastIndexOf('\n', start - 1) + 1;
    let lineEnd = val.indexOf('\n', end);
    if (lineEnd === -1) lineEnd = val.length;
    const lines = val.substring(lineStart, lineEnd).split('\n');
    const allActive = lines.every((l) => isActive(l));
    const newLines = allActive ? lines.map(removeFn) : lines.map(prefix);
    const joined = newLines.join('\n');
    el.value = val.substring(0, lineStart) + joined + val.substring(lineEnd);
    el.setSelectionRange(lineStart, lineStart + joined.length);
    el.dispatchEvent(new Event('input', { bubbles: true }));
  }

  // ── Insert at cursor ─────────────────────────────────────────────────────
  function insertAtCursor(text, selOffset, selLen) {
    el.value = val.substring(0, start) + text + val.substring(end);
    const s = start + (selOffset !== undefined ? selOffset : 0);
    el.setSelectionRange(s, s + (selLen !== undefined ? selLen : 0));
    el.dispatchEvent(new Event('input', { bubbles: true }));
  }

  if (format === 'bold') {
    wrapInline('**', '**', 'bold text');
  } else if (format === 'italic') {
    wrapInline('*', '*', 'italic text');
  } else if (format === 'underline') {
    if (selected.startsWith('<u>') && selected.endsWith('</u>') && selected.length >= 7) {
      const inner = selected.slice(3, -4);
      el.value = val.substring(0, start) + inner + val.substring(end);
      el.setSelectionRange(start, start + inner.length);
      el.dispatchEvent(new Event('input', { bubbles: true }));
    } else if (selected.startsWith('++') && selected.endsWith('++') && selected.length >= 4) {
      const inner = selected.slice(2, -2);
      el.value = val.substring(0, start) + inner + val.substring(end);
      el.setSelectionRange(start, start + inner.length);
      el.dispatchEvent(new Event('input', { bubbles: true }));
    } else {
      wrapInline('<u>', '</u>', 'underlined text');
    }
  } else if (format === 'highlight') {
    wrapInline('==', '==', 'highlighted text');
  } else if (format === 'sub') {
    wrapInline('~', '~', 'subscript');
  } else if (format === 'sup') {
    wrapInline('^', '^', 'superscript');
  } else if (format === 'code') {
    if (selected.includes('\n')) {
      const fence = '\n```\n';
      const text = selected || 'code here';
      const wrapped = fence + text + fence;
      el.value = val.substring(0, start) + wrapped + val.substring(end);
      el.setSelectionRange(start + 5, start + 5 + text.length);
      el.dispatchEvent(new Event('input', { bubbles: true }));
    } else {
      wrapInline('`', '`', 'code');
    }
  } else if (format === 'h1' || format === 'h2') {
    const prefix = format === 'h1' ? '# ' : '## ';
    const lineStart = val.lastIndexOf('\n', start - 1) + 1;
    let lineEnd = val.indexOf('\n', end);
    if (lineEnd === -1) lineEnd = val.length;
    const lineText = val.substring(lineStart, lineEnd);
    const cleanLine = lineText.replace(/^#{1,6}\s+/, '');
    const newLine = lineText.startsWith(prefix) ? cleanLine : `${prefix}${cleanLine}`;
    el.value = val.substring(0, lineStart) + newLine + val.substring(lineEnd);
    el.setSelectionRange(lineStart, lineStart + newLine.length);
    el.dispatchEvent(new Event('input', { bubbles: true }));
  } else if (format === 'ul') {
    prefixLines(
      (l) => `- ${l}`,
      (l) => l.trimStart().startsWith('- '),
      (l) => l.replace(/^(\s*)- /, '$1')
    );
  } else if (format === 'ol') {
    const lineStart = val.lastIndexOf('\n', start - 1) + 1;
    let lineEnd = val.indexOf('\n', end);
    if (lineEnd === -1) lineEnd = val.length;
    const lines = val.substring(lineStart, lineEnd).split('\n');
    const isAllOl = lines.every((l) => /^\s*\d+\.\s+/.test(l));
    const newLines = isAllOl
      ? lines.map((l) => l.replace(/^(\s*)\d+\.\s+/, '$1'))
      : lines.map((l, i) => `${i + 1}. ${l.replace(/^(\s*)\d+\.\s+/, '$1')}`);
    const joined = newLines.join('\n');
    el.value = val.substring(0, lineStart) + joined + val.substring(lineEnd);
    el.setSelectionRange(lineStart, lineStart + joined.length);
    el.dispatchEvent(new Event('input', { bubbles: true }));
  } else if (format === 'blockquote' || format === 'card') {
    prefixLines(
      (l) => `> ${l || 'Blockquote text'}`,
      (l) => l.trimStart().startsWith('> '),
      (l) => l.replace(/^(\s*)>\s?/, '$1')
    );
  } else if (format === 'hr') {
    const newline = start > 0 && val[start - 1] !== '\n' ? '\n' : '';
    insertAtCursor(`${newline}\n---\n\n`, newline.length + 1, 3);
  } else if (format === 'link') {
    const text = selected || 'link text';
    const snippet = `[${text}](https://example.com)`;
    el.value = val.substring(0, start) + snippet + val.substring(end);
    const urlStart = start + text.length + 3;
    el.setSelectionRange(urlStart, urlStart + 19);
    el.dispatchEvent(new Event('input', { bubbles: true }));
  } else if (format === 'image') {
    handleEditorImageUpload(el);
    return;
  } else if (format === 'table') {
    const tableSnippet = `\n| Header 1 | Header 2 | Header 3 |\n| --- | --- | --- |\n| Cell 1 | Cell 2 | Cell 3 |\n| Cell 4 | Cell 5 | Cell 6 |\n`;
    el.value = val.substring(0, start) + tableSnippet + val.substring(end);
    el.setSelectionRange(start + 3, start + 11);
    el.dispatchEvent(new Event('input', { bubbles: true }));
  } else if (format === 'footnote') {
    const fnMatches = val.match(/\[\^(\d+)\]/g) || [];
    const nextFn = fnMatches.length + 1;
    const refSnippet = `[^${nextFn}]`;
    const defSnippet = `\n\n[^${nextFn}]: Footnote text here`;
    el.value = val.substring(0, start) + refSnippet + val.substring(end) + defSnippet;
    el.setSelectionRange(start, start + refSnippet.length);
    el.dispatchEvent(new Event('input', { bubbles: true }));
  }
}

function setupRichEditorToolbars() {
  document.querySelectorAll('[data-rich-editor]').forEach((wrap) => {
    const inputOrTextarea = wrap.querySelector('input, textarea');
    const toolbar = wrap.querySelector('.editor-toolbar');
    if (!inputOrTextarea || !toolbar || wrap._richEditorAttached) return;
    wrap._richEditorAttached = true;

    // ── Inject split preview pane ──────────────────────────────────────────
    const editorBody = document.createElement('div');
    editorBody.className = 'rich-editor-body';

    // Move textarea into editor body
    inputOrTextarea.parentNode.insertBefore(editorBody, inputOrTextarea);
    editorBody.appendChild(inputOrTextarea);

    const preview = document.createElement('div');
    preview.className = 'rich-editor-preview';
    preview.setAttribute('aria-label', 'Markdown preview');
    preview.setAttribute('aria-live', 'polite');
    editorBody.appendChild(preview);

    // Add a toggle button to the toolbar
    const previewToggle = document.createElement('button');
    previewToggle.type = 'button';
    previewToggle.className = 'toolbar-btn toolbar-preview-toggle';
    previewToggle.title = 'Toggle preview';
    previewToggle.setAttribute('aria-label', 'Toggle preview');
    previewToggle.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>';
    toolbar.appendChild(previewToggle);

    let previewVisible = true;

    function updatePreview() {
      preview.innerHTML = markdownToHtml(inputOrTextarea.value);
    }

    function togglePreview() {
      previewVisible = !previewVisible;
      preview.style.display = previewVisible ? '' : 'none';
      editorBody.classList.toggle('preview-hidden', !previewVisible);
      previewToggle.classList.toggle('is-active', previewVisible);
    }

    previewToggle.addEventListener('mousedown', (e) => e.preventDefault());
    previewToggle.addEventListener('click', (e) => { e.preventDefault(); togglePreview(); });

    inputOrTextarea.addEventListener('input', updatePreview);
    inputOrTextarea.addEventListener('change', updatePreview);
    if (inputOrTextarea.form) {
      inputOrTextarea.form.addEventListener('reset', () => {
        window.setTimeout(updatePreview, 0);
      });
    }
    updatePreview();
    previewToggle.classList.add('is-active');
    // ─────────────────────────────────────────────────────────────────────

    toolbar.querySelectorAll('[data-format]').forEach((btn) => {
      btn.addEventListener('mousedown', (e) => {
        e.preventDefault(); // Prevents input from losing focus / selection
      });
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        applyMarkdownFormat(inputOrTextarea, btn.dataset.format);
        updatePreview();
      });
    });

    inputOrTextarea.addEventListener('keydown', (e) => {
      if ((e.ctrlKey || e.metaKey) && (e.key === 'b' || e.key === 'B')) {
        e.preventDefault();
        applyMarkdownFormat(inputOrTextarea, 'bold');
        updatePreview();
      } else if ((e.ctrlKey || e.metaKey) && (e.key === 'i' || e.key === 'I')) {
        e.preventDefault();
        applyMarkdownFormat(inputOrTextarea, 'italic');
        updatePreview();
      } else if ((e.ctrlKey || e.metaKey) && (e.key === 'u' || e.key === 'U')) {
        e.preventDefault();
        applyMarkdownFormat(inputOrTextarea, 'underline');
        updatePreview();
      }
    });
  });
}

// Global delegated fallback for toolbar interactions
if (!window.__sppRichToolbarDelegated) {
  window.__sppRichToolbarDelegated = true;
  document.addEventListener('mousedown', (e) => {
    const btn = e.target.closest('.editor-toolbar [data-format]');
    if (btn) {
      e.preventDefault();
    }
  });
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.editor-toolbar [data-format]');
    if (!btn) return;
    const wrap = btn.closest('[data-rich-editor]');
    if (!wrap) return;
    const inputOrTextarea = wrap.querySelector('input, textarea');
    if (!inputOrTextarea) return;
    e.preventDefault();
    applyMarkdownFormat(inputOrTextarea, btn.dataset.format);
    // Trigger preview update if it was set up
    inputOrTextarea.dispatchEvent(new Event('input', { bubbles: true }));
  });
}

/* ─── Local Autosave & Draft Recovery ───────────────────────────────────── */
let newsAutosaveTimer = null;
let activeNewsDraft = null;

function getNewsDraftKey(postId) {
  return postId ? `spp-draft-news-${postId}` : 'spp-draft-news-new';
}

function saveNewsDraft() {
  if (!newsForm) return;
  const postId = state.editingNewsId || null;
  const title = (newsForm.elements.title?.value || '').trim();
  const summary = (newsForm.elements.summary?.value || '').trim();
  const body = (newsForm.elements.body?.value || '').trim();

  // Local storage auto-save disabled to rely strictly on database
  return;
}

function scheduleNewsAutosave() {
  if (newsAutosaveTimer) clearTimeout(newsAutosaveTimer);
  newsAutosaveTimer = setTimeout(() => {
    saveNewsDraft();
  }, 1500);
}

function formatDraftTime(timestamp) {
  if (!timestamp) return '';
  const now = Date.now();
  const diffSec = Math.round((now - timestamp) / 1000);
  if (diffSec < 60) return 'just now';
  const diffMin = Math.round(diffSec / 60);
  if (diffMin < 60) return `${diffMin}m ago`;
  const diffHr = Math.round(diffMin / 60);
  if (diffHr < 24) return `${diffHr}h ago`;
  const date = new Date(timestamp);
  return date.toLocaleDateString(undefined, { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
}

function loadNewsDraft(postId) {
  const banner = document.querySelector('[data-draft-banner="news"]');
  if (banner) banner.classList.add('is-hidden');
  activeNewsDraft = null;
}

function restoreNewsDraft() {
  const banner = document.querySelector('[data-draft-banner="news"]');
  banner?.classList.add('is-hidden');
}

function discardNewsDraft() {
  const banner = document.querySelector('[data-draft-banner="news"]');
  activeNewsDraft = null;
  banner?.classList.add('is-hidden');
}

function clearNewsDraft(postId) {
  activeNewsDraft = null;
  const banner = document.querySelector('[data-draft-banner="news"]');
  banner?.classList.add('is-hidden');
}

function startEditingNews(postId) {
  const post = state.posts.find((p) => p.id === postId);
  if (!post || !newsForm) return;

  state.editingNewsId = post.id;
  newsForm.elements.title.value = post.title || '';
  newsForm.elements.summary.value = post.summary || '';
  newsForm.elements.publishDate.value = post.publishDate || '';
  newsForm.elements.body.value = post.body || '';
  if (newsForm.elements.body._syncToVisual) {
    newsForm.elements.body._syncToVisual();
  }
  newsForm.elements.body.dispatchEvent(new Event('input', { bubbles: true }));
  newsForm.elements.body.dispatchEvent(new Event('change', { bubbles: true }));
  if (newsForm.elements.status) {
    newsForm.elements.status.value = post.status || 'published';
  }

  const newsZone = document.querySelector('[data-upload-zone="news"]');
  if (post.coverImage && newsZone?._applyImage) {
    newsZone._applyImage(post.coverImage, 'Current image');
  } else {
    newsZone?._clearImage?.();
  }

  setNewsView('editor');
  updateNewsEditorUI();
  renderNewsQueue();
  checkNewsDraft(post.id);
  document.querySelector('#news-section')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function cancelEditingNews() {
  state.editingNewsId = null;
  newsForm?.reset();
  if (newsForm?.elements.body) {
    newsForm.elements.body.value = '';
    if (newsForm.elements.body._syncToVisual) {
      newsForm.elements.body._syncToVisual();
    }
    newsForm.elements.body.dispatchEvent(new Event('input', { bubbles: true }));
    newsForm.elements.body.dispatchEvent(new Event('change', { bubbles: true }));
  }
  document.querySelector('[data-upload-zone="news"]')?._clearImage?.();
  updateNewsEditorUI();
  renderNewsQueue();
  checkNewsDraft(null);
}

function handleNewsSubmit(event) {
  event.preventDefault();
  if (!newsForm) return;

  const overrideStatus = event.submitter?.dataset.statusOverride;
  const data = new FormData(newsForm);
  const title = String(data.get('title') || '').trim();
  if (!title) return;

  const chosenStatus = overrideStatus || String(data.get('status') || 'published');

  const postData = {
    type: 'announcement',
    section: 'News',
    title,
    summary: String(data.get('summary') || '').trim(),
    publishDate: String(data.get('publishDate') || ''),
    status: chosenStatus,
    body: String(data.get('body') || '').trim(),
    coverImage: imageState.news || null,
  };

  if (state.editingNewsId) {
    const idx = state.posts.findIndex((p) => p.id === state.editingNewsId);
    if (idx >= 0) {
      state.posts[idx] = { ...state.posts[idx], ...postData };
    }
    state.editingNewsId = null;
  } else {
    const newPost = {
      id: typeof crypto !== 'undefined' && crypto.randomUUID ? crypto.randomUUID() : `post-${Date.now()}`,
      ...postData,
    };
    state.posts = [newPost, ...state.posts];
  }

  const savedId = state.editingNewsId;
  savePosts();
  newsForm.reset();
  if (newsForm?.elements.body) {
    newsForm.elements.body.value = '';
    if (newsForm.elements.body._syncToVisual) {
      newsForm.elements.body._syncToVisual();
    }
    newsForm.elements.body.dispatchEvent(new Event('input', { bubbles: true }));
    newsForm.elements.body.dispatchEvent(new Event('change', { bubbles: true }));
  }
  document.querySelector('[data-upload-zone="news"]')?._clearImage?.();
  clearNewsDraft(savedId);
  renderAll();
  setNewsView('posts');
}

function handleNewsAction(event) {
  const target = event.target.closest('[data-news-action]');
  if (!target) return;

  const item = target.closest('[data-post-id]');
  if (!item) return;

  const postId = item.dataset.postId;
  const action = target.dataset.newsAction;

  if (action === 'edit') {
    startEditingNews(postId);
    return;
  }

  const idx = state.posts.findIndex((p) => p.id === postId);
  if (idx < 0) return;

  if (action === 'delete') {
    if (state.editingNewsId === postId) state.editingNewsId = null;
    state.posts.splice(idx, 1);
  } else if (action === 'publish') {
    state.posts[idx].status = 'published';
  } else if (action === 'archive') {
    state.posts[idx].status = 'archived';
  } else if (action === 'draft') {
    state.posts[idx].status = 'draft';
  }

  savePosts();
  renderAll();
}

function startEditingActivity(postId) {
  const post = state.posts.find((p) => p.id === postId);
  if (!post || !activityForm) return;

  state.editingActivityId = post.id;
  activityForm.elements.title.value = post.title || '';
  activityForm.elements.summary.value = post.summary || '';
  activityForm.elements.publishDate.value = post.publishDate || '';
  activityForm.elements.body.value = post.body || '';
  if (activityForm.elements.body._syncToVisual) {
    activityForm.elements.body._syncToVisual();
  }
  activityForm.elements.body.dispatchEvent(new Event('input', { bubbles: true }));
  activityForm.elements.body.dispatchEvent(new Event('change', { bubbles: true }));
  if (activityForm.elements.status) {
    activityForm.elements.status.value = post.status || 'scheduled';
  }

  const activityZone = document.querySelector('[data-upload-zone="activity"]');
  if (post.coverImage && activityZone?._applyImage) {
    activityZone._applyImage(post.coverImage, 'Current image');
  } else {
    activityZone?._clearImage?.();
  }

  setActivityView('editor');
  updateActivityEditorUI();
  renderActivityQueue();
  document.querySelector('#activities-section')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function cancelEditingActivity() {
  state.editingActivityId = null;
  activityForm?.reset();
  if (activityForm?.elements.body) {
    activityForm.elements.body.value = '';
    if (activityForm.elements.body._syncToVisual) {
      activityForm.elements.body._syncToVisual();
    }
    activityForm.elements.body.dispatchEvent(new Event('input', { bubbles: true }));
    activityForm.elements.body.dispatchEvent(new Event('change', { bubbles: true }));
  }
  document.querySelector('[data-upload-zone="activity"]')?._clearImage?.();
  updateActivityEditorUI();
  renderActivityQueue();
}

function handleActivitySubmit(event) {
  event.preventDefault();
  if (!activityForm) return;

  const overrideStatus = event.submitter?.dataset.statusOverride;
  const data = new FormData(activityForm);
  const title = String(data.get('title') || '').trim();
  if (!title) return;

  const chosenStatus = overrideStatus || String(data.get('status') || 'scheduled');

  const postData = {
    type: 'event',
    section: 'Activities',
    title,
    summary: String(data.get('summary') || '').trim(),
    publishDate: String(data.get('publishDate') || ''),
    status: chosenStatus,
    body: String(data.get('body') || '').trim(),
    coverImage: imageState.activity || null,
  };

  if (state.editingActivityId) {
    const idx = state.posts.findIndex((p) => p.id === state.editingActivityId);
    if (idx >= 0) {
      state.posts[idx] = { ...state.posts[idx], ...postData };
    }
    state.editingActivityId = null;
  } else {
    const newPost = {
      id: typeof crypto !== 'undefined' && crypto.randomUUID ? crypto.randomUUID() : `post-${Date.now()}`,
      ...postData,
    };
    state.posts = [newPost, ...state.posts];
  }

  savePosts();
  activityForm.reset();
  document.querySelector('[data-upload-zone="activity"]')?._clearImage?.();
  renderAll();
  setActivityView('posts');
}

function handleActivityAction(event) {
  const target = event.target.closest('[data-activity-action]');
  if (!target) return;

  const item = target.closest('[data-post-id]');
  if (!item) return;

  const postId = item.dataset.postId;
  const action = target.dataset.activityAction;

  if (action === 'edit') {
    startEditingActivity(postId);
    return;
  }

  const idx = state.posts.findIndex((p) => p.id === postId);
  if (idx < 0) return;

  if (action === 'delete') {
    if (state.editingActivityId === postId) state.editingActivityId = null;
    state.posts.splice(idx, 1);
  } else if (action === 'publish') {
    state.posts[idx].status = 'published';
  } else if (action === 'archive') {
    state.posts[idx].status = 'archived';
  } else if (action === 'draft') {
    state.posts[idx].status = 'draft';
  }

  savePosts();
  renderAll();
}

function bindEvents() {
  document.querySelector('[data-show-news-posts]')?.addEventListener('click', () => setNewsView('posts'));
  document.querySelector('[data-show-news-editor]')?.addEventListener('click', () => {
    cancelEditingNews();
    setNewsView('editor');
  });

  document.querySelector('[data-show-activity-posts]')?.addEventListener('click', () => setActivityView('posts'));
  document.querySelector('[data-show-activity-editor]')?.addEventListener('click', () => {
    cancelEditingActivity();
    setActivityView('editor');
  });

  newsLoadMoreBtn?.addEventListener('click', () => {
    state.newsVisibleCount += PAGE_SIZE;
    renderNewsQueue();
  });

  newsShowLessBtn?.addEventListener('click', () => {
    state.newsVisibleCount = PAGE_SIZE;
    renderNewsQueue();
  });

  activityLoadMoreBtn?.addEventListener('click', () => {
    state.activityVisibleCount += PAGE_SIZE;
    renderActivityQueue();
  });

  activityShowLessBtn?.addEventListener('click', () => {
    state.activityVisibleCount = PAGE_SIZE;
    renderActivityQueue();
  });

  newsForm?.addEventListener('submit', handleNewsSubmit);
  newsForm?.addEventListener('input', (e) => {
    if (['title', 'summary', 'body'].includes(e.target.name)) {
      scheduleNewsAutosave();
    }
  });
  newsForm?.addEventListener('reset', () => {
    state.editingNewsId = null;
    window.setTimeout(() => {
      if (newsForm?.elements.body) {
        newsForm.elements.body.value = '';
        if (newsForm.elements.body._syncToVisual) {
          newsForm.elements.body._syncToVisual();
        }
        newsForm.elements.body.dispatchEvent(new Event('input', { bubbles: true }));
        newsForm.elements.body.dispatchEvent(new Event('change', { bubbles: true }));
      }
      updateNewsEditorUI();
      checkNewsDraft(null);
    }, 0);
  });
  newsCancelEdit?.addEventListener('click', cancelEditingNews);
  newsList?.addEventListener('click', handleNewsAction);

  document.querySelector('[data-draft-restore="news"]')?.addEventListener('click', restoreNewsDraft);
  document.querySelector('[data-draft-discard="news"]')?.addEventListener('click', discardNewsDraft);

  activityForm?.addEventListener('submit', handleActivitySubmit);
  activityForm?.addEventListener('reset', () => {
    state.editingActivityId = null;
    window.setTimeout(() => {
      if (activityForm?.elements.body) {
        activityForm.elements.body.value = '';
        if (activityForm.elements.body._syncToVisual) {
          activityForm.elements.body._syncToVisual();
        }
        activityForm.elements.body.dispatchEvent(new Event('input', { bubbles: true }));
        activityForm.elements.body.dispatchEvent(new Event('change', { bubbles: true }));
      }
      updateActivityEditorUI();
    }, 0);
  });
  activityCancelEdit?.addEventListener('click', cancelEditingActivity);
  activityList?.addEventListener('click', handleActivityAction);

  document.querySelectorAll('[data-news-filter]').forEach((btn) => {
    btn.addEventListener('click', () => {
      state.newsFilter = btn.dataset.newsFilter;
      state.newsVisibleCount = PAGE_SIZE;
      document.querySelectorAll('[data-news-filter]').forEach((b) => b.classList.toggle('active', b === btn));
      renderNewsQueue();
    });
  });

  document.querySelectorAll('[data-activity-filter]').forEach((btn) => {
    btn.addEventListener('click', () => {
      state.activityFilter = btn.dataset.activityFilter;
      state.activityVisibleCount = PAGE_SIZE;
      document.querySelectorAll('[data-activity-filter]').forEach((b) => b.classList.toggle('active', b === btn));
      renderActivityQueue();
    });
  });
}

const savedTheme = localStorage.getItem(themeKey);
const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
setTheme(savedTheme || (prefersDark ? 'dark' : 'light'));

themeToggle?.addEventListener('click', () => {
  const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
  setTheme(isDark ? 'light' : 'dark');
});

const menuToggle = document.querySelector('[data-menu-toggle]');
const menuClose = document.querySelector('[data-menu-close]');
const sidebar = document.querySelector('[data-sidebar]');
const navLinks = Array.from(document.querySelectorAll('[data-nav-link]'));

function openSidebar() {
  sidebar?.classList.add('is-open');
}

function closeSidebar() {
  sidebar?.classList.remove('is-open');
}

menuToggle?.addEventListener('click', openSidebar);
menuClose?.addEventListener('click', closeSidebar);

navLinks.forEach((link) => {
  link.addEventListener('click', closeSidebar);
});

function updateActiveNavLink() {
  let currentHash = window.location.hash || '#news-section';
  if (!['#news-section', '#activities-section', '#conferences-section', '#downloads-section', '#hero-banner-section'].includes(currentHash)) {
    currentHash = '#news-section';
  }
  navLinks.forEach((link) => {
    const isActive = link.getAttribute('href') === currentHash;
    link.classList.toggle('active', isActive);
  });

  const sections = ['news-section', 'activities-section', 'conferences-section', 'downloads-section', 'hero-banner-section'];
  sections.forEach((secId) => {
    const secEl = document.getElementById(secId);
    if (secEl) {
      const isTarget = currentHash === `#${secId}`;
      secEl.classList.toggle('is-hidden-section', !isTarget);
    }
  });
}
window.addEventListener('hashchange', updateActiveNavLink);
window.addEventListener('load', updateActiveNavLink);

renderAll();
if (!state.editingId) setNewsView('posts');
if (!state.editingActivityId) setActivityView('posts');
bindEvents();
setupRichEditorToolbars();
updateActiveNavLink();
checkNewsDraft(null);

setupImageUpload('news');
setupImageUpload('activity');
setupImageUpload('hero-banner');

// ─── Hero Banner Settings & Link Handling ─────────────────────────────────────
const bannerLinkTypeSelect = document.querySelector('[data-hero-banner-link-type]');
const bannerPostRow = document.querySelector('[data-hero-banner-post-row]');
const bannerPostSelect = document.querySelector('[data-hero-banner-post-select]');
const bannerUrlRow = document.querySelector('[data-hero-banner-url-row]');
const bannerCustomUrlInput = document.querySelector('[data-hero-banner-custom-url]');
const bannerTargetRow = document.querySelector('[data-hero-banner-target-row]');
const bannerNewTabCheckbox = document.querySelector('[data-hero-banner-new-tab]');

let availableBannerPosts = { news: [], activities: [], conferences: [] };

function updateBannerLinkVisibility() {
  const val = bannerLinkTypeSelect ? bannerLinkTypeSelect.value : 'none';
  if (bannerPostRow) bannerPostRow.classList.toggle('is-hidden', val !== 'post');
  if (bannerUrlRow) bannerUrlRow.classList.toggle('is-hidden', val !== 'url');
  if (bannerTargetRow) bannerTargetRow.classList.toggle('is-hidden', val === 'none');
}

bannerLinkTypeSelect?.addEventListener('change', updateBannerLinkVisibility);

function populateBannerPostsDropdown(selectedType, selectedId, selectedSlug) {
  if (!bannerPostSelect) return;

  bannerPostSelect.innerHTML = '<option value="">-- Choose a post --</option>';

  // NEWS
  if (availableBannerPosts.news && availableBannerPosts.news.length > 0) {
    const newsGroup = document.createElement('optgroup');
    newsGroup.label = 'News';

    availableBannerPosts.news.forEach((post) => {
      const opt = document.createElement('option');

      opt.value = `news:${post.id}`;
      opt.textContent = `${post.title} (${post.date || 'Recent'})`;

      if (
        selectedType === 'news' &&
        String(selectedId) === String(post.id)
      ) {
        opt.selected = true;
      }

      newsGroup.appendChild(opt);
    });

    bannerPostSelect.appendChild(newsGroup);
  }

  // ACTIVITIES
  if (
    availableBannerPosts.activities &&
    availableBannerPosts.activities.length > 0
  ) {
    const activityGroup = document.createElement('optgroup');
    activityGroup.label = 'Activities';

    availableBannerPosts.activities.forEach((post) => {
      const opt = document.createElement('option');

      opt.value = `activity:${post.id}`;
      opt.textContent = `${post.title} (${post.date || 'Upcoming'})`;

      if (
        selectedType === 'activity' &&
        String(selectedId) === String(post.id)
      ) {
        opt.selected = true;
      }

      activityGroup.appendChild(opt);
    });

    bannerPostSelect.appendChild(activityGroup);
  }

  // CONFERENCE
  if (
    availableBannerPosts.conferences &&
    availableBannerPosts.conferences.length > 0
  ) {
    const conferenceGroup = document.createElement('optgroup');
    conferenceGroup.label = 'Conference';

    availableBannerPosts.conferences.forEach((post) => {
      const opt = document.createElement('option');

      opt.value = `conference:${post.id}:${post.slug || post.year || ''}`;

      opt.textContent =
        `${post.title || `SPP${post.year || ''}`} ` +
        `(${post.date || post.year || 'Conference'})`;

      if (
        selectedType === 'conference' &&
        (
          String(selectedId) === String(post.id) ||
          String(selectedSlug) === String(post.slug) ||
          String(selectedSlug) === String(post.year)
        )
      ) {
        opt.selected = true;
      }

      conferenceGroup.appendChild(opt);
    });

    bannerPostSelect.appendChild(conferenceGroup);
  }
}


async function loadHeroBannerSetting() {
  try {
    const res = await fetch('/admin/api/hero-banner');
    if (res.ok) {
      const data = await res.json();
      if (data.available_posts) {
        availableBannerPosts = data.available_posts;
      }

      if (data.image_url) {
        imageState['hero-banner'] = data.image_url;
        const zone = document.querySelector('[data-upload-zone="hero-banner"]');
        if (zone && zone._applyImage) {
          zone._applyImage(data.image_url, 'Current Hero Banner');
        }
      }

      // Populate Link Form fields
      const linkType = data.link_type || 'none';
      if (['news', 'activity', 'conference'].includes(linkType)) {
        if (bannerLinkTypeSelect) bannerLinkTypeSelect.value = 'post';
        populateBannerPostsDropdown(linkType, data.link_target_id, data.link_target_slug);
      } else if (linkType === 'url') {
        if (bannerLinkTypeSelect) bannerLinkTypeSelect.value = 'url';
        populateBannerPostsDropdown(null, null, null);
        if (bannerCustomUrlInput) bannerCustomUrlInput.value = data.link_url || '';
      } else {
        if (bannerLinkTypeSelect) bannerLinkTypeSelect.value = 'none';
        populateBannerPostsDropdown(null, null, null);
        if (bannerCustomUrlInput) bannerCustomUrlInput.value = '';
      }

      if (bannerNewTabCheckbox) {
        bannerNewTabCheckbox.checked = Boolean(data.open_in_new_tab);
      }

      updateBannerLinkVisibility();
    }
  } catch (err) {
    console.error('Error fetching hero banner:', err);
  }
}
loadHeroBannerSetting();

document.querySelector('[data-hero-banner-form]')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  const form = e.target;
  const submitter = e.submitter || form.querySelector('[data-hero-banner-submit]');
  const fileInput = form.querySelector('input[type="file"]');
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  const formData = new FormData();

  if (fileInput && fileInput.files[0]) {
    formData.append('image', fileInput.files[0]);
  } else if (imageState['hero-banner']) {
    formData.append('image_url', imageState['hero-banner']);
  } else {
    alert('Please select or upload a banner image first.');
    return;
  }

  // Handle Link Destination
  const chosenLinkType = bannerLinkTypeSelect ? bannerLinkTypeSelect.value : 'none';
  if (chosenLinkType === 'post') {
    const postVal = bannerPostSelect ? bannerPostSelect.value : '';
    if (!postVal) {
      alert('Please choose an existing post for the banner link.');
      return;
    }
    const [tType, tId, tSlug] = postVal.split(':');
    formData.append('link_type', tType);
    if (tType === 'conference') {
      if (tSlug) formData.append('link_target_slug', tSlug);
      if (tId && !isNaN(Number(tId))) formData.append('link_target_id', tId);
    } else {
      formData.append('link_target_id', tId);
    }
  } else if (chosenLinkType === 'url') {
    const urlVal = bannerCustomUrlInput ? bannerCustomUrlInput.value.trim() : '';
    if (!urlVal) {
      alert('Please enter a destination URL.');
      return;
    }
    formData.append('link_type', 'url');
    formData.append('link_url', urlVal);
  } else {
    formData.append('link_type', 'none');
  }

  if (chosenLinkType !== 'none' && bannerNewTabCheckbox && bannerNewTabCheckbox.checked) {
    formData.append('open_in_new_tab', '1');
  } else {
    formData.append('open_in_new_tab', '0');
  }

  setButtonLoading(submitter, true, 'Saving Banner...');

  try {
    const res = await fetch('/admin/api/hero-banner', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken || '',
        'Accept': 'application/json',
      },
      body: formData,
    });

    const data = await res.json();
    if (res.ok) {
      imageState['hero-banner'] = data.image_url;
      const zone = document.querySelector('[data-upload-zone="hero-banner"]');
      if (zone && zone._applyImage) {
        zone._applyImage(data.image_url, 'Current Hero Banner');
      }
      const userHeroBannerImg = document.getElementById('hero-banner-img');
      const userHeroBannerTitle = document.getElementById('hero-banner-title');
      if (userHeroBannerImg) {
        userHeroBannerImg.src = data.image_url;
        userHeroBannerImg.style.display = 'block';
      }
      if (userHeroBannerTitle) {
        userHeroBannerTitle.style.display = 'none';
      }
      alert('Hero Banner and link destination saved successfully!');
    } else {
      alert(data.message || 'Failed to save hero banner.');
    }
  } catch (err) {
    console.error(err);
    alert('An error occurred while uploading hero banner.');
  } finally {
    setButtonLoading(submitter, false);
  }
});

document.querySelector('[data-hero-banner-reset]')?.addEventListener('click', async (e) => {
  const target = e.currentTarget;
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  setButtonLoading(target, true, 'Resetting...');
  try {
    const res = await fetch('/admin/api/hero-banner', {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': csrfToken || '',
        'Accept': 'application/json',
      },
    });
    if (res.ok) {
      imageState['hero-banner'] = null;
      const zone = document.querySelector('[data-upload-zone="hero-banner"]');
      if (zone && zone._clearImage) zone._clearImage();
      const userHeroBannerImg = document.getElementById('hero-banner-img');
      const userHeroBannerTitle = document.getElementById('hero-banner-title');
      if (userHeroBannerImg) {
        userHeroBannerImg.src = '';
        userHeroBannerImg.style.display = 'none';
      }
      if (userHeroBannerTitle) {
        userHeroBannerTitle.style.display = 'block';
      }

      if (bannerLinkTypeSelect) bannerLinkTypeSelect.value = 'none';
      if (bannerPostSelect) bannerPostSelect.value = '';
      if (bannerCustomUrlInput) bannerCustomUrlInput.value = '';
      if (bannerNewTabCheckbox) bannerNewTabCheckbox.checked = false;
      updateBannerLinkVisibility();

      alert('Hero Banner removed. Website title will be displayed.');
    } else {
      alert('Failed to reset hero banner.');
    }
  } catch (err) {
    console.error(err);
    alert('Error resetting hero banner.');
  } finally {
    setButtonLoading(target, false);
  }
});

document.querySelector('[data-upload-clear="hero-banner"]')?.addEventListener('click', async (e) => {
  const target = e.currentTarget;
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  setButtonLoading(target, true, 'Removing...');
  try {
    const res = await fetch('/admin/api/hero-banner', {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': csrfToken || '',
        'Accept': 'application/json',
      },
    });
    if (res.ok) {
      imageState['hero-banner'] = null;
      const zone = document.querySelector('[data-upload-zone="hero-banner"]');
      if (zone && zone._clearImage) zone._clearImage();
      const userHeroBannerImg = document.getElementById('hero-banner-img');
      const userHeroBannerTitle = document.getElementById('hero-banner-title');
      if (userHeroBannerImg) {
        userHeroBannerImg.src = '';
        userHeroBannerImg.style.display = 'none';
      }
      if (userHeroBannerTitle) {
        userHeroBannerTitle.style.display = 'block';
      }

      if (bannerLinkTypeSelect) bannerLinkTypeSelect.value = 'none';
      if (bannerPostSelect) bannerPostSelect.value = '';
      if (bannerCustomUrlInput) bannerCustomUrlInput.value = '';
      if (bannerNewTabCheckbox) bannerNewTabCheckbox.checked = false;
      updateBannerLinkVisibility();
    }
  } catch (err) {
    console.error(err);
  } finally {
    setButtonLoading(target, false);
  }
});

newsForm?.addEventListener('reset', () => {
  window.setTimeout(() => {
    if (newsForm?.elements.body) {
      newsForm.elements.body.value = '';
      if (newsForm.elements.body._syncToVisual) {
        newsForm.elements.body._syncToVisual();
      }
      newsForm.elements.body.dispatchEvent(new Event('input', { bubbles: true }));
      newsForm.elements.body.dispatchEvent(new Event('change', { bubbles: true }));
    }
    document.querySelector('[data-upload-zone="news"]')?._clearImage?.();
  }, 0);
});
activityForm?.addEventListener('reset', () => {
  window.setTimeout(() => {
    if (activityForm?.elements.body) {
      activityForm.elements.body.value = '';
      if (activityForm.elements.body._syncToVisual) {
        activityForm.elements.body._syncToVisual();
      }
      activityForm.elements.body.dispatchEvent(new Event('input', { bubbles: true }));
      activityForm.elements.body.dispatchEvent(new Event('change', { bubbles: true }));
    }
    document.querySelector('[data-upload-zone="activity"]')?._clearImage?.();
  }, 0);
});

// ─── Downloads Manager: Dynamic Categories & Solo Category Editor ────────────
const DOWNLOADS_STORAGE_KEY = 'spp-admin-downloads-v1';

const defaultDownloadCategories = [
  {
    id: 'cat-1',
    name: 'Conference Handbooks',
    docs: [
      { id: 'doc-1', year: '2026', title: 'SPP2026 Conference Handbook', filename: 'Handbook_2026.pdf' },
      { id: 'doc-2', year: '2025', title: 'SPP2025 Conference Handbook', filename: 'Handbook_2025.pdf' },
      { id: 'doc-3', year: '2024', title: 'SPP2024 Conference Handbook', filename: 'Handbook_2024.pdf' },
      { id: 'doc-4', year: '2023', title: 'SPP2023 Conference Handbook', filename: 'Handbook_2023.pdf' },
      { id: 'doc-5', year: '2022', title: 'SPP2022 Conference Handbook', filename: 'Handbook_2022.pdf' },
      { id: 'doc-6', year: '2021', title: 'SPP2021 Conference Handbook', filename: 'Handbook_2021.pdf' },
      { id: 'doc-7', year: '2020', title: 'SPP2020 Conference Handbook', filename: 'Handbook_2020.pdf' },
      { id: 'doc-8', year: '2019', title: 'SPP2019 Conference Handbook', filename: 'Handbook_2019.pdf' },
      { id: 'doc-9', year: '2018', title: 'SPP2018 Conference Handbook', filename: 'Handbook_2018.pdf' },
      { id: 'doc-10', year: '2017', title: 'SPP2017 Conference Handbook', filename: 'Handbook_2017.pdf' },
      { id: 'doc-11', year: '2016', title: 'SPP2016 Conference Handbook', filename: 'Handbook_2016.pdf' },
      { id: 'doc-12', year: '2015', title: 'SPP2015 Conference Handbook', filename: 'Handbook_2015.pdf' },
    ],
  },
  {
    id: 'cat-2',
    name: 'Backdrops for Online Talks',
    docs: [
      { id: 'doc-13', year: '2021', title: 'SPP2021 Virtual Conference Backdrop', filename: 'Backdrop_2021.png' },
      { id: 'doc-14', year: '2020', title: 'SPP2020 Virtual Conference Backdrop', filename: 'Backdrop_2020.png' },
    ],
  },
  {
    id: 'cat-3',
    name: 'PASUC Endorsement',
    docs: [
      { id: 'doc-15', year: '2024', title: 'PASUC Advisory Endorsement 2024', filename: 'PASUC_2024.pdf' },
    ],
  },
  {
    id: 'cat-4',
    name: 'DepEd Advisory',
    docs: [
      { id: 'doc-16', year: '2021', title: 'DepEd Advisory No. 042 s. 2021', filename: 'DepEd_2021.pdf' },
      { id: 'doc-17', year: '2020', title: 'DepEd Advisory No. 018 s. 2020', filename: 'DepEd_2020.pdf' },
    ],
  },
  {
    id: 'cat-5',
    name: 'CHEd Endorsement',
    docs: [
      { id: 'doc-18', year: '2019', title: 'CHEd Endorsement Letter 2019', filename: 'CHEd_2019.pdf' },
      { id: 'doc-19', year: '2018', title: 'CHEd Endorsement Letter 2018', filename: 'CHEd_2018.pdf' },
    ],
  },
];

function loadDownloadData() {
  try {
    const raw = localStorage.getItem(DOWNLOADS_STORAGE_KEY);
    if (raw) {
      const parsed = JSON.parse(raw);
      if (Array.isArray(parsed) && parsed.length > 0) return parsed;
    }
  } catch (e) {
    console.error('Failed to load downloads from storage', e);
  }
  return JSON.parse(JSON.stringify(defaultDownloadCategories));
}

function saveDownloadData(data) {
  try {
    localStorage.setItem(DOWNLOADS_STORAGE_KEY, JSON.stringify(data));
  } catch (e) {
    console.error('Failed to save downloads to storage', e);
  }
}

let downloadCategories = loadDownloadData();
let downloadEditingCatId = null;
let downloadCatVisibleCount = 3;
let downloadDocVisibleCount = 3;

const downloadViews = {
  categories: document.querySelector('[data-download-view="categories"]'),
  categoryEditor: document.querySelector('[data-download-view="category-editor"]'),
  docEditor: document.querySelector('[data-download-view="doc-editor"]'),
};

const downloadCatListEl = document.querySelector('[data-download-categories-list]');
const downloadDocsListEl = document.querySelector('[data-download-docs-list]');
const downloadCatPaginationEl = document.querySelector('[data-download-cat-pagination]');
const downloadCatPaginationInfo = document.querySelector('[data-download-cat-pagination-info]');
const downloadCatLoadMoreBtn = document.querySelector('[data-download-cat-load-more]');
const downloadCatShowLessBtn = document.querySelector('[data-download-cat-show-less]');

const downloadDocPaginationEl = document.querySelector('[data-download-doc-pagination]');
const downloadDocPaginationInfo = document.querySelector('[data-download-doc-pagination-info]');
const downloadDocLoadMoreBtn = document.querySelector('[data-download-doc-load-more]');
const downloadDocShowLessBtn = document.querySelector('[data-download-doc-show-less]');

function setDownloadView(viewName) {
  if (downloadViews.categories) downloadViews.categories.classList.toggle('is-hidden', viewName !== 'categories');
  if (downloadViews.categoryEditor) downloadViews.categoryEditor.classList.toggle('is-hidden', viewName !== 'category-editor');
  if (downloadViews.docEditor) downloadViews.docEditor.classList.toggle('is-hidden', viewName !== 'doc-editor');
}

function updateDownloadBadges() {
  const totalCats = downloadCategories.length;
  const totalDocs = downloadCategories.reduce((sum, cat) => sum + (cat.docs ? cat.docs.length : 0), 0);

  document.querySelectorAll('[data-download-total-cats]').forEach((el) => (el.textContent = String(totalCats)));
  document.querySelectorAll('[data-download-total-docs]').forEach((el) => (el.textContent = String(totalDocs)));
  document.querySelectorAll('[data-downloads-count-badge]').forEach((el) => (el.textContent = String(totalDocs)));
}

function renderDownloadCategoriesList() {
  if (!downloadCatListEl) return;
  downloadCatListEl.innerHTML = '';

  const total = downloadCategories.length;
  const visible = downloadCategories.slice(0, downloadCatVisibleCount);

  if (visible.length === 0) {
    downloadCatListEl.innerHTML = `
      <div style="text-align: center; padding: 36px 16px; background: var(--surface-soft); border-radius: var(--radius-md); border: 1px dashed var(--border); color: var(--muted);">
        <p style="margin: 0;">No document categories found. Click "Add Category" to create one.</p>
      </div>
    `;
  } else {
    visible.forEach((cat) => {
      const docCount = cat.docs ? cat.docs.length : 0;
      const row = document.createElement('div');
      row.className = 'downloads-cat-row';
      row.innerHTML = `
        <div class="downloads-cat-info">
          <div class="downloads-cat-folder-icon" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg></div>
          <div class="downloads-cat-title-wrap">
            <span class="downloads-cat-name">${escapeHtml(cat.name)}</span>
            <span class="downloads-cat-meta">${docCount} ${docCount === 1 ? 'document' : 'documents'}</span>
          </div>
        </div>
        <div class="downloads-cat-actions">
          <button type="button" class="item-action" data-download-open-cat="${cat.id}">Edit</button>
          <button type="button" class="item-action danger" data-download-delete-cat-id="${cat.id}">Delete</button>
        </div>
      `;
      downloadCatListEl.appendChild(row);
    });
  }

  // Categories Pagination
  if (downloadCatPaginationEl) {
    if (total > 3) {
      downloadCatPaginationEl.style.display = 'flex';
      if (downloadCatPaginationInfo) {
        downloadCatPaginationInfo.textContent = `Showing ${Math.min(downloadCatVisibleCount, total)} of ${total} categories`;
      }
      if (downloadCatLoadMoreBtn) {
        downloadCatLoadMoreBtn.style.display = downloadCatVisibleCount < total ? '' : 'none';
      }
      if (downloadCatShowLessBtn) {
        downloadCatShowLessBtn.style.display = downloadCatVisibleCount > 3 ? '' : 'none';
      }
    } else {
      downloadCatPaginationEl.style.display = 'none';
    }
  }

  updateDownloadBadges();
}

function openCategoryEditor(catId) {
  const cat = downloadCategories.find((c) => c.id === catId);
  if (!cat) return;

  downloadEditingCatId = catId;
  downloadDocVisibleCount = 3;

  const headingEl = document.querySelector('[data-download-editing-cat-name]');
  const soloTitleEl = document.querySelector('[data-download-solo-cat-title]');
  if (headingEl) headingEl.textContent = `Edit Category: ${cat.name}`;
  if (soloTitleEl) soloTitleEl.textContent = cat.name;

  renderCategoryDocs();
  setDownloadView('category-editor');
}

function renderCategoryDocs() {
  if (!downloadDocsListEl) return;
  downloadDocsListEl.innerHTML = '';

  const cat = downloadCategories.find((c) => c.id === downloadEditingCatId);
  if (!cat) return;

  const docs = cat.docs || [];
  const total = docs.length;

  const countEl = document.querySelector('[data-download-solo-cat-count]');
  if (countEl) countEl.textContent = String(total);

  const visible = docs.slice(0, downloadDocVisibleCount);

  if (visible.length === 0) {
    downloadDocsListEl.innerHTML = `
      <div style="text-align: center; padding: 32px 16px; background: var(--surface-soft); border-radius: var(--radius-md); border: 1px dashed var(--border); color: var(--muted);">
        <p style="margin: 0 0 12px;">No documents in this category yet.</p>
        <button type="button" class="button button-primary" data-download-add-doc>+ Add First Document</button>
      </div>
    `;
  } else {
    visible.forEach((doc) => {
      const row = document.createElement('div');
      row.className = 'downloads-doc-row';
      row.innerHTML = `
        <div class="downloads-doc-info">
          <span class="downloads-doc-pill">${escapeHtml(doc.year || 'File')}</span>
          <div class="downloads-doc-title-wrap">
            <span class="downloads-doc-name">${escapeHtml(doc.title || doc.filename || 'Untitled Document')}</span>
            <span class="downloads-doc-meta">${escapeHtml(doc.filename || 'Document File')}</span>
          </div>
        </div>
        <div class="downloads-doc-actions">
          <button type="button" class="item-action" data-download-edit-doc-id="${doc.id}">Edit</button>
          <button type="button" class="item-action danger" data-download-delete-doc-id="${doc.id}">&times;</button>
        </div>
      `;
      downloadDocsListEl.appendChild(row);
    });
  }

  // Documents Pagination (Minimum 3, show more / show less)
  if (downloadDocPaginationEl) {
    if (total > 3) {
      downloadDocPaginationEl.style.display = 'flex';
      if (downloadDocPaginationInfo) {
        downloadDocPaginationInfo.textContent = `Showing ${Math.min(downloadDocVisibleCount, total)} of ${total} documents`;
      }
      if (downloadDocLoadMoreBtn) {
        downloadDocLoadMoreBtn.style.display = downloadDocVisibleCount < total ? '' : 'none';
      }
      if (downloadDocShowLessBtn) {
        downloadDocShowLessBtn.style.display = downloadDocVisibleCount > 3 ? '' : 'none';
      }
    } else {
      downloadDocPaginationEl.style.display = 'none';
    }
  }

  updateDownloadBadges();
}

function openDocEditor(docId = null, preselectedCatId = null) {
  const form = document.querySelector('[data-download-doc-form]');
  if (!form) return;

  const selectEl = form.querySelector('[data-download-doc-cat-select]');
  if (selectEl) {
    selectEl.innerHTML = '';
    downloadCategories.forEach((cat) => {
      const opt = document.createElement('option');
      opt.value = cat.id;
      opt.textContent = cat.name;
      selectEl.appendChild(opt);
    });
  }

  const headingEl = document.querySelector('[data-download-doc-editor-heading]');
  const bannerTextEl = document.querySelector('[data-download-doc-banner-text]');
  const docIdInput = form.querySelector('input[name="docId"]');
  const catIdInput = form.querySelector('input[name="catId"]');
  const yearInput = form.querySelector('[data-download-doc-year]');
  const titleInput = form.querySelector('[data-download-doc-title]');
  const fileActions = document.querySelector('[data-download-file-actions]');
  const filenameLabel = document.querySelector('[data-download-attached-filename]');

  const targetCatId = preselectedCatId || downloadEditingCatId || (downloadCategories[0] ? downloadCategories[0].id : '');

  if (docId) {
    // Edit existing doc
    let foundDoc = null;
    let foundCat = null;
    for (const cat of downloadCategories) {
      const d = (cat.docs || []).find((item) => item.id === docId);
      if (d) {
        foundDoc = d;
        foundCat = cat;
        break;
      }
    }

    if (foundDoc && foundCat) {
      if (headingEl) headingEl.textContent = `Edit Document: ${foundDoc.title || foundDoc.filename}`;
      if (bannerTextEl) bannerTextEl.textContent = 'Editing Document';
      if (docIdInput) docIdInput.value = foundDoc.id;
      if (catIdInput) catIdInput.value = foundCat.id;
      if (selectEl) selectEl.value = foundCat.id;
      if (yearInput) yearInput.value = foundDoc.year || '';
      if (titleInput) titleInput.value = foundDoc.title || '';

      if (fileActions && filenameLabel) {
        if (foundDoc.filename) {
          filenameLabel.textContent = `Attached: ${foundDoc.filename}`;
          fileActions.classList.remove('is-hidden');
        } else {
          fileActions.classList.add('is-hidden');
        }
      }
    }
  } else {
    // Create new document
    if (headingEl) headingEl.textContent = 'Add Download Document';
    if (bannerTextEl) bannerTextEl.textContent = 'Add Document to Directory';
    if (docIdInput) docIdInput.value = '';
    if (catIdInput) catIdInput.value = targetCatId;
    if (selectEl) selectEl.value = targetCatId;
    if (yearInput) yearInput.value = new Date().getFullYear().toString();
    if (titleInput) titleInput.value = '';
    if (fileActions) fileActions.classList.add('is-hidden');
  }

  setDownloadView('doc-editor');
}

function saveDocFromForm() {
  const form = document.querySelector('[data-download-doc-form]');
  if (!form) return;

  const docIdInput = form.querySelector('input[name="docId"]');
  const selectEl = form.querySelector('[data-download-doc-cat-select]');
  const yearInput = form.querySelector('[data-download-doc-year]');
  const titleInput = form.querySelector('[data-download-doc-title]');
  const fileInput = form.querySelector('[data-download-doc-file-input]');
  const filenameLabel = document.querySelector('[data-download-attached-filename]');

  const docId = docIdInput ? docIdInput.value : '';
  const newCatId = selectEl ? selectEl.value : '';
  const year = yearInput ? yearInput.value.trim() : '';
  const title = titleInput ? titleInput.value.trim() : '';

  if (!title) {
    alert('Please enter a document title.');
    titleInput?.focus();
    return;
  }

  let filename = '';
  if (fileInput && fileInput.files && fileInput.files[0]) {
    filename = fileInput.files[0].name;
  } else if (filenameLabel && filenameLabel.textContent.includes('Attached: ')) {
    filename = filenameLabel.textContent.replace('Attached: ', '').trim();
  } else {
    filename = `${title.replace(/\s+/g, '_')}.pdf`;
  }

  if (docId) {
    // Remove from old category if category changed
    for (const cat of downloadCategories) {
      const idx = (cat.docs || []).findIndex((d) => d.id === docId);
      if (idx !== -1) {
        cat.docs.splice(idx, 1);
        break;
      }
    }
  }

  const targetCat = downloadCategories.find((c) => c.id === newCatId);
  if (targetCat) {
    if (!targetCat.docs) targetCat.docs = [];
    const newDoc = {
      id: docId || `doc-${Date.now()}`,
      year: year || new Date().getFullYear().toString(),
      title,
      filename,
    };
    targetCat.docs.unshift(newDoc);
  }

  saveDownloadData(downloadCategories);

  // Return to the category editor if we were editing inside it, otherwise categories list
  downloadEditingCatId = newCatId;
  openCategoryEditor(newCatId);
}

function initDownloadsManager() {
  renderDownloadCategoriesList();

  // Categories Pagination clicks
  downloadCatLoadMoreBtn?.addEventListener('click', () => {
    downloadCatVisibleCount += 3;
    renderDownloadCategoriesList();
  });
  downloadCatShowLessBtn?.addEventListener('click', () => {
    downloadCatVisibleCount = 3;
    renderDownloadCategoriesList();
    document.getElementById('downloads-section')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  // Docs Pagination clicks
  downloadDocLoadMoreBtn?.addEventListener('click', () => {
    downloadDocVisibleCount += 3;
    renderCategoryDocs();
  });
  downloadDocShowLessBtn?.addEventListener('click', () => {
    downloadDocVisibleCount = 3;
    renderCategoryDocs();
    document.getElementById('downloads-section')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  // Back button
  document.querySelector('[data-download-back-to-categories]')?.addEventListener('click', () => {
    downloadEditingCatId = null;
    renderDownloadCategoriesList();
    setDownloadView('categories');
  });

  // Add Category button
  document.querySelector('[data-download-add-category]')?.addEventListener('click', () => {
    const name = prompt('Enter name for the new category:');
    if (name && name.trim()) {
      const newCat = {
        id: `cat-${Date.now()}`,
        name: name.trim(),
        docs: [],
      };
      downloadCategories.push(newCat);
      saveDownloadData(downloadCategories);
      renderDownloadCategoriesList();
      openCategoryEditor(newCat.id);
    }
  });

  // Rename category
  document.querySelector('[data-download-rename-cat]')?.addEventListener('click', () => {
    const cat = downloadCategories.find((c) => c.id === downloadEditingCatId);
    if (!cat) return;
    const newName = prompt('Enter new category name:', cat.name);
    if (newName && newName.trim()) {
      cat.name = newName.trim();
      saveDownloadData(downloadCategories);
      openCategoryEditor(cat.id);
    }
  });

  // Delete category from solo view
  document.querySelector('[data-download-delete-cat]')?.addEventListener('click', () => {
    const cat = downloadCategories.find((c) => c.id === downloadEditingCatId);
    if (!cat) return;
    if (confirm(`Are you sure you want to delete the category "${cat.name}" and all its documents?`)) {
      downloadCategories = downloadCategories.filter((c) => c.id !== cat.id);
      saveDownloadData(downloadCategories);
      downloadEditingCatId = null;
      renderDownloadCategoriesList();
      setDownloadView('categories');
    }
  });

  // Open Document Editor (Add button)
  document.querySelectorAll('[data-download-add-doc]').forEach((btn) => {
    btn.addEventListener('click', () => {
      openDocEditor(null, downloadEditingCatId);
    });
  });

  // Document Editor Actions
  document.querySelector('[data-download-doc-save-btn]')?.addEventListener('click', saveDocFromForm);
  document.querySelectorAll('[data-download-doc-cancel-btn]').forEach((btn) => {
    btn.addEventListener('click', () => {
      if (downloadEditingCatId) {
        setDownloadView('category-editor');
      } else {
        setDownloadView('categories');
      }
    });
  });

  // File upload input change
  const fileInput = document.querySelector('[data-download-doc-file-input]');
  const uploadZone = document.getElementById('download-doc-upload-zone');
  const fileActions = document.querySelector('[data-download-file-actions]');
  const filenameLabel = document.querySelector('[data-download-attached-filename]');
  const clearFileBtn = document.querySelector('[data-download-clear-file]');

  uploadZone?.addEventListener('click', () => fileInput?.click());
  fileInput?.addEventListener('change', () => {
    if (fileInput.files && fileInput.files[0]) {
      const name = fileInput.files[0].name;
      if (filenameLabel) filenameLabel.textContent = `Attached: ${name}`;
      fileActions?.classList.remove('is-hidden');
    }
  });

  clearFileBtn?.addEventListener('click', () => {
    if (fileInput) fileInput.value = '';
    if (filenameLabel) filenameLabel.textContent = '';
    fileActions?.classList.add('is-hidden');
  });

  // Delegated clicks for Category and Document rows
  document.addEventListener('click', (e) => {
    // Open category edit
    const openCatBtn = e.target.closest('[data-download-open-cat]');
    if (openCatBtn) {
      e.preventDefault();
      const catId = openCatBtn.getAttribute('data-download-open-cat');
      openCategoryEditor(catId);
      return;
    }

    // Delete category from list
    const delCatBtn = e.target.closest('[data-download-delete-cat-id]');
    if (delCatBtn) {
      e.preventDefault();
      const catId = delCatBtn.getAttribute('data-download-delete-cat-id');
      const cat = downloadCategories.find((c) => c.id === catId);
      if (cat && confirm(`Are you sure you want to delete "${cat.name}"?`)) {
        downloadCategories = downloadCategories.filter((c) => c.id !== catId);
        saveDownloadData(downloadCategories);
        renderDownloadCategoriesList();
      }
      return;
    }

    // Edit doc
    const editDocBtn = e.target.closest('[data-download-edit-doc-id]');
    if (editDocBtn) {
      e.preventDefault();
      const docId = editDocBtn.getAttribute('data-download-edit-doc-id');
      openDocEditor(docId);
      return;
    }

    // Delete doc
    const delDocBtn = e.target.closest('[data-download-delete-doc-id]');
    if (delDocBtn) {
      e.preventDefault();
      const docId = delDocBtn.getAttribute('data-download-delete-doc-id');
      const cat = downloadCategories.find((c) => c.id === downloadEditingCatId);
      if (cat) {
        const doc = (cat.docs || []).find((d) => d.id === docId);
        if (doc && confirm(`Delete document "${doc.title || doc.filename}"?`)) {
          cat.docs = cat.docs.filter((d) => d.id !== docId);
          saveDownloadData(downloadCategories);
          renderCategoryDocs();
        }
      }
      return;
    }
  });
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

initDownloadsManager();

