<?php

use App\Models\User;

test('home page can be rendered via /', function () {
    $response = $this->get('/');

    $response->assertOk()
        ->assertSee('Samahang Pisika ng Pilipinas')
        ->assertSee('News and Announcements')
        ->assertSee('Activities');
});

test('legacy index.html redirects to /', function () {
    $response = $this->get('/index.html');

    $response->assertRedirect('/');
});

test('news page redirects to home #news when no slug is given', function () {
    $response = $this->get('/news');

    $response->assertRedirect(route('home').'#news');
});

test('legacy news.html redirects to /news', function () {
    $response = $this->get('/news.html');

    $response->assertRedirect('/news');
});

test('spp conference page can be rendered via /spp', function () {
    $response = $this->get('/spp');

    $response->assertOk()
        ->assertSee('SPP | Samahang Pisika ng Pilipinas')
        ->assertSee('Conference year choices');
});

test('legacy spp.html redirects to /spp', function () {
    $response = $this->get('/spp.html');

    $response->assertRedirect('/spp');
});

test('admin dashboard can be rendered via /admin by authenticated admin', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get('/admin');

    $response->assertOk()
        ->assertSee('SPP Admin Dashboard')
        ->assertSee('News Management')
        ->assertSee('Activities Management')
        ->assertSee('SPP Conferences');
});

test('legacy AdminDashboard.html redirects to /admin', function () {
    $response = $this->get('/AdminDashboard.html');

    $response->assertRedirect('/admin');
});

test('authenticated admin users can access dashboard and view admin panels', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get(route('dashboard'));

    $response->assertOk()
        ->assertSee('SPP Admin Dashboard')
        ->assertSee('News Management')
        ->assertSee('Activities Management')
        ->assertSee('SPP Conferences');
});
