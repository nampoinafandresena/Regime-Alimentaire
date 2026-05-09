<!-- ============================= -->
<!-- PAGE 1 : LANDING              -->
<!-- ============================= -->
<div style="padding-top: 56px;">
  <div class="landing-hero">
    <div class="landing-logo">NutriPath</div>
    <h1>Votre chemin vers un <em>poids idéal</em>, scientifiquement guidé.</h1>
    <p>Calculez votre IMC, choisissez votre objectif et recevez un programme nutritionnel sur mesure.</p>
    <div class="hero-btns">
      <a href="/inscription/etape-1" class="btn-primary">S'inscrire</a>
      <a href="/formulaire" class="btn-outline">Se connecter</a>
    </div>
  </div>

  <div class="landing-features">
    <h2>Tout ce dont vous avez besoin</h2>
    <p class="subtitle">Une approche complète et personnalisée de la nutrition</p>
    <div class="feat-grid">
      <div class="feat-card">
        <div class="feat-icon">⚖️</div>
        <h3>Calcul IMC instantané</h3>
        <p>Entrez votre taille et poids, obtenez votre IMC et une analyse complète de votre situation.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon">🥗</div>
        <h3>Régimes adaptés</h3>
        <p>5 programmes nutritionnels variés avec composition détaillée (viande, poisson, volaille).</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon">🏃</div>
        <h3>Activité sportive</h3>
        <p>Des recommandations sportives complémentaires adaptées à votre objectif et votre condition.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon">📄</div>
        <h3>Export PDF</h3>
        <p>Téléchargez votre plan complet en PDF pour le partager avec votre médecin ou coach.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon">⭐</div>
        <h3>Option Gold</h3>
        <p>Accédez à 15% de remise sur tous les régimes avec notre offre premium.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon">💰</div>
        <h3>Porte-monnaie</h3>
        <p>Rechargez votre compte avec des codes et payez vos programmes facilement.</p>
      </div>
    </div>
  </div>

  <div class="landing-imc">
    <h2>Calculez votre IMC maintenant</h2>
    <p>Découvrez votre indice de masse corporelle en quelques secondes, sans inscription</p>
    <div class="imc-widget">
      <div class="imc-field">
        <label>Taille (cm)</label>
        <input type="number" id="calc-taille" placeholder="175" value="175">
      </div>
      <div class="imc-field">
        <label>Poids (kg)</label>
        <input type="number" id="calc-poids" placeholder="72" value="72">
      </div>
      <button class="imc-btn" onclick="calcIMC()">Calculer mon IMC</button>
    </div>
    <div class="imc-result" id="imc-result"></div>
  </div>
</div>

<script>
function calcIMC() {
  const t = parseFloat(document.getElementById('calc-taille').value) / 100;
  const p = parseFloat(document.getElementById('calc-poids').value);
  if (!t || !p) return;
  const imc = (p / (t * t)).toFixed(1);
  let cat = imc < 18.5 ? 'Insuffisance pondérale' : imc < 25 ? 'Poids normal ✓' : imc < 30 ? 'Surpoids' : 'Obésité';
  let color = imc < 18.5 ? '#3b82f6' : imc < 25 ? '#3aaa6b' : imc < 30 ? '#e6a817' : '#e04646';
  const r = document.getElementById('imc-result');
  r.style.display = 'block';
  r.innerHTML = `Votre IMC est <strong style="color:${color}; font-size:24px;">${imc}</strong> — <span style="color:${color}">${cat}</span>`;
}
</script>
