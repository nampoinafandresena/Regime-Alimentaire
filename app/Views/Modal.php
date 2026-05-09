<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NutriPath — Accueil</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="<?= base_url('assets/CSS/Style.css') ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
  
</style>
</head>
<body>

<!-- META NAVIGATION (démo) -->
<nav class="demo-nav">
  <span>PAGES →</span>
  <a href="index.html" class="active"><i class="bi bi-house-fill"></i> Landing</a>
  <a href="login.html"><i class="bi bi-lock-fill"></i> Login</a>
  <a href="inscription1.html"><i class="bi bi-pencil-fill"></i> Inscription #1</a>
  <a href="inscription2.html"><i class="bi bi-clipboard-check"></i> Inscription #2</a>
  <a href="dashboard.html"><i class="bi bi-graph-up"></i> Dashboard</a>
  <a href="regimes.html"><i class="bi bi-leaf"></i> Régimes</a>
  <a href="profil.html"><i class="bi bi-person-circle"></i> Profil & Plan</a>
  <a href="bo-dashboard.html"><i class="bi bi-gear-fill"></i> BO Dashboard</a>
  <a href="bo-crud.html"><i class="bi bi-pencil-square"></i> BO Régime CRUD</a>
  <a href="bo-codes.html"><i class="bi bi-credit-card"></i> BO Codes</a>
</nav>
    <?php include $page . '.php' ?>
</body>
</html>