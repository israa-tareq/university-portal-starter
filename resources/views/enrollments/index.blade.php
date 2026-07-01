@extends('layouts.layout')
@section('title', 'Enrollments')
@section('content')

<div class="module-section">

    <div class="module-header">
        <div class="module-logo">
            <i data-lucide="clipboard-list"></i>
        </div>
        <div>
            <p class="module-title">Enrollments</p>
            <p class="module-desc">Manage student course enrollments and grades</p>
        </div>
    </div>

    <div class="search-and-create-card">
        <div class="search-input-wrapper">
            <i data-lucide="search" class="search-icon"></i>
            <input type="text" id="enrollmentSearch" class="search-input" placeholder="Search students...">
        </div>
        <x-button :href="route('enrollments.create')" variant="primary" class="btn-add">
            <i data-lucide="plus"></i>
            Add Enrollment
        </x-button>
    </div>

    <div class="module-tabs" id="statusTabs">
        <button type="button" class="module-tab active" data-status="all">All <span class="tab-count" data-count="all"></span></button>
        <button type="button" class="module-tab" data-status="in_progress">In Progress <span class="tab-count" data-count="in_progress"></span></button>
        <button type="button" class="module-tab" data-status="passed">Passed <span class="tab-count" data-count="passed"></span></button>
    </div>

    <div class="module-display-card">
        <div class="display-card-header">
            <span class="display-card-title" id="displayTitle">All students</span>
            <span class="display-card-count" id="displayCount">{{ $students->count() }}</span>
        </div>

        <div id="studentList">
            @forelse($students as $row)
                @php $statuses = $row['courses']->pluck('status')->unique()->values()->implode(','); @endphp
                <div class="student-group" data-student-name="{{ strtolower($row['name']) }}" data-statuses="{{ $statuses }}">
                    <button type="button" class="module-row student-toggle">
                        <div class="module-row-icon">
                            <i data-lucide="user"></i>
                        </div>
                        <div class="module-row-info">
                            <span class="module-row-name">{{ $row['name'] }}</span>
                            <div class="module-row-meta">
                                <span class="meta-tag">{{ $row['courses']->count() }} course{{ $row['courses']->count() === 1 ? '' : 's' }}</span>
                            </div>
                        </div>
                        <div class="module-row-actions">
                            <i data-lucide="chevron-down" class="dropdown-chevron"></i>
                        </div>
                    </button>

                    <div class="student-dropdown">
                        @foreach($row['courses'] as $course)
                            <div class="module-row course-row" data-status="{{ $course['status'] }}">
                                <div class="module-row-icon">
                                    <i data-lucide="book-open"></i>
                                </div>
                                <div class="module-row-info">
                                    <span class="module-row-name">{{ $course['title'] }}</span>
                                    <div class="module-row-meta">
                                        <span class="meta-tag">{{ $course['code'] }}</span>
                                        @if($course['grade'])
                                            <span class="meta-tag">Grade: {{ $course['grade'] }}</span>
                                        @else
                                            <span class="meta-tag">In progress</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="module-row-actions">
                                    <a href="{{ route('enrollments.edit', $course['id']) }}" class="btn-edit">
                                        <i data-lucide="pencil"></i>
                                    </a>
                                    <form action="{{ route('enrollments.destroy', $course['id']) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">
                                            <i data-lucide="trash-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="module-empty">No enrollments found.</p>
            @endforelse
        </div>

        @if($students->isNotEmpty())
            <p class="module-empty" id="noResultsMessage" style="display:none;">No students found.</p>
        @endif
    </div>

</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ url('css/modules.css') }}">
    <link rel="stylesheet" href="{{ url('css/enrollments-index.css') }}">
@endpush

@push('scripts')
    <script src="{{ url('js/modules.js') }}"></script>
    <script>
    (function () {
        var groups = Array.prototype.slice.call(document.querySelectorAll('.student-group'));
        var tabs = Array.prototype.slice.call(document.querySelectorAll('.module-tab'));
        var searchInput = document.getElementById('enrollmentSearch');
        var displayTitle = document.getElementById('displayTitle');
        var displayCount = document.getElementById('displayCount');
        var noResults = document.getElementById('noResultsMessage');

        var titles = {
            all: 'All students',
            in_progress: 'Students with courses in progress',
            passed: 'Students with passed courses',
        };

        var activeStatus = 'all';

        function groupStatuses(group) {
            return (group.dataset.statuses || '').split(',').filter(Boolean);
        }

        function applyFilters() {
            var query = (searchInput && searchInput.value || '').trim().toLowerCase();
            var visibleCount = 0;

            groups.forEach(function (group) {
                var matchesStatus = activeStatus === 'all' || groupStatuses(group).indexOf(activeStatus) !== -1;
                var matchesSearch = !query || group.dataset.studentName.indexOf(query) !== -1;
                var visible = matchesStatus && matchesSearch;

                group.classList.toggle('hidden', !visible);

                var rows = group.querySelectorAll('.course-row');
                rows.forEach(function (row) {
                    row.classList.toggle('hidden-by-tab', activeStatus !== 'all' && row.dataset.status !== activeStatus);
                });

                if (visible) visibleCount++;
            });

            displayTitle.textContent = titles[activeStatus];
            displayCount.textContent = visibleCount;
            if (noResults) noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        function updateTabCounts() {
            ['all', 'in_progress', 'passed'].forEach(function (status) {
                var count = groups.filter(function (group) {
                    return status === 'all' || groupStatuses(group).indexOf(status) !== -1;
                }).length;
                var el = document.querySelector('.tab-count[data-count="' + status + '"]');
                if (el) el.textContent = count;
            });
        }

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(function (t) { t.classList.remove('active'); });
                tab.classList.add('active');
                activeStatus = tab.dataset.status;
                applyFilters();
            });
        });

        if (searchInput) {
            searchInput.addEventListener('input', applyFilters);
        }

        groups.forEach(function (group) {
            var toggle = group.querySelector('.student-toggle');
            toggle.addEventListener('click', function () {
                group.classList.toggle('open');
            });
        });

        updateTabCounts();
        applyFilters();
    })();
    </script>
@endpush
