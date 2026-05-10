<form action="/login" method="post" id="loginForm">
    <div class="login-wrap">
        <div class="login-box">
            <div class="login-logo">NutriPath</div>
            <p class="login-sub">Connectez-vous à votre compte</p>
            
            <!-- Champ caché pour stocker le rôle sélectionné -->
            <input type="hidden" name="role" id="selectedRole" value="user">
            
            <div class="login-role">
                <button type="button" class="role-btn active" data-role="user">Utilisateur</button>
                <button type="button" class="role-btn" data-role="admin">Administrateur</button>
            </div>
            
            <?php if(isset($erreur)): ?>
                <div class="flash flash-error">
                    <i class="fa-solid fa-circle-exclamation"></i> <?= esc($erreur) ?>
                </div>
            <?php endif; ?>
            
            <div class="form-group">
                <label>Adresse e-mail</label>
                <input type="email" name="email" placeholder="marie@example.com" required>
            </div>
            
            <div class="form-group">
                <label>Mot de passe</label>
                <div class="input-with-icon">
                    <input type="password" id="login-password" name="password" placeholder="••••••••" required>
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
// Gestion des boutons rôle
document.querySelectorAll('.role-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Supprimer la classe active de tous les boutons
        document.querySelectorAll('.role-btn').forEach(b => b.classList.remove('active'));
        // Ajouter la classe active au bouton cliqué
        this.classList.add('active');
        
        // Récupérer la valeur du rôle (data-role)
        const role = this.getAttribute('data-role');
        
        // Mettre à jour le champ caché
        document.getElementById('selectedRole').value = role;
        
        // Optionnel : Afficher dans la console pour déboguer
        console.log('Rôle sélectionné :', role);
    });
});

// Toggle password
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

// Optionnel : Vérifier que le rôle est sélectionné avant soumission
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const role = document.getElementById('selectedRole').value;
    console.log('Envoi du formulaire avec rôle :', role);
});
</script>