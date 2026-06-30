<?php

namespace App\Http\Controllers;

use App\Services\DepartmentService;
use App\Services\ProfessorService;
use Illuminate\Http\Request;

/**
 * ProfessorController (Student 4).
 */
class ProfessorController extends Controller
{
    public function __construct(
        private ProfessorService $professors,
        private DepartmentService $departments,
    ) {}

    public function index()
    {
        return view('professors.index', [
            'professors' => $this->professors->all(),
        ]);
    }

    public function create()
    {
        return view('professors.create', [
            'departmentOptions' => $this->departmentOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:professors,email'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
        ]);

        $this->professors->create($data);

        return redirect()
            ->route('professors.index')
            ->with('success', 'Professor created successfully.');
    }

    public function edit(int $id)
    {
        $professor = $this->professors->find($id);
        abort_unless($professor, 404);

        return view('professors.edit', [
            'professor' => $professor,
            'departmentOptions' => $this->departmentOptions(),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:professors,email,'.$id],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
        ]);

        $this->professors->update($id, $data);

        return redirect()
            ->route('professors.index')
            ->with('success', 'Professor updated successfully.');
    }

    public function destroy(int $id)
    {
        $this->professors->delete($id);

        return redirect()
            ->route('professors.index')
            ->with('success', 'Professor deleted successfully.');
    }

    /**
     * @return array<int, string>
     */
    private function departmentOptions(): array
    {
        return collect($this->departments->all())
            ->mapWithKeys(fn ($dept) => [$dept->getId() => $dept->getName()])
            ->all();
    }
}
