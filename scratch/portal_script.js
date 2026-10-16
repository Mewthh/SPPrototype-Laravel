
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

					const recSurname = app.recommender_surname || '';
					const recFirst = app.recommender_first_name || '';
					const recFull = (recFirst || recSurname) ? `${recFirst} ${recSurname}`.trim() : (app.recommender_name || '—');
					document.getElementById('modal-recommender-name').textContent = recFull;
					document.getElementById('modal-recommender-email').textContent = app.recommender_email || '—';
					document.getElementById('modal-recommender-suffix').textContent = app.recommender_suffix || '—';
					document.getElementById('modal-alt-recommender-name').textContent = app.alt_recommender_name || '—';
					const altRecEmailEl = document.getElementById('modal-alt-recommender-email');
					if (altRecEmailEl) altRecEmailEl.textContent = app.alt_recommender_email || '—';

					document.getElementById('modal-surname').textContent = app.surname || '—';
					document.getElementById('modal-first-name').textContent = app.first_name || '—';
					document.getElementById('modal-middle-name').textContent = app.middle_name || '—';
					document.getElementById('modal-mobile-number').textContent = app.mobile_number || '—';
					const altMobEl = document.getElementById('modal-alt-mobile-number');
					if (altMobEl) altMobEl.textContent = app.alt_mobile_number || '—';
					document.getElementById('modal-personal-email').textContent = app.account_email || '—';

					document.getElementById('modal-current-affiliation').textContent = app.current_affiliation || '—';
					document.getElementById('modal-current-position').textContent = app.current_position || '—';
					document.getElementById('modal-institutional-email').textContent = app.institutional_email || '—';

					document.getElementById('modal-highest-education').textContent = app.highest_educational_attainment || '—';
					document.getElementById('modal-degree').textContent = app.degree || '—';
					document.getElementById('modal-date-degree-obtained').textContent = app.date_degree_obtained || '—';
					document.getElementById('modal-institution').textContent = app.institution_name || app.current_affiliation || '—';
					document.getElementById('modal-institution-address').textContent = app.institution_address || '—';

					// Documents Population
					const docBadgesEl = document.getElementById('modal-header-doc-badges');
					if (docBadgesEl) {
						docBadgesEl.innerHTML = '';
						if (app.cv_path) {
							docBadgesEl.innerHTML += `<span style="background: var(--surface); color: var(--text); border: 1px solid var(--border); padding: 2px 8px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 700;">CV Attached</span>`;
						}
						if (app.proof_path) {
							docBadgesEl.innerHTML += `<span style="background: var(--surface); color: var(--text); border: 1px solid var(--border); padding: 2px 8px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 700;">Proof Attached</span>`;
						}
					}

					const cvActions = document.getElementById('modal-cv-actions');
					const cvFilename = document.getElementById('modal-cv-filename');
					const cvDocUrl = app.cv_path ? `/admin/api/membership-applications/${app.id}/document/cv` : null;

					if (cvActions) {
						if (cvDocUrl) {
							if (cvFilename) cvFilename.textContent = app.cv_path.split('/').pop() || 'PDF Document Attached';
							cvActions.innerHTML = `
								<a href="${cvDocUrl}" target="_blank" rel="noopener noreferrer" class="button button-secondary" style="font-size: 0.78rem; padding: 6px 14px; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
									View CV
									<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
								</a>
							`;
						} else {
							if (cvFilename) cvFilename.textContent = 'No CV file attached';
							cvActions.innerHTML = `<span style="background: var(--surface-soft); color: var(--muted); border: 1px solid var(--border); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 700;">Not Attached</span>`;
						}
					}

					const proofActions = document.getElementById('modal-proof-actions');
					const proofFilename = document.getElementById('modal-proof-filename');
					const proofDocUrl = app.proof_path ? `/admin/api/membership-applications/${app.id}/document/proof` : null;

					if (proofActions) {
						if (proofDocUrl) {
							if (proofFilename) proofFilename.textContent = app.proof_path.split('/').pop() || 'Proof Document Attached';
							proofActions.innerHTML = `
								<a href="${proofDocUrl}" target="_blank" rel="noopener noreferrer" class="button button-secondary" style="font-size: 0.78rem; padding: 6px 14px; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
									View Proof
									<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
								</a>
							`;
						} else {
							if (proofFilename) proofFilename.textContent = 'No proof file attached';
							proofActions.innerHTML = `<span style="background: var(--surface-soft); color: var(--muted); border: 1px solid var(--border); padding: 3px 10px; border-radius: var(--radius-pill); font-size: 0.72rem; font-weight: 700;">Not Attached</span>`;
						}
					}

					document.getElementById('modal-declaration').textContent = app.declaration_agree ? 'Agreed' : 'No';
					document.getElementById('modal-certification').textContent = app.certification_confirm ? 'Confirmed' : 'No';
					const certEmailEl = document.getElementById('modal-certification-email');
					if (certEmailEl) certEmailEl.textContent = app.certification_email || (app.certification_confirm ? 'Confirmed' : '—');
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
			const getInquiryRows = () => document.querySelectorAll('#inquiries-table-body [data-inquiry-row]');
			const inquiryStatusFilterBtns = document.querySelectorAll('[data-inquiry-status-filter]');
			const inquiryTypeFilterSelect = document.querySelector('[data-inquiry-type-filter]');
			const inquiryCategoryFilterSelect = document.querySelector('[data-inquiry-category-filter]');
			const inquirySearchInput = document.querySelector('[data-inquiry-search]');
			const inquiriesEmptyState = document.getElementById('inquiries-empty-state');
			const inquiryModal = document.getElementById('inquiry-detail-modal');
			const closeInquiryModalBtns = document.querySelectorAll('[data-close-inquiry-modal]');
			const sendResponseBtn = document.getElementById('modal-send-response-btn');

			const adminInquiryShowMoreBtn = document.getElementById('admin-inquiry-show-more');
			const adminInquiryShowLessBtn = document.getElementById('admin-inquiry-show-less');
			const adminInquiryToggleWrap = document.getElementById('admin-inquiry-toggle-wrap');

			let activeInquiryStatus = 'all';
			let activeInquiryType = 'all';
			let activeInquiryCategory = 'all';
			let activeInquirySearch = '';
			let currentActiveRow = null;
			let adminInquiryExpanded = false;

			function updateInquiryCounts() {
				const allRows = getInquiryRows();
				let counts = { all: allRows.length, Submitted: 0, 'Under Review': 0, Responded: 0, Closed: 0 };
				allRows.forEach(r => {
					const s = r.getAttribute('data-status');
					if (counts[s] !== undefined) counts[s]++;
				});
				const cAll = document.getElementById('inquiry-count-all');
				const cSub = document.getElementById('inquiry-count-submitted');
				const cRev = document.getElementById('inquiry-count-under-review');
				const cRes = document.getElementById('inquiry-count-responded');
				const cClo = document.getElementById('inquiry-count-closed');
				const navCount = document.getElementById('nav-inquiries-count');
				if (cAll) cAll.textContent = counts.all;
				if (cSub) cSub.textContent = counts.Submitted;
				if (cRev) cRev.textContent = counts['Under Review'];
				if (cRes) cRes.textContent = counts.Responded;
				if (cClo) cClo.textContent = counts.Closed;
				if (navCount) navCount.textContent = counts.all;
			}

			function filterInquiries(resetExpansion = false) {
				if (resetExpansion) {
					adminInquiryExpanded = false;
				}

				const allRows = getInquiryRows();
				let matchingRows = [];

				allRows.forEach(row => {
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

					const isMatch = matchesStatus && matchesType && matchesCategory && matchesSearch;
					if (isMatch) {
						matchingRows.push(row);
					} else {
						row.style.display = 'none';
					}
				});

				const totalMatching = matchingRows.length;
				if (inquiriesEmptyState) {
					inquiriesEmptyState.style.display = totalMatching === 0 ? 'block' : 'none';
				}

				if (totalMatching <= 3) {
					if (adminInquiryToggleWrap) adminInquiryToggleWrap.style.display = 'none';
					matchingRows.forEach(r => r.style.display = '');
				} else {
					if (adminInquiryToggleWrap) adminInquiryToggleWrap.style.display = 'flex';
					if (!adminInquiryExpanded) {
						matchingRows.forEach((r, idx) => {
							r.style.display = idx < 3 ? '' : 'none';
						});
						if (adminInquiryShowMoreBtn) adminInquiryShowMoreBtn.style.display = '';
						if (adminInquiryShowLessBtn) adminInquiryShowLessBtn.style.display = 'none';
					} else {
						matchingRows.forEach(r => r.style.display = '');
						if (adminInquiryShowMoreBtn) adminInquiryShowMoreBtn.style.display = 'none';
						if (adminInquiryShowLessBtn) adminInquiryShowLessBtn.style.display = '';
					}
				}
			}

			adminInquiryShowMoreBtn?.addEventListener('click', function() {
				adminInquiryExpanded = true;
				filterInquiries(false);
			});

			adminInquiryShowLessBtn?.addEventListener('click', function() {
				adminInquiryExpanded = false;
				filterInquiries(false);
			});

			inquiryStatusFilterBtns.forEach(btn => {
				btn.addEventListener('click', function() {
					activeInquiryStatus = this.getAttribute('data-inquiry-status-filter');
					inquiryStatusFilterBtns.forEach(b => {
						const isActive = b === btn;
						b.classList.toggle('button-primary', isActive);
						b.classList.toggle('button-quiet', !isActive);
						b.setAttribute('aria-pressed', String(isActive));
					});
					filterInquiries(true);
				});
			});

			if (inquiryTypeFilterSelect) {
				inquiryTypeFilterSelect.addEventListener('change', function() {
					activeInquiryType = this.value;
					filterInquiries(true);
				});
			}

			if (inquiryCategoryFilterSelect) {
				inquiryCategoryFilterSelect.addEventListener('change', function() {
					activeInquiryCategory = this.value;
					filterInquiries(true);
				});
			}

			if (inquirySearchInput) {
				inquirySearchInput.addEventListener('input', function() {
					activeInquirySearch = this.value.trim();
					filterInquiries(true);
				});
			}

			filterInquiries(true);

			// Inquirer Info Category Tab Switcher (Category 1, 2, 3, 4)
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
					section.style.display = (cat === activeCat) ? 'flex' : 'none';
				});
			}

			inquiryCatTabBtns.forEach(btn => {
				btn.addEventListener('click', function() {
					setInquiryInfoCategory(this.getAttribute('data-inquiry-info-tab'));
				});
			});

			if (inquiryModal) {
				inquiryModal.querySelectorAll('[data-inquiry-switch-cat]').forEach(btn => {
					btn.addEventListener('click', function() {
						const target = this.getAttribute('data-inquiry-switch-cat');
						if (target) setInquiryInfoCategory(target);
					});
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
					let currentUploadedFile = null;

					// Populate header & contact
					document.getElementById('modal-ticket-id').textContent = `Ticket #${ticketId}`;
					document.getElementById('modal-inquirer-name').textContent = name;
					const cardNameEl = document.getElementById('modal-card-inquirer-name');
					if (cardNameEl) cardNameEl.textContent = name;

					document.getElementById('modal-inquirer-email').textContent = email;
					document.getElementById('modal-inquirer-institution').textContent = inst;
					document.getElementById('modal-inquirer-tier').textContent = tier;
					document.getElementById('modal-submitted-date').textContent = date;
					document.getElementById('modal-inquiry-remarks').textContent = remarks || 'No additional remarks provided.';

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
						classTypeEl.textContent = isApplicant ? 'New Membership Applicant' : 'Registered SPP Member';
						classTypeEl.style.cssText = isApplicant
							? 'background: var(--surface-strong); color: var(--muted); border: 1px solid var(--border); padding: 2px 8px; border-radius: 4px; font-weight: 600; font-size: 0.76rem;'
							: 'background: rgba(22, 163, 74, 0.07); color: #15803d; border: 1px solid rgba(22, 163, 74, 0.2); padding: 2px 8px; border-radius: 4px; font-weight: 600; font-size: 0.76rem;';
					}

					const appTypeEl = document.getElementById('modal-inquiry-application-type') || document.getElementById('modal-application-type');
					if (appTypeEl) appTypeEl.textContent = appType;

					// Reset category tab to first tab (Inquirer Information) when modal opens
					setInquiryInfoCategory('profile');

					const targetEmailEl = document.getElementById('modal-response-target-email');
					if (targetEmailEl) targetEmailEl.textContent = email;

					const queryTypeLabel = document.getElementById('modal-query-type-label');
					if (queryTypeLabel) queryTypeLabel.textContent = queryType;

					const queryBadge = document.getElementById('modal-query-badge');
					if (queryBadge) {
						queryBadge.textContent = queryType;
						queryBadge.style.cssText = 'background: var(--surface-strong); color: var(--muted); border: 1px solid var(--border); padding: 2px 9px; border-radius: 4px; font-size: 0.73rem; font-weight: 600;';
					}

					// Dynamic Questions Display (Clean, Spacious Mini-Cards)
					const fieldsContainer = document.getElementById('modal-inquiry-fields-container');
					const remarksTitle = document.getElementById('modal-inquiry-remarks-title');

					if (fieldsContainer) {
						let html = '';
						if (queryType === 'Membership Status') {
							if (remarksTitle) remarksTitle.textContent = 'Background Context & Purpose of Inquiry';
							html = `
								<div style="background: var(--surface); padding: 14px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
									<span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; letter-spacing: 0.03em;">Last Known Membership</span>
									<span style="font-size: 0.94rem; font-weight: 700; color: var(--accent-strong); margin-top: 3px; display: block;">${lastKnownMem || 'Not specified'}</span>
								</div>
								<div style="background: var(--surface); padding: 14px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
									<span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; letter-spacing: 0.03em;">Year of Last SPP Attendance</span>
									<span style="font-size: 0.94rem; font-weight: 700; color: var(--accent-strong); margin-top: 3px; display: block;">${lastAttYear || 'N/A'}</span>
								</div>
								<div style="background: var(--surface); padding: 14px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); grid-column: 1 / -1;">
									<span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; letter-spacing: 0.03em;">Last SPP Attendance (Place)</span>
									<span style="font-size: 0.94rem; font-weight: 700; color: var(--accent-strong); margin-top: 3px; display: block;">${lastAttPlace || 'N/A'}</span>
								</div>
							`;
						} else if (queryType === 'Request for Certificate of Membership') {
							if (remarksTitle) remarksTitle.textContent = 'Additional Inquirer Notes';
							html = `
								<div style="background: var(--surface); padding: 14px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
									<span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; letter-spacing: 0.03em;">Year of Oath Taking</span>
									<span style="font-size: 0.94rem; font-weight: 700; color: var(--accent-strong); margin-top: 3px; display: block;">${oathYear || 'N/A'}</span>
								</div>
								<div style="background: var(--surface); padding: 14px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
									<span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; letter-spacing: 0.03em;">Venue of Oath Taking</span>
									<span style="font-size: 0.94rem; font-weight: 700; color: var(--accent-strong); margin-top: 3px; display: block;">${oathVenue || 'Online'}</span>
								</div>
								<div style="background: var(--surface); padding: 14px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
									<span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; letter-spacing: 0.03em;">Known Membership Type</span>
									<span style="font-size: 0.94rem; font-weight: 700; color: var(--accent-strong); margin-top: 3px; display: block;">${knownMemType || tier}</span>
								</div>
								<div style="background: var(--surface); padding: 14px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
									<span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; letter-spacing: 0.03em;">Last Attendance</span>
									<span style="font-size: 0.94rem; font-weight: 700; color: var(--accent-strong); margin-top: 3px; display: block;">${lastAttYear ? `${lastAttYear} (${lastAttPlace || 'N/A'})` : 'N/A'}</span>
								</div>
								<div style="background: var(--surface); padding: 14px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); grid-column: 1 / -1;">
									<span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; letter-spacing: 0.03em;">Intended Certificate Purpose</span>
									<span style="font-size: 0.94rem; font-weight: 700; color: var(--accent-strong); margin-top: 3px; display: block;">${purpose || 'Faculty Evaluation and Professional Dossier'}</span>
								</div>
							`;
						} else {
							if (remarksTitle) remarksTitle.textContent = 'Member Concern / Detailed Inquiry';
							html = `
								<div style="background: var(--surface); padding: 14px 16px; border-radius: var(--radius-sm); border: 1px solid var(--border); grid-column: 1 / -1;">
									<span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--muted); display: block; letter-spacing: 0.03em;">Inquiry Keyword(s)</span>
									<span style="font-size: 0.94rem; font-weight: 700; color: var(--accent-strong); margin-top: 3px; display: block;">${keywords || 'fee, inquiry'}</span>
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
								certStatusBadge.textContent = currentAttachedCert ? 'Attached & Ready' : 'Recommended';
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
								currentUploadedFile = file;
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

					// Cert Preview Button (Opens directly in a new tab)
					const certPreviewBtn = document.getElementById('modal-cert-preview-btn');
					if (certPreviewBtn) {
						certPreviewBtn.onclick = function() {
							if (currentUploadedFile) {
								const fileUrl = URL.createObjectURL(currentUploadedFile);
								window.open(fileUrl, '_blank');
								return;
							}
							const previewWin = window.open('', '_blank');
							if (previewWin) {
								previewWin.document.write(`
									<!DOCTYPE html>
									<html lang="en">
									<head>
										<meta charset="UTF-8">
										<meta name="viewport" content="width=device-width, initial-scale=1.0">
										<title>Certificate Preview - ${currentAttachedCert || 'SPP Certificate'}</title>
										<style>
											body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; background: #0b1120; color: #f8fafc; padding: 24px; }
											.card { background: #1e293b; border: 1px solid #334155; border-radius: 16px; max-width: 580px; width: 100%; padding: 40px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); text-align: center; }
											.header-kicker { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: #38bdf8; margin-bottom: 6px; }
											h1 { font-size: 1.45rem; font-weight: 900; color: #f8fafc; margin: 0 0 8px 0; }
											.sub { font-size: 0.88rem; color: #94a3b8; margin: 0 0 24px 0; }
											.badge { display: inline-block; background: rgba(56, 189, 248, 0.12); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.25); border-radius: 9999px; padding: 4px 14px; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.04em; margin-bottom: 24px; }
											.grid { display: flex; flex-direction: column; gap: 10px; text-align: left; margin-bottom: 24px; }
											.row { background: #0f172a; border: 1px solid #1e293b; border-radius: 8px; padding: 12px 16px; }
											.label { font-size: 0.7rem; color: #64748b; font-weight: 800; text-transform: uppercase; letter-spacing: 0.04em; }
											.val { font-size: 0.95rem; font-weight: 700; color: #f8fafc; margin-top: 2px; }
											.footer { font-size: 0.75rem; color: #64748b; border-top: 1px solid #334155; padding-top: 16px; }
										</style>
									</head>
									<body>
										<div class="card">
											<div class="header-kicker">Samahang Pisika ng Pilipinas</div>
											<h1>Official Certificate of Good Standing</h1>
											<p class="sub">Official Secretariat &amp; Executive Board Certification Record</p>
											<div class="badge">Verified Certificate Document</div>
											<div class="grid">
												<div class="row"><div class="label">Recipient / Inquirer</div><div class="val">${name}</div></div>
												<div class="row"><div class="label">Certificate File</div><div class="val">${currentAttachedCert}</div></div>
												<div class="row"><div class="label">File Size / Details</div><div class="val">${currentAttachedCertSize || '245 KB • Certified Copy'}</div></div>
												<div class="row"><div class="label">Validation Security</div><div class="val">Digital Signature &amp; Serialized Seal</div></div>
											</div>
											<div class="footer">Samahang Pisika ng Pilipinas National Secretariat</div>
										</div>
									</body>
									</html>
								`);
								previewWin.document.close();
							}
						};
					}

					// Cert Remove Button
					const certRemoveBtn = document.getElementById('modal-cert-remove-btn');
					if (certRemoveBtn) {
						certRemoveBtn.onclick = function() {
							currentAttachedCert = '';
							currentAttachedCertSize = '';
							currentUploadedFile = null;
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

					const internalNotesInput = document.getElementById('modal-internal-notes');
					if (internalNotesInput) internalNotesInput.value = response;

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
					const newResponse = document.getElementById('modal-internal-notes')?.value || '';
					const certFileName = document.getElementById('modal-cert-filename');
					const certAttachedState = document.getElementById('modal-cert-attached-state');

					const isCertAttached = certAttachedState && certAttachedState.style.display !== 'none';
					const certName = isCertAttached && certFileName ? certFileName.textContent : '';

					currentActiveRow.setAttribute('data-status', newStatus);
					currentActiveRow.setAttribute('data-response', newResponse);
					currentActiveRow.setAttribute('data-certificate-attached', certName);

					// Persist via API
					const inqId = currentActiveRow.getAttribute('data-inquiry-id');
					if (inqId) {
						const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
						fetch(`/admin/api/inquiries/${inqId}/status`, {
							method: 'PATCH',
							headers: {
								'Content-Type': 'application/json',
								'X-CSRF-TOKEN': csrfToken,
								'X-Requested-With': 'XMLHttpRequest',
								'Accept': 'application/json'
							},
							body: JSON.stringify({
								status: newStatus,
								admin_response: newResponse,
								certificate_attached: certName,
								certificate_size: isCertAttached ? (currentActiveRow.getAttribute('data-certificate-size') || '245 KB • Certified Copy') : null
							})
						}).catch(console.error);
					}

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

					alert('Status updated successfully.');
					inquiryModal.style.display = 'none';
					updateInquiryCounts();
					filterInquiries(false);
				});
			}
		});
	