@extends('header')

@section('home')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ══════════════════════════════════════════
   RESET & ROOT VARIABLES
══════════════════════════════════════════ */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
:root{
  --primary:#2563eb;
  --primary-dark:#1e40af;
  --primary-light:#eff6ff;
  --primary-pale:#dbeafe;
  --navy:#0f172a;
  --slate:#334155;
  --gray:#64748b;
  --border:#e2e8f0;
  --bg:#f0f4f8;
  --green:#16a34a;
  --green-light:#dcfce7;
  --green-dark:#14532d;
  --amber:#d97706;
  --amber-light:#fef3c7;
  --red:#dc2626;
  --font-main:'Plus Jakarta Sans',sans-serif;
  --font-display:'Space Grotesk',sans-serif;
}
body,html{font-family:var(--font-main);background:var(--bg);color:var(--navy);}

/* ══════════════════════════════════════════
   HERO BANNER
══════════════════════════════════════════ */
.cf-hero{
  background:linear-gradient(135deg,#052e16 0%,#14532d 50%,#16a34a 100%);
  padding:52px 0 60px;
  position:relative;
  overflow:hidden;
}
.cf-hero::before{
  content:'';position:absolute;inset:0;
  background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.cf-hero-inner{position:relative;z-index:1;text-align:center;}

.cf-check-wrap{
  width:88px;height:88px;border-radius:50%;
  background:rgba(255,255,255,.15);
  border:3px solid rgba(255,255,255,.3);
  display:flex;align-items:center;justify-content:center;
  margin:0 auto 20px;
  animation:popIn .5s cubic-bezier(.34,1.56,.64,1) both;
}
.cf-check-wrap i{font-size:2.4rem;color:#fff;}
@keyframes popIn{from{opacity:0;transform:scale(.4);}to{opacity:1;transform:scale(1);}}

.cf-title{
  font-family:var(--font-display);color:#fff;
  font-size:2rem;font-weight:700;
  animation:fadeUp .5s .15s ease both;
}
.cf-subtitle{
  color:rgba(255,255,255,.75);font-size:.92rem;margin-top:6px;
  animation:fadeUp .5s .25s ease both;
}
@keyframes fadeUp{from{opacity:0;transform:translateY(14px);}to{opacity:1;transform:translateY(0);}}

.cf-ref-pill{
  display:inline-flex;align-items:center;gap:12px;
  background:rgba(255,255,255,.18);
  border:1.5px solid rgba(255,255,255,.3);
  border-radius:100px;padding:10px 24px;
  margin-top:20px;
  animation:fadeUp .5s .35s ease both;
}
.cf-ref-lbl{color:rgba(255,255,255,.7);font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;}
.cf-ref-val{font-family:var(--font-display);color:#fff;font-size:1.1rem;font-weight:700;letter-spacing:.08em;}
.cf-ref-copy{background:rgba(255,255,255,.2);border:none;border-radius:6px;color:#fff;padding:5px 12px;font-size:.68rem;font-weight:700;cursor:pointer;transition:background .15s;}
.cf-ref-copy:hover{background:rgba(255,255,255,.35);}

.cf-steps-bar{
  display:flex;align-items:center;justify-content:center;gap:4px;
  margin-top:28px;
  animation:fadeUp .5s .4s ease both;
}
.cf-step{display:flex;align-items:center;gap:5px;font-size:.7rem;font-weight:700;color:rgba(255,255,255,.35);}
.cf-step.done{color:rgba(255,255,255,.7);}
.cf-step.active{color:#fff;}
.cf-snum{width:22px;height:22px;border-radius:50%;border:2px solid rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;font-size:.58rem;font-weight:800;}
.cf-step.done .cf-snum{background:var(--green);border-color:var(--green);}
.cf-step.active .cf-snum{background:#fff;color:var(--green-dark);border-color:#fff;}
.cf-sdiv{width:28px;height:2px;background:rgba(255,255,255,.15);margin:0 2px;}

/* ══════════════════════════════════════════
   LAYOUT WRAP
══════════════════════════════════════════ */
.cf-wrap{padding:32px 0 72px;}

/* ══════════════════════════════════════════
   TICKET / SECTION CARDS
══════════════════════════════════════════ */
.ticket-card{
  background:#fff;
  border-radius:16px;
  border:1.5px solid var(--border);
  overflow:hidden;
  box-shadow:0 4px 24px rgba(0,0,0,.06);
  margin-bottom:20px;
  animation:fadeUp .45s ease both;
}
.ticket-card:nth-child(2){animation-delay:.08s;}
.ticket-card:nth-child(3){animation-delay:.14s;}

.tc-head{padding:14px 22px;display:flex;align-items:center;gap:10px;}
.tc-head.dep{background:linear-gradient(90deg,#eff6ff,#dbeafe);}
.tc-head.ret{background:linear-gradient(90deg,#f0fdf4,#dcfce7);}
.tc-head.pax{background:linear-gradient(90deg,#fefce8,#fef3c7);}
.tc-head.info{background:linear-gradient(90deg,var(--navy),var(--slate));}

.tc-hicon{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:.9rem;flex-shrink:0;}
.tc-hicon.blue{background:var(--primary-pale);color:var(--primary);}
.tc-hicon.green{background:var(--green-light);color:var(--green);}
.tc-hicon.amber{background:#fde68a;color:#92400e;}
.tc-hicon.white{background:rgba(255,255,255,.12);color:#fff;}

.tc-htitle{font-family:var(--font-display);font-weight:700;font-size:.92rem;}
.tc-htitle.light{color:#fff;}
.tc-hsub{font-size:.68rem;margin-top:2px;}
.tc-hsub.light{color:rgba(255,255,255,.5);}
.tc-hsub.dark{color:var(--gray);}
.tc-badge{margin-left:auto;font-size:.62rem;font-weight:700;padding:3px 12px;border-radius:100px;letter-spacing:.06em;text-transform:uppercase;color:#fff;white-space:nowrap;}

/* ══════════════════════════════════════════
   FLIGHT BODY
══════════════════════════════════════════ */
.ticket-body{padding:22px 22px 18px;position:relative;}

.ticket-divider{
  display:flex;align-items:center;
  margin:16px -22px;
}
.td-circle{
  width:20px;height:20px;border-radius:50%;
  background:var(--bg);border:1.5px solid var(--border);
  flex-shrink:0;
}
.td-dashes{flex:1;height:0;border-top:2px dashed var(--border);}

/* Flight route */
.fd-row{display:flex;align-items:center;gap:14px;flex-wrap:wrap;}
.fd-airline{display:flex;align-items:center;gap:10px;min-width:150px;}
.fd-logo{width:44px;height:44px;border-radius:10px;border:1.5px solid var(--border);background:#fff;display:flex;align-items:center;justify-content:center;overflow:hidden;font-size:.55rem;font-weight:800;color:var(--primary);flex-shrink:0;}
.fd-logo img{width:100%;height:100%;object-fit:contain;padding:4px;}
.fd-al-name{font-family:var(--font-display);font-weight:700;font-size:.85rem;color:var(--navy);}
.fd-al-sub{font-size:.65rem;color:var(--gray);margin-top:2px;display:flex;align-items:center;gap:5px;}
.fd-route{flex:1;display:flex;align-items:center;min-width:0;}
.fd-ep{}
.fd-ep-r{text-align:right;}
.fd-time{font-family:var(--font-display);font-size:1.5rem;font-weight:700;color:var(--navy);line-height:1;}
.fd-iata{font-size:.8rem;font-weight:700;color:var(--primary);margin-top:3px;letter-spacing:.05em;}
.fd-apt{font-size:.63rem;color:var(--gray);margin-top:2px;}
.fd-ep-r .fd-apt{text-align:right;}
.fd-mid{flex:1;display:flex;flex-direction:column;align-items:center;gap:5px;padding:0 10px;}
.fd-line{display:flex;align-items:center;width:100%;gap:3px;}
.fd-dot{width:7px;height:7px;border-radius:50%;border:2px solid var(--primary);background:#fff;flex-shrink:0;}
.fd-dash{flex:1;height:2px;background:repeating-linear-gradient(90deg,var(--primary) 0,var(--primary) 4px,transparent 4px,transparent 9px);}
.fd-plane{color:var(--primary);font-size:.75rem;}
.fd-dur{background:var(--primary-light);color:var(--primary);font-size:.66rem;font-weight:700;padding:3px 10px;border-radius:100px;white-space:nowrap;}
.fd-stop{font-size:.64rem;font-weight:700;padding:3px 10px;border-radius:100px;}
.ns{background:#dcfce7;color:#14532d;}
.os{background:#fef9c3;color:#78350f;}
.ts{background:#fee2e2;color:#7f1d1d;}

/* Flight meta grid */
.flight-meta{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-top:16px;}
.fm-item{background:var(--bg);border:1px solid var(--border);border-radius:10px;padding:10px 12px;}
.fm-lbl{font-size:.6rem;font-weight:700;color:var(--gray);text-transform:uppercase;letter-spacing:.06em;}
.fm-val{font-size:.82rem;font-weight:700;color:var(--navy);margin-top:3px;}

/* ══════════════════════════════════════════
   PASSENGER TABLE
══════════════════════════════════════════ */
.pax-table{width:100%;border-collapse:collapse;}
.pax-table th{
  font-size:.66rem;font-weight:700;color:var(--gray);
  text-transform:uppercase;letter-spacing:.07em;
  padding:10px 14px;text-align:left;
  background:#f8fafc;border-bottom:1.5px solid var(--border);
}
.pax-table td{
  padding:12px 14px;font-size:.8rem;color:var(--navy);
  border-bottom:1px solid #f1f5f9;font-weight:500;
}
.pax-table tr:last-child td{border-bottom:none;}
.pax-table tr:hover td{background:#fafbff;}
.pax-type-badge{font-size:.6rem;font-weight:700;padding:2px 8px;border-radius:100px;text-transform:uppercase;letter-spacing:.06em;}
.adult-badge{background:var(--primary-pale);color:var(--primary);}
.child-badge{background:#fef9c3;color:#78350f;}
.gender-icon{font-size:.72rem;margin-right:4px;}

/* ══════════════════════════════════════════
   PRICE SUMMARY
══════════════════════════════════════════ */
.price-grid{display:grid;grid-template-columns:1fr auto;gap:7px 20px;align-items:center;}
.pg-lbl{font-size:.78rem;color:var(--slate);}
.pg-val{font-size:.82rem;font-weight:700;color:var(--navy);text-align:right;}
.pg-div{grid-column:1/-1;height:1px;background:var(--border);margin:4px 0;}
.pg-total-lbl{font-family:var(--font-display);font-size:.92rem;font-weight:700;color:var(--navy);}
.pg-total-val{font-family:var(--font-display);font-size:1.5rem;font-weight:700;color:var(--green-dark);text-align:right;}

/* ══════════════════════════════════════════
   INFO ROWS (sidebar)
══════════════════════════════════════════ */
.ir{display:flex;justify-content:space-between;align-items:center;padding:11px 22px;border-bottom:1px solid #f1f5f9;font-size:.78rem;}
.ir:last-child{border-bottom:none;}
.ir-lbl{color:var(--gray);font-weight:500;}
.ir-val{font-weight:700;color:var(--navy);}
.status-confirmed{background:var(--green-light);color:var(--green-dark);font-size:.68rem;font-weight:700;padding:3px 12px;border-radius:100px;}
.status-pending{background:#fef9c3;color:#78350f;font-size:.68rem;font-weight:700;padding:3px 12px;border-radius:100px;}
.status-cancelled{background:#fee2e2;color:#7f1d1d;font-size:.68rem;font-weight:700;padding:3px 12px;border-radius:100px;}

/* ══════════════════════════════════════════
   NOTICE BOX
══════════════════════════════════════════ */
.notice-box{
  display:flex;align-items:flex-start;gap:12px;
  background:#fefce8;border:1.5px solid #fde68a;
  border-radius:12px;padding:14px 18px;
  font-size:.76rem;color:#78350f;line-height:1.6;
  margin-bottom:20px;
}
.notice-box i{font-size:1rem;color:var(--amber);flex-shrink:0;margin-top:1px;}

/* ══════════════════════════════════════════
   ACTION BUTTONS
══════════════════════════════════════════ */
.cf-actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:6px;}
.btn-primary-cf{
  display:inline-flex;align-items:center;gap:8px;
  background:linear-gradient(135deg,var(--primary),var(--primary-dark));
  color:#fff;border:none;border-radius:12px;
  padding:13px 28px;font-family:var(--font-display);
  font-weight:700;font-size:.88rem;cursor:pointer;
  text-decoration:none;transition:transform .15s,box-shadow .15s;
}
.btn-primary-cf:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(37,99,235,.35);color:#fff;}
.btn-outline-cf{
  display:inline-flex;align-items:center;gap:8px;
  background:#fff;color:var(--navy);
  border:1.5px solid var(--border);border-radius:12px;
  padding:13px 24px;font-family:var(--font-display);
  font-weight:700;font-size:.88rem;cursor:pointer;
  text-decoration:none;transition:all .15s;
}
.btn-outline-cf:hover{border-color:var(--primary);color:var(--primary);background:var(--primary-light);}
.btn-red-cf{
  display:inline-flex;align-items:center;gap:8px;
  background:#fff;color:var(--red);
  border:1.5px solid #fecaca;border-radius:12px;
  padding:13px 24px;font-family:var(--font-display);
  font-weight:700;font-size:.88rem;cursor:pointer;
  text-decoration:none;transition:all .15s;
}
.btn-red-cf:hover{background:#fff5f5;border-color:var(--red);}

/* ══════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════ */
@media(max-width:991px){.cf-sidebar{position:static !important;}}
@media(max-width:768px){
  .flight-meta{grid-template-columns:repeat(2,1fr);}
  .cf-title{font-size:1.5rem;}
  .cf-actions{flex-direction:column;}
  .btn-primary-cf,.btn-outline-cf,.btn-red-cf{justify-content:center;}
}
@media(max-width:576px){
  .flight-meta{grid-template-columns:1fr 1fr;}
  .pax-table th:nth-child(3),.pax-table td:nth-child(3){display:none;}
}

/* ══════════════════════════════════════════
   CONFETTI
══════════════════════════════════════════ */
.confetti-wrap{position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:9999;overflow:hidden;}
.confetti-piece{
  position:absolute;top:-12px;
  width:10px;height:10px;
  border-radius:2px;
  animation:fall linear forwards;
}
@keyframes fall{
  0%{transform:translateY(0) rotate(0deg);opacity:1;}
  80%{opacity:1;}
  100%{transform:translateY(110vh) rotate(720deg);opacity:0;}
}

/* ══════════════════════════════════════════
   ██████  PRINT / PDF STYLES  ██████
   • Header hidden completely
   • No element breaks mid-page
   • Invoice-style clean layout
   • Page margins for clean borders
══════════════════════════════════════════ */
@media print{

  /* Hide EVERYTHING from the site that isn't our content */
  header, nav, footer,
  .navbar, .topbar, .site-header,
  #header, #footer, #navbar,
  .cf-hero,            /* hide the green hero banner too */
  .notice-box,
  .cf-actions,
  .confetti-wrap,
  .btn-primary-cf,
  .btn-outline-cf,
  .btn-red-cf          { display:none !important; }

  /* Page setup */
  @page{
    size:A4 portrait;
    margin:14mm 12mm 16mm 12mm;
  }

  html,body{
    background:#fff !important;
    color:#000 !important;
    font-family:'Plus Jakarta Sans',sans-serif !important;
    font-size:10pt;
  }

  /* Remove shadows and rounded corners for PDF cleanliness */
  .ticket-card{
    box-shadow:none !important;
    border:1.5px solid #cbd5e1 !important;
    border-radius:8px !important;
    margin-bottom:14px !important;
    /* Never break a card across pages */
    break-inside:avoid;
    page-break-inside:avoid;
  }

  /* Each major section stays whole */
  .ticket-card,
  .flight-meta,
  .pax-table,
  .price-grid,
  .info-rows,
  .fd-row,
  .fm-item,
  tr            {
    break-inside:avoid !important;
    page-break-inside:avoid !important;
  }

  /* Force sidebar to stack under main on print */
  .col-lg-8, .col-lg-4{
    width:100% !important;
    flex:0 0 100% !important;
    max-width:100% !important;
  }
  .row{ display:block !important; }
  .cf-sidebar{ position:static !important; }
  .cf-wrap{ padding:0 !important; }

  /* Add a clean print-only header at the top of the document */
  .print-invoice-header{
    display:flex !important;
    justify-content:space-between;
    align-items:flex-start;
    padding-bottom:12px;
    margin-bottom:18px;
    border-bottom:2px solid #0f172a;
  }
  .pih-brand{font-family:'Space Grotesk',sans-serif;font-size:15pt;font-weight:700;color:#0f172a;}
  .pih-brand span{color:#2563eb;}
  .pih-meta{text-align:right;font-size:8pt;color:#475569;line-height:1.7;}
  .pih-meta strong{color:#0f172a;font-size:9pt;}
  .pih-title{font-family:'Space Grotesk',sans-serif;font-size:13pt;font-weight:700;color:#16a34a;margin-top:4px;}

  /* Restore color backgrounds for headers */
  .tc-head.dep{background:#eff6ff !important;-webkit-print-color-adjust:exact;print-color-adjust:exact;}
  .tc-head.ret{background:#f0fdf4 !important;-webkit-print-color-adjust:exact;print-color-adjust:exact;}
  .tc-head.pax{background:#fefce8 !important;-webkit-print-color-adjust:exact;print-color-adjust:exact;}
  .tc-head.info{background:#0f172a !important;-webkit-print-color-adjust:exact;print-color-adjust:exact;}
  .tc-head[style*="fefce8"]{background:#fefce8 !important;-webkit-print-color-adjust:exact;print-color-adjust:exact;}

  /* Adjust font sizes slightly for paper */
  .fd-time{font-size:14pt !important;}
  .tc-htitle{font-size:9pt !important;}
  .tc-hsub{font-size:7pt !important;}
  .fm-val{font-size:8pt !important;}
  .pg-total-val{font-size:14pt !important;}
  .pax-table th, .pax-table td{font-size:8pt !important;padding:8px 12px !important;}
  .ir{font-size:8pt !important;padding:9px 18px !important;}

  /* Row stripes in table for readability */
  .pax-table tr:nth-child(even) td{background:#f8fafc !important;-webkit-print-color-adjust:exact;print-color-adjust:exact;}

  /* Flight meta on 4 cols print */
  .flight-meta{grid-template-columns:repeat(4,1fr) !important;}

  /* Contact footer */
  .contact-footer{padding:12px 16px !important;background:#f8fafc !important;-webkit-print-color-adjust:exact;print-color-adjust:exact;}

  /* Price card pull colour */
  .pg-total-val{color:#14532d !important;-webkit-print-color-adjust:exact;print-color-adjust:exact;}

  /* Trust badges hidden in print */
  .trust-badges{display:none !important;}

  /* Footer stamp at bottom */
  .print-invoice-footer{
    display:block !important;
    margin-top:20px;
    padding-top:10px;
    border-top:1px solid #e2e8f0;
    font-size:7.5pt;
    color:#64748b;
    text-align:center;
  }

}

/* Hide print-only elements on screen */
.print-invoice-header,
.print-invoice-footer{ display:none; }

</style>

{{-- ── DATA PREP ── --}}
@php
  $isRound     = $booking->trip_type === 'round';
  $passengers  = $booking->passengers ?? [];
  $adults      = (int) $booking->adults;
  $children    = (int) $booking->children;
  $totalPax    = $adults + $children;
  $departFlight = $booking->departFlight;
  $returnFlight = $booking->returnFlight;
  $departClass  = $booking->departClass;
  $returnClass  = $booking->returnClass;

  $dDep = \Carbon\Carbon::parse($departFlight->departure_time);
  $dArr = \Carbon\Carbon::parse($departFlight->arrival_time);
  $dON  = (int)($departFlight->overnight_arrival ?? 0);
  if ($dON) { $dArr->addDay(); } elseif ($dArr->lessThan($dDep)) { $dArr->addDay(); }
  $dDiff    = $dDep->diff($dArr);
  $dSc      = (int)$departFlight->stops;
  $dStopLbl = $dSc === 0 ? 'Non-stop' : ($dSc === 1 ? '1 Stop' : $dSc . ' Stops');
  $dStopCls = $dSc === 0 ? 'ns' : ($dSc === 1 ? 'os' : 'ts');

  if ($isRound && $returnFlight) {
    $rDep = \Carbon\Carbon::parse($returnFlight->departure_time);
    $rArr = \Carbon\Carbon::parse($returnFlight->arrival_time);
    $rON  = (int)($returnFlight->overnight_arrival ?? 0);
    if ($rON) { $rArr->addDay(); } elseif ($rArr->lessThan($rDep)) { $rArr->addDay(); }
    $rDiff    = $rDep->diff($rArr);
    $rSc      = (int)$returnFlight->stops;
    $rStopLbl = $rSc === 0 ? 'Non-stop' : ($rSc === 1 ? '1 Stop' : $rSc . ' Stops');
    $rStopCls = $rSc === 0 ? 'ns' : ($rSc === 1 ? 'os' : 'ts');
  }

  $dPrice = $departClass?->base_price ?? 0;
  $dTax   = $departClass?->tax ?? 0;
  $rPrice = ($isRound && $returnClass) ? ($returnClass->base_price ?? 0) : 0;
  $rTax   = ($isRound && $returnClass) ? ($returnClass->tax ?? 0) : 0;

  $statusClass = match($booking->status) {
    'confirmed' => 'status-confirmed',
    'cancelled'  => 'status-cancelled',
    default      => 'status-pending',
  };
@endphp

{{-- ══ PRINT-ONLY INVOICE HEADER (hidden on screen) ══ --}}
<div class="print-invoice-header">
  <div>
    <div class="pih-brand">✈ Flight<span>Book</span></div>
    <div class="pih-title">Booking Confirmation</div>
  </div>
  <div class="pih-meta">
    <div><strong>Reference: {{ $booking->booking_reference }}</strong></div>
    <div>Booked: {{ $booking->created_at->format('d M Y, H:i') }}</div>
    <div>Status: {{ ucfirst($booking->status) }}</div>
    <div>{{ $booking->contact_email }}</div>
  </div>
</div>

{{-- ══ CONFETTI ══ --}}
<div class="confetti-wrap" id="confettiWrap"></div>

{{-- ══ HERO (screen only) ══ --}}
<div class="cf-hero">
  <div class="container-xl">
    <div class="cf-hero-inner">
      <div class="cf-check-wrap">
        <i class="fa-solid fa-check"></i>
      </div>
      <div class="cf-title">Booking Confirmed!</div>
      <div class="cf-subtitle">
        Your booking is {{ $booking->status }}. A confirmation has been sent to {{ $booking->contact_email }}.
      </div>
      <div class="cf-ref-pill">
        <div>
          <div class="cf-ref-lbl">Booking Reference</div>
          <div class="cf-ref-val" id="bookingRef">{{ $booking->booking_reference }}</div>
        </div>
        <button class="cf-ref-copy" onclick="copyRef()" id="copyBtn">
          <i class="fa-solid fa-copy"></i> Copy
        </button>
      </div>
      <div class="cf-steps-bar">
        <div class="cf-step done"><div class="cf-snum"><i class="fa-solid fa-check" style="font-size:.44rem;"></i></div>Search</div>
        <div class="cf-sdiv"></div>
        <div class="cf-step done"><div class="cf-snum"><i class="fa-solid fa-check" style="font-size:.44rem;"></i></div>Select</div>
        <div class="cf-sdiv"></div>
        <div class="cf-step done"><div class="cf-snum"><i class="fa-solid fa-check" style="font-size:.44rem;"></i></div>Review</div>
        <div class="cf-sdiv"></div>
        <div class="cf-step active"><div class="cf-snum"><i class="fa-solid fa-check" style="font-size:.44rem;"></i></div>Booked</div>
      </div>
    </div>
  </div>
</div>

{{-- ══ MAIN CONTENT ══ --}}
<div class="cf-wrap">
<div class="container-xl">
<div class="row g-4">

  {{-- ── LEFT COLUMN ── --}}
  <div class="col-lg-8">

    {{-- Notice (screen only) --}}
    <div class="notice-box">
      <i class="fa-solid fa-circle-info"></i>
      <div>
        <strong>Free cancellation window:</strong> You may cancel this booking within 24 hours at no extra charge.
        After that, the airline's standard cancellation policy applies.
      </div>
    </div>

    {{-- ── OUTBOUND FLIGHT ── --}}
    <div class="ticket-card">
      <div class="tc-head dep">
        <div class="tc-hicon blue"><i class="fa-solid fa-plane-departure"></i></div>
        <div>
          <div class="tc-htitle">{{ $isRound ? 'Outbound Flight' : 'Your Flight' }}</div>
          <div class="tc-hsub dark">{{ \Carbon\Carbon::parse($booking->depart_date)->format('l, d M Y') }}</div>
        </div>
        <span class="tc-badge" style="background:var(--primary);">{{ $booking->class }}</span>
      </div>
      <div class="ticket-body">

        <div class="fd-row">
          {{-- Airline --}}
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
                <span style="font-weight:600;color:var(--slate);">{{ $departFlight->flight_number }}</span>
                @if($departFlight->aircraft_type)
                  <span style="background:#f1f5f9;border:1px solid var(--border);padding:1px 6px;border-radius:4px;font-size:.58rem;font-weight:700;">{{ $departFlight->aircraft_type }}</span>
                @endif
              </div>
            </div>
          </div>
          {{-- Route --}}
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
              <span class="fd-stop {{ $dStopCls }}">{{ $dStopLbl }}</span>
            </div>
            <div class="fd-ep fd-ep-r">
              <div class="fd-time">{{ $dArr->format('H:i') }}@if($dON)<sup style="font-size:.52rem;color:#f97316;vertical-align:super;">+1</sup>@endif</div>
              <div class="fd-iata">{{ $departFlight->to_airport_code }}</div>
              <div class="fd-apt">{{ $departFlight->to_airport_code }}</div>
            </div>
          </div>
        </div>

        <div class="ticket-divider">
          <div class="td-circle"></div>
          <div class="td-dashes"></div>
          <div class="td-circle"></div>
        </div>

        <div class="flight-meta">
          <div class="fm-item">
            <div class="fm-lbl"><i class="fa-solid fa-briefcase" style="color:var(--primary);"></i> Cabin Bag</div>
            <div class="fm-val">{{ $departClass->cabin_baggage_kg ?? 7 }}kg</div>
          </div>
          <div class="fm-item">
            <div class="fm-lbl"><i class="fa-solid fa-suitcase-rolling" style="color:var(--primary);"></i> Check-in</div>
            <div class="fm-val">{{ $departClass->checkin_baggage_kg ?? 23 }}kg</div>
          </div>
          <div class="fm-item">
            <div class="fm-lbl"><i class="fa-solid fa-rotate-left" style="color:var(--primary);"></i> Refund</div>
            <div class="fm-val" style="font-size:.75rem;">{{ $departClass->is_refundable != 0 ? 'Refundable' : 'Non-refundable' }}</div>
          </div>
          <div class="fm-item">
            <div class="fm-lbl"><i class="fa-solid fa-star" style="color:var(--amber);"></i> Class</div>
            <div class="fm-val" style="color:var(--primary);">{{ $departClass->class_type }}</div>
          </div>
        </div>
      </div>
    </div>

    {{-- ── RETURN FLIGHT ── --}}
    @if($isRound && $returnFlight)
    <div class="ticket-card">
      <div class="tc-head ret">
        <div class="tc-hicon green"><i class="fa-solid fa-plane-arrival"></i></div>
        <div>
          <div class="tc-htitle">Return Flight</div>
          <div class="tc-hsub dark">{{ \Carbon\Carbon::parse($booking->return_date)->format('l, d M Y') }}</div>
        </div>
        <span class="tc-badge" style="background:var(--green);">{{ $booking->class }}</span>
      </div>
      <div class="ticket-body">
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
                <span style="font-weight:600;color:var(--slate);">{{ $returnFlight->flight_number }}</span>
                @if($returnFlight->aircraft_type)
                  <span style="background:#f1f5f9;border:1px solid var(--border);padding:1px 6px;border-radius:4px;font-size:.58rem;font-weight:700;">{{ $returnFlight->aircraft_type }}</span>
                @endif
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
              <span class="fd-stop {{ $rStopCls }}">{{ $rStopLbl }}</span>
            </div>
            <div class="fd-ep fd-ep-r">
              <div class="fd-time">{{ $rArr->format('H:i') }}@if($rON)<sup style="font-size:.52rem;color:#f97316;vertical-align:super;">+1</sup>@endif</div>
              <div class="fd-iata">{{ $returnFlight->to_airport_code }}</div>
              <div class="fd-apt">{{ $returnFlight->to_airport_code }}</div>
            </div>
          </div>
        </div>

        <div class="ticket-divider">
          <div class="td-circle"></div>
          <div class="td-dashes"></div>
          <div class="td-circle"></div>
        </div>

        <div class="flight-meta">
          <div class="fm-item">
            <div class="fm-lbl"><i class="fa-solid fa-briefcase" style="color:var(--green);"></i> Cabin Bag</div>
            <div class="fm-val">{{ $returnClass->cabin_baggage_kg ?? 7 }}kg</div>
          </div>
          <div class="fm-item">
            <div class="fm-lbl"><i class="fa-solid fa-suitcase-rolling" style="color:var(--green);"></i> Check-in</div>
            <div class="fm-val">{{ $returnClass->checkin_baggage_kg ?? 23 }}kg</div>
          </div>
          <div class="fm-item">
            <div class="fm-lbl"><i class="fa-solid fa-rotate-left" style="color:var(--green);"></i> Refund</div>
            <div class="fm-val" style="font-size:.75rem;">{{ $returnClass->is_refundable != 0 ? 'Refundable' : 'Non-refundable' }}</div>
          </div>
          <div class="fm-item">
            <div class="fm-lbl"><i class="fa-solid fa-star" style="color:var(--amber);"></i> Class</div>
            <div class="fm-val" style="color:var(--green);">{{ $returnClass->class_type }}</div>
          </div>
        </div>
      </div>
    </div>
    @endif

    {{-- ── PASSENGERS ── --}}
    <div class="ticket-card">
      <div class="tc-head pax">
        <div class="tc-hicon amber"><i class="fa-solid fa-users"></i></div>
        <div>
          <div class="tc-htitle">Passengers</div>
          <div class="tc-hsub dark">{{ $totalPax }} traveller{{ $totalPax > 1 ? 's' : '' }} on this booking</div>
        </div>
        <span class="tc-badge" style="background:var(--amber);">
          {{ $adults }} Adult{{ $adults > 1 ? 's' : '' }}@if($children) · {{ $children }} Child{{ $children > 1 ? 'ren' : '' }}@endif
        </span>
      </div>
      <div style="overflow-x:auto;">
        <table class="pax-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Full Name</th>
              <th>Gender</th>
              <th>Type</th>
              @if($children)<th>Date of Birth</th>@endif
            </tr>
          </thead>
          <tbody>
            @foreach($passengers as $index => $pax)
            <tr>
              <td style="color:var(--gray);font-weight:700;">{{ $index + 1 }}</td>
              <td><span style="font-weight:700;">{{ $pax['first_name'] }} {{ $pax['last_name'] }}</span></td>
              <td>
                @if($pax['gender'] === 'male')
                  <i class="fa-solid fa-mars gender-icon" style="color:#3b82f6;"></i>Male
                @elseif($pax['gender'] === 'female')
                  <i class="fa-solid fa-venus gender-icon" style="color:#ec4899;"></i>Female
                @else
                  <i class="fa-solid fa-genderless gender-icon" style="color:var(--gray);"></i>Other
                @endif
              </td>
              <td>
                <span class="pax-type-badge {{ $pax['type'] === 'adult' ? 'adult-badge' : 'child-badge' }}">
                  {{ ucfirst($pax['type']) }}
                </span>
              </td>
              @if($children)
              <td>{{ isset($pax['dob']) ? \Carbon\Carbon::parse($pax['dob'])->format('d M Y') : '—' }}</td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="contact-footer" style="display:flex;gap:20px;flex-wrap:wrap;padding:14px 20px;background:#f8fafc;border-top:1.5px solid var(--border);">
        <div style="display:flex;align-items:center;gap:8px;font-size:.76rem;">
          <i class="fa-solid fa-envelope" style="color:var(--primary);"></i>
          <span style="color:var(--gray);">Contact:</span>
          <strong>{{ $booking->contact_email }}</strong>
        </div>
        <div style="display:flex;align-items:center;gap:8px;font-size:.76rem;">
          <i class="fa-solid fa-phone" style="color:var(--primary);"></i>
          <strong>{{ $booking->contact_phone }}</strong>
        </div>
      </div>
    </div>

    {{-- ── ACTION BUTTONS (screen only) ── --}}
    <div class="cf-actions">
      <a href="{{ route('flight.search') }}" class="btn-primary-cf">
        <i class="fa-solid fa-magnifying-glass"></i> Search More Flights
      </a>
      <button onclick="window.print()" class="btn-outline-cf">
        <i class="fa-solid fa-print"></i> Print / Save PDF
      </button>
      @if($booking->isCancellable())
      <a href="#" class="btn-red-cf"
         onclick="return confirm('Are you sure you want to cancel this booking?')">
        <i class="fa-solid fa-xmark"></i> Cancel Booking
      </a>
      @endif
    </div>

  </div>{{-- col-lg-8 --}}

  {{-- ── RIGHT SIDEBAR ── --}}
  <div class="col-lg-4">
    <div class="cf-sidebar" style="position:sticky;top:18px;display:flex;flex-direction:column;gap:16px;">

      {{-- Booking Status --}}
      <div class="ticket-card">
        <div class="tc-head info">
          <div class="tc-hicon white"><i class="fa-solid fa-circle-info"></i></div>
          <div>
            <div class="tc-htitle light">Booking Info</div>
            <div class="tc-hsub light">Your trip summary</div>
          </div>
        </div>
        <div class="info-rows">
          <div class="ir">
            <span class="ir-lbl">Status</span>
            <span class="{{ $statusClass }}">{{ ucfirst($booking->status) }}</span>
          </div>
          <div class="ir">
            <span class="ir-lbl">Reference</span>
            <span class="ir-val" style="font-family:var(--font-display);letter-spacing:.05em;">{{ $booking->booking_reference }}</span>
          </div>
          <div class="ir">
            <span class="ir-lbl">Trip Type</span>
            <span class="ir-val">{{ $isRound ? 'Round Trip' : 'One Way' }}</span>
          </div>
          <div class="ir">
            <span class="ir-lbl">Route</span>
            <span class="ir-val">{{ $departFlight->from_airport_code }} → {{ $departFlight->to_airport_code }}@if($isRound && $returnFlight) · {{ $returnFlight->from_airport_code }} → {{ $returnFlight->to_airport_code }}@endif</span>
          </div>
          <div class="ir">
            <span class="ir-lbl">Depart</span>
            <span class="ir-val">{{ \Carbon\Carbon::parse($booking->depart_date)->format('d M Y') }}</span>
          </div>
          @if($isRound && $booking->return_date)
          <div class="ir">
            <span class="ir-lbl">Return</span>
            <span class="ir-val">{{ \Carbon\Carbon::parse($booking->return_date)->format('d M Y') }}</span>
          </div>
          @endif
          <div class="ir">
            <span class="ir-lbl">Class</span>
            <span class="ir-val" style="color:var(--primary);">{{ $booking->class }}</span>
          </div>
          <div class="ir">
            <span class="ir-lbl">Booked On</span>
            <span class="ir-val">{{ $booking->created_at->format('d M Y, H:i') }}</span>
          </div>
        </div>
      </div>

      {{-- Price Summary --}}
      <div class="ticket-card">
        <div class="tc-head" style="background:linear-gradient(90deg,#fefce8,#fef3c7);">
          <div class="tc-hicon amber"><i class="fa-solid fa-receipt"></i></div>
          <div>
            <div class="tc-htitle">Price Summary</div>
            <div class="tc-hsub dark">{{ $totalPax }} traveller{{ $totalPax > 1 ? 's' : '' }}</div>
          </div>
        </div>
        <div class="ticket-body">
          <div class="price-grid">
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
            <div class="pg-total-lbl">Total Paid</div>
            <div class="pg-total-val"><span style="font-size:.82rem;font-weight:500;vertical-align:super;">$</span>{{ number_format($booking->grand_total) }}</div>
          </div>
        </div>
      </div>

      {{-- Trust badges (screen only) --}}
      <div class="trust-badges" style="display:flex;flex-direction:column;gap:9px;padding:0 4px;">
        <div style="display:flex;align-items:center;gap:9px;font-size:.74rem;color:var(--slate);font-weight:500;">
          <i class="fa-solid fa-lock" style="color:var(--green);width:16px;text-align:center;"></i> SSL secured &amp; encrypted
        </div>
        <div style="display:flex;align-items:center;gap:9px;font-size:.74rem;color:var(--slate);font-weight:500;">
          <i class="fa-solid fa-shield-halved" style="color:var(--green);width:16px;text-align:center;"></i> No hidden fees
        </div>
        <div style="display:flex;align-items:center;gap:9px;font-size:.74rem;color:var(--slate);font-weight:500;">
          <i class="fa-solid fa-headset" style="color:var(--primary);width:16px;text-align:center;"></i> 24/7 support available
        </div>
        <div style="display:flex;align-items:center;gap:9px;font-size:.74rem;color:var(--slate);font-weight:500;">
          <i class="fa-solid fa-clock-rotate-left" style="color:var(--amber);width:16px;text-align:center;"></i> Free cancellation within 24h
        </div>
      </div>

    </div>
  </div>{{-- col-lg-4 --}}

</div>{{-- row --}}
</div>{{-- container --}}
</div>{{-- cf-wrap --}}

{{-- ══ PRINT-ONLY FOOTER STAMP ══ --}}
<div class="print-invoice-footer">
  This is a computer-generated confirmation and does not require a signature. &nbsp;|&nbsp;
  For support contact us at support@flightbook.com &nbsp;|&nbsp;
  Printed on {{ now()->format('d M Y, H:i') }}
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ── Confetti burst ──
(function(){
  const colors=['#2563eb','#16a34a','#f59e0b','#ec4899','#06b6d4','#8b5cf6','#f97316'];
  const wrap=document.getElementById('confettiWrap');
  for(let i=0;i<80;i++){
    const p=document.createElement('div');
    p.className='confetti-piece';
    const size=Math.random()*8+6;
    p.style.cssText=[
      `left:${Math.random()*100}%`,
      `width:${size}px`,
      `height:${size}px`,
      `background:${colors[Math.floor(Math.random()*colors.length)]}`,
      `border-radius:${Math.random()>.5?'50%':'2px'}`,
      `animation-duration:${Math.random()*2.5+1.5}s`,
      `animation-delay:${Math.random()*.8}s`,
    ].join(';');
    wrap.appendChild(p);
  }
  setTimeout(()=>wrap.remove(),4000);
})();

// ── Copy reference ──
function copyRef(){
  const ref=document.getElementById('bookingRef').textContent.trim();
  navigator.clipboard.writeText(ref).then(()=>{
    const btn=document.getElementById('copyBtn');
    btn.innerHTML='<i class="fa-solid fa-check"></i> Copied!';
    btn.style.background='rgba(22,163,74,.4)';
    setTimeout(()=>{
      btn.innerHTML='<i class="fa-solid fa-copy"></i> Copy';
      btn.style.background='';
    },2000);
  });
}
</script>

@endsection