<?php

use App\Models\MembershipApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('join spp page renders cleanly with empty inputs and no temporary values', function () {
    $response = $this->get(route('join-spp'));

    $response->assertOk()
        ->assertDontSee('value="Sample"')
        ->assertDontSee('value="Sample Name"')
        ->assertDontSee('value="example@email.com"')
        ->assertDontSee('value="password123"');
});

test('guest can submit join-spp form and create member account and application', function () {
    Storage::fake('public');

    $cvFile = UploadedFile::fake()->create('curriculum_vitae.pdf', 500, 'application/pdf');
    $proofFile = UploadedFile::fake()->create('employment_certificate.pdf', 300, 'application/pdf');

    $postData = [
        'membership_type' => 'Regular Member',
        'application_type' => 'New Application',
        'application_date' => now()->format('m/d/Y'),
        'recommender_suffix' => 'Dr.',
        'recommender_surname' => 'Santos',
        'recommender_first_name' => 'Maria',
        'recommender_email' => 'msantos@physics.edu.ph',
        'alt_recommender_name' => 'Dr. Jose Rizal',
        'surname' => 'Dela Cruz',
        'first_name' => 'Juan',
        'middle_name' => 'Mercado',
        'mobile_number' => '0988-123-4567',
        'alt_mobile_number' => '+63 912 345 6789',
        'personal_email' => 'juan.delacruz@gmail.com',
        'current_affiliation' => 'National Institute of Physics',
        'current_position' => 'Associate Professor',
        'professional_email' => 'juan@nip.upd.edu.ph',
        'highest_educational_attainment' => 'Doctor of Philosophy (Ph.D.)',
        'degree' => 'Ph.D. in Physics',
        'date_degree_obtained' => 'June 2020',
        'institution' => 'University of the Philippines Diliman',
        'institution_address' => 'Quezon City, Philippines',
        'declaration_agree' => '1',
        'certification_confirm' => '1',
        'certification_email' => 'juan.delacruz@portal.ph',
        'account_email' => 'juan.delacruz@portal.ph',
        'account_password' => 'SecurePass123!',
        'account_password_confirmation' => 'SecurePass123!',
        'cv_file' => $cvFile,
        'proof_file' => $proofFile,
    ];

    $response = $this->postJson(route('join-spp.store'), $postData);

    $response->assertCreated()
        ->assertJson([
            'success' => true,
        ]);

    $this->assertDatabaseHas('users', [
        'email' => 'juan.delacruz@portal.ph',
        'name' => 'Juan Dela Cruz',
        'role' => 'member',
    ]);

    $this->assertDatabaseHas('membership_applications', [
        'account_email' => 'juan.delacruz@portal.ph',
        'surname' => 'Dela Cruz',
        'first_name' => 'Juan',
        'recommender_surname' => 'Santos',
        'recommender_first_name' => 'Maria',
        'recommender_name' => 'Maria Santos',
        'alt_mobile_number' => '+63 912 345 6789',
        'certification_email' => 'juan.delacruz@portal.ph',
        'membership_type' => 'Regular Member',
        'status' => 'Under Evaluation',
        'current_affiliation' => 'National Institute of Physics',
    ]);
});

