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
const conferencePortalPills = document.querySelector('[data-conference-portal-pills]');
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
  try {
    const stored = localStorage.getItem(localStorageKey);
    if (!stored) {
      return defaultPosts.slice();
    }
    const parsed = JSON.parse(stored);
    return Array.isArray(parsed) && parsed.length > 0 ? parsed : defaultPosts.slice();
  } catch (error) {
    return defaultPosts.slice();
  }
}

function savePosts() {
  localStorage.setItem(localStorageKey, JSON.stringify(state.posts));
}

function loadConferences() {
  try {
    const stored = localStorage.getItem(conferenceStorageKey);
    if (!stored) return defaultConferences.slice();
    const parsed = JSON.parse(stored);
    return Array.isArray(parsed) && parsed.length > 0 ? parsed : defaultConferences.slice();
  } catch (error) {
    return defaultConferences.slice();
  }
}

function saveConferences() {
  localStorage.setItem(conferenceStorageKey, JSON.stringify(state.conferences));
}

async function fetchNewsFromDatabase() {
  try {
    const res = await fetch('/admin/api/news');
    if (!res.ok) throw new Error('Failed to load news');
    const result = await res.json();
    if (result && Array.isArray(result.data)) {
      const dbNews = result.data.map((item) => ({
        id: item.id,
        type: 'announcement',
        section: 'News',
        title: item.title,
        slug: item.slug,
        summary: item.excerpt || '',
        publishDate: item.published_at ? item.published_at.slice(0, 10) : (item.created_at ? item.created_at.slice(0, 10) : ''),
        body: item.content || '',
        status: item.status || 'draft',
        coverImage: item.image || null,
      }));

      const otherPosts = state.posts.filter((p) => p.type !== 'announcement');
      state.posts = [...dbNews, ...otherPosts];
      renderAll();
    }
  } catch (err) {
    console.error('Error fetching news from database:', err);
  }
}

async function fetchActivitiesFromDatabase() {
  try {
    const res = await fetch('/admin/api/activities');
    if (!res.ok) throw new Error('Failed to load activities');
    const result = await res.json();
    if (result && Array.isArray(result.data)) {
      const dbActivities = result.data.map((item) => ({
        id: item.id,
        type: 'event',
        section: 'Activities',
        title: item.title,
        slug: item.slug,
        summary: item.summary || '',
        publishDate: item.event_date ? item.event_date.slice(0, 10) : (item.created_at ? item.created_at.slice(0, 10) : ''),
        body: item.description || '',
        location: item.location || '',
        status: item.status || 'draft',
        coverImage: item.image || null,
        featured: item.is_featured || false,
      }));

      state.posts = [
        ...state.posts.filter((p) => p.type !== 'event'),
        ...dbActivities,
      ];
      renderAll();
    }
  } catch (err) {
    console.error('Error fetching activities from database:', err);
  }
}

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

