<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('first visitor can register and is saved in database as admin', function () {
    expect(User::count())->toBe(0);

    $response = $this->post(route('register.store'), [
        'name' => 'Main Admin',
        'email' => 'admin@spp-online.org',
        'password' => 'SecurePass123!',
        'password_confirmation' => 'SecurePass123!',
    ]);

    $response->assertRedirect(route('dashboard'));

    $user = User::where('email', 'admin@spp-online.org')->first();
    expect($user)->not->toBeNull()
        ->and($user->name)->toBe('Main Admin')
        ->and($user->role)->toBe('admin')
        ->and($user->isAdmin())->toBeTrue();

    $this->assertAuthenticatedAs($user);
});

test('subsequent registrations are blocked once an admin already exists', function () {
    User::factory()->create([
        'email' => 'firstadmin@spp-online.org',
        'role' => 'admin',
    ]);

    expect(User::where('role', 'admin')->count())->toBe(1);

    $response = $this->post(route('register.store'), [
        'name' => 'Second Admin Attempt',
        'email' => 'second@spp-online.org',
        'password' => 'AnotherPass123!',
        'password_confirmation' => 'AnotherPass123!',
    ]);

    // Aborts with 403 Forbidden
    $response->assertForbidden();

    expect(User::where('email', 'second@spp-online.org')->exists())->toBeFalse();
});

test('unauthenticated guests are redirected to login when accessing admin dashboard', function () {
    $response = $this->get(route('admin'));
    $response->assertRedirect(route('login'));

    $responseApi = $this->getJson(route('admin.api.news.index'));
    $responseApi->assertStatus(401);
});

test('regular non-admin users cannot access admin dashboard or admin apis', function () {
    $regularUser = User::factory()->create([
        'email' => 'member@spp-online.org',
        'role' => 'user',
    ]);

    $response = $this->actingAs($regularUser)->get(route('admin'));
    $response->assertForbidden();

    $responseApi = $this->actingAs($regularUser)->getJson(route('admin.api.news.index'));
    $responseApi->assertForbidden();
});

test('registered admin can log in and view dashboard', function () {
    $admin = User::factory()->create([
        'email' => 'registeredadmin@spp-online.org',
        'password' => bcrypt('AdminPassword123!'),
        'role' => 'admin',
    ]);

    $loginRes = $this->post(route('login.store'), [
        'email' => 'registeredadmin@spp-online.org',
        'password' => 'AdminPassword123!',
    ]);

    $loginRes->assertRedirect(route('dashboard'));
    $this->assertAuthenticatedAs($admin);

    $dashRes = $this->actingAs($admin)->get(route('admin'));
    $dashRes->assertOk();
    $dashRes->assertSee('SPP Admin');
    $dashRes->assertSee($admin->name);
});
