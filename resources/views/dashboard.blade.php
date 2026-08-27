<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>SPP Admin Dashboard</title>

	<script>
		(function() {
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
	<script src="{{ asset('admin/app.js') }}?v={{ file_exists(public_path('admin/app.js')) ? filemtime(public_path('admin/app.js')) : time() }}" defer></script>
</head>

<body>
	<a class="skip-link" href="#main-content">Skip to content</a>

	<div class="dashboard-shell">
		<header class="mobile-topbar" data-mobile-header>
			<div class="topbar-inner">
				<button class="menu-toggle" type="button" aria-label="Toggle menu" data-menu-toggle>
					<span class="menu-toggle-icon" aria-hidden="true">&#x2630;</span>
				</button>
				<div class="mobile-brand">SPP Admin</div>
			</div>
		</header>

		<aside class="dashboard-sidebar" data-sidebar>
			<button class="menu-close" type="button" aria-label="Close menu" data-menu-close>&#x00D7;</button>
			<div class="brand-block">
				<div class="brand-mark" aria-hidden="true">SPP</div>
				<div class="brand-copy">
					<p class="eyebrow">Admin</p>
					<h1>Samahang Pisika ng Pilipinas</h1>
					<p class="brand-desc">sample text.</p>
				</div>
			</div>

			<nav class="dashboard-nav" aria-label="Dashboard sections">
				<a href="#news-section" data-nav-link>News</a>
				<a href="#activities-section" data-nav-link>Activities</a>
				<a href="#conferences" data-nav-link>Conferences</a>
			</nav>

			<div class="sidebar-footer">
				<a class="ghost-button" href="{{ route('home') }}" aria-label="Go to user side">
					<span aria-hidden="true">&#x2302;</span>
					<span>Go to User Side</span>
				</a>
				<button class="ghost-button theme-toggle" type="button" data-theme-toggle aria-label="Toggle theme mode">
					<span class="theme-icon theme-icon-moon" aria-hidden="true">&#x263E;</span>
					<span class="theme-icon theme-icon-sun" aria-hidden="true">&#x2600;</span>
					<span class="theme-toggle-text theme-label-dark">Dark Mode</span>
					<span class="theme-toggle-text theme-label-light">Light Mode</span>
				</button>
			</div>
		</aside>

		<main id="main-content" class="dashboard-main">
			<section class="panel editor-panel" id="news-section">
				<div class="panel-view" data-news-view="editor">
					<div class="section-panel-head">
						<div>
							<p class="panel-kicker">News Management</p>
							<h2>News Editor</h2>
							<p>sample text.</p>
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
							<button type="button" class="item-action" data-news-cancel-edit style="display: none;">Cancel Edit</button>
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
								<button type="button" class="button button-secondary draft-btn-restore" data-draft-restore="news">Restore Draft</button>
								<button type="button" class="button button-quiet draft-btn-discard" data-draft-discard="news">Discard</button>
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
							<span>Title</span>
							<input type="text" name="title" placeholder="sample text" required />
						</label>

						<label class="field-row">
							<span>Summary</span>
							<textarea name="summary" rows="2" placeholder="sample text"></textarea>
						</label>

						<label class="field-row">
							<span>Publish date</span>
							<input type="date" name="publishDate" />
						</label>

						<div class="field-row field-row-wide">
							<span class="field-label">Article Body</span>
							<div class="rich-editor-wrap" data-rich-editor="body">
								<div class="editor-toolbar" role="toolbar" aria-label="Article body formatting toolbar">
									<button type="button" class="toolbar-btn" data-format="bold" title="Bold (**text**)" aria-label="Bold"><strong>B</strong></button>
									<button type="button" class="toolbar-btn" data-format="italic" title="Italic (*text*)" aria-label="Italic"><em>I</em></button>
									<button type="button" class="toolbar-btn" data-format="underline" title="Underline (<u>text</u>)" aria-label="Underline"><u>U</u></button>
									<button type="button" class="toolbar-btn" data-format="h1" title="Heading 1 (# Title)" aria-label="Heading 1">H1</button>
									<button type="button" class="toolbar-btn" data-format="h2" title="Heading 2 (## Subtitle)" aria-label="Heading 2">H2</button>
									<button type="button" class="toolbar-btn" data-format="ul" title="Bullet List (- item)" aria-label="Bullet List"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><circle cx="3.5" cy="6" r="1.5" fill="currentColor"></circle><circle cx="3.5" cy="12" r="1.5" fill="currentColor"></circle><circle cx="3.5" cy="18" r="1.5" fill="currentColor"></circle></svg></button>
									<button type="button" class="toolbar-btn" data-format="ol" title="Numbered List (1. item)" aria-label="Numbered List"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="10" y1="6" x2="21" y2="6"></line><line x1="10" y1="12" x2="21" y2="12"></line><line x1="10" y1="18" x2="21" y2="18"></line><path d="M4 6h1v4M4 10h2" stroke-width="1.6"></path><path d="M4 14h2a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H4v1h3" stroke-width="1.6"></path></svg></button>
									<button type="button" class="toolbar-btn" data-format="blockquote" title="Blockquote (> text)" aria-label="Blockquote"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2H4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2 0 4-1 6-1 8z" fill="currentColor" stroke="none"></path><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2h-4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2 0 4-1 6-1 8z" fill="currentColor" stroke="none"></path></svg></button>
									<button type="button" class="toolbar-btn" data-format="code" title="Inline code (`code`)" aria-label="Code">&lt;/&gt;</button>
									<button type="button" class="toolbar-btn" data-format="hr" title="Horizontal rule (---)" aria-label="Horizontal Rule">&#x2014;</button>
									<button type="button" class="toolbar-btn" data-format="link" title="Link ([text](url))" aria-label="Link">&#x1F517;</button>
									<button type="button" class="toolbar-btn" data-format="image" title="Image (![alt](url))" aria-label="Image">&#x1F5BC;</button>
									<button type="button" class="toolbar-btn" data-format="table" title="Insert table" aria-label="Table"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="3" y1="15" x2="21" y2="15"></line><line x1="9" y1="3" x2="9" y2="21"></line><line x1="15" y1="3" x2="15" y2="21"></line></svg></button>
									<button type="button" class="toolbar-btn" data-format="footnote" title="Footnote ([^1])" aria-label="Footnote">fn</button>
									<button type="button" class="toolbar-btn" data-format="highlight" title="Highlight (==text==)" aria-label="Highlight"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 11-6 6v3h3l6-6"></path><path d="m22 7-4.5-4.5a2.12 2.12 0 0 0-3 0L10 7l7 7 4.5-4.5a2.12 2.12 0 0 0 0-3z"></path><line x1="14" y1="20" x2="22" y2="20" stroke-width="2.5" stroke="#f59e0b"></line></svg></button>
									<button type="button" class="toolbar-btn" data-format="sub" title="Subscript (~text~)" aria-label="Subscript">X<sub>2</sub></button>
									<button type="button" class="toolbar-btn" data-format="sup" title="Superscript (^text^)" aria-label="Superscript">X<sup>2</sup></button>
								</div>
								<textarea name="body" rows="8" placeholder="sample text."></textarea>
							</div>
						</div>

						<div class="field-row field-row-wide">
							<span class="field-label">Cover Image</span>
							<div class="image-upload-zone" id="news-image-zone" data-upload-zone="news" tabindex="0" role="button" aria-label="Click or drag an image here to upload">
								<div class="image-upload-placeholder" data-upload-placeholder="news">
									<span class="upload-icon" aria-hidden="true">&#x1F5BC;</span>
									<span>Click to upload or drag &amp; drop</span>
									<small>PNG, JPG, GIF, WebP &mdash; max 5 MB</small>
								</div>
								<img class="image-upload-preview is-hidden" data-upload-preview="news" alt="Cover image preview" />
								<input type="file" name="coverImage" accept="image/*" class="image-upload-input" data-upload-input="news" aria-label="Upload cover image" />
							</div>
							<div class="image-upload-actions is-hidden" data-upload-actions="news">
								<span class="image-upload-filename" data-upload-filename="news"></span>
								<button type="button" class="item-action danger" data-upload-clear="news">Remove image</button>
							</div>
						</div>

						<div class="form-actions">
							<button type="submit" class="button button-primary" data-news-submit-primary>Save & Publish</button>
							<button type="submit" class="button button-secondary" data-status-override="draft" data-news-submit-secondary>Save as Draft</button>
							<button type="reset" class="button button-quiet">Reset</button>
						</div>
					</form>
				</div>

				<div class="panel-view is-hidden" data-news-view="posts">
					<div class="section-panel-head">
						<div>
							<p class="panel-kicker">News Management</p>
							<h2>All News Posts</h2>
							<p>sample text.</p>
						</div>
						<div>
							<button type="button" class="button button-primary" data-show-news-editor>
								&#x2190; Back to News Editor
							</button>
						</div>
					</div>

					<div class="posts-view-wrapper">
						<div class="queue-toolbar">
							<div class="queue-filters" aria-label="News filters">
								<button type="button" class="filter-tab active" data-news-filter="all">All (<span data-news-filter-all-count>0</span>)</button>
								<button type="button" class="filter-tab" data-news-filter="published">Published (<span data-news-filter-published-count>0</span>)</button>
								<button type="button" class="filter-tab" data-news-filter="scheduled">Scheduled (<span data-news-filter-scheduled-count>0</span>)</button>
								<button type="button" class="filter-tab" data-news-filter="draft">Drafts (<span data-news-filter-draft-count>0</span>)</button>
								<button type="button" class="filter-tab" data-news-filter="archived">Archived (<span data-news-filter-archived-count>0</span>)</button>
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
							<div class="queue-pagination-actions" style="display: flex; gap: 10px; align-items: center;">
								<button type="button" class="button button-secondary" data-news-load-more>Show More</button>
								<button type="button" class="button button-secondary" data-news-show-less style="display: none;">Show Less</button>
							</div>
						</div>
					</div>
				</div>
			</section>

			<section class="panel editor-panel" id="activities-section">
				<div class="panel-view" data-activity-view="editor">
					<div class="section-panel-head">
						<div>
							<p class="panel-kicker">Activities Management</p>
							<h2>Activities Editor</h2>
							<p>sample text.</p>
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
							<button type="button" class="item-action" data-activity-cancel-edit style="display: none;">Cancel Edit</button>
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
							<span>Activity Title</span>
							<input type="text" name="title" placeholder="sample text" required />
						</label>

						<label class="field-row">
							<span>Summary</span>
							<textarea name="summary" rows="2" placeholder="sample text"></textarea>
						</label>

						<label class="field-row">
							<span>Event Date</span>
							<input type="date" name="publishDate" />
						</label>

						<div class="field-row field-row-wide">
							<span class="field-label">Event Details</span>
							<div class="rich-editor-wrap" data-rich-editor="activity-body">
								<div class="editor-toolbar" role="toolbar" aria-label="Event details formatting toolbar">
									<button type="button" class="toolbar-btn" data-format="bold" title="Bold (**text**)" aria-label="Bold"><strong>B</strong></button>
									<button type="button" class="toolbar-btn" data-format="italic" title="Italic (*text*)" aria-label="Italic"><em>I</em></button>
									<button type="button" class="toolbar-btn" data-format="underline" title="Underline (<u>text</u>)" aria-label="Underline"><u>U</u></button>
									<button type="button" class="toolbar-btn" data-format="h1" title="Heading 1 (# Title)" aria-label="Heading 1">H1</button>
									<button type="button" class="toolbar-btn" data-format="h2" title="Heading 2 (## Subtitle)" aria-label="Heading 2">H2</button>
									<button type="button" class="toolbar-btn" data-format="ul" title="Bullet List (- item)" aria-label="Bullet List"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><circle cx="3.5" cy="6" r="1.5" fill="currentColor"></circle><circle cx="3.5" cy="12" r="1.5" fill="currentColor"></circle><circle cx="3.5" cy="18" r="1.5" fill="currentColor"></circle></svg></button>
									<button type="button" class="toolbar-btn" data-format="ol" title="Numbered List (1. item)" aria-label="Numbered List"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="10" y1="6" x2="21" y2="6"></line><line x1="10" y1="12" x2="21" y2="12"></line><line x1="10" y1="18" x2="21" y2="18"></line><path d="M4 6h1v4M4 10h2" stroke-width="1.6"></path><path d="M4 14h2a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H4v1h3" stroke-width="1.6"></path></svg></button>
									<button type="button" class="toolbar-btn" data-format="blockquote" title="Blockquote (> text)" aria-label="Blockquote"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2H4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2 0 4-1 6-1 8z" fill="currentColor" stroke="none"></path><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2h-4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2 0 4-1 6-1 8z" fill="currentColor" stroke="none"></path></svg></button>
									<button type="button" class="toolbar-btn" data-format="code" title="Inline code (`code`)" aria-label="Code">&lt;/&gt;</button>
									<button type="button" class="toolbar-btn" data-format="hr" title="Horizontal rule (---)" aria-label="Horizontal Rule">&#x2014;</button>
									<button type="button" class="toolbar-btn" data-format="link" title="Link ([text](url))" aria-label="Link">&#x1F517;</button>
									<button type="button" class="toolbar-btn" data-format="image" title="Image (![alt](url))" aria-label="Image">&#x1F5BC;</button>
									<button type="button" class="toolbar-btn" data-format="table" title="Insert table" aria-label="Table"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="3" y1="15" x2="21" y2="15"></line><line x1="9" y1="3" x2="9" y2="21"></line><line x1="15" y1="3" x2="15" y2="21"></line></svg></button>
									<button type="button" class="toolbar-btn" data-format="footnote" title="Footnote ([^1])" aria-label="Footnote">fn</button>
									<button type="button" class="toolbar-btn" data-format="highlight" title="Highlight (==text==)" aria-label="Highlight"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 11-6 6v3h3l6-6"></path><path d="m22 7-4.5-4.5a2.12 2.12 0 0 0-3 0L10 7l7 7 4.5-4.5a2.12 2.12 0 0 0 0-3z"></path><line x1="14" y1="20" x2="22" y2="20" stroke-width="2.5" stroke="#f59e0b"></line></svg></button>
									<button type="button" class="toolbar-btn" data-format="sub" title="Subscript (~text~)" aria-label="Subscript">X<sub>2</sub></button>
									<button type="button" class="toolbar-btn" data-format="sup" title="Superscript (^text^)" aria-label="Superscript">X<sup>2</sup></button>
								</div>
								<textarea name="body" rows="6" placeholder="sample text."></textarea>
							</div>
						</div>

						<div class="field-row field-row-wide">
							<span class="field-label">Cover Image</span>
							<div class="image-upload-zone" id="activity-image-zone" data-upload-zone="activity" tabindex="0" role="button" aria-label="Click or drag an image here to upload">
								<div class="image-upload-placeholder" data-upload-placeholder="activity">
									<span class="upload-icon" aria-hidden="true">&#x1F5BC;</span>
									<span>Click to upload or drag &amp; drop</span>
									<small>PNG, JPG, GIF, WebP &mdash; max 5 MB</small>
								</div>
								<img class="image-upload-preview is-hidden" data-upload-preview="activity" alt="Cover image preview" />
								<input type="file" name="coverImage" accept="image/*" class="image-upload-input" data-upload-input="activity" aria-label="Upload cover image" />
							</div>
							<div class="image-upload-actions is-hidden" data-upload-actions="activity">
								<span class="image-upload-filename" data-upload-filename="activity"></span>
								<button type="button" class="item-action danger" data-upload-clear="activity">Remove image</button>
							</div>
						</div>

						<div class="form-actions">
							<button type="submit" class="button button-primary" data-activity-submit-primary>Save & Publish</button>
							<button type="submit" class="button button-secondary" data-status-override="scheduled" data-activity-submit-secondary>Save as Scheduled</button>
							<button type="reset" class="button button-quiet">Reset</button>
						</div>
					</form>
				</div>

				<div class="panel-view is-hidden" data-activity-view="posts">
					<div class="section-panel-head">
						<div>
							<p class="panel-kicker">Activities Management</p>
							<h2>All Activities</h2>
							<p>sample text.</p>
						</div>
						<div>
							<button type="button" class="button button-primary" data-show-activity-editor>
								&#x2190; Back to Activities Editor
							</button>
						</div>
					</div>

					<div class="posts-view-wrapper">
						<div class="queue-toolbar">
							<div class="queue-filters" aria-label="Activity filters">
								<button type="button" class="filter-tab active" data-activity-filter="all">All (<span data-activity-filter-all-count>0</span>)</button>
								<button type="button" class="filter-tab" data-activity-filter="published">Published (<span data-activity-filter-published-count>0</span>)</button>
								<button type="button" class="filter-tab" data-activity-filter="scheduled">Scheduled (<span data-activity-filter-scheduled-count>0</span>)</button>
								<button type="button" class="filter-tab" data-activity-filter="draft">Drafts (<span data-activity-filter-draft-count>0</span>)</button>
								<button type="button" class="filter-tab" data-activity-filter="archived">Archived (<span data-activity-filter-archived-count>0</span>)</button>
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
							<div class="queue-pagination-actions" style="display: flex; gap: 10px; align-items: center;">
								<button type="button" class="button button-secondary" data-activity-load-more>Show More</button>
								<button type="button" class="button button-secondary" data-activity-show-less style="display: none;">Show Less</button>
							</div>
						</div>
					</div>
				</div>
			</section>

			<section class="panel conference-panel" id="conferences">
				<div class="section-panel-head">
					<div>
						<p class="panel-kicker">SPP Conferences</p>
						<h2>Conference Years Management</h2>
						<p>sample text.</p>
					</div>
				</div>

				<div class="conference-toolbar">
					<div class="conference-years-group" aria-label="Conference choices">
						<span class="conference-years-label">Conference Portals:</span>
						<a href="{{ route('spp.show', ['year' => '2024']) }}" class="conference-year-btn" target="_blank" aria-label="Open SPP 2024 page">SPP 2024 &#x2197;</a>
						<a href="{{ route('spp.show', ['year' => '2025']) }}" class="conference-year-btn" target="_blank" aria-label="Open SPP 2025 page">SPP 2025 &#x2197;</a>
						<a href="{{ route('spp.show', ['year' => '2026']) }}" class="conference-year-btn active" target="_blank" aria-label="Open SPP 2026 page">SPP 2026 &#x2197;</a>
					</div>
					<button type="button" class="button button-primary" aria-label="Add new conference year">+ Add New SPP Conference (e.g. SPP 2027)</button>
				</div>

				<div class="conference-grid">
					<article class="conference-card">
						<div class="conference-card-head">
							<h3>42nd SPP Physics Conference (SPP 2024)</h3>
							<span class="conference-badge">Archived</span>
						</div>
						<div class="conference-card-meta">
							<span><strong>Location:</strong> sample text</span>
							<span><strong>Date:</strong> sample text</span>
						</div>
						<p>sample text.</p>
						<div class="conference-card-actions">
							<a href="{{ route('spp.show', ['year' => '2024']) }}" class="button button-secondary" target="_blank">View Portal</a>
							<button type="button" class="button button-secondary">Edit Details</button>
						</div>
					</article>

					<article class="conference-card">
						<div class="conference-card-head">
							<h3>43rd SPP Physics Conference (SPP 2025)</h3>
							<span class="conference-badge active">Published</span>
						</div>
						<div class="conference-card-meta">
							<span><strong>Location:</strong> sample text</span>
							<span><strong>Date:</strong> sample text</span>
						</div>
						<p>sample text.</p>
						<div class="conference-card-actions">
							<a href="{{ route('spp.show', ['year' => '2025']) }}" class="button button-secondary" target="_blank">View Portal</a>
							<button type="button" class="button button-secondary">Edit Details</button>
						</div>
					</article>

					<article class="conference-card">
						<div class="conference-card-head">
							<h3>44th SPP Physics Conference (SPP 2026)</h3>
							<span class="conference-badge active">Active Portal</span>
						</div>
						<div class="conference-card-meta">
							<span><strong>Location:</strong> sample text</span>
							<span><strong>Date:</strong> sample text</span>
						</div>
						<p>sample text.</p>
						<div class="conference-card-actions">
							<a href="{{ route('spp.show', ['year' => '2026']) }}" class="button button-secondary" target="_blank">View Portal</a>
							<button type="button" class="button button-secondary">Edit Details</button>
						</div>
					</article>

					<article class="conference-card">
						<div class="conference-card-head">
							<h3>45th SPP Physics Conference (SPP 2027)</h3>
							<span class="conference-badge upcoming">Planned Draft</span>
						</div>
						<div class="conference-card-meta">
							<span><strong>Location:</strong> sample text</span>
							<span><strong>Date:</strong> sample text</span>
						</div>
						<p>sample text.</p>
						<div class="conference-card-actions">
							<button type="button" class="button button-primary">Configure Conference</button>
							<button type="button" class="button button-secondary">Publish Portal</button>
						</div>
					</article>
				</div>
			</section>

			<footer class="site-footer">
			</footer>
		</main>
	</div>
</body>

</html>
