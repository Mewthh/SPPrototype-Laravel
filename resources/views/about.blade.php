<x-layouts.public :title="$aboutPage->title . ' | Samahang Pisika ng Pilipinas'" :description="$aboutPage->introduction">
    <section class="about-page shell">
        <header class="about-page-intro {{ $aboutPage->image_url ? 'has-image' : '' }}">
            <div>
                <p class="eyebrow">Samahang Pisika ng Pilipinas</p>
                <h1>{{ $aboutPage->title }}</h1>
                <p>{{ $aboutPage->introduction }}</p>
            </div>
            @if ($aboutPage->image_url)
                <img src="{{ $aboutPage->image_url }}" alt="Samahang Pisika ng Pilipinas" class="about-page-image" />
            @endif
        </header>

        <section class="about-page-section" aria-labelledby="council-heading">
            <div class="section-header">
                <div>
                    <p class="eyebrow">Leadership</p>
                    <h2 id="council-heading">{{ $aboutPage->council_heading }}</h2>
                </div>
            </div>

            <div class="about-officers-grid">
                @foreach ($aboutPage->officers ?? [] as $officer)
                    <article class="about-person-card">
                        <p class="about-person-role">{{ $officer['role'] }}</p>
                        <h3>{{ $officer['name'] }}</h3>
                        <p>{{ $officer['institution'] }}</p>
                    </article>
                @endforeach
            </div>

            @if (! empty($aboutPage->councilors))
                <div class="about-councilors">
                    <h3>Councilors</h3>
                    <div class="about-councilors-grid">
                        @foreach ($aboutPage->councilors as $councilor)
                            <article>
                                <strong>{{ $councilor['name'] }}</strong>
                                <span>{{ $councilor['institution'] }}</span>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif
        </section>

        <section class="about-contact-card" aria-labelledby="contact-heading">
            <p class="eyebrow">Get in touch</p>
            <h2 id="contact-heading">Contact Us</h2>
            <address>{{ $aboutPage->address }}</address>
            <a href="mailto:{{ $aboutPage->email }}">{{ $aboutPage->email }}</a>
        </section>
    </section>
</x-layouts.public>
