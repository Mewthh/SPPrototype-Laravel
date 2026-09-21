<x-layouts.public title="Membership FAQ | Samahang Pisika ng Pilipinas">
    <style>
        .membership-faq-answer a { color: #2563eb !important; font-style: normal; font-weight: 700; text-decoration: underline; }
        .membership-faq-answer a[href*="1FAIpQLSdO5VZ9uKaRC-mObDdPcipjsl1aBjWKIF9-H5tVs_C2EKifJQ"] { display: inline-flex; align-items: center; margin-top: 12px; padding: 8px 16px; background: var(--accent-strong); border-radius: var(--radius-sm); color: var(--surface) !important; text-decoration: none; }
        .membership-faq-answer a[href*="1FAIpQLSdO5VZ9uKaRC-mObDdPcipjsl1aBjWKIF9-H5tVs_C2EKifJQ"]:hover { filter: brightness(1.08); }
    </style>
    <section class="membership-faq-page" style="padding: 40px 0 60px;">
        <div class="shell" style="max-width: 920px; margin: 0 auto; padding: 0 20px;">
            <main aria-label="Membership FAQ content">
                <header style="text-align: center; margin-bottom: 36px;"><h1 style="font-size: 2.25rem; font-weight: 800; color: var(--accent-strong); margin: 0;">Membership FAQ</h1></header>
                <div style="background: var(--surface-soft); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 24px; margin-bottom: 32px;">
                    <p style="font-size: 0.95rem; color: var(--text); line-height: 1.6; margin: 0 0 16px;">Search this webpage for related terms of your query using your web browser's search function. If you don't find it here, you may accomplish an online form to ask your question:</p>
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSexjHKcRXZk9Q6mq-AZj2fijUBVjzoUcsRi7VvONcxU5H4olQ/viewform" target="_blank" rel="noopener noreferrer" class="button button-primary" style="display: inline-flex; align-items: center; font-weight: 700; padding: 10px 20px; text-decoration: none;">Membership Inquiry Form</a>
                </div>
                <section aria-labelledby="faq-list-heading">
                    <h2 id="faq-list-heading" style="font-size: 1.35rem; font-weight: 800; color: var(--accent-strong); margin-bottom: 24px; padding-bottom: 10px; border-bottom: 2px solid var(--border);">Frequently Asked Questions about SPP Membership</h2>
                    @if ($faqs->isEmpty())
                        <p style="color: var(--muted);">No membership FAQs have been published yet.</p>
                    @else
                        <div style="display: flex; flex-direction: column; gap: 24px; font-size: 0.95rem; line-height: 1.6;">
                            @foreach ($faqs as $faq)
                                <article style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 20px; box-shadow: var(--shadow);">
                                    <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--accent-strong); margin: 0 0 8px;">{{ $loop->iteration }}. {{ $faq->question }}</h3>
                                    <div class="membership-faq-answer" style="color: var(--muted); font-style: italic;">{!! \Illuminate\Support\Str::markdown($faq->answer, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}</div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </section>
            </main>
        </div>
    </section>
</x-layouts.public>
