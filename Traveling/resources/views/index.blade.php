@extends('header')

@section('home')

<style>
  @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&display=swap');

  :root {
    --primary:      #ff5722;
    --primary-dark: #e64a19;
    --white:        #ffffff;
  }

  /* ════ HERO WRAPPER ════ */
  .hero-section {
    position: relative;
    width: 100%;
    height: 100vh;
    min-height: 620px;
    overflow: hidden;
    background: #0d0d0d;
    font-family: 'Outfit', sans-serif;
  }

  /* ════ SLIDESHOW ════ */
  .hero-slides { position: absolute; inset: 0; z-index: 0; }
  .hero-slide {
    position: absolute; inset: 0;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transform: scale(1.08);
    transition: opacity 1.4s ease, transform 8s ease;
  }
  .hero-slide.active { opacity: 1; transform: scale(1); }

  /* ── 3 stunning adventure travel images from Unsplash ── */
  .hero-slide:nth-child(1) {
    background-image: url('{{ asset('images/sea.jpg') }}');
}
.hero-slide:nth-child(2) {
    background-image: url('{{ asset('images/lake.jpg') }}');
}
.hero-slide:nth-child(3) {
    background-image: url('{{ asset('images/mountain.jpg') }}');
}

  /* ════ OVERLAYS ════ */
  .hero-overlay {
    position: absolute; inset: 0; z-index: 1;
    background:
      linear-gradient(to top,  rgba(0,0,0,.88) 0%, rgba(0,0,0,.25) 55%, rgba(0,0,0,.1) 100%),
      linear-gradient(to right, rgba(0,0,0,.55) 0%, transparent 65%);
  }
  .hero-grain {
    position: absolute; inset: 0; z-index: 2;
    opacity: .045;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
    background-size: 180px;
    pointer-events: none;
  }
  .hero-sweep {
    position: absolute; inset: 0; z-index: 2;
    background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,.035) 50%, transparent 70%);
    background-size: 200% 100%;
    animation: sweep 7s ease-in-out infinite;
    pointer-events: none;
  }
  @keyframes sweep {
    0%   { background-position: 200% 0; }
    100% { background-position: -200% 0; }
  }

  /* ════ CONTENT ════ */
  .hero-content {
    position: absolute; inset: 0; z-index: 10;
    display: flex; flex-direction: column;
    justify-content: center;
    padding: 0 7vw;
    padding-bottom: 110px;
  }

  /* Tag */
  .hero-tag {
    display: inline-flex; align-items: center; gap: 9px;
    background: rgba(255,87,34,.14);
    border: 1px solid rgba(255,87,34,.45);
    color: var(--primary);
    font-size: 11.5px; font-weight: 700;
    letter-spacing: 2.8px; text-transform: uppercase;
    padding: 7px 18px; border-radius: 30px;
    width: fit-content; margin-bottom: 24px;
    opacity: 0; transform: translateY(22px);
    animation: heroIn .8s ease forwards;
    animation-delay: .3s;
  }
  .hero-tag .dot {
    width: 7px; height: 7px;
    background: var(--primary); border-radius: 50%;
    animation: blink 1.8s ease infinite;
  }
  @keyframes blink {
    0%,100% { transform: scale(1); opacity:1; }
    50%      { transform: scale(1.7); opacity:.4; }
  }

  /* Headline */
  .hero-title {
    font-family: 'Bebas Neue', cursive;
    font-size: clamp(76px, 12vw, 156px);
    line-height: .9;
    color: var(--white);
    letter-spacing: 2px;
    margin-bottom: 14px;
    overflow: hidden;
  }
  .hero-title .line {
    display: block;
    opacity: 0; transform: translateY(110%);
    animation: slideUp .95s cubic-bezier(.22,1,.36,1) forwards;
  }
  .hero-title .line:nth-child(1) { animation-delay: .5s; }
  .hero-title .line:nth-child(2) {
    animation-delay: .72s;
    -webkit-text-stroke: 3px var(--primary);
    color: transparent;
  }
  @keyframes slideUp { to { opacity:1; transform:translateY(0); } }

  /* Sub */
  .hero-sub {
    font-size: clamp(15px, 1.4vw, 18px);
    color: rgba(255,255,255,.72);
    font-weight: 300; max-width: 480px;
    line-height: 1.75; margin-bottom: 38px;
    opacity: 0; transform: translateY(18px);
    animation: heroIn .85s ease forwards;
    animation-delay: 1s;
  }

  /* Buttons */
  .hero-btns {
    display: flex; gap: 14px; flex-wrap: wrap;
    opacity: 0; transform: translateY(18px);
    animation: heroIn .85s ease forwards;
    animation-delay: 1.2s;
  }
  .hero-btn {
    display: inline-flex; align-items: center; gap: 10px;
    padding: 14px 32px; border-radius: 50px;
    font-size: 15px; font-weight: 600;
    text-decoration: none; border: none; cursor: pointer;
    font-family: 'Outfit', sans-serif;
    transition: all .3s; letter-spacing: .3px;
  }
  .hero-btn-primary {
    background: var(--primary); color: #fff;
    box-shadow: 0 6px 30px rgba(255,87,34,.45);
  }
  .hero-btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-3px);
    box-shadow: 0 12px 38px rgba(255,87,34,.55);
  }
  .hero-btn-secondary {
    background: rgba(255,255,255,.1); color: #fff;
    border: 1.5px solid rgba(255,255,255,.35);
    backdrop-filter: blur(10px);
  }
  .hero-btn-secondary:hover {
    background: rgba(255,255,255,.2);
    transform: translateY(-3px);
  }

  /* Stats */
  .hero-stats {
    position: absolute; bottom: 28px;
    left: 7vw; right: 7vw; z-index: 10;
    display: flex;
    background: rgba(255,255,255,.07);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 18px; overflow: hidden;
    opacity: 0; transform: translateY(18px);
    animation: heroIn 1s ease forwards;
    animation-delay: 1.55s;
  }
  .hero-stat {
    flex: 1; padding: 20px 24px; text-align: center;
    border-right: 1px solid rgba(255,255,255,.1);
    transition: background .25s;
  }
  .hero-stat:last-child { border-right: none; }
  .hero-stat:hover { background: rgba(255,255,255,.07); }
  .hero-stat-num {
    font-family: 'Bebas Neue', cursive;
    font-size: 34px; color: var(--primary);
    line-height: 1; letter-spacing: 1px;
  }
  .hero-stat-label {
    font-size: 11px; color: rgba(255,255,255,.5);
    text-transform: uppercase; letter-spacing: 1.5px;
    margin-top: 5px;
  }

  /* Dots */
  .hero-dots {
    position: absolute; right: 28px; top: 50%;
    transform: translateY(-50%); z-index: 10;
    display: flex; flex-direction: column; gap: 10px;
    opacity: 0;
    animation: heroIn .8s ease forwards;
    animation-delay: 1.7s;
  }
  .hero-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: rgba(255,255,255,.35);
    border: none; cursor: pointer; padding: 0;
    transition: all .3s;
  }
  .hero-dot.active {
    background: var(--primary);
    transform: scale(1.5);
    box-shadow: 0 0 12px rgba(255,87,34,.65);
  }

  /* Scroll cue */
  .hero-scroll {
    position: absolute; bottom: 130px; right: 32px;
    z-index: 10;
    display: flex; flex-direction: column; align-items: center; gap: 7px;
    opacity: 0;
    animation: heroIn .8s ease forwards;
    animation-delay: 1.9s;
  }
  .hero-scroll span {
    font-size: 10px; color: rgba(255,255,255,.4);
    letter-spacing: 2px; text-transform: uppercase;
    writing-mode: vertical-rl;
  }
  .scroll-line {
    width: 1px; height: 52px;
    background: linear-gradient(to bottom, rgba(255,255,255,.45), transparent);
    animation: scrollDrop 2s ease infinite;
  }
  @keyframes scrollDrop {
    0%   { transform: scaleY(0); transform-origin: top; opacity:1; }
    100% { transform: scaleY(1); transform-origin: top; opacity:0; }
  }

  /* Shared entrance */
  @keyframes heroIn {
    to { opacity: 1; transform: translateY(0); }
  }

  /* Particles */
  .hero-particles { position: absolute; inset: 0; z-index: 3; pointer-events: none; overflow: hidden; }
  .particle {
    position: absolute; border-radius: 50%;
    background: rgba(255,87,34,.3);
    animation: floatUp linear infinite;
  }
  @keyframes floatUp {
    0%   { transform: translateY(100vh) rotate(0deg); opacity:0; }
    10%  { opacity: 1; }
    90%  { opacity: .35; }
    100% { transform: translateY(-100px) rotate(720deg); opacity:0; }
  }

  /* Slide counter */
  .hero-counter {
    position: absolute; bottom: 135px; left: 7vw;
    z-index: 10; display: flex; align-items: baseline; gap: 4px;
    opacity: 0;
    animation: heroIn .8s ease forwards;
    animation-delay: 1.7s;
  }
  .hero-counter .current {
    font-family: 'Bebas Neue', cursive;
    font-size: 48px; color: var(--primary); line-height: 1;
  }
  .hero-counter .sep {
    font-size: 18px; color: rgba(255,255,255,.3); margin: 0 3px;
  }
  .hero-counter .total {
    font-size: 16px; color: rgba(255,255,255,.4);
    font-weight: 300;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .hero-content { padding: 0 5vw; padding-bottom: 180px; }
    .hero-stats { flex-wrap: wrap; left: 4vw; right: 4vw; bottom: 20px; }
    .hero-stat { min-width: 50%; border-bottom: 1px solid rgba(255,255,255,.1); }
    .hero-dots, .hero-scroll, .hero-counter { display: none; }
  }

  @media (max-width: 992px) {
    .trending-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .trending-grid {
        grid-template-columns: 1fr;
    }
}


