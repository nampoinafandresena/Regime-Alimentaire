<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NutriPath — Régimes</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
  :root {
    --green-50: #f0faf4;
    --green-100: #d4f0e0;
    --green-400: #3aaa6b;
    --green-500: #2d8f57;
    --green-600: #1e6b3e;
    --green-900: #0d2e1a;
    --gold-100: #fef6e0;
    --gold-400: #e6a817;
    --gold-500: #c48a00;
    --slate-50: #f8f9fa;
    --slate-100: #f1f3f5;
    --slate-200: #e9ecef;
    --slate-300: #dee2e6;
    --slate-400: #adb5bd;
    --slate-500: #6c757d;
    --slate-600: #495057;
    --slate-700: #343a40;
    --slate-900: #111316;
    --red-400: #e04646;
    --red-100: #fde8e8;
    --blue-400: #3b82f6;
    --blue-100: #dbeafe;
    --radius: 12px;
    --radius-sm: 8px;
    --radius-lg: 20px;
    --shadow-md: 0 4px 24px rgba(0,0,0,0.11);
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'DM Sans', sans-serif; background: #fff; color: var(--slate-900); line-height: 1.6; }
  h1, h2, h3 { font-family: 'Playfair Display', serif; }

  .demo-nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 9999;
    background: rgba(255,255,255,0.95); backdrop-filter: blur(8px);
    display: flex; align-items: center; gap: 0; overflow-x: auto;
    padding: 0 24px; height: 56px; border-bottom: 1px solid rgba(0,0,0,0.06);
  }
  .demo-nav span { color: var(--slate-500); font-size: 11px; text-transform: uppercase; letter-spacing: .08em; padding: 0 12px 0 4px; white-space: nowrap; }
  .demo-nav a {
    background: none; border: none; color: var(--slate-500); font-family: 'DM Sans', sans-serif;
    font-size: 13px; padding: 8px 16px; cursor: pointer; white-space: nowrap; border-radius: 0;
    border-bottom: 2px solid transparent; transition: color .15s, border-color .15s;
    text-decoration: none;
  }
  .demo-nav a:hover { color: var(--slate-900); }
  .demo-nav a.active { color: var(--green-500); border-bottom-color: var(--green-500); }

  .app-layout { display: flex; min-height: 100vh; padding-top: 56px; }
  .sidebar { width: 240px; background: var(--slate-900); padding: 24px 0; display: flex; flex-direction: column; flex-shrink: 0; }
  .sidebar-logo { font-family: 'Playfair Display', serif; font-size: 20px; color: #fff; padding: 8px 24px 32px; letter-spacing: .05em; }
  .sidebar-logo span { color: var(--green-400); }
  .sidebar-section { font-size: 10px; text-transform: uppercase; letter-spacing: .1em; color: var(--slate-500); padding: 0 24px 8px; }
  .sidebar-item { display: flex; align-items: center; gap: 10px; padding: 11px 24px; font-size: 14px; color: var(--slate-400); cursor: pointer; transition: background .12s, color .12s; text-decoration: none; }
  .sidebar-item:hover { background: rgba(255,255,255,0.05); color: #fff; }
  .sidebar-item.active { background: rgba(58, 170, 107, 0.15); color: var(--green-400); }
  .sidebar-item .icon { font-size: 18px; }
  .sidebar-footer { margin-top: auto; padding: 16px 24px; border-top: 1px solid rgba(255,255,255,0.07); }
  .sidebar-user { display: flex; align-items: center; gap: 10px; }
  .avatar { width: 34px; height: 34px; border-radius: 50%; background: var(--green-400); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600; color: #fff; flex-shrink: 0; }
  .avatar-info p { font-size: 13px; color: #fff; font-weight: 500; }
  .avatar-info span { font-size: 11px; color: var(--slate-500); }

  .main-content { flex: 1; padding: 36px 40px; background: var(--slate-100); overflow-y: auto; }
  .page-header { margin-bottom: 32px; }
  .page-header h2 { font-size: 28px; color: var(--slate-900); }
  .page-header p { color: var(--slate-500); font-size: 15px; margin-top: 4px; }

  .regime-filters { display: flex; gap: 10px; margin-bottom: 28px; flex-wrap: wrap; }
  .filter-btn { padding: 8px 20px; border-radius: 100px; border: 1.5px solid var(--slate-200); font-family: 'DM Sans', sans-serif; font-size: 13px; cursor: pointer; background: #fff; transition: all .15s; }
  .filter-btn.active { background: var(--green-500); color: #fff; border-color: var(--green-500); }
  .regime-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
  .regime-card { background: #fff; border-radius: var(--radius); border: 1px solid var(--slate-200); overflow: hidden; transition: transform .15s, box-shadow .15s; }
  .regime-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
  .regime-banner { height: 120px; position: relative; overflow: hidden; display: flex; align-items: center; justify-content: center; font-size: 40px; }
  .regime-banner.green { background: linear-gradient(135deg, #d4f0e0, #9fdcb7); }
  .regime-banner.amber { background: linear-gradient(135deg, #fef6e0, #f7d37a); }
  .regime-banner.blue { background: linear-gradient(135deg, #dbeafe, #93c5fd); }
  .regime-body { padding: 20px; }
  .regime-name { font-family: 'Playfair Display', serif; font-size: 18px; margin-bottom: 6px; }
  .regime-desc { font-size: 13px; color: var(--slate-500); margin-bottom: 16px; line-height: 1.5; }
  .regime-meta { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 16px; }
  .tag { padding: 4px 10px; border-radius: 100px; font-size: 12px; font-weight: 500; }
  .tag.green { background: var(--green-100); color: var(--green-600); }
  .tag.amber { background: var(--gold-100); color: var(--gold-500); }
  .tag.red { background: var(--red-100); color: var(--red-400); }
  .tag.blue { background: var(--blue-100); color: var(--blue-400); }
  .composition-bar { margin-bottom: 16px; }
  .comp-label { font-size: 12px; color: var(--slate-500); margin-bottom: 6px; }
  .comp-bar { height: 8px; border-radius: 100px; overflow: hidden; display: flex; }
  .seg-meat { background: #e04646; }
  .seg-fish { background: #3b82f6; }
  .seg-poultry { background: #e6a817; }
  .regime-price { display: flex; align-items: center; justify-content: space-between; padding-top: 16px; border-top: 1px solid var(--slate-100); }
  .price-amount { font-size: 22px; font-weight: 700; color: var(--slate-900); }
  .price-period { font-size: 12px; color: var(--slate-400); }
  .btn-add { background: var(--green-500); color: #fff; border: none; padding: 10px 20px; border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; }
  .gold-badge { display: inline-flex; align-items: center; gap: 5px; background: var(--gold-100); color: var(--gold-500); font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 100px; margin-left: 8px; }

  @media (max-width: 900px) {
    .sidebar { width: 200px; }
    .main-content { padding: 20px; }
  }
</style>
</head>
<body>

<nav class="demo-nav">
  <span>PAGES →</span>
  <a href="index.html">Landing</a>
  <a href="login.html">Login</a>
  <a href="inscription1.html">Inscription #1</a>
  <a href="inscription2.html">Inscription #2</a>
  <a href="dashboard.html">Dashboard</a>
  <a href="regimes.html" class="active">Régimes</a>
  <a href="sports.html">Sports</a>
  <a href="profil.html">Profil & Plan</a>
  <a href="bo-dashboard.html">BO Dashboard</a>
  <a href="bo-crud.html">BO Régime CRUD</a>
  <a href="bo-sports.html">BO Sports CRUD</a>
  <a href="bo-codes.html">BO Codes</a>
</nav>

<div class="app-layout">
  <div class="sidebar">
    <div class="sidebar-logo">Nutri<span>Path</span></div>
    <div class="sidebar-section">Menu</div>
    <a href="dashboard.html" class="sidebar-item"><span class="icon">📊</span> Tableau de bord</a>
    <a href="regimes.html" class="sidebar-item active"><span class="icon">🥗</span> Régimes</a>
    <a href="sports.html" class="sidebar-item"><span class="icon">🏃</span> Activités</a>
    <a href="profil.html" class="sidebar-item"><span class="icon">👤</span> Mon profil</a>
    <div class="sidebar-section" style="margin-top:20px;">Compte</div>
    <div class="sidebar-item"><span class="icon">💰</span> Porte-monnaie</div>
    <div class="sidebar-item"><span class="icon">⭐</span> Option Gold</div>
    <div class="sidebar-footer">
      <div class="sidebar-user">
        <div class="avatar">MD</div>
        <div class="avatar-info"><p>Marie Dupont</p><span>Compte standard</span></div>
      </div>
    </div>
  </div>
  <div class="main-content">
    <div class="page-header">
      <h2>Choisir un régime</h2>
      <p>Sélectionnez un programme adapté à votre objectif de réduction de poids</p>
    </div>
    <div class="regime-filters">
      <button class="filter-btn active">Tous</button>
      <button class="filter-btn">Perte de poids</button>
      <button class="filter-btn">Prise de poids</button>
      <button class="filter-btn">IMC idéal</button>
      <button class="filter-btn">< 1 mois</button>
    </div>
    <div class="regime-grid">
      <div class="regime-card">
        <div class="regime-banner green">🥗</div>
        <div class="regime-body">
          <div class="regime-name">Méditerranéen</div>
          <div class="regime-desc">Riche en légumes frais, poissons et huile d'olive. Programme éprouvé pour une perte de poids durable.</div>
          <div class="regime-meta"><span class="tag green">Perte de poids</span><span class="tag blue">12 semaines</span></div>
          <div class="composition-bar"><div class="comp-label">Composition : Viande 20% · Poisson 50% · Volaille 30%</div><div class="comp-bar"><div class="seg-meat" style="width:20%"></div><div class="seg-fish" style="width:50%"></div><div class="seg-poultry" style="width:30%"></div></div></div>
          <div class="regime-price"><div><div class="price-amount">45 000 Ar<span class="gold-badge">GOLD −15%</span></div><div class="price-period">pour 4 semaines</div></div><button class="btn-add">Choisir</button></div>
        </div>
      </div>
      <div class="regime-card">
        <div class="regime-banner amber">🍗</div>
        <div class="regime-body">
          <div class="regime-name">Protéiné Sport</div>
          <div class="regime-desc">Haute teneur en protéines pour favoriser la prise de masse musculaire et la récupération sportive.</div>
          <div class="regime-meta"><span class="tag red">Prise de poids</span><span class="tag amber">8 semaines</span></div>
          <div class="composition-bar"><div class="comp-label">Composition : Viande 45% · Poisson 20% · Volaille 35%</div><div class="comp-bar"><div class="seg-meat" style="width:45%"></div><div class="seg-fish" style="width:20%"></div><div class="seg-poultry" style="width:35%"></div></div></div>
          <div class="regime-price"><div><div class="price-amount">52 000 Ar</div><div class="price-period">pour 4 semaines</div></div><button class="btn-add">Choisir</button></div>
        </div>
      </div>
      <div class="regime-card">
        <div class="regime-banner blue">🐟</div>
        <div class="regime-body">
          <div class="regime-name">Détox Marine</div>
          <div class="regime-desc">Basé sur les poissons et fruits de mer, ce régime riche en oméga-3 optimise votre métabolisme.</div>
          <div class="regime-meta"><span class="tag green">Perte de poids</span><span class="tag blue">6 semaines</span></div>
          <div class="composition-bar"><div class="comp-label">Composition : Viande 10% · Poisson 70% · Volaille 20%</div><div class="comp-bar"><div class="seg-meat" style="width:10%"></div><div class="seg-fish" style="width:70%"></div><div class="seg-poultry" style="width:20%"></div></div></div>
          <div class="regime-price"><div><div class="price-amount">38 000 Ar<span class="gold-badge">GOLD −15%</span></div><div class="price-period">pour 2 semaines</div></div><button class="btn-add">Choisir</button></div>
        </div>
      </div>
      <div class="regime-card">
        <div class="regime-banner green" style="background: linear-gradient(135deg, #e8f5e9, #a5d6a7);">🌿</div>
        <div class="regime-body">
          <div class="regime-name">Équilibre Vital</div>
          <div class="regime-desc">Programme équilibré pour atteindre et maintenir son IMC idéal avec variété et plaisir alimentaire.</div>
          <div class="regime-meta"><span class="tag green">IMC idéal</span><span class="tag blue">16 semaines</span></div>
          <div class="composition-bar"><div class="comp-label">Composition : Viande 33% · Poisson 33% · Volaille 34%</div><div class="comp-bar"><div class="seg-meat" style="width:33%"></div><div class="seg-fish" style="width:33%"></div><div class="seg-poultry" style="width:34%"></div></div></div>
          <div class="regime-price"><div><div class="price-amount">60 000 Ar<span class="gold-badge">GOLD −15%</span></div><div class="price-period">pour 8 semaines</div></div><button class="btn-add">Choisir</button></div>
        </div>
      </div>
      <div class="regime-card">
        <div class="regime-banner amber" style="background: linear-gradient(135deg, #fff8e1, #ffe082);">🥩</div>
        <div class="regime-body">
          <div class="regime-name">Masse & Force</div>
          <div class="regime-desc">Régime hyperprotéiné orienté prise de masse, idéal pour les sportifs cherchant à augmenter leur poids.</div>
          <div class="regime-meta"><span class="tag red">Prise de poids</span><span class="tag amber">12 semaines</span></div>
          <div class="composition-bar"><div class="comp-label">Composition : Viande 55% · Poisson 15% · Volaille 30%</div><div class="comp-bar"><div class="seg-meat" style="width:55%"></div><div class="seg-fish" style="width:15%"></div><div class="seg-poultry" style="width:30%"></div></div></div>
          <div class="regime-price"><div><div class="price-amount">68 000 Ar</div><div class="price-period">pour 4 semaines</div></div><button class="btn-add">Choisir</button></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.filter-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
  });
});
</script>
</body>
</html>