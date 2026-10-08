<?php

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('portal announcements page displays empty state when no announcements exist', function () {
    $response = $this->get(route('membership-portal.announcements'));

    $response->assertOk()
        ->assertSee('No announcements yet')
        ->assertDontSee('Annual Conference 2025 – Registration Now Open')
        ->assertDontSee('Membership Renewal for 2026');
});

test('portal announcements page displays published announcements with audience badges and no summary', function () {
    $announcement = Announcement::factory()->create([
        'title' => 'Important General Assembly',
        'target_audience' => 'regular',
        'summary' => 'Details regarding upcoming assembly.',
        'content' => 'Full text content of the assembly announcement.',
        'status' => 'published',
    ]);

    $draftAnnouncement = Announcement::factory()->draft()->create([
        'title' => 'Draft Secret Meeting',
    ]);

    $response = $this->get(route('membership-portal.announcements'));

    $response->assertOk()
        ->assertSee('Important General Assembly')
        ->assertSee('Regular Members Only')
        ->assertSee('Full text content of the assembly announcement.')
        ->assertDontSee('Details regarding upcoming assembly.')
        ->assertDontSee('Draft Secret Meeting');

    // Verify summary is displayed in portal notifications
    $notifResponse = $this->get(route('membership-portal.notifications'));
    $notifResponse->assertOk()
        ->assertSee('Important General Assembly')
        ->assertSee('Details regarding upcoming assembly.');
});

test('admin can list, create, update, and delete announcements via api', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    // Index
    $response = $this->actingAs($admin)->getJson(route('admin.api.announcements.index'));
    $response->assertOk()
        ->assertJson([
            'data' => [],
            'counts' => [
                'all' => 0,
                'published' => 0,
                'draft' => 0,
                'archived' => 0,
            ],
        ]);

    // Store
    $storeResponse = $this->actingAs($admin)->postJson(route('admin.api.announcements.store'), [
        'title' => 'New Physics Workshop',
        'target_audience' => 'associate',
        'summary' => 'Workshop for associate members',
        'content' => 'Detailed curriculum for the workshop.',
        'status' => 'published',
    ]);

    $storeResponse->assertCreated()
        ->assertJsonPath('data.title', 'New Physics Workshop')
        ->assertJsonPath('data.target_audience', 'associate');

    $this->assertDatabaseHas('announcements', [
        'title' => 'New Physics Workshop',
        'target_audience' => 'associate',
        'status' => 'published',
    ]);

    $announcement = Announcement::where('title', 'New Physics Workshop')->first();

    // Show
    $this->actingAs($admin)
        ->getJson(route('admin.api.announcements.show', $announcement))
        ->assertOk()
        ->assertJsonPath('data.id', $announcement->id);

    // Update
    $updateResponse = $this->actingAs($admin)->putJson(route('admin.api.announcements.update', $announcement), [
        'title' => 'Updated Physics Workshop',
        'target_audience' => 'institutional',
        'summary' => 'Updated summary for institutions',
        'content' => 'Updated curriculum content.',
        'status' => 'published',
    ]);

    $updateResponse->assertOk()
        ->assertJsonPath('data.title', 'Updated Physics Workshop')
        ->assertJsonPath('data.target_audience', 'institutional');

    $this->assertDatabaseHas('announcements', [
        'id' => $announcement->id,
        'title' => 'Updated Physics Workshop',
        'target_audience' => 'institutional',
    ]);

    // Update status
    $this->actingAs($admin)->patchJson(route('admin.api.announcements.status', $announcement), [
        'status' => 'draft',
    ])->assertOk()
        ->assertJsonPath('data.status', 'draft');

    $this->assertDatabaseHas('announcements', [
        'id' => $announcement->id,
        'status' => 'draft',
    ]);

    // Destroy
    $this->actingAs($admin)->deleteJson(route('admin.api.announcements.destroy', $announcement))
        ->assertOk();

    $this->assertDatabaseMissing('announcements', [
        'id' => $announcement->id,
    ]);
});

test('unauthenticated users cannot manage announcements via api', function () {
    $this->getJson(route('admin.api.announcements.index'))
        ->assertUnauthorized();

    $this->postJson(route('admin.api.announcements.store'), [
        'title' => 'Unauthorized Post',
        'target_audience' => 'all',
        'content' => 'Content',
        'status' => 'published',
    ])->assertUnauthorized();
});

test('admin membership portal page renders dynamic announcements data', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    Announcement::factory()->create([
        'title' => 'Admin Visible Post',
        'target_audience' => 'regular',
        'status' => 'published',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.membership-portal'));

    $response->assertOk()
        ->assertSee('Admin Visible Post')
        ->assertSee('Regular Members Only');
});
