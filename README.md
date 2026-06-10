# University Portal — Student Starter

Welcome! This is a partially-built Laravel application. The **back end is done for you** — your job is to build the **routes and the views** so the portal actually works in the browser.

When you are finished you will have a working university management system with five modules: **Departments, Students, Courses, Professors,** and **Enrollments**.

> 📚 **New to this pattern?** Read [`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md) to see how the pieces fit together, follow [`docs/ADDING-A-CRUD-MODULE.md`](docs/ADDING-A-CRUD-MODULE.md) for a full worked example, and keep [`docs/CHEATSHEET.md`](docs/CHEATSHEET.md) open while you build.

---

## What is already provided (do NOT change these)

| Layer | Files | What it does |
| --- | --- | --- |
| **Controllers** | `app/Http/Controllers/*Controller.php` | Receive the request, call a service, return a view |
| **Services** | `app/Services/*Service.php` | All the data access / business logic |
| **DTOs** | `app/DTOs/*DTO.php` | Plain objects that carry one record's data |
| **Migrations** | `database/migrations/2025_01_01_*` | Create the database tables |
| **Seeder** | `database/seeders/DatabaseSeeder.php` | Fills the database with sample data |
| **Stylesheet** | `public/css/app.css` | Ready-made CSS classes you may use for styling |

## What YOU build

| Layer | Files | Outcome |
| --- | --- | --- |
| **Routes** | `routes/web.php` | Wire the 5 controllers to URLs |
| **Layout** | `resources/views/layouts/app.blade.php` | The shared page frame (W13) |
| **Components** | `resources/views/components/{button,form-input,card}.blade.php` | Reusable `<x-...>` tags (W14) |
| **Module views** | `resources/views/{departments,students,courses,professors,enrollments}/{index,create,edit}.blade.php` | The 15 CRUD screens (W10) |

Every one of those files already exists with a **comment inside telling you exactly what to build and what data it receives** — open them and follow the `TODO`.

---

## Getting started

```bash
cd university-portal-starter

# 1. install PHP dependencies
composer install

# 2. create your environment file and generate the app key
cp .env.example .env
php artisan key:generate

# 3. create the (empty) SQLite database file
#    On Windows, just create an empty file at database/database.sqlite
touch database/database.sqlite

# 4. create the tables and load the sample data
php artisan migrate:fresh --seed

# 5. run the app
php artisan serve
```

Then open **http://127.0.0.1:8000**. (Pages will be blank until you build the views — that's expected!)

---

## Your task list

1. **Routes** (`routes/web.php`) — register a resource route for each controller. The resource names must be `departments`, `students`, `courses`, `professors`, `enrollments`.
2. **Layout** — build `layouts/app.blade.php` with a nav bar and `@yield('content')`.
3. **Components** — build `<x-button>`, `<x-form-input>`, `<x-card>`.
4. **Departments** → **Students** → **Courses** → **Professors** → **Enrollments** — build the `index`, `create`, and `edit` view for each. Do them in that order; the pattern repeats.

Tip: get **Departments** fully working first (routes + layout + components + its 3 views). Once one module clicks, the other four are the same shape.

---

## Data contract (quick reference)

Your views receive **objects** (DTOs) and **arrays**. Read each value with a getter method, e.g. `{{ $student->getName() }}`.

**DTO getters**

| DTO | Methods |
| --- | --- |
| `DepartmentDTO` | `getId() getName()` |
| `StudentDTO` | `getId() getName() getEmail() getStudentNumber() getDepartmentId() getDepartmentName()` |
| `CourseDTO` | `getId() getTitle() getCourseCode() getCreditHours() getDepartmentId() getDepartmentName()` |
| `ProfessorDTO` | `getId() getName() getEmail() getDepartmentId() getDepartmentName()` |
| `EnrollmentDTO` | `getId() getStudentId() getCourseId() getGrade() getStudentName() getCourseTitle() getCourseCode()` |

**Form field names** (what each `store`/`update` expects — use them as your input `name=""`)

| Module | Fields |
| --- | --- |
| Departments | `name` |
| Students | `name`, `email`, `student_number`, `department_id` |
| Courses | `title`, `course_code`, `credit_hours`, `department_id` |
| Professors | `name`, `email`, `department_id` |
| Enrollments | `student_id`, `course_id`, `grade` |

**Remember for every form:** add `@csrf`. For edit/update forms also add `@method('PUT')`, and for delete buttons use a small `POST` form with `@method('DELETE')`.

---

## What you are being assessed on (ILOs)

- **W10** — processing form data and looping over arrays with `@foreach` in your views.
- **W11** — (provided) OOP Controllers, Services and DTOs — read them to see encapsulation in action.
- **W12** — Laravel + MVC: your routes connect URLs to the provided controllers.
- **W13** — your `layouts/app.blade.php` master layout, extended by every view.
- **W14** — your reusable `<x-button>`, `<x-form-input>`, `<x-card>` components.

Good luck!