/* ─── Markdown Toolbar Engine ───────────────────────────────────────────── */
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
    const text = selected || 'link text';
    const snippet = `[${text}](https://example.com)`;
    el.value = val.substring(0, start) + snippet + val.substring(end);
    const urlStart = start + text.length + 3;
    el.setSelectionRange(urlStart, urlStart + 19);
    el.dispatchEvent(new Event('input', { bubbles: true }));
  } else if (format === 'image') {
    const alt = selected || 'image alt text';
    const snippet = `![${alt}](https://example.com/image.png)`;
    el.value = val.substring(0, start) + snippet + val.substring(end);
    const urlStart = start + alt.length + 4;
    el.setSelectionRange(urlStart, urlStart + 30);
    el.dispatchEvent(new Event('input', { bubbles: true }));
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

  // Don't save empty drafts for new posts
  if (!postId && !title && !summary && !body) {
    localStorage.removeItem(getNewsDraftKey(null));
    return;
  }

  // If editing an existing post and values match server state, clean up
  if (postId) {
    const originalPost = state.posts.find((p) => String(p.id) === String(postId));
    if (originalPost) {
      const origTitle = (originalPost.title || '').trim();
      const origSummary = (originalPost.summary || originalPost.excerpt || '').trim();
      const origBody = (originalPost.body || originalPost.content || '').trim();
      if (title === origTitle && summary === origSummary && body === origBody) {
        localStorage.removeItem(getNewsDraftKey(postId));
        return;
      }
    }
  }

  const draft = {
    id: postId,
    title: newsForm.elements.title?.value || '',
    summary: newsForm.elements.summary?.value || '',
    body: newsForm.elements.body?.value || '',
    updatedAt: Date.now(),
  };

  try {
    localStorage.setItem(getNewsDraftKey(postId), JSON.stringify(draft));
  } catch (err) {
    console.warn('Could not save draft to localStorage:', err);
  }
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

function checkNewsDraft(postId) {
  const banner = document.querySelector('[data-draft-banner="news"]');
  const timeSpan = document.querySelector('[data-draft-time="news"]');
  if (!banner || !newsForm) return;

  const key = getNewsDraftKey(postId);
  const raw = localStorage.getItem(key);
  if (!raw) {
    activeNewsDraft = null;
    banner.classList.add('is-hidden');
    return;
  }

  try {
    const draft = JSON.parse(raw);
    if (!draft || typeof draft !== 'object') {
      banner.classList.add('is-hidden');
      return;
    }

    const currentTitle = (newsForm.elements.title?.value || '').trim();
    const currentSummary = (newsForm.elements.summary?.value || '').trim();
    const currentBody = (newsForm.elements.body?.value || '').trim();

    const draftTitle = (draft.title || '').trim();
    const draftSummary = (draft.summary || '').trim();
    const draftBody = (draft.body || '').trim();

    const hasChanges = draftTitle !== currentTitle || draftSummary !== currentSummary || draftBody !== currentBody;

    if (hasChanges && (draftTitle || draftSummary || draftBody)) {
      activeNewsDraft = draft;
      if (timeSpan) {
        timeSpan.textContent = `(Saved ${formatDraftTime(draft.updatedAt)})`;
      }
      banner.classList.remove('is-hidden');
    } else {
      activeNewsDraft = null;
      banner.classList.add('is-hidden');
    }
  } catch (e) {
    banner.classList.add('is-hidden');
  }
}

function restoreNewsDraft() {
  const banner = document.querySelector('[data-draft-banner="news"]');
  if (!activeNewsDraft || !newsForm) return;

  if (newsForm.elements.title && activeNewsDraft.title !== undefined) {
    newsForm.elements.title.value = activeNewsDraft.title;
  }
  if (newsForm.elements.summary && activeNewsDraft.summary !== undefined) {
    newsForm.elements.summary.value = activeNewsDraft.summary;
  }
  if (newsForm.elements.body && activeNewsDraft.body !== undefined) {
    newsForm.elements.body.value = activeNewsDraft.body;
  }

  banner?.classList.add('is-hidden');
}

function discardNewsDraft() {
  const banner = document.querySelector('[data-draft-banner="news"]');
  const key = getNewsDraftKey(state.editingNewsId);
  localStorage.removeItem(key);
  activeNewsDraft = null;
  banner?.classList.add('is-hidden');
}

function clearNewsDraft(postId) {
  const key = getNewsDraftKey(postId);
  localStorage.removeItem(key);
  if (postId) {
    localStorage.removeItem(getNewsDraftKey(null));
  }
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
      coverImage: item.image || item.coverImage || null,
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
      type: 'activity',
      section: 'Activity',
      title: item.title,
      summary: item.excerpt || item.summary || '',
      publishDate: item.published_at ? String(item.published_at).substring(0, 10) : (item.created_at ? String(item.created_at).substring(0, 10) : ''),
      status: item.status || 'scheduled',
      body: item.content || item.body || '',
      coverImage: item.image || item.coverImage || null,
      featured: Boolean(item.featured),
    }));
    state.posts = state.posts.filter((p) => p.section !== 'Activity').concat(items);
    renderAll();
  } catch (err) {
    console.error('Failed to fetch activities from database:', err);
  }
}

