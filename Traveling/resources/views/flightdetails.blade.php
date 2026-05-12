@extends('header')

@section('home')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
/* ─── RESET & TOKENS ─────────────────────────────────────────── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
:root{
  --primary:#1d4ed8;--primary-dark:#1e3a8a;--primary-mid:#2563eb;
  --primary-light:#eff6ff;--primary-pale:#dbeafe;
  --navy:#0f172a;--slate:#1e293b;--gray:#64748b;
  --border:#e2e8f0;--bg:#f1f5f9;
  --green:#16a34a;--green-light:#dcfce7;
  --r8:8px;--r12:12px;--r16:16px;
  --sh:0 4px 24px rgba(0,0,0,.08),0  1px 4px rgba(0,0,0,.04);
  --font-main:'Outfit',sans-serif;
  --font-display:'Sora',sans-serif;
}
body,html{font-family:var(--font-main);background:var(--bg);color:var(--navy);}

/* ─── HERO SEARCH ─────────────────────────────────────────────── */
.hero-search-section{
  background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 55%,#1d4ed8 100%);
  padding:28px 0 40px;
  box-shadow:0 4px 28px rgba(0,0,0,.35);
  position:relative;
  z-index:100;
}
.hero-title{
  font-family:var(--font-display);color:#fff;font-size:1.15rem;
  font-weight:700;margin-bottom:16px;display:flex;align-items:center;gap:8px;opacity:.9;
}

/* ── SEARCH BOX ── */
.search-box{
  width:100%;
  background:rgba(255,255,255,.97);
  backdrop-filter:blur(20px);
  border-radius:24px;
  box-shadow:0 32px 80px rgba(0,0,0,.28),0 8px 20px rgba(29,78,216,.12);
  overflow:visible;
  animation:searchRise .9s cubic-bezier(.22,1,.36,1) both;
}
@keyframes searchRise{from{opacity:0;transform:translateY(40px) scale(.96);}to{opacity:1;transform:translateY(0) scale(1);}}

