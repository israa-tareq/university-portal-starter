@extends('layouts.layout')

@section('title', 'Page Title Here')

@section('content')
    
    <div class="department-section">
        <div class="Department-Title-And-Logo">
            <p>Departments</p>
        </div>
        <div class="Search-card">

        </div>
    </div>   
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ url('css/yourpage.css') }}">
@endpush

@push('scripts')
    <script src="{{ url('js/yourpage.js') }}"></script>
@endpush