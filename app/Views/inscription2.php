<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NutriPath — Inscription Etape 2</title>
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
    --slate-50: #f8f9fa;
    --slate-100: #f1f3f5;
    --slate-200: #e9ecef;
    --slate-400: #adb5bd;
    --slate-500: #6c757d;
    --slate-600: #495057;
    --slate-900: #111316;
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

  .auth-wrap { min-height: 100vh; display: flex; padding-top: 56px; }
  .auth-side { width: 420px; min-width: 420px; background: linear-gradient(160deg, var(--green-900) 0%, var(--green-600) 100%); padding: 60px 48px; display: flex; flex-direction: column; justify-content: center; }
  .auth-side h2 { font-size: 36px; color: #fff; line-height: 1.2; margin-bottom: 20px; }
  .auth-side p { color: rgba(255,255,255,0.65); font-size: 15px; }
  .auth-steps { margin-top: 48px; display: flex; flex-direction: column; gap: 20px; }
  .auth-step { display: flex; align-items: center; gap: 14px; }
  .auth-step-num { width: 32px; height: 32px; border-radius: 50%; background: rgba(255,255,255,0.15); color: #fff; font-size: 14px; font-weight: 600; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
  .auth-step-num.done { background: var(--green-400); }
  .auth-step span { color: rgba(255,255,255,0.75); font-size: 14px; }
  .auth-form { flex: 1; padding: 60px 64px; display: flex; flex-direction: column; justify-content: center; max-width: 580px; }
  .auth-form h3 { font-family: 'DM Sans', sans-serif; font-size: 22px; font-weight: 600; margin-bottom: 6px; }
  .auth-form .step-label { color: var(--slate-500); font-size: 14px; margin-bottom: 36px; }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
  .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 20px; }
  .form-group label { font-size: 13px; font-weight: 500; color: var(--slate-700); }
  .form-group input, .form-group select { padding: 12px 16px; border: 1.5px solid var(--slate-200); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 15px; outline: none; background: #fff; transition: border-color .15s; }
  .form-group input:focus, .form-group select:focus { border-color: var(--green-400); }
  .form-submit { background: var(--green-500); color: #fff; border: none; padding: 14px 32px; border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 600; cursor: pointer; width: 100%; margin-top: 8px; transition: background .15s; }
  .form-submit:hover { background: var(--green-600); }
  .stat-card { background: var(--green-50); border-radius: var(--radius); padding: 20px; border: 1px solid var(--green-100); margin-bottom: 24px; }
  .stat-label { font-size: 12px; color: var(--green-600); text-transform: uppercase; letter-spacing: .06em; margin-bottom: 8px; }
  .stat-value { font-size: 28px; font-weight: 600; color: var(--green-500); }
  .stat-sub { font-size: 13px; margin-top: 4px; color: var(--slate-500); }
  .obj-card { border: 2px solid var(--slate-200); border-radius: var(--radius-sm); padding: 16px; cursor: pointer; transition: all .15s; display: flex; gap: 12px; align-items: flex-start; }
  .obj-card:hover { border-color: var(--green-400); background: var(--green-50); }
  .obj-card.selected { border-color: var(--green-500); background: var(--green-50); }
  .obj-card h4 { font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 600; color: var(--slate-900); margin-bottom: 4px; }
  .obj-card p { font-size: 13px; color: var(--slate-500); }
  .obj-icon { font-size: 20px; margin-bottom: 8px; }
  .obj-input { margin-top: 3px; }
  .error-box { background: #fde8e8; border: 1px solid #e04646; color: #7a1f1f; padding: 12px 14px; border-radius: var(--radius-sm); margin-bottom: 18px; font-size: 13px; }

  @media (max-width: 900px) {
    .auth-side { display: none; }
    .auth-form { padding: 40px 28px; max-width: 100%; }
  }
</style>
</head>
<body>

<nav class="demo-nav">
  <span>PAGES →</span>
  <a href="/">Landing</a>
  <a href="/login">Login</a>
  <a href="/inscription/etape-1">Inscription #1</a>
  <a href="/inscription/etape-2" class="active">Inscription #2</a>
  <a href="/dashboard">Dashboard</a>
  <a href="/regimes">Regimes</a>
  <a href="/profil">Profil & Plan</a>
</nav>

<div class="auth-wrap">
  <div class="auth-side">
    <h2>Vos donnees de sante</h2>
    <p>Ces informations nous permettent de calculer votre IMC et de personnaliser vos recommandations.</p>
    <div class="auth-steps">
      <div class="auth-step"><div class="auth-step-num done">1</div><span>Informations personnelles ✓</span></div>
      <div class="auth-step"><div class="auth-step-num done">2</div><span>Donnees de sante</span></div>
      <div class="auth-step"><div class="auth-step-num">3</div><span>Choix de vos objectifs</span></div>
    </div>
  </div>
  <div class="auth-form">
    <h3>Donnees de sante</h3>
    <p class="step-label">Etape 2 sur 2 — Votre condition physique actuelle</p>

    <?php if (session()->getFlashdata('errors')): ?>
      <div class="error-box">
        <?php foreach (session()->getFlashdata('errors') as $message): ?>
          <div><?= esc($message) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form method="post" action="/inscription/etape-2">
      <div class="form-row">
        <div class="form-group">
          <label>Taille (cm)</label>
          <input type="number" id="taille_cm" name="taille_cm" placeholder="168" value="<?= esc(old('taille_cm') ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label>Poids actuel (kg)</label>
          <input type="number" id="poids_kg" name="poids_kg" placeholder="72" value="<?= esc(old('poids_kg') ?? '') ?>" required>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-label">Votre IMC estime</div>
        <div class="stat-value" id="imc-value">---</div>
        <div class="stat-sub" id="imc-sub">Sera calcule apres inscription</div>
      </div>

      <div class="form-group">
        <label>Vos objectifs (max 3)</label>
        <div style="display: flex; flex-direction: column; gap: 10px;">
          <?php foreach ($objectifs as $objectif): ?>
            <label class="obj-card" onclick="toggleObj(this)">
              <input class="obj-input" type="checkbox" name="objectifs[]" value="<?= esc($objectif['id']) ?>" onchange="syncObjCard(this)">
              <div>
                <h4><?= esc($objectif['libelle']) ?></h4>
                <p>Choisir cet objectif</p>
              </div>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <button class="form-submit" type="submit">Creer mon compte</button>
    </form>
  </div>
</div>

<script src="/assets/js/inscription2.js"></script>
</body>
</html>
