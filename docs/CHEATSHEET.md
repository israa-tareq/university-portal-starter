# Cheat Sheet

Quick reference for working on the University Portal.

## Artisan commands

```bash
php artisan serve                        # run the app at http://127.0.0.1:8000
php artisan make:controller XController  # new controller
php artisan make:migration create_xs_table
php artisan migrate                      # run new migrations
php artisan migrate:fresh --seed         # wipe + rebuild + reload sample data
php artisan route:list                   # show all routes
php artisan tinker                       # interactive PHP shell
php artisan test                         # run the tests
```

## The CRUD map

One line — `Route::resource('students', StudentController::class)` — creates all of these:

| Verb | URL | Controller method | Purpose |
|------|-----|-------------------|---------|
| GET | `/students` | `index` | list (Read) |
| GET | `/students/create` | `create` | show the new form |
| POST | `/students` | `store` | save new (Create) |
| GET | `/students/{id}/edit` | `edit` | show the edit form |
| PUT | `/students/{id}` | `update` | save changes (Update) |
| DELETE | `/students/{id}` | `destroy` | delete (Delete) |

## Blade snippets

**Extend the layout:**
```blade
@extends('layouts.app')
@section('title', 'Page Title')
@section('content')
    ...
@endsection
```

**Loop an array of DTOs:**
```blade
@foreach ($students as $student)
    {{ $student->getName() }}
@endforeach
```

**Create form:**
```blade
<form action="{{ route('students.store') }}" method="POST">
    @csrf
    <x-form-input name="name" label="Name" required />
    <x-button type="submit">Save</x-button>
</form>
```

**Edit form (note the PUT):**
```blade
<form action="{{ route('students.update', $student->getId()) }}" method="POST">
    @csrf
    @method('PUT')
    <x-form-input name="name" label="Name" :value="$student->getName()" required />
    <x-button type="submit">Update</x-button>
</form>
```

**Delete button:**
```blade
<form action="{{ route('students.destroy', $student->getId()) }}" method="POST"
      onsubmit="return confirm('Delete?')">
    @csrf
    @method('DELETE')
    <x-button type="submit" variant="danger">Delete</x-button>
</form>
```

**Dropdown from an `[id => name]` array:**
```blade
<select name="department_id" class="form-control">
    <option value="">- Select -</option>
    @foreach ($departmentOptions as $id => $name)
        <option value="{{ $id }}" @selected(old('department_id') == $id)>{{ $name }}</option>
    @endforeach
</select>
```

## Validation rules (in the controller)

```php
$data = $request->validate([
    'name'          => ['required', 'string', 'max:255'],
    'email'         => ['required', 'email', 'max:255'],
    'capacity'      => ['required', 'integer', 'min:0'],
    'department_id' => ['nullable', 'integer', 'exists:departments,id'],
]);
```

| Rule | Meaning |
|------|---------|
| `required` | must be present |
| `nullable` | may be left empty |
| `string` / `integer` / `email` | the type |
| `max:255` / `min:0` | length or value bounds |
| `exists:departments,id` | the value must exist in that table |

## DTO getters (existing modules)

| DTO | Getters |
|-----|---------|
| `DepartmentDTO` | `getId` `getName` |
| `StudentDTO` | `getId` `getName` `getEmail` `getStudentNumber` `getDepartmentId` `getDepartmentName` |
| `CourseDTO` | `getId` `getTitle` `getCourseCode` `getCreditHours` `getDepartmentId` `getDepartmentName` |
| `ProfessorDTO` | `getId` `getName` `getEmail` `getDepartmentId` `getDepartmentName` |
| `EnrollmentDTO` | `getId` `getStudentId` `getCourseId` `getGrade` `getStudentName` `getCourseTitle` `getCourseCode` |

## CSS classes you can use (from `public/css/app.css`)

`.page-head` `.card` `.card-header` `.card-body` `.table` `.btn` `.btn-primary` `.btn-secondary` `.btn-danger` `.form-group` `.form-control` `.form-error` `.alert` `.badge` `.empty`
