<x-layouts.public title="Samahang Pisika ng Pilipinas">
    <section class="hero section-shell" id="top">
        <div class="hero-grid shell">
            <div class="hero-copy">
                <div class="hero-banner-wrap" id="hero-banner-container">
                    @if(!empty($heroBannerLink))
                        <a href="{{ $heroBannerLink }}" class="hero-banner-link" id="hero-banner-link" target="{{ !empty($heroBannerOpenInNewTab) ? '_blank' : '_self' }}" {!! !empty($heroBannerOpenInNewTab) ? 'rel="noopener noreferrer"' : '' !!} aria-label="Visit linked page">
                            <img src="{{ $heroBanner ?? asset('images/hero-banner.jpg') }}" alt="Hero Banner" class="hero-banner-img" id="hero-banner-img" style="{{ !empty($heroBanner) ? 'display: block;' : 'display: none;' }}" onload="if(this.getAttribute('src') && !this.getAttribute('src').endsWith('hero-banner.jpg')){ document.getElementById('hero-banner-title').style.display='none'; this.style.display='block'; }" onerror="this.style.display='none'; document.getElementById('hero-banner-title').style.display='block';" />
                        </a>
                    @else
                        <img src="{{ $heroBanner ?? asset('images/hero-banner.jpg') }}" alt="Hero Banner" class="hero-banner-img" id="hero-banner-img" style="{{ !empty($heroBanner) ? 'display: block;' : 'display: none;' }}" onload="if(this.getAttribute('src') && !this.getAttribute('src').endsWith('hero-banner.jpg')){ document.getElementById('hero-banner-title').style.display='none'; this.style.display='block'; }" onerror="this.style.display='none'; document.getElementById('hero-banner-title').style.display='block';" />
                    @endif
                    <div id="hero-banner-title" class="hero-banner-title" style="{{ !empty($heroBanner) ? 'display: none;' : 'display: block;' }}">
                        <h1>Samahang Pisika ng Pilipinas</h1>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="section shell" id="news">
        <div class="section-header">
            <div>
                <h2>News and Announcements</h2>
            </div>
        </div>

        <div id="news-listing-wrapper">
            @if(isset($news) && $news->count() > 0)
                <div id="news-grid" class="card-grid news-grid" data-server-rendered="true">
                    @foreach($news as $index => $item)
                        <x-news-card :news="$item" :hidden="$index >= 4" />
                    @endforeach
                </div>

                @if($news->count() > 4)
                    <div class="news-more-wrap" style="display: flex; justify-content: center; gap: 12px; margin-top: 36px;">
                        <button type="button" class="button button-secondary" id="news-show-more-btn">
                            Show More
                        </button>
                        <button type="button" class="button button-secondary" id="news-show-less-btn" style="display: none;">
                            Show Less
                        </button>
                    </div>
                @endif
            @else
                <div id="news-grid" class="card-grid news-grid" data-server-rendered="true">
                    <div class="news-empty-state">
                        <p>No published news or announcements at this time.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <section class="section shell" id="activities">
        <div class="section-header">
            <div>
                <h2>Activities</h2>
            </div>
        </div>

        <div id="activity-listing-wrapper">
            @if(isset($activities) && $activities->count() > 0)
                <div id="activity-grid" class="card-grid activity-grid" data-server-rendered="true">
                    @foreach($activities as $index => $activity)
                        <x-activity-card :activity="$activity" chip="Activities" :hidden="$index >= 4" />
                    @endforeach
                </div>

                @if($activities->count() > 4)
                    <div class="news-more-wrap" style="display: flex; justify-content: center; gap: 12px; margin-top: 36px;">
                        <button type="button" class="button button-secondary" id="activity-show-more-btn">
                            Show More
                        </button>
                        <button type="button" class="button button-secondary" id="activity-show-less-btn"
                            style="display: none;">
                            Show Less
                        </button>
                    </div>
                @endif
            @else
                <div id="activity-grid" class="card-grid activity-grid">
                    <div class="news-empty-state">
                        <p>No activities or events at this time.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <section class="section shell" id="downloads">
        <div class="section-header">
            <div>
                <h2>Downloads</h2>
                <p style="color: var(--muted); margin-top: 4px;">Access official SPP conference handbooks, online talk backdrops, and institutional endorsements.</p>
            </div>
        </div>

        <div class="downloads-directory-container">
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
    </section>
</x-layouts.public>