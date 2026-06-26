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
    <div class="header">
        <div class="logo">
            <i data-lucide="book-open"></i>
            LIMU
        </div>
        <div class="nav-links">
    <a href="{{ route('dashboard') }}"><i data-lucide="gauge"></i> Dashboard</a>
    <a href="{{ route('departments.index') }}"><i data-lucide="layout-dashboard"></i> Departments</a>
    <a href="{{ route('students.index') }}"><i data-lucide="users"></i> Students</a>
    <a href="{{ route('courses.index') }}"><i data-lucide="book-open"></i> Courses</a>
    <a href="{{ route('professors.index') }}"><i data-lucide="user"></i> Professors</a>
    <a href="{{ route('enrollments.index') }}"><i data-lucide="clipboard-list"></i> Enrollments</a>
</div>
        <div class="right-section">
            <div class="notifications">
                <i data-lucide="bell"></i>
            </div>
            <div class="profile-wrapper">
                <div class="profile" id="profileBtn">
                    <div class="profile-circle"><span>JD</span></div>
                    <i data-lucide="chevron-down" class="arrow" id="profileArrow"></i>
                </div>
                <div class="profile-dropdown" id="profileDropdown">
                    <div class="dropdown-header">
                        <p class="dropdown-name">Jane Smith</p>
                        <p class="dropdown-email">jane.smith@university.edu</p>
                    </div>
                    <div class="dropdown-items">
                        <a href="#"><i data-lucide="user"></i> Profile</a>
                        <a href="#"><i data-lucide="settings"></i> Preferences</a>
                        <a href="{{ route('logout') }}" class="logout"><i data-lucide="log-out"></i> Log out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="content">
            @yield('content')
        </div>

        <div class="footer">
            <div class="footer-main">
                <div class="footer-top">
                    <div class="footer-brand">
                        <div class="footer-logo">
                            <i data-lucide="graduation-cap"></i>
                        </div>
                        <div class="footer-brand-text">
                            <span class="footer-name">LIMU</span>
                            <span class="footer-tagline">LEARNING MANAGEMENT</span>
                        </div>
                    </div>
                    <p class="footer-desc">One of Libyas' most prominent learning management systems.</p>
                    <div class="footer-socials">
                        <a href="#">T</a>
                        <a href="#">F</a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                        <a href="#">M</a>
                    </div>
                </div>
                <div class="footer-contact">
                    <p class="footer-contact-title">GET IN TOUCH</p>
                    <div class="footer-contact-item">
                        <i data-lucide="mail"></i>
                        <span>support@limu.edu.ly</span>
                    </div>
                    <div class="footer-contact-item">
                        <i data-lucide="phone"></i>
                        <span>+1 (800) 000-0000</span>
                    </div>
                    <div class="footer-contact-item">
                        <i data-lucide="map-pin"></i>
                        <span>Benghazi, Libya</span>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p style="font-weight:bold">&copy; 2023 LIMU. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script src="{{ url('js/layout.js') }}"></script>
    @stack('scripts')
</body>
</html>