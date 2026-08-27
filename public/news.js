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

function renderInlineMarkdown(text) {
  if (!text) return '';
  let html = escapeHtml(text);
  html = html.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
  html = html.replace(/\*(.+?)\*/g, '<em>$1</em>');
  html = html.replace(/\+\+(.+?)\+\+/g, '<u>$1</u>');
  html = html.replace(/&lt;u&gt;([\s\S]*?)&lt;\/u&gt;/gi, '<u>$1</u>');
  html = html.replace(/==(.+?)==/g, '<mark>$1</mark>');
  html = html.replace(/(?<!~)(?<!\\)~([^~\n]+)~(?!~)/g, '<sub>$1</sub>');
  html = html.replace(/(?<!\^)(?<!\\)\^([^\^\n]+)\^(?!\^)/g, '<sup>$1</sup>');
  html = html.replace(/`([^`]+)`/g, '<code>$1</code>');
  html = html.replace(/!\[(.*?)\]\((.*?)\)/g, '<img src="$2" alt="$1" />');
  html = html.replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" target="_blank" rel="noopener noreferrer">$1</a>');
  html = html.replace(/^#{1,6}\s+/, '');
  return html;
}

function renderMarkdown(text) {
  if (!text) return '';
  let html = escapeHtml(text);

  // Inline formatting
  html = html.replace(/```([\s\S]*?)```/g, '<pre><code>$1</code></pre>');
  html = html.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
  html = html.replace(/\*(.+?)\*/g, '<em>$1</em>');
  html = html.replace(/\+\+(.+?)\+\+/g, '<u>$1</u>');
  html = html.replace(/&lt;u&gt;([\s\S]*?)&lt;\/u&gt;/gi, '<u>$1</u>');
  html = html.replace(/==(.+?)==/g, '<mark>$1</mark>');
  html = html.replace(/(?<!~)(?<!\\)~([^~\n]+)~(?!~)/g, '<sub>$1</sub>');
  html = html.replace(/(?<!\^)(?<!\\)\^([^\^\n]+)\^(?!\^)/g, '<sup>$1</sup>');
  html = html.replace(/`([^`]+)`/g, '<code>$1</code>');
  html = html.replace(/!\[(.*?)\]\((.*?)\)/g, '<img src="$2" alt="$1" />');
  html = html.replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" target="_blank" rel="noopener noreferrer">$1</a>');

  // Footnote references [^1]
  html = html.replace(/\[\^(\d+)\]/g, '<sup><a href="#fn-$1" id="fnref-$1">[$1]</a></sup>');

  const blocks = html.split(/\n\s*\n/).map((b) => b.trim()).filter(Boolean);
  if (!blocks.length) return `<p>${html}</p>`;

  const footnotes = [];

  const renderedBlocks = blocks.map((block) => {
    // If it's a preformatted code block
    if (block.startsWith('<pre>') && block.endsWith('</pre>')) {
      return block;
    }

    // Horizontal rule
    if (/^(\-{3,}|\*{3,}|_{3,})$/.test(block.trim())) {
      return '<hr>';
    }

    // Footnote definition [^1]: content
    const fnDefMatch = block.match(/^\[\^(\d+)\]:\s*(.*)$/);
    if (fnDefMatch) {
      footnotes.push({ num: fnDefMatch[1], content: fnDefMatch[2] });
      return '';
    }

    const lines = block.split('\n').map((l) => l.trim()).filter(Boolean);
    if (!lines.length) return '';

    if (lines.length === 1 && lines[0].startsWith('# ')) {
      return `<h2>${lines[0].slice(2)}</h2>`;
    }
    if (lines.length === 1 && lines[0].startsWith('## ')) {
      return `<h3>${lines[0].slice(3)}</h3>`;
    }
    if (lines.every((l) => l.startsWith('- '))) {
      return `<ul>${lines.map((l) => `<li>${l.slice(2)}</li>`).join('')}</ul>`;
    }
    if (lines.every((l) => /^\d+\.\s+/.test(l))) {
      return `<ol>${lines.map((l) => `<li>${l.replace(/^\d+\.\s+/, '')}</li>`).join('')}</ol>`;
    }
    if (lines.every((l) => l.startsWith('&gt; ') || l.startsWith('> '))) {
      const inner = lines.map((l) => l.replace(/^(&gt;|>)\s?/, '')).join('<br>');
      return `<blockquote><p>${inner}</p></blockquote>`;
    }

    // Table parsing: lines starting/containing |
    if (lines.length >= 2 && lines.every((l) => l.startsWith('|') && l.endsWith('|'))) {
      const headerRow = lines[0].slice(1, -1).split('|').map((c) => `<th>${c.trim()}</th>`).join('');
      const bodyRows = lines.slice(2).map((row) => {
        const cells = row.slice(1, -1).split('|').map((c) => `<td>${c.trim()}</td>`).join('');
        return `<tr>${cells}</tr>`;
      }).join('');
      return `<table><thead><tr>${headerRow}</tr></thead><tbody>${bodyRows}</tbody></table>`;
    }

    return `<p>${lines.join('<br>')}</p>`;
  }).filter(Boolean);

  if (footnotes.length > 0) {
    const fnHtml = `
      <section class="footnotes">
        <ol>
          ${footnotes.map((fn) => `<li id="fn-${fn.num}">${fn.content} <a href="#fnref-${fn.num}">↩</a></li>`).join('')}
        </ol>
      </section>
    `;
    renderedBlocks.push(fnHtml);
  }

  return renderedBlocks.join('');
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
        <h1 class="article-title">${renderInlineMarkdown(post.title)}</h1>
      </header>

      <div class="article-hero-media">
        <img src="${imageSrc}" alt="${escapeHtml(post.title)}" />
      </div>

      <div class="article-body">
        ${renderMarkdown(fullContent)}
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
