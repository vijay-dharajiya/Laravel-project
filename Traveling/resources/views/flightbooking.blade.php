@extends('header')

@section('home')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ─── ROOT ───────────────────────────────────────────────── */
:root {
    --bg:        #f7f5f0;
    --surface:   #ffffff;
    --surface2:  #fafaf8;
    --border:    #e8e4dc;
    --border2:   #d4cec2;
    --ink:       #1a1714;
    --ink2:      #4a4540;
    --muted:     #9a948a;
    --gold:      #c8913a;
    --gold2:     #e8b060;
    --gold-lt:   #fdf3e3;
    --gold-mid:  rgba(200,145,58,0.12);
    --sky:       #2d7dd2;
    --sky-lt:    #eef5fd;
    --mint:      #2a9d68;
    --mint-lt:   #edfaf3;
    --rose:      #d64f4f;
    --rose-lt:   #fdf0f0;
    --r:         18px;
    --shadow-sm: 0 1px 3px rgba(26,23,20,0.06), 0 1px 2px rgba(26,23,20,0.04);
    --shadow-md: 0 4px 16px rgba(26,23,20,0.08), 0 2px 6px rgba(26,23,20,0.05);
    --shadow-lg: 0 12px 40px rgba(26,23,20,0.10), 0 4px 12px rgba(26,23,20,0.06);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    background: var(--bg);
    color: var(--ink);
    font-family: 'Outfit', sans-serif;
}

/* ─── BACKGROUND TEXTURE ─────────────────────────────────── */
.bg-texture {
    position: fixed; inset: 0; pointer-events: none; z-index: 0;
    background-image:
        radial-gradient(ellipse 80% 50% at 0% 0%,   rgba(200,145,58,0.06) 0%, transparent 60%),
        radial-gradient(ellipse 60% 40% at 100% 80%, rgba(45,125,210,0.05) 0%, transparent 60%),
        url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c8913a' fill-opacity='0.018'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

/* ─── PAGE ───────────────────────────────────────────────── */
.page-wrap { position: relative; z-index: 1; padding: 110px 0 80px; }

/* ─── SECTION TITLE ──────────────────────────────────────── */
.s-title {
    font-family: 'Outfit', sans-serif;
    font-size: 10px; font-weight: 600;
    color: var(--muted); text-transform: uppercase; letter-spacing: 0.14em;
    margin-bottom: 14px;
    display: flex; align-items: center; gap: 10px;
}
.s-title::after { content: ''; flex: 1; height: 1px; background: var(--border); }

/* ─── HERO STRIP ─────────────────────────────────────────── */
.hero-strip {
    border-radius: 24px;
    overflow: hidden;
    margin-bottom: 20px;
    position: relative;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--border);
    height: 220px;                          /* fixed height */
    background: linear-gradient(135deg, #1a1714 0%, #2d2520 60%, #3a2e24 100%); /* fallback bg */
}

/* background image layer */
.hero-strip-bg {
    position: absolute; inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    filter: brightness(0.55) saturate(0.85);
    transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    display: block;
}
.hero-strip:hover .hero-strip-bg { transform: scale(1.04); }

/* dark gradient overlay */
.hero-strip-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(105deg, rgba(26,23,20,0.92) 0%, rgba(26,23,20,0.55) 55%, rgba(26,23,20,0.20) 100%);
    z-index: 1;
}

/* content sits on top of overlay */
.hero-strip-content {
    position: absolute; inset: 0; z-index: 2;
    display: flex; align-items: center;
    padding: 0 36px; gap: 28px;
}

/* airline logo circle */
.airline-logo-wrap {
    width: 64px; height: 64px; flex-shrink: 0;
    background: rgba(255,255,255,0.14);
    border: 1.5px solid rgba(255,255,255,0.28);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden; backdrop-filter: blur(14px);
}
.airline-logo-wrap img {
    width: 100%; height: 100%;
    object-fit: contain; padding: 8px;
}
.al-init {
    font-family: 'Playfair Display', serif;
    font-weight: 700; font-size: 20px; color: var(--gold2);
}

/* text block */
.hero-text { flex: 1; min-width: 0; }
.hero-airline-name {
    font-family: 'Playfair Display', serif;
    font-size: 24px; font-weight: 700;
    color: #fff; line-height: 1.1; margin-bottom: 10px;
}
.hero-meta { display: flex; gap: 10px; flex-wrap: wrap; }
.hero-tag {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,0.13);
    border: 1px solid rgba(255,255,255,0.22);
    border-radius: 999px; padding: 5px 13px;
    font-size: 11px; font-weight: 500; color: rgba(255,255,255,0.88);
    backdrop-filter: blur(8px);
}
.hero-tag i { color: var(--gold2); font-size: 10px; }

