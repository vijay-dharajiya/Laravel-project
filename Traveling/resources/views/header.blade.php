<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>DreamsTour - Header</title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
*, *::before, *::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

:root {
  --primary: #ff5722;
  --nav-height: 72px;
}

body {
  font-family: 'Outfit', sans-serif;
}

/* ===== NAVBAR ===== */
.navbar {
  background: rgba(41, 85, 129, 0.08);
  backdrop-filter: blur(6px);
  -webkit-backdrop-filter: blur(6px);
  box-shadow: 0 2px 12px rgba(0,0,0,0.25);

  position: absolute;
  width: 100%;
  top: 0;
  left: 0;
  z-index: 9999;

  transition: all 0.3s ease;
}

.navbar.scrolled {
  position: fixed;
  background: rgba(255,255,255,0.65);
  backdrop-filter: blur(8px);
  box-shadow: 0 10px 35px rgba(0,0,0,0.45);
}

/* ===== LAYOUT ===== */
.nav-inner {
  height: var(--nav-height);
}

/* ===== LOGO ===== */
.nav-logo {
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
}

.logo-icon {
  width: 42px;
  height: 42px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #ff5722, #ff8a50);
  color: #fff;
  font-size: 18px;
  box-shadow: 0 0 15px rgba(255,87,34,0.6);
  animation: glow 2.5s infinite ease-in-out;
}

@keyframes glow {
  0%, 100% { box-shadow: 0 0 10px rgba(255,87,34,0.4); }
  50%       { box-shadow: 0 0 25px rgba(255,87,34,0.8); }
}

.logo-text {
  font-size: 22px;
  font-weight: 700;
  color: #fff;
}

.logo-text span {
  color: var(--primary);
}

.navbar.scrolled .logo-text {
  color: #222;
}

/* ===== RIGHT SIDE ===== */
.nav-actions {
  display: flex;
  align-items: center;
  gap: 10px;
}

.btn-login {
  border: 1px solid rgba(255,255,255,0.4);
  padding: 8px 16px;
  border-radius: 8px;
  text-decoration: none;
  color: #fff;
  font-size: 15px;
  font-weight: 500;
  transition: background 0.2s;
}

.navbar.scrolled .btn-login {
  color: #222;
  border-color: rgba(0,0,0,0.3);
}

.btn-login:hover {
  background: rgba(255,255,255,0.1);
}

.btn-register {
  padding: 8px 16px;
  border-radius: 8px;
  background: linear-gradient(135deg, #ff5722, #ff8a50);
  color: #fff;
  text-decoration: none;
  font-size: 15px;
  font-weight: 500;
  transition: opacity 0.2s, transform 0.2s;
}

.btn-register:hover {
  opacity: 0.9;
  transform: translateY(-1px);
}

/* ===== MOBILE AUTH ===== */
.mobile-auth {
  display: flex;
  align-items: center;
  gap: 8px;
}

.mobile-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 14px;
  border-radius: 8px;
  text-decoration: none;
  border: 1px solid rgba(255,255,255,0.4);
  color: #fff;
  font-size: 14px;
  font-weight: 500;
  transition: background 0.2s;
}

.navbar.scrolled .mobile-btn {
  color: #222;
  border-color: rgba(0,0,0,0.3);
}

.mobile-btn:hover {
  background: rgba(255,255,255,0.1);
}

.mobile-btn.primary {
  background: linear-gradient(135deg, #ff5722, #ff8a50);
  color: #fff;
  border: none;
}

.mobile-btn.primary:hover {
  opacity: 0.9;
}

@media (max-width: 992px) {
  .nav-actions {
    display: none;
  }
}

@media (min-width: 993px) {
  .mobile-auth {
    display: none;
  }
}
</style>
</head>

<body>

<nav class="navbar" id="mainNav">
  <div class="container-fluid d-flex align-items-center justify-content-between nav-inner">

    <!-- LOGO -->
    <a href="{{ route('index') }}" class="nav-logo">
      <div class="logo-icon">
        <i class="fa-solid fa-plane-departure"></i>
      </div>
      <span class="logo-text">Dreams<span>Tour</span></span>
    </a>

    <!-- MOBILE AUTH -->
    <div class="mobile-auth d-lg-none">
      @auth
        <a href="{{ route('dashboard') }}" class="mobile-btn">
          <i class="fa fa-user" aria-hidden="true"></i>
          <span>{{ Auth::user()->name }}</span>
        </a>
      @else
        <a href="{{ route('login') }}" class="mobile-btn">
          <i class="fa fa-user" aria-hidden="true"></i>
          <span>Login</span>
        </a>
        <a href="{{ route('register') }}" class="mobile-btn primary">
          <i class="fa fa-user-plus" aria-hidden="true"></i>
          <span>Sign Up</span>
        </a>
      @endauth
    </div>

    <!-- DESKTOP AUTH -->
    <div class="nav-actions">
      @auth
        {{-- Show "Admin Panel" button only if admin --}}
        @if(Auth::user()->usertype == 'admin')
          <a href="{{ route('admin.viewhotel') }}" class="btn-login">
            <i class="fa fa-dashboard" aria-hidden="true"></i>
            <span>Admin Panel</span>
          </a>
        @endif

        {{-- Show username for both admin and user --}}
        <a href="{{ route('dashboard') }}" class="btn-register">
          <i class="fa fa-user" aria-hidden="true"></i>
          <span>{{ Auth::user()->name }}</span>
        </a>
      @else
        {{-- User is NOT logged in --}}
        <a href="{{ route('login') }}" class="btn-login">
          <i class="fa fa-user" aria-hidden="true"></i>
          <span>Login</span>
        </a>
        <a href="{{ route('register') }}" class="btn-register">
          <i class="fa fa-user-plus" aria-hidden="true"></i>
          <span>Sign Up</span>
        </a>
      @endauth
    </div>

  </div>
</nav>

<div class="page-content">
  @yield('home')
</div>

<script>
const nav = document.getElementById('mainNav');
window.addEventListener('scroll', () => {
  nav.classList.toggle('scrolled', window.scrollY > 10);
});
</script>

</body>
</html>