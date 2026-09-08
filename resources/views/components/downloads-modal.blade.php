<div class="downloads-modal-overlay is-hidden" id="downloads-modal" role="dialog" aria-modal="true" aria-labelledby="downloads-modal-title">
    <div class="downloads-modal-backdrop" data-close-downloads-modal></div>
    <div class="downloads-modal-card">
        <div class="downloads-modal-header">
            <div>
                <span class="downloads-modal-badge"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display: inline-block; vertical-align: -2px; margin-right: 4px;"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg> Resources &amp; Documents</span>
                <h2 class="downloads-modal-title" id="downloads-modal-title">Downloads Directory</h2>
                <p class="downloads-modal-subtitle">Access official SPP conference handbooks, online talk backdrops, and institutional endorsements.</p>
            </div>
            <button type="button" class="downloads-modal-close" data-close-downloads-modal aria-label="Close downloads dialog">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <div class="downloads-modal-body">
            <div class="downloads-directory-container modal-version">
                <div class="downloads-directory-grid">
                    <!-- Column 1: Conference Handbooks -->
                    <div class="downloads-cat-card">
                        <h3 class="downloads-cat-title">Conference Handbooks</h3>
                        <div class="downloads-pill-stack">
                            @foreach(['2026', '2025', '2024', '2023', '2022', '2021', '2020', '2019', '2018', '2017', '2016', '2015'] as $year)
                                <a href="#download-handbook-{{ $year }}" class="downloads-year-pill" title="Download {{ $year }} Conference Handbook">
                                    <span>{{ $year }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Column 2: Backdrops for Online Talks -->
                    <div class="downloads-cat-card">
                        <h3 class="downloads-cat-title">Backdrops for Online Talks</h3>
                        <div class="downloads-pill-stack">
                            @foreach(['2021', '2020'] as $year)
                                <a href="#download-backdrop-{{ $year }}" class="downloads-year-pill" title="Download {{ $year }} Backdrop">
                                    <span>{{ $year }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Column 3: PASUC / DepEd / CHEd Endorsements -->
                    <div class="downloads-cat-card">
                        <!-- PASUC Endorsement -->
                        <div class="downloads-subcat-group">
                            <h3 class="downloads-cat-title">PASUC Endorsement</h3>
                            <div class="downloads-pill-stack">
                                <a href="#download-pasuc-2024" class="downloads-year-pill" title="Download 2024 PASUC Endorsement">
                                    <span>2024</span>
                                </a>
                            </div>
                        </div>

                        <div class="downloads-divider"></div>

                        <!-- DepEd Advisory -->
                        <div class="downloads-subcat-group">
                            <h3 class="downloads-cat-title">DepEd Advisory</h3>
                            <div class="downloads-pill-stack">
                                @foreach(['2021', '2020'] as $year)
                                    <a href="#download-deped-{{ $year }}" class="downloads-year-pill" title="Download {{ $year }} DepEd Advisory">
                                        <span>{{ $year }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="downloads-divider"></div>

                        <!-- CHEd Endorsement -->
                        <div class="downloads-subcat-group">
                            <h3 class="downloads-cat-title">CHEd Endorsement</h3>
                            <div class="downloads-pill-stack">
                                @foreach(['2019', '2018'] as $year)
                                    <a href="#download-ched-{{ $year }}" class="downloads-year-pill" title="Download {{ $year }} CHEd Endorsement">
                                        <span>{{ $year }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="downloads-modal-footer">
            <button type="button" class="button button-secondary" data-close-downloads-modal>Close</button>
        </div>
    </div>
</div>
