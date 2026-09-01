@props([
    'activity' => null,
    'title'    => 'title',
    'chip'     => 'Activities',
    'summary'  => 'sample text.',
    'meta'     => '',
    'image'    => '',
    'hidden'   => false,
])

@php
    $slug = $activity?->slug ?: ($activity?->id ?: null);
    $detailUrl = $slug ? route('activities.show', ['slug' => $slug]) : ($slug ? route('activities.index', ['slug' => $slug]) : null);
    $actualTitle = $activity?->title ?: $title;
    $actualSummary = $activity ? ($activity->summary ?: Str::limit(strip_tags($activity->description), 130)) : $summary;
    $actualMeta = $meta ?: ($activity?->event_date ? $activity->event_date->format('M j, Y') : ($activity?->location ?: ''));
    $safeTitle = urlencode(mb_substr($actualTitle, 0, 20));
    $placeholder = "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 520'><rect width='800' height='520' rx='28' fill='%23e5e7eb'/><text x='50%25' y='50%25' text-anchor='middle' dominant-baseline='middle' fill='%236b7280' font-family='Segoe UI,Arial,sans-serif' font-size='32'>{$safeTitle}</text></svg>";
    $src = ($activity?->image_url ?: ($activity?->image ?: $image)) ?: $placeholder;
@endphp

<article class="content-card activity-card-item {{ $hidden ? 'activity-item-hidden' : '' }}" @if($slug) data-slug="{{ $slug }}" @endif @if($hidden) style="display: none;" @endif>
    @if($detailUrl)
        <a href="{{ $detailUrl }}" class="card-image-link" tabindex="-1" aria-hidden="true">
            <img src="{{ $src }}" alt="{{ $actualTitle }}" loading="lazy" />
        </a>
    @else
        <img src="{{ $src }}" alt="{{ $actualTitle }}" loading="lazy" />
    @endif
    <div class="card-body">
        <span class="card-chip">{{ $chip }}</span>
        @if($actualMeta)
            <p class="card-meta-line">{{ $actualMeta }}</p>
        @endif
        <h3>
            @if($detailUrl)
                <a href="{{ $detailUrl }}" class="card-title-link">{!! \App\Support\Markdown::renderInline($actualTitle) !!}</a>
            @else
                {!! \App\Support\Markdown::renderInline($actualTitle) !!}
            @endif
        </h3>
        <p>{!! \App\Support\Markdown::renderInline($actualSummary) !!}</p>
        @if($detailUrl)
            <a class="text-button" href="{{ $detailUrl }}">Read More &rarr;</a>
        @endif
    </div>
</article>

