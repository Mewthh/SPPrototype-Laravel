<x-layouts.public :title="$article->title.' | Samahang Pisika ng Pilipinas'">
    <style>
        .article-container {
            max-width: 960px;
            margin: 0 auto;
            padding: 40px 20px 60px;
        }
        .article-title {
            text-align: center;
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--accent-strong, #ffffff);
            margin: 0 0 40px;
        }
        .article-content {
            font-size: 0.95rem;
            line-height: 1.6;
            color: var(--text, #e2e8f0);
        }
        .article-content p {
            margin: 0 0 20px;
            white-space: pre-wrap;
        }
        .article-content strong {
            display: block;
            font-size: 1rem;
            font-weight: 800;
            color: var(--accent-strong, #ffffff);
            margin-bottom: 4px;
        }
    </style>
    <section class="membership-article-page">
        <div class="article-container">
            <div style="margin-bottom: 24px;">
                <a href="{{ route('membership-faq') }}" style="color: var(--accent-strong, #60a5fa); text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                    &larr; Back to Membership FAQ
                </a>
            </div>
            <h1 class="article-title">{{ $article->title }}</h1>
            <div class="article-content">
                {!! \Illuminate\Support\Str::markdown($article->content, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
            </div>
        </div>
    </section>
</x-layouts.public>


