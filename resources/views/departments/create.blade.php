@extends('layouts.layout')
@section('title', 'Add Department')
@section('content')
    <div class="create-department">
        <div class="return-home">
            <a href="{{ route('departments.index') }}">
                <i class="fa-solid fa-arrow-left"></i>
                <span>&lt; Return to Departments</span>
            </a>
        </div>

        <x-card title="Add New Department">
            <form action="{{ route('departments.store') }}" method="POST" class="create-department-form">
                @csrf

                <x-form-input
                    name="name"
                    label="Department Name"
                    placeholder="e.g. Computer Science"
                    required
                />

                <x-button type="submit" variant="primary">Create Department</x-button>
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