@extends('header')

@section('home')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
:root{
  --primary:#1d4ed8;--primary-dark:#1e3a8a;--primary-mid:#2563eb;
  --primary-light:#eff6ff;--primary-pale:#dbeafe;
  --navy:#0f172a;--slate:#1e293b;--gray:#64748b;
  --border:#e2e8f0;--bg:#f1f5f9;
  --r8:8px;--r12:12px;--r16:16px;--r20:20px;
  --sh-lg:0 20px 60px rgba(0,0,0,.14),0 8px 24px rgba(0,0,0,.07);
  --font-main:'Outfit',sans-serif;
  --font-display:'Sora',sans-serif;
}
body,html{font-family:var(--font-main);background:var(--bg);}

/* ── HERO ── */
.hero{position:relative;height:100vh;min-height:620px;overflow:hidden;}
.slide{position:absolute;inset:0;background-size:cover;background-position:center;opacity:0;transform:scale(1.07);transition:opacity 1.4s ease,transform 8s ease;}
.slide.active{opacity:1;transform:scale(1);}
.slide:nth-child(1){background-image:url('{{ asset("images/sea.jpg") }}');}
.slide:nth-child(2){background-image:url('{{ asset("images/lake.jpg") }}');}
.slide:nth-child(3){background-image:url('{{ asset("images/mountain.jpg") }}');}
.hero-overlay{position:absolute;inset:0;background:linear-gradient(to bottom,rgba(10,22,40,.18) 0%,rgba(10,22,40,.10) 40%,rgba(10,22,40,.62) 100%);}
.hero-search-wrap{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;z-index:10;padding:0 16px;}
@keyframes searchRise{from{opacity:0;transform:translateY(40px) scale(.96);}to{opacity:1;transform:translateY(0) scale(1);}}