async function handleNewsSubmit(event) {
  event.preventDefault();
  if (!newsForm) return;

  const overrideStatus = event.submitter?.dataset.statusOverride;
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
    document.querySelector('[data-upload-zone="news"]')?._clearImage?.();
    clearNewsDraft(savedId);
    await fetchNewsFromDatabase();
    setNewsView('posts');
  } catch (err) {
    console.error('Error saving news:', err);
    alert('An error occurred while saving the news post.');
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
    if (!confirm('Are you sure you want to delete this news post?')) return;
    try {
      const res = await fetch(`/admin/api/news/${postId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': csrfToken || '',
          'Accept': 'application/json',
        },
      });

      if (res.ok) {
        if (state.editingNewsId == postId) state.editingNewsId = null;
        await fetchNewsFromDatabase();
      } else {
        alert('Failed to delete news post.');
      }
    } catch (err) {
      console.error(err);
      alert('Error deleting news post.');
    }
    return;
  }

  if (action === 'publish' || action === 'archive' || action === 'draft') {
    const nextStatus = action === 'publish' ? 'published' : (action === 'archive' ? 'archived' : 'draft');
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

async function handleActivitySubmit(event) {
  event.preventDefault();
  if (!activityForm) return;

  const overrideStatus = event.submitter?.dataset.statusOverride;
  const data = new FormData(activityForm);
  const title = String(data.get('title') || '').trim();
  if (!title) return;

  const chosenStatus = overrideStatus || String(data.get('status') || 'scheduled');
  data.set('status', chosenStatus);

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  if (imageState.activity && !data.get('coverImage')?.name) {
    data.set('coverImage', imageState.activity);
  }

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

    state.editingActivityId = null;
    activityForm.reset();
    document.querySelector('[data-upload-zone="activity"]')?._clearImage?.();
    await fetchActivitiesFromDatabase();
    setActivityView('posts');
  } catch (err) {
    console.error('Error saving activity:', err);
    alert('An error occurred while saving the activity.');
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
    if (!confirm('Are you sure you want to delete this activity?')) return;
    try {
      const res = await fetch(`/admin/api/activities/${postId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': csrfToken || '',
          'Accept': 'application/json',
        },
      });

      if (res.ok) {
        if (state.editingActivityId == postId) state.editingActivityId = null;
        await fetchActivitiesFromDatabase();
      } else {
        alert('Failed to delete activity.');
      }
    } catch (err) {
      console.error(err);
      alert('Error deleting activity.');
    }
    return;
  }

  if (action === 'publish' || action === 'archive' || action === 'draft') {
    const nextStatus = action === 'publish' ? 'published' : (action === 'archive' ? 'archived' : 'draft');
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
    }
  }
}

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

  // Render Portal Pills
  if (conferencePortalPills) {
    const sorted = allConfs
      .filter((c) => c.year)
      .slice()
      .sort((a, b) => parseInt(a.year, 10) - parseInt(b.year, 10));

    conferencePortalPills.innerHTML = sorted
      .map((c) => {
        const isCurrent = c.year === '2026' || c.status === 'published';
        return `<a href="/spp?year=${encodeURIComponent(c.year)}" class="conference-year-btn ${isCurrent ? 'active' : ''}" target="_blank">SPP ${escapeHtml(c.year)} &#x2197;</a>`;
      })
      .join('');
  }

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

      return `
        <article class="conference-card" data-conference-id="${escapeHtml(conf.id)}">
          <div class="conference-card-head">
            <h3>${escapeHtml(conf.title || `SPP ${conf.year}`)}</h3>
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
            ${conf.year ? `<a href="/spp?year=${encodeURIComponent(conf.year)}" class="button button-secondary" target="_blank">View Portal &#x2197;</a>` : ''}
            <button type="button" class="item-action primary" data-conference-action="edit">Edit Details</button>
            ${quickAction}
            <button type="button" class="item-action danger" data-conference-action="delete">Delete</button>
          </div>
        </article>
      `;
    })
    .join('');
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
  if (conferenceForm.elements.body) conferenceForm.elements.body.value = conf.body || '';

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
  document.querySelector('[data-upload-zone="conference"]')?._clearImage?.();
  updateConferenceEditorUI();
  setConferenceView('list');
}

function handleConferenceSubmit(event) {
  event.preventDefault();
  if (!conferenceForm) return;

  const overrideStatus = event.submitter?.dataset.statusOverride;
  const data = new FormData(conferenceForm);
  const title = String(data.get('title') || '').trim();
  const year = String(data.get('year') || '').trim();
  if (!title) return;

  const chosenStatus = overrideStatus || String(data.get('status') || 'published');

  const confData = {
    year: year,
    title: title,
    theme: String(data.get('theme') || '').trim(),
    location: String(data.get('location') || '').trim(),
    dates: String(data.get('dates') || '').trim(),
    summary: String(data.get('summary') || '').trim(),
    body: String(data.get('body') || '').trim(),
    status: chosenStatus,
    coverImage: imageState.conference || null,
  };

  if (state.editingConferenceId) {
    const idx = state.conferences.findIndex((c) => String(c.id) === String(state.editingConferenceId));
    if (idx >= 0) {
      state.conferences[idx] = { ...state.conferences[idx], ...confData };
    }
    state.editingConferenceId = null;
  } else {
    const newConf = {
      id: `conf-${Date.now()}`,
      ...confData,
    };
    state.conferences = [newConf, ...state.conferences];
  }

  saveConferences();
  conferenceForm.reset();
  document.querySelector('[data-upload-zone="conference"]')?._clearImage?.();
  renderConferences();
  setConferenceView('list');
}

function handleConferenceAction(event) {
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

  const idx = state.conferences.findIndex((c) => String(c.id) === String(confId));
  if (idx < 0) return;

  if (action === 'delete') {
    if (!confirm('Are you sure you want to delete this conference entry?')) return;
    if (String(state.editingConferenceId) === String(confId)) state.editingConferenceId = null;
    state.conferences.splice(idx, 1);
  } else if (action === 'publish') {
    state.conferences[idx].status = 'published';
  } else if (action === 'archive') {
    state.conferences[idx].status = 'archived';
  } else if (action === 'draft') {
    state.conferences[idx].status = 'draft';
  }

  saveConferences();
  renderConferences();
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

  conferenceForm?.addEventListener('submit', handleConferenceSubmit);
  conferenceForm?.addEventListener('reset', () => {
    state.editingConferenceId = null;
    window.setTimeout(updateConferenceEditorUI, 0);
  });
  conferenceCancelEdit?.addEventListener('click', cancelEditingConference);
  conferenceList?.addEventListener('click', handleConferenceAction);

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
  const currentHash = window.location.hash || '#news-section';
  navLinks.forEach((link) => {
    const isActive = link.getAttribute('href') === currentHash;
    link.classList.toggle('active', isActive);
  });
}
window.addEventListener('hashchange', updateActiveNavLink);
window.addEventListener('load', updateActiveNavLink);

renderAll();
bindEvents();
setupRichEditorToolbars();
updateActiveNavLink();
fetchNewsFromDatabase();
fetchActivitiesFromDatabase();
checkNewsDraft(null);

setupImageUpload('news');
setupImageUpload('activity');
setupImageUpload('conference');

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
conferenceForm?.addEventListener('reset', () => {
  window.setTimeout(() => {
    document.querySelector('[data-upload-zone="conference"]')?._clearImage?.();
  }, 0);
});
