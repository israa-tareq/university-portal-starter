{{--
    YOUR TASK (W14 — Blade Components):  build the <x-card> component.

    A simple panel used to wrap tables and forms:
        <x-card>
            ... content ...
        </x-card>

    Suggested prop: title (optional) — show a header bar when it is provided.
    Render the body with {{ $slot }}.

    Provided CSS classes: .card, .card-header, .card-body

    TODO: build the component here.
--}}

@props([
    'title' => null,
])

<div {{ $attributes->merge(['class' => 'card']) }}>
    @if($title)
        <div class="card-header">{{ $title }}</div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
</div>