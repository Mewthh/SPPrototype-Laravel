@props([
    'title' => 'title',
    'chip' => 'Activities',
    'summary' => 'sample text.',
    'meta' => 'sample text',
    'image' => "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 520'><rect width='800' height='520' rx='28' fill='%23e5e7eb'/><rect x='40' y='40' width='720' height='440' rx='22' fill='%23f8fafc' stroke='%23cbd5e1'/><text x='50%25' y='50%25' text-anchor='middle' dominant-baseline='middle' fill='%236b7280' font-family='Segoe UI,Arial,sans-serif' font-size='40'>sample text</text></svg>"
])

<article class="content-card">
    <img src="{{ $image }}" alt="{{ $title }}" />
    <div class="card-body">
        <span class="card-chip">{{ $chip }}</span>
        <h3>{{ $title }}</h3>
        <p>{{ $summary }}</p>
        <small>{{ $meta }}</small>
    </div>
</article>
