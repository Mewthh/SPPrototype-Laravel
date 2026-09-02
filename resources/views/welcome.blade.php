<x-layouts.public title="Samahang Pisika ng Pilipinas">
    <section class="hero section-shell" id="top">
        <div class="hero-grid shell">
            <div class="hero-copy">
                <div class="hero-banner-wrap" id="hero-banner-container">
                    <img src="{{ $heroBanner ?? asset('images/hero-banner.jpg') }}" alt="Hero Banner" class="hero-banner-img" id="hero-banner-img" style="{{ !empty($heroBanner) ? 'display: block;' : 'display: none;' }}" onload="if(this.getAttribute('src') && !this.getAttribute('src').endsWith('hero-banner.jpg')){ document.getElementById('hero-banner-title').style.display='none'; this.style.display='block'; }" onerror="this.style.display='none'; document.getElementById('hero-banner-title').style.display='block';" />
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
</x-layouts.public>