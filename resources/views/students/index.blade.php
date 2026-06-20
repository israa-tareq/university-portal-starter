@extends('layouts.app')

@section('title', 'Students List')

@section('content')
<div class="page-head">
    <h1>Students List</h1>
    <a href="{{ route('students.create') }}" class="btn btn-primary">New Student</a>
</div>

<div class="card" style="padding: 0;">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background: #fafbfe; color: #6b7688; text-transform: uppercase; font-size: 0.78rem; letter-spacing: 0.04em;">
                <th style="padding: 14px; border-bottom: 1px solid #e3e8f0;">Student Number</th>
                <th style="padding: 14px; border-bottom: 1px solid #e3e8f0;">Name</th>
                <th style="padding: 14px; border-bottom: 1px solid #e3e8f0;">Email</th>
                <th style="padding: 14px; border-bottom: 1px solid #e3e8f0;">Department</th>
                <th style="padding: 14px; border-bottom: 1px solid #e3e8f0; text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr style="border-bottom: 1px solid #e3e8f0;">
                    <td style="padding: 14px;"><strong>{{ $student->getStudentNumber() }}</strong></td>
                    <td style="padding: 14px;">{{ $student->getName() }}</td>
                    <td style="padding: 14px;">{{ $student->getEmail() }}</td>
                    <td style="padding: 14px;"><span style="background: #eef1f8; color: #38415a; padding: 4px 8px; border-radius: 6px; font-size: 0.8rem; font-weight: 600;">{{ $student->getDepartmentName() }}</span></td>
                    <td style="padding: 14px; text-align: right;">
                        <a href="{{ route('students.edit', $student->getId()) }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.8rem;">Edit</a>
                        <form action="{{ route('students.destroy', $student->getId()) }}" method="POST" style="display: inline; margin-left: 4px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.8rem; border: none; border-radius: 8px; cursor: pointer;" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 32px; text-align: center; color: #6b7688;">
                        No students found. Click "New Student" to add records!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection