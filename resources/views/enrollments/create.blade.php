@extends('layouts.layout')
@section('title', 'Add Enrollment')
@section('content')

<div class="module-form-page">
    <div class="module-return">
        <a href="{{ route('enrollments.index') }}">
            <i data-lucide="arrow-left"></i>
            <span>Return to Enrollments</span>
        </a>
    </div>

    <x-card title="Add New Enrollment">
        <form action="{{ route('enrollments.store') }}" method="POST" class="module-form" id="enrollmentForm" novalidate>
            @csrf

            {{-- Validation error banner --}}
            <div class="form-error-banner" id="errorBanner" {{ $errors->any() ? '' : 'style=display:none' }}>
                <i data-lucide="alert-circle"></i>
                <span>Please fill out all required fields.</span>
            </div>

            {{-- Student autocomplete --}}
            <div class="form-group">
                <label class="form-label">Student <span class="required-asterisk">*</span></label>
                <div class="student-autocomplete">
                    <input
                        type="text"
                        id="studentSearch"
                        class="form-control {{ $errors->has('student_id') ? 'input-error' : '' }}"
                        placeholder="Search student by name..."
                        autocomplete="off"
                    >
                    <input type="hidden" name="student_id" id="student_id">
                    <ul class="student-dropdown" id="studentDropdown"></ul>
                </div>
            </div>

            <div id="courseGroup">
                <x-form-select name="course_id" label="Course" :options="$courseOptions" placeholder="-- Select Course --" />
            </div>
            <x-form-input name="grade" label="Grade" placeholder="e.g. A, B+, 90 (optional)" />

            <x-button type="submit" variant="primary">Create Enrollment</x-button>
        </form>
    </x-card>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ url('css/modules.css') }}">
    <link rel="stylesheet" href="{{ url('css/enrollments-create.css') }}">
    <style>
        .card { overflow: visible; }
        .card-header { border-radius: 8px 8px 0 0; }

        .student-autocomplete {
            position: relative;
        }
        .student-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 2px);
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid #0FA4AF;
            border-radius: 6px;
            max-height: 200px;
            overflow-y: auto;
            list-style: none;
            margin: 0;
            padding: 4px 0;
            z-index: 200;
            box-shadow: 0 4px 12px rgba(0,0,0,0.10);
        }
        .student-dropdown.open {
            display: block;
        }
        .student-dropdown li {
            padding: 9px 14px;
            cursor: pointer;
            font-size: 0.9em;
            color: #111827;
            border-radius: 4px;
            margin: 2px 4px;
        }
        .student-dropdown li:hover,
        .student-dropdown li.active {
            background-color: #e0f7f8;
            color: #0FA4AF;
        }
        .student-dropdown .no-results {
            padding: 9px 14px;
            font-size: 0.875em;
            color: #9ca3af;
            cursor: default;
        }
        #studentSearch.has-selection {
            border-color: #0FA4AF;
            background-color: #f0fdfe;
        }
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
    var students = @json(
        collect($studentOptions)->map(fn($name, $id) => ['id' => (string) $id, 'name' => $name])->values()
    );

    var search      = document.getElementById('studentSearch');
    var hidden      = document.getElementById('student_id');
    var dropdown    = document.getElementById('studentDropdown');
    var form        = document.getElementById('enrollmentForm');
    var errorBanner = document.getElementById('errorBanner');
    var courseSelect = form.querySelector('[name="course_id"]');

    function renderDropdown(items) {
        dropdown.innerHTML = '';
        if (items.length === 0) {
            var li = document.createElement('li');
            li.className = 'no-results';
            li.textContent = 'No students found.';
            dropdown.appendChild(li);
        } else {
            items.forEach(function (s) {
                var li = document.createElement('li');
                li.textContent = s.name;
                li.addEventListener('mousedown', function (e) {
                    e.preventDefault();
                    selectStudent(s);
                });
                dropdown.appendChild(li);
            });
        }
        dropdown.classList.add('open');
    }

    function selectStudent(s) {
        search.value = s.name;
        hidden.value = s.id;
        search.classList.add('has-selection');
        search.classList.remove('input-error');
        dropdown.classList.remove('open');
        hideBanner();
    }

    function clearSelection() {
        hidden.value = '';
        search.classList.remove('has-selection');
    }

    function showBanner() {
        errorBanner.style.display = 'flex';
        lucide.createIcons();
    }

    function hideBanner() {
        if (!hidden.value || !courseSelect.value) return;
        errorBanner.style.display = 'none';
    }

    search.addEventListener('input', function () {
        clearSelection();
        var q = this.value.trim().toLowerCase();
        if (q === '') {
            dropdown.classList.remove('open');
            return;
        }
        var matches = students.filter(function (s) {
            return s.name.toLowerCase().includes(q);
        });
        renderDropdown(matches);
    });

    search.addEventListener('focus', function () {
        if (this.value.trim()) {
            this.dispatchEvent(new Event('input'));
        }
    });

    search.addEventListener('blur', function () {
        setTimeout(function () { dropdown.classList.remove('open'); }, 150);
    });

    if (courseSelect) {
        courseSelect.addEventListener('change', function () {
            if (this.value) this.classList.remove('input-error');
            hideBanner();
        });
    }

    form.addEventListener('submit', function (e) {
        var missing = false;

        if (!hidden.value) {
            search.classList.add('input-error');
            missing = true;
        }

        if (courseSelect && !courseSelect.value) {
            courseSelect.classList.add('input-error');
            missing = true;
        }

        if (missing) {
            e.preventDefault();
            showBanner();
            errorBanner.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
})();
</script>
@endpush
