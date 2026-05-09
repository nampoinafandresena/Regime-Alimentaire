<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NutriPath — Connexion</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    --amber-50: #fffbf0;
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
    --shadow: 0 2px 16px rgba(0,0,0,0.07);
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

  .login-wrap { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: var(--slate-100); padding-top: 56px; }
  .login-box { background: #fff; border-radius: var(--radius-lg); border: 1px solid var(--slate-200); padding: 48px; width: 100%; max-width: 400px; box-shadow: var(--shadow-md); }
  .login-logo { font-family: 'Playfair Display', serif; font-size: 22px; text-align: center; margin-bottom: 8px; }
  .login-sub { text-align: center; font-size: 14px; color: var(--slate-500); margin-bottom: 36px; }
  .login-role { display: flex; gap: 8px; margin-bottom: 28px; }
  .role-btn { flex: 1; padding: 9px; border: 1.5px solid var(--slate-200); border-radius: var(--radius-sm); font-size: 13px; cursor: pointer; background: #fff; font-family: 'DM Sans', sans-serif; transition: all .15s; }
  .role-btn.active { border-color: var(--green-400); background: var(--green-50); color: var(--green-600); font-weight: 600; }
  .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 20px; }
  .form-group label { font-size: 13px; font-weight: 500; color: var(--slate-700); }
  .form-group input { padding: 12px 16px; border: 1.5px solid var(--slate-200); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 15px; outline: none; background: #fff; transition: border-color .15s; }
  .form-group input:focus { border-color: var(--green-400); }
  .input-with-icon { position: relative; }
  .input-with-icon input { padding-right: 44px; }
  .toggle-password {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    background: transparent; border: none; color: var(--slate-500);
    cursor: pointer; font-size: 16px; line-height: 1;
  }
  .toggle-password:hover { color: var(--slate-700); }
  .form-submit { background: var(--green-500); color: #fff; border: none; padding: 14px 32px; border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 600; cursor: pointer; width: 100%; margin-top: 8px; transition: background .15s; }
  .form-submit:hover { background: var(--green-600); }
  .form-link { text-align: center; font-size: 14px; color: var(--slate-500); margin-top: 20px; }
  .form-link a { color: var(--green-500); text-decoration: none; font-weight: 500; }
    .flash { padding:12px 14px; border-radius:8px; margin-bottom:16px; display:flex; align-items:center; gap:10px; font-weight:600; }
  .flash-error { background:#fde8e8; color:#8b1d1d; border:1px solid #f5c2c2; }

</style>
</head>
<body>

<nav class="demo-nav">
  <span>PAGES →</span>
  <a href="index.html">Landing</a>
  <a href="login.html" class="active">Login</a>
  <a href="inscription1.html">Inscription #1</a>
  <a href="inscription2.html">Inscription #2</a>
  <a href="dashboard.html">Dashboard</a>
  <a href="regimes.html">Régimes</a>
  <a href="profil.html">Profil & Plan</a>
  <a href="bo-dashboard.html">BO Dashboard</a>
  <a href="bo-crud.html">BO Régime CRUD</a>
  <a href="bo-codes.html">BO Codes</a>
</nav>
<form action="/login" method="post">
    <div class="login-wrap">
        <div class="login-box">
            <div class="login-logo">NutriPath</div>
            <p class="login-sub">Connectez-vous à votre compte</p>
            <div class="login-role">
                <button class="role-btn active">Utilisateur</button>
                <button class="role-btn">Administrateur</button>
            </div>
            <?php if(isset($erreur)): ?>
                <div class="flash flash-error">
                    <i class="fa-solid fa-circle-exclamation"></i> <?= esc($erreur) ?>
                </div>
            <?php endif; ?>
        <div class="form-group">
        <label>Adresse e-mail</label>
        <input type="email" name="email" placeholder="marie@example.com">
        </div>
    <div class="form-group">
    <label>Mot de passe</label>
    <div class="input-with-icon">
      <input type="password" id="login-password" name="password" placeholder="••••••••">
      <button type="button" class="toggle-password" aria-label="Afficher le mot de passe">
        <i class="fa-solid fa-eye"></i>
      </button>
    </div>
    </div>
        <button class="form-submit" type="submit">Se connecter</button>
        <p class="form-link" style="margin-top:16px">Pas encore de compte ? <a href="inscription1.html">S'inscrire</a></p>
    </div>
    </div>
</form>

<script>
document.querySelectorAll('.role-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.role-btn').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
  });
});

const togglePasswordBtn = document.querySelector('.toggle-password');
const passwordInput = document.getElementById('login-password');

if (togglePasswordBtn && passwordInput) {
  togglePasswordBtn.addEventListener('click', () => {
    const isHidden = passwordInput.type === 'password';
    passwordInput.type = isHidden ? 'text' : 'password';
    togglePasswordBtn.innerHTML = isHidden
      ? '<i class="fa-solid fa-eye-slash"></i>'
      : '<i class="fa-solid fa-eye"></i>';
  });
}
</script>
</body>
</html>