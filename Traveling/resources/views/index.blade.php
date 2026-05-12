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

/* ── SEARCH BOX ── */
.search-box{
  width:85%;max-width:1200px;min-width:320px;
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
.sf-select{width:100%;padding:11px 12px;border:1.5px solid var(--border);border-radius:12px;font-family:var(--font-main);font-size:.88rem;font-weight:500;color:var(--navy);background:#FAFBFF;outline:none;transition:border-color .2s;}
.sb-swap{display:flex;align-items:flex-end;padding-bottom:2px;}
.swap-btn{width:36px;height:36px;border-radius:50%;background:var(--primary-light);border:2px solid var(--primary);color:var(--primary);font-size:14px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .2s,transform .2s;flex-shrink:0;}
.swap-btn:hover{background:var(--primary);color:#fff;transform:rotate(180deg);}
.sb-row{display:flex;gap:10px;width:100%;align-items:flex-end;flex-wrap:wrap;}
.sb-row+.sb-row{margin-top:10px;}

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
.tcc-drop{position:fixed;top:0;left:0;min-width:310px;background:rgba(255,255,255,.98);backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);border:1.5px solid rgba(191,219,254,.8);border-radius:18px;box-shadow:0 32px 80px rgba(0,0,0,.25),0 8px 24px rgba(29,78,216,.16),0 0 0 1px rgba(255,255,255,.6) inset;z-index:999999;display:none;overflow:hidden;}
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
.sb-search-btn{height:46px;padding:0 26px;background:linear-gradient(135deg,var(--primary-mid),var(--primary-dark));color:#fff;border:none;border-radius:12px;font-family:var(--font-display);font-size:.86rem;font-weight:700;display:flex;align-items:center;gap:7px;cursor:pointer;transition:transform .15s,box-shadow .15s;white-space:nowrap;flex-shrink:0;}
.sb-search-btn:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(29,78,216,.38);}

/* ── AUTOCOMPLETE ── */
.autocomplete-dropdown{position:absolute;top:calc(100% + 6px);left:0;width:100%;background:#fff;border:1.5px solid #bfdbfe;border-radius:14px;box-shadow:0 12px 40px rgba(0,0,0,.12),0 4px 12px rgba(29,78,216,.08);max-height:280px;overflow-y:auto;z-index:99999;padding:6px;display:flex;flex-direction:column;gap:2px;}
.autocomplete-item{padding:8px 10px;border-radius:10px;cursor:pointer;transition:background .12s;}
.autocomplete-item:hover,.autocomplete-item.hovered{background:#eff6ff;}
.autocomplete-item.no-result{color:#94a3b8;cursor:default;font-size:.82rem;}
.ac-inner{display:flex;align-items:center;gap:10px;}
.ac-code-box{min-width:46px;height:46px;background:#eff6ff;border:1.5px solid #bfdbfe;border-radius:10px;display:flex;align-items:center;justify-content:center;font-family:'Sora',sans-serif;font-size:.72rem;font-weight:800;color:#1d4ed8;letter-spacing:.04em;flex-shrink:0;}
.ac-detail-name{font-weight:700;font-size:.84rem;color:#0f172a;line-height:1.25;}
.ac-detail-city{font-size:.72rem;color:#64748b;margin-top:2px;display:flex;align-items:center;gap:4px;}

/* ── LISTINGS SECTION ── */
.listings{padding:52px 0 80px;background:var(--bg);}
.section-head{text-align:center;margin-bottom:40px;}
.section-head h2{font-family:var(--font-display);font-size:clamp(24px,3.5vw,36px);font-weight:800;color:var(--navy);margin-bottom:6px;}
.section-head p{color:var(--gray);font-size:15px;}
.listing-panel{display:none;}
.listing-panel.active{display:block;}

/* ══════════════════════════════════════════
   FLIGHT CARD — UPGRADED
══════════════════════════════════════════ */
.rtcard{
  background:#fff;
  border-radius:var(--r16);
  border:1.5px solid var(--border);
  overflow:hidden;
  transition:transform .2s,box-shadow .2s,border-color .2s;
  position:relative;
}
.rtcard:hover{
  transform:translateY(-4px);
  box-shadow:0 20px 56px rgba(29,78,216,.12),0 4px 16px rgba(0,0,0,.07);
  border-color:#bfdbfe;
}

/* ── CARD HEADER ── */
.rt-card-header{
  display:flex;
  align-items:center;
  justify-content:space-between;
  padding:10px 20px;
  background:linear-gradient(90deg,#eff6ff 0%,#dbeafe 100%);
  border-bottom:1.5px solid #bfdbfe;
  gap:12px;
}
.rt-header-left{
  display:flex;
  align-items:center;
  gap:8px;
  flex-shrink:0;
}
.rt-header-left i{
  font-size:.75rem;
  color:var(--primary-dark);
}
.rt-header-dep-label{
  font-size:.65rem;
  font-weight:800;
  letter-spacing:.09em;
  text-transform:uppercase;
  color:var(--primary-dark);
}
.rt-header-date{
  font-size:.68rem;
  font-weight:600;
  color:#3b5fc0;
  opacity:.85;
}
/* route pill + stop badge together on the right */
.rt-header-right{
  display:flex;
  align-items:center;
  gap:8px;
  flex-shrink:0;
}
.rt-route-pill{
  display:flex;
  align-items:center;
  gap:6px;
  background:#fff;
  border:1.5px solid #bfdbfe;
  border-radius:100px;
  padding:4px 14px 4px 10px;
  font-size:.74rem;
  font-weight:800;
  color:var(--primary-dark);
  letter-spacing:.05em;
}
.rt-route-pill i{
  font-size:.68rem;
  color:var(--primary);
}
/* stop badge in header */
.rt-hdr-stop{
  font-size:.63rem;
  font-weight:800;
  padding:4px 11px;
  border-radius:100px;
  display:inline-flex;
  align-items:center;
  gap:4px;
  white-space:nowrap;
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

.rt-airline-block{
  display:flex;
  align-items:center;
  gap:10px;
  min-width:170px;
}
.rt-al-logo{
  width:42px;height:42px;
  border-radius:var(--r8);
  background:#fff;
  border:1.5px solid #dde3f0;
  display:flex;align-items:center;justify-content:center;
  overflow:hidden;flex-shrink:0;
  font-size:.58rem;font-weight:800;color:var(--primary);
  letter-spacing:.04em;text-align:center;line-height:1.2;
}
.rt-al-logo img{width:100%;height:100%;object-fit:contain;padding:3px;}
.rt-al-name{font-family:var(--font-display);font-weight:700;font-size:.82rem;color:var(--navy);}
.rt-al-sub{font-size:.68rem;color:var(--gray);margin-top:2px;display:flex;align-items:center;gap:5px;}
.rt-al-flno{font-weight:600;color:var(--slate);}
.rt-al-ac{background:#f1f5f9;border:1px solid var(--border);padding:2px 6px;border-radius:4px;font-size:.62rem;font-weight:700;}

/* ── ROUTE SECTION ── */
.rt-route{
  flex:1;
  display:flex;
  align-items:center;
  padding:0 12px;
  min-width:0;
}

/* endpoint blocks — both centered */
.rt-ep{
  display:flex;
  flex-direction:column;
  align-items:center;
  text-align:center;
  min-width:0;
}

/* time with superscript AM/PM */
.rt-ep-time-wrap{
  display:flex;
  align-items:flex-start;
  gap:2px;
  line-height:1;
}
.rt-ep-time{
  font-family:var(--font-display);
  font-size:1.38rem;
  font-weight:800;
  color:var(--navy);
  line-height:1;
}
.rt-ep-ampm{
  font-size:.58rem;
  font-weight:700;
  color:var(--gray);
  margin-top:1px;
  line-height:1;
  letter-spacing:.04em;
}
/* timezone below time */
.rt-ep-tz{
  font-size:.6rem;
  font-weight:600;
  color:#94a3b8;
  letter-spacing:.04em;
  margin-top:15px;
  margin-left:-18px;
  line-height:1;
}
.rt-ep-iata{
  font-size:.8rem;
  font-weight:800;
  color:var(--primary);
  margin-top:5px;
  letter-spacing:.06em;
}
.rt-ep-city{
  font-size:.64rem;
  color:var(--gray);
  margin-top:2px;
  font-weight:500;
  line-height:1.3;
  max-width:110px;
}

/* middle connector */
.rt-mid{
  flex:1;
  display:flex;
  flex-direction:column;
  align-items:center;
  gap:6px;
  padding:0 10px;
  min-width:0;
}
.rt-route-line{display:flex;align-items:center;width:100%;gap:3px;}
.rt-r-dot{width:6px;height:6px;border-radius:50%;border:2px solid var(--primary);background:#fff;flex-shrink:0;}
.rt-r-dash{flex:1;height:2px;background:repeating-linear-gradient(90deg,var(--primary) 0,var(--primary) 4px,transparent 4px,transparent 9px);}
.rt-r-plane{font-size:.76rem;color:var(--primary);}
.rt-dur-pill{
  background:var(--primary-light);
  color:var(--primary-mid);
  font-size:.66rem;
  font-weight:700;
  padding:3px 10px;
  border-radius:100px;
  white-space:nowrap;
}
.rt-stopover{
  display:inline-flex;align-items:center;justify-content:center;gap:4px;
  background:#fffbeb;border:1px solid #fde68a;color:#92400e;
  font-size:.64rem;font-weight:600;padding:3px 10px;border-radius:6px;
  text-align:center;line-height:1.4;
}
.rt-overnight{
  display:inline-flex;align-items:center;gap:4px;
  background:#f0f9ff;border:1px solid #bae6fd;color:#0369a1;
  font-size:.64rem;font-weight:600;padding:3px 10px;border-radius:6px;
}
.sv-city{
  background:#fef3c7;border:1px solid #fde68a;
  padding:1px 7px;border-radius:100px;
  font-size:.62rem;font-weight:700;color:#78350f;white-space:nowrap;
}

/* ── PRICE COL ── */
.rt-price-col{
  text-align:right;
  min-width:120px;
  flex-shrink:0;
  padding-left:10px;
  border-left:1.5px solid var(--border);
  margin-left:8px;
}
.cls-chip{
  display:inline-flex;align-items:center;gap:3px;
  background:var(--primary-pale);color:var(--primary-dark);
  font-size:.58rem;font-weight:800;letter-spacing:.06em;
  padding:3px 9px;border-radius:100px;text-transform:uppercase;
  margin-bottom:5px;
}
.rt-price-label{font-size:.6rem;font-weight:800;color:var(--gray);text-transform:uppercase;letter-spacing:.07em;}
.rt-price-amt{
  font-family:var(--font-display);
  font-size:1.15rem;font-weight:800;color:var(--primary-dark);
}
.rt-price-sup{font-size:.75rem;font-weight:500;vertical-align:super;}
.rt-price-sub{font-size:.62rem;color:var(--gray);margin-top:1px;}
/* baggage chips */
.rt-baggage{
  display:flex;
  flex-direction:column;
  gap:4px;
  margin-top:8px;
  align-items:flex-end;
}
.rt-bag-chip{
  display:inline-flex;
  align-items:center;
  gap:4px;
  background:#f8faff;
  border:1px solid #e0e7ff;
  border-radius:7px;
  padding:3px 8px;
}
.rt-bag-chip i{color:var(--primary);font-size:.58rem;}
.rt-bag-chip span{font-size:.62rem;font-weight:600;color:var(--slate);}

/* ── FOOTER ── */
.rt-footer{
  padding:13px 20px 15px;
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:16px;
  background:linear-gradient(135deg,#f8faff 0%,#eef4ff 100%);
  border-top:1.5px solid #e8edf8;
  flex-wrap:wrap;
}
.rt-class-badge{
  display:inline-flex;align-items:center;gap:4px;
  background:var(--primary-pale);color:var(--primary-dark);
  font-size:.62rem;font-weight:800;letter-spacing:.07em;
  padding:3px 10px;border-radius:100px;text-transform:uppercase;
}
.seats-warn{display:flex;align-items:center;gap:5px;font-size:.7rem;font-weight:700;color:#dc2626;}
.rt-footer-right{display:flex;flex-direction:column;align-items:flex-end;gap:7px;}
.btn-select-rt{
  background:linear-gradient(135deg,var(--primary-mid),var(--primary-dark));
  color:#fff;border:none;border-radius:var(--r8);
  padding:11px 26px;font-family:var(--font-display);font-weight:700;font-size:.84rem;
  display:inline-flex;align-items:center;gap:7px;
  white-space:nowrap;cursor:pointer;text-decoration:none;
  transition:transform .14s,box-shadow .14s;
}
.btn-select-rt:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(29,78,216,.4);color:#fff;}

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

/* ── EMPTY ── */
.empty-box{text-align:center;padding:64px 20px;background:#fff;border-radius:var(--r16);border:2px dashed var(--border);}
.e-icon{width:64px;height:64px;border-radius:50%;background:var(--primary-light);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;}
.e-icon i{font-size:1.6rem;color:var(--primary);}
.empty-box h5{font-family:var(--font-display);font-weight:800;color:var(--navy);margin-bottom:6px;}
.empty-box p{color:var(--gray);font-size:.88rem;}

/* ── RESPONSIVE ── */
@media(max-width:1100px){.search-box{width:92%;}}
@media(max-width:991px){.search-box{width:96%;}}
@media(max-width:768px){
  .search-box{width:100%;}
  .sb-tab{font-size:11px;padding:10px 6px;}
  .sb-tab .tab-icon{width:32px;height:32px;font-size:16px;}
  .sb-swap{display:none;}
  .sb-search-btn{width:100%;justify-content:center;}
  .rt-card-header{flex-wrap:wrap;gap:8px;padding:10px 14px;}
  .rt-header-right{flex-wrap:wrap;}
  .rt-flight-row{padding:14px;flex-direction:column;align-items:stretch;gap:14px;}
  .rt-airline-block{min-width:unset;width:100%;}
  .rt-route{padding:0;width:100%;}
  .rt-ep-time{font-size:1.1rem;}
  .rt-ep-city{font-size:.6rem;max-width:80px;}
  .rt-mid{padding:0 6px;}
  .rt-price-col{
    text-align:left;min-width:unset;padding-left:0;
    border-left:none;margin-left:0;
    border-top:1.5px solid var(--border);padding-top:12px;
    display:flex;flex-wrap:wrap;align-items:center;gap:12px;
  }
  .rt-baggage{flex-direction:row;align-items:flex-start;}
  .rt-footer{flex-direction:column;align-items:stretch;gap:12px;padding:12px 14px;}
  .rt-footer-right{flex-direction:row;align-items:center;justify-content:space-between;}
  .btn-select-rt{padding:10px 20px;font-size:.8rem;}
}
@media(max-width:576px){
  .sb-panel{padding:16px;}
  .sb-fields{flex-direction:column;}
  .sb-row{flex-direction:column;}
}
@media(max-width:480px){
  .rt-ep-time{font-size:1rem;}
}
</style>

{{-- ═══ HERO ═══ --}}
<section class="hero">
  <div class="slide active"></div>
  <div class="slide"></div>
  <div class="slide"></div>
  <div class="hero-overlay"></div>

  <div class="hero-search-wrap">
    <div class="search-box">

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

      {{-- FLIGHTS PANEL --}}
      <div class="sb-panel active" id="sp-flights">
        <div class="trip-tabs-inner">
          <button class="trip-tab-inner active" onclick="setTrip(this,'one-way')">
            <i class="fa-solid fa-arrow-right"></i>One Way
          </button>
          <button class="trip-tab-inner" onclick="setTrip(this,'round')">
            <i class="fa-solid fa-arrows-left-right"></i>Round Trip
          </button>
        </div>

        <form method="GET" action="{{ route('flight.search') }}" id="homeFlightForm" onsubmit="syncBeforeSubmit()">
          <input type="hidden" name="adults"   id="hfAdultsH"   value="1">
          <input type="hidden" name="children" id="hfChildrenH" value="0">
          <input type="hidden" name="class"    id="hfClassH"    value="Economy">
          <input type="hidden" name="trip"     id="hfTripH"     value="one-way">

          <div class="sb-fields">
            <div class="sb-field" style="flex:1.3;">
              <label>From</label>
              <div class="sf-wrap" style="position:relative;">
                <i class="sf-icon-abs fa-solid fa-plane-departure"></i>
                <input type="text" id="fromInput" name="from" class="sf-inp" placeholder="City or airport" value="{{ old('from') }}" autocomplete="off">
                <div id="fromDropdown" class="autocomplete-dropdown" style="display:none;"></div>
                <input type="hidden" name="from_code" id="fromCode" value="{{ old('from_code') }}">
              </div>
            </div>

            <div class="sb-swap">
              <button type="button" class="swap-btn" onclick="hfSwap()" title="Swap">⇄</button>
            </div>

            <div class="sb-field" style="flex:1.3;">
              <label>To</label>
              <div class="sf-wrap" style="position:relative;">
                <i class="sf-icon-abs fa-solid fa-plane-arrival"></i>
                <input type="text" id="toInput" name="to" class="sf-inp" placeholder="City or airport" value="{{ old('to') }}" autocomplete="off">
                <div id="toDropdown" class="autocomplete-dropdown" style="display:none;"></div>
                <input type="hidden" name="to_code" id="toCode" value="{{ old('to_code') }}">
              </div>
            </div>

            <div class="sb-field">
              <label>Depart</label>
              <input type="date" name="depart" id="hfDepartDate" class="sf-date"
                     value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}"
                     onchange="onDepartChange(this)">
            </div>

            <div class="sb-field" id="hfReturnWrap" style="display:none;">
              <label>Return</label>
              <input type="date" name="return" id="hfReturnDate" class="sf-date"
                     value="{{ date('Y-m-d', strtotime('+7 days')) }}"
                     min="{{ date('Y-m-d', strtotime('+1 day')) }}">
            </div>

            <div class="sb-field tcc-wrap" style="flex:1.4;">
              <label>Travellers &amp; Class</label>
              <div class="tcc-trigger" id="hfTccTrigger" onclick="toggleTcc(event)">
                <i class="fa-solid fa-users tcc-icon"></i>
                <div class="tcc-text">
                  <span class="tcc-val" id="hfTccVal">1 Adult, Economy</span>
                </div>
                <i class="fa-solid fa-chevron-down tcc-chev"></i>
              </div>
            </div>

            <button type="submit" class="sb-search-btn">
              <i class="fa-solid fa-magnifying-glass"></i>Search Flights
            </button>
          </div>
        </form>
      </div>

      {{-- HOTELS PANEL --}}
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
            <select class="sf-select"><option>1 Room, 1 Guest</option><option>1 Room, 2 Guests</option><option>2 Rooms, 4 Guests</option></select>
          </div>
          <button class="sb-search-btn"><i class="fa-solid fa-magnifying-glass"></i>Search Hotels</button>
        </div>
      </div>

      {{-- TOURS PANEL --}}
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
          <div class="sb-field"><label>Duration</label><select class="sf-select"><option>Any</option><option>3–5 Days</option><option>6–8 Days</option><option>9–14 Days</option><option>15+ Days</option></select></div>
          <div class="sb-field" style="flex:0.7;"><label>Travellers</label><select class="sf-select"><option>1</option><option>2</option><option>3–5</option><option>6+</option></select></div>
          <button class="sb-search-btn"><i class="fa-solid fa-magnifying-glass"></i>Search Tours</button>
        </div>
      </div>

      {{-- CARS PANEL --}}
      <div class="sb-panel" id="sp-cars">
        <div class="sb-row" style="margin-bottom:10px;">
          <div class="sb-field" style="flex:1.5;"><label>Pick-up Location</label><div class="sf-wrap"><i class="sf-icon-abs fa-solid fa-car"></i><input type="text" class="sf-inp" placeholder="Airport, city or address"></div></div>
          <div class="sb-field" style="flex:1.5;"><label>Drop-off Location</label><div class="sf-wrap"><i class="sf-icon-abs fa-solid fa-flag-checkered"></i><input type="text" class="sf-inp" placeholder="Same as pick-up"></div></div>
        </div>
        <div class="sb-row">
          <div class="sb-field"><label>Pick-up Date</label><input type="date" class="sf-date" id="carPickupDate" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" onchange="validateCarDates()"></div>
          <div class="sb-field"><label>Pick-up Time</label><input type="time" class="sf-date" value="10:00"></div>
          <div class="sb-field"><label>Drop-off Date</label><input type="date" class="sf-date" id="carDropDate" min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ date('Y-m-d', strtotime('+1 day')) }}" onchange="validateCarDates()"></div>
          <div class="sb-field"><label>Drop-off Time</label><input type="time" class="sf-date" value="10:00"></div>
          <div class="sb-field"><label>Car Type</label><select class="sf-select"><option value="">Any Type</option><option>Economy</option><option>Compact</option><option>SUV</option><option>Luxury</option><option>Van / MPV</option><option>Electric</option></select></div>
          <button class="sb-search-btn"><i class="fa-solid fa-magnifying-glass"></i>Search Cars</button>
        </div>
      </div>

    </div>{{-- /search-box --}}
  </div>
</section>

{{-- TCC DROPDOWN — appended to body by JS --}}
<div class="tcc-drop" id="hfTccDrop">
  <div class="tcc-sec">
    <span class="tcc-slbl">Cabin Class</span>
    <select class="cabin-sel" id="hfCabinSel" onchange="updateHfTcc()">
      <option value="Economy">Economy</option>
      <option value="Premium Economy">Premium Economy</option>
      <option value="Business">Business</option>
      <option value="First">First</option>
    </select>
  </div>
  <div class="tcc-sec">
    <span class="tcc-slbl">Passengers</span>
    <div class="pax-row">
      <div class="pax-info"><strong>Adults</strong><small>Aged 18+</small></div>
      <div class="pax-ctrl">
        <button type="button" class="pax-btn" id="hfAdMinus" onclick="chHfPax('a',-1)">−</button>
        <span class="pax-count" id="hfAdCnt">1</span>
        <button type="button" class="pax-btn" onclick="chHfPax('a',1)">+</button>
      </div>
    </div>
    <div class="pax-row">
      <div class="pax-info"><strong>Children</strong><small>Aged 0–17</small></div>
      <div class="pax-ctrl">
        <button type="button" class="pax-btn" id="hfChMinus" onclick="chHfPax('c',-1)">−</button>
        <span class="pax-count" id="hfChCnt">0</span>
        <button type="button" class="pax-btn" onclick="chHfPax('c',1)">+</button>
      </div>
    </div>
  </div>
  <div class="tcc-note">Age at time of travel must be valid for the booked category.</div>
  <button class="btn-apply" onclick="applyHfTcc()">Done</button>
</div>

{{-- ═══ LISTINGS ═══ --}}
<section class="listings" id="listingsSection">
<div class="container-xl">

  <div class="section-head">
    <h2 id="listing-title">Trending Flights</h2>
    <p id="listing-sub">Best deals on flights handpicked for you</p>
  </div>

  {{-- ── FLIGHTS ── --}}
  <div class="listing-panel active" id="lp-flights">
    @if($flights->isEmpty())
      <div class="empty-box">
        <div class="e-icon"><i class="fa-solid fa-plane-circle-xmark"></i></div>
        <h5>No Flights Available</h5>
        <p>Use the search above to find available flights.</p>
      </div>
    @else
      <div class="d-flex flex-column gap-3">
        @foreach($flights as $flight)
        @php
          $fDep  = \Carbon\Carbon::parse($flight->departure_time);
          $fArr  = \Carbon\Carbon::parse($flight->arrival_time);
          $fON   = (int)($flight->overnight_arrival ?? 0);
          if ($fON) { $fArr->addDay(); } elseif ($fArr->lessThan($fDep)) { $fArr->addDay(); }
          $fDiff = $fDep->diff($fArr);
          $fSc   = (int)$flight->stops;
          $fStop = $fSc === 0 ? 'nonstop' : ($fSc === 1 ? '1stop' : '2stop');
          $fStopLabel = $fSc === 0 ? 'Non-stop' : ($fSc === 1 ? '1 Stop' : $fSc . ' Stops');
          $fStopBadge = $fSc === 0 ? 'rt-stop-ns' : ($fSc === 1 ? 'rt-stop-1s' : 'rt-stop-2s');
          $fStopIcon  = $fSc === 0 ? 'fa-circle-check' : 'fa-circle-dot';
          $fStopovers = $flight->stopover_cities ? json_decode($flight->stopover_cities, true) : [];
          $fCls   = $flight->flightClasses->firstWhere('class_type','Economy')
                    ?? $flight->flightClasses->sortBy('total_price')->first();
          $fPrice = $fCls ? $fCls->base_price : 0;
          $fIsLow = $fCls && $fCls->available_seats > 0 && $fCls->available_seats <= 5;
          $fBookUrl = route('flight.details', [
            'id'            => $flight->id,
            'depart_flight' => $flight->id,
            'depart_date'   => date('Y-m-d'),
            'class'         => 'Economy',
            'adults'        => 1,
            'children'      => 0,
            'trip'          => 'one-way',
            'depart_class'  => $fCls ? $fCls->id : '',
          ]);
        @endphp

        <div class="rtcard">

          {{-- ── CARD HEADER: left = label+date | right = route pill + stop badge ── --}}
          <div class="rt-card-header">
            <div class="rt-header-left">
              <i class="fa-solid fa-plane-departure"></i>
              <span class="rt-header-dep-label">Departure</span>
              <span class="rt-header-date">{{ $fDep->format('D, d M Y') }}</span>
            </div>
            <div class="rt-header-right">
              <div class="rt-route-pill">
                {{ $flight->from_airport_code }}
                <i class="fa-solid fa-arrow-right"></i>
                {{ $flight->to_airport_code }}
              </div>
              <span class="rt-hdr-stop {{ $fStopBadge }}">
                <i class="fa-solid {{ $fStopIcon }}"></i>{{ $fStopLabel }}
              </span>
            </div>
          </div>

          {{-- ── FLIGHT ROW ── --}}
          <div class="rt-flight-row">

            {{-- Airline --}}
            <div class="rt-airline-block">
              <div class="rt-al-logo">
                @if($flight->airline_logo)
                  <img src="{{ asset($flight->airline_logo) }}" alt="{{ $flight->airline_name }}"
                       onerror="this.style.display='none';this.parentElement.textContent='{{ strtoupper(substr($flight->airline_code,0,2)) }}';">
                @else
                  {{ strtoupper(substr($flight->airline_code, 0, 2)) }}
                @endif
              </div>
              <div>
                <div class="rt-al-name">{{ $flight->airline_name }}</div>
                <div class="rt-al-sub">
                  <span class="rt-al-flno">{{ $flight->flight_number }}</span>
                  @if($flight->aircraft_type)<span class="rt-al-ac">{{ $flight->aircraft_type }}</span>@endif
                </div>
              </div>
            </div>

            {{-- Route --}}
            <div class="rt-route">

              {{-- DEPARTURE endpoint — centered --}}
              <div class="rt-ep">
                <div class="rt-ep-time-wrap">
                  <span class="rt-ep-time">{{ $fDep->format('h:i') }}</span>
                  <span class="rt-ep-ampm">{{ $fDep->format('A') }}</span>
                  @if($flight->departure_timezone)
                    <div class="rt-ep-tz">{{ $flight->departure_timezone }}</div>
                  @endif
                </div>
                <div class="rt-ep-iata">{{ $flight->from_airport_code }}</div>
                <div class="rt-ep-city">{{ $flight->from_city ?? $flight->from_airport_code }}</div>
              </div>

              {{-- Mid connector --}}
              <div class="rt-mid">
                <div class="rt-route-line">
                  <div class="rt-r-dot"></div>
                  <div class="rt-r-dash"></div>
                  <span class="rt-r-plane"><i class="fa-solid fa-plane"></i></span>
                  <div class="rt-r-dash"></div>
                  <div class="rt-r-dot"></div>
                </div>
                <span class="rt-dur-pill">{{ $flight->duration }}</span>
                @if(count($fStopovers))
                  <div class="rt-stopover">
                    <i class="fa-solid fa-clock"></i> layover :
                    @foreach($fStopovers as $city)<span class="sv-city">{{ $city }}</span>@endforeach
                  </div>
                @endif
                @if($fON)<div class="rt-overnight"><i class="fa-solid fa-moon"></i> +1 night</div>@endif
              </div>

              {{-- ARRIVAL endpoint — centered --}}
              <div class="rt-ep">
                <div class="rt-ep-time-wrap">
                  <span class="rt-ep-time">{{ $fArr->format('h:i') }}@if($fON)<sup style="font-size:.55rem;color:#f97316;margin-left:1px;">+1</sup>@endif</span>
                  <span class="rt-ep-ampm">{{ $fArr->format('A') }}</span>
                  @if($flight->arrival_timezone)
                    <div class="rt-ep-tz">{{ $flight->arrival_timezone }}</div>
                  @endif
                </div>
                <div class="rt-ep-iata">{{ $flight->to_airport_code }}</div>
                <div class="rt-ep-city">{{ $flight->to_city ?? $flight->to_airport_code }}</div>
              </div>

            </div>{{-- /rt-route --}}

            {{-- Price --}}
            <div class="rt-price-col">
              <div class="cls-chip"><i class="fa-solid fa-star" style="font-size:.5rem;"></i> Economy</div>
              <div class="rt-price-label">One Way</div>
              <div class="rt-price-amt"><span class="rt-price-sup">$</span>{{ number_format($fPrice) }}</div>
              <div class="rt-price-sub">per adult</div>
              @if($fCls)
                <div class="rt-baggage">
                  <div class="rt-bag-chip"><i class="fa-solid fa-briefcase"></i><span>{{ $fCls->cabin_baggage_kg }}kg cabin</span></div>
                  <div class="rt-bag-chip"><i class="fa-solid fa-suitcase-rolling"></i><span>{{ $fCls->checkin_baggage_kg }}kg check-in</span></div>
                </div>
              @endif
            </div>

          </div>{{-- /rt-flight-row --}}

          {{-- Footer --}}
          <div class="rt-footer">
            <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
              <div>
                <span class="rt-class-badge"><i class="fa-solid fa-star"></i> Economy</span>
                <div style="margin-top:6px;">
                  <div style="font-size:.62rem;color:var(--gray);font-weight:600;">Per adult</div>
                  <div style="font-family:var(--font-display);font-size:1.55rem;font-weight:800;color:var(--primary-dark);line-height:1;">
                    <span style="font-size:.82rem;font-weight:500;vertical-align:super;">$</span>{{ number_format($fPrice) }}
                  </div>
                </div>
              </div>
            </div>
            <div class="rt-footer-right">
              @if($fIsLow)
                <span class="seats-warn"><i class="fa-solid fa-fire"></i> Only {{ $fCls->available_seats }} seats left!</span>
              @endif
              <a href="{{ $fBookUrl }}" class="btn-select-rt">
                <i class="fa-solid fa-check-circle"></i> Select <i class="fa-solid fa-arrow-right"></i>
              </a>
            </div>
          </div>

        </div>{{-- /rtcard --}}
        @endforeach
      </div>
    @endif
  </div>

  {{-- ── HOTELS ── --}}
  <div class="listing-panel" id="lp-hotels">
    <div class="row g-4">
      @forelse($hotels ?? [] as $hotel)
        <div class="col-md-6 col-lg-4">
          <div class="hotel-card">
            <div class="hotel-img">
              <img src="{{ asset('hotel_images/' . $hotel->thumbnail) }}" alt="{{ $hotel->name }}">
              <div class="hotel-img-overlay"></div>
              <div class="hotel-star">⭐ {{ $hotel->star_rating ?? 'N/A' }}</div>
            </div>
            <div class="hotel-body">
              <div class="hotel-name">{{ $hotel->name }}</div>
              <div class="hotel-loc"><i class="fa-solid fa-location-dot" style="color:#ef4444"></i>{{ $hotel->city }}, {{ $hotel->country }}</div>
              <div class="hotel-amenities">
                @if($hotel->wifi)<span class="hotel-am">📶 WiFi</span>@endif
                @if($hotel->parking)<span class="hotel-am">🅿 Parking</span>@endif
                @if($hotel->pool)<span class="hotel-am">🏊 Pool</span>@endif
                @if($hotel->ac)<span class="hotel-am">❄ AC</span>@endif
                @if($hotel->restaurant)<span class="hotel-am">🍽️ Restaurant</span>@endif
              </div>
              <div class="hotel-footer-c">
                <div class="hotel-price"><strong>₹{{ number_format($hotel->price_per_night) }}</strong><small>per night</small></div>
                <a href="{{ route('hotelview', $hotel->id) }}" class="hotel-btn">View <i class="fa-solid fa-arrow-right"></i></a>
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

  {{-- ── TOURS ── --}}
  <div class="listing-panel" id="lp-tours">
    <div class="empty-box">
      <div class="e-icon"><i class="fa-solid fa-map-location-dot"></i></div>
      <h5>Tours Coming Soon</h5>
      <p>We're curating amazing packages — stay tuned!</p>
    </div>
  </div>

  {{-- ── CARS ── --}}
  <div class="listing-panel" id="lp-cars">
    <div class="empty-box">
      <div class="e-icon"><i class="fa-solid fa-car"></i></div>
      <h5>Car Rentals Coming Soon</h5>
      <p>Launching shortly!</p>
    </div>
  </div>

</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

let hfPax = { a: 1, c: 0 };

/* ═══════════════════════════════════════════════════════
   SINGLE DOMContentLoaded
═══════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', function () {
  document.body.appendChild(document.getElementById('hfTccDrop'));
  document.getElementById('hfAdMinus').disabled = true;
  document.getElementById('hfChMinus').disabled = true;
});

/* ── HERO SLIDER ── */
(function () {
  const slides = document.querySelectorAll('.slide');
  let si = 0;
  setInterval(() => {
    slides[si].classList.remove('active');
    si = (si + 1) % slides.length;
    slides[si].classList.add('active');
  }, 5000);
})();

/* ── MODE SWITCH ── */
const listingMeta = {
  'lp-flights': { title: 'Trending Flights',  sub: 'Best deals on flights handpicked for you' },
  'lp-hotels':  { title: 'Top Hotels',         sub: 'Handpicked stays for every budget'        },
  'lp-tours':   { title: 'Popular Tours',      sub: 'Explore the world with our curated tours' },
  'lp-cars':    { title: 'Car Rentals',         sub: 'Drive anywhere at unbeatable rates'       },
};
function switchMode(btn) {
  document.querySelectorAll('.sb-tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.sb-panel').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.listing-panel').forEach(p => p.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById(btn.dataset.panel).classList.add('active');
  const lp = document.getElementById(btn.dataset.listing);
  if (lp) lp.classList.add('active');
  const m = listingMeta[btn.dataset.listing];
  if (m) {
    document.getElementById('listing-title').textContent = m.title;
    document.getElementById('listing-sub').textContent   = m.sub;
  }
}

/* ── TRIP TYPE ── */
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
    if (!ri.value || ri.value <= depart) ri.value = depart;
  }
}

function onDepartChange(input) {
  const ri = document.getElementById('hfReturnDate');
  if (ri) { ri.min = input.value; if (ri.value < input.value) ri.value = input.value; }
}

/* ── SWAP ── */
function hfSwap() {
  const fi = document.getElementById('fromInput'), ti = document.getElementById('toInput');
  const fc = document.getElementById('fromCode'),  tc = document.getElementById('toCode');
  [fi.value, ti.value] = [ti.value, fi.value];
  [fc.value, tc.value] = [tc.value, fc.value];
}

/* ── TCC DROPDOWN ── */
function positionDrop() {
  const trigger = document.getElementById('hfTccTrigger');
  const drop    = document.getElementById('hfTccDrop');
  const rect    = trigger.getBoundingClientRect();
  const vw      = window.innerWidth;
  if (vw < 768) {
    drop.style.left     = '12px';
    drop.style.right    = '12px';
    drop.style.width    = (vw - 24) + 'px';
    drop.style.minWidth = '';
    drop.style.top      = (rect.bottom + 8) + 'px';
    drop.style.bottom   = 'auto';
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

/* ── CAR DATES ── */
function validateCarDates() {
  const pu = document.getElementById('carPickupDate');
  const dr = document.getElementById('carDropDate');
  if (!pu || !dr) return;
  dr.min = pu.value;
  if (dr.value < pu.value) dr.value = pu.value;
}

/* ── AIRPORT AUTOCOMPLETE ── */
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
      dropdown.innerHTML = !airports.length
        ? `<div class="autocomplete-item no-result"><i class="fa-solid fa-circle-info"></i> No airports found</div>`
        : airports.map(a => `
            <div class="autocomplete-item" data-city="${esc(a.city)}" data-code="${esc(a.airport_code)}" data-name="${esc(a.airport_name)}">
              <div class="ac-inner">
                <div class="ac-code-box">${esc(a.airport_code)}</div>
                <div>
                  <div class="ac-detail-name">${esc(a.airport_code)} — ${esc(a.airport_name)}</div>
                  <div class="ac-detail-city"><i class="fa-solid fa-location-dot" style="color:#ef4444;font-size:.65rem;"></i>${esc(a.city)}</div>
                </div>
              </div>
            </div>`).join('');
      show();
    }
    function fetchAirports(q) {
      fetch(`${SEARCH_URL}?q=${encodeURIComponent(q)}`).then(r => r.json()).then(render).catch(hide);
    }
    function show() { dropdown.style.display = 'flex'; }
    function hide() { dropdown.style.display = 'none'; }
    function selectItem(item) {
      input.value      = `${item.dataset.city} (${item.dataset.code})`;
      codeHidden.value = item.dataset.code;
      lastQuery        = input.value;
      hide(); input.focus();
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
    dropdown.addEventListener('click', e => {
      const item = e.target.closest('.autocomplete-item[data-code]');
      if (item) selectItem(item);
    });
    input.addEventListener('keydown', function (e) {
      const items = [...dropdown.querySelectorAll('.autocomplete-item[data-code]')];
      if (!items.length || dropdown.style.display === 'none') return;
      let idx = items.findIndex(i => i.classList.contains('hovered'));
      if (e.key === 'ArrowDown') {
        e.preventDefault();
        if (idx >= 0) items[idx].classList.remove('hovered');
        const ni = (idx + 1) % items.length;
        items[ni].classList.add('hovered');
        items[ni].scrollIntoView({ block: 'nearest' });
      } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        if (idx >= 0) items[idx].classList.remove('hovered');
        const ni = (idx - 1 + items.length) % items.length;
        items[ni].classList.add('hovered');
        items[ni].scrollIntoView({ block: 'nearest' });
      } else if (e.key === 'Enter') {
        const h = dropdown.querySelector('.autocomplete-item.hovered');
        if (h) { e.preventDefault(); selectItem(h); }
      } else if (e.key === 'Escape') { hide(); }
    });
    document.addEventListener('click', e => {
      if (!input.contains(e.target) && !dropdown.contains(e.target)) hide();
    });
  });
})();
</script>

@endsection