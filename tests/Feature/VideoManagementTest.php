<?php

use App\Models\User;
use App\Models\Video;

test('public videos page displays only published video resources', function () {
    Video::factory()->create([
        'title' => 'Published recording',
        'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'status' => 'published',
        'published_at' => now()->subDay(),
    ]);
    Video::factory()->create([
        'title' => 'Draft video',
        'status' => 'draft',
        'published_at' => now()->subDay(),
    ]);

    $this->get(route('videos.index'))
        ->assertOk()
        ->assertSee('Published recording')
        ->assertSee('https://i.ytimg.com/vi/dQw4w9WgXcQ/hqdefault.jpg')
        ->assertDontSee('Draft video');
});

test('administrators can create a video resource', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->postJson(route('admin.api.videos.store'), [
            'title' => 'Physics Teaching Recording',
            'video_url' => 'https://www.youtube.com/watch?v=abc123',
            'published_at' => '2026-09-17',
            'status' => 'published',
        ])
        ->assertCreated()
        ->assertJsonPath('data.title', 'Physics Teaching Recording');

    $this->assertDatabaseHas('videos', [
        'title' => 'Physics Teaching Recording',
        'status' => 'published',
    ]);
});

test('video resource creation rejects a non-YouTube recording URL', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->postJson(route('admin.api.videos.store'), [
            'title' => 'Invalid resource',
            'video_url' => 'https://example.com/recording',
            'status' => 'draft',
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['video_url'])
        ->assertJsonPath('errors.video_url.0', 'Please enter a valid YouTube video link.');

    $this->assertDatabaseMissing('videos', ['title' => 'Invalid resource']);
});

test('non-admin users cannot manage video resources', function () {
    $user = User::factory()->create(['role' => 'user']);

    $this->actingAs($user)
        ->getJson(route('admin.api.videos.index'))
        ->assertForbidden();
});
