<x-layouts.portal title="Inquiries | SPP Membership Portal">

    {{-- Portal floating toast (mirrors admin floating-toast structure) --}}
    <div id="portal-floating-toast" class="portal-floating-toast-container portal-toast-hidden" role="status" aria-live="polite">
        <div class="portal-floating-toast-card">
            <span class="portal-floating-toast-icon" id="portal-floating-toast-icon" aria-hidden="true">&#x2714;</span>
            <div class="portal-floating-toast-content">
                <span class="portal-floating-toast-message" id="portal-floating-toast-message">Saved successfully.</span>
            </div>
            <button type="button" class="portal-floating-toast-close" id="portal-floating-toast-close" aria-label="Dismiss notification">&times;</button>
        </div>
    </div>
    <div class="portal-page-header">
        <div>
            <p class="portal-eyebrow">Support</p>
            <h1>Inquiries</h1>
        </div>
    </div>

    @if (session('status'))
        <div style="background: rgba(22, 163, 74, 0.1); border: 1px solid rgba(22, 163, 74, 0.25); color: #15803d; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; font-size: 0.88rem;">
            {{ session('status') }}
        </div>
    @endif

    <section class="portal-card">
        <h2>Submit Inquiry</h2>
        <form class="portal-form" id="portal-inquiry-form" method="POST" action="{{ route('membership-portal.inquiries.store') }}">
            @csrf
            <!-- Query Type Selector -->
            <label class="portal-form-wide">
                <span>Query Type <span style="color: #dc2626;">*</span></span>
                <select id="portal-query-type" name="query_type" style="font-weight: 700;">
                    <option value="membership_status">Membership Status</option>
                    <option value="certificate">Request for Certificate of Membership</option>
                    <option value="other">Other</option>
                </select>
            </label>

            <!-- SECTION 1: Membership Status -->
            <div id="fields-membership_status" class="portal-form-wide" style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 17px;">
                <label>
                    <span>Last known membership <span style="color: #dc2626;">*</span></span>
                    <select name="last_known_membership" required>
                        <option value="" disabled selected>Select last known membership</option>
                        <option value="Associate member">Associate member</option>
                        <option value="Regular member">Regular member</option>
                        <option value="Institutional partner">Institutional partner</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                </label>

                <label>
                    <span>Year of last SPP attendance</span>
                    <input type="text" name="status_last_attendance_year" placeholder="YYYY" pattern="[12][0-9]{3}" maxlength="4" />
                    <small style="font-weight: 500; font-size: 0.74rem; opacity: 0.8; color: var(--portal-muted);">Enter year only [yyyy]: E.g. 2001</small>
                </label>

                <label class="portal-form-wide">
                    <span>Last SPP attendance (place)</span>
                    <input type="text" name="status_last_attendance_place" placeholder="City or Host Institution (e.g. UP Diliman, Quezon City)" />
                </label>

                <label class="portal-form-wide">
                    <span>Remarks</span>
                    <textarea name="status_remarks" rows="4" placeholder="Kindly provide some background or context of your query. You may also express the purpose why you wish to know..."></textarea>
                </label>
            </div>

            <!-- SECTION 2: Request for Certificate of Membership -->
            <div id="fields-certificate" class="portal-form-wide" style="display: none; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 17px;">
                <label>
                    <span>Year of oath taking</span>
                    <input type="text" name="cert_oath_year" placeholder="YYYY" pattern="[12][0-9]{3}" maxlength="4" />
                </label>

                <label>
                    <span>Venue of oath taking</span>
                    <input type="text" name="cert_oath_venue" placeholder="e.g. DLSU Manila or Online" />
                    <small style="font-weight: 500; font-size: 0.74rem; opacity: 0.8; color: var(--portal-muted);">Put &quot;Online&quot; if done online or submitted as video.</small>
                </label>

                <label class="portal-form-wide">
                    <span>Known membership type</span>
                    <select name="cert_membership_type">
                        <option value="" disabled selected>Select membership type</option>
                        <option value="Associate">Associate</option>
                        <option value="Regular">Regular</option>
                        <option value="Institutional">Institutional - please add the institutional name in remarks below</option>
                        <option value="Fellow">Fellow</option>
                        <option value="Honorary">Honorary</option>
                    </select>
                </label>

                <label>
                    <span>Year of last SPP attendance</span>
                    <input type="text" name="cert_attendance_year" placeholder="YYYY" pattern="[12][0-9]{3}" maxlength="4" />
                    <small style="font-weight: 500; font-size: 0.74rem; opacity: 0.8; color: var(--portal-muted);">Enter year only [yyyy]: E.g. 2001</small>
                </label>

                <label>
                    <span>Last SPP attendance (place)</span>
                    <input type="text" name="cert_attendance_place" placeholder="City or Host Institution (e.g. Ateneo de Davao, Davao City)" />
                </label>

                <label class="portal-form-wide">
                    <span>Purpose</span>
                    <textarea name="cert_purpose" rows="3" placeholder="Please state the purpose for which the certificate is intended..."></textarea>
                </label>
            </div>

            <!-- SECTION 3: Other -->
            <div id="fields-other" class="portal-form-wide" style="display: none; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 17px;">
                <label class="portal-form-wide">
                    <span>Keyword(s) <span style="color: #dc2626;">*</span></span>
                    <input type="text" name="other_keywords" placeholder="e.g. fee, conference discount, roster update" />
                </label>

                <label class="portal-form-wide">
                    <span>Concern / Remarks</span>
                    <textarea name="other_concern" rows="4" placeholder="Please type your concern below..."></textarea>
                    <small style="font-weight: 500; font-size: 0.74rem; opacity: 0.8; color: var(--portal-muted);">Please type your concern below. A committee member will respond to you as soon as possible.</small>
                </label>
            </div>

            <div class="portal-form-wide">
                <button type="submit" class="portal-button" id="portal-inquiry-submit-btn">
                    <span id="portal-submit-label">Submit</span>
                    <span id="portal-submit-spinner" style="display: none; align-items: center; gap: 6px;">
                        <svg style="animation: portalSpin 0.8s linear infinite;" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
                        Submitting…
                    </span>
                </button>
            </div>
        </form>
    </section>

    <section class="portal-card">
        <div class="portal-section-heading">
            <h2>Inquiry History</h2>
        </div>
        <div class="portal-table-wrap">
            <table class="portal-table">
                <thead>
                    <tr>
                        <th>Query Type</th>
                        <th>Details / Summary</th>
                        <th>Date Submitted</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="portal-inquiry-tbody">
                    @forelse ($inquiries ?? [] as $index => $item)
                        <tr class="portal-inquiry-row" data-inquiry-index="{{ $index }}">
                            <td>
                                <strong>{{ $item->query_type }}</strong>
                                @if ($item->certificate_attached)
                                    <div style="margin-top: 4px;">
                                        <a href="#" class="portal-text-link" style="display: inline-flex; align-items: center; gap: 5px; font-size: 0.78rem;" onclick="alert('Downloading official SPP Certificate of Membership (PDF)...'); return false;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                            Download Attached Certificate (PDF)
                                        </a>
                                    </div>
                                @endif
                            </td>
                            <td style="color: var(--portal-muted); font-size: 0.86rem;">
                                @if ($item->query_type === 'Membership Status')
                                    Last known: {{ $item->last_known_membership ?? 'Not specified' }}
                                    @if ($item->last_attendance_year)
                                        &bull; Last attended: {{ $item->last_attendance_year }}{{ $item->last_attendance_place ? ' ('.$item->last_attendance_place.')' : '' }}
                                    @endif
                                @elseif ($item->query_type === 'Request for Certificate of Membership')
                                    @if ($item->purpose)
                                        {{ $item->purpose }} &bull;
                                    @endif
                                    Known type: {{ $item->known_membership_type ?? 'Regular' }}
                                    @if ($item->oath_year)
                                        &bull; Oath: {{ $item->oath_year }}
                                    @endif
                                    @if ($item->certificate_attached)
                                        &bull; Certificate attached by Secretariat
                                    @endif
                                @else
                                    Keywords: {{ $item->keywords ?? 'General' }}
                                    @if ($item->remarks)
                                        &bull; {{ \Illuminate\Support\Str::limit($item->remarks, 60) }}
                                    @endif
                                @endif
                            </td>
                            <td>{{ $item->created_at?->format('m/d/Y') ?? now()->format('m/d/Y') }}</td>
                            <td><x-portal.status-badge :status="$item->status" /></td>
                        </tr>
                    @empty
                        <tr id="portal-inquiry-empty-row">
                            <td colspan="4" style="text-align: center; color: var(--portal-muted); padding: 24px;">No inquiries submitted yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="portal-inquiry-toggle-wrap" style="display: none; justify-content: center; gap: 8px; margin-top: 16px;">
            <button type="button" class="portal-button" id="portal-inquiry-show-more" style="background: transparent; color: var(--portal-text); border: 1px solid var(--portal-border); font-size: 0.82rem; padding: 6px 18px; cursor: pointer;">Show more</button>
            <button type="button" class="portal-button" id="portal-inquiry-show-less" style="display: none; background: transparent; color: var(--portal-text); border: 1px solid var(--portal-border); font-size: 0.82rem; padding: 6px 18px; cursor: pointer;">Show less</button>
        </div>
    </section>

    <style>
        @keyframes portalSpin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .portal-floating-toast-container {
            position: fixed;
            top: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 99999;
            pointer-events: none;
            display: flex;
            justify-content: center;
            align-items: center;
            width: auto;
            max-width: 90vw;
            transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1), transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .portal-toast-hidden {
            opacity: 0;
            transform: translate(-50%, -20px) scale(0.95);
            pointer-events: none;
            visibility: hidden;
        }

        .portal-floating-toast-card {
            pointer-events: auto;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            background: var(--portal-surface, #ffffff);
            border: 1px solid var(--portal-border, #e2e8f0);
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            color: var(--portal-text, #1e293b);
            animation: portalToastDropIn 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes portalToastDropIn {
            0% { opacity: 0; transform: translateY(-16px) scale(0.96); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }

        .portal-floating-toast-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            background: #16a34a;
            color: #ffffff;
            border-radius: 50%;
            font-size: 0.78rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .portal-floating-toast-container.is-error .portal-floating-toast-icon {
            background: #dc2626;
        }

        .portal-floating-toast-content {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .portal-floating-toast-message {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--portal-text, #0f172a);
        }

        .portal-floating-toast-close {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            margin-left: 8px;
            background: transparent;
            border: none;
            border-radius: 4px;
            color: var(--portal-muted, #94a3b8);
            font-size: 1.25rem;
            line-height: 1;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .portal-floating-toast-close:hover {
            background: var(--portal-surface-soft, #f1f5f9);
            color: var(--portal-text, #0f172a);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Portal Toast ---
            let portalToastTimer = null;
            function showPortalToast(message, isError = false) {
                const toast = document.getElementById('portal-floating-toast');
                const msg = document.getElementById('portal-floating-toast-message');
                const icon = document.getElementById('portal-floating-toast-icon');
                if (!toast || !msg) return;
                msg.textContent = message;
                toast.classList.toggle('is-error', isError);
                icon.textContent = isError ? '\u2715' : '\u2714';
                toast.classList.remove('portal-toast-hidden');
                clearTimeout(portalToastTimer);
                portalToastTimer = setTimeout(() => toast.classList.add('portal-toast-hidden'), 4000);
            }

            document.getElementById('portal-floating-toast-close')?.addEventListener('click', () => {
                document.getElementById('portal-floating-toast')?.classList.add('portal-toast-hidden');
            });

            // --- Query Type Sections ---
            const queryTypeSelect = document.getElementById('portal-query-type');
            const sectionMembership = document.getElementById('fields-membership_status');
            const sectionCert = document.getElementById('fields-certificate');
            const sectionOther = document.getElementById('fields-other');

            function toggleSections() {
                const val = queryTypeSelect.value;

                if (sectionMembership) sectionMembership.style.display = (val === 'membership_status') ? 'grid' : 'none';
                if (sectionCert) sectionCert.style.display = (val === 'certificate') ? 'grid' : 'none';
                if (sectionOther) sectionOther.style.display = (val === 'other') ? 'grid' : 'none';

                const lastKnownSelect = sectionMembership ? sectionMembership.querySelector('[name="last_known_membership"]') : null;
                const otherKeywordsInput = sectionOther ? sectionOther.querySelector('[name="other_keywords"]') : null;

                if (lastKnownSelect) lastKnownSelect.required = (val === 'membership_status');
                if (otherKeywordsInput) otherKeywordsInput.required = (val === 'other');
            }

            if (queryTypeSelect) {
                queryTypeSelect.addEventListener('change', toggleSections);
                toggleSections();
            }

            // --- Inquiry History Max 3 Pagination ---
            const rows = () => document.querySelectorAll('#portal-inquiry-tbody .portal-inquiry-row');
            const showMoreBtn = document.getElementById('portal-inquiry-show-more');
            const showLessBtn = document.getElementById('portal-inquiry-show-less');
            const toggleWrap = document.getElementById('portal-inquiry-toggle-wrap');
            let isExpanded = false;

            function updatePagination() {
                const allRows = rows();
                const total = allRows.length;

                if (total <= 3) {
                    if (toggleWrap) toggleWrap.style.display = 'none';
                    allRows.forEach(r => r.style.display = '');
                    return;
                }

                if (toggleWrap) toggleWrap.style.display = 'flex';

                if (!isExpanded) {
                    allRows.forEach((r, idx) => { r.style.display = idx < 3 ? '' : 'none'; });
                    if (showMoreBtn) showMoreBtn.style.display = '';
                    if (showLessBtn) showLessBtn.style.display = 'none';
                } else {
                    allRows.forEach(r => r.style.display = '');
                    if (showMoreBtn) showMoreBtn.style.display = 'none';
                    if (showLessBtn) showLessBtn.style.display = '';
                }
            }

            showMoreBtn?.addEventListener('click', () => { isExpanded = true; updatePagination(); });
            showLessBtn?.addEventListener('click', () => { isExpanded = false; updatePagination(); });

            updatePagination();

            // --- Form Submit via AJAX ---
            const inquiryForm = document.getElementById('portal-inquiry-form');
            if (inquiryForm) {
                inquiryForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const submitBtn = document.getElementById('portal-inquiry-submit-btn');
                    const submitLabel = document.getElementById('portal-submit-label');
                    const submitSpinner = document.getElementById('portal-submit-spinner');

                    if (submitBtn) submitBtn.disabled = true;
                    if (submitLabel) submitLabel.style.display = 'none';
                    if (submitSpinner) submitSpinner.style.display = 'inline-flex';

                    const formData = new FormData(inquiryForm);
                    fetch(inquiryForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (submitBtn) submitBtn.disabled = false;
                        if (submitLabel) submitLabel.style.display = '';
                        if (submitSpinner) submitSpinner.style.display = 'none';

                        if (data.success) {
                            const tbody = document.getElementById('portal-inquiry-tbody');
                            const emptyRow = document.getElementById('portal-inquiry-empty-row');
                            if (emptyRow) emptyRow.remove();

                            const newRow = document.createElement('tr');
                            newRow.className = 'portal-inquiry-row';

                            let certHtml = '';
                            if (data.data.certificate_attached) {
                                certHtml = `<div style="margin-top: 4px;">
                                    <a href="#" class="portal-text-link" style="display: inline-flex; align-items: center; gap: 5px; font-size: 0.78rem;" onclick="alert('Downloading official SPP Certificate of Membership (PDF)...'); return false;">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                        Download Attached Certificate (PDF)
                                    </a>
                                </div>`;
                            }

                            newRow.innerHTML = `
                                <td><strong>${data.formatted.query_type}</strong>${certHtml}</td>
                                <td style="color: var(--portal-muted); font-size: 0.86rem;">${data.formatted.details_summary}</td>
                                <td>${data.formatted.date}</td>
                                <td><span class="portal-badge" style="background: rgba(107, 114, 128, 0.1); color: var(--portal-muted); border: 1px solid var(--portal-border); font-size: 0.72rem; font-weight: 700; padding: 3px 8px; border-radius: 4px;">${data.formatted.status}</span></td>
                            `;
                            tbody.insertBefore(newRow, tbody.firstChild);

                            inquiryForm.reset();
                            toggleSections();
                            isExpanded = false;
                            updatePagination();

                            showPortalToast(data.message || 'Your inquiry has been submitted to the Secretariat.');
                        } else {
                            showPortalToast(data.message || 'Failed to submit inquiry. Please check the fields and try again.', true);
                        }
                    })
                    .catch(() => {
                        if (submitBtn) submitBtn.disabled = false;
                        if (submitLabel) submitLabel.style.display = '';
                        if (submitSpinner) submitSpinner.style.display = 'none';
                        inquiryForm.submit();
                    });
                });
            }
        });
    </script>
</x-layouts.portal>
