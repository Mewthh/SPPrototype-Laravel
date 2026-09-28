@props(['title'])

<section {{ $attributes->merge(['class' => 'portal-card portal-info-card']) }}>
    <h2>{{ $title }}</h2>
    <dl class="portal-definition-list">
        {{ $slot }}
    </dl>
</section>
