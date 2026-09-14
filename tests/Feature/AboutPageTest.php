<?php

use App\Models\AboutPage;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('the public about page shows the official default SPP details', function () {
    $response = $this->get(route('about.show'));

    $response->assertOk()
        ->assertSee('About SPP')
        ->assertSee('National Council 2026')
        ->assertSee('Darwin Putungan, Ph.D.')
        ->assertSee('hq@spp-online.org');

    expect(AboutPage::query()->exists())->toBeTrue();
});

test('admins can update the about SPP page', function () {
    Storage::fake('public');
    $admin = User::factory()->create(['role' => 'admin']);
    $aboutPage = AboutPage::query()->create(AboutPage::defaultAttributes());

    $payload = $aboutPage->only([
        'title',
        'introduction',
        'council_heading',
        'officers',
        'councilors',
        'address',
        'email',
    ]);
    $payload['title'] = 'About the SPP';
    $payload['email'] = 'contact@spp-online.org';
    $payload['image'] = UploadedFile::fake()->image('about-spp.jpg');

    $response = $this->actingAs($admin)->put(route('admin.about.update'), $payload);

    $response->assertRedirect(route('dashboard').'#about-section');

    $this->assertDatabaseHas('about_pages', [
        'id' => $aboutPage->id,
        'title' => 'About the SPP',
        'email' => 'contact@spp-online.org',
    ]);

    expect($aboutPage->fresh()->image)->toStartWith('about/');
});

test('non-admin users cannot edit the about SPP page', function () {
    $user = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($user)->get(route('admin.about.edit'));

    $response->assertForbidden();
});

test('admins can add and remove councilors', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $aboutPage = AboutPage::query()->create(AboutPage::defaultAttributes());
    $payload = $aboutPage->only([
        'title',
        'introduction',
        'council_heading',
        'officers',
        'councilors',
        'address',
        'email',
    ]);
    $payload['councilors'][] = [
        'name' => 'New Councilor, Ph.D.',
        'institution' => 'SPP Partner University',
    ];

    $this->actingAs($admin)->put(route('admin.about.update'), $payload)->assertRedirect();

    expect($aboutPage->fresh()->councilors)->toContain([
        'name' => 'New Councilor, Ph.D.',
        'institution' => 'SPP Partner University',
    ]);

    $payload['councilors'] = [];
    $this->actingAs($admin)->put(route('admin.about.update'), $payload)->assertRedirect();

    expect($aboutPage->fresh()->councilors)->toBe([]);
});

test('the old about editor URL opens the dashboard about section', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get(route('admin.about.edit'));

    $response->assertRedirect(route('dashboard').'#about-section');
});
