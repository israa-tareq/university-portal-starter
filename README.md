# LIMU University Portal

A web-based university management system built with **Laravel** (PHP) for managing students, courses, professors, departments, and enrollments — with full authentication and a live analytics dashboard.

---

## Project Overview

The LIMU University Portal is an internal management tool for university administrators. It provides a clean, role-protected interface for all core academic data, with real-time statistics and charts on the dashboard.

**Tech stack:** Laravel 11 · PHP 8.4 · SQLite · Blade Templates · Chart.js · Bootstrap Icons · Lucide Icons

---

## Features

- **Authentication** — Secure login and registration with session-based auth and protected routes
- **Dashboard** — Live stats (students, courses, professors, enrollments) with bar, donut, radar, and line charts
- **Departments** — Full CRUD for university departments
- **Students** — Full CRUD for student records
- **Courses** — Full CRUD for course catalog
- **Professors** — Full CRUD for faculty members
- **Enrollments** — Full CRUD for student–course enrollments with grade tracking
- **Collapsible sidebar** — Responsive side navigation that collapses to icons on desktop and slides in on mobile

---

## Getting Started

### Requirements
- PHP 8.2+
- Composer

### Setup

```bash
# 1. Install PHP dependencies
composer install

# 2. Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# 3. Make sure your .env has:
#    SESSION_DRIVER=file

# 4. Run migrations and seed sample data
php artisan migrate:fresh --seed
php artisan portal:seed-auth

# 5. Start the development server
php artisan serve
```

Then open `http://localhost:8000` and log in with:

| Role  | Email           | Password |
|-------|-----------------|----------|
| Admin | admin@uni.edu   | password |
| User  | student@uni.edu | password |

---

## Team & Contributions

| Name            | Contributions |
|-----------------|---------------|
| **Abdel Hady**  | Overall layout design and system architecture · Departments module (views, controller, service) |
| **Israa**       | Authentication integration (connecting login/signup to the portal) · Courses module · Dashboard page |
| **Ghanima**     | Reusable Blade components (button, card, form-input, form-select) · Students module |
| **Yahya**       | Login and signup page UI/UX design · Professors module · Enrollments module |

---

## Project Structure

```
app/
├── Http/Controllers/    # One controller per module + AuthController + DashboardController
├── Models/              # User model
├── Services/            # Business logic layer (one service per module)
└── DTOs/                # Data Transfer Objects for each module

resources/views/
├── auth/                # Login & register pages
├── layouts/             # Main layout with collapsible sidebar
├── components/          # Reusable Blade components
├── dashboard/           # Dashboard with charts
├── departments/         # Department CRUD views
├── students/            # Student CRUD views
├── courses/             # Course CRUD views
├── professors/          # Professor CRUD views
└── enrollments/         # Enrollment CRUD views

routes/
└── web.php              # All application routes
```

---

&copy; 2025 LIMU · Benghazi, Libya
