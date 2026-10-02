<x-layouts.portal title="Inquiries | SPP Membership Portal">
    <div class="portal-page-header">
        <div>
            <p class="portal-eyebrow">Support</p>
            <h1>Inquiries</h1>
        </div>
    </div>

    <section class="portal-card">
        <h2>Submit Inquiry</h2>
        <form class="portal-form" id="portal-inquiry-form" onsubmit="return false;">
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
                <button type="submit" class="portal-button" onclick="alert('Your inquiry has been submitted to the Secretariat. If a response is required, we will email you.');">Submit Inquiry</button>
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
                <tbody>
                    <tr>
                        <td><strong>Membership Status</strong></td>
                        <td style="color: var(--portal-muted); font-size: 0.86rem;">Last known: Associate member &bull; Last attended: 2023 (Tagbilaran City)</td>
                        <td>09/29/2025</td>
                        <td><x-portal.status-badge status="Under Review" /></td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Request for Certificate of Membership</strong>
                            <div style="margin-top: 4px;">
                                <a href="#" class="portal-text-link" style="display: inline-flex; align-items: center; gap: 5px; font-size: 0.78rem;" onclick="alert('Downloading official SPP Certificate of Membership (PDF)...'); return false;">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                    Download Attached Certificate (PDF)
                                </a>
                            </div>
                        </td>
                        <td style="color: var(--portal-muted); font-size: 0.86rem;">Faculty promotion dossier &bull; Known type: Regular &bull; Oath: 2018 &bull; Certificate attached by Secretariat</td>
                        <td>09/26/2025</td>
                        <td><x-portal.status-badge status="Responded" /></td>
                    </tr>
                    <tr>
                        <td><strong>Membership Status</strong></td>
                        <td style="color: var(--portal-muted); font-size: 0.86rem;">Record verification &bull; Last known: Regular member &bull; Last attended: 2022</td>
                        <td>09/20/2025</td>
                        <td><x-portal.status-badge status="Submitted" /></td>
                    </tr>
                    <tr>
                        <td><strong>Other</strong></td>
                        <td style="color: var(--portal-muted); font-size: 0.86rem;">Keywords: fee, institutional roster addition</td>
                        <td>09/18/2025</td>
                        <td><x-portal.status-badge status="Closed" /></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const queryTypeSelect = document.getElementById('portal-query-type');
            const sectionMembership = document.getElementById('fields-membership_status');
            const sectionCert = document.getElementById('fields-certificate');
            const sectionOther = document.getElementById('fields-other');

            function toggleSections() {
                const val = queryTypeSelect.value;

                if (sectionMembership) sectionMembership.style.display = (val === 'membership_status') ? 'grid' : 'none';
                if (sectionCert) sectionCert.style.display = (val === 'certificate') ? 'grid' : 'none';
                if (sectionOther) sectionOther.style.display = (val === 'other') ? 'grid' : 'none';

                // Manage HTML5 required validation
                const lastKnownSelect = sectionMembership ? sectionMembership.querySelector('[name="last_known_membership"]') : null;
                const otherKeywordsInput = sectionOther ? sectionOther.querySelector('[name="other_keywords"]') : null;

                if (lastKnownSelect) {
                    lastKnownSelect.required = (val === 'membership_status');
                }
                if (otherKeywordsInput) {
                    otherKeywordsInput.required = (val === 'other');
                }
            }

            if (queryTypeSelect) {
                queryTypeSelect.addEventListener('change', toggleSections);
                toggleSections();
            }
        });
    </script>
</x-layouts.portal>