/* SECTION BACKGROUND */
.trending-section {
    background: #ffffff;
    padding: 70px 0;
}

/* CARD GRID */
.trending-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
}

/* CARD DESIGN */
.trend-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: 0.3s;
}

.trend-card:hover {
    transform: translateY(-6px);
}

/* IMAGE */
.trend-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

/* CONTENT */
.trend-content {
    padding: 15px;
}

.trend-content h4 {
    font-size: 16px;
    margin-bottom: 5px;
}

.trend-content p {
    font-size: 13px;
    color: #777;
}

/* BUTTONS */
.top-tabs {
    text-align: center;
    margin-bottom: 30px;
}

.tab-btn {
    padding: 10px 22px;
    border: none;
    margin: 5px;
    border-radius: 25px;
    background: #eee;
    cursor: pointer;
}

.tab-btn.active {
    background: #ff5722;
    color: #fff;
}

/* HIDE */
.d-none {
    display: none !important;
}
.section-header {
    text-align: center;
}

.section-header h2 {
    font-size: 32px;
    font-weight: 600;
    margin-bottom: 10px;
}

.section-header p {
    font-size: 14px;
    color: #777;
}
</style>

<!-- ═══════════ HERO ═══════════ -->
<section class="hero-section" id="heroSection">

  {{-- Slides --}}
  <div class="hero-slides">
    <div class="hero-slide active"></div>
    <div class="hero-slide"></div>
    <div class="hero-slide"></div>
  </div>

  {{-- Atmosphere --}}
  <div class="hero-overlay"></div>
  <div class="hero-grain"></div>
  <div class="hero-sweep"></div>

  {{-- Particles --}}
  <div class="hero-particles" id="heroParticles"></div>

  {{-- Content --}}
  <div class="hero-content">
    <div class="hero-tag">
      <span class="dot"></span>
      Discover the World
    </div>

    <h1 class="hero-title">
      <span class="line">Feel the</span>
      <span class="line">Adventure</span>
    </h1>

    <p class="hero-sub">
      Explore breathtaking destinations, book seamless journeys, and create memories that last a lifetime. Your next great escape starts here.
    </p>

  </div>

  {{-- Slide counter --}}
  <div class="hero-counter">
    <span class="current" id="slideCurrentNum">01</span>
    <span class="sep">/</span>
    <span class="total">03</span>
  </div>

  {{-- Stats --}}
  <div class="hero-stats">
    <div class="hero-stat">
      <div class="hero-stat-num" data-count="15000">0</div>
      <div class="hero-stat-label">Happy Clients</div>
    </div>
    <div class="hero-stat">
      <div class="hero-stat-num" data-count="98">0</div>
      <div class="hero-stat-label">Destinations</div>
    </div>
    <div class="hero-stat">
      <div class="hero-stat-num" data-count="20">0</div>
      <div class="hero-stat-label">Services</div>
    </div>
    <div class="hero-stat">
      <div class="hero-stat-num" data-count="12">0</div>
      <div class="hero-stat-label">Years Experience</div>
    </div>
  </div>

  {{-- Dots --}}
  <div class="hero-dots">
    <button class="hero-dot active" data-slide="0"></button>
    <button class="hero-dot" data-slide="1"></button>
    <button class="hero-dot" data-slide="2"></button>
  </div>

  {{-- Scroll indicator --}}
  <div class="hero-scroll">
    <div class="scroll-line"></div>
    <span>Scroll</span>
  </div>

