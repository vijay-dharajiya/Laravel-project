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
  50% { box-shadow: 0 0 25px rgba(255,87,34,0.8); }
}

.logo-text {
  font-size: 22px;
  font-weight: 700;
  color: #fff;
}

.logo-text span {
  color: var(--primary);
}

/* ===== NAV LINKS ===== */
.nav-links {
  display: flex;
  align-items: center;
  list-style: none;
  gap: 2px;
}

.nav-links > li {
  position: relative;
}

.nav-links > li > a {
  display: flex;
  align-items: center;
  padding: 0 16px;
  height: var(--nav-height);
  text-decoration: none;
  font-size: 15px;
  font-weight: 500;
  color: #fff;
  position: relative;
  transition: 0.3s;
}

.navbar.scrolled .nav-links > li > a {
  color: #222;
}

/* HOVER */
.nav-links > li > a::after {
  content: "";
  position: absolute;
  left: 16px;
  right: 16px;
  bottom: 0;
  height: 3px;
  background: linear-gradient(90deg, #ff5722, #ff8a50);
  border-radius: 4px;
  transform: scaleX(0);
  transition: transform 0.25s ease;
}

.nav-links > li:hover > a {
  color: #ff8a50;
  transform: translateY(-2px);
}

.nav-links > li:hover > a::after {
  transform: scaleX(1);
}

/* ===== DROPDOWN ===== */
.mega-menu {
  display: none;
  position: absolute;
  top: 100%;
  left: 0;
  background: #fff;
  min-width: 220px;
  border-radius: 10px;
  box-shadow: 0 12px 40px rgba(0,0,0,0.25);
  padding: 10px 0;
  animation: fadeDown 0.25s ease;
}

@keyframes fadeDown {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}

.nav-links > li:hover .mega-menu {
  display: block;
}

.mega-menu a {
  display: block;
  padding: 8px 16px;
  text-decoration: none;
  color: #333;
}

.mega-menu a:hover {
  background: #fff5f2;
  color: var(--primary);
  padding-left: 20px;
}

.menu-img {
  display: block;
  width: calc(100% - 36px);
  max-height: 110px;
  object-fit: cover;
  border-radius: 8px;
  margin: 8px 18px 14px;
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
}

/* ===== MOBILE ===== */
.mobile-toggle {
  display: none;
  font-size: 22px;
  color: #fff;
  cursor: pointer;
}

@media (max-width: 992px) {

  .mobile-toggle {
    display: block;
  }

  .nav-links {
    display: flex !important;
    position: absolute;
    top: 72px;
    left: 0;
    width: 100%;
    flex-direction: column;
    background: #ffffff;
    max-height: 0;
    overflow: hidden;
    transition: 0.3s ease;
  }

  .nav-links.active {
    max-height: 600px;
  }

  .nav-links > li > a {
    height: auto;
    padding: 14px 20px;
    color: #222;
  }

  .mega-menu {
    position: static;
    display: none !important;
    background: #f9f9f9;
    box-shadow: none;
  }

  .dropdown.active .mega-menu {
    display: block !important;
  }

  .mega-menu a {
    color: #444;
  }

  .menu-img {
    display: none;
  }

  .nav-actions {
    display: none;
  }

  /* MOBILE AUTH */
  .mobile-auth {
    padding: 10px 20px;
  }

  .mobile-btn {
    display: block;
    margin: 8px 0;
    padding: 10px;
    text-align: center;
    border-radius: 8px;
    text-decoration: none;
    border: 1px solid #ddd;
    color: #333;
  }

  .mobile-btn.primary {
    background: linear-gradient(135deg, #ff5722, #ff8a50);
    color: #fff;
    border: none;
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

    <!-- MOBILE BUTTON -->
    <div class="mobile-toggle d-lg-none" id="menuToggle">
      <i class="fa-solid fa-bars"></i>
    </div>

    <!-- NAV -->
    <ul class="nav-links d-lg-flex" id="navMenu">

      <li><a href="{{ route('index') }}">Home</a></li>

      <li class="dropdown">
        <a href="#">Flight</a>
        <div class="mega-menu">
          <a href="#">Flight List</a>
          <a href="#">Flight Details</a>
          <a href="#">Flight Booking</a>
          <img class="menu-img" src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=300&q=80">
        </div>
      </li>

      <li class="dropdown">
        <a href="#">Hotel</a>
        <div class="mega-menu">
          <a href="#">Hotel List</a>
          <a href="#">Hotel Map</a>
          <a href="#">Hotel Booking</a>
          <img class="menu-img" src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=300&q=80">
        </div>
      </li>

      <li class="dropdown">
        <a href="#">Tour</a>
        <div class="mega-menu">
          <a href="#">Tour List</a>
          <a href="#">Tour Details</a>
          <a href="#">Tour Booking</a>
          <img class="menu-img" src="https://images.unsplash.com/photo-1527631746610-bca00a040d60?w=300&q=80">
        </div>
      </li>

      <!-- MOBILE AUTH -->
      <li class="mobile-auth d-lg-none">
        @auth
          <a href="{{ route('dashboard') }}" class="mobile-btn">
            <i class="fa fa-user" aria-hidden="true"></i>
            <span>
                {{ Auth::user()->name }}
            </span>
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
      </li>

    </ul>

    <!-- DESKTOP AUTH -->
    <div class="nav-actions">
      @auth
        <!-- User is logged in -->
        <a href="{{ route('dashboard') }}" class="btn-register">
          <i class="fa fa-user" aria-hidden="true"></i>
          <span>
              {{ Auth::user()->name }}
          </span>
        </a>
      @else
        <!-- User is NOT logged in -->
        <a href="{{ route('login') }}" class="btn-login">
          <i class="fa fa-user" aria-hidden="true"></i>
          <span>Login</span>
        </a>
        <a href="{{ route('register') }}" class="btn-register">
          <i class="fa fa-user" aria-hidden="true"></i>
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

// MOBILE MENU
const toggle = document.getElementById('menuToggle');
const menu = document.getElementById('navMenu');

toggle.addEventListener('click', () => {
  menu.classList.toggle('active');
});

// MOBILE DROPDOWN
document.querySelectorAll('.nav-links > li > a').forEach(link => {
  link.addEventListener('click', function(e){
    if(window.innerWidth < 992){
      const parent = this.parentElement;
      if(parent.querySelector('.mega-menu')){
        e.preventDefault();
        parent.classList.toggle('active');
      }
    }
  });
});
</script>

</body>
</html>