# Adding a New CRUD Module

This guide walks you through adding a brand-new module to the University Portal, end to end, following the exact pattern every existing module uses:

```
Migration  →  DTO  →  Service  →  Controller  →  Routes  →  Views
```

We'll build a complete example module: **Classrooms** (rooms that belong to a department). By the end you'll have a working Create / Read / Update / Delete screen.

> New here? Read **[ARCHITECTURE.md](ARCHITECTURE.md)** first to see how the layers fit together, and keep **[CHEATSHEET.md](CHEATSHEET.md)** open for quick snippets.

---

## The pattern at a glance

Every module is the same six pieces:

| # | Layer | File(s) | Job |
|---|-------|---------|-----|
| 1 | Migration | `database/migrations/...` | Create the database table |
| 2 | DTO | `app/DTOs/XDTO.php` | Carry one row's data (getters) |
| 3 | Service | `app/Services/XService.php` | All DB access; returns DTOs |
| 4 | Controller | `app/Http/Controllers/XController.php` | Connect requests to the service + views |
| 5 | Routes | `routes/web.php` | Map URLs to the controller |
| 6 | Views | `resources/views/x/{index,create,edit}.blade.php` | The screens |

Our example entity **Classroom** has these fields:

- `room_name` — text, required (e.g. "Room 101")
- `building` — text, optional
- `capacity` — number, required
- `department_id` — optional link to a department (dropdown)

---

## Step 1 — Migration (create the table)

Generate a migration:

```bash
php artisan make:migration create_classrooms_table
```

Open the new file in `database/migrations/` and define the table:

```php
public function up(): void
{
    Schema::create('classrooms', function (Blueprint $table) {
        $table->id();
        $table->string('room_name');
        $table->string('building')->nullable();
        $table->unsignedInteger('capacity')->default(0);
        $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('classrooms');
}
```

Run it:

```bash
php artisan migrate
```

> `constrained()` links `department_id` to the `departments` table automatically. `nullOnDelete()` means if a department is deleted, its classrooms survive with `department_id = null`.

---

## Step 2 — DTO (the data carrier)

Create `app/DTOs/ClassroomDTO.php`. It holds one classroom's data in **private** properties and exposes **getters** — this is the encapsulation part (W11):

```php
<?php

namespace App\DTOs;

class ClassroomDTO
{
    public function __construct(
        private ?int $id,
        private string $roomName,
        private ?string $building = null,
        private int $capacity = 0,
        private ?int $departmentId = null,
        private ?string $departmentName = null,
    ) {}

    public static function fromRow(object $row): self
    {
        return new self(
            id: (int) $row->id,
            roomName: $row->room_name,
            building: $row->building,
            capacity: (int) $row->capacity,
            departmentId: $row->department_id !== null ? (int) $row->department_id : null,
            departmentName: $row->department_name ?? null,
        );
    }

    public function getId(): ?int { return $this->id; }
    public function getRoomName(): string { return $this->roomName; }
    public function getBuilding(): ?string { return $this->building; }
    public function getCapacity(): int { return $this->capacity; }
    public function getDepartmentId(): ?int { return $this->departmentId; }
    public function getDepartmentName(): ?string { return $this->departmentName; }
}
```

> `fromRow()` turns a raw database row (a `stdClass`) into a typed object. The `department_name` value comes from a JOIN we write in the service next.

---

## Step 3 — Service (all the data access)

Create `app/Services/ClassroomService.php`. This is the **only** place that talks to the database. Every public method returns DTOs:

```php
<?php

namespace App\Services;

use App\DTOs\ClassroomDTO;
use Illuminate\Support\Facades\DB;

class ClassroomService
{
    private string $table = 'classrooms';

    /** @return ClassroomDTO[] */
    public function all(): array
    {
        return $this->baseQuery()
            ->orderBy('classrooms.room_name')
            ->get()
            ->map(fn ($row) => ClassroomDTO::fromRow($row))
            ->all();
    }

    public function find(int $id): ?ClassroomDTO
    {
        $row = $this->baseQuery()->where('classrooms.id', $id)->first();

        return $row ? ClassroomDTO::fromRow($row) : null;
    }

    public function create(array $data): void
    {
        DB::table($this->table)->insert([
            'room_name' => $data['room_name'],
            'building' => $data['building'] ?? null,
            'capacity' => $data['capacity'] ?? 0,
            'department_id' => $data['department_id'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function update(int $id, array $data): void
    {
        DB::table($this->table)->where('id', $id)->update([
            'room_name' => $data['room_name'],
            'building' => $data['building'] ?? null,
            'capacity' => $data['capacity'] ?? 0,
            'department_id' => $data['department_id'] ?? null,
            'updated_at' => now(),
        ]);
    }

    public function delete(int $id): void
    {
        DB::table($this->table)->delete($id);
    }

    private function baseQuery()
    {
        return DB::table('classrooms')
            ->leftJoin('departments', 'classrooms.department_id', '=', 'departments.id')
            ->select('classrooms.*', 'departments.name as department_name');
    }
}
```

