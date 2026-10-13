<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Join SPP | Membership Application</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" />
    <script>
        (function () {
            const theme = localStorage.getItem('spp-theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
            document.documentElement.classList.toggle('dark', theme === 'dark');
        })();
    </script>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/portal.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/join-spp.css') }}" />
</head>
<body class="join-spp-body">
    <!-- Topbar -->
    <header class="portal-topbar">
        <a class="brand" href="{{ route('home') }}" aria-label="Samahang Pisika ng Pilipinas Home">
            <span class="brand-mark" aria-hidden="true">SPP</span>
            <span class="brand-copy">
                <strong>Samahang Pisika ng Pilipinas</strong>
                <span>Membership Application</span>
            </span>
        </a>

        <div class="portal-topbar-actions">
            <a href="{{ route('home') }}" class="join-btn join-btn-secondary" style="padding: 7px 14px; font-size: 0.82rem;">
                &larr; Back to Home
            </a>
        </div>
    </header>

    <!-- Main Container -->
    <main class="join-spp-container">
        <!-- Intro -->
        <div class="join-spp-intro">
            <p class="join-spp-eyebrow">Samahang Pisika ng Pilipinas</p>
            <h1 class="join-spp-title">Join SPP Membership</h1>
            <p class="join-spp-subtitle">
                Complete the membership application below to join the premier professional society of physicists in the Philippines.
            </p>
        </div>

        <!-- Compact Guidelines Banner (Triggers Pop-up) -->
        <div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; background: var(--portal-surface-soft); border: 1px solid var(--portal-border); border-left: 4px solid var(--portal-accent-strong, #1b7a4c); border-radius: 10px; padding: 12px 18px; flex-wrap: wrap; gap: 10px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 1.2rem; line-height: 1; color: var(--portal-accent-strong, #1b7a4c);" aria-hidden="true">&#x2139;</span>
                <span style="font-size: 0.88rem; color: var(--portal-text);">
                    <strong>Important:</strong> Review the online membership prerequisites and fee guidelines before submitting.
                </span>
            </div>
            <button type="button" id="btn-trigger-info-modal" class="join-btn join-btn-secondary" style="padding: 5px 12px; font-size: 0.8rem;">
                View Guidelines &amp; Requirements
            </button>
        </div>

        <!-- Guidelines & Information Pop-up Modal -->
        <div id="join-info-modal" style="display: flex; position: fixed; inset: 0; z-index: 9999; background: rgba(0, 0, 0, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px; overflow-y: auto;" role="dialog" aria-modal="true" aria-labelledby="join-info-modal-title">
            <div style="background: var(--portal-surface, #ffffff); border: 1px solid var(--portal-border); border-radius: 16px; max-width: 840px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25); margin: auto;">
                <!-- Modal Header -->
                <div style="padding: 20px 28px; border-bottom: 1px solid var(--portal-border); display: flex; justify-content: space-between; align-items: center; background: var(--portal-surface-soft);">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 1.35rem; line-height: 1; color: var(--portal-accent-strong, #1b7a4c);">&#x2139;</span>
                        <h2 id="join-info-modal-title" style="font-size: 1.2rem; font-weight: 800; color: var(--portal-text); margin: 0;">Application Information &amp; Guidelines</h2>
                    </div>
                    <button type="button" id="btn-close-info-modal-x" style="background: none; border: none; font-size: 1.6rem; color: var(--portal-muted); cursor: pointer; padding: 0 4px; line-height: 1;" aria-label="Close guidelines modal">&times;</button>
                </div>

                <!-- Modal Content Body -->
                <div style="padding: 26px 28px; font-size: 0.95rem; line-height: 1.65; color: var(--portal-text);">
                    <p style="margin: 0 0 12px; font-weight: 700; color: var(--portal-text);">
                        This is an online version of SPP Membership. Further instructions will be sent to your email.
                    </p>
                    <p style="margin: 0 0 16px; color: var(--portal-text);">
                        Membership fee is incorporated (waived) into the Conference Fee. It is recommended that you <strong>REGISTER AS A PARTICIPANT</strong> in the Physics Conference this year before applying for membership as follows.
                    </p>

                    <div style="background: var(--portal-surface-soft); border: 1px solid var(--portal-border); border-radius: 10px; padding: 14px 18px; margin-bottom: 16px;">
                        <strong style="display: block; margin-bottom: 8px; font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.04em; color: var(--portal-muted);">
                            You will need to ready the following files to proceed:
                        </strong>
                        <ol style="margin: 0; padding-left: 20px; font-size: 0.88rem; display: flex; flex-direction: column; gap: 6px;">
                            <li><strong>[All]</strong> Updated Curriculum Vitae (CV) &mdash; for records purposes.</li>
                            <li><strong>[All Applicants]</strong> Email of the recommending mentor / former professor.</li>
                            <li><strong>[Grad. Students only]</strong> Proof of Employment / Enrollment.</li>
                        </ol>
                    </div>

                    <p style="margin: 0; font-size: 0.86rem; color: var(--portal-muted);">
                        We will request recommendation based on your provided email. You may request recommendation from your research supervisor, an SPP Fellow, or Regular Member. It is preferred that the recommending party use his/her institutional email address in making this recommendation email.
                    </p>
                </div>

                <!-- Modal Footer -->
                <div style="padding: 14px 24px; border-top: 1px solid var(--portal-border); display: flex; justify-content: space-between; align-items: center; background: var(--portal-surface-soft);">
                    <span style="font-size: 0.78rem; color: var(--portal-muted);">You can reopen this at any time using the View Guidelines & Requirements</span>
                    <button type="button" id="btn-close-info-modal-ok" class="join-btn join-btn-primary" style="padding: 7px 20px; font-size: 0.85rem;">
                        Got It
                    </button>
                </div>
            </div>
        </div>

        <!-- 6-Stage Visual Stepper -->
        <nav class="join-stepper-wrap" aria-label="Application Progress Stepper">
            <div class="join-step-connector" aria-hidden="true"></div>
            <ol class="join-stepper-list">
                <li>
                    <button type="button" class="join-step-item is-active" data-step-target="1" aria-current="step">
                        <span class="join-step-indicator">1</span>
                        <span class="join-step-name">Recommender</span>
                    </button>
                </li>
                <li>
                    <button type="button" class="join-step-item" data-step-target="2">
                        <span class="join-step-indicator">2</span>
                        <span class="join-step-name">Member Information</span>
                    </button>
                </li>
                <li>
                    <button type="button" class="join-step-item" data-step-target="3">
                        <span class="join-step-indicator">3</span>
                        <span class="join-step-name">Documents</span>
                    </button>
                </li>
                <li>
                    <button type="button" class="join-step-item" data-step-target="4">
                        <span class="join-step-indicator">4</span>
                        <span class="join-step-name">Validation / Certification</span>
                    </button>
                </li>
                <li>
                    <button type="button" class="join-step-item" data-step-target="5">
                        <span class="join-step-indicator">5</span>
                        <span class="join-step-name">Account Setup</span>
                    </button>
                </li>
                <li>
                    <button type="button" class="join-step-item" data-step-target="6">
                        <span class="join-step-indicator">6</span>
                        <span class="join-step-name">Review &amp; Submit</span>
                    </button>
                </li>
            </ol>
        </nav>

        <!-- Multi-Step Form Container -->
        <form id="join-spp-form" method="POST" action="{{ route('join-spp.store') }}" enctype="multipart/form-data">
            @csrf
            <!-- Default Application Metadata -->
            <input type="hidden" name="membership_type" value="Regular Member" />
            <input type="hidden" name="application_type" value="New Application" />
            <input type="hidden" id="application_date" name="application_date" value="{{ now()->format('m/d/Y') }}" />

            <!-- STAGE 1: Recommender Details -->
            <section class="join-step-pane is-active" data-step="1" aria-labelledby="step-1-heading">
                <div class="join-form-card">
                    <div class="join-card-head">
                        <h2 id="step-1-heading">Stage 1: Recommender Details</h2>
                        <p>We will send a request for recommendation to the person VIA email. Applicants must be endorsed by an active SPP Regular Member, Fellow, or supervisor.</p>
                    </div>

                    <!-- Primary Applicant Email (First Form Question) -->
                    <div class="join-field-group" style="margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid var(--portal-border);">
                        <label class="join-field-label" for="primary_email">Email <span style="color: #ef4444;">*</span></label>
                        <input type="email" id="primary_email" name="primary_email" class="join-input" placeholder="applicant@email.com" required />
                        <small style="color: var(--portal-muted); font-size: 0.78rem; margin-top: 4px; display: block;">
                            Further instructions and application updates will be sent to your email.
                        </small>
                    </div>

                    <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 8px; color: var(--portal-text);">Recommendation</h3>
                    <p style="font-size: 0.82rem; color: var(--portal-muted); margin-bottom: 16px;">We will send a request for recommendation to the person VIA email. The first recommender is required.</p>
                    
                    <div class="join-form-grid" style="margin-bottom: 24px;">
                        <div class="join-field-group">
                            <label class="join-field-label" for="recommender_suffix">Suffix</label>
                            <select id="recommender_suffix" name="recommender_suffix" class="join-select">
                                <option value="">Select suffix</option>
                                <option value="Prof.">Prof.</option>
                                <option value="Dr.">Dr.</option>
                                <option value="Mr.">Mr.</option>
                                <option value="Ms.">Ms.</option>
                                <option value="Mrs.">Mrs.</option>
                                <option value="Other">Other</option>
                            </select>
                            <input type="text" id="recommender_suffix_other" class="join-input" placeholder="Specify suffix (e.g. Engr.)" style="display: none; margin-top: 8px;" />
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="recommender_surname">Surname <span style="color: #ef4444;">*</span></label>
                            <input type="text" id="recommender_surname" name="recommender_surname" class="join-input" placeholder="e.g. Santos" required />
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="recommender_first_name">First Name(s) <span style="color: #ef4444;">*</span></label>
                            <input type="text" id="recommender_first_name" name="recommender_first_name" class="join-input" placeholder="e.g. Maria" required />
                        </div>
                        <div class="join-field-group join-form-grid-full">
                            <label class="join-field-label" for="recommender_email">Email address <span style="color: #ef4444;">*</span></label>
                            <input type="email" id="recommender_email" name="recommender_email" class="join-input" placeholder="recommender@institution.edu" required />
                            <small style="color: var(--portal-muted); font-size: 0.78rem; margin-top: 4px; display: block;">
                                We prefer that you provide institutional email and that the recommending person be notified.
                            </small>
                        </div>
                    </div>

                    <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 8px; color: var(--portal-text);">Alternate Recommender (alt1)</h3>
                    <p style="font-size: 0.82rem; color: var(--portal-muted); margin-bottom: 16px;">Optional second recommender endorsement.</p>

                    <div class="join-form-grid" style="margin-bottom: 20px;">
                        <div class="join-field-group">
                            <label class="join-field-label" for="alt_recommender_name">Fullname</label>
                            <input type="text" id="alt_recommender_name" name="alt_recommender_name" class="join-input" placeholder="SURNAME / FirstNames / M.I." />
                            <small style="color: var(--portal-muted); font-size: 0.76rem; margin-top: 4px; display: block;">SURNAME / FirstNames / M.I.</small>
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="alt_recommender_email">Email address</label>
                            <input type="email" id="alt_recommender_email" name="alt_recommender_email" class="join-input" placeholder="alt.recommender@institution.edu" />
                            <small style="color: var(--portal-muted); font-size: 0.76rem; margin-top: 4px; display: block;">
                                We prefer that you provide institutional email and that the recommending person be notified.
                            </small>
                        </div>
                    </div>
                </div>
            </section>

            <!-- STAGE 2: Member Information -->
            <section class="join-step-pane" data-step="2" aria-labelledby="step-2-heading">
                <!-- Personal Information -->
                <div class="join-form-card" style="margin-bottom: 20px;">
                    <div class="join-card-head" style="margin-bottom: 18px; padding-bottom: 12px;">
                        <h2 id="step-2-heading" style="margin-bottom: 6px;">Stage 2: Member Information</h2>
                        <p style="margin-bottom: 16px;">Provide your personal details, institutional affiliation, and educational credentials.</p>
                        <h3 style="font-size: 1.1rem; font-weight: 700; margin: 0; color: var(--portal-text);">Personal Information</h3>
                    </div>
                    <div class="join-form-grid">
                        <div class="join-field-group">
                            <label class="join-field-label" for="surname">Surname <span style="color: #ef4444;">*</span></label>
                            <input type="text" id="surname" name="surname" class="join-input" placeholder="e.g. Dela Cruz" required />
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="first_name">First Name(s) <span style="color: #ef4444;">*</span></label>
                            <input type="text" id="first_name" name="first_name" class="join-input" placeholder="e.g. Juan" required />
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="middle_name">Middle Name(s)</label>
                            <input type="text" id="middle_name" name="middle_name" class="join-input" placeholder="e.g. Mercado" />
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="mobile_number">Mobile phone number</label>
                            <input type="tel" id="mobile_number" name="mobile_number" class="join-input" placeholder="0988-123-4567" />
                            <small style="color: var(--portal-muted); font-size: 0.78rem; margin-top: 4px; display: block; line-height: 1.4;">
                                Format: 0988-123-4567 // Could be used to contact you for quick update or query regarding your application status and if the application is approved, the Oath Taking schedule and other matters.
                            </small>
                        </div>
                        <div class="join-field-group join-form-grid-full">
                            <label class="join-field-label" for="alt_mobile_number">Mobile phone number (optional)</label>
                            <input type="tel" id="alt_mobile_number" name="alt_mobile_number" class="join-input" placeholder="0988-123-4567 or +63 912..." />
                            <small style="color: var(--portal-muted); font-size: 0.78rem; margin-top: 4px; display: block; line-height: 1.4;">
                                Philippine-based mobile number only. For Viber international mobile number, include the country code.
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Professional Information -->
                <div class="join-form-card" style="margin-bottom: 20px;">
                    <div class="join-card-head" style="margin-bottom: 18px; padding-bottom: 12px;">
                        <h3 style="font-size: 1.1rem; font-weight: 700; margin: 0; color: var(--portal-text);">Professional Information</h3>
                    </div>
                    <div class="join-form-grid">
                        <div class="join-field-group join-form-grid-full">
                            <label class="join-field-label" for="current_affiliation">Current Institutional Affiliation <span style="color: #ef4444;">*</span></label>
                            <input type="text" id="current_affiliation" name="current_affiliation" class="join-input" placeholder="Sample Institution" required />
                            <small style="color: var(--portal-muted); font-size: 0.78rem; margin-top: 4px; display: block;">
                                Professional organization or institution. Please do not abbreviate.
                            </small>
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="current_position_select">Current Position <span style="color: #ef4444;">*</span></label>
                            <select id="current_position_select" class="join-select" required>
                                <option value="" disabled selected>Select current position</option>
                                <option value="Professor">Professor</option>
                                <option value="Assoc. Professor">Assoc. Professor</option>
                                <option value="Asst. Professor">Asst. Professor</option>
                                <option value="Instructor">Instructor</option>
                                <option value="Faculty">Faculty</option>
                                <option value="MS Student">MS Student</option>
                                <option value="PhD Student">PhD Student</option>
                                <option value="Other">Other</option>
                            </select>
                            <input type="text" id="current_position_other" class="join-input" placeholder="Specify position name" style="display: none; margin-top: 8px;" />
                            <input type="hidden" id="current_position" name="current_position" value="" />
                            <small style="color: var(--portal-muted); font-size: 0.78rem; margin-top: 4px; display: block;">
                                If not in the academe, please choose "Other" and input the appropriate position name.
                            </small>
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="professional_email">Email Address (Professional/Institutional) <span style="color: #ef4444;">*</span></label>
                            <input type="email" id="professional_email" name="professional_email" class="join-input" placeholder="institutional@university.edu.ph" required />
                            <small style="color: var(--portal-muted); font-size: 0.78rem; margin-top: 4px; display: block;">
                                This are emails with ends such as *.edu or *.edu.ph and other institutional addresses. You may just write the same email above if same as the one you are using to fill-out this form.
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Educational Information -->
                <div class="join-form-card">
                    <div class="join-card-head" style="margin-bottom: 18px; padding-bottom: 12px;">
                        <h3 style="font-size: 1.1rem; font-weight: 700; margin: 0; color: var(--portal-text);">Educational Information</h3>
                    </div>
                    <div class="join-form-grid">
                        <div class="join-field-group join-form-grid-full">
                            <label class="join-field-label" for="highest_educational_attainment">Highest completed educational attainment (Degree) <span style="color: #ef4444;">*</span></label>
                            <input type="text" id="highest_educational_attainment" name="highest_educational_attainment" class="join-input" placeholder="e.g. MS Physics" required />
                            <small style="color: var(--portal-muted); font-size: 0.78rem; margin-top: 4px; display: block;">
                                Examples:. PhD Physics, MS Physics, BS Applied Physics, BS Physics // STUDENT? Write something like: "MS Physics student".
                            </small>
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="date_degree_obtained">Date degree is obtained <span style="color: #ef4444;">*</span></label>
                            <input type="text" id="date_degree_obtained" name="date_degree_obtained" class="join-input" placeholder="e.g. June 2018" required />
                            <small style="color: var(--portal-muted); font-size: 0.78rem; margin-top: 4px; display: block;">
                                Provide Month and Year only. Example: June 2018 // STUDENT? Write expected Month Year of graduation.
                            </small>
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="institution">Institution where Degree is obtained <span style="color: #ef4444;">*</span></label>
                            <input type="text" id="institution" name="institution" class="join-input" placeholder="e.g. University of the Philippines" required />
                            <small style="color: var(--portal-muted); font-size: 0.78rem; margin-top: 4px; display: block;">
                                Give complete names, examples: "University of the Philippines", "Ateneo de Manila"
                            </small>
                        </div>
                        <div class="join-field-group join-form-grid-full">
                            <label class="join-field-label" for="institution_address">Address of the Institution where Degree is obtained <span style="color: #ef4444;">*</span></label>
                            <input type="text" id="institution_address" name="institution_address" class="join-input" placeholder="e.g. Quezon City, Philippines" required />
                            <small style="color: var(--portal-muted); font-size: 0.78rem; margin-top: 4px; display: block;">
                                Examples: "Quezon City, Philippines", "Romblon, Philippines"
                            </small>
                        </div>
                    </div>
                </div>
            </section>

            <!-- STAGE 3: Documents -->
            <section class="join-step-pane" data-step="3" aria-labelledby="step-3-heading">
                <div class="join-form-card">
                    <div class="join-card-head">
                        <h2 id="step-3-heading">Stage 3: Documents</h2>
                        <p>Upload your academic curriculum vitae and employment or enrollment credentials.</p>
                    </div>

                    <div style="display: grid; gap: 24px;">
                        <!-- CV Card -->
                        <div style="border: 1px solid var(--portal-border); border-radius: 12px; padding: 20px; background: var(--portal-surface-soft);">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                <div>
                                    <h3 style="font-size: 1rem; font-weight: 700; margin: 0; color: var(--portal-text);">Updated Curriculum Vitae (CV) <span style="color: #ef4444;">*</span></h3>
                                    <p style="font-size: 0.82rem; color: var(--portal-muted); margin: 2px 0 0;">Recent academic CV highlighting research, publications, and physics activities.</p>
                                </div>
                                <span class="portal-badge portal-badge-active" id="badge-cv-file" style="font-size: 0.72rem;">Required</span>
                            </div>
                            <input type="file" id="cv_file" name="cv_file" accept=".pdf" style="display: none;" />
                            <div class="join-upload-zone" id="zone-cv-file" style="cursor: pointer;" onclick="document.getElementById('cv_file').click()">
                                <span class="join-upload-icon">&#x1F4C4;</span>
                                <div class="join-upload-text" id="text-cv-file">Click to browse or drop Updated CV file here</div>
                                <div class="join-upload-hint">Upload 1 supported file: PDF. Max 100 MB.</div>
                            </div>
                        </div>

                        <!-- Proof of Employment Card -->
                        <div style="border: 1px solid var(--portal-border); border-radius: 12px; padding: 20px; background: var(--portal-surface-soft);">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                <div>
                                    <h3 style="font-size: 1rem; font-weight: 700; margin: 0; color: var(--portal-text);">Proof of Employment or Enrollment</h3>
                                    <p style="font-size: 0.82rem; color: var(--portal-muted); margin: 2px 0 0;">Such as School ID, Company ID, HR appointment, etc. (Required for Graduate Students).</p>
                                </div>
                                <span class="portal-badge portal-badge-pending" id="badge-proof-file" style="font-size: 0.72rem;">Grad. Students Only</span>
                            </div>
                            <input type="file" id="proof_file" name="proof_file" accept=".pdf,.jpg,.jpeg,.png" style="display: none;" />
                            <div class="join-upload-zone" id="zone-proof-file" style="cursor: pointer;" onclick="document.getElementById('proof_file').click()">
                                <span class="join-upload-icon">&#x1F4C1;</span>
                                <div class="join-upload-text" id="text-proof-file">Click to browse or drop Proof file here</div>
                                <div class="join-upload-hint">Upload 1 supported file: PDF or image. Max 10 MB.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- STAGE 4: Validation / Certification -->
            <section class="join-step-pane" data-step="4" aria-labelledby="step-4-heading">
                <div class="join-form-card">
                    <div class="join-card-head">
                        <h2 id="step-4-heading">Stage 4: VALIDATION &amp; CERTIFICATION</h2>
                        <p>Affirm the veracity of all supplied details and commit to the constitution of the Samahang Pisika ng Pilipinas.</p>
                    </div>

                    <div style="margin-bottom: 24px;">
                        <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 12px; color: var(--portal-text);">
                            VALIDATION <span style="color: #ef4444;">*</span>
                        </h3>
                        <label class="join-cert-box" style="cursor: pointer;">
                            <input type="checkbox" id="declaration_agree" name="declaration_agree" value="1" checked required />
                            <div class="join-cert-copy">
                                <strong>Declaration: Agree <span style="color: #ef4444;">*</span></strong>
                                <p style="margin-top: 6px; line-height: 1.5;">
                                    By clicking "Agree" below, I hereby declare that the information provided in this online form is true to the best of my ability. Further, that if admitted to the Samahang Pisika ng Pilipinas (Physics Society of the Philippines), I consciously agree to be bound by its Constitution and by- laws and to advance the objectives of the Samahan in so far as in my power.
                                </p>
                            </div>
                        </label>
                    </div>

                    <div style="background: var(--portal-surface-soft); border: 1px solid var(--portal-border); border-radius: 12px; padding: 20px;">
                        <h3 style="font-size: 1.05rem; font-weight: 700; margin: 0 0 4px 0; color: var(--portal-text);">
                            CERTIFICATION <span style="color: #ef4444;">*</span>
                        </h3>
                        <p style="font-size: 0.85rem; color: var(--portal-muted); margin: 0 0 14px 0;">
                            By typing your email address below, you certify the validity of this submission
                        </p>
                        <div class="join-field-group">
                            <label class="join-field-label" for="certification_email">Certification Email <span style="color: #ef4444;">*</span></label>
                            <input type="email" id="certification_email" name="certification_email" class="join-input" placeholder="Type your email address to certify" required />
                        </div>
                    </div>
                </div>
            </section>

            <!-- STAGE 5: Account Setup -->
            <section class="join-step-pane" data-step="5" aria-labelledby="step-5-heading">
                <div class="join-form-card">
                    <div class="join-card-head">
                        <h2 id="step-5-heading">Stage 5: Account Setup</h2>
                        <p>Create your portal account login credentials. Once your application is submitted, you will use these credentials to log in to the SPP Membership Portal.</p>
                    </div>

                    <div class="join-form-grid">
                        <div class="join-field-group">
                            <label class="join-field-label" for="account_email">Account Email Address <span style="color: #ef4444;">*</span></label>
                            <input type="email" id="account_email" name="account_email" class="join-input" placeholder="e.g. user@email.com" required />
                            <small style="color: var(--portal-muted); font-size: 0.78rem; margin-top: 4px;">This email will be your portal login username.</small>
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="account_password">Password <span style="color: #ef4444;">*</span></label>
                            <input type="password" id="account_password" name="account_password" class="join-input" placeholder="••••••••••••" required />
                            <small style="color: var(--portal-muted); font-size: 0.78rem; margin-top: 4px;">Minimum 8 characters with letters and numbers.</small>
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="account_password_confirmation">Confirm Password <span style="color: #ef4444;">*</span></label>
                            <input type="password" id="account_password_confirmation" name="account_password_confirmation" class="join-input" placeholder="••••••••••••" required />
                            <small style="color: var(--portal-muted); font-size: 0.78rem; margin-top: 4px;">Re-enter password to confirm.</small>
                        </div>
                    </div>
                </div>
            </section>

            <!-- STAGE 6: Review & Submit -->
            <section class="join-step-pane" data-step="6" aria-labelledby="step-6-heading">
                <div class="join-form-card">
                    <div class="join-card-head">
                        <h2 id="step-6-heading">Stage 6: Review &amp; Submit</h2>
                        <p>Review all submitted information and your portal account credentials before submitting your application.</p>
                    </div>

                    <div class="join-review-grid">
                        <!-- Recommender Summary -->
                        <div class="join-review-card">
                            <div class="join-review-header">
                                <h3>Recommender</h3>
                                <button type="button" class="join-review-edit-btn" onclick="goToStep(1)">Edit</button>
                            </div>
                            <dl class="join-review-dl">
                                <div><dt>Applicant Email</dt><dd id="review-primary-email">—</dd></div>
                                <div><dt>Suffix</dt><dd id="review-recommender-suffix">—</dd></div>
                                <div><dt>Primary Recommender</dt><dd id="review-recommender-name">—</dd></div>
                                <div><dt>Email Address</dt><dd id="review-recommender-email">—</dd></div>
                                <div><dt>Alternate Recommender</dt><dd id="review-alt-recommender-name">—</dd></div>
                                <div><dt>Alternate Email</dt><dd id="review-alt-recommender-email">—</dd></div>
                            </dl>
                        </div>

                        <!-- Member Information Summary -->
                        <div class="join-review-card">
                            <div class="join-review-header">
                                <h3>Member Information</h3>
                                <button type="button" class="join-review-edit-btn" onclick="goToStep(2)">Edit</button>
                            </div>
                            <dl class="join-review-dl">
                                <div><dt>Surname</dt><dd id="review-surname">—</dd></div>
                                <div><dt>First Name(s)</dt><dd id="review-first-name">—</dd></div>
                                <div><dt>Middle Name(s)</dt><dd id="review-middle-name">—</dd></div>
                                <div><dt>Mobile Number</dt><dd id="review-mobile-number">—</dd></div>
                                <div><dt>Secondary Mobile</dt><dd id="review-alt-mobile-number">—</dd></div>
                                <div><dt>Current Affiliation</dt><dd id="review-affiliation">—</dd></div>
                                <div><dt>Current Position</dt><dd id="review-position">—</dd></div>
                                <div><dt>Professional Email</dt><dd id="review-professional-email">—</dd></div>
                                <div><dt>Degree Attainment</dt><dd id="review-highest-ed">—</dd></div>
                                <div><dt>Date Degree Obtained</dt><dd id="review-degree-date">—</dd></div>
                                <div><dt>Institution</dt><dd id="review-institution">—</dd></div>
                                <div><dt>Institution Address</dt><dd id="review-institution-address">—</dd></div>
                            </dl>
                        </div>

                        <!-- Documents Summary -->
                        <div class="join-review-card">
                            <div class="join-review-header">
                                <h3>Documents</h3>
                                <button type="button" class="join-review-edit-btn" onclick="goToStep(3)">Edit</button>
                            </div>
                            <div style="display: grid; gap: 8px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 14px; background: var(--portal-surface-soft); border: 1px solid var(--portal-border); border-radius: 8px;">
                                    <span style="font-weight: 600; font-size: 0.88rem;">Updated CV (PDF)</span>
                                    <span id="review-cv-status" class="portal-badge portal-badge-pending" style="font-size: 0.72rem;">Not Uploaded</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 14px; background: var(--portal-surface-soft); border: 1px solid var(--portal-border); border-radius: 8px;">
                                    <span style="font-weight: 600; font-size: 0.88rem;">Proof of Employment / Enrollment</span>
                                    <span id="review-proof-status" class="portal-badge portal-badge-pending" style="font-size: 0.72rem;">Not Uploaded</span>
                                </div>
                            </div>
                        </div>

                        <!-- Validation Summary -->
                        <div class="join-review-card">
                            <div class="join-review-header">
                                <h3>Validation / Certification</h3>
                                <button type="button" class="join-review-edit-btn" onclick="goToStep(4)">Edit</button>
                            </div>
                            <dl class="join-review-dl">
                                <div><dt>VALIDATION</dt><dd id="review-declaration">Agreed</dd></div>
                                <div><dt>CERTIFICATION</dt><dd id="review-certification">—</dd></div>
                            </dl>
                        </div>

                        <!-- Portal Account Summary -->
                        <div class="join-review-card">
                            <div class="join-review-header">
                                <h3>Portal Account Credentials</h3>
                                <button type="button" class="join-review-edit-btn" onclick="goToStep(5)">Edit</button>
                            </div>
                            <dl class="join-review-dl">
                                <div><dt>Account Login Email</dt><dd id="review-account-email">—</dd></div>
                                <div><dt>Password</dt><dd>••••••••••••</dd></div>
                                <div><dt>Account Status</dt><dd><span class="portal-badge portal-badge-pending">Pending Creation</span></dd></div>
                            </dl>
                        </div>
                    </div>

                    <!-- Submit Button Area -->
                    <div id="join-submit-area" style="margin-top: 28px; text-align: center; padding-top: 20px; border-top: 1px solid var(--portal-border);">
                        <button type="button" id="btn-submit-application" class="join-btn join-btn-primary" style="padding: 12px 32px; font-size: 1rem;">
                            Submit Application
                        </button>
                        <p style="font-size: 0.8rem; color: var(--portal-muted); margin-top: 8px;">
                            Submitting creates your portal account and forwards your application for evaluation.
                        </p>
                    </div>

                    <!-- Submission Success & Login Portal Card -->
                    <div id="join-submission-success" hidden style="margin-top: 20px; padding: 20px 20px; background: var(--portal-surface); border: 1px solid var(--portal-border); border-radius: 12px; text-align: center; box-shadow: var(--portal-shadow, 0 4px 16px rgba(0,0,0,0.06));">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: #10b981; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; margin: 0 auto 10px;">&#x2714;</div>
                        <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--portal-text); margin: 0 0 6px;">Application Submitted &amp; Account Created!</h3>
                        <p style="font-size: 0.82rem; color: var(--portal-muted); max-width: 420px; margin: 0 auto 14px; line-height: 1.45;">
                            Your application has been received and your account is ready. Log in to the portal to track evaluation progress.
                        </p>
                        <div style="background: var(--portal-surface-soft); border: 1px solid var(--portal-border); border-radius: 8px; padding: 10px 16px; display: inline-block; margin-bottom: 16px; text-align: left;">
                            <div style="font-size: 0.7rem; color: var(--portal-muted); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">Portal Account Ready</div>
                            <div style="font-size: 0.9rem; font-weight: 800; color: var(--portal-text); margin-top: 3px;" id="success-account-email">—</div>
                            <div style="display: flex; gap: 6px; align-items: center; margin-top: 6px; flex-wrap: wrap;">
                                <span class="portal-badge portal-badge-active" style="font-size: 0.7rem;">Account Created</span>
                                <span class="portal-badge portal-badge-pending" style="font-size: 0.7rem;">Under Evaluation</span>
                            </div>
                        </div>
                        <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                            <a href="{{ route('membership-portal.dashboard') }}" class="join-btn join-btn-primary" style="padding: 8px 20px; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                <span>Log In to Portal Dashboard</span>
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                            <a href="{{ route('home') }}" class="join-btn join-btn-secondary" style="padding: 8px 16px; font-size: 0.85rem; text-decoration: none;">
                                Return to Home
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Bottom Navigation Bar -->
            <div class="join-action-bar">
                <button type="button" id="btn-prev-step" class="join-btn join-btn-secondary" disabled>
                    &larr; Previous Step
                </button>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <button type="button" id="btn-next-step" class="join-btn join-btn-primary">
                        Next Step &rarr;
                    </button>
                </div>
            </div>
        </form>
    </main>

    <!-- Floating Toast Notification (matches admin style) -->
    <div id="join-toast" class="floating-toast-container is-hidden" role="status" aria-live="polite">
        <div class="floating-toast-card">
            <span class="floating-toast-icon" id="join-toast-icon" aria-hidden="true">&#x2714;</span>
            <div class="floating-toast-content">
                <span class="floating-toast-message" id="join-toast-text">Notification message</span>
            </div>
            <button type="button" class="floating-toast-close" id="join-toast-close" aria-label="Dismiss notification">&times;</button>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 6;

        function updateStepUI() {
            // Update pane visibility
            document.querySelectorAll('.join-step-pane').forEach(pane => {
                const stepNum = parseInt(pane.getAttribute('data-step'), 10);
                pane.classList.toggle('is-active', stepNum === currentStep);
            });

            // Update stepper list
            document.querySelectorAll('.join-step-item').forEach(item => {
                const targetStep = parseInt(item.getAttribute('data-step-target'), 10);
                item.classList.toggle('is-active', targetStep === currentStep);
                item.classList.toggle('is-completed', targetStep < currentStep);
                if (targetStep === currentStep) {
                    item.setAttribute('aria-current', 'step');
                } else {
                    item.removeAttribute('aria-current');
                }
            });

            // Update action bar buttons
            const prevBtn = document.getElementById('btn-prev-step');
            const nextBtn = document.getElementById('btn-next-step');

            if (prevBtn) {
                prevBtn.disabled = currentStep === 1;
            }

            if (nextBtn) {
                if (currentStep === totalSteps) {
                    nextBtn.style.display = 'none';
                } else {
                    nextBtn.style.display = 'inline-flex';
                    nextBtn.textContent = currentStep === totalSteps - 1 ? 'Review Application \u2192' : 'Next Step \u2192';
                }
            }

            // If navigating to Review step (Step 6), sync field values to summary
            if (currentStep === 6) {
                syncReviewData();
            }

            // Smooth scroll to top of form
            window.scrollTo({ top: 120, behavior: 'smooth' });
        }

        function goToStep(step) {
            if (step >= 1 && step <= totalSteps) {
                currentStep = step;
                updateStepUI();
            }
        }

        function syncReviewData() {
            // Primary Applicant Email
            const primEmail = document.getElementById('primary_email')?.value.trim();
            const reviewPrim = document.getElementById('review-primary-email');
            if (reviewPrim) {
                reviewPrim.textContent = primEmail || '—';
            }

            // Recommender
            const suffixVal = document.getElementById('recommender_suffix')?.value;
            const suffixOther = document.getElementById('recommender_suffix_other')?.value.trim();
            const finalSuffix = (suffixVal === 'Other' ? suffixOther : suffixVal) || '—';
            const recSuffixEl = document.getElementById('review-recommender-suffix');
            if (recSuffixEl) recSuffixEl.textContent = finalSuffix;

            const recSurname = document.getElementById('recommender_surname')?.value.trim() || '';
            const recFirst = document.getElementById('recommender_first_name')?.value.trim() || '';
            const recFull = `${recFirst} ${recSurname}`.trim() || '—';
            const recNameEl = document.getElementById('review-recommender-name');
            if (recNameEl) recNameEl.textContent = recFull;

            const recEmail = document.getElementById('recommender_email')?.value.trim();
            if (recEmail) {
                document.getElementById('review-recommender-email').textContent = recEmail || '—';
            }

            const altRecName = document.getElementById('alt_recommender_name')?.value.trim();
            const altRecNameEl = document.getElementById('review-alt-recommender-name');
            if (altRecNameEl) altRecNameEl.textContent = altRecName || '—';

            const altRecEmail = document.getElementById('alt_recommender_email')?.value.trim();
            const altRecEmailEl = document.getElementById('review-alt-recommender-email');
            if (altRecEmailEl) altRecEmailEl.textContent = altRecEmail || '—';

            // Member Info
            const surname = document.getElementById('surname')?.value.trim();
            if (surname) document.getElementById('review-surname').textContent = surname;

            const firstName = document.getElementById('first_name')?.value.trim();
            if (firstName) document.getElementById('review-first-name').textContent = firstName;

            const middleName = document.getElementById('middle_name')?.value.trim();
            const reviewMiddle = document.getElementById('review-middle-name');
            if (reviewMiddle) reviewMiddle.textContent = middleName || '—';

            const mobile = document.getElementById('mobile_number')?.value.trim();
            const reviewMob = document.getElementById('review-mobile-number');
            if (reviewMob) reviewMob.textContent = mobile || '—';

            const altMobile = document.getElementById('alt_mobile_number')?.value.trim();
            const reviewAltMob = document.getElementById('review-alt-mobile-number');
            if (reviewAltMob) reviewAltMob.textContent = altMobile || '—';

            const affil = document.getElementById('current_affiliation')?.value.trim();
            if (affil) document.getElementById('review-affiliation').textContent = affil;

            const posVal = document.getElementById('current_position')?.value.trim();
            const reviewPos = document.getElementById('review-position');
            if (reviewPos) reviewPos.textContent = posVal || '—';

            const profEmail = document.getElementById('professional_email')?.value.trim();
            const reviewProfEmail = document.getElementById('review-professional-email');
            if (reviewProfEmail) reviewProfEmail.textContent = profEmail || '—';

            const highEd = document.getElementById('highest_educational_attainment')?.value.trim();
            const reviewHighEd = document.getElementById('review-highest-ed');
            if (reviewHighEd) reviewHighEd.textContent = highEd || '—';

            const degreeDate = document.getElementById('date_degree_obtained')?.value.trim();
            const reviewDegreeDate = document.getElementById('review-degree-date');
            if (reviewDegreeDate) reviewDegreeDate.textContent = degreeDate || '—';

            const inst = document.getElementById('institution')?.value.trim();
            const reviewInst = document.getElementById('review-institution');
            if (reviewInst) reviewInst.textContent = inst || '—';

            const instAddress = document.getElementById('institution_address')?.value.trim();
            const reviewInstAddress = document.getElementById('review-institution-address');
            if (reviewInstAddress) reviewInstAddress.textContent = instAddress || '—';

            // Certification
            const certEmail = document.getElementById('certification_email')?.value.trim();
            const reviewCert = document.getElementById('review-certification');
            if (reviewCert) reviewCert.textContent = certEmail ? `Certified via ${certEmail}` : '—';

            // Account
            const accEmail = document.getElementById('account_email')?.value.trim();
            const reviewAcc = document.getElementById('review-account-email');
            if (reviewAcc) reviewAcc.textContent = accEmail || '—';
        }

        function showToast(message, isError = false) {
            const toast = document.getElementById('join-toast');
            const toastText = document.getElementById('join-toast-text');
            const toastIcon = document.getElementById('join-toast-icon');
            if (!toast || !toastText) return;

            const header = document.querySelector('.portal-topbar');
            if (header) {
                toast.style.top = (header.offsetHeight + 10) + 'px';
            }

            toastText.textContent = message;
            if (isError) {
                toast.classList.add('is-error');
                if (toastIcon) toastIcon.innerHTML = '&#x2716;';
            } else {
                toast.classList.remove('is-error');
                if (toastIcon) toastIcon.innerHTML = '&#x2714;';
            }
            toast.classList.remove('is-hidden');

            if (window._joinToastTimeout) clearTimeout(window._joinToastTimeout);
            window._joinToastTimeout = setTimeout(() => {
                toast.classList.add('is-hidden');
            }, 7000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const appDateInput = document.getElementById('application_date');
            if (appDateInput) {
                const today = new Date();
                const mm = String(today.getMonth() + 1).padStart(2, '0');
                const dd = String(today.getDate()).padStart(2, '0');
                const yyyy = today.getFullYear();
                appDateInput.value = `${mm}/${dd}/${yyyy}`;
            }

            // Suffix Other Toggle
            const recSuffixSelect = document.getElementById('recommender_suffix');
            const recSuffixOtherInput = document.getElementById('recommender_suffix_other');
            recSuffixSelect?.addEventListener('change', () => {
                if (recSuffixSelect.value === 'Other') {
                    recSuffixOtherInput.style.display = 'block';
                    recSuffixOtherInput.focus();
                } else {
                    recSuffixOtherInput.style.display = 'none';
                    recSuffixOtherInput.value = '';
                }
            });

            // Position Select & Other Toggle
            const posSelect = document.getElementById('current_position_select');
            const posOtherInput = document.getElementById('current_position_other');
            const posHidden = document.getElementById('current_position');
            function updatePositionValue() {
                if (posSelect.value === 'Other') {
                    posOtherInput.style.display = 'block';
                    posHidden.value = posOtherInput.value.trim();
                } else {
                    posOtherInput.style.display = 'none';
                    posHidden.value = posSelect.value;
                }
            }
            posSelect?.addEventListener('change', updatePositionValue);
            posOtherInput?.addEventListener('input', updatePositionValue);

            // File upload listeners
            const cvInput = document.getElementById('cv_file');
            cvInput?.addEventListener('change', () => {
                if (cvInput.files && cvInput.files[0]) {
                    const name = cvInput.files[0].name;
                    const textEl = document.getElementById('text-cv-file');
                    if (textEl) textEl.textContent = name;
                    const badge = document.getElementById('badge-cv-file');
                    if (badge) {
                        badge.className = 'portal-badge portal-badge-active';
                        badge.textContent = 'Selected';
                    }
                    const reviewBadge = document.getElementById('review-cv-status');
                    if (reviewBadge) {
                        reviewBadge.className = 'portal-badge portal-badge-active';
                        reviewBadge.textContent = name;
                    }
                }
            });

            const proofInput = document.getElementById('proof_file');
            proofInput?.addEventListener('change', () => {
                if (proofInput.files && proofInput.files[0]) {
                    const name = proofInput.files[0].name;
                    const textEl = document.getElementById('text-proof-file');
                    if (textEl) textEl.textContent = name;
                    const badge = document.getElementById('badge-proof-file');
                    if (badge) {
                        badge.className = 'portal-badge portal-badge-active';
                        badge.textContent = 'Selected';
                    }
                    const reviewBadge = document.getElementById('review-proof-status');
                    if (reviewBadge) {
                        reviewBadge.className = 'portal-badge portal-badge-active';
                        reviewBadge.textContent = name;
                    }
                }
            });

            // Auto-fill account email from primary email
            const primaryEmailInput = document.getElementById('primary_email');
            const accEmailInput = document.getElementById('account_email');
            primaryEmailInput?.addEventListener('input', () => {
                if (accEmailInput && (!accEmailInput.value || accEmailInput.dataset.userEdited !== 'true')) {
                    accEmailInput.value = primaryEmailInput.value;
                }
            });
            accEmailInput?.addEventListener('input', () => {
                accEmailInput.dataset.userEdited = 'true';
            });

            // Stepper item clicks
            document.querySelectorAll('.join-step-item').forEach(item => {
                item.addEventListener('click', () => {
                    const target = parseInt(item.getAttribute('data-step-target'), 10);
                    goToStep(target);
                });
            });

            // Toast dismiss button
            document.getElementById('join-toast-close')?.addEventListener('click', () => {
                document.getElementById('join-toast')?.classList.add('is-hidden');
            });

            // Prev & Next buttons
            document.getElementById('btn-prev-step')?.addEventListener('click', () => {
                if (currentStep > 1) {
                    goToStep(currentStep - 1);
                }
            });

            document.getElementById('btn-next-step')?.addEventListener('click', () => {
                if (currentStep < totalSteps) {
                    goToStep(currentStep + 1);
                }
            });

            // Real submit & create account
            document.getElementById('btn-submit-application')?.addEventListener('click', () => {
                const form = document.getElementById('join-spp-form');

                // Validate Stage 1 Recommender
                const primEmail = document.getElementById('primary_email')?.value.trim();
                const recSurname = document.getElementById('recommender_surname')?.value.trim();
                const recFirst = document.getElementById('recommender_first_name')?.value.trim();
                const recEmail = document.getElementById('recommender_email')?.value.trim();
                if (!primEmail) {
                    showToast('Please provide your Email in Stage 1.', true);
                    goToStep(1);
                    return;
                }
                if (!recSurname || !recFirst || !recEmail) {
                    showToast('Please provide your Recommender Surname, First Name, and Email in Stage 1.', true);
                    goToStep(1);
                    return;
                }

                // Validate Stage 2 Member Information
                const surname = document.getElementById('surname')?.value.trim();
                const firstName = document.getElementById('first_name')?.value.trim();
                const affil = document.getElementById('current_affiliation')?.value.trim();
                const pos = document.getElementById('current_position')?.value.trim();
                const profEmail = document.getElementById('professional_email')?.value.trim();
                const highEd = document.getElementById('highest_educational_attainment')?.value.trim();
                const dateDeg = document.getElementById('date_degree_obtained')?.value.trim();
                const inst = document.getElementById('institution')?.value.trim();
                const instAddr = document.getElementById('institution_address')?.value.trim();

                if (!surname || !firstName) {
                    showToast('Please provide your Surname and First Name in Stage 2.', true);
                    goToStep(2);
                    return;
                }
                if (!affil || !pos || !profEmail) {
                    showToast('Please complete your Affiliation, Position, and Professional Email in Stage 2.', true);
                    goToStep(2);
                    return;
                }
                if (!highEd || !dateDeg || !inst || !instAddr) {
                    showToast('Please complete all Educational Information fields in Stage 2.', true);
                    goToStep(2);
                    return;
                }

                // Validate Stage 3 Documents
                const cvInput = document.getElementById('cv_file');
                if (!cvInput || !cvInput.files || cvInput.files.length === 0) {
                    showToast('Please upload your Updated Curriculum Vitae (CV) in Stage 3.', true);
                    goToStep(3);
                    return;
                }

                // Validate Stage 4 Validation & Certification
                const declAgree = document.getElementById('declaration_agree');
                if (!declAgree || !declAgree.checked) {
                    showToast('You must agree to the VALIDATION declaration in Stage 4.', true);
                    goToStep(4);
                    return;
                }
                const certEmail = document.getElementById('certification_email')?.value.trim();
                if (!certEmail) {
                    showToast('Please type your email address under CERTIFICATION in Stage 4.', true);
                    goToStep(4);
                    return;
                }

                // Validate Stage 5 Account Setup
                const email = document.getElementById('account_email')?.value.trim();
                const password = document.getElementById('account_password')?.value;
                const passwordConfirm = document.getElementById('account_password_confirmation')?.value;

                if (!email) {
                    showToast('Please provide your Account Email in Stage 5.', true);
                    goToStep(5);
                    return;
                }
                if (!password || password.length < 8) {
                    showToast('Password must be at least 8 characters.', true);
                    goToStep(5);
                    return;
                }
                if (password !== passwordConfirm) {
                    showToast('Passwords do not match.', true);
                    goToStep(5);
                    return;
                }

                const submitBtn = document.getElementById('btn-submit-application');
                submitBtn.disabled = true;
                const origText = submitBtn.textContent;
                submitBtn.textContent = 'Submitting Application...';

                // Sync Suffix before FormData
                const suffixSelect = document.getElementById('recommender_suffix');
                if (suffixSelect && suffixSelect.value === 'Other') {
                    const otherVal = document.getElementById('recommender_suffix_other')?.value.trim();
                    if (otherVal) suffixSelect.value = otherVal;
                }

                const formData = new FormData(form);

                fetch('{{ route('join-spp.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(async response => {
                    const data = await response.json().catch(() => ({}));
                    if (!response.ok) {
                        const err = data.errors ? Object.values(data.errors)[0][0] : (data.message || 'Validation error');
                        throw new Error(err);
                    }
                    return data;
                })
                .then(data => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = origText;

                    const successEmail = document.getElementById('success-account-email');
                    if (successEmail) successEmail.textContent = email;

                    const submitArea = document.getElementById('join-submit-area');
                    const successCard = document.getElementById('join-submission-success');
                    const actionBar = document.querySelector('.join-action-bar');
                    if (submitArea && successCard) {
                        submitArea.style.display = 'none';
                        if (actionBar) actionBar.style.display = 'none';
                        successCard.hidden = false;
                        successCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    showToast('Account created & application submitted! You can now log in to the portal.');
                })
                .catch(err => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = origText;
                    showToast(err.message || 'Submission failed. Please check required fields.', true);
                });
            });

            // Info Pop-up Modal Handlers
            const infoModal = document.getElementById('join-info-modal');
            const openInfoModal = () => {
                if (infoModal) {
                    infoModal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                }
            };
            const closeInfoModal = () => {
                if (infoModal) {
                    infoModal.style.display = 'none';
                    document.body.style.overflow = '';
                }
            };

            document.getElementById('btn-open-info-modal')?.addEventListener('click', openInfoModal);
            document.getElementById('btn-trigger-info-modal')?.addEventListener('click', openInfoModal);
            document.getElementById('btn-close-info-modal-x')?.addEventListener('click', closeInfoModal);
            document.getElementById('btn-close-info-modal-ok')?.addEventListener('click', closeInfoModal);

            infoModal?.addEventListener('click', (e) => {
                if (e.target === infoModal) {
                    closeInfoModal();
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && infoModal && infoModal.style.display === 'flex') {
                    closeInfoModal();
                }
            });

            // Theme toggle
            document.querySelector('[data-theme-toggle]')?.addEventListener('click', () => {
                const current = document.documentElement.getAttribute('data-theme') || 'light';
                const next = current === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-theme', next);
                document.documentElement.classList.toggle('dark', next === 'dark');
                localStorage.setItem('spp-theme', next);
            });
        });
    </script>

    <!-- Floating Info / Guidelines Button (Positioned on top of theme toggle) -->
    <button class="floating-info-btn" type="button" id="btn-open-info-modal" aria-label="Open Application Guidelines"
        title="Application Guidelines">
        <span aria-hidden="true">&#x2139;</span>
        <span class="floating-info-tooltip">Application Guidelines</span>
    </button>

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
