<?php

use App\Models\User;

test('home page can be rendered via / and index.html', function (string $url) {
    $response = $this->get($url);

    $response->assertOk()
        ->assertSee('Samahang Pisika ng Pilipinas')
        ->assertSee('News and Announcements')
        ->assertSee('Activities');
})->with(['/', '/index.html']);

test('news page can be rendered via /news and news.html', function (string $url) {
    $response = $this->get($url);

    $response->assertOk()
        ->assertSee('News | Samahang Pisika ng Pilipinas')
        ->assertSee('article-root');
})->with(['/news', '/news.html']);

test('spp conference page can be rendered via /spp and spp.html', function (string $url) {
    $response = $this->get($url);

    $response->assertOk()
        ->assertSee('SPP | Samahang Pisika ng Pilipinas')
        ->assertSee('Conference year choices');
})->with(['/spp', '/spp.html']);

test('admin dashboard can be rendered via /admin and AdminDashboard.html', function (string $url) {
    $response = $this->get($url);

    $response->assertOk()
        ->assertSee('SPP Admin Dashboard')
        ->assertSee('News Management')
        ->assertSee('Activities Management')
        ->assertSee('SPP Conferences');
})->with(['/admin', '/AdminDashboard.html']);

test('authenticated users can access dashboard and view admin panels', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertOk()
        ->assertSee('SPP Admin Dashboard')
        ->assertSee('News Management')
        ->assertSee('Activities Management')
        ->assertSee('SPP Conferences');
});
