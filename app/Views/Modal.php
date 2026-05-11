<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="<?= csrf_hash() ?>">
<title>NutriPath — <?= $title ?? 'Accueil' ?></title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('assets/CSS/Theme.css') ?>">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>

<nav class="demo-nav">
    <span>MENU →</span>
    <a href="/" class="<?= ($page ?? '') === 'Home' ? 'active' : '' ?>">
        <i class="bi bi-house-fill"></i> Accueil
    </a>
    <a href="/formulaire" class="<?= ($page ?? '') === 'auth/Login' ? 'active' : '' ?>">
        <i class="bi bi-lock-fill"></i> Connexion
    </a>
    <a href="/inscription/etape-1" class="<?= ($page ?? '') === 'inscription1' ? 'active' : '' ?>">
        <i class="bi bi-pencil-fill"></i> Inscription
    </a>
</nav>

    <?php include $page . '.php' ?>
</body>
</html>