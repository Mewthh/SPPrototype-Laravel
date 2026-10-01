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

<body style="background: var(--bg); color: var(--text); font-family: var(--font-body, system-ui, sans-serif); min-height: 100vh;">
	<a class="skip-link" href="#main-content">Skip to content</a>

	<!-- Admin Header / Navigation Bar -->
	<header style="background: var(--surface); border-bottom: 1px solid var(--border); padding: 14px 24px; position: sticky; top: 0; z-index: 100; box-shadow: var(--shadow);">
		<div style="max-width: 1320px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
			<div style="display: flex; align-items: center; gap: 14px;">
				<div class="brand-mark" aria-hidden="true" style="font-weight: 900; font-size: 1.1rem; background: var(--accent-strong); color: var(--bg-page); padding: 4px 10px; border-radius: var(--radius-sm);">SPP</div>
				<div>
					<div style="font-weight: 800; font-size: 1.05rem; color: var(--accent-strong); line-height: 1.2;">Membership Portal Manager</div>
					<div style="font-size: 0.78rem; color: var(--muted);">Samahang Pisika ng Pilipinas Admin System</div>
				</div>
			</div>

			<div style="display: flex; align-items: center; gap: 10px;">
				<a href="{{ route('admin') }}" class="button button-secondary" style="font-weight: 700; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
					<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
					<span>Back to CMS Admin</span>
				</a>

				@auth
					<form method="POST" action="{{ route('logout') }}" style="margin: 0;">
						@csrf
						<button type="submit" class="ghost-button" style="padding: 6px 12px; height: 36px; min-height: 36px; font-size: 0.8rem; color: var(--danger); border-color: rgba(220, 53, 69, 0.25);" aria-label="Log out">
							<span>Log Out</span>
						</button>
					</form>
				@endauth
			</div>
		</div>
	</header>

	<!-- Main Body Layout -->
	<main id="main-content" style="max-width: 1320px; margin: 0 auto; padding: 28px 24px;">
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

		<!-- Overview Stat Cards Grid -->
		<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px;">
			<div style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 18px 20px; box-shadow: var(--shadow);">
				<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
					<span style="font-size: 0.78rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em;">Active Members</span>
					<div style="width: 32px; height: 32px; border-radius: var(--radius-md); background: var(--surface-soft); display: flex; align-items: center; justify-content: center; color: var(--accent-strong);">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
					</div>
				</div>
				<div style="font-size: 1.8rem; font-weight: 900; color: var(--accent-strong); line-height: 1.1;">248</div>
				<span style="font-size: 0.78rem; color: var(--muted); margin-top: 4px; display: block;">180 Regular &bull; 52 Student &bull; 16 Life</span>
			</div>

			<div style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 18px 20px; box-shadow: var(--shadow);">
				<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
					<span style="font-size: 0.78rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em;">Pending Applications</span>
					<div style="width: 32px; height: 32px; border-radius: var(--radius-md); background: rgba(234, 179, 8, 0.12); display: flex; align-items: center; justify-content: center; color: #b45309;">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
					</div>
				</div>
				<div style="font-size: 1.8rem; font-weight: 900; color: #b45309; line-height: 1.1;">4</div>
				<span style="font-size: 0.78rem; color: var(--muted); margin-top: 4px; display: block;">Requires Secretariat Review</span>
			</div>

			<div style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 18px 20px; box-shadow: var(--shadow);">
				<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
					<span style="font-size: 0.78rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em;">Open Inquiries</span>
					<div style="width: 32px; height: 32px; border-radius: var(--radius-md); background: rgba(59, 130, 246, 0.12); display: flex; align-items: center; justify-content: center; color: #1d4ed8;">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
					</div>
				</div>
				<div style="font-size: 1.8rem; font-weight: 900; color: #1d4ed8; line-height: 1.1;">6</div>
				<span style="font-size: 0.78rem; color: var(--muted); margin-top: 4px; display: block;">2 High Priority</span>
			</div>

			<div style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 18px 20px; box-shadow: var(--shadow);">
				<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
					<span style="font-size: 0.78rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em;">Renewals Due</span>
					<div style="width: 32px; height: 32px; border-radius: var(--radius-md); background: rgba(239, 68, 68, 0.12); display: flex; align-items: center; justify-content: center; color: #b91c1c;">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
					</div>
				</div>
				<div style="font-size: 1.8rem; font-weight: 900; color: #b91c1c; line-height: 1.1;">12</div>
				<span style="font-size: 0.78rem; color: var(--muted); margin-top: 4px; display: block;">Expiring in next 30 days</span>
			</div>
		</div>

		<!-- Navigation Sub-tabs for Portal Admin -->
		<div style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 20px; box-shadow: var(--shadow); margin-bottom: 24px;" id="portal-manager-container">
			<div style="display: flex; gap: 8px; border-bottom: 1px solid var(--border); padding-bottom: 14px; margin-bottom: 20px; overflow-x: auto;" data-portal-admin-tabs>
				<button type="button" class="filter-tab active" data-portal-tab="applications" style="font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
					<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
					Applications (4)
				</button>
				<button type="button" class="filter-tab" data-portal-tab="roster" style="font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
					<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
					Member Roster
				</button>
				<button type="button" class="filter-tab" data-portal-tab="inquiries" style="font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
					<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
					Inquiries (6)
				</button>
				<button type="button" class="filter-tab" data-portal-tab="broadcasts" style="font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
					<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
					Portal Announcements
				</button>
				<button type="button" class="filter-tab" data-portal-tab="settings" style="font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
					<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
					Portal Settings
				</button>
			</div>

			<!-- TAB 1: APPLICATIONS -->
			<div data-portal-panel="applications">
				<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
					<div style="display: flex; gap: 8px; align-items: center;">
						<button type="button" class="button button-quiet" style="font-weight: 700; background: var(--surface-soft); font-size: 0.8rem;">All Statuses</button>
						<button type="button" class="button button-primary" style="font-weight: 700; font-size: 0.8rem;">Under Evaluation (1)</button>
						<button type="button" class="button button-quiet" style="font-weight: 700; font-size: 0.8rem;">Pending</button>
						<button type="button" class="button button-quiet" style="font-weight: 700; font-size: 0.8rem;">Approved</button>
					</div>
					<div style="display: flex; gap: 8px;">
						<input type="text" placeholder="Search applicant..." style="padding: 7px 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 0.85rem; background: var(--surface-soft); color: var(--text); width: 220px;" />
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
								<td style="padding: 14px 16px;"><span style="background: rgba(59, 130, 246, 0.1); color: #1d4ed8; padding: 3px 8px; border-radius: 4px; font-weight: 700; font-size: 0.78rem;">Regular Member</span></td>
								<td style="padding: 14px 16px; color: var(--text);">Sample Institution</td>
								<td style="padding: 14px 16px; color: var(--muted);">MM/DD/YYYY</td>
								<td style="padding: 14px 16px;"><span style="background: rgba(234, 179, 8, 0.15); color: #b45309; padding: 3px 10px; border-radius: 12px; font-weight: 700; font-size: 0.75rem;">Under Evaluation</span></td>
								<td style="padding: 14px 16px; text-align: right;">
									<button type="button" class="button button-primary" style="padding: 5px 10px; font-size: 0.78rem;">Review</button>
									<button type="button" class="button button-secondary" style="padding: 5px 10px; font-size: 0.78rem;">Approve</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<!-- TAB 2: MEMBER ROSTER -->
			<div data-portal-panel="roster" style="display: none;">
				<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
					<div style="display: flex; gap: 8px;">
						<input type="text" placeholder="Search members by name or email..." style="padding: 7px 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 0.85rem; background: var(--surface-soft); color: var(--text); width: 280px;" />
						<select style="padding: 7px 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 0.85rem; background: var(--surface-soft); color: var(--text);">
							<option value="">All Tiers</option>
							<option value="regular">Regular Member</option>
							<option value="student">Associate (Student)</option>
							<option value="life">Life Member</option>
						</select>
					</div>
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
								<td style="padding: 14px 16px;"><span style="background: rgba(59, 130, 246, 0.1); color: #1d4ed8; padding: 3px 8px; border-radius: 4px; font-weight: 700; font-size: 0.78rem;">Regular Member</span></td>
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
				<div style="display: flex; flex-direction: column; gap: 12px;">
					<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 14px 16px; display: flex; justify-content: space-between; align-items: center;">
						<div>
							<div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
								<span style="font-weight: 800; color: var(--accent-strong); font-size: 0.92rem;">Application Status</span>
								<span style="background: rgba(239, 68, 68, 0.12); color: #b91c1c; padding: 2px 8px; border-radius: 10px; font-size: 0.7rem; font-weight: 800;">SUBMITTED</span>
							</div>
							<div style="font-size: 0.8rem; color: var(--muted);">From: <strong>Sample Name</strong> (example@email.com) &bull; Submitted: MM/DD/YYYY</div>
						</div>
						<button type="button" class="button button-secondary" style="padding: 6px 12px; font-size: 0.8rem;">Reply</button>
					</div>

					<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 14px 16px; display: flex; justify-content: space-between; align-items: center;">
						<div>
							<div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
								<span style="font-weight: 800; color: var(--accent-strong); font-size: 0.92rem;">Membership Status</span>
								<span style="background: rgba(234, 179, 8, 0.15); color: #b45309; padding: 2px 8px; border-radius: 10px; font-size: 0.7rem; font-weight: 800;">UNDER REVIEW</span>
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

			<!-- TAB 5: SETTINGS -->
			<div data-portal-panel="settings" style="display: none;">
				<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
					<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px;">
						<h4 style="margin: 0 0 12px; color: var(--accent-strong); font-weight: 800;">Membership Dues &amp; Tier Rates</h4>
						<div style="display: flex; flex-direction: column; gap: 10px;">
							<label style="font-size: 0.8rem; font-weight: 700; color: var(--muted);">REGULAR MEMBER DUES (PHP)
								<input type="number" value="1000" style="width: 100%; margin-top: 4px; padding: 8px 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text);" />
							</label>
							<label style="font-size: 0.8rem; font-weight: 700; color: var(--muted);">STUDENT MEMBER DUES (PHP)
								<input type="number" value="500" style="width: 100%; margin-top: 4px; padding: 8px 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text);" />
							</label>
							<label style="font-size: 0.8rem; font-weight: 700; color: var(--muted);">LIFE MEMBERSHIP ONE-TIME (PHP)
								<input type="number" value="10000" style="width: 100%; margin-top: 4px; padding: 8px 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--surface); color: var(--text);" />
							</label>
						</div>
						<button type="button" class="button button-primary" style="margin-top: 14px; font-weight: 700;">Save Rates</button>
					</div>

					<div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px;">
						<h4 style="margin: 0 0 12px; color: var(--accent-strong); font-weight: 800;">Portal Features &amp; Workflow</h4>
						<label style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px; font-size: 0.88rem;">
							<input type="checkbox" checked /> Allow Online Member Application Submissions
						</label>
						<label style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px; font-size: 0.88rem;">
							<input type="checkbox" checked /> Require Endorsement Upload for Student Tier
						</label>
						<label style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px; font-size: 0.88rem;">
							<input type="checkbox" checked /> Automated Email Notification on Status Change
						</label>
						<button type="button" class="button button-primary" style="margin-top: 14px; font-weight: 700;">Save Settings</button>
					</div>
				</div>
			</div>
		</div>
	</main>

	<!-- Floating Theme Toggle Button -->
	<button class="theme-toggle floating-theme-toggle" type="button" data-theme-toggle aria-label="Toggle theme mode" title="Toggle theme mode">
		<span class="theme-icon theme-icon-moon" aria-hidden="true">&#x263E;</span>
		<span class="theme-icon theme-icon-sun" aria-hidden="true">&#x2600;</span>
		<span class="floating-theme-tooltip">
			<span class="theme-toggle-text theme-label-dark">Dark Mode</span>
			<span class="theme-toggle-text theme-label-light">Light Mode</span>
		</span>
	</button>

	<!-- Script for Tab Switching -->
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const container = document.getElementById('portal-manager-container');
			if (!container) return;

			container.addEventListener('click', function(event) {
				const tabBtn = event.target.closest('[data-portal-tab]');
				if (!tabBtn) return;

				const targetTab = tabBtn.getAttribute('data-portal-tab');
				const tabs = container.querySelectorAll('[data-portal-tab]');
				tabs.forEach(t => t.classList.toggle('active', t === tabBtn));

				const panels = container.querySelectorAll('[data-portal-panel]');
				panels.forEach(p => {
					const isTarget = p.getAttribute('data-portal-panel') === targetTab;
					p.style.display = isTarget ? 'block' : 'none';
				});
			});
		});
	</script>
</body>

</html>
