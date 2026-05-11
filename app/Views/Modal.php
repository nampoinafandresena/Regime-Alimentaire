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

<footer class="landing-footer">
    <div class="footer-main">
        <div class="footer-grid">
            <!-- Colonne 1: Logo & description -->
            <div class="footer-col">
                <div class="footer-logo">Nutri<span>Path</span></div>
                <p class="footer-description">
                    Votre chemin vers un poids idéal, scientifiquement guidé. 
                    Des programmes nutritionnels personnalisés pour atteindre vos objectifs.
                </p>
                <div class="footer-badges">
                    <span class="badge"><i class="fas fa-shield-alt"></i> Données sécurisées</span>
                    <span class="badge"><i class="fas fa-certificate"></i> Certifié nutrition</span>
                </div>
            </div>

            <!-- Colonne 2: Liens rapides -->
            <div class="footer-col">
                <h4>Liens rapides</h4>
                <ul class="footer-links">
                    <li><a href="/"><i class="fas fa-chevron-right"></i> Accueil</a></li>
                    <li><a href="/formulaire"><i class="fas fa-chevron-right"></i> Connexion</a></li>
                    <li><a href="/inscription/etape-1"><i class="fas fa-chevron-right"></i> Inscription</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Calcul IMC</a></li>
                </ul>
            </div>

            <!-- Colonne 3: Fonctionnalités -->
            <div class="footer-col">
                <h4>Fonctionnalités</h4>
                <ul class="footer-links">
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Régimes personnalisés</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Activités sportives</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Option Gold</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Export PDF</a></li>
                </ul>
            </div>

            <!-- Colonne 4: Contact & social -->
            <div class="footer-col">
                <h4>Nous suivre</h4>
                <div class="footer-social">
                    <a href="#" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" target="_blank" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" target="_blank" class="social-icon"><i class="fab fa-youtube"></i></a>
                </div>
                <div class="footer-contact">
                    <p><i class="fas fa-envelope"></i> contact@nutripath.com</p>
                    <p><i class="fas fa-phone-alt"></i> +261 34 12 345 67</p>
                </div>
            </div>
        </div>

        <!-- Newsletter section -->
        <div class="footer-newsletter">
            <div class="newsletter-content">
                <div class="newsletter-text">
                    <i class="fas fa-envelope-open-text"></i>
                    <div>
                        <h4>Recevez nos conseils nutritionnels</h4>
                        <p>Inscrivez-vous à notre newsletter pour recevoir des astuces santé et des offres exclusives.</p>
                    </div>
                </div>
                <div class="newsletter-form">
                    <input type="email" placeholder="Votre adresse email" id="newsletter-email">
                    <button onclick="subscribeNewsletter()">
                        <i class="fas fa-paper-plane"></i> S'abonner
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer bottom -->
    <div class="footer-bottom">
        <div class="footer-bottom-inner">
            <p>&copy; <?= date('Y') ?> NutriPath. Tous droits réservés. ETU3920-ETU4017-ETU4161</p>
            <div class="footer-legal">
                <a href="#">Mentions légales</a>
                <span class="separator">|</span>
                <a href="#">Politique de confidentialité</a>
                <span class="separator">|</span>
                <a href="#">CGU</a>
                <span class="separator">|</span>
                <a href="#">Cookies</a>
            </div>
            <div class="footer-backtop">
                <button onclick="window.scrollTo({top: 0, behavior: 'smooth'});">
                    <i class="fas fa-arrow-up"></i> Haut de page
                </button>
            </div>
        </div>
    </div>
</footer>

<style>

</style>

<script>
function subscribeNewsletter() {
    const email = document.getElementById('newsletter-email').value;
    if (!email || !email.includes('@')) {
        alert('Veuillez entrer une adresse email valide');
        return;
    }
    
    // Afficher une notification
    const btn = event.currentTarget;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Envoi...';
    btn.disabled = true;
    
    // Simulation d'envoi (à remplacer par votre appel API)
    setTimeout(() => {
        alert(`Merci pour votre inscription ! Vous recevrez nos conseils à ${email}`);
        btn.innerHTML = originalText;
        btn.disabled = false;
        document.getElementById('newsletter-email').value = '';
    }, 1000);
}
</script>
</body>
</html>