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
  --orange:#ea580c;--orange-light:#ffedd5;
  --r8:8px;--r12:12px;--r16:16px;
  --sh:0 4px 24px rgba(0,0,0,.08),0 1px 4px rgba(0,0,0,.04);
  --sh-lg:0 20px 60px rgba(0,0,0,.14),0 8px 24px rgba(0,0,0,.07);
  --font-main:'Outfit',sans-serif;
  --font-display:'Sora',sans-serif;
}
body,html{font-family:var(--font-main);background:var(--bg);color:var(--navy);}

/* ════════════════════════════════════════
   HERO SEARCH — same as homepage (flights only)
════════════════════════════════════════ */
.hero-search-section{
  background:linear-gradient(135deg,var(--navy) 0%,#1e3a8a 55%,#1d4ed8 100%);
  padding:28px 0 36px;
  position:sticky;top:0;z-index:200;
  box-shadow:0 4px 28px rgba(0,0,0,.25);
}
.search-box{
  width:100%;
  background:rgba(255,255,255,.97);
  backdrop-filter:blur(20px);
  border-radius:24px;
  box-shadow:0 32px 80px rgba(0,0,0,.28),0 8px 20px rgba(29,78,216,.12);
  overflow:visible;
}
.sb-tabs{display:flex;border-bottom:1px solid var(--border);padding:0 8px;gap:2px;border-radius:24px 24px 0 0;overflow:hidden;}
.sb-tab{flex:1;display:flex;flex-direction:column;align-items:center;gap:5px;padding:14px 10px 12px;cursor:pointer;border:none;background:transparent;font-family:var(--font-main);font-size:13px;font-weight:600;color:var(--gray);border-bottom:3px solid transparent;transition:color .2s,border-color .2s;white-space:nowrap;}
.sb-tab .tab-icon{width:38px;height:38px;border-radius:12px;background:#F0F4FF;display:flex;align-items:center;justify-content:center;font-size:18px;transition:background .2s,transform .2s;}
.sb-tab:hover .tab-icon{background:#dce8ff;transform:scale(1.08);}
.sb-tab.active{color:var(--primary);border-bottom-color:var(--primary);}
.sb-tab.active .tab-icon{background:var(--primary-light);}
.sb-panel{padding:20px 24px 22px;}

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

/* ── AUTOCOMPLETE ── */
.autocomplete-dropdown{
  position:absolute;top:calc(100% + 6px);left:0;width:100%;
  background:#fff;border:1.5px solid #bfdbfe;border-radius:14px;
  box-shadow:0 12px 40px rgba(0,0,0,.12),0 4px 12px rgba(29,78,216,.08);
  max-height:280px;overflow-y:auto;z-index:9999;
  padding:6px;display:flex;flex-direction:column;gap:2px;
}
.autocomplete-item{padding:8px 10px;border-radius:10px;cursor:pointer;transition:background .12s;}
.autocomplete-item:hover,.autocomplete-item.hovered{background:#eff6ff;}
.autocomplete-item.no-result{color:#94a3b8;cursor:default;font-size:.82rem;}
.ac-inner{display:flex;align-items:center;gap:10px;}
.ac-code-box{min-width:46px;height:46px;background:#eff6ff;border:1.5px solid #bfdbfe;border-radius:10px;display:flex;align-items:center;justify-content:center;font-family:'Sora',sans-serif;font-size:.72rem;font-weight:800;color:#1d4ed8;letter-spacing:.04em;flex-shrink:0;}
.ac-detail-name{font-weight:700;font-size:.84rem;color:#0f172a;line-height:1.25;}
.ac-detail-city{font-size:.72rem;color:#64748b;margin-top:2px;display:flex;align-items:center;gap:4px;}

/* ════════════════════════════════════════
   MAIN LAYOUT
════════════════════════════════════════ */
.main-wrap{padding:28px 0 60px;}

/* ════════════════════════════════════════
   SIDEBAR
════════════════════════════════════════ */
.sidebar{background:#fff;border-radius:var(--r16);border:1.5px solid var(--border);overflow:hidden;position:sticky;top:180px;}
.sbf-head{background:var(--navy);padding:13px 16px;display:flex;align-items:center;gap:8px;}
.sbf-head span{font-family:var(--font-display);font-weight:700;font-size:.78rem;color:#fff;letter-spacing:.07em;text-transform:uppercase;}
.sbf-body{padding:16px;}
.sbf-sec{margin-bottom:18px;padding-bottom:18px;border-bottom:1px solid var(--border);}
.sbf-sec:last-child{margin-bottom:0;padding-bottom:0;border-bottom:none;}
.sbf-lbl{font-size:.62rem;font-weight:800;color:var(--gray);text-transform:uppercase;letter-spacing:.1em;margin-bottom:9px;display:block;}

/* Stops */
.stop-pills{display:flex;flex-direction:column;gap:4px;}
.stop-pill{display:flex;align-items:center;justify-content:space-between;padding:8px 11px;border-radius:var(--r8);border:2px solid var(--border);background:#fff;cursor:pointer;transition:all .14s;font-size:.8rem;font-weight:600;color:var(--slate);}
.stop-pill:hover{border-color:var(--primary);background:var(--primary-light);}
.stop-pill.active{border-color:var(--primary);background:var(--primary-light);color:var(--primary-dark);}
.sp-l{display:flex;align-items:center;gap:7px;}
.sp-dot{width:7px;height:7px;border-radius:50%;background:#cbd5e1;flex-shrink:0;transition:background .14s;}
.stop-pill.active .sp-dot{background:var(--primary);}
.sp-n{font-size:.65rem;font-weight:700;background:#f1f5f9;padding:2px 7px;border-radius:100px;color:var(--gray);}
.stop-pill.active .sp-n{background:var(--primary-pale);color:var(--primary-mid);}

/* Price range — dual handle */
.price-range-wrap{margin-top:4px;}
.dual-range{position:relative;height:36px;display:flex;align-items:center;}
.dual-range input[type=range]{position:absolute;width:100%;-webkit-appearance:none;appearance:none;height:4px;background:transparent;outline:none;pointer-events:none;}
.dual-range input[type=range]::-webkit-slider-thumb{-webkit-appearance:none;width:17px;height:17px;border-radius:50%;background:#fff;border:3px solid var(--primary);cursor:pointer;pointer-events:all;box-shadow:0 2px 8px rgba(29,78,216,.28);}
.dual-range input[type=range]::-moz-range-thumb{width:17px;height:17px;border-radius:50%;background:#fff;border:3px solid var(--primary);cursor:pointer;pointer-events:all;box-shadow:0 2px 8px rgba(29,78,216,.28);}
.range-track{position:absolute;left:0;right:0;height:4px;border-radius:100px;background:#e2e8f0;z-index:0;}
.range-fill{position:absolute;height:4px;border-radius:100px;background:var(--primary);z-index:1;}
.price-disp-row{display:flex;justify-content:space-between;align-items:center;margin-top:8px;gap:6px;}
.price-disp-box{flex:1;background:#f8fafc;border:1.5px solid var(--border);border-radius:8px;padding:5px 8px;text-align:center;}
.price-disp-box .pdl{font-size:.58rem;font-weight:800;color:var(--gray);text-transform:uppercase;letter-spacing:.08em;display:block;}
.price-disp-box .pdv{font-size:.82rem;font-weight:800;color:var(--primary-dark);}
.price-sep{font-size:.8rem;color:var(--gray);flex-shrink:0;}

/* Airlines */
.al-list{display:flex;flex-direction:column;gap:6px;}
.al-item{display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.8rem;font-weight:500;color:var(--slate);}
.al-item input{width:14px;height:14px;accent-color:var(--primary);cursor:pointer;}

.btn-reset-f{width:100%;background:#f8fafc;border:1.5px solid var(--border);border-radius:var(--r8);padding:8px;font-size:.74rem;font-weight:700;color:var(--gray);cursor:pointer;transition:all .14s;font-family:var(--font-main);display:flex;align-items:center;justify-content:center;gap:5px;margin-top:10px;}
.btn-reset-f:hover{background:var(--navy);color:#fff;border-color:var(--navy);}

/* ════════════════════════════════════════
   RESULTS HEADER
════════════════════════════════════════ */
.res-hdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:10px;}
.res-count{font-family:var(--font-display);font-size:.9rem;font-weight:700;color:var(--navy);}
.res-count .n{color:var(--primary);font-size:1.05rem;}
.sort-grp{display:flex;align-items:center;gap:6px;}
.sort-lbl{font-size:.74rem;color:var(--gray);font-weight:600;}
.sort-sel{border:2px solid var(--border);border-radius:var(--r8);padding:6px 10px;font-size:.78rem;background:#fff;font-family:var(--font-main);cursor:pointer;color:var(--navy);font-weight:600;outline:none;}
.sort-sel:focus{border-color:var(--primary);}

/* ════════════════════════════════════════
   FLIGHT CARD — homepage style
════════════════════════════════════════ */
.fcard-link{display:block;text-decoration:none;color:inherit;}
.fcard{background:#fff;border-radius:var(--r16);border:2px solid var(--border);overflow:hidden;transition:transform .2s,box-shadow .2s,border-color .2s;}
.fcard-link:hover .fcard{transform:translateY(-4px);box-shadow:0 20px 56px rgba(29,78,216,.12),0 4px 16px rgba(0,0,0,.07);border-color:#bfdbfe;}

/* card top */
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

/* route */
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

/* footer */
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

/* empty */
.empty-box{text-align:center;padding:64px 20px;background:#fff;border-radius:var(--r16);border:2px dashed var(--border);}
.e-icon{width:64px;height:64px;border-radius:50%;background:var(--primary-light);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;}
.e-icon i{font-size:1.6rem;color:var(--primary);}
.empty-box h5{font-family:var(--font-display);font-weight:800;color:var(--navy);margin-bottom:6px;}
.empty-box p{color:var(--gray);font-size:.88rem;}

/* ════════════════════════════════════════
   RESPONSIVE
════════════════════════════════════════ */
@media(max-width:991px){
  .sidebar{position:static;margin-bottom:18px;top:auto;}
}
@media(max-width:768px){
  .sb-swap{display:none;}
  .sb-search-btn{width:100%;justify-content:center;}
  .ep-time{font-size:1.2rem;}
  .fp-price{font-size:1.3rem;}
  .fp-divider{display:none;}
  .fcard-footer{flex-direction:column;align-items:stretch;}
  .fp-right{flex-direction:row;align-items:center;justify-content:space-between;}
}
@media(max-width:576px){
  .sb-panel{padding:16px;}
  .sb-fields{flex-direction:column;}
}
</style>

{{-- ════════════════════════════════════════
     HERO SEARCH BAR — Flights Only (homepage style)
════════════════════════════════════════ --}}
<div class="hero-search-section">
  <div class="container-xl">
    <div class="search-box">

      {{-- Flights panel --}}
      <div class="sb-panel">
        <div class="trip-tabs-inner">
          <button class="trip-tab-inner {{ request('trip','one-way') === 'one-way' ? 'active' : '' }}"
                  onclick="setTrip(this,'one-way')">
            <i class="fa-solid fa-arrow-right"></i>One Way
          </button>
          <button class="trip-tab-inner {{ request('trip') === 'round' ? 'active' : '' }}"
                  onclick="setTrip(this,'round')">
            <i class="fa-solid fa-arrows-left-right"></i>Round Trip
          </button>
        </div>

        <form method="GET" action="{{ route('flight.search') }}" id="flightSearchForm">
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

            {{-- RETURN --}}
            <div class="sb-field" id="hfReturnWrap"
                 style="{{ request('trip') === 'round' ? '' : 'display:none;' }}">
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
                <div class="tcc-note">Age at time of travel must be valid for the booked category.</div>
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

    </div>{{-- /search-box --}}
  </div>
</div>

{{-- ════════════════════════════════════════
     MAIN CONTENT
════════════════════════════════════════ --}}
<div class="main-wrap">
<div class="container-xl">
<div class="row g-4">

  {{-- ════ SIDEBAR ════ --}}
  <div class="col-lg-3">
  <div class="sidebar">
    <div class="sbf-head">
      <i class="fa-solid fa-sliders" style="color:#93c5fd;font-size:.78rem;"></i>
      <span>Filter Results</span>
    </div>
    <div class="sbf-body">

      {{-- Stops --}}
      <div class="sbf-sec">
        <span class="sbf-lbl">Stops</span>
        <div class="stop-pills">
          <div class="stop-pill active" onclick="fStop(this,'all')">
            <div class="sp-l"><div class="sp-dot"></div>All Flights</div>
            <span class="sp-n" id="cnt-all">{{ isset($flights) ? $flights->count() : 0 }}</span>
          </div>
          <div class="stop-pill" onclick="fStop(this,'nonstop')">
            <div class="sp-l"><div class="sp-dot"></div>Non-stop</div>
            <span class="sp-n" id="cnt-ns">{{ isset($flights) ? $flights->filter(fn($f)=>$f->stops==0)->count() : 0 }}</span>
          </div>
          <div class="stop-pill" onclick="fStop(this,'1stop')">
            <div class="sp-l"><div class="sp-dot"></div>1 Stop</div>
            <span class="sp-n" id="cnt-1s">{{ isset($flights) ? $flights->filter(fn($f)=>$f->stops==1)->count() : 0 }}</span>
          </div>
          <div class="stop-pill" onclick="fStop(this,'2stop')">
            <div class="sp-l"><div class="sp-dot"></div>2+ Stops</div>
            <span class="sp-n" id="cnt-2s">{{ isset($flights) ? $flights->filter(fn($f)=>$f->stops>=2)->count() : 0 }}</span>
          </div>
        </div>
      </div>

      {{-- Price Range (Min–Max dual slider) --}}
      @php
        $allPrices = isset($flights)
          ? $flights->flatMap->flightClasses->pluck('total_price')->filter()->values()
          : collect();
        $PRICE_MIN = $allPrices->min() ? (int)floor($allPrices->min()) : 0;
        $PRICE_MAX = $allPrices->max() ? (int)ceil($allPrices->max())  : 100000;
        // round to nearest 100 for cleanliness
        $PRICE_MIN = (int)(floor($PRICE_MIN / 100) * 100);
        $PRICE_MAX = (int)(ceil($PRICE_MAX  / 100) * 100);
      @endphp
      <div class="sbf-sec">
        <span class="sbf-lbl">Price Range (₹)</span>
        <div class="price-range-wrap">
          <div class="dual-range" id="dualRange">
            <div class="range-track"></div>
            <div class="range-fill" id="rangeFill"></div>
            <input type="range" id="rangeMin"
                   min="{{ $PRICE_MIN }}" max="{{ $PRICE_MAX }}"
                   value="{{ $PRICE_MIN }}"
                   oninput="dualRangeUpdate()">
            <input type="range" id="rangeMax"
                   min="{{ $PRICE_MIN }}" max="{{ $PRICE_MAX }}"
                   value="{{ $PRICE_MAX }}"
                   oninput="dualRangeUpdate()">
          </div>
          <div class="price-disp-row">
            <div class="price-disp-box">
              <span class="pdl">Min</span>
              <span class="pdv" id="priceMinDisp">₹{{ number_format($PRICE_MIN) }}</span>
            </div>
            <span class="price-sep">—</span>
            <div class="price-disp-box">
              <span class="pdl">Max</span>
              <span class="pdv" id="priceMaxDisp">₹{{ number_format($PRICE_MAX) }}</span>
            </div>
          </div>
        </div>
      </div>

      {{-- Airlines --}}
      <div class="sbf-sec">
        <span class="sbf-lbl">Airlines</span>
        <div class="al-list">
          @if(isset($flights))
            @foreach($flights->pluck('airline_name')->unique()->sort() as $al)
            <label class="al-item">
              <input type="checkbox" class="al-cb" value="{{ $al }}" checked onchange="runFilters()">
              {{ $al }}
            </label>
            @endforeach
          @endif
        </div>
      </div>

      <button class="btn-reset-f" onclick="resetFilters()">
        <i class="fa-solid fa-rotate-left"></i> Reset Filters
      </button>
    </div>
  </div>
  </div>

  {{-- ════ RESULTS ════ --}}
  <div class="col-lg-9">

    {{-- Results header --}}
    <div class="res-hdr">
      <div class="res-count">
        <span class="n" id="visCount">{{ isset($flights) ? $flights->count() : 0 }}</span> flights found
        @if(request('from') || request('to'))
        <span style="display:inline-flex;align-items:center;gap:5px;background:var(--primary-pale);color:var(--primary-dark);font-size:.7rem;font-weight:700;padding:3px 11px;border-radius:100px;margin-left:7px;">
          @if(request('from'))<i class="fa-solid fa-plane-departure"></i> {{ request('from') }}@endif
          @if(request('from')&&request('to')) → @endif
          @if(request('to'))<i class="fa-solid fa-plane-arrival"></i> {{ request('to') }}@endif
        </span>
        @endif
        @if(request('depart'))
        <span style="display:inline-flex;align-items:center;gap:5px;background:#f0fdf4;color:#166534;font-size:.7rem;font-weight:700;padding:3px 11px;border-radius:100px;margin-left:5px;">
          <i class="fa-solid fa-calendar-days"></i>
          {{ \Carbon\Carbon::parse(request('depart'))->format('d M Y') }}
        </span>
        @endif
      </div>
      <div class="sort-grp">
        <span class="sort-lbl">Sort:</span>
        <select class="sort-sel" onchange="sortCards(this.value)">
          <option value="">Default</option>
          <option value="price_asc">Price ↑ Low to High</option>
          <option value="price_desc">Price ↓ High to Low</option>
          <option value="duration">Shortest Duration</option>
          <option value="stops">Fewest Stops</option>
        </select>
      </div>
    </div>

    {{-- Flight Cards (homepage style) --}}
    @if(!isset($flights) || $flights->isEmpty())
    <div class="empty-box">
      <div class="e-icon"><i class="fa-solid fa-plane-circle-xmark"></i></div>
      <h5>No Flights Found</h5>
      <p>Try adjusting your search or filters to find available flights.</p>
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
      $durMins   = $dep->diffInMinutes($arr);
      $sc        = (int)$flight->stops;
      $stopLabel = $sc === 0 ? 'Non-stop' : ($sc === 1 ? '1 Stop' : $sc . ' Stops');
      $stopBadge = $sc === 0 ? 'fc-badge-ns' : ($sc === 1 ? 'fc-badge-1s' : 'fc-badge-2s');
      $stopData  = $sc === 0 ? 'nonstop' : ($sc === 1 ? '1stop' : '2stop');
      $stopovers = $flight->stopover_cities ? json_decode($flight->stopover_cities, true) : [];
      $classes   = $flight->flightClasses ?? collect();
      $econCls   = $classes->firstWhere('class_type', 'Economy') ?? $classes->sortBy('total_price')->first();
      $listPrice = $econCls ? $econCls->total_price : 0;
      $selDate   = request('depart', date('Y-m-d'));
      $isSoldOut = $econCls && $econCls->available_seats === 0;
      $isLow     = $econCls && $econCls->available_seats > 0 && $econCls->available_seats <= 5;
    @endphp

    <div class="flight-item"
         data-price="{{ $listPrice }}"
         data-stops="{{ $stopData }}"
         data-dur="{{ $durMins }}"
         data-airline="{{ $flight->airline_name }}"
         id="card-{{ $flight->id }}">

      <a href="{{ route('flight', $flight->id) }}?depart={{ $selDate }}&trip={{ request('trip','one-way') }}&return={{ request('return','') }}&class={{ request('class','Economy') }}"
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
              @if($isLow)
                <span class="fc-badge" style="background:#fee2e2;color:#7f1d1d;">
                  <i class="fa-solid fa-fire"></i> Only {{ $econCls->available_seats }} left
                </span>
              @endif
              @if($isSoldOut)
                <span class="fc-badge" style="background:#f1f5f9;color:#64748b;">
                  <i class="fa-solid fa-ban"></i> Sold Out
                </span>
              @endif
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
                <div class="ep-time">
                  {{ $arr->format('H:i') }}
                  @if($overnight)<sup style="font-size:.65rem;color:#f97316;vertical-align:super;">+1</sup>@endif
                </div>
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
                  <i class="fa-solid fa-tag" style="font-size:.6rem;"></i>
                  {{ request('class', 'Economy') }}
                </div>
                <div class="fp-price">
                  <span class="sym">₹</span>{{ number_format($listPrice) }}
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
              @if($isSoldOut)
                <span class="seats-warn s-full"><i class="fa-solid fa-ban me-1"></i>Sold Out</span>
                <span class="btn-na"><i class="fa-solid fa-ban"></i>Sold Out</span>
              @else
                @if($isLow)
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
    </div>{{-- /flight-item --}}
   
    </div>{{-- /flightGrid --}}
 @endforeach
    <div id="noResults" style="display:none;">
      <div class="empty-box">
        <div class="e-icon"><i class="fa-solid fa-magnifying-glass-minus"></i></div>
        <h5>No Matching Flights</h5>
        <p>Try adjusting the sidebar filters.</p>
      </div>
    </div>

    @endif
  </div>{{-- /col results --}}

</div>{{-- /row --}}
</div>{{-- /container --}}
</div>{{-- /main-wrap --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* ════════════════════════════════════════
   TRIP TYPE
════════════════════════════════════════ */
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
document.getElementById('hfDepartDate').addEventListener('change', function () {
  const returnInput = document.getElementById('hfReturnDate');
  if (!returnInput) return;
  returnInput.min = this.value;
  if (returnInput.value < this.value) returnInput.value = this.value;
});

/* ════════════════════════════════════════
   SWAP FROM ↔ TO
════════════════════════════════════════ */
function hfSwap() {
  const fi = document.getElementById('fromInput');
  const ti = document.getElementById('toInput');
  const fc = document.getElementById('fromCode');
  const tc = document.getElementById('toCode');
  [fi.value, ti.value] = [ti.value, fi.value];
  [fc.value, tc.value] = [tc.value, fc.value];
}

/* ════════════════════════════════════════
   TRAVELLERS & CLASS
════════════════════════════════════════ */
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
  const wrap = document.querySelector('.tcc-wrap');
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

/* ════════════════════════════════════════
   DUAL PRICE RANGE SLIDER
════════════════════════════════════════ */
const PRICE_MIN_BOUND = {{ $PRICE_MIN }};
const PRICE_MAX_BOUND = {{ $PRICE_MAX }};
let filterMinPrice = PRICE_MIN_BOUND;
let filterMaxPrice = PRICE_MAX_BOUND;

function dualRangeUpdate() {
  const rMin = document.getElementById('rangeMin');
  const rMax = document.getElementById('rangeMax');
  let vMin   = parseInt(rMin.value);
  let vMax   = parseInt(rMax.value);
  // prevent crossing
  if (vMin > vMax) { vMin = vMax; rMin.value = vMin; }
  if (vMax < vMin) { vMax = vMin; rMax.value = vMax; }
  filterMinPrice = vMin;
  filterMaxPrice = vMax;
  // update display
  document.getElementById('priceMinDisp').textContent = '₹' + vMin.toLocaleString('en-IN');
  document.getElementById('priceMaxDisp').textContent = '₹' + vMax.toLocaleString('en-IN');
  // update track fill
  const pctMin = ((vMin - PRICE_MIN_BOUND) / (PRICE_MAX_BOUND - PRICE_MIN_BOUND)) * 100;
  const pctMax = ((vMax - PRICE_MIN_BOUND) / (PRICE_MAX_BOUND - PRICE_MIN_BOUND)) * 100;
  document.getElementById('rangeFill').style.left  = pctMin + '%';
  document.getElementById('rangeFill').style.width = (pctMax - pctMin) + '%';
  runFilters();
}
// init fill
(function(){
  const pctMin = 0, pctMax = 100;
  document.getElementById('rangeFill').style.left  = pctMin + '%';
  document.getElementById('rangeFill').style.width = (pctMax - pctMin) + '%';
})();

/* ════════════════════════════════════════
   SIDEBAR FILTERS
════════════════════════════════════════ */
let activeStop = 'all';

function fStop(el, t) {
  document.querySelectorAll('.stop-pill').forEach(p => p.classList.remove('active'));
  el.classList.add('active');
  activeStop = t;
  runFilters();
}

function runFilters() {
  let vis = 0;
  const als = Array.from(document.querySelectorAll('.al-cb'))
                   .filter(c => c.checked).map(c => c.value);
  document.querySelectorAll('.flight-item').forEach(item => {
    const price    = parseFloat(item.dataset.price);
    const okPrice  = price >= filterMinPrice && price <= filterMaxPrice;
    const okStop   = activeStop === 'all' || item.dataset.stops === activeStop;
    const okAir    = als.includes(item.dataset.airline);
    const ok       = okPrice && okStop && okAir;
    item.style.display = ok ? '' : 'none';
    if (ok) vis++;
  });
  document.getElementById('visCount').textContent = vis;
  const nr = document.getElementById('noResults');
  if (nr) nr.style.display = vis === 0 ? 'block' : 'none';
}

function sortCards(val) {
  const list = document.getElementById('flightGrid');
  if (!list) return;
  const items = Array.from(list.querySelectorAll('.flight-item'));
  const ord   = { nonstop: 0, '1stop': 1, '2stop': 2 };
  items.sort((a, b) => {
    if (val === 'price_asc')  return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
    if (val === 'price_desc') return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
    if (val === 'duration')   return parseInt(a.dataset.dur) - parseInt(b.dataset.dur);
    if (val === 'stops')      return (ord[a.dataset.stops] || 3) - (ord[b.dataset.stops] || 3);
    return 0;
  });
  const nr = document.getElementById('noResults');
  items.forEach(i => list.insertBefore(i, nr));
}

function resetFilters() {
  // reset sliders
  document.getElementById('rangeMin').value = PRICE_MIN_BOUND;
  document.getElementById('rangeMax').value = PRICE_MAX_BOUND;
  filterMinPrice = PRICE_MIN_BOUND;
  filterMaxPrice = PRICE_MAX_BOUND;
  document.getElementById('priceMinDisp').textContent = '₹' + PRICE_MIN_BOUND.toLocaleString('en-IN');
  document.getElementById('priceMaxDisp').textContent = '₹' + PRICE_MAX_BOUND.toLocaleString('en-IN');
  document.getElementById('rangeFill').style.left  = '0%';
  document.getElementById('rangeFill').style.width = '100%';
  // reset stops
  activeStop = 'all';
  document.querySelectorAll('.stop-pill').forEach((p, i) => p.classList.toggle('active', i === 0));
  // reset airlines
  document.querySelectorAll('.al-cb').forEach(c => c.checked = true);
  // show all
  document.querySelectorAll('.flight-item').forEach(i => i.style.display = '');
  document.getElementById('visCount').textContent = '{{ isset($flights) ? $flights->count() : 0 }}';
  const nr = document.getElementById('noResults');
  if (nr) nr.style.display = 'none';
}

/* ════════════════════════════════════════
   AIRPORT AUTOCOMPLETE
════════════════════════════════════════ */
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

    let debounce = null, lastQuery = '';

    function render(airports) {
      if (!airports.length) {
        dropdown.innerHTML = `<div class="autocomplete-item no-result"><i class="fa-solid fa-circle-info"></i> No airports found</div>`;
        show(); return;
      }
      dropdown.innerHTML = airports.map(a => `
        <div class="autocomplete-item"
             data-city="${esc(a.city)}"
             data-code="${esc(a.airport_code)}"
             data-name="${esc(a.airport_name)}">
          <div class="ac-inner">
            <div class="ac-code-box">${esc(a.airport_code)}</div>
            <div>
              <div class="ac-detail-name">${esc(a.airport_code)} — ${esc(a.airport_name)}</div>
              <div class="ac-detail-city">
                <i class="fa-solid fa-location-dot" style="color:#ef4444;font-size:.65rem;"></i>
                ${esc(a.city)}
              </div>
            </div>
          </div>
        </div>`).join('');
      show();
    }

    function fetchAirports(q) {
      fetch(`${SEARCH_URL}?q=${encodeURIComponent(q)}`)
        .then(r => r.json()).then(render).catch(hide);
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
      input.value      = `${item.dataset.city} (${item.dataset.code})`;
      codeHidden.value = item.dataset.code;
      lastQuery        = input.value;
      hide(); input.focus();
    });

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
        const h = dropdown.querySelector('.autocomplete-item.hovered');
        if (h) { e.preventDefault(); h.click(); }
      } else if (e.key === 'Escape') { hide(); }
    });

    document.addEventListener('click', function (e) {
      if (!input.contains(e.target) && !dropdown.contains(e.target)) hide();
    });
  });

  function esc(str) {
    return String(str ?? '')
      .replace(/&/g,'&amp;').replace(/</g,'&lt;')
      .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }
})();
</script>

@endsection