@props(['news', 'hidden' => false])

@php
    $slug = $news->slug ?: $news->id;
    $detailUrl = route('news.index', ['slug' => $slug]);
    $title = Str::limit($news->title, 100, '…');
    $excerpt = Str::limit($news->excerpt ?: Str::limit(strip_tags($news->content), 200), 200, '…');
    $dateFormatted = $news->published_at ? $news->published_at->format('M j, Y') : ($news->created_at ? $news->created_at->format('M j, Y') : 'Recent');
    $safeTitle = urlencode(mb_substr($title, 0, 20));
    $defaultSvg = "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 520'><rect width='800' height='520' rx='24' fill='%23e5e7eb'/><rect x='32' y='32' width='736' height='456' rx='18' fill='%23f8fafc' stroke='%23cbd5e1'/><text x='50%25' y='50%25' text-anchor='middle' dominant-baseline='middle' fill='%236b7280' font-family='Segoe UI,Arial,sans-serif' font-size='32'>{$safeTitle}</text></svg>";
    $imageSrc = $news->image_url ?: ($news->image ?: $defaultSvg);
@endphp

<article class="content-card news-card-item {{ $hidden ? 'news-item-hidden' : '' }}" data-slug="{{ $slug }}" @if($hidden) style="display: none;" @endif>
    <a href="{{ $detailUrl }}" class="card-image-link" tabindex="-1" aria-hidden="true">
        <img src="{{ $imageSrc }}" alt="{{ $title }}" loading="lazy" data-fallback-src="{{ $defaultSvg }}" data-original-src="{{ $imageSrc }}" onerror="if(this.dataset.fallbackSrc && this.src !== this.dataset.fallbackSrc){ this.src = this.dataset.fallbackSrc; this.dataset.imageFailed = 'true'; this.dataset.isUsingFallback = 'true'; }" />
    </a>
    <div class="card-body">
        <span class="card-chip">News</span>
        <p class="card-meta-line">{{ $dateFormatted }}</p>
        <h3><a href="{{ $detailUrl }}" class="card-title-link">{!! \App\Support\Markdown::renderInline($title) !!}</a></h3>
        <p>{!! \App\Support\Markdown::renderInline($excerpt) !!}</p>
        <a class="text-button" href="{{ $detailUrl }}">Read More &rarr;</a>
    </div>
</article>
