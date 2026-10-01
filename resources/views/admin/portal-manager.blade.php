<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>SPP Membership Portal Manager | Admin</title>

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
	<a class="skip-link" href="#main-content">Skip to content</a>

	<div class="dashboard-shell">
		<!-- Mobile Top Header -->
		<header class="mobile-topbar" data-mobile-header>
			<div class="topbar-inner" style="justify-content: space-between;">
				<div style="display: flex; align-items: center; gap: 10px;">
					<button class="menu-toggle" type="button" aria-label="Toggle menu" data-menu-toggle>
						<span class="menu-toggle-icon" aria-hidden="true">&#x2630;</span>
					</button>
					<div class="mobile-brand">Portal Admin</div>
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

		<!-- Sidebar Navigation -->
		<aside class="dashboard-sidebar" data-sidebar>
			<button class="menu-close" type="button" aria-label="Close menu" data-menu-close>&#x00D7;</button>
			<div class="brand-block">
				<div class="brand-mark" aria-hidden="true">SPP</div>
				<div class="brand-copy">
					<p class="eyebrow">Portal Admin</p>
					<h1>Membership Manager</h1>
				</div>
			</div>

			<nav class="dashboard-nav" aria-label="Portal Admin sections">
				<div class="nav-section-label">Portal Management</div>
				
				<a href="#applications" class="nav-item active" data-portal-tab="applications">
					<span class="nav-icon" aria-hidden="true">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
							<polyline points="14 2 14 8 20 8"></polyline>
							<line x1="16" y1="13" x2="8" y2="13"></line>
							<line x1="16" y1="17" x2="8" y2="17"></line>
						</svg>
					</span>
					<span class="nav-text">Applications</span>
					<span class="nav-badge">4</span>
				</a>

				<a href="#roster" class="nav-item" data-portal-tab="roster">
					<span class="nav-icon" aria-hidden="true">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
							<circle cx="9" cy="7" r="4"></circle>
						</svg>
					</span>
					<span class="nav-text">Member Roster</span>
				</a>

				<a href="#inquiries" class="nav-item" data-portal-tab="inquiries">
					<span class="nav-icon" aria-hidden="true">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
						</svg>
					</span>
					<span class="nav-text">Inquiries</span>
					<span class="nav-badge">6</span>
				</a>

				<a href="#broadcasts" class="nav-item" data-portal-tab="broadcasts">
					<span class="nav-icon" aria-hidden="true">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
							<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
						</svg>
					</span>
					<span class="nav-text">Announcements</span>
				</a>

				<div class="nav-section-label" style="margin-top: 1.25rem;">Navigation</div>
				<a href="{{ route('admin') }}" class="nav-item">
					<span class="nav-icon" aria-hidden="true">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
							<line x1="19" y1="12" x2="5" y2="12"></line>
							<polyline points="12 19 5 12 12 5"></polyline>
						</svg>
					</span>
					<span class="nav-text">Back to CMS Admin</span>
				</a>
			</nav>

			<div class="sidebar-footer">
				@auth
					<div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; background: var(--surface-soft); border-radius: var(--radius-md); border: 1px solid var(--border); font-size: 0.85rem;">
						<div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
							<div style="font-weight: 700; color: var(--accent-strong); font-size: 0.88rem;">{{ auth()->user()->name }}</div>
							<div style="color: var(--muted); font-size: 0.78rem;">{{ auth()->user()->email }}</div>
						</div>
						<span style="background: #1b7a4c; color: #fff; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; padding: 2px 7px; border-radius: var(--radius-pill); letter-spacing: 0.04em;">Admin</span>
					</div>
				@endauth

				@auth
					<form method="POST" action="{{ route('logout') }}" style="margin: 0;">
						@csrf
						<button type="submit" class="ghost-button" style="color: var(--danger); border-color: rgba(220, 53, 69, 0.25);" aria-label="Log out of admin session">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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

		<!-- Main Content Area -->
		<main id="main-content" class="dashboard-main">
			<!-- SECTION HEAD -->
			<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: 12px;">
				<div>
					<p class="panel-kicker" style="font-size: 0.8rem; font-weight: 800; text-transform: uppercase; color: var(--muted); letter-spacing: 0.05em; margin: 0 0 4px 0;">Membership System &amp; Self-Service Administration</p>
					<h1 style="font-size: 1.75rem; font-weight: 900; color: var(--accent-strong); margin: 0;">Member Portal Management</h1>
				</div>
				<div style="display: flex; gap: 10px; align-items: center;">
					<span style="font-size: 0.75rem; background: rgba(27, 122, 76, 0.12); color: #1b7a4c; border: 1px solid rgba(27, 122, 76, 0.3); padding: 4px 10px; border-radius: var(--radius-pill); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">Dedicated Admin View</span>
				</div>
			</div>

			<!-- Main Content Panels Container -->
			<div style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 24px; box-shadow: var(--shadow);" id="portal-panels-wrapper">
				<!-- TAB 1: APPLICATIONS -->
				<div data-portal-panel="applications">
					<!-- Pending Applications Widget -->
					<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 16px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
						<div>
							<span style="font-size: 0.78rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em;">Pending Applications</span>
							<div style="font-size: 1.8rem; font-weight: 900; color: var(--accent-strong); line-height: 1.1; margin-top: 2px;">4</div>
							<span style="font-size: 0.78rem; color: var(--muted); margin-top: 4px; display: block;">Requires Secretariat Review</span>
						</div>
						<div style="width: 44px; height: 44px; border-radius: var(--radius-md); background: var(--surface); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--accent-strong);">
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
						</div>
					</div>

					<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
						<h3 style="font-size: 1.1rem; font-weight: 800; color: var(--accent-strong); margin: 0;">Membership Applications</h3>
						<div style="display: flex; gap: 8px; align-items: center;">
							<button type="button" class="button button-quiet" style="font-weight: 700; background: var(--surface-soft); font-size: 0.8rem;">All Statuses</button>
							<button type="button" class="button button-primary" style="font-weight: 700; font-size: 0.8rem;">Under Evaluation (1)</button>
							<button type="button" class="button button-quiet" style="font-weight: 700; font-size: 0.8rem;">Pending</button>
							<button type="button" class="button button-quiet" style="font-weight: 700; font-size: 0.8rem;">Approved</button>
						</div>
					</div>

					<div style="overflow-x: auto; border: 1px solid var(--border); border-radius: var(--radius-md);">
						<table style="width: 100%; border-collapse: collapse; font-size: 0.88rem; text-align: left;">
							<thead>
								<tr style="background: var(--surface-soft); border-bottom: 1px solid var(--border); font-size: 0.78rem; text-transform: uppercase; color: var(--muted); letter-spacing: 0.04em;">
									<th style="padding: 12px 16px;">Applicant</th>
									<th style="padding: 12px 16px;">Membership Type</th>
									<th style="padding: 12px 16px;">Institution</th>
									<th style="padding: 12px 16px;">Submitted</th>
									<th style="padding: 12px 16px;">Status</th>
									<th style="padding: 12px 16px; text-align: right;">Actions</th>
								</tr>
							</thead>
							<tbody>
								<tr style="border-bottom: 1px solid var(--border);">
									<td style="padding: 14px 16px;">
										<div style="font-weight: 700; color: var(--accent-strong);">Sample Name</div>
										<div style="font-size: 0.78rem; color: var(--muted);">example@email.com</div>
									</td>
									<td style="padding: 14px 16px;"><span style="background: var(--accent-soft); color: var(--accent-strong); border: 1px solid rgba(27, 122, 76, 0.25); padding: 3px 8px; border-radius: 4px; font-weight: 700; font-size: 0.78rem;">Regular Member</span></td>
									<td style="padding: 14px 16px; color: var(--text);">Sample Institution</td>
									<td style="padding: 14px 16px; color: var(--muted);">MM/DD/YYYY</td>
									<td style="padding: 14px 16px;"><span style="background: rgba(194, 125, 0, 0.12); color: var(--warn); border: 1px solid rgba(194, 125, 0, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">Under Evaluation</span></td>
									<td style="padding: 14px 16px; text-align: right;">
										<button type="button" class="button button-primary" style="padding: 5px 10px; font-size: 0.78rem;" data-open-review-modal>Review</button>
										<button type="button" class="button button-secondary" style="padding: 5px 10px; font-size: 0.78rem;">Approve</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<!-- TAB 2: MEMBER ROSTER -->
				<div data-portal-panel="roster" style="display: none;">
					<!-- Active Members Widget -->
					<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 16px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
						<div>
							<span style="font-size: 0.78rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em;">Active Members</span>
							<div style="font-size: 1.8rem; font-weight: 900; color: var(--accent-strong); line-height: 1.1; margin-top: 2px;">248</div>
							<span style="font-size: 0.78rem; color: var(--muted); margin-top: 4px; display: block;">180 Regular &bull; 52 Student &bull; 16 Life</span>
						</div>
						<div style="width: 44px; height: 44px; border-radius: var(--radius-md); background: var(--surface); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--accent-strong);">
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
						</div>
					</div>

					<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
						<h3 style="font-size: 1.1rem; font-weight: 800; color: var(--accent-strong); margin: 0;">Member Directory &amp; Roster</h3>
						<button type="button" class="button button-primary" style="font-weight: 700; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px;">
							<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							Add Member Manually
						</button>
					</div>

					<div style="overflow-x: auto; border: 1px solid var(--border); border-radius: var(--radius-md);">
						<table style="width: 100%; border-collapse: collapse; font-size: 0.88rem; text-align: left;">
							<thead>
								<tr style="background: var(--surface-soft); border-bottom: 1px solid var(--border); font-size: 0.78rem; text-transform: uppercase; color: var(--muted); letter-spacing: 0.04em;">
									<th style="padding: 12px 16px;">Member ID</th>
									<th style="padding: 12px 16px;">Name &amp; Contact</th>
									<th style="padding: 12px 16px;">Tier</th>
									<th style="padding: 12px 16px;">Affiliation</th>
									<th style="padding: 12px 16px;">Valid Until</th>
									<th style="padding: 12px 16px; text-align: right;">Action</th>
								</tr>
							</thead>
							<tbody>
								<tr style="border-bottom: 1px solid var(--border);">
									<td style="padding: 14px 16px; font-weight: 800; font-family: monospace; color: var(--accent-strong);">SPP-SAMPLE-001</td>
									<td style="padding: 14px 16px;">
										<div style="font-weight: 700; color: var(--accent-strong);">Sample Name</div>
										<div style="font-size: 0.78rem; color: var(--muted);">example@email.com</div>
									</td>
									<td style="padding: 14px 16px;"><span style="background: var(--accent-soft); color: var(--accent-strong); border: 1px solid rgba(27, 122, 76, 0.25); padding: 3px 8px; border-radius: 4px; font-weight: 700; font-size: 0.78rem;">Regular Member</span></td>
									<td style="padding: 14px 16px; color: var(--text);">Sample Institution</td>
									<td style="padding: 14px 16px; color: var(--muted);">MM/DD/YYYY</td>
									<td style="padding: 14px 16px; text-align: right;">
										<button type="button" class="button button-quiet" style="padding: 5px 10px; font-size: 0.78rem;">View Profile</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<!-- TAB 3: INQUIRIES -->
				<div data-portal-panel="inquiries" style="display: none;">
					<!-- Open Inquiries Widget -->
					<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 16px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
						<div>
							<span style="font-size: 0.78rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em;">Open Inquiries</span>
							<div style="font-size: 1.8rem; font-weight: 900; color: var(--accent-strong); line-height: 1.1; margin-top: 2px;">6</div>
							<span style="font-size: 0.78rem; color: var(--muted); margin-top: 4px; display: block;">2 High Priority</span>
						</div>
						<div style="width: 44px; height: 44px; border-radius: var(--radius-md); background: var(--surface); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--accent-strong);">
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
						</div>
					</div>

					<h3 style="font-size: 1.1rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 16px 0;">Member Support Inquiries</h3>
					<div style="display: flex; flex-direction: column; gap: 12px;">
						<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 14px 16px; display: flex; justify-content: space-between; align-items: center;">
							<div>
								<div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
									<span style="font-weight: 800; color: var(--accent-strong); font-size: 0.92rem;">Application Status</span>
									<span style="background: rgba(27, 122, 76, 0.12); color: var(--success); border: 1px solid rgba(27, 122, 76, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">SUBMITTED</span>
								</div>
								<div style="font-size: 0.8rem; color: var(--muted);">From: <strong>Sample Name</strong> (example@email.com) &bull; Submitted: MM/DD/YYYY</div>
							</div>
							<button type="button" class="button button-secondary" style="padding: 6px 12px; font-size: 0.8rem;">Reply</button>
						</div>

						<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 14px 16px; display: flex; justify-content: space-between; align-items: center;">
							<div>
								<div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
									<span style="font-weight: 800; color: var(--accent-strong); font-size: 0.92rem;">Membership Status</span>
									<span style="background: rgba(194, 125, 0, 0.12); color: var(--warn); border: 1px solid rgba(194, 125, 0, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">UNDER REVIEW</span>
								</div>
								<div style="font-size: 0.8rem; color: var(--muted);">From: <strong>Sample Name</strong> (example@email.com) &bull; Submitted: MM/DD/YYYY</div>
							</div>
							<button type="button" class="button button-secondary" style="padding: 6px 12px; font-size: 0.8rem;">Reply</button>
						</div>

						<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 14px 16px; display: flex; justify-content: space-between; align-items: center;">
							<div>
								<div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
									<span style="font-weight: 800; color: var(--accent-strong); font-size: 0.92rem;">Request for Certificate of Membership</span>
									<span style="background: rgba(59, 130, 246, 0.12); color: #1d4ed8; padding: 2px 8px; border-radius: 10px; font-size: 0.7rem; font-weight: 800;">RESPONDED</span>
								</div>
								<div style="font-size: 0.8rem; color: var(--muted);">From: <strong>Sample Name</strong> (example@email.com) &bull; Submitted: MM/DD/YYYY</div>
							</div>
							<button type="button" class="button button-secondary" style="padding: 6px 12px; font-size: 0.8rem;">View Thread</button>
						</div>

						<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 14px 16px; display: flex; justify-content: space-between; align-items: center;">
							<div>
								<div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
									<span style="font-weight: 800; color: var(--accent-strong); font-size: 0.92rem;">Other</span>
									<span style="background: rgba(107, 114, 128, 0.12); color: #4b5563; padding: 2px 8px; border-radius: 10px; font-size: 0.7rem; font-weight: 800;">CLOSED</span>
								</div>
								<div style="font-size: 0.8rem; color: var(--muted);">From: <strong>Sample Name</strong> (example@email.com) &bull; Submitted: MM/DD/YYYY</div>
							</div>
							<button type="button" class="button button-secondary" style="padding: 6px 12px; font-size: 0.8rem;">View Details</button>
						</div>
					</div>
				</div>

				<!-- TAB 4: BROADCASTS -->
				<div data-portal-panel="broadcasts" style="display: none;">
					<form style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px; margin-bottom: 20px;">
						<h4 style="margin: 0 0 12px; color: var(--accent-strong); font-size: 1rem; font-weight: 800;">Post Portal Notification / Announcement</h4>
						<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 12px;">
							<label style="font-size: 0.8rem; font-weight: 700; color: var(--muted);">NOTIFICATION TITLE
								<input type="text" value="Additional Information Required" style="width: 100%; margin-top: 4px; padding: 8px 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text);" />
							</label>
							<label style="font-size: 0.8rem; font-weight: 700; color: var(--muted);">TARGET AUDIENCE
								<select style="width: 100%; margin-top: 4px; padding: 8px 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text);">
									<option value="all">All Applicants &amp; Members</option>
									<option value="regular">Regular Members Only</option>
								</select>
							</label>
						</div>
						<label style="font-size: 0.8rem; font-weight: 700; color: var(--muted); display: block; margin-bottom: 12px;">NOTIFICATION MESSAGE
							<textarea rows="3" style="width: 100%; margin-top: 4px; padding: 8px 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text); resize: vertical;">Please review your application.</textarea>
						</label>
						<button type="button" class="button button-primary" style="font-weight: 700;">Send Notification</button>
					</form>

					<div style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 16px;">
						<h4 style="margin: 0 0 12px; color: var(--accent-strong); font-size: 0.95rem; font-weight: 800;">Recent Notifications History</h4>
						<ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px;">
							<li style="background: var(--surface-soft); padding: 12px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
								<strong>Application Submitted</strong> — <span style="color: var(--muted);">Your application was submitted.</span>
							</li>
							<li style="background: var(--surface-soft); padding: 12px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
								<strong>Application Under Evaluation</strong> — <span style="color: var(--muted);">Your application is currently being reviewed.</span>
							</li>
							<li style="background: var(--surface-soft); padding: 12px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
								<strong>Additional Information Required</strong> — <span style="color: var(--muted);">Please review your application.</span>
							</li>
						</ul>
					</div>
				</div>

			</div>
		</main>
	</div>

	<!-- Floating Theme Toggle Button -->
	<button class="theme-toggle floating-theme-toggle" type="button" data-theme-toggle aria-label="Toggle theme mode" title="Toggle theme mode">
		<span class="theme-icon theme-icon-moon" aria-hidden="true">&#x263E;</span>
		<span class="theme-icon theme-icon-sun" aria-hidden="true">&#x2600;</span>
		<span class="floating-theme-tooltip">
			<span class="theme-toggle-text theme-label-dark">Dark Mode</span>
			<span class="theme-toggle-text theme-label-light">Light Mode</span>
		</span>
	</button>

	<!-- Review Application Details Modal -->
	<div id="review-application-modal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0, 0, 0, 0.75); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px; overflow-y: auto;">
		<div style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); max-width: 950px; width: 100%; max-height: 90vh; display: flex; flex-direction: column; box-shadow: var(--shadow); overflow: hidden; margin: auto;">
			<!-- Modal Header -->
			<div style="padding: 18px 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; background: var(--surface-soft);">
				<div>
					<span style="font-size: 0.75rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em;">Membership Application Review</span>
					<h2 style="font-size: 1.3rem; font-weight: 900; color: var(--accent-strong); margin: 2px 0 0 0;">Sample Name</h2>
				</div>
				<button type="button" data-close-review-modal style="background: none; border: none; font-size: 1.5rem; color: var(--muted); cursor: pointer; padding: 4px 8px; line-height: 1;" aria-label="Close modal">&times;</button>
			</div>

			<!-- Modal Body (Cards Grid matching exact screenshot sections) -->
			<div style="padding: 24px; overflow-y: auto; display: flex; flex-direction: column; gap: 20px;">
				<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 20px;">
					<!-- 1. Membership Information -->
					<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px;">
						<h4 style="font-size: 0.95rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 14px 0; border-bottom: 1px solid var(--border); padding-bottom: 8px;">Membership Information</h4>
						<div style="display: flex; flex-direction: column; gap: 12px;">
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Membership Type</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">Regular Member</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Application Type</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">Sample Application</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Application Date</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">MM/DD/YYYY</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted); margin-bottom: 4px;">Application Status</div>
								<span style="background: rgba(194, 125, 0, 0.12); color: var(--warn); border: 1px solid rgba(194, 125, 0, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">Under Evaluation</span>
							</div>
						</div>
					</div>

					<!-- 2. Recommender -->
					<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px;">
						<h4 style="font-size: 0.95rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 14px 0; border-bottom: 1px solid var(--border); padding-bottom: 8px;">Recommender</h4>
						<div style="display: flex; flex-direction: column; gap: 12px;">
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Name</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">Sample Name</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Email</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">example@email.com</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Suffix</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">Sample</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Alternate Recommender</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">Sample Name</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted); margin-bottom: 4px;">Recommender Status</div>
								<span style="background: rgba(59, 130, 246, 0.12); color: #1d4ed8; border: 1px solid rgba(59, 130, 246, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800;">Pending</span>
							</div>
						</div>
					</div>

					<!-- 3. Personal Information -->
					<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px;">
						<h4 style="font-size: 0.95rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 14px 0; border-bottom: 1px solid var(--border); padding-bottom: 8px;">Personal Information</h4>
						<div style="display: flex; flex-direction: column; gap: 12px;">
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Surname</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">Sample</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">First Name(s)</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">Sample Name</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Middle Name(s)</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">Sample</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Mobile Number</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">Sample</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Email Address</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">example@email.com</div>
							</div>
						</div>
					</div>

					<!-- 4. Professional Information -->
					<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px;">
						<h4 style="font-size: 0.95rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 14px 0; border-bottom: 1px solid var(--border); padding-bottom: 8px;">Professional Information</h4>
						<div style="display: flex; flex-direction: column; gap: 12px;">
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Current Institutional Affiliation</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">Sample Institution</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Current Position</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">Sample</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Professional / Institutional Email</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">example@email.com</div>
							</div>
						</div>
					</div>

					<!-- 5. Educational Information -->
					<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px;">
						<h4 style="font-size: 0.95rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 14px 0; border-bottom: 1px solid var(--border); padding-bottom: 8px;">Educational Information</h4>
						<div style="display: flex; flex-direction: column; gap: 12px;">
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Highest Educational Attainment</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">Sample</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Degree</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">Sample</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Date Degree Obtained</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">MM/DD/YYYY</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Institution</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">Sample Institution</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Institution Address</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">Sample</div>
							</div>
						</div>
					</div>

					<!-- 6. Documents -->
					<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px;">
						<h4 style="font-size: 0.95rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 14px 0; border-bottom: 1px solid var(--border); padding-bottom: 8px;">Documents</h4>
						<div style="display: flex; flex-direction: column; gap: 14px;">
							<div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed var(--border); padding-bottom: 10px;">
								<span style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong);">Updated CV</span>
								<span style="background: rgba(27, 122, 76, 0.12); color: var(--success); border: 1px solid rgba(27, 122, 76, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">Submitted</span>
							</div>
							<div style="display: flex; justify-content: space-between; align-items: center;">
								<span style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong);">Proof of Employment / Enrollment</span>
								<span style="background: rgba(27, 122, 76, 0.12); color: var(--success); border: 1px solid rgba(27, 122, 76, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">Submitted</span>
							</div>
						</div>
					</div>

					<!-- 7. Validation / Certification -->
					<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px;">
						<h4 style="font-size: 0.95rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 14px 0; border-bottom: 1px solid var(--border); padding-bottom: 8px;">Validation / Certification</h4>
						<div style="display: flex; flex-direction: column; gap: 12px;">
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Declaration</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">Agreed</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Certification</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;">Confirmed</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal Footer Actions -->
			<div style="padding: 16px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; background: var(--surface-soft);">
				<button type="button" class="button button-secondary" data-close-review-modal style="font-weight: 700; font-size: 0.85rem;">Close</button>
				<button type="button" class="button button-primary" style="font-weight: 700; font-size: 0.85rem;" onclick="alert('Application approved successfully.'); document.getElementById('review-application-modal').style.display='none';">Approve Application</button>
			</div>
		</div>
	</div>

	<!-- Script for Sidebar Tab Switching, Mobile Menu & Review Modal -->
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const navLinks = document.querySelectorAll('[data-portal-tab]');
			const panels = document.querySelectorAll('[data-portal-panel]');
			const sidebar = document.querySelector('[data-sidebar]');
			const menuToggle = document.querySelector('[data-menu-toggle]');
			const menuClose = document.querySelector('[data-menu-close]');

			navLinks.forEach(link => {
				link.addEventListener('click', function(e) {
					e.preventDefault();
					const targetTab = this.getAttribute('data-portal-tab');

					// Update active class on nav links
					navLinks.forEach(l => l.classList.toggle('active', l === link));

					// Show target panel
					panels.forEach(panel => {
						const isMatch = panel.getAttribute('data-portal-panel') === targetTab;
						panel.style.display = isMatch ? 'block' : 'none';
					});

					// Close sidebar on mobile
					if (sidebar && sidebar.classList.contains('is-open')) {
						sidebar.classList.remove('is-open');
					}
				});
			});

			if (menuToggle && sidebar) {
				menuToggle.addEventListener('click', function() {
					sidebar.classList.add('is-open');
				});
			}

			if (menuClose && sidebar) {
				menuClose.addEventListener('click', function() {
					sidebar.classList.remove('is-open');
				});
			}

			// Review Modal Handlers
			const reviewModal = document.getElementById('review-application-modal');
			const openModalBtns = document.querySelectorAll('[data-open-review-modal]');
			const closeModalBtns = document.querySelectorAll('[data-close-review-modal]');

			openModalBtns.forEach(btn => {
				btn.addEventListener('click', function() {
					if (reviewModal) {
						reviewModal.style.display = 'flex';
					}
				});
			});

			closeModalBtns.forEach(btn => {
				btn.addEventListener('click', function() {
					if (reviewModal) {
						reviewModal.style.display = 'none';
					}
				});
			});

			if (reviewModal) {
				reviewModal.addEventListener('click', function(e) {
					if (e.target === reviewModal) {
						reviewModal.style.display = 'none';
					}
				});
			}
		});
	</script>
</body>

</html>
