<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>DreamsTour - Header</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --primary: #ff5722;
      --primary-dark: #e64a19;
      --dark: #1a1a2e;
      --text: #374151;
      --text-light: #6b7280;
      --border: #e5e7eb;
      --white: #ffffff;
      --bg-light: #f9fafb;
      --nav-height: 72px;
    }

    body {
      font-family: 'Outfit', sans-serif;
      color: var(--text);
      min-height: 200vh;
      background: linear-gradient(135deg, #1a1a2e 0%, #16213e 40%, #0f3460 100%);
    }

    /* ── NAVBAR ── */
    .navbar {
      background: var(--white);
      box-shadow: 0 2px 12px rgba(0,0,0,.08);
      position: sticky;
      top: 0;
      z-index: 900;
      transition: box-shadow .3s;
    }
    .navbar.scrolled { box-shadow: 0 4px 20px rgba(0,0,0,.15); }

    .nav-inner {
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 24px;
      height: var(--nav-height);
      display: flex;
      align-items: center;
      gap: 16px;
    }

    /* Logo */
    .nav-logo {
      display: flex; align-items: center; gap: 9px;
      text-decoration: none; flex-shrink: 0;
      margin-right: 16px;
    }
    .nav-logo svg { height: 38px; }
    .logo-text { font-size: 22px; font-weight: 700; color: var(--dark); letter-spacing: -0.5px; }
    .logo-text span { color: var(--primary); }

    /* Nav links */
    .nav-links {
      display: flex; align-items: center;
      list-style: none; gap: 2px; flex: 1;
    }
    .nav-links > li { position: relative; }
    .nav-links > li > a {
      display: flex; align-items: center; gap: 5px;
      padding: 0 16px;
      height: var(--nav-height);
      text-decoration: none;
      font-size: 15px; font-weight: 500;
      color: var(--text); white-space: nowrap;
      transition: color .2s; position: relative;
    }
    .nav-links > li > a::after {
      content: ''; position: absolute;
      bottom: 0; left: 16px; right: 16px;
      height: 3px; background: var(--primary);
      border-radius: 3px 3px 0 0;
      transform: scaleX(0); transition: transform .25s ease;
    }
    .nav-links > li:hover > a,
    .nav-links > li > a.active { color: var(--primary); }
    .nav-links > li:hover > a::after,
    .nav-links > li > a.active::after { transform: scaleX(1); }
    .nav-links > li > a i.chevron { font-size: 10px; opacity: .55; transition: transform .25s; }
    .nav-links > li:hover > a i.chevron { transform: rotate(180deg); }

    /* Mega menu base */
    .mega-menu {
      display: none; position: absolute;
      top: calc(100% + 1px); left: 0;
      background: var(--white);
      border-radius: 0 0 12px 12px;
      box-shadow: 0 12px 40px rgba(0,0,0,.13);
      z-index: 800; min-width: 220px;
      animation: fadeDown .2s ease;
    }
    @keyframes fadeDown {
      from { opacity: 0; transform: translateY(-8px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .nav-links > li:hover .mega-menu { display: block; }

    /* Simple dropdown */
    .mega-menu.simple { padding: 10px 0; }
    .mega-menu.simple .mega-section-title {
      font-size: 10px; font-weight: 700; text-transform: uppercase;
      color: var(--text-light); letter-spacing: 1px;
      padding: 10px 18px 6px;
    }
    .mega-menu.simple a {
      display: block; padding: 9px 18px;
      color: var(--text); text-decoration: none;
      font-size: 13.5px; transition: all .15s;
      border-left: 3px solid transparent;
    }
    .mega-menu.simple a:hover {
      color: var(--primary); background: #fff5f2;
      border-left-color: var(--primary); padding-left: 22px;
    }
    .mega-menu.simple .menu-img {
      display: block; width: calc(100% - 36px);
      max-height: 110px; object-fit: cover;
      border-radius: 8px; margin: 8px 18px 14px;
    }

    /* Home wide mega */
    .mega-menu.wide { padding: 20px 24px; min-width: 720px; }
    .mega-menu.wide .mega-header {
      display: flex; justify-content: space-between; align-items: center;
      margin-bottom: 16px; padding-bottom: 12px;
      border-bottom: 1px solid var(--border);
    }
    .mega-menu.wide .mega-header h6 {
      font-size: 11px; font-weight: 700; text-transform: uppercase;
      letter-spacing: 1px; color: var(--text-light);
    }
    .mega-menu.wide .mega-header a.purchase-btn {
      background: var(--primary); color: #fff;
      padding: 6px 16px; border-radius: 6px;
      font-size: 12px; font-weight: 600; text-decoration: none;
      transition: background .2s;
    }
    .mega-menu.wide .mega-header a.purchase-btn:hover { background: var(--primary-dark); }
    .home-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; }
    .home-grid-item { text-align: center; text-decoration: none; }
    .home-grid-item img {
      width: 100%; aspect-ratio: 16/10; object-fit: cover;
      border-radius: 8px; border: 2px solid transparent; transition: all .2s;
    }
    .home-grid-item:hover img { border-color: var(--primary); transform: translateY(-2px); }
    .home-grid-item span {
      display: block; font-size: 12.5px; font-weight: 500;
      color: var(--text); margin-top: 6px; transition: color .2s;
    }
    .home-grid-item:hover span { color: var(--primary); }

    /* Auth buttons */
    .nav-actions { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
    .nav-btn {
      padding: 9px 22px; border-radius: 8px;
      font-size: 14px; font-weight: 600;
      text-decoration: none; font-family: 'Outfit', sans-serif;
      white-space: nowrap; transition: all .2s;
      border: none; cursor: pointer;
    }
    .nav-btn-outline { border: 1.5px solid var(--primary); color: var(--primary); background: none; }
    .nav-btn-outline:hover { background: var(--primary); color: #fff; }
    .nav-btn-fill { background: var(--primary); color: #fff; }
    .nav-btn-fill:hover { background: var(--primary-dark); box-shadow: 0 4px 14px rgba(255,87,34,.35); }

    /* Hamburger */
    .hamburger {
      display: none; background: none; border: none;
      cursor: pointer; padding: 6px; flex-direction: column; gap: 5px;
    }
    .hamburger span {
      display: block; width: 24px; height: 2px;
      background: var(--text); border-radius: 2px; transition: all .3s;
    }

    /* Demo */
    .hero-demo { padding: 120px 20px; text-align: center; color: #fff; }
    .hero-demo h1 { font-size: 48px; font-weight: 700; margin-bottom: 12px; }
    .hero-demo p  { font-size: 18px; opacity: .75; }

    @media (max-width: 860px) {
      .nav-links { display: none; }
      .hamburger { display: flex; }
    }

    .user-profile {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 8px 14px;
    background: #f5f7fa;
    border-radius: 30px;
    text-decoration: none;
    color: #333;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 1px solid #e0e0e0;
}

.user-profile i {
    font-size: 16px;
    color: #fff;
    background: #007bff;
    padding: 8px;
    border-radius: 50%;
    transition: 0.3s;
}

.user-profile span {
    font-size: 14px;
    white-space: nowrap;
}

/* Hover effect */
.user-profile:hover {
    background: #007bff;
    color: #fff;
    border-color: #007bff;
}

.user-profile:hover i {
    background: #fff;
    color: #007bff;
}
.user-profile span {
    max-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
}
  </style>
</head>
<body>

  <nav class="navbar" id="mainNav">
    <div class="nav-inner">

      <!-- ── Logo ── -->
      <a href="{{ route('index') }}" class="nav-logo">
        <svg viewBox="0 0 36 36" fill="none">
          <circle cx="18" cy="18" r="18" fill="#ff5722"/>
          <path d="M10 22 Q18 10 26 22" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round"/>
          <circle cx="18" cy="22" r="3" fill="white"/>
        </svg>
        <span class="logo-text">Dreams<span>Tour</span></span>
      </a>

      <!-- ── Nav Links ── -->
      <ul class="nav-links">

        <!-- HOME -->
        <li>
          <a href="{{ route('index') }}" class="active">
            Home
          </a>
          
        </li>

        <!-- FLIGHT -->
        <li>
          <a href="#">
            Flight <i class="fa-solid fa-chevron-down chevron"></i>
          </a>
          <div class="mega-menu simple">
            <div class="mega-section-title">Flight Bookings</div>
            <a href="#">Flight List</a>
            <a href="#">Flight Details</a>
            <a href="#">Flight Booking</a>
            <img class="menu-img" src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=300&q=80" alt="Flight"/>
          </div>
        </li>

        <!-- HOTEL -->
        <li>
          <a href="#">
            Hotel <i class="fa-solid fa-chevron-down chevron"></i>
          </a>
          <div class="mega-menu simple">
            <div class="mega-section-title">Hotel Bookings</div>
            <a href="#">Hotel List</a>
            <a href="#">Hotel Map</a>
            <a href="#">Hotel Details</a>
            <a href="#">Hotel Booking</a>
            <img class="menu-img" src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=300&q=80" alt="Hotel"/>
          </div>
        </li>

        <!-- TOUR -->
        <li>
          <a href="#">
            Tour <i class="fa-solid fa-chevron-down chevron"></i>
          </a>
          <div class="mega-menu simple">
            <div class="mega-section-title">Tour Bookings</div>
            <a href="#">Tour List</a>
            <a href="#">Tour Map</a>
            <a href="#">Tour Details</a>
            <a href="#">Tour Booking</a>
            <img class="menu-img" src="https://images.unsplash.com/photo-1527631746610-bca00a040d60?w=300&q=80" alt="Tour"/>
          </div>
        </li>

      </ul>

        <!-- ── Auth Buttons ── -->
        <div class="user_option">

            @auth
                <a href="{{ route('dashboard') }}" class="user-profile">
                    <i class="fa fa-user"></i>
                    <span>{{ Auth::user()->name }}</span>
                </a>
            @else
                <!-- User is NOT logged in -->
                <a href="{{ route('login') }}">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span>Login</span>
                </a>

                <a href="{{ route('register') }}">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span>Sign Up</span>
                </a>
            @endauth
        </div>

      <!-- Hamburger (mobile) -->
      <button class="hamburger" id="hamburger" aria-label="Menu">
        <span></span><span></span><span></span>
      </button>

    </div>
  </nav>

  <!-- slider section -->
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
