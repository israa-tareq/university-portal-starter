{{--
    YOUR TASK (W10):  form to create a new course.

    The controller passes in:
        $departmentOptions  — an array of [id => name] for a dropdown

    Submit with:
        method="POST"  action="{{ route('courses.store') }}"  @csrf

    Validated fields (use these as input name=""):
        title         (required)
        course_code   (required)
        credit_hours  (required, a whole number between 1 and 12)
        department_id (optional)

    TODO: build the form here.
--}}
@extends('layouts.layout')

@section('content')
    <div class="page-header">
        <a href="{{ route('courses.index') }}" class="back-btn">&#8592;</a>
        <h1 class="page-title">Add Course</h1>
    </div>

    <form method="POST" action="{{ route('courses.store') }}" class="form-card">
        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title">
        </div>

        <div class="form-group">
            <label for="course_code">Course Code</label>
            <input type="text" id="course_code" name="course_code">
        </div>

        <div class="form-group">
            <label for="credit_hours">Credit Hours</label>
            <input type="number" id="credit_hours" name="credit_hours" min="1" max="12">
        </div>

        <div class="form-group">
            <label for="department_id">Department</label>
            <select id="department_id" name="department_id">
                <option value="">-- None --</option>
                @foreach($departmentOptions as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn">Save</button>
    </form>
@endsection