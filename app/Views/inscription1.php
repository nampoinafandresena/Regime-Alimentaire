<div class="auth-wrap">
  <div class="auth-side">
    <h2>Rejoignez NutriPath</h2>
    <p>Votre parcours vers une meilleure sante commence ici.</p>
    <div class="auth-steps">
      <div class="auth-step"><div class="auth-step-num done">1</div><span>Vos informations personnelles</span></div>
      <div class="auth-step"><div class="auth-step-num">2</div><span>Donnees de sante</span></div>
      <div class="auth-step"><div class="auth-step-num">3</div><span>Choix de vos objectifs</span></div>
    </div>
  </div>
  <div class="auth-form">
    <h3>Informations personnelles</h3>
    <p class="step-label">Etape 1 sur 2 — Parlez-nous de vous</p>

    <?php if (session()->getFlashdata('errors')): ?>
      <div class="error-box">
        <?php foreach (session()->getFlashdata('errors') as $message): ?>
          <div><?= esc($message) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form method="post" action="/inscription/etape-1">
      <div class="form-row">
        <div class="form-group">
          <label>Prenom</label>
          <input type="text" name="prenom" placeholder="Marie" value="<?= esc(old('prenom') ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label>Nom</label>
          <input type="text" name="nom" placeholder="Dupont" value="<?= esc(old('nom') ?? '') ?>" required>
        </div>
      </div>
      <div class="form-group">
        <label>Adresse e-mail</label>
        <input type="email" name="email" placeholder="marie@example.com" value="<?= esc(old('email') ?? '') ?>" required>
      </div>
      <div class="form-group">
        <label>Mot de passe</label>
        <input type="password" name="mot_de_passe" placeholder="Min. 6 caracteres" required>
      </div>
      <div class="form-group">
        <label>Genre</label>
        <div class="gender-btns">
          <button type="button" class="gender-btn active" onclick="selectGender(this, 'Femme')">♀ Femme</button>
          <button type="button" class="gender-btn" onclick="selectGender(this, 'Homme')">♂ Homme</button>
          <button type="button" class="gender-btn" onclick="selectGender(this, 'Autre')">⚬ Autre</button>
        </div>
        <input type="hidden" name="genre" id="genre" value="Femme">
      </div>
      <button class="form-submit" type="submit">Continuer →</button>
      <p class="form-link">Deja inscrit ? <a href="/login">Se connecter</a></p>
    </form>
  </div>
</div>

<script>
function selectGender(btn, value) {
  document.querySelectorAll('.gender-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('genre').value = value;
}
</script>

