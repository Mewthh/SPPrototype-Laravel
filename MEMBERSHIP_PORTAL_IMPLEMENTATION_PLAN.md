# Membership Portal Implementation Plan

## Scope

Create a static, publicly accessible SPP membership portal at `/membership-portal`, with seven navigable screens and no authentication, database access, submission handling, uploads, or changes to existing public pages beyond route registration.

## Reused SPP conventions

- Typography: `Trebuchet MS`, `Segoe UI`, and system fallbacks.
- Visual tokens: the public site's slate palette, `--bg`, `--surface`, `--text`, `--muted`, `--border`, and shadow values.
- Styling: compact rounded controls, restrained white card surfaces, existing light/dark theme behavior, and inline SVG icons.
- Brand treatment: the existing text-based `SPP` brand mark and Samahang Pisika ng Pilipinas naming.

## Route design

Use a public route group with the `membership-portal` prefix:

- `/membership-portal` — Dashboard
- `/membership-portal/application` — My Application
- `/membership-portal/membership` — Membership
- `/membership-portal/information` — My Information
- `/membership-portal/inquiries` — Inquiries
- `/membership-portal/notifications` — Notifications
- `/membership-portal/settings` — Settings

Each route will render static Blade data only. Named routes will drive sidebar links and active navigation states.

## Page and component structure

```
resources/views/
├── layouts/portal.blade.php                 Shared top bar, mobile drawer, sidebar, and content shell
├── portal/
│   ├── dashboard.blade.php
│   ├── application.blade.php
│   ├── membership.blade.php
│   ├── information.blade.php
│   ├── inquiries.blade.php
│   ├── notifications.blade.php
│   ├── settings.blade.php
│   └── partials/sidebar.blade.php           Shared navigation links and inline SVG icons
└── components/portal/
    ├── status-badge.blade.php
    ├── info-card.blade.php
    ├── timeline.blade.php
    └── document-row.blade.php
```

`resources/css/portal.css` will define the portal-only responsive dashboard styling, referencing the public SPP variables rather than changing the public-site layout.

## Interaction boundaries

- The mobile sidebar will use a no-backend, accessible native disclosure/drawer pattern.
- The Membership page’s applicant/approved prototype state will use a clearly marked client-side demo toggle only.
- Inquiry, settings, and update controls will be rendered as non-submitting UI.
- Existing public Login and Join SPP links will not be edited.

## Testing and verification

- Add focused Pest feature coverage for each portal route, public access, and key dashboard/page content.
- Run the new test file and Laravel Pint.
- Verify all sidebar routes and responsive layouts at 375px, 768px, and 1440px with the browser agent; retain screenshots as the verification artifacts.
