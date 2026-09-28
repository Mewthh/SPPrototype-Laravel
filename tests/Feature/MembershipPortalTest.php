<?php

test('membership portal pages are publicly available', function (string $path, string $content): void {
    $this->get($path)
        ->assertOk()
        ->assertSee($content)
        ->assertSee('Sample Name');
})->with([
    ['/membership-portal', 'Welcome, Sample Name'],
    ['/membership-portal/application', 'Application Flow'],
    ['/membership-portal/membership', 'Certificate of Membership'],
    ['/membership-portal/information', 'My Information'],
    ['/membership-portal/inquiries', 'Inquiry History'],
    ['/membership-portal/notifications', 'Additional Information Required'],
    ['/membership-portal/settings', 'Notification Preferences'],
]);

test('membership portal navigation exposes every portal destination', function (): void {
    $this->get('/membership-portal')
        ->assertSee('href="'.route('membership-portal.dashboard').'"', false)
        ->assertSee('href="'.route('membership-portal.application').'"', false)
        ->assertSee('href="'.route('membership-portal.membership').'"', false)
        ->assertSee('href="'.route('membership-portal.information').'"', false)
        ->assertSee('href="'.route('membership-portal.inquiries').'"', false)
        ->assertSee('href="'.route('membership-portal.notifications').'"', false)
        ->assertSee('href="'.route('membership-portal.settings').'"', false);
});
