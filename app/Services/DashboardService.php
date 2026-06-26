<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getTotalStudents(): int
    {
        return (int) DB::table('students')->count();
    }

    public function getTotalCourses(): int
    {
        return (int) DB::table('courses')->count();
    }

    public function getTotalProfessors(): int
    {
        return (int) DB::table('professors')->count();
    }

    public function getTotalEnrollments(): int
    {
        return (int) DB::table('enrollments')->count();
    }

    public function getEnrollmentsByDepartment(): array
    {
        return DB::table('enrollments')
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->join('departments', 'courses.department_id', '=', 'departments.id')
            ->select('departments.name as dept_name', DB::raw('COUNT(*) as count'))
            ->whereNotNull('departments.id')
            ->groupBy('departments.id', 'departments.name')
            ->orderByDesc('count')
            ->limit(6)
            ->get()
            ->map(fn ($row) => [
                'dept'  => $this->abbreviate($row->dept_name),
                'count' => (int) $row->count,
            ])
            ->all();
    }

    public function getGradeDistribution(): array
    {
        $dist = ['Grade A' => 0, 'Grade B' => 0, 'Grade C' => 0, 'Grade F' => 0, 'In Progress' => 0];

        DB::table('enrollments')->select('grade')->get()->each(function ($row) use (&$dist) {
            if ($row->grade === null) {
                $dist['In Progress']++;
            } elseif (str_starts_with(strtoupper($row->grade), 'A')) {
                $dist['Grade A']++;
            } elseif (str_starts_with(strtoupper($row->grade), 'B')) {
                $dist['Grade B']++;
            } elseif (str_starts_with(strtoupper($row->grade), 'C')) {
                $dist['Grade C']++;
            } else {
                $dist['Grade F']++;
            }
        });

        return $dist;
    }

    public function getEnrollmentTrend(): array
    {
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Count enrollments per YYYY-MM key
        $counts = DB::table('enrollments')
            ->select('created_at')
            ->whereNotNull('created_at')
            ->get()
            ->groupBy(fn ($row) => date('Y-m', strtotime((string) $row->created_at)))
            ->map(fn ($items) => $items->count());

        // Always build last 6 months so the chart always has a line
        $result = [];
        for ($i = 5; $i >= 0; $i--) {
            $ts  = strtotime("-{$i} months");
            $key = date('Y-m', $ts);
            $result[] = [
                'month' => $monthNames[(int) date('n', $ts) - 1],
                'count' => $counts->get($key, 0),
            ];
        }

        return $result;
    }

    public function getRecentEnrollments(): array
    {
        return DB::table('enrollments')
            ->join('students', 'enrollments.student_id', '=', 'students.id')
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->leftJoin('departments', 'courses.department_id', '=', 'departments.id')
            ->select(
                'students.name as student_name',
                'students.student_number',
                'courses.course_code',
                'departments.name as department_name',
                'enrollments.grade',
            )
            ->orderByDesc('enrollments.id')
            ->limit(5)
            ->get()
            ->all();
    }

    public function getCourseDistributions(): array
    {
        // Only count enrollments that have a proper department
        $withDept = (int) DB::table('enrollments')
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->join('departments', 'courses.department_id', '=', 'departments.id')
            ->whereNotNull('departments.id')
            ->count();

        if ($withDept === 0) {
            return [];
        }

        return DB::table('enrollments')
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->join('departments', 'courses.department_id', '=', 'departments.id')
            ->select('departments.name as dept_name', DB::raw('COUNT(*) as count'))
            ->whereNotNull('departments.id')
            ->groupBy('departments.id', 'departments.name')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->map(fn ($row) => [
                'name'       => $row->dept_name,
                'abbr'       => $this->abbreviate($row->dept_name),
                'count'      => (int) $row->count,
                'percentage' => (int) round(($row->count / $withDept) * 100),
            ])
            ->all();
    }

    public function getDepartmentCards(): array
    {
        return DB::table('departments')
            ->leftJoin('courses', 'departments.id', '=', 'courses.department_id')
            ->leftJoin('professors', 'departments.id', '=', 'professors.department_id')
            ->leftJoin('students', 'departments.id', '=', 'students.department_id')
            ->select(
                'departments.id',
                'departments.name',
                DB::raw('COUNT(DISTINCT courses.id) as course_count'),
                DB::raw('COUNT(DISTINCT professors.id) as professor_count'),
                DB::raw('COUNT(DISTINCT students.id) as student_count'),
            )
            ->groupBy('departments.id', 'departments.name')
            ->limit(4)
            ->get()
            ->all();
    }

    public function getRadarData(): array
    {
        $deptCount   = max(1, DB::table('departments')->count());
        $professors  = DB::table('professors')->count();
        $courses     = DB::table('courses')->count();
        $enrollments = DB::table('enrollments')->count();
        $students    = max(1, DB::table('students')->count());
        $avgCredit   = (float) (DB::table('courses')->avg('credit_hours') ?? 3);

        return [
            (int) round(min(100, ($professors / $deptCount) * 20)),       // Research
            (int) round(min(100, ($courses / $deptCount) * 12)),          // Teaching
            (int) round(min(100, ($avgCredit / 12) * 100)),               // Publishing
            (int) round(min(100, ($enrollments / $students) * 35)),       // Grants
            (int) round(min(100, $deptCount * 8)),                        // Admin
        ];
    }

    private function abbreviate(?string $name): string
    {
        if (!$name) {
            return 'N/A';
        }
        $words = preg_split('/\s+/', trim($name));
        if (count($words) >= 2) {
            return strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
        }

        return strtoupper(mb_substr($name, 0, 2));
    }
}
