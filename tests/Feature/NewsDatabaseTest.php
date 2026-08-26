<?php

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can retrieve news list and status counts from database', function () {
    News::factory()->create([
        'title' => 'First Published News',
        'slug' => 'first-published-news',
        'status' => 'published',
    ]);

    News::factory()->create([
        'title' => 'Draft News',
        'slug' => 'draft-news',
        'status' => 'draft',
    ]);

    $response = $this->getJson(route('admin.api.news.index'));

    $response->assertSuccessful()
        ->assertJsonPath('counts.all', 2)
        ->assertJsonPath('counts.published', 1)
        ->assertJsonPath('counts.draft', 1)
        ->assertJsonFragment(['title' => 'First Published News']);
});

test('admin can create a new news post in database', function () {
    $payload = [
        'title' => 'New Breakthrough in Quantum Physics',
        'summary' => 'Researchers discovered a new particle state.',
        'body' => 'Full article text detailing the quantum physics experiment and methodology.',
        'status' => 'published',
        'publishDate' => '2026-08-26',
    ];

    $response = $this->postJson(route('admin.api.news.store'), $payload);

    $response->assertCreated()
        ->assertJsonPath('data.title', 'New Breakthrough in Quantum Physics')
        ->assertJsonPath('data.slug', 'new-breakthrough-in-quantum-physics')
        ->assertJsonPath('data.status', 'published');

    $this->assertDatabaseHas('news', [
        'title' => 'New Breakthrough in Quantum Physics',
        'slug' => 'new-breakthrough-in-quantum-physics',
        'status' => 'published',
    ]);
});

test('admin can update an existing news post in database', function () {
    $news = News::factory()->create([
        'title' => 'Old Title',
        'slug' => 'old-title',
        'content' => 'Old content',
        'status' => 'draft',
    ]);

    $updatePayload = [
        'title' => 'Updated Physics Title',
        'body' => 'Updated content body',
        'status' => 'published',
    ];

    $response = $this->putJson(route('admin.api.news.update', $news), $updatePayload);

    $response->assertSuccessful()
        ->assertJsonPath('data.title', 'Updated Physics Title')
        ->assertJsonPath('data.slug', 'updated-physics-title')
        ->assertJsonPath('data.status', 'published');

    $this->assertDatabaseHas('news', [
        'id' => $news->id,
        'title' => 'Updated Physics Title',
        'slug' => 'updated-physics-title',
        'status' => 'published',
    ]);
});

test('admin can delete a news post from database', function () {
    $news = News::factory()->create([
        'title' => 'To Be Deleted',
        'slug' => 'to-be-deleted',
    ]);

    $response = $this->deleteJson(route('admin.api.news.destroy', $news));

    $response->assertSuccessful()
        ->assertJsonPath('message', 'News post deleted successfully.');

    $this->assertDatabaseMissing('news', [
        'id' => $news->id,
    ]);
});

test('admin can quick update status of a news post', function () {
    $news = News::factory()->create([
        'status' => 'published',
    ]);

    $response = $this->patchJson(route('admin.api.news.status', $news), [
        'status' => 'archived',
    ]);

    $response->assertSuccessful()
        ->assertJsonPath('data.status', 'archived');

    $this->assertDatabaseHas('news', [
        'id' => $news->id,
        'status' => 'archived',
    ]);
});

test('public home page displays published news posts from database', function () {
    $publishedNews = News::factory()->create([
        'title' => 'Public Visible News Article',
        'slug' => 'public-visible-news-article',
        'excerpt' => 'This summary should be visible to public users.',
        'status' => 'published',
        'published_at' => now()->subDay(),
    ]);

    $draftNews = News::factory()->create([
        'title' => 'Secret Internal Draft News',
        'slug' => 'secret-internal-draft-news',
        'status' => 'draft',
    ]);

    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('Public Visible News Article')
        ->assertSee('This summary should be visible to public users.')
        ->assertDontSee('Secret Internal Draft News');
});

test('public news page displays news detail by slug parameter or route', function () {
    $news = News::factory()->create([
        'title' => 'Annual Physics Assembly 2026',
        'slug' => 'annual-physics-assembly-2026',
        'content' => "Paragraph 1 about assembly.\n\nParagraph 2 with details.",
        'status' => 'published',
        'published_at' => now()->subDay(),
    ]);

    // Test query parameter: /news?slug=...
    $responseParam = $this->get(route('news.index', ['slug' => $news->slug]));
    $responseParam->assertOk()
        ->assertSee('Annual Physics Assembly 2026')
        ->assertSee('Paragraph 1 about assembly.')
        ->assertSee('Paragraph 2 with details.');

    // Test route parameter: /news/...
    $responseRoute = $this->get(route('news.show', ['slug' => $news->slug]));
    $responseRoute->assertOk()
        ->assertSee('Annual Physics Assembly 2026')
        ->assertSee('Paragraph 1 about assembly.');
});

test('public news page displays article not found for drafts or missing articles', function () {
    $draftNews = News::factory()->create([
        'title' => 'Unpublished News Article',
        'slug' => 'unpublished-news-article',
        'status' => 'draft',
    ]);

    $responseDraft = $this->get(route('news.index', ['slug' => $draftNews->slug]));
    $responseDraft->assertOk()
        ->assertSee('Article Not Found')
        ->assertDontSee('Unpublished News Article');

    $responseMissing = $this->get(route('news.index', ['slug' => 'nonexistent-slug']));
    $responseMissing->assertOk()
        ->assertSee('Article Not Found');
});
