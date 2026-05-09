<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NutriPath — Back-office Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
  :root {
    --green-50: #f0faf4;
    --green-100: #d4f0e0;
    --green-400: #3aaa6b;
    --green-500: #2d8f57;
    --green-600: #1e6b3e;
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
  .bo-sidebar { width: 220px; background: #1a1d21; padding: 20px 0; flex-shrink: 0; }
  .bo-logo { font-family: 'Playfair Display', serif; font-size: 16px; color: #fff; padding: 6px 20px 28px; }
  .bo-logo span { color: #e6a817; }
  .bo-item { display: flex; align-items: center; gap: 9px; padding: 10px 20px; font-size: 13px; color: #8a8f98; cursor: pointer; transition: all .12s; text-decoration: none; }
  .bo-item:hover { color: #fff; background: rgba(255,255,255,0.05); }
  .bo-item.active { color: #fff; background: rgba(230,168,23,0.15); border-left: 3px solid #e6a817; }
  .bo-section { font-size: 10px; text-transform: uppercase; letter-spacing: .1em; color: #4a4f5a; padding: 16px 20px 6px; }

  .bo-content { flex: 1; padding: 32px 36px; background: #f0f2f5; }
  .page-header { margin-bottom: 32px; }
  .page-header h2 { font-size: 28px; color: var(--slate-900); }
  .page-header p { color: var(--slate-500); font-size: 15px; margin-top: 4px; }

  .kpi-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
  .kpi-card { background: #fff; border-radius: var(--radius); padding: 20px; border: 1px solid var(--slate-200); }
  .kpi-label { font-size: 12px; color: var(--slate-500); margin-bottom: 8px; }
  .kpi-value { font-size: 32px; font-weight: 700; color: var(--slate-900); margin-bottom: 6px; }
  .kpi-trend { font-size: 13px; color: var(--green-500); }

  .chart-row { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 24px; }
  .chart-card { background: #fff; border-radius: var(--radius); padding: 24px; border: 1px solid var(--slate-200); }
  .chart-card h3 { font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 600; margin-bottom: 20px; }
  .mock-chart { height: 160px; display: flex; align-items: flex-end; gap: 12px; padding-top: 20px; border-bottom: 1px solid var(--slate-200); padding-bottom: 0; }
  .mock-bar { flex: 1; border-radius: 4px 4px 0 0; }
  .mock-bar.b1 { height: 60%; background: #d4f0e0; }
  .mock-bar.b2 { height: 80%; background: #d4f0e0; }
  .mock-bar.b3 { height: 55%; background: #d4f0e0; }
  .mock-bar.b4 { height: 90%; background: var(--green-400); }
  .mock-bar.b5 { height: 70%; background: #d4f0e0; }
  .mock-bar.b6 { height: 85%; background: #d4f0e0; }
  .mock-bar.b7 { height: 75%; background: #d4f0e0; }
  .mock-bar.b8 { height: 95%; background: var(--green-400); }
  .pie-mock { width: 100px; height: 100px; border-radius: 50%; background: conic-gradient(var(--green-400) 0% 45%, var(--gold-400) 45% 72%, var(--blue-400) 72% 100%); margin: 16px auto; }
  .pie-legend { display: flex; flex-direction: column; gap: 8px; }
  .pie-leg-item { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--slate-600); }
  .pie-dot { width: 10px; height: 10px; border-radius: 50%; }

  .bo-table { background: #fff; border-radius: var(--radius); border: 1px solid var(--slate-200); overflow: hidden; }
  .bo-table-header { display: flex; align-items: center; justify-content: space-between; padding: 18px 24px; border-bottom: 1px solid var(--slate-200); }
  .bo-table-header h3 { font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 600; }
  .btn-add-bo { background: var(--green-500); color: #fff; border: none; padding: 9px 20px; border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; }
  table { width: 100%; border-collapse: collapse; }
  th { font-family: 'DM Sans', sans-serif; font-size: 12px; text-transform: uppercase; letter-spacing: .06em; color: var(--slate-500); padding: 12px 20px; text-align: left; border-bottom: 1px solid var(--slate-200); }
  td { padding: 14px 20px; font-size: 14px; color: var(--slate-700); border-bottom: 1px solid var(--slate-100); }
  tr:last-child td { border-bottom: none; }
  .badge-status { padding: 4px 10px; border-radius: 100px; font-size: 12px; font-weight: 500; }
  .badge-active { background: var(--green-100); color: var(--green-600); }
  .badge-pending { background: var(--gold-100); color: var(--gold-500); }
  .badge-inactive { background: var(--slate-100); color: var(--slate-500); }

  @media (max-width: 900px) {
    .kpi-row { grid-template-columns: repeat(2, 1fr); }
    .chart-row { grid-template-columns: 1fr; }
    .bo-sidebar { width: 200px; }
    .bo-content { padding: 20px; }
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
  <a href="regimes.html">Régimes</a>
  <a href="sports.html">Sports</a>
  <a href="profil.html">Profil & Plan</a>
  <a href="bo-dashboard.html" class="active">BO Dashboard</a>
  <a href="bo-crud.html">BO Régime CRUD</a>
  <a href="bo-sports.html">BO Sports CRUD</a>
  <a href="bo-codes.html">BO Codes</a>
</nav>

<div class="app-layout">
  <div class="bo-sidebar">
    <div class="bo-logo">Nutri<span>Path</span> Admin</div>
    <div class="bo-section">Général</div>
    <a href="bo-dashboard.html" class="bo-item active">📊 Tableau de bord</a>
    <div class="bo-section">Gestion</div>
    <a href="bo-crud.html" class="bo-item">🥗 Régimes</a>
    <a href="bo-sports.html">🏃 Sports</a>
    <a href="bo-codes.html" class="bo-item">💳 Codes wallet</a>
    <div class="bo-item">👥 Utilisateurs</div>
    <div class="bo-section">Paramètres</div>
    <div class="bo-item">⚙️ Paramètres</div>
    <div class="bo-item">🔒 Se déconnecter</div>
  </div>
  <div class="bo-content">
    <div class="page-header"><h2>Tableau de bord Admin</h2><p>Vue d'ensemble au 6 mai 2026</p></div>
    <div class="kpi-row">
      <div class="kpi-card"><div class="kpi-label">Utilisateurs total</div><div class="kpi-value">247</div><div class="kpi-trend">↑ +12 ce mois</div></div>
      <div class="kpi-card"><div class="kpi-label">Abonnés Gold</div><div class="kpi-value">38</div><div class="kpi-trend">↑ +5 ce mois</div></div>
      <div class="kpi-card"><div class="kpi-label">Régimes actifs</div><div class="kpi-value">189</div><div class="kpi-trend">↑ +23 ce mois</div></div>
      <div class="kpi-card"><div class="kpi-label">Codes validés</div><div class="kpi-value">94</div><div class="kpi-trend">↑ +8 ce mois</div></div>
    </div>
    <div class="chart-row">
      <div class="chart-card">
        <h3>Inscriptions par semaine</h3>
        <div class="mock-chart">
          <div class="mock-bar b1"></div><div class="mock-bar b2"></div><div class="mock-bar b3"></div>
          <div class="mock-bar b4"></div><div class="mock-bar b5"></div><div class="mock-bar b6"></div>
          <div class="mock-bar b7"></div><div class="mock-bar b8"></div>
        </div>
        <div style="display:flex; justify-content:space-between; font-size:11px; color:var(--slate-400); margin-top:6px;">
          <span>Sem. 1</span><span>Sem. 2</span><span>Sem. 3</span><span>Sem. 4</span><span>Sem. 5</span><span>Sem. 6</span><span>Sem. 7</span><span>Sem. 8</span>
        </div>
      </div>
      <div class="chart-card">
        <h3>Objectifs populaires</h3>
        <div class="pie-mock"></div>
        <div class="pie-legend">
          <div class="pie-leg-item"><div class="pie-dot" style="background: var(--green-400)"></div>Réduire poids (45%)</div>
          <div class="pie-leg-item"><div class="pie-dot" style="background: var(--gold-400)"></div>IMC idéal (27%)</div>
          <div class="pie-leg-item"><div class="pie-dot" style="background: var(--blue-400)"></div>Augmenter poids (28%)</div>
        </div>
      </div>
    </div>
    <div class="bo-table">
      <div class="bo-table-header"><h3>Derniers utilisateurs inscrits</h3><button class="btn-add-bo">Voir tous</button></div>
      <table>
        <thead><tr><th>Nom</th><th>Email</th><th>IMC</th><th>Objectif</th><th>Statut</th></tr></thead>
        <tbody>
          <tr><td>Marie Dupont</td><td>marie@example.com</td><td>25.5</td><td>Réduire poids</td><td><span class="badge-status badge-active">Actif</span></td></tr>
          <tr><td>Jean Rakoto</td><td>jean@example.com</td><td>22.1</td><td>IMC idéal</td><td><span class="badge-status badge-active">Gold ⭐</span></td></tr>
          <tr><td>Soa Andria</td><td>soa@example.com</td><td>30.2</td><td>Réduire poids</td><td><span class="badge-status badge-pending">En attente</span></td></tr>
          <tr><td>Luc Martin</td><td>luc@example.com</td><td>19.8</td><td>Augmenter poids</td><td><span class="badge-status badge-active">Actif</span></td></tr>
          <tr><td>Fara Razafy</td><td>fara@example.com</td><td>27.0</td><td>Réduire poids</td><td><span class="badge-status badge-inactive">Inactif</span></td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>