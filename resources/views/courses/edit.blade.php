@extends('layouts.layout')
@section('title', 'Edit Course')
@section('content')

<div class="module-form-page">
    <div class="module-return">
        <a href="{{ route('courses.index') }}">
            <i data-lucide="arrow-left"></i>
            <span>Return to Courses</span>
        </a>
    </div>

    <x-card title="Edit Course">
        <form action="{{ route('courses.update', $course->getId()) }}" method="POST" class="module-form">
            @csrf
            @method('PUT')

            <x-form-input name="title" label="Course Title" :value="$course->getTitle()" placeholder="e.g. Introduction to Programming" required />
            <x-form-input name="course_code" label="Course Code" :value="$course->getCourseCode()" placeholder="e.g. CS101" required />
            <x-form-input name="credit_hours" label="Credit Hours" type="number" :value="$course->getCreditHours()" required />
            <x-form-select name="department_id" label="Department" :options="$departmentOptions" :selected="$course->getDepartmentId()" placeholder="-- Select Department --" required />

            <div class="form-divider"></div>
            <div class="form-actions">
                <x-button :href="route('courses.index')" variant="secondary">Cancel</x-button>
                <x-button type="submit" variant="primary">Save Changes</x-button>
            </div>
        </form>
    </x-card>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ url('css/modules.css') }}">
    <link rel="stylesheet" href="{{ url('css/courses-edit.css') }}">
@endpush
