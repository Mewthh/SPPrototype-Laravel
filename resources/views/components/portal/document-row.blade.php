@props(['label', 'status' => 'Submitted'])

<div {{ $attributes->merge(['class' => 'portal-document-row']) }}>
    <span>{{ $label }}</span>
    <x-portal.status-badge :status="$status" />
</div>
