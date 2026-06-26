@extends('layouts.layout')
@section('title', 'Students')
@section('content')

<div class="module-section">

    <div class="module-header">
        <div class="module-logo">
            <i data-lucide="users"></i>
        </div>
        <div>
            <p class="module-title">Students</p>
            <p class="module-desc">Manage enrolled students and their information</p>
        </div>
    </div>

    <div class="search-and-create-card">
        <div class="search-input-wrapper">
            <i data-lucide="search" class="search-icon"></i>
            <input type="text" id="module-search" class="search-input" placeholder="Search students...">
        </div>
        <x-button :href="route('students.create')" variant="primary" class="btn-add">
            <i data-lucide="plus"></i>
            Add Student
        </x-button>
    </div>

    <div class="module-display-card">
        <div class="display-card-header">
            <span class="display-card-title">All Students</span>
            <span class="display-card-count">{{ count($students) }}</span>
        </div>

        @forelse($students as $student)
            <div class="module-row">
                <div class="module-row-icon">
                    <i data-lucide="user"></i>
                </div>
                <div class="module-row-info">
                    <span class="module-row-name">{{ $student->getName() }}</span>
                    <div class="module-row-meta">
                        <span class="meta-tag">#{{ $student->getStudentNumber() }}</span>
                        <span class="meta-tag">{{ $student->getEmail() }}</span>
                        @if($student->getDepartmentName())
                            <span class="meta-tag">{{ $student->getDepartmentName() }}</span>
                        @endif
                    </div>
                </div>
                <div class="module-row-actions">
                    <a href="{{ route('students.edit', $student->getId()) }}" class="btn-edit">
                        <i data-lucide="pencil"></i>
                    </a>
                    <form action="{{ route('students.destroy', $student->getId()) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">
                            <i data-lucide="trash-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="module-empty">No students found.</p>
        @endforelse
    </div>

</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ url('css/modules.css') }}">
    <link rel="stylesheet" href="{{ url('css/students-index.css') }}">
@endpush

@push('scripts')
    <script src="{{ url('js/modules.js') }}"></script>
@endpush
