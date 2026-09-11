<?php

use App\Models\DownloadCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('local');
    config()->set('filesystems.private', 'local');
    $this->actingAs(User::factory()->create(['role' => 'admin']));
});

test('admin can create a category and post a published download', function () {
    $category = DownloadCategory::create(['name' => 'Conference Handbooks']);

    $response = $this->post(route('admin.api.downloads.store'), [
        'download_category_id' => $category->id,
        'year' => 2026,
        'status' => 'published',
        'file' => UploadedFile::fake()->create('handbook.pdf', 100, 'application/pdf'),
    ]);

    $response->assertCreated()
        ->assertJsonPath('data.title', 'handbook')
        ->assertJsonPath('data.status', 'published');

    $this->assertDatabaseHas('downloads', [
        'download_category_id' => $category->id,
        'category' => 'Conference Handbooks',
        'title' => 'handbook',
    ]);
});

test('public downloads modal omits drafts and balances categories by document count', function () {
    $first = DownloadCategory::create(['name' => 'First']);
    $second = DownloadCategory::create(['name' => 'Second']);
    $third = DownloadCategory::create(['name' => 'Third']);
    $fourth = DownloadCategory::create(['name' => 'Fourth']);

    foreach ([$first, $first, $second, $third] as $category) {
        $category->downloads()->create([
            'category' => $category->name,
            'title' => 'Published document',
            'year' => 2026,
            'file_url' => 'downloads/document.pdf',
            'file_name' => 'document.pdf',
            'status' => 'published',
        ]);
    }
    $fourth->downloads()->create([
        'category' => 'Fourth',
        'title' => 'Draft document',
        'year' => 2026,
        'file_url' => 'downloads/draft.pdf',
        'file_name' => 'draft.pdf',
        'status' => 'draft',
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('First')
        ->assertSee('Fourth')
        ->assertDontSee('Draft document');
});

test('admin can save the proceedings template shown above public downloads', function () {
    $response = $this->postJson(route('admin.api.proceedings-template.update'), [
        'title' => 'Proceedings Template',
        'image' => 'https://example.com/template.png',
        'first_label' => 'Download Template',
        'first_url' => 'https://example.com/template.docx',
        'second_label' => 'Submission Guide',
        'second_url' => 'https://example.com/guide.pdf',
    ]);

    $response->assertSuccessful()
        ->assertJsonPath('data.title', 'Proceedings Template');

    $this->assertDatabaseHas('proceedings_templates', ['first_label' => 'Download Template']);

    $this->get(route('home'))
        ->assertSee('Proceedings Template')
        ->assertSee('Download Template')
        ->assertSee('Submission Guide');
});
