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
