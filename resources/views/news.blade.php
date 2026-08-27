@php
    $pageTitle = $news ? "{$news->title} | Samahang Pisika ng Pilipinas" : 'News | Samahang Pisika ng Pilipinas';
    $pageDescription = $news ? ($news->excerpt ?: Str::limit(strip_tags($news->content), 150)) : 'Read the latest news and announcements from Samahang Pisika ng Pilipinas.';
@endphp

<x-layouts.public :title="$pageTitle" :description="$pageDescription" class="shell">
    <div id="article-root" class="article-page-layout" data-server-rendered="true">
        @if($news)
            @php
                $dateFormatted = $news->published_at ? $news->published_at->format('M j, Y') : ($news->created_at ? $news->created_at->format('M j, Y') : 'Recent');
                $safeTitle = urlencode(mb_substr($news->title, 0, 20));
                $defaultSvg = "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 520'><rect width='800' height='520' rx='24' fill='%23e5e7eb'/><rect x='32' y='32' width='736' height='456' rx='18' fill='%23f8fafc' stroke='%23cbd5e1'/><text x='50%25' y='50%25' text-anchor='middle' dominant-baseline='middle' fill='%236b7280' font-family='Segoe UI,Arial,sans-serif' font-size='32'>{$safeTitle}</text></svg>";
                $imageSrc = $news->image ?: $defaultSvg;
            @endphp

            <article class="article-container">
                <div class="article-top-nav">
                    <a href="{{ route('home') }}#news" class="button button-secondary">&larr; Back to News</a>
                </div>

                <header class="article-header">
                    <div class="article-meta-row">
                        <span class="card-chip">News</span>
                        <time class="card-meta-line" datetime="{{ $news->published_at?->toIso8601String() }}">
                            Published on {{ $dateFormatted }}
                        </time>
                    </div>
                    <h1 class="article-title">{!! \App\Support\Markdown::renderInline($news->title) !!}</h1>
                </header>

                <div class="article-hero-media">
                    <img src="{{ $imageSrc }}" alt="{{ strip_tags(\App\Support\Markdown::renderInline($news->title)) }}" />
                </div>

                <div class="article-body">
                    {!! \App\Support\Markdown::render($news->content) !!}
                </div>

                <footer class="article-footer">
                    <a href="{{ route('home') }}#news" class="button button-secondary">&larr; Back to News</a>
                </footer>
            </article>
        @elseif(!empty($slug))
            <div class="article-not-found">
                <h2>Article Not Found</h2>
                <p>This article is not available, has been archived, or is not yet published.</p>
                <a href="{{ route('home') }}#news" class="button button-primary">&larr; Back to News</a>
            </div>
        @else
            <div class="article-not-found">
                <h2>No Article Specified</h2>
                <p>Please select an article from the news listing.</p>
                <a href="{{ route('home') }}#news" class="button button-primary">&larr; View All News</a>
            </div>
        @endif
    </div>
</x-layouts.public>
