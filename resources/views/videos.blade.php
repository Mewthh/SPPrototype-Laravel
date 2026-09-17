<x-layouts.public title="Videos and Webinars | Samahang Pisika ng Pilipinas">
    <section class="videos-page">
        <div class="shell">
            <header class="videos-page-header">
                <h1>Videos and Webinars</h1>
            </header>

            <section aria-label="Videos and webinars">
                @if ($videos->isEmpty())
                    <p class="video-library-empty">No videos or webinars have been published yet. Please check back soon.</p>
                @else
                    <div class="video-library-grid" id="video-library-grid">
                        @foreach ($videos as $video)
                            @php($youtubeId = $video->youtubeId())
                            <button class="video-library-card {{ $loop->index >= 8 ? 'video-library-card-hidden' : '' }}" type="button" data-video-player data-youtube-id="{{ $youtubeId }}" aria-label="Play {{ $video->title }}">
                                <div class="video-library-preview" aria-hidden="true">
                                    @if ($youtubeId)
                                        <img src="https://i.ytimg.com/vi/{{ $youtubeId }}/hqdefault.jpg" alt="" loading="lazy">
                                    @endif
                                    <span class="video-library-play">&#x25B6;</span>
                                </div>
                                <div class="video-library-card-body">
                                    @if ($video->published_at)
                                        <time datetime="{{ $video->published_at->toDateString() }}">
                                            <span aria-hidden="true">&#x25F7;</span> {{ $video->published_at->format('d F Y') }}
                                        </time>
                                    @endif
                                    <h3>{{ $video->title }}</h3>
                                </div>
                            </button>
                        @endforeach
                    </div>

                    @if ($videos->count() > 8)
                        <div class="video-library-actions" aria-label="Video library controls">
                            <button class="video-library-button" id="videos-show-more" type="button">Show More</button>
                            <button class="video-library-button video-library-button-secondary" id="videos-show-less" type="button" hidden>Show Less</button>
                        </div>
                    @endif
                @endif
            </section>
        </div>
    </section>

    <div class="video-player-modal is-hidden" id="video-player-modal" role="dialog" aria-modal="true" aria-labelledby="video-player-title">
        <div class="video-player-modal-backdrop" data-video-player-close></div>
        <div class="video-player-modal-dialog">
            <div class="video-player-modal-head">
                <h2 id="video-player-title">Video player</h2>
                <button class="video-player-close" type="button" data-video-player-close aria-label="Close video player">&times;</button>
            </div>
            <div class="video-player-frame" data-video-player-frame></div>
        </div>
    </div>
</x-layouts.public>
