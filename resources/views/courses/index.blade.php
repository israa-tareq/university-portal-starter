{{--
    YOUR TASK (W10 + W13):  list every course.

    The controller passes in:
        $courses  — an array of App\DTOs\CourseDTO

    Each CourseDTO gives you:
        getId(), getTitle(), getCourseCode(), getCreditHours(),
        getDepartmentId(), getDepartmentName()

    Build a table (loop with @foreach) with, per row:
        - an "Edit" link    -> route('courses.edit', $course->getId())
        - a "Delete" <form> (POST + @csrf + @method('DELETE'))
              action -> route('courses.destroy', $course->getId())
    Plus a "New Course" link -> route('courses.create').

    TODO: build the view here.
--}}
@extends('layouts.layout')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Courses</h1>
        <a href="{{ route('courses.create') }}" class="btn">+ New Course</a>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Code</th>
                <th>Credit Hours</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
                <tr>
                    <td>{{ $course->getTitle() }}</td>
                    <td>{{ $course->getCourseCode() }}</td>
                    <td>{{ $course->getCreditHours() }}</td>
                    <td>{{ $course->getDepartmentName() }}</td>
                    <td class="actions-cell">
                        <a href="{{ route('courses.edit', $course->getId()) }}">Edit</a>

                        <form action="{{ route('courses.destroy', $course->getId()) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection