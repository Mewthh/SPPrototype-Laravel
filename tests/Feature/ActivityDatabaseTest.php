<?php

use App\Models\Activity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($this->admin);
});

test('admin can retrieve activity list and status counts from database', function () {
    Activity::factory()->create([
        'title' => 'SPP Annual Conference',
        'slug' => 'spp-annual-conference',
        'status' => 'published',
    ]);

    Activity::factory()->create([
        'title' => 'Draft Workshop',
        'slug' => 'draft-workshop',
        'status' => 'draft',
    ]);

    $response = $this->getJson(route('admin.api.activities.index'));

    $response->assertSuccessful()
        ->assertJsonPath('counts.all', 2)
        ->assertJsonPath('counts.published', 1)
        ->assertJsonPath('counts.draft', 1)
        ->assertJsonFragment(['title' => 'SPP Annual Conference']);
});

test('admin can create a new activity in database', function () {
    $payload = [
        'title' => 'Physics Colloquium 2026',
        'summary' => 'Annual colloquium bringing together physicists.',
        'body' => 'Detailed description of the event program and speakers.',
        'status' => 'published',
        'location' => 'Manila, Philippines',
    ];

    $response = $this->postJson(route('admin.api.activities.store'), $payload);

    $response->assertCreated()
        ->assertJsonPath('data.title', 'Physics Colloquium 2026')
        ->assertJsonPath('data.slug', 'physics-colloquium-2026')
        ->assertJsonPath('data.status', 'published');

    $this->assertDatabaseHas('activities', [
        'title' => 'Physics Colloquium 2026',
        'slug' => 'physics-colloquium-2026',
        'status' => 'published',
    ]);
});

test('admin can update an existing activity in database', function () {
    $activity = Activity::factory()->create([
        'title' => 'Old Activity Title',
        'slug' => 'old-activity-title',
        'status' => 'draft',
    ]);

    $response = $this->putJson(route('admin.api.activities.update', $activity), [
        'title' => 'Updated Activity Title',
        'status' => 'published',
    ]);

    $response->assertSuccessful()
        ->assertJsonPath('data.title', 'Updated Activity Title')
        ->assertJsonPath('data.status', 'published');

    $this->assertDatabaseHas('activities', [
        'id' => $activity->id,
        'title' => 'Updated Activity Title',
        'status' => 'published',
    ]);
});

test('admin can delete an activity from database', function () {
    $activity = Activity::factory()->create([
        'slug' => 'delete-me-activity',
        'status' => 'draft',
    ]);

    $this->assertDatabaseHas('activities', ['id' => $activity->id]);

    $response = $this->deleteJson(route('admin.api.activities.destroy', $activity));

    $response->assertSuccessful()
        ->assertJsonFragment(['message' => 'Activity deleted successfully.']);

    $this->assertDatabaseMissing('activities', ['id' => $activity->id]);
});

test('admin can quickly change activity status', function () {
    $activity = Activity::factory()->create([
        'slug' => 'status-change-activity',
        'status' => 'draft',
    ]);

    $response = $this->patchJson(route('admin.api.activities.status', $activity), [
        'status' => 'published',
    ]);

    $response->assertSuccessful()
        ->assertJsonPath('data.status', 'published');

    $this->assertDatabaseHas('activities', [
        'id' => $activity->id,
        'status' => 'published',
    ]);
});

test('admin can filter activities by status', function () {
    Activity::factory()->create(['status' => 'published', 'slug' => 'pub-1']);
    Activity::factory()->create(['status' => 'published', 'slug' => 'pub-2']);
    Activity::factory()->create(['status' => 'draft', 'slug' => 'draft-1']);

    $response = $this->getJson(route('admin.api.activities.index', ['status' => 'published']));

    $response->assertSuccessful();
    expect($response->json('data'))->toHaveCount(2);
    expect($response->json('counts.all'))->toBe(3);
});

test('published activities appear on the homepage', function () {
    Activity::factory()->create([
        'title' => 'Visible Activity',
        'slug' => 'visible-activity',
        'status' => 'published',
    ]);

    Activity::factory()->create([
        'title' => 'Hidden Draft Activity',
        'slug' => 'hidden-draft-activity',
        'status' => 'draft',
    ]);

    $response = $this->get(route('home'));

    $response->assertSuccessful()
        ->assertSee('Visible Activity')
        ->assertDontSee('Hidden Draft Activity');
});

test('scheduled activities are hidden until their publish date and time', function () {
    $this->travelTo('2026-09-24 12:00:00');

    Activity::factory()->create([
        'title' => 'Future Scheduled Event',
        'slug' => 'future-scheduled-event',
        'status' => 'scheduled',
        'published_at' => '2026-09-25 12:00:00',
    ]);

    $response = $this->get(route('home'));

    $response->assertSuccessful()
        ->assertDontSee('Future Scheduled Event');
});

