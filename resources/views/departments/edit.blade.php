@extends('layouts.layout')
@section('title', 'Edit Department')
@section('content')
    <div class="create-department">
        <div class="return-home">
            <a href="{{ route('departments.index') }}">
                <i class="fa-solid fa-arrow-left"></i>
                <span>&lt; Return to Departments</span>
            </a>
        </div>

        <x-card title="Edit Department">
            <form action="{{ route('departments.update', $department->getId()) }}" method="POST" class="create-department-form">
                @csrf
                @method('PUT')

                <x-form-input
                    name="name"
                    label="Department Name"
                    :value="$department->getName()"
                    placeholder="e.g. Computer Science"
                    required
                />

                <div class="form-divider"></div>

                <div class="form-actions">
                    <x-button :href="route('departments.index')" variant="secondary">Cancel</x-button>
                    <x-button type="submit" variant="primary">Save Changes</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ url('css/Departments.css') }}">
@endpush
@push('scripts')
    <script src="{{ url('js/Departments.js') }}"></script>
@endpush