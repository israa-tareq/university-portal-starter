{{--
    YOUR TASK (W14 — Blade Components):  build the <x-form-input> component.

    You will use it inside the create/edit forms, e.g.:
        <x-form-input name="email" label="Email" type="email" required />
        <x-form-input name="name"  label="Full Name" :value="$student->getName()" required />

    Suggested props:
        name, label, type (default 'text'), value (default ''), required (default false)

    It should render a <label> and an <input>. Two helpful tips:
        - keep the user's input after a validation error:
              value="{{ old($name, $value) }}"
        - show the validation message for this field:
              @error($name) ... {{ $message }} ... @enderror

    Provided CSS classes: .form-group, .form-control, .form-error

    TODO: build the component here.
--}}

@props([
    'name',
    'label',
    'type' => 'text',
    'value' => '',
    'required' => false,
])

<div class="form-group">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if($required)
            <span class="required-asterisk">*</span>
        @endif
    </label>

    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-control']) }}
    >

    @error($name)
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>