.sb-tabs{display:flex;border-bottom:1px solid var(--border);padding:0 8px;gap:2px;border-radius:24px 24px 0 0;overflow:visible;}
.sb-tab{flex:1;display:flex;flex-direction:column;align-items:center;gap:5px;padding:14px 10px 12px;cursor:pointer;border:none;background:transparent;font-family:var(--font-main);font-size:13px;font-weight:600;color:var(--gray);border-bottom:3px solid transparent;transition:color .2s,border-color .2s;white-space:nowrap;}
.sb-tab .tab-icon{width:38px;height:38px;border-radius:12px;background:#F0F4FF;display:flex;align-items:center;justify-content:center;font-size:18px;transition:background .2s,transform .2s;}
.sb-tab:hover .tab-icon{background:#dce8ff;transform:scale(1.08);}
.sb-tab.active{color:var(--primary);border-bottom-color:var(--primary);}
.sb-tab.active .tab-icon{background:var(--primary-light);}
.sb-panel{display:none;padding:20px 24px 22px;overflow:visible;}
.sb-panel.active{display:block;}

.trip-tabs-inner{display:flex;gap:6px;margin-bottom:16px;}
.trip-tab-inner{display:flex;align-items:center;gap:6px;padding:6px 16px;border-radius:100px;border:2px solid var(--border);background:#fff;font-size:.76rem;font-weight:700;color:var(--gray);cursor:pointer;transition:all .16s;}
.trip-tab-inner.active{background:var(--primary);color:#fff;border-color:var(--primary);}
.trip-tab-inner:hover:not(.active){border-color:var(--primary);color:var(--primary);}

.sb-fields{display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;overflow:visible;}
.sb-field{flex:1;min-width:120px;display:flex;flex-direction:column;gap:4px;}
.sb-field label{font-size:.64rem;font-weight:800;letter-spacing:.07em;color:var(--gray);text-transform:uppercase;}
.sf-wrap{position:relative;}
.sf-icon-abs{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:var(--primary);font-size:.76rem;pointer-events:none;z-index:1;}
.sf-inp{width:100%;padding:11px 12px 11px 32px;border:1.5px solid var(--border);border-radius:12px;font-family:var(--font-main);font-size:.88rem;font-weight:500;color:var(--navy);background:#FAFBFF;outline:none;transition:border-color .2s,box-shadow .2s;}
.sf-inp:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(29,78,216,.10);}
.sf-inp::placeholder{color:#b0bac8;font-weight:400;}
.sf-date{width:100%;padding:11px 12px;border:1.5px solid var(--border);border-radius:12px;font-family:var(--font-main);font-size:.88rem;font-weight:500;color:var(--navy);background:#FAFBFF;outline:none;transition:border-color .2s,box-shadow .2s;cursor:pointer;}
.sf-date:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(29,78,216,.10);}

.sb-swap{display:flex;align-items:flex-end;padding-bottom:2px;}
.swap-btn{width:36px;height:36px;border-radius:50%;background:var(--primary-light);border:2px solid var(--primary);color:var(--primary);font-size:14px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .2s,transform .2s;flex-shrink:0;}
.swap-btn:hover{background:var(--primary);color:#fff;transform:rotate(180deg);}

/* ── TCC DROPDOWN ── */
.tcc-wrap{position:relative;}
.tcc-trigger{border:1.5px solid var(--border);border-radius:12px;padding:10px;width:100%;background:#FAFBFF;cursor:pointer;display:flex;align-items:center;gap:6px;transition:border-color .2s,box-shadow .2s;user-select:none;overflow:hidden;min-width:0;}
.tcc-trigger:hover,.tcc-trigger.open{border-color:var(--primary);}
.tcc-trigger.open{box-shadow:0 0 0 3px rgba(29,78,216,.10);}
.tcc-icon{color:var(--primary);font-size:.78rem;flex-shrink:0;}
.tcc-text{flex:1;min-width:0;overflow:hidden;}
.tcc-lbl{font-size:.62rem;font-weight:800;color:var(--gray);text-transform:uppercase;letter-spacing:.09em;display:block;line-height:1;}
.tcc-val{font-size:.82rem;font-weight:600;color:var(--navy);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;line-height:1.4;max-width:100%;}
.tcc-chev{color:var(--gray);font-size:.65rem;flex-shrink:0;transition:transform .2s;}
.tcc-trigger.open .tcc-chev{transform:rotate(180deg);}

/* TCC Drop — fixed position, appended to body */
.tcc-drop{
  position:fixed;
  top:0;left:0;
  width:320px;
  background:rgba(255,255,255,.99);
  backdrop-filter:blur(24px);
  -webkit-backdrop-filter:blur(24px);
  border:1.5px solid rgba(191,219,254,.8);
  border-radius:18px;
  box-shadow:0 32px 80px rgba(0,0,0,.25),0 8px 24px rgba(29,78,216,.16),0 0 0 1px rgba(255,255,255,.6) inset;
  z-index:999999;
  display:none;
  overflow:hidden;
}
.tcc-drop.open{display:block;animation:tccOpen .18s cubic-bezier(.22,1,.36,1) both;}
@keyframes tccOpen{from{opacity:0;transform:translateY(-6px) scale(.97);}to{opacity:1;transform:translateY(0) scale(1);}}

.tcc-sec{padding:14px 18px;border-bottom:1px solid #f0f4ff;}
.tcc-slbl{font-size:.63rem;font-weight:800;color:var(--primary-dark);text-transform:uppercase;letter-spacing:.12em;margin-bottom:8px;display:flex;align-items:center;gap:5px;}
.tcc-slbl::before{content:'';display:inline-block;width:3px;height:11px;background:var(--primary);border-radius:2px;}
.cabin-sel{width:100%;border:1.5px solid var(--border);border-radius:var(--r8);padding:9px 12px;font-size:.88rem;font-family:var(--font-main);color:var(--navy);font-weight:500;outline:none;background:#fff;cursor:pointer;transition:border-color .2s;}
.cabin-sel:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(29,78,216,.08);}
.pax-row{display:flex;align-items:center;justify-content:space-between;padding:7px 0;}
.pax-row+.pax-row{border-top:1px solid #f8faff;padding-top:10px;}
.pax-info strong{font-size:.88rem;font-weight:700;color:var(--navy);display:block;}
.pax-info small{font-size:.7rem;color:var(--gray);margin-top:1px;display:block;}
.pax-ctrl{display:flex;align-items:center;gap:10px;flex-shrink:0;}
.pax-btn{width:34px;height:34px;border-radius:var(--r8);border:1.5px solid var(--border);background:#fff;cursor:pointer;font-size:.9rem;font-weight:700;display:flex;align-items:center;justify-content:center;transition:all .15s;color:var(--navy);flex-shrink:0;}
.pax-btn:hover:not(:disabled){border-color:var(--primary);background:var(--primary);color:#fff;}
.pax-btn:disabled{opacity:.3;cursor:not-allowed;}
.pax-count{font-weight:800;font-size:1rem;min-width:22px;text-align:center;color:var(--navy);}
.tcc-note{padding:10px 18px;font-size:.68rem;color:var(--gray);line-height:1.55;background:#fafbff;border-top:1px solid #f0f4ff;}
.btn-apply{display:block;width:100%;background:linear-gradient(135deg,var(--primary-mid),var(--primary-dark));color:#fff;border:none;padding:13px;font-family:var(--font-display);font-weight:700;font-size:.86rem;cursor:pointer;transition:opacity .15s;}
.btn-apply:hover{opacity:.9;}

/* Search button */
.sb-search-btn{height:46px;padding:0 26px;background:linear-gradient(135deg,var(--primary-mid),var(--primary-dark));color:#fff;border:none;border-radius:12px;font-family:var(--font-display);font-size:.86rem;font-weight:700;display:flex;align-items:center;gap:7px;cursor:pointer;transition:transform .15s,box-shadow .15s;white-space:nowrap;flex-shrink:0;}
.sb-search-btn:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(29,78,216,.38);}

/* Autocomplete */
.autocomplete-dropdown{position:absolute;top:calc(100% + 6px);left:0;width:100%;background:#fff;border:1.5px solid #bfdbfe;border-radius:14px;box-shadow:0 12px 40px rgba(0,0,0,.12),0 4px 12px rgba(29,78,216,.08);max-height:280px;overflow-y:auto;z-index:99999;padding:6px;display:flex;flex-direction:column;gap:2px;}
.autocomplete-item{padding:8px 10px;border-radius:10px;cursor:pointer;transition:background .12s;}
.autocomplete-item:hover,.autocomplete-item.hovered{background:#eff6ff;}
.autocomplete-item.no-result{color:#94a3b8;cursor:default;font-size:.82rem;}
.ac-inner{display:flex;align-items:center;gap:10px;}
.ac-code-box{min-width:46px;height:46px;background:#eff6ff;border:1.5px solid #bfdbfe;border-radius:10px;display:flex;align-items:center;justify-content:center;font-family:'Sora',sans-serif;font-size:.72rem;font-weight:800;color:#1d4ed8;letter-spacing:.04em;flex-shrink:0;}
.ac-detail-name{font-weight:700;font-size:.84rem;color:#0f172a;line-height:1.25;}
.ac-detail-city{font-size:.72rem;color:#64748b;margin-top:2px;display:flex;align-items:center;gap:4px;}

/* ─── MAIN LAYOUT ─────────────────────────────────────────────── */
.main-wrap{padding:28px 0 60px;}

/* ─── SIDEBAR ─────────────────────────────────────────────────── */
.sidebar{background:#fff;border-radius:var(--r16);border:1.5px solid var(--border);overflow:hidden;position:sticky;top:18px;}
.sbf-head{background:var(--navy);padding:13px 16px;display:flex;align-items:center;gap:8px;}
.sbf-head span{font-family:var(--font-display);font-weight:700;font-size:.78rem;color:#fff;letter-spacing:.07em;text-transform:uppercase;}
.sbf-body{padding:16px;}
.sbf-sec{margin-bottom:18px;padding-bottom:18px;border-bottom:1px solid var(--border);}
.sbf-sec:last-child{margin-bottom:0;padding-bottom:0;border-bottom:none;}
.sbf-lbl{font-size:.62rem;font-weight:800;color:var(--gray);text-transform:uppercase;letter-spacing:.1em;margin-bottom:9px;display:block;}

.stop-pills{display:flex;flex-direction:column;gap:4px;}
.stop-pill{display:flex;align-items:center;justify-content:space-between;padding:8px 11px;border-radius:var(--r8);border:2px solid var(--border);background:#fff;cursor:pointer;transition:all .14s;font-size:.8rem;font-weight:600;color:var(--slate);}
.stop-pill:hover{border-color:var(--primary);background:var(--primary-light);}
.stop-pill.active{border-color:var(--primary);background:var(--primary-light);color:var(--primary-dark);}
.sp-l{display:flex;align-items:center;gap:7px;}
.sp-dot{width:7px;height:7px;border-radius:50%;background:#cbd5e1;flex-shrink:0;transition:background .14s;}
.stop-pill.active .sp-dot{background:var(--primary);}
.sp-n{font-size:.65rem;font-weight:700;background:#f1f5f9;padding:2px 7px;border-radius:100px;color:var(--gray);}
.stop-pill.active .sp-n{background:var(--primary-pale);color:var(--primary-mid);}

.al-list{display:flex;flex-direction:column;gap:6px;}
.al-item{display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.8rem;font-weight:500;color:var(--slate);}
.al-item input{width:14px;height:14px;accent-color:var(--primary);cursor:pointer;}
.btn-reset-f{width:100%;background:#f8fafc;border:1.5px solid var(--border);border-radius:var(--r8);padding:8px;font-size:.74rem;font-weight:700;color:var(--gray);cursor:pointer;transition:all .14s;font-family:var(--font-main);display:flex;align-items:center;justify-content:center;gap:5px;margin-top:10px;}
.btn-reset-f:hover{background:var(--navy);color:#fff;border-color:var(--navy);}

/* ─── RESULTS HEADER ──────────────────────────────────────────── */
.res-hdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:10px;}
.res-count{font-family:var(--font-display);font-size:.9rem;font-weight:700;color:var(--navy);}
.res-count .n{color:var(--primary);font-size:1.05rem;}
.sort-grp{display:flex;align-items:center;gap:6px;}
.sort-lbl{font-size:.74rem;color:var(--gray);font-weight:600;}
.sort-sel{border:2px solid var(--border);border-radius:var(--r8);padding:6px 10px;font-size:.78rem;background:#fff;font-family:var(--font-main);cursor:pointer;color:var(--navy);font-weight:600;outline:none;}
.sort-sel:focus{border-color:var(--primary);}

/* ─── FLIGHT CARD ─────────────────────────────────────────────── */
.rtcard{background:#fff;border-radius:var(--r16);border:2px solid var(--border);overflow:hidden;transition:transform .2s,box-shadow .2s,border-color .2s;position:relative;}
.rtcard:hover{transform:translateY(-4px);box-shadow:0 20px 56px rgba(29,78,216,.12),0 4px 16px rgba(0,0,0,.07);border-color:#bfdbfe;}

.rt-leg-strip{display:flex;align-items:center;gap:8px;padding:8px 18px;font-size:.7rem;font-weight:800;letter-spacing:.07em;text-transform:uppercase;}
.rt-leg-strip.depart{background:linear-gradient(90deg,#eff6ff 0%,#dbeafe 100%);color:var(--primary-dark);border-bottom:1.5px solid #bfdbfe;}
.rt-leg-strip.return-leg{background:linear-gradient(90deg,#f0fdf4 0%,#dcfce7 100%);color:#14532d;border-top:2px dashed #86efac;border-bottom:1.5px solid #86efac;}
.rt-leg-strip i{font-size:.72rem;}
.rt-leg-date{margin-left:auto;font-size:.68rem;font-weight:700;opacity:.75;}

.rt-flight-row{padding:16px 18px 14px;display:flex;align-items:center;gap:0;}
.rt-airline-block{display:flex;align-items:center;gap:10px;min-width:170px;}
.rt-al-logo{width:40px;height:40px;border-radius:var(--r8);background:#fff;border:1.5px solid #dde3f0;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;font-size:.58rem;font-weight:800;color:var(--primary);letter-spacing:.04em;text-align:center;line-height:1.2;}
.rt-al-logo img{width:100%;height:100%;object-fit:contain;padding:3px;}
.rt-al-name{font-family:var(--font-display);font-weight:700;font-size:.82rem;color:var(--navy);}
.rt-al-sub{font-size:.68rem;color:var(--gray);margin-top:1px;display:flex;align-items:center;gap:5px;}
.rt-al-flno{font-weight:600;color:var(--slate);}
.rt-al-ac{background:#f1f5f9;border:1px solid var(--border);padding:1px 6px;border-radius:4px;font-size:.62rem;font-weight:700;}

.rt-route{flex:1;display:flex;align-items:center;padding:0 12px;min-width:0;}
.rt-ep-time{font-family:var(--font-display);font-size:1.35rem;font-weight:800;color:var(--navy);line-height:1;}
.rt-ep-iata{font-size:.8rem;font-weight:800;color:var(--primary);margin-top:3px;letter-spacing:.06em;}
.rt-ep-airport{font-size:.63rem;color:var(--gray);margin-top:1px;font-weight:500;line-height:1.3;max-width:110px;}
.rt-ep-r .rt-ep-airport{text-align:right;}
.rt-mid{flex:1;display:flex;flex-direction:column;align-items:center;gap:5px;padding:0 10px;min-width:0;}
.rt-route-line{display:flex;align-items:center;width:100%;gap:3px;}
.rt-r-dot{width:6px;height:6px;border-radius:50%;border:2px solid var(--primary);background:#fff;flex-shrink:0;}
.rt-r-dash{flex:1;height:2px;background:repeating-linear-gradient(90deg,var(--primary) 0,var(--primary) 4px,transparent 4px,transparent 9px);}
.rt-r-plane{font-size:.76rem;color:var(--primary);}
.rt-dur-pill{background:var(--primary-light);color:var(--primary-mid);font-size:.66rem;font-weight:700;padding:2px 9px;border-radius:100px;white-space:nowrap;}
.rt-stop-badge{font-size:.65rem;font-weight:800;padding:3px 10px;border-radius:100px;display:inline-flex;align-items:center;gap:4px;}
.rt-stop-ns{background:#dcfce7;color:#14532d;}
.rt-stop-1s{background:#fef9c3;color:#78350f;}
.rt-stop-2s{background:#fee2e2;color:#7f1d1d;}
.rt-stopover{display:inline-flex;align-items:center;justify-content:center;gap:4px;background:#fffbeb;border:1px solid #fde68a;color:#92400e;font-size:.64rem;font-weight:600;padding:3px 10px;border-radius:6px;text-align:center;line-height:1.4;}
.rt-overnight{display:inline-flex;align-items:center;gap:4px;background:#f0f9ff;border:1px solid #bae6fd;color:#0369a1;font-size:.64rem;font-weight:600;padding:3px 10px;border-radius:6px;}
.sv-city{background:#fef3c7;border:1px solid #fde68a;padding:1px 7px;border-radius:100px;font-size:.62rem;font-weight:700;color:#78350f;white-space:nowrap;}

.rt-price-col{text-align:right;min-width:110px;flex-shrink:0;padding-left:8px;}
.rt-price-label{font-size:.6rem;font-weight:800;color:var(--gray);text-transform:uppercase;letter-spacing:.07em;}
.rt-price-amt{font-family:var(--font-display);font-size:1.1rem;font-weight:800;color:var(--primary-dark);}
.rt-price-amt.return-price{color:#14532d;}
.rt-price-sup{font-size:.75rem;font-weight:500;vertical-align:super;}
.rt-price-sub{font-size:.62rem;color:var(--gray);}
.rt-baggage{display:flex;flex-direction:column;gap:2px;margin-top:5px;}
.rt-bag-row{display:flex;align-items:center;gap:3px;font-size:.62rem;color:var(--gray);justify-content:flex-end;}
.rt-bag-row i{color:var(--primary);font-size:.56rem;}
.cls-chip{display:inline-flex;align-items:center;gap:3px;background:var(--primary-pale);color:var(--primary-dark);font-size:.58rem;font-weight:800;letter-spacing:.06em;padding:2px 8px;border-radius:100px;text-transform:uppercase;margin-bottom:4px;}
.cls-chip.return-chip{background:#dcfce7;color:#14532d;}

.rt-footer{padding:14px 18px 16px;display:flex;align-items:center;justify-content:space-between;gap:16px;background:linear-gradient(135deg,#f8faff 0%,#eef4ff 100%);border-top:1.5px solid #e8edf8;flex-wrap:wrap;}
.rt-class-badge{display:inline-flex;align-items:center;gap:4px;background:var(--primary-pale);color:var(--primary-dark);font-size:.62rem;font-weight:800;letter-spacing:.07em;padding:3px 10px;border-radius:100px;text-transform:uppercase;}
.seats-warn{display:flex;align-items:center;gap:5px;font-size:.7rem;font-weight:700;color:#dc2626;}
.rt-footer-right{display:flex;flex-direction:column;align-items:flex-end;gap:7px;}
.btn-select-rt{background:linear-gradient(135deg,var(--primary-mid),var(--primary-dark));color:#fff;border:none;border-radius:var(--r8);padding:11px 26px;font-family:var(--font-display);font-weight:700;font-size:.84rem;display:inline-flex;align-items:center;gap:7px;white-space:nowrap;cursor:pointer;text-decoration:none;transition:transform .14s,box-shadow .14s;}
.btn-select-rt:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(29,78,216,.4);color:#fff;}

/* Empty state */
.empty-box{text-align:center;padding:64px 20px;background:#fff;border-radius:var(--r16);border:2px dashed var(--border);}
.e-icon{width:64px;height:64px;border-radius:50%;background:var(--primary-light);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;}
.e-icon i{font-size:1.6rem;color:var(--primary);}
.empty-box h5{font-family:var(--font-display);font-weight:800;color:var(--navy);margin-bottom:6px;}
.empty-box p{color:var(--gray);font-size:.88rem;}

/* ─── MOBILE RESPONSIVE ────────────────────────────────────────── */
@media(max-width:991px){
  .sidebar{position:static;margin-bottom:18px;top:auto;}
}

@media(max-width:768px){
  .sb-swap{display:none;}
  .sb-search-btn{width:100%;justify-content:center;}
  .sb-panel{padding:16px;}
  .sb-fields{flex-direction:column;}
  .sb-field{min-width:unset;width:100%;}

  .tcc-drop{
    width:calc(100vw - 24px) !important;
    left:12px !important;
    right:12px !important;
    border-radius:16px;
  }
  .pax-ctrl{gap:16px;}
  .pax-btn{width:40px;height:40px;font-size:1.1rem;}

  .rt-leg-strip{font-size:.62rem;padding:7px 12px;flex-wrap:wrap;gap:4px;}
  .rt-leg-date{margin-left:0;width:100%;font-size:.6rem;margin-top:2px;}

  .rt-flight-row{
    padding:12px;
    flex-direction:column;
    align-items:stretch;
    gap:12px;
  }
  .rt-airline-block{
    min-width:unset;
    width:100%;
    justify-content:flex-start;
  }

  .rt-route{
    padding:0;
    width:100%;
    gap:4px;
  }
  .rt-ep-time{font-size:1.1rem;}
  .rt-ep-airport{font-size:.58rem;max-width:80px;}
  .rt-mid{padding:0 6px;}
  .rt-dur-pill{font-size:.58rem;padding:2px 7px;}
  .rt-stop-badge{font-size:.58rem;padding:2px 8px;}

  .rt-price-col{
    text-align:left;
    min-width:unset;
    padding-left:0;
    display:flex;
    flex-wrap:wrap;
    align-items:center;
    gap:10px;
    border-top:1px solid var(--border);
    padding-top:10px;
  }
  .rt-price-col .cls-chip{margin-bottom:0;}
  .rt-baggage{flex-direction:row;gap:10px;flex-wrap:wrap;}
  .rt-bag-row{justify-content:flex-start;}

  .rt-footer{
    flex-direction:column;
    align-items:stretch;
    gap:12px;
    padding:12px;
  }
  .rt-footer-right{
    flex-direction:row;
    align-items:center;
    justify-content:space-between;
  }
  .btn-select-rt{padding:10px 20px;font-size:.8rem;}
}

@media(max-width:480px){
  .rt-ep-time{font-size:1rem;}
  .res-hdr{flex-direction:column;align-items:flex-start;}
  .sort-grp{width:100%;}
  .sort-sel{flex:1;}
}
</style>

@php
  $selDate    = $selDate   ?? request('depart',  date('Y-m-d'));
  $retDate    = $returnDate ?? request('return',  date('Y-m-d', strtotime('+7 days')));
  $tripType   = $tripType  ?? request('trip',    'one-way');
  $isRound    = $tripType === 'round';
  $selClass   = $selClass  ?? request('class',    'Economy');
  $adults     = isset($adults)   ? (int)$adults   : (int)request('adults',   1);
  $children   = isset($children) ? (int)$children : (int)request('children', 0);
  $totalPax   = $adults + $children;
  $fromText   = $fromText ?? request('from', '');
  $toText     = $toText   ?? request('to',   '');
  $fromCode   = $fromCode ?? request('from_code', '');
  $toCode     = $toCode   ?? request('to_code',   '');
  $airportNames = $airportNames ?? collect();
  $displayPairs   = isset($pairs)   ? $pairs   : [];
  $displayFlights = isset($flights) ? $flights : collect();

  $getClassPrice = function($flight, $class) {
    return $flight->flightClasses->firstWhere('class_type', $class)
        ?? $flight->flightClasses->sortBy('total_price')->first();
  };
  $airportName = function($code) use ($airportNames) {
    return $airportNames[$code] ?? $code;
  };

  if ($isRound && count($displayPairs)) {
    $allPrices = collect($displayPairs)->map(function($pair) use($selClass, $getClassPrice) {
      $dc = $getClassPrice($pair['depart'], $selClass);
      $rc = $getClassPrice($pair['return'], $selClass);
      return ($dc ? $dc->total_price : 0) + ($rc ? $rc->total_price : 0);
    });
  } else {
    $allPrices = $displayFlights->flatMap->flightClasses
        ->where('class_type', $selClass)->pluck('total_price')->filter()->values();
    if ($allPrices->isEmpty()) {
      $allPrices = $displayFlights->flatMap->flightClasses->pluck('total_price')->filter()->values();
    }
  }
  $PRICE_MIN = $allPrices->isNotEmpty() ? (int)floor($allPrices->min() / 100) * 100 : 0;
  $PRICE_MAX = $allPrices->isNotEmpty() ? (int)ceil($allPrices->max()  / 100) * 100 : 100000;

  $travellersDisplay = $adults . ' Adult' . ($adults > 1 ? 's' : '')
    . ($children ? ', ' . $children . ' Child' . ($children > 1 ? 'ren' : '') : '')
    . ', ' . $selClass;
@endphp

{{-- ══ HERO SEARCH BAR ══ --}}
<div class="hero-search-section">
  <div class="container-xl">
    <div class="hero-title">
      <i class="fa-solid fa-plane"></i> Flight Search
    </div>
    <div class="search-box">
      <div class="sb-tabs">
        <button class="sb-tab active" onclick="switchTab(this,'sp-flights')">
          <span class="tab-icon">✈️</span>Flights
        </button>
      </div>

      <div class="sb-panel active" id="sp-flights">
        <div class="trip-tabs-inner">
          <button type="button"
                  class="trip-tab-inner {{ $tripType === 'one-way' ? 'active' : '' }}"
                  onclick="setTrip(this,'one-way')">
            <i class="fa-solid fa-arrow-right"></i>One Way
          </button>
          <button type="button"
                  class="trip-tab-inner {{ $tripType === 'round' ? 'active' : '' }}"
                  onclick="setTrip(this,'round')">
            <i class="fa-solid fa-arrows-left-right"></i>Round Trip
          </button>
        </div>

        <form method="GET" action="{{ route('flight.search') }}" id="flightSearchForm" onsubmit="syncBeforeSubmit()">
          <input type="hidden" name="trip"     id="hfTripH"     value="{{ $tripType }}">
          <input type="hidden" name="class"    id="hfClassH"    value="{{ $selClass }}">
          <input type="hidden" name="adults"   id="hfAdultsH"   value="{{ $adults }}">
          <input type="hidden" name="children" id="hfChildrenH" value="{{ $children }}">

          <div class="sb-fields">
            {{-- From --}}
            <div class="sb-field" style="flex:1.3;">
              <label>From</label>
              <div class="sf-wrap" style="position:relative;">
                <i class="sf-icon-abs fa-solid fa-plane-departure"></i>
                <input type="text" id="fromInput" name="from" class="sf-inp"
                       placeholder="City or airport"
                       value="{{ $fromText }}" autocomplete="off">
                <div id="fromDropdown" class="autocomplete-dropdown" style="display:none;"></div>
                <input type="hidden" name="from_code" id="fromCode" value="{{ $fromCode }}">
              </div>
            </div>

            {{-- Swap --}}
            <div class="sb-swap">
              <button type="button" class="swap-btn" onclick="hfSwap()" title="Swap">⇄</button>
            </div>

            {{-- To --}}
            <div class="sb-field" style="flex:1.3;">
              <label>To</label>
              <div class="sf-wrap" style="position:relative;">
                <i class="sf-icon-abs fa-solid fa-plane-arrival"></i>
                <input type="text" id="toInput" name="to" class="sf-inp"
                       placeholder="City or airport"
                       value="{{ $toText }}" autocomplete="off">
                <div id="toDropdown" class="autocomplete-dropdown" style="display:none;"></div>
                <input type="hidden" name="to_code" id="toCode" value="{{ $toCode }}">
              </div>
            </div>

            {{-- Depart --}}
            <div class="sb-field">
              <label>Depart</label>
              <input type="date" name="depart" id="hfDepartDate" class="sf-date"
                     value="{{ $selDate }}" min="{{ date('Y-m-d') }}"
                     onchange="onDepartChange(this)">
            </div>

            {{-- Return --}}
            <div class="sb-field" id="hfReturnWrap" style="{{ $isRound ? '' : 'display:none;' }}">
              <label>Return</label>
              <input type="date" name="return" id="hfReturnDate" class="sf-date"
                     value="{{ $retDate }}" min="{{ $selDate }}">
            </div>

            {{-- Travellers & Class --}}
            <div class="sb-field tcc-wrap" style="flex:1.4;">
              <label>Travellers &amp; Class</label>
              <div class="tcc-trigger" id="hfTccTrigger" onclick="toggleTcc(event)">
                <i class="fa-solid fa-users tcc-icon"></i>
                <div class="tcc-text">
                  <span class="tcc-lbl">Travellers &amp; Class</span>
                  <span class="tcc-val" id="hfTccVal">{{ $travellersDisplay }}</span>
                </div>
                <i class="fa-solid fa-chevron-down tcc-chev"></i>
              </div>
            </div>

            {{-- Search --}}
            <button type="submit" class="sb-search-btn">
              <i class="fa-solid fa-magnifying-glass"></i>Search Flights
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- TCC DROPDOWN — appended to <body> by JS --}}
<div class="tcc-drop" id="hfTccDrop">
  <div class="tcc-sec">
    <span class="tcc-slbl">Cabin Class</span>
    <select class="cabin-sel" id="hfCabinSel" onchange="updateHfTcc()">
      @foreach(['Economy','Premium Economy','Business','First'] as $cls)
        <option value="{{ $cls }}" {{ $selClass === $cls ? 'selected' : '' }}>{{ $cls }}</option>
      @endforeach
    </select>
  </div>
  <div class="tcc-sec">
    <span class="tcc-slbl">Passengers</span>
    <div class="pax-row">
      <div class="pax-info"><strong>Adults</strong><small>Aged 18+</small></div>
      <div class="pax-ctrl">
        <button type="button" class="pax-btn" id="hfAdMinus" onclick="chHfPax('a',-1)">−</button>
        <span class="pax-count" id="hfAdCnt">{{ $adults }}</span>
        <button type="button" class="pax-btn" onclick="chHfPax('a',1)">+</button>
      </div>
    </div>
    <div class="pax-row">
      <div class="pax-info"><strong>Children</strong><small>Aged 0–17</small></div>
      <div class="pax-ctrl">
        <button type="button" class="pax-btn" id="hfChMinus" onclick="chHfPax('c',-1)">−</button>
        <span class="pax-count" id="hfChCnt">{{ $children }}</span>
        <button type="button" class="pax-btn" onclick="chHfPax('c',1)">+</button>
      </div>
    </div>
  </div>
  <div class="tcc-note">Age at time of travel must be valid for the booked category.</div>
  <button class="btn-apply" onclick="applyHfTcc()">Done</button>
</div>

{{-- ══ MAIN CONTENT ══ --}}
<div class="main-wrap">
<div class="container-xl">
<div class="row g-4">

  {{-- ── SIDEBAR ── --}}
  <div class="col-lg-3">
    <div class="sidebar">
      <div class="sbf-head">
        <i class="fa-solid fa-sliders" style="color:#93c5fd;font-size:.78rem;"></i>
        <span>Filter Results</span>
      </div>
      <div class="sbf-body">

        {{-- Stops --}}
        <div class="sbf-sec">
          <span class="sbf-lbl">Stops (Outbound)</span>
          <div class="stop-pills">
            <div class="stop-pill active" onclick="fStop(this,'all')">
              <div class="sp-l"><div class="sp-dot"></div>All Flights</div>
              <span class="sp-n" id="cnt-all">{{ $isRound ? count($displayPairs) : $displayFlights->count() }}</span>
            </div>
            <div class="stop-pill" onclick="fStop(this,'nonstop')">
              <div class="sp-l"><div class="sp-dot"></div>Non-stop</div>
              <span class="sp-n" id="cnt-ns">
                @if($isRound){{ collect($displayPairs)->filter(fn($p) => $p['depart']->stops == 0)->count() }}
                @else{{ $displayFlights->filter(fn($f) => $f->stops == 0)->count() }}@endif
              </span>
            </div>
            <div class="stop-pill" onclick="fStop(this,'1stop')">
              <div class="sp-l"><div class="sp-dot"></div>1 Stop</div>
              <span class="sp-n" id="cnt-1s">
                @if($isRound){{ collect($displayPairs)->filter(fn($p) => $p['depart']->stops == 1)->count() }}
                @else{{ $displayFlights->filter(fn($f) => $f->stops == 1)->count() }}@endif
              </span>
            </div>
            <div class="stop-pill" onclick="fStop(this,'2stop')">
              <div class="sp-l"><div class="sp-dot"></div>2+ Stops</div>
              <span class="sp-n" id="cnt-2s">
                @if($isRound){{ collect($displayPairs)->filter(fn($p) => $p['depart']->stops >= 2)->count() }}
                @else{{ $displayFlights->filter(fn($f) => $f->stops >= 2)->count() }}@endif
              </span>
            </div>
          </div>
        </div>

        {{-- Airlines --}}
        <div class="sbf-sec">
          <span class="sbf-lbl">Airlines</span>
          <div class="al-list">
            @php
              $allAirlines = $isRound && count($displayPairs)
                ? collect($displayPairs)->pluck('depart')->pluck('airline_name')
                    ->merge(collect($displayPairs)->pluck('return')->pluck('airline_name'))
                    ->unique()->sort()->values()
                : $displayFlights->pluck('airline_name')->unique()->sort()->values();
            @endphp
            @foreach($allAirlines as $al)
              <label class="al-item">
                <input type="checkbox" class="al-cb" value="{{ $al }}" checked onchange="runFilters()">
                {{ $al }}
              </label>
            @endforeach
          </div>
        </div>

        <button class="btn-reset-f" onclick="resetFilters()">
          <i class="fa-solid fa-rotate-left"></i> Reset Filters
        </button>

      </div>
    </div>
  </div>

  {{-- ── RESULTS ── --}}
  <div class="col-lg-9">

    <div class="res-hdr">
      <div class="res-count">
        <span class="n" id="visCount">{{ $isRound ? count($displayPairs) : $displayFlights->count() }}</span>
        {{ $isRound ? 'round-trip combinations found' : 'flights found' }}

        @if($fromText || $toText)
          <span style="display:inline-flex;align-items:center;gap:5px;background:var(--primary-pale);color:var(--primary-dark);font-size:.7rem;font-weight:700;padding:3px 11px;border-radius:100px;margin-left:7px;">
            @if($fromText)<i class="fa-solid fa-plane-departure"></i> {{ $fromText }}@endif
            @if($fromText && $toText) ⇄ @endif
            @if($toText)<i class="fa-solid fa-plane-arrival"></i> {{ $toText }}@endif
          </span>
        @endif

        @if($isRound)
          <span style="display:inline-flex;align-items:center;gap:5px;background:#f0fdf4;color:#166534;font-size:.7rem;font-weight:700;padding:3px 11px;border-radius:100px;margin-left:5px;">
            <i class="fa-solid fa-calendar-days"></i>
            {{ \Carbon\Carbon::parse($selDate)->format('d M') }} – {{ \Carbon\Carbon::parse($retDate)->format('d M Y') }}
          </span>
        @else
          <span style="display:inline-flex;align-items:center;gap:5px;background:#f0fdf4;color:#166534;font-size:.7rem;font-weight:700;padding:3px 11px;border-radius:100px;margin-left:5px;">
            <i class="fa-solid fa-calendar-days"></i>
            {{ \Carbon\Carbon::parse($selDate)->format('d M Y') }}
          </span>
        @endif

        <span style="display:inline-flex;align-items:center;gap:5px;background:#fef9c3;color:#78350f;font-size:.7rem;font-weight:700;padding:3px 11px;border-radius:100px;margin-left:5px;">
          <i class="fa-solid fa-users"></i>
          {{ $adults }} Adult{{ $adults > 1 ? 's' : '' }}{{ $children ? ', ' . $children . ' Child' . ($children > 1 ? 'ren' : '') : '' }}
          · {{ $selClass }}
        </span>
      </div>

      <div class="sort-grp">
        <span class="sort-lbl">Sort:</span>
        <select class="sort-sel" onchange="sortCards(this.value)">
          <option value="">Default</option>
          <option value="price_asc">Price ↑ Low to High</option>
          <option value="price_desc">Price ↓ High to Low</option>
        </select>
      </div>
    </div>

    {{-- ════ WARNING STATE ════ --}}
    @if(isset($noFlightWarning) && $noFlightWarning)
      <div class="empty-box">
        <div class="e-icon"><i class="fa-solid fa-plane-circle-exclamation"></i></div>
        <h5>Flight Not Available</h5>
        <p>{{ $noFlightWarning }}</p>
        <div style="margin-top:16px;display:flex;gap:10px;justify-content:center;flex-wrap:wrap;">
          <a href="{{ route('flight.search') }}" style="display:inline-flex;align-items:center;gap:6px;background:var(--primary);color:#fff;border-radius:var(--r8);padding:10px 20px;font-family:var(--font-display);font-weight:700;font-size:.82rem;text-decoration:none;">
            <i class="fa-solid fa-search"></i> New Search
          </a>
          <button onclick="history.back()" style="display:inline-flex;align-items:center;gap:6px;background:#f1f5f9;color:var(--navy);border:1.5px solid var(--border);border-radius:var(--r8);padding:10px 20px;font-family:var(--font-display);font-weight:700;font-size:.82rem;cursor:pointer;">
            <i class="fa-solid fa-arrow-left"></i> Go Back
          </button>
        </div>
      </div>

    {{-- ════ ROUND-TRIP CARDS ════ --}}
    @elseif($isRound && count($displayPairs))
      <div class="d-flex flex-column gap-3" id="flightGrid">

      @foreach($displayPairs as $pairIdx => $pair)
      @php
        $df  = $pair['depart'];
        $rf  = $pair['return'];

        $dDep = \Carbon\Carbon::parse($df->departure_time);
        $dArr = \Carbon\Carbon::parse($df->arrival_time);
        $dON  = (int)($df->overnight_arrival ?? 0);
        if ($dON) { $dArr->addDay(); } elseif ($dArr->lessThan($dDep)) { $dArr->addDay(); }
        $dDiff = $dDep->diff($dArr);
        $dMins = $dDep->diffInMinutes($dArr);
        $dSc   = (int)$df->stops;
        $dStop = $dSc === 0 ? 'nonstop' : ($dSc === 1 ? '1stop' : '2stop');
        $dStopLabel = $dSc === 0 ? 'Non-stop' : ($dSc === 1 ? '1 Stop' : $dSc . ' Stops');
        $dStopBadge = $dSc === 0 ? 'rt-stop-ns' : ($dSc === 1 ? 'rt-stop-1s' : 'rt-stop-2s');
        $dStopovers = $df->stopover_cities ? json_decode($df->stopover_cities, true) : [];
        $dCls   = $getClassPrice($df, $selClass);
        $dPrice = $dCls ? $dCls->total_price : 0;
        $dFromAirport = $airportName($df->from_airport_code);
        $dToAirport   = $airportName($df->to_airport_code);

        $rDep = \Carbon\Carbon::parse($rf->departure_time);
        $rArr = \Carbon\Carbon::parse($rf->arrival_time);
        $rON  = (int)($rf->overnight_arrival ?? 0);
        if ($rON) { $rArr->addDay(); } elseif ($rArr->lessThan($rDep)) { $rArr->addDay(); }
        $rDiff = $rDep->diff($rArr);
        $rMins = $rDep->diffInMinutes($rArr);
        $rSc   = (int)$rf->stops;
        $rStopLabel = $rSc === 0 ? 'Non-stop' : ($rSc === 1 ? '1 Stop' : $rSc . ' Stops');
        $rStopBadge = $rSc === 0 ? 'rt-stop-ns' : ($rSc === 1 ? 'rt-stop-1s' : 'rt-stop-2s');
        $rStopovers = $rf->stopover_cities ? json_decode($rf->stopover_cities, true) : [];
        $rCls   = $getClassPrice($rf, $selClass);
        $rPrice = $rCls ? $rCls->total_price : 0;
        $rFromAirport = $airportName($rf->from_airport_code);
        $rToAirport   = $airportName($rf->to_airport_code);

        $totalPrice  = $dPrice + $rPrice;
        $totalPerPax = $totalPrice * $totalPax;
        $isLowD = $dCls && $dCls->available_seats > 0 && $dCls->available_seats <= 5;
        $isLowR = $rCls && $rCls->available_seats > 0 && $rCls->available_seats <= 5;

        $bookUrl = route('flight.details', [
          'id'            => $df->id,
          'depart_flight' => $df->id,
          'return_flight' => $rf->id,
          'depart_date'   => $selDate,
          'return_date'   => $retDate,
          'class'         => $selClass,
          'adults'        => $adults,
          'children'      => $children,
          'trip'          => 'round',
          'depart_class'  => $dCls ? $dCls->id : '',
          'return_class'  => $rCls ? $rCls->id : '',
        ]);
      @endphp

      <div class="flight-item"
           data-price="{{ $totalPrice }}"
           data-stops="{{ $dStop }}"
           data-dur="{{ $dMins }}"
           data-airline="{{ $df->airline_name }}"
           id="pair-{{ $pairIdx }}">
        <div class="rtcard">

          <div class="rt-leg-strip depart">
            <i class="fa-solid fa-plane-departure"></i>
            Depart · {{ \Carbon\Carbon::parse($selDate)->format('D, d M Y') }}
            <span class="rt-leg-date">{{ $fromText ?: $df->from_airport_code }} → {{ $toText ?: $df->to_airport_code }}</span>
          </div>

          <div class="rt-flight-row">
            <div class="rt-airline-block">
              <div class="rt-al-logo">
                @if($df->airline_logo)
                  <img src="{{ asset($df->airline_logo) }}" alt="{{ $df->airline_name }}"
                       onerror="this.style.display='none';this.parentElement.textContent='{{ strtoupper(substr($df->airline_code,0,2)) }}';">
                @else{{ strtoupper(substr($df->airline_code, 0, 2)) }}@endif
              </div>
              <div>
                <div class="rt-al-name">{{ $df->airline_name }}</div>
                <div class="rt-al-sub">
                  <span class="rt-al-flno">{{ $df->flight_number }}</span>
                  @if($df->aircraft_type)<span class="rt-al-ac">{{ $df->aircraft_type }}</span>@endif
                </div>
              </div>
            </div>

            <div class="rt-route">
              <div class="rt-ep">
                <div class="rt-ep-time">{{ $dDep->format('H:i') }}</div>
                <div class="rt-ep-iata">{{ $df->from_airport_code }}</div>
                <div class="rt-ep-airport" title="{{ $dFromAirport }}">{{ $dFromAirport }}</div>
              </div>
              <div class="rt-mid">
                <div class="rt-route-line">
                  <div class="rt-r-dot"></div><div class="rt-r-dash"></div>
                  <span class="rt-r-plane"><i class="fa-solid fa-plane"></i></span>
                  <div class="rt-r-dash"></div><div class="rt-r-dot"></div>
                </div>
                <span class="rt-dur-pill">{{ $dDiff->h }}h {{ $dDiff->i }}m</span>
                <span class="rt-stop-badge {{ $dStopBadge }}">
                  <i class="fa-solid {{ $dSc === 0 ? 'fa-circle-check' : 'fa-circle-dot' }}"></i>{{ $dStopLabel }}
                </span>
                @if(count($dStopovers))<div class="rt-stopover"><i class="fa-solid fa-clock"></i> layover @foreach($dStopovers as $city)<span class="sv-city">{{ $city }}</span>@endforeach</div>@endif
                @if($dON)<div class="rt-overnight"><i class="fa-solid fa-moon"></i> +1 day</div>@endif
              </div>
              <div class="rt-ep rt-ep-r">
                <div class="rt-ep-time">{{ $dArr->format('H:i') }}@if($dON)<sup style="font-size:.6rem;color:#f97316;vertical-align:super;">+1</sup>@endif</div>
                <div class="rt-ep-iata">{{ $df->to_airport_code }}</div>
                <div class="rt-ep-airport" title="{{ $dToAirport }}">{{ $dToAirport }}</div>
              </div>
            </div>

            <div class="rt-price-col">
              <span class="cls-chip"><i class="fa-solid fa-star" style="font-size:.5rem;"></i>{{ $selClass }}</span>
              <div class="rt-price-label">Outbound</div>
              <div class="rt-price-amt"><span class="rt-price-sup">$</span>{{ number_format($dPrice) }}</div>
              <div class="rt-price-sub">per adult</div>
              @if($dCls)
                <div class="rt-baggage">
                  <div class="rt-bag-row"><i class="fa-solid fa-briefcase"></i>{{ $dCls->cabin_baggage_kg }}kg cabin</div>
                  <div class="rt-bag-row"><i class="fa-solid fa-suitcase-rolling"></i>{{ $dCls->checkin_baggage_kg }}kg check-in</div>
                </div>
              @endif
            </div>
          </div>

          <div class="rt-leg-strip return-leg">
            <i class="fa-solid fa-plane-arrival"></i>
            Return · {{ \Carbon\Carbon::parse($retDate)->format('D, d M Y') }}
            <span class="rt-leg-date">{{ $toText ?: $rf->from_airport_code }} → {{ $fromText ?: $rf->to_airport_code }}</span>
          </div>

          <div class="rt-flight-row">
            <div class="rt-airline-block">
              <div class="rt-al-logo">
                @if($rf->airline_logo)
                  <img src="{{ asset($rf->airline_logo) }}" alt="{{ $rf->airline_name }}"
                       onerror="this.style.display='none';this.parentElement.textContent='{{ strtoupper(substr($rf->airline_code,0,2)) }}';">
                @else{{ strtoupper(substr($rf->airline_code, 0, 2)) }}@endif
              </div>
              <div>
                <div class="rt-al-name">{{ $rf->airline_name }}</div>
                <div class="rt-al-sub">
                  <span class="rt-al-flno">{{ $rf->flight_number }}</span>
                  @if($rf->aircraft_type)<span class="rt-al-ac">{{ $rf->aircraft_type }}</span>@endif
                </div>
              </div>
            </div>

            <div class="rt-route">
              <div class="rt-ep">
                <div class="rt-ep-time">{{ $rDep->format('H:i') }}</div>
                <div class="rt-ep-iata">{{ $rf->from_airport_code }}</div>
                <div class="rt-ep-airport" title="{{ $rFromAirport }}">{{ $rFromAirport }}</div>
              </div>
              <div class="rt-mid">
                <div class="rt-route-line">
                  <div class="rt-r-dot"></div><div class="rt-r-dash"></div>
                  <span class="rt-r-plane"><i class="fa-solid fa-plane" style="transform:scaleX(-1);display:inline-block;"></i></span>
                  <div class="rt-r-dash"></div><div class="rt-r-dot"></div>
                </div>
                <span class="rt-dur-pill">{{ $rDiff->h }}h {{ $rDiff->i }}m</span>
                <span class="rt-stop-badge {{ $rStopBadge }}">
                  <i class="fa-solid {{ $rSc === 0 ? 'fa-circle-check' : 'fa-circle-dot' }}"></i>{{ $rStopLabel }}
                </span>
                @if(count($rStopovers))<div class="rt-stopover"><i class="fa-solid fa-clock"></i> layover @foreach($rStopovers as $city)<span class="sv-city">{{ $city }}</span>@endforeach</div>@endif
                @if($rON)<div class="rt-overnight"><i class="fa-solid fa-moon"></i> +1 day</div>@endif
              </div>
              <div class="rt-ep rt-ep-r">
                <div class="rt-ep-time">{{ $rArr->format('H:i') }}@if($rON)<sup style="font-size:.6rem;color:#f97316;vertical-align:super;">+1</sup>@endif</div>
                <div class="rt-ep-iata">{{ $rf->to_airport_code }}</div>
                <div class="rt-ep-airport" title="{{ $rToAirport }}">{{ $rToAirport }}</div>
              </div>
            </div>

            <div class="rt-price-col">
              <span class="cls-chip return-chip"><i class="fa-solid fa-star" style="font-size:.5rem;"></i>{{ $selClass }}</span>
              <div class="rt-price-label">Return</div>
              <div class="rt-price-amt return-price"><span class="rt-price-sup">$</span>{{ number_format($rPrice) }}</div>
              <div class="rt-price-sub">per adult</div>
              @if($rCls)
                <div class="rt-baggage">
                  <div class="rt-bag-row"><i class="fa-solid fa-briefcase"></i>{{ $rCls->cabin_baggage_kg }}kg cabin</div>
                  <div class="rt-bag-row"><i class="fa-solid fa-suitcase-rolling"></i>{{ $rCls->checkin_baggage_kg }}kg check-in</div>
                </div>
              @endif
            </div>
          </div>

          <div class="rt-footer">
            <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
              <div>
                <span class="rt-class-badge"><i class="fa-solid fa-star"></i> {{ $selClass }}</span>
                <div style="margin-top:6px;">
                  <div style="font-size:.62rem;color:var(--gray);font-weight:600;">Combined per adult</div>
                  <div style="font-family:var(--font-display);font-size:1.55rem;font-weight:800;color:var(--primary-dark);line-height:1;">
                    <span style="font-size:.82rem;font-weight:500;vertical-align:super;">$</span>{{ number_format($totalPrice) }}
                  </div>
                </div>
              </div>
              @if($totalPax > 1)
                <div style="width:1px;height:48px;background:var(--border);flex-shrink:0;"></div>
                <div>
                  <div style="font-size:.62rem;color:var(--gray);font-weight:600;">Total for {{ $totalPax }} traveller{{ $totalPax > 1 ? 's' : '' }}</div>
                  <div style="font-family:var(--font-display);font-size:1.25rem;font-weight:800;color:var(--navy);line-height:1;margin-top:2px;">
                    <span style="font-size:.75rem;font-weight:500;vertical-align:super;">$</span>{{ number_format($totalPerPax) }}
                  </div>
                  <div style="font-size:.64rem;color:var(--gray);margin-top:2px;">{{ $adults }} adult{{ $adults > 1 ? 's' : '' }}{{ $children ? ' + ' . $children . ' child' . ($children > 1 ? 'ren' : '') : '' }}</div>
                </div>
              @endif
            </div>
            <div class="rt-footer-right">
              @if($isLowD || $isLowR)
                <span class="seats-warn"><i class="fa-solid fa-fire"></i>
                  @if($isLowD) Only {{ $dCls->available_seats }} outbound seats left! @endif
                  @if($isLowR) Only {{ $rCls->available_seats }} return seats left! @endif
                </span>
              @endif
              <a href="{{ $bookUrl }}" class="btn-select-rt">
                <i class="fa-solid fa-check-circle"></i> Select <i class="fa-solid fa-arrow-right"></i>
              </a>
            </div>
          </div>

        </div>
      </div>
      @endforeach

      </div>{{-- #flightGrid --}}
      <div id="noResults" style="display:none;margin-top:12px;">
        <div class="empty-box"><div class="e-icon"><i class="fa-solid fa-magnifying-glass-minus"></i></div><h5>No Matching Flights</h5><p>Try adjusting the sidebar filters.</p></div>
      </div>

    {{-- ════ ONE-WAY CARDS ════ --}}
    @elseif(!$isRound && $displayFlights->count())
      <div class="d-flex flex-column gap-3" id="flightGrid">

      @foreach($displayFlights as $flight)
      @php
        $fDep = \Carbon\Carbon::parse($flight->departure_time);
        $fArr = \Carbon\Carbon::parse($flight->arrival_time);
        $fON  = (int)($flight->overnight_arrival ?? 0);
        if ($fON) { $fArr->addDay(); } elseif ($fArr->lessThan($fDep)) { $fArr->addDay(); }
        $fDiff = $fDep->diff($fArr);
        $fMins = $fDep->diffInMinutes($fArr);
        $fSc   = (int)$flight->stops;
        $fStop = $fSc === 0 ? 'nonstop' : ($fSc === 1 ? '1stop' : '2stop');
        $fStopLabel = $fSc === 0 ? 'Non-stop' : ($fSc === 1 ? '1 Stop' : $fSc . ' Stops');
        $fStopBadge = $fSc === 0 ? 'rt-stop-ns' : ($fSc === 1 ? 'rt-stop-1s' : 'rt-stop-2s');
        $fStopovers = $flight->stopover_cities ? json_decode($flight->stopover_cities, true) : [];
        $fCls        = $getClassPrice($flight, $selClass);
        $fPrice      = $fCls ? $fCls->total_price : 0;
        $fTotalPerPax = $fPrice * $totalPax;
        $fIsLow      = $fCls && $fCls->available_seats > 0 && $fCls->available_seats <= 5;
        $fFromAirport = $airportName($flight->from_airport_code);
        $fToAirport   = $airportName($flight->to_airport_code);
        $fBookUrl = route('flight.details', [
          'id'           => $flight->id,
          'depart_flight'=> $flight->id,
          'depart_date'  => $selDate,
          'class'        => $selClass,
          'adults'       => $adults,
          'children'     => $children,
          'trip'         => 'one-way',
          'depart_class' => $fCls ? $fCls->id : '',
        ]);
      @endphp

      <div class="flight-item"
           data-price="{{ $fPrice }}"
           data-stops="{{ $fStop }}"
           data-dur="{{ $fMins }}"
           data-airline="{{ $flight->airline_name }}">
        <div class="rtcard">

          <div class="rt-leg-strip depart">
            <i class="fa-solid fa-plane-departure"></i>
            {{ \Carbon\Carbon::parse($selDate)->format('D, d M Y') }}
            <span class="rt-leg-date">{{ $fromText ?: $flight->from_airport_code }} → {{ $toText ?: $flight->to_airport_code }}</span>
          </div>

          <div class="rt-flight-row">
            <div class="rt-airline-block">
              <div class="rt-al-logo">
                @if($flight->airline_logo)
                  <img src="{{ asset($flight->airline_logo) }}" alt="{{ $flight->airline_name }}"
                       onerror="this.style.display='none';this.parentElement.textContent='{{ strtoupper(substr($flight->airline_code,0,2)) }}';">
                @else{{ strtoupper(substr($flight->airline_code, 0, 2)) }}@endif
              </div>
              <div>
                <div class="rt-al-name">{{ $flight->airline_name }}</div>
                <div class="rt-al-sub">
                  <span class="rt-al-flno">{{ $flight->flight_number }}</span>
                  @if($flight->aircraft_type)<span class="rt-al-ac">{{ $flight->aircraft_type }}</span>@endif
                </div>
              </div>
            </div>

            <div class="rt-route">
              <div class="rt-ep">
                <div class="rt-ep-time">{{ $fDep->format('H:i') }}</div>
                <div class="rt-ep-iata">{{ $flight->from_airport_code }}</div>
                <div class="rt-ep-airport" title="{{ $fFromAirport }}">{{ $fFromAirport }}</div>
              </div>
              <div class="rt-mid">
                <div class="rt-route-line">
                  <div class="rt-r-dot"></div><div class="rt-r-dash"></div>
                  <span class="rt-r-plane"><i class="fa-solid fa-plane"></i></span>
                  <div class="rt-r-dash"></div><div class="rt-r-dot"></div>
                </div>
                <span class="rt-dur-pill">{{ $fDiff->h }}h {{ $fDiff->i }}m</span>
                <span class="rt-stop-badge {{ $fStopBadge }}">
                  <i class="fa-solid {{ $fSc === 0 ? 'fa-circle-check' : 'fa-circle-dot' }}"></i>{{ $fStopLabel }}
                </span>
                @if(count($fStopovers))<div class="rt-stopover"><i class="fa-solid fa-clock"></i> layover : @foreach($fStopovers as $city)<span class="sv-city">{{ $city }}</span>@endforeach</div>@endif
                @if($fON)<div class="rt-overnight"><i class="fa-solid fa-moon"></i> +1 day</div>@endif
              </div>
              <div class="rt-ep rt-ep-r">
                <div class="rt-ep-time">{{ $fArr->format('H:i') }}@if($fON)<sup style="font-size:.6rem;color:#f97316;vertical-align:super;">+1</sup>@endif</div>
                <div class="rt-ep-iata">{{ $flight->to_airport_code }}</div>
                <div class="rt-ep-airport" title="{{ $fToAirport }}">{{ $fToAirport }}</div>
              </div>
            </div>

            <div class="rt-price-col">
              <span class="cls-chip"><i class="fa-solid fa-star" style="font-size:.5rem;"></i>{{ $selClass }}</span>
              <div class="rt-price-label">One Way</div>
              <div class="rt-price-amt"><span class="rt-price-sup">$</span>{{ number_format($fPrice) }}</div>
              <div class="rt-price-sub">per adult</div>
              @if($fCls)
                <div class="rt-baggage">
                  <div class="rt-bag-row"><i class="fa-solid fa-briefcase"></i>{{ $fCls->cabin_baggage_kg }}kg cabin</div>
                  <div class="rt-bag-row"><i class="fa-solid fa-suitcase-rolling"></i>{{ $fCls->checkin_baggage_kg }}kg check-in</div>
                </div>
              @endif
            </div>
          </div>

          <div class="rt-footer">
            <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
              <div>
                <span class="rt-class-badge"><i class="fa-solid fa-star"></i> {{ $selClass }}</span>
                <div style="margin-top:6px;">
                  <div style="font-size:.62rem;color:var(--gray);font-weight:600;">Per adult</div>
                  <div style="font-family:var(--font-display);font-size:1.55rem;font-weight:800;color:var(--primary-dark);line-height:1;">
                    <span style="font-size:.82rem;font-weight:500;vertical-align:super;">$</span>{{ number_format($fPrice) }}
                  </div>
                </div>
              </div>
              @if($totalPax > 1)
                <div style="width:1px;height:48px;background:var(--border);flex-shrink:0;"></div>
                <div>
                  <div style="font-size:.62rem;color:var(--gray);font-weight:600;">Total for {{ $totalPax }} traveller{{ $totalPax > 1 ? 's' : '' }}</div>
                  <div style="font-family:var(--font-display);font-size:1.25rem;font-weight:800;color:var(--navy);line-height:1;margin-top:2px;">
                    <span style="font-size:.75rem;font-weight:500;vertical-align:super;">$</span>{{ number_format($fTotalPerPax) }}
                  </div>
                  <div style="font-size:.64rem;color:var(--gray);margin-top:2px;">{{ $adults }} adult{{ $adults > 1 ? 's' : '' }}{{ $children ? ' + ' . $children . ' child' . ($children > 1 ? 'ren' : '') : '' }}</div>
                </div>
              @endif
            </div>
            <div class="rt-footer-right">
              @if($fIsLow)<span class="seats-warn"><i class="fa-solid fa-fire"></i> Only {{ $fCls->available_seats }} seats left!</span>@endif
              <a href="{{ $fBookUrl }}" class="btn-select-rt">
                <i class="fa-solid fa-check-circle"></i> Select <i class="fa-solid fa-arrow-right"></i>
              </a>
            </div>
          </div>

        </div>
      </div>
      @endforeach

      </div>{{-- #flightGrid --}}
      <div id="noResults" style="display:none;margin-top:12px;">
        <div class="empty-box"><div class="e-icon"><i class="fa-solid fa-magnifying-glass-minus"></i></div><h5>No Matching Flights</h5><p>Try adjusting the sidebar filters.</p></div>
      </div>

    {{-- ════ EMPTY ════ --}}
    @else
      <div class="empty-box">
        <div class="e-icon"><i class="fa-solid fa-plane-circle-exclamation"></i></div>
        <h5>No Flights Found</h5>
        <p>Try different dates, routes, or a broader class selection.</p>
        <div style="margin-top:16px;">
          <a href="{{ route('flight.search') }}" style="display:inline-flex;align-items:center;gap:6px;background:var(--primary);color:#fff;border-radius:var(--r8);padding:10px 20px;font-family:var(--font-display);font-weight:700;font-size:.82rem;text-decoration:none;">
            <i class="fa-solid fa-search"></i> New Search
          </a>
        </div>
      </div>
    @endif

  </div>{{-- col-lg-9 --}}
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

let hfPax = { a: {{ $adults }}, c: {{ $children }} };

/* ═══════════════════════════════════════════════════════════════
   SINGLE DOMContentLoaded — all init logic here, nothing duplicated
═══════════════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', function () {

  // 1. Move TCC dropdown to body so it escapes overflow:hidden parents
  document.body.appendChild(document.getElementById('hfTccDrop'));

  // 2. Set initial disabled state for pax buttons
  document.getElementById('hfAdMinus').disabled = hfPax.a <= 1;
  document.getElementById('hfChMinus').disabled = hfPax.c <= 0;

  // 3. Stamp original sort index on every flight card — MUST happen before
  //    any sortCards() call so Default order can always be restored correctly
  const list = document.getElementById('flightGrid');
  if (list) {
    list.querySelectorAll('.flight-item').forEach((item, i) => {
      item.dataset.origIdx = i;
    });
  }

});

/* ─── TAB / TRIP HELPERS ──────────────────────────────────────── */
function switchTab(btn, panelId) {
  document.querySelectorAll('.sb-tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.sb-panel').forEach(p => p.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById(panelId).classList.add('active');
}

function setTrip(btn, t) {
  document.querySelectorAll('.trip-tab-inner').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('hfTripH').value = t;
  const rw = document.getElementById('hfReturnWrap');
  rw.style.display = t === 'round' ? '' : 'none';
  if (t === 'round') {
    const depart = document.getElementById('hfDepartDate').value;
    const ri = document.getElementById('hfReturnDate');
    ri.min = depart;
    if (!ri.value || ri.value < depart) ri.value = depart;
  }
}

function onDepartChange(input) {
  const r = document.getElementById('hfReturnDate');
  if (r) { r.min = input.value; if (r.value < input.value) r.value = input.value; }
}

function hfSwap() {
  const fi = document.getElementById('fromInput'), ti = document.getElementById('toInput');
  const fc = document.getElementById('fromCode'),  tc = document.getElementById('toCode');
  [fi.value, ti.value] = [ti.value, fi.value];
  [fc.value, tc.value] = [tc.value, fc.value];
}

/* ─── TCC DROPDOWN ────────────────────────────────────────────── */
function positionDrop() {
  const trigger = document.getElementById('hfTccTrigger');
  const drop    = document.getElementById('hfTccDrop');
  const rect    = trigger.getBoundingClientRect();
  const vw      = window.innerWidth;
  const isMobile = vw < 768;

  if (isMobile) {
    const dropH      = drop.offsetHeight || 320;
    const spaceBelow = window.innerHeight - rect.bottom - 8;
    const spaceAbove = rect.top - 8;
    drop.style.left     = '12px';
    drop.style.right    = '12px';
    drop.style.width    = (vw - 24) + 'px';
    drop.style.minWidth = '';
    if (spaceBelow >= dropH || spaceBelow >= spaceAbove) {
      drop.style.top    = (rect.bottom + 8) + 'px';
      drop.style.bottom = 'auto';
    } else {
      drop.style.bottom = (window.innerHeight - rect.top + 8) + 'px';
      drop.style.top    = 'auto';
    }
  } else {
    drop.style.top      = (rect.bottom + 8) + 'px';
    drop.style.bottom   = 'auto';
    drop.style.left     = rect.left + 'px';
    drop.style.right    = 'auto';
    drop.style.width    = '';
    drop.style.minWidth = Math.max(310, rect.width) + 'px';
  }
}

function toggleTcc(e) {
  e.stopPropagation();
  const drop    = document.getElementById('hfTccDrop');
  const trigger = document.getElementById('hfTccTrigger');
  if (drop.classList.contains('open')) {
    drop.classList.remove('open');
    trigger.classList.remove('open');
    document.removeEventListener('click', closeTccOut);
  } else {
    positionDrop();
    drop.classList.add('open');
    trigger.classList.add('open');
    setTimeout(() => document.addEventListener('click', closeTccOut), 0);
  }
}

function closeTccOut(e) {
  const drop    = document.getElementById('hfTccDrop');
  const trigger = document.getElementById('hfTccTrigger');
  if (!drop.contains(e.target) && !trigger.contains(e.target)) {
    drop.classList.remove('open');
    trigger.classList.remove('open');
    document.removeEventListener('click', closeTccOut);
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
  const cls   = document.getElementById('hfCabinSel').value;
  const parts = [hfPax.a + ' Adult' + (hfPax.a > 1 ? 's' : '')];
  if (hfPax.c) parts.push(hfPax.c + ' Child' + (hfPax.c > 1 ? 'ren' : ''));
  parts.push(cls);
  document.getElementById('hfTccVal').textContent = parts.join(', ');
}

function applyHfTcc() {
  updateHfTcc();
  document.getElementById('hfTccDrop').classList.remove('open');
  document.getElementById('hfTccTrigger').classList.remove('open');
  document.removeEventListener('click', closeTccOut);
}

function syncBeforeSubmit() {
  document.getElementById('hfAdultsH').value   = hfPax.a;
  document.getElementById('hfChildrenH').value = hfPax.c;
  document.getElementById('hfClassH').value    = document.getElementById('hfCabinSel').value;
}

window.addEventListener('scroll', () => {
  if (document.getElementById('hfTccDrop').classList.contains('open')) positionDrop();
}, { passive: true });
window.addEventListener('resize', () => {
  if (document.getElementById('hfTccDrop').classList.contains('open')) positionDrop();
}, { passive: true });

/* ─── AIRPORT AUTOCOMPLETE ────────────────────────────────────── */
(function () {
  const SEARCH_URL = '{{ route("airports.search") }}';
  const FIELDS = [
    ['fromInput', 'fromDropdown', 'fromCode'],
    ['toInput',   'toDropdown',   'toCode'  ],
  ];

  function esc(str) {
    return String(str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

  FIELDS.forEach(([inputId, dropId, codeId]) => {
    const input      = document.getElementById(inputId);
    const dropdown   = document.getElementById(dropId);
    const codeHidden = document.getElementById(codeId);
    if (!input || !dropdown || !codeHidden) return;

    let debounce = null, lastQuery = '';

    function render(airports) {
      if (!airports.length) {
        dropdown.innerHTML = `<div class="autocomplete-item no-result">
          <i class="fa-solid fa-circle-info"></i> No airports found</div>`;
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

    function selectItem(item) {
      input.value      = `${item.dataset.city} (${item.dataset.code})`;
      codeHidden.value = item.dataset.code;
      lastQuery        = input.value;
      hide();
      input.focus();
    }

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
      if (item) selectItem(item);
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
        if (h) { e.preventDefault(); selectItem(h); }
      } else if (e.key === 'Escape') {
        hide();
      }
    });

    document.addEventListener('click', function (e) {
      if (!input.contains(e.target) && !dropdown.contains(e.target)) hide();
    });
  });
})();

/* ═══════════════════════════════════════════════════════════════
   SIDEBAR FILTERS
═══════════════════════════════════════════════════════════════ */
let activeStop = 'all';

function fStop(el, t) {
  document.querySelectorAll('.stop-pill').forEach(p => p.classList.remove('active'));
  el.classList.add('active');
  activeStop = t;
  runFilters();
}

function runFilters() {
  const checkedAirlines = Array.from(document.querySelectorAll('.al-cb'))
    .filter(c => c.checked).map(c => c.value);
  let vis = 0;
  document.querySelectorAll('.flight-item').forEach(item => {
    const inStop = activeStop === 'all' || item.dataset.stops === activeStop;
    const inAl   = checkedAirlines.includes(item.dataset.airline);
    const show   = inStop && inAl;
    item.style.display = show ? '' : 'none';
    if (show) vis++;
  });
  document.getElementById('visCount').textContent = vis;
  const nr = document.getElementById('noResults');
  if (nr) nr.style.display = vis === 0 ? 'block' : 'none';
}

/* ─── SORT ────────────────────────────────────────────────────── */
function sortCards(val) {
  const list = document.getElementById('flightGrid');
  if (!list) return;

  const items = Array.from(list.querySelectorAll('.flight-item'));

  items.sort((a, b) => {
    const pa = parseFloat(a.dataset.price) || 0;
    const pb = parseFloat(b.dataset.price) || 0;
    if (val === 'price_asc')  return pa - pb;
    if (val === 'price_desc') return pb - pa;
    return (parseInt(a.dataset.origIdx) || 0) - (parseInt(b.dataset.origIdx) || 0);
  });

  items.forEach(item => list.appendChild(item));
}

function resetFilters() {
  activeStop = 'all';
  document.querySelectorAll('.stop-pill').forEach((p, i) => p.classList.toggle('active', i === 0));
  document.querySelectorAll('.al-cb').forEach(c => c.checked = true);
  document.querySelectorAll('.flight-item').forEach(i => i.style.display = '');
  document.getElementById('visCount').textContent = document.querySelectorAll('.flight-item').length;
  const nr = document.getElementById('noResults');
  if (nr) nr.style.display = 'none';
}
</script>

@endsection