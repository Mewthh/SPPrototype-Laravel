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
							<span style="font-size: 0.78rem; color: var(--muted); margin-top: 4px; display: block;">180 Regular &bull; 52 Associate &bull; 16 Institutional</span>
						</div>
						<div style="width: 44px; height: 44px; border-radius: var(--radius-md); background: var(--surface); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--accent-strong);">
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
						</div>
					</div>

					<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 12px;">
						<h3 style="font-size: 1.1rem; font-weight: 800; color: var(--accent-strong); margin: 0;">Member Directory &amp; Roster</h3>
						<button type="button" class="button button-primary" style="font-weight: 700; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px;">
							<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							Add Member Manually
						</button>
					</div>
					<div style="display: flex; gap: 8px; align-items: center; margin-bottom: 16px; flex-wrap: wrap;" data-roster-filters>
						<button type="button" class="button button-primary" style="font-weight: 700; font-size: 0.8rem;" data-roster-filter="all" aria-pressed="true">All</button>
						<button type="button" class="button button-quiet" style="font-weight: 700; font-size: 0.8rem;" data-roster-filter="regular" aria-pressed="false">Regular</button>
						<button type="button" class="button button-quiet" style="font-weight: 700; font-size: 0.8rem;" data-roster-filter="associate" aria-pressed="false">Associate</button>
						<button type="button" class="button button-quiet" style="font-weight: 700; font-size: 0.8rem;" data-roster-filter="institutional" aria-pressed="false">Institutional</button>
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
								<tr style="border-bottom: 1px solid var(--border);" data-member-tier="regular">
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
					<!-- KPI Summary Cards Grid -->
					<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; margin-bottom: 22px;">
						<!-- Total Inquiries -->
						<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 16px 18px;">
							<span style="font-size: 0.75rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em;">Total Inquiries</span>
							<div style="font-size: 1.7rem; font-weight: 900; color: var(--accent-strong); line-height: 1.1; margin-top: 4px;" data-inquiry-total-count>6</div>
							<span style="font-size: 0.75rem; color: var(--muted); margin-top: 4px; display: block;">Across all query types</span>
						</div>

						<!-- Needs Attention / Submitted -->
						<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 16px 18px;">
							<span style="font-size: 0.75rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em;">Awaiting Response</span>
							<div style="font-size: 1.7rem; font-weight: 900; color: var(--accent-strong); line-height: 1.1; margin-top: 4px;">1</div>
							<span style="font-size: 0.75rem; color: var(--muted); margin-top: 4px; display: block;">Requires action</span>
						</div>

						<!-- Under Review -->
						<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 16px 18px;">
							<span style="font-size: 0.75rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em;">Under Review</span>
							<div style="font-size: 1.7rem; font-weight: 900; color: var(--accent-strong); line-height: 1.1; margin-top: 4px;">2</div>
							<span style="font-size: 0.75rem; color: var(--muted); margin-top: 4px; display: block;">Assigned to Secretariat</span>
						</div>

						<!-- Certificates Requested -->
						<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 16px 18px;">
							<span style="font-size: 0.75rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em;">Certificates Requested</span>
							<div style="font-size: 1.7rem; font-weight: 900; color: var(--accent-strong); line-height: 1.1; margin-top: 4px;">1</div>
							<span style="font-size: 0.75rem; color: var(--muted); margin-top: 4px; display: block;">Official endorsement</span>
						</div>
					</div>

					<!-- Section Header & Filter Toolbar -->
					<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
						<div>
							<h3 style="font-size: 1.15rem; font-weight: 800; color: var(--accent-strong); margin: 0;">Member Support &amp; Inquiries</h3>
							<p style="font-size: 0.8rem; color: var(--muted); margin: 3px 0 0;">Tickets filed through the Membership Portal and Join SPP application inquiries.</p>
						</div>

						<!-- Status Filter Tabs -->
						<div style="display: flex; gap: 6px; align-items: center; flex-wrap: wrap;">
							<button type="button" class="button button-primary" style="font-weight: 700; font-size: 0.8rem;" data-inquiry-status-filter="all" aria-pressed="true">All (6)</button>
							<button type="button" class="button button-quiet" style="font-weight: 700; font-size: 0.8rem;" data-inquiry-status-filter="Submitted" aria-pressed="false">Submitted (1)</button>
							<button type="button" class="button button-quiet" style="font-weight: 700; font-size: 0.8rem;" data-inquiry-status-filter="Under Review" aria-pressed="false">Under Review (2)</button>
							<button type="button" class="button button-quiet" style="font-weight: 700; font-size: 0.8rem;" data-inquiry-status-filter="Responded" aria-pressed="false">Responded (2)</button>
							<button type="button" class="button button-quiet" style="font-weight: 700; font-size: 0.8rem;" data-inquiry-status-filter="Closed" aria-pressed="false">Closed (1)</button>
						</div>
					</div>

					<!-- Secondary Filter Toolbar (Query Type & Search) -->
					<div style="display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 16px; flex-wrap: wrap; background: var(--surface-soft); padding: 12px 14px; border: 1px solid var(--border); border-radius: var(--radius-md);">
						<!-- Query Type Dropdown Filter (Matching portal/inquiries.blade.php) -->
						<div style="display: flex; align-items: center; gap: 8px;">
							<label for="inquiry-type-select" style="font-size: 0.78rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em;">Query Type:</label>
							<select id="inquiry-type-select" data-inquiry-type-filter style="padding: 6px 12px; font-size: 0.82rem; font-weight: 600; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text);">
								<option value="all">All Query Types</option>
								<option value="Application Status">Application Status</option>
								<option value="Membership Status">Membership Status</option>
								<option value="Request for Certificate of Membership">Request for Certificate of Membership</option>
								<option value="Other">Other</option>
							</select>
						</div>

						<!-- Search Filter Input -->
						<div style="display: flex; align-items: center; gap: 8px; flex: 1; max-width: 360px; min-width: 240px;">
							<div style="position: relative; width: 100%;">
								<input type="search" placeholder="Search by name, email, institution, or remarks…" data-inquiry-search style="width: 100%; padding: 7px 12px 7px 32px; font-size: 0.82rem; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text); box-sizing: border-box;" />
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
							</div>
						</div>
					</div>

					<!-- Inquiries Table (Streamlined, clean & not overcrowded) -->
					<div style="overflow-x: auto; border: 1px solid var(--border); border-radius: var(--radius-md);">
						<table style="width: 100%; border-collapse: collapse; font-size: 0.88rem; text-align: left;">
							<thead>
								<tr style="background: var(--surface-soft); border-bottom: 1px solid var(--border); font-size: 0.78rem; text-transform: uppercase; color: var(--muted); letter-spacing: 0.04em;">
									<th style="padding: 12px 16px;">Inquirer</th>
									<th style="padding: 12px 16px;">Query Type</th>
									<th style="padding: 12px 16px;">Date Submitted</th>
									<th style="padding: 12px 16px;">Status</th>
									<th style="padding: 12px 16px; text-align: right;">Action</th>
								</tr>
							</thead>
							<tbody id="inquiries-table-body">
								<!-- Ticket 1 -->
								<tr style="border-bottom: 1px solid var(--border);"
									data-inquiry-row
									data-ticket-id="INQ-1042"
									data-inquirer-name="Dr. Aris C. Morales"
									data-inquirer-email="a.morales@nip.upd.edu.ph"
									data-inquirer-institution="National Institute of Physics, UP Diliman"
									data-inquirer-tier="Regular Member"
									data-application-type="Status Upgrade"
									data-query-type="Application Status"
									data-date="10/01/2025"
									data-status="Submitted"
									data-priority="High"
									data-remarks="Following up on Stage 4 document validation for my Regular Member upgrade submitted last Sept 28. Has the endorsement letter from the SPP Fellow been verified by the secretariat?"
									data-response="">
									<td style="padding: 14px 16px;">
										<div style="font-weight: 700; color: var(--accent-strong);">Dr. Aris C. Morales</div>
										<div style="font-size: 0.78rem; color: var(--muted);">a.morales@nip.upd.edu.ph</div>
									</td>
									<td style="padding: 14px 16px; color: var(--text);">
										Application Status
									</td>
									<td style="padding: 14px 16px; color: var(--muted);">
										10/01/2025
									</td>
									<td style="padding: 14px 16px;">
										<span class="inquiry-status-tag" style="background: rgba(245, 158, 11, 0.12); color: var(--warn); border: 1px solid rgba(194, 125, 0, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">Submitted</span>
									</td>
									<td style="padding: 14px 16px; text-align: right;">
										<button type="button" class="button button-primary" style="padding: 5px 12px; font-size: 0.78rem;" data-open-inquiry-modal>View</button>
									</td>
								</tr>

								<!-- Ticket 2 -->
								<tr style="border-bottom: 1px solid var(--border);"
									data-inquiry-row
									data-ticket-id="INQ-1041"
									data-inquirer-name="Maria Elena Santos"
									data-inquirer-email="mesantos@admu.edu.ph"
									data-inquirer-institution="Department of Physics, Ateneo de Manila University"
									data-inquirer-tier="Associate Member"
									data-application-type="Membership Renewal"
									data-query-type="Membership Status"
									data-date="09/29/2025"
									data-status="Under Review"
									data-priority="Normal"
									data-remarks="I would like to inquire about the renewal procedure for 2026 Associate Membership and if early renewals qualify for the annual conference registration discount."
									data-response="Secretariat reviewing renewal schedule. Advised member that early renewal window opens Nov 1 with early-bird conference rates.">
									<td style="padding: 14px 16px;">
										<div style="font-weight: 700; color: var(--accent-strong);">Maria Elena Santos</div>
										<div style="font-size: 0.78rem; color: var(--muted);">mesantos@admu.edu.ph</div>
									</td>
									<td style="padding: 14px 16px; color: var(--text);">
										Membership Status
									</td>
									<td style="padding: 14px 16px; color: var(--muted);">
										09/29/2025
									</td>
									<td style="padding: 14px 16px;">
										<span class="inquiry-status-tag" style="background: rgba(194, 125, 0, 0.12); color: var(--warn); border: 1px solid rgba(194, 125, 0, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">Under Review</span>
									</td>
									<td style="padding: 14px 16px; text-align: right;">
										<button type="button" class="button button-primary" style="padding: 5px 12px; font-size: 0.78rem;" data-open-inquiry-modal>View</button>
									</td>
								</tr>

								<!-- Ticket 3 -->
								<tr style="border-bottom: 1px solid var(--border);"
									data-inquiry-row
									data-ticket-id="INQ-1040"
									data-inquirer-name="Prof. Raymond C. Cruz"
									data-inquirer-email="raymond.cruz@dlsu.edu.ph"
									data-inquirer-institution="De La Salle University - Manila"
									data-inquirer-tier="Regular Member"
									data-application-type="New Application"
									data-query-type="Request for Certificate of Membership"
									data-date="09/26/2025"
									data-status="Under Review"
									data-priority="High"
									data-remarks="Requesting an official digital Certificate of Good Standing and Active Membership for faculty promotion and research grant dossier submission at DLSU."
									data-response="Certificate generated and queued for officer digital signature.">
									<td style="padding: 14px 16px;">
										<div style="font-weight: 700; color: var(--accent-strong);">Prof. Raymond C. Cruz</div>
										<div style="font-size: 0.78rem; color: var(--muted);">raymond.cruz@dlsu.edu.ph</div>
									</td>
									<td style="padding: 14px 16px; color: var(--text);">
										Request for Certificate of Membership
									</td>
									<td style="padding: 14px 16px; color: var(--muted);">
										09/26/2025
									</td>
									<td style="padding: 14px 16px;">
										<span class="inquiry-status-tag" style="background: rgba(194, 125, 0, 0.12); color: var(--warn); border: 1px solid rgba(194, 125, 0, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">Under Review</span>
									</td>
									<td style="padding: 14px 16px; text-align: right;">
										<button type="button" class="button button-primary" style="padding: 5px 12px; font-size: 0.78rem;" data-open-inquiry-modal>View</button>
									</td>
								</tr>

								<!-- Ticket 4 -->
								<tr style="border-bottom: 1px solid var(--border);"
									data-inquiry-row
									data-ticket-id="INQ-1039"
									data-inquirer-name="Engr. Gabriel Tan"
									data-inquirer-email="gabriel.tan@ust.edu.ph"
									data-inquirer-institution="University of Santo Tomas"
									data-inquirer-tier="Associate Member"
									data-application-type="New Application"
									data-query-type="Application Status"
									data-date="09/22/2025"
									data-status="Responded"
									data-priority="Normal"
									data-remarks="Uploaded the bank transfer receipt for the membership application fee via Join SPP Stage 4. Kindly confirm receipt and advise next steps for portal access."
									data-response="Dear Engr. Tan, Payment of PHP 800 has been verified by the Secretariat. Your application is now marked Approved. Welcome to SPP!">
									<td style="padding: 14px 16px;">
										<div style="font-weight: 700; color: var(--accent-strong);">Engr. Gabriel Tan</div>
										<div style="font-size: 0.78rem; color: var(--muted);">gabriel.tan@ust.edu.ph</div>
									</td>
									<td style="padding: 14px 16px; color: var(--text);">
										Application Status
									</td>
									<td style="padding: 14px 16px; color: var(--muted);">
										09/22/2025
									</td>
									<td style="padding: 14px 16px;">
										<span class="inquiry-status-tag" style="background: rgba(27, 122, 76, 0.12); color: var(--success); border: 1px solid rgba(27, 122, 76, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">Responded</span>
									</td>
									<td style="padding: 14px 16px; text-align: right;">
										<button type="button" class="button button-primary" style="padding: 5px 12px; font-size: 0.78rem;" data-open-inquiry-modal>View</button>
									</td>
								</tr>

								<!-- Ticket 5 -->
								<tr style="border-bottom: 1px solid var(--border);"
									data-inquiry-row
									data-ticket-id="INQ-1038"
									data-inquirer-name="Dr. Patricia Gomez"
									data-inquirer-email="pgomez@clsu.edu.ph"
									data-inquirer-institution="Central Luzon State University"
									data-inquirer-tier="Institutional Member"
									data-application-type="Membership Renewal"
									data-query-type="Other"
									data-date="09/18/2025"
									data-status="Responded"
									data-priority="Normal"
									data-remarks="We need to update our institutional primary representative contact and add two junior faculty researchers to our institutional membership roster."
									data-response="Representative update form sent. Roster additions processed under Institutional tier limit.">
									<td style="padding: 14px 16px;">
										<div style="font-weight: 700; color: var(--accent-strong);">Dr. Patricia Gomez</div>
										<div style="font-size: 0.78rem; color: var(--muted);">pgomez@clsu.edu.ph</div>
									</td>
									<td style="padding: 14px 16px; color: var(--text);">
										Other
									</td>
									<td style="padding: 14px 16px; color: var(--muted);">
										09/18/2025
									</td>
									<td style="padding: 14px 16px;">
										<span class="inquiry-status-tag" style="background: rgba(27, 122, 76, 0.12); color: var(--success); border: 1px solid rgba(27, 122, 76, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">Responded</span>
									</td>
									<td style="padding: 14px 16px; text-align: right;">
										<button type="button" class="button button-primary" style="padding: 5px 12px; font-size: 0.78rem;" data-open-inquiry-modal>View</button>
									</td>
								</tr>

								<!-- Ticket 6 -->
								<tr style="border-bottom: 1px solid var(--border);"
									data-inquiry-row
									data-ticket-id="INQ-1035"
									data-inquirer-name="Kevin Lee"
									data-inquirer-email="klee@mapua.edu.ph"
									data-inquirer-institution="Mapúa University"
									data-inquirer-tier="Associate Member"
									data-application-type="New Application"
									data-query-type="Other"
									data-date="09/10/2025"
									data-status="Closed"
									data-priority="Low"
									data-remarks="Inquiry regarding password reset link and 2FA recovery code for the portal account. Resolved via automated link."
									data-response="Automated one-time authentication code sent to registered university email. User successfully logged into the Membership Portal. Ticket closed.">
									<td style="padding: 14px 16px;">
										<div style="font-weight: 700; color: var(--accent-strong);">Kevin Lee</div>
										<div style="font-size: 0.78rem; color: var(--muted);">klee@mapua.edu.ph</div>
									</td>
									<td style="padding: 14px 16px; color: var(--text);">
										Other
									</td>
									<td style="padding: 14px 16px; color: var(--muted);">
										09/10/2025
									</td>
									<td style="padding: 14px 16px;">
										<span class="inquiry-status-tag" style="background: rgba(107, 114, 128, 0.12); color: var(--muted); border: 1px solid rgba(107, 114, 128, 0.25); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">Closed</span>
									</td>
									<td style="padding: 14px 16px; text-align: right;">
										<button type="button" class="button button-primary" style="padding: 5px 12px; font-size: 0.78rem;" data-open-inquiry-modal>View</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					<!-- Empty State (when search/filters return 0) -->
					<div id="inquiries-empty-state" style="display: none; padding: 40px 20px; text-align: center; color: var(--muted); background: var(--surface-soft); border: 1px dashed var(--border); border-radius: var(--radius-md); margin-top: 14px;">
						<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 10px; opacity: 0.5;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
						<p style="font-weight: 800; margin: 0; color: var(--accent-strong);">No inquiries found</p>
						<span style="font-size: 0.82rem; margin-top: 4px; display: block;">Try adjusting your query type, status filters, or search terms.</span>
					</div>
				</div>

			<!-- TAB 4: BROADCASTS / ANNOUNCEMENTS -->
				<div data-portal-panel="broadcasts" style="display: none;">

					<!-- VIEW 1: Compose / Editor -->
					<div data-announce-view="editor">
						<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
							<div>
								<p class="panel-kicker" style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: var(--muted); letter-spacing: 0.05em; margin: 0 0 2px;">Portal Announcements</p>
								<h3 style="font-size: 1.25rem; font-weight: 800; color: var(--accent-strong); margin: 0;">New Announcement</h3>
							</div>
							<button type="button" class="button button-secondary" style="font-weight: 700; font-size: 0.85rem;" data-announce-show-posts>
								View Posts (<span data-announce-count>7</span>)
							</button>
						</div>

						<form style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 20px; display: flex; flex-direction: column; gap: 16px;">
							<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
								<label style="font-size: 0.8rem; font-weight: 700; color: var(--muted); display: flex; flex-direction: column; gap: 6px;">
									<span>TITLE <span style="font-weight: 400; opacity: 0.6;">(max 100 chars)</span></span>
									<input type="text" placeholder="Announcement title…" required maxlength="100" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text); box-sizing: border-box;" />
								</label>
								<label style="font-size: 0.8rem; font-weight: 700; color: var(--muted); display: flex; flex-direction: column; gap: 6px;">
									<span>TARGET AUDIENCE</span>
									<select style="width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text); box-sizing: border-box;">
										<option value="all">All Applicants &amp; Members</option>
										<option value="regular">Regular Members Only</option>
										<option value="associate">Associate Members Only</option>
										<option value="institutional">Institutional Members Only</option>
									</select>
								</label>
							</div>

							<label style="font-size: 0.8rem; font-weight: 700; color: var(--muted); display: flex; flex-direction: column; gap: 6px;">
								<span>SUMMARY <span style="font-weight: 400; opacity: 0.6;">(Brief overview shown in feeds and notifications)</span></span>
								<input type="text" placeholder="Brief summary of the announcement…" maxlength="200" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text); box-sizing: border-box;" />
							</label>

							<label style="font-size: 0.8rem; font-weight: 700; color: var(--muted); display: flex; flex-direction: column; gap: 6px;">
								<span>ANNOUNCEMENT BODY</span>
								<textarea rows="6" placeholder="Write full announcement details…" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text); resize: vertical; box-sizing: border-box;"></textarea>
							</label>

							<div style="display: flex; gap: 10px; align-items: center; padding-top: 4px;">
								<button type="button" class="button button-primary" style="font-weight: 700; padding: 9px 20px;">Publish Announcement</button>
								<button type="button" class="button button-quiet" style="font-weight: 700; padding: 9px 16px;">Save as Draft</button>
							</div>
						</form>
					</div>

					<!-- VIEW 2: Posts List (SPP Admin Queue Pattern) -->
					<div data-announce-view="posts" style="display: none;">
						<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
							<div>
								<p class="panel-kicker" style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: var(--muted); letter-spacing: 0.05em; margin: 0 0 2px;">Portal Announcements</p>
								<h3 style="font-size: 1.25rem; font-weight: 800; color: var(--accent-strong); margin: 0;">All Announcements</h3>
							</div>
							<button type="button" class="button button-primary" style="font-weight: 700; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px;" data-announce-show-editor>
								<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
								Create
							</button>
						</div>

						<div class="posts-view-wrapper">
							<!-- Filter Toolbar -->
							<div class="queue-toolbar">
								<div class="queue-filters" aria-label="Announcement filters">
									<button type="button" class="filter-tab active" data-announce-filter="all">All (<span data-announce-filter-all-count>7</span>)</button>
									<button type="button" class="filter-tab" data-announce-filter="published">Published (<span data-announce-filter-published-count>6</span>)</button>
									<button type="button" class="filter-tab" data-announce-filter="draft">Drafts (<span data-announce-filter-draft-count>1</span>)</button>
									<button type="button" class="filter-tab" data-announce-filter="archived">Archived (<span data-announce-filter-archived-count>0</span>)</button>
								</div>
							</div>

							<!-- Table Header -->
							<div class="queue-table-head" aria-hidden="true">
								<span>Title &amp; Summary</span>
								<span>Status</span>
								<span>Date</span>
								<span>Actions</span>
							</div>

							<!-- Summarized Posts List -->
							<div class="queue-list" data-announce-list>

								<!-- Post 1 -->
								<article class="queue-row" data-announce-row data-status="published">
									<div class="queue-cell queue-title">
										<strong>Annual Conference 2025 – Registration Now Open</strong>
										<span>We are pleased to announce that registration for the SPP Annual National Physics Conference 2025 is now open! Early-bird registration ends October 15, 2025.</span>
									</div>
									<div class="queue-cell queue-status">
										<span class="post-tag" data-status="published">Published</span>
									</div>
									<div class="queue-cell queue-date">Sep 30, 2025</div>
									<div class="queue-cell queue-actions">
										<button type="button" class="item-action">Edit</button>
										<button type="button" class="item-action danger">Delete</button>
									</div>
								</article>

								<!-- Post 2 -->
								<article class="queue-row" data-announce-row data-status="published">
									<div class="queue-cell queue-title">
										<strong>Membership Renewal for 2026</strong>
										<span>Members are reminded that membership renewals for the year 2026 will begin on November 1, 2025. Please ensure contact details are updated.</span>
									</div>
									<div class="queue-cell queue-status">
										<span class="post-tag" data-status="published">Published</span>
									</div>
									<div class="queue-cell queue-date">Sep 15, 2025</div>
									<div class="queue-cell queue-actions">
										<button type="button" class="item-action">Edit</button>
										<button type="button" class="item-action danger">Delete</button>
									</div>
								</article>

								<!-- Post 3 -->
								<article class="queue-row" data-announce-row data-status="published">
									<div class="queue-cell queue-title">
										<strong>Call for Papers – SPP 2025</strong>
										<span>The SPP invites submissions of abstracts for oral and poster presentations at the 2025 Annual Conference across multiple physics disciplines.</span>
									</div>
									<div class="queue-cell queue-status">
										<span class="post-tag" data-status="published">Published</span>
									</div>
									<div class="queue-cell queue-date">Sep 01, 2025</div>
									<div class="queue-cell queue-actions">
										<button type="button" class="item-action">Edit</button>
										<button type="button" class="item-action danger">Delete</button>
									</div>
								</article>

								<!-- Post 4 -->
								<article class="queue-row" data-announce-row data-status="published">
									<div class="queue-cell queue-title">
										<strong>Welcome to the SPP Membership Portal</strong>
										<span>We are excited to launch the new SPP Membership Portal where you can track application status, view certificates, and manage records.</span>
									</div>
									<div class="queue-cell queue-status">
										<span class="post-tag" data-status="published">Published</span>
									</div>
									<div class="queue-cell queue-date">Aug 20, 2025</div>
									<div class="queue-cell queue-actions">
										<button type="button" class="item-action">Edit</button>
										<button type="button" class="item-action danger">Delete</button>
									</div>
								</article>

								<!-- Post 5 -->
								<article class="queue-row" data-announce-row data-status="published">
									<div class="queue-cell queue-title">
										<strong>SPP Research Grant Applications Open</strong>
										<span>Applications for the 2025 Research Grant Program are officially open for student researchers and faculty-led initiatives.</span>
									</div>
									<div class="queue-cell queue-status">
										<span class="post-tag" data-status="published">Published</span>
									</div>
									<div class="queue-cell queue-date">Jul 10, 2025</div>
									<div class="queue-cell queue-actions">
										<button type="button" class="item-action">Edit</button>
										<button type="button" class="item-action danger">Delete</button>
									</div>
								</article>

								<!-- Post 6 -->
								<article class="queue-row" data-announce-row data-status="published" style="display: none;">
									<div class="queue-cell queue-title">
										<strong>New Partnership with National Research Council</strong>
										<span>The SPP is proud to announce a new partnership with the National Research Council of the Philippines to expand opportunities.</span>
									</div>
									<div class="queue-cell queue-status">
										<span class="post-tag" data-status="published">Published</span>
									</div>
									<div class="queue-cell queue-date">Jun 05, 2025</div>
									<div class="queue-cell queue-actions">
										<button type="button" class="item-action">Edit</button>
										<button type="button" class="item-action danger">Delete</button>
									</div>
								</article>

								<!-- Post 7 -->
								<article class="queue-row" data-announce-row data-status="draft" style="display: none;">
									<div class="queue-cell queue-title">
										<strong>Physics Olympiad Coaching Program</strong>
										<span>SPP will be conducting a coaching program for students joining the International Physics Olympiad (IPhO) 2026. Draft proposal awaiting review.</span>
									</div>
									<div class="queue-cell queue-status">
										<span class="post-tag" data-status="draft">Draft</span>
									</div>
									<div class="queue-cell queue-date">May 18, 2025</div>
									<div class="queue-cell queue-actions">
										<button type="button" class="item-action">Edit</button>
										<button type="button" class="item-action danger">Delete</button>
									</div>
								</article>

							</div>

							<!-- Pagination / Show More -->
							<div class="queue-pagination" data-announce-pagination style="display: flex; justify-content: space-between; align-items: center; padding-top: 8px;">
								<span class="pagination-info" data-announce-pagination-info style="color: var(--muted); font-size: 0.85rem;">Showing 5 of 7 posts</span>
								<div class="queue-pagination-actions" style="display: flex; gap: 10px; align-items: center;">
									<button type="button" class="button button-secondary" data-announce-load-more style="font-size: 0.82rem; font-weight: 700;">Show More</button>
									<button type="button" class="button button-secondary" data-announce-show-less style="display: none; font-size: 0.82rem; font-weight: 700;">Show Less</button>
								</div>
							</div>

						</div>
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

	<!-- Inquiry Details & Secretariat Response Modal -->
	<div id="inquiry-detail-modal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0, 0, 0, 0.75); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px; overflow-y: auto;">
		<div style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); max-width: 900px; width: 100%; max-height: 90vh; display: flex; flex-direction: column; box-shadow: var(--shadow); overflow: hidden; margin: auto;">
			<!-- Modal Header -->
			<div style="padding: 18px 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; background: var(--surface-soft);">
				<div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
					<div>
						<div style="display: flex; align-items: center; gap: 8px;">
							<span style="font-size: 0.75rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em;" id="modal-ticket-id">Ticket #INQ-1042</span>
							<span id="modal-priority-badge" style="display: none; background: rgba(220, 38, 38, 0.1); color: #dc2626; border: 1px solid rgba(220, 38, 38, 0.25); padding: 2px 8px; border-radius: var(--radius-pill); font-size: 0.7rem; font-weight: 800; letter-spacing: 0.03em;">HIGH PRIORITY</span>
							<span id="modal-query-badge" style="background: rgba(37, 99, 235, 0.1); color: #2563eb; border: 1px solid rgba(37, 99, 235, 0.25); padding: 2px 8px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800;">Application Status</span>
						</div>
						<h2 style="font-size: 1.25rem; font-weight: 900; color: var(--accent-strong); margin: 3px 0 0 0;" id="modal-inquirer-name">Dr. Aris C. Morales</h2>
					</div>
				</div>
				<div style="display: flex; align-items: center; gap: 10px;">
					<span id="modal-status-badge" style="background: rgba(245, 158, 11, 0.12); color: #b45309; border: 1px solid rgba(245, 158, 11, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">SUBMITTED</span>
					<button type="button" data-close-inquiry-modal style="background: none; border: none; font-size: 1.5rem; color: var(--muted); cursor: pointer; padding: 4px 8px; line-height: 1;" aria-label="Close modal">&times;</button>
				</div>
			</div>

			<!-- Modal Body -->
			<div style="padding: 24px; overflow-y: auto; display: flex; flex-direction: column; gap: 20px;">
				<!-- Inquirer & Join SPP Application Context -->
				<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px;">
					<div>
						<div style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); letter-spacing: 0.04em;">Inquirer Contact</div>
						<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-inquirer-email">a.morales@nip.upd.edu.ph</div>
						<div style="font-size: 0.78rem; color: var(--muted); margin-top: 2px;" id="modal-inquirer-institution">National Institute of Physics, UP Diliman</div>
					</div>
					<div>
						<div style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); letter-spacing: 0.04em;">Membership Tier</div>
						<div style="display: flex; align-items: center; gap: 6px; margin-top: 2px;">
							<span style="background: var(--accent-soft); color: var(--accent-strong); border: 1px solid rgba(27, 122, 76, 0.25); padding: 2px 8px; border-radius: 4px; font-weight: 800; font-size: 0.76rem;" id="modal-inquirer-tier">Regular Member</span>
						</div>
						<div style="font-size: 0.78rem; color: var(--muted); margin-top: 2px;">Application: <strong id="modal-app-type" style="color: var(--accent-strong);">Status Upgrade</strong></div>
					</div>
					<div>
						<div style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); letter-spacing: 0.04em;">Date Filed in Portal</div>
						<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-submitted-date">Oct 01, 2025</div>
						<div style="font-size: 0.78rem; color: var(--muted); margin-top: 2px;">Channel: Self-Service Portal</div>
					</div>
				</div>

				<!-- Member's Inquiry Remarks -->
				<div style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px;">
					<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
						<span style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: var(--muted); letter-spacing: 0.04em;">Member's Remarks &amp; Inquiry</span>
						<span style="font-size: 0.75rem; color: var(--muted);">Direct from Membership Portal Support</span>
					</div>
					<div style="background: var(--surface-soft); border-left: 3px solid var(--accent); padding: 14px 16px; border-radius: var(--radius-sm); font-size: 0.9rem; color: var(--text); line-height: 1.5;" id="modal-inquiry-remarks">
						Following up on Stage 4 document validation for my Regular Member upgrade submitted last Sept 28. Has the endorsement letter from the SPP Fellow been verified by the secretariat?
					</div>
				</div>

				<!-- Secretariat Response Form -->
				<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 20px;">
					<h4 style="font-size: 0.95rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 14px 0; border-bottom: 1px solid var(--border); padding-bottom: 8px;">Secretariat Action &amp; Response</h4>

					<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 14px; margin-bottom: 14px;">
						<div>
							<label style="font-size: 0.78rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; margin-bottom: 6px;">Update Ticket Status</label>
							<select id="modal-status-select" style="width: 100%; padding: 8px 12px; font-size: 0.85rem; font-weight: 700; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text);">
								<option value="Submitted">Submitted (Awaiting Action)</option>
								<option value="Under Review">Under Review (Investigating)</option>
								<option value="Responded">Responded (Replied to Member)</option>
								<option value="Closed">Closed (Resolved)</option>
							</select>
						</div>
						<div>
							<label style="font-size: 0.78rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; margin-bottom: 6px;">Quick Response Template</label>
							<select id="modal-template-select" style="width: 100%; padding: 8px 12px; font-size: 0.85rem; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text);">
								<option value="">Choose a template or write custom...</option>
								<option value="app_verified">Application Documents Verified - Ready for Council Approval</option>
								<option value="cert_issued">Certificate of Membership Generated &amp; Available</option>
								<option value="renewal_guidance">Renewal Guidelines &amp; Conference Discount Notice</option>
								<option value="more_info">Additional Documents Required for Review</option>
							</select>
						</div>
					</div>

					<div>
						<label style="font-size: 0.78rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; margin-bottom: 6px;">Official Secretariat Response</label>
						<textarea id="modal-response-text" rows="4" placeholder="Write response to be displayed in the member's portal inquiry history…" style="width: 100%; padding: 10px 12px; font-size: 0.88rem; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text); resize: vertical; box-sizing: border-box;"></textarea>
					</div>

					<div style="margin-top: 12px;">
						<label style="font-size: 0.78rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; margin-bottom: 6px;">Internal Secretariat Notes (Private / Admin Only)</label>
						<input type="text" id="modal-internal-notes" placeholder="Optional notes for Secretariat audit trail…" style="width: 100%; padding: 8px 12px; font-size: 0.82rem; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text); box-sizing: border-box;" />
					</div>
				</div>
			</div>

			<!-- Modal Footer Actions -->
			<div style="padding: 16px 24px; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; background: var(--surface-soft); flex-wrap: wrap; gap: 10px;">
				<div style="font-size: 0.78rem; color: var(--muted);">Updates will reflect on the member's inquiry dashboard in real time.</div>
				<div style="display: flex; gap: 10px;">
					<button type="button" class="button button-quiet" data-close-inquiry-modal style="font-weight: 700; font-size: 0.85rem;">Cancel</button>
					<button type="button" class="button button-primary" id="modal-send-response-btn" style="font-weight: 700; font-size: 0.85rem;">Save &amp; Update Inquiry</button>
				</div>
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

			// Roster Tier Filters
			const rosterFilterBtns = document.querySelectorAll('[data-roster-filter]');
			rosterFilterBtns.forEach(btn => {
				btn.addEventListener('click', function() {
					const tier = this.getAttribute('data-roster-filter');

					// Toggle active button styles
					rosterFilterBtns.forEach(b => {
						const isActive = b === btn;
						b.classList.toggle('button-primary', isActive);
						b.classList.toggle('button-quiet', !isActive);
						b.setAttribute('aria-pressed', String(isActive));
					});

					// Filter rows
					document.querySelectorAll('[data-member-tier]').forEach(row => {
						row.style.display = (tier === 'all' || row.getAttribute('data-member-tier') === tier) ? '' : 'none';
					});
				});
			});

			// Announcements View Toggle (Compose ↔ Posts List)
			const announceEditorView = document.querySelector('[data-announce-view="editor"]');
			const announcePostsView = document.querySelector('[data-announce-view="posts"]');
			const showPostsBtn = document.querySelector('[data-announce-show-posts]');
			const showEditorBtn = document.querySelector('[data-announce-show-editor]');

			if (showPostsBtn && announceEditorView && announcePostsView) {
				showPostsBtn.addEventListener('click', function() {
					announceEditorView.style.display = 'none';
					announcePostsView.style.display = 'block';
				});
			}

			if (showEditorBtn && announceEditorView && announcePostsView) {
				showEditorBtn.addEventListener('click', function() {
					announcePostsView.style.display = 'none';
					announceEditorView.style.display = 'block';
				});
			}

			// Announcements Filter & Pagination
			const announceFilterBtns = document.querySelectorAll('[data-announce-filter]');
			const announceRows = document.querySelectorAll('[data-announce-row]');
			const announceLoadMore = document.querySelector('[data-announce-load-more]');
			const announceShowLess = document.querySelector('[data-announce-show-less]');
			const announcePaginationInfo = document.querySelector('[data-announce-pagination-info]');

			let currentFilter = 'all';
			let isExpanded = false;
			const PAGE_LIMIT = 5;

			function updateAnnounceDisplay() {
				const matchingRows = Array.from(announceRows).filter(row => {
					return currentFilter === 'all' || row.getAttribute('data-status') === currentFilter;
				});

				const total = matchingRows.length;
				const limit = isExpanded ? total : Math.min(PAGE_LIMIT, total);

				announceRows.forEach(row => {
					row.style.display = 'none';
				});

				matchingRows.forEach((row, idx) => {
					if (idx < limit) {
						row.style.display = 'grid';
					}
				});

				if (announcePaginationInfo) {
					announcePaginationInfo.textContent = `Showing ${Math.min(limit, total)} of ${total} posts`;
				}

				if (announceLoadMore && announceShowLess) {
					if (total <= PAGE_LIMIT) {
						announceLoadMore.style.display = 'none';
						announceShowLess.style.display = 'none';
					} else if (isExpanded) {
						announceLoadMore.style.display = 'none';
						announceShowLess.style.display = 'inline-flex';
					} else {
						announceLoadMore.style.display = 'inline-flex';
						announceShowLess.style.display = 'none';
					}
				}
			}

			announceFilterBtns.forEach(btn => {
				btn.addEventListener('click', function() {
					currentFilter = this.getAttribute('data-announce-filter');

					announceFilterBtns.forEach(b => {
						b.classList.toggle('active', b === btn);
					});

					isExpanded = false;
					updateAnnounceDisplay();
				});
			});

			if (announceLoadMore) {
				announceLoadMore.addEventListener('click', function() {
					isExpanded = true;
					updateAnnounceDisplay();
				});
			}

			if (announceShowLess) {
				announceShowLess.addEventListener('click', function() {
					isExpanded = false;
					updateAnnounceDisplay();
				});
			}

			updateAnnounceDisplay();

			// --- INQUIRIES MANAGEMENT SCRIPT ---
			const inquiryRows = document.querySelectorAll('[data-inquiry-row]');
			const inquiryStatusFilterBtns = document.querySelectorAll('[data-inquiry-status-filter]');
			const inquiryTypeFilterSelect = document.querySelector('[data-inquiry-type-filter]');
			const inquirySearchInput = document.querySelector('[data-inquiry-search]');
			const inquiriesEmptyState = document.getElementById('inquiries-empty-state');
			const inquiryModal = document.getElementById('inquiry-detail-modal');
			const closeInquiryModalBtns = document.querySelectorAll('[data-close-inquiry-modal]');
			const sendResponseBtn = document.getElementById('modal-send-response-btn');
			const templateSelect = document.getElementById('modal-template-select');
			const responseTextarea = document.getElementById('modal-response-text');

			let activeInquiryStatus = 'all';
			let activeInquiryType = 'all';
			let activeInquirySearch = '';
			let currentActiveRow = null;

			function filterInquiries() {
				let visibleCount = 0;

				inquiryRows.forEach(row => {
					const status = row.getAttribute('data-status') || '';
					const type = row.getAttribute('data-query-type') || '';
					const name = row.getAttribute('data-inquirer-name') || '';
					const email = row.getAttribute('data-inquirer-email') || '';
					const inst = row.getAttribute('data-inquirer-institution') || '';
					const remarks = row.getAttribute('data-remarks') || '';
					const ticket = row.getAttribute('data-ticket-id') || '';

					const matchesStatus = (activeInquiryStatus === 'all' || status === activeInquiryStatus);
					const matchesType = (activeInquiryType === 'all' || type === activeInquiryType);

					const fullText = `${name} ${email} ${inst} ${remarks} ${ticket} ${type}`.toLowerCase();
					const matchesSearch = !activeInquirySearch || fullText.includes(activeInquirySearch.toLowerCase());

					const isVisible = matchesStatus && matchesType && matchesSearch;
					row.style.display = isVisible ? '' : 'none';
					if (isVisible) visibleCount++;
				});

				if (inquiriesEmptyState) {
					inquiriesEmptyState.style.display = visibleCount === 0 ? 'block' : 'none';
				}
			}

			inquiryStatusFilterBtns.forEach(btn => {
				btn.addEventListener('click', function() {
					activeInquiryStatus = this.getAttribute('data-inquiry-status-filter');
					inquiryStatusFilterBtns.forEach(b => {
						const isActive = b === btn;
						b.classList.toggle('button-primary', isActive);
						b.classList.toggle('button-quiet', !isActive);
						b.setAttribute('aria-pressed', String(isActive));
					});
					filterInquiries();
				});
			});

			if (inquiryTypeFilterSelect) {
				inquiryTypeFilterSelect.addEventListener('change', function() {
					activeInquiryType = this.value;
					filterInquiries();
				});
			}

			if (inquirySearchInput) {
				inquirySearchInput.addEventListener('input', function() {
					activeInquirySearch = this.value.trim();
					filterInquiries();
				});
			}

			// Modal Open / Populate
			document.querySelectorAll('[data-open-inquiry-modal]').forEach(btn => {
				btn.addEventListener('click', function() {
					const row = this.closest('[data-inquiry-row]');
					if (!row || !inquiryModal) return;

					currentActiveRow = row;

					const ticketId = row.getAttribute('data-ticket-id') || 'INQ-1000';
					const name = row.getAttribute('data-inquirer-name') || '';
					const email = row.getAttribute('data-inquirer-email') || '';
					const inst = row.getAttribute('data-inquirer-institution') || '';
					const tier = row.getAttribute('data-inquirer-tier') || '';
					const appType = row.getAttribute('data-application-type') || 'New Application';
					const queryType = row.getAttribute('data-query-type') || '';
					const date = row.getAttribute('data-date') || '';
					const status = row.getAttribute('data-status') || 'Submitted';
					const priority = row.getAttribute('data-priority') || 'Normal';
					const remarks = row.getAttribute('data-remarks') || '';
					const response = row.getAttribute('data-response') || '';

					// Populate modal
					document.getElementById('modal-ticket-id').textContent = `Ticket #${ticketId}`;
					document.getElementById('modal-inquirer-name').textContent = name;
					document.getElementById('modal-inquirer-email').textContent = email;
					document.getElementById('modal-inquirer-institution').textContent = inst;
					document.getElementById('modal-inquirer-tier').textContent = tier;
					document.getElementById('modal-app-type').textContent = appType;
					document.getElementById('modal-submitted-date').textContent = date;
					document.getElementById('modal-inquiry-remarks').textContent = remarks;

					const priorityBadge = document.getElementById('modal-priority-badge');
					if (priorityBadge) {
						priorityBadge.style.display = (priority === 'High') ? 'inline-block' : 'none';
					}

					const queryBadge = document.getElementById('modal-query-badge');
					if (queryBadge) {
						queryBadge.textContent = queryType;
						if (queryType === 'Application Status') {
							queryBadge.style.cssText = 'background: rgba(37, 99, 235, 0.1); color: #2563eb; border: 1px solid rgba(37, 99, 235, 0.25); padding: 2px 8px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800;';
						} else if (queryType === 'Membership Status') {
							queryBadge.style.cssText = 'background: rgba(147, 51, 234, 0.1); color: #9333ea; border: 1px solid rgba(147, 51, 234, 0.25); padding: 2px 8px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800;';
						} else if (queryType === 'Request for Certificate of Membership') {
							queryBadge.style.cssText = 'background: rgba(22, 163, 74, 0.1); color: #16a34a; border: 1px solid rgba(22, 163, 74, 0.25); padding: 2px 8px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800;';
						} else {
							queryBadge.style.cssText = 'background: rgba(107, 114, 128, 0.1); color: var(--muted); border: 1px solid var(--border); padding: 2px 8px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800;';
						}
					}

					const statusBadge = document.getElementById('modal-status-badge');
					if (statusBadge) {
						statusBadge.textContent = status.toUpperCase();
						if (status === 'Submitted') {
							statusBadge.style.cssText = 'background: rgba(245, 158, 11, 0.12); color: #b45309; border: 1px solid rgba(245, 158, 11, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;';
						} else if (status === 'Under Review') {
							statusBadge.style.cssText = 'background: rgba(194, 125, 0, 0.12); color: var(--warn); border: 1px solid rgba(194, 125, 0, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;';
						} else if (status === 'Responded') {
							statusBadge.style.cssText = 'background: rgba(27, 122, 76, 0.12); color: var(--success); border: 1px solid rgba(27, 122, 76, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;';
						} else {
							statusBadge.style.cssText = 'background: rgba(107, 114, 128, 0.12); color: var(--muted); border: 1px solid rgba(107, 114, 128, 0.25); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;';
						}
					}

					const statusSelect = document.getElementById('modal-status-select');
					if (statusSelect) statusSelect.value = status;

					if (responseTextarea) responseTextarea.value = response;
					if (templateSelect) templateSelect.value = '';

					inquiryModal.style.display = 'flex';
				});
			});

			// Modal Close
			closeInquiryModalBtns.forEach(btn => {
				btn.addEventListener('click', function() {
					if (inquiryModal) inquiryModal.style.display = 'none';
				});
			});

			if (inquiryModal) {
				inquiryModal.addEventListener('click', function(e) {
					if (e.target === inquiryModal) {
						inquiryModal.style.display = 'none';
					}
				});
			}

			// Template Selection
			if (templateSelect && responseTextarea) {
				templateSelect.addEventListener('change', function() {
					const val = this.value;
					if (val === 'app_verified') {
						responseTextarea.value = 'Dear Member/Applicant, Your submitted application requirements have been verified by the Secretariat. Your dossier is now forwarded for Council evaluation.';
					} else if (val === 'cert_issued') {
						responseTextarea.value = 'Dear Member, Your digital Certificate of Membership and Good Standing has been generated and validated by the SPP Secretariat. You can now download it directly from your Membership Portal.';
					} else if (val === 'renewal_guidance') {
						responseTextarea.value = 'Dear Member, Renewals for the upcoming membership cycle are active. Early renewal qualifies for discounted registration rates for the SPP Annual National Physics Conference.';
					} else if (val === 'more_info') {
						responseTextarea.value = 'Dear Member/Applicant, To complete the processing of your request, please provide the required supplemental document via the portal upload facility.';
					}
				});
			}

			// Save / Update Response
			if (sendResponseBtn) {
				sendResponseBtn.addEventListener('click', function() {
					if (!currentActiveRow) return;

					const newStatus = document.getElementById('modal-status-select').value;
					const newResponse = responseTextarea.value.trim();

					currentActiveRow.setAttribute('data-status', newStatus);
					currentActiveRow.setAttribute('data-response', newResponse);

					// Update tag in row
					const tag = currentActiveRow.querySelector('.inquiry-status-tag');
					if (tag) {
						tag.textContent = newStatus.toUpperCase();
						if (newStatus === 'Submitted') {
							tag.style.cssText = 'background: rgba(245, 158, 11, 0.12); color: #b45309; border: 1px solid rgba(245, 158, 11, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;';
						} else if (newStatus === 'Under Review') {
							tag.style.cssText = 'background: rgba(194, 125, 0, 0.12); color: var(--warn); border: 1px solid rgba(194, 125, 0, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;';
						} else if (newStatus === 'Responded') {
							tag.style.cssText = 'background: rgba(27, 122, 76, 0.12); color: var(--success); border: 1px solid rgba(27, 122, 76, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;';
						} else {
							tag.style.cssText = 'background: rgba(107, 114, 128, 0.12); color: var(--muted); border: 1px solid rgba(107, 114, 128, 0.25); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;';
						}
					}

					inquiryModal.style.display = 'none';
					filterInquiries();
				});
			}
		});
	</script>
</body>

</html>
