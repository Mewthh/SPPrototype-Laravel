<x-layouts.public :title="$article->title.' | Samahang Pisika ng Pilipinas'">
    <section style="padding: 40px 0 60px;"><div class="shell" style="max-width: 920px; margin: 0 auto; padding: 0 20px;"><article><h1 style="font-size: 2.25rem; font-weight: 800; color: var(--accent-strong);">{{ $article->title }}</h1><div style="line-height: 1.7; color: var(--text);">{!! \Illuminate\Support\Str::markdown($article->content, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}</div></article></div></section>
</x-layouts.public>