> Notice this is almost a copy of `CourseService` — once you know one service, you know them all.

---

## Step 4 — Controller (the glue)

Generate it with Artisan:

```bash
php artisan make:controller ClassroomController
```

Then fill in `app/Http/Controllers/ClassroomController.php`:

```php
<?php

namespace App\Http\Controllers;

use App\Services\ClassroomService;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function __construct(
        private ClassroomService $classrooms,
        private DepartmentService $departments,
    ) {}

    public function index()
    {
        return view('classrooms.index', [
            'classrooms' => $this->classrooms->all(),
        ]);
    }

    public function create()
    {
        return view('classrooms.create', [
            'departmentOptions' => $this->departmentOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_name' => ['required', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:0', 'max:100000'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
        ]);

        $this->classrooms->create($data);

        return redirect()->route('classrooms.index')->with('success', 'Classroom created successfully.');
    }

    public function edit(int $id)
    {
        $classroom = $this->classrooms->find($id);
        abort_unless($classroom, 404);

        return view('classrooms.edit', [
            'classroom' => $classroom,
            'departmentOptions' => $this->departmentOptions(),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'room_name' => ['required', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:0', 'max:100000'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
        ]);

        $this->classrooms->update($id, $data);

        return redirect()->route('classrooms.index')->with('success', 'Classroom updated successfully.');
    }

    public function destroy(int $id)
    {
        $this->classrooms->delete($id);

        return redirect()->route('classrooms.index')->with('success', 'Classroom deleted successfully.');
    }

    /** @return array<int, string> */
    private function departmentOptions(): array
    {
        return collect($this->departments->all())
            ->mapWithKeys(fn ($d) => [$d->getId() => $d->getName()])
            ->all();
    }
}
```

---

## Step 5 — Routes

Open `routes/web.php`, add the import at the top, and register the resource:

```php
use App\Http\Controllers\ClassroomController;

Route::resource('classrooms', ClassroomController::class)->except('show');
```

Check it worked:

```bash
php artisan route:list --name=classrooms
```

You should see the index / create / store / edit / update / destroy routes.

---

## Step 6 — Views

Create the folder `resources/views/classrooms/` and add three files.

### `index.blade.php` — the list (Read)

```blade
@extends('layouts.app')

@section('title', 'Classrooms')

@section('content')
    <div class="page-head">
        <h1>Classrooms</h1>
        <x-button :href="route('classrooms.create')">+ New Classroom</x-button>
    </div>

    <x-card>
        @if (count($classrooms) === 0)
            <p class="empty">No classrooms yet.</p>
        @else
            <table class="table">
                <thead>
                    <tr><th>#</th><th>Room</th><th>Building</th><th>Capacity</th><th>Department</th><th></th></tr>
                </thead>
                <tbody>
                    @foreach ($classrooms as $classroom)
                        <tr>
                            <td>{{ $classroom->getId() }}</td>
                            <td>{{ $classroom->getRoomName() }}</td>
                            <td>{{ $classroom->getBuilding() ?? '-' }}</td>
                            <td>{{ $classroom->getCapacity() }}</td>
                            <td>{{ $classroom->getDepartmentName() ?? '-' }}</td>
                            <td>
                                <x-button :href="route('classrooms.edit', $classroom->getId())" variant="secondary">Edit</x-button>
                                <form action="{{ route('classrooms.destroy', $classroom->getId()) }}" method="POST"
                                      style="display:inline" onsubmit="return confirm('Delete this classroom?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger">Delete</x-button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </x-card>
@endsection
```

### `create.blade.php` — the new form (Create)

```blade
@extends('layouts.app')

@section('title', 'New Classroom')

@section('content')
    <div class="page-head"><h1>New Classroom</h1></div>

    <x-card>
        <form action="{{ route('classrooms.store') }}" method="POST" class="form">
            @csrf

            <x-form-input name="room_name" label="Room Name" required />
            <x-form-input name="building" label="Building" />
            <x-form-input name="capacity" label="Capacity" type="number" value="0" required />

            <div class="form-group">
                <label for="department_id">Department</label>
                <select name="department_id" id="department_id" class="form-control">
                    <option value="">- Select -</option>
                    @foreach ($departmentOptions as $id => $name)
                        <option value="{{ $id }}" @selected(old('department_id') == $id)>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-actions">
                <x-button type="submit">Save Classroom</x-button>
                <x-button :href="route('classrooms.index')" variant="secondary">Cancel</x-button>
            </div>
        </form>
    </x-card>
@endsection
```

