<x-layouts.public title="Videos and Webinars | Samahang Pisika ng Pilipinas">
    @php
        $videos = [
            ['title' => 'Philippine Physics Olympiad PPO2022 Closing Ceremony', 'date' => '14 May 2022'],
            ['title' => 'SPP 2020 Session 5G: Condensed Matter & Materials Science', 'date' => '23 October 2020'],
            ['title' => 'SPP 2020 Session 5E: Condensed Matter & Materials Science', 'date' => '23 October 2020'],
            ['title' => 'SPP 2020 Session 5D: Physics Education', 'date' => '23 October 2020'],
            ['title' => 'SPP 2020 Session 5C: Condensed Matter and Materials Science', 'date' => '23 October 2020'],
            ['title' => 'SPP 2020 Plenary Session 5B', 'date' => '23 October 2020'],
            ['title' => 'SPP 2020 Session 5A: Theoretical & Mathematical Physics', 'date' => '23 October 2020'],
            ['title' => 'SPP 2020 Session 4G: Materials Science and Computational Physics', 'date' => '22 October 2020'],
            ['title' => 'SPP 2020 Session 4F: Condensed Matter and Materials Science', 'date' => '22 October 2020'],
            ['title' => 'SPP 2020 Session 4E: Condensed Matter & Materials Science', 'date' => '22 October 2020'],
            ['title' => 'W3-E1: Establishing the Student-Teacher Relationship, Part 1', 'date' => '18 September 2020'],
            ['title' => 'W2-E2: Flipped Classrooms and Remote Learning, Part 2', 'date' => '11 September 2020'],
        ];
    @endphp

    <section class="videos-page">
        <div class="shell">
            <header class="videos-page-header">
                <p class="section-kicker">SPP Resource Library</p>
                <h1>Videos and Webinars</h1>
            </header>

            <section aria-labelledby="video-library-heading">
                <div class="videos-section-heading">
                    <div>
                        <h2 id="video-library-heading">Video Library</h2>
                    </div>
                    <span class="videos-count">{{ count($videos) }} videos</span>
                </div>

                <div class="video-library-grid" id="video-library-grid">
                    @foreach ($videos as $video)
                        <article class="video-library-card {{ $loop->index >= 8 ? 'video-library-card-hidden' : '' }}">
                            <div class="video-library-preview" aria-hidden="true">
                                <span>SPP</span>
                                <span class="video-library-play">&#x25B6;</span>
                            </div>
                            <div class="video-library-card-body">
                                <time>
                                    <span aria-hidden="true">&#x25F7;</span> {{ $video['date'] }}
                                </time>
                                <h3>{{ $video['title'] }}</h3>
                                <span class="video-library-type">Video recording</span>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="video-library-actions" aria-label="Video library controls">
                    <button class="video-library-button" id="videos-show-more" type="button">Show More</button>
                    <button class="video-library-button video-library-button-secondary" id="videos-show-less" type="button" hidden>Show Less</button>
                </div>
            </section>
        </div>
    </section>
</x-layouts.public>