</section>


<section class="trending-section">
    <div class="container">

        <div class="text-center mb-5 section-header">
            <h2>Trending Listings</h2>
            <p>Best Seller Travel Services</p>
        </div>
<br>
<br>
        {{-- TOP BUTTONS --}}
        <div class="top-tabs">
            <button class="tab-btn active" data-tab="flight">Flight</button>
            <button class="tab-btn" data-tab="hotel">Hotel</button>
            <button class="tab-btn" data-tab="tour">Tour</button>
            <button class="tab-btn" data-tab="car">Car</button>
        </div>

        {{-- CARDS (ALL IN ONE GRID) --}}
        <div class="trending-grid">

            {{-- FLIGHT --}}
            @foreach($flights as $flight)
            <div class="trend-card tab-item flight">
                <img src="{{ asset('images/'.$flight->image) }}">
                <div class="trend-content">
                    <h2>{{ $flight->airline_name }}</h2>
                    <h4>{{ $flight->from_city }} → {{ $flight->to_city }}</h4>
                    <p>₹{{ $flight->price }}</p>
                </div>
            </div>
            @endforeach

            {{-- HOTEL --}}
            @for($i=1;$i<=4;$i++)
            <div class="trend-card tab-item hotel d-none">
                <img src="{{ asset('images/hotel.jpg') }}">
                <div class="trend-content">
                    <h4>Hotel {{ $i }}</h4>
                </div>
            </div>
            @endfor

            {{-- TOUR --}}
            @for($i=1;$i<=4;$i++)
            <div class="trend-card tab-item tour d-none">
                <img src="{{ asset('images/tour.jpg') }}">
                <div class="trend-content">
                    <h4>Tour {{ $i }}</h4>
                </div>
            </div>
            @endfor

            {{-- CAR --}}
            @for($i=1;$i<=4;$i++)
            <div class="trend-card tab-item car d-none">
                <img src="{{ asset('images/car.jpg') }}">
                <div class="trend-content">
                    <h4>Car {{ $i }}</h4>
                </div>
            </div>
            @endfor

        </div>

    </div>
