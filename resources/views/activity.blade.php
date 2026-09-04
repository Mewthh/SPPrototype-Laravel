@php
    $pageTitle = $activity ? "{$activity->title} | Samahang Pisika ng Pilipinas" : 'Activities | Samahang Pisika ng Pilipinas';
    $pageDescription = $activity ? ($activity->summary ?: Str::limit(strip_tags($activity->description), 150)) : 'Read about the latest activities and events from Samahang Pisika ng Pilipinas.';
@endphp

<x-layouts.public :title="$pageTitle" :description="$pageDescription" class="shell">
    <div id="article-root" class="article-page-layout" data-server-rendered="true">
        @if($activity)
            @php
                $dateFormatted = $activity->event_date ? $activity->event_date->format('M j, Y') : ($activity->created_at ? $activity->created_at->format('M j, Y') : 'Recent');
                $safeTitle = urlencode(mb_substr($activity->title, 0, 20));
                $defaultSvg = "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 520'><rect width='800' height='520' rx='24' fill='%23e5e7eb'/><rect x='32' y='32' width='736' height='456' rx='18' fill='%23f8fafc' stroke='%23cbd5e1'/><text x='50%25' y='50%25' text-anchor='middle' dominant-baseline='middle' fill='%236b7280' font-family='Segoe UI,Arial,sans-serif' font-size='32'>{$safeTitle}</text></svg>";
                $imageSrc = $activity->image_url ?: ($activity->image ?: $defaultSvg);
            @endphp

            <article class="article-container">
                <div class="article-top-nav">
                    <a href="{{ route('home') }}#activities" class="button button-secondary">&larr; Back to Activities</a>
                </div>

                <header class="article-header">
                    <div class="article-meta-row">
                        <span class="card-chip">Activity</span>
                        @if($activity->event_date)
                            <time class="card-meta-line" datetime="{{ $activity->event_date?->toIso8601String() }}">
                                Event Date: {{ $dateFormatted }}
                            </time>
                        @endif
                        @if($activity->location)
                            <span class="card-meta-line">&bull; {{ $activity->location }}</span>
                        @endif
                    </div>
                    <h1 class="article-title">{!! \App\Support\Markdown::renderInline($activity->title) !!}</h1>
                </header>

                <div class="article-hero-media">
                    <img src="{{ $imageSrc }}" alt="{{ strip_tags(\App\Support\Markdown::renderInline($activity->title)) }}" data-fallback-src="{{ $defaultSvg }}" data-original-src="{{ $imageSrc }}" onerror="if(this.dataset.fallbackSrc && this.src !== this.dataset.fallbackSrc){ this.src = this.dataset.fallbackSrc; this.dataset.imageFailed = 'true'; this.dataset.isUsingFallback = 'true'; }" />
                </div>

                <div class="article-body">
                    {!! \App\Support\Markdown::render($activity->description ?: $activity->summary) !!}
                </div>

                <footer class="article-footer">
                    <a href="{{ route('home') }}#activities" class="button button-secondary">&larr; Back to Activities</a>
                </footer>
            </article>
        @elseif(!empty($slug))
            <div class="article-not-found">
                <h2>Activity Not Found</h2>
                <p>This activity is not available, has been archived, or is not yet published.</p>
                <a href="{{ route('home') }}#activities" class="button button-primary">&larr; Back to Activities</a>
            </div>
        @else
            <div class="article-not-found">
                <h2>No Activity Specified</h2>
                <p>Please select an activity from the listing.</p>
                <a href="{{ route('home') }}#activities" class="button button-primary">&larr; View All Activities</a>
            </div>
        @endif
    </div>
</x-layouts.public>
