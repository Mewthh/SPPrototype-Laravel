<?php

test('public users can visit the join spp prototype route without authentication', function () {
    $response = $this->get(route('join-spp'));

    $response->assertOk()
        ->assertSee('Join SPP Membership')
        ->assertSee('Membership Type')
        ->assertSee('Recommender')
        ->assertSee('Member Information')
        ->assertSee('Documents')
        ->assertSee('Validation / Certification')
        ->assertSee('Account Setup')
        ->assertSee('Review &amp; Submit', false)
        ->assertSee('Submit Application')
        ->assertSee('Log In to Portal Dashboard');
});

test('join spp page displays all required question fields and placeholders', function () {
    $response = $this->get(route('join-spp'));

    $response->assertOk()
        // Stage 1
        ->assertSee('Regular Member')
        ->assertSee('Associate Member')
        ->assertSee('Institutional Member')
        ->assertSee(now()->format('m/d/Y'))
        ->assertSee('MM/DD/YYYY')
        // Stage 2
        ->assertSee('Primary Recommender')
        ->assertSee('Alternate Recommender')
        ->assertSee('recommender_email')
        // Stage 3
        ->assertSee('Current Institutional Affiliation')
        ->assertSee('Highest Educational Attainment')
        ->assertSee('Sample Institution')
        // Stage 4
        ->assertSee('Updated Curriculum Vitae (CV)')
        ->assertSee('Proof of Employment / Enrollment')
        // Stage 5
        ->assertSee('Declaration: Agreed')
        ->assertSee('Certification: Confirmed')
        // Stage 6 (Account Setup after Validation)
        ->assertSee('Stage 6: Account Setup')
        ->assertSee('Account Email Address')
        // Stage 7 (Review & Submit)
        ->assertSee('Stage 7: Review &amp; Submit', false)
        ->assertSee('Portal Account Credentials');
});

test('main website join spp buttons remain unconnected to new prototype route', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        // Public header Join SPP still points to membership-faq as specified in hard scope
        ->assertSee(route('membership-faq'))
        ->assertDontSee(route('join-spp'));
});
