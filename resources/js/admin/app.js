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

    toolbar.querySelectorAll('[data-format]').forEach((btn) => {
      btn.addEventListener('mousedown', (e) => {
        e.preventDefault(); // Prevents input from losing focus / selection
      });
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        applyMarkdownFormat(inputOrTextarea, btn.dataset.format);
      });
    });

    inputOrTextarea.addEventListener('keydown', (e) => {
      if ((e.ctrlKey || e.metaKey) && (e.key === 'b' || e.key === 'B')) {
        e.preventDefault();
        applyMarkdownFormat(inputOrTextarea, 'bold');
      } else if ((e.ctrlKey || e.metaKey) && (e.key === 'i' || e.key === 'I')) {
        e.preventDefault();
        applyMarkdownFormat(inputOrTextarea, 'italic');
      } else if ((e.ctrlKey || e.metaKey) && (e.key === 'u' || e.key === 'U')) {
        e.preventDefault();
        applyMarkdownFormat(inputOrTextarea, 'underline');
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
    window.setTimeout(updateActivityEditorUI, 0);
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
  if (!['#news-section', '#activities-section', '#conferences-section'].includes(currentHash)) {
    currentHash = '#news-section';
  }
  navLinks.forEach((link) => {
    const isActive = link.getAttribute('href') === currentHash;
    link.classList.toggle('active', isActive);
  });

  const sections = ['news-section', 'activities-section', 'conferences-section'];
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

newsForm?.addEventListener('reset', () => {
  window.setTimeout(() => {
    document.querySelector('[data-upload-zone="news"]')?._clearImage?.();
  }, 0);
});
activityForm?.addEventListener('reset', () => {
  window.setTimeout(() => {
    document.querySelector('[data-upload-zone="activity"]')?._clearImage?.();
  }, 0);
});