/* flight number pill */
.flight-no-pill {
    background: linear-gradient(135deg, var(--gold), var(--gold2));
    color: #fff; border-radius: 14px;
    padding: 10px 20px; flex-shrink: 0;
    font-family: 'Outfit', sans-serif;
    font-size: 14px; font-weight: 700; letter-spacing: 0.1em;
    box-shadow: 0 4px 14px rgba(200,145,58,0.45);
}

/* ─── CARDS ──────────────────────────────────────────────── */
.card-block {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r);
    padding: 26px 28px;
    margin-bottom: 16px;
    box-shadow: var(--shadow-sm);
}

/* ─── ROUTE ──────────────────────────────────────────────── */
.route-row {
    display: flex; align-items: center;
    justify-content: space-between; gap: 16px;
}
.ep { text-align: center; flex-shrink: 0; }
.ep .time {
    font-family: 'Playfair Display', serif;
    font-size: 36px; font-weight: 700;
    color: var(--ink); line-height: 1; letter-spacing: -0.02em;
}
.ep .iata {
    font-size: 13px; font-weight: 700;
    color: var(--gold); letter-spacing: 0.14em; margin-top: 6px;
}
.ep .city-name {
    font-size: 11px; color: var(--muted);
    margin-top: 3px; text-transform: uppercase; letter-spacing: 0.06em;
}
.ep .airport-name {
    font-size: 11px; color: var(--border2);
    margin-top: 3px; line-height: 1.4; max-width: 120px;
}
.ep-r { text-align: right; }
.ep-r .airport-name { margin-left: auto; }

.route-mid {
    flex: 1; display: flex; flex-direction: column;
    align-items: center; gap: 8px; min-width: 0;
}
.r-track { width: 100%; display: flex; align-items: center; gap: 6px; }
.r-dot {
    width: 9px; height: 9px; border-radius: 50%;
    border: 2px solid var(--gold); background: var(--surface); flex-shrink: 0;
}
.r-line {
    flex: 1; height: 1.5px;
    background: linear-gradient(90deg, var(--gold), rgba(200,145,58,0.2));
}
.r-line.rev { background: linear-gradient(90deg, rgba(200,145,58,0.2), var(--gold)); }
.r-plane-icon { font-size: 22px; filter: drop-shadow(0 2px 6px rgba(200,145,58,0.3)); }
.dur-badge {
    background: var(--gold-lt);
    border: 1px solid rgba(200,145,58,0.25);
    border-radius: 999px; padding: 4px 16px;
    font-size: 12px; font-weight: 600; color: var(--gold); letter-spacing: 0.05em;
}
.stopover-info {
    display: flex; align-items: center; gap: 8px; flex-wrap: wrap; justify-content: center;
    background: var(--gold-lt); border: 1px solid rgba(200,145,58,0.2);
    border-radius: 10px; padding: 6px 14px; margin-top: 4px;
    font-size: 11px; color: var(--gold);
}
.sv-pill {
    background: rgba(200,145,58,0.15); border-radius: 999px;
    padding: 2px 10px; font-size: 11px; font-weight: 600; color: var(--gold);
}
.overnight-pill {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--sky-lt); border: 1px solid rgba(45,125,210,0.2);
    border-radius: 999px; padding: 4px 12px;
    font-size: 11px; font-weight: 600; color: var(--sky);
}

