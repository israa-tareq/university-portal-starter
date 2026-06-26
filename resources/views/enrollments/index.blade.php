@extends('layouts.layout')
@section('title', 'Enrollments')
@section('content')

<div class="module-section">

    <div class="module-header">
        <div class="module-logo">
            <i data-lucide="clipboard-list"></i>
        </div>
        <div>
            <p class="module-title">Enrollments</p>
            <p class="module-desc">Manage student course enrollments and grades</p>
        </div>
    </div>

    <div class="search-and-create-card">
        <div class="search-input-wrapper">
            <i data-lucide="search" class="search-icon"></i>
            <input type="text" id="module-search" class="search-input" placeholder="Search enrollments...">
        </div>
        <x-button :href="route('enrollments.create')" variant="primary" class="btn-add">
            <i data-lucide="plus"></i>
            Add Enrollment
        </x-button>
    </div>

    <div class="module-display-card">
        <div class="display-card-header">
            <span class="display-card-title">All Enrollments</span>
            <span class="display-card-count">{{ count($enrollments) }}</span>
        </div>

        @forelse($enrollments as $enrollment)
            <div class="module-row">
                <div class="module-row-icon">
                    <i data-lucide="clipboard-list"></i>
                </div>
                <div class="module-row-info">
                    <span class="module-row-name">{{ $enrollment->getStudentName() }}</span>
                    <div class="module-row-meta">
                        <span class="meta-tag">{{ $enrollment->getCourseCode() }}</span>
                        <span class="meta-tag">{{ $enrollment->getCourseTitle() }}</span>
                        @if($enrollment->getGrade())
                            <span class="meta-tag">Grade: {{ $enrollment->getGrade() }}</span>
                        @endif
                    </div>
                </div>
                <div class="module-row-actions">
                    <a href="{{ route('enrollments.edit', $enrollment->getId()) }}" class="btn-edit">
                        <i data-lucide="pencil"></i>
                    </a>
                    <form action="{{ route('enrollments.destroy', $enrollment->getId()) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">
                            <i data-lucide="trash-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="module-empty">No enrollments found.</p>
        @endforelse
    </div>

</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ url('css/modules.css') }}">
    <link rel="stylesheet" href="{{ url('css/enrollments-index.css') }}">
@endpush

@push('scripts')
    <script src="{{ url('js/modules.js') }}"></script>
@endpush
