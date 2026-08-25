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
                <p class="eyebrow">News and Announcements</p>
                <h2>title</h2>
                <p>sample text.</p>
            </div>
        </div>

        <div id="news-listing-wrapper">
            <div id="news-grid" class="card-grid news-grid">
                <div class="news-loading">Loading news...</div>
            </div>
            <nav id="news-pagination" class="pagination-bar" aria-label="News pagination" style="display: none;"></nav>
        </div>
    </section>

    <section class="section shell" id="activities">
        <div class="section-header">
            <div>
                <p class="eyebrow">Activities</p>
                <h2>title</h2>
                <p>sample text.</p>
            </div>
        </div>

        <div class="card-grid activity-grid">
            <x-activity-card />
            <x-activity-card />
            <x-activity-card />
            <x-activity-card />
        </div>
    </section>
</x-layouts.public>
