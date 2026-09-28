@props(['status'])

@php
    $classes = match ($status) {
        'Active', 'Approved', 'Submitted', 'Responded' => 'is-positive',
        'Under Evaluation', 'Under Review', 'Needs Information' => 'is-attention',
        'Closed', 'Not Yet Active' => 'is-muted',
        default => 'is-pending',
    };
@endphp

<span {{ $attributes->merge(['class' => 'portal-status '.$classes]) }}>{{ $status }}</span>
