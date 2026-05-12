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

/* ── HERO ── */
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

/* ── WRAP ── */
.bk-wrap{padding:28px 0 60px;}

/* ══════════════════════════════════════════
   FLIGHT CARD — matches search results style
══════════════════════════════════════════ */
.bk-card{
  background:#fff;
  border-radius:var(--r16);
  border:1.5px solid var(--border);
  overflow:hidden;
  margin-bottom:20px;
  box-shadow:0 4px 20px rgba(0,0,0,.05);
  animation:fadeUp .45s ease both;
}
.bk-card:nth-child(2){animation-delay:.08s;}
@keyframes fadeUp{from{opacity:0;transform:translateY(18px);}to{opacity:1;transform:translateY(0);}}

/* ── CARD HEADER (same structure as search results rt-card-header) ── */
.bk-card-header{
  display:flex;
  align-items:center;
  justify-content:space-between;
  padding:10px 20px;
  border-bottom:1.5px solid #bfdbfe;
  gap:12px;
}
.bk-card-header.depart-hdr{
  background:linear-gradient(90deg,#eff6ff 0%,#dbeafe 100%);
}
.bk-card-header.return-hdr{
  background:linear-gradient(90deg,#f0fdf4 0%,#dcfce7 100%);
  border-top:2px dashed #86efac;
  border-bottom-color:#86efac;
}

/* header left: icon + label + date */
.bk-hdr-left{display:flex;align-items:center;gap:8px;flex-shrink:0;}
.bk-hdr-left i{font-size:.73rem;}
.depart-hdr .bk-hdr-left i{color:var(--primary-dark);}
.return-hdr .bk-hdr-left i{color:#166534;}
.bk-hdr-label{font-size:.64rem;font-weight:800;letter-spacing:.09em;text-transform:uppercase;}
.depart-hdr .bk-hdr-label{color:var(--primary-dark);}
.return-hdr .bk-hdr-label{color:#166534;}
.bk-hdr-date{font-size:.68rem;font-weight:600;opacity:.8;}
.depart-hdr .bk-hdr-date{color:#3b5fc0;}
.return-hdr .bk-hdr-date{color:#15803d;}

/* header right: route pill + stop badge */
.bk-hdr-right{display:flex;align-items:center;gap:8px;flex-shrink:0;}
.bk-route-pill{
  display:flex;align-items:center;gap:6px;background:#fff;
  border:1.5px solid #bfdbfe;border-radius:100px;
  padding:4px 12px 4px 10px;font-size:.72rem;font-weight:800;
  color:var(--primary-dark);letter-spacing:.05em;
}
.bk-route-pill i{font-size:.66rem;color:var(--primary);}
.return-hdr .bk-route-pill{border-color:#86efac;color:#166534;}
.return-hdr .bk-route-pill i{color:#16a34a;}
.bk-hdr-stop{
  font-size:.62rem;font-weight:800;padding:4px 11px;border-radius:100px;
  display:inline-flex;align-items:center;gap:4px;white-space:nowrap;
}
.rt-stop-ns{background:#dcfce7;color:#14532d;}
.rt-stop-1s{background:#fef9c3;color:#78350f;}
.rt-stop-2s{background:#fee2e2;color:#7f1d1d;}

/* ── FLIGHT ROW ── */
.rt-flight-row{
  padding:18px 20px 14px;
  display:flex;
  align-items:center;
  gap:0;
}

/* Airline block */
.rt-airline-block{display:flex;align-items:center;gap:10px;min-width:170px;}
.rt-al-logo{
  width:42px;height:42px;border-radius:var(--r8);background:#fff;
  border:1.5px solid #dde3f0;display:flex;align-items:center;justify-content:center;
  overflow:hidden;flex-shrink:0;font-size:.58rem;font-weight:800;color:var(--primary);
  letter-spacing:.04em;text-align:center;line-height:1.2;
}
.rt-al-logo img{width:100%;height:100%;object-fit:contain;padding:3px;}
.rt-al-name{font-family:var(--font-display);font-weight:700;font-size:.82rem;color:var(--navy);}
.rt-al-sub{font-size:.67rem;color:var(--gray);margin-top:2px;display:flex;align-items:center;gap:5px;}
.rt-al-flno{font-weight:600;color:var(--slate);}
.rt-al-ac{background:#f1f5f9;border:1px solid var(--border);padding:2px 6px;border-radius:4px;font-size:.61rem;font-weight:700;}

/* Route section */
.rt-route{flex:1;display:flex;align-items:center;padding:0 12px;min-width:0;}

/* Endpoint — CENTERED (matching search results) */
.rt-ep{
  display:flex;flex-direction:column;align-items:center;text-align:center;min-width:0;
}

/* Time + AM/PM superscript (same as search results) */
.rt-ep-time-wrap{
  display:flex;align-items:flex-start;gap:2px;line-height:1;
}
.rt-ep-time{
  font-family:var(--font-display);font-size:1.35rem;font-weight:800;color:var(--navy);line-height:1;
}
.rt-ep-ampm{
  font-size:.56rem;font-weight:700;color:var(--gray);margin-top:1px;line-height:1;letter-spacing:.04em;
}
/* Timezone below time (same as search results) */
.rt-ep-tz{
  font-size:.6rem;font-weight:600;color:#94a3b8;letter-spacing:.04em;
  margin-top:15px;margin-left:-18px;line-height:1;
}
/* Airport IATA code — centered */
.rt-ep-iata{
  font-size:.8rem;font-weight:800;color:var(--primary);margin-top:5px;letter-spacing:.06em;
  text-align:center;
}
/* Airport name — centered */
.rt-ep-city{
  font-size:.63rem;color:var(--gray);margin-top:2px;font-weight:500;
  line-height:1.3;max-width:110px;text-align:center;
}

/* Middle connector */
.rt-mid{flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;padding:0 10px;min-width:0;}
.rt-route-line{display:flex;align-items:center;width:100%;gap:3px;}
.rt-r-dot{width:6px;height:6px;border-radius:50%;border:2px solid var(--primary);background:#fff;flex-shrink:0;}
.rt-r-dash{flex:1;height:2px;background:repeating-linear-gradient(90deg,var(--primary) 0,var(--primary) 4px,transparent 4px,transparent 9px);}
.rt-r-plane{font-size:.76rem;color:var(--primary);}
.rt-dur-pill{background:var(--primary-light);color:var(--primary-mid);font-size:.66rem;font-weight:700;padding:3px 10px;border-radius:100px;white-space:nowrap;}
.rt-stopover{display:inline-flex;align-items:center;justify-content:center;gap:4px;background:#fffbeb;border:1px solid #fde68a;color:#92400e;font-size:.64rem;font-weight:600;padding:3px 10px;border-radius:6px;text-align:center;line-height:1.4;}
.rt-overnight{display:inline-flex;align-items:center;gap:4px;background:#f0f9ff;border:1px solid #bae6fd;color:#0369a1;font-size:.64rem;font-weight:600;padding:3px 10px;border-radius:6px;}
.sv-city{background:#fef3c7;border:1px solid #fde68a;padding:1px 7px;border-radius:100px;font-size:.62rem;font-weight:700;color:#78350f;white-space:nowrap;}

/* ── CLASS PANEL ── */
.cls-panel{background:var(--primary-light);border:1.5px solid var(--primary-pale);border-radius:var(--r12);padding:16px 18px;margin:0 20px 18px;}
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

/* ── PRICE SUMMARY ── */
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

/* ── TRIP INFO ── */
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

.pax-block{border-bottom:1.5px solid var(--border);}
.pax-block:last-child{border-bottom:none;}
.pax-accordion-btn{width:100%;background:none;border:none;padding:14px 22px;display:flex;align-items:center;gap:12px;cursor:pointer;text-align:left;transition:background .15s;}
.pax-accordion-btn:hover{background:#f8fafc;}
.pax-accordion-btn[aria-expanded="true"]{background:var(--primary-light);}
.pab-num{width:30px;height:30px;border-radius:50%;background:var(--primary-pale);color:var(--primary);font-size:.72rem;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2px solid var(--primary-pale);}
.pax-accordion-btn[aria-expanded="true"] .pab-num{background:var(--primary);color:#fff;border-color:var(--primary);}
.pab-title{font-family:var(--font-display);font-weight:700;font-size:.82rem;color:var(--navy);}
.pab-sub{font-size:.65rem;color:var(--gray);margin-top:2px;}
.pab-type{margin-left:auto;font-size:.6rem;font-weight:800;padding:3px 10px;border-radius:100px;text-transform:uppercase;letter-spacing:.07em;}
.pab-type.adult{background:var(--primary-pale);color:var(--primary);}
.pab-type.child{background:#fef9c3;color:#78350f;}
.pab-chevron{color:var(--gray);font-size:.75rem;margin-left:8px;transition:transform .25s;}
.pax-accordion-btn[aria-expanded="true"] .pab-chevron{transform:rotate(180deg);color:var(--primary);}
.pab-status{width:8px;height:8px;border-radius:50%;background:#e2e8f0;flex-shrink:0;margin-left:4px;transition:background .2s;}
.pab-status.filled{background:var(--green);}

.pax-fields{padding:20px 22px 24px;background:#fafbff;border-top:1.5px solid var(--primary-pale);}
.pax-fields.child-fields{background:#fffdf0;border-top-color:#fde68a;}
.pf-row{display:grid;gap:14px;margin-bottom:14px;}
.pf-row.cols-2{grid-template-columns:1fr 1fr;}
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
.contact-divider{height:1px;background:var(--border);margin:6px 0 16px;}
.contact-label{font-size:.7rem;font-weight:700;color:var(--primary);text-transform:uppercase;letter-spacing:.08em;margin-bottom:12px;display:flex;align-items:center;gap:5px;}

.pax-form-footer{padding:18px 22px;background:#f8fafc;border-top:1.5px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;}
.pff-total-lbl{font-size:.6rem;color:var(--gray);font-weight:700;text-transform:uppercase;letter-spacing:.07em;}
.pff-total-amt{font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--primary-dark);}
.btn-submit{background:linear-gradient(135deg,var(--primary-mid),var(--primary-dark));color:#fff;border:none;border-radius:var(--r12);padding:14px 36px;font-family:var(--font-display);font-weight:800;font-size:.92rem;display:inline-flex;align-items:center;gap:9px;cursor:pointer;transition:transform .15s,box-shadow .15s;white-space:nowrap;}
.btn-submit:hover{transform:translateY(-2px);box-shadow:0 12px 32px rgba(29,78,216,.38);}
.btn-submit:disabled{opacity:.65;cursor:not-allowed;transform:none;box-shadow:none;}

.alert-success{background:#f0fdf4;border:1.5px solid #bbf7d0;color:#14532d;border-radius:var(--r12);padding:14px 18px;margin-bottom:20px;font-size:.82rem;font-weight:600;display:flex;align-items:center;gap:10px;}
.alert-error{background:#fef2f2;border:1.5px solid #fecaca;color:#7f1d1d;border-radius:var(--r12);padding:14px 18px;margin-bottom:20px;font-size:.82rem;font-weight:600;display:flex;align-items:center;gap:10px;}

/* ── RESPONSIVE ── */
@media(max-width:991px){.bk-sidebar{position:static !important;}}
@media(max-width:768px){
  .bk-steps{display:none;}
  .bk-card-header{flex-wrap:wrap;gap:8px;padding:10px 14px;}
  .bk-hdr-right{flex-wrap:wrap;}
  .rt-flight-row{padding:14px;flex-direction:column;align-items:stretch;gap:14px;}
  .rt-airline-block{min-width:unset;width:100%;}
  .rt-route{padding:0;width:100%;}
  .rt-ep-time{font-size:1.1rem;}
  .rt-ep-city{font-size:.6rem;max-width:80px;}
  .rt-mid{padding:0 6px;}
  .cls-panel{margin:0 14px 14px;}
  .pf-row.cols-2{grid-template-columns:1fr;}
}
@media(max-width:576px){
  .pax-form-footer{flex-direction:column;align-items:stretch;}
  .btn-submit{justify-content:center;}
}
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

  // ── Outbound times ──
  $dDep = \Carbon\Carbon::parse($departFlight->departure_time);
  $dArr = \Carbon\Carbon::parse($departFlight->arrival_time);
  $dON  = (int)($departFlight->overnight_arrival ?? 0);
  if ($dON) { $dArr->addDay(); } elseif ($dArr->lessThan($dDep)) { $dArr->addDay(); }
  $dDiff    = $dDep->diff($dArr);
  $dSc      = (int)$departFlight->stops;
  $dStopLbl = $dSc === 0 ? 'Non-stop' : ($dSc === 1 ? '1 Stop' : $dSc . ' Stops');
  $dStopBadge = $dSc === 0 ? 'rt-stop-ns' : ($dSc === 1 ? 'rt-stop-1s' : 'rt-stop-2s');
  $dStopIcon  = $dSc === 0 ? 'fa-circle-check' : 'fa-circle-dot';
  $dStopovers = $departFlight->stopover_cities ? json_decode($departFlight->stopover_cities, true) : [];
  $dAvail = $departAvailableSeats ?? ($departClass?->available_seats ?? 0);
  $dLow     = $dAvail > 0 && $dAvail <= 5;
  $dPrice   = $departClass?->base_price ?? 0;
  $dTax     = $departClass?->tax ?? 0;
  $drefund  = $departClass?->is_refundable ?? 0;
  $dcancel  = $departClass?->cancellation_charge;

  // ── Return times ──
  $rPrice = 0; $rTax = 0;
  if ($isRound && $returnFlight) {
    $rDep = \Carbon\Carbon::parse($returnFlight->departure_time);
    $rArr = \Carbon\Carbon::parse($returnFlight->arrival_time);
    $rON  = (int)($returnFlight->overnight_arrival ?? 0);
    if ($rON) { $rArr->addDay(); } elseif ($rArr->lessThan($rDep)) { $rArr->addDay(); }
    $rDiff      = $rDep->diff($rArr);
    $rSc        = (int)$returnFlight->stops;
    $rStopLbl   = $rSc === 0 ? 'Non-stop' : ($rSc === 1 ? '1 Stop' : $rSc . ' Stops');
    $rStopBadge = $rSc === 0 ? 'rt-stop-ns' : ($rSc === 1 ? 'rt-stop-1s' : 'rt-stop-2s');
    $rStopIcon  = $rSc === 0 ? 'fa-circle-check' : 'fa-circle-dot';
    $rStopovers = $returnFlight->stopover_cities ? json_decode($returnFlight->stopover_cities, true) : [];
    $rAvail = $returnAvailableSeats ?? ($returnClass?->available_seats ?? 0);
    $rLow       = $rAvail > 0 && $rAvail <= 5;
    $rPrice     = $returnClass?->base_price ?? 0;
    $rTax       = $returnClass?->tax ?? 0;
    $rrefund    = $returnClass?->is_refundable ?? 0;
    $rcancel    = $returnClass?->cancellation_charge;
  }

  $grandTotal = ($dPrice + $dTax + $rPrice + $rTax) * $totalPax;
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

  @if(session('success'))
    <div class="alert-success"><i class="fa-solid fa-circle-check fa-lg"></i> {{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert-error"><i class="fa-solid fa-circle-exclamation fa-lg"></i> {{ session('error') }}</div>
  @endif
  @if($errors->any())
    <div class="alert-error"><i class="fa-solid fa-circle-exclamation fa-lg"></i> Please fix the errors below and try again.</div>
  @endif

<div class="row g-4">

  {{-- ══ LEFT ══ --}}
  <div class="col-lg-8">

    {{-- ════ OUTBOUND CARD ════ --}}
    <div class="bk-card">

      {{-- Header: label + date on left | route pill + stop badge on right --}}
      <div class="bk-card-header depart-hdr">
        <div class="bk-hdr-left">
          <i class="fa-solid fa-plane-departure"></i>
          <span class="bk-hdr-label">{{ $isRound ? 'Outbound' : 'Departure' }}</span>
          <span class="bk-hdr-date">{{ \Carbon\Carbon::parse($departDate)->format('D, d M Y') }}</span>
        </div>
        <div class="bk-hdr-right">
          <div class="bk-route-pill">
            {{ $departFlight->from_airport_code }}
            <i class="fa-solid fa-arrow-right"></i>
            {{ $departFlight->to_airport_code }}
          </div>
          <span class="bk-hdr-stop {{ $dStopBadge }}">
            <i class="fa-solid {{ $dStopIcon }}"></i>{{ $dStopLbl }}
          </span>
        </div>
      </div>

      {{-- Flight row --}}
      <div class="rt-flight-row">

        {{-- Airline --}}
        <div class="rt-airline-block">
          <div class="rt-al-logo">
            @if($departFlight->airline_logo)
              <img src="{{ asset($departFlight->airline_logo) }}" alt="{{ $departFlight->airline_name }}"
                   onerror="this.style.display='none';this.parentElement.textContent='{{ strtoupper(substr($departFlight->airline_code,0,2)) }}';">
            @else{{ strtoupper(substr($departFlight->airline_code,0,2)) }}@endif
          </div>
          <div>
            <div class="rt-al-name">{{ $departFlight->airline_name }}</div>
            <div class="rt-al-sub">
              <span class="rt-al-flno">{{ $departFlight->flight_number }}</span>
              @if($departFlight->aircraft_type)<span class="rt-al-ac">{{ $departFlight->aircraft_type }}</span>@endif
            </div>
          </div>
        </div>

        {{-- Route --}}
        <div class="rt-route">

          {{-- Departure endpoint — centered --}}
          <div class="rt-ep">
            <div class="rt-ep-time-wrap">
              <span class="rt-ep-time">{{ $dDep->format('h:i') }}</span>
              <span class="rt-ep-ampm">{{ $dDep->format('A') }}</span>
              @if($departFlight->departure_timezone)
                <div class="rt-ep-tz">{{ $departFlight->departure_timezone }}</div>
              @endif
            </div>
            <div class="rt-ep-iata">{{ $departFlight->from_airport_code }}</div>
            <div class="rt-ep-city" title="{{ $departFlight->from_airport }}">{{ $departFlight->from_airport }}</div>
          </div>

          {{-- Middle --}}
          <div class="rt-mid">
            <div class="rt-route-line">
              <div class="rt-r-dot"></div>
              <div class="rt-r-dash"></div>
              <span class="rt-r-plane"><i class="fa-solid fa-plane"></i></span>
              <div class="rt-r-dash"></div>
              <div class="rt-r-dot"></div>
            </div>
            <span class="rt-dur-pill">{{ $dDiff->h }}h {{ $dDiff->i }}m</span>
            @if(count($dStopovers))
              <div class="rt-stopover">
                <i class="fa-solid fa-clock"></i> layover
                @foreach($dStopovers as $city)<span class="sv-city">{{ $city }}</span>@endforeach
              </div>
            @endif
            @if($dON)<div class="rt-overnight"><i class="fa-solid fa-moon"></i> +1 day</div>@endif
          </div>

          {{-- Arrival endpoint — centered --}}
          <div class="rt-ep">
            <div class="rt-ep-time-wrap">
              <span class="rt-ep-time">{{ $dArr->format('h:i') }}@if($dON)<sup style="font-size:.55rem;color:#f97316;margin-left:1px;">+1</sup>@endif</span>
              <span class="rt-ep-ampm">{{ $dArr->format('A') }}</span>
              @if($departFlight->arrival_timezone)
                <div class="rt-ep-tz">{{ $departFlight->arrival_timezone }}</div>
              @endif
            </div>
            <div class="rt-ep-iata">{{ $departFlight->to_airport_code }}</div>
            <div class="rt-ep-city" title="{{ $departFlight->to_airport }}">{{ $departFlight->to_airport }}</div>
          </div>

        </div>{{-- rt-route --}}
      </div>{{-- rt-flight-row --}}

      {{-- Class panel --}}
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
            @if($drefund)<span style="font-size:.7rem;font-weight:700;color:#166534;display:inline-flex;align-items:center;gap:4px;"><i class="fa-solid fa-rotate-left"></i> Refundable</span>@endif
            @if($dcancel)<span style="font-size:.7rem;color:var(--gray);">Cancellation: ${{ number_format($dcancel) }}</span>@endif
          </div>
          <div class="cls-price-blk">
            <div class="cls-price-lbl">Per person</div>
            <div class="cls-price-amt"><span style="font-size:.75rem;font-weight:500;vertical-align:super;">$</span>{{ number_format($dPrice) }}</div>
            <div class="cls-price-sub">Base price</div>
          </div>
        </div>
        <div class="cls-specs">
          <div class="spec"><i class="fa-solid fa-briefcase"></i> {{ $departClass->cabin_baggage_kg ?? 7 }}kg cabin</div>
          <div class="spec"><i class="fa-solid fa-suitcase-rolling"></i> {{ $departClass->checkin_baggage_kg ?? 23 }}kg check-in</div>
          @if(!empty($departClass->meal_included))<div class="spec"><i class="fa-solid fa-utensils"></i> Meal included</div>@endif
          @if(!empty($departClass->seat_pitch))<div class="spec"><i class="fa-solid fa-arrows-up-down"></i> {{ $departClass->seat_pitch }} seat pitch</div>@endif
        </div>
      </div>

    </div>{{-- bk-card --}}

    {{-- ════ RETURN CARD (round trip only) ════ --}}
    @if($isRound && $returnFlight)
    <div class="bk-card">

      <div class="bk-card-header return-hdr">
        <div class="bk-hdr-left">
          <i class="fa-solid fa-plane-arrival"></i>
          <span class="bk-hdr-label">Return</span>
          <span class="bk-hdr-date">{{ \Carbon\Carbon::parse($returnDate)->format('D, d M Y') }}</span>
        </div>
        <div class="bk-hdr-right">
          <div class="bk-route-pill">
            {{ $returnFlight->from_airport_code }}
            <i class="fa-solid fa-arrow-right"></i>
            {{ $returnFlight->to_airport_code }}
          </div>
          <span class="bk-hdr-stop {{ $rStopBadge }}">
            <i class="fa-solid {{ $rStopIcon }}"></i>{{ $rStopLbl }}
          </span>
        </div>
      </div>

      <div class="rt-flight-row">

        <div class="rt-airline-block">
          <div class="rt-al-logo">
            @if($returnFlight->airline_logo)
              <img src="{{ asset($returnFlight->airline_logo) }}" alt="{{ $returnFlight->airline_name }}"
                   onerror="this.style.display='none';this.parentElement.textContent='{{ strtoupper(substr($returnFlight->airline_code,0,2)) }}';">
            @else{{ strtoupper(substr($returnFlight->airline_code,0,2)) }}@endif
          </div>
          <div>
            <div class="rt-al-name">{{ $returnFlight->airline_name }}</div>
            <div class="rt-al-sub">
              <span class="rt-al-flno">{{ $returnFlight->flight_number }}</span>
              @if($returnFlight->aircraft_type)<span class="rt-al-ac">{{ $returnFlight->aircraft_type }}</span>@endif
            </div>
          </div>
        </div>

        <div class="rt-route">

          <div class="rt-ep">
            <div class="rt-ep-time-wrap">
              <span class="rt-ep-time">{{ $rDep->format('h:i') }}</span>
              <span class="rt-ep-ampm">{{ $rDep->format('A') }}</span>
              @if($returnFlight->departure_timezone)
                <div class="rt-ep-tz">{{ $returnFlight->departure_timezone }}</div>
              @endif
            </div>
            <div class="rt-ep-iata">{{ $returnFlight->from_airport_code }}</div>
            <div class="rt-ep-city" title="{{ $returnFlight->from_airport }}">{{ $returnFlight->from_airport }}</div>
          </div>

          <div class="rt-mid">
            <div class="rt-route-line">
              <div class="rt-r-dot"></div>
              <div class="rt-r-dash"></div>
              <span class="rt-r-plane"><i class="fa-solid fa-plane" style="transform:scaleX(-1);display:inline-block;"></i></span>
              <div class="rt-r-dash"></div>
              <div class="rt-r-dot"></div>
            </div>
            <span class="rt-dur-pill">{{ $rDiff->h }}h {{ $rDiff->i }}m</span>
            @if(count($rStopovers))
              <div class="rt-stopover">
                <i class="fa-solid fa-clock"></i> layover
                @foreach($rStopovers as $city)<span class="sv-city">{{ $city }}</span>@endforeach
              </div>
            @endif
            @if($rON)<div class="rt-overnight"><i class="fa-solid fa-moon"></i> +1 day</div>@endif
          </div>

          <div class="rt-ep">
            <div class="rt-ep-time-wrap">
              <span class="rt-ep-time">{{ $rArr->format('h:i') }}@if($rON)<sup style="font-size:.55rem;color:#f97316;margin-left:1px;">+1</sup>@endif</span>
              <span class="rt-ep-ampm">{{ $rArr->format('A') }}</span>
              @if($returnFlight->arrival_timezone)
                <div class="rt-ep-tz">{{ $returnFlight->arrival_timezone }}</div>
              @endif
            </div>
            <div class="rt-ep-iata">{{ $returnFlight->to_airport_code }}</div>
            <div class="rt-ep-city" title="{{ $returnFlight->to_airport }}">{{ $returnFlight->to_airport }}</div>
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
            @if($rrefund)<span style="font-size:.7rem;font-weight:700;color:#166534;display:inline-flex;align-items:center;gap:4px;"><i class="fa-solid fa-rotate-left"></i> Refundable</span>@endif
            @if($rcancel)<span style="font-size:.7rem;color:var(--gray);">Cancellation: ${{ number_format($rcancel) }}</span>@endif
          </div>
          <div class="cls-price-blk">
            <div class="cls-price-lbl">Per person</div>
            <div class="cls-price-amt ret"><span style="font-size:.75rem;font-weight:500;vertical-align:super;">$</span>{{ number_format($rPrice) }}</div>
            <div class="cls-price-sub">Base price</div>
          </div>
        </div>
        <div class="cls-specs">
          <div class="spec"><i class="fa-solid fa-briefcase"></i> {{ $returnClass->cabin_baggage_kg ?? 7 }}kg cabin</div>
          <div class="spec"><i class="fa-solid fa-suitcase-rolling"></i> {{ $returnClass->checkin_baggage_kg ?? 23 }}kg check-in</div>
          @if(!empty($returnClass->meal_included))<div class="spec"><i class="fa-solid fa-utensils"></i> Meal included</div>@endif
          @if(!empty($returnClass->seat_pitch))<div class="spec"><i class="fa-solid fa-arrows-up-down"></i> {{ $returnClass->seat_pitch }} seat pitch</div>@endif
        </div>
      </div>

    </div>{{-- bk-card --}}
    @endif

    {{-- ════ PASSENGER FORM ════ --}}
    <div class="pax-form-card" id="passengerFormCard">
      <div class="pax-form-head">
        <div class="pfh-icon"><i class="fa-solid fa-users"></i></div>
        <div>
          <div class="pfh-title">Passenger Details</div>
          <div class="pfh-sub">Fill in first name, last name &amp; gender for each traveller</div>
        </div>
        <span class="pfh-count">{{ $totalPax }} Passenger{{ $totalPax > 1 ? 's' : '' }}</span>
      </div>

      <form id="passengerForm" method="POST" action="{{ route('flight.book') }}" novalidate>
        @csrf
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
        <input type="hidden" name="grand_total"       value="{{ $grandTotal }}">

        {{-- Adults --}}
        @for($i = 1; $i <= $adults; $i++)
        @php $isFirstAdult = $i === 1; @endphp
        <div class="pax-block" id="paxBlock_adult_{{ $i }}">
          <button type="button" class="pax-accordion-btn"
            data-bs-toggle="collapse" data-bs-target="#paxCollapse_adult_{{ $i }}"
            aria-expanded="{{ $isFirstAdult ? 'true' : 'false' }}"
            id="paxBtn_adult_{{ $i }}">
            <div class="pab-num">{{ $i }}</div>
            <div>
              <div class="pab-title" id="pabTitle_adult_{{ $i }}">
                Adult {{ $i }}{{ $isFirstAdult ? ' (Primary Contact)' : '' }}
              </div>
              <div class="pab-sub">First name, last name &amp; gender{{ $isFirstAdult ? ' · Email &amp; phone required' : '' }}</div>
            </div>
            <span class="pab-type adult">Adult</span>
            <div class="pab-status" id="pabStatus_adult_{{ $i }}"></div>
            <i class="fa-solid fa-chevron-down pab-chevron"></i>
          </button>

          <div class="collapse {{ $isFirstAdult ? 'show' : '' }}" id="paxCollapse_adult_{{ $i }}">
            <div class="pax-fields">
              <div class="pf-row cols-2">
                <div class="pf-group">
                  <label class="pf-label">First Name <span class="req">*</span></label>
                  <input type="text" name="passengers[adult][{{ $i }}][first_name]"
                    class="pf-input pax-required" placeholder="First name"
                    data-block="adult_{{ $i }}" value="{{ old('passengers.adult.'.$i.'.first_name') }}"
                    oninput="updatePaxTitle('adult','{{ $i }}',this)">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
                <div class="pf-group">
                  <label class="pf-label">Last Name <span class="req">*</span></label>
                  <input type="text" name="passengers[adult][{{ $i }}][last_name]"
                    class="pf-input pax-required" placeholder="Last name"
                    data-block="adult_{{ $i }}" value="{{ old('passengers.adult.'.$i.'.last_name') }}"
                    oninput="updatePaxTitle('adult','{{ $i }}',this,true)">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
              </div>
              <div class="pf-row cols-1">
                <div class="pf-group">
                  <label class="pf-label">Gender <span class="req">*</span></label>
                  <select name="passengers[adult][{{ $i }}][gender]" class="pf-input pf-select pax-required" data-block="adult_{{ $i }}">
                    <option value="">Select gender</option>
                    <option value="male"   {{ old('passengers.adult.'.$i.'.gender') == 'male'   ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('passengers.adult.'.$i.'.gender') == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other"  {{ old('passengers.adult.'.$i.'.gender') == 'other'  ? 'selected' : '' }}>Other</option>
                  </select>
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
              </div>
              @if($isFirstAdult)
              <div class="contact-divider"></div>
              <div class="contact-label"><i class="fa-solid fa-envelope"></i> Contact Information</div>
              <div class="pf-row cols-2">
                <div class="pf-group">
                  <label class="pf-label">Email Address <span class="req">*</span></label>
                  <input type="email" name="contact_email"
                    class="pf-input pax-required" placeholder="you@example.com"
                    data-block="adult_{{ $i }}" value="{{ old('contact_email') }}">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Valid email required</span>
                </div>
                <div class="pf-group">
                  <label class="pf-label">Phone Number <span class="req">*</span></label>
                  <input type="tel" name="contact_phone"
                    class="pf-input pax-required" placeholder="+91 9876543210"
                    data-block="adult_{{ $i }}" value="{{ old('contact_phone') }}">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
              </div>
              @endif
            </div>
          </div>
        </div>
        @endfor

        {{-- Children --}}
        @for($j = 1; $j <= $children; $j++)
        @php $childIndex = $adults + $j; @endphp
        <div class="pax-block" id="paxBlock_child_{{ $j }}">
          <button type="button" class="pax-accordion-btn"
            data-bs-toggle="collapse" data-bs-target="#paxCollapse_child_{{ $j }}"
            aria-expanded="false" id="paxBtn_child_{{ $j }}">
            <div class="pab-num" style="background:#fef9c3;color:#92400e;border-color:#fef9c3;">{{ $childIndex }}</div>
            <div>
              <div class="pab-title" id="pabTitle_child_{{ $j }}">Child {{ $j }}</div>
              <div class="pab-sub">First name, last name, gender &amp; date of birth</div>
            </div>
            <span class="pab-type child">Child</span>
            <div class="pab-status" id="pabStatus_child_{{ $j }}"></div>
            <i class="fa-solid fa-chevron-down pab-chevron"></i>
          </button>

          <div class="collapse" id="paxCollapse_child_{{ $j }}">
            <div class="pax-fields child-fields">
              <div class="child-banner">
                <i class="fa-solid fa-child-reaching"></i>
                Child passenger — must be 0–17 years old at time of travel.
              </div>
              <div class="pf-row cols-2">
                <div class="pf-group">
                  <label class="pf-label">First Name <span class="req">*</span></label>
                  <input type="text" name="passengers[child][{{ $j }}][first_name]"
                    class="pf-input pax-required" placeholder="First name"
                    data-block="child_{{ $j }}" value="{{ old('passengers.child.'.$j.'.first_name') }}"
                    oninput="updatePaxTitle('child','{{ $j }}',this)">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
                <div class="pf-group">
                  <label class="pf-label">Last Name <span class="req">*</span></label>
                  <input type="text" name="passengers[child][{{ $j }}][last_name]"
                    class="pf-input pax-required" placeholder="Last name"
                    data-block="child_{{ $j }}" value="{{ old('passengers.child.'.$j.'.last_name') }}"
                    oninput="updatePaxTitle('child','{{ $j }}',this,true)">
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
              </div>
              <div class="pf-row cols-2">
                <div class="pf-group">
                  <label class="pf-label">Gender <span class="req">*</span></label>
                  <select name="passengers[child][{{ $j }}][gender]" class="pf-input pf-select pax-required" data-block="child_{{ $j }}">
                    <option value="">Select gender</option>
                    <option value="male"   {{ old('passengers.child.'.$j.'.gender') == 'male'   ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('passengers.child.'.$j.'.gender') == 'female' ? 'selected' : '' }}>Female</option>
                  </select>
                  <span class="pf-err"><i class="fa-solid fa-circle-exclamation"></i> Required</span>
                </div>
                <div class="pf-group">
                  <label class="pf-label">Date of Birth <span class="req">*</span></label>
                  <input type="date" name="passengers[child][{{ $j }}][dob]"
                    class="pf-input pax-required child-dob"
                    data-block="child_{{ $j }}"
                    max="{{ date('Y-m-d') }}"
                    min="{{ date('Y-m-d', strtotime('-18 years')) }}"
                    value="{{ old('passengers.child.'.$j.'.dob') }}"
                    onchange="calcChildAge(this,'childAge_{{ $j }}')">
                  <span class="pf-err" id="childDobErr_{{ $j }}"><i class="fa-solid fa-circle-exclamation"></i> Must be 0–17 years old</span>
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
            </div>
          </div>
        </div>
        @endfor

        <div class="pax-form-footer">
          <div>
            <button type="submit" class="btn-submit" id="submitBtn">
              <i class="fa-solid fa-check-circle"></i>
              Confirm &amp; Proceed to Book
              <i class="fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </div>

      </form>
    </div>{{-- pax-form-card --}}

  </div>{{-- col-lg-8 --}}

  {{-- ══ RIGHT SIDEBAR ══ --}}
  <div class="col-lg-4">
    <div class="bk-sidebar" style="position:sticky;top:18px;">

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
            <div class="pg-lbl" style="padding-left:12px;">Tax</div>
            <div class="pg-val">${{ number_format($dTax * $adults) }}</div>
            @if($children)
              <div class="pg-lbl" style="padding-left:12px;">{{ $children }} Child{{ $children > 1 ? 'ren' : '' }} × ${{ number_format($dPrice) }}</div>
              <div class="pg-val">${{ number_format($dPrice * $children) }}</div>
              <div class="pg-lbl" style="padding-left:12px;">Tax</div>
              <div class="pg-val">${{ number_format($dTax * $children) }}</div>
            @endif
            @if($isRound && $returnFlight)
              <div class="pg-div"></div>
              <div class="pg-lbl" style="font-weight:700;color:var(--green);">
                <i class="fa-solid fa-plane-arrival" style="font-size:.7rem;"></i> Return
              </div><div></div>
              <div class="pg-lbl" style="padding-left:12px;">{{ $adults }} Adult{{ $adults > 1 ? 's' : '' }} × ${{ number_format($rPrice) }}</div>
              <div class="pg-val">${{ number_format($rPrice * $adults) }}</div>
              <div class="pg-lbl" style="padding-left:12px;">Tax</div>
              <div class="pg-val">${{ number_format($rTax * $adults) }}</div>
              @if($children)
                <div class="pg-lbl" style="padding-left:12px;">{{ $children }} Child{{ $children > 1 ? 'ren' : '' }} × ${{ number_format($rPrice) }}</div>
                <div class="pg-val">${{ number_format($rPrice * $children) }}</div>
                <div class="pg-lbl" style="padding-left:12px;">Tax</div>
                <div class="pg-val">${{ number_format($rTax * $children) }}</div>
              @endif
            @endif
            <div class="pg-div"></div>
            <div class="pg-total-lbl">Grand Total</div>
            <div class="pg-total-val"><span style="font-size:.82rem;font-weight:500;vertical-align:super;">$</span>{{ number_format($grandTotal) }}</div>
          </div>
          <div style="background:#f8fafc;border:1.5px solid var(--border);border-radius:var(--r8);padding:10px 12px;margin-top:14px;font-size:.68rem;color:var(--gray);line-height:1.6;">
            <i class="fa-solid fa-circle-info" style="color:var(--primary);"></i>
            24 hour cancellation allowed after booking at no extra cost.
          </div>
        </div>
      </div>

      <div class="info-card">
        <div class="info-card-head">
          <div class="ic-icon"><i class="fa-solid fa-circle-info"></i></div>
          <div>
            <div class="ic-title">Trip Details</div>
            <div class="ic-sub">Your selected options</div>
          </div>
        </div>
        <div class="info-card-body">
          <div class="info-row"><span class="ir-lbl">Trip Type</span><span class="ir-val">{{ $isRound ? 'Round Trip' : 'One Way' }}</span></div>
          <div class="info-row"><span class="ir-lbl">Class</span><span class="ir-val" style="color:var(--primary);">{{ $selClass }}</span></div>
          <div class="info-row">
            <span class="ir-lbl">Route</span>
            <span class="ir-val">{{ $departFlight->from_airport_code }} → {{ $departFlight->to_airport_code }}@if($isRound && $returnFlight) · {{ $returnFlight->from_airport_code }} → {{ $returnFlight->to_airport_code }}@endif</span>
          </div>
          <div class="info-row"><span class="ir-lbl">Depart</span><span class="ir-val">{{ \Carbon\Carbon::parse($departDate)->format('d M Y') }}</span></div>
          @if($isRound && $returnDate)
          <div class="info-row"><span class="ir-lbl">Return</span><span class="ir-val">{{ \Carbon\Carbon::parse($returnDate)->format('d M Y') }}</span></div>
          @endif
          <div class="info-row"><span class="ir-lbl">Adults</span><span class="ir-val">{{ $adults }}</span></div>
          @if($children)
          <div class="info-row"><span class="ir-lbl">Children</span><span class="ir-val">{{ $children }}</span></div>
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
const firstNames = {}, lastNames = {};

function updatePaxTitle(type, index, input, isLast = false) {
  const key = type + '_' + index;
  if (!isLast) firstNames[key] = input.value.trim();
  else         lastNames[key]  = input.value.trim();
  const fn = firstNames[key] || '', ln = lastNames[key] || '';
  const nameDisplay = [fn, ln].filter(Boolean).join(' ');
  const titleEl = document.getElementById('pabTitle_' + key);
  if (titleEl) {
    const suffix = (type === 'adult' && index == 1) ? ' (Primary Contact)' : '';
    titleEl.textContent = nameDisplay
      ? nameDisplay + suffix
      : (type === 'adult' ? 'Adult ' + index : 'Child ' + index) + suffix;
  }
}

function calcChildAge(input, displayId) {
  const dob = new Date(input.value), today = new Date();
  if (isNaN(dob)) return;
  let age = today.getFullYear() - dob.getFullYear();
  const m = today.getMonth() - dob.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) age--;
  const el = document.getElementById(displayId);
  if (!el) return;
  if (age < 0 || age > 17) {
    el.textContent = '⚠ Age ' + age + ' — must be between 0 and 17 years';
    el.style.color = 'var(--red)'; el.style.background = '#fee2e2'; el.style.borderColor = '#fca5a5';
    input.classList.add('error');
  } else {
    el.textContent = age + ' year' + (age !== 1 ? 's' : '') + ' old at time of travel';
    el.style.color = 'var(--primary-dark)'; el.style.background = 'var(--primary-light)'; el.style.borderColor = 'var(--primary-pale)';
    input.classList.remove('error');
  }
}

function checkBlockFilled(block) {
  const inputs = document.querySelectorAll('[data-block="' + block + '"].pax-required');
  const allFilled = [...inputs].every(i => i.value.trim() !== '');
  const dot = document.getElementById('pabStatus_' + block);
  if (dot) dot.classList.toggle('filled', allFilled);
}

document.querySelectorAll('.pax-required').forEach(input => {
  input.addEventListener('input',  () => checkBlockFilled(input.dataset.block));
  input.addEventListener('change', () => checkBlockFilled(input.dataset.block));
});

document.getElementById('passengerForm').addEventListener('submit', function(e) {
  let valid = true;
  document.querySelectorAll('.pax-required').forEach(input => {
    const errEl = input.nextElementSibling;
    if (!input.value.trim()) {
      input.classList.add('error');
      if (errEl && errEl.classList.contains('pf-err')) errEl.classList.add('show');
      valid = false;
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
    const firstErr = document.querySelector('.pf-input.error');
    if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
    return;
  }
  const btn = document.getElementById('submitBtn');
  btn.disabled = true;
  btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';
});

document.querySelectorAll('.pf-input').forEach(input => {
  input.addEventListener('input', function() {
    this.classList.remove('error');
    const errEl = this.nextElementSibling;
    if (errEl && errEl.classList.contains('pf-err')) errEl.classList.remove('show');
  });
});
</script>

@endsection