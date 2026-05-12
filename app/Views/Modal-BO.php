<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="<?= csrf_hash() ?>">
<title>NutriPath — Back-office <?= $title ?? 'Dashboard' ?></title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="<?= base_url('assets/CSS/Theme.css') ?>">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<nav class="demo-nav">
  <span>PAGES →</span>
  <a href="/"><i class="bi bi-house-fill"></i> Landing</a>
  <a href="/formulaire"><i class="bi bi-lock-fill"></i> Se connecter</a>
  <a href="/bo/dashboard/general" class="active"><i class="bi bi-pencil-fill"></i> BO Dashboard</a>
  <a href="/bo/dashboard/regime"><i class="bi bi-cup-straw"></i> BO Régime CRUD</a>
  <a href="/bo/dashboard/sport"><i class="bi bi-bicycle"></i> BO Sports CRUD</a>
  <a href="/bo/dashboard/code"><i class="bi bi-credit-card"></i> BO Codes</a>
  <a href="/bo/dashboard/user"><i class="bi bi-people"></i> BO Utilisateurs</a>
</nav>

<div class="app-layout">
    <div class="bo-sidebar">
        <div class="bo-logo">Nutri<span>Path</span> Admin</div>
        
        <div class="bo-section">Général</div>
        <a href="/bo/dashboard/general" class="bo-item">
            <i class="fas fa-chart-line" style="font-size: 1.2rem; margin-right: 10px;"></i> Tableau de bord
        </a>
        
        <div class="bo-section">Gestion</div>
        <a href="/bo/dashboard/regime" class="bo-item">
            <i class="fas fa-utensils" style="font-size: 1.2rem; margin-right: 10px;"></i> Régimes
        </a>
        <a href="/bo/dashboard/sport" class="bo-item">
            <i class="fas fa-dumbbell" style="font-size: 1.2rem; margin-right: 10px;"></i> Sports
        </a>
        <a href="/bo/dashboard/code" class="bo-item">
            <i class="fas fa-credit-card" style="font-size: 1.2rem; margin-right: 10px;"></i> Codes wallet
        </a>
        <a href="/bo/dashboard/user" class="bo-item">
            <i class="fas fa-users" style="font-size: 1.2rem; margin-right: 10px;"></i> Utilisateurs
        </a>
        
        <div class="bo-section">Paramètres</div>
        <!-- <div class="bo-item">
            <i class="fas fa-cog" style="font-size: 1.2rem; margin-right: 10px;"></i> Paramètres
        </div> -->
        <a href="/logout" class="bo-item">
            <i class="fas fa-sign-out-alt" style="font-size: 1.2rem; margin-right: 10px;"></i> Se déconnecter
        </a>
    </div>
    <?php include $page . '.php' ?>
</div>

<script>
// ========== DYNAMISATION AVEC LE TITRE PHP ==========
// Injecter les données PHP dans JavaScript
const currentPage = <?= json_encode($page ?? '') ?>;
const currentTitle = <?= json_encode($title ?? '') ?>;

// Mapping des pages vers les URLs et les classes actives
const pageMapping = {
    'bo-dashboard': {
        sidebar: '/bo/dashboard/general',
        navbar: '/bo/dashboard/general',
        title: 'Dashboard'
    },
    'bo-crud-regime': {
        sidebar: '/bo/dashboard/regime',
        navbar: '/bo/dashboard/regime',
        title: 'Régimes'
    },
    'bo-crud-sport': {
        sidebar: '/bo/dashboard/sport',
        navbar: '/bo/dashboard/sport',
        title: 'Sports'
    },
    'bo-crud-code': {
        sidebar: '/bo/dashboard/code',
        navbar: '/bo/dashboard/code',
        title: 'Codes'
    },
    'bo-crud-user': {
        sidebar: '/bo/dashboard/user',
        navbar: '/bo/dashboard/user',
        title: 'Utilisateurs'
    }
};

document.addEventListener('DOMContentLoaded', function() {
    // Récupérer la page courante ou l'URL
    const currentPageName = currentPage.split('/').pop();
    const mapping = pageMapping[currentPageName] || pageMapping['bo-dashboard'];
    
    // === SIDEBAR ===
    const sidebarLinks = document.querySelectorAll('.bo-sidebar .bo-item');
    sidebarLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === mapping.sidebar) {
            sidebarLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
        }
    });
    
    // === NAVBAR ===
    const navLinks = document.querySelectorAll('.demo-nav a');
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === mapping.navbar) {
            navLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
        }
    });
});
</script>

<footer class="bo-footer-simple">
    <div class="footer-inner">
        <p>© <?= date('Y') ?> NutriPath — Back-office Administration</p>
        <div class="footer-version">
            <i class="fas fa-code-branch"></i> v1.0
        </div>
    </div>
</footer>

<style>
.bo-footer-simple { background: var(--slate-900); border-top: 1px solid rgba(255, 255, 255, 0.05); padding: 16px 32px; margin-top: auto;}
.footer-inner {display: flex;justify-content: space-between;align-items: center;flex-wrap: wrap;gap: 12px;max-width: 1400px;margin: 0 ;}
.bo-footer-simple p {font-size: 12px;color: var(--slate-500);margi;}
.footer-version {font-size: 11px;color: var(--slate-600);font-family: monos;}
.footer-version i { margin-right:4px;}
</style>

</body>
</html>