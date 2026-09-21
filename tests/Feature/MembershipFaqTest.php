<?php

use App\Models\MembershipFaq;
use App\Models\User;

test('public membership FAQ page displays only visible FAQs in their configured order', function () {
    MembershipFaq::factory()->create(['question' => 'Second visible question', 'is_visible' => true, 'sort_order' => 2]);
    MembershipFaq::factory()->create(['question' => 'Hidden question', 'is_visible' => false, 'sort_order' => 1]);
    MembershipFaq::factory()->create(['question' => 'First visible question', 'is_visible' => true, 'sort_order' => 1]);

    $this->get(route('membership-faq'))
        ->assertOk()
        ->assertSeeInOrder(['First visible question', 'Second visible question'])
        ->assertDontSee('Hidden question');
});

test('public membership FAQ page renders safe Markdown links in an answer', function () {
    MembershipFaq::factory()->create([
        'question' => 'Where can I read the constitution?',
        'answer' => 'Read the constitution [here](https://example.com/constitution).',
        'is_visible' => true,
        'sort_order' => 99,
    ]);

    $this->get(route('membership-faq'))
        ->assertOk()
        ->assertSee('href="https://example.com/constitution"', false)
        ->assertSee('here');
});

test('public membership FAQ page styles the membership application form as a button', function () {
    MembershipFaq::factory()->create([
        'question' => 'How do I apply?',
        'answer' => '[Membership Application Form](https://docs.google.com/forms/d/e/1FAIpQLSdO5VZ9uKaRC-mObDdPcipjsl1aBjWKIF9-H5tVs_C2EKifJQ/viewform)',
        'is_visible' => true,
        'sort_order' => 100,
    ]);

    $this->get(route('membership-faq'))
        ->assertOk()
        ->assertSee('Membership Application Form')
        ->assertSee('display: inline-flex', false);
});

test('public membership FAQ page displays membership inquiry form links', function () {
    MembershipFaq::factory()->create([
        'question' => 'How can I verify membership?',
        'answer' => 'Use the [Membership Inquiry form](https://docs.google.com/forms/d/e/1FAIpQLSexjHKcRXZk9Q6mq-AZj2fijUBVjzoUcsRi7VvONcxU5H4olQ/viewform).',
        'is_visible' => true,
        'sort_order' => 101,
    ]);

    $this->get(route('membership-faq'))
        ->assertOk()
        ->assertSee('Membership Inquiry form')
        ->assertSee('href="https://docs.google.com/forms/d/e/1FAIpQLSexjHKcRXZk9Q6mq-AZj2fijUBVjzoUcsRi7VvONcxU5H4olQ/viewform"', false);
});

test('administrators can update the Article II page linked from membership FAQs', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)->putJson(route('admin.api.membership-article.update'), [
        'title' => 'Article II — Membership',
        'content' => 'Membership rules are available [here](https://example.com/rules).',
    ])->assertOk();

    $this->get(route('membership-articles.show', 'article-ii'))
        ->assertOk()
        ->assertSee('Membership rules are available')
        ->assertSee('href="https://example.com/rules"', false);
});

test('administrators can create and update membership FAQs', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->postJson(route('admin.api.membership-faqs.store'), [
        'question' => 'How do I join?',
        'answer' => 'Complete the membership application form.',
        'is_visible' => true,
    ]);

    $response->assertCreated()->assertJsonPath('data.question', 'How do I join?');
    $faq = MembershipFaq::query()->where('question', 'How do I join?')->firstOrFail();

    $this->actingAs($admin)->patchJson(route('admin.api.membership-faqs.update', $faq), [
        'question' => 'How can I join?',
        'answer' => 'Complete the application form.',
        'is_visible' => false,
    ])->assertOk()->assertJsonPath('data.is_visible', false);

    $this->assertDatabaseHas('membership_faqs', ['id' => $faq->id, 'question' => 'How can I join?', 'is_visible' => false]);
});

test('membership FAQ management validates its required content and requires an administrator', function () {
    $this->postJson(route('admin.api.membership-faqs.store'), [])
        ->assertUnauthorized();

    $user = User::factory()->create(['role' => 'user']);
    $this->actingAs($user)->postJson(route('admin.api.membership-faqs.store'), [])
        ->assertForbidden();

    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin)->postJson(route('admin.api.membership-faqs.store'), ['question' => '', 'answer' => '', 'is_visible' => true])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['question', 'answer']);
});
