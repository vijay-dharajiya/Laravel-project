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
  --green:#16a34a;--green-light:#dcfce7;
  --red:#dc2626;
  --r8:8px;--r12:12px;--r16:16px;
  --font-main:'Outfit',sans-serif;
  --font-display:'Sora',sans-serif;
}
body,html{font-family:var(--font-main);background:var(--bg);color:var(--navy);}

/* HERO */
.bk-hero{background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 55%,#1d4ed8 100%);padding:22px 0 30px;box-shadow:0 4px 28px rgba(0,0,0,.35);}
.bk-back{display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,.7);font-size:.78rem;font-weight:600;text-decoration:none;border:1.5px solid rgba(255,255,255,.2);border-radius:var(--r8);padding:6px 14px;transition:all .15s;margin-bottom:14px;}
.bk-back:hover{background:rgba(255,255,255,.1);color:#fff;}
.bk-hero-title{font-family:var(--font-display);color:#fff;font-size:1.25rem;font-weight:800;display:flex;align-items:center;gap:8px;}
.bk-hero-sub{color:rgba(255,255,255,.55);font-size:.76rem;margin-top:4px;}
.trip-badge{background:rgba(255,255,255,.15);color:#fff;font-size:.62rem;font-weight:700;padding:3px 10px;border-radius:100px;letter-spacing:.06em;text-transform:uppercase;}

/* Steps */
.bk-steps{display:flex;align-items:center;gap:4px;}
.bk-step{display:flex;align-items:center;gap:5px;font-size:.7rem;font-weight:700;color:rgba(255,255,255,.35);}
.bk-step.done{color:rgba(255,255,255,.65);}
.bk-step.active{color:#fff;}
.bk-snum{width:22px;height:22px;border-radius:50%;border:2px solid rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;font-size:.6rem;font-weight:800;}
.bk-step.active .bk-snum{background:var(--primary-mid);border-color:var(--primary-mid);}
.bk-step.done .bk-snum{background:var(--green);border-color:var(--green);}
.bk-sdiv{width:26px;height:2px;background:rgba(255,255,255,.1);margin:0 3px;}

/* WRAP */
.bk-wrap{padding:28px 0 60px;}

/* CARD */
.bk-card{background:#fff;border-radius:var(--r16);border:1.5px solid var(--border);overflow:hidden;margin-bottom:20px;box-shadow:0 4px 20px rgba(0,0,0,.05);animation:fadeUp .45s ease both;}
@keyframes fadeUp{from{opacity:0;transform:translateY(18px);}to{opacity:1;transform:translateY(0);}}
.bk-card:nth-child(2){animation-delay:.08s;}
.bk-card-head{padding:13px 20px;display:flex;align-items:center;gap:10px;}
.bk-card-head.dep{background:linear-gradient(90deg,#eff6ff,#dbeafe);}
.bk-card-head.ret{background:linear-gradient(90deg,#f0fdf4,#dcfce7);}
.bk-ch-icon{width:34px;height:34px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:.88rem;flex-shrink:0;}
.bk-ch-icon.blue{background:var(--primary-pale);color:var(--primary);}
.bk-ch-icon.green{background:var(--green-light);color:var(--green);}
.bk-ch-title{font-family:var(--font-display);font-weight:800;font-size:.88rem;color:var(--navy);}
.bk-ch-sub{font-size:.67rem;color:var(--gray);margin-top:1px;}
.cls-tag{margin-left:auto;font-size:.63rem;font-weight:800;padding:3px 12px;border-radius:100px;letter-spacing:.07em;text-transform:uppercase;color:#fff;}
.bk-card-body{padding:20px 22px;}

/* FLIGHT ROW */
.fd-row{display:flex;align-items:center;gap:14px;flex-wrap:wrap;}
.fd-airline{display:flex;align-items:center;gap:11px;min-width:160px;}
.fd-logo{width:46px;height:46px;border-radius:var(--r8);border:1.5px solid var(--border);background:#fff;display:flex;align-items:center;justify-content:center;overflow:hidden;font-size:.58rem;font-weight:800;color:var(--primary);flex-shrink:0;}
.fd-logo img{width:100%;height:100%;object-fit:contain;padding:4px;}
.fd-al-name{font-family:var(--font-display);font-weight:700;font-size:.86rem;color:var(--navy);}
.fd-al-sub{font-size:.67rem;color:var(--gray);margin-top:2px;display:flex;align-items:center;gap:5px;}
.fd-flno{font-weight:600;color:var(--slate);}
.fd-ac{background:#f1f5f9;border:1px solid var(--border);padding:1px 6px;border-radius:4px;font-size:.6rem;font-weight:700;}
.fd-route{flex:1;display:flex;align-items:center;min-width:0;}
.fd-ep{}
.fd-ep-r{text-align:right;}
.fd-time{font-family:var(--font-display);font-size:1.55rem;font-weight:800;color:var(--navy);line-height:1;}
.fd-iata{font-size:.82rem;font-weight:800;color:var(--primary);margin-top:3px;letter-spacing:.05em;}
.fd-apt{font-size:.64rem;color:var(--gray);margin-top:2px;max-width:115px;line-height:1.3;}
.fd-ep-r .fd-apt{text-align:right;}
.fd-mid{flex:1;display:flex;flex-direction:column;align-items:center;gap:5px;padding:0 14px;}
.fd-line{display:flex;align-items:center;width:100%;gap:3px;}
.fd-dot{width:7px;height:7px;border-radius:50%;border:2px solid var(--primary);background:#fff;flex-shrink:0;}
.fd-dash{flex:1;height:2px;background:repeating-linear-gradient(90deg,var(--primary) 0,var(--primary) 4px,transparent 4px,transparent 9px);}
.fd-plane{color:var(--primary);font-size:.78rem;}
.fd-dur{background:var(--primary-light);color:var(--primary-mid);font-size:.67rem;font-weight:700;padding:3px 10px;border-radius:100px;white-space:nowrap;}
.fd-stop{font-size:.65rem;font-weight:800;padding:3px 10px;border-radius:100px;display:inline-flex;align-items:center;gap:4px;}
.ns{background:#dcfce7;color:#14532d;}
.os{background:#fef9c3;color:#78350f;}
.ts{background:#fee2e2;color:#7f1d1d;}
.fd-via{display:inline-flex;align-items:center;gap:4px;background:#fffbeb;border:1px solid #fde68a;color:#92400e;font-size:.63rem;font-weight:600;padding:3px 10px;border-radius:6px;}
.sv-city{background:#fef3c7;border:1px solid #fde68a;padding:1px 6px;border-radius:100px;font-size:.61rem;font-weight:700;color:#78350f;}
.fd-over{display:inline-flex;align-items:center;gap:4px;background:#f0f9ff;border:1px solid #bae6fd;color:#0369a1;font-size:.63rem;font-weight:600;padding:3px 10px;border-radius:6px;}

/* CLASS PANEL */
.cls-panel{background:var(--primary-light);border:1.5px solid var(--primary-pale);border-radius:var(--r12);padding:16px 18px;margin-top:18px;}
.cls-panel.ret-cls{background:#f0fdf4;border-color:#bbf7d0;}
.cls-top{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-bottom:14px;}
.cls-badge{display:inline-flex;align-items:center;gap:5px;color:#fff;font-size:.67rem;font-weight:800;letter-spacing:.08em;padding:4px 13px;border-radius:100px;text-transform:uppercase;}
.seats-pill{display:inline-flex;align-items:center;gap:5px;font-size:.7rem;font-weight:800;padding:4px 12px;border-radius:100px;}
.seats-ok{background:#dcfce7;color:#14532d;}
.seats-low{background:#fee2e2;color:#7f1d1d;animation:pulse 1.8s ease-in-out infinite;}
@keyframes pulse{0%,100%{opacity:1;}50%{opacity:.6;}}
.cls-price-blk{text-align:right;}
.cls-price-lbl{font-size:.6rem;color:var(--gray);font-weight:700;text-transform:uppercase;letter-spacing:.07em;}
.cls-price-amt{font-family:var(--font-display);font-size:1.35rem;font-weight:800;color:var(--primary-dark);}
.cls-price-amt.ret{color:var(--green);}
.cls-price-sub{font-size:.62rem;color:var(--gray);}
.cls-specs{display:flex;flex-wrap:wrap;gap:8px;}
.spec{display:flex;align-items:center;gap:6px;background:#fff;border:1.5px solid var(--border);border-radius:var(--r8);padding:8px 12px;font-size:.73rem;font-weight:600;color:var(--slate);}
.spec i{color:var(--primary);font-size:.7rem;}
.ret-cls .spec i{color:var(--green);}

/* PRICE SUMMARY */
.price-card{background:#fff;border-radius:var(--r16);border:1.5px solid var(--border);overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.05);margin-bottom:16px;}
.price-card-head{background:linear-gradient(90deg,#fefce8,#fef3c7);padding:13px 20px;display:flex;align-items:center;gap:10px;}
.pc-icon{width:34px;height:34px;border-radius:10px;background:#fde68a;color:#92400e;display:flex;align-items:center;justify-content:center;font-size:.88rem;}
.pc-title{font-family:var(--font-display);font-weight:800;font-size:.88rem;color:#78350f;}
.pc-sub{font-size:.67rem;color:#a16207;margin-top:1px;}
.price-card-body{padding:18px 20px;}
.pg{display:grid;grid-template-columns:1fr auto;gap:6px 20px;align-items:center;}
.pg-lbl{font-size:.78rem;color:var(--slate);}
.pg-val{font-size:.82rem;font-weight:700;color:var(--navy);text-align:right;}
.pg-div{grid-column:1/-1;height:1px;background:var(--border);margin:5px 0;}
.pg-total-lbl{font-family:var(--font-display);font-size:.92rem;font-weight:800;color:var(--navy);}
.pg-total-val{font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--primary-dark);text-align:right;}

/* TRIP INFO */
.info-card{background:#fff;border-radius:var(--r16);border:1.5px solid var(--border);overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.05);}
.info-card-head{background:linear-gradient(90deg,var(--navy),var(--slate));padding:13px 20px;display:flex;align-items:center;gap:10px;}
.ic-icon{width:34px;height:34px;border-radius:10px;background:rgba(255,255,255,.12);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.88rem;}
.ic-title{font-family:var(--font-display);font-weight:800;font-size:.88rem;color:#fff;}
.ic-sub{font-size:.67rem;color:rgba(255,255,255,.5);margin-top:1px;}
.info-card-body{padding:4px 0;}
.info-row{display:flex;justify-content:space-between;align-items:center;padding:10px 20px;border-bottom:1px solid #f1f5f9;font-size:.78rem;}
.info-row:last-child{border-bottom:none;}
.ir-lbl{color:var(--gray);font-weight:500;}
.ir-val{font-weight:700;color:var(--navy);text-align:right;}

/* ══ PASSENGER FORM ══ */
.pax-form-card{background:#fff;border-radius:var(--r16);border:1.5px solid var(--border);overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.07);margin-bottom:20px;animation:fadeUp .5s ease both;animation-delay:.12s;}
.pax-form-head{background:linear-gradient(90deg,#1e293b,#0f172a);padding:16px 22px;display:flex;align-items:center;gap:12px;}
.pfh-icon{width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,.1);color:#fff;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;}
.pfh-title{font-family:var(--font-display);font-weight:800;font-size:.95rem;color:#fff;}
.pfh-sub{font-size:.68rem;color:rgba(255,255,255,.5);margin-top:2px;}
.pfh-count{margin-left:auto;background:var(--primary-mid);color:#fff;font-size:.65rem;font-weight:800;padding:4px 12px;border-radius:100px;letter-spacing:.06em;}

/* Passenger accordion block */
.pax-block{border-bottom:1.5px solid var(--border);}
.pax-block:last-child{border-bottom:none;}
.pax-accordion-btn{width:100%;background:none;border:none;padding:14px 22px;display:flex;align-items:center;gap:12px;cursor:pointer;text-align:left;transition:background .15s;}
.pax-accordion-btn:hover{background:#f8fafc;}
.pax-accordion-btn[aria-expanded="true"]{background:var(--primary-light);}
.pab-num{width:30px;height:30px;border-radius:50%;background:var(--primary-pale);color:var(--primary);font-size:.72rem;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2px solid var(--primary-pale);}
.pax-accordion-btn[aria-expanded="true"] .pab-num{background:var(--primary);color:#fff;border-color:var(--primary);}
.pab-info{}
.pab-title{font-family:var(--font-display);font-weight:700;font-size:.82rem;color:var(--navy);}
.pab-sub{font-size:.65rem;color:var(--gray);margin-top:2px;}
.pab-type{margin-left:auto;font-size:.6rem;font-weight:800;padding:3px 10px;border-radius:100px;text-transform:uppercase;letter-spacing:.07em;}
.pab-type.adult{background:var(--primary-pale);color:var(--primary);}
.pab-type.child{background:#fef9c3;color:#78350f;}
.pab-chevron{color:var(--gray);font-size:.75rem;margin-left:8px;transition:transform .25s;}
.pax-accordion-btn[aria-expanded="true"] .pab-chevron{transform:rotate(180deg);color:var(--primary);}
.pab-status{width:8px;height:8px;border-radius:50%;background:#e2e8f0;flex-shrink:0;margin-left:4px;transition:background .2s;}
.pab-status.filled{background:var(--green);}

/* Form inside accordion */
.pax-fields{padding:20px 22px 24px;background:#fafbff;border-top:1.5px solid var(--primary-pale);}
.pax-fields.child-fields{background:#fffdf0;border-top-color:#fde68a;}
.pf-row{display:grid;gap:14px;margin-bottom:14px;}
.pf-row.cols-2{grid-template-columns:1fr 1fr;}
.pf-row.cols-3{grid-template-columns:1fr 1fr 1fr;}
.pf-row.cols-1{grid-template-columns:1fr;}
.pf-group{display:flex;flex-direction:column;gap:5px;}
.pf-label{font-size:.68rem;font-weight:700;color:var(--slate);text-transform:uppercase;letter-spacing:.06em;display:flex;align-items:center;gap:5px;}
.pf-label .req{color:var(--red);font-size:.7rem;}
.pf-input{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:var(--r8);font-family:var(--font-main);font-size:.82rem;font-weight:500;color:var(--navy);background:#fff;transition:border-color .15s,box-shadow .15s;outline:none;}
.pf-input:focus{border-color:var(--primary-mid);box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.pf-input.error{border-color:var(--red);box-shadow:0 0 0 3px rgba(220,38,38,.08);}
.pf-input::placeholder{color:#c0cad8;}
.pf-select{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;padding-right:36px;}
.pf-err{font-size:.62rem;color:var(--red);font-weight:600;display:none;align-items:center;gap:4px;}
.pf-err.show{display:flex;}
.child-banner{display:flex;align-items:center;gap:10px;background:#fefce8;border:1.5px solid #fde68a;border-radius:var(--r8);padding:10px 14px;margin-bottom:18px;font-size:.74rem;color:#78350f;font-weight:600;}
.child-banner i{font-size:.85rem;color:#d97706;}

/* Submit footer */
.pax-form-footer{padding:18px 22px;background:#f8fafc;border-top:1.5px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;}
.pff-total-lbl{font-size:.6rem;color:var(--gray);font-weight:700;text-transform:uppercase;letter-spacing:.07em;}
.pff-total-amt{font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--primary-dark);}
.pff-note{font-size:.63rem;color:var(--gray);display:flex;align-items:center;gap:4px;margin-top:2px;}
.pff-note i{color:var(--green);}
.btn-submit{background:linear-gradient(135deg,var(--primary-mid),var(--primary-dark));color:#fff;border:none;border-radius:var(--r12);padding:14px 36px;font-family:var(--font-display);font-weight:800;font-size:.92rem;display:inline-flex;align-items:center;gap:9px;cursor:pointer;transition:transform .15s,box-shadow .15s;white-space:nowrap;}
.btn-submit:hover{transform:translateY(-2px);box-shadow:0 12px 32px rgba(29,78,216,.38);}
.btn-submit:disabled{opacity:.65;cursor:not-allowed;transform:none;box-shadow:none;}
.btn-submit-note{font-size:.63rem;color:var(--gray);display:flex;align-items:center;gap:4px;justify-content:flex-end;margin-top:5px;}
.btn-submit-note i{color:var(--green);}

@media(max-width:991px){.bk-sidebar{position:static !important;}}
@media(max-width:768px){.bk-steps{display:none;}.fd-airline{min-width:unset;}.pf-row.cols-3{grid-template-columns:1fr 1fr;}.pf-row.cols-2{grid-template-columns:1fr;}}
@media(max-width:576px){.pf-row.cols-2,.pf-row.cols-3{grid-template-columns:1fr;}.pax-form-footer{flex-direction:column;align-items:stretch;}.btn-submit{justify-content:center;}}
</style>

{{-- ── DATA PREP ── --}}
@php
  $tripType   = $tripType  ?? request('trip',  'one-way');
  $isRound    = $tripType === 'round';
  $selClass   = $selClass  ?? request('class', 'Economy');
  $adults     = isset($adults)   ? (int)$adults   : (int)request('adults',   1);
  $children   = isset($children) ? (int)$children : (int)request('children', 0);
  $totalPax   = $adults + $children;
  $departDate = $departDate ?? request('depart_date', date('Y-m-d'));
  $returnDate = $returnDate ?? request('return_date', '');

  // Outbound
  $dDep = \Carbon\Carbon::parse($departFlight->departure_time);
  $dArr = \Carbon\Carbon::parse($departFlight->arrival_time);
  $dON  = (int)($departFlight->overnight_arrival ?? 0);
  if ($dON)                  { $dArr->addDay(); }
  elseif ($dArr->lessThan($dDep)) { $dArr->addDay(); }
  $dDiff      = $dDep->diff($dArr);
  $dSc        = (int)$departFlight->stops;
  $dStopLbl   = $dSc === 0 ? 'Non-stop' : ($dSc === 1 ? '1 Stop' : $dSc . ' Stops');
  $dStopCls   = $dSc === 0 ? 'ns' : ($dSc === 1 ? 'os' : 'ts');
  $dStopIco   = $dSc === 0 ? 'fa-circle-check' : 'fa-circle-dot';
  $dStopovers = $departFlight->stopover_cities ? json_decode($departFlight->stopover_cities, true) : [];
  $dAvail = $departClass?->available_seats ?? 0;
  $dLow       = $dAvail > 0 && $dAvail <= 5;
  $dPrice = $departClass?->total_price ?? 0;

  // Return
  $rPrice = 0;
  if ($isRound && $returnFlight) {
    $rDep = \Carbon\Carbon::parse($returnFlight->departure_time);
    $rArr = \Carbon\Carbon::parse($returnFlight->arrival_time);
    $rON  = (int)($returnFlight->overnight_arrival ?? 0);
    if ($rON)                  { $rArr->addDay(); }
    elseif ($rArr->lessThan($rDep)) { $rArr->addDay(); }
    $rDiff      = $rDep->diff($rArr);
    $rSc        = (int)$returnFlight->stops;
    $rStopLbl   = $rSc === 0 ? 'Non-stop' : ($rSc === 1 ? '1 Stop' : $rSc . ' Stops');
    $rStopCls   = $rSc === 0 ? 'ns' : ($rSc === 1 ? 'os' : 'ts');
    $rStopIco   = $rSc === 0 ? 'fa-circle-check' : 'fa-circle-dot';
    $rStopovers = $returnFlight->stopover_cities ? json_decode($returnFlight->stopover_cities, true) : [];
    $rAvail     = $returnClass?->available_seats ?? 0;
    $rLow       = $rAvail > 0 && $rAvail <= 5;
    $rPrice     = $returnClass?->total_price ?? 0;
  }

  $grandTotal = ($dPrice + $rPrice) * $totalPax;
@endphp

{{-- ══ HERO ══ --}}
<div class="bk-hero">
  <div class="container-xl">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:16px;">
      <div>
        <a href="javascript:history.back()" class="bk-back">
          <i class="fa-solid fa-arrow-left"></i> Back to Results
        </a>
        <div class="bk-hero-title">
          <i class="fa-solid fa-ticket"></i>
          Review &amp; Passenger Details
          <span class="trip-badge">{{ $isRound ? 'Round Trip' : 'One Way' }}</span>
        </div>
        <div class="bk-hero-sub">
          {{ $departFlight->from_airport_code }} → {{ $departFlight->to_airport_code }}
          @if($isRound && $returnFlight) &nbsp;·&nbsp; {{ $returnFlight->from_airport_code }} → {{ $returnFlight->to_airport_code }} @endif
          &nbsp;·&nbsp; {{ $adults }} Adult{{ $adults > 1 ? 's' : '' }}
          @if($children), {{ $children }} Child{{ $children > 1 ? 'ren' : '' }} @endif
          &nbsp;·&nbsp; {{ $selClass }}
        </div>
      </div>
      <div class="bk-steps">
        <div class="bk-step done"><div class="bk-snum"><i class="fa-solid fa-check" style="font-size:.48rem;"></i></div>Search</div>
        <div class="bk-sdiv"></div>
        <div class="bk-step done"><div class="bk-snum"><i class="fa-solid fa-check" style="font-size:.48rem;"></i></div>Select</div>
        <div class="bk-sdiv"></div>
        <div class="bk-step active"><div class="bk-snum">3</div>Review</div>
        <div class="bk-sdiv"></div>
        <div class="bk-step"><div class="bk-snum">4</div>Book</div>
      </div>
    </div>
  </div>
</div>

{{-- ══ MAIN ══ --}}
<div class="bk-wrap">
<div class="container-xl">
<div class="row g-4">

  {{-- LEFT — flight cards + passenger form --}}
  <div class="col-lg-8">

    {{-- ── OUTBOUND ── --}}
    <div class="bk-card">
      <div class="bk-card-head dep">
        <div class="bk-ch-icon blue"><i class="fa-solid fa-plane-departure"></i></div>
        <div>
          <div class="bk-ch-title">{{ $isRound ? 'Outbound Flight' : 'Your Flight' }}</div>
          <div class="bk-ch-sub">{{ \Carbon\Carbon::parse($departDate)->format('l, d M Y') }}</div>
        </div>
        <span class="cls-tag" style="background:var(--primary);">{{ $selClass }}</span>
      </div>
      <div class="bk-card-body">
        <div class="fd-row">
          <div class="fd-airline">
            <div class="fd-logo">
              @if($departFlight->airline_logo)
                <img src="{{ asset($departFlight->airline_logo) }}" alt="{{ $departFlight->airline_name }}"
                     onerror="this.style.display='none';this.parentElement.textContent='{{ strtoupper(substr($departFlight->airline_code,0,2)) }}';">
              @else{{ strtoupper(substr($departFlight->airline_code,0,2)) }}@endif
            </div>
            <div>
              <div class="fd-al-name">{{ $departFlight->airline_name }}</div>
              <div class="fd-al-sub">
                <span class="fd-flno">{{ $departFlight->flight_number }}</span>
                @if($departFlight->aircraft_type)<span class="fd-ac">{{ $departFlight->aircraft_type }}</span>@endif
              </div>
            </div>
          </div>
          <div class="fd-route">
            <div class="fd-ep">
              <div class="fd-time">{{ $dDep->format('H:i') }}</div>
              <div class="fd-iata">{{ $departFlight->from_airport_code }}</div>
              <div class="fd-apt">{{ $departFlight->from_airport_code }}</div>
            </div>
            <div class="fd-mid">
              <div class="fd-line">
                <div class="fd-dot"></div><div class="fd-dash"></div>
                <span class="fd-plane"><i class="fa-solid fa-plane"></i></span>
                <div class="fd-dash"></div><div class="fd-dot"></div>
              </div>
              <span class="fd-dur">{{ $dDiff->h }}h {{ $dDiff->i }}m</span>
              <span class="fd-stop {{ $dStopCls }}">
                <i class="fa-solid {{ $dStopIco }}"></i>{{ $dStopLbl }}
              </span>
              @if(count($dStopovers))
                <div class="fd-via"><i class="fa-solid fa-clock"></i> layover :
                  @foreach($dStopovers as $c)<span class="sv-city">{{ $c }}</span>@endforeach
                </div>
              @endif
              @if($dON)<div class="fd-over"><i class="fa-solid fa-moon"></i> +1 day</div>@endif
            </div>
            <div class="fd-ep fd-ep-r">
              <div class="fd-time">{{ $dArr->format('H:i') }}@if($dON)<sup style="font-size:.55rem;color:#f97316;vertical-align:super;">+1</sup>@endif</div>
              <div class="fd-iata">{{ $departFlight->to_airport_code }}</div>
              <div class="fd-apt">{{ $departFlight->to_airport_code }}</div>
            </div>
          </div>
        </div>
        <div class="cls-panel">
          <div class="cls-top">
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
              <span class="cls-badge" style="background:var(--primary);">
                <i class="fa-solid fa-star" style="font-size:.52rem;"></i> {{ $departClass->class_type }}
              </span>
              <span class="seats-pill {{ $dLow ? 'seats-low' : 'seats-ok' }}">
                <i class="fa-solid {{ $dLow ? 'fa-fire' : 'fa-couch' }}"></i>
                {{ $dAvail }} seat{{ $dAvail != 1 ? 's' : '' }} available
              </span>
            </div>
            <div class="cls-price-blk">
              <div class="cls-price-lbl">Per adult</div>
              <div class="cls-price-amt"><span style="font-size:.75rem;font-weight:500;vertical-align:super;">$</span>{{ number_format($dPrice) }}</div>
              <div class="cls-price-sub">taxes included</div>
            </div>
          </div>
          <div class="cls-specs">
            <div class="spec"><i class="fa-solid fa-briefcase"></i> {{ $departClass->cabin_baggage_kg ?? 7 }}kg cabin</div>
            <div class="spec"><i class="fa-solid fa-suitcase-rolling"></i> {{ $departClass->checkin_baggage_kg ?? 23 }}kg check-in</div>
            @if(!empty($departClass->meal_included))<div class="spec"><i class="fa-solid fa-utensils"></i> Meal included</div>@endif
            @if(!empty($departClass->seat_pitch))<div class="spec"><i class="fa-solid fa-arrows-up-down"></i> {{ $departClass->seat_pitch }} seat pitch</div>@endif
            @if(!empty($departClass->refundable))<div class="spec"><i class="fa-solid fa-rotate-left"></i> Refundable</div>@endif
          </div>
        </div>
      </div>
    </div>

    {{-- ── RETURN (only for round trip) ── --}}
    @if($isRound && $returnFlight)
    <div class="bk-card">
      <div class="bk-card-head ret">
        <div class="bk-ch-icon green"><i class="fa-solid fa-plane-arrival"></i></div>
        <div>
          <div class="bk-ch-title">Return Flight</div>
          <div class="bk-ch-sub">{{ \Carbon\Carbon::parse($returnDate)->format('l, d M Y') }}</div>
        </div>
        <span class="cls-tag" style="background:var(--green);">{{ $selClass }}</span>
      </div>
      <div class="bk-card-body">
        <div class="fd-row">
          <div class="fd-airline">
            <div class="fd-logo">
              @if($returnFlight->airline_logo)
                <img src="{{ asset($returnFlight->airline_logo) }}" alt="{{ $returnFlight->airline_name }}"
                     onerror="this.style.display='none';this.parentElement.textContent='{{ strtoupper(substr($returnFlight->airline_code,0,2)) }}';">
              @else{{ strtoupper(substr($returnFlight->airline_code,0,2)) }}@endif
            </div>
            <div>
              <div class="fd-al-name">{{ $returnFlight->airline_name }}</div>
              <div class="fd-al-sub">
                <span class="fd-flno">{{ $returnFlight->flight_number }}</span>
                @if($returnFlight->aircraft_type)<span class="fd-ac">{{ $returnFlight->aircraft_type }}</span>@endif
              </div>
            </div>
          </div>
          <div class="fd-route">
            <div class="fd-ep">
              <div class="fd-time">{{ $rDep->format('H:i') }}</div>
              <div class="fd-iata">{{ $returnFlight->from_airport_code }}</div>
              <div class="fd-apt">{{ $returnFlight->from_airport_code }}</div>
            </div>
            <div class="fd-mid">
              <div class="fd-line">
                <div class="fd-dot"></div><div class="fd-dash"></div>
                <span class="fd-plane"><i class="fa-solid fa-plane" style="transform:scaleX(-1);display:inline-block;"></i></span>
                <div class="fd-dash"></div><div class="fd-dot"></div>
              </div>
              <span class="fd-dur">{{ $rDiff->h }}h {{ $rDiff->i }}m</span>
              <span class="fd-stop {{ $rStopCls }}">
                <i class="fa-solid {{ $rStopIco }}"></i>{{ $rStopLbl }}
              </span>
              @if(count($rStopovers))
                <div class="fd-via"><i class="fa-solid fa-clock"></i> layover :
                  @foreach($rStopovers as $c)<span class="sv-city">{{ $c }}</span>@endforeach
                </div>
              @endif
              @if($rON)<div class="fd-over"><i class="fa-solid fa-moon"></i> +1 day</div>@endif
            </div>
            <div class="fd-ep fd-ep-r">
              <div class="fd-time">{{ $rArr->format('H:i') }}@if($rON)<sup style="font-size:.55rem;color:#f97316;vertical-align:super;">+1</sup>@endif</div>
              <div class="fd-iata">{{ $returnFlight->to_airport_code }}</div>
              <div class="fd-apt">{{ $returnFlight->to_airport_code }}</div>
            </div>
          </div>
        </div>
        <div class="cls-panel ret-cls">
          <div class="cls-top">
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
              <span class="cls-badge" style="background:var(--green);">
                <i class="fa-solid fa-star" style="font-size:.52rem;"></i> {{ $returnClass->class_type }}
              </span>
              <span class="seats-pill {{ $rLow ? 'seats-low' : 'seats-ok' }}">
                <i class="fa-solid {{ $rLow ? 'fa-fire' : 'fa-couch' }}"></i>
                {{ $rAvail }} seat{{ $rAvail != 1 ? 's' : '' }} available
              </span>
            </div>
            <div class="cls-price-blk">
              <div class="cls-price-lbl">Per adult</div>
              <div class="cls-price-amt ret"><span style="font-size:.75rem;font-weight:500;vertical-align:super;">$</span>{{ number_format($rPrice) }}</div>
              <div class="cls-price-sub">taxes included</div>
            </div>
          </div>
          <div class="cls-specs">
            <div class="spec"><i class="fa-solid fa-briefcase"></i> {{ $returnClass->cabin_baggage_kg ?? 7 }}kg cabin</div>
            <div class="spec"><i class="fa-solid fa-suitcase-rolling"></i> {{ $returnClass->checkin_baggage_kg ?? 23 }}kg check-in</div>
            @if(!empty($returnClass->meal_included))<div class="spec"><i class="fa-solid fa-utensils"></i> Meal included</div>@endif
            @if(!empty($returnClass->seat_pitch))<div class="spec"><i class="fa-solid fa-arrows-up-down"></i> {{ $returnClass->seat_pitch }} seat pitch</div>@endif
            @if(!empty($returnClass->refundable))<div class="spec"><i class="fa-solid fa-rotate-left"></i> Refundable</div>@endif
          </div>
        </div>
      </div>
    </div>
    @endif

    {{-- ══ PASSENGER DETAILS FORM ══ --}}
    <div class="pax-form-card" id="passengerFormCard">
      <div class="pax-form-head">
        <div class="pfh-icon"><i class="fa-solid fa-users"></i></div>
        <div>
          <div class="pfh-title">Passenger Details</div>
          <div class="pfh-sub">Please fill in accurate details as per passport / ID</div>
        </div>
        <span class="pfh-count">{{ $totalPax }} Passenger{{ $totalPax > 1 ? 's' : '' }}</span>
      </div>

      <form id="passengerForm" method="POST" action="{{ route('booking.passengers.store') }}" novalidate>
        @csrf
        {{-- Hidden trip data --}}
        <input type="hidden" name="depart_flight_id"  value="{{ $departFlight->id }}">
        <input type="hidden" name="depart_class_id"   value="{{ $departClass->id }}">
        @if($isRound && $returnFlight)
        <input type="hidden" name="return_flight_id"  value="{{ $returnFlight->id }}">
        <input type="hidden" name="return_class_id"   value="{{ $returnClass->id }}">
        @endif
        <input type="hidden" name="trip_type"         value="{{ $tripType }}">
        <input type="hidden" name="class"             value="{{ $selClass }}">
        <input type="hidden" name="adults"            value="{{ $adults }}">
        <input type="hidden" name="children"          value="{{ $children }}">
        <input type="hidden" name="depart_date"       value="{{ $departDate }}">
        <input type="hidden" name="return_date"       value="{{ $returnDate }}">

        {{-- ADULT PASSENGERS --}}
        @for($i = 1; $i <= $adults; $i++)
        @php $paxIndex = $i; $isFirstAdult = $i === 1; @endphp
        <div class="pax-block" id="paxBlock_adult_{{ $i }}">
          <button type="button"
            class="pax-accordion-btn"
            data-bs-toggle="collapse"
            data-bs-target="#paxCollapse_adult_{{ $i }}"
            aria-expanded="{{ $isFirstAdult ? 'true' : 'false' }}"
            aria-controls="paxCollapse_adult_{{ $i }}"
            id="paxBtn_adult_{{ $i }}">
            <div class="pab-num">{{ $i }}</div>
            <div class="pab-info">
              <div class="pab-title" id="pabTitle_adult_{{ $i }}">
                Adult {{ $i }}{{ $isFirstAdult ? ' (Primary Contact)' : '' }}
              </div>
              <div class="pab-sub">Full name, passport &amp; contact{{ $isFirstAdult ? ' · Email &amp; phone required' : '' }}</div>
            </div>
            <span class="pab-type adult">Adult</span>
            <div class="pab-status" id="pabStatus_adult_{{ $i }}"></div>
            <i class="fa-solid fa-chevron-down pab-chevron"></i>
          </button>

          <div class="collapse {{ $isFirstAdult ? 'show' : '' }}" id="paxCollapse_adult_{{ $i }}">
            <div class="pax-fields">

              {{-- Title + First Name + Last Name --}}
              <div class="pf-row cols-3">
                <div class="pf-group">
                  <label class="pf-label">Title <span class="req">*</span></label>
                  <select name="passengers[adult][{{ $i }}][title]" class="pf-input pf-select pax-required" data-block="adult_{{ $i }}">
                    <option value="">Select</option>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Ms">Ms</option>
                    <option value="Dr">Dr</option>
                  </select>
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
                <div class="pf-group" style="grid-column:span 2;">
                  <label class="pf-label">First Name <span class="req">*</span></label>
                  <input type="text" name="passengers[adult][{{ $i }}][first_name]"
                    class="pf-input pax-required" placeholder="As on passport" data-block="adult_{{ $i }}"
                    oninput="updatePaxTitle('adult','{{ $i }}',this)">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
              </div>

              <div class="pf-row cols-2">
                <div class="pf-group">
                  <label class="pf-label">Last Name <span class="req">*</span></label>
                  <input type="text" name="passengers[adult][{{ $i }}][last_name]"
                    class="pf-input pax-required" placeholder="As on passport" data-block="adult_{{ $i }}"
                    oninput="updatePaxTitle('adult','{{ $i }}',this,true)">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
                <div class="pf-group">
                  <label class="pf-label">Date of Birth <span class="req">*</span></label>
                  <input type="date" name="passengers[adult][{{ $i }}][dob]"
                    class="pf-input pax-required" data-block="adult_{{ $i }}"
                    max="{{ date('Y-m-d', strtotime('-18 years')) }}">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
              </div>

              <div class="pf-row cols-2">
                <div class="pf-group">
                  <label class="pf-label">Gender <span class="req">*</span></label>
                  <select name="passengers[adult][{{ $i }}][gender]" class="pf-input pf-select pax-required" data-block="adult_{{ $i }}">
                    <option value="">Select gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                  </select>
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
                <div class="pf-group">
                  <label class="pf-label">Nationality <span class="req">*</span></label>
                  <input type="text" name="passengers[adult][{{ $i }}][nationality]"
                    class="pf-input pax-required" placeholder="e.g. Indian" data-block="adult_{{ $i }}">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
              </div>

              <div class="pf-row cols-2">
                <div class="pf-group">
                  <label class="pf-label">Passport / ID Number <span class="req">*</span></label>
                  <input type="text" name="passengers[adult][{{ $i }}][passport_number]"
                    class="pf-input pax-required" placeholder="e.g. A1234567" data-block="adult_{{ $i }}">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
                <div class="pf-group">
                  <label class="pf-label">Passport Expiry <span class="req">*</span></label>
                  <input type="date" name="passengers[adult][{{ $i }}][passport_expiry]"
                    class="pf-input pax-required" data-block="adult_{{ $i }}"
                    min="{{ date('Y-m-d', strtotime('+6 months')) }}">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Must be valid 6+ months</span>
                </div>
              </div>

              {{-- Contact info only for first adult --}}
              @if($isFirstAdult)
              <div style="height:1px;background:var(--border);margin:6px 0 16px;"></div>
              <div style="font-size:.7rem;font-weight:700;color:var(--primary);text-transform:uppercase;letter-spacing:.08em;margin-bottom:12px;">
                <i class="fa-solid fa-envelope" style="margin-right:5px;"></i>Contact Information
              </div>
              <div class="pf-row cols-2">
                <div class="pf-group">
                  <label class="pf-label">Email Address <span class="req">*</span></label>
                  <input type="email" name="contact_email"
                    class="pf-input pax-required" placeholder="you@example.com" data-block="adult_{{ $i }}">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Valid email required</span>
                </div>
                <div class="pf-group">
                  <label class="pf-label">Phone Number <span class="req">*</span></label>
                  <input type="tel" name="contact_phone"
                    class="pf-input pax-required" placeholder="+91 9876543210" data-block="adult_{{ $i }}">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
              </div>
              @endif

            </div>{{-- pax-fields --}}
          </div>{{-- collapse --}}
        </div>{{-- pax-block --}}
        @endfor

        {{-- CHILD PASSENGERS --}}
        @for($j = 1; $j <= $children; $j++)
        @php $childIndex = $adults + $j; @endphp
        <div class="pax-block" id="paxBlock_child_{{ $j }}">
          <button type="button"
            class="pax-accordion-btn"
            data-bs-toggle="collapse"
            data-bs-target="#paxCollapse_child_{{ $j }}"
            aria-expanded="false"
            aria-controls="paxCollapse_child_{{ $j }}"
            id="paxBtn_child_{{ $j }}">
            <div class="pab-num" style="background:#fef9c3;color:#92400e;border-color:#fef9c3;">{{ $childIndex }}</div>
            <div class="pab-info">
              <div class="pab-title" id="pabTitle_child_{{ $j }}">Child {{ $j }}</div>
              <div class="pab-sub">Must be under 12 years of age at time of travel</div>
            </div>
            <span class="pab-type child">Child</span>
            <div class="pab-status" id="pabStatus_child_{{ $j }}"></div>
            <i class="fa-solid fa-chevron-down pab-chevron"></i>
          </button>

          <div class="collapse" id="paxCollapse_child_{{ $j }}">
            <div class="pax-fields child-fields">

              <div class="child-banner">
                <i class="fa-solid fa-child-reaching"></i>
                Child passenger — age at time of travel is required. Must be 2–11 years old.
              </div>

              <div class="pf-row cols-3">
                <div class="pf-group">
                  <label class="pf-label">Title <span class="req">*</span></label>
                  <select name="passengers[child][{{ $j }}][title]" class="pf-input pf-select pax-required" data-block="child_{{ $j }}">
                    <option value="">Select</option>
                    <option value="Master">Master</option>
                    <option value="Miss">Miss</option>
                  </select>
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
                <div class="pf-group" style="grid-column:span 2;">
                  <label class="pf-label">First Name <span class="req">*</span></label>
                  <input type="text" name="passengers[child][{{ $j }}][first_name]"
                    class="pf-input pax-required" placeholder="As on passport" data-block="child_{{ $j }}"
                    oninput="updatePaxTitle('child','{{ $j }}',this)">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
              </div>

              <div class="pf-row cols-2">
                <div class="pf-group">
                  <label class="pf-label">Last Name <span class="req">*</span></label>
                  <input type="text" name="passengers[child][{{ $j }}][last_name]"
                    class="pf-input pax-required" placeholder="As on passport" data-block="child_{{ $j }}"
                    oninput="updatePaxTitle('child','{{ $j }}',this,true)">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
                <div class="pf-group">
                  <label class="pf-label">Date of Birth <span class="req">*</span></label>
                  <input type="date" name="passengers[child][{{ $j }}][dob]"
                    class="pf-input pax-required child-dob" data-block="child_{{ $j }}"
                    max="{{ date('Y-m-d', strtotime('-2 years')) }}"
                    min="{{ date('Y-m-d', strtotime('-12 years')) }}"
                    onchange="calcChildAge(this,'childAge_{{ $j }}')">
                  <span class="pf-err" id="childDobErr_{{ $j }}"><i class="fa-solid fa-circle-exclamation"></i> Child must be 2–11 years old</span>
                </div>
              </div>

              <div class="pf-row cols-1">
                <div class="pf-group">
                  <label class="pf-label">Age at Travel</label>
                  <div style="padding:9px 14px;background:var(--primary-light);border:1.5px solid var(--primary-pale);border-radius:var(--r8);font-size:.8rem;font-weight:700;color:var(--primary-dark);min-height:40px;" id="childAge_{{ $j }}">
                    — will calculate from date of birth
                  </div>
                </div>
              </div>

              <div class="pf-row cols-2">
                <div class="pf-group">
                  <label class="pf-label">Gender <span class="req">*</span></label>
                  <select name="passengers[child][{{ $j }}][gender]" class="pf-input pf-select pax-required" data-block="child_{{ $j }}">
                    <option value="">Select gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                  </select>
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
                <div class="pf-group">
                  <label class="pf-label">Nationality <span class="req">*</span></label>
                  <input type="text" name="passengers[child][{{ $j }}][nationality]"
                    class="pf-input pax-required" placeholder="e.g. Indian" data-block="child_{{ $j }}">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
              </div>

              <div class="pf-row cols-2">
                <div class="pf-group">
                  <label class="pf-label">Passport / ID Number <span class="req">*</span></label>
                  <input type="text" name="passengers[child][{{ $j }}][passport_number]"
                    class="pf-input pax-required" placeholder="e.g. A1234567" data-block="child_{{ $j }}">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
                <div class="pf-group">
                  <label class="pf-label">Passport Expiry <span class="req">*</span></label>
                  <input type="date" name="passengers[child][{{ $j }}][passport_expiry]"
                    class="pf-input pax-required" data-block="child_{{ $j }}"
                    min="{{ date('Y-m-d', strtotime('+6 months')) }}">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Must be valid 6+ months</span>
                </div>
              </div>

            </div>{{-- pax-fields --}}
          </div>{{-- collapse --}}
        </div>{{-- pax-block --}}
        @endfor

        {{-- FORM FOOTER / SUBMIT --}}
        <div class="pax-form-footer">
          <div>
            <div class="pff-total-lbl">Total Amount</div>
            <div class="pff-total-amt"><span style="font-size:.88rem;font-weight:500;vertical-align:super;">$</span>{{ number_format($grandTotal) }}</div>
            <div class="pff-note"><i class="fa-solid fa-lock"></i> Secure &amp; encrypted</div>
          </div>
          <div style="text-align:right;">
            <button type="submit" class="btn-submit" id="submitBtn">
              <i class="fa-solid fa-check-circle"></i>
              Confirm &amp; Proceed to Book
              <i class="fa-solid fa-arrow-right"></i>
            </button>
            <div class="btn-submit-note"><i class="fa-solid fa-shield-halved"></i> No hidden charges</div>
          </div>
        </div>

      </form>
    </div>{{-- pax-form-card --}}

  </div>{{-- col-lg-8 --}}

  {{-- RIGHT — summary sidebar --}}
  <div class="col-lg-4">
    <div class="bk-sidebar" style="position:sticky;top:18px;">

      {{-- Price Summary --}}
      <div class="price-card">
        <div class="price-card-head">
          <div class="pc-icon"><i class="fa-solid fa-receipt"></i></div>
          <div>
            <div class="pc-title">Price Summary</div>
            <div class="pc-sub">{{ $totalPax }} traveller{{ $totalPax > 1 ? 's' : '' }}</div>
          </div>
        </div>
        <div class="price-card-body">
          <div class="pg">
            <div class="pg-lbl" style="font-weight:700;color:var(--primary-dark);">
              <i class="fa-solid fa-plane-departure" style="font-size:.7rem;"></i>
              {{ $isRound ? 'Outbound' : 'Flight' }}
            </div><div></div>
            <div class="pg-lbl" style="padding-left:12px;">{{ $adults }} Adult{{ $adults > 1 ? 's' : '' }} × ${{ number_format($dPrice) }}</div>
            <div class="pg-val">${{ number_format($dPrice * $adults) }}</div>
            @if($children)
              <div class="pg-lbl" style="padding-left:12px;">{{ $children }} Child{{ $children > 1 ? 'ren' : '' }} × ${{ number_format($dPrice) }}</div>
              <div class="pg-val">${{ number_format($dPrice * $children) }}</div>
            @endif
            @if($isRound && $returnFlight)
              <div class="pg-div"></div>
              <div class="pg-lbl" style="font-weight:700;color:var(--green);">
                <i class="fa-solid fa-plane-arrival" style="font-size:.7rem;"></i> Return
              </div><div></div>
              <div class="pg-lbl" style="padding-left:12px;">{{ $adults }} Adult{{ $adults > 1 ? 's' : '' }} × ${{ number_format($rPrice) }}</div>
              <div class="pg-val">${{ number_format($rPrice * $adults) }}</div>
              @if($children)
                <div class="pg-lbl" style="padding-left:12px;">{{ $children }} Child{{ $children > 1 ? 'ren' : '' }} × ${{ number_format($rPrice) }}</div>
                <div class="pg-val">${{ number_format($rPrice * $children) }}</div>
              @endif
            @endif
            <div class="pg-div"></div>
            <div class="pg-total-lbl">Grand Total</div>
            <div class="pg-total-val"><span style="font-size:.82rem;font-weight:500;vertical-align:super;">$</span>{{ number_format($grandTotal) }}</div>
          </div>
          <div style="background:#f8fafc;border:1.5px solid var(--border);border-radius:var(--r8);padding:10px 12px;margin-top:14px;font-size:.68rem;color:var(--gray);line-height:1.6;">
            <i class="fa-solid fa-circle-info" style="color:var(--primary);"></i>
            All taxes and surcharges are included. Price is final.
          </div>
        </div>
      </div>

      {{-- Trip Info --}}
      <div class="info-card">
        <div class="info-card-head">
          <div class="ic-icon"><i class="fa-solid fa-circle-info"></i></div>
          <div>
            <div class="ic-title">Trip Details</div>
            <div class="ic-sub">Your selected options</div>
          </div>
        </div>
        <div class="info-card-body">
          <div class="info-row">
            <span class="ir-lbl">Trip Type</span>
            <span class="ir-val">{{ $isRound ? 'Round Trip' : 'One Way' }}</span>
          </div>
          <div class="info-row">
            <span class="ir-lbl">Class</span>
            <span class="ir-val" style="color:var(--primary);">{{ $selClass }}</span>
          </div>
          <div class="info-row">
            <span class="ir-lbl">Route</span>
            <span class="ir-val">{{ $departFlight->from_airport_code }} → {{ $departFlight->to_airport_code }}@if($isRound && $returnFlight) · {{ $returnFlight->from_airport_code }} → {{ $returnFlight->to_airport_code }}@endif</span>
          </div>
          <div class="info-row">
            <span class="ir-lbl">Depart</span>
            <span class="ir-val">{{ \Carbon\Carbon::parse($departDate)->format('d M Y') }}</span>
          </div>
          @if($isRound && $returnDate)
          <div class="info-row">
            <span class="ir-lbl">Return</span>
            <span class="ir-val">{{ \Carbon\Carbon::parse($returnDate)->format('d M Y') }}</span>
          </div>
          @endif
          <div class="info-row">
            <span class="ir-lbl">Adults</span>
            <span class="ir-val">{{ $adults }}</span>
          </div>
          @if($children)
          <div class="info-row">
            <span class="ir-lbl">Children</span>
            <span class="ir-val">{{ $children }}</span>
          </div>
          @endif
          <div class="info-row">
            <span class="ir-lbl">Outbound Seats Left</span>
            <span class="ir-val" style="color:{{ $dLow ? 'var(--red)' : 'var(--green)' }};">{{ $dAvail }}</span>
          </div>
          @if($isRound && $returnFlight)
          <div class="info-row">
            <span class="ir-lbl">Return Seats Left</span>
            <span class="ir-val" style="color:{{ $rLow ? 'var(--red)' : 'var(--green)' }};">{{ $rAvail }}</span>
          </div>
          @endif
        </div>
      </div>

      {{-- Trust --}}
      <div style="display:flex;flex-direction:column;gap:9px;margin-top:14px;padding:0 4px;">
        <div style="display:flex;align-items:center;gap:9px;font-size:.74rem;color:var(--slate);font-weight:500;">
          <i class="fa-solid fa-lock" style="color:var(--green);width:16px;text-align:center;"></i> SSL secured &amp; encrypted
        </div>
        <div style="display:flex;align-items:center;gap:9px;font-size:.74rem;color:var(--slate);font-weight:500;">
          <i class="fa-solid fa-shield-halved" style="color:var(--green);width:16px;text-align:center;"></i> No hidden fees
        </div>
        <div style="display:flex;align-items:center;gap:9px;font-size:.74rem;color:var(--slate);font-weight:500;">
          <i class="fa-solid fa-headset" style="color:var(--primary);width:16px;text-align:center;"></i> 24/7 support
        </div>
      </div>

    </div>
  </div>{{-- col-lg-4 --}}

</div>{{-- row --}}
</div>{{-- container --}}
</div>{{-- bk-wrap --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ── Update accordion title with passenger name as they type ──
const firstNames  = {};
const lastNames   = {};

function updatePaxTitle(type, index, input, isLast = false) {
  const key = type + '_' + index;
  if (!isLast) firstNames[key] = input.value.trim();
  else         lastNames[key]  = input.value.trim();
  const fn = firstNames[key] || '';
  const ln = lastNames[key]  || '';
  const nameDisplay = [fn, ln].filter(Boolean).join(' ');
  const titleEl = document.getElementById('pabTitle_' + key);
  if (titleEl) {
    const suffix = (type === 'adult' && index == 1) ? ' (Primary Contact)' : '';
    titleEl.textContent = nameDisplay
      ? nameDisplay + suffix
      : (type === 'adult' ? 'Adult ' + index : 'Child ' + index) + suffix;
  }
}

// ── Calculate child age from DOB ──
function calcChildAge(input, displayId) {
  const dob   = new Date(input.value);
  const today = new Date('{{ $departDate }}') || new Date();
  if (isNaN(dob)) return;
  let age = today.getFullYear() - dob.getFullYear();
  const m = today.getMonth() - dob.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) age--;
  const el = document.getElementById(displayId);
  if (!el) return;
  if (age < 2 || age > 11) {
    el.textContent = '⚠ Age ' + age + ' — must be between 2 and 11 years';
    el.style.color = 'var(--red)';
    el.style.background = '#fee2e2';
    el.style.borderColor = '#fca5a5';
    input.classList.add('error');
  } else {
    el.textContent = age + ' year' + (age !== 1 ? 's' : '') + ' old at time of travel';
    el.style.color = 'var(--primary-dark)';
    el.style.background = 'var(--primary-light)';
    el.style.borderColor = 'var(--primary-pale)';
    input.classList.remove('error');
  }
}

// ── Mark passenger block as filled (green dot) ──
function checkBlockFilled(block) {
  const inputs  = document.querySelectorAll('[data-block="' + block + '"].pax-required');
  const allFilled = [...inputs].every(i => i.value.trim() !== '');
  const dot = document.getElementById('pabStatus_' + block);
  if (dot) dot.classList.toggle('filled', allFilled);
}

document.querySelectorAll('.pax-required').forEach(input => {
  input.addEventListener('input',  () => checkBlockFilled(input.dataset.block));
  input.addEventListener('change', () => checkBlockFilled(input.dataset.block));
});

// ── Form validation on submit ──
document.getElementById('passengerForm').addEventListener('submit', function(e) {
  let valid = true;
  document.querySelectorAll('.pax-required').forEach(input => {
    const errEl = input.nextElementSibling;
    if (!input.value.trim()) {
      input.classList.add('error');
      if (errEl && errEl.classList.contains('pf-err')) errEl.classList.add('show');
      valid = false;
      // Open the collapsed panel that has the error
      const block = input.dataset.block;
      const collapseEl = document.getElementById('paxCollapse_' + block);
      if (collapseEl && !collapseEl.classList.contains('show')) {
        const btn = document.getElementById('paxBtn_' + block);
        if (btn) btn.click();
      }
    } else {
      input.classList.remove('error');
      if (errEl && errEl.classList.contains('pf-err')) errEl.classList.remove('show');
    }
  });
  if (!valid) {
    e.preventDefault();
    // Scroll to first error
    const firstErr = document.querySelector('.pf-input.error');
    if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
  }
});

// Clear error styling on input
document.querySelectorAll('.pf-input').forEach(input => {
  input.addEventListener('input', function() {
    this.classList.remove('error');
    const errEl = this.nextElementSibling;
    if (errEl && errEl.classList.contains('pf-err')) errEl.classList.remove('show');
  });
});
</script>
@endsection