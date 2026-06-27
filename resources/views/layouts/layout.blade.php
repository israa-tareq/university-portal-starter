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
        <div class="sidebar-avatar">{{ $initials }}</div>
        <div class="sidebar-user-info">
            <p class="sidebar-user-name">{{ $user->name }}</p>
            <p class="sidebar-user-email">{{ $user->email }}</p>
        </div>
<<<<<<< HEAD
        <div class="nav-links">
    <a href="{{ route('dashboard') }}"><i data-lucide="layout-grid"></i> Dashboard</a>
    <a href="{{ route('departments.index') }}"><i data-lucide="layout-dashboard"></i> Departments</a>
    <a href="{{ route('students.index') }}"><i data-lucide="users"></i> Students</a>
    <a href="{{ route('courses.index') }}"><i data-lucide="book-open"></i> Courses</a>
    <a href="{{ route('professors.index') }}"><i data-lucide="user"></i> Professors</a>
    <a href="{{ route('enrollments.index') }}"><i data-lucide="clipboard-list"></i> Enrollments</a>
=======
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
            <div class="topbar-avatar">{{ $initials }}</div>
        </div>
    </header>

    <div class="page-content">
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

>>>>>>> bdc868ba56576c286d9fdd5377c0b74babee6e9c
</div>

<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script src="{{ url('js/layout.js') }}"></script>
@stack('scripts')
</body>
</html>
