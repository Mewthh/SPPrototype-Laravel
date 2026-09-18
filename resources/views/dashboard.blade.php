<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>SPP Admin Dashboard</title>

	<script>
		(function () {
			const saved = localStorage.getItem('spp-theme');
			const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
			const theme = saved || (prefersDark ? 'dark' : 'light');
			document.documentElement.setAttribute('data-theme', theme);
			if (theme === 'dark') {
				document.documentElement.classList.add('dark');
			} else {
				document.documentElement.classList.remove('dark');
			}
		})();
	</script>

	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<script
		src="{{ asset('admin/app.js') }}?v={{ file_exists(public_path('admin/app.js')) ? filemtime(public_path('admin/app.js')) : time() }}"
		defer></script>
</head>

<body>
	<!-- Admin UI Loading Screen -->
	<div id="admin-loading-screen" class="admin-loading-overlay" role="status" aria-live="polite"
		aria-label="Loading Admin Dashboard">
		<div class="admin-loading-card">
			<div class="admin-loading-spinner-wrap" aria-hidden="true">
				<div class="admin-loading-spinner-glow"></div>
				<div class="admin-loading-spinner-outer"></div>
				<div class="admin-loading-spinner-inner"></div>
			</div>
			<p class="admin-loading-status" id="admin-loading-text">Loading...</p>
		</div>
	</div>

	<a class="skip-link" href="#main-content">Skip to content</a>

	<!-- Global Floating Toast Notification (Center Top) -->
	<div id="admin-floating-toast" class="floating-toast-container is-hidden" role="status" aria-live="polite" data-success-message="{{ session('status') }}">
		<div class="floating-toast-card">
			<span class="floating-toast-icon" aria-hidden="true">&#x2714;</span>
			<div class="floating-toast-content">
				<span class="floating-toast-message" id="admin-floating-toast-message">Saved successfully.</span>
			</div>
			<button type="button" class="floating-toast-close" id="admin-floating-toast-close" aria-label="Dismiss notification">&times;</button>
		</div>
	</div>

	<div class="dashboard-shell">
		<header class="mobile-topbar" data-mobile-header>
			<div class="topbar-inner" style="justify-content: space-between;">
				<div style="display: flex; align-items: center; gap: 10px;">
					<button class="menu-toggle" type="button" aria-label="Toggle menu" data-menu-toggle>
						<span class="menu-toggle-icon" aria-hidden="true">&#x2630;</span>
					</button>
					<div class="mobile-brand">SPP Admin</div>
				</div>
				@auth
					<form method="POST" action="{{ route('logout') }}" style="margin: 0;">
						@csrf
						<button type="submit" class="ghost-button"
							style="padding: 6px 12px; height: 36px; min-height: 36px; font-size: 0.8rem; color: var(--danger); border-color: rgba(220, 53, 69, 0.25);"
							aria-label="Log out">
							<span>Log Out</span>
						</button>
					</form>
				@endauth
			</div>
		</header>

		<aside class="dashboard-sidebar" data-sidebar>
			<button class="menu-close" type="button" aria-label="Close menu" data-menu-close>&#x00D7;</button>
			<div class="brand-block">
				<div class="brand-mark" aria-hidden="true">SPP</div>
				<div class="brand-copy">
					<p class="eyebrow">Admin</p>
					<h1>Samahang Pisika ng Pilipinas</h1>
				</div>
			</div>

			<nav class="dashboard-nav" aria-label="Dashboard sections">
				<div class="nav-section-label">Bulletins</div>
				<a href="#news-section" class="nav-item" data-nav-link>
					<span class="nav-icon" aria-hidden="true">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
							stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10l5 5v11a2 2 0 0 1-2 2z"></path>
							<polyline points="14 2 14 8 20 8"></polyline>
							<line x1="16" y1="13" x2="8" y2="13"></line>
							<line x1="16" y1="17" x2="8" y2="17"></line>
						</svg>
					</span>
					<span class="nav-text">News</span>
					<span class="nav-badge" data-news-count-badge>0</span>
				</a>
				<a href="#activities-section" class="nav-item" data-nav-link>
					<span class="nav-icon" aria-hidden="true">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
							stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
							<line x1="16" y1="2" x2="16" y2="6"></line>
							<line x1="8" y1="2" x2="8" y2="6"></line>
							<line x1="3" y1="10" x2="21" y2="10"></line>
						</svg>
					</span>
					<span class="nav-text">Activities</span>
					<span class="nav-badge" data-activity-count-badge>0</span>
				</a>
				<a href="#conferences-section" class="nav-item" data-nav-link>
					<span class="nav-icon" aria-hidden="true">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
							stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
							<path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
						</svg>
					</span>
					<span class="nav-text">Conferences</span>
					<span class="nav-badge" data-conference-count-badge>0</span>
				</a>
				<a href="#downloads-section" class="nav-item" data-nav-link>
					<span class="nav-icon" aria-hidden="true">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
							stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
							<polyline points="7 10 12 15 17 10"></polyline>
							<line x1="12" y1="15" x2="12" y2="3"></line>
						</svg>
					</span>
					<span class="nav-text">Downloads</span>
					<span class="nav-badge" data-downloads-count-badge>19</span>
				</a>
				<a href="#videos-section" class="nav-item" data-nav-link>
					<span class="nav-icon" aria-hidden="true">&#x25B6;</span>
					<span class="nav-text">Videos &amp; Webinars</span>
					<span class="nav-badge" data-videos-count-badge>12</span>
				</a>
				<a href="#membership-faq-section" class="nav-item" data-nav-link>
					<span class="nav-icon" aria-hidden="true">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
							stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<circle cx="12" cy="12" r="10"></circle>
							<path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
							<line x1="12" y1="17" x2="12.01" y2="17"></line>
						</svg>
					</span>
					<span class="nav-text">Membership FAQ</span>
					<span class="nav-badge" data-faq-count-badge style="background: var(--accent-strong); color: var(--surface);">7</span>
				</a>
				<div class="nav-section-label" style="margin-top: 1.25rem;">Site Settings</div>
				<a href="#about-section" class="nav-item" data-nav-link>
					<span class="nav-icon" aria-hidden="true">ⓘ</span>
					<span class="nav-text">About SPP</span>
				</a>
				<a href="#hero-banner-section" class="nav-item" data-nav-link>
					<span class="nav-icon" aria-hidden="true">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
							stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
							<circle cx="8.5" cy="8.5" r="1.5"></circle>
							<polyline points="21 15 16 10 5 21"></polyline>
						</svg>
					</span>
					<span class="nav-text">Banner Image</span>
				</a>
			</nav>

			<div class="sidebar-footer">
				@auth
					<div
						style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; background: var(--surface-soft); border-radius: var(--radius-md); border: 1px solid var(--border); font-size: 0.85rem;">
						<div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
							<div style="font-weight: 700; color: var(--accent-strong); font-size: 0.88rem;">
								{{ auth()->user()->name }}
							</div>
							<div style="color: var(--muted); font-size: 0.78rem;">{{ auth()->user()->email }}</div>
						</div>
						<span
							style="background: #1b7a4c; color: #fff; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; padding: 2px 7px; border-radius: var(--radius-pill); letter-spacing: 0.04em;">Admin</span>
					</div>
				@endauth

				<a class="ghost-button" href="{{ route('home') }}" aria-label="Go to user side">
					<span aria-hidden="true">&#x2302;</span>
					<span>Go to User Side</span>
				</a>

				@auth
					<form method="POST" action="{{ route('logout') }}" style="margin: 0;">
						@csrf
						<button type="submit" class="ghost-button"
							style="color: var(--danger); border-color: rgba(220, 53, 69, 0.25);"
							aria-label="Log out of admin session">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
								stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
								<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
								<polyline points="16 17 21 12 16 7"></polyline>
								<line x1="21" y1="12" x2="9" y2="12"></line>
							</svg>
							<span>Log Out</span>
						</button>
					</form>
				@endauth
			</div>
		</aside>

		<main id="main-content" class="dashboard-main">
			<section class="panel editor-panel" id="news-section">
				<div class="panel-view is-hidden" data-news-view="editor">
					<div class="section-panel-head">
						<div>
							<p class="panel-kicker">News Management</p>
							<h2>News Editor</h2>
						</div>
						<div>
							<button type="button" class="button button-secondary" data-show-news-posts>
								View News Posts (<span data-news-count-badge>0</span>)
							</button>
						</div>
					</div>

					<form class="compose-form" data-news-form>
						<div class="editor-status-banner" data-news-banner>
							<span data-news-banner-text>Create New News Post</span>
							<button type="button" class="item-action" data-news-cancel-edit
								style="display: none;">Cancel Edit</button>
						</div>

						<!-- Draft Recovery Banner -->
						<div class="draft-recovery-banner is-hidden" data-draft-banner="news" role="alert">
							<div class="draft-recovery-info">
								<span class="draft-icon" aria-hidden="true">&#x26A0;</span>
								<div class="draft-copy">
									<strong>Unsaved draft found</strong>
									<span class="draft-timestamp" data-draft-time="news"></span>
								</div>
							</div>
							<div class="draft-recovery-actions">
								<button type="button" class="button button-secondary draft-btn-restore"
									data-draft-restore="news">Restore Draft</button>
								<button type="button" class="button button-quiet draft-btn-discard"
									data-draft-discard="news">Discard</button>
							</div>
						</div>

						<input type="hidden" name="editingId" value="" />

						<label class="field-row">
							<span>Status</span>
							<select name="status">
								<option value="draft">Draft</option>
								<option value="published" selected>Published</option>
								<option value="scheduled">Scheduled</option>
								<option value="archived">Archived</option>
							</select>
						</label>

						<label class="field-row">
							<span>Title <small style="font-weight: 400; opacity: 0.6;">(max 100 chars)</small></span>
							<input type="text" name="title" placeholder="News title..." required maxlength="100" />
						</label>

						<label class="field-row">
							<span>Summary <small style="font-weight: 400; opacity: 0.6;">(max 200 chars)</small></span>
							<textarea name="summary" rows="2" placeholder="Brief summary of the article..."
								maxlength="200"></textarea>
						</label>

						<label class="field-row">
							<span>Publish date</span>
							<input type="date" name="publishDate" />
						</label>

						<div class="field-row field-row-wide">
							<span class="field-label">Article Body</span>
							<div class="rich-editor-wrap" data-rich-editor="body">
								<div class="editor-toolbar" role="toolbar" aria-label="Article body formatting toolbar">
									<button type="button" class="toolbar-btn" data-format="bold" title="Bold (**text**)"
										aria-label="Bold"><strong>B</strong></button>
									<button type="button" class="toolbar-btn" data-format="italic"
										title="Italic (*text*)" aria-label="Italic"><em>I</em></button>
									<button type="button" class="toolbar-btn" data-format="underline"
										title="Underline (<u>text</u>)" aria-label="Underline"><u>U</u></button>
									<button type="button" class="toolbar-btn" data-format="h1"
										title="Heading 1 (# Title)" aria-label="Heading 1">H1</button>
									<button type="button" class="toolbar-btn" data-format="h2"
										title="Heading 2 (## Subtitle)" aria-label="Heading 2">H2</button>
									<button type="button" class="toolbar-btn" data-format="ul"
										title="Bullet List (- item)" aria-label="Bullet List"><svg width="15"
											height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
											stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
											aria-hidden="true">
											<line x1="8" y1="6" x2="21" y2="6"></line>
											<line x1="8" y1="12" x2="21" y2="12"></line>
											<line x1="8" y1="18" x2="21" y2="18"></line>
											<circle cx="3.5" cy="6" r="1.5" fill="currentColor"></circle>
											<circle cx="3.5" cy="12" r="1.5" fill="currentColor"></circle>
											<circle cx="3.5" cy="18" r="1.5" fill="currentColor"></circle>
										</svg></button>
									<button type="button" class="toolbar-btn" data-format="ol"
										title="Numbered List (1. item)" aria-label="Numbered List"><svg width="15"
											height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
											stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
											aria-hidden="true">
											<line x1="10" y1="6" x2="21" y2="6"></line>
											<line x1="10" y1="12" x2="21" y2="12"></line>
											<line x1="10" y1="18" x2="21" y2="18"></line>
											<path d="M4 6h1v4M4 10h2" stroke-width="1.6"></path>
											<path d="M4 14h2a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H4v1h3" stroke-width="1.6">
											</path>
										</svg></button>
									<button type="button" class="toolbar-btn" data-format="blockquote"
										title="Blockquote (> text)" aria-label="Blockquote"><svg width="15" height="15"
											viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
											stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
											<path
												d="M3 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2H4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2 0 4-1 6-1 8z"
												fill="currentColor" stroke="none"></path>
											<path
												d="M15 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2h-4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2 0 4-1 6-1 8z"
												fill="currentColor" stroke="none"></path>
										</svg></button>
									<button type="button" class="toolbar-btn" data-format="code"
										title="Inline code (`code`)" aria-label="Code">&lt;/&gt;</button>
									<button type="button" class="toolbar-btn" data-format="hr"
										title="Horizontal rule (---)" aria-label="Horizontal Rule">&#x2014;</button>
									<button type="button" class="toolbar-btn" data-format="link"
										title="Link ([text](url))" aria-label="Link">&#x1F517;</button>
									<button type="button" class="toolbar-btn" data-format="image"
										title="Image (![alt](url))" aria-label="Image">&#x1F5BC;</button>
									<button type="button" class="toolbar-btn" data-format="table" title="Insert table"
										aria-label="Table"><svg width="15" height="15" viewBox="0 0 24 24" fill="none"
											stroke="currentColor" stroke-width="2" stroke-linecap="round"
											stroke-linejoin="round" aria-hidden="true">
											<rect x="3" y="3" width="18" height="18" rx="2"></rect>
											<line x1="3" y1="9" x2="21" y2="9"></line>
											<line x1="3" y1="15" x2="21" y2="15"></line>
											<line x1="9" y1="3" x2="9" y2="21"></line>
											<line x1="15" y1="3" x2="15" y2="21"></line>
										</svg></button>
									<button type="button" class="toolbar-btn" data-format="footnote"
										title="Footnote ([^1])" aria-label="Footnote">fn</button>
									<button type="button" class="toolbar-btn" data-format="highlight"
										title="Highlight (==text==)" aria-label="Highlight"><svg width="15" height="15"
											viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
											stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
											<path d="m9 11-6 6v3h3l6-6"></path>
											<path
												d="m22 7-4.5-4.5a2.12 2.12 0 0 0-3 0L10 7l7 7 4.5-4.5a2.12 2.12 0 0 0 0-3z">
											</path>
											<line x1="14" y1="20" x2="22" y2="20" stroke-width="2.5" stroke="#f59e0b">
											</line>
										</svg></button>
									<button type="button" class="toolbar-btn" data-format="sub"
										title="Subscript (~text~)" aria-label="Subscript">X<sub>2</sub></button>
									<button type="button" class="toolbar-btn" data-format="sup"
										title="Superscript (^text^)" aria-label="Superscript">X<sup>2</sup></button>
								</div>
								<textarea name="body" rows="8" placeholder="Type article content here..."></textarea>
							</div>
						</div>

						<div class="field-row field-row-wide">
							<span class="field-label">Cover Image</span>
							<div class="image-upload-zone" id="news-image-zone" data-upload-zone="news" tabindex="0"
								role="button" aria-label="Click or drag an image here to upload">
								<div class="image-upload-placeholder" data-upload-placeholder="news">
									<span class="upload-icon" aria-hidden="true">&#x1F5BC;</span>
									<span>Click to upload or drag &amp; drop</span>
									<small>PNG, JPG, GIF, WebP &mdash; max 5 MB</small>
								</div>
								<img class="image-upload-preview is-hidden" data-upload-preview="news"
									alt="Cover image preview" />
								<input type="file" name="coverImage" accept="image/*" class="image-upload-input"
									data-upload-input="news" aria-label="Upload cover image" />
							</div>
							<div class="image-upload-actions is-hidden" data-upload-actions="news">
								<span class="image-upload-filename" data-upload-filename="news"></span>
								<button type="button" class="item-action danger" data-upload-clear="news">Remove
									image</button>
							</div>
						</div>

						<div class="form-actions">
							<button type="submit" class="button button-primary" data-news-submit-primary>Save &
								Publish</button>
							<button type="submit" class="button button-secondary" data-status-override="draft"
								data-news-submit-secondary>Save as Draft</button>
							<button type="reset" class="button button-quiet">Reset</button>
						</div>
					</form>
				</div>

				<div class="panel-view" data-news-view="posts">
					<div class="section-panel-head">
						<div>
							<p class="panel-kicker">News Management</p>
							<h2>All News Posts</h2>
						</div>
						<div>
							<button type="button" class="button button-primary" data-show-news-editor style="gap: 6px;">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
									stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
									aria-hidden="true">
									<line x1="12" y1="5" x2="12" y2="19"></line>
									<line x1="5" y1="12" x2="19" y2="12"></line>
								</svg>
								Create
							</button>
						</div>
					</div>

					<div class="posts-view-wrapper">
						<div class="queue-toolbar">
							<div class="queue-filters" aria-label="News filters">
								<button type="button" class="filter-tab active" data-news-filter="all">All (<span
										data-news-filter-all-count>0</span>)</button>
								<button type="button" class="filter-tab" data-news-filter="published">Published (<span
										data-news-filter-published-count>0</span>)</button>
								<button type="button" class="filter-tab" data-news-filter="scheduled">Scheduled (<span
										data-news-filter-scheduled-count>0</span>)</button>
								<button type="button" class="filter-tab" data-news-filter="draft">Drafts (<span
										data-news-filter-draft-count>0</span>)</button>
								<button type="button" class="filter-tab" data-news-filter="archived">Archived (<span
										data-news-filter-archived-count>0</span>)</button>
							</div>
						</div>

						<div class="queue-table-head" aria-hidden="true">
							<span>Title & Summary</span>
							<span>Status</span>
							<span>Date</span>
							<span>Actions</span>
						</div>

						<div class="queue-list" data-news-list></div>

						<div class="queue-pagination" data-news-pagination style="display: none;">
							<span class="pagination-info" data-news-pagination-info>Showing 3 of 8 posts</span>
							<div class="queue-pagination-actions"
								style="display: flex; gap: 10px; align-items: center;">
								<button type="button" class="button button-secondary" data-news-load-more>Show
									More</button>
								<button type="button" class="button button-secondary" data-news-show-less
									style="display: none;">Show Less</button>
							</div>
						</div>
					</div>
				</div>
			</section>

			<section class="panel editor-panel" id="activities-section">
				<div class="panel-view is-hidden" data-activity-view="editor">
					<div class="section-panel-head">
						<div>
							<p class="panel-kicker">Activities Management</p>
							<h2>Activities Editor</h2>
						</div>
						<div>
							<button type="button" class="button button-secondary" data-show-activity-posts>
								View Activities Posts (<span data-activity-count-badge>0</span>)
							</button>
						</div>
					</div>

					<form class="compose-form" data-activity-form>
						<div class="editor-status-banner" data-activity-banner>
							<span data-activity-banner-text>Create New Activity</span>
							<button type="button" class="item-action" data-activity-cancel-edit
								style="display: none;">Cancel Edit</button>
						</div>

						<input type="hidden" name="editingId" value="" />

						<label class="field-row">
							<span>Status</span>
							<select name="status">
								<option value="scheduled" selected>Scheduled</option>
								<option value="published">Published</option>
								<option value="draft">Draft</option>
								<option value="archived">Archived</option>
							</select>
						</label>

						<label class="field-row">
							<span>Activity Title <small style="font-weight: 400; opacity: 0.6;">(max 100
									chars)</small></span>
							<input type="text" name="title" placeholder="Activity title..." required maxlength="100" />
						</label>

						<label class="field-row">
							<span>Summary <small style="font-weight: 400; opacity: 0.6;">(max 200 chars)</small></span>
							<textarea name="summary" rows="2" placeholder="Brief activity description..."
								maxlength="200"></textarea>
						</label>

						<label class="field-row">
							<span>Event Date</span>
							<input type="date" name="publishDate" />
						</label>

						<div class="field-row field-row-wide">
							<span class="field-label">Event Details</span>
							<div class="rich-editor-wrap" data-rich-editor="activity-body">
								<div class="editor-toolbar" role="toolbar"
									aria-label="Event details formatting toolbar">
									<button type="button" class="toolbar-btn" data-format="bold" title="Bold (**text**)"
										aria-label="Bold"><strong>B</strong></button>
									<button type="button" class="toolbar-btn" data-format="italic"
										title="Italic (*text*)" aria-label="Italic"><em>I</em></button>
									<button type="button" class="toolbar-btn" data-format="underline"
										title="Underline (<u>text</u>)" aria-label="Underline"><u>U</u></button>
									<button type="button" class="toolbar-btn" data-format="h1"
										title="Heading 1 (# Title)" aria-label="Heading 1">H1</button>
									<button type="button" class="toolbar-btn" data-format="h2"
										title="Heading 2 (## Subtitle)" aria-label="Heading 2">H2</button>
									<button type="button" class="toolbar-btn" data-format="ul"
										title="Bullet List (- item)" aria-label="Bullet List"><svg width="15"
											height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
											stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
											aria-hidden="true">
											<line x1="8" y1="6" x2="21" y2="6"></line>
											<line x1="8" y1="12" x2="21" y2="12"></line>
											<line x1="8" y1="18" x2="21" y2="18"></line>
											<circle cx="3.5" cy="6" r="1.5" fill="currentColor"></circle>
											<circle cx="3.5" cy="12" r="1.5" fill="currentColor"></circle>
											<circle cx="3.5" cy="18" r="1.5" fill="currentColor"></circle>
										</svg></button>
									<button type="button" class="toolbar-btn" data-format="ol"
										title="Numbered List (1. item)" aria-label="Numbered List"><svg width="15"
											height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
											stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
											aria-hidden="true">
											<line x1="10" y1="6" x2="21" y2="6"></line>
											<line x1="10" y1="12" x2="21" y2="12"></line>
											<line x1="10" y1="18" x2="21" y2="18"></line>
											<path d="M4 6h1v4M4 10h2" stroke-width="1.6"></path>
											<path d="M4 14h2a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H4v1h3" stroke-width="1.6">
											</path>
										</svg></button>
									<button type="button" class="toolbar-btn" data-format="blockquote"
										title="Blockquote (> text)" aria-label="Blockquote"><svg width="15" height="15"
											viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
											stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
											<path
												d="M3 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2H4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2 0 4-1 6-1 8z"
												fill="currentColor" stroke="none"></path>
											<path
												d="M15 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2h-4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2 0 4-1 6-1 8z"
												fill="currentColor" stroke="none"></path>
										</svg></button>
									<button type="button" class="toolbar-btn" data-format="code"
										title="Inline code (`code`)" aria-label="Code">&lt;/&gt;</button>
									<button type="button" class="toolbar-btn" data-format="hr"
										title="Horizontal rule (---)" aria-label="Horizontal Rule">&#x2014;</button>
									<button type="button" class="toolbar-btn" data-format="link"
										title="Link ([text](url))" aria-label="Link">&#x1F517;</button>
									<button type="button" class="toolbar-btn" data-format="image"
										title="Image (![alt](url))" aria-label="Image">&#x1F5BC;</button>
									<button type="button" class="toolbar-btn" data-format="table" title="Insert table"
										aria-label="Table"><svg width="15" height="15" viewBox="0 0 24 24" fill="none"
											stroke="currentColor" stroke-width="2" stroke-linecap="round"
											stroke-linejoin="round" aria-hidden="true">
											<rect x="3" y="3" width="18" height="18" rx="2"></rect>
											<line x1="3" y1="9" x2="21" y2="9"></line>
											<line x1="3" y1="15" x2="21" y2="15"></line>
											<line x1="9" y1="3" x2="9" y2="21"></line>
											<line x1="15" y1="3" x2="15" y2="21"></line>
										</svg></button>
									<button type="button" class="toolbar-btn" data-format="footnote"
										title="Footnote ([^1])" aria-label="Footnote">fn</button>
									<button type="button" class="toolbar-btn" data-format="highlight"
										title="Highlight (==text==)" aria-label="Highlight"><svg width="15" height="15"
											viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
											stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
											<path d="m9 11-6 6v3h3l6-6"></path>
											<path
												d="m22 7-4.5-4.5a2.12 2.12 0 0 0-3 0L10 7l7 7 4.5-4.5a2.12 2.12 0 0 0 0-3z">
											</path>
											<line x1="14" y1="20" x2="22" y2="20" stroke-width="2.5" stroke="#f59e0b">
											</line>
										</svg></button>
									<button type="button" class="toolbar-btn" data-format="sub"
										title="Subscript (~text~)" aria-label="Subscript">X<sub>2</sub></button>
									<button type="button" class="toolbar-btn" data-format="sup"
										title="Superscript (^text^)" aria-label="Superscript">X<sup>2</sup></button>
								</div>
								<textarea name="body" rows="6" placeholder="Type event details here..."></textarea>
							</div>
						</div>

						<div class="field-row field-row-wide">
							<span class="field-label">Cover Image</span>
							<div class="image-upload-zone" id="activity-image-zone" data-upload-zone="activity"
								tabindex="0" role="button" aria-label="Click or drag an image here to upload">
								<div class="image-upload-placeholder" data-upload-placeholder="activity">
									<span class="upload-icon" aria-hidden="true">&#x1F5BC;</span>
									<span>Click to upload or drag &amp; drop</span>
									<small>PNG, JPG, GIF, WebP &mdash; max 5 MB</small>
								</div>
								<img class="image-upload-preview is-hidden" data-upload-preview="activity"
									alt="Cover image preview" />
								<input type="file" name="coverImage" accept="image/*" class="image-upload-input"
									data-upload-input="activity" aria-label="Upload cover image" />
							</div>
							<div class="image-upload-actions is-hidden" data-upload-actions="activity">
								<span class="image-upload-filename" data-upload-filename="activity"></span>
								<button type="button" class="item-action danger" data-upload-clear="activity">Remove
									image</button>
							</div>
						</div>

						<div class="form-actions">
							<button type="submit" class="button button-primary" data-activity-submit-primary>Save &
								Publish</button>
							<button type="submit" class="button button-secondary" data-status-override="scheduled"
								data-activity-submit-secondary>Save as Scheduled</button>
							<button type="reset" class="button button-quiet">Reset</button>
						</div>
					</form>
				</div>

				<div class="panel-view" data-activity-view="posts">
					<div class="section-panel-head">
						<div>
							<p class="panel-kicker">Activities Management</p>
							<h2>All Activities</h2>
						</div>
						<div>
							<button type="button" class="button button-primary" data-show-activity-editor
								style="gap: 6px;">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
									stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
									aria-hidden="true">
									<line x1="12" y1="5" x2="12" y2="19"></line>
									<line x1="5" y1="12" x2="19" y2="12"></line>
								</svg>
								Create
							</button>
						</div>
					</div>

					<div class="posts-view-wrapper">
						<div class="queue-toolbar">
							<div class="queue-filters" aria-label="Activity filters">
								<button type="button" class="filter-tab active" data-activity-filter="all">All (<span
										data-activity-filter-all-count>0</span>)</button>
								<button type="button" class="filter-tab" data-activity-filter="published">Published
									(<span data-activity-filter-published-count>0</span>)</button>
								<button type="button" class="filter-tab" data-activity-filter="scheduled">Scheduled
									(<span data-activity-filter-scheduled-count>0</span>)</button>
								<button type="button" class="filter-tab" data-activity-filter="draft">Drafts (<span
										data-activity-filter-draft-count>0</span>)</button>
								<button type="button" class="filter-tab" data-activity-filter="archived">Archived (<span
										data-activity-filter-archived-count>0</span>)</button>
							</div>
						</div>

						<div class="queue-table-head" aria-hidden="true">
							<span>Title & Summary</span>
							<span>Status</span>
							<span>Date</span>
							<span>Actions</span>
						</div>

						<div class="queue-list" data-activity-list></div>

						<div class="queue-pagination" data-activity-pagination style="display: none;">
							<span class="pagination-info" data-activity-pagination-info>Showing 3 of 8 posts</span>
							<div class="queue-pagination-actions"
								style="display: flex; gap: 10px; align-items: center;">
								<button type="button" class="button button-secondary" data-activity-load-more>Show
									More</button>
								<button type="button" class="button button-secondary" data-activity-show-less
									style="display: none;">Show Less</button>
							</div>
						</div>
					</div>
				</div>
			</section>

			<section class="panel editor-panel" id="conferences-section">
				<div class="panel-view is-hidden" data-conference-view="editor">
					<div class="section-panel-head">
						<div>
							<p class="panel-kicker">Conference Management</p>
							<h2>Conference Editor</h2>
						</div>
						<div>
							<button type="button" class="button button-secondary" data-show-conference-list>
								View All Conferences (<span data-conference-count-badge>0</span>)
							</button>
						</div>
					</div>

					<form class="compose-form" data-conference-form>
						<div class="editor-status-banner" data-conference-banner>
							<span data-conference-banner-text>Create New Conference</span>
							<button type="button" class="item-action" data-conference-cancel-edit
								style="display: none;">Cancel Edit</button>
						</div>

						<input type="hidden" name="editingId" value="" />

						<label class="field-row">
							<span>Status</span>
							<select name="status">
								<option value="published" selected>Published</option>
								<option value="draft">Draft</option>
								<option value="archived">Archived</option>
							</select>
						</label>

						<label class="field-row">
							<span>Conference Name / Year <small style="font-weight: 400; opacity: 0.6;">(e.g. 2027 or SPP2027)</small></span>
							<input type="text" name="year" placeholder="e.g. 2027 or SPP2027" required />
						</label>

						<label class="field-row">
							<span>Conference Title <small style="font-weight: 400; opacity: 0.6;">(max 100
									chars)</small></span>
							<input type="text" name="title" placeholder="e.g. 44th SPP Physics Conference" required
								maxlength="100" />
						</label>

						<label class="field-row">
							<span>Theme / Subtitle</span>
							<input type="text" name="theme" placeholder="e.g. Physics Conference" />
						</label>

						<label class="field-row">
							<span>Location</span>
							<input type="text" name="location" placeholder="e.g. Los Banos, Laguna" />
						</label>

						<label class="field-row">
							<span>Dates</span>
							<input type="text" name="dates" placeholder="e.g. October 21-24, 2026" />
						</label>

						<label class="field-row">
							<span>Short Summary <small style="font-weight: 400; opacity: 0.6;">(max 200
									chars)</small></span>
							<textarea name="summary" rows="2" placeholder="Brief overview of the conference..."
								maxlength="200"></textarea>
						</label>

						<div class="field-row field-row-wide">
							<span class="field-label">Conference Details</span>
							<div class="rich-editor-wrap" data-rich-editor="conference-body">
								<div class="editor-toolbar" role="toolbar"
									aria-label="Conference details formatting toolbar">
									<button type="button" class="toolbar-btn" data-format="bold" title="Bold (**text**)"
										aria-label="Bold"><strong>B</strong></button>
									<button type="button" class="toolbar-btn" data-format="italic"
										title="Italic (*text*)" aria-label="Italic"><em>I</em></button>
									<button type="button" class="toolbar-btn" data-format="underline"
										title="Underline (<u>text</u>)" aria-label="Underline"><u>U</u></button>
									<button type="button" class="toolbar-btn" data-format="h1"
										title="Heading 1 (# Title)" aria-label="Heading 1">H1</button>
									<button type="button" class="toolbar-btn" data-format="h2"
										title="Heading 2 (## Subtitle)" aria-label="Heading 2">H2</button>
									<button type="button" class="toolbar-btn" data-format="ul"
										title="Bullet List (- item)" aria-label="Bullet List"><svg width="15"
											height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
											stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
											aria-hidden="true">
											<line x1="8" y1="6" x2="21" y2="6"></line>
											<line x1="8" y1="12" x2="21" y2="12"></line>
											<line x1="8" y1="18" x2="21" y2="18"></line>
											<circle cx="3.5" cy="6" r="1.5" fill="currentColor"></circle>
											<circle cx="3.5" cy="12" r="1.5" fill="currentColor"></circle>
											<circle cx="3.5" cy="18" r="1.5" fill="currentColor"></circle>
										</svg></button>
									<button type="button" class="toolbar-btn" data-format="ol"
										title="Numbered List (1. item)" aria-label="Numbered List"><svg width="15"
											height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
											stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
											aria-hidden="true">
											<line x1="10" y1="6" x2="21" y2="6"></line>
											<line x1="10" y1="12" x2="21" y2="12"></line>
											<line x1="10" y1="18" x2="21" y2="18"></line>
											<path d="M4 6h1v4M4 10h2" stroke-width="1.6"></path>
											<path d="M4 14h2a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H4v1h3" stroke-width="1.6">
											</path>
										</svg></button>
									<button type="button" class="toolbar-btn" data-format="blockquote"
										title="Blockquote (> text)" aria-label="Blockquote"><svg width="15" height="15"
											viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
											stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
											<path
												d="M3 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2H4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2 0 4-1 6-1 8z"
												fill="currentColor" stroke="none"></path>
											<path
												d="M15 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2h-4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2 0 4-1 6-1 8z"
												fill="currentColor" stroke="none"></path>
										</svg></button>
									<button type="button" class="toolbar-btn" data-format="code"
										title="Inline code (`code`)" aria-label="Code">&lt;/&gt;</button>
									<button type="button" class="toolbar-btn" data-format="hr"
										title="Horizontal rule (---)" aria-label="Horizontal Rule">&#x2014;</button>
									<button type="button" class="toolbar-btn" data-format="link"
										title="Link ([text](url))" aria-label="Link">&#x1F517;</button>
									<button type="button" class="toolbar-btn" data-format="image"
										title="Image (![alt](url))" aria-label="Image">&#x1F5BC;</button>
									<button type="button" class="toolbar-btn" data-format="table" title="Insert table"
										aria-label="Table"><svg width="15" height="15" viewBox="0 0 24 24" fill="none"
											stroke="currentColor" stroke-width="2" stroke-linecap="round"
											stroke-linejoin="round" aria-hidden="true">
											<rect x="3" y="3" width="18" height="18" rx="2"></rect>
											<line x1="3" y1="9" x2="21" y2="9"></line>
											<line x1="3" y1="15" x2="21" y2="15"></line>
											<line x1="9" y1="3" x2="9" y2="21"></line>
											<line x1="15" y1="3" x2="15" y2="21"></line>
										</svg></button>
									<button type="button" class="toolbar-btn" data-format="footnote"
										title="Footnote ([^1])" aria-label="Footnote">fn</button>
									<button type="button" class="toolbar-btn" data-format="highlight"
										title="Highlight (==text==)" aria-label="Highlight"><svg width="15" height="15"
											viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
											stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
											<path d="m9 11-6 6v3h3l6-6"></path>
											<path
												d="m22 7-4.5-4.5a2.12 2.12 0 0 0-3 0L10 7l7 7 4.5-4.5a2.12 2.12 0 0 0 0-3z">
											</path>
											<line x1="14" y1="20" x2="22" y2="20" stroke-width="2.5" stroke="#f59e0b">
											</line>
										</svg></button>
									<button type="button" class="toolbar-btn" data-format="sub"
										title="Subscript (~text~)" aria-label="Subscript">X<sub>2</sub></button>
									<button type="button" class="toolbar-btn" data-format="sup"
										title="Superscript (^text^)" aria-label="Superscript">X<sup>2</sup></button>
								</div>
								<textarea name="body" rows="6" placeholder="Type conference details here..."></textarea>
							</div>
						</div>

						<!-- Conference Custom Sidebar Tabs Section -->
						<div class="field-row field-row-wide conference-tabs-manager-wrap">
							<div class="conference-tabs-header-bar">
								<div>
									<span class="field-label"
										style="font-size: 0.95rem; font-weight: 700; display: block;">Conference Sidebar
										Tabs</span>
									<p style="font-size: 0.82rem; color: var(--muted); margin: 2px 0 0 0;">Add custom
										tab sections (e.g. Important Dates, Registration, Program, Venue) displayed on
										the public conference page sidebar.</p>
								</div>
								<div class="conference-tabs-actions-bar">
									<button type="button" class="btn-add-tab-primary" data-add-conference-tab>
										<svg width="15" height="15" viewBox="0 0 24 24" fill="none"
											stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
											stroke-linejoin="round" aria-hidden="true">
											<line x1="12" y1="5" x2="12" y2="19"></line>
											<line x1="5" y1="12" x2="19" y2="12"></line>
										</svg>
										Add New Tab
									</button>
								</div>
							</div>

							<div class="conference-tabs-container" data-conference-tabs-container>
								<!-- Tab items will be dynamically injected here -->
							</div>

							<div class="conference-tabs-toggle-wrap is-hidden" data-conference-tabs-toggle-wrap>
								<button type="button" class="conference-tabs-toggle-btn" data-conference-tabs-toggle aria-expanded="false">
									<span class="conference-tabs-toggle-text" data-conference-tabs-toggle-text>Show More Tabs</span>
									<svg class="conference-tabs-toggle-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
										<polyline points="6 9 12 15 18 9"></polyline>
									</svg>
								</button>
							</div>
						</div>

						<div class="field-row field-row-wide">
							<span class="field-label">Banner Image</span>
							<div class="image-upload-zone" id="conference-image-zone" data-upload-zone="conference"
								tabindex="0" role="button" aria-label="Click or drag an image here to upload">
								<div class="image-upload-placeholder" data-upload-placeholder="conference">
									<span class="upload-icon" aria-hidden="true">&#x1F5BC;</span>
									<span>Click to upload or drag &amp; drop</span>
									<small>PNG, JPG, GIF, WebP &mdash; max 5 MB</small>
								</div>
								<img class="image-upload-preview is-hidden" data-upload-preview="conference"
									alt="Banner image preview" />
								<input type="file" name="coverImage" accept="image/*" class="image-upload-input"
									data-upload-input="conference" aria-label="Upload conference banner image" />
							</div>
							<div class="image-upload-actions is-hidden" data-upload-actions="conference">
								<span class="image-upload-filename" data-upload-filename="conference"></span>
								<button type="button" class="item-action danger" data-upload-clear="conference">Remove
									image</button>
							</div>
						</div>

						<div class="form-actions">
							<button type="submit" class="button button-primary" data-conference-submit-primary>Save &
								Publish</button>
							<button type="submit" class="button button-secondary" data-status-override="draft"
								data-conference-submit-secondary>Save as Draft</button>
							<button type="reset" class="button button-quiet">Reset</button>
						</div>
					</form>
				</div>

				<div class="panel-view" data-conference-view="list">
					<div class="section-panel-head">
						<div>
							<p class="panel-kicker">SPP Conferences</p>
							<h2>All Conferences</h2>
						</div>
						<div>
							<button type="button" class="button button-primary" data-show-conference-editor
								style="gap: 6px;">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
									stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
									aria-hidden="true">
									<line x1="12" y1="5" x2="12" y2="19"></line>
									<line x1="5" y1="12" x2="19" y2="12"></line>
								</svg>
								Create
							</button>
						</div>
					</div>

					<div class="posts-view-wrapper">
						<div class="queue-toolbar">
							<div class="queue-filters" aria-label="Conference filters">
								<button type="button" class="filter-tab active" data-conference-filter="all">All (<span
										data-conference-filter-all-count>0</span>)</button>
								<button type="button" class="filter-tab" data-conference-filter="published">Published
									(<span data-conference-filter-published-count>0</span>)</button>
								<button type="button" class="filter-tab" data-conference-filter="draft">Drafts (<span
										data-conference-filter-draft-count>0</span>)</button>
								<button type="button" class="filter-tab" data-conference-filter="archived">Archived
									(<span data-conference-filter-archived-count>0</span>)</button>
							</div>
						</div>

						<div class="conference-list" data-conference-list style="display: grid; gap: 16px;"></div>
					</div>
				</div>
			</section>

			<section class="panel editor-panel" id="hero-banner-section">
				<div class="panel-view">
					<div class="section-panel-head">
						<div>
							<p class="panel-kicker">Site Settings</p>
							<h2>Banner Image</h2>
						</div>
					</div>

					<form class="compose-form" data-hero-banner-form>
						<div class="field-row field-row-wide">
							<span class="field-label">Banner Image</span>
							<div class="image-upload-zone" id="hero-banner-upload-zone" data-upload-zone="hero-banner"
								tabindex="0" role="button" aria-label="Click or drag a banner image here to upload">
								<div class="image-upload-placeholder" data-upload-placeholder="hero-banner">
									<span class="upload-icon" aria-hidden="true">&#x1F5BC;</span>
									<span>Click to upload or drag &amp; drop</span>
									<small>PNG, JPG, GIF, WebP &mdash; max 5 MB</small>
								</div>
								<img class="image-upload-preview is-hidden" data-upload-preview="hero-banner"
									alt="Hero banner image preview" />
								<input type="file" name="heroBannerImage" accept="image/*" class="image-upload-input"
									data-upload-input="hero-banner" aria-label="Upload hero banner image" />
							</div>
							<div class="image-upload-actions is-hidden" data-upload-actions="hero-banner">
								<span class="image-upload-filename" data-upload-filename="hero-banner"></span>
								<button type="button" class="item-action danger" data-upload-clear="hero-banner">Remove
									image</button>
							</div>
						</div>

						<div class="field-row field-row-wide" style="margin-top: 20px;">
							<label class="field-row" style="margin-bottom: 0;">
								<span>Link Destination</span>
								<select name="heroBannerLinkType" data-hero-banner-link-type>
									<option value="none" selected>None (Image only)</option>
									<option value="post">Existing Post</option>
									<option value="url">Custom Web Link</option>
								</select>
							</label>
							<p style="font-size: 0.82rem; color: var(--muted); margin-top: 4px;">Choose what happens
								when visitors click the homepage hero banner.</p>
						</div>

						<div class="field-row field-row-wide is-hidden" data-hero-banner-post-row
							style="margin-top: 12px;">
							<label class="field-row" style="margin-bottom: 0;">
								<span>Select Existing Post</span>
								<select name="heroBannerPostSelect" data-hero-banner-post-select>
									<option value="">-- Choose a post --</option>
								</select>
							</label>
							<p style="font-size: 0.82rem; color: var(--muted); margin-top: 4px;">When clicked, users
								will be taken directly to this published post or portal.</p>
						</div>

						<div class="field-row field-row-wide is-hidden" data-hero-banner-url-row
							style="margin-top: 12px;">
							<label class="field-row" style="margin-bottom: 0;">
								<span>Custom Link URL</span>
								<input type="url" name="heroBannerCustomUrl" data-hero-banner-custom-url
									placeholder="https://example.com or /news" />
							</label>
							<p style="font-size: 0.82rem; color: var(--muted); margin-top: 4px;">Enter a complete web
								URL (e.g. https://...) or internal site path.</p>
						</div>

						<div class="field-row field-row-wide is-hidden" data-hero-banner-target-row
							style="margin-top: 12px;">
							<label
								style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem; font-weight: 500;">
								<input type="checkbox" name="heroBannerOpenInNewTab" data-hero-banner-new-tab value="1"
									style="width: 16px; height: 16px; cursor: pointer;" />
								<span>Open link in a new tab</span>
							</label>
						</div>

						<div class="form-actions" style="margin-top: 24px;">
							<button type="submit" class="button button-primary" data-hero-banner-submit>Save & Apply
								Banner</button>
							<button type="button" class="button button-quiet" data-hero-banner-reset>Reset
								Banner</button>
						</div>
					</form>
				</div>
			</section>

			<section class="panel editor-panel" id="about-section">
				<div class="panel-view">
					<div class="section-panel-head">
						<div>
							<p class="panel-kicker">Site Settings</p>
							<h2>About SPP</h2>
							<p>Update the public organization profile, council, contact information, and title image.</p>
						</div>
					</div>

					<form class="compose-form admin-about-form" method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<section class="admin-about-section">
							<h2>Introduction</h2>
							<label class="field-row field-row-wide"><span>Page title</span><input type="text" name="title" value="{{ old('title', $aboutPage->title) }}" required />@error('title') <small class="field-error">{{ $message }}</small> @enderror</label>
							<label class="field-row field-row-wide"><span>Organization description</span><textarea name="introduction" rows="6" required>{{ old('introduction', $aboutPage->introduction) }}</textarea>@error('introduction') <small class="field-error">{{ $message }}</small> @enderror</label>
							<label class="field-row field-row-wide">
								<span>Image beside the title</span>
								@if ($aboutPage->image_url)<img class="admin-about-image-preview" src="{{ $aboutPage->image_url }}" alt="Current About SPP image" />@endif
								<input type="file" name="image" accept="image/*" />
								<small>Optional. JPG, PNG, WEBP, or GIF up to 10 MB.</small>
								@error('image') <small class="field-error">{{ $message }}</small> @enderror
							</label>
							<input type="hidden" name="remove_image" value="0" data-about-remove-image-input />
							@if ($aboutPage->image_url)<button type="button" class="item-action danger admin-about-remove-image" data-about-remove-image>Remove image</button>@endif
						</section>

						<section class="admin-about-section">
							<div class="admin-about-section-heading">
								<label class="field-row admin-about-heading-field"><span>National council heading</span><input type="text" name="council_heading" value="{{ old('council_heading', $aboutPage->council_heading) }}" required /></label>
								<button type="button" class="button button-primary admin-about-add-button" data-about-add-officer><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M12 5v14M5 12h14"></path></svg>Add</button>
							</div>
							<div class="admin-about-member-list" data-about-member-list="officers">
							@foreach (old('officers', $aboutPage->officers ?? []) as $index => $officer)
								<div class="admin-about-person-grid" data-about-member>
									<div class="admin-about-person-card-head"><strong>National Council Member</strong><button type="button" class="button button-danger" data-about-delete-officer>Delete</button></div>
									<label class="field-row"><span>Name</span><input type="text" name="officers[{{ $index }}][name]" value="{{ $officer['name'] }}" required /></label>
									<label class="field-row"><span>Role</span><input type="text" name="officers[{{ $index }}][role]" value="{{ $officer['role'] }}" required /></label>
									<label class="field-row field-row-wide"><span>Institution</span><input type="text" name="officers[{{ $index }}][institution]" value="{{ $officer['institution'] }}" required /></label>
								</div>
							@endforeach
							</div>
							<div class="admin-about-list-actions" data-about-list-actions="officers">
								<button type="button" class="button button-secondary" data-about-show-more>Show More</button>
								<button type="button" class="button button-secondary is-hidden" data-about-show-less>Show Less</button>
							</div>
						</section>

						<section class="admin-about-section">
							<div class="admin-about-section-heading"><h2>Councilors</h2><button type="button" class="button button-primary admin-about-add-button" data-about-add-councilor><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M12 5v14M5 12h14"></path></svg>Add</button></div>
							<div class="admin-about-member-list" data-about-member-list="councilors">
							@foreach (old('councilors', $aboutPage->councilors ?? []) as $index => $councilor)
								<div class="admin-about-person-grid admin-about-councilor-grid" data-about-member data-about-councilor-index="{{ $index }}">
									<div class="admin-about-person-card-head"><strong>Councilor</strong><button type="button" class="button button-danger" data-about-delete-councilor>Delete</button></div>
									<label class="field-row"><span>Name</span><input type="text" name="councilors[{{ $index }}][name]" value="{{ $councilor['name'] }}" required /></label>
									<label class="field-row"><span>Institution</span><input type="text" name="councilors[{{ $index }}][institution]" value="{{ $councilor['institution'] }}" required /></label>
								</div>
							@endforeach
							</div>
							<div class="admin-about-list-actions" data-about-list-actions="councilors">
								<button type="button" class="button button-secondary" data-about-show-more>Show More</button>
								<button type="button" class="button button-secondary is-hidden" data-about-show-less>Show Less</button>
							</div>
						</section>

						<section class="admin-about-section">
							<h2>Contact</h2>
							<label class="field-row field-row-wide"><span>Address</span><textarea name="address" rows="3" required>{{ old('address', $aboutPage->address) }}</textarea></label>
							<label class="field-row field-row-wide"><span>Email</span><input type="email" name="email" value="{{ old('email', $aboutPage->email) }}" required /></label>
						</section>
						<div class="form-actions"><button class="button button-primary" type="submit">Save About SPP</button></div>
					</form>
				</div>
			</section>

			<section class="panel editor-panel" id="downloads-section">
				<div class="downloads-proceedings-editor">
					<div class="section-panel-head">
						<div>
							<p class="panel-kicker">Public Downloads</p>
							<h2>Proceedings Template</h2>
							<p>Configure the featured image and up to two download or link buttons.</p>
						</div>
					</div>
					<form class="compose-form" data-proceedings-template-form>
						<label class="field-row field-row-wide"><span>Title</span><input class="proceedings-text-input" name="title" required value="Proceedings Template" placeholder="e.g. Proceedings Template"></label>
						<div class="proceedings-form-grid">
							<div class="field-row"><span>Featured image</span><label class="proceedings-attachment"><input type="file" name="image" accept="image/*" data-proceedings-image-input><span class="proceedings-attachment-icon" data-proceedings-image-icon>↑</span><span data-proceedings-image-copy><strong>Choose image</strong><small data-proceedings-image-name>PNG, JPG, or WEBP</small></span></label><div class="proceedings-image-preview-wrap is-hidden" data-proceedings-image-preview-wrap><img class="proceedings-image-preview" data-proceedings-image-preview alt="Selected proceedings image"></div><small>Shown on the left side of the public template.</small></div>
							<div class="proceedings-button-fields">
								<label class="field-row"><span>First button</span><input class="proceedings-text-input" name="first_label" placeholder="Button name"><input class="proceedings-text-input" name="first_url" type="url" placeholder="Paste link: https://example.com/file.pdf"><span class="proceedings-or">— OR —</span><input class="proceedings-file-input" name="first_file" type="file"><span class="proceedings-checkbox"><input name="first_opens_in_new_tab" type="checkbox" value="1" checked> open in a new tab</span></label>
								<label class="field-row"><span>Second button</span><input class="proceedings-text-input" name="second_label" placeholder="Button name"><input class="proceedings-text-input" name="second_url" type="url" placeholder="Paste link: https://example.com/file.pdf"><span class="proceedings-or">— OR —</span><input class="proceedings-file-input" name="second_file" type="file"><span class="proceedings-checkbox"><input name="second_opens_in_new_tab" type="checkbox" value="1" checked> open in a new tab</span></label>
							</div>
						</div>
						<div class="form-actions"><button type="submit" class="button button-primary" data-proceedings-save>Save Template</button></div>
					</form>
				</div>

				<!-- 1. Categories List View -->
				<div class="panel-view" data-download-view="categories">
					<div class="section-panel-head" style="align-items: center; margin-bottom: 16px;">
						<div>
							<p class="panel-kicker">Content & Documents</p>
							<h2 style="margin: 0;">Downloads Manager</h2>
						</div>
						<div style="display: flex; gap: 10px; flex-wrap: nowrap; align-items: center;">
							<button type="button" class="button button-primary" data-download-add-category style="display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
								<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
								<span>Add Category</span>
							</button>
						</div>
					</div>

					<!-- Categories List View -->
					<div class="downloads-admin-overview" style="margin-top: 14px; display: grid; gap: 20px;">
						<!-- Vertical Categories List (Without inner documents) -->
						<div class="downloads-cat-list" data-download-categories-list style="display: grid; gap: 12px;">
							<!-- Dynamically rendered via JS -->
						</div>

						<!-- Categories Pagination / Show More / Show Less -->
						<div class="queue-pagination" data-download-cat-pagination style="display: none;">
							<span class="pagination-info" data-download-cat-pagination-info>Showing 3 categories</span>
							<div class="queue-pagination-actions" style="display: flex; gap: 10px; align-items: center;">
								<button type="button" class="button button-secondary" data-download-cat-load-more>Show More</button>
								<button type="button" class="button button-secondary" data-download-cat-show-less style="display: none;">Show Less</button>
							</div>
						</div>
					</div>
				</div>

				<!-- 2. Solo Category Editor View (Opened when clicking Edit on a category) -->
				<div class="panel-view is-hidden" data-download-view="category-editor">
					<div class="section-panel-head" style="align-items: center; margin-bottom: 16px;">
						<div>
							<p class="panel-kicker">Downloads Category</p>
							<h2 data-download-editing-cat-name style="margin: 0;">Edit Category</h2>
						</div>
						<div style="display: flex; gap: 10px; flex-wrap: nowrap; align-items: center; white-space: nowrap;">
							<button type="button" class="button button-secondary" data-download-back-to-categories style="display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
								&larr; Back to All Categories
							</button>
							<button type="button" class="button button-primary" data-download-add-doc style="display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
								<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
								<span>Add Document</span>
							</button>
						</div>
					</div>

					<!-- The Solo Card for this Category -->
					<div class="downloads-solo-card" style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 24px; box-shadow: var(--shadow); margin-top: 14px;">
						<div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 16px; border-bottom: 1px solid var(--border); margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
							<div>
								<span class="badge" style="background: rgba(37, 99, 235, 0.12); color: #2563eb; font-weight: 700; font-size: 0.78rem; padding: 4px 10px; border-radius: 999px; display: inline-block; margin-bottom: 6px;">Category</span>
								<h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text);" data-download-solo-cat-title>Category Title</h3>
								<p style="margin: 4px 0 0; font-size: 0.85rem; color: var(--muted);"><span data-download-solo-cat-count>0</span> documents attached</p>
							</div>
							<div style="display: flex; gap: 8px;">
								<button type="button" class="button button-secondary" data-download-rename-cat style="font-size: 0.84rem; padding: 6px 14px; min-height: 38px;">
									Rename Category
								</button>
								<button type="button" class="button button-danger" data-download-delete-cat style="font-size: 0.84rem; padding: 6px 14px; min-height: 38px;">
									Delete Category
								</button>
							</div>
						</div>

						<!-- Vertical Documents List Inside This Category -->
						<div class="downloads-doc-list" data-download-docs-list style="display: grid; gap: 10px;">
							<!-- Dynamically populated documents -->
						</div>

						<!-- Documents Pagination / Show More / Show Less (Minimum 3 visible) -->
						<div class="queue-pagination" data-download-doc-pagination style="display: none; margin-top: 18px;">
							<span class="pagination-info" data-download-doc-pagination-info>Showing 3 of 12 documents</span>
							<div class="queue-pagination-actions" style="display: flex; gap: 10px; align-items: center;">
								<button type="button" class="button button-secondary" data-download-doc-load-more>Show More</button>
								<button type="button" class="button button-secondary" data-download-doc-show-less style="display: none;">Show Less</button>
							</div>
						</div>
					</div>
				</div>

				<!-- 3. Document Editor View (Activated when editing or adding a document) -->
				<div class="panel-view is-hidden" data-download-view="doc-editor">
					<div class="section-panel-head">
						<div>
							<p class="panel-kicker">Document Editor</p>
							<h2 data-download-doc-editor-heading>Edit Document</h2>
							<p>Update title, year tag, category destination, or file attachment.</p>
						</div>
						<div>
							<button type="button" class="button button-secondary" data-download-doc-cancel-btn style="gap: 6px;">
								Cancel
							</button>
						</div>
					</div>

					<form class="compose-form" data-download-doc-form onsubmit="return false;" style="margin-top: 20px;">
						<div class="editor-status-banner" data-download-doc-banner>
							<span data-download-doc-banner-text>Edit Document</span>
						</div>

						<input type="hidden" name="docId" value="" />
						<input type="hidden" name="catId" value="" />

						<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
							<label class="field-row">
								<span>Target Category</span>
								<select name="download_category" data-download-doc-cat-select required>
									<!-- Populated from categories list -->
								</select>
							</label>

							<label class="field-row">
								<span>Year / Label Tag <small style="font-weight: 400; opacity: 0.6;">(e.g., 2026)</small></span>
								<input type="text" name="download_year" data-download-doc-year placeholder="2026" required />
							</label>
						</div>

						<div class="field-row field-row-wide">
							<span class="field-label">Document File Attachment</span>
							<div class="image-upload-zone" id="download-doc-upload-zone" tabindex="0" role="button" aria-label="Click or drag a file to upload">
								<div class="image-upload-placeholder">
									<span class="upload-icon" aria-hidden="true" style="display: inline-flex; align-items: center; justify-content: center;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><path d="M12 11v6"></path><path d="M9 14l3-3 3 3"></path></svg></span>
									<span data-download-upload-hint>Click to upload document or drag &amp; drop</span>
									<small>PDF, DOC, DOCX, ZIP, PNG &mdash; max 25 MB</small>
								</div>
								<input type="file" name="downloadFile" class="image-upload-input" data-download-doc-file-input aria-label="Upload document file" />
							</div>
							<div class="image-upload-actions is-hidden" data-download-file-actions style="display: flex; align-items: center; justify-content: space-between; margin-top: 8px; padding: 6px 12px; background: var(--surface); border: 1px solid var(--border); border-radius: 8px;">
								<span data-download-attached-filename style="font-size: 0.85rem; font-weight: 600; color: var(--text);"></span>
								<button type="button" class="item-action danger" data-download-clear-file style="font-size: 0.75rem; padding: 2px 8px;">Remove file</button>
							</div>
						</div>

						<div class="form-actions">
							<button type="button" class="button button-primary" data-download-doc-save-btn>
								<span class="btn-spinner is-hidden" data-download-save-spinner aria-hidden="true"></span>
								<span data-download-save-label>Save Document</span>
							</button>
							<button type="button" class="button button-quiet" data-download-doc-cancel-btn>Cancel</button>
						</div>
					</form>
				</div>
			</section>

			<section class="panel editor-panel" id="videos-section">
				<div class="section-panel-head">
					<div>
						<p class="panel-kicker">Resource Library</p>
						<h2>Videos &amp; Webinars</h2>
					</div>
					<span class="video-admin-preview-badge">Managed</span>
				</div>

				<div class="video-admin-layout">
					<form class="compose-form video-admin-form" data-video-form>
						<div class="editor-status-banner"><span data-video-form-heading>Add video or webinar</span></div>
						<label class="field-row field-row-wide">
							<span>Title</span>
							<input type="text" name="title" required>
						</label>
						<label class="field-row field-row-wide">
							<span>YouTube link</span>
							<input type="url" name="video_url" placeholder="https://www.youtube.com/watch?v=..." inputmode="url" required>
						</label>
						<label class="field-row"><span>Recording date</span><input type="date" name="published_at"></label>
						<label class="field-row"><span>Status</span><select name="status"><option value="draft">Draft</option><option value="published">Published</option><option value="archived">Archived</option></select></label>
						<p class="video-admin-help">Use the recording date, not the date the video was uploaded or posted.</p>
						<div class="form-actions"><button class="button button-primary" type="submit" data-video-save>Save Resource</button><button class="button button-quiet" type="button" data-video-cancel hidden>Cancel</button></div>
					</form>

					<div class="video-admin-list" aria-label="Managed videos and webinars">
						<div class="video-admin-list-head"><h3>Resources</h3><span data-video-count>0 items</span></div>
						<div data-video-list><p class="video-admin-list-note">Loading resources…</p></div>
					</div>
				</div>
			</section>

			<!-- MEMBERSHIP FAQ SECTION -->
			<section class="panel editor-panel is-hidden-section" id="membership-faq-section">
				<div class="section-panel-head" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border);">
					<div>
						<p class="panel-kicker">Resource Library &amp; Public Pages</p>
						<h2 style="font-size: 1.5rem; font-weight: 800; color: var(--accent-strong); margin: 4px 0 0 0;">Membership FAQ Management</h2>
					</div>
					<div style="display: flex; align-items: center; gap: 10px;">
						<span class="video-admin-preview-badge" style="background: var(--surface-strong); border: 1px solid var(--border); color: var(--accent-strong); padding: 4px 10px; border-radius: var(--radius-sm); font-size: 0.78rem; font-weight: 700;">UI Only &bull; 7 Active FAQs</span>
						<button type="button" class="button button-primary" onclick="alert('UI Demo: Add new FAQ item modal/drawer')" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 700; font-size: 0.88rem;">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							Add New FAQ Item
						</button>
					</div>
				</div>

				<!-- Page Header Settings & Form Link Cards -->
				<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 20px; margin-bottom: 24px; box-shadow: var(--shadow);">
					<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
						<h3 style="font-size: 1rem; font-weight: 800; color: var(--accent-strong); margin: 0; display: flex; align-items: center; gap: 8px;">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
							Public Header &amp; Application Form Links
						</h3>
						<button type="button" class="button button-secondary" style="padding: 5px 12px; font-size: 0.8rem; font-weight: 700;">Save Header Links</button>
					</div>

					<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 14px;">
						<div>
							<label style="font-size: 0.78rem; font-weight: 800; color: var(--muted); display: block; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.04em;">MEMBERSHIP INQUIRY FORM URL</label>
							<div style="display: flex; gap: 8px;">
								<input type="url" value="https://docs.google.com/forms/d/e/1FAIpQLSexjHKcRXZk9Q6mq-AZj2fijUBVjzoUcsRi7VvONcxU5H4olQ/viewform" style="width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 0.88rem; background: var(--surface); color: var(--text);" />
								<a href="https://docs.google.com/forms/d/e/1FAIpQLSexjHKcRXZk9Q6mq-AZj2fijUBVjzoUcsRi7VvONcxU5H4olQ/viewform" target="_blank" rel="noopener noreferrer" class="button button-quiet" style="padding: 8px 12px; font-size: 0.8rem; text-decoration: none;" title="Test Link">Open</a>
							</div>
						</div>
						<div>
							<label style="font-size: 0.78rem; font-weight: 800; color: var(--muted); display: block; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.04em;">MEMBERSHIP APPLICATION FORM URL</label>
							<div style="display: flex; gap: 8px;">
								<input type="url" value="https://docs.google.com/forms/d/e/1FAIpQLSdO5VZ9uKaRC-mObDdPcipjsl1aBjWKIF9-H5tVs_C2EKifJQ/viewform" style="width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 0.88rem; background: var(--surface); color: var(--text);" />
								<a href="https://docs.google.com/forms/d/e/1FAIpQLSdO5VZ9uKaRC-mObDdPcipjsl1aBjWKIF9-H5tVs_C2EKifJQ/viewform" target="_blank" rel="noopener noreferrer" class="button button-quiet" style="padding: 8px 12px; font-size: 0.8rem; text-decoration: none;" title="Test Link">Open</a>
							</div>
						</div>
					</div>

					<div>
						<label style="font-size: 0.78rem; font-weight: 800; color: var(--muted); display: block; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.04em;">SEARCH HELPER NOTICE BANNER TEXT</label>
						<textarea rows="2" style="width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 0.88rem; background: var(--surface); color: var(--text); resize: vertical;">Search this webpage for related terms of your query using your web browser's search function. If you don't find it here, you may accomplish an online form to ask your question:</textarea>
					</div>
				</div>

				<!-- FAQs Management Roster / Accordion Cards -->
				<div style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 20px; box-shadow: var(--shadow); margin-bottom: 24px;">
					
					<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 12px;">
						<div style="display: flex; align-items: center; gap: 10px;">
							<h3 style="font-size: 1.05rem; font-weight: 800; color: var(--accent-strong); margin: 0;">Frequently Asked Questions</h3>
							<span style="font-size: 0.75rem; background: var(--surface-strong); color: var(--muted); padding: 3px 10px; border-radius: 12px; font-weight: 700;">7 Items</span>
						</div>
						
						<div style="display: flex; gap: 10px; align-items: center;">
							<input type="text" placeholder="Search questions..." style="padding: 7px 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 0.85rem; background: var(--surface-soft); color: var(--text); width: 220px;" />
							<select style="padding: 7px 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 0.85rem; background: var(--surface-soft); color: var(--text);">
								<option selected>All Categories</option>
								<option>Membership Types</option>
								<option>Application &amp; Fees</option>
								<option>Status &amp; Dues</option>
								<option>Certificates &amp; Validity</option>
							</select>
						</div>
					</div>

					<div style="display: flex; flex-direction: column; gap: 14px;">

						<!-- FAQ Item 1 -->
						<div class="tab-card-admin" style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px; transition: var(--transition);">
							<div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 10px;">
								<div style="display: flex; align-items: flex-start; gap: 10px;">
									<span style="cursor: grab; color: var(--muted); font-weight: 800; font-size: 1.1rem; line-height: 1.2;" title="Drag to reorder">&#x2630;</span>
									<span style="font-weight: 800; font-size: 0.8rem; background: var(--accent-strong); color: var(--surface); padding: 3px 8px; border-radius: var(--radius-sm);">Q1</span>
									<div>
										<strong style="font-size: 0.98rem; color: var(--accent-strong); display: block; line-height: 1.4;">
											1. What are the types of membership in Samahang Pisika ng Pilipinas (SPP, or Samahan)?
										</strong>
										<span style="font-size: 0.72rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em;">Category: Membership Types</span>
									</div>
								</div>
								<div style="display: flex; gap: 8px; align-items: center;">
									<span style="font-size: 0.72rem; background: rgba(27, 122, 76, 0.12); color: var(--success); padding: 3px 8px; border-radius: var(--radius-pill); font-weight: 700;">Visible</span>
									<button type="button" class="button button-quiet" style="padding: 4px 10px; font-size: 0.78rem;">Edit</button>
									<button type="button" class="button button-quiet" style="color: var(--danger); padding: 4px 10px; font-size: 0.78rem;">Delete</button>
								</div>
							</div>
							<div style="background: var(--surface); padding: 12px 14px; border-radius: var(--radius-sm); border: 1px solid var(--border); font-size: 0.86rem; color: var(--text); line-height: 1.5; font-style: italic;">
								"There are three basic types of membership in SPP: (1) Associate member; (2) Regular member; and (3) Institutional member. For details, kindly refer to the SPP Constitution and By-Laws Article II <a href="#" style="color: #60a5fa; text-decoration: underline;">here</a>."
							</div>
						</div>

						<!-- FAQ Item 2 -->
						<div class="tab-card-admin" style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px; transition: var(--transition);">
							<div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 10px;">
								<div style="display: flex; align-items: flex-start; gap: 10px;">
									<span style="cursor: grab; color: var(--muted); font-weight: 800; font-size: 1.1rem; line-height: 1.2;" title="Drag to reorder">&#x2630;</span>
									<span style="font-weight: 800; font-size: 0.8rem; background: var(--accent-strong); color: var(--surface); padding: 3px 8px; border-radius: var(--radius-sm);">Q2</span>
									<div>
										<strong style="font-size: 0.98rem; color: var(--accent-strong); display: block; line-height: 1.4;">
											2. How do I apply for membership to the Samahan?
										</strong>
										<span style="font-size: 0.72rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em;">Category: Application &amp; Fees</span>
									</div>
								</div>
								<div style="display: flex; gap: 8px; align-items: center;">
									<span style="font-size: 0.72rem; background: rgba(27, 122, 76, 0.12); color: var(--success); padding: 3px 8px; border-radius: var(--radius-pill); font-weight: 700;">Visible</span>
									<button type="button" class="button button-quiet" style="padding: 4px 10px; font-size: 0.78rem;">Edit</button>
									<button type="button" class="button button-quiet" style="color: var(--danger); padding: 4px 10px; font-size: 0.78rem;">Delete</button>
								</div>
							</div>
							<div style="background: var(--surface); padding: 12px 14px; border-radius: var(--radius-sm); border: 1px solid var(--border); font-size: 0.86rem; color: var(--text); line-height: 1.5; font-style: italic;">
								"The Samahan accepts membership application and/or profile update via a submission online. The online form and submission requirements are available from the link below: <span style="background: rgba(96, 165, 250, 0.15); color: #60a5fa; padding: 2px 6px; border-radius: 4px; font-weight: 600;">Membership Application Form</span>"
							</div>
						</div>

						<!-- FAQ Item 3 -->
						<div class="tab-card-admin" style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px; transition: var(--transition);">
							<div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 10px;">
								<div style="display: flex; align-items: flex-start; gap: 10px;">
									<span style="cursor: grab; color: var(--muted); font-weight: 800; font-size: 1.1rem; line-height: 1.2;" title="Drag to reorder">&#x2630;</span>
									<span style="font-weight: 800; font-size: 0.8rem; background: var(--accent-strong); color: var(--surface); padding: 3px 8px; border-radius: var(--radius-sm);">Q3</span>
									<div>
										<strong style="font-size: 0.98rem; color: var(--accent-strong); display: block; line-height: 1.4;">
											3. Is there an application fee to be paid as a new member?
										</strong>
										<span style="font-size: 0.72rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em;">Category: Application &amp; Fees</span>
									</div>
								</div>
								<div style="display: flex; gap: 8px; align-items: center;">
									<span style="font-size: 0.72rem; background: rgba(27, 122, 76, 0.12); color: var(--success); padding: 3px 8px; border-radius: var(--radius-pill); font-weight: 700;">Visible</span>
									<button type="button" class="button button-quiet" style="padding: 4px 10px; font-size: 0.78rem;">Edit</button>
									<button type="button" class="button button-quiet" style="color: var(--danger); padding: 4px 10px; font-size: 0.78rem;">Delete</button>
								</div>
							</div>
							<div style="background: var(--surface); padding: 12px 14px; border-radius: var(--radius-sm); border: 1px solid var(--border); font-size: 0.86rem; color: var(--text); line-height: 1.5; font-style: italic;">
								"No. Once your application is approved you are required to attend the SPP National Physics Congress to take an oath of membership and pay annual membership dues. However, your annual membership fee is waived if you have paid conference fees to attend the SPP Congress in the same year."
							</div>
						</div>

						<!-- FAQ Item 4 -->
						<div class="tab-card-admin" style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px; transition: var(--transition);">
							<div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 10px;">
								<div style="display: flex; align-items: flex-start; gap: 10px;">
									<span style="cursor: grab; color: var(--muted); font-weight: 800; font-size: 1.1rem; line-height: 1.2;" title="Drag to reorder">&#x2630;</span>
									<span style="font-weight: 800; font-size: 0.8rem; background: var(--accent-strong); color: var(--surface); padding: 3px 8px; border-radius: var(--radius-sm);">Q4</span>
									<div>
										<strong style="font-size: 0.98rem; color: var(--accent-strong); display: block; line-height: 1.4;">
											4. How do I know my membership status in the Samahan?
										</strong>
										<span style="font-size: 0.72rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em;">Category: Status &amp; Dues</span>
									</div>
								</div>
								<div style="display: flex; gap: 8px; align-items: center;">
									<span style="font-size: 0.72rem; background: rgba(27, 122, 76, 0.12); color: var(--success); padding: 3px 8px; border-radius: var(--radius-pill); font-weight: 700;">Visible</span>
									<button type="button" class="button button-quiet" style="padding: 4px 10px; font-size: 0.78rem;">Edit</button>
									<button type="button" class="button button-quiet" style="color: var(--danger); padding: 4px 10px; font-size: 0.78rem;">Delete</button>
								</div>
							</div>
							<div style="background: var(--surface); padding: 12px 14px; border-radius: var(--radius-sm); border: 1px solid var(--border); font-size: 0.86rem; color: var(--text); line-height: 1.5; font-style: italic;">
								"You may ask the Membership Committee via the following link: <a href="#" style="color: #60a5fa; text-decoration: underline;">Membership Inquiry form</a>."
							</div>
						</div>

						<!-- FAQ Item 5 -->
						<div class="tab-card-admin" style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px; transition: var(--transition);">
							<div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 10px;">
								<div style="display: flex; align-items: flex-start; gap: 10px;">
									<span style="cursor: grab; color: var(--muted); font-weight: 800; font-size: 1.1rem; line-height: 1.2;" title="Drag to reorder">&#x2630;</span>
									<span style="font-weight: 800; font-size: 0.8rem; background: var(--accent-strong); color: var(--surface); padding: 3px 8px; border-radius: var(--radius-sm);">Q5</span>
									<div>
										<strong style="font-size: 0.98rem; color: var(--accent-strong); display: block; line-height: 1.4;">
											5. How is the membership fee paid in the Samahan?
										</strong>
										<span style="font-size: 0.72rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em;">Category: Application &amp; Fees</span>
									</div>
								</div>
								<div style="display: flex; gap: 8px; align-items: center;">
									<span style="font-size: 0.72rem; background: rgba(27, 122, 76, 0.12); color: var(--success); padding: 3px 8px; border-radius: var(--radius-pill); font-weight: 700;">Visible</span>
									<button type="button" class="button button-quiet" style="padding: 4px 10px; font-size: 0.78rem;">Edit</button>
									<button type="button" class="button button-quiet" style="color: var(--danger); padding: 4px 10px; font-size: 0.78rem;">Delete</button>
								</div>
							</div>
							<div style="background: var(--surface); padding: 12px 14px; border-radius: var(--radius-sm); border: 1px solid var(--border); font-size: 0.86rem; color: var(--text); line-height: 1.5; font-style: italic;">
								"In the past few years, the Membership Fee for a given year is deemed paid every time you attend the annual SPP National Physics Congress. The membership fee is waived for members who pay for the conference fee that year."
							</div>
						</div>

						<!-- FAQ Item 6 -->
						<div class="tab-card-admin" style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px; transition: var(--transition);">
							<div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 10px;">
								<div style="display: flex; align-items: flex-start; gap: 10px;">
									<span style="cursor: grab; color: var(--muted); font-weight: 800; font-size: 1.1rem; line-height: 1.2;" title="Drag to reorder">&#x2630;</span>
									<span style="font-weight: 800; font-size: 0.8rem; background: var(--accent-strong); color: var(--surface); padding: 3px 8px; border-radius: var(--radius-sm);">Q6</span>
									<div>
										<strong style="font-size: 0.98rem; color: var(--accent-strong); display: block; line-height: 1.4;">
											6. How do I request for a membership certificate?
										</strong>
										<span style="font-size: 0.72rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em;">Category: Certificates &amp; Validity</span>
									</div>
								</div>
								<div style="display: flex; gap: 8px; align-items: center;">
									<span style="font-size: 0.72rem; background: rgba(27, 122, 76, 0.12); color: var(--success); padding: 3px 8px; border-radius: var(--radius-pill); font-weight: 700;">Visible</span>
									<button type="button" class="button button-quiet" style="padding: 4px 10px; font-size: 0.78rem;">Edit</button>
									<button type="button" class="button button-quiet" style="color: var(--danger); padding: 4px 10px; font-size: 0.78rem;">Delete</button>
								</div>
							</div>
							<div style="background: var(--surface); padding: 12px 14px; border-radius: var(--radius-sm); border: 1px solid var(--border); font-size: 0.86rem; color: var(--text); line-height: 1.5; font-style: italic;">
								"You may accomplish the query form under 'Request for certificate of membership': <a href="#" style="color: #60a5fa; text-decoration: underline;">Membership Inquiry form</a>."
							</div>
						</div>

						<!-- FAQ Item 7 -->
						<div class="tab-card-admin" style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px; transition: var(--transition);">
							<div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 10px;">
								<div style="display: flex; align-items: flex-start; gap: 10px;">
									<span style="cursor: grab; color: var(--muted); font-weight: 800; font-size: 1.1rem; line-height: 1.2;" title="Drag to reorder">&#x2630;</span>
									<span style="font-weight: 800; font-size: 0.8rem; background: var(--accent-strong); color: var(--surface); padding: 3px 8px; border-radius: var(--radius-sm);">Q7</span>
									<div>
										<strong style="font-size: 0.98rem; color: var(--accent-strong); display: block; line-height: 1.4;">
											7. When does a membership certificate lose validity?
										</strong>
										<span style="font-size: 0.72rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em;">Category: Certificates &amp; Validity</span>
									</div>
								</div>
								<div style="display: flex; gap: 8px; align-items: center;">
									<span style="font-size: 0.72rem; background: rgba(27, 122, 76, 0.12); color: var(--success); padding: 3px 8px; border-radius: var(--radius-pill); font-weight: 700;">Visible</span>
									<button type="button" class="button button-quiet" style="padding: 4px 10px; font-size: 0.78rem;">Edit</button>
									<button type="button" class="button button-quiet" style="color: var(--danger); padding: 4px 10px; font-size: 0.78rem;">Delete</button>
								</div>
							</div>
							<div style="background: var(--surface); padding: 12px 14px; border-radius: var(--radius-sm); border: 1px solid var(--border); font-size: 0.86rem; color: var(--text); line-height: 1.5; font-style: italic;">
								"Membership certificates are valid for 72 months (6 years) from the month of issue (except for 'lifetime membership'). You are encouraged to maintain active membership by regularly attending the Physics Congress every year. Check Article II of the SPP Constitution and By-Laws <a href="#" style="color: #60a5fa; text-decoration: underline;">here</a> for more details."
							</div>
						</div>

					</div>
				</div>

				<!-- Live Public Page UI Preview Card -->
				<div style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow);">
					
					<!-- Mock Toolbar -->
					<div style="background: var(--surface-strong); padding: 12px 18px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border);">
						<div style="display: flex; align-items: center; gap: 8px;">
							<span style="width: 10px; height: 10px; border-radius: 50%; background: #dc3545; display: inline-block;"></span>
							<span style="width: 10px; height: 10px; border-radius: 50%; background: #c27d00; display: inline-block;"></span>
							<span style="width: 10px; height: 10px; border-radius: 50%; background: #1b7a4c; display: inline-block;"></span>
							<span style="font-size: 0.8rem; color: var(--muted); font-weight: 700; margin-left: 10px;">Live User Website Preview &mdash; Membership FAQ Page</span>
						</div>
						<div style="background: var(--surface); color: var(--muted); font-size: 0.78rem; padding: 4px 14px; border-radius: var(--radius-pill); border: 1px solid var(--border);">
							https://spp-online.org/resources/membership-faq
						</div>
					</div>

					<!-- Simulated User Website View (Theme-Reactive using SPP CSS variables) -->
					<div style="background: var(--bg-page); color: var(--text); padding: 36px 32px; font-family: system-ui, -apple-system, sans-serif; transition: var(--transition);">
						<div style="max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1fr 300px; gap: 40px;">
							
							<!-- Main Left Column -->
							<div>
								<h1 style="font-size: 2.2rem; font-weight: 800; color: var(--accent-strong); text-align: center; margin-bottom: 36px; letter-spacing: -0.02em;">Membership FAQ</h1>

								<p style="font-size: 0.9rem; color: var(--muted); line-height: 1.5; margin-bottom: 16px;">
									Search this webpage for related terms of your query using your web browser's search function. If you don't find it here, you may accomplish an online form to ask your question:
								</p>

								<div style="margin-bottom: 32px;">
									<a style="display: inline-flex; align-items: center; gap: 8px; background: var(--accent-strong); color: var(--surface); padding: 9px 18px; border-radius: 6px; font-size: 0.88rem; font-weight: 700; text-decoration: none; box-shadow: var(--shadow);">
										<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
										Membership Inquiry Form
									</a>
								</div>

								<h2 style="font-size: 1.25rem; font-weight: 700; color: var(--accent-strong); margin-bottom: 24px; padding-bottom: 8px; border-bottom: 1px solid var(--border);">
									Frequently Asked Questions about SPP Membership
								</h2>

								<!-- Questions List matching Reference Photo -->
								<div style="display: flex; flex-direction: column; gap: 20px; font-size: 0.92rem; line-height: 1.6;">
									<div>
										<strong style="color: var(--accent-strong); display: block; margin-bottom: 4px;">1. What are the types of membership in Samahang Pisika ng Pilipinas (SPP, or Samahan)?</strong>
										<div style="color: var(--muted); font-style: italic;">
											There are three basic types of membership in SPP: (1) Associate member; (2) Regular member; and (3) Institutional member. For details, kindly refer to the SPP Constitution and By-Laws Article II <a style="color: var(--accent); text-decoration: underline;">here</a>.
										</div>
									</div>

									<div>
										<strong style="color: var(--accent-strong); display: block; margin-bottom: 4px;">2. How do I apply for membership to the Samahan?</strong>
										<div style="color: var(--muted); font-style: italic; margin-bottom: 8px;">
											The Samahan accepts membership application and/or profile update via a submission online. The online form and submission requirements are available from the link below:
										</div>
										<a style="display: inline-flex; align-items: center; gap: 8px; background: var(--accent-strong); color: var(--surface); padding: 7px 16px; border-radius: 6px; font-size: 0.84rem; font-weight: 700; text-decoration: none;">
											<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
											Membership Application Form
										</a>
									</div>

									<div>
										<strong style="color: var(--accent-strong); display: block; margin-bottom: 4px;">3. Is there an application fee to be paid as a new member?</strong>
										<div style="color: var(--muted); font-style: italic;">
											No. Once your application is approved you are required to attend the SPP National Physics Congress to take an oath of membership and pay annual membership dues. However, your annual membership fee is waived if you have paid conference fees to attend the SPP Congress in the same year.
										</div>
									</div>

									<div>
										<strong style="color: var(--accent-strong); display: block; margin-bottom: 4px;">4. How do I know my membership status in the Samahan?</strong>
										<div style="color: var(--muted); font-style: italic;">
											You may ask the Membership Committee via the following link: <a style="color: var(--accent); text-decoration: underline;">Membership Inquiry form</a>.
										</div>
									</div>

									<div>
										<strong style="color: var(--accent-strong); display: block; margin-bottom: 4px;">5. How is the membership fee paid in the Samahan?</strong>
										<div style="color: var(--muted); font-style: italic;">
											In the past few years, the Membership Fee for a given year is deemed paid every time you attend the annual SPP National Physics Congress. The <strong style="color: var(--text); font-style: normal;">membership fee is waived</strong> for members who pay for the conference fee that year.
										</div>
									</div>

									<div>
										<strong style="color: var(--accent-strong); display: block; margin-bottom: 4px;">6. How do I request for a membership certificate?</strong>
										<div style="color: var(--muted); font-style: italic;">
											You may accomplish the query form under "Request for certificate of membership": <a style="color: var(--accent); text-decoration: underline;">Membership Inquiry form</a>.
										</div>
									</div>

									<div>
										<strong style="color: #ffffff; display: block; margin-bottom: 4px;">7. When does a membership certificate lose validity?</strong>
										<div style="color: var(--muted); font-style: italic;">
											Membership certificates are <strong style="color: var(--text); font-style: normal;">valid for 72 months (6 years) from the month of issue</strong> (except for "lifetime membership"). You are encouraged to maintain active membership by regularly attending the Physics Congress every year. Check Article II of the SPP Constitution and By-Laws <a style="color: var(--accent); text-decoration: underline;">here</a> for more details.
										</div>
									</div>
								</div>
							</div>

							<!-- Sidebar Widgets on Reference Website -->
							<div>
								<div style="margin-bottom: 32px;">
									<h3 style="font-size: 1.05rem; font-weight: 700; color: var(--accent-strong); margin-bottom: 16px;">Recent Activities</h3>
									<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
										<div style="background: var(--surface-soft); border-radius: 6px; aspect-ratio: 1; display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--accent-strong); font-size: 0.8rem; border: 1px solid var(--border);">SPP 2026</div>
										<div style="background: var(--surface-soft); border-radius: 6px; aspect-ratio: 1; display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--success); font-size: 0.8rem; border: 1px solid var(--border);">Entangles</div>
										<div style="background: var(--surface-soft); border-radius: 6px; aspect-ratio: 1; display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--warn); font-size: 0.8rem; border: 1px solid var(--border);">SPP 2024</div>
										<div style="background: var(--surface-soft); border-radius: 6px; aspect-ratio: 1; display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--accent); font-size: 0.8rem; border: 1px solid var(--border);">SPP 2023</div>
									</div>
								</div>

								<div>
									<h3 style="font-size: 1.05rem; font-weight: 700; color: var(--accent-strong); margin-bottom: 12px;">Recent News</h3>
									<div style="font-size: 0.82rem; color: var(--muted); display: flex; flex-direction: column; gap: 12px;">
										<div>
											<a style="color: var(--accent); font-weight: 600; text-decoration: none;">Job Posting 2025-1: SPP Graduate Student Assistant</a>
											<div style="font-size: 0.75rem; color: var(--muted);">14 April 2025</div>
										</div>
										<div>
											<a style="color: var(--accent); font-weight: 600; text-decoration: none;">Association of Asia Pacific Physical Societies announces APPC16</a>
											<div style="font-size: 0.75rem; color: var(--muted);">1 March 2025</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>

				</div>

			</section>


		</main>
	</div>
	<!-- Custom Confirmation Modal -->
	<div class="confirm-modal-overlay is-hidden" id="custom-confirm-modal" role="dialog" aria-modal="true"
		aria-labelledby="confirm-modal-title">
		<div class="confirm-modal-card">
			<div class="confirm-modal-icon warning" aria-hidden="true">&#x26A0;</div>
			<h3 class="confirm-modal-title" id="confirm-modal-title">Confirm Deletion</h3>
			<p class="confirm-modal-message" id="confirm-modal-message">Are you sure you want to delete this item? This
				action cannot be undone.</p>
			<div class="confirm-modal-actions">
				<button type="button" class="button button-quiet" id="confirm-modal-cancel">Cancel</button>
				<button type="button" class="button button-danger" id="confirm-modal-proceed">Delete</button>
			</div>
		</div>
	</div>

	<!-- Floating Theme Toggle Button -->
	<button class="theme-toggle floating-theme-toggle" type="button" data-theme-toggle aria-label="Toggle theme mode"
		title="Toggle theme mode">
		<span class="theme-icon theme-icon-moon" aria-hidden="true">&#x263E;</span>
		<span class="theme-icon theme-icon-sun" aria-hidden="true">&#x2600;</span>
		<span class="floating-theme-tooltip">
			<span class="theme-toggle-text theme-label-dark">Dark Mode</span>
			<span class="theme-toggle-text theme-label-light">Light Mode</span>
		</span>
	</button>
</body>

</html>