/* ── SEARCH BOX ── */
.search-box{
  width:85%;
  max-width:1200px;
  min-width:320px;
  background:rgba(255,255,255,.97);
  backdrop-filter:blur(20px);
  border-radius:24px;
  box-shadow:0 32px 80px rgba(0,0,0,.28),0 8px 20px rgba(29,78,216,.12);
  overflow:visible;
  animation:searchRise .9s cubic-bezier(.22,1,.36,1) both;
}
.sb-tabs{display:flex;border-bottom:1px solid var(--border);padding:0 8px;gap:2px;border-radius:24px 24px 0 0;overflow:hidden;}
.sb-tab{flex:1;display:flex;flex-direction:column;align-items:center;gap:5px;padding:14px 10px 12px;cursor:pointer;border:none;background:transparent;font-family:var(--font-main);font-size:13px;font-weight:600;color:var(--gray);border-bottom:3px solid transparent;transition:color .2s,border-color .2s;white-space:nowrap;}
.sb-tab .tab-icon{width:38px;height:38px;border-radius:12px;background:#F0F4FF;display:flex;align-items:center;justify-content:center;font-size:18px;transition:background .2s,transform .2s;}
.sb-tab:hover .tab-icon{background:#dce8ff;transform:scale(1.08);}
.sb-tab.active{color:var(--primary);border-bottom-color:var(--primary);}
.sb-tab.active .tab-icon{background:var(--primary-light);}
.sb-panel{display:none;padding:20px 24px 22px;}
.sb-panel.active{display:block;}

/* trip sub-tabs */
.trip-tabs-inner{display:flex;gap:6px;margin-bottom:16px;}
.trip-tab-inner{display:flex;align-items:center;gap:6px;padding:6px 16px;border-radius:100px;border:2px solid var(--border);background:#fff;font-size:.76rem;font-weight:700;color:var(--gray);cursor:pointer;transition:all .16s;}
.trip-tab-inner.active{background:var(--primary);color:#fff;border-color:var(--primary);}
.trip-tab-inner:hover:not(.active){border-color:var(--primary);color:var(--primary);}

/* fields */
.sb-fields{display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;}
.sb-field{flex:1;min-width:120px;display:flex;flex-direction:column;gap:4px;}
.sb-field label{font-size:.64rem;font-weight:800;letter-spacing:.07em;color:var(--gray);text-transform:uppercase;}
.sf-wrap{position:relative;}
.sf-icon-abs{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:var(--primary);font-size:.76rem;pointer-events:none;}
.sf-inp{width:100%;padding:11px 12px 11px 32px;border:1.5px solid var(--border);border-radius:12px;font-family:var(--font-main);font-size:.88rem;font-weight:500;color:var(--navy);background:#FAFBFF;outline:none;transition:border-color .2s,box-shadow .2s;}
.sf-inp:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(29,78,216,.10);}
.sf-inp::placeholder{color:#b0bac8;font-weight:400;}
.sf-date{width:100%;padding:11px 12px;border:1.5px solid var(--border);border-radius:12px;font-family:var(--font-main);font-size:.88rem;font-weight:500;color:var(--navy);background:#FAFBFF;outline:none;transition:border-color .2s,box-shadow .2s;}
.sf-date:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(29,78,216,.10);}
.sf-select{width:100%;padding:11px 12px;border:1.5px solid var(--border);border-radius:12px;font-family:var(--font-main);font-size:.88rem;font-weight:500;color:var(--navy);background:#FAFBFF;outline:none;transition:border-color .2s;}
.sf-select:focus{border-color:var(--primary);}
.sb-swap{display:flex;align-items:flex-end;padding-bottom:2px;}
.swap-btn{width:36px;height:36px;border-radius:50%;background:var(--primary-light);border:2px solid var(--primary);color:var(--primary);font-size:14px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .2s,transform .2s;flex-shrink:0;}
.swap-btn:hover{background:var(--primary);color:#fff;transform:rotate(180deg);}

/* Cars two-row layout */
.sb-row{display:flex;gap:10px;width:100%;align-items:flex-end;flex-wrap:wrap;}
.sb-row + .sb-row{margin-top:10px;}

/* TCC */
.tcc-wrap{position:relative;}
.tcc-trigger{border:1.5px solid var(--border);border-radius:12px;padding:10px 10px;width:100%;background:#FAFBFF;cursor:pointer;display:flex;align-items:center;gap:6px;transition:border-color .2s;user-select:none;overflow:hidden;min-width:0;}
.tcc-trigger:hover,.tcc-trigger.open{border-color:var(--primary);}
.tcc-trigger.open{box-shadow:0 0 0 3px rgba(29,78,216,.10);}
.tcc-icon{color:var(--primary);font-size:.78rem;flex-shrink:0;}
.tcc-text{flex:1;min-width:0;overflow:hidden;}
.tcc-lbl{font-size:.62rem;font-weight:800;color:var(--gray);text-transform:uppercase;letter-spacing:.09em;display:block;line-height:1;}
.tcc-val{font-size:.82rem;font-weight:600;color:var(--navy);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;line-height:1.4;max-width:100%;}
.tcc-chev{color:var(--gray);font-size:.65rem;flex-shrink:0;transition:transform .2s;}
.tcc-trigger.open .tcc-chev{transform:rotate(180deg);}
.tcc-drop{position:absolute;top:calc(100% + 8px);left:0;min-width:300px;background:#fff;border:2px solid var(--border);border-radius:var(--r16);box-shadow:var(--sh-lg);z-index:9999;display:none;overflow:hidden;}
.tcc-drop.open{display:block;}
.tcc-sec{padding:14px 18px;border-bottom:1px solid #f1f5f9;}
.tcc-slbl{font-size:.68rem;font-weight:800;color:var(--gray);text-transform:uppercase;letter-spacing:.1em;margin-bottom:8px;display:block;}
.cabin-sel{width:100%;border:1.5px solid var(--border);border-radius:var(--r8);padding:9px 12px;font-size:.88rem;font-family:var(--font-main);color:var(--navy);font-weight:500;outline:none;background:#fff;cursor:pointer;}
.cabin-sel:focus{border-color:var(--primary);}
.pax-row{display:flex;align-items:center;justify-content:space-between;padding:7px 0;}
.pax-info strong{font-size:.88rem;font-weight:700;color:var(--navy);display:block;}
.pax-info small{font-size:.7rem;color:var(--gray);margin-top:1px;display:block;}
.pax-ctrl{display:flex;align-items:center;gap:12px;}
.pax-btn{width:30px;height:30px;border-radius:var(--r8);border:1.5px solid var(--border);background:#fff;cursor:pointer;font-size:.9rem;font-weight:700;display:flex;align-items:center;justify-content:center;transition:all .15s;color:var(--navy);}
.pax-btn:hover:not(:disabled){border-color:var(--primary);background:var(--primary);color:#fff;}
.pax-btn:disabled{opacity:.3;cursor:not-allowed;}
.pax-count{font-weight:800;font-size:1rem;min-width:18px;text-align:center;color:var(--navy);}
.tcc-note{padding:11px 18px;font-size:.7rem;color:var(--gray);line-height:1.55;border-top:1px solid #f1f5f9;}
.btn-apply{display:block;width:100%;background:var(--primary);color:#fff;border:none;padding:12px;font-family:var(--font-display);font-weight:700;font-size:.86rem;cursor:pointer;transition:background .15s;}
.btn-apply:hover{background:var(--primary-dark);}
.sb-search-btn{height:46px;padding:0 26px;background:linear-gradient(135deg,var(--primary-mid),var(--primary-dark));color:#fff;border:none;border-radius:12px;font-family:var(--font-display);font-size:.86rem;font-weight:700;display:flex;align-items:center;gap:7px;cursor:pointer;transition:transform .15s,box-shadow .15s;white-space:nowrap;flex-shrink:0;}
.sb-search-btn:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(29,78,216,.38);}

/* ── LISTINGS ── */
.listings{padding:52px 0 80px;background:var(--bg);}
.section-head{text-align:center;margin-bottom:40px;}
.section-head h2{font-family:var(--font-display);font-size:clamp(24px,3.5vw,36px);font-weight:800;color:var(--navy);margin-bottom:6px;}
.section-head p{color:var(--gray);font-size:15px;}
.listing-panel{display:none;}
.listing-panel.active{display:block;}

/* ── FLIGHT CARD ── */
.fcard-link{display:block;text-decoration:none;color:inherit;}
.fcard{background:#fff;border-radius:var(--r16);border:2px solid var(--border);overflow:hidden;transition:transform .2s,box-shadow .2s,border-color .2s;}
.fcard-link:hover .fcard{transform:translateY(-4px);box-shadow:0 20px 56px rgba(29,78,216,.12),0 4px 16px rgba(0,0,0,.07);border-color:#bfdbfe;}
.fcard-top{background:linear-gradient(135deg,#f8faff 0%,#eef4ff 100%);padding:12px 18px;display:flex;align-items:center;justify-content:space-between;border-bottom:1.5px solid #e8edf8;flex-wrap:wrap;gap:8px;}
.fcard-airline{display:flex;align-items:center;gap:11px;}
.al-logo{width:42px;height:42px;border-radius:var(--r8);background:#fff;border:1.5px solid #dde3f0;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;font-size:.6rem;font-weight:800;color:var(--primary);letter-spacing:.04em;text-align:center;line-height:1.2;}
.al-logo img{width:100%;height:100%;object-fit:contain;padding:3px;display:block;}
.al-name{font-family:var(--font-display);font-weight:700;font-size:.9rem;color:var(--navy);}
.al-sub{font-size:.7rem;color:var(--gray);margin-top:2px;display:flex;align-items:center;gap:6px;}
.al-flno{font-weight:600;color:var(--slate);}
.al-ac{background:#f1f5f9;border:1px solid var(--border);padding:1px 7px;border-radius:5px;font-size:.64rem;font-weight:700;}
.fcard-badges{display:flex;align-items:center;gap:6px;flex-wrap:wrap;}
.fc-badge{font-size:.67rem;font-weight:800;padding:4px 11px;border-radius:100px;display:inline-flex;align-items:center;gap:4px;}
.fc-badge-ns{background:#dcfce7;color:#14532d;}
.fc-badge-1s{background:#fef9c3;color:#78350f;}
.fc-badge-2s{background:#fee2e2;color:#7f1d1d;}
.fcard-route{padding:20px 18px 0;}
.route-row{display:flex;align-items:stretch;justify-content:space-between;gap:0;}
.ep{min-width:90px;display:flex;flex-direction:column;justify-content:center;}
.ep-r{text-align:right;align-items:flex-end;}
.ep-time{font-family:var(--font-display);font-size:1.55rem;font-weight:800;color:var(--navy);line-height:1;}
.ep-iata{font-size:.86rem;font-weight:800;color:var(--primary);margin-top:4px;letter-spacing:.07em;}
.ep-city{font-size:.7rem;color:var(--gray);margin-top:2px;font-weight:500;}
.ep-airport{font-size:.62rem;color:#94a3b8;margin-top:1px;line-height:1.35;}
.route-mid{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;padding:0 12px;min-width:0;}
.route-line{display:flex;align-items:center;width:100%;gap:3px;}
.r-dot{width:7px;height:7px;border-radius:50%;border:2.5px solid var(--primary);background:#fff;flex-shrink:0;}
.r-dash{flex:1;height:2px;background:repeating-linear-gradient(90deg,var(--primary) 0,var(--primary) 4px,transparent 4px,transparent 9px);}
.r-plane{font-size:.82rem;color:var(--primary);}
.dur-pill{background:var(--primary-light);color:var(--primary-mid);font-size:.68rem;font-weight:700;padding:3px 10px;border-radius:100px;white-space:nowrap;}
.stopover-tag{display:inline-flex;align-items:center;justify-content:center;gap:5px;flex-wrap:wrap;background:#fffbeb;border:1px solid #fde68a;color:#92400e;font-size:.68rem;font-weight:600;padding:4px 12px;border-radius:7px;width:80%;text-align:center;line-height:1.4;}
.stopover-tag i{font-size:.65rem;color:#d97706;flex-shrink:0;}
.sv-city{background:#fef3c7;border:1px solid #fde68a;padding:1px 8px;border-radius:100px;font-size:.64rem;font-weight:700;color:#78350f;white-space:nowrap;}
.overnight-tag{display:inline-flex;align-items:center;justify-content:center;gap:5px;background:#f0f9ff;border:1px solid #bae6fd;color:#0369a1;font-size:.68rem;font-weight:600;padding:4px 12px;border-radius:7px;width:80%;text-align:center;}
.route-spacer{height:16px;}
.fcard-footer{border-top:1.5px solid #f1f5f9;padding:14px 18px 16px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;}
.fp-left{display:flex;align-items:center;gap:14px;}
.fp-label{display:inline-flex;align-items:center;gap:4px;background:var(--primary-pale);color:var(--primary-dark);font-size:.6rem;font-weight:800;letter-spacing:.07em;padding:2px 9px;border-radius:100px;margin-bottom:4px;text-transform:uppercase;}
.fp-price{font-family:var(--font-display);font-size:1.6rem;font-weight:800;color:var(--primary-dark);line-height:1;}
.fp-price .sym{font-size:.85rem;font-weight:500;vertical-align:super;}
.fp-baggage{display:flex;gap:10px;margin-top:6px;flex-wrap:wrap;}
.fp-baggage span{display:flex;align-items:center;gap:4px;font-size:.7rem;color:var(--gray);font-weight:500;}
.fp-baggage i{color:var(--primary);font-size:.65rem;}
.fp-divider{width:1px;height:44px;background:var(--border);flex-shrink:0;}
.fp-right{display:flex;flex-direction:column;align-items:flex-end;gap:7px;}
.seats-warn{display:flex;align-items:center;gap:5px;font-size:.7rem;font-weight:700;}
.s-fire{color:#dc2626;}.s-full{color:var(--gray);}
.btn-view{background:linear-gradient(135deg,var(--primary-mid),var(--primary-dark));color:#fff;border:none;border-radius:var(--r8);padding:10px 22px;font-family:var(--font-display);font-weight:700;font-size:.82rem;display:inline-flex;align-items:center;gap:6px;white-space:nowrap;transition:transform .14s,box-shadow .14s;cursor:pointer;}
.fcard-link:hover .btn-view{transform:translateY(-2px);box-shadow:0 8px 24px rgba(29,78,216,.4);}
.btn-na{background:#f1f5f9;color:var(--gray);border:2px solid var(--border);border-radius:var(--r8);padding:9px 16px;font-family:var(--font-display);font-weight:700;font-size:.78rem;display:inline-flex;align-items:center;gap:6px;cursor:not-allowed;white-space:nowrap;}

/* ── HOTEL CARD ── */
.hotel-card{background:#fff;border-radius:var(--r16);overflow:hidden;border:2px solid var(--border);transition:transform .25s,box-shadow .25s,border-color .25s;height:100%;}
.hotel-card:hover{transform:translateY(-8px);box-shadow:0 24px 60px rgba(0,0,0,.12);border-color:#bfdbfe;}
.hotel-img{position:relative;overflow:hidden;height:200px;}
.hotel-img img{width:100%;height:100%;object-fit:cover;transition:transform .55s;display:block;}
.hotel-card:hover .hotel-img img{transform:scale(1.1);}
.hotel-img-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(10,22,40,.5) 0%,transparent 50%);}
.hotel-star{position:absolute;top:10px;right:10px;background:#FFC107;color:#1a1a1a;font-size:.65rem;font-weight:800;padding:3px 9px;border-radius:100px;display:flex;align-items:center;gap:3px;}
.hotel-body{padding:14px 16px 16px;}
.hotel-name{font-family:var(--font-display);font-weight:700;font-size:.95rem;color:var(--navy);margin-bottom:4px;}
.hotel-loc{font-size:.72rem;color:var(--gray);display:flex;align-items:center;gap:4px;margin-bottom:10px;}
.hotel-amenities{display:flex;flex-wrap:wrap;gap:5px;margin-bottom:12px;}
.hotel-am{background:#F0F4FF;color:var(--primary);font-size:.65rem;font-weight:600;padding:3px 9px;border-radius:100px;}
.hotel-footer-c{display:flex;align-items:center;justify-content:space-between;border-top:1.5px solid var(--border);padding-top:12px;}
.hotel-price strong{font-family:var(--font-display);font-size:1.3rem;font-weight:800;color:var(--primary-dark);}
.hotel-price small{font-size:.68rem;color:var(--gray);display:block;}
.hotel-btn{background:linear-gradient(135deg,var(--primary-mid),var(--primary-dark));color:#fff;border:none;border-radius:10px;padding:9px 18px;font-family:var(--font-display);font-weight:700;font-size:.78rem;display:inline-flex;align-items:center;gap:5px;cursor:pointer;text-decoration:none;transition:transform .15s,box-shadow .15s;}
.hotel-btn:hover{transform:translateY(-2px);box-shadow:0 8px 22px rgba(29,78,216,.35);color:#fff;}

/* empty */
.empty-box{text-align:center;padding:64px 20px;background:#fff;border-radius:var(--r16);border:2px dashed var(--border);}
.e-icon{width:64px;height:64px;border-radius:50%;background:var(--primary-light);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;}
.e-icon i{font-size:1.6rem;color:var(--primary);}
.empty-box h5{font-family:var(--font-display);font-weight:800;color:var(--navy);margin-bottom:6px;}
.empty-box p{color:var(--gray);font-size:.88rem;}

/* ── AUTOCOMPLETE ── */
.autocomplete-dropdown{
  position:absolute;top:calc(100% + 6px);left:0;width:100%;
  background:#fff;border:1.5px solid #bfdbfe;border-radius:14px;
  box-shadow:0 12px 40px rgba(0,0,0,.12),0 4px 12px rgba(29,78,216,.08);
  max-height:280px;overflow-y:auto;z-index:9999;
  padding:6px;display:flex;flex-direction:column;gap:2px;
}
.autocomplete-item{padding:8px 10px;border-radius:10px;cursor:pointer;transition:background .12s;border-bottom:none;}
.autocomplete-item:hover,.autocomplete-item.hovered{background:#eff6ff;}
.autocomplete-item.no-result{color:#94a3b8;cursor:default;font-size:.82rem;}
.ac-inner{display:flex;align-items:center;gap:10px;}
.ac-code-box{min-width:46px;height:46px;background:#eff6ff;border:1.5px solid #bfdbfe;border-radius:10px;display:flex;align-items:center;justify-content:center;font-family:'Sora',sans-serif;font-size:.72rem;font-weight:800;color:#1d4ed8;letter-spacing:.04em;flex-shrink:0;}
.ac-detail-name{font-weight:700;font-size:.84rem;color:#0f172a;line-height:1.25;}
.ac-detail-city{font-size:.72rem;color:#64748b;margin-top:2px;display:flex;align-items:center;gap:4px;}

/* ── RESPONSIVE ── */
@media(max-width:1100px){.search-box{width:92%;}}
@media(max-width:991px){.search-box{width:96%;}}
@media(max-width:768px){
  .search-box{width:100%;}
  .sb-tab{font-size:11px;padding:10px 6px;}
  .sb-tab .tab-icon{width:32px;height:32px;font-size:16px;}
  .sb-swap{display:none;}
  .sb-search-btn{width:100%;justify-content:center;}
  .ep-time{font-size:1.2rem;}
  .fp-price{font-size:1.3rem;}
  .fp-divider{display:none;}
}
@media(max-width:576px){
  .sb-panel{padding:16px;}
  .sb-fields{flex-direction:column;}
  .sb-row{flex-direction:column;}
  .fcard-footer{flex-direction:column;align-items:stretch;}
  .fp-right{flex-direction:row;align-items:center;justify-content:space-between;}
}
</style>

{{-- ══ HERO ══ --}}
<section class="hero">
  <div class="slide active"></div>
  <div class="slide"></div>
  <div class="slide"></div>
  <div class="hero-overlay"></div>

  <div class="hero-search-wrap">
    <div class="search-box">

      {{-- 4 mode tabs --}}
      <div class="sb-tabs">
        <button class="sb-tab active" data-panel="sp-flights" data-listing="lp-flights" onclick="switchMode(this)">
          <span class="tab-icon">✈️</span>Flights
        </button>
        <button class="sb-tab" data-panel="sp-hotels" data-listing="lp-hotels" onclick="switchMode(this)">
          <span class="tab-icon">🏨</span>Hotels
        </button>
        <button class="sb-tab" data-panel="sp-tours" data-listing="lp-tours" onclick="switchMode(this)">
          <span class="tab-icon">🌍</span>Tours
        </button>
        <button class="sb-tab" data-panel="sp-cars" data-listing="lp-cars" onclick="switchMode(this)">
          <span class="tab-icon">🚗</span>Cars
        </button>
      </div>

      {{-- ═══ FLIGHTS PANEL ═══ --}}
      <div class="sb-panel active" id="sp-flights">
        <div class="trip-tabs-inner">
          <button class="trip-tab-inner active" onclick="setTrip(this,'one-way')">
            <i class="fa-solid fa-arrow-right"></i>One Way
          </button>
          <button class="trip-tab-inner" onclick="setTrip(this,'round')">
            <i class="fa-solid fa-arrows-left-right"></i>Round Trip
          </button>
        </div>
        <form method="GET" action="#" id="homeFlightForm">
          <div class="sb-fields">

            {{-- FROM --}}
            <div class="sb-field" style="flex:1.3;">
              <label>From</label>
              <div class="sf-wrap position-relative">
                <i class="sf-icon-abs fa-solid fa-plane-departure"></i>
                <input type="text" id="fromInput" name="from" class="sf-inp"
                       placeholder="City or airport"
                       value="{{ request('from') }}" autocomplete="off">
                <div id="fromDropdown" class="autocomplete-dropdown" style="display:none;"></div>
                <input type="hidden" name="from_code" id="fromCode" value="{{ request('from_code') }}">
              </div>
            </div>

            {{-- SWAP --}}
            <div class="sb-swap">
              <button type="button" class="swap-btn" onclick="hfSwap()" title="Swap">⇄</button>
            </div>

            {{-- TO --}}
            <div class="sb-field" style="flex:1.3;">
              <label>To</label>
              <div class="sf-wrap position-relative">
                <i class="sf-icon-abs fa-solid fa-plane-arrival"></i>
                <input type="text" id="toInput" name="to" class="sf-inp"
                       placeholder="City or airport"
                       value="{{ request('to') }}" autocomplete="off">
                <div id="toDropdown" class="autocomplete-dropdown" style="display:none;"></div>
                <input type="hidden" name="to_code" id="toCode" value="{{ request('to_code') }}">
              </div>
            </div>

            {{-- DEPART --}}
            <div class="sb-field">
              <label>Depart</label>
              <input type="date" name="depart" id="hfDepartDate" class="sf-date"
                     value="{{ request('depart', date('Y-m-d')) }}"
                     min="{{ date('Y-m-d') }}">
            </div>

            {{-- RETURN (hidden by default) --}}
            <div class="sb-field" id="hfReturnWrap" style="display:none;">
              <label>Return</label>
              <input type="date" name="return" id="hfReturnDate" class="sf-date"
                     value="{{ request('return', date('Y-m-d', strtotime('+1 day'))) }}"
                     min="{{ request('depart', date('Y-m-d')) }}">
            </div>

            {{-- TRAVELLERS & CLASS --}}
            <div class="sb-field tcc-wrap" style="flex:1.4;">
              <label>Travellers &amp; Class</label>
              <div class="tcc-trigger" id="hfTccTrigger" onclick="toggleTcc()">
                <i class="fa-solid fa-users tcc-icon"></i>
                <div class="tcc-text">
                  <span class="tcc-lbl">Travellers &amp; Class</span>
                  <span class="tcc-val" id="hfTccVal">1 Adult, Economy</span>
                </div>
                <i class="fa-solid fa-chevron-down tcc-chev"></i>
              </div>
              <div class="tcc-drop" id="hfTccDrop">
                <div class="tcc-sec">
                  <span class="tcc-slbl">Cabin class</span>
                  <select class="cabin-sel" id="hfCabinSel" onchange="updateHfTcc()">
                    <option value="Economy"         {{ request('class','Economy')==='Economy'         ?'selected':'' }}>Economy</option>
                    <option value="Premium Economy" {{ request('class')==='Premium Economy'           ?'selected':'' }}>Premium Economy</option>
                    <option value="Business"        {{ request('class')==='Business'                  ?'selected':'' }}>Business</option>
                    <option value="First"           {{ request('class')==='First'                     ?'selected':'' }}>First</option>
                  </select>
                </div>
                <div class="tcc-sec">
                  <div class="pax-row">
                    <div class="pax-info"><strong>Adults</strong><small>Aged 18+</small></div>
                    <div class="pax-ctrl">
                      <button type="button" class="pax-btn" id="hfAdMinus" onclick="chHfPax('a',-1)">−</button>
                      <span class="pax-count" id="hfAdCnt">1</span>
                      <button type="button" class="pax-btn" onclick="chHfPax('a',1)">+</button>
                    </div>
                  </div>
                  <div class="pax-row" style="padding-top:0;">
                    <div class="pax-info"><strong>Children</strong><small>Aged 0–17</small></div>
                    <div class="pax-ctrl">
                      <button type="button" class="pax-btn" id="hfChMinus" onclick="chHfPax('c',-1)">−</button>
                      <span class="pax-count" id="hfChCnt">0</span>
                      <button type="button" class="pax-btn" onclick="chHfPax('c',1)">+</button>
                    </div>
                  </div>
                </div>
                <div class="tcc-note">Age at time of travel must be valid for the booked category. Airline policies on children may vary.</div>
                <button type="button" class="btn-apply" onclick="applyHfTcc()">Apply</button>
              </div>
              <input type="hidden" name="adults"   id="hfAdultsH"   value="{{ request('adults',1) }}">
              <input type="hidden" name="children" id="hfChildrenH" value="{{ request('children',0) }}">
              <input type="hidden" name="class"    id="hfClassH"    value="{{ request('class','Economy') }}">
              <input type="hidden" name="trip"     id="hfTripH"     value="{{ request('trip','one-way') }}">
            </div>

            <button type="submit" class="sb-search-btn">
              <i class="fa-solid fa-magnifying-glass"></i>Search Flights
            </button>
          </div>
        </form>
      </div>

      {{-- ═══ HOTELS PANEL ═══ --}}
      <div class="sb-panel" id="sp-hotels">
        <div class="sb-fields">
          <div class="sb-field" style="flex:2;">
            <label>Destination</label>
            <div class="sf-wrap">
              <i class="sf-icon-abs fa-solid fa-location-dot"></i>
              <input type="text" class="sf-inp" placeholder="City, region or hotel name">
            </div>
          </div>
          <div class="sb-field"><label>Check-in</label><input type="date" class="sf-date"></div>
          <div class="sb-field"><label>Check-out</label><input type="date" class="sf-date"></div>
          <div class="sb-field" style="flex:0.9;">
            <label>Guests &amp; Rooms</label>
            <select class="sf-select">
              <option>1 Room, 1 Guest</option>
              <option>1 Room, 2 Guests</option>
              <option>2 Rooms, 4 Guests</option>
            </select>
          </div>
          <button class="sb-search-btn"><i class="fa-solid fa-magnifying-glass"></i>Search Hotels</button>
        </div>
      </div>

      {{-- ═══ TOURS PANEL ═══ --}}
      <div class="sb-panel" id="sp-tours">
        <div class="sb-fields">
          <div class="sb-field" style="flex:2;">
            <label>Destination / Package</label>
            <div class="sf-wrap">
              <i class="sf-icon-abs fa-solid fa-map-location-dot"></i>
              <input type="text" class="sf-inp" placeholder="Where do you want to go?">
            </div>
          </div>
          <div class="sb-field"><label>Start Date</label><input type="date" class="sf-date"></div>
          <div class="sb-field">
            <label>Duration</label>
            <select class="sf-select">
              <option>Any</option><option>3–5 Days</option><option>6–8 Days</option>
              <option>9–14 Days</option><option>15+ Days</option>
            </select>
          </div>
          <div class="sb-field" style="flex:0.7;">
            <label>Travellers</label>
            <select class="sf-select">
              <option>1</option><option>2</option><option>3–5</option><option>6+</option>
            </select>
          </div>
          <button class="sb-search-btn"><i class="fa-solid fa-magnifying-glass"></i>Search Tours</button>
        </div>
      </div>

      {{-- ═══ CARS PANEL ═══ --}}
      <div class="sb-panel" id="sp-cars">
        <div class="sb-row" style="margin-bottom:10px;">
          <div class="sb-field" style="flex:1.5;">
            <label>Pick-up Location</label>
            <div class="sf-wrap">
              <i class="sf-icon-abs fa-solid fa-car"></i>
              <input type="text" class="sf-inp" placeholder="Airport, city or address">
            </div>
          </div>
          <div class="sb-field" style="flex:1.5;">
            <label>Drop-off Location</label>
            <div class="sf-wrap">
              <i class="sf-icon-abs fa-solid fa-flag-checkered"></i>
              <input type="text" class="sf-inp" placeholder="Same as pick-up">
            </div>
          </div>
        </div>
        <div class="sb-row">
          <div class="sb-field">
            <label>Pick-up Date</label>
            <input type="date" class="sf-date" id="carPickupDate"
                   min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}"
                   onchange="validateCarDates()">
          </div>
          <div class="sb-field">
            <label>Pick-up Time</label>
            <input type="time" class="sf-date" id="carPickupTime" value="10:00">
          </div>
          <div class="sb-field">
            <label>Drop-off Date</label>
            <input type="date" class="sf-date" id="carDropDate"
                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                   value="{{ date('Y-m-d', strtotime('+1 day')) }}"
                   onchange="validateCarDates()">
          </div>
          <div class="sb-field">
            <label>Drop-off Time</label>
            <input type="time" class="sf-date" id="carDropTime" value="10:00">
          </div>
          <div class="sb-field">
            <label>Car Type</label>
            <select class="sf-select">
              <option value="">Any Type</option>
              <option value="economy">Economy</option>
              <option value="compact">Compact</option>
              <option value="suv">SUV</option>
              <option value="luxury">Luxury</option>
              <option value="van">Van / MPV</option>
              <option value="electric">Electric</option>
            </select>
          </div>
          <button class="sb-search-btn">
            <i class="fa-solid fa-magnifying-glass"></i>Search Cars
          </button>
        </div>
      </div>

    </div>{{-- /search-box --}}
  </div>
</section>

{{-- ══ LISTINGS SECTION ══ --}}
<section class="listings" id="listingsSection">
<div class="container-xl">

  <div class="section-head">
    <h2 id="listing-title">Trending Flights</h2>
    <p id="listing-sub">Best deals on flights handpicked for you</p>
  </div>

  {{-- ════ FLIGHTS PANEL ════ --}}
  <div class="listing-panel active" id="lp-flights">

    @if(!isset($flights) || $flights->isEmpty())
    <div class="empty-box">
      <div class="e-icon"><i class="fa-solid fa-plane-circle-xmark"></i></div>
      <h5>No Flights Available</h5>
      <p>Use the search above to find available flights.</p>
    </div>

    @else
    <div class="d-flex flex-column gap-3" id="flightGrid">
      @foreach($flights as $flight)
      @php
        $dep       = \Carbon\Carbon::parse($flight->departure_time);
        $arr       = \Carbon\Carbon::parse($flight->arrival_time);
        $overnight = (int)($flight->overnight_arrival ?? 0);
        if ($overnight) $arr->addDay();
        elseif ($arr->lessThan($dep)) $arr->addDay();
        $diff      = $dep->diff($arr);
        $sc        = (int)$flight->stops;
        $stopLabel = $sc === 0 ? 'Non-stop' : ($sc === 1 ? '1 Stop' : $sc . ' Stops');
        $stopBadge = $sc === 0 ? 'fc-badge-ns' : ($sc === 1 ? 'fc-badge-1s' : 'fc-badge-2s');
        $stopovers = $flight->stopover_cities ? json_decode($flight->stopover_cities, true) : [];
        $classes   = $flight->flightClasses ?? collect();
        $econCls   = $classes->firstWhere('class_type', 'Economy') ?? $classes->sortBy('total_price')->first();
        $listPrice = $econCls ? $econCls->total_price : 0;
      @endphp

      <a href="{{ route('flight.details', $flight->id) }}?depart={{ date('Y-m-d') }}&trip=one-way"
         class="fcard-link">
        <div class="fcard">

          {{-- TOP --}}
          <div class="fcard-top">
            <div class="fcard-airline">
              <div class="al-logo" id="logo-{{ $flight->id }}">
                @if($flight->airline_logo)
                  <img src="{{ asset($flight->airline_logo) }}"
                       alt="{{ $flight->airline_name }}"
                       onerror="this.style.display='none';document.getElementById('logo-{{ $flight->id }}').innerText='{{ strtoupper(substr($flight->airline_code,0,2)) }}';">
                @else
                  {{ strtoupper(substr($flight->airline_code, 0, 2)) }}
                @endif
              </div>
              <div>
                <div class="al-name">{{ $flight->airline_name }}</div>
                <div class="al-sub">
                  <span class="al-flno">{{ $flight->flight_number }}</span>
                  @if($flight->aircraft_type)
                    <span class="al-ac">{{ $flight->aircraft_type }}</span>
                  @endif
                </div>
              </div>
            </div>
            <div class="fcard-badges">
              <span class="fc-badge {{ $stopBadge }}">
                <i class="fa-solid {{ $sc === 0 ? 'fa-circle-check' : 'fa-circle-dot' }}"></i>
                {{ $stopLabel }}
              </span>
            </div>
          </div>

          {{-- ROUTE --}}
          <div class="fcard-route">
            <div class="route-row">
              <div class="ep">
                <div class="ep-time">{{ $dep->format('H:i') }}</div>
                <div class="ep-iata">{{ $flight->from_airport_code }}</div>
                <div class="ep-city">{{ $flight->from_city }}</div>
                <div class="ep-airport">{{ Str::limit($flight->from_airport ?? '', 26) }}</div>
              </div>
              <div class="route-mid">
                <div class="route-line">
                  <div class="r-dot"></div>
                  <div class="r-dash"></div>
                  <span class="r-plane"><i class="fa-solid fa-plane"></i></span>
                  <div class="r-dash"></div>
                  <div class="r-dot"></div>
                </div>
                <span class="dur-pill">{{ $diff->h }}h {{ $diff->i }}m</span>
                @if(count($stopovers))
                  <div class="stopover-tag">
                    <i class="fa-solid fa-clock"></i><span>Stopover via</span>
                    @foreach($stopovers as $city)
                      <span class="sv-city">{{ $city }}</span>
                    @endforeach
                  </div>
                @endif
                @if($overnight)
                  <div class="overnight-tag">
                    <i class="fa-solid fa-moon"></i><span>Arrives next day (+1)</span>
                  </div>
                @endif
              </div>
              <div class="ep ep-r">
                <div class="ep-time">{{ $arr->format('H:i') }}</div>
                <div class="ep-iata">{{ $flight->to_airport_code }}</div>
                <div class="ep-city">{{ $flight->to_city }}</div>
                <div class="ep-airport">{{ Str::limit($flight->to_airport ?? '', 26) }}</div>
              </div>
            </div>
            <div class="route-spacer"></div>
          </div>

          {{-- FOOTER --}}
          <div class="fcard-footer">
            <div class="fp-left">
              <div>
                <div class="fp-label">
                  <i class="fa-solid fa-tag" style="font-size:.6rem;"></i>Economy
                </div>
                <div class="fp-price">
                  <span class="sym">$</span>{{ number_format($listPrice) }}
                </div>
              </div>
              @if($econCls)
                <div class="fp-divider"></div>
                <div class="fp-baggage">
                  <span><i class="fa-solid fa-briefcase"></i>Cabin {{ $econCls->cabin_baggage_kg }}kg</span>
                  <span><i class="fa-solid fa-suitcase-rolling"></i>Check-in {{ $econCls->checkin_baggage_kg }}kg</span>
                </div>
              @endif
            </div>
            <div class="fp-right">
              @if($econCls && $econCls->available_seats === 0)
                <span class="seats-warn s-full"><i class="fa-solid fa-ban me-1"></i>Sold Out</span>
                <span class="btn-na"><i class="fa-solid fa-ban"></i>Sold Out</span>
              @else
                @if($econCls && $econCls->available_seats <= 5)
                  <span class="seats-warn s-fire">
                    <i class="fa-solid fa-fire me-1"></i>Only {{ $econCls->available_seats }} left!
                  </span>
                @endif
                <span class="btn-view">View Details <i class="fa-solid fa-arrow-right"></i></span>
              @endif
            </div>
          </div>

        </div>
      </a>
      @endforeach
    </div>
    @endif

  </div>{{-- /lp-flights --}}

  {{-- ════ HOTELS PANEL ════ --}}
  <div class="listing-panel" id="lp-hotels">
    <div class="row g-4">
      @forelse($hotels ?? [] as $hotel)
      <div class="col-md-6 col-lg-4">
        <div class="hotel-card">
          <div class="hotel-img">
            <img src="{{ asset('hotel_images/'.$hotel->thumbnail) }}" alt="{{ $hotel->name }}">
            <div class="hotel-img-overlay"></div>
            <div class="hotel-star">⭐ {{ $hotel->star_rating ?? 'N/A' }}</div>
          </div>
          <div class="hotel-body">
            <div class="hotel-name">{{ $hotel->name }}</div>
            <div class="hotel-loc">
              <i class="fa-solid fa-location-dot" style="color:#ef4444"></i>
              {{ $hotel->city }}, {{ $hotel->country }}
            </div>
            <div class="hotel-amenities">
              @if($hotel->wifi)       <span class="hotel-am">📶 WiFi</span>       @endif
              @if($hotel->parking)    <span class="hotel-am">🅿 Parking</span>    @endif
              @if($hotel->pool)       <span class="hotel-am">🏊 Pool</span>        @endif
              @if($hotel->ac)         <span class="hotel-am">❄ AC</span>           @endif
              @if($hotel->restaurant) <span class="hotel-am">🍽️ Restaurant</span> @endif
            </div>
            <div class="hotel-footer-c">
              <div class="hotel-price">
                <strong>${{ number_format($hotel->price_per_night) }}</strong>
                <small>per night</small>
              </div>
              <a href="{{ route('hotelview', $hotel->id) }}" class="hotel-btn">
                View <i class="fa-solid fa-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      @empty
      <div class="col-12">
        <div class="empty-box">
          <div class="e-icon"><i class="fa-solid fa-hotel"></i></div>
          <h5>No Hotels Found</h5>
          <p>Check back soon!</p>
        </div>
      </div>
      @endforelse
    </div>
  </div>

  {{-- ════ TOURS ════ --}}
  <div class="listing-panel" id="lp-tours">
    <div class="empty-box">
      <div class="e-icon"><i class="fa-solid fa-map-location-dot"></i></div>
      <h5>Tours Coming Soon</h5>
      <p>We're curating amazing packages — stay tuned!</p>
    </div>
  </div>

  {{-- ════ CARS ════ --}}
  <div class="listing-panel" id="lp-cars">
    <div class="empty-box">
      <div class="e-icon"><i class="fa-solid fa-car"></i></div>
      <h5>Car Rentals Coming Soon</h5>
      <p>Launching shortly!</p>
    </div>
  </div>

</div>{{-- /container --}}
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* ══════════════════════════════════════════════════════
   HERO SLIDER
══════════════════════════════════════════════════════ */
const slides = document.querySelectorAll('.slide');
let si = 0;
setInterval(() => {
  slides[si].classList.remove('active');
  si = (si + 1) % slides.length;
  slides[si].classList.add('active');
}, 5000);

/* ══════════════════════════════════════════════════════
   MODE SWITCH
══════════════════════════════════════════════════════ */
const listingMeta = {
  'lp-flights': { title: 'Trending Flights',  sub: 'Best deals on flights handpicked for you' },
  'lp-hotels':  { title: 'Top Hotels',         sub: 'Handpicked stays for every budget'        },
  'lp-tours':   { title: 'Popular Tours',      sub: 'Explore the world with our curated tours' },
  'lp-cars':    { title: 'Car Rentals',         sub: 'Drive anywhere at unbeatable rates'       },
};
function switchMode(btn) {
  document.querySelectorAll('.sb-tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.sb-panel').forEach(p => p.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById(btn.dataset.panel).classList.add('active');
  document.querySelectorAll('.listing-panel').forEach(p => p.classList.remove('active'));
  const lp = document.getElementById(btn.dataset.listing);
  if (lp) lp.classList.add('active');
  const m = listingMeta[btn.dataset.listing];
  if (m) {
    document.getElementById('listing-title').textContent = m.title;
    document.getElementById('listing-sub').textContent   = m.sub;
  }
}

/* ══════════════════════════════════════════════════════
   TRIP TYPE
══════════════════════════════════════════════════════ */
function setTrip(btn, t) {
  document.querySelectorAll('.trip-tab-inner').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('hfTripH').value = t;
  document.getElementById('hfReturnWrap').style.display = t === 'round' ? '' : 'none';
  if (t === 'round') {
    const depart      = document.getElementById('hfDepartDate').value || new Date().toISOString().slice(0, 10);
    const returnInput = document.getElementById('hfReturnDate');
    returnInput.min   = depart;
    if (!returnInput.value || returnInput.value < depart) returnInput.value = depart;
  }
}
const departDateField = document.getElementById('hfDepartDate');
if (departDateField) {
  departDateField.addEventListener('change', function () {
    const returnInput = document.getElementById('hfReturnDate');
    if (!returnInput) return;
    returnInput.min = this.value;
    if (returnInput.value < this.value) returnInput.value = this.value;
  });
}
(function () {
  const t = '{{ request("trip","one-way") }}';
  if (t === 'round') {
    document.getElementById('hfReturnWrap').style.display = '';
    const depart      = document.getElementById('hfDepartDate').value || new Date().toISOString().slice(0, 10);
    const returnInput = document.getElementById('hfReturnDate');
    returnInput.min   = depart;
    if (!returnInput.value || returnInput.value < depart) returnInput.value = depart;
  }
})();

/* ══════════════════════════════════════════════════════
   SWAP FROM ↔ TO
══════════════════════════════════════════════════════ */
function hfSwap() {
  const fromInput = document.getElementById('fromInput');
  const toInput   = document.getElementById('toInput');
  const fromCode  = document.getElementById('fromCode');
  const toCode    = document.getElementById('toCode');
  [fromInput.value, toInput.value] = [toInput.value, fromInput.value];
  [fromCode.value,  toCode.value ] = [toCode.value,  fromCode.value ];
}

/* ══════════════════════════════════════════════════════
   TRAVELLERS & CLASS
══════════════════════════════════════════════════════ */
let hfPax = {
  a: parseInt('{{ request("adults",  1) }}') || 1,
  c: parseInt('{{ request("children",0) }}') || 0,
};
function toggleTcc() {
  const d  = document.getElementById('hfTccDrop');
  const t  = document.getElementById('hfTccTrigger');
  const op = d.classList.toggle('open');
  t.classList.toggle('open', op);
  if (op) setTimeout(() => document.addEventListener('click', closeTccOut, true), 0);
}
function closeTccOut(e) {
  const wrap = document.querySelector('#sp-flights .tcc-wrap');
  if (wrap && !wrap.contains(e.target)) {
    document.getElementById('hfTccDrop').classList.remove('open');
    document.getElementById('hfTccTrigger').classList.remove('open');
    document.removeEventListener('click', closeTccOut, true);
  }
}
function chHfPax(type, delta) {
  if (type === 'a') hfPax.a = Math.max(1, hfPax.a + delta);
  else              hfPax.c = Math.max(0, hfPax.c + delta);
  document.getElementById('hfAdMinus').disabled = hfPax.a <= 1;
  document.getElementById('hfChMinus').disabled = hfPax.c <= 0;
  document.getElementById('hfAdCnt').textContent = hfPax.a;
  document.getElementById('hfChCnt').textContent = hfPax.c;
  updateHfTcc();
}
function updateHfTcc() {
  const cls = document.getElementById('hfCabinSel').value;
  let p = [hfPax.a + ' Adult' + (hfPax.a > 1 ? 's' : '')];
  if (hfPax.c) p.push(hfPax.c + ' Child' + (hfPax.c > 1 ? 'ren' : ''));
  p.push(cls);
  document.getElementById('hfTccVal').textContent = p.join(', ');
}
function applyHfTcc() {
  document.getElementById('hfAdultsH').value   = hfPax.a;
  document.getElementById('hfChildrenH').value = hfPax.c;
  document.getElementById('hfClassH').value    = document.getElementById('hfCabinSel').value;
  document.getElementById('hfTccDrop').classList.remove('open');
  document.getElementById('hfTccTrigger').classList.remove('open');
}
(function () {
  document.getElementById('hfAdMinus').disabled = hfPax.a <= 1;
  document.getElementById('hfChMinus').disabled = hfPax.c <= 0;
  document.getElementById('hfAdCnt').textContent = hfPax.a;
  document.getElementById('hfChCnt').textContent = hfPax.c;
  updateHfTcc();
})();

/* ══════════════════════════════════════════════════════
   CAR DATE VALIDATION
══════════════════════════════════════════════════════ */
function validateCarDates() {
  const pickup = document.getElementById('carPickupDate');
  const drop   = document.getElementById('carDropDate');
  if (!pickup || !drop) return;
  if (drop.value && drop.value < pickup.value) drop.value = pickup.value;
  drop.min = pickup.value;
}

/* ══════════════════════════════════════════════════════
   AIRPORT AUTOCOMPLETE — vanilla JS, no jQuery
══════════════════════════════════════════════════════ */
(function () {
  const SEARCH_URL = '{{ route("airports.search") }}';

  const FIELDS = [
    ['fromInput', 'fromDropdown', 'fromCode'],
    ['toInput',   'toDropdown',   'toCode'  ],
  ];

  FIELDS.forEach(([inputId, dropId, codeId]) => {
    const input      = document.getElementById(inputId);
    const dropdown   = document.getElementById(dropId);
    const codeHidden = document.getElementById(codeId);
    if (!input || !dropdown || !codeHidden) return;

    let debounce  = null;
    let lastQuery = '';

    function render(airports) {
      if (!airports.length) {
        dropdown.innerHTML = `
          <div class="autocomplete-item no-result">
            <i class="fa-solid fa-circle-info"></i> No airports found
          </div>`;
        show(); return;
      }
      dropdown.innerHTML = airports.map(a => `
        <div class="autocomplete-item"
             data-city="${escHtml(a.city)}"
             data-code="${escHtml(a.airport_code)}"
             data-name="${escHtml(a.airport_name)}">
          <div class="ac-inner">
            <div class="ac-code-box">${escHtml(a.airport_code)}</div>
            <div>
              <div class="ac-detail-name">
                ${escHtml(a.airport_code)} — ${escHtml(a.airport_name)}
              </div>
              <div class="ac-detail-city">
                <i class="fa-solid fa-location-dot" style="color:#ef4444;font-size:.65rem;"></i>
                ${escHtml(a.city)}
              </div>
            </div>
          </div>
        </div>
      `).join('');
      show();
    }

    function fetchAirports(q) {
      fetch(`${SEARCH_URL}?q=${encodeURIComponent(q)}`)
        .then(r => r.json())
        .then(data => render(data))
        .catch(() => hide());
    }

    function show() { dropdown.style.display = 'flex'; }
    function hide() { dropdown.style.display = 'none'; }

    input.addEventListener('input', function () {
      const q = this.value.trim();
      codeHidden.value = '';
      if (q.length < 2) { hide(); return; }
      if (q === lastQuery) return;
      lastQuery = q;
      clearTimeout(debounce);
      debounce = setTimeout(() => fetchAirports(q), 250);
    });

    dropdown.addEventListener('click', function (e) {
      const item = e.target.closest('.autocomplete-item[data-code]');
      if (!item) return;
      selectItem(item);
    });

    function selectItem(item) {
      const city = item.dataset.city;
      const code = item.dataset.code;
      input.value      = `${city} (${code})`;
      codeHidden.value = code;
      lastQuery        = input.value;
      hide();
      input.focus();
    }

    input.addEventListener('keydown', function (e) {
      const items = Array.from(dropdown.querySelectorAll('.autocomplete-item[data-code]'));
      if (!items.length || dropdown.style.display === 'none') return;
      let idx = items.findIndex(i => i.classList.contains('hovered'));

      if (e.key === 'ArrowDown') {
        e.preventDefault();
        if (idx >= 0) items[idx].classList.remove('hovered');
        idx = (idx + 1) % items.length;
        items[idx].classList.add('hovered');
        items[idx].scrollIntoView({ block: 'nearest' });
      } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        if (idx >= 0) items[idx].classList.remove('hovered');
        idx = (idx - 1 + items.length) % items.length;
        items[idx].classList.add('hovered');
        items[idx].scrollIntoView({ block: 'nearest' });
      } else if (e.key === 'Enter') {
        const hovered = dropdown.querySelector('.autocomplete-item.hovered');
        if (hovered) { e.preventDefault(); selectItem(hovered); }
      } else if (e.key === 'Escape') {
        hide();
      }
    });

    document.addEventListener('click', function (e) {
      if (!input.contains(e.target) && !dropdown.contains(e.target)) hide();
    });
  });

  function escHtml(str) {
    return String(str ?? '')
      .replace(/&/g,'&amp;').replace(/</g,'&lt;')
      .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }
})();
</script>

@endsection