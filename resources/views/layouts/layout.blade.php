<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LIMU')</title>
    <link rel="stylesheet" href="{{ url('css/layout.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @stack('styles')
</head>
<body>

@php
    $user     = auth()->user();
    $parts    = explode(' ', $user->name ?? '');
    $initials = strtoupper(mb_substr($parts[0] ?? '', 0, 1) . mb_substr($parts[1] ?? '', 0, 1));
@endphp

{{-- ════════════════════ SIDEBAR ════════════════════ --}}
<aside class="sidebar" id="sidebar">

    <div class="sidebar-logo">
        <div class="sidebar-logo-icon"><i data-lucide="book-open"></i></div>
        <span class="sidebar-logo-text">LIMU</span>
    </div>

    <button class="sidebar-toggle" id="sidebarToggle" title="Collapse sidebar">
        <i data-lucide="chevrons-left" id="toggleIcon"></i>
    </button>

    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}"         class="sidebar-link"><i data-lucide="gauge"></i><span>Dashboard</span></a>
        <a href="{{ route('departments.index') }}" class="sidebar-link"><i data-lucide="layout-dashboard"></i><span>Departments</span></a>
        <a href="{{ route('students.index') }}"    class="sidebar-link"><i data-lucide="users"></i><span>Students</span></a>
        <a href="{{ route('courses.index') }}"     class="sidebar-link"><i data-lucide="book-copy"></i><span>Courses</span></a>
        <a href="{{ route('professors.index') }}"  class="sidebar-link"><i data-lucide="graduation-cap"></i><span>Professors</span></a>
        <a href="{{ route('enrollments.index') }}" class="sidebar-link"><i data-lucide="clipboard-list"></i><span>Enrollments</span></a>
    </nav>

    <div class="sidebar-user">
        <a href="{{ route('profile.edit') }}" class="sidebar-avatar" title="Edit profile">
            @if($user->avatarUrl())
                <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}">
            @else
                {{ $initials }}
            @endif
        </a>
        <div class="sidebar-user-info">
            <a href="{{ route('profile.edit') }}">
                <p class="sidebar-user-name">{{ $user->name }}</p>
            </a>
            <p class="sidebar-user-email">{{ $user->email }}</p>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="sidebar-logout-form">
            @csrf
            <button type="submit" class="sidebar-logout-btn" title="Log out">
                <i data-lucide="log-out"></i>
            </button>
        </form>
    </div>

</aside>

{{-- Mobile overlay --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>

{{-- ════════════════════ MAIN ════════════════════ --}}
<div class="main-wrapper" id="mainWrapper">

    <header class="topbar">
        <div class="topbar-left">
            <button class="topbar-menu-btn" id="mobileMenuBtn">
                <i data-lucide="menu"></i>
            </button>
            <span class="topbar-title">@yield('title', 'LIMU')</span>
        </div>
        <div class="topbar-right">
            <div class="topbar-bell"><i data-lucide="bell"></i></div>
            <a href="{{ route('profile.edit') }}" class="topbar-avatar" title="Edit profile">
                @if($user->avatarUrl())
                    <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}">
                @else
                    {{ $initials }}
                @endif
            </a>
        </div>
    </header>

    <div class="page-content">
        @if(session('success'))
            <div class="flash-banner flash-success">
                <i data-lucide="check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="flash-banner flash-error">
                <i data-lucide="alert-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @yield('content')
    </div>

    <footer class="footer">
        <div class="footer-main">
            <div class="footer-top">
                <div class="footer-brand">
                    <div class="footer-logo"><i data-lucide="graduation-cap"></i></div>
                    <div class="footer-brand-text">
                        <span class="footer-name">LIMU</span>
                        <span class="footer-tagline">LEARNING MANAGEMENT</span>
                    </div>
                </div>
                <p class="footer-desc">One of Libya's most prominent learning management systems.</p>
                <div class="footer-socials">
                    <a href="#">T</a>
                    <a href="#">F</a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                    <a href="#">M</a>
                </div>
            </div>
            <div class="footer-contact">
                <p class="footer-contact-title">GET IN TOUCH</p>
                <div class="footer-contact-item"><i data-lucide="mail"></i><span>support@limu.edu.ly</span></div>
                <div class="footer-contact-item"><i data-lucide="phone"></i><span>+1 (800) 000-0000</span></div>
                <div class="footer-contact-item"><i data-lucide="map-pin"></i><span>Benghazi, Libya</span></div>
            </div>
        </div>
        <div class="footer-bottom">
            <p style="font-weight:bold">&copy; 2025 LIMU. All rights reserved.</p>
        </div>
    </footer>

</div>

<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script src="{{ url('js/layout.js') }}"></script>
@stack('scripts')
</body>
</html>
