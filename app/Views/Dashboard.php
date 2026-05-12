<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NutriPath — Dashboard Utilisateur</title>
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
    --radius: 12px;
    --radius-sm: 8px;
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

  .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 28px; }
  .stat-card { background: #fff; border-radius: var(--radius); padding: 20px; border: 1px solid var(--slate-200); }
  .stat-label { font-size: 12px; color: var(--slate-500); text-transform: uppercase; letter-spacing: .06em; margin-bottom: 8px; }
  .stat-value { font-size: 28px; font-weight: 600; color: var(--slate-900); }
  .stat-sub { font-size: 13px; margin-top: 4px; }
  .stat-sub.up { color: var(--green-500); }
  .stat-sub.down { color: var(--red-400); }

  .cards-row { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 24px; }
  .card { background: #fff; border-radius: var(--radius); padding: 24px; border: 1px solid var(--slate-200); }
  .card-title { font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 600; color: var(--slate-900); margin-bottom: 20px; }
  .imc-gauge { display: flex; flex-direction: column; align-items: center; padding: 8px 0; }
  .gauge-bar { width: 100%; height: 16px; border-radius: 100px; background: linear-gradient(to right, #3b82f6 0%, #3aaa6b 30%, #e6a817 65%, #e04646 100%); position: relative; margin-bottom: 24px; }
  .gauge-marker { position: absolute; top: -4px; width: 24px; height: 24px; border-radius: 50%; background: #fff; border: 3px solid var(--slate-900); transform: translateX(-50%); left: 38%; }
  .gauge-labels { display: flex; justify-content: space-between; width: 100%; font-size: 11px; color: var(--slate-500); }
  .imc-num { font-size: 48px; font-weight: 700; font-family: 'Playfair Display', serif; color: var(--green-500); }
  .imc-tag { background: var(--green-100); color: var(--green-600); font-size: 13px; font-weight: 600; padding: 4px 12px; border-radius: 100px; margin-top: 8px; }
  .chart-placeholder { height: 140px; background: var(--slate-50); border-radius: var(--radius-sm); display: flex; align-items: flex-end; padding: 16px; gap: 8px; }
  .bar { flex: 1; border-radius: 4px 4px 0 0; background: var(--green-100); height: 70%; }
  .bar.active { background: var(--green-400); }

  @media (max-width: 900px) {
    .cards-row { grid-template-columns: 1fr; }
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
  <a href="dashboard.html" class="active">Dashboard</a>
  <a href="regimes.html">Régimes</a>
  <a href="profil.html">Profil & Plan</a>
  <a href="bo-dashboard.html">BO Dashboard</a>
  <a href="bo-crud.html">BO Régime CRUD</a>
  <a href="bo-codes.html">BO Codes</a>
</nav>

<div class="app-layout">
  <div class="sidebar">
    <div class="sidebar-logo">Nutri<span>Path</span></div>
    <div class="sidebar-section">Menu</div>
    <a href="dashboard.html" class="sidebar-item active"><span class="icon">📊</span> Tableau de bord</a>
    <a href="regimes.html" class="sidebar-item"><span class="icon">🥗</span> Régimes</a>
    <a href="sports.html" class="sidebar-item"><span class="icon">🏃</span> Activités</a>
    <a href="profil.html" class="sidebar-item"><span class="icon">👤</span> Mon profil</a>
    <div class="sidebar-section" style="margin-top:20px;">Compte</div>
    <div class="sidebar-item"><span class="icon">💰</span> Porte-monnaie</div>
    <div class="sidebar-item"><span class="icon">⭐</span> Option Gold</div>
    <div class="sidebar-footer">
      <div class="sidebar-user">
        <div class="avatar">MD</div>
        <div class="avatar-info">
          <p>Marie Dupont</p>
          <span>Compte standard</span>
        </div>
      </div>
    </div>
  </div>
  <div class="main-content">
    <div class="page-header">
      <h2>Bonjour, Marie 👋</h2>
      <p>Voici votre tableau de bord — semaine du 5 mai 2026</p>
    </div>

    <div class="stats-row">
      <div class="stat-card">
        <div class="stat-label">Poids actuel</div>
        <div class="stat-value">72 kg</div>
        <div class="stat-sub down">−0.5 kg cette semaine</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">IMC</div>
        <div class="stat-value" style="color: var(--gold-500);">25.5</div>
        <div class="stat-sub" style="color: var(--slate-500);">Surpoids léger</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Objectif</div>
        <div class="stat-value" style="color: var(--green-500);">65 kg</div>
        <div class="stat-sub up">7 kg restants</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Programme en cours</div>
        <div class="stat-value" style="font-size: 18px; padding-top: 4px;">Méditerranéen</div>
        <div class="stat-sub" style="color: var(--slate-500);">Semaine 3 / 12</div>
      </div>
    </div>

    <div class="cards-row">
      <div class="card">
        <div class="card-title">Progression du poids (8 semaines)</div>
        <div class="chart-placeholder">
          <div class="bar" style="height: 72%"></div>
          <div class="bar" style="height: 75%"></div>
          <div class="bar" style="height: 68%"></div>
          <div class="bar" style="height: 80%"></div>
          <div class="bar" style="height: 78%"></div>
          <div class="bar active" style="height: 85%"></div>
          <div class="bar" style="height: 90%"></div>
          <div class="bar active" style="height: 95%"></div>
        </div>
        <div style="display:flex; justify-content:space-between; margin-top:6px;">
          <span style="font-size:11px;color:var(--slate-400)">Sem. 1</span>
          <span style="font-size:11px;color:var(--slate-400)">Sem. 8</span>
        </div>
      </div>
      <div class="card">
        <div class="card-title">Votre IMC</div>
        <div class="imc-gauge">
          <div style="font-size:13px; color: var(--slate-500); margin-bottom: 12px; text-align: center;">Indice de masse corporelle</div>
          <div class="imc-num">25.5</div>
          <div class="imc-tag">Surpoids léger</div>
          <div style="width:100%; margin-top: 20px;">
            <div class="gauge-bar"><div class="gauge-marker"></div></div>
            <div class="gauge-labels">
              <span>Insuffisant<br>< 18.5</span>
              <span>Normal<br>18.5–25</span>
              <span>Surpoids<br>25–30</span>
              <span>Obésité<br>> 30</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card" style="margin-bottom: 24px;">
      <div class="card-title">Programme Méditerranéen — Semaine 3</div>
      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px,1fr)); gap: 10px;">
        <div style="background: var(--green-50); border-radius: 8px; padding: 12px; text-align: center;">
          <div style="font-size:11px; color:var(--slate-500); margin-bottom: 6px;">Lun</div>
          <div style="font-size:12px; font-weight: 600; color: var(--green-600);">Poulet / Légumes</div>
        </div>
        <div style="background: var(--green-50); border-radius: 8px; padding: 12px; text-align: center;">
          <div style="font-size:11px; color:var(--slate-500); margin-bottom: 6px;">Mar</div>
          <div style="font-size:12px; font-weight: 600; color: var(--green-600);">Poisson / Riz</div>
        </div>
        <div style="background: var(--slate-100); border-radius: 8px; padding: 12px; text-align: center; border: 2px solid var(--green-400);">
          <div style="font-size:11px; color:var(--slate-500); margin-bottom: 6px;">Mer ← Aujourd'hui</div>
          <div style="font-size:12px; font-weight: 600; color: var(--green-600);">Salade niçoise</div>
        </div>
        <div style="background: var(--slate-50); border-radius: 8px; padding: 12px; text-align: center; opacity: .5;">
          <div style="font-size:11px; color:var(--slate-500); margin-bottom: 6px;">Jeu</div>
          <div style="font-size:12px; font-weight: 600; color: var(--slate-500);">Viande / Quinoa</div>
        </div>
        <div style="background: var(--slate-50); border-radius: 8px; padding: 12px; text-align: center; opacity: .5;">
          <div style="font-size:11px; color:var(--slate-500); margin-bottom: 6px;">Ven</div>
          <div style="font-size:12px; font-weight: 600; color: var(--slate-500);">Poisson vapeur</div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>