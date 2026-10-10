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

	<style>
		/* High-Contrast Category Tab Navigation in Modals */
		.app-cat-tab-btn,
		.inquiry-cat-tab-btn {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			padding: 6px 16px;
			font-size: 0.8rem;
			font-weight: 700;
			line-height: 1.2;
			border-radius: var(--radius-pill);
			cursor: pointer;
			border: 1.5px solid var(--border);
			background: var(--surface);
			color: var(--text);
			transition: all 0.15s ease;
			user-select: none;
			box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
		}

		.app-cat-tab-btn:hover,
		.inquiry-cat-tab-btn:hover {
			border-color: var(--accent);
			color: var(--accent-strong);
			background: var(--accent-soft);
		}

		.app-cat-tab-btn.active,
		.inquiry-cat-tab-btn.active {
			background: var(--accent-strong) !important;
			border-color: var(--accent-strong) !important;
			color: var(--bg-page) !important;
			font-weight: 800 !important;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.18);
		}

		html[data-theme="dark"] .app-cat-tab-btn,
		html[data-theme="dark"] .inquiry-cat-tab-btn {
			background: #18181b;
			color: #f4f4f5;
			border-color: #3f3f46;
		}

		html[data-theme="dark"] .app-cat-tab-btn:hover,
		html[data-theme="dark"] .inquiry-cat-tab-btn:hover {
			background: var(--accent-soft);
			border-color: var(--accent);
			color: var(--accent-strong);
		}

		html[data-theme="dark"] .app-cat-tab-btn.active,
		html[data-theme="dark"] .inquiry-cat-tab-btn.active {
			background: var(--accent-strong) !important;
			border-color: var(--accent-strong) !important;
			color: var(--bg-page) !important;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.35);
		}
	</style>
</head>

