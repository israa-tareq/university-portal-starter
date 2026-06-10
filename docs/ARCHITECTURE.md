# Architecture

The University Portal uses a clean, layered architecture. Each layer has **one** job and talks only to its neighbours.

## The data flow

```
   Browser
     |  HTTP request  (GET /students)
     v
   Route            routes/web.php
     |  maps the URL to a controller method
     v
   Controller       app/Http/Controllers
     |  asks the service for data (never touches the DB itself)
     v
   Service          app/Services
     |  runs the query, wraps each row in a DTO
     v
   Database         SQLite, via the Query Builder
     |
     v  rows come back
   Service   ->   builds DTO objects   ->   returns DTO[] to the controller
     |
     v
   Controller   ->   passes the DTOs to a view
     v
   Blade view       resources/views  (@extends layout, uses <x-components>)
     |  renders HTML
     v
   Browser
```

## The layers

### 1. Routes — `routes/web.php`
Map URLs to controller methods. We use `Route::resource()`, which creates the standard CRUD routes in a single line.

### 2. Controller — thin glue
- Receives the request.
- Validates form input.
- Calls the service.
- Returns a view (or a redirect).

It **never** runs database queries directly. Keeping controllers thin is the whole point.

### 3. Service — the data layer (encapsulation, W11)
- The **only** place that touches the database.
- Holds its data source in a **private** property (`private string $table`). Tomorrow that could be a `private Http $client` calling a REST API, and nothing else in the app would change.
- Exposes a stable public interface: `all()`, `find()`, `create()`, `update()`, `delete()`.
- Returns **DTOs**, never raw database rows.

### 4. DTO — Data Transfer Object (W11)
- A plain object that carries one record's data.
- **Private** properties + public **getters** = encapsulation.
- Built once via `fromRow()`, then only read.
- Why? Views get a clean, predictable object (`$student->getName()`) instead of guessing column names.

### 5. Views — Blade (W10, W13, W14)
- **Layout** (`layouts/app.blade.php`) — the shared page frame; every view `@extends` it (W13).
- **Components** (`<x-button>`, `<x-form-input>`, `<x-card>`) — reusable UI written once, used everywhere (W14).
- **Module views** — `index` loops the DTO array with `@foreach` (W10); `create` / `edit` are forms.

## Why no Eloquent models?

Laravel normally uses Eloquent models for the database. This project deliberately uses the **Service + DTO** pattern instead, because the course's goal is to practise OOP by hand — writing your own classes, encapsulating data, and passing structured objects around. The usual "Model" role is split between the **Service** (behaviour) and the **DTO** (data).

## The contract between layers

| From → To | What's passed |
|-----------|---------------|
| Service → Controller | a DTO, or an array of DTOs |
| Controller → View | named variables (`'students' => [...]`) |
| View → Controller | form fields (validated by name) |
| Controller → Service | a plain `$data` array |

## Naming conventions

| Thing | Convention | Example |
|-------|-----------|---------|
| Table | plural, snake_case | `students` |
| DTO | singular + `DTO` | `StudentDTO` |
| Service | singular + `Service` | `StudentService` |
| Controller | singular + `Controller` | `StudentController` |
| Route / resource | plural | `students` |
| Views folder | plural | `resources/views/students/` |

## How it maps to the course ILOs

- **W10** — forms (`store` / `update`) + arrays and `@foreach` in views.
- **W11** — OOP: Controller, Service and DTO classes; encapsulation via private properties.
- **W12** — Laravel + MVC + Artisan (`make:controller`, `make:migration`).
- **W13** — the Blade layout every view extends.
- **W14** — the reusable Blade components.

Ready to build something? See **[ADDING-A-CRUD-MODULE.md](ADDING-A-CRUD-MODULE.md)**.
