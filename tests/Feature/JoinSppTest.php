<?php

test('public users can visit the join spp prototype route without authentication', function () {
    $response = $this->get(route('join-spp'));

    $response->assertOk()
        ->assertSee('Join SPP Membership')
        ->assertSee('Recommender')
        ->assertSee('Member Information')
        ->assertSee('Documents')
        ->assertSee('Validation / Certification')
        ->assertSee('Account Setup')
        ->assertSee('Review &amp; Submit', false)
        ->assertSee('Submit')
        ->assertSee('Login');
});

test('join spp page displays all required question fields and placeholders', function () {
    $response = $this->get(route('join-spp'));

    $response->assertOk()
        // Notices
        ->assertSee('This is an online version of SPP Membership')
        ->assertSee('Membership fee is incorporated (waived) into the Conference Fee')
        // Removal of Membership Category choice
        ->assertDontSee('Choose Membership Category')
        // Stage 1: Recommender & Primary Email
        ->assertSee('Stage 1: Recommender Details')
        ->assertSee('primary_email')
        ->assertSee('Primary Recommender')
        ->assertSee('recommender_surname')
        ->assertSee('recommender_first_name')
        ->assertSee('Alternate Recommender (alt1)')
        ->assertSee('recommender_email')
        // Stage 2: Member Info
        ->assertSee('Stage 2: Member Information')
        ->assertSee('Current Institutional Affiliation')
        ->assertSee('Highest completed educational attainment (Degree)')
        ->assertSee('Sample Institution')
        ->assertDontSee('personal_email')
        // Stage 3: Documents
        ->assertSee('Stage 3: Documents')
        ->assertSee('Updated Curriculum Vitae (CV)')
        ->assertSee('Proof of Employment or Enrollment')
        // Stage 4: Validation / Certification
        ->assertSee('Stage 4: VALIDATION &amp; CERTIFICATION', false)
        ->assertSee('VALIDATION')
        ->assertSee('Declaration: Agree')
        ->assertSee('CERTIFICATION')
        ->assertSee('certification_email')
        // Stage 5: Account Setup
        ->assertSee('Stage 5: Account Setup')
        ->assertSee('Account Email Address')
        // Stage 6: Review & Submit
        ->assertSee('Stage 6: Review &amp; Submit', false)
        ->assertSee('Portal Account Credentials');
});

test('main website join spp buttons remain unconnected to new prototype route', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        // Public header Join SPP still points to membership-faq as specified in hard scope
        ->assertSee(route('membership-faq'))
        ->assertDontSee(route('join-spp'));
});
