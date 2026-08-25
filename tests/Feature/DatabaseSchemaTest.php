<?php

use App\Models\Activity;
use App\Models\Download;
use App\Models\News;
use App\Models\Page;
use App\Models\SppEvent;
use App\Models\Video;
use Illuminate\Support\Facades\Schema;

test('database has all 6 prototype tables', function () {
    expect(Schema::hasTable('news'))->toBeTrue();
    expect(Schema::hasTable('activities'))->toBeTrue();
    expect(Schema::hasTable('downloads'))->toBeTrue();
    expect(Schema::hasTable('videos'))->toBeTrue();
    expect(Schema::hasTable('pages'))->toBeTrue();
    expect(Schema::hasTable('spp_events'))->toBeTrue();
});

test('news model can be created and retrieved', function () {
    $news = News::factory()->create([
        'title' => 'Test News Title',
        'slug' => 'test-news-title',
        'status' => 'published',
    ]);

    expect($news->exists)->toBeTrue();
    expect(News::where('slug', 'test-news-title')->first()->title)->toBe('Test News Title');
});

test('activity model can be created and retrieved', function () {
    $activity = Activity::factory()->create([
        'title' => 'Test Activity Title',
        'slug' => 'test-activity-title',
        'status' => 'published',
    ]);

    expect($activity->exists)->toBeTrue();
    expect(Activity::where('slug', 'test-activity-title')->first()->title)->toBe('Test Activity Title');
});

test('download model can be created and retrieved', function () {
    $download = Download::factory()->create([
        'title' => 'Test Download Document',
        'category' => 'Handbook',
        'year' => 2026,
    ]);

    expect($download->exists)->toBeTrue();
    expect(Download::where('title', 'Test Download Document')->first()->category)->toBe('Handbook');
});

test('video model can be created and retrieved', function () {
    $video = Video::factory()->create([
        'title' => 'Test Video Presentation',
        'video_url' => 'https://example.com/video.mp4',
    ]);

    expect($video->exists)->toBeTrue();
    expect(Video::where('title', 'Test Video Presentation')->first()->video_url)->toBe('https://example.com/video.mp4');
});

test('page model can be created and retrieved', function () {
    $page = Page::factory()->create([
        'title' => 'About SPP Page',
        'slug' => 'about-spp',
    ]);

    expect($page->exists)->toBeTrue();
    expect(Page::where('slug', 'about-spp')->first()->title)->toBe('About SPP Page');
});

test('spp_event model can be created and retrieved', function () {
    $event = SppEvent::factory()->create([
        'title' => '44th SPP Physics Conference',
        'slug' => 'spp-2026',
        'location' => 'Manila, Philippines',
    ]);

    expect($event->exists)->toBeTrue();
    expect(SppEvent::where('slug', 'spp-2026')->first()->location)->toBe('Manila, Philippines');
});