</section>

<script>
(function () {

  /* ── Slideshow ── */
  const slides  = document.querySelectorAll('.hero-slide');
  const dots    = document.querySelectorAll('.hero-dot');
  const counter = document.getElementById('slideCurrentNum');
  let current = 0, timer;

  function goTo(i) {
    slides[current].classList.remove('active');
    dots[current].classList.remove('active');
    current = (i + slides.length) % slides.length;
    slides[current].classList.add('active');
    dots[current].classList.add('active');
    if (counter) counter.textContent = String(current + 1).padStart(2, '0');
  }

  function startAuto() { timer = setInterval(() => goTo(current + 1), 6000); }

  dots.forEach(d => d.addEventListener('click', () => {
    clearInterval(timer);
    goTo(+d.dataset.slide);
    startAuto();
  }));

  startAuto();

  /* ── Count-up ── */
  function countUp(el) {
    const target = +el.dataset.count;
    const isK    = target >= 1000;
    const end    = isK ? target / 1000 : target;
    const suffix = isK ? 'K+' : '+';
    let n = 0;
    const step = end / 55;
    const iv = setInterval(() => {
      n += step;
      if (n >= end) { el.textContent = end + suffix; clearInterval(iv); }
      else          { el.textContent = Math.floor(n) + suffix; }
    }, 22);
  }

  const obs = new IntersectionObserver(entries => {
    if (entries[0].isIntersecting) {
      document.querySelectorAll('.hero-stat-num').forEach(countUp);
      obs.disconnect();
    }
  }, { threshold: .3 });
  const statsEl = document.querySelector('.hero-stats');
  if (statsEl) obs.observe(statsEl);

  /* ── Particles ── */
  const pc = document.getElementById('heroParticles');
  if (pc) {
    for (let i = 0; i < 20; i++) {
      const p = document.createElement('div');
      p.className = 'particle';
      const size = Math.random() * 7 + 3;
      p.style.cssText = `
        width:${size}px;height:${size}px;
        left:${Math.random()*100}%;
        animation-duration:${Math.random()*14+10}s;
        animation-delay:${Math.random()*12}s;
        opacity:${Math.random()*.35+.1};
      `;
      pc.appendChild(p);
    }
  }

})();

document.querySelectorAll('.top-tabs .tab-btn').forEach(btn=>{
    btn.addEventListener('click', function(){

        document.querySelectorAll('.top-tabs .tab-btn').forEach(b=>b.classList.remove('active'));
        this.classList.add('active');

        document.querySelectorAll('.listing-tabs-section .tab-content')
        .forEach(tab=>tab.classList.remove('active'));

        document.getElementById(this.dataset.tab).classList.add('active');
    });
});
</script>

@endsection