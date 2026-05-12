<<<<<<< HEAD
=======

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
>>>>>>> dev2

    <?php if (session()->getFlashdata('errors')): ?>
      <div class="error-bo
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
x">
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

