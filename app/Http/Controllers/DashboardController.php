<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboard) {}

    public function index()
    {
        return view('dashboard.index', [
            'totalStudents'       => $this->dashboard->getTotalStudents(),
            'totalCourses'        => $this->dashboard->getTotalCourses(),
            'totalProfessors'     => $this->dashboard->getTotalProfessors(),
            'totalEnrollments'    => $this->dashboard->getTotalEnrollments(),
            'enrollmentsByDept'   => $this->dashboard->getEnrollmentsByDepartment(),
            'gradeDistribution'   => $this->dashboard->getGradeDistribution(),
            'enrollmentTrend'     => $this->dashboard->getEnrollmentTrend(),
            'recentEnrollments'   => $this->dashboard->getRecentEnrollments(),
            'courseDistributions' => $this->dashboard->getCourseDistributions(),
            'departmentCards'     => $this->dashboard->getDepartmentCards(),
            'radarData'           => $this->dashboard->getRadarData(),
        ]);
    }
}
