@extends('layouts.app')

@section('title', 'Add New Student')

@section('content')
<div class="page-head">
    <h1>Add New Student</h1>
</div>

<div class="card" style="max-width: 520px;">
    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Student Number <span style="color: var(--danger)">*</span></label>
            <input type="text" name="student_number" class="form-control" value="{{ old('student_number') }}" required>
            @error('student_number') <p style="color: var(--danger); font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label>Full Name <span style="color: var(--danger)">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name') <p style="color: var(--danger); font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label>Email Address <span style="color: var(--danger)">*</span></label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            @error('email') <p style="color: var(--danger); font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label>Department ID</label>
            <input type="number" name="department_id" class="form-control" placeholder="e.g. 1">
        </div>

        <div class="form-actions" style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Save Student</button>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection