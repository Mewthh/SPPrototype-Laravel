<?php

use App\Models\MembershipInquiry;
use App\Models\User;

test('portal inquiries page loads successfully and displays inquiry history', function () {
    $response = $this->get(route('membership-portal.inquiries'));

    $response->assertOk()
        ->assertSee('Inquiry History')
        ->assertSee('Submit Inquiry')
        ->assertSee('Show more')
        ->assertSee('Show less');
});

test('submitting inquiry via portal stores record and returns success', function () {
    $response = $this->postJson(route('membership-portal.inquiries.store'), [
        'query_type' => 'membership_status',
        'last_known_membership' => 'Regular member',
        'status_last_attendance_year' => '2023',
        'status_last_attendance_place' => 'Tagbilaran City',
        'status_remarks' => 'Looking to verify regular membership status.',
    ]);

    $response->assertOk()
        ->assertJsonPath('success', true);

    $this->assertDatabaseHas('membership_inquiries', [
        'query_type' => 'Membership Status',
        'last_known_membership' => 'Regular member',
        'last_attendance_year' => '2023',
        'status' => 'Submitted',
    ]);
});

test('submitting inquiry requires appropriate fields per query type', function () {
    // Missing last_known_membership for membership_status
    $statusResponse = $this->postJson(route('membership-portal.inquiries.store'), [
        'query_type' => 'membership_status',
    ]);
    $statusResponse->assertUnprocessable()
        ->assertJsonValidationErrors(['last_known_membership']);

    // Missing other_keywords for other
    $otherResponse = $this->postJson(route('membership-portal.inquiries.store'), [
        'query_type' => 'other',
    ]);
    $otherResponse->assertUnprocessable()
        ->assertJsonValidationErrors(['other_keywords']);
});

test('admin can view inquiries in portal manager with counts and show more / show less', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $inquiry = MembershipInquiry::factory()->create([
        'inquirer_name' => 'Dr. Marie Curie',
        'query_type' => 'Membership Status',
        'status' => 'Submitted',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.membership-portal'));

    $response->assertOk()
        ->assertSee('Dr. Marie Curie')
        ->assertSee('Member Support &amp; Inquiries', false)
        ->assertSee('Show more')
        ->assertSee('Show less');
});

test('admin can update inquiry status and response via api', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $inquiry = MembershipInquiry::factory()->create([
        'status' => 'Submitted',
        'admin_response' => null,
    ]);

    $response = $this->actingAs($admin)->patchJson(
        route('admin.api.inquiries.status', $inquiry),
        [
            'status' => 'Responded',
            'admin_response' => 'Your certificate has been validated and issued.',
        ]
    );

    $response->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.status', 'Responded')
        ->assertJsonPath('data.admin_response', 'Your certificate has been validated and issued.');

    $this->assertDatabaseHas('membership_inquiries', [
        'id' => $inquiry->id,
        'status' => 'Responded',
        'admin_response' => 'Your certificate has been validated and issued.',
    ]);
});

test('guests cannot update inquiry status via admin api', function () {
    $inquiry = MembershipInquiry::factory()->create();

    $response = $this->patchJson(
        route('admin.api.inquiries.status', $inquiry),
        ['status' => 'Responded']
    );

    $response->assertUnauthorized();
});
