<x-layouts.public title="Samahang Pisika ng Pilipinas">
    <section class="hero section-shell" id="top">
        <div class="hero-grid shell">
            <div class="hero-copy">
                <p class="eyebrow">SAMAHANG PISIKA NG PILIPINAS</p>
                <h1>title</h1>
                <p class="hero-text">sample text.</p>

                <div class="hero-actions">
                    <a class="button button-primary" href="#events">View Events</a>
                    <a class="button button-secondary" href="#about">Join SPP</a>
                </div>

                <div class="hero-meta" aria-label="Quick highlights">
                    <article>
                        <strong>sample text</strong>
                        <span>sample text</span>
                    </article>
                    <article>
                        <strong>sample text</strong>
                        <span>sample text</span>
                    </article>
                    <article>
                        <strong>sample text</strong>
                        <span>sample text</span>
                    </article>
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
                        <x-activity-card
                            :activity="$activity"
                            chip="Activities"
                            :hidden="$index >= 4"
                        />
                    @endforeach
                </div>

                @if($activities->count() > 4)
                    <div class="news-more-wrap" style="display: flex; justify-content: center; gap: 12px; margin-top: 36px;">
                        <button type="button" class="button button-secondary" id="activity-show-more-btn">
                            Show More
                        </button>
                        <button type="button" class="button button-secondary" id="activity-show-less-btn" style="display: none;">
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
