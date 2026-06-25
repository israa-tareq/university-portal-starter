{{--
    YOUR TASK (W14 — Blade Components):  build the <x-button> component.

    You will use it all over the app, e.g.:
        <x-button type="submit">Save</x-button>
        <x-button :href="route('students.create')">+ New Student</x-button>
        <x-button variant="danger" type="submit">Delete</x-button>

    Suggested props (declare them with @props([...])):
        href     (optional) — if provided, render an <a>; otherwise a <button>
        type     (default 'button')
        variant  (default 'primary')  -> primary | secondary | danger

    Render the label with {{ $slot }}.

    The provided stylesheet already has: .btn, .btn-primary,
    .btn-secondary, .btn-danger — use them via class="btn btn-{{ $variant }}".

    TODO: build the component here.
--}}

@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
])

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "btn btn-$variant"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "btn btn-$variant"]) }}>
        {{ $slot }}
    </button>
@endif