@extends('layouts.layout')
@section('title', 'Add Course')
@section('content')

<div class="module-form-page">
    <div class="module-return">
        <a href="{{ route('courses.index') }}">
            <i data-lucide="arrow-left"></i>
            <span>Return to Courses</span>
        </a>
    </div>

    <x-card title="Add New Course">
        <form action="{{ route('courses.store') }}" method="POST" class="module-form" id="courseForm" novalidate>
            @csrf

            {{-- Validation error banner --}}
            <div class="form-error-banner" id="errorBanner" {{ $errors->any() ? '' : 'style=display:none' }}>
                <i data-lucide="alert-circle"></i>
                <span>Please fill out all required fields.</span>
            </div>

            <x-form-input name="title" label="Course Title" placeholder="e.g. Introduction to Programming" :value="old('title')" />
            <x-form-input name="course_code" label="Course Code" placeholder="e.g. CS101" :value="old('course_code')" />
            <x-form-input name="credit_hours" label="Credit Hours" type="number" placeholder="e.g. 3" :value="old('credit_hours')" />
            <x-form-select name="department_id" label="Department" :options="$departmentOptions" :selected="old('department_id')" placeholder="-- Select Department --" />

            <x-button type="submit" variant="primary">Create Course</x-button>
        </form>
    </x-card>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ url('css/modules.css') }}">
    <link rel="stylesheet" href="{{ url('css/courses-create.css') }}">
    <style>
        .form-error-banner {
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: #fef2f2;
            border: 1px solid #fca5a5;
            border-radius: 6px;
            padding: 10px 14px;
            color: #dc2626;
            font-size: 0.9em;
            font-weight: 500;
        }
        .form-error-banner svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }
        .input-error {
            border-color: #ef4444 !important;
        }
    </style>
@endpush

@push('scripts')
<script>
(function () {
    var form        = document.getElementById('courseForm');
    var errorBanner = document.getElementById('errorBanner');

    var titleInput   = form.querySelector('[name="title"]');
    var codeInput    = form.querySelector('[name="course_code"]');
    var hoursInput   = form.querySelector('[name="credit_hours"]');
    var deptSelect   = form.querySelector('[name="department_id"]');

    var required = [titleInput, codeInput, hoursInput, deptSelect];

    function showBanner() {
        errorBanner.style.display = 'flex';
        lucide.createIcons();
    }

    function tryHideBanner() {
        var allFilled = required.every(function (el) { return el && el.value.trim() !== ''; });
        if (allFilled) errorBanner.style.display = 'none';
    }

    required.forEach(function (el) {
        if (!el) return;
        el.addEventListener('input', function () {
            if (this.value.trim()) this.classList.remove('input-error');
            tryHideBanner();
        });
        el.addEventListener('change', function () {
            if (this.value.trim()) this.classList.remove('input-error');
            tryHideBanner();
        });
    });

    form.addEventListener('submit', function (e) {
        var missing = false;

        required.forEach(function (el) {
            if (el && !el.value.trim()) {
                el.classList.add('input-error');
                missing = true;
            }
        });

        if (missing) {
            e.preventDefault();
            showBanner();
            errorBanner.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
})();
</script>
@endpush
