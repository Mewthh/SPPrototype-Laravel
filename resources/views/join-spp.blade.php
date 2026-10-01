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
                Complete the six-stage membership application below to join the premier professional society of physicists in the Philippines.
            </p>
        </div>

        <!-- 6-Stage Visual Stepper -->
        <nav class="join-stepper-wrap" aria-label="Application Progress Stepper">
            <div class="join-step-connector" aria-hidden="true"></div>
            <ol class="join-stepper-list">
                <li>
                    <button type="button" class="join-step-item is-active" data-step-target="1" aria-current="step">
                        <span class="join-step-indicator">1</span>
                        <span class="join-step-name">Membership Type</span>
                    </button>
                </li>
                <li>
                    <button type="button" class="join-step-item" data-step-target="2">
                        <span class="join-step-indicator">2</span>
                        <span class="join-step-name">Recommender</span>
                    </button>
                </li>
                <li>
                    <button type="button" class="join-step-item" data-step-target="3">
                        <span class="join-step-indicator">3</span>
                        <span class="join-step-name">Member Information</span>
                    </button>
                </li>
                <li>
                    <button type="button" class="join-step-item" data-step-target="4">
                        <span class="join-step-indicator">4</span>
                        <span class="join-step-name">Documents</span>
                    </button>
                </li>
                <li>
                    <button type="button" class="join-step-item" data-step-target="5">
                        <span class="join-step-indicator">5</span>
                        <span class="join-step-name">Validation / Certification</span>
                    </button>
                </li>
                <li>
                    <button type="button" class="join-step-item" data-step-target="6">
                        <span class="join-step-indicator">6</span>
                        <span class="join-step-name">Account Setup</span>
                    </button>
                </li>
                <li>
                    <button type="button" class="join-step-item" data-step-target="7">
                        <span class="join-step-indicator">7</span>
                        <span class="join-step-name">Review &amp; Submit</span>
                    </button>
                </li>
            </ol>
        </nav>

        <!-- Multi-Step Form Container -->
        <form id="join-spp-form" onsubmit="return false;">
            <!-- STAGE 1: Membership Type -->
            <section class="join-step-pane is-active" data-step="1" aria-labelledby="step-1-heading">
                <div class="join-form-card">
                    <div class="join-card-head">
                        <h2 id="step-1-heading">Stage 1: Membership Information</h2>
                        <p>Select your desired membership category and indicate the type of application you are filing.</p>
                    </div>

                    <div class="join-field-group" style="margin-bottom: 22px;">
                        <span class="join-field-label">Choose Membership Category</span>
                        <div class="join-radio-tiles">
                            <label class="join-radio-tile">
                                <input type="radio" name="membership_type" value="Regular Member" checked />
                                <div class="join-tile-box">
                                    <div class="join-tile-title">
                                        <span>Regular Member</span>
                                        <span class="portal-badge portal-badge-active" style="font-size: 0.7rem;">Primary</span>
                                    </div>
                                    <p class="join-tile-desc">For holders of Ph.D. or M.S. degrees in physics or actively engaged in physics research.</p>
                                </div>
                            </label>
                            <label class="join-radio-tile">
                                <input type="radio" name="membership_type" value="Associate Member" />
                                <div class="join-tile-box">
                                    <div class="join-tile-title">
                                        <span>Associate Member</span>
                                    </div>
                                    <p class="join-tile-desc">For educators, physics teachers, advanced students, and allied physics professionals.</p>
                                </div>
                            </label>
                            <label class="join-radio-tile">
                                <input type="radio" name="membership_type" value="Institutional Member" />
                                <div class="join-tile-box">
                                    <div class="join-tile-title">
                                        <span>Institutional Member</span>
                                    </div>
                                    <p class="join-tile-desc">For universities, academic departments, research bodies, or corporate affiliates.</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="join-form-grid">
                        <div class="join-field-group">
                            <label class="join-field-label" for="application_type">Application Type</label>
                            <select id="application_type" name="application_type" class="join-select">
                                <option value="New Application" selected>New Application</option>
                                <option value="Membership Renewal">Membership Renewal</option>
                                <option value="Status Upgrade">Status Upgrade</option>
                            </select>
                        </div>

                        <div class="join-field-group">
                            <label class="join-field-label" for="application_date">Application Date</label>
                            <input type="text" id="application_date" name="application_date" class="join-input" value="MM/DD/YYYY" readonly />
                        </div>

                        <div class="join-field-group">
                            <label class="join-field-label">Initial Status</label>
                            <div style="padding-top: 6px;">
                                <x-portal.status-badge status="Pending" />
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- STAGE 2: Recommender Details -->
            <section class="join-step-pane" data-step="2" aria-labelledby="step-2-heading">
                <div class="join-form-card">
                    <div class="join-card-head">
                        <h2 id="step-2-heading">Stage 2: Recommender Details</h2>
                        <p>Applicants must be endorsed by an active SPP Regular Member in good standing.</p>
                    </div>

                    <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 12px; color: var(--portal-text);">Primary Recommender</h3>
                    <div class="join-form-grid" style="margin-bottom: 24px;">
                        <div class="join-field-group">
                            <label class="join-field-label" for="recommender_name">Recommender Name</label>
                            <input type="text" id="recommender_name" name="recommender_name" class="join-input" placeholder="Sample Name" value="Sample Name" />
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="recommender_email">Recommender Email</label>
                            <input type="email" id="recommender_email" name="recommender_email" class="join-input" placeholder="example@email.com" value="example@email.com" />
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="recommender_suffix">Suffix</label>
                            <input type="text" id="recommender_suffix" name="recommender_suffix" class="join-input" placeholder="Sample" value="Sample" />
                        </div>
                    </div>

                    <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 12px; color: var(--portal-text);">Alternate Recommender</h3>
                    <div class="join-form-grid" style="margin-bottom: 20px;">
                        <div class="join-field-group">
                            <label class="join-field-label" for="alt_recommender_name">Alternate Recommender Name</label>
                            <input type="text" id="alt_recommender_name" name="alt_recommender_name" class="join-input" placeholder="Sample Name" value="Sample Name" />
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="alt_recommender_email">Alternate Recommender Email</label>
                            <input type="email" id="alt_recommender_email" name="alt_recommender_email" class="join-input" placeholder="example@email.com" value="example@email.com" />
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="alt_recommender_suffix">Suffix</label>
                            <input type="text" id="alt_recommender_suffix" name="alt_recommender_suffix" class="join-input" placeholder="Sample" value="Sample" />
                        </div>
                    </div>

                    <div class="join-field-group" style="padding-top: 10px; border-top: 1px solid var(--portal-border);">
                        <label class="join-field-label">Recommender Status</label>
                        <div>
                            <x-portal.status-badge status="Pending" />
                        </div>
                    </div>
                </div>
            </section>

            <!-- STAGE 3: Member Information -->
            <section class="join-step-pane" data-step="3" aria-labelledby="step-3-heading">
                <!-- Personal Information -->
                <div class="join-form-card" style="margin-bottom: 20px;">
                    <div class="join-card-head" style="margin-bottom: 18px; padding-bottom: 12px;">
                        <h2 id="step-3-heading" style="margin-bottom: 6px;">Stage 3: Member Information</h2>
                        <p style="margin-bottom: 16px;">Provide your personal details, institutional affiliation, and educational credentials.</p>
                        <h3 style="font-size: 1.1rem; font-weight: 700; margin: 0; color: var(--portal-text);">Personal Information</h3>
                    </div>
                    <div class="join-form-grid">
                        <div class="join-field-group">
                            <label class="join-field-label" for="surname">Surname</label>
                            <input type="text" id="surname" name="surname" class="join-input" placeholder="Sample" value="Sample" />
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="first_name">First Name(s)</label>
                            <input type="text" id="first_name" name="first_name" class="join-input" placeholder="Sample Name" value="Sample Name" />
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="middle_name">Middle Name(s)</label>
                            <input type="text" id="middle_name" name="middle_name" class="join-input" placeholder="Sample" value="Sample" />
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="mobile_number">Mobile Number</label>
                            <input type="tel" id="mobile_number" name="mobile_number" class="join-input" placeholder="Sample" value="Sample" />
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="personal_email">Personal Email Address</label>
                            <input type="email" id="personal_email" name="personal_email" class="join-input" placeholder="example@email.com" value="example@email.com" />
                        </div>
                    </div>
                </div>

                <!-- Professional Information -->
                <div class="join-form-card" style="margin-bottom: 20px;">
                    <div class="join-card-head" style="margin-bottom: 18px; padding-bottom: 12px;">
                        <h3 style="font-size: 1.1rem; font-weight: 700; margin: 0; color: var(--portal-text);">Professional Information</h3>
                    </div>
                    <div class="join-form-grid">
                        <div class="join-field-group">
                            <label class="join-field-label" for="current_affiliation">Current Institutional Affiliation</label>
                            <input type="text" id="current_affiliation" name="current_affiliation" class="join-input" placeholder="Sample Institution" value="Sample Institution" />
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="current_position">Current Position</label>
                            <input type="text" id="current_position" name="current_position" class="join-input" placeholder="Sample" value="Sample" />
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="professional_email">Professional / Institutional Email</label>
                            <input type="email" id="professional_email" name="professional_email" class="join-input" placeholder="example@email.com" value="example@email.com" />
                        </div>
                    </div>
                </div>

                <!-- Educational Information -->
                <div class="join-form-card">
                    <div class="join-card-head" style="margin-bottom: 18px; padding-bottom: 12px;">
                        <h3 style="font-size: 1.1rem; font-weight: 700; margin: 0; color: var(--portal-text);">Educational Information</h3>
                    </div>
                    <div class="join-form-grid">
                        <div class="join-field-group">
                            <label class="join-field-label" for="highest_educational_attainment">Highest Educational Attainment</label>
                            <select id="highest_educational_attainment" name="highest_educational_attainment" class="join-select">
                                <option value="Sample" selected>Sample</option>
                                <option value="Doctor of Philosophy (Ph.D.)">Doctor of Philosophy (Ph.D.)</option>
                                <option value="Master of Science (M.S.)">Master of Science (M.S.)</option>
                                <option value="Bachelor of Science (B.S.)">Bachelor of Science (B.S.)</option>
                            </select>
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="degree">Degree</label>
                            <input type="text" id="degree" name="degree" class="join-input" placeholder="Sample" value="Sample" />
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="date_degree_obtained">Date Degree Obtained</label>
                            <input type="text" id="date_degree_obtained" name="date_degree_obtained" class="join-input" placeholder="MM/DD/YYYY" value="MM/DD/YYYY" />
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="institution">Institution</label>
                            <input type="text" id="institution" name="institution" class="join-input" placeholder="Sample Institution" value="Sample Institution" />
                        </div>
                        <div class="join-field-group join-form-grid-full">
                            <label class="join-field-label" for="institution_address">Institution Address</label>
                            <input type="text" id="institution_address" name="institution_address" class="join-input" placeholder="Sample" value="Sample" />
                        </div>
                    </div>
                </div>
            </section>

            <!-- STAGE 4: Documents -->
            <section class="join-step-pane" data-step="4" aria-labelledby="step-4-heading">
                <div class="join-form-card">
                    <div class="join-card-head">
                        <h2 id="step-4-heading">Stage 4: Documents</h2>
                        <p>Upload your academic curriculum vitae and current employment or enrollment credentials.</p>
                    </div>

                    <div style="display: grid; gap: 24px;">
                        <!-- CV Card -->
                        <div style="border: 1px solid var(--portal-border); border-radius: 12px; padding: 20px; background: var(--portal-surface-soft);">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                <div>
                                    <h3 style="font-size: 1rem; font-weight: 700; margin: 0; color: var(--portal-text);">Updated Curriculum Vitae (CV)</h3>
                                    <p style="font-size: 0.82rem; color: var(--portal-muted); margin: 2px 0 0;">Recent academic CV highlighting research, publications, and physics activities.</p>
                                </div>
                                <span class="portal-badge portal-badge-active">Submitted</span>
                            </div>
                            <div class="join-upload-zone" onclick="showToast('Sample file selected: Updated_CV_Sample.pdf')">
                                <span class="join-upload-icon">&#x1F4C4;</span>
                                <div class="join-upload-text">Click to browse or drop Updated CV file here</div>
                                <div class="join-upload-hint">Supported formats: PDF (Maximum 10 MB)</div>
                            </div>
                        </div>

                        <!-- Proof of Employment Card -->
                        <div style="border: 1px solid var(--portal-border); border-radius: 12px; padding: 20px; background: var(--portal-surface-soft);">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                <div>
                                    <h3 style="font-size: 1rem; font-weight: 700; margin: 0; color: var(--portal-text);">Proof of Employment / Enrollment</h3>
                                    <p style="font-size: 0.82rem; color: var(--portal-muted); margin: 2px 0 0;">Certificate of employment, department appointment, or recent student enrollment form.</p>
                                </div>
                                <span class="portal-badge portal-badge-active">Submitted</span>
                            </div>
                            <div class="join-upload-zone" onclick="showToast('Sample file selected: Proof_Employment_Sample.pdf')">
                                <span class="join-upload-icon">&#x1F4C1;</span>
                                <div class="join-upload-text">Click to browse or drop Proof of Employment file here</div>
                                <div class="join-upload-hint">Supported formats: PDF, JPG, PNG (Maximum 10 MB)</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- STAGE 5: Validation / Certification -->
            <section class="join-step-pane" data-step="5" aria-labelledby="step-5-heading">
                <div class="join-form-card">
                    <div class="join-card-head">
                        <h2 id="step-5-heading">Stage 5: Validation &amp; Certification</h2>
                        <p>Affirm the veracity of all supplied details and commit to the code of ethics of Samahang Pisika ng Pilipinas.</p>
                    </div>

                    <label class="join-cert-box">
                        <input type="checkbox" id="declaration_agree" name="declaration_agree" checked />
                        <div class="join-cert-copy">
                            <strong>Declaration: Agreed</strong>
                            <p>I hereby declare that all statements and information provided in this application are true, accurate, and complete to the best of my knowledge.</p>
                        </div>
                    </label>

                    <label class="join-cert-box">
                        <input type="checkbox" id="certification_confirm" name="certification_confirm" checked />
                        <div class="join-cert-copy">
                            <strong>Certification: Confirmed</strong>
                            <p>I pledge to abide by the Constitution and By-Laws of the Samahang Pisika ng Pilipinas (SPP) and to uphold the ethical standards of the physics profession.</p>
                        </div>
                    </label>
                </div>
            </section>

            <!-- STAGE 6: Account Setup -->
            <section class="join-step-pane" data-step="6" aria-labelledby="step-6-heading">
                <div class="join-form-card">
                    <div class="join-card-head">
                        <h2 id="step-6-heading">Stage 6: Account Setup</h2>
                        <p>Create your portal account login credentials. Once your application is submitted, you will use these credentials to log in to the SPP Membership Portal.</p>
                    </div>

                    <div class="join-form-grid">
                        <div class="join-field-group">
                            <label class="join-field-label" for="account_email">Account Email Address</label>
                            <input type="email" id="account_email" name="account_email" class="join-input" placeholder="example@email.com" value="example@email.com" />
                            <small style="color: var(--portal-muted); font-size: 0.78rem; margin-top: 4px;">This email will be your portal login username.</small>
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="account_password">Password</label>
                            <input type="password" id="account_password" name="account_password" class="join-input" placeholder="••••••••••••" value="password123" />
                            <small style="color: var(--portal-muted); font-size: 0.78rem; margin-top: 4px;">Minimum 8 characters with letters and numbers.</small>
                        </div>
                        <div class="join-field-group">
                            <label class="join-field-label" for="account_password_confirmation">Confirm Password</label>
                            <input type="password" id="account_password_confirmation" name="account_password_confirmation" class="join-input" placeholder="••••••••••••" value="password123" />
                            <small style="color: var(--portal-muted); font-size: 0.78rem; margin-top: 4px;">Re-enter password to confirm.</small>
                        </div>
                    </div>
                </div>
            </section>

            <!-- STAGE 7: Review & Submit -->
            <section class="join-step-pane" data-step="7" aria-labelledby="step-7-heading">
                <div class="join-form-card">
                    <div class="join-card-head">
                        <h2 id="step-7-heading">Stage 7: Review &amp; Submit</h2>
                        <p>Review all submitted information and your portal account credentials before submitting your application.</p>
                    </div>

                    <div class="join-review-grid">
                        <!-- Membership Summary -->
                        <div class="join-review-card">
                            <div class="join-review-header">
                                <h3>Membership Information</h3>
                                <button type="button" class="join-review-edit-btn" onclick="goToStep(1)">Edit</button>
                            </div>
                            <dl class="join-review-dl">
                                <div><dt>Membership Type</dt><dd id="review-membership-type">Regular Member</dd></div>
                                <div><dt>Application Type</dt><dd id="review-application-type">New Application</dd></div>
                                <div><dt>Application Date</dt><dd>MM/DD/YYYY</dd></div>
                                <div><dt>Application Status</dt><dd><x-portal.status-badge status="Pending" /></dd></div>
                            </dl>
                        </div>

                        <!-- Recommender Summary -->
                        <div class="join-review-card">
                            <div class="join-review-header">
                                <h3>Recommender</h3>
                                <button type="button" class="join-review-edit-btn" onclick="goToStep(2)">Edit</button>
                            </div>
                            <dl class="join-review-dl">
                                <div><dt>Name</dt><dd id="review-recommender-name">Sample Name</dd></div>
                                <div><dt>Email</dt><dd id="review-recommender-email">example@email.com</dd></div>
                                <div><dt>Suffix</dt><dd>Sample</dd></div>
                                <div><dt>Alternate Recommender</dt><dd id="review-alt-recommender-name">Sample Name</dd></div>
                                <div><dt>Recommender Status</dt><dd><x-portal.status-badge status="Pending" /></dd></div>
                            </dl>
                        </div>

                        <!-- Member Information Summary -->
                        <div class="join-review-card">
                            <div class="join-review-header">
                                <h3>Member Information</h3>
                                <button type="button" class="join-review-edit-btn" onclick="goToStep(3)">Edit</button>
                            </div>
                            <dl class="join-review-dl">
                                <div><dt>Surname</dt><dd id="review-surname">Sample</dd></div>
                                <div><dt>First Name(s)</dt><dd id="review-first-name">Sample Name</dd></div>
                                <div><dt>Middle Name(s)</dt><dd>Sample</dd></div>
                                <div><dt>Mobile Number</dt><dd>Sample</dd></div>
                                <div><dt>Current Institutional Affiliation</dt><dd id="review-affiliation">Sample Institution</dd></div>
                                <div><dt>Current Position</dt><dd>Sample</dd></div>
                                <div><dt>Professional / Institutional Email</dt><dd>example@email.com</dd></div>
                                <div><dt>Highest Educational Attainment</dt><dd>Sample</dd></div>
                                <div><dt>Degree</dt><dd>Sample</dd></div>
                                <div><dt>Date Degree Obtained</dt><dd>MM/DD/YYYY</dd></div>
                                <div><dt>Institution</dt><dd>Sample Institution</dd></div>
                                <div><dt>Institution Address</dt><dd>Sample</dd></div>
                            </dl>
                        </div>

                        <!-- Documents Summary -->
                        <div class="join-review-card">
                            <div class="join-review-header">
                                <h3>Documents</h3>
                                <button type="button" class="join-review-edit-btn" onclick="goToStep(4)">Edit</button>
                            </div>
                            <div style="display: grid; gap: 8px;">
                                <x-portal.document-row label="Updated CV" />
                                <x-portal.document-row label="Proof of Employment / Enrollment" />
                            </div>
                        </div>

                        <!-- Validation Summary -->
                        <div class="join-review-card">
                            <div class="join-review-header">
                                <h3>Validation / Certification</h3>
                                <button type="button" class="join-review-edit-btn" onclick="goToStep(5)">Edit</button>
                            </div>
                            <dl class="join-review-dl">
                                <div><dt>Declaration</dt><dd>Agreed</dd></div>
                                <div><dt>Certification</dt><dd>Confirmed</dd></div>
                            </dl>
                        </div>

                        <!-- Portal Account Summary -->
                        <div class="join-review-card">
                            <div class="join-review-header">
                                <h3>Portal Account Credentials</h3>
                                <button type="button" class="join-review-edit-btn" onclick="goToStep(6)">Edit</button>
                            </div>
                            <dl class="join-review-dl">
                                <div><dt>Account Login Email</dt><dd id="review-account-email">example@email.com</dd></div>
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
                    <div id="join-submission-success" hidden style="margin-top: 28px; padding: 32px 24px; background: var(--portal-surface); border: 2px solid #10b981; border-radius: 16px; text-align: center; box-shadow: 0 10px 28px rgba(16, 185, 129, 0.12);">
                        <div style="width: 56px; height: 56px; border-radius: 50%; background: #10b981; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; margin: 0 auto 16px;">&#x2714;</div>
                        <h3 style="font-size: 1.4rem; font-weight: 800; color: var(--portal-text); margin: 0 0 8px;">Application Submitted &amp; Account Created!</h3>
                        <p style="font-size: 0.92rem; color: var(--portal-muted); max-width: 520px; margin: 0 auto 20px; line-height: 1.5;">
                            Your membership application has been received and your new account has been created. You can now log in to the SPP Membership Portal to monitor evaluation progress.
                        </p>
                        <div style="background: var(--portal-surface-soft); border: 1px solid var(--portal-border); border-radius: 12px; padding: 16px 24px; display: inline-block; margin-bottom: 24px; text-align: left;">
                            <div style="font-size: 0.76rem; color: var(--portal-muted); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">Portal Account Ready</div>
                            <div style="font-size: 1.05rem; font-weight: 800; color: var(--portal-text); margin-top: 4px;" id="success-account-email">example@email.com</div>
                            <div style="display: flex; gap: 8px; align-items: center; margin-top: 8px;">
                                <span class="portal-badge portal-badge-active" style="font-size: 0.74rem;">Account Created</span>
                                <span class="portal-badge portal-badge-pending" style="font-size: 0.74rem;">Application Under Evaluation</span>
                            </div>
                        </div>
                        <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                            <a href="{{ route('membership-portal.dashboard') }}" class="join-btn join-btn-primary" style="padding: 12px 28px; font-size: 1rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                                <span>Log In to Portal Dashboard</span>
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                            <a href="{{ route('home') }}" class="join-btn join-btn-secondary" style="padding: 12px 20px; font-size: 0.95rem; text-decoration: none;">
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
                    <button type="button" class="join-btn join-btn-secondary" onclick="showToast('Draft progress saved (Mock)')">
                        Save as Draft
                    </button>
                    <button type="button" id="btn-next-step" class="join-btn join-btn-primary">
                        Next Step &rarr;
                    </button>
                </div>
            </div>
        </form>
    </main>

    <!-- Floating Toast Notification -->
    <div id="join-toast" class="join-toast" role="status" aria-live="polite">
        <span aria-hidden="true">&#x2714;</span>
        <span id="join-toast-text">Notification message</span>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 7;

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

            // If navigating to Review step (Step 7), sync field values to summary
            if (currentStep === 7) {
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
            const selectedType = document.querySelector('input[name="membership_type"]:checked');
            if (selectedType) {
                document.getElementById('review-membership-type').textContent = selectedType.value;
            }
            const appType = document.getElementById('application_type');
            if (appType) {
                document.getElementById('review-application-type').textContent = appType.value;
            }
            const recName = document.getElementById('recommender_name');
            if (recName) {
                document.getElementById('review-recommender-name').textContent = recName.value || 'Sample Name';
            }
            const recEmail = document.getElementById('recommender_email');
            if (recEmail) {
                document.getElementById('review-recommender-email').textContent = recEmail.value || 'example@email.com';
            }
            const altRecName = document.getElementById('alt_recommender_name');
            if (altRecName) {
                document.getElementById('review-alt-recommender-name').textContent = altRecName.value || 'Sample Name';
            }
            const surname = document.getElementById('surname');
            if (surname) {
                document.getElementById('review-surname').textContent = surname.value || 'Sample';
            }
            const firstName = document.getElementById('first_name');
            if (firstName) {
                document.getElementById('review-first-name').textContent = firstName.value || 'Sample Name';
            }
            const accEmail = document.getElementById('account_email');
            if (accEmail) {
                const reviewAcc = document.getElementById('review-account-email');
                if (reviewAcc) {
                    reviewAcc.textContent = accEmail.value || 'example@email.com';
                }
            }
            const affil = document.getElementById('current_affiliation');
            if (affil) {
                document.getElementById('review-affiliation').textContent = affil.value || 'Sample Institution';
            }
        }

        function showToast(message) {
            const toast = document.getElementById('join-toast');
            const text = document.getElementById('join-toast-text');
            if (toast && text) {
                text.textContent = message;
                toast.classList.add('is-visible');
                setTimeout(() => {
                    toast.classList.remove('is-visible');
                }, 3500);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Stepper item clicks
            document.querySelectorAll('.join-step-item').forEach(item => {
                item.addEventListener('click', () => {
                    const target = parseInt(item.getAttribute('data-step-target'), 10);
                    goToStep(target);
                });
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

            // Mock submit & create account
            document.getElementById('btn-submit-application')?.addEventListener('click', () => {
                const emailInput = document.getElementById('account_email');
                if (emailInput && emailInput.value) {
                    const successEmail = document.getElementById('success-account-email');
                    if (successEmail) successEmail.textContent = emailInput.value;
                }
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
