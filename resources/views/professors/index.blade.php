@extends('layouts.layout')
@section('title', 'Professors')
@section('content')

<div class="module-section">

    <div class="module-header">
        <div class="module-logo">
            <i data-lucide="graduation-cap"></i>
        </div>
        <div>
            <p class="module-title">Professors</p>
            <p class="module-desc">Manage faculty members and their departments</p>
        </div>
    </div>

    <div class="search-and-create-card">
        <div class="search-input-wrapper">
            <i data-lucide="search" class="search-icon"></i>
            <input type="text" id="module-search" class="search-input" placeholder="Search professors...">
        </div>
        <x-button :href="route('professors.create')" variant="primary" class="btn-add">
            <i data-lucide="plus"></i>
            Add Professor
        </x-button>
    </div>

    <div class="module-display-card">
        <div class="display-card-header">
            <span class="display-card-title">All Professors</span>
            <span class="display-card-count">{{ count($professors) }}</span>
        </div>

        @forelse($professors as $professor)
            <div class="module-row">
                <div class="module-row-icon">
                    <i data-lucide="graduation-cap"></i>
                </div>
                <div class="module-row-info">
                    <span class="module-row-name">{{ $professor->getName() }}</span>
                    <div class="module-row-meta">
                        <span class="meta-tag">{{ $professor->getEmail() }}</span>
                        @if($professor->getDepartmentName())
                            <span class="meta-tag">{{ $professor->getDepartmentName() }}</span>
                        @endif
                    </div>
                </div>
                <div class="module-row-actions">
                    <a href="{{ route('professors.edit', $professor->getId()) }}" class="btn-edit">
                        <i data-lucide="pencil"></i>
                    </a>
                    <form action="{{ route('professors.destroy', $professor->getId()) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-delete"
                            onclick="openDeleteConfirm(this.closest('form'), '{{ addslashes($professor->getName()) }}', 'Professor', 'Deleting this professor will remove their association with all courses and departments.')">
                            <i data-lucide="trash-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="module-empty">No professors found.</p>
        @endforelse
    </div>

</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ url('css/modules.css') }}">
    <link rel="stylesheet" href="{{ url('css/professors-index.css') }}">
@endpush

@push('scripts')
    <script src="{{ url('js/modules.js') }}"></script>
@endpush
