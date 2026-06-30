<?php

namespace App\Http\Controllers;

use App\Services\DepartmentService;
use App\Services\StudentService;
use Illuminate\Http\Request;

/**
 * StudentController (Student 2).
 *
 * Depends on TWO services: StudentService for the CRUD work and
 * DepartmentService to populate the "department" dropdown. Both are
 * injected through the constructor (W11/W12 – dependency injection).
 */
class StudentController extends Controller
{
    public function __construct(
        private StudentService $students,
        private DepartmentService $departments,
    ) {}

    public function index()
    {
        return view('students.index', [
            'students' => $this->students->all(),
        ]);
    }

    public function create()
    {
        return view('students.create', [
            'departmentOptions' => $this->departmentOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email'],
            'student_number' => ['required', 'string', 'max:50'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
        ]);

        $this->students->create($data);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    public function edit(int $id)
    {
        $student = $this->students->find($id);
        abort_unless($student, 404);

        return view('students.edit', [
            'student' => $student,
            'departmentOptions' => $this->departmentOptions(),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email,'.$id],
            'student_number' => ['required', 'string', 'max:50'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
        ]);

        $this->students->update($id, $data);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(int $id)
    {
        $this->students->delete($id);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }

    /**
     * Build a [id => name] map of departments for the <x-form-select>.
     * Uses the DTO getters, so the dropdown is driven by the same objects
     * the rest of the app uses.
     *
     * @return array<int, string>
     */
    private function departmentOptions(): array
    {
        return collect($this->departments->all())
            ->mapWithKeys(fn ($dept) => [$dept->getId() => $dept->getName()])
            ->all();
    }
}