### `edit.blade.php` — the edit form (Update)

```blade
@extends('layouts.app')

@section('title', 'Edit Classroom')

@section('content')
    <div class="page-head"><h1>Edit Classroom</h1></div>

    <x-card>
        <form action="{{ route('classrooms.update', $classroom->getId()) }}" method="POST" class="form">
            @csrf
            @method('PUT')

            <x-form-input name="room_name" label="Room Name" :value="$classroom->getRoomName()" required />
            <x-form-input name="building" label="Building" :value="$classroom->getBuilding()" />
            <x-form-input name="capacity" label="Capacity" type="number" :value="$classroom->getCapacity()" required />

            <div class="form-group">
                <label for="department_id">Department</label>
                <select name="department_id" id="department_id" class="form-control">
                    <option value="">- Select -</option>
                    @foreach ($departmentOptions as $id => $name)
                        <option value="{{ $id }}" @selected(old('department_id', $classroom->getDepartmentId()) == $id)>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-actions">
                <x-button type="submit">Update Classroom</x-button>
                <x-button :href="route('classrooms.index')" variant="secondary">Cancel</x-button>
            </div>
        </form>
    </x-card>
@endsection
```

---

## Step 7 — Add it to the navigation

Open `resources/views/layouts/app.blade.php` and add a link so people can reach your page. In this project the nav is built from a `$links` array — add one entry:

```php
'classrooms' => 'Classrooms',
```

(Or, if you wrote a plain nav, just add `<a href="{{ route('classrooms.index') }}">Classrooms</a>`.)

---

## Step 8 — (Optional) Seed some sample data

In `database/seeders/DatabaseSeeder.php`, add a few rows so the page isn't empty:

```php
DB::table('classrooms')->insert([
    ['room_name' => 'Room 101', 'building' => 'Main Hall',     'capacity' => 40, 'department_id' => null, 'created_at' => now(), 'updated_at' => now()],
    ['room_name' => 'Lab A',    'building' => 'Science Block', 'capacity' => 25, 'department_id' => null, 'created_at' => now(), 'updated_at' => now()],
]);
```

Then reload everything:

```bash
php artisan migrate:fresh --seed
```

---

## Step 9 — Try it

```bash
php artisan serve
```

Visit `http://127.0.0.1:8000/classrooms` and test every button — create a room, edit it, delete it.

---

## Done — what you created

```
database/migrations/xxxx_create_classrooms_table.php   (new)
app/DTOs/ClassroomDTO.php                              (new)
app/Services/ClassroomService.php                      (new)
app/Http/Controllers/ClassroomController.php           (new)
routes/web.php                                         (added 1 line)
resources/views/classrooms/index.blade.php             (new)
resources/views/classrooms/create.blade.php            (new)
resources/views/classrooms/edit.blade.php              (new)
resources/views/layouts/app.blade.php                  (added a nav link)
```

That's the whole pattern. **Every** module — students, courses, professors — is built exactly like this. To add another, copy a module and rename.

---

## Bonus: adding a single (non-CRUD) page

Sometimes you just want one page — an "About", a report — with no database table.

**Option A — a static page, no controller:**

```php
// routes/web.php
Route::view('/about', 'about')->name('about');
```

```blade
{{-- resources/views/about.blade.php --}}
@extends('layouts.app')
@section('title', 'About')
@section('content')
    <x-card title="About">
        <p>This portal was built for the web development course.</p>
    </x-card>
@endsection
```

**Option B — a page that needs data (use a controller method):**

```php
// routes/web.php
Route::get('/stats', [StatsController::class, 'index'])->name('stats');
```

```php
// app/Http/Controllers/StatsController.php
public function index(\App\Services\StudentService $students)
{
    return view('stats', ['total' => count($students->all())]);
}
```

```blade
{{-- resources/views/stats.blade.php --}}
@extends('layouts.app')
@section('content')
    <x-card title="Stats">We have {{ $total }} students.</x-card>
@endsection
```

---

## Common gotchas

- **`@csrf` on every form** — Laravel rejects POST/PUT/DELETE without it.
- **`@method('PUT')` / `@method('DELETE')`** — HTML forms only do GET/POST, so these tell Laravel the real verb.
- **Route names must match the resource** — the controller redirects to `classrooms.index`, so the resource name must be `classrooms`.
- **Validation keys == input `name`** — input `name="room_name"` ⇒ validate `'room_name'`.
- **`exists:departments,id`** — rejects a department id that doesn't exist.
- **Dropdowns** — submit the department's **id**, display its **name**.
