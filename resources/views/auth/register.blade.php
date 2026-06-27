<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up — LIMU</title>
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
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 0;
    }

    .signup-box {
      background-color: var(--panel);
      padding: 40px;
      border-radius: 14px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.45);
      width: 400px;
      box-sizing: border-box;
      position: relative;
      overflow: hidden;
    }

    .signup-box::before {
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

    .signup-box h1 {
      text-align: center;
      color: #ffffff;
      font-size: 22px;
      margin: 0 0 6px;
    }

    .join-us-text {
      color: var(--muted);
      margin-bottom: 16px;
      text-align: center;
    }

    .signup-box input {
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

    .signup-box input:focus {
      outline: none;
      border-color: var(--teal);
      box-shadow: 0 0 0 3px rgba(15, 164, 175, 0.25);
    }

    .signup-box input::placeholder { color: var(--muted); }

    .signup-box form p {
      margin: 0 0 4px 0;
      color: #ffffff;
      font-size: 14px;
    }

    .input-wrapper {
      position: relative;
      margin-bottom: 16px;
    }

    .input-wrapper input { padding-right: 42px; }

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

    .signup-btn {
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

    .signup-btn:hover {
      background-color: var(--teal-bright);
      box-shadow: 0 8px 24px rgba(15, 164, 175, 0.5);
    }

    .signup-btn:active {
      transform: scale(0.98);
      background-color: var(--teal-deep);
    }

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

    .divider {
      width: 100%;
      height: 1px;
      background-color: var(--line);
      margin: 20px 0;
      border: none;
    }

    .profile-section-label {
      color: #ffffff;
      font-size: 14px;
      margin: 0 0 10px 0;
      text-align: center;
    }

    .selected-preview {
      width: 60px;
      height: 60px;
      border-radius: 25%;
      border: 2px solid var(--line);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      font-weight: 700;
      color: var(--muted);
      background-color: var(--field);
      margin: 0 auto 14px auto;
      transition: background-color 0.2s ease, border-color 0.2s ease;
      overflow: hidden;
    }

    .profile-pic {
      display: flex;
      flex-direction: row;
      justify-content: center;
      gap: 10px;
      flex-wrap: wrap;
    }

    .circle-option {
      width: 55px;
      height: 55px;
      border-radius: 25%;
      border: 2px solid #0a4347;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      font-weight: 700;
      color: #ffffff;
      cursor: pointer;
      position: relative;
      filter: brightness(0.55);
      transition: filter 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
      user-select: none;
      flex-shrink: 0;
    }

    .circle-option:hover { filter: brightness(1); }

    .circle-option.selected {
      filter: brightness(1);
      border: 2px solid transparent;
      box-shadow: 0 0 0 2px rgba(15, 164, 175, 0.55);
    }

    .circle-option .tick {
      display: none;
      position: absolute;
      top: -5px;
      right: -5px;
      width: 15px;
      height: 15px;
      background-color: var(--teal);
      border-radius: 50%;
      align-items: center;
      justify-content: center;
      font-size: 9px;
      color: white;
      font-weight: 900;
    }

    .circle-option.selected .tick { display: flex; }

    .upload-btn {
      display: block;
      margin: 12px auto 0 auto;
      padding: 7px 18px;
      border: 1px solid var(--line);
      border-radius: 8px;
      background-color: var(--field);
      color: var(--muted);
      font-size: 13px;
      cursor: pointer;
      transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    }

    .upload-btn:hover {
      background-color: #033a3f;
      border-color: var(--teal);
      color: #ffffff;
    }
  </style>
</head>
<body>
  <div class="signup-box">
    <div class="brand">
      <div class="brand-logo"><i class="bi bi-mortarboard-fill"></i></div>
      <div class="brand-name">
        <span class="name">LIMU</span>
        <span class="sub">LEARNING MANAGEMENT</span>
      </div>
    </div>
    <h1>Sign Up</h1>
    <p class="join-us-text">Join us today! It takes only a few steps</p>

    <p class="profile-section-label">Choose a profile picture</p>
    <div class="selected-preview" id="selectedPreview">
      <i class="bi bi-person" style="font-size: 24px; color: #555;"></i>
    </div>
    <div class="profile-pic">
      <div class="circle-option" style="background-color: #2A3A5C;" data-label="WB" onclick="selectAvatar(this)">
        WB<span class="tick">✓</span>
      </div>
      <div class="circle-option" style="background-color: #3D2E52;" data-label="MM" onclick="selectAvatar(this)">
        MM<span class="tick">✓</span>
      </div>
      <div class="circle-option" style="background-color: #1E3A3A;" data-label="KK" onclick="selectAvatar(this)">
        KK<span class="tick">✓</span>
      </div>
      <div class="circle-option" style="background-color: #444441;" data-label="SL" onclick="selectAvatar(this)">
        SL<span class="tick">✓</span>
      </div>
      <div class="circle-option" style="background-color: #7A3B3B;" data-label="AR" onclick="selectAvatar(this)">
        AR<span class="tick">✓</span>
      </div>
    </div>
    <button class="upload-btn" type="button" onclick="document.getElementById('photoUpload').click()">
      <i class="bi bi-upload"></i> Upload photo
    </button>
    <input type="file" id="photoUpload" accept="image/*" style="display: none;" onchange="previewPhoto(this)">

    <hr class="divider">

    <form action="{{ route('register') }}" method="POST">
      @csrf
      @if($errors->any())
        <div style="background:#fee2e2;border:1px solid #fca5a5;border-radius:8px;padding:10px 14px;margin-bottom:14px;font-size:13px;color:#dc2626;">
          @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      @endif
      <p>Full Name</p>
      <div class="input-wrapper">
        <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
      </div>
      <p>Email</p>
      <div class="input-wrapper">
        <input type="email" name="email" placeholder="Email address" value="{{ old('email') }}" required>
      </div>
      <p>Password</p>
      <div class="input-wrapper">
        <input type="password" name="password" id="passwordInput" placeholder="Password" required>
        <button type="button" class="toggle-password" onclick="togglePassword()" id="eyeBtn">
          <i class="bi bi-eye-slash" id="eyeIcon"></i>
        </button>
      </div>
      <p>Confirm Password</p>
      <div class="input-wrapper">
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
      </div>
      <button type="submit" class="signup-btn">Sign Up</button>
    </form>

    <div class="create-account">
      <p>Already have an account?</p>
      <a href="{{ route('login') }}">Login</a>
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

    function selectAvatar(el) {
      document.querySelectorAll('.circle-option').forEach(c => c.classList.remove('selected'));
      el.classList.add('selected');
      const preview = document.getElementById('selectedPreview');
      preview.style.backgroundColor = el.style.backgroundColor;
      preview.style.borderColor = 'var(--teal)';
      preview.innerHTML = '<span style="color:#fff;font-weight:700;font-size:13px">' + el.dataset.label + '</span>';
    }

    function previewPhoto(input) {
      if (!input.files || !input.files[0]) return;
      const reader = new FileReader();
      reader.onload = function(e) {
        const preview = document.getElementById('selectedPreview');
        preview.style.backgroundColor = '';
        preview.innerHTML = '<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover;">';
        document.querySelectorAll('.circle-option').forEach(c => c.classList.remove('selected'));
      };
      reader.readAsDataURL(input.files[0]);
    }
  </script>
</body>
</html>
