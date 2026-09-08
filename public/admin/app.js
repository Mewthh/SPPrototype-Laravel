function escapeHtml(str) {
  if (!str) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

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

const conferenceForm = document.querySelector('[data-conference-form]');
const conferenceViews = {
  editor: document.querySelector('[data-conference-view="editor"]'),
  list: document.querySelector('[data-conference-view="list"]'),
};
const conferenceList = document.querySelector('[data-conference-list]');
const conferenceBanner = document.querySelector('[data-conference-banner]');
const conferenceBannerText = document.querySelector('[data-conference-banner-text]');
const conferenceCancelEdit = document.querySelector('[data-conference-cancel-edit]');
const conferenceSubmitPrimary = document.querySelector('[data-conference-submit-primary]');
const conferenceSubmitSecondary = document.querySelector('[data-conference-submit-secondary]');
const conferenceCountBadges = document.querySelectorAll('[data-conference-count-badge]');

const localStorageKey = 'spp-admin-posts-v3';
const conferenceStorageKey = 'spp-admin-conferences-v1';
const themeKey = 'spp-theme';
const PAGE_SIZE = 3;

const imageState = {
  news: null,
  activity: null,
  conference: null,
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

const defaultConferences = [
  {
    id: 'conf-2024',
    year: '2024',
    title: '42nd SPP Physics Conference (SPP 2024)',
    theme: 'Physics without Borders: Igniting Innovation and Transforming Communities',
    location: 'Bohol Tropics Resort, Tagbilaran City, Bohol',
    dates: 'October 18–21, 2024',
    status: 'archived',
    summary: 'The 42nd National Physics Conference featured research breakthroughs in condensed matter, photonics, and physics education.',
    body: '## 42nd SPP Physics Conference Overview\n\nThe 42nd SPP Physics Conference was held in Bohol, bringing together physicists, researchers, and students from across the Philippines and international institutions.',
    coverImage: null,
  },
  {
    id: 'conf-2025',
    year: '2025',
    title: '43rd SPP Physics Conference (SPP 2025)',
    theme: 'Advancing Frontiers in Physics for Sustainable Development',
    location: 'Baguio Convention Center, Baguio City, Benguet',
    dates: 'October 16–19, 2025',
    status: 'published',
    summary: 'The 43rd National Physics Conference showcased cutting-edge quantum optics, materials science, and computational physics.',
    body: '## 43rd SPP Physics Conference Overview\n\nThe 43rd SPP Physics Conference convened in the summer capital, featuring plenary sessions, poster presentations, and specialized workshops.',
    coverImage: null,
  },
  {
    id: 'conf-2026',
    year: '2026',
    title: '44th SPP Physics Conference (SPP 2026)',
    theme: 'Frontiers in Physics, Quantum Information, and AI-Driven Sciences',
    location: 'Ateneo de Manila University, Quezon City, Metro Manila',
    dates: 'October 15–18, 2026',
    status: 'published',
    summary: 'The 44th SPP National Physics Conference is our flagship annual gathering of leading physicists, researchers, educators, and innovators.',
    body: '## Welcome to SPP 2026\n\nJoin the Samahang Pisika ng Pilipinas for the 44th SPP Physics Conference. Featuring international keynote speakers, parallel scientific sessions, and interactive panel discussions.',
    coverImage: null,
  },
  {
    id: 'conf-2027',
    year: '2027',
    title: '45th SPP Physics Conference (SPP 2027)',
    theme: 'Next-Generation Physics: Empowering Emerging Technologies',
    location: 'Cebu City, Philippines',
    dates: 'October 2027',
    status: 'draft',
    summary: 'Planning and preparations for the 45th National Physics Conference.',
    body: '## 45th SPP Physics Conference Planning\n\nCall for papers, workshop proposals, and registration timelines will be announced soon.',
    coverImage: null,
  },
];

const state = {
  posts: loadPosts(),
  conferences: loadConferences(),
  newsFilter: 'all',
  activityFilter: 'all',
  conferenceFilter: 'all',
  newsVisibleCount: PAGE_SIZE,
  activityVisibleCount: PAGE_SIZE,
  editingNewsId: null,
  editingActivityId: null,
  editingConferenceId: null,
};

function loadPosts() {
  return [];
}

function savePosts() {
  // Database persists changes; bypass localStorage write
}

function loadConferences() {
  return [];
}

function saveConferences() {
  // Database persists changes; bypass localStorage write
}

const loadingScreenEl = document.getElementById('admin-loading-screen');
const loadingScreenText = document.getElementById('admin-loading-text');

function showAdminLoadingScreen(statusText = 'Loading workspace & retrieving database items...') {
  console.log('[SPP Admin Loader Debug] showAdminLoadingScreen requested with status:', statusText);
  if (!loadingScreenEl) {
    console.warn('[SPP Admin Loader Debug] #admin-loading-screen element not found.');
    return;
  }
  if (loadingScreenText && statusText) {
    loadingScreenText.textContent = statusText;
  }
  loadingScreenEl.classList.remove('is-hidden', 'fade-out');
  console.log('[SPP Admin Loader Debug] #admin-loading-screen is now visible.');
}

function hideAdminLoadingScreen(trigger = 'unspecified') {
  console.log(`[SPP Admin Loader Debug] hideAdminLoadingScreen called. Trigger: "${trigger}"`);
  if (!loadingScreenEl) return;
  loadingScreenEl.classList.add('fade-out');
  setTimeout(() => {
    loadingScreenEl.classList.add('is-hidden');
    console.log('[SPP Admin Loader Debug] #admin-loading-screen is now hidden.');
  }, 450);
}

window.showAdminLoadingScreen = showAdminLoadingScreen;
window.hideAdminLoadingScreen = hideAdminLoadingScreen;

let pendingInitialDatabaseRequests = 2;
let initialLoadDismissed = false;

function notifyDatabaseFetchComplete(source = 'unknown') {
  pendingInitialDatabaseRequests--;
  console.log(`[SPP Admin Loader Debug] notifyDatabaseFetchComplete from "${source}". Remaining pending requests:`, pendingInitialDatabaseRequests);
  if (pendingInitialDatabaseRequests <= 0 && !initialLoadDismissed) {
    initialLoadDismissed = true;
    hideAdminLoadingScreen('all database requests completed');
  }
}

setTimeout(() => {
  if (!initialLoadDismissed) {
    initialLoadDismissed = true;
    console.log('[SPP Admin Loader Debug] 3000ms safety timeout reached, dismissing admin loader.');
    hideAdminLoadingScreen('timeout 3000ms');
  }
}, 3000);

function setTheme(theme) {
  const nextTheme = theme === 'dark' ? 'dark' : 'light';
  document.documentElement.setAttribute('data-theme', nextTheme);
  if (nextTheme === 'dark') {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }

  const toggles = document.querySelectorAll('[data-theme-toggle]');
  toggles.forEach((t) => {
    t.setAttribute('aria-label', nextTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
    t.title = nextTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode';
  });

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
  const isAct = (p) => p.type === 'event' || p.type === 'activity' || p.section === 'Activity';
  const activityCount = state.posts.filter(isAct).length;

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
  const actPublished = state.posts.filter((p) => isAct(p) && p.status === 'published').length;
  const actScheduled = state.posts.filter((p) => isAct(p) && p.status === 'scheduled').length;
  const actDraft = state.posts.filter((p) => isAct(p) && p.status === 'draft').length;
  const actArchived = state.posts.filter((p) => isAct(p) && p.status === 'archived').length;

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

  const actItems = state.posts.filter((p) => p.type === 'event' || p.type === 'activity' || p.section === 'Activity');
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
  renderConferences();
  updateNewsEditorUI();
  updateActivityEditorUI();
  updateConferenceEditorUI();
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

function handleEditorImageUpload(textarea, visualEditor = null) {
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

    const alt = file.name.replace(/\.[^/.]+$/, '');
    const isVisual = visualEditor && visualEditor.style.display !== 'none';

    // Disable the image button for the duration of the upload
    const wrap = (textarea.closest('[data-rich-editor]') || visualEditor?.closest('[data-rich-editor]'));
    const imgBtn = wrap?.querySelector('[data-format="image"]');
    if (imgBtn) { imgBtn.disabled = true; imgBtn.classList.add('is-loading'); }

    // In visual mode: insert a spinner placeholder immediately at the cursor
    let placeholderId = null;
    if (isVisual) {
      visualEditor.focus();
      placeholderId = `img-ph-${Date.now()}-${Math.random().toString(36).slice(2, 7)}`;
      const placeholderHtml = `<span class="rich-editor-img-placeholder" id="${placeholderId}" contenteditable="false"><span class="rich-editor-img-spinner" aria-hidden="true"></span>Uploading image…</span>`;
      document.execCommand('insertHTML', false, placeholderHtml);
    }

    try {
      const data = await uploadMediaAsset(file);
      const markdownSnippet = `![${alt}](${data.url})`;

      if (isVisual) {
        // Swap the placeholder out for the real image wrap
        const placeholder = document.getElementById(placeholderId);
        if (placeholder) {
          const safeAlt = alt.replace(/"/g, '&quot;');
          const imgWrap = document.createElement('span');
          imgWrap.className = 'rich-editor-img-wrap';
          imgWrap.setAttribute('contenteditable', 'false');
          imgWrap.innerHTML = `<img src="${data.url}" alt="${safeAlt}"><button class="rich-editor-img-remove" type="button" title="Remove image" aria-label="Remove image">&#x2715;</button>`;
          placeholder.replaceWith(imgWrap);
        }
        visualEditor.dispatchEvent(new Event('input', { bubbles: true }));
      } else {
        const start = textarea.selectionStart ?? textarea.value.length;
        const end = textarea.selectionEnd ?? textarea.value.length;
        const val = textarea.value || '';
        textarea.value = val.substring(0, start) + markdownSnippet + val.substring(end);
        textarea.dispatchEvent(new Event('input', { bubbles: true }));
      }
    } catch (err) {
      // Remove placeholder on failure so the editor stays clean
      if (isVisual && placeholderId) {
        document.getElementById(placeholderId)?.remove();
      }
      alert('Failed to upload image: ' + err.message);
    } finally {
      if (imgBtn) { imgBtn.disabled = false; imgBtn.classList.remove('is-loading'); }
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
    // Check if multi-line → fenced code block, else inline backtick
    if (selected.includes('\n')) {
      const fence = '\n```\n';
      const text = selected || 'code here';
      const wrapped = fence + text + fence;
      el.value = val.substring(0, start) + wrapped + val.substring(end);
      el.setSelectionRange(start + 5, start + 5 + text.length);
    } else {
      wrapInline('`', '`', 'code');
    }
    el.dispatchEvent(new Event('input', { bubbles: true }));
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
    showLinkModal(selected || '', '').then((result) => {
      if (!result) return;
      const { text, url } = result;
      const snippet = `[${text}](${url})`;
      const freshVal = el.value;
      const freshStart = el.selectionStart ?? start;
      const freshEnd = el.selectionEnd ?? end;
      el.value = freshVal.substring(0, freshStart) + snippet + freshVal.substring(freshEnd);
      el.setSelectionRange(freshStart, freshStart + snippet.length);
      el.dispatchEvent(new Event('input', { bubbles: true }));
      el.focus();
    });
    return;
  } else if (format === 'image') {
    handleEditorImageUpload(el);
    return;
  } else if (format === 'table') {
    showTableModal().then((dims) => {
      if (!dims) return;
      const { rows, cols } = dims;
      const headerCells = Array.from({ length: cols }, (_, i) => ` Header ${i + 1} `).join('|');
      const separators = Array.from({ length: cols }, () => ' --- ').join('|');
      const dataRow = Array.from({ length: cols }, (_, i) => ` Cell ${i + 1} `).join('|');
      let snippet = `\n|${headerCells}|\n|${separators}|`;
      for (let r = 0; r < rows; r++) {
        const rowCells = Array.from({ length: cols }, (_, i) => ` Cell ${r * cols + i + 1} `).join('|');
        snippet += `\n|${rowCells}|`;
      }
      snippet += '\n';
      const freshVal = el.value;
      const freshStart = el.selectionStart;
      const freshEnd = el.selectionEnd;
      el.value = freshVal.substring(0, freshStart) + snippet + freshVal.substring(freshEnd);
      el.setSelectionRange(freshStart + 3, freshStart + 3 + `Header 1`.length);
      el.dispatchEvent(new Event('input', { bubbles: true }));
      el.focus();
    });
    return; // modal is async, don't fall through
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

/* ─── Table Grid Picker ─────────────────────────────────────────────────── */
function showTableGridPicker(anchorBtn, onSelect) {
  const MAX = 8;

  // Remove any existing picker
  document.getElementById('spp-table-picker')?.remove();

  const picker = document.createElement('div');
  picker.id = 'spp-table-picker';
  picker.setAttribute('role', 'dialog');
  picker.setAttribute('aria-label', 'Choose table size');
  Object.assign(picker.style, {
    position: 'fixed',
    zIndex: '9999',
    background: 'var(--surface, #ffffff)',
    border: '1px solid var(--border, #e2e8f0)',
    borderRadius: '10px',
    boxShadow: '0 8px 32px rgba(0,0,0,0.18)',
    padding: '14px',
    userSelect: 'none',
  });

  const label = document.createElement('div');
  label.textContent = 'Insert Table';
  Object.assign(label.style, {
    fontSize: '0.78rem',
    fontWeight: '600',
    color: 'var(--text-muted, #64748b)',
    marginBottom: '10px',
    textAlign: 'center',
    letterSpacing: '0.04em',
    textTransform: 'uppercase',
  });
  picker.appendChild(label);

  const grid = document.createElement('div');
  Object.assign(grid.style, {
    display: 'grid',
    gridTemplateColumns: `repeat(${MAX}, 22px)`,
    gap: '3px',
  });
  picker.appendChild(grid);

  let hoverRow = 0;
  let hoverCol = 0;
  const cells = [];

  function updateHighlight(r, c) {
    hoverRow = r;
    hoverCol = c;
    cells.forEach((cell, idx) => {
      const cr = Math.floor(idx / MAX) + 1;
      const cc = (idx % MAX) + 1;
      const active = cr <= r && cc <= c;
      cell.style.background = active
        ? 'var(--accent-strong, #3b82f6)'
        : 'var(--surface-strong, #f1f5f9)';
      cell.style.borderColor = active
        ? 'var(--accent-strong, #3b82f6)'
        : 'var(--border, #e2e8f0)';
    });
    label.textContent = (r && c) ? `${r} × ${c} Table` : 'Insert Table';
  }

  for (let r = 1; r <= MAX; r++) {
    for (let c = 1; c <= MAX; c++) {
      const cell = document.createElement('div');
      Object.assign(cell.style, {
        width: '22px',
        height: '22px',
        border: '1px solid var(--border, #e2e8f0)',
        borderRadius: '3px',
        background: 'var(--surface-strong, #f1f5f9)',
        cursor: 'pointer',
        transition: 'background 0.1s, border-color 0.1s',
      });
      cell.addEventListener('mouseenter', () => updateHighlight(r, c));
      cell.addEventListener('click', (e) => {
        e.stopPropagation();
        picker.remove();
        document.removeEventListener('mousedown', outsideHandler, true);
        onSelect(r, c);
      });
      grid.appendChild(cell);
      cells.push(cell);
    }
  }

  // Position below the anchor button
  document.body.appendChild(picker);
  const rect = anchorBtn.getBoundingClientRect();
  const pickerRect = picker.getBoundingClientRect();
  let top = rect.bottom + 6;
  let left = rect.left;
  if (left + pickerRect.width > window.innerWidth - 8) {
    left = window.innerWidth - pickerRect.width - 8;
  }
  if (top + pickerRect.height > window.innerHeight - 8) {
    top = rect.top - pickerRect.height - 6;
  }
  picker.style.top = top + 'px';
  picker.style.left = left + 'px';

  // Close on outside click
  function outsideHandler(e) {
    if (!picker.contains(e.target)) {
      picker.remove();
      document.removeEventListener('mousedown', outsideHandler, true);
    }
  }
  setTimeout(() => document.addEventListener('mousedown', outsideHandler, true), 0);

  // Default highlight 3×3
  updateHighlight(3, 3);
}

function setupRichEditorToolbars() {
  document.querySelectorAll('[data-rich-editor]').forEach((wrap) => {
    const textarea = wrap.querySelector('textarea');
    const toolbar = wrap.querySelector('.editor-toolbar');
    if (!textarea || !toolbar || wrap._richEditorAttached) return;
    wrap._richEditorAttached = true;

    // Create visual contenteditable element
    const visualEditor = document.createElement('div');
    visualEditor.className = 'rich-editor-visual';
    visualEditor.contentEditable = 'true';
    visualEditor.setAttribute('role', 'textbox');
    visualEditor.setAttribute('aria-multiline', 'true');
    visualEditor.setAttribute('placeholder', textarea.placeholder || 'Type here...');

    let isSyncing = false;

    // Function to convert raw markdown/HTML into visual editor HTML
    const syncToVisual = (force = false) => {
      if (isSyncing) return;
      if (!force && document.activeElement === visualEditor) return;
      isSyncing = true;
      try {
        let raw = textarea.value || '';
        // Convert markdown images and links BEFORE HTML-escaping so URLs stay intact.
        // Store placeholders to survive the escaping pass, then restore them as real HTML.
        const insertions = [];
        let prep = raw
          // ![alt](url) → placeholder (wrapped with remove button)
          .replace(/!\[([^\]]*)\]\(([^)\s]+)\)/g, (_, alt, src) => {
            const i = insertions.length;
            const safeAlt = alt.replace(/"/g,'&quot;');
            const safeSrc = src.replace(/"/g,'&quot;');
            insertions.push(`<span class="rich-editor-img-wrap" contenteditable="false"><img src="${safeSrc}" alt="${safeAlt}"><button class="rich-editor-img-remove" type="button" title="Remove image" aria-label="Remove image">&#x2715;</button></span>`);
            return `\x00img${i}\x00`;
          })
          // [text](url) → placeholder
          .replace(/\[([^\]]+)\]\(([^)\s]+)\)/g, (_, text, href) => {
            const i = insertions.length;
            insertions.push(`<a href="${href.replace(/"/g,'&quot;')}" target="_blank" rel="noopener noreferrer" style="color:var(--accent-strong,#3b82f6);text-decoration:underline;">${text}</a>`);
            return `\x00a${i}\x00`;
          });
        // Now HTML-escape the remaining text safely
        let html = prep
          .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
          // Restore image/link placeholders as real HTML
          .replace(/\x00(img|a)(\d+)\x00/g, (_, _tag, idx) => insertions[+idx] || '')
          .replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>')
          .replace(/_([^_]+)_/g, '<em>$1</em>')
          .replace(/\*([^*]+)\*/g, '<em>$1</em>')
          // <u>text</u> — after escaping becomes &lt;u&gt;text&lt;/u&gt;
          .replace(/&lt;u&gt;([^&]+(?:&(?!lt;\/u&gt;)[^&]*)*?)&lt;\/u&gt;/gi, '<u>$1</u>')
          .replace(/==([^=]+)==/g, '<mark>$1</mark>')
          .replace(/~([^~]+)~/g, '<sub>$1</sub>')
          .replace(/\^([^^]+)\^/g, '<sup>$1</sup>')
          .replace(/`([^`]+)`/g, '<code>$1</code>')
          .replace(/^# (.*$)/gim, '<h1>$1</h1>')
          .replace(/^## (.*$)/gim, '<h2>$2</h2>')
          .replace(/\n/g, '<br>');
        visualEditor.innerHTML = html;
      } finally {
        isSyncing = false;
      }
    };

    // Function to sync visual content back to textarea value
    const syncToTextarea = () => {
      if (isSyncing) return;
      isSyncing = true;
      try {
        // Convert an HTML table element to GFM markdown table
        function tableToMarkdown(table) {
          const rows = Array.from(table.querySelectorAll('tr'));
          if (!rows.length) return '';
          const allCells = rows.map((row) =>
            Array.from(row.querySelectorAll('th, td')).map((cell) => cell.innerText.trim().replace(/\|/g, '\\|'))
          );
          const header = allCells[0] || [];
          const body = allCells.slice(1);
          const sep = header.map(() => '---');
          const toRow = (cells) => `| ${cells.join(' | ')} |`;
          return '\n' + [toRow(header), toRow(sep), ...body.map(toRow)].join('\n') + '\n';
        }

        const clone = visualEditor.cloneNode(true);

        clone.querySelectorAll('table').forEach((tbl) => {
          const idx = Array.from(visualEditor.querySelectorAll('table'))
            .findIndex((t) => t.isEqualNode(tbl));
          const liveTable = visualEditor.querySelectorAll('table')[idx] || tbl;
          const md = tableToMarkdown(liveTable);
          const placeholder = document.createTextNode(md);
          tbl.parentNode.replaceChild(placeholder, tbl);
        });

        let html = clone.innerHTML;
        // Strip upload placeholders entirely so they never bleed into saved markdown
        html = html.replace(/<span[^>]*class="[^"]*rich-editor-img-placeholder[^"]*"[^>]*>[\s\S]*?<\/span>/gi, '');
        let raw = html
          .replace(/<div><br><\/div>/gi, '\n')
          .replace(/<div>/gi, '\n').replace(/<\/div>/gi, '')
          .replace(/<br\s*[\/]?>/gi, '\n')
          .replace(/<strong>(.*?)<\/strong>/gi, '**$1**')
          .replace(/<b>(.*?)<\/b>/gi, '**$1**')
          .replace(/<em>(.*?)<\/em>/gi, '*$1*')
          .replace(/<i>(.*?)<\/i>/gi, '*$1*')
          .replace(/<u>(.*?)<\/u>/gi, '<u>$1</u>')
          .replace(/<mark[^>]*>(.*?)<\/mark>/gi, '==$1==')
          .replace(/<sub>(.*?)<\/sub>/gi, '~$1~')
          .replace(/<sup class="footnote-ref">\[(\d+)\]<\/sup>/gi, '[^$1]')
          .replace(/<sup>(.*?)<\/sup>/gi, '^$1^')
          .replace(/<code>(.*?)<\/code>/gi, '`$1`')
          .replace(/<h1[^>]*>(.*?)<\/h1>/gi, '\n# $1\n')
          .replace(/<h2[^>]*>(.*?)<\/h2>/gi, '\n## $1\n')
          .replace(/<h3[^>]*>(.*?)<\/h3>/gi, '\n### $1\n')
          .replace(/<blockquote[^>]*>([\s\S]*?)<\/blockquote>/gi, (_, inner) => '\n> ' + inner.trim() + '\n')
          .replace(/<li[^>]*>(.*?)<\/li>/gi, '\n- $1')
          .replace(/<\/?(ul|ol|p)[^>]*>/gi, '\n')
          .replace(/<img\b[^>]*>/gi, (match) => {
            const srcM = match.match(/src="([^"]*)"/i);
            const altM = match.match(/alt="([^"]*)"/i);
            const src = srcM ? srcM[1] : '';
            const alt = altM ? altM[1] : '';
            return `![${alt}](${src})`;
          })
          // Strip remove-button content before generic tag stripping (avoids ✕ leaking into markdown)
          .replace(/<button[^>]*class="[^"]*rich-editor-img-remove[^"]*"[^>]*>[\s\S]*?<\/button>/gi, '')
          .replace(/<a[^>]*href="([^"]*)"[^>]*>(.*?)<\/a>/gi, '[$2]($1)')
          .replace(/<[^>]+>/g, '')
          .replace(/&nbsp;/gi, ' ')
          .replace(/&amp;/gi, '&')
          .replace(/&lt;/gi, '<')
          .replace(/&gt;/gi, '>')
          .replace(/\n{3,}/g, '\n\n')
          .trim();
        textarea.value = raw;
        textarea.dispatchEvent(new Event('input', { bubbles: true }));
      } finally {
        isSyncing = false;
      }
    };


    // Helper to check selection hierarchy
    const getSelectionNode = () => {
      const sel = window.getSelection();
      if (!sel || !sel.rangeCount) return null;
      let node = sel.anchorNode;
      return node ? (node.nodeType === 3 ? node.parentNode : node) : null;
    };

    let isHighlightPending = false;

    const getHighlightParentNode = () => {
      let node = getSelectionNode();
      while (node && node !== visualEditor) {
        const name = node.nodeName.toLowerCase();
        if (name === 'mark') return node;
        if (name === 'span' && node.style && node.style.backgroundColor) {
          const bg = node.style.backgroundColor.toLowerCase();
          if (bg !== 'transparent' && bg !== 'rgba(0, 0, 0, 0)' && (bg.includes('254') || bg.includes('240') || bg.includes('138') || bg.includes('yellow') || bg.includes('fef08a'))) {
            return node;
          }
        }
        node = node.parentNode;
      }
      return null;
    };

    const isInsideTag = (tagName) => {
      if (tagName === 'highlight' || tagName === 'mark') {
        return Boolean(getHighlightParentNode()) || isHighlightPending;
      }
      let node = getSelectionNode();
      while (node && node !== visualEditor) {
        const name = node.nodeName.toLowerCase();
        if (name === tagName.toLowerCase()) return true;
        node = node.parentNode;
      }
      return false;
    };

    // Update active indicators on format buttons based on selection state
    const updateFormatIndicators = () => {
      const markNode = getHighlightParentNode();
      if (!markNode && isHighlightPending && !document.queryCommandState('hiliteColor')) {
        // If selection moved out of pending highlight position, clear pending
      }

      toolbar.querySelectorAll('[data-format]').forEach((btn) => {
        const fmt = btn.dataset.format;
        let isActive = false;

        try {
          if (fmt === 'bold') isActive = document.queryCommandState('bold') || isInsideTag('strong') || isInsideTag('b');
          else if (fmt === 'italic') isActive = document.queryCommandState('italic') || isInsideTag('em') || isInsideTag('i');
          else if (fmt === 'underline') isActive = document.queryCommandState('underline') || isInsideTag('u');
          else if (fmt === 'ul') isActive = document.queryCommandState('insertUnorderedList') || isInsideTag('ul');
          else if (fmt === 'ol') isActive = document.queryCommandState('insertOrderedList') || isInsideTag('ol');
          else if (fmt === 'sub') isActive = document.queryCommandState('subscript') || isInsideTag('sub');
          else if (fmt === 'sup') isActive = document.queryCommandState('superscript') || isInsideTag('sup');
          else if (fmt === 'h1') isActive = isInsideTag('h1');
          else if (fmt === 'h2') isActive = isInsideTag('h2');
          else if (fmt === 'blockquote') isActive = isInsideTag('blockquote');
          else if (fmt === 'code') isActive = isInsideTag('code') || isInsideTag('pre');
          else if (fmt === 'highlight') isActive = Boolean(markNode) || isHighlightPending;
        } catch (e) {
          isActive = false;
        }

        btn.classList.toggle('active', Boolean(isActive));
      });
    };

    // Initial sync & hide raw textarea
    syncToVisual();
    textarea.style.display = 'none';
    wrap.appendChild(visualEditor);
    wrap._syncToVisual = (force = true) => syncToVisual(force);
    textarea._syncToVisual = (force = true) => syncToVisual(force);

    // Listen for input and selection changes
    visualEditor.addEventListener('input', () => {
      syncToTextarea();
      updateFormatIndicators();
    });

    // Remove-image button (delegated — images are wrapped in .rich-editor-img-wrap)
    visualEditor.addEventListener('click', (e) => {
      if (e.target.closest('.rich-editor-img-remove')) {
        const wrapper = e.target.closest('.rich-editor-img-wrap');
        if (wrapper) {
          wrapper.remove();
          syncToTextarea();
        }
      }
    });

    ['keyup', 'mouseup', 'focus', 'click'].forEach((evt) => {
      visualEditor.addEventListener(evt, updateFormatIndicators);
    });

    textarea.addEventListener('change', syncToVisual);
    textarea.addEventListener('input', syncToVisual);

    if (textarea.form) {
      textarea.form.addEventListener('reset', () => {
        window.setTimeout(() => {
          syncToVisual();
        }, 0);
      });
    }

    // Toolbar formatting actions
    toolbar.querySelectorAll('[data-format]').forEach((btn) => {
      btn.addEventListener('mousedown', (e) => {
        e.preventDefault();
      });

      btn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        const format = btn.dataset.format;
        visualEditor.focus();

        switch (format) {
          case 'bold':
            document.execCommand('bold', false, null);
            break;
          case 'italic':
            document.execCommand('italic', false, null);
            break;
          case 'underline':
            document.execCommand('underline', false, null);
            break;
          case 'h1':
            document.execCommand('formatBlock', false, isInsideTag('h1') ? '<p>' : '<h1>');
            break;
          case 'h2':
            document.execCommand('formatBlock', false, isInsideTag('h2') ? '<p>' : '<h2>');
            break;
          case 'ul':
            document.execCommand('insertUnorderedList', false, null);
            break;
          case 'ol':
            document.execCommand('insertOrderedList', false, null);
            break;
          case 'blockquote':
            document.execCommand('formatBlock', false, isInsideTag('blockquote') ? '<p>' : '<blockquote>');
            break;
          case 'code':
            document.execCommand('formatBlock', false, isInsideTag('pre') || isInsideTag('code') ? '<p>' : '<pre>');
            break;
          case 'sub':
            document.execCommand('subscript', false, null);
            break;
          case 'sup':
            document.execCommand('superscript', false, null);
            break;
          case 'hr':
            document.execCommand('insertHorizontalRule', false, null);
            break;
          case 'highlight':
            const markNode = getHighlightParentNode();
            if (markNode || isHighlightPending) {
              if (markNode) {
                const parent = markNode.parentNode;
                while (markNode.firstChild) {
                  parent.insertBefore(markNode.firstChild, markNode);
                }
                parent.removeChild(markNode);
              }
              isHighlightPending = false;
              document.execCommand('hiliteColor', false, 'transparent');
              document.execCommand('backColor', false, 'transparent');
            } else {
              isHighlightPending = true;
              const sel = window.getSelection();
              if (sel && sel.rangeCount && !sel.isCollapsed) {
                const range = sel.getRangeAt(0);
                const mark = document.createElement('mark');
                mark.style.backgroundColor = '#fef08a';
                mark.style.color = '#1e293b';
                mark.style.padding = '2px 4px';
                mark.style.borderRadius = '2px';
                try {
                  range.surroundContents(mark);
                } catch (err) {
                  document.execCommand('hiliteColor', false, '#fef08a');
                }
              } else {
                document.execCommand('hiliteColor', false, '#fef08a');
              }
            }
            break;
          case 'table': {
            // Show a grid picker anchored to this button; insert on selection
            const savedRange = (window.getSelection() && window.getSelection().rangeCount)
              ? window.getSelection().getRangeAt(0).cloneRange()
              : null;
            showTableGridPicker(btn, (rows, cols) => {
              // Restore caret position before inserting
              if (savedRange) {
                const sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(savedRange);
              }
              visualEditor.focus();

              const thCells = Array.from({ length: cols }, (_, i) =>
                `<th style="border:1px solid var(--border,#cbd5e1);padding:6px 12px;background:var(--surface-strong,#f1f5f9);font-weight:600;">Header ${i + 1}</th>`
              ).join('');
              const tdCells = (r) => Array.from({ length: cols }, (_, i) =>
                `<td style="border:1px solid var(--border,#cbd5e1);padding:6px 12px;">Cell ${r * cols + i + 1}</td>`
              ).join('');
              const bodyRows = Array.from({ length: rows }, (_, r) =>
                `<tr>${tdCells(r)}</tr>`
              ).join('');

              const tableHtml =
                `<table class="rich-editor-table" style="border-collapse:collapse;width:100%;margin:8px 0;">` +
                  `<thead><tr>${thCells}</tr></thead>` +
                  `<tbody>${bodyRows}</tbody>` +
                `</table><p><br></p>`;

              document.execCommand('insertHTML', false, tableHtml);
              syncToTextarea();
              updateFormatIndicators();
            });
            return; // picker is async — skip the syncToTextarea below
          }
          case 'link': {
            const sel = window.getSelection();
            const selectedText = (sel && !sel.isCollapsed) ? sel.toString() : '';
            // Save caret/selection before the modal opens (it loses focus)
            const savedRange = (sel && sel.rangeCount) ? sel.getRangeAt(0).cloneRange() : null;
            showLinkModal(selectedText, '').then((result) => {
              if (!result) return;
              const { text, url } = result;
              visualEditor.focus();
              if (savedRange) {
                const s = window.getSelection();
                s.removeAllRanges();
                s.addRange(savedRange);
              }
              const safeUrl = url.replace(/"/g, '&quot;');
              const safeText = text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
              const linkHtml = `<a href="${safeUrl}" target="_blank" rel="noopener noreferrer" style="color:var(--accent-strong,#3b82f6);text-decoration:underline;">${safeText}</a>`;
              document.execCommand('insertHTML', false, linkHtml);
              syncToTextarea();
              updateFormatIndicators();
            });
            return; // async modal — skip the syncToTextarea below
          }
          case 'image':
            handleEditorImageUpload(textarea, visualEditor);
            return; // async upload, skip the syncToTextarea below
          case 'footnote': {
            const existingFns = visualEditor.querySelectorAll('sup.footnote-ref');
            const nextFn = existingFns.length + 1;
            document.execCommand('insertHTML', false, `<sup class="footnote-ref">[${nextFn}]</sup>`);
            break;
          }
          default:
            applyMarkdownFormat(textarea, format);
            syncToVisual();
            break;
        }

        syncToTextarea();
        updateFormatIndicators();
      });
    });

    // Keyboard shortcuts
    visualEditor.addEventListener('keydown', (e) => {
      if (e.ctrlKey || e.metaKey) {
        const k = e.key.toLowerCase();
        if (k === 'b' || k === 'i' || k === 'u') {
          e.preventDefault();
          const cmd = k === 'b' ? 'bold' : k === 'i' ? 'italic' : 'underline';
          document.execCommand(cmd, false, null);
          syncToTextarea();
          updateFormatIndicators();
        }
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
}

function formatDraftTime(timestamp) {
  return '';
}

function checkNewsDraft(postId) {
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
  const post = state.posts.find((p) => String(p.id) === String(postId));
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

async function fetchNewsFromDatabase() {
  try {
    const res = await fetch('/admin/api/news', {
      headers: { 'Accept': 'application/json' },
    });
    if (!res.ok) return;
    const result = await res.json();
    const items = (result.data || []).map((item) => ({
      id: item.id,
      type: 'announcement',
      section: 'News',
      title: item.title,
      summary: item.excerpt || item.summary || '',
      publishDate: item.published_at ? String(item.published_at).substring(0, 10) : (item.created_at ? String(item.created_at).substring(0, 10) : ''),
      status: item.status || 'published',
      body: item.content || item.body || '',
      coverImage: item.image_url || item.image || item.coverImage || null,
      featured: Boolean(item.featured),
    }));
    state.posts = state.posts.filter((p) => p.section !== 'News').concat(items);
    renderAll();
  } catch (err) {
    console.error('Failed to fetch news from database:', err);
  }
}

async function fetchActivitiesFromDatabase() {
  try {
    const res = await fetch('/admin/api/activities', {
      headers: { 'Accept': 'application/json' },
    });
    if (!res.ok) return;
    const result = await res.json();
    const items = (result.data || []).map((item) => ({
      id: item.id,
      type: 'event',
      section: 'Activity',
      title: item.title,
      summary: item.excerpt || item.summary || '',
      publishDate: item.published_at ? String(item.published_at).substring(0, 10) : (item.created_at ? String(item.created_at).substring(0, 10) : ''),
      status: item.status || 'scheduled',
      body: item.content || item.body || '',
      coverImage: item.image_url || item.image || item.coverImage || null,
      featured: Boolean(item.featured),
    }));
    state.posts = state.posts.filter((p) => p.section !== 'Activity' && p.type !== 'event' && p.type !== 'activity').concat(items);
    renderAll();
  } catch (err) {
    console.error('Failed to fetch activities from database:', err);
  }
}

function setButtonLoading(button, isLoading, text = 'Saving...') {
  if (!button) return;
  if (isLoading) {
    button._origHtml = button.innerHTML;
    button.disabled = true;
    button.classList.add('is-loading');
    button.innerHTML = `<span class="btn-spinner" aria-hidden="true"></span>${text}`;
  } else {
    button.disabled = false;
    button.classList.remove('is-loading');
    if (button._origHtml) {
      button.innerHTML = button._origHtml;
      delete button._origHtml;
    }
  }
}

/* ─── Link Insertion Modal ──────────────────────────────────────────────── */
function showLinkModal(prefillText = '', prefillUrl = '') {
  return new Promise((resolve) => {
    let modal = document.getElementById('spp-link-modal');
    if (!modal) {
      modal = document.createElement('div');
      modal.id = 'spp-link-modal';
      modal.className = 'confirm-modal-overlay is-hidden';
      modal.setAttribute('role', 'dialog');
      modal.setAttribute('aria-modal', 'true');
      modal.setAttribute('aria-labelledby', 'link-modal-title');
      modal.innerHTML = `
        <div class="confirm-modal-card table-modal-card">
          <div class="confirm-modal-icon" style="background:rgba(59,130,246,0.12);color:#3b82f6;" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
          </div>
          <h3 class="confirm-modal-title" id="link-modal-title">Insert Link</h3>
          <p class="confirm-modal-message">Enter the link text and URL below.</p>
          <div style="display:flex;flex-direction:column;gap:12px;margin:0 0 20px;">
            <label style="display:flex;flex-direction:column;gap:5px;text-align:left;">
              <span style="font-size:0.8rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.05em;">Link Text</span>
              <input id="link-modal-text" type="text" placeholder="e.g. Click here" style="padding:8px 10px;border:1px solid var(--border);border-radius:var(--radius-sm);background:var(--surface-strong);color:var(--text);font-size:0.9rem;outline:none;" />
            </label>
            <label style="display:flex;flex-direction:column;gap:5px;text-align:left;">
              <span style="font-size:0.8rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.05em;">URL</span>
              <input id="link-modal-url" type="url" placeholder="https://example.com" style="padding:8px 10px;border:1px solid var(--border);border-radius:var(--radius-sm);background:var(--surface-strong);color:var(--text);font-size:0.9rem;outline:none;" />
            </label>
          </div>
          <div class="confirm-modal-actions">
            <button type="button" class="button button-quiet" id="link-modal-cancel">Cancel</button>
            <button type="button" class="button button-primary" id="link-modal-insert">Insert Link</button>
          </div>
        </div>
      `;
      document.body.appendChild(modal);
    }

    const textInput = modal.querySelector('#link-modal-text');
    const urlInput = modal.querySelector('#link-modal-url');
    const btnCancel = modal.querySelector('#link-modal-cancel');
    const btnInsert = modal.querySelector('#link-modal-insert');

    textInput.value = prefillText;
    urlInput.value = prefillUrl || 'https://';

    function close(result) {
      modal.classList.add('is-hidden');
      btnCancel.replaceWith(btnCancel.cloneNode(true));
      btnInsert.replaceWith(btnInsert.cloneNode(true));
      urlInput.removeEventListener('keydown', onKeydown);
      textInput.removeEventListener('keydown', onKeydown);
      resolve(result);
    }

    function submit() {
      const url = urlInput.value.trim();
      const text = textInput.value.trim() || url;
      if (!url || url === 'https://') { urlInput.focus(); return; }
      close({ text, url });
    }

    function onKeydown(e) {
      if (e.key === 'Enter') { e.preventDefault(); submit(); }
      if (e.key === 'Escape') { e.preventDefault(); close(null); }
    }

    modal.querySelector('#link-modal-cancel').addEventListener('click', () => close(null));
    modal.querySelector('#link-modal-insert').addEventListener('click', submit);
    textInput.addEventListener('keydown', onKeydown);
    urlInput.addEventListener('keydown', onKeydown);

    modal.classList.remove('is-hidden');
    // Focus appropriate field
    if (prefillText) { urlInput.focus(); urlInput.select(); }
    else { textInput.focus(); }
  });
}

function showTableModal() {
  return new Promise((resolve) => {
    let modal = document.getElementById('table-picker-modal');
    if (!modal) {
      modal = document.createElement('div');
      modal.id = 'table-picker-modal';
      modal.className = 'confirm-modal-overlay is-hidden';
      modal.setAttribute('role', 'dialog');
      modal.setAttribute('aria-modal', 'true');
      modal.setAttribute('aria-labelledby', 'table-modal-title');
      modal.innerHTML = `
        <div class="confirm-modal-card table-modal-card">
          <div class="confirm-modal-icon table-icon" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="3" y1="15" x2="21" y2="15"></line><line x1="9" y1="3" x2="9" y2="21"></line><line x1="15" y1="3" x2="15" y2="21"></line></svg>
          </div>
          <h3 class="confirm-modal-title" id="table-modal-title">Insert Table</h3>
          <p class="confirm-modal-message">Choose the number of columns and rows for your table.</p>
          <div class="table-modal-inputs">
            <label class="table-modal-field">
              <span>Columns</span>
              <div class="table-modal-stepper">
                <button type="button" class="table-step-btn" data-table-step="cols" data-dir="-1">−</button>
                <input type="number" id="table-modal-cols" class="table-modal-num" min="1" max="10" value="3" />
                <button type="button" class="table-step-btn" data-table-step="cols" data-dir="1">+</button>
              </div>
            </label>
            <label class="table-modal-field">
              <span>Rows</span>
              <div class="table-modal-stepper">
                <button type="button" class="table-step-btn" data-table-step="rows" data-dir="-1">−</button>
                <input type="number" id="table-modal-rows" class="table-modal-num" min="1" max="20" value="2" />
                <button type="button" class="table-step-btn" data-table-step="rows" data-dir="1">+</button>
              </div>
            </label>
          </div>
          <div class="table-modal-preview" id="table-modal-preview" aria-hidden="true"></div>
          <div class="confirm-modal-actions">
            <button type="button" class="button button-quiet" id="table-modal-cancel">Cancel</button>
            <button type="button" class="button button-primary" id="table-modal-insert">Insert Table</button>
          </div>
        </div>
      `;
      document.body.appendChild(modal);
    } else if (modal.parentElement !== document.body) {
      document.body.appendChild(modal);
    }

    const colsInput = modal.querySelector('#table-modal-cols');
    const rowsInput = modal.querySelector('#table-modal-rows');
    const preview = modal.querySelector('#table-modal-preview');
    const btnCancel = modal.querySelector('#table-modal-cancel');
    const btnInsert = modal.querySelector('#table-modal-insert');

    function clamp(val, min, max) { return Math.min(Math.max(Number(val) || min, min), max); }

    function renderPreview() {
      const cols = clamp(colsInput.value, 1, 10);
      const rows = clamp(rowsInput.value, 1, 20);
      let html = '<table class="table-preview-grid">';
      html += '<thead><tr>' + Array.from({ length: cols }, () => '<th></th>').join('') + '</tr></thead>';
      html += '<tbody>';
      for (let r = 0; r < rows; r++) {
        html += '<tr>' + Array.from({ length: cols }, () => '<td></td>').join('') + '</tr>';
      }
      html += '</tbody></table>';
      preview.innerHTML = html;
    }

    colsInput.value = 3;
    rowsInput.value = 2;
    renderPreview();

    modal.querySelectorAll('.table-step-btn').forEach((btn) => {
      btn.addEventListener('click', () => {
        const target = btn.dataset.tableStep === 'cols' ? colsInput : rowsInput;
        const dir = Number(btn.dataset.dir);
        const max = Number(target.max);
        const min = Number(target.min);
        target.value = clamp(Number(target.value) + dir, min, max);
        renderPreview();
      });
    });

    colsInput.addEventListener('input', renderPreview);
    rowsInput.addEventListener('input', renderPreview);

    const cleanup = (result) => {
      modal.classList.add('is-hidden');
      btnCancel.removeEventListener('click', onCancel);
      btnInsert.removeEventListener('click', onInsert);
      modal.removeEventListener('click', onBackdrop);
      resolve(result);
    };

    const onCancel = () => cleanup(null);
    const onInsert = () => {
      const cols = clamp(colsInput.value, 1, 10);
      const rows = clamp(rowsInput.value, 1, 20);
      cleanup({ cols, rows });
    };
    const onBackdrop = (e) => { if (e.target === modal) cleanup(null); };

    btnCancel.addEventListener('click', onCancel);
    btnInsert.addEventListener('click', onInsert);
    modal.addEventListener('click', onBackdrop);

    modal.classList.remove('is-hidden');
    colsInput.focus();
  });
}

function showConfirmModal(title = 'Confirm Deletion', message = 'Are you sure you want to delete this item? This action cannot be undone.', confirmText = 'Delete', confirmButtonClass = 'button-danger') {
  return new Promise((resolve) => {
    let modal = document.getElementById('custom-confirm-modal');
    if (!modal) {
      modal = document.createElement('div');
      modal.id = 'custom-confirm-modal';
      modal.className = 'confirm-modal-overlay is-hidden';
      modal.setAttribute('role', 'dialog');
      modal.setAttribute('aria-modal', 'true');
      modal.innerHTML = `
        <div class="confirm-modal-card">
          <div class="confirm-modal-icon warning" aria-hidden="true">&#x26A0;</div>
          <h3 class="confirm-modal-title" id="confirm-modal-title">Confirm Deletion</h3>
          <p class="confirm-modal-message" id="confirm-modal-message">Are you sure you want to delete this item?</p>
          <div class="confirm-modal-actions">
            <button type="button" class="button button-quiet" id="confirm-modal-cancel">Cancel</button>
            <button type="button" class="button button-danger" id="confirm-modal-proceed">Delete</button>
          </div>
        </div>
      `;
      document.body.appendChild(modal);
    } else if (modal.parentElement !== document.body) {
      document.body.appendChild(modal);
    }

    const titleEl = modal.querySelector('#confirm-modal-title');
    const messageEl = modal.querySelector('#confirm-modal-message');
    const btnCancel = modal.querySelector('#confirm-modal-cancel');
    const btnProceed = modal.querySelector('#confirm-modal-proceed');

    if (titleEl) titleEl.textContent = title;
    if (messageEl) messageEl.textContent = message;
    if (btnProceed) {
      btnProceed.textContent = confirmText;
      btnProceed.className = `button ${confirmButtonClass}`;
    }

    const cleanup = (result) => {
      modal.classList.add('is-hidden');
      btnCancel?.removeEventListener('click', onCancel);
      btnProceed?.removeEventListener('click', onProceed);
      modal.removeEventListener('click', onBackdrop);
      resolve(result);
    };

    const onCancel = () => cleanup(false);
    const onProceed = () => cleanup(true);
    const onBackdrop = (e) => {
      if (e.target === modal) cleanup(false);
    };

    btnCancel?.addEventListener('click', onCancel);
    btnProceed?.addEventListener('click', onProceed);
    modal.addEventListener('click', onBackdrop);

    modal.classList.remove('is-hidden');
  });
}

async function handleNewsSubmit(event) {
  event.preventDefault();
  if (!newsForm) return;

  const submitter = event.submitter;
  const overrideStatus = submitter?.dataset.statusOverride;
  const data = new FormData(newsForm);
  const title = String(data.get('title') || '').trim();
  if (!title) return;

  const chosenStatus = overrideStatus || String(data.get('status') || 'published');
  data.set('status', chosenStatus);

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  // If image preview has a data URL or image string that wasn't uploaded via input file
  if (imageState.news && !data.get('coverImage')?.name) {
    data.set('coverImage', imageState.news);
  }

  setButtonLoading(submitter, true, 'Saving...');

  try {
    let url = '/admin/api/news';
    if (state.editingNewsId) {
      url = `/admin/api/news/${state.editingNewsId}`;
      data.append('_method', 'PUT');
    }

    const res = await fetch(url, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken || '',
        'Accept': 'application/json',
      },
      body: data,
    });

    if (!res.ok) {
      const err = await res.json().catch(() => ({}));
      alert(err.message || 'Failed to save news post.');
      return;
    }

    const savedId = state.editingNewsId;
    state.editingNewsId = null;
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
    await fetchNewsFromDatabase();
    setNewsView('posts');
    showFloatingToast(savedId ? `News post "${title}" updated successfully.` : `News post "${title}" published successfully.`);
  } catch (err) {
    console.error('Error saving news:', err);
    alert('An error occurred while saving the news post.');
  } finally {
    setButtonLoading(submitter, false);
  }
}

async function handleNewsAction(event) {
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

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  if (action === 'delete') {
    const confirmed = await showConfirmModal('Delete News Post', 'Are you sure you want to delete this news post? This action cannot be undone.');
    if (!confirmed) return;

    setButtonLoading(target, true, 'Deleting...');
    item.classList.add('is-deleting');

    try {
      const res = await fetch(`/admin/api/news/${postId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': csrfToken || '',
          'Accept': 'application/json',
        },
      });

      if (res.ok || res.status === 404) {
        if (state.editingNewsId == postId) state.editingNewsId = null;
        state.posts = state.posts.filter((p) => String(p.id) !== String(postId));
        renderAll();
      } else {
        item.classList.remove('is-deleting');
        setButtonLoading(target, false);
        alert('Failed to delete news post.');
      }
    } catch (err) {
      console.error(err);
      item.classList.remove('is-deleting');
      setButtonLoading(target, false);
      alert('Error deleting news post.');
    }
    return;
  }

  if (action === 'publish' || action === 'archive' || action === 'draft') {
    const nextStatus = action === 'publish' ? 'published' : (action === 'archive' ? 'archived' : 'draft');
    const loadingText = action === 'archive' ? 'Archiving...' : (action === 'publish' ? 'Publishing...' : 'Updating...');
    setButtonLoading(target, true, loadingText);

    try {
      const res = await fetch(`/admin/api/news/${postId}/status`, {
        method: 'PATCH',
        headers: {
          'X-CSRF-TOKEN': csrfToken || '',
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify({ status: nextStatus }),
      });

      if (res.ok) {
        await fetchNewsFromDatabase();
      } else {
        alert('Failed to update news status.');
      }
    } catch (err) {
      console.error(err);
      alert('Error updating status.');
    } finally {
      setButtonLoading(target, false);
    }
  }
}

function startEditingActivity(postId) {
  const post = state.posts.find((p) => String(p.id) === String(postId));
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

async function handleActivitySubmit(event) {
  event.preventDefault();
  if (!activityForm) return;

  const submitter = event.submitter;
  const overrideStatus = submitter?.dataset.statusOverride;
  const data = new FormData(activityForm);
  const title = String(data.get('title') || '').trim();
  if (!title) return;

  const chosenStatus = overrideStatus || String(data.get('status') || 'scheduled');
  data.set('status', chosenStatus);

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  if (imageState.activity && !data.get('coverImage')?.name) {
    data.set('coverImage', imageState.activity);
  }

  setButtonLoading(submitter, true, 'Saving...');

  try {
    let url = '/admin/api/activities';
    if (state.editingActivityId) {
      url = `/admin/api/activities/${state.editingActivityId}`;
      data.append('_method', 'PUT');
    }

    const res = await fetch(url, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken || '',
        'Accept': 'application/json',
      },
      body: data,
    });

    if (!res.ok) {
      const err = await res.json().catch(() => ({}));
      alert(err.message || 'Failed to save activity.');
      return;
    }

    const savedActivityId = state.editingActivityId;
    state.editingActivityId = null;
    activityForm.reset();
    document.querySelector('[data-upload-zone="activity"]')?._clearImage?.();
    await fetchActivitiesFromDatabase();
    setActivityView('posts');
    showFloatingToast(savedActivityId ? `Activity "${title}" updated successfully.` : `Activity "${title}" published successfully.`);
  } catch (err) {
    console.error('Error saving activity:', err);
    alert('An error occurred while saving the activity.');
  } finally {
    setButtonLoading(submitter, false);
  }
}

async function handleActivityAction(event) {
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

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  if (action === 'delete') {
    const confirmed = await showConfirmModal('Delete Activity', 'Are you sure you want to delete this activity? This action cannot be undone.');
    if (!confirmed) return;

    setButtonLoading(target, true, 'Deleting...');
    item.classList.add('is-deleting');

    try {
      const res = await fetch(`/admin/api/activities/${postId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': csrfToken || '',
          'Accept': 'application/json',
        },
      });

      if (res.ok || res.status === 404) {
        if (state.editingActivityId == postId) state.editingActivityId = null;
        state.posts = state.posts.filter((p) => String(p.id) !== String(postId));
        renderAll();
      } else {
        item.classList.remove('is-deleting');
        setButtonLoading(target, false);
        alert('Failed to delete activity.');
      }
    } catch (err) {
      console.error(err);
      item.classList.remove('is-deleting');
      setButtonLoading(target, false);
      alert('Error deleting activity.');
    }
    return;
  }

  if (action === 'publish' || action === 'archive' || action === 'draft') {
    const nextStatus = action === 'publish' ? 'published' : (action === 'archive' ? 'archived' : 'draft');
    const loadingText = action === 'archive' ? 'Archiving...' : (action === 'publish' ? 'Publishing...' : 'Updating...');
    setButtonLoading(target, true, loadingText);

    try {
      const res = await fetch(`/admin/api/activities/${postId}/status`, {
        method: 'PATCH',
        headers: {
          'X-CSRF-TOKEN': csrfToken || '',
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify({ status: nextStatus }),
      });

      if (res.ok) {
        await fetchActivitiesFromDatabase();
      } else {
        alert('Failed to update activity status.');
      }
    } catch (err) {
      console.error(err);
      alert('Error updating status.');
    } finally {
      setButtonLoading(target, false);
    }
  }
}

// ─── Global Floating Center-Top Toast Notification ─────────────────────────
let _floatingToastTimer = null;
function showFloatingToast(message, title = 'Success') {
  const toast = document.getElementById('admin-floating-toast');
  const toastMsg = document.getElementById('admin-floating-toast-message');
  const toastTitle = toast?.querySelector('.floating-toast-title');
  if (!toast || !toastMsg) return;

  if (toastTitle) toastTitle.textContent = title;
  toastMsg.textContent = message;
  toast.classList.remove('is-hidden');

  if (_floatingToastTimer) window.clearTimeout(_floatingToastTimer);
  _floatingToastTimer = window.setTimeout(() => {
    toast.classList.add('is-hidden');
  }, 4000);
}

document.getElementById('admin-floating-toast-close')?.addEventListener('click', () => {
  const toast = document.getElementById('admin-floating-toast');
  if (toast) toast.classList.add('is-hidden');
  if (_floatingToastTimer) window.clearTimeout(_floatingToastTimer);
});

function setConferenceView(view) {
  if (conferenceViews.editor && conferenceViews.list) {
    conferenceViews.editor.classList.toggle('is-hidden', view !== 'editor');
    conferenceViews.list.classList.toggle('is-hidden', view !== 'list');
  }
}

function updateConferenceEditorUI() {
  if (!conferenceBanner || !conferenceBannerText) return;
  if (state.editingConferenceId) {
    const conf = state.conferences.find((c) => String(c.id) === String(state.editingConferenceId));
    conferenceBanner.classList.add('is-editing');
    conferenceBannerText.textContent = conf ? `Editing: "${conf.title}"` : 'Editing Conference';
    if (conferenceCancelEdit) conferenceCancelEdit.style.display = 'inline-flex';
    if (conferenceSubmitPrimary) conferenceSubmitPrimary.textContent = 'Update Conference';
    if (conferenceSubmitSecondary) conferenceSubmitSecondary.textContent = 'Save as Draft';
  } else {
    conferenceBanner.classList.remove('is-editing');
    conferenceBannerText.textContent = 'Create New Conference';
    if (conferenceCancelEdit) conferenceCancelEdit.style.display = 'none';
    if (conferenceSubmitPrimary) conferenceSubmitPrimary.textContent = 'Save & Publish';
    if (conferenceSubmitSecondary) conferenceSubmitSecondary.textContent = 'Save as Draft';
  }
}

function renderConferences() {
  if (!conferenceList) return;

  const allConfs = state.conferences || [];
  const confCount = allConfs.length;
  conferenceCountBadges.forEach((b) => (b.textContent = String(confCount)));

  const pubCount = allConfs.filter((c) => c.status === 'published').length;
  const draftCount = allConfs.filter((c) => c.status === 'draft').length;
  const archCount = allConfs.filter((c) => c.status === 'archived').length;

  const elAll = document.querySelector('[data-conference-filter-all-count]');
  const elPub = document.querySelector('[data-conference-filter-published-count]');
  const elDraft = document.querySelector('[data-conference-filter-draft-count]');
  const elArch = document.querySelector('[data-conference-filter-archived-count]');

  if (elAll) elAll.textContent = String(confCount);
  if (elPub) elPub.textContent = String(pubCount);
  if (elDraft) elDraft.textContent = String(draftCount);
  if (elArch) elArch.textContent = String(archCount);

  // Helper to format button / display label cleanly (e.g. SPP2027)
  const getCleanConfLabel = (c) => {
    const rawYear = String(c.year || '').trim();
    const rawTitle = String(c.title || '').trim();
    const match = rawTitle.match(/^spp\s*(\d{4}|\w+)/i);
    if (match) return `SPP${match[1]}`;
    if (rawYear) return /^spp/i.test(rawYear) ? rawYear.toUpperCase() : `SPP${rawYear}`;
    if (rawTitle) return /^spp/i.test(rawTitle) ? rawTitle : `SPP ${rawTitle}`;
    return 'SPP';
  };

  const renderTabSummary = (tabs) => {
    if (!Array.isArray(tabs) || tabs.length === 0) return '';

    const tabItems = tabs.slice(0, 3).map((tab, index) => {
      const title = String(tab?.title || `Tab ${index + 1}`).trim();
      const rawContent = String(tab?.content || '').replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim();
      const excerpt = rawContent ? `${rawContent.slice(0, 90)}${rawContent.length > 90 ? '…' : ''}` : 'No content yet';
      return `
        <div class="conference-card-tab-summary">
          <strong>${escapeHtml(title)}</strong>
          <span>${escapeHtml(excerpt)}</span>
        </div>
      `;
    }).join('');

    const moreCount = tabs.length - 3;
    const moreBadge = moreCount > 0 ? `<span class="conference-card-tabs-more">+${moreCount} more tab${moreCount === 1 ? '' : 's'}</span>` : '';

    return `
      <div class="conference-card-tabs">
        <div class="conference-card-tabs-label">Tabs</div>
        <div class="conference-card-tabs-list">${tabItems}</div>
        ${moreBadge}
      </div>
    `;
  };

  // Filter conferences
  const filtered = state.conferenceFilter === 'all'
    ? allConfs
    : allConfs.filter((c) => c.status === state.conferenceFilter);

  if (!filtered.length) {
    conferenceList.innerHTML = '<div class="conference-empty-state"><p>No conferences found matching this filter.</p></div>';
    return;
  }

  conferenceList.innerHTML = filtered
    .map((conf) => {
      const statusClass = conf.status === 'published' ? 'published' : (conf.status === 'draft' ? 'draft' : 'archived');
      const statusText = conf.status === 'published' ? 'Published' : (conf.status === 'draft' ? 'Draft' : 'Archived');
      let quickAction = '';
      if (conf.status === 'published') {
        quickAction = '<button type="button" class="item-action" data-conference-action="archive">Archive</button>';
      } else if (conf.status === 'archived') {
        quickAction = '<button type="button" class="item-action" data-conference-action="publish">Restore</button>';
      } else {
        quickAction = '<button type="button" class="item-action primary" data-conference-action="publish">Publish</button>';
      }

      const confTarget = conf.year || conf.title || conf.id;
      const confBadgeLabel = getCleanConfLabel(conf);

      return `
        <article class="conference-card" data-conference-id="${escapeHtml(conf.id)}">
          <div class="conference-card-head">
            <h3>${escapeHtml(conf.title || confBadgeLabel)}</h3>
            <span class="conference-badge ${statusClass}">${statusText}</span>
          </div>
          ${conf.theme ? `<div class="conference-theme-line">&ldquo;${escapeHtml(conf.theme)}&rdquo;</div>` : ''}
          <div class="conference-card-meta">
            ${conf.location ? `<span><strong>Location:</strong> ${escapeHtml(conf.location)}</span>` : ''}
            ${conf.dates ? `<span><strong>Dates:</strong> ${escapeHtml(conf.dates)}</span>` : ''}
            ${conf.year ? `<span><strong>Year:</strong> ${escapeHtml(conf.year)}</span>` : ''}
          </div>
          ${conf.summary ? `<p class="conference-card-summary">${escapeHtml(conf.summary)}</p>` : ''}
          <div class="conference-card-actions">
            <a href="/spp?year=${encodeURIComponent(confTarget)}" class="button button-secondary" target="_blank">View Portal (${escapeHtml(confBadgeLabel)}) &#x2197;</a>
            <button type="button" class="item-action primary" data-conference-action="edit">Edit Details</button>
            ${quickAction}
            <button type="button" class="item-action danger" data-conference-action="delete">Delete</button>
          </div>
        </article>
      `;
    })
    .join('');
}

// ─── Conference Tabs Manager ──────────────────────────────────────────────────
let _conferenceTabCounter = 0;
let _activeConferenceTabId = null;
let _conferenceTabsExpanded = false;

function getConferenceTabExcerpt(content) {
  const plainText = String(content || '').replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim();
  if (!plainText) return 'No content yet';
  return plainText.length > 110 ? `${plainText.slice(0, 110)}…` : plainText;
}

function updateConferenceTabsVisibility() {
  const container = document.querySelector('[data-conference-tabs-container]');
  const toggleWrap = document.querySelector('[data-conference-tabs-toggle-wrap]');
  const toggleBtn = document.querySelector('[data-conference-tabs-toggle]');
  const toggleText = document.querySelector('[data-conference-tabs-toggle-text]');
  if (!container) return;

  const items = Array.from(container.querySelectorAll('.conference-tab-item'));
  const totalTabs = items.length;

  // When editing a specific tab, that tab is visible and other tabs are hidden
  if (_activeConferenceTabId !== null) {
    if (toggleWrap) toggleWrap.classList.add('is-hidden');
    return;
  }

  // When not editing a tab, show only 2 at a time unless expanded
  const limit = 2;
  items.forEach((tabEl, index) => {
    if (!_conferenceTabsExpanded && index >= limit) {
      tabEl.classList.add('is-hidden');
    } else {
      tabEl.classList.remove('is-hidden');
    }
  });

  if (toggleWrap && toggleBtn && toggleText) {
    if (totalTabs > limit) {
      toggleWrap.classList.remove('is-hidden');
      toggleBtn.classList.toggle('is-expanded', _conferenceTabsExpanded);
      toggleBtn.setAttribute('aria-expanded', _conferenceTabsExpanded ? 'true' : 'false');
      const hiddenCount = totalTabs - limit;
      toggleText.textContent = _conferenceTabsExpanded
        ? 'Show Less'
        : `Show More (${hiddenCount} more)`;
    } else {
      toggleWrap.classList.add('is-hidden');
    }
  }
}

function updateConferenceTabView(tabEl, isActive) {
  const summaryEl = tabEl.querySelector('.conference-tab-summary');
  const bodyEl = tabEl.querySelector('.conference-tab-body');
  const editBtn = tabEl.querySelector('[data-conference-tab-edit]');
  const cancelBtn = tabEl.querySelector('[data-conference-tab-cancel]');

  tabEl.classList.toggle('is-expanded', isActive);
  tabEl.classList.toggle('is-collapsed', !isActive);
  tabEl.classList.toggle('is-hidden', _activeConferenceTabId !== null && !isActive);

  if (summaryEl) summaryEl.classList.toggle('is-hidden', isActive);
  if (bodyEl) bodyEl.classList.toggle('is-hidden', !isActive);
  if (editBtn) editBtn.style.display = isActive ? 'none' : 'inline-flex';
  if (cancelBtn) cancelBtn.style.display = isActive ? 'inline-flex' : 'none';
}

function refreshConferenceTabSummaries() {
  const container = document.querySelector('[data-conference-tabs-container]');
  if (!container) return;

  const items = Array.from(container.querySelectorAll('.conference-tab-item'));
  items.forEach((tabEl, index) => {
    const badge = tabEl.querySelector('.conference-tab-badge');
    if (badge) badge.textContent = `Tab ${index + 1}`;

    const title = (tabEl.querySelector('.conference-tab-title-input')?.value || '').trim();
    const content = tabEl.querySelector('.conference-tab-content-textarea')?.value || '';
    const summaryTitle = tabEl.querySelector('[data-conference-tab-summary-title]');
    const summaryExcerpt = tabEl.querySelector('[data-conference-tab-summary-excerpt]');
    if (summaryTitle) summaryTitle.textContent = title || `Tab ${index + 1}`;
    if (summaryExcerpt) summaryExcerpt.textContent = getConferenceTabExcerpt(content);
  });

  if (_activeConferenceTabId) {
    items.forEach((tabEl) => updateConferenceTabView(tabEl, String(tabEl.dataset.tabId) === String(_activeConferenceTabId)));
  } else {
    items.forEach((tabEl) => updateConferenceTabView(tabEl, false));
  }

  updateConferenceTabsVisibility();
}

function setActiveConferenceTab(tabId = null) {
  _activeConferenceTabId = tabId;
  refreshConferenceTabSummaries();
}

function updateConferenceTabsEmptyState() {
  const container = document.querySelector('[data-conference-tabs-container]');
  const toggleWrap = document.querySelector('[data-conference-tabs-toggle-wrap]');
  if (!container) return;
  const items = container.querySelectorAll('.conference-tab-item');
  const existingEmpty = container.querySelector('.conference-tabs-empty');
  if (items.length === 0) {
    if (toggleWrap) toggleWrap.classList.add('is-hidden');
    if (!existingEmpty) {
      const emptyDiv = document.createElement('div');
      emptyDiv.className = 'conference-tabs-empty';
      emptyDiv.innerHTML = `
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.5; margin: 0 auto 8px; display: block;" aria-hidden="true">
          <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
          <line x1="3" y1="9" x2="21" y2="9"></line>
          <line x1="9" y1="21" x2="9" y2="9"></line>
        </svg>
        <p style="margin: 0; font-weight: 500;">No custom sidebar tabs added yet.</p>
        <p style="margin: 4px 0 0; font-size: 0.8rem; opacity: 0.7;">Click <strong>&ldquo;Add New Tab&rdquo;</strong> above to create one.</p>
      `;
      container.appendChild(emptyDiv);
    }
  } else {
    if (existingEmpty) existingEmpty.remove();
    // Update badge numbers
    items.forEach((item, index) => {
      const badge = item.querySelector('.conference-tab-badge');
      if (badge) badge.textContent = `Tab ${index + 1}`;
    });
    updateConferenceTabsVisibility();
  }
}

function addConferenceTab(tabData = {}) {
  const container = document.querySelector('[data-conference-tabs-container]');
  if (!container) return;
  const existingEmpty = container.querySelector('.conference-tabs-empty');
  if (existingEmpty) existingEmpty.remove();

  _conferenceTabCounter++;
  const tabId = tabData.id || `tab-${Date.now()}-${_conferenceTabCounter}`;
  const currentCount = container.querySelectorAll('.conference-tab-item').length + 1;
  const tabEl = document.createElement('div');
  tabEl.className = 'conference-tab-item';
  tabEl.dataset.tabId = tabId;
  tabEl.innerHTML = `
    <div class="conference-tab-header">
      <span class="conference-tab-badge">Tab ${currentCount}</span>
      <input type="text" class="conference-tab-title-input" placeholder="Tab Title (e.g. Important Dates)" value="${escapeHtml(tabData.title || '')}" aria-label="Tab title" />
      <button type="button" class="conference-tab-remove" aria-label="Remove tab" title="Remove this tab">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18"></path><path d="M8 6V4h8v2"></path><path d="M6 6l1 14h10l1-14"></path><path d="M10 11v5"></path><path d="M14 11v5"></path></svg>
      </button>
    </div>
    <div class="conference-tab-summary">
      <div class="conference-tab-summary-meta">
        <strong data-conference-tab-summary-title>Tab ${currentCount}</strong>
        <span class="conference-tab-summary-excerpt" data-conference-tab-summary-excerpt>${escapeHtml(getConferenceTabExcerpt(tabData.content || ''))}</span>
      </div>
      <button type="button" class="button button-quiet conference-tab-edit-button" data-conference-tab-edit>Edit Tab</button>
    </div>
    <div class="conference-tab-body rich-editor-wrap" data-rich-editor="conference-tab-${tabId}">
      <div class="editor-toolbar" role="toolbar" aria-label="Tab content formatting toolbar">
        <button type="button" class="toolbar-btn" data-format="bold" title="Bold" aria-label="Bold"><strong>B</strong></button>
        <button type="button" class="toolbar-btn" data-format="italic" title="Italic" aria-label="Italic"><em>I</em></button>
        <button type="button" class="toolbar-btn" data-format="underline" title="Underline (<u>text</u>)" aria-label="Underline"><u>U</u></button>
        <button type="button" class="toolbar-btn" data-format="h1" title="Heading 1 (# Title)" aria-label="Heading 1">H1</button>
        <button type="button" class="toolbar-btn" data-format="h2" title="Heading 2 (## Subtitle)" aria-label="Heading 2">H2</button>
        <button type="button" class="toolbar-btn" data-format="ul" title="Bullet List (- item)" aria-label="Bullet List"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><circle cx="3.5" cy="6" r="1.5" fill="currentColor"></circle><circle cx="3.5" cy="12" r="1.5" fill="currentColor"></circle><circle cx="3.5" cy="18" r="1.5" fill="currentColor"></circle></svg></button>
        <button type="button" class="toolbar-btn" data-format="ol" title="Numbered List (1. item)" aria-label="Numbered List"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><path d="M4 6h1v4M4 10h2" stroke-width="1.6"></path><path d="M4 14h2a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H4v1h3" stroke-width="1.6"></path></svg></button>
        <button type="button" class="toolbar-btn" data-format="blockquote" title="Blockquote (> text)" aria-label="Blockquote"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2H4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2 0 4-1 6-1 8z" fill="currentColor" stroke="none"></path><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2h-4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2 0 4-1 6-1 8z" fill="currentColor" stroke="none"></path></svg></button>
        <button type="button" class="toolbar-btn" data-format="code" title="Inline code (&grave;code&grave;)" aria-label="Code">&lt;/&gt;</button>
        <button type="button" class="toolbar-btn" data-format="hr" title="Horizontal rule (---)" aria-label="Horizontal Rule">&#x2014;</button>
        <button type="button" class="toolbar-btn" data-format="link" title="Link" aria-label="Link">&#x1F517;</button>
        <button type="button" class="toolbar-btn" data-format="image" title="Image (![alt](url))" aria-label="Image">&#x1F5BC;</button>
        <button type="button" class="toolbar-btn" data-format="table" title="Insert table" aria-label="Table"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="3" y1="15" x2="21" y2="15"></line><line x1="9" y1="3" x2="9" y2="21"></line><line x1="15" y1="3" x2="15" y2="21"></line></svg></button>
        <button type="button" class="toolbar-btn" data-format="footnote" title="Footnote ([^1])" aria-label="Footnote">fn</button>
        <button type="button" class="toolbar-btn" data-format="highlight" title="Highlight (==text==)" aria-label="Highlight"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 11-6 6v3h3l6-6"></path><path d="m22 7-4.5-4.5a2.12 2.12 0 0 0-3 0L10 7l7 7 4.5-4.5a2.12 2.12 0 0 0 0-3z"></path><line x1="14" y1="20" x2="22" y2="20" stroke-width="2.5" stroke="#f59e0b"></line></svg></button>
        <button type="button" class="toolbar-btn" data-format="sub" title="Subscript (~text~)" aria-label="Subscript">X<sub>2</sub></button>
        <button type="button" class="toolbar-btn" data-format="sup" title="Superscript (^text^)" aria-label="Superscript">X<sup>2</sup></button>
      </div>
      <textarea rows="6" class="conference-tab-content-textarea" placeholder="Tab section details (markdown supported)..." aria-label="Tab content">${escapeHtml(tabData.content || '')}</textarea>
      <div class="conference-tab-footer">
        <button type="button" class="button button-secondary btn-save-conference-tabs" data-conference-tab-save>
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 5h12l4 4v10H4z"></path><path d="M7 5v6h8V5"></path><path d="M7 19v-5h10v5"></path></svg>
          Save
        </button>
        <button type="button" class="button button-quiet conference-tab-cancel-button" data-conference-tab-cancel style="display: none;">
          Cancel Editing
        </button>
      </div>
    </div>
  `;
  container.appendChild(tabEl);

  const removeButton = tabEl.querySelector('.conference-tab-remove');
  const saveButton = tabEl.querySelector('[data-conference-tab-save]');
  const cancelButton = tabEl.querySelector('[data-conference-tab-cancel]');

  removeButton?.addEventListener('click', async () => {
    const confirmed = await showConfirmModal('Delete Tab', 'Are you sure you want to delete this tab? This action cannot be undone.', 'Delete Tab');
    if (!confirmed) return;

    setButtonLoading(removeButton, true, 'Deleting...');
    await new Promise((resolve) => window.setTimeout(resolve, 120));

    tabEl.remove();
    if (String(_activeConferenceTabId) === String(tabId)) {
      _activeConferenceTabId = null;
    }
    updateConferenceTabsEmptyState();
    refreshConferenceTabSummaries();
    if (container.querySelectorAll('.conference-tab-item').length === 0) {
      _activeConferenceTabId = null;
    }
  });

  tabEl.querySelector('[data-conference-tab-edit]')?.addEventListener('click', () => {
    setActiveConferenceTab(tabId);
    tabEl.querySelector('.conference-tab-title-input')?.focus();
  });

  cancelButton?.addEventListener('click', () => {
    setActiveConferenceTab(null);
  });

  saveButton?.addEventListener('click', async () => {
    await saveConferenceFromEditor(saveButton, { keepEditorOpen: true });
  });

  tabEl.querySelector('.conference-tab-title-input')?.addEventListener('input', refreshConferenceTabSummaries);
  tabEl.querySelector('.conference-tab-content-textarea')?.addEventListener('input', refreshConferenceTabSummaries);

  // Init rich editor for this tab's textarea
  setupRichEditorToolbars();

  // Focus title input if it's a new tab without title
  if (!tabData.title) {
    const input = tabEl.querySelector('.conference-tab-title-input');
    if (input) input.focus();
  }

  if (_activeConferenceTabId && String(_activeConferenceTabId) !== String(tabId)) {
    updateConferenceTabView(tabEl, false);
  } else {
    _activeConferenceTabId = tabId;
    updateConferenceTabView(tabEl, true);
  }

  refreshConferenceTabSummaries();
}

function clearConferenceTabs() {
  const container = document.querySelector('[data-conference-tabs-container]');
  if (container) {
    container.innerHTML = '';
    _activeConferenceTabId = null;
    _conferenceTabsExpanded = false;
    updateConferenceTabsEmptyState();
  }
}

function collectConferenceTabs() {
  const container = document.querySelector('[data-conference-tabs-container]');
  if (!container) return [];
  const tabs = [];
  container.querySelectorAll('.conference-tab-item').forEach((tabEl) => {
    const tabId = tabEl.dataset.tabId || `tab-${Date.now()}`;
    const title = (tabEl.querySelector('.conference-tab-title-input')?.value || '').trim();
    const content = (tabEl.querySelector('.conference-tab-content-textarea')?.value || '').trim();
    if (title || content) {
      tabs.push({ id: tabId, title, content });
    }
  });
  return tabs;
}

// ─── Conference DB Functions ──────────────────────────────────────────────────
async function fetchConferencesFromDatabase() {
  try {
    const res = await fetch('/admin/api/conferences', {
      headers: { 'Accept': 'application/json' },
    });
    if (!res.ok) return;
    const result = await res.json();
    state.conferences = (result.data || []).map((item) => ({
      id: item.id,
      year: item.year || '',
      title: item.title || '',
      theme: item.theme || '',
      location: item.location || '',
      dates: item.dates || '',
      summary: item.summary || '',
      body: item.description || '',
      status: item.status || 'draft',
      coverImage: item.image_url || item.image || null,
      tabs: Array.isArray(item.tabs) ? item.tabs : (typeof item.tabs === 'string' ? (JSON.parse(item.tabs || '[]')) : []),
    }));
    renderConferences();
  } catch (err) {
    console.error('Failed to fetch conferences from database:', err);
  }
}

async function saveConferenceFromEditor(submitter, options = {}) {
  if (!conferenceForm) return;

  const keepEditorOpen = options.keepEditorOpen ?? false;
  const overrideStatus = submitter?.dataset.statusOverride;
  const data = new FormData(conferenceForm);
  const title = String(data.get('title') || '').trim();
  if (!title) return;

  const chosenStatus = overrideStatus || String(data.get('status') || 'published');
  data.set('status', chosenStatus);

  const tabs = collectConferenceTabs();
  data.set('tabs', JSON.stringify(tabs));

  if (imageState.conference && !data.get('coverImage')?.name) {
    data.set('coverImage', imageState.conference);
  }

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  setButtonLoading(submitter, true, 'Saving...');

  try {
    let url = '/admin/api/conferences';
    if (state.editingConferenceId) {
      url = `/admin/api/conferences/${state.editingConferenceId}`;
      data.append('_method', 'PUT');
    }

    const res = await fetch(url, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken || '',
        'Accept': 'application/json',
      },
      body: data,
    });

    if (!res.ok) {
      const err = await res.json().catch(() => ({}));
      alert(err.message || 'Failed to save conference.');
      return;
    }

    const result = await res.json().catch(() => ({}));
    if (result?.data?.id) {
      state.editingConferenceId = result.data.id;
    }

    await fetchConferencesFromDatabase();
    if (keepEditorOpen) {
      setActiveConferenceTab(null);
      updateConferenceEditorUI();
      refreshConferenceTabSummaries();
      setConferenceView('editor');
      showFloatingToast(`Tab in "${title}" saved successfully.`);
    } else {
      const wasEditing = Boolean(state.editingConferenceId);
      state.editingConferenceId = null;
      conferenceForm.reset();
      clearConferenceTabs();
      document.querySelector('[data-upload-zone="conference"]')?._clearImage?.();
      updateConferenceEditorUI();
      setConferenceView('list');

      showFloatingToast(wasEditing ? `Conference "${title}" updated successfully.` : `Conference "${title}" created successfully.`);
      document.querySelector('#conferences-section')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  } catch (err) {
    console.error('Error saving conference:', err);
    alert('Network error. Please try again.');
  } finally {
    setButtonLoading(submitter, false);
  }
}

function startEditingConference(confId) {
  const conf = state.conferences.find((c) => String(c.id) === String(confId));
  if (!conf || !conferenceForm) return;

  state.editingConferenceId = conf.id;
  if (conferenceForm.elements.status) conferenceForm.elements.status.value = conf.status || 'published';
  if (conferenceForm.elements.year) conferenceForm.elements.year.value = conf.year || '';
  if (conferenceForm.elements.title) conferenceForm.elements.title.value = conf.title || '';
  if (conferenceForm.elements.theme) conferenceForm.elements.theme.value = conf.theme || '';
  if (conferenceForm.elements.location) conferenceForm.elements.location.value = conf.location || '';
  if (conferenceForm.elements.dates) conferenceForm.elements.dates.value = conf.dates || '';
  if (conferenceForm.elements.summary) conferenceForm.elements.summary.value = conf.summary || '';

  // Set body / description
  const bodyEl = conferenceForm.elements.body;
  if (bodyEl) {
    bodyEl.value = conf.body || '';
    if (bodyEl._syncToVisual) bodyEl._syncToVisual();
  }

  // Load tabs
  clearConferenceTabs();
  if (Array.isArray(conf.tabs)) {
    conf.tabs.forEach((tab) => addConferenceTab(tab));
  }
  setActiveConferenceTab(null);

  const confZone = document.querySelector('[data-upload-zone="conference"]');
  if (conf.coverImage && confZone?._applyImage) {
    confZone._applyImage(conf.coverImage, 'Current banner image');
  } else {
    confZone?._clearImage?.();
  }

  setConferenceView('editor');
  updateConferenceEditorUI();
  document.querySelector('#conferences-section')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function cancelEditingConference() {
  state.editingConferenceId = null;
  conferenceForm?.reset();
  clearConferenceTabs();
  document.querySelector('[data-upload-zone="conference"]')?._clearImage?.();
  updateConferenceEditorUI();
  setConferenceView('list');
}

async function handleConferenceSubmit(event) {
  event.preventDefault();
  await saveConferenceFromEditor(event.submitter, { keepEditorOpen: false });
}

async function handleConferenceAction(event) {
  const target = event.target.closest('[data-conference-action]');
  if (!target) return;

  const card = target.closest('[data-conference-id]');
  if (!card) return;

  const confId = card.dataset.conferenceId;
  const action = target.dataset.conferenceAction;

  if (action === 'edit') {
    startEditingConference(confId);
    return;
  }

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  if (action === 'delete') {
    const confirmed = await showConfirmModal('Delete Conference', 'Are you sure you want to delete this conference? This action cannot be undone.');
    if (!confirmed) return;
    setButtonLoading(target, true, 'Deleting...');
    try {
      const res = await fetch(`/admin/api/conferences/${confId}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken || '', 'Accept': 'application/json' },
      });
      if (res.ok) {
        if (String(state.editingConferenceId) === String(confId)) state.editingConferenceId = null;
        await fetchConferencesFromDatabase();
      } else {
        alert('Failed to delete conference.');
      }
    } catch (err) {
      console.error(err);
      alert('Error deleting conference.');
    } finally {
      setButtonLoading(target, false);
    }
    return;
  }

  const nextStatusMap = { publish: 'published', archive: 'archived', draft: 'draft' };
  const nextStatus = nextStatusMap[action];
  if (!nextStatus) return;

  setButtonLoading(target, true, 'Updating...');
  try {
    const res = await fetch(`/admin/api/conferences/${confId}/status`, {
      method: 'PATCH',
      headers: {
        'X-CSRF-TOKEN': csrfToken || '',
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({ status: nextStatus }),
    });
    if (res.ok) {
      await fetchConferencesFromDatabase();
    } else {
      alert('Failed to update conference status.');
    }
  } catch (err) {
    console.error(err);
    alert('Error updating conference status.');
  } finally {
    setButtonLoading(target, false);
  }
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

  document.querySelector('[data-show-conference-list]')?.addEventListener('click', () => setConferenceView('list'));
  document.querySelector('[data-show-conference-editor]')?.addEventListener('click', () => {
    cancelEditingConference();
    setConferenceView('editor');
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

  conferenceForm?.addEventListener('submit', handleConferenceSubmit);
  conferenceForm?.addEventListener('reset', () => {
    state.editingConferenceId = null;
    clearConferenceTabs();
    window.setTimeout(updateConferenceEditorUI, 0);
  });
  conferenceCancelEdit?.addEventListener('click', cancelEditingConference);
  conferenceList?.addEventListener('click', handleConferenceAction);

  document.querySelector('[data-add-conference-tab]')?.addEventListener('click', () => {
    _conferenceTabsExpanded = true;
    addConferenceTab();
  });

  document.querySelector('[data-conference-tabs-toggle]')?.addEventListener('click', () => {
    _conferenceTabsExpanded = !_conferenceTabsExpanded;
    updateConferenceTabsVisibility();
  });

  // Auto-sync year & title inputs if empty
  const confYearInput = conferenceForm?.elements.year;
  const confTitleInput = conferenceForm?.elements.title;
  if (confYearInput && confTitleInput) {
    confYearInput.addEventListener('input', () => {
      if (!state.editingConferenceId && (!confTitleInput.value || /^SPP\d{4}$/i.test(confTitleInput.value.trim()))) {
        const val = confYearInput.value.trim();
        if (/^\d{4}$/.test(val)) {
          confTitleInput.value = `SPP${val}`;
        }
      }
    });
    confTitleInput.addEventListener('input', () => {
      if (!state.editingConferenceId && !confYearInput.value) {
        const val = confTitleInput.value.trim();
        const m = val.match(/\b(20\d{2})\b/);
        if (m) {
          confYearInput.value = m[1];
        }
      }
    });
  }

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

  document.querySelectorAll('[data-conference-filter]').forEach((btn) => {
    btn.addEventListener('click', () => {
      state.conferenceFilter = btn.dataset.conferenceFilter;
      document.querySelectorAll('[data-conference-filter]').forEach((b) => b.classList.toggle('active', b === btn));
      renderConferences();
    });
  });
}

const savedTheme = localStorage.getItem(themeKey);
const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
setTheme(savedTheme || (prefersDark ? 'dark' : 'light'));

if (!window.__sppThemeListenerAttached) {
  window.__sppThemeListenerAttached = true;
  document.addEventListener('click', (e) => {
    const toggleBtn = e.target.closest('[data-theme-toggle]');
    if (toggleBtn) {
      e.preventDefault();
      const isDark = document.documentElement.getAttribute('data-theme') === 'dark' || document.documentElement.classList.contains('dark');
      setTheme(isDark ? 'light' : 'dark');
    }
  });
}

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
if (!state.editingConferenceId) setConferenceView('list');
bindEvents();
setupRichEditorToolbars();
updateActiveNavLink();
fetchNewsFromDatabase();
fetchActivitiesFromDatabase();
fetchConferencesFromDatabase();
updateConferenceTabsEmptyState();
checkNewsDraft(null);

setupImageUpload('news');
setupImageUpload('activity');
setupImageUpload('conference');
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

  if (availableBannerPosts.news && availableBannerPosts.news.length > 0) {
    const newsGroup = document.createElement('optgroup');
    newsGroup.label = 'News Articles';
    availableBannerPosts.news.forEach((post) => {
      const opt = document.createElement('option');
      opt.value = `news:${post.id}`;
      opt.textContent = `${post.title} (${post.date || 'Recent'})`;
      if (selectedType === 'news' && String(selectedId) === String(post.id)) {
        opt.selected = true;
      }
      newsGroup.appendChild(opt);
    });
    bannerPostSelect.appendChild(newsGroup);
  }

  if (availableBannerPosts.activities && availableBannerPosts.activities.length > 0) {
    const actGroup = document.createElement('optgroup');
    actGroup.label = 'Activities & Events';
    availableBannerPosts.activities.forEach((post) => {
      const opt = document.createElement('option');
      opt.value = `activity:${post.id}`;
      opt.textContent = `${post.title} (${post.date || 'Upcoming'})`;
      if (selectedType === 'activity' && String(selectedId) === String(post.id)) {
        opt.selected = true;
      }
      actGroup.appendChild(opt);
    });
    bannerPostSelect.appendChild(actGroup);
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
    console.error('Error fetching hero banner setting:', err);
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
      showFloatingToast('Hero Banner and link destination saved successfully!');
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

      showFloatingToast('Hero Banner removed. Website title will be displayed.');
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
conferenceForm?.addEventListener('reset', () => {
  window.setTimeout(() => {
    document.querySelector('[data-upload-zone="conference"]')?._clearImage?.();
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
          <div class="downloads-cat-folder-icon" aria-hidden="true">&#x1F4C1;</div>
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

  // Return to the category editor
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

initDownloadsManager();

// ─── Logout Confirmation ─────────────────────────────────────────────────────
document.querySelectorAll('form[action*="logout"]').forEach((form) => {
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const confirmed = await showConfirmModal(
      'Confirm Logout',
      'Are you sure you want to log out of your session?',
      'Log Out',
      'button-danger'
    );
    if (confirmed) {
      form.submit();
    }
  });
});