test('scheduled activities are visible on and after their publish date and time', function () {
    $this->travelTo('2026-09-24 12:00:00');

    Activity::factory()->create([
        'title' => 'Ready Scheduled Event',
        'slug' => 'ready-scheduled-event',
        'status' => 'scheduled',
        'published_at' => '2026-09-24 12:00:00',
    ]);

    $response = $this->get(route('activities.show', ['slug' => 'ready-scheduled-event']));

    $response->assertSee('Ready Scheduled Event');
});

test('admin cannot schedule an activity without a publish date and time', function () {
    $response = $this->postJson(route('admin.api.activities.store'), [
        'title' => 'Incomplete Scheduled Event',
        'status' => 'scheduled',
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors('published_at');
});

test('admin sets the publish time when publishing an activity immediately', function () {
    $this->travelTo('2026-09-24 12:00:00');

    $response = $this->postJson(route('admin.api.activities.store'), [
        'title' => 'Immediate Activity',
        'status' => 'published',
        'published_at' => '2026-10-01 12:00:00',
    ]);

    $response->assertCreated();

    $this->assertDatabaseHas('activities', [
        'title' => 'Immediate Activity',
        'published_at' => '2026-09-24 12:00:00',
    ]);
});

test('publishing a scheduled activity immediately replaces its scheduled publish time', function () {
    $this->travelTo('2026-09-24 12:00:00');

    $activity = Activity::factory()->create([
        'status' => 'scheduled',
        'published_at' => '2026-10-01 12:00:00',
    ]);

    $response = $this->patchJson(route('admin.api.activities.status', $activity), ['status' => 'published']);

    $response->assertSuccessful();

    $this->assertDatabaseHas('activities', [
        'id' => $activity->id,
        'status' => 'published',
        'published_at' => '2026-09-24 12:00:00',
    ]);
});

test('archived activities do not appear on the homepage', function () {
    Activity::factory()->create([
        'title' => 'Old Archived Event',
        'slug' => 'old-archived-event',
        'status' => 'archived',
    ]);

    $response = $this->get(route('home'));

    $response->assertSuccessful()
        ->assertDontSee('Old Archived Event');
});

test('activity slug is unique and auto-generated on duplicate title', function () {
    Activity::factory()->create([
        'title' => 'Repeat Title',
        'slug' => 'repeat-title',
        'status' => 'published',
    ]);

    $response = $this->postJson(route('admin.api.activities.store'), [
        'title' => 'Repeat Title',
        'status' => 'draft',
    ]);

    $response->assertCreated();
    $slug = $response->json('data.slug');
    expect($slug)->not->toBe('repeat-title');
    expect($slug)->toStartWith('repeat-title-');
});

test('activity summary and description are stored correctly', function () {
    $response = $this->postJson(route('admin.api.activities.store'), [
        'title' => 'Summary Test Activity',
        'summary' => 'A short summary of the activity.',
        'body' => 'The full description body with all details.',
        'status' => 'draft',
    ]);

    $response->assertCreated();

    $this->assertDatabaseHas('activities', [
        'title' => 'Summary Test Activity',
        'summary' => 'A short summary of the activity.',
        'description' => 'The full description body with all details.',
    ]);
});

test('public user can view single activity detail page', function () {
    $activity = Activity::factory()->create([
        'title' => 'Annual SPP Physics Congress',
        'slug' => 'annual-spp-physics-congress',
        'summary' => 'Join physicists from across the country.',
        'description' => 'Full event breakdown, plenary speakers, and workshop schedules.',
        'status' => 'published',
        'location' => 'Diliman, Quezon City',
    ]);

    $response = $this->get(route('activities.show', $activity->slug));

    $response->assertSuccessful()
        ->assertSee('Annual SPP Physics Congress')
        ->assertSee('Diliman, Quezon City')
        ->assertSee('Full event breakdown, plenary speakers, and workshop schedules.');
});

test('activities index without query redirects to home activities section', function () {
    $response = $this->get(route('activities.index'));

    $response->assertRedirect(route('home').'#activities');
});

test('activity card renders Read More link on homepage', function () {
    Activity::factory()->create([
        'title' => 'Read More Test Activity',
        'slug' => 'read-more-test-activity',
        'status' => 'published',
    ]);

    $response = $this->get(route('home'));

    $response->assertSuccessful()
        ->assertSee('Read More Test Activity')
        ->assertSee('Read More &rarr;', false)
        ->assertSee(route('activities.show', 'read-more-test-activity'));
});
