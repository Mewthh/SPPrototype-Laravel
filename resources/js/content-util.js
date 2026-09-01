const SPP_STORAGE_KEY = 'spp-admin-posts-v3';

const DEFAULT_POSTS_DATA = [
  {
    id: 'post-n1',
    type: 'announcement',
    title: 'sample text',
    slug: 'sample-text-n1',
    section: 'News',
    status: 'published',
    publishDate: '2026-08-19',
    summary: 'sample text.',
    body: 'sample text.',
    featured: true
  },
  {
    id: 'post-n2',
    type: 'announcement',
    title: 'sample text',
    slug: 'sample-text-n2',
    section: 'News',
    status: 'scheduled',
    publishDate: '2026-08-25',
    summary: 'sample text.',
    body: 'sample text.',
    featured: true
  },
  {
    id: 'post-n3',
    type: 'announcement',
    title: 'sample text',
    slug: 'sample-text-n3',
    section: 'News',
    status: 'draft',
    publishDate: '2026-08-10',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false
  },
  {
    id: 'post-n4',
    type: 'announcement',
    title: 'sample text',
    slug: 'sample-text-n4',
    section: 'News',
    status: 'archived',
    publishDate: '2026-07-20',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false
  },
  {
    id: 'post-n5',
    type: 'announcement',
    title: 'sample text',
    slug: 'sample-text-n5',
    section: 'News',
    status: 'published',
    publishDate: '2026-08-01',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false
  },
  {
    id: 'post-n6',
    type: 'announcement',
    title: 'sample text',
    slug: 'sample-text-n6',
    section: 'News',
    status: 'draft',
    publishDate: '2026-07-28',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false
  },
  {
    id: 'post-n7',
    type: 'announcement',
    title: 'sample text',
    slug: 'sample-text-n7',
    section: 'News',
    status: 'archived',
    publishDate: '2026-06-15',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false
  },
  {
    id: 'post-a1',
    type: 'event',
    title: 'sample text',
    slug: 'sample-text-a1',
    section: 'Activities',
    status: 'scheduled',
    publishDate: '2026-08-28',
    summary: 'sample text.',
    body: 'sample text.',
    featured: true
  },
  {
    id: 'post-a2',
    type: 'event',
    title: 'sample text',
    slug: 'sample-text-a2',
    section: 'Activities',
    status: 'published',
    publishDate: '2026-08-22',
    summary: 'sample text.',
    body: 'sample text.',
    featured: true
  },
  {
    id: 'post-a3',
    type: 'event',
    title: 'sample text',
    slug: 'sample-text-a3',
    section: 'Activities',
    status: 'draft',
    publishDate: '2026-08-16',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false
  },
  {
    id: 'post-a4',
    type: 'event',
    title: 'sample text',
    slug: 'sample-text-a4',
    section: 'Activities',
    status: 'archived',
    publishDate: '2026-07-10',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false
  },
  {
    id: 'post-a5',
    type: 'event',
    title: 'sample text',
    slug: 'sample-text-a5',
    section: 'Activities',
    status: 'scheduled',
    publishDate: '2026-08-04',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false
  },
  {
    id: 'post-a6',
    type: 'event',
    title: 'sample text',
    slug: 'sample-text-a6',
    section: 'Activities',
    status: 'published',
    publishDate: '2026-07-25',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false
  },
  {
    id: 'post-a7',
    type: 'event',
    title: 'sample text',
    slug: 'sample-text-a7',
    section: 'Activities',
    status: 'archived',
    publishDate: '2026-06-01',
    summary: 'sample text.',
    body: 'sample text.',
    featured: false
  }
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
  if (item.slug && String(item.slug).trim()) {
    return String(item.slug).trim();
  }
  const fromTitle = generateSlug(item.title);
  if (fromTitle) return fromTitle;
  return item.id || '';
}

function isContentVisible(item) {
  if (!item) return false;
  const status = item.status || 'draft';
  if (status === 'published') {
    return true;
  }
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
  return new Intl.DateTimeFormat('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric'
  }).format(date);
}

function getItemExcerpt(item, maxLength = 140) {
  if (!item) return '';
  const excerpt = item.excerpt || item.summary;
  if (excerpt && String(excerpt).trim()) {
    return String(excerpt).trim();
  }
  const content = item.content || item.body || '';
  const plainText = String(content).replace(/<[^>]*>/g, '').trim();
  if (!plainText) return '';
  if (plainText.length <= maxLength) {
    return plainText;
  }
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
