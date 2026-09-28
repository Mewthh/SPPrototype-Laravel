@props(['steps', 'current' => 0])

<ol class="portal-timeline">
    @foreach ($steps as $index => $step)
        <li class="portal-timeline-step {{ $index < $current ? 'is-complete' : '' }} {{ $index === $current ? 'is-current' : '' }}">
            <span class="portal-step-marker" aria-hidden="true">{{ $index < $current ? '✓' : $index + 1 }}</span>
            <span>{{ $step }}</span>
        </li>
    @endforeach
</ol>
