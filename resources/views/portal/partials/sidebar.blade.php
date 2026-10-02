@php
    $navigation = [
        ['route' => 'membership-portal.announcements', 'label' => 'Announcements', 'path' => 'M3 11l19-9-9 19-2-8-8-2Z'],
        ['route' => 'membership-portal.dashboard', 'label' => 'Dashboard', 'path' => 'M3 10l9-7 9 7v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Z M9 21v-7h6v7'],
        ['route' => 'membership-portal.application', 'label' => 'My Application', 'path' => 'M4 3h16v18H4Z M8 8h8 M8 12h8 M8 16h5'],
        ['route' => 'membership-portal.membership', 'label' => 'Membership', 'path' => 'm12 3 3 6 6 .9-4.4 4.3 1 6.1-5.6-3-5.6 3 1-6.1L3 9.9 9 9Z'],
        ['route' => 'membership-portal.information', 'label' => 'My Information', 'path' => 'M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z M4 21c.8-4 3.3-6 8-6s7.2 2 8 6'],
        ['route' => 'membership-portal.inquiries', 'label' => 'Inquiries', 'path' => 'M4 5h16v11H9l-5 4Z M9.5 9a2.5 2.5 0 1 1 4.5 1.5c-1 1-2 1.3-2 2.5 M12 14h.01'],
        ['route' => 'membership-portal.settings', 'label' => 'Settings', 'path' => 'M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1-2.2 2.2-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.6v.2h-3.2v-.2a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1-2.2-2.2.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.6-1H5v-3.2h.2a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.3-1.9l-.1-.1 2.2-2.2.1.1a1.7 1.7 0 0 0 1.9.3 1.7 1.7 0 0 0 1-1.6V3.4h3.2v.2a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.9-.3l.1-.1L20 7l-.1.1a1.7 1.7 0 0 0-.3 1.9 1.7 1.7 0 0 0 1.6 1h.2v3.2h-.2a1.7 1.7 0 0 0-1.8 1.8Z'],
    ];
@endphp

<aside id="portal-sidebar" class="portal-sidebar" aria-label="Membership portal navigation">
    <nav class="portal-nav">
        @foreach ($navigation as $item)
            <a href="{{ route($item['route']) }}" class="portal-nav-link {{ request()->routeIs($item['route']) ? 'is-active' : '' }}" @if (request()->routeIs($item['route'])) aria-current="page" @endif>
                <span class="portal-nav-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="{{ $item['path'] }}" /></svg></span>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>
    <button class="portal-logout-button" type="button">Log Out</button>
</aside>
