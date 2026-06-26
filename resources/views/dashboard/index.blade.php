@extends('layouts.layout')
@section('title', 'Dashboard')

@section('content')
<div class="dashboard-section">

    {{-- Page header --}}
    <div class="dashboard-header">
        <h1 class="dashboard-title">System Overview</h1>
        <p class="dashboard-subtitle">Welcome back, Admin. Here&rsquo;s what&rsquo;s happening across the university today.</p>
    </div>

    {{-- ── Stat cards ── --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-icon--teal">
                <i data-lucide="users"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Students</span>
                <span class="stat-value">{{ number_format($totalStudents) }}</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon--blue">
                <i data-lucide="book-copy"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Active Courses</span>
                <span class="stat-value">{{ number_format($totalCourses) }}</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon--purple">
                <i data-lucide="graduation-cap"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Faculty Members</span>
                <span class="stat-value">{{ number_format($totalProfessors) }}</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon--orange">
                <i data-lucide="clipboard-list"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Enrollments</span>
                <span class="stat-value">
                    @if($totalEnrollments >= 1000)
                        ~{{ number_format(round($totalEnrollments / 100) * 100) }}
                    @else
                        {{ number_format($totalEnrollments) }}
                    @endif
                </span>
            </div>
        </div>
    </div>

    {{-- ── Analytics & Visualizations ── --}}
    <h2 class="section-heading">
        <i data-lucide="clock"></i>
        Analytics &amp; Visualizations
    </h2>

    <div class="charts-grid">
        <div class="chart-card">
            <h3>Enrollments by Dept</h3>
            <div class="chart-canvas-wrapper">
                <canvas id="enrollmentsByDeptChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <h3>Grade Distribution</h3>
            <div class="chart-canvas-wrapper">
                <canvas id="gradeDistributionChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <h3>Faculty Overview</h3>
            <div class="chart-canvas-wrapper">
                <canvas id="facultyRadarChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <h3>Enrollment Trend</h3>
            <div class="chart-canvas-wrapper">
                <canvas id="enrollmentTrendChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ── Bottom row: table + distributions ── --}}
    <div class="dashboard-bottom-row">

        {{-- Recent Grade Postings & Enrollments --}}
        <div class="recent-card">
            <div class="recent-card-header">
                <span class="recent-card-title">
                    <i data-lucide="clock"></i>
                    Recent Grade Postings &amp; Enrollments
                </span>
                <a href="{{ route('enrollments.index') }}" class="view-all-link">View All</a>
            </div>

            <table class="enrollment-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course Code</th>
                        <th>Department</th>
                        <th>Status/Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $avatarPalette = [
                            '#0FA4AF','#3b82f6','#8b5cf6','#f97316',
                            '#ef4444','#22c55e','#ec4899','#f59e0b',
                        ];
                    @endphp

                    @forelse($recentEnrollments as $enrollment)
                        @php
                            $nameParts = explode(' ', $enrollment->student_name ?? '');
                            $initials  = strtoupper(
                                mb_substr($nameParts[0] ?? '', 0, 1) .
                                mb_substr($nameParts[1] ?? '', 0, 1)
                            );
                            $avatarColor = $avatarPalette[abs(crc32($enrollment->student_name ?? '')) % count($avatarPalette)];

                            $grade = $enrollment->grade;
                            if ($grade === null) {
                                $badgeClass = 'grade-badge--yellow';
                                $badgeText  = 'In Progress';
                            } elseif (in_array(strtoupper(mb_substr($grade, 0, 1)), ['A', 'B'])) {
                                $badgeClass = 'grade-badge--green';
                                $badgeText  = 'Grade: ' . $grade;
                            } else {
                                $badgeClass = 'grade-badge--red';
                                $badgeText  = 'Grade: ' . $grade;
                            }
                        @endphp
                        <tr>
                            <td>
                                <div class="student-cell">
                                    <div class="student-avatar" style="background-color:{{ $avatarColor }}">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <div class="student-info-name">{{ $enrollment->student_name }}</div>
                                        <div class="student-info-number">{{ $enrollment->student_number ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="course-code-badge">{{ $enrollment->course_code }}</span></td>
                            <td><span class="dept-text">{{ $enrollment->department_name ?? 'N/A' }}</span></td>
                            <td><span class="grade-badge {{ $badgeClass }}">{{ $badgeText }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center;padding:28px;color:#6b7280;font-size:13px;">
                                No enrollments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Course Distributions --}}
        <div class="distributions-card">
            <p class="distributions-card-title">
                <i data-lucide="bar-chart-2"></i>
                Course Distributions
            </p>

            @forelse($courseDistributions as $index => $dist)
                <div class="distribution-item">
                    <div class="distribution-header">
                        <span class="distribution-name">{{ $dist['name'] }} ({{ $dist['abbr'] }})</span>
                        <span class="distribution-pct">{{ $dist['percentage'] }}%</span>
                    </div>
                    <div class="distribution-bar-track">
                        <div
                            class="distribution-bar-fill {{ $index === count($courseDistributions) - 1 ? 'distribution-bar-fill--light' : '' }}"
                            style="width:{{ $dist['percentage'] }}%"
                        ></div>
                    </div>
                </div>
            @empty
                <p style="color:#6b7280;font-size:13px;margin:0;">No enrollment data yet.</p>
            @endforelse
        </div>

    </div>

    {{-- ── Department cards ── --}}
    @if(count($departmentCards) > 0)
    @php
        $deptIconMap = [
            'computer science'        => 'cpu',
            'mathematics'             => 'calculator',
            'electrical engineering'  => 'zap',
            'mechanical engineering'  => 'wrench',
            'business administration' => 'briefcase',
            'economics'               => 'trending-up',
            'physics'                 => 'atom',
            'chemistry'               => 'flask-conical',
            'biology'                 => 'microscope',
            'psychology'              => 'brain',
            'english literature'      => 'book-open',
            'civil engineering'       => 'hard-hat',
        ];
    @endphp

    <div class="dept-cards-grid">
        @foreach($departmentCards as $dept)
            @php
                $icon = $deptIconMap[strtolower($dept->name)] ?? 'building-2';
            @endphp
            <div class="dept-card">
                <div class="dept-card-icon">
                    <i data-lucide="{{ $icon }}"></i>
                </div>
                <p class="dept-card-name">{{ $dept->name }}</p>
                <p class="dept-card-meta">
                    {{ $dept->course_count }} Core Courses
                    &bull; {{ $dept->student_count }} Active Students
                    &bull; {{ $dept->professor_count }} Professors
                </p>
                <div class="dept-card-actions">
                    <a href="{{ route('courses.index') }}" class="dept-btn dept-btn--teal">Manage Catalog</a>
                    <a href="{{ route('professors.index') }}" class="dept-btn dept-btn--gray">View Staff</a>
                </div>
            </div>
        @endforeach
    </div>
    @endif

</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ url('css/dashboard.css') }}">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const enrollmentsByDept = @json($enrollmentsByDept);
    const gradeDistribution = @json($gradeDistribution);
    const enrollmentTrend   = @json($enrollmentTrend);
    const radarData         = @json($radarData);

    Chart.defaults.font.family = "system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif";

    /* ── Bar chart: Enrollments by Dept ── */
    new Chart(document.getElementById('enrollmentsByDeptChart'), {
        type: 'bar',
        data: {
            labels: enrollmentsByDept.map(d => d.dept),
            datasets: [{
                data: enrollmentsByDept.map(d => d.count),
                backgroundColor: '#0FA4AF',
                borderRadius: 4,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { font: { size: 10 }, color: '#9ca3af' },
                    grid: { color: '#f3f4f6' },
                    border: { display: false },
                },
                x: {
                    ticks: { font: { size: 10 }, color: '#6b7280' },
                    grid: { display: false },
                    border: { display: false },
                }
            }
        }
    });

    /* ── Donut chart: Grade Distribution ── */
    new Chart(document.getElementById('gradeDistributionChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(gradeDistribution),
            datasets: [{
                data: Object.values(gradeDistribution),
                backgroundColor: ['#003135', '#0FA4AF', '#f59e0b', '#ef4444', '#e2e8f0'],
                borderWidth: 2,
                borderColor: '#fff',
                hoverBorderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '62%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 10 },
                        padding: 8,
                        boxWidth: 12,
                        boxHeight: 12,
                        color: '#374151',
                    }
                }
            }
        }
    });

    /* ── Radar chart: Faculty Overview ── */
    new Chart(document.getElementById('facultyRadarChart'), {
        type: 'radar',
        data: {
            labels: ['Research', 'Teaching', 'Publishing', 'Grants', 'Admin'],
            datasets: [{
                data: radarData,
                backgroundColor: 'rgba(15, 164, 175, 0.15)',
                borderColor: '#0FA4AF',
                borderWidth: 2,
                pointBackgroundColor: '#003135',
                pointBorderColor: '#fff',
                pointRadius: 3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100,
                    ticks: { display: false, stepSize: 25 },
                    pointLabels: { font: { size: 10 }, color: '#6b7280' },
                    grid: { color: '#e5e7eb' },
                    angleLines: { color: '#e5e7eb' },
                }
            },
            plugins: { legend: { display: false } }
        }
    });

    /* ── Line chart: Enrollment Trend ── */
    new Chart(document.getElementById('enrollmentTrendChart'), {
        type: 'line',
        data: {
            labels: enrollmentTrend.map(d => d.month),
            datasets: [{
                data: enrollmentTrend.map(d => d.count),
                borderColor: '#0FA4AF',
                backgroundColor: 'rgba(15, 164, 175, 0.08)',
                fill: true,
                tension: 0.4,
                borderWidth: 2,
                pointRadius: 3,
                pointBackgroundColor: '#0FA4AF',
                pointBorderColor: '#fff',
                pointHoverRadius: 5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { font: { size: 10 }, color: '#9ca3af' },
                    grid: { color: '#f3f4f6' },
                    border: { display: false },
                },
                x: {
                    ticks: { font: { size: 10 }, color: '#6b7280' },
                    grid: { display: false },
                    border: { display: false },
                }
            }
        }
    });
</script>
@endpush
