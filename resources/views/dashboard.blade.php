<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard · University Portal</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <span class="brand">🎓 University Portal</span>
            <div style="display: flex; align-items: center; gap: 14px;">
                <span class="muted">Signed in as <strong>{{ auth()->user()->name }}</strong></span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Log out</button>
                </form>
            </div>
        </div>
    </header>

    <main class="container page">
        <div class="page-head">
            <h1>Welcome back, {{ auth()->user()->name }} 👋</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <p>You are signed in. Jump into a module:</p>
                <p style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 12px;">
                    <a class="btn btn-primary" href="/departments">Departments</a>
                    <a class="btn btn-primary" href="/students">Students</a>
                    <a class="btn btn-primary" href="/courses">Courses</a>
                    <a class="btn btn-primary" href="/professors">Professors</a>
                    <a class="btn btn-primary" href="/enrollments">Enrollments</a>
                </p>
                <p class="muted" style="margin-top: 14px; font-size: 0.85rem;">
                    A link 404s until you have added its route and built its view.
                </p>
            </div>
        </div>
    </main>
</body>
</html>