<body>
	<!-- Global Floating Toast Notification (Center Top) -->
	<div id="admin-floating-toast" class="floating-toast-container is-hidden" role="status" aria-live="polite">
		<div class="floating-toast-card">
			<span class="floating-toast-icon" aria-hidden="true">&#x2714;</span>
			<div class="floating-toast-content">
				<span class="floating-toast-message" id="admin-floating-toast-message">Saved successfully.</span>
			</div>
			<button type="button" class="floating-toast-close" id="admin-floating-toast-close" aria-label="Dismiss notification">&times;</button>
		</div>
	</div>

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
					<span class="nav-badge" id="nav-applications-count">{{ $applicationCounts['all'] ?? 0 }}</span>
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

					<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
						<h3 style="font-size: 1.1rem; font-weight: 800; color: var(--accent-strong); margin: 0;">Membership Applications</h3>
						<div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;" data-app-filter-buttons>
							<button type="button" class="button button-primary" data-app-filter="all" style="font-weight: 700; font-size: 0.8rem;">All Statuses (<span id="app-count-all">{{ $applicationCounts['all'] ?? 0 }}</span>)</button>
							<button type="button" class="button button-quiet" data-app-filter="Under Evaluation" style="font-weight: 700; font-size: 0.8rem;">Under Evaluation (<span id="app-count-under-eval">{{ $applicationCounts['under_evaluation'] ?? 0 }}</span>)</button>
							<button type="button" class="button button-quiet" data-app-filter="Pending" style="font-weight: 700; font-size: 0.8rem;">Pending (<span id="app-count-pending">{{ $applicationCounts['pending'] ?? 0 }}</span>)</button>
							<button type="button" class="button button-quiet" data-app-filter="Approved" style="font-weight: 700; font-size: 0.8rem;">Approved (<span id="app-count-approved">{{ $applicationCounts['approved'] ?? 0 }}</span>)</button>
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
							<tbody id="applications-table-body">
								@forelse ($applications ?? [] as $app)
									<tr style="border-bottom: 1px solid var(--border);" data-app-row data-app-id="{{ $app->id }}" data-status="{{ $app->status }}">
										<td style="padding: 14px 16px;">
											<div style="font-weight: 700; color: var(--accent-strong);" class="app-row-name">{{ $app->first_name }} {{ $app->surname }}</div>
											<div style="font-size: 0.78rem; color: var(--muted);" class="app-row-email">{{ $app->account_email }}</div>
										</td>
										<td style="padding: 14px 16px;"><span style="background: var(--accent-soft); color: var(--accent-strong); border: 1px solid rgba(27, 122, 76, 0.25); padding: 3px 8px; border-radius: 4px; font-weight: 700; font-size: 0.78rem;">{{ $app->membership_type }}</span></td>
										<td style="padding: 14px 16px; color: var(--text);">{{ $app->current_affiliation ?: '—' }}</td>
										<td style="padding: 14px 16px; color: var(--muted);">{{ $app->created_at?->format('m/d/Y') ?? $app->application_date }}</td>
										<td style="padding: 14px 16px;">
											@if ($app->status === 'Approved')
												<span class="app-status-badge" style="background: rgba(22, 163, 74, 0.12); color: #16a34a; border: 1px solid rgba(22, 163, 74, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">Approved</span>
											@elseif ($app->status === 'Pending')
												<span class="app-status-badge" style="background: rgba(234, 179, 8, 0.12); color: #ca8a04; border: 1px solid rgba(234, 179, 8, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">Pending</span>
											@elseif ($app->status === 'Rejected')
												<span class="app-status-badge" style="background: rgba(239, 68, 68, 0.12); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">Rejected</span>
											@else
												<span class="app-status-badge" style="background: rgba(194, 125, 0, 0.12); color: var(--warn); border: 1px solid rgba(194, 125, 0, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">Under Evaluation</span>
											@endif
										</td>
										<td style="padding: 14px 16px; text-align: right;">
											<button type="button" class="button button-primary" style="padding: 5px 10px; font-size: 0.78rem;" data-open-review-modal data-app-id="{{ $app->id }}">Review</button>
											@if ($app->status !== 'Approved')
												<button type="button" class="button button-secondary" style="padding: 5px 10px; font-size: 0.78rem;" data-quick-approve data-app-id="{{ $app->id }}">Approve</button>
											@endif
										</td>
									</tr>
								@empty
									<tr id="no-applications-row">
										<td colspan="6" style="padding: 32px 16px; text-align: center; color: var(--muted); font-size: 0.9rem;">
											No membership applications found.
										</td>
									</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>

				<!-- TAB 2: MEMBER ROSTER -->
				<div data-portal-panel="roster" style="display: none;">

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
							<tbody id="roster-table-body">
								@forelse ($approvedMembers ?? [] as $member)
									<tr style="border-bottom: 1px solid var(--border);" data-member-tier="{{ strtolower(str_replace(' Member', '', $member->membership_type)) }}">
										<td style="padding: 14px 16px; font-weight: 800; font-family: monospace; color: var(--accent-strong);">SPP-MEM-{{ str_pad($member->id, 4, '0', STR_PAD_LEFT) }}</td>
										<td style="padding: 14px 16px;">
											<div style="font-weight: 700; color: var(--accent-strong);">{{ $member->first_name }} {{ $member->surname }}</div>
											<div style="font-size: 0.78rem; color: var(--muted);">{{ $member->account_email ?: $member->personal_email }}</div>
										</td>
										<td style="padding: 14px 16px;"><span style="background: var(--accent-soft); color: var(--accent-strong); border: 1px solid rgba(27, 122, 76, 0.25); padding: 3px 8px; border-radius: 4px; font-weight: 700; font-size: 0.78rem;">{{ $member->membership_type }}</span></td>
										<td style="padding: 14px 16px; color: var(--text);">{{ $member->current_affiliation ?: '—' }}</td>
										<td style="padding: 14px 16px; color: var(--muted);">{{ $member->updated_at?->addYear()->format('m/d/Y') ?? '—' }}</td>
										<td style="padding: 14px 16px; text-align: right;">
											<button type="button" class="button button-quiet" style="padding: 5px 10px; font-size: 0.78rem;" data-open-review-modal data-app-id="{{ $member->id }}">View Details</button>
										</td>
									</tr>
								@empty
									<tr id="no-roster-row">
										<td colspan="6" style="padding: 32px 16px; text-align: center; color: var(--muted); font-size: 0.9rem;">
											No active members in roster yet.
										</td>
									</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>

				<!-- TAB 3: INQUIRIES -->
				<div data-portal-panel="inquiries" style="display: none;">

					<!-- Section Header & Filter Toolbar -->
					<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
						<div>
							<h3 style="font-size: 1.15rem; font-weight: 800; color: var(--accent-strong); margin: 0;">Member Support &amp; Inquiries</h3>
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

					<!-- Secondary Filter Toolbar (Query Type, Category & Search) -->
					<div style="display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 16px; flex-wrap: wrap; background: var(--surface-soft); padding: 12px 14px; border: 1px solid var(--border); border-radius: var(--radius-md);">
						<div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
							<!-- Inquirer Category Filter (Members vs Applicants) -->
							<div style="display: flex; align-items: center; gap: 8px;">
								<label for="inquiry-category-select" style="font-size: 0.78rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em;">Category:</label>
								<select id="inquiry-category-select" data-inquiry-category-filter style="padding: 6px 12px; font-size: 0.82rem; font-weight: 600; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text);">
									<option value="all">All (Members &amp; Applicants)</option>
									<option value="member">Members (Upgrades &amp; Renewals)</option>
									<option value="applicant">Applicants (New Applications)</option>
								</select>
							</div>

							<!-- Query Type Dropdown Filter (Matching portal/inquiries.blade.php) -->
							<div style="display: flex; align-items: center; gap: 8px;">
								<label for="inquiry-type-select" style="font-size: 0.78rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em;">Query Type:</label>
								<select id="inquiry-type-select" data-inquiry-type-filter style="padding: 6px 12px; font-size: 0.82rem; font-weight: 600; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text);">
									<option value="all">All Query Types</option>
									<option value="Membership Status">Membership Status</option>
									<option value="Request for Certificate of Membership">Request for Certificate of Membership</option>
									<option value="Other">Other</option>
								</select>
							</div>
						</div>

						<!-- Search Filter Input -->
						<div style="display: flex; align-items: center; gap: 8px; flex: 1; max-width: 340px; min-width: 220px;">
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
									data-query-type="Membership Status"
									data-last-known-membership="Regular member"
									data-last-attendance-year="2022"
									data-last-attendance-place="National Institute of Physics, UP Diliman"
									data-date="10/01/2025"
									data-status="Submitted"
									data-priority="High"
									data-remarks="Verifying official membership number and regular membership standing for university faculty tenure and promotion evaluation."
									data-response="">
									<td style="padding: 14px 16px;">
										<div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
											<span style="font-weight: 700; color: var(--accent-strong);">Dr. Aris C. Morales</span>
											<span class="inquiry-cat-tag" style="background: rgba(22, 163, 74, 0.07); color: #15803d; border: 1px solid rgba(22, 163, 74, 0.2); padding: 1px 6px; border-radius: 4px; font-size: 0.68rem; font-weight: 600;">Member</span>
										</div>
										<div style="font-size: 0.78rem; color: var(--muted); margin-top: 2px;">a.morales@nip.upd.edu.ph</div>
									</td>
									<td style="padding: 14px 16px; color: var(--text);">
										Membership Status
									</td>
									<td style="padding: 14px 16px; color: var(--muted);">
										10/01/2025
									</td>
									<td style="padding: 14px 16px;">
										<span class="inquiry-status-tag" style="background: transparent; color: var(--text); border: 1px solid var(--border); padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 600;">Submitted</span>
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
									data-last-known-membership="Associate member"
									data-last-attendance-year="2023"
									data-last-attendance-place="Tagbilaran City, Bohol"
									data-date="09/29/2025"
									data-status="Under Review"
									data-priority="Normal"
									data-remarks="I would like to inquire about the renewal procedure for 2026 Associate Membership and if early renewals qualify for the annual conference registration discount."
									data-response="Secretariat reviewing renewal schedule. Advised member that early renewal window opens Nov 1 with early-bird conference rates.">
									<td style="padding: 14px 16px;">
										<div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
											<span style="font-weight: 700; color: var(--accent-strong);">Maria Elena Santos</span>
											<span class="inquiry-cat-tag" style="background: rgba(22, 163, 74, 0.07); color: #15803d; border: 1px solid rgba(22, 163, 74, 0.2); padding: 1px 6px; border-radius: 4px; font-size: 0.68rem; font-weight: 600;">Member</span>
										</div>
										<div style="font-size: 0.78rem; color: var(--muted); margin-top: 2px;">mesantos@admu.edu.ph</div>
									</td>
									<td style="padding: 14px 16px; color: var(--text);">
										Membership Status
									</td>
									<td style="padding: 14px 16px; color: var(--muted);">
										09/29/2025
									</td>
									<td style="padding: 14px 16px;">
										<span class="inquiry-status-tag" style="background: transparent; color: var(--text); border: 1px solid var(--border); padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 600;">Under Review</span>
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
									data-oath-year="2018"
									data-oath-venue="Ateneo de Davao University, Davao City"
									data-known-membership-type="Regular"
									data-last-attendance-year="2024"
									data-last-attendance-place="Iloilo City"
									data-purpose="Faculty promotion dossier and CHED research grant submission at DLSU."
									data-certificate-attached="SPP_Cert_2025_RaymondCruz.pdf"
									data-certificate-size="245 KB &bull; Certified Copy"
									data-date="09/26/2025"
									data-status="Under Review"
									data-priority="High"
									data-remarks="Requesting an official digital Certificate of Good Standing and Active Membership for faculty promotion and research grant dossier submission at DLSU."
									data-response="Certificate generated and queued for officer digital signature.">
									<td style="padding: 14px 16px;">
										<div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
											<span style="font-weight: 700; color: var(--accent-strong);">Prof. Raymond C. Cruz</span>
											<span class="inquiry-cat-tag" style="background: var(--surface-strong); color: var(--muted); border: 1px solid var(--border); padding: 1px 6px; border-radius: 4px; font-size: 0.68rem; font-weight: 600;">Applicant</span>
										</div>
										<div style="font-size: 0.78rem; color: var(--muted); margin-top: 2px;">raymond.cruz@dlsu.edu.ph</div>
									</td>
									<td style="padding: 14px 16px; color: var(--text);">
										<div>Request for Certificate of Membership</div>
										<div class="row-cert-badge" style="margin-top: 4px; font-size: 0.72rem; color: #16a34a; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; background: rgba(22, 163, 74, 0.08); padding: 2px 7px; border-radius: 4px; border: 1px solid rgba(22, 163, 74, 0.2);">
											<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
											Certificate Attached
										</div>
									</td>
									<td style="padding: 14px 16px; color: var(--muted);">
										09/26/2025
									</td>
									<td style="padding: 14px 16px;">
										<span class="inquiry-status-tag" style="background: transparent; color: var(--text); border: 1px solid var(--border); padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 600;">Under Review</span>
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
									data-query-type="Membership Status"
									data-last-known-membership="Associate member"
									data-last-attendance-year="2023"
									data-last-attendance-place="Online"
									data-date="09/22/2025"
									data-status="Responded"
									data-priority="Normal"
									data-remarks="Verifying if previous 2023 associate attendance qualifies towards regular membership transition requirements."
									data-response="Dear Engr. Tan, The secretariat confirms your 2023 associate participation is recorded and eligible for regular membership upgrade.">
									<td style="padding: 14px 16px;">
										<div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
											<span style="font-weight: 700; color: var(--accent-strong);">Engr. Gabriel Tan</span>
											<span class="inquiry-cat-tag" style="background: var(--surface-strong); color: var(--muted); border: 1px solid var(--border); padding: 1px 6px; border-radius: 4px; font-size: 0.68rem; font-weight: 600;">Applicant</span>
										</div>
										<div style="font-size: 0.78rem; color: var(--muted); margin-top: 2px;">gabriel.tan@ust.edu.ph</div>
									</td>
									<td style="padding: 14px 16px; color: var(--text);">
										Membership Status
									</td>
									<td style="padding: 14px 16px; color: var(--muted);">
										09/22/2025
									</td>
									<td style="padding: 14px 16px;">
										<span class="inquiry-status-tag" style="background: rgba(22, 163, 74, 0.07); color: #15803d; border: 1px solid rgba(22, 163, 74, 0.18); padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 600;">Responded</span>
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
									data-keywords="fee, institutional roster"
									data-date="09/18/2025"
									data-status="Responded"
									data-priority="Normal"
									data-remarks="We need to update our institutional primary representative contact and add two junior faculty researchers to our institutional membership roster."
									data-response="Representative update form sent. Roster additions processed under Institutional tier limit.">
									<td style="padding: 14px 16px;">
										<div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
											<span style="font-weight: 700; color: var(--accent-strong);">Dr. Patricia Gomez</span>
											<span class="inquiry-cat-tag" style="background: rgba(22, 163, 74, 0.07); color: #15803d; border: 1px solid rgba(22, 163, 74, 0.2); padding: 1px 6px; border-radius: 4px; font-size: 0.68rem; font-weight: 600;">Member</span>
										</div>
										<div style="font-size: 0.78rem; color: var(--muted); margin-top: 2px;">pgomez@clsu.edu.ph</div>
									</td>
									<td style="padding: 14px 16px; color: var(--text);">
										Other
									</td>
									<td style="padding: 14px 16px; color: var(--muted);">
										09/18/2025
									</td>
									<td style="padding: 14px 16px;">
										<span class="inquiry-status-tag" style="background: rgba(22, 163, 74, 0.07); color: #15803d; border: 1px solid rgba(22, 163, 74, 0.18); padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 600;">Responded</span>
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
									data-keywords="password reset, 2FA recovery"
									data-date="09/10/2025"
									data-status="Closed"
									data-priority="Low"
									data-remarks="Inquiry regarding password reset link and 2FA recovery code for the portal account. Resolved via automated link."
									data-response="Automated one-time authentication code sent to registered university email. User successfully logged into the Membership Portal. Ticket closed.">
									<td style="padding: 14px 16px;">
										<div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
											<span style="font-weight: 700; color: var(--accent-strong);">Kevin Lee</span>
											<span class="inquiry-cat-tag" style="background: var(--surface-strong); color: var(--muted); border: 1px solid var(--border); padding: 1px 6px; border-radius: 4px; font-size: 0.68rem; font-weight: 600;">Applicant</span>
										</div>
										<div style="font-size: 0.78rem; color: var(--muted); margin-top: 2px;">klee@mapua.edu.ph</div>
									</td>
									<td style="padding: 14px 16px; color: var(--text);">
										Other
									</td>
									<td style="padding: 14px 16px; color: var(--muted);">
										09/10/2025
									</td>
									<td style="padding: 14px 16px;">
										<span class="inquiry-status-tag" style="background: var(--surface-strong); color: var(--muted); border: 1px solid var(--border); padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 600;">Closed</span>
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
								<h3 style="font-size: 1.25rem; font-weight: 800; color: var(--accent-strong); margin: 0;" data-announce-form-title>New Announcement</h3>
							</div>
							<button type="button" class="button button-secondary" style="font-weight: 700; font-size: 0.85rem;" data-announce-show-posts>
								View Posts (<span data-announce-count>{{ $announcementCounts['all'] ?? 0 }}</span>)
							</button>
						</div>

						<form data-announce-form style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 20px; display: flex; flex-direction: column; gap: 16px;">
							<input type="hidden" name="id" data-announce-id value="" />
							<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
								<label style="font-size: 0.8rem; font-weight: 700; color: var(--muted); display: flex; flex-direction: column; gap: 6px;">
									<span>TITLE <span style="font-weight: 400; opacity: 0.6;">(max 100 chars)</span></span>
									<input type="text" name="title" data-announce-title placeholder="Announcement title…" required maxlength="100" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text); box-sizing: border-box;" />
								</label>
								<label style="font-size: 0.8rem; font-weight: 700; color: var(--muted); display: flex; flex-direction: column; gap: 6px;">
									<span>TARGET AUDIENCE</span>
									<select name="target_audience" data-announce-audience style="width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text); box-sizing: border-box;">
										<option value="all">All Applicants &amp; Members</option>
										<option value="regular">Regular Members Only</option>
										<option value="associate">Associate Members Only</option>
										<option value="institutional">Institutional Members Only</option>
									</select>
								</label>
							</div>

							<label style="font-size: 0.8rem; font-weight: 700; color: var(--muted); display: flex; flex-direction: column; gap: 6px;">
								<span>SUMMARY <span style="font-weight: 400; opacity: 0.6;">(For portal notifications)</span></span>
								<input type="text" name="summary" data-announce-summary placeholder="Brief summary of the announcement…" maxlength="200" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text); box-sizing: border-box;" />
							</label>

							<label style="font-size: 0.8rem; font-weight: 700; color: var(--muted); display: flex; flex-direction: column; gap: 6px;">
								<span>ANNOUNCEMENT BODY</span>
								<textarea name="content" data-announce-content rows="6" placeholder="Write full announcement details…" required style="width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text); resize: vertical; box-sizing: border-box;"></textarea>
							</label>

							<div style="display: flex; gap: 10px; align-items: center; padding-top: 4px;">
								<button type="button" class="button button-primary" data-announce-publish-btn style="font-weight: 700; padding: 9px 20px;">Publish</button>
								<button type="button" class="button button-quiet" data-announce-draft-btn style="font-weight: 700; padding: 9px 16px;">Draft</button>
								<button type="button" class="button button-quiet" data-announce-cancel-btn style="display: none; font-weight: 700; padding: 9px 16px;">Cancel</button>
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
									<button type="button" class="filter-tab active" data-announce-filter="all">All (<span data-announce-filter-all-count>{{ $announcementCounts['all'] ?? 0 }}</span>)</button>
									<button type="button" class="filter-tab" data-announce-filter="published">Published (<span data-announce-filter-published-count>{{ $announcementCounts['published'] ?? 0 }}</span>)</button>
									<button type="button" class="filter-tab" data-announce-filter="draft">Drafts (<span data-announce-filter-draft-count>{{ $announcementCounts['draft'] ?? 0 }}</span>)</button>
									<button type="button" class="filter-tab" data-announce-filter="archived">Archived (<span data-announce-filter-archived-count>{{ $announcementCounts['archived'] ?? 0 }}</span>)</button>
								</div>
							</div>

							<!-- Table Header -->
							<div class="queue-table-head" aria-hidden="true">
								<span>Title &amp; Audience</span>
								<span>Status</span>
								<span>Date</span>
								<span>Actions</span>
							</div>

							<!-- Summarized Posts List -->
							<div class="queue-list" data-announce-list>
								@forelse ($announcements ?? [] as $index => $post)
									<article class="queue-row" data-announce-row data-id="{{ $post->id }}" data-status="{{ $post->status }}" style="{{ $index >= 5 ? 'display: none;' : '' }}">
										<div class="queue-cell queue-title">
											<div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
												<strong>{{ $post->title }}</strong>
												<span class="announce-audience-badge" style="font-size: 0.68rem; padding: 2px 7px; border-radius: 999px; background: color-mix(in srgb, var(--muted) 12%, transparent); border: 1px solid color-mix(in srgb, var(--muted) 25%, transparent); color: var(--muted); font-weight: 700;">
													{{ $post->audience_label }}
												</span>
											</div>
											<span>{{ $post->summary ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}</span>
										</div>
										<div class="queue-cell queue-status">
											<span class="post-tag" data-status="{{ $post->status }}">{{ ucfirst($post->status) }}</span>
										</div>
										<div class="queue-cell queue-date">{{ $post->created_at?->format('M d, Y') ?? '—' }}</div>
										<div class="queue-cell queue-actions">
											<button type="button" class="item-action" data-announce-edit="{{ $post->id }}">Edit</button>
											<button type="button" class="item-action danger" data-announce-delete="{{ $post->id }}">Delete</button>
										</div>
									</article>
								@empty
									<div id="announce-empty-state" style="padding: 40px 20px; text-align: center; color: var(--muted); background: var(--surface-soft); border: 1px dashed var(--border); border-radius: var(--radius-md); margin-top: 14px;">
										<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 10px; opacity: 0.5;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
										<p style="font-weight: 800; margin: 0; color: var(--accent-strong);">No announcements found</p>
										<span style="font-size: 0.82rem; margin-top: 4px; display: block;">Create an announcement using the editor above.</span>
									</div>
								@endforelse
							</div>

							<!-- Pagination / Show More -->
							<div class="queue-pagination" data-announce-pagination style="display: {{ count($announcements ?? []) > 0 ? 'flex' : 'none' }}; justify-content: space-between; align-items: center; padding-top: 8px;">
								<span class="pagination-info" data-announce-pagination-info style="color: var(--muted); font-size: 0.85rem;">Showing {{ min(5, count($announcements ?? [])) }} of {{ count($announcements ?? []) }} posts</span>
								<div class="queue-pagination-actions" style="display: flex; gap: 10px; align-items: center;">
									<button type="button" class="button button-secondary" data-announce-load-more style="display: {{ count($announcements ?? []) > 5 ? 'inline-flex' : 'none' }}; font-size: 0.82rem; font-weight: 700;">Show More</button>
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
					<h2 style="font-size: 1.3rem; font-weight: 900; color: var(--accent-strong); margin: 2px 0 0 0;" id="modal-applicant-name">—</h2>
				</div>
				<button type="button" data-close-review-modal style="background: none; border: none; font-size: 1.5rem; color: var(--muted); cursor: pointer; padding: 4px 8px; line-height: 1;" aria-label="Close modal">&times;</button>
			</div>

			<!-- Category Tab Navigation -->
			<div style="padding: 12px 24px; border-bottom: 1px solid var(--border); background: var(--surface-soft);">
				<div style="display: flex; gap: 8px; flex-wrap: wrap;" role="tablist" aria-label="Application Information Categories">
					<button type="button" class="app-cat-tab-btn active" data-app-info-tab="membership">
						Membership
					</button>
					<button type="button" class="app-cat-tab-btn" data-app-info-tab="personal">
						Personal
					</button>
					<button type="button" class="app-cat-tab-btn" data-app-info-tab="professional">
						Professional &amp; Education
					</button>
					<button type="button" class="app-cat-tab-btn" data-app-info-tab="documents">
						Documents &amp; Validation
					</button>
				</div>
			</div>

			<!-- Modal Body: Categorized Cards Grid -->
			<div style="padding: 20px 24px; overflow-y: auto; display: flex; flex-direction: column; gap: 16px;">
				<div id="review-modal-cards-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 16px;">

					<!-- CATEGORY 1: Membership Information -->
					<div data-app-cat-section="membership" style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px;">
						<h4 style="font-size: 0.95rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 14px 0; border-bottom: 1px solid var(--border); padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--accent); flex-shrink: 0;"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
							Membership Information
						</h4>
						<div style="display: flex; flex-direction: column; gap: 12px;">
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Membership Type</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-membership-type">—</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Application Type</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-application-type">New Application</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Application Date</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-application-date">—</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted); margin-bottom: 4px;">Application Status</div>
								<span id="modal-application-status" style="background: transparent; color: var(--text); border: 1px solid var(--border); padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 600;">Under Evaluation</span>
							</div>
						</div>
					</div>

					<!-- CATEGORY 1: Recommender -->
					<div data-app-cat-section="membership" style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px;">
						<h4 style="font-size: 0.95rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 14px 0; border-bottom: 1px solid var(--border); padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #9333ea; flex-shrink: 0;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
							Recommender
						</h4>
						<div style="display: flex; flex-direction: column; gap: 12px;">
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Name</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-recommender-name">—</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Email</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-recommender-email">—</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Suffix</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-recommender-suffix">—</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Alternate Recommender</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-alt-recommender-name">—</div>
							</div>
						</div>
					</div>

					<!-- CATEGORY 2: Personal Information -->
					<div data-app-cat-section="personal" style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px; display: none;">
						<h4 style="font-size: 0.95rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 14px 0; border-bottom: 1px solid var(--border); padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--accent); flex-shrink: 0;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
							Personal Information
						</h4>
						<div style="display: flex; flex-direction: column; gap: 12px;">
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Surname</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-surname">—</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">First Name(s)</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-first-name">—</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Middle Name(s)</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-middle-name">—</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Mobile Number</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-mobile-number">—</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Email Address</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-personal-email">—</div>
							</div>
						</div>
					</div>

					<!-- CATEGORY 3: Professional Information -->
					<div data-app-cat-section="professional" style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px; display: none;">
						<h4 style="font-size: 0.95rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 14px 0; border-bottom: 1px solid var(--border); padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #2563eb; flex-shrink: 0;"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
							Professional Information
						</h4>
						<div style="display: flex; flex-direction: column; gap: 12px;">
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Current Institutional Affiliation</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-current-affiliation">—</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Current Position</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-current-position">—</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Professional / Institutional Email</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-institutional-email">—</div>
							</div>
						</div>
					</div>

					<!-- CATEGORY 3: Educational Information -->
					<div data-app-cat-section="professional" style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px; display: none;">
						<h4 style="font-size: 0.95rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 14px 0; border-bottom: 1px solid var(--border); padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #ea580c; flex-shrink: 0;"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
							Educational Information
						</h4>
						<div style="display: flex; flex-direction: column; gap: 12px;">
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Highest Educational Attainment</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-highest-education">—</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Degree</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-degree">—</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Date Degree Obtained</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-date-degree-obtained">—</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Institution</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-institution">—</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Institution Address</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-institution-address">—</div>
							</div>
						</div>
					</div>

					<!-- CATEGORY 4: Documents -->
					<div data-app-cat-section="documents" style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px; display: none;">
						<h4 style="font-size: 0.95rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 14px 0; border-bottom: 1px solid var(--border); padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--accent); flex-shrink: 0;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
							Documents
						</h4>
						<div style="display: flex; flex-direction: column; gap: 14px;">
							<div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed var(--border); padding-bottom: 10px;">
								<span style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong);">Updated CV</span>
								<span id="modal-cv-status" style="background: rgba(27, 122, 76, 0.12); color: var(--success); border: 1px solid rgba(27, 122, 76, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">None</span>
							</div>
							<div style="display: flex; justify-content: space-between; align-items: center;">
								<span style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong);">Proof of Employment / Enrollment</span>
								<span id="modal-proof-status" style="background: rgba(27, 122, 76, 0.12); color: var(--success); border: 1px solid rgba(27, 122, 76, 0.3); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em;">None</span>
							</div>
						</div>
					</div>

					<!-- CATEGORY 4: Validation / Certification -->
					<div data-app-cat-section="documents" style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px; display: none;">
						<h4 style="font-size: 0.95rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 14px 0; border-bottom: 1px solid var(--border); padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #16a34a; flex-shrink: 0;"><polyline points="20 6 9 17 4 12"></polyline></svg>
							Validation / Certification
						</h4>
						<div style="display: flex; flex-direction: column; gap: 12px;">
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Declaration</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-declaration">Agreed</div>
							</div>
							<div>
								<div style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">Certification</div>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-certification">Confirmed</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<!-- Modal Footer Actions -->
			<div style="padding: 16px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; background: var(--surface-soft);">
				<button type="button" class="button button-secondary" data-close-review-modal style="font-weight: 700; font-size: 0.85rem;">Close</button>
				<button type="button" id="modal-reject-app-btn" class="button button-danger" style="font-weight: 700; font-size: 0.85rem; background: #dc2626; color: white; border: none; padding: 6px 14px; border-radius: 6px;">Reject Application</button>
				<button type="button" id="modal-approve-app-btn" class="button button-primary" style="font-weight: 700; font-size: 0.85rem;">Approve Application</button>
			</div>
		</div>
	</div>

	<!-- Inquiry Details Modal -->
	<div id="inquiry-detail-modal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0, 0, 0, 0.75); backdrop-filter: blur(5px); align-items: center; justify-content: center; padding: 24px; overflow-y: auto;">
		<div style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); max-width: 860px; width: 100%; max-height: 92vh; display: flex; flex-direction: column; box-shadow: 0 24px 60px rgba(0, 0, 0, 0.35); overflow: hidden; margin: auto;">
			<!-- Modal Header -->
			<div style="padding: 20px 28px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; background: var(--surface-soft); flex-wrap: wrap; gap: 14px;">
				<div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
					<div>
						<div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
							<span style="font-size: 0.76rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em;" id="modal-ticket-id">Ticket #INQ-1040</span>
							<span id="modal-inquirer-category-badge" style="background: rgba(22, 163, 74, 0.07); color: #15803d; border: 1px solid rgba(22, 163, 74, 0.2); padding: 1px 7px; border-radius: 4px; font-size: 0.72rem; font-weight: 600;">Member</span>
							<span id="modal-query-badge" style="background: var(--surface-strong); color: var(--muted); border: 1px solid var(--border); padding: 2px 9px; border-radius: 4px; font-size: 0.73rem; font-weight: 600;">Request for Certificate of Membership</span>
						</div>
						<h2 style="font-size: 1.35rem; font-weight: 900; color: var(--accent-strong); margin: 4px 0 0 0;" id="modal-inquirer-name">Prof. Raymond C. Cruz</h2>
					</div>
				</div>
				<div style="display: flex; align-items: center; gap: 12px;">
					<span id="modal-status-badge" style="background: transparent; color: var(--text); border: 1px solid var(--border); padding: 4px 12px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">Under Review</span>
					<button type="button" data-close-inquiry-modal style="background: var(--surface); border: 1px solid var(--border); border-radius: 6px; font-size: 1.3rem; color: var(--muted); cursor: pointer; padding: 4px 10px; line-height: 1; transition: color 0.15s ease;" aria-label="Close modal">&times;</button>
				</div>
			</div>

			<!-- Modal Body: Single-Column Layout -->
			<div style="padding: 20px 28px; overflow-y: auto; display: flex; flex-direction: column; gap: 16px;">

				<!-- Category Tab Navigation -->
				<div style="display: flex; gap: 8px; flex-wrap: wrap;" role="tablist" aria-label="Inquirer Information Categories">
					<button type="button" class="inquiry-cat-tab-btn active" data-inquiry-info-tab="profile">
						Profile &amp; Contact
					</button>
					<button type="button" class="inquiry-cat-tab-btn" data-inquiry-info-tab="standing">
						Membership Standing
					</button>
					<button type="button" class="inquiry-cat-tab-btn" data-inquiry-info-tab="questionnaire">
						Questionnaire
					</button>
					<button type="button" class="inquiry-cat-tab-btn" data-inquiry-info-tab="remarks">
						Remarks
					</button>
				</div>

					<!-- CATEGORY 1: Inquirer Profile & Account Context -->
					<div data-inquiry-cat-section="profile" style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px; transition: all 0.2s ease;">
						<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid var(--border); padding-bottom: 8px;">
							<div style="display: flex; align-items: center; gap: 8px;">
								<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--accent);"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
								<span style="font-size: 0.76rem; font-weight: 800; text-transform: uppercase; color: var(--accent-strong); letter-spacing: 0.04em;">Category 1: Personal &amp; Contact Profile</span>
							</div>
							<span style="font-size: 0.7rem; font-weight: 800; background: var(--surface); color: var(--muted); border: 1px solid var(--border); padding: 2px 7px; border-radius: 4px;">Identity</span>
						</div>
						<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
							<div>
								<span style="font-size: 0.72rem; color: var(--muted); display: block;">Inquirer Full Name</span>
								<div style="font-size: 0.92rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px;" id="modal-card-inquirer-name">Prof. Raymond C. Cruz</div>
							</div>
							<div>
								<span style="font-size: 0.72rem; color: var(--muted); display: block;">Classification</span>
								<div style="margin-top: 2px;" id="modal-inquirer-class-wrap">
									<span id="modal-inquirer-class-type" style="background: rgba(22, 163, 74, 0.12); color: #16a34a; border: 1px solid rgba(22, 163, 74, 0.25); padding: 2px 8px; border-radius: 4px; font-weight: 800; font-size: 0.76rem;">Existing Member</span>
								</div>
							</div>
							<div>
								<span style="font-size: 0.72rem; color: var(--muted); display: block;">Registered Email</span>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 2px; word-break: break-all;" id="modal-inquirer-email">raymond.cruz@dlsu.edu.ph</div>
							</div>
							<div>
								<span style="font-size: 0.72rem; color: var(--muted); display: block;">Current Affiliation / Institution</span>
								<div style="font-size: 0.84rem; font-weight: 700; color: var(--text); margin-top: 2px;" id="modal-inquirer-institution">De La Salle University - Manila</div>
							</div>
						</div>
					</div>

					<!-- CATEGORY 2: Membership Standing & Application Context -->
					<div data-inquiry-cat-section="standing" style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px; transition: all 0.2s ease; display: none;">
						<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid var(--border); padding-bottom: 8px;">
							<div style="display: flex; align-items: center; gap: 8px;">
								<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #9333ea;"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
								<span style="font-size: 0.76rem; font-weight: 800; text-transform: uppercase; color: var(--accent-strong); letter-spacing: 0.04em;">Category 2: Membership &amp; Application Standing</span>
							</div>
							<span style="font-size: 0.7rem; font-weight: 800; background: var(--surface); color: var(--muted); border: 1px solid var(--border); padding: 2px 7px; border-radius: 4px;">Standing</span>
						</div>
						<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
							<div>
								<span style="font-size: 0.72rem; color: var(--muted); display: block;">Membership Standing</span>
								<div style="margin-top: 3px;">
									<span style="background: var(--accent-soft); color: var(--accent-strong); border: 1px solid rgba(27, 122, 76, 0.25); padding: 2px 8px; border-radius: 4px; font-weight: 800; font-size: 0.76rem;" id="modal-inquirer-tier">Regular Member</span>
								</div>
							</div>
							<div>
								<span style="font-size: 0.72rem; color: var(--muted); display: block;">Application / Track Type</span>
								<div style="font-size: 0.88rem; font-weight: 800; color: var(--accent-strong); margin-top: 3px;" id="modal-application-type">New Application</div>
							</div>
							<div>
								<span style="font-size: 0.72rem; color: var(--muted); display: block;">Submission Date</span>
								<div style="font-size: 0.84rem; font-weight: 700; color: var(--text); margin-top: 2px;" id="modal-submitted-date">09/26/2025</div>
							</div>
						</div>
					</div>

					<!-- CATEGORY 3: Submitted Questionnaire Answers & Historical Records -->
					<div data-inquiry-cat-section="questionnaire" style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px; transition: all 0.2s ease; display: none;">
						<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid var(--border); padding-bottom: 8px;">
							<div style="display: flex; align-items: center; gap: 8px;">
								<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #2563eb;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
								<span style="font-size: 0.76rem; font-weight: 800; text-transform: uppercase; color: var(--accent-strong); letter-spacing: 0.04em;">Category 3: Questionnaire &amp; Historical Records</span>
							</div>
							<span style="font-size: 0.75rem; font-weight: 700; color: var(--accent-strong);" id="modal-query-type-label">Request for Certificate of Membership</span>
						</div>

						<!-- Dynamic questionnaire items injected via JS -->
						<div id="modal-inquiry-fields-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
							<!-- Injected by JavaScript -->
						</div>
					</div>

					<!-- CATEGORY 4: Inquirer Remarks / Context Message -->
					<div data-inquiry-cat-section="remarks" style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 20px; transition: all 0.2s ease; display: none;">
						<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
							<div style="display: flex; align-items: center; gap: 8px;">
								<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #ea580c;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
								<span style="font-size: 0.76rem; font-weight: 800; text-transform: uppercase; color: var(--accent-strong); letter-spacing: 0.04em;" id="modal-inquiry-remarks-title">Category 4: Inquirer Statement &amp; Remarks</span>
							</div>
							<span style="font-size: 0.7rem; font-weight: 800; background: var(--surface); color: var(--muted); border: 1px solid var(--border); padding: 2px 7px; border-radius: 4px;">Statement</span>
						</div>
						<div style="background: var(--surface); border-left: 3px solid var(--accent); padding: 14px 16px; border-radius: var(--radius-sm); font-size: 0.9rem; color: var(--text); line-height: 1.6;" id="modal-inquiry-remarks">
							Requesting an official digital Certificate of Good Standing and Active Membership...
						</div>
					</div>

				<!-- Admin Controls: Status & Certificate -->
				<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 16px 20px; display: flex; flex-direction: column; gap: 14px;">
					<div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
						<label style="font-size: 0.74rem; font-weight: 800; text-transform: uppercase; color: var(--muted); white-space: nowrap;">Ticket Status</label>
						<select id="modal-status-select" style="flex: 1; min-width: 180px; padding: 7px 12px; font-size: 0.84rem; font-weight: 700; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text);">
							<option value="Submitted">Submitted (Awaiting Action)</option>
							<option value="Under Review">Under Review</option>
							<option value="Responded">Responded (via Email)</option>
							<option value="Closed">Closed (Resolved)</option>
						</select>
						<label style="font-size: 0.74rem; font-weight: 800; text-transform: uppercase; color: var(--muted); white-space: nowrap;">Internal Notes</label>
						<input type="text" id="modal-internal-notes" placeholder="Private notes for audit trail…" style="flex: 2; min-width: 200px; padding: 7px 12px; font-size: 0.82rem; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text);" />
					</div>

					<!-- Certificate Attachment -->
					<div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
						<span style="font-size: 0.74rem; font-weight: 800; text-transform: uppercase; color: var(--muted); white-space: nowrap;">Attach Certificate</span>
						<span id="modal-cert-status-badge" style="font-size: 0.7rem; font-weight: 800; padding: 2px 7px; border-radius: 4px; background: rgba(22, 163, 74, 0.1); color: #16a34a;">Recommended</span>
						<input type="file" id="modal-cert-file-input" accept=".pdf,.doc,.docx" style="display: none;" />
						<div id="modal-cert-empty-state" style="display: flex; align-items: center; gap: 8px;">
							<button type="button" class="button button-secondary" id="modal-cert-choose-btn" style="padding: 5px 14px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
								<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
								Upload PDF
							</button>
						</div>
						<div id="modal-cert-attached-state" style="display: none; background: rgba(22, 163, 74, 0.06); border: 1px solid rgba(22, 163, 74, 0.3); border-radius: var(--radius-sm); padding: 7px 12px; align-items: center; gap: 10px;">
							<div style="min-width: 0;">
								<div id="modal-cert-filename" style="font-size: 0.82rem; font-weight: 800; color: var(--accent-strong); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">SPP_Cert_2025_RaymondCruz.pdf</div>
								<div id="modal-cert-filesize" style="font-size: 0.72rem; color: var(--muted);">245 KB &bull; Certified Copy</div>
							</div>
							<button type="button" id="modal-cert-preview-btn" style="padding: 4px 9px; font-size: 0.74rem; font-weight: 700; background: var(--surface); border: 1px solid var(--border); border-radius: 4px; cursor: pointer; color: var(--text); white-space: nowrap;">Preview</button>
							<button type="button" id="modal-cert-remove-btn" style="padding: 4px 9px; font-size: 0.74rem; font-weight: 700; background: none; border: none; cursor: pointer; color: #dc2626;">Remove</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal Footer -->
			<div style="padding: 14px 28px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; background: var(--surface-soft);">
				<button type="button" class="button button-quiet" data-close-inquiry-modal style="font-weight: 700; font-size: 0.85rem;">Close</button>
				<button type="button" class="button button-primary" id="modal-send-response-btn" style="font-weight: 700; font-size: 0.85rem;">Update Status</button>
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
			const closeModalBtns = document.querySelectorAll('[data-close-review-modal]');
			let currentReviewAppId = null;

			async function openApplicationModal(appId) {
				currentReviewAppId = appId;
				setAppInfoCategory('membership');
				if (reviewModal) reviewModal.style.display = 'flex';

				try {
					const res = await fetch(`/admin/api/membership-applications/${appId}`, {
						headers: { 'Accept': 'application/json' }
					});
					const json = await res.json();
					const app = json.data;
					if (!app) return;

					const name = `${app.first_name || ''} ${app.surname || ''}`.trim() || 'Applicant';
					const titleEl = document.getElementById('modal-applicant-name');
					if (titleEl) titleEl.textContent = name;

					document.getElementById('modal-membership-type').textContent = app.membership_type || '—';
					document.getElementById('modal-application-type').textContent = app.application_type || 'New Application';
					document.getElementById('modal-application-date').textContent = app.application_date || '—';
					document.getElementById('modal-application-status').textContent = app.status || 'Under Evaluation';

					document.getElementById('modal-recommender-name').textContent = app.recommender_name || '—';
					document.getElementById('modal-recommender-email').textContent = app.recommender_email || '—';
					document.getElementById('modal-recommender-suffix').textContent = app.recommender_suffix || '—';
					document.getElementById('modal-alt-recommender-name').textContent = app.alt_recommender_name || '—';

					document.getElementById('modal-surname').textContent = app.surname || '—';
					document.getElementById('modal-first-name').textContent = app.first_name || '—';
					document.getElementById('modal-middle-name').textContent = app.middle_name || '—';
					document.getElementById('modal-mobile-number').textContent = app.mobile_number || '—';
					document.getElementById('modal-personal-email').textContent = app.account_email || '—';

					document.getElementById('modal-current-affiliation').textContent = app.current_affiliation || '—';
					document.getElementById('modal-current-position').textContent = app.current_position || '—';
					document.getElementById('modal-institutional-email').textContent = app.institutional_email || '—';

					document.getElementById('modal-highest-education').textContent = app.highest_educational_attainment || '—';
					document.getElementById('modal-degree').textContent = app.degree || '—';
					document.getElementById('modal-date-degree-obtained').textContent = app.date_degree_obtained || '—';
					document.getElementById('modal-institution').textContent = app.institution_name || app.current_affiliation || '—';
					document.getElementById('modal-institution-address').textContent = app.institution_address || '—';

					const cvBadge = document.getElementById('modal-cv-status');
					if (cvBadge) {
						cvBadge.textContent = app.cv_path ? 'Uploaded' : 'None';
						cvBadge.style.color = app.cv_path ? 'var(--success)' : 'var(--muted)';
					}
					const proofBadge = document.getElementById('modal-proof-status');
					if (proofBadge) {
						proofBadge.textContent = app.proof_path ? 'Uploaded' : 'None';
						proofBadge.style.color = app.proof_path ? 'var(--success)' : 'var(--muted)';
					}

					document.getElementById('modal-declaration').textContent = app.declaration_agree ? 'Agreed' : 'No';
					document.getElementById('modal-certification').textContent = app.certification_confirm ? 'Confirmed' : 'No';
				} catch (err) {
					console.error('Error fetching application details:', err);
				}
			}

			async function updateApplicationStatus(appId, newStatus) {
				const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
				try {
					const res = await fetch(`/admin/api/membership-applications/${appId}/status`, {
						method: 'PATCH',
						headers: {
							'Content-Type': 'application/json',
							'Accept': 'application/json',
							'X-CSRF-TOKEN': csrfToken
						},
						body: JSON.stringify({ status: newStatus })
					});
					const json = await res.json();
					if (res.ok) {
						const row = document.querySelector(`tr[data-app-id="${appId}"]`);
						if (row) {
							row.setAttribute('data-status', newStatus);
							const badge = row.querySelector('.app-status-badge');
							if (badge) {
								badge.textContent = newStatus;
								if (newStatus === 'Approved') {
									badge.style.background = 'rgba(22, 163, 74, 0.12)';
									badge.style.color = '#16a34a';
									badge.style.border = '1px solid rgba(22, 163, 74, 0.3)';
								} else if (newStatus === 'Rejected') {
									badge.style.background = 'rgba(239, 68, 68, 0.12)';
									badge.style.color = '#dc2626';
									badge.style.border = '1px solid rgba(239, 68, 68, 0.3)';
								}
							}
							const quickApproveBtn = row.querySelector('[data-quick-approve]');
							if (quickApproveBtn && newStatus === 'Approved') {
								quickApproveBtn.remove();
							}
						}
						if (reviewModal) reviewModal.style.display = 'none';
						refreshApplicationCounts();
						alert(`Application ${newStatus.toLowerCase()} successfully.`);
					} else {
						alert(json.message || 'Error updating status');
					}
				} catch (err) {
					alert('Network error updating status');
				}
			}

			async function refreshApplicationCounts() {
				try {
					const res = await fetch('/admin/api/membership-applications', {
						headers: { 'Accept': 'application/json' }
					});
					const json = await res.json();
					if (json.counts) {
						document.getElementById('app-count-all').textContent = json.counts.all;
						document.getElementById('app-count-under-eval').textContent = json.counts.under_evaluation;
						document.getElementById('app-count-pending').textContent = json.counts.pending;
						document.getElementById('app-count-approved').textContent = json.counts.approved;
						const navCount = document.getElementById('nav-applications-count');
						if (navCount) navCount.textContent = json.counts.all;
					}
				} catch (e) {}
			}

			// Open modal listener on table delegation
			document.getElementById('applications-table-body')?.addEventListener('click', function(e) {
				const reviewBtn = e.target.closest('[data-open-review-modal]');
				if (reviewBtn) {
					const appId = reviewBtn.getAttribute('data-app-id');
					if (appId) openApplicationModal(appId);
					return;
				}
				const approveBtn = e.target.closest('[data-quick-approve]');
				if (approveBtn) {
					const appId = approveBtn.getAttribute('data-app-id');
					if (appId && confirm('Approve this membership application?')) {
						updateApplicationStatus(appId, 'Approved');
					}
				}
			});

			// Modal Approve & Reject action buttons
			document.getElementById('modal-approve-app-btn')?.addEventListener('click', function() {
				if (currentReviewAppId) {
					updateApplicationStatus(currentReviewAppId, 'Approved');
				}
			});

			document.getElementById('modal-reject-app-btn')?.addEventListener('click', function() {
				if (currentReviewAppId && confirm('Reject this membership application?')) {
					updateApplicationStatus(currentReviewAppId, 'Rejected');
				}
			});

			// Filter buttons
			document.querySelectorAll('[data-app-filter]').forEach(btn => {
				btn.addEventListener('click', function() {
					const filter = this.getAttribute('data-app-filter');
					document.querySelectorAll('[data-app-filter]').forEach(b => {
						b.className = (b === this) ? 'button button-primary' : 'button button-quiet';
					});
					document.querySelectorAll('[data-app-row]').forEach(row => {
						const rowStatus = row.getAttribute('data-status');
						if (filter === 'all' || rowStatus === filter) {
							row.style.display = '';
						} else {
							row.style.display = 'none';
						}
					});
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

			// Application Review Modal — Category Tab Switcher
			const appCatTabBtns = reviewModal ? reviewModal.querySelectorAll('[data-app-info-tab]') : [];
			const appCatSections = reviewModal ? reviewModal.querySelectorAll('[data-app-cat-section]') : [];

			function setAppInfoCategory(activeCat) {
				appCatTabBtns.forEach(btn => {
					const isTarget = btn.getAttribute('data-app-info-tab') === activeCat;
					btn.classList.toggle('active', isTarget);
					btn.setAttribute('aria-selected', String(isTarget));
				});

				appCatSections.forEach(section => {
					const cat = section.getAttribute('data-app-cat-section');
					section.style.display = (cat === activeCat) ? '' : 'none';
				});
			}

			appCatTabBtns.forEach(btn => {
				btn.addEventListener('click', function() {
					setAppInfoCategory(this.getAttribute('data-app-info-tab'));
				});
			});

			// Reset to first tab whenever the review modal is opened
			openModalBtns.forEach(btn => {
				btn.addEventListener('click', function() {
					setAppInfoCategory('membership');
				});
			});

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

			// Dedicated Admin Floating Toast Notification
			function showAdminToast(message, isError = false) {
				const toast = document.getElementById('admin-floating-toast');
				const toastMessage = document.getElementById('admin-floating-toast-message');
				const toastIcon = toast?.querySelector('.floating-toast-icon');

				if (!toast || !toastMessage) return;

				toastMessage.textContent = message;
				if (isError) {
					toast.classList.add('is-error');
					if (toastIcon) toastIcon.innerHTML = '&#x2716;';
				} else {
					toast.classList.remove('is-error');
					if (toastIcon) toastIcon.innerHTML = '&#x2714;';
				}

				toast.classList.remove('is-hidden');

				if (window._adminToastTimeout) {
					clearTimeout(window._adminToastTimeout);
				}
				window._adminToastTimeout = setTimeout(() => {
					toast.classList.add('is-hidden');
				}, 4000);
			}

			document.getElementById('admin-floating-toast-close')?.addEventListener('click', () => {
				document.getElementById('admin-floating-toast')?.classList.add('is-hidden');
			});

			// Announcements Management Script
			const announceEditorView = document.querySelector('[data-announce-view="editor"]');
			const announcePostsView = document.querySelector('[data-announce-view="posts"]');
			const showPostsBtn = document.querySelector('[data-announce-show-posts]');
			const showEditorBtn = document.querySelector('[data-announce-show-editor]');

			const announceForm = document.querySelector('[data-announce-form]');
			const announceIdInput = document.querySelector('[data-announce-id]');
			const announceTitleInput = document.querySelector('[data-announce-title]');
			const announceAudienceSelect = document.querySelector('[data-announce-audience]');
			const announceSummaryInput = document.querySelector('[data-announce-summary]');
			const announceContentInput = document.querySelector('[data-announce-content]');
			const announcePublishBtn = document.querySelector('[data-announce-publish-btn]');
			const announceDraftBtn = document.querySelector('[data-announce-draft-btn]');
			const announceCancelBtn = document.querySelector('[data-announce-cancel-btn]');
			const announceFormTitle = document.querySelector('[data-announce-form-title]');

			const announceList = document.querySelector('[data-announce-list]');
			const announceCountEl = document.querySelector('[data-announce-count]');
			const announceFilterBtns = document.querySelectorAll('[data-announce-filter]');
			const announceLoadMore = document.querySelector('[data-announce-load-more]');
			const announceShowLess = document.querySelector('[data-announce-show-less]');
			const announcePagination = document.querySelector('[data-announce-pagination]');
			const announcePaginationInfo = document.querySelector('[data-announce-pagination-info]');

			const csrfMeta = document.querySelector('meta[name="csrf-token"]');
			const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

			let currentFilter = 'all';
			let isExpanded = false;
			const PAGE_LIMIT = 5;

			const audienceLabels = {
				'all': 'All Applicants & Members',
				'regular': 'Regular Members Only',
				'associate': 'Associate Members Only',
				'institutional': 'Institutional Members Only'
			};

			function getAudienceLabel(val) {
				return audienceLabels[val] || 'All Applicants & Members';
			}

			// View Toggles
			if (showPostsBtn && announceEditorView && announcePostsView) {
				showPostsBtn.addEventListener('click', function() {
					announceEditorView.style.display = 'none';
					announcePostsView.style.display = 'block';
				});
			}

			if (showEditorBtn && announceEditorView && announcePostsView) {
				showEditorBtn.addEventListener('click', function() {
					resetAnnounceForm();
					announcePostsView.style.display = 'none';
					announceEditorView.style.display = 'block';
				});
			}

			function resetAnnounceForm() {
				if (!announceForm) return;
				announceForm.reset();
				if (announceIdInput) announceIdInput.value = '';
				if (announceFormTitle) announceFormTitle.textContent = 'New Announcement';
				if (announcePublishBtn) announcePublishBtn.textContent = 'Publish';
				if (announceDraftBtn) announceDraftBtn.textContent = 'Draft';
				if (announceCancelBtn) announceCancelBtn.style.display = 'none';
			}

			if (announceCancelBtn) {
				announceCancelBtn.addEventListener('click', function() {
					resetAnnounceForm();
					if (announceEditorView && announcePostsView) {
						announceEditorView.style.display = 'none';
						announcePostsView.style.display = 'block';
					}
				});
			}

			// Filter & Pagination Display
			function updateAnnounceDisplay() {
				const rows = document.querySelectorAll('[data-announce-row]');
				const matchingRows = Array.from(rows).filter(row => {
					return currentFilter === 'all' || row.getAttribute('data-status') === currentFilter;
				});

				const total = matchingRows.length;
				const limit = isExpanded ? total : Math.min(PAGE_LIMIT, total);

				rows.forEach(row => {
					row.style.display = 'none';
				});

				matchingRows.forEach((row, idx) => {
					if (idx < limit) {
						row.style.display = 'grid';
					}
				});

				if (announcePagination) {
					announcePagination.style.display = total > 0 ? 'flex' : 'none';
				}

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

			// Save / Publish / Draft Handler
			async function submitAnnouncement(status) {
				const title = announceTitleInput ? announceTitleInput.value.trim() : '';
				const audience = announceAudienceSelect ? announceAudienceSelect.value : 'all';
				const summary = announceSummaryInput ? announceSummaryInput.value.trim() : '';
				const content = announceContentInput ? announceContentInput.value.trim() : '';
				const existingId = announceIdInput ? announceIdInput.value.trim() : '';

				if (!title) {
					showAdminToast('Please provide an announcement title.', true);
					if (announceTitleInput) announceTitleInput.focus();
					return;
				}

				if (!content) {
					showAdminToast('Please enter announcement body details.', true);
					if (announceContentInput) announceContentInput.focus();
					return;
				}

				const isEdit = Boolean(existingId);
				const url = isEdit ? `/admin/api/announcements/${existingId}` : '/admin/api/announcements';
				const method = isEdit ? 'PUT' : 'POST';

				const activeBtn = status === 'published' ? announcePublishBtn : announceDraftBtn;
				const originalText = activeBtn ? activeBtn.textContent : '';
				if (activeBtn) {
					activeBtn.disabled = true;
					activeBtn.textContent = status === 'published' ? 'Publishing…' : 'Saving…';
				}

				try {
					const res = await fetch(url, {
						method: method,
						headers: {
							'Content-Type': 'application/json',
							'Accept': 'application/json',
							'X-CSRF-TOKEN': csrfToken
						},
						body: JSON.stringify({
							title: title,
							target_audience: audience,
							summary: summary,
							content: content,
							status: status
						})
					});

					const data = await res.json();

					if (!res.ok) {
						const errMessage = data.message || (data.errors ? Object.values(data.errors).flat().join('\n') : 'Error saving announcement');
						showAdminToast(errMessage, true);
						return;
					}

					const successMsg = status === 'published'
						? (isEdit ? 'Announcement updated and published.' : 'Announcement published successfully.')
						: (isEdit ? 'Draft updated successfully.' : 'Announcement saved as draft.');
					showAdminToast(data.message || successMsg);

					resetAnnounceForm();
					await reloadAnnouncements();

					if (announceEditorView && announcePostsView) {
						announceEditorView.style.display = 'none';
						announcePostsView.style.display = 'block';
					}
				} catch (err) {
					console.error('Save error:', err);
					showAdminToast('Failed to save announcement. Please check your connection and try again.', true);
				} finally {
					if (activeBtn) {
						activeBtn.disabled = false;
						activeBtn.textContent = originalText;
					}
				}
			}

			if (announcePublishBtn) {
				announcePublishBtn.addEventListener('click', () => submitAnnouncement('published'));
			}

			if (announceDraftBtn) {
				announceDraftBtn.addEventListener('click', () => submitAnnouncement('draft'));
			}

			// Reload Announcements from API & re-render list
			async function reloadAnnouncements() {
				try {
					const res = await fetch('/admin/api/announcements', {
						headers: { 'Accept': 'application/json' }
					});
					if (!res.ok) return;

					const json = await res.json();
					const posts = json.data || [];
					const counts = json.counts || { all: 0, published: 0, draft: 0, archived: 0 };

					// Update counts in DOM
					if (announceCountEl) announceCountEl.textContent = counts.all;
					const allCountEl = document.querySelector('[data-announce-filter-all-count]');
					const pubCountEl = document.querySelector('[data-announce-filter-published-count]');
					const draftCountEl = document.querySelector('[data-announce-filter-draft-count]');
					const archCountEl = document.querySelector('[data-announce-filter-archived-count]');

					if (allCountEl) allCountEl.textContent = counts.all;
					if (pubCountEl) pubCountEl.textContent = counts.published;
					if (draftCountEl) draftCountEl.textContent = counts.draft;
					if (archCountEl) archCountEl.textContent = counts.archived;

					// Re-render list
					if (!announceList) return;

					if (posts.length === 0) {
						announceList.innerHTML = `
							<div id="announce-empty-state" style="padding: 40px 20px; text-align: center; color: var(--muted); background: var(--surface-soft); border: 1px dashed var(--border); border-radius: var(--radius-md); margin-top: 14px;">
								<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 10px; opacity: 0.5;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
								<p style="font-weight: 800; margin: 0; color: var(--accent-strong);">No announcements found</p>
								<span style="font-size: 0.82rem; margin-top: 4px; display: block;">Create an announcement using the editor above.</span>
							</div>
						`;
					} else {
						announceList.innerHTML = posts.map(post => {
							const dateStr = post.created_at ? new Date(post.created_at).toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' }) : '—';
							const audienceText = getAudienceLabel(post.target_audience);
							const summaryText = post.summary || (post.content ? post.content.replace(/<[^>]*>?/gm, '').substring(0, 120) : '');
							const statusCap = (post.status || 'published').charAt(0).toUpperCase() + (post.status || 'published').slice(1);

							return `
								<article class="queue-row" data-announce-row data-id="${post.id}" data-status="${post.status}" style="display: none;">
									<div class="queue-cell queue-title">
										<div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
											<strong>${escapeHtml(post.title)}</strong>
											<span class="announce-audience-badge" style="font-size: 0.68rem; padding: 2px 7px; border-radius: 999px; background: color-mix(in srgb, var(--muted) 12%, transparent); border: 1px solid color-mix(in srgb, var(--muted) 25%, transparent); color: var(--muted); font-weight: 700;">
												${escapeHtml(audienceText)}
											</span>
										</div>
										<span>${escapeHtml(summaryText)}</span>
									</div>
									<div class="queue-cell queue-status">
										<span class="post-tag" data-status="${post.status}">${escapeHtml(statusCap)}</span>
									</div>
									<div class="queue-cell queue-date">${dateStr}</div>
									<div class="queue-cell queue-actions">
										<button type="button" class="item-action" data-announce-edit="${post.id}">Edit</button>
										<button type="button" class="item-action danger" data-announce-delete="${post.id}">Delete</button>
									</div>
								</article>
							`;
						}).join('');
					}

					bindRowEvents();
					updateAnnounceDisplay();
				} catch (err) {
					console.error('Reload error:', err);
				}
			}

			function escapeHtml(str) {
				if (!str) return '';
				return String(str)
					.replace(/&/g, '&amp;')
					.replace(/</g, '&lt;')
					.replace(/>/g, '&gt;')
					.replace(/"/g, '&quot;');
			}

			// Edit & Delete row event bindings
			function bindRowEvents() {
				document.querySelectorAll('[data-announce-edit]').forEach(btn => {
					btn.onclick = async function() {
						const id = this.getAttribute('data-announce-edit');
						try {
							const res = await fetch(`/admin/api/announcements/${id}`, {
								headers: { 'Accept': 'application/json' }
							});
							if (!res.ok) {
								showAdminToast('Could not load announcement details.', true);
								return;
							}
							const json = await res.json();
							const item = json.data;
							if (!item) return;

							if (announceIdInput) announceIdInput.value = item.id;
							if (announceTitleInput) announceTitleInput.value = item.title || '';
							if (announceAudienceSelect) announceAudienceSelect.value = item.target_audience || 'all';
							if (announceSummaryInput) announceSummaryInput.value = item.summary || '';
							if (announceContentInput) announceContentInput.value = item.content || '';

							if (announceFormTitle) announceFormTitle.textContent = 'Edit Announcement';
							if (announcePublishBtn) announcePublishBtn.textContent = 'Publish';
							if (announceDraftBtn) announceDraftBtn.textContent = 'Draft';
							if (announceCancelBtn) announceCancelBtn.style.display = 'inline-flex';

							if (announceEditorView && announcePostsView) {
								announcePostsView.style.display = 'none';
								announceEditorView.style.display = 'block';
								announceTitleInput.focus();
							}
						} catch (err) {
							console.error('Edit error:', err);
							showAdminToast('Failed to load announcement for editing.', true);
						}
					};
				});

				document.querySelectorAll('[data-announce-delete]').forEach(btn => {
					btn.onclick = async function() {
						const id = this.getAttribute('data-announce-delete');
						if (!confirm('Are you sure you want to delete this announcement? This action cannot be undone.')) {
							return;
						}

						try {
							const res = await fetch(`/admin/api/announcements/${id}`, {
								method: 'DELETE',
								headers: {
									'Accept': 'application/json',
									'X-CSRF-TOKEN': csrfToken
								}
							});

							if (!res.ok) {
								const err = await res.json().catch(() => ({}));
								showAdminToast(err.message || 'Failed to delete announcement.', true);
								return;
							}

							showAdminToast('Announcement deleted successfully.');
							await reloadAnnouncements();
						} catch (err) {
							console.error('Delete error:', err);
							showAdminToast('Error deleting announcement.', true);
						}
					};
				});
			}

			bindRowEvents();
			updateAnnounceDisplay();

			// --- INQUIRIES MANAGEMENT SCRIPT ---
			const inquiryRows = document.querySelectorAll('[data-inquiry-row]');
			const inquiryStatusFilterBtns = document.querySelectorAll('[data-inquiry-status-filter]');
			const inquiryTypeFilterSelect = document.querySelector('[data-inquiry-type-filter]');
			const inquiryCategoryFilterSelect = document.querySelector('[data-inquiry-category-filter]');
			const inquirySearchInput = document.querySelector('[data-inquiry-search]');
			const inquiriesEmptyState = document.getElementById('inquiries-empty-state');
			const inquiryModal = document.getElementById('inquiry-detail-modal');
			const closeInquiryModalBtns = document.querySelectorAll('[data-close-inquiry-modal]');
			const sendResponseBtn = document.getElementById('modal-send-response-btn');

			let activeInquiryStatus = 'all';
			let activeInquiryType = 'all';
			let activeInquiryCategory = 'all';
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
					const appType = row.getAttribute('data-application-type') || '';
					const isApplicant = appType === 'New Application';

					const matchesStatus = (activeInquiryStatus === 'all' || status === activeInquiryStatus);
					const matchesType = (activeInquiryType === 'all' || type === activeInquiryType);
					const matchesCategory = (activeInquiryCategory === 'all')
						|| (activeInquiryCategory === 'applicant' && isApplicant)
						|| (activeInquiryCategory === 'member' && !isApplicant);

					const fullText = `${name} ${email} ${inst} ${remarks} ${ticket} ${type} ${appType}`.toLowerCase();
					const matchesSearch = !activeInquirySearch || fullText.includes(activeInquirySearch.toLowerCase());

					const isVisible = matchesStatus && matchesType && matchesCategory && matchesSearch;
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

			if (inquiryCategoryFilterSelect) {
				inquiryCategoryFilterSelect.addEventListener('change', function() {
					activeInquiryCategory = this.value;
					filterInquiries();
				});
			}

			if (inquirySearchInput) {
				inquirySearchInput.addEventListener('input', function() {
					activeInquirySearch = this.value.trim();
					filterInquiries();
				});
			}

			// Inquirer Info Category Tab Switcher (Category 1, 2, 3, 4 vs All)
			const inquiryCatTabBtns = inquiryModal ? inquiryModal.querySelectorAll('[data-inquiry-info-tab]') : [];
			const inquiryCatSections = inquiryModal ? inquiryModal.querySelectorAll('[data-inquiry-cat-section]') : [];

			function setInquiryInfoCategory(activeCat) {
				inquiryCatTabBtns.forEach(btn => {
					const isTarget = btn.getAttribute('data-inquiry-info-tab') === activeCat;
					btn.classList.toggle('active', isTarget);
					btn.setAttribute('aria-selected', String(isTarget));
				});

				inquiryCatSections.forEach(section => {
					const cat = section.getAttribute('data-inquiry-cat-section');
					section.style.display = (cat === activeCat) ? 'block' : 'none';
				});
			}

			inquiryCatTabBtns.forEach(btn => {
				btn.addEventListener('click', function() {
					setInquiryInfoCategory(this.getAttribute('data-inquiry-info-tab'));
				});
			});

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
					const remarks = row.getAttribute('data-remarks') || '';
					const response = row.getAttribute('data-response') || '';

					// Specific questionnaire fields
					const lastKnownMem = row.getAttribute('data-last-known-membership') || '';
					const lastAttYear = row.getAttribute('data-last-attendance-year') || '';
					const lastAttPlace = row.getAttribute('data-last-attendance-place') || '';
					const oathYear = row.getAttribute('data-oath-year') || '';
					const oathVenue = row.getAttribute('data-oath-venue') || '';
					const knownMemType = row.getAttribute('data-known-membership-type') || '';
					const purpose = row.getAttribute('data-purpose') || '';
					const keywords = row.getAttribute('data-keywords') || '';

					// Certificate Attachment State
					let currentAttachedCert = row.getAttribute('data-certificate-attached') || '';
					let currentAttachedCertSize = row.getAttribute('data-certificate-size') || '';

					// Populate header & contact
					document.getElementById('modal-ticket-id').textContent = `Ticket #${ticketId}`;
					document.getElementById('modal-inquirer-name').textContent = name;
					const cardNameEl = document.getElementById('modal-card-inquirer-name');
					if (cardNameEl) cardNameEl.textContent = name;

					document.getElementById('modal-inquirer-email').textContent = email;
					document.getElementById('modal-inquirer-institution').textContent = inst;
					document.getElementById('modal-inquirer-tier').textContent = tier;
					document.getElementById('modal-submitted-date').textContent = date;
					document.getElementById('modal-inquiry-remarks').textContent = remarks;

					// Inquirer Category Badges (Member vs Applicant)
					const isApplicant = appType === 'New Application';
					const headerCatBadge = document.getElementById('modal-inquirer-category-badge');
					if (headerCatBadge) {
						headerCatBadge.textContent = isApplicant ? 'Applicant' : 'Member';
						if (isApplicant) {
							headerCatBadge.style.cssText = 'background: var(--surface-strong); color: var(--muted); border: 1px solid var(--border); padding: 1px 7px; border-radius: 4px; font-size: 0.72rem; font-weight: 600;';
						} else {
							headerCatBadge.style.cssText = 'background: rgba(22, 163, 74, 0.07); color: #15803d; border: 1px solid rgba(22, 163, 74, 0.2); padding: 1px 7px; border-radius: 4px; font-size: 0.72rem; font-weight: 600;';
						}
					}

					const classTypeEl = document.getElementById('modal-inquirer-class-type');
					if (classTypeEl) {
						classTypeEl.textContent = isApplicant ? 'New Applicant' : 'Existing Member';
						classTypeEl.style.cssText = isApplicant
							? 'background: var(--surface-strong); color: var(--muted); border: 1px solid var(--border); padding: 2px 8px; border-radius: 4px; font-weight: 600; font-size: 0.76rem;'
							: 'background: rgba(22, 163, 74, 0.07); color: #15803d; border: 1px solid rgba(22, 163, 74, 0.2); padding: 2px 8px; border-radius: 4px; font-weight: 600; font-size: 0.76rem;';
					}

					const appTypeEl = document.getElementById('modal-application-type');
					if (appTypeEl) appTypeEl.textContent = appType;

					// Reset category tab to first tab when modal opens
					setInquiryInfoCategory('profile');

					const targetEmailEl = document.getElementById('modal-response-target-email');
					if (targetEmailEl) targetEmailEl.textContent = email;

					const queryTypeLabel = document.getElementById('modal-query-type-label');
					if (queryTypeLabel) queryTypeLabel.textContent = queryType;

					const queryBadge = document.getElementById('modal-query-badge');
					if (queryBadge) {
						queryBadge.textContent = queryType;
						if (queryType === 'Membership Status') {
							queryBadge.style.cssText = 'background: var(--surface-strong); color: var(--muted); border: 1px solid var(--border); padding: 2px 9px; border-radius: 4px; font-size: 0.73rem; font-weight: 600;';
						} else if (queryType === 'Request for Certificate of Membership') {
							queryBadge.style.cssText = 'background: var(--surface-strong); color: var(--muted); border: 1px solid var(--border); padding: 2px 9px; border-radius: 4px; font-size: 0.73rem; font-weight: 600;';
						} else {
							queryBadge.style.cssText = 'background: var(--surface-strong); color: var(--muted); border: 1px solid var(--border); padding: 2px 9px; border-radius: 4px; font-size: 0.73rem; font-weight: 600;';
						}
					}

					// Dynamic Questions Display (Clean, Spacious Mini-Cards)
					const fieldsContainer = document.getElementById('modal-inquiry-fields-container');
					const remarksTitle = document.getElementById('modal-inquiry-remarks-title');

					if (fieldsContainer) {
						let html = '';
						if (queryType === 'Membership Status') {
							if (remarksTitle) remarksTitle.textContent = 'Background Context & Purpose of Inquiry';
							html = `
								<div style="background: var(--surface-soft); padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
									<span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; letter-spacing: 0.03em;">Last Known Membership</span>
									<span style="font-size: 0.92rem; font-weight: 700; color: var(--accent-strong); margin-top: 3px; display: block;">${lastKnownMem || 'Not specified'}</span>
								</div>
								<div style="background: var(--surface-soft); padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
									<span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; letter-spacing: 0.03em;">Year of Last SPP Attendance</span>
									<span style="font-size: 0.92rem; font-weight: 700; color: var(--accent-strong); margin-top: 3px; display: block;">${lastAttYear || 'N/A'}</span>
								</div>
								<div style="background: var(--surface-soft); padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); grid-column: 1 / -1;">
									<span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; letter-spacing: 0.03em;">Last SPP Attendance (Place)</span>
									<span style="font-size: 0.92rem; font-weight: 700; color: var(--accent-strong); margin-top: 3px; display: block;">${lastAttPlace || 'N/A'}</span>
								</div>
							`;
						} else if (queryType === 'Request for Certificate of Membership') {
							if (remarksTitle) remarksTitle.textContent = 'Additional Inquirer Notes';
							html = `
								<div style="background: var(--surface-soft); padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
									<span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; letter-spacing: 0.03em;">Year of Oath Taking</span>
									<span style="font-size: 0.92rem; font-weight: 700; color: var(--accent-strong); margin-top: 3px; display: block;">${oathYear || 'N/A'}</span>
								</div>
								<div style="background: var(--surface-soft); padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
									<span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; letter-spacing: 0.03em;">Venue of Oath Taking</span>
									<span style="font-size: 0.92rem; font-weight: 700; color: var(--accent-strong); margin-top: 3px; display: block;">${oathVenue || 'Online'}</span>
								</div>
								<div style="background: var(--surface-soft); padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
									<span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; letter-spacing: 0.03em;">Known Membership Type</span>
									<span style="font-size: 0.92rem; font-weight: 700; color: var(--accent-strong); margin-top: 3px; display: block;">${knownMemType || tier}</span>
								</div>
								<div style="background: var(--surface-soft); padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
									<span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; letter-spacing: 0.03em;">Last Attendance</span>
									<span style="font-size: 0.92rem; font-weight: 700; color: var(--accent-strong); margin-top: 3px; display: block;">${lastAttYear ? `${lastAttYear} (${lastAttPlace || 'N/A'})` : 'N/A'}</span>
								</div>
								<div style="background: var(--surface-soft); padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); grid-column: 1 / -1;">
									<span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; letter-spacing: 0.03em;">Intended Certificate Purpose</span>
									<span style="font-size: 0.92rem; font-weight: 700; color: var(--accent-strong); margin-top: 3px; display: block;">${purpose || 'Faculty Evaluation and Professional Dossier'}</span>
								</div>
							`;
						} else {
							if (remarksTitle) remarksTitle.textContent = 'Member Concern / Detailed Inquiry';
							html = `
								<div style="background: var(--surface-soft); padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); grid-column: 1 / -1;">
									<span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; letter-spacing: 0.03em;">Inquiry Keyword(s)</span>
									<span style="font-size: 0.92rem; font-weight: 700; color: var(--accent-strong); margin-top: 3px; display: block;">${keywords || 'fee, inquiry'}</span>
								</div>
							`;
						}
						fieldsContainer.innerHTML = html;
					}

					// Certificate Attachment UI Sync
					const certEmptyState = document.getElementById('modal-cert-empty-state');
					const certAttachedState = document.getElementById('modal-cert-attached-state');
					const certFileName = document.getElementById('modal-cert-filename');
					const certFileSize = document.getElementById('modal-cert-filesize');
					const certStatusBadge = document.getElementById('modal-cert-status-badge');
					const certFileInput = document.getElementById('modal-cert-file-input');

					function updateCertAttachmentUI() {
						if (certStatusBadge) {
							if (queryType === 'Request for Certificate of Membership') {
								certStatusBadge.textContent = currentAttachedCert ? 'Attached & Ready' : 'Required / Recommended';
								certStatusBadge.style.cssText = 'font-size: 0.7rem; font-weight: 800; padding: 2px 7px; border-radius: 4px; background: rgba(22, 163, 74, 0.1); color: #16a34a;';
							} else {
								certStatusBadge.textContent = currentAttachedCert ? 'Attached' : 'Optional';
								certStatusBadge.style.cssText = 'font-size: 0.7rem; font-weight: 800; padding: 2px 7px; border-radius: 4px; background: rgba(107, 114, 128, 0.1); color: var(--muted);';
							}
						}

						if (currentAttachedCert) {
							if (certEmptyState) certEmptyState.style.display = 'none';
							if (certAttachedState) {
								certAttachedState.style.display = 'flex';
								if (certFileName) certFileName.textContent = currentAttachedCert;
								if (certFileSize) certFileSize.innerHTML = currentAttachedCertSize || '245 KB &bull; Certified Copy';
							}
						} else {
							if (certAttachedState) certAttachedState.style.display = 'none';
							if (certEmptyState) certEmptyState.style.display = 'flex';
							if (certFileInput) certFileInput.value = '';
						}
					}

					updateCertAttachmentUI();

					// Cert Upload Button Trigger
					const certChooseBtn = document.getElementById('modal-cert-choose-btn');
					if (certChooseBtn && certFileInput) {
						certChooseBtn.onclick = function() {
							certFileInput.click();
						};
					}

					// Cert File Input Change
					if (certFileInput) {
						certFileInput.onchange = function(e) {
							const file = e.target.files[0];
							if (file) {
								currentAttachedCert = file.name;
								currentAttachedCertSize = `${(file.size / 1024).toFixed(1)} KB &bull; Uploaded PDF`;
								updateCertAttachmentUI();

								const statusSel = document.getElementById('modal-status-select');
								if (statusSel && statusSel.value !== 'Responded') {
									statusSel.value = 'Responded';
								}
							}
						};
					}

					// Cert Preview Button
					const certPreviewBtn = document.getElementById('modal-cert-preview-btn');
					if (certPreviewBtn) {
						certPreviewBtn.onclick = function() {
							alert(`[DOCUMENT PREVIEW]\n\nSamahang Pisika ng Pilipinas (SPP)\nOfficial Certificate of Membership & Good Standing\n\nRecipient: ${name}\nFile: ${currentAttachedCert}\nStatus: Digitally Signed by SPP Secretariat & President\nSecurity: Validated QR Signature`);
						};
					}

					// Cert Remove Button
					const certRemoveBtn = document.getElementById('modal-cert-remove-btn');
					if (certRemoveBtn) {
						certRemoveBtn.onclick = function() {
							currentAttachedCert = '';
							currentAttachedCertSize = '';
							updateCertAttachmentUI();
						};
					}

					const statusBadge = document.getElementById('modal-status-badge');
					if (statusBadge) {
						statusBadge.textContent = status;
						if (status === 'Submitted') {
							statusBadge.style.cssText = 'background: transparent; color: var(--text); border: 1px solid var(--border); padding: 4px 12px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;';
						} else if (status === 'Under Review') {
							statusBadge.style.cssText = 'background: transparent; color: var(--text); border: 1px solid var(--border); padding: 4px 12px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;';
						} else if (status === 'Responded') {
							statusBadge.style.cssText = 'background: rgba(22, 163, 74, 0.07); color: #15803d; border: 1px solid rgba(22, 163, 74, 0.18); padding: 4px 12px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;';
						} else {
							statusBadge.style.cssText = 'background: var(--surface-strong); color: var(--muted); border: 1px solid var(--border); padding: 4px 12px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;';
						}
					}

					const statusSelect = document.getElementById('modal-status-select');
					if (statusSelect) statusSelect.value = status;

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

			// Update Status & Certificate Attachment
			if (sendResponseBtn) {
				sendResponseBtn.addEventListener('click', function() {
					if (!currentActiveRow) return;

					const newStatus = document.getElementById('modal-status-select').value;
					const certFileName = document.getElementById('modal-cert-filename');
					const certAttachedState = document.getElementById('modal-cert-attached-state');

					const isCertAttached = certAttachedState && certAttachedState.style.display !== 'none';
					const certName = isCertAttached && certFileName ? certFileName.textContent : '';

					currentActiveRow.setAttribute('data-status', newStatus);
					currentActiveRow.setAttribute('data-certificate-attached', certName);

					// Update tag in row
					const tag = currentActiveRow.querySelector('.inquiry-status-tag');
					if (tag) {
						tag.textContent = newStatus;
						if (newStatus === 'Submitted') {
							tag.style.cssText = 'background: transparent; color: var(--text); border: 1px solid var(--border); padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 600;';
						} else if (newStatus === 'Under Review') {
							tag.style.cssText = 'background: transparent; color: var(--text); border: 1px solid var(--border); padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 600;';
						} else if (newStatus === 'Responded') {
							tag.style.cssText = 'background: rgba(22, 163, 74, 0.07); color: #15803d; border: 1px solid rgba(22, 163, 74, 0.18); padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 600;';
						} else {
							tag.style.cssText = 'background: var(--surface-strong); color: var(--muted); border: 1px solid var(--border); padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 600;';
						}
					}

					// Update cert badge in row if present
					let rowCertBadge = currentActiveRow.querySelector('.row-cert-badge');
					const queryTypeTd = currentActiveRow.children[1];
					if (isCertAttached && queryTypeTd) {
						if (!rowCertBadge) {
							rowCertBadge = document.createElement('div');
							rowCertBadge.className = 'row-cert-badge';
							rowCertBadge.style.cssText = 'margin-top: 4px; font-size: 0.72rem; color: #16a34a; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; background: rgba(22, 163, 74, 0.08); padding: 2px 7px; border-radius: 4px; border: 1px solid rgba(22, 163, 74, 0.2);';
							rowCertBadge.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg> Certificate Attached';
							queryTypeTd.appendChild(rowCertBadge);
						}
					} else if (!isCertAttached && rowCertBadge) {
						rowCertBadge.remove();
					}

					alert(`Status updated successfully.`);
					inquiryModal.style.display = 'none';
					filterInquiries();
				});
			}
		});
	</script>
</body>

</html>
