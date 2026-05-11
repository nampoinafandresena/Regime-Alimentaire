



<div class="app-layout">
  <?php include ('Sidebar.php') ?>
  <div class="main-content">
    <div class="page-header"><h2>Mon profil</h2><p>Gerez vos informations et consultez votre plan nutritionnel</p></div>
    <div class="profile-layout">
      <div>
          <div class="profile-card">
          <div class="profile-avatar"><?= esc($initials) ?></div>
          <div class="profile-name"><?= esc($nom) ?></div>
          <div class="profile-email"><?= esc($email) ?></div>
          <div class="profile-stat"><span class="profile-stat-label">Genre</span><span class="profile-stat-val"><?= esc($genre) ?></span></div>
          <div class="profile-stat"><span class="profile-stat-label">Taille</span><span class="profile-stat-val"><?= esc($latestSante['taille_cm'] ?? '-') ?> cm</span></div>
          <div class="profile-stat"><span class="profile-stat-label">Poids actuel</span><span class="profile-stat-val"><?= esc($latestSante['poids_kg'] ?? '-') ?> kg</span></div>
          <div class="profile-stat"><span class="profile-stat-label">IMC actuel</span><span class="profile-stat-val" style="color: var(--gold-500);"><?= $imc !== null ? esc($imc) : '-' ?></span></div>
          <div class="profile-stat"><span class="profile-stat-label">Objectif</span><span class="profile-stat-val"><?= esc($objectifLabel ?: '-') ?></span></div>
          <button id="edit-profile-btn" style="width:100%; margin-top:16px; padding: 11px; border: 1.5px solid var(--slate-200); border-radius: var(--radius-sm); background: #fff; font-family: 'DM Sans'; font-size: 14px; cursor: pointer; color: var(--slate-700);">✏️ Modifier le profil</button>
        </div>
        <?php if (! $isGold): ?>
          <div class="gold-option">
            <div class="gold-title">⭐ Option Gold</div>
            <div style="font-size:13px; color: var(--slate-600); margin-bottom: 8px;">Paiement unique</div>
            <div class="gold-price"><?= number_format((float) ($goldOption['prix'] ?? 29.99), 2, ',', ' ') ?> Ar</div>
            <div class="gold-features">
              <div class="gold-feat"><span class="check">✓</span> 15% de remise sur tous les regimes</div>
              <div class="gold-feat"><span class="check">✓</span> Suivi personnalise avance</div>
              <div class="gold-feat"><span class="check">✓</span> Export PDF illimite</div>
              <div class="gold-feat"><span class="check">✓</span> Support prioritaire</div>
            </div>
            <form method="post" action="/profil/gold">
              <?= csrf_field() ?>
              <button class="btn-gold" type="submit">Activer Gold</button>
            </form>
          </div>
        <?php else: ?>
          <div class="gold-option">
            <div class="gold-title">⭐ Compte Gold actif</div>
            <div style="font-size:13px; color: var(--slate-600);">Vous bénéficiez déjà des avantages Gold.</div>
          </div>
        <?php endif; ?>
        <div class="wallet-section">
          <div style="font-size:13px; color:var(--slate-400); margin-bottom:4px;">Mon porte-monnaie</div>
          <div id="wallet-balance" class="wallet-balance" data-value="<?= number_format((float) ($user['solde_portefeuille'] ?? 0), 0, ',', ' ') ?>"><?= number_format((float) ($user['solde_portefeuille'] ?? 0), 0, ',', ' ') ?> Ar</div>
          <div class="wallet-sub">Solde disponible</div>
          <form id="redeem-form" method="post" action="/profil/redeem" class="wallet-code">
            <?= csrf_field() ?>
            <input name="code" placeholder="Entrer un code cadeau..." required>
            <button id="redeem-btn" type="submit">Valider</button>
          </form>
          <div id="redeem-feedback" style="margin-top:8px; font-size:14px;"></div>
        </div>
      </div>
      <div>
        <div class="result-section" id="profil-edit" style="display:none;">
          <h3>Mettre a jour mon profil</h3>
          <form method="post" action="/profil/update" style="margin-bottom:20px;">
            <div class="form-group">
              <label>Nom complet</label>
              <input type="text" name="nom" value="<?= esc($nom) ?>" required>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" value="<?= esc($email) ?>" required>
            </div>
            <div class="form-group">
              <label>Genre</label>
              <select name="genre" required>
                <option value="Homme" <?= $genre === 'Homme' ? 'selected' : '' ?>>Homme</option>
                <option value="Femme" <?= $genre === 'Femme' ? 'selected' : '' ?>>Femme</option>
                <option value="Autre" <?= $genre === 'Autre' ? 'selected' : '' ?>>Autre</option>
              </select>
            </div>
            <button class="form-submit" type="submit">Mettre a jour</button>
          </form>

          <h3 style="margin-top:24px;">Mettre a jour mes donnees de sante</h3>
          <form method="post" action="/profil/sante" style="margin-bottom:20px;">
            <div class="form-row">
              <div class="form-group">
                <label>Taille (cm)</label>
                <input type="number" name="taille_cm" step="0.01" required>
              </div>
              <div class="form-group">
                <label>Poids (kg)</label>
                <input type="number" name="poids_kg" step="0.01" required>
              </div>
            </div>
            <button class="form-submit" type="submit">Ajouter mesure</button>
          </form>

          <h3 style="margin-top:24px;">Objectifs (max 3)</h3>
          <form method="post" action="/profil/objectifs">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
              <?php foreach ($objectifs as $objectif): ?>
                <?php $checked = in_array((int) $objectif['id'], $selectedObjectifIds ?? [], true); ?>
                <label style="display:flex; align-items:center; gap:8px; padding:10px 12px; border:1px solid #e9ecef; border-radius:8px;">
                  <input type="checkbox" name="objectifs[]" value="<?= esc($objectif['id']) ?>" <?= $checked ? 'checked' : '' ?>>
                  <span><?= esc($objectif['libelle']) ?></span>
                </label>
              <?php endforeach; ?>
            </div>
            <button class="form-submit" type="submit" style="margin-top:16px;">Mettre a jour objectifs</button>
          </form>
        </div>
        
        <!-- Recommendations and objectives (visible by default) -->
        <div class="recommendations">
          <h3>Mon plan actuel</h3>
          <?php if (! empty($recommendedRegimes)): ?>
            <?php foreach ($recommendedRegimes as $r): ?>
              <div class="regime-card" style="margin-bottom:12px;">
                <div style="display:flex; justify-content:space-between; align-items:center; padding:12px;">
                  <div>
                    <div class="regime-name"><?= esc($r['nom']) ?></div>
                    <div class="regime-desc" style="font-size:13px; color:var(--slate-500);"><?= esc($r['description']) ?></div>
                  </div>
                  <div style="text-align:right;">
                    <div class="price-amount"><?= esc($r['prix']) ?> Ar</div>
                    <div class="price-period" style="font-size:12px; color:var(--slate-500);"><?= esc($r['duree_semaines']) ?> semaines</div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div style="color:var(--slate-500);">Aucun régime recommandé pour le moment.</div>
          <?php endif; ?>

          <h4 id="objectifs-summary-title" style="margin-top:18px;">Objectifs sélectionnés</h4>
          <div id="objectifs-summary" style="display:flex; flex-direction:column; gap:8px;">
            <?php if (! empty($selectedObjectifIds)): ?>
              <?php foreach ($objectifs as $obj): ?>
                <?php if (in_array((int)$obj['id'], $selectedObjectifIds, true)): ?>
                  <div style="padding:10px; background:#fff; border:1px solid var(--slate-100); border-radius:8px;"><?= esc($obj['libelle']) ?></div>
                <?php endif; ?>
              <?php endforeach; ?>
            <?php else: ?>
              <div style="color:var(--slate-500);">Aucun objectif sélectionné.</div>
            <?php endif; ?>
          </div>

          <?php if (! empty($recommendedRegimes)): ?>
            <a href="<?= base_url('profil/export-pdf') ?>" class="btn-export-pdf" style="display:inline-block; margin-top:20px; padding:12px 20px; background:#000; color:#fff; text-decoration:none; border-radius:8px; font-weight:600; text-align:center; cursor:pointer;">
              📄 Exporter mon plan en PDF
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/js/profil.js') ?>"></script>
