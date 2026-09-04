<?php

use App\Models\SppEvent;
use App\Models\User;

test('public conference page displays published conference with custom tabs', function () {
    $event = SppEvent::create([
        'year' => '2027',
        'title' => '45th National Physics Conference',
        'slug' => 'spp-2027',
        'theme' => 'Frontiers of Quantum and Condensed Matter',
        'description' => 'Detailed description of the 2027 conference.',
        'location' => 'Baguio City, Philippines',
        'dates' => 'October 20-23, 2027',
        'summary' => 'Join physicists across the nation.',
        'status' => 'published',
        'tabs' => [
            ['id' => 'tab-dates', 'title' => 'Important Dates', 'content' => 'Abstract submission: July 31, 2027'],
            ['id' => 'tab-reg', 'title' => 'Registration Fees', 'content' => 'Regular: PHP 3,500; Students: PHP 2,000'],
        ],
    ]);

    $response = $this->get('/spp?year=2027');

    $response->assertOk()
        ->assertSee('45th National Physics Conference')
        ->assertSee('Frontiers of Quantum and Condensed Matter')
        ->assertSee('Baguio City, Philippines')
        ->assertSee('Important Dates')
        ->assertSee('Registration Fees')
        ->assertSee('Abstract submission: July 31, 2027');
});

test('admin can create conference with custom tabs via API', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->postJson('/admin/api/conferences', [
        'year' => '2028',
        'title' => '46th National Physics Conference',
        'theme' => 'Physics in the Age of AI',
        'location' => 'Iloilo City',
        'dates' => 'November 10-13, 2028',
        'summary' => 'Annual SPP conference in Western Visayas.',
        'body' => 'Overview of themes and sessions.',
        'status' => 'published',
        'tabs' => json_encode([
            ['id' => 'tab-1', 'title' => 'Call for Papers', 'content' => 'Submit abstracts online.'],
        ]),
    ]);

    $response->assertCreated()
        ->assertJsonPath('data.year', '2028')
        ->assertJsonPath('data.title', '46th National Physics Conference');

    $this->assertDatabaseHas('spp_events', [
        'year' => '2028',
        'title' => '46th National Physics Conference',
        'status' => 'published',
    ]);

    $created = SppEvent::where('year', '2028')->first();
    expect($created->tabs)->toHaveCount(1);
    expect($created->tabs[0]['title'])->toBe('Call for Papers');
});

test('admin can update conference status via API', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $event = SppEvent::create([
        'year' => '2029',
        'title' => '47th National Physics Conference',
        'slug' => 'spp-2029',
        'description' => 'Draft conference description.',
        'status' => 'draft',
    ]);

    $response = $this->actingAs($admin)->patchJson("/admin/api/conferences/{$event->id}/status", [
        'status' => 'published',
    ]);

    $response->assertOk()
        ->assertJsonPath('data.status', 'published');

    $this->assertDatabaseHas('spp_events', [
        'id' => $event->id,
        'status' => 'published',
    ]);
});

test('public header renders newly published conference button with normalized SPP label', function () {
    SppEvent::create([
        'year' => '2027',
        'title' => 'SPP2027',
        'slug' => 'spp-2027',
        'description' => 'SPP 2027 Annual Physics Conference.',
        'status' => 'published',
    ]);

    $response = $this->get('/');

    $response->assertOk()
        ->assertSee('SPP2027')
        ->assertDontSee('SPPSPP2027');
});
