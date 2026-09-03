<?php

use App\Models\Activity;
use App\Models\News;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    $this->user = User::factory()->create();
});

test('hero banner settings can be viewed and return available posts', function () {
    $news = News::create([
        'title' => 'Quantum Computing Breakthrough',
        'slug' => 'quantum-computing-breakthrough',
        'content' => 'Full article content here.',
        'status' => 'published',
    ]);

    $activity = Activity::create([
        'title' => 'SPP Congress 2026',
        'slug' => 'spp-congress-2026',
        'description' => 'Annual national congress.',
        'status' => 'published',
        'event_date' => now()->addDays(10),
    ]);

    $response = $this->actingAs($this->user)
        ->getJson(route('admin.api.hero-banner.show'));

    $response->assertOk()
        ->assertJsonStructure([
            'image_url',
            'image_path',
            'link_type',
            'link_url',
            'link_target_id',
            'open_in_new_tab',
            'resolved_link_url',
            'available_posts' => [
                'news',
                'activities',
            ],
        ]);

    $data = $response->json();
    expect($data['available_posts']['news'])->not->toBeEmpty()
        ->and($data['available_posts']['activities'])->not->toBeEmpty();
});

test('hero banner can be saved with custom url and appears on homepage with link', function () {
    $file = UploadedFile::fake()->image('banner.png', 1200, 400);

    $response = $this->actingAs($this->user)
        ->postJson(route('admin.api.hero-banner.update'), [
            'image' => $file,
            'link_type' => 'url',
            'link_url' => 'https://example.com/symposium',
            'open_in_new_tab' => true,
        ]);

    $response->assertOk()
        ->assertJson([
            'link_type' => 'url',
            'link_url' => 'https://example.com/symposium',
            'open_in_new_tab' => true,
            'resolved_link_url' => 'https://example.com/symposium',
        ]);

    // Check homepage renders the link
    $homeRes = $this->get('/');
    $homeRes->assertOk();
    $homeRes->assertSee('href="https://example.com/symposium"', false);
    $homeRes->assertSee('target="_blank"', false);
});

test('hero banner can be linked to an existing news post and resolves slug route', function () {
    $news = News::create([
        'title' => 'Physics Nobel Prize Discussion',
        'slug' => 'physics-nobel-prize-discussion',
        'content' => 'Article details...',
        'status' => 'published',
    ]);

    $file = UploadedFile::fake()->image('banner_nobel.jpg', 1200, 400);

    $response = $this->actingAs($this->user)
        ->postJson(route('admin.api.hero-banner.update'), [
            'image' => $file,
            'link_type' => 'news',
            'link_target_id' => $news->id,
            'open_in_new_tab' => false,
        ]);

    $expectedUrl = route('news.show', ['slug' => $news->slug]);

    $response->assertOk()
        ->assertJson([
            'link_type' => 'news',
            'link_target_id' => $news->id,
            'resolved_link_url' => $expectedUrl,
        ]);

    // Check homepage renders the route to this article
    $homeRes = $this->get('/');
    $homeRes->assertOk();
    $homeRes->assertSee('href="'.$expectedUrl.'"', false);
    $homeRes->assertSee('target="_self"', false);
});

test('hero banner can be linked to an existing activity post', function () {
    $activity = Activity::create([
        'title' => 'National Physics Olympiad',
        'slug' => 'national-physics-olympiad',
        'description' => 'Event details...',
        'status' => 'published',
        'event_date' => now()->addMonth(),
    ]);

    $response = $this->actingAs($this->user)
        ->postJson(route('admin.api.hero-banner.update'), [
            'image_url' => 'banners/existing.jpg',
            'link_type' => 'activity',
            'link_target_id' => $activity->id,
            'open_in_new_tab' => true,
        ]);

    $expectedUrl = route('activities.show', ['slug' => $activity->slug]);

    $response->assertOk()
        ->assertJson([
            'link_type' => 'activity',
            'link_target_id' => $activity->id,
            'resolved_link_url' => $expectedUrl,
        ]);

    $homeRes = $this->get('/');
    $homeRes->assertOk();
    $homeRes->assertSee('href="'.$expectedUrl.'"', false);
});

test('hero banner can be linked to a conference post and navigates to spp portal', function () {
    $response = $this->actingAs($this->user)
        ->postJson(route('admin.api.hero-banner.update'), [
            'image_url' => 'banners/conf2026.jpg',
            'link_type' => 'conference',
            'link_target_slug' => '2026',
            'open_in_new_tab' => true,
        ]);

    $expectedUrl = route('spp.show', ['year' => '2026']);

    $response->assertOk()
        ->assertJson([
            'link_type' => 'conference',
            'link_target_slug' => '2026',
            'resolved_link_url' => $expectedUrl,
        ]);

    $homeRes = $this->get('/');
    $homeRes->assertOk();
    $homeRes->assertSee('href="'.$expectedUrl.'"', false);
    $homeRes->assertSee('target="_blank"', false);
});

test('hero banner can be reset removing link and image', function () {
    Page::updateOrCreate(
        ['slug' => 'home-hero'],
        [
            'title' => 'Home Hero Banner',
            'content' => 'Hero Banner Configuration',
            'image' => 'banners/dummy.png',
            'link_type' => 'url',
            'link_url' => 'https://example.com',
            'open_in_new_tab' => true,
            'status' => 'published',
        ]
    );

    $response = $this->actingAs($this->user)
        ->deleteJson(route('admin.api.hero-banner.destroy'));

    $response->assertOk()
        ->assertJson([
            'image_url' => null,
            'link_type' => 'none',
            'resolved_link_url' => null,
        ]);

    $page = Page::where('slug', 'home-hero')->first();
    expect($page->image)->toBeNull()
        ->and($page->link_type)->toBe('none')
        ->and($page->link_url)->toBeNull();
});
