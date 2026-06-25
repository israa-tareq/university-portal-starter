@extends('layouts.layout')
@section('title', 'Departments')
@section('content')

    {{-- Main section wrapper for the entire departments page --}}
    <div class="department-page-section">

        {{-- Page header: contains the icon logo and the title/description --}}
        <div class="Department-page-header">

            {{-- Logo icon using Lucide icons --}}
            <div class="Department-page-Logo">
                <i data-lucide="building-2"></i>
            </div>

            {{-- Page title and subtitle text --}}
            <div class="Department-page-title">
                <p class="Department-page-title-text">Departments</p>
                <p class="Department-page-description">Manage your institution's academic departments</p>
            </div>

        </div>

        {{-- Search and create card: contains the search input and add button --}}
        <div class="search-and-create-card">

            {{-- Search icon + input field --}}
            <div class="search-input-wrapper">
                <i data-lucide="search" class="search-icon"></i>
                <input
                    type="text"
                    id="department-search"
                    class="search-input"
                    placeholder="Search departments..."
                />
            </div>

            {{-- Add department button --}}
            <x-button :href="route('departments.create')" variant="primary" class="btn-add-department">
                <i data-lucide="plus"></i>
                Add Department
            </x-button>

        </div>

        {{-- Display card: lists all existing departments from the database --}}
        <div class="Department-display-card">

            {{-- Card header: title and department count badge --}}
            <div class="display-card-header">
                <span class="display-card-title">All Departments</span>
                <span class="display-card-count">{{ count($departments) }}</span>
            </div>

            {{-- Loop through each department and render a row --}}
            @foreach($departments as $department)
                <div class="department-row">

                    {{-- Department icon --}}
                    <div class="department-row-icon">
                        <i data-lucide="building-2"></i>
                    </div>

                    {{-- Department name and ID stacked vertically --}}
                        <div class="department-row-info">
                            <span class="department-row-name">{{ $department->getName() }}</span>
                            <div class="department-row-id">
                                <span>Code: {{ $department->getId() }}</span>
                            </div>
                        </div>

                    {{-- Action buttons: edit and delete --}}
                    <div class="department-row-actions">

                        {{-- Edit button: links to the edit page --}}
                        <a href="{{ route('departments.edit', $department->getId()) }}" class="btn-edit">
                            <i data-lucide="pencil"></i>
                        </a>

                        {{-- Delete button: submits a DELETE form --}}
                        <form action="{{ route('departments.destroy', $department->getId()) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">
                                <i data-lucide="trash-2"></i>
                            </button>
                        </form>

                    </div>
                </div>
            @endforeach

            {{-- Empty state: shown when there are no departments yet --}}
            @if(count($departments) === 0)
                <p class="no-departments">No departments found.</p>
            @endif

        </div>

    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ url('css/Departments.css') }}">
@endpush

@push('scripts')
    <script src="{{ url('js/Departments.js') }}"></script>
@endpush