/* ─── INFO GRID ──────────────────────────────────────────── */
.info-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 10px;
    margin-bottom: 16px;
}
.info-cell {
    background: var(--surface2); border: 1px solid var(--border);
    border-radius: 12px; padding: 14px 16px;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.info-cell:hover {
    border-color: rgba(200,145,58,0.3);
    box-shadow: 0 2px 8px rgba(200,145,58,0.08);
}
.ic-lbl {
    font-size: 10px; font-weight: 600; color: var(--muted);
    letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 5px;
}
.ic-val { font-size: 14px; font-weight: 600; color: var(--ink); }

/* ─── CLASS CARDS ────────────────────────────────────────── */
.class-grid { display: flex; flex-direction: column; gap: 10px; }
.class-card {
    background: var(--surface); border: 1.5px solid var(--border);
    border-radius: 14px; padding: 16px 20px;
    cursor: pointer; transition: border-color 0.2s, box-shadow 0.2s, transform 0.15s;
    position: relative; overflow: hidden;
}
.class-card::before {
    content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px;
    background: transparent; transition: background 0.2s;
}
.class-card:hover { border-color: rgba(200,145,58,0.4); box-shadow: 0 4px 16px rgba(200,145,58,0.1); transform: translateX(3px); }
.class-card:hover::before { background: var(--gold); }
.class-card.selected { border-color: var(--gold); background: var(--gold-lt); box-shadow: 0 4px 20px rgba(200,145,58,0.15); }
.class-card.selected::before { background: var(--gold); }
.class-card.sold-out { opacity: 0.4; cursor: not-allowed; }
.class-top { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
.class-name { font-size: 15px; font-weight: 700; color: var(--ink); }
.class-price { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 700; color: var(--gold); }
.class-price .sym { font-size: 13px; font-weight: 600; vertical-align: super; }
.class-price .per { font-size: 11px; font-weight: 400; color: var(--muted); font-family: 'Outfit', sans-serif; }
.class-meta { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px; }
.cm-tag { display: inline-flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 500; color: var(--muted); }
.cm-tag i { font-size: 10px; color: var(--sky); }
.cm-tag.green i { color: var(--mint); }
.cm-tag.rose  i { color: var(--rose); }
.seats-badge {
    display: inline-flex; align-items: center; gap: 4px;
    background: var(--rose-lt); border: 1px solid rgba(214,79,79,0.2);
    border-radius: 999px; padding: 3px 10px;
    font-size: 11px; font-weight: 700; color: var(--rose);
}
.seats-badge.ok { background: var(--mint-lt); border-color: rgba(42,157,104,0.2); color: var(--mint); }

/* ─── FORM CARD ──────────────────────────────────────────── */
.form-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: 24px; padding: 36px 32px;
    position: sticky; top: 20px;
    box-shadow: var(--shadow-lg);
}
.form-card-eyebrow { font-size: 10px; font-weight: 700; color: var(--gold); letter-spacing: 0.16em; text-transform: uppercase; margin-bottom: 6px; }
.form-card-title { font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 700; color: var(--ink); margin-bottom: 4px; line-height: 1.2; }
.form-card-sub { font-size: 13px; color: var(--muted); margin-bottom: 28px; }

/* ─── FORM INPUTS ────────────────────────────────────────── */
.form-label-custom {
    font-size: 10px; letter-spacing: 0.1em; text-transform: uppercase;
    color: var(--muted); margin-bottom: 7px; display: block; font-weight: 600;
}
.custom-input {
    background: var(--surface2) !important;
    border: 1.5px solid var(--border) !important;
    border-radius: 12px !important;
    color: var(--ink) !important;
    padding: 12px 16px !important;
    font-family: 'Outfit', sans-serif !important;
    font-size: 14px !important;
    width: 100%;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.custom-input::placeholder { color: var(--muted) !important; }
.custom-input:focus {
    outline: none !important;
    border-color: var(--gold) !important;
    box-shadow: 0 0 0 3px rgba(200,145,58,0.12) !important;
    background: #fff !important;
}

/* ─── CLASS SELECT IN FORM ───────────────────────────────── */
.class-select-wrap { display: flex; flex-direction: column; gap: 8px; }
.cs-option {
    display: flex; align-items: center; justify-content: space-between;
    background: var(--surface2); border: 1.5px solid var(--border);
    border-radius: 12px; padding: 11px 16px;
    cursor: pointer; transition: all 0.2s; gap: 10px;
}
.cs-option:hover { border-color: rgba(200,145,58,0.4); background: var(--gold-lt); }
.cs-option.active { border-color: var(--gold); background: var(--gold-lt); }
.cs-option.disabled { opacity: 0.35; cursor: not-allowed; pointer-events: none; }
.cs-name { font-size: 13px; font-weight: 600; color: var(--ink); }
.cs-price { font-family: 'Playfair Display', serif; font-size: 15px; font-weight: 700; color: var(--gold); }
.cs-radio {
    width: 16px; height: 16px; border-radius: 50%;
    border: 2px solid var(--border2); flex-shrink: 0; transition: all 0.2s;
}
.cs-option.active .cs-radio { border-color: var(--gold); background: var(--gold); box-shadow: 0 0 0 3px rgba(200,145,58,0.18); }

/* ─── PASSENGER BOX ──────────────────────────────────────── */
.passenger-box { background: var(--surface2); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; }
.passenger-row { display: flex; justify-content: space-between; align-items: center; padding: 14px 18px; }
.passenger-row + .passenger-row { border-top: 1px solid var(--border); }
.passenger-label strong { font-size: 14px; font-weight: 600; color: var(--ink); }
.passenger-label small { display: block; font-size: 11px; color: var(--muted); margin-top: 2px; }
.counter { display: flex; align-items: center; gap: 14px; }
.counter button {
    width: 32px; height: 32px; border: 1.5px solid var(--border2);
    background: var(--surface); color: var(--gold); border-radius: 50%;
    font-size: 16px; cursor: pointer; transition: all 0.18s;
    display: flex; align-items: center; justify-content: center;
    box-shadow: var(--shadow-sm);
}
.counter button:hover { background: var(--gold); color: #fff; border-color: var(--gold); transform: scale(1.1); box-shadow: 0 4px 12px rgba(200,145,58,0.3); }
.counter span { font-family: 'Playfair Display', serif; font-weight: 700; font-size: 18px; min-width: 24px; text-align: center; color: var(--ink); }

/* ─── PRICE SUMMARY ──────────────────────────────────────── */
.price-summary {
    background: linear-gradient(135deg, var(--gold-lt) 0%, #fff 100%);
    border: 1px solid rgba(200,145,58,0.25);
    border-radius: 16px; padding: 18px 20px; margin-top: 20px;
}
.ps-row { display: flex; justify-content: space-between; align-items: center; padding: 5px 0; }
.ps-label { font-size: 12px; color: var(--muted); }
.ps-val   { font-size: 13px; font-weight: 600; color: var(--ink); }
.ps-divider { height: 1px; background: rgba(200,145,58,0.2); margin: 10px 0; }
.ps-total-label { font-size: 14px; font-weight: 600; color: var(--ink); }
.ps-total-val { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 700; color: var(--gold); }

/* ─── SUBMIT BTN ─────────────────────────────────────────── */
.btn-main {
    background: linear-gradient(135deg, var(--gold) 0%, var(--gold2) 100%);
    color: #fff; border: none; border-radius: 14px;
    padding: 16px; font-family: 'Outfit', sans-serif;
    font-size: 15px; font-weight: 700; letter-spacing: 0.04em;
    cursor: pointer; width: 100%; margin-top: 20px;
    position: relative; overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
    box-shadow: 0 6px 20px rgba(200,145,58,0.35);
}
.btn-main::before {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.2), transparent);
    opacity: 0; transition: opacity 0.2s;
}
.btn-main:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(200,145,58,0.45); }
.btn-main:hover::before { opacity: 1; }
.btn-main:active { transform: translateY(0); }

/* ─── TOAST ──────────────────────────────────────────────── */
#successMsg {
    background: linear-gradient(135deg, var(--mint), #4ade80);
    color: #fff; padding: 14px 20px; border-radius: 14px;
    margin-bottom: 20px; font-size: 14px; font-weight: 500;
    display: flex; align-items: center; gap: 10px;
    box-shadow: 0 4px 16px rgba(42,157,104,0.3);
    transition: opacity 0.5s, transform 0.5s;
}

/* ─── DIVIDER ────────────────────────────────────────────── */
.form-divider { height: 1px; background: var(--border); margin: 20px 0; }

/* ─── RESPONSIVE ─────────────────────────────────────────── */
@media (max-width: 991px) {
    .form-card { position: static; }
    .hero-strip-content { padding: 0 20px; gap: 16px; }
    .hero-airline-name  { font-size: 18px; }
}
@media (max-width: 768px) {
    .page-wrap  { padding: 90px 0 60px; }
    .form-card  { padding: 24px 18px; }
    .ep .time   { font-size: 28px; }
    .info-grid  { grid-template-columns: 1fr; }
    .hero-strip { height: 180px; }
    .card-block { padding: 18px 16px; }
}
@media (max-width: 576px) {
    .route-row  { flex-wrap: wrap; justify-content: center; gap: 20px; }
    .ep-r       { text-align: center; }
    .ep-r .airport-name { margin: 0 auto; }
    .hero-strip { height: 160px; }
    .hero-airline-name { font-size: 16px; }
    .flight-no-pill { display: none; }
}
</style>

<div class="bg-texture"></div>

<div class="container page-wrap">

    {{-- ── Success Toast ── --}}
    @if(session('success'))
    <div id="successMsg">
        <span style="font-size:18px">✔</span> {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div style="margin-bottom:18px;padding:16px;border:1px solid #f5c2c7;background:#f8d7da;color:#842029;border-radius:12px;">
        <strong>There were some problems with your booking:</strong>
        <ul style="margin:8px 0 0 18px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @php
        $dep       = \Carbon\Carbon::parse($flight->departure_time);
        $arr       = \Carbon\Carbon::parse($flight->arrival_time);
        $overnight = (int)($flight->overnight_arrival ?? 0);
        if ($overnight) $arr->addDay();
        elseif ($arr->lessThan($dep)) $arr->addDay();
        $diff      = $dep->diff($arr);
        $stopovers = $flight->stopover_cities ? json_decode($flight->stopover_cities, true) : [];
        $classes   = $flight->flightClasses ?? collect();
        $econClass = $classes->firstWhere('class_type', 'Economy') ?? $classes->sortBy('total_price')->first();
        $basePrice = $econClass ? $econClass->total_price : 0;
        $defaultTravelDate = request('travel_date', request('depart', date('Y-m-d')));
        $defaultReturnDate = request('return');
        $selectedTrip = request('trip', 'one-way');
        $tripType = $selectedTrip === 'round' ? 'Round Trip' : 'One Way';
    @endphp

    <div class="row g-4">

        {{-- ══════════ LEFT COLUMN ══════════ --}}
        <div class="col-lg-7">

            {{-- ── Hero Strip ── --}}
            {{--
                FIX SUMMARY:
                1. Removed stray `forelse($flights as $flight)` text that was literally printed inside the div.
                2. hero-strip-bg (<img>) is now a sibling of .hero-strip-overlay and .hero-strip-content,
                   NOT inside .airline-logo-wrap.
                3. .hero-strip has a fixed height (220px) so content is always visible.
                4. All layers are stacked correctly: bg-img → overlay → content (z-index: 1 / 2).
            --}}
            <div class="hero-strip">

                {{-- Layer 1 — background image (fills the strip) --}}
                @if($flight->airline_logo)
                    <img
                        src="{{ asset($flight->airline_logo) }}"
                        class="hero-strip-bg"
                        alt="{{ $flight->airline_name }}"
                        onerror="this.style.display='none';"
                    >
                @else
                    {{-- Fallback: a subtle pattern when no image exists --}}
                    <div style="position:absolute;inset:0;background:linear-gradient(135deg,#1a1714 0%,#3a2e24 50%,#2d2520 100%);"></div>
                @endif

                {{-- Layer 2 — dark gradient overlay --}}
                <div class="hero-strip-overlay"></div>

                {{-- Layer 3 — content --}}
                <div class="hero-strip-content">

                    {{-- Airline logo icon (small, in content row) --}}
                    <div class="airline-logo-wrap">
                        @if($flight->airline_logo)
                            <img
                                src="{{ asset($flight->airline_logo) }}"
                                alt="{{ $flight->airline_name }}"
                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
                            >
                            <div class="al-init" style="display:none;">
                                {{ strtoupper(substr($flight->airline_code ?? 'AI', 0, 2)) }}
                            </div>
                        @else
                            <div class="al-init">
                                {{ strtoupper(substr($flight->airline_code ?? 'AI', 0, 2)) }}
                            </div>
                        @endif
                    </div>

                    {{-- Airline name + tags --}}
                    <div class="hero-text">
                        <div class="hero-airline-name">{{ $flight->airline_name }}</div>
                        <div class="hero-meta">
                            <span class="hero-tag">
                                <i class="fa-solid fa-plane"></i>
                                {{ $flight->flight_number }}
                            </span>
                            @if($flight->aircraft_type)
                            <span class="hero-tag">
                                <i class="fa-solid fa-jet-fighter-up"></i>
                                {{ $flight->aircraft_type }}
                            </span>
                            @endif
                            <span class="hero-tag">
                                <i class="fa-solid fa-circle-dot"></i>
                                {{ $flight->stops == 0 ? 'Non-stop' : $flight->stops.' Stop'.($flight->stops > 1 ? 's' : '') }}
                            </span>
                            <span class="hero-tag">
                                <i class="fa-solid fa-location-dot"></i>
                                {{ $flight->from_airport_code }} → {{ $flight->to_airport_code }}
                            </span>
                        </div>
                    </div>

                    {{-- Flight number pill (right side) --}}
                    <div class="flight-no-pill">
                        {{ $flight->flight_number }}
                    </div>

                </div>{{-- /hero-strip-content --}}
            </div>{{-- /hero-strip --}}

            {{-- Route Card --}}
            <div class="card-block">
                <div class="s-title"><i class="fa-solid fa-route" style="color:var(--gold)"></i> Route</div>
                <div class="route-row">

                    {{-- Origin --}}
                    <div class="ep">
                        <div class="time">{{ $dep->format('H:i') }}</div>
                        <div class="iata">{{ $flight->from_airport_code }}</div>
                        <div class="city-name">{{ $flight->from_city }}</div>
                        <div class="airport-name">{{ $flight->from_airport }}</div>
                    </div>

                    {{-- Middle track --}}
                    <div class="route-mid">
                        <div class="r-track">
                            <div class="r-dot"></div>
                            <div class="r-line"></div>
                            <div class="r-plane-icon">✈</div>
                            <div class="r-line rev"></div>
                            <div class="r-dot"></div>
                        </div>
                        <div class="dur-badge">{{ $diff->h }}h {{ $diff->i }}m</div>
                        @if(count($stopovers))
                        <div class="stopover-info">
                            <i class="fa-solid fa-clock" style="font-size:11px;"></i> Stopover via
                            @foreach($stopovers as $city)
                                <span class="sv-pill">{{ $city }}</span>
                            @endforeach
                        </div>
                        @endif
                        @if($overnight)
                        <div class="overnight-pill">
                            <i class="fa-solid fa-moon"></i> Arrives next day (+1)
                        </div>
                        @endif
                    </div>

                    {{-- Destination --}}
                    <div class="ep ep-r">
                        <div class="time">{{ $arr->format('H:i') }}</div>
                        <div class="iata">{{ $flight->to_airport_code }}</div>
                        <div class="city-name">{{ $flight->to_city }}</div>
                        <div class="airport-name">{{ $flight->to_airport }}</div>
                    </div>

                </div>
            </div>

            {{-- Info Grid --}}
            <div class="info-grid">
                <div class="info-cell">
                    <div class="ic-lbl">Departure</div>
                    <div class="ic-val">{{ $dep->format('h:i A') }}</div>
                </div>
                <div class="info-cell">
                    <div class="ic-lbl">Arrival</div>
                    <div class="ic-val">
                        {{ $arr->format('h:i A') }}
                    </div>
                </div>
                <div class="info-cell">
                    <div class="ic-lbl">From Airport</div>
                    <div class="ic-val" style="font-size:12px;line-height:1.4;">{{ $flight->from_airport }}</div>
                </div>
                <div class="info-cell">
                    <div class="ic-lbl">To Airport</div>
                    <div class="ic-val" style="font-size:12px;line-height:1.4;">{{ $flight->to_airport }}</div>
                </div>
                <div class="info-cell">
                    <div class="ic-lbl">Duration</div>
                    <div class="ic-val">{{ $diff->h }}h {{ $diff->i }}m</div>
                </div>
                <div class="info-cell">
                    <div class="ic-lbl">Stops</div>
                    <div class="ic-val">{{ $flight->stops == 0 ? 'Non-stop' : $flight->stops.' Stop'.($flight->stops > 1 ? 's' : '') }}</div>
                </div>
                @if($flight->aircraft_type)
                <div class="info-cell">
                    <div class="ic-lbl">Aircraft</div>
                    <div class="ic-val">{{ $flight->aircraft_type }}</div>
                </div>
                @endif
                <div class="info-cell">
                    <div class="ic-lbl">Airline Code</div>
                    <div class="ic-val">{{ $flight->airline_code }}</div>
                </div>
            </div>

            {{-- Available Classes --}}
            <div class="card-block">
                <div class="s-title"><i class="fa-solid fa-chair" style="color:var(--gold)"></i> Available Classes</div>
                <div class="class-grid">
                    @forelse($classes as $cls)
                    @php
                        $isSoldOut = $cls->available_seats <= 0;
                        $isLow     = !$isSoldOut && $cls->available_seats <= 5;
                    @endphp
                    <div class="class-card {{ $isSoldOut ? 'sold-out' : ($loop->first ? 'selected' : '') }}"
                         id="cls-{{ $cls->id }}"
                         onclick="{{ !$isSoldOut ? 'selectClass('.$cls->id.','.$cls->total_price.',this)' : '' }}">
                        <div class="class-top">
                            <div class="class-name">{{ $cls->class_type }}</div>
                            <div style="display:flex;align-items:center;gap:10px;">
                                @if($isSoldOut)
                                    <span class="seats-badge"><i class="fa-solid fa-ban"></i> Sold Out</span>
                                @elseif($isLow)
                                    <span class="seats-badge"><i class="fa-solid fa-fire"></i> {{ $cls->available_seats }} left</span>
                                @else
                                    <span class="seats-badge ok"><i class="fa-solid fa-check"></i> {{ $cls->available_seats }} seats</span>
                                @endif
                                <div class="class-price">
                                    <span class="sym">$</span>{{ number_format($cls->total_price) }}
                                    <span class="per">/person</span>
                                </div>
                            </div>
                        </div>
                        <div class="class-meta">
                            <span class="cm-tag green"><i class="fa-solid fa-briefcase"></i> Cabin {{ $cls->cabin_baggage_kg }}kg</span>
                            <span class="cm-tag"><i class="fa-solid fa-suitcase-rolling"></i> Check-in {{ $cls->checkin_baggage_kg }}kg</span>
                            <span class="cm-tag"><i class="fa-solid fa-indian-rupee-sign"></i> Base ${{ number_format($cls->base_price) }}</span>
                            <span class="cm-tag"><i class="fa-solid fa-receipt"></i> Tax ${{ number_format($cls->tax) }}</span>
                            @if($cls->is_refundable)
                                <span class="cm-tag green"><i class="fa-solid fa-rotate-left"></i> Refundable</span>
                            @else
                                <span class="cm-tag rose"><i class="fa-solid fa-ban"></i> Non-refundable</span>
                            @endif
                            @if($cls->cancellation_charge > 0)
                                <span class="cm-tag rose"><i class="fa-solid fa-triangle-exclamation"></i> Cancel fee ${{ number_format($cls->cancellation_charge) }}</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div style="text-align:center;padding:32px;color:var(--muted);font-size:14px;">
                        No class information available.
                    </div>
                    @endforelse
                </div>
            </div>

        </div>{{-- /col-lg-7 --}}

        {{-- ══════════ RIGHT: BOOKING FORM ══════════ --}}
        <div class="col-lg-5">
            <div class="form-card">

                <div class="form-card-eyebrow">✈ Secure Booking</div>
                <div class="form-card-title">Book Your Flight</div>
                <div class="form-card-sub">Fill in your details to confirm the reservation</div>

                <form action="{{ route('flightbooking', $flight->id) }}" method="POST" id="bookingForm">
                    @csrf
                    <input type="hidden" name="user_id"   value="{{ Auth::id() }}">
                    <input type="hidden" name="adults"    id="adultInput"   value="1">
                    <input type="hidden" name="children"  id="childInput"   value="0">
                    <input type="hidden" name="class"     id="classInput"   value="{{ $econClass->class_type ?? 'Economy' }}">
                    <input type="hidden" name="class_id"  id="classIdInput" value="{{ $econClass->id ?? '' }}">
                    <input type="hidden" name="return_date" value="{{ old('return_date', $defaultReturnDate) }}">

                    <div class="mb-3">
                        <label class="form-label-custom">Travel Date</label>
                        <input type="date" name="travel_date" class="custom-input"
                               required
                               value="{{ old('travel_date', $defaultTravelDate) }}"
                               min="{{ date('Y-m-d') }}">
                    </div>
                    @if($tripType === 'Round Trip' && $defaultReturnDate)
                    <div class="mb-3" style="color:#4a4a4a;font-size:0.95rem;">
                        <strong>Return Date:</strong> {{ \Carbon\Carbon::parse($defaultReturnDate)->format('d M Y') }}
                    </div>
                    @endif

                    {{-- Passenger Details --}}
                    <div class="s-title" style="margin-bottom:16px;">
                        <i class="fa-solid fa-user" style="color:var(--gold)"></i> Passenger Details
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label-custom">First Name</label>
                            <input type="text" name="first_name" class="custom-input"
                                   placeholder="John" required
                                   value="{{ old('first_name') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Last Name</label>
                            <input type="text" name="last_name" class="custom-input"
                                   placeholder="Doe" required
                                   value="{{ old('last_name') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">Gender</label>
                            <select name="gender" class="custom-input" required>
                                <option value="" disabled selected>Select gender</option>
                                <option value="Male"   {{ old('gender') == 'Male'   ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other"  {{ old('gender') == 'Other'  ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">Email</label>
                            <input type="email" name="email" class="custom-input"
                                   placeholder="john@example.com" required
                                   value="{{ old('email', Auth::user()->email ?? '') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">Phone Number</label>
                            <input type="text" name="phone_number" class="custom-input"
                                   placeholder="+91 98765 43210" required
                                   value="{{ old('phone_number') }}">
                        </div>
                    </div>

                    <div class="form-divider"></div>

                    {{-- Trip Type --}}
                    <label class="form-label-custom" style="margin-bottom:10px;">Trip Type</label>
                    <div style="display:flex;gap:8px;margin-bottom:20px;">
                        <label style="flex:1;cursor:pointer;">
                            <input type="radio" name="trip_type" value="One Way" {{ $tripType === 'One Way' ? 'checked' : '' }} style="display:none;" class="trip-radio">
                            <div class="cs-option {{ $tripType === 'One Way' ? 'active' : '' }}" id="trip-ow" onclick="selectTrip('One Way')">
                                <div class="cs-radio"></div>
                                <div class="cs-name">One Way</div>
                                <i class="fa-solid fa-arrow-right" style="color:var(--gold);font-size:12px;"></i>
                            </div>
                        </label>
                        <label style="flex:1;cursor:pointer;">
                            <input type="radio" name="trip_type" value="Round Trip" {{ $tripType === 'Round Trip' ? 'checked' : '' }} style="display:none;" class="trip-radio">
                            <div class="cs-option {{ $tripType === 'Round Trip' ? 'active' : '' }}" id="trip-rt" onclick="selectTrip('Round Trip')">
                                <div class="cs-radio"></div>
                                <div class="cs-name">Round Trip</div>
                                <i class="fa-solid fa-arrows-rotate" style="color:{{ $tripType === 'Round Trip' ? 'var(--gold)' : 'var(--muted)' }};font-size:12px;" id="rt-icon"></i>
                            </div>
                        </label>
                    </div>

                    {{-- Cabin Class --}}
                    <label class="form-label-custom" style="margin-bottom:10px;">Cabin Class</label>
                    <div class="class-select-wrap" style="margin-bottom:20px;">
                        @foreach($classes as $cls)
                        @php $sold = $cls->available_seats <= 0; @endphp
                        <div class="cs-option {{ $loop->first && !$sold ? 'active' : '' }} {{ $sold ? 'disabled' : '' }}"
                             id="form-cls-{{ $cls->id }}"
                             onclick="{{ !$sold ? 'selectClass('.$cls->id.','.$cls->total_price.',null,\''.$cls->class_type.'\')' : '' }}">
                            <div class="cs-radio"></div>
                            <div class="cs-name">{{ $cls->class_type }}</div>
                            <div class="cs-price">${{ number_format($cls->total_price) }}</div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Passengers --}}
                    <label class="form-label-custom" style="margin-bottom:10px;">Passengers</label>
                    <div class="passenger-box" style="margin-bottom:0;">
                        <div class="passenger-row">
                            <div class="passenger-label">
                                <strong>Adults</strong>
                                <small>Age 18 and above</small>
                            </div>
                            <div class="counter">
                                <button type="button" onclick="changeCount('adult',-1)">−</button>
                                <span id="adultCount">1</span>
                                <button type="button" onclick="changeCount('adult',1)">+</button>
                            </div>
                        </div>
                        <div class="passenger-row">
                            <div class="passenger-label">
                                <strong>Children</strong>
                                <small>Ages 0 – 17</small>
                            </div>
                            <div class="counter">
                                <button type="button" onclick="changeCount('child',-1)">−</button>
                                <span id="childCount">0</span>
                                <button type="button" onclick="changeCount('child',1)">+</button>
                            </div>
                        </div>
                    </div>

                    {{-- Price Summary --}}
                    <div class="price-summary">
                        <div class="ps-row">
                            <span class="ps-label">Cabin class</span>
                            <span class="ps-val" id="summaryClass">{{ $econClass->class_type ?? '—' }}</span>
                        </div>
                        <div class="ps-row">
                            <span class="ps-label">Price per person</span>
                            <span class="ps-val">$<span id="summaryPerPerson">{{ number_format($basePrice) }}</span></span>
                        </div>
                        <div class="ps-row">
                            <span class="ps-label">Passengers</span>
                            <span class="ps-val"><span id="summaryPax">1</span> Adult(s)</span>
                        </div>
                        <div class="ps-divider"></div>
                        <div class="ps-row">
                            <span class="ps-total-label">Total Amount</span>
                            <span class="ps-total-val">$<span id="summaryTotal">{{ number_format($basePrice) }}</span></span>
                        </div>
                    </div>

                    <button class="btn-main" type="submit">
                        Confirm Booking &nbsp;✈
                    </button>

                </form>
            </div>
        </div>

    </div>{{-- /row --}}
</div>

<script>
let adult           = 1;
let child           = 0;
let pricePerPax     = {{ $basePrice }};
let selectedClassId = {{ $econClass->id ?? 'null' }};

/* ── Class selection ──────────────────────────────────── */
function selectClass(id, price, cardEl, className) {
    pricePerPax     = price;
    selectedClassId = id;

    // Update left-column class cards
    document.querySelectorAll('.class-card').forEach(c => c.classList.remove('selected'));
    const card = document.getElementById('cls-' + id);
    if (card) card.classList.add('selected');

    // Update form class options
    document.querySelectorAll('.cs-option[id^="form-cls-"]').forEach(c => c.classList.remove('active'));
    const formOpt = document.getElementById('form-cls-' + id);
    if (formOpt) formOpt.classList.add('active');

    if (className) {
        document.getElementById('classInput').value         = className;
        document.getElementById('summaryClass').textContent = className;
    }
    document.getElementById('classIdInput').value = id;
    updatePrice();
}

/* ── Trip type toggle ─────────────────────────────────── */
function selectTrip(type) {
    const ow     = document.getElementById('trip-ow');
    const rt     = document.getElementById('trip-rt');
    const rtIcon = document.getElementById('rt-icon');

    if (type === 'One Way') {
        ow.classList.add('active');    rt.classList.remove('active');
        rtIcon.style.color = 'var(--muted)';
    } else {
        rt.classList.add('active');    ow.classList.remove('active');
        rtIcon.style.color = 'var(--gold)';
    }
    document.querySelectorAll('.trip-radio').forEach(r => {
        r.checked = r.value === type;
    });
}

/* ── Passenger counters ───────────────────────────────── */
function changeCount(type, delta) {
    if (type === 'adult') adult = Math.max(0, adult + delta);
    if (type === 'child') child = Math.max(0, child + delta);
    if (adult + child === 0) { type === 'adult' ? adult = 1 : child = 1; }

    document.getElementById('adultCount').innerText = adult;
    document.getElementById('childCount').innerText = child;
    document.getElementById('adultInput').value     = adult;
    document.getElementById('childInput').value     = child;
    updatePrice();
}

/* ── Price summary ────────────────────────────────────── */
function updatePrice() {
    const totalPax = adult + child;
    const total    = totalPax * pricePerPax;

    document.getElementById('summaryPerPerson').innerText = pricePerPax.toLocaleString('en-IN');
    document.getElementById('summaryPax').innerText       = totalPax;
    document.getElementById('summaryTotal').innerText     = total.toLocaleString('en-IN');
}

/* ── Success toast auto-hide ──────────────────────────── */
setTimeout(function () {
    const msg = document.getElementById('successMsg');
    if (msg) {
        msg.style.opacity   = '0';
        msg.style.transform = 'translateY(-10px)';
        setTimeout(() => msg.remove(), 500);
    }
}, 3000);
</script>

@endsection