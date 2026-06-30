<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — LIMU</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    :root {
      --bg-deep: #003135;
      --panel: #024950;
      --teal: #0FA4AF;
      --teal-bright: #1bbcc7;
      --teal-deep: #0c8d97;
      --pale: #AFDDE5;
      --rust: #964734;
      --field: #022b2f;
      --line: #0c5b62;
      --muted: #8fb8bb;
    }

    body {
      margin: 0;
      min-height: 100vh;
      font-family: Arial, sans-serif;
      background:
        radial-gradient(ellipse 70% 50% at 50% 100%, rgba(15,164,175,0.22) 0%, transparent 70%),
        radial-gradient(ellipse at 80% 90%, rgba(2,73,80,0.50) 0%, transparent 50%),
        radial-gradient(ellipse at 15% 85%, rgba(255,255,255,0.14) 0%, transparent 45%),
        var(--bg-deep);
      position: relative;
      isolation: isolate;
    }

    .login-box {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: var(--panel);
      padding: 40px;
      border-radius: 14px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.45);
      width: 400px;
      box-sizing: border-box;
      overflow: hidden;
    }

    .login-box::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, var(--teal), var(--rust), var(--teal));
    }

    .brand {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      margin-bottom: 14px;
    }

    .brand-logo {
      width: 46px;
      height: 46px;
      border-radius: 12px;
      background: var(--teal);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #012427;
      font-size: 24px;
      box-shadow: 0 6px 16px rgba(15, 164, 175, 0.4);
    }

    .brand-name {
      display: flex;
      flex-direction: column;
      line-height: 1;
    }

    .brand-name .name {
      color: #ffffff;
      font-weight: 800;
      font-size: 22px;
      letter-spacing: 1px;
    }

    .brand-name .sub {
      color: var(--teal);
      font-size: 9px;
      font-weight: 700;
      letter-spacing: 3px;
      margin-top: 5px;
    }

    .login-box h1 {
      text-align: center;
      color: white;
      font-size: 22px;
      margin: 0 0 6px;
    }

    .welcome-back-text {
      color: var(--muted);
      margin-bottom: 22px;
      text-align: center;
      font-weight: bold;
      font-size: 14px;
    }

    .login-box form p {
      color: #ffffff;
      margin: 8px 0 4px;
      font-size: 14px;
    }

    .input-wrapper {
      position: relative;
      margin-bottom: 16px;
    }

    .input-wrapper input {
      display: block;
      width: 100%;
      padding: 11px 14px;
      border-radius: 8px;
      border: 1px solid var(--line);
      background-color: var(--field);
      color: white;
      box-sizing: border-box;
      font-size: 15px;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .input-wrapper input:focus {
      outline: none;
      border-color: var(--teal);
      box-shadow: 0 0 0 3px rgba(15, 164, 175, 0.25);
    }

    .input-wrapper input::placeholder {
      color: var(--muted);
    }

    .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      color: var(--muted);
      font-size: 18px;
      padding: 0;
      display: flex;
      align-items: center;
    }

    .toggle-password:hover { color: var(--teal); }

    .login-btn {
      display: block;
      width: 100%;
      padding: 13px;
      margin-top: 6px;
      border: none;
      border-radius: 8px;
      background-color: var(--teal);
      color: #ffffff;
      font-size: 16px;
      font-weight: 700;
      letter-spacing: 0.3px;
      cursor: pointer;
      box-shadow: 0 6px 18px rgba(15, 164, 175, 0.35);
      transition: background-color 0.2s ease, transform 0.1s ease, box-shadow 0.2s ease;
    }

    .login-btn:hover {
      background-color: var(--teal-bright);
      box-shadow: 0 8px 24px rgba(15, 164, 175, 0.5);
    }

    .login-btn:active {
      transform: scale(0.98);
      background-color: var(--teal-deep);
    }

    .restart-password {
      margin-top: 15px;
      text-align: right;
      color: var(--muted);
      font-size: 14px;
      cursor: pointer;
    }

    .restart-password:hover { color: var(--teal); }

    .create-account {
      margin-top: 20px;
      text-align: center;
      display: flex;
      flex-direction: row;
      justify-content: center;
      gap: 6px;
    }

    .create-account p { margin: 0; color: #ffffff; }

    .create-account a {
      color: var(--teal);
      text-decoration: none;
    }

    .create-account a:hover {
      color: var(--pale);
      text-decoration: underline;
    }

    .alert-error {
      background-color: rgba(150, 71, 52, 0.2);
      border: 1px solid var(--rust);
      color: #f5c6bc;
      border-radius: 8px;
      padding: 10px 14px;
      margin-bottom: 16px;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <div class="brand">
      <div class="brand-logo"><i class="bi bi-mortarboard-fill"></i></div>
      <div class="brand-name">
        <span class="name">LIMU</span>
        <span class="sub">LEARNING MANAGEMENT</span>
      </div>
    </div>
    <h1>Login</h1>
    <p class="welcome-back-text">Welcome back! Please login to your account.</p>

    @if($errors->any())
      <div class="alert-error">
        @foreach($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
      @csrf
      <p>Email</p>
      <div class="input-wrapper">
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
      </div>
      <p>Password</p>
      <div class="input-wrapper">
        <input type="password" name="password" id="passwordInput" placeholder="Password" required>
        <button type="button" class="toggle-password" onclick="togglePassword()" id="eyeBtn">
          <i class="bi bi-eye-slash" id="eyeIcon"></i>
        </button>
      </div>
      <button type="submit" class="login-btn">Login</button>
    </form>

    <p class="restart-password">Forgot password?</p>
    <div class="create-account">
      <p>Don't have an account?</p>
      <a href="{{ route('register') }}">Sign up</a>
    </div>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById('passwordInput');
      const icon = document.getElementById('eyeIcon');
      if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye';
      } else {
        input.type = 'password';
        icon.className = 'bi bi-eye-slash';
      }
    }
  </script>
</body>
</html>
