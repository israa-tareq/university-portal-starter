@extends('layouts.layout')
@section('title', 'Courses')
@section('content')

<div class="module-section">

    <div class="module-header">
        <div class="module-logo">
            <i data-lucide="book-open"></i>
        </div>
        <div>
            <p class="module-title">Courses</p>
            <p class="module-desc">Manage academic courses and their departments</p>
        </div>
    </div>

    <div class="search-and-create-card">
        <div class="search-input-wrapper">
            <i data-lucide="search" class="search-icon"></i>
            <input type="text" id="module-search" class="search-input" placeholder="Search courses...">
        </div>
        <x-button :href="route('courses.create')" variant="primary" class="btn-add">
            <i data-lucide="plus"></i>
            Add Course
        </x-button>
    </div>

    <div class="module-display-card">
        <div class="display-card-header">
            <span class="display-card-title">All Courses</span>
            <span class="display-card-count">{{ count($courses) }}</span>
        </div>

        @foreach($courses as $course)
            <div class="module-row">
                <div class="module-row-icon">
                    <i data-lucide="book-open"></i>
                </div>
                <div class="module-row-info">
                    <span class="module-row-name">{{ $course->getTitle() }}</span>
                    <div class="module-row-meta">
                        <span class="meta-tag">{{ $course->getCourseCode() }}</span>
                        <span class="meta-tag">{{ $course->getCreditHours() }} cr</span>
                        @if($course->getDepartmentName())
                            <span class="meta-tag">{{ $course->getDepartmentName() }}</span>
                        @endif
                    </div>
                </div>
                <div class="module-row-actions">
                    <a href="{{ route('courses.edit', $course->getId()) }}" class="btn-edit">
                        <i data-lucide="pencil"></i>
                    </a>
                    <form action="{{ route('courses.destroy', $course->getId()) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-delete"
                            onclick="openDeleteConfirm(this.closest('form'), '{{ addslashes($course->getTitle()) }}', 'Course', 'Deleting this course will remove all student enrollments linked to it.')">
                            <i data-lucide="trash-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach

        @if(count($courses) === 0)
            <p class="module-empty">No courses found.</p>
        @endif
    </div>

</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ url('css/modules.css') }}">
    <link rel="stylesheet" href="{{ url('css/courses-index.css') }}">
@endpush

@push('scripts')
    <script src="{{ url('js/modules.js') }}"></script>
@endpush