test('admin can view applications and roster in portal manager', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $application = MembershipApplication::factory()->create([
        'surname' => 'Einstein',
        'first_name' => 'Albert',
        'membership_type' => 'Regular Member',
        'account_email' => 'albert@princeton.edu',
        'current_affiliation' => 'Institute for Advanced Study',
        'status' => 'Under Evaluation',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.membership-portal'));

    $response->assertOk()
        ->assertSee('Albert Einstein')
        ->assertSee('albert@princeton.edu')
        ->assertSee('Regular Member')
        ->assertSee('Under Evaluation');
});

test('admin can inspect application details and update status via api', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $application = MembershipApplication::factory()->create([
        'surname' => 'Curie',
        'first_name' => 'Marie',
        'account_email' => 'marie.curie@radium.org',
        'status' => 'Under Evaluation',
    ]);

    // Inspect via API
    $showResponse = $this->actingAs($admin)->getJson(route('admin.api.membership-applications.show', $application));

    $showResponse->assertOk()
        ->assertJsonPath('data.surname', 'Curie')
        ->assertJsonPath('data.first_name', 'Marie');

    // Update status to Approved
    $patchResponse = $this->actingAs($admin)->patchJson(
        route('admin.api.membership-applications.status', $application),
        ['status' => 'Approved']
    );

    $patchResponse->assertOk()
        ->assertJsonPath('data.status', 'Approved');

    $this->assertDatabaseHas('membership_applications', [
        'id' => $application->id,
        'status' => 'Approved',
    ]);

    // When status is Approved, member shows up in portal manager roster
    $portalResponse = $this->actingAs($admin)->get(route('admin.membership-portal'));
    $portalResponse->assertOk()
        ->assertSee('SPP-MEM-'.str_pad($application->id, 4, '0', STR_PAD_LEFT))
        ->assertSee('Marie Curie');
});

test('guests and regular members cannot manage applications via admin api', function () {
    $application = MembershipApplication::factory()->create();

    // Guest cannot fetch
    $this->getJson(route('admin.api.membership-applications.show', $application))
        ->assertUnauthorized();

    // Regular member cannot update
    $member = User::factory()->create(['role' => 'member']);

    $this->actingAs($member)->patchJson(
        route('admin.api.membership-applications.status', $application),
        ['status' => 'Approved']
    )->assertForbidden();
});

test('admin and owner can view attached cv and proof documents', function () {
    Storage::fake('public');

    $cvPath = 'applications/cv/sample_cv.pdf';
    $proofPath = 'applications/proofs/sample_proof.pdf';
    Storage::disk('public')->put($cvPath, '%PDF-1.4 sample cv content');
    Storage::disk('public')->put($proofPath, '%PDF-1.4 sample proof content');

    $applicantUser = User::factory()->create(['role' => 'member']);
    $application = MembershipApplication::factory()->create([
        'user_id' => $applicantUser->id,
        'cv_path' => $cvPath,
        'proof_path' => $proofPath,
    ]);

    $admin = User::factory()->create(['role' => 'admin']);

    // Admin can view CV
    $this->actingAs($admin)
        ->get(route('admin.api.membership-applications.document', ['application' => $application, 'type' => 'cv']))
        ->assertOk();

    // Admin can view Proof
    $this->actingAs($admin)
        ->get(route('admin.api.membership-applications.document', ['application' => $application, 'type' => 'proof']))
        ->assertOk();

    // Owner can view their own documents via membership-portal route
    $this->actingAs($applicantUser)
        ->get(route('membership-portal.applications.document', ['application' => $application, 'type' => 'cv']))
        ->assertOk();

    // Another regular member cannot view this application's document
    $otherMember = User::factory()->create(['role' => 'member']);
    $this->actingAs($otherMember)
        ->get(route('membership-portal.applications.document', ['application' => $application, 'type' => 'cv']))
        ->assertForbidden();
});

test('admin can view attached cv and proof in portal application review page', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $application = MembershipApplication::factory()->create([
        'first_name' => 'Richard',
        'surname' => 'Feynman',
        'cv_path' => 'applications/cv/feynman_cv.pdf',
        'proof_path' => 'applications/proofs/feynman_id.pdf',
        'status' => 'Under Evaluation',
    ]);

    $response = $this->actingAs($admin)->get(route('membership-portal.application', ['id' => $application->id]));

    $response->assertOk()
        ->assertSee('ADMIN MODE')
        ->assertSee('Richard Feynman')
        ->assertSee('View CV')
        ->assertSee('View Proof')
        ->assertDontSee('Not Uploaded');
});
