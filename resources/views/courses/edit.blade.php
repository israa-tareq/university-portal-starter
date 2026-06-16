{{--
    YOUR TASK (W10):  form to edit an existing course.

    The controller passes in:
        $course             — an App\DTOs\CourseDTO (getters listed in courses/index)
        $departmentOptions  — an array of [id => name]

    Submit with:
        method="POST" + @csrf + @method('PUT')
        action="{{ route('courses.update', $course->getId()) }}"

    Pre-fill each input from the DTO and pre-select the current department
    ($course->getDepartmentId()).

    Validated fields:  title, course_code, credit_hours, department_id

    TODO: build the form here.
--}}
@extends('layouts.layout')

@section('content')
    <div class="page-header">
        <a href="{{ route('courses.index') }}" class="back-btn">&#8592;</a>
        <h1 class="page-title">Edit Course</h1>
    </div>

    <form method="POST" action="{{ route('courses.update', $course->getId()) }}" class="form-card">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="{{ $course->getTitle() }}">
        </div>

        <div class="form-group">
            <label for="course_code">Course Code</label>
            <input type="text" id="course_code" name="course_code" value="{{ $course->getCourseCode() }}">
        </div>

        <div class="form-group">
            <label for="credit_hours">Credit Hours</label>
            <input type="number" id="credit_hours" name="credit_hours" min="1" max="12" value="{{ $course->getCreditHours() }}">
        </div>

        <div class="form-group">
            <label for="department_id">Department</label>
            <select id="department_id" name="department_id">
                <option value="">-- None --</option>
                @foreach($departmentOptions as $id => $name)
                    <option value="{{ $id }}" {{ $id == $course->getDepartmentId() ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn">Update</button>
    </form>
@endsection