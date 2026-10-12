<?php

use App\Models\SppEvent;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

test('public conference page displays handbook download button when handbook is attached', function () {
    $event = SppEvent::create([
        'year' => '2027',
        'title' => '45th National Physics Conference',
        'slug' => 'spp-2027',
        'description' => 'Detailed description of the 2027 conference.',
        'status' => 'published',
        'handbook_name' => 'SPP 2027 Official Handbook',
        'handbook_file' => 'conferences/handbooks/spp2027-handbook.pdf',
    ]);

    $response = $this->get('/spp?year=2027');

    $response->assertOk()
        ->assertSee('SPP 2027 Official Handbook')
        ->assertSee('conference-handbook-download-btn')
        ->assertSee(route('spp.handbook.download', $event));
});

test('public conference page does not display handbook button when handbook is not attached', function () {
    SppEvent::create([
        'year' => '2027',
        'title' => '45th National Physics Conference',
        'slug' => 'spp-2027',
        'description' => 'Detailed description of the 2027 conference.',
        'status' => 'published',
    ]);

    $response = $this->get('/spp?year=2027');

    $response->assertOk()
        ->assertDontSee('conference-handbook-download-btn');
});

test('user can download conference handbook via download route', function () {
    Storage::fake('public');
    config(['filesystems.default' => 'public']);

    Storage::disk('public')->put('conferences/handbooks/sample-handbook.pdf', 'PDF content');

    $event = SppEvent::create([
        'year' => '2027',
        'title' => '45th National Physics Conference',
        'slug' => 'spp-2027',
        'description' => 'Conference description',
        'status' => 'published',
        'handbook_name' => 'SPP 2027 Official Handbook',
        'handbook_file' => 'conferences/handbooks/sample-handbook.pdf',
    ]);

    $response = $this->get(route('spp.handbook.download', $event));

    $response->assertOk()
        ->assertDownload('spp-2027-official-handbook.pdf');
});

test('admin can create conference with handbook via API', function () {
    Storage::fake('public');
    config(['filesystems.default' => 'public']);

    $admin = User::factory()->create(['role' => 'admin']);
    $file = UploadedFile::fake()->create('conference-handbook.pdf', 300, 'application/pdf');

    $response = $this->actingAs($admin)->postJson('/admin/api/conferences', [
        'year' => '2030',
        'title' => '48th National Physics Conference',
        'status' => 'published',
        'handbook_name' => 'SPP 2030 Conference Handbook',
        'handbookFile' => $file,
    ]);

    $response->assertCreated()
        ->assertJsonPath('data.handbook_name', 'SPP 2030 Conference Handbook');

    $created = SppEvent::where('year', '2030')->first();
    expect($created->handbook_file)->not->toBeNull();
    Storage::disk('public')->assertExists($created->handbook_file);
});

test('admin can update conference handbook and remove handbook via API', function () {
    Storage::fake('public');
    config(['filesystems.default' => 'public']);

    $admin = User::factory()->create(['role' => 'admin']);
    Storage::disk('public')->put('conferences/handbooks/initial.pdf', 'dummy');

    $event = SppEvent::create([
        'year' => '2031',
        'title' => '49th National Physics Conference',
        'slug' => 'spp-2031',
        'description' => 'Conference description',
        'status' => 'published',
        'handbook_name' => 'Initial Handbook',
        'handbook_file' => 'conferences/handbooks/initial.pdf',
    ]);

    // Update name
    $response = $this->actingAs($admin)->putJson("/admin/api/conferences/{$event->id}", [
        'title' => '49th National Physics Conference',
        'status' => 'published',
        'handbook_name' => 'Updated Handbook Title',
    ]);

    $response->assertOk()
        ->assertJsonPath('data.handbook_name', 'Updated Handbook Title');

    expect($event->fresh()->handbook_file)->toBe('conferences/handbooks/initial.pdf');

    // Remove handbook
    $removeResponse = $this->actingAs($admin)->putJson("/admin/api/conferences/{$event->id}", [
        'title' => '49th National Physics Conference',
        'status' => 'published',
        'removeHandbook' => 'true',
    ]);

    $removeResponse->assertOk();
    expect($event->fresh()->handbook_file)->toBeNull();
    Storage::disk('public')->assertMissing('conferences/handbooks/initial.pdf');
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
