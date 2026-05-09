<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NutriPath — Back-office Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="<?= base_url('assets/CSS/Style-BO.css') ?>">

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

<?php include $page . '.php' ?>

</body>
</html>