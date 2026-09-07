@php
    $confYear = trim($conference->year ?? '');
    $formattedBadge = preg_match('/^spp/i', $confYear) ? strtoupper($confYear) : ($confYear ? "SPP {$confYear}" : 'SPP');
    $formattedHeaderCode = preg_match('/^spp/i', $confYear) ? strtoupper($confYear) : ($confYear ? "SPP{$confYear}" : 'SPP');
    $confTitle = $conference ? "{$formattedHeaderCode}: {$conference->title} | Samahang Pisika ng Pilipinas" : 'SPP | Samahang Pisika ng Pilipinas';
    $confDesc = $conference ? ($conference->summary ?: Str::limit(strip_tags($conference->description), 150)) : "Samahang Pisika ng Pilipinas (SPP) Conference {$activeYear}";
    $tabs = $conference && is_array($conference->tabs) ? $conference->tabs : [];
@endphp

<x-layouts.public :title="$confTitle" :description="$confDesc" class="shell" id="spp-conference-main">
    <div class="conference-portal">
        @if($conference)
            <div class="conference-hero">
                @if($conference->image_url || $conference->image)
                    <div class="conference-hero-banner">
                        <img src="{{ $conference->image_url ?: $conference->image }}" alt="{{ $conference->title }}" />
                    </div>
                @endif
                <div class="conference-hero-content">
                    <div class="conference-meta-row">
                        <span class="conference-badge">{{ $formattedBadge }}</span>
                        @if($conference->location)
                            <span class="card-meta-line">&#x1F4CD; {{ $conference->location }}</span>
                        @endif
                        @if($conference->dates)
                            <span class="card-meta-line">&#x1F4C5; {{ $conference->dates }}</span>
                        @endif
                    </div>
                    <h1 class="conference-title">{!! \App\Support\Markdown::renderInline($conference->title) !!}</h1>
                    @if($conference->theme)
                        <p class="conference-theme">&ldquo;{{ $conference->theme }}&rdquo;</p>
                    @endif
                    @if($conference->summary)
                        <p class="conference-summary" style="font-size: 1.1rem; color: var(--text-muted, #64748b); line-height: 1.6; margin: 0;">
                            {{ $conference->summary }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="conference-layout">
                <aside class="conference-sidebar" aria-label="Conference sections">
                    <h2 class="conference-sidebar-title">Conference Menu</h2>
                    <nav class="conference-tab-nav" role="tablist">
                        <button type="button" class="conference-tab-btn active" data-tab-target="tab-overview" role="tab" aria-selected="true" aria-controls="tab-overview">
                            <span>Overview</span>
                            <span aria-hidden="true">&rsaquo;</span>
                        </button>
                        @foreach($tabs as $index => $tab)
                            @php
                                $tabKey = 'tab-custom-' . ($tab['id'] ?? $index);
                                $tabTitle = !empty($tab['title']) ? $tab['title'] : 'Tab ' . ($index + 1);
                            @endphp
                            <button type="button" class="conference-tab-btn" data-tab-target="{{ $tabKey }}" role="tab" aria-selected="false" aria-controls="{{ $tabKey }}">
                                <span>{{ $tabTitle }}</span>
                                <span aria-hidden="true">&rsaquo;</span>
                            </button>
                        @endforeach
                    </nav>

                    @if(isset($conferences) && $conferences->count() > 1)
                        <div style="border-top: 1px solid var(--border); margin-top: 12px; padding-top: 12px;">
                            <h2 class="conference-sidebar-title">Other Years</h2>
                            <div style="display: grid; gap: 4px;">
                                @foreach($conferences as $otherConf)
                                    @if($otherConf->id !== $conference->id)
                                        @php
                                            $rawYear = trim($otherConf->year ?? '');
                                            $rawTitle = trim($otherConf->title ?? '');
                                            if (preg_match('/^spp\s*(\d{4}|\w+)/i', $rawTitle, $m)) {
                                                $otherLabel = 'SPP' . $m[1];
                                            } elseif (!empty($rawYear)) {
                                                $otherLabel = preg_match('/^spp/i', $rawYear) ? strtoupper($rawYear) : 'SPP' . $rawYear;
                                            } else {
                                                $otherLabel = preg_match('/^spp/i', $rawTitle) ? $rawTitle : 'SPP ' . $rawTitle;
                                            }
                                            $otherTarget = $otherConf->year ?: ($otherConf->title ?: $otherConf->id);
                                        @endphp
                                        <a href="{{ route('spp.show', ['year' => $otherTarget]) }}"
                                           class="conference-tab-btn" style="text-decoration: none;">
                                            <span>{{ $otherLabel }}</span>
                                            <span aria-hidden="true">&rarr;</span>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </aside>

                <main class="conference-main-panel">
                    <section id="tab-overview" class="conference-tab-pane active" role="tabpanel" aria-labelledby="tab-overview">
                        <div class="conference-body-text">
                            @if($conference->description)
                                {!! \App\Support\Markdown::render($conference->description) !!}
                            @elseif($conference->summary)
                                <p>{{ $conference->summary }}</p>
                            @else
                                <p>Welcome to the Samahang Pisika ng Pilipinas {{ $conference->year }} National Physics Conference and Annual Meeting.</p>
                            @endif
                        </div>
                    </section>

                    @foreach($tabs as $index => $tab)
                        @php
                            $tabKey = 'tab-custom-' . ($tab['id'] ?? $index);
                            $tabTitle = !empty($tab['title']) ? $tab['title'] : 'Section ' . ($index + 1);
                            $tabContent = $tab['content'] ?? '';
                        @endphp
                        <section id="{{ $tabKey }}" class="conference-tab-pane" role="tabpanel" aria-labelledby="{{ $tabKey }}">
                            <h2 style="font-size: 1.8rem; margin: 0 0 18px; color: var(--text); font-weight: 700;">{{ $tabTitle }}</h2>
                            <div class="conference-body-text">
                                {!! \App\Support\Markdown::render($tabContent) !!}
                            </div>
                        </section>
                    @endforeach
                </main>
            </div>
        @else
            <div class="article-not-found" style="text-align: center; padding: 64px 16px;">
                <h1 style="font-size: 2.2rem; margin-bottom: 12px;">SPP{{ $activeYear }} Conference</h1>
                <p style="color: var(--text-muted, #64748b); font-size: 1.1rem; max-width: 540px; margin: 0 auto 24px;">
                    Information for the {{ $activeYear }} Samahang Pisika ng Pilipinas Conference is coming soon or has not been published yet.
                </p>
                <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('home') }}" class="button button-primary">&larr; Back to Home</a>
                    @if(isset($conferences) && $conferences->isNotEmpty())
                        @foreach($conferences->take(3) as $c)
                            @php
                                $cYear = trim($c->year ?? '');
                                $cTitle = trim($c->title ?? '');
                                if (preg_match('/^spp\s*(\d{4}|\w+)/i', $cTitle, $m)) {
                                    $cBtnLabel = 'SPP' . $m[1];
                                } elseif (!empty($cYear)) {
                                    $cBtnLabel = preg_match('/^spp/i', $cYear) ? strtoupper($cYear) : 'SPP' . $cYear;
                                } else {
                                    $cBtnLabel = preg_match('/^spp/i', $cTitle) ? $cTitle : 'SPP ' . $cTitle;
                                }
                            @endphp
                            <a href="{{ route('spp.show', ['year' => $c->year ?? $c->title]) }}" class="button button-secondary">
                                {{ $cBtnLabel }}
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabButtons = document.querySelectorAll('.conference-tab-btn[data-tab-target]');
            const tabPanes = document.querySelectorAll('.conference-tab-pane');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const targetId = button.getAttribute('data-tab-target');
                    if (!targetId) return;

                    tabButtons.forEach(btn => {
                        btn.classList.remove('active');
                        btn.setAttribute('aria-selected', 'false');
                    });
                    tabPanes.forEach(pane => {
                        pane.classList.remove('active');
                    });

                    button.classList.add('active');
                    button.setAttribute('aria-selected', 'true');
                    const targetPane = document.getElementById(targetId);
                    if (targetPane) {
                        targetPane.classList.add('active');
                    }
                });
            });
        });
    </script>
</x-layouts.public>
