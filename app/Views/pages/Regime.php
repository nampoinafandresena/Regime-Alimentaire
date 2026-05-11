
<div class="app-layout">
  <?php include ('Sidebar.php') ?>
  <div class="main-content">
    <div class="page-header">
      <h2>Objectif et variation de poids</h2>
      <p>Choisissez votre objectif puis le poids a gagner ou a perdre : le systeme classe les regimes et sports dont la variation est la plus proche.</p>
    </div>
    
    <div class="card objective-card">
      <div class="card-title">Parametrer votre plan</div>
      <form class="objective-form-wrap" method="post" action="/regimes#results-section">
        <?= csrf_field() ?>
        <div class="objective-form">
          <?php foreach (($objectifs ?? []) as $objectif): ?>
            <label class="objective-option">
              <input type="radio" name="objectif_id" value="<?= esc($objectif['id']) ?>" <?= ((int) $selectedObjectifId === (int) $objectif['id']) ? 'checked' : '' ?>>
              <span class="objective-content">
                <span class="objective-name"><?= esc($objectif['libelle']) ?></span>
                <span class="objective-desc">Objectif pris en compte pour selectionner regime et sport.</span>
              </span>
            </label>
          <?php endforeach; ?>
        </div>

        <div class="duration-row">
          <label for="variation_kg">Poids a perdre ou a gagner (kg)</label>
          <input type="number" id="variation_kg" name="variation_kg" min="0.1" step="0.1" value="<?= esc($variationKg ?? 5) ?>" required>
          <span class="field-hint">Saisissez une valeur positive ; le signe (perte / prise) depend de l'objectif.</span>
          <button type="submit" class="btn-add">Generer les suggestions</button>
        </div>
      </form>
    </div>

    <div class="card suggestion-summary">
      <div class="card-title">Synthese actuelle</div>
      <p><strong>Objectif:</strong> <?= esc($objectifLabel ?? 'Non defini') ?></p>
      <p><strong>Variation demandee:</strong> <?= esc($variationKg ?? 5) ?> kg <?= isset($selectedObjectifId) && (int) $selectedObjectifId === 1 ? 'en prise' : ((int) $selectedObjectifId === 2 ? 'en perte' : '(IMC idéal : tri proche de 0)') ?></p>
      <?php if (isset($variationSouhaitee)): ?>
        <p><strong>Cible de tri (regime & sport):</strong> <?= $variationSouhaitee > 0 ? '+' : '' ?><?= esc($variationSouhaitee) ?> (comparaison ABS avec les variations en base)</p>
      <?php endif; ?>
      <p><strong>Poids actuel:</strong> <?= esc($poids ?? 0) ?> kg</p>
      <p><strong>IMC:</strong> <?= esc($imc ?? 'N/A') ?></p>
    </div>

    <!-- FORMULAIRE GLOBAL POUR RÉGIMES + SPORT (sélection unique pour le sport) -->
    <form method="post" action="/traitement-choix"> <!-- à adapter -->
      <?= csrf_field() ?>
      
      <!-- SECTION RÉGIMES (checkbox multiples) -->
      <div class="card" id="results-section">
        <div class="card-title">Regimes suggeres</div>
        <div class="regime-grid">
          <?php if (!empty($recommendedRegimes)): ?>
            <?php foreach ($recommendedRegimes as $regime): ?>
              <?php $variation = (float) $regime['variation_poids']; ?>
              <div class="regime-card">
                <div class="regime-banner green">🥗</div>
                <div class="regime-body">
                  <div class="regime-name"><?= esc($regime['nom']) ?></div>
                  <div class="regime-desc"><?= esc($regime['description']) ?></div>
                  <div class="regime-meta">
                    <span class="tag green"><?= esc($objectifLabel ?? '') ?></span>
                    <span class="tag blue"><?= esc($regime['duree_semaines_calculee'] ?? $regime['duree_semaines']) ?> semaines</span>
                    <span class="tag <?= $variation < 0 ? 'red' : 'amber' ?>">
                      Variation <?= $variation > 0 ? '+' : '' ?><?= esc($regime['variation_poids']) ?> kg
                    </span>
                  </div>
                  <div class="composition-bar">
                    <div class="comp-label">
                      Composition : Viande <?= esc($regime['pourcentage_viande']) ?>% · Poisson <?= esc($regime['pourcentage_poisson']) ?>% · Volaille <?= esc($regime['pourcentage_volaille']) ?>%
                    </div>
                    <div class="comp-bar">
                      <div class="seg-meat" style="width:<?= esc($regime['pourcentage_viande']) ?>%"></div>
                      <div class="seg-fish" style="width:<?= esc($regime['pourcentage_poisson']) ?>%"></div>
                      <div class="seg-poultry" style="width:<?= esc($regime['pourcentage_volaille']) ?>%"></div>
                    </div>
                  </div>
                  <div class="regime-price">
                    <div>
                      <?php if ((int) ($user['est_gold'] ?? 0) === 1 && isset($regime['prix_initial'])): ?>
                        <div class="price-amount" style="font-size:14px; color: var(--slate-500); text-decoration: line-through;">
                          <?= number_format((float) ($regime['prix_initial']), 0, ',', ' ') ?> Ar
                        </div>
                        <div class="price-amount">
                          <?= number_format((float) ($regime['prix_calcule']), 0, ',', ' ') ?> Ar
                        </div>
                      <?php else: ?>
                        <div class="price-amount"><?= number_format((float) ($regime['prix_calcule']), 0, ',', ' ') ?> Ar</div>
                      <?php endif; ?>
                    </div>
                  </div>
                  <!-- Checkbox pour ce régime -->
                  <div class="selection-checkbox">
                    <label>
                      <input type="checkbox" name="regime_ids[]" value="<?= esc($regime['id']) ?>">
                      Choisir ce régime
                    </label>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>Aucun regime trouve pour cet objectif.</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- SECTION SPORTS AVEC SÉLECTION UNIQUE (Radio buttons) -->
      <div class="card">
        <div class="card-title">Activites sportives suggerees</div>
        <div class="activity-list">
          <?php if (!empty($suggestedActivities)): ?>
            <?php foreach ($suggestedActivities as $activity): ?>
              <div class="activity-item">
                <div class="activity-name"><?= esc($activity['nom']) ?></div>
                <div class="activity-meta">
                  Impact poids / heure: <?= ((float) $activity['variation_poids_par_heure'] > 0 ? '+' : '') . esc($activity['variation_poids_par_heure']) ?> kg
                </div>
                <div class="activity-meta">
                  Categorie: <?= esc($activity['categorie'] ?? 'N/A') ?> · Intensite: <?= esc($activity['intensite'] ?? 'N/A') ?>
                </div>
                <!-- Radio pour sélection unique (même nom "sport_id") -->
                <div class="selection-radio">
                  <label>
                    <input type="radio" name="sport_id" value="<?= esc($activity['id']) ?>" required>
                    Sélectionner ce sport
                  </label>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>Aucune activite proposee.</p>
          <?php endif; ?>
        </div>
      </form>
    </div>

    <div class="card suggestion-summary">
      <div class="card-title">Synthese actuelle</div>
      <p><strong>Objectif:</strong> <?= esc($objectifLabel ?? 'Non defini') ?></p>
      <p><strong>Variation demandee:</strong> <?= esc($variationKg ?? 5) ?> kg <?= isset($selectedObjectifId) && (int) $selectedObjectifId === 1 ? 'en prise' : ((int) $selectedObjectifId === 2 ? 'en perte' : '(IMC idéal : tri proche de 0)') ?></p>
      <?php if (isset($variationSouhaitee)): ?>
        <p><strong>Cible de tri (regime & sport):</strong> <?= $variationSouhaitee > 0 ? '+' : '' ?><?= esc($variationSouhaitee) ?> (comparaison ABS avec les variations en base)</p>
      <?php endif; ?>
      <p><strong>Poids actuel:</strong> <?= esc($poids ?? 0) ?> kg</p>
      <p><strong>IMC:</strong> <?= esc($imc ?? 'N/A') ?></p>
    </div>

    <div class="card" id="results-section">
      <div class="card-title">Regimes suggeres</div>
      <div class="regime-grid">
        <?php if (!empty($recommendedRegimes)): ?>
          <?php foreach ($recommendedRegimes as $regime): ?>
            <?php $variation = (float) $regime['variation_poids']; ?>
            <div class="regime-card">
              <div class="regime-banner green">🥗</div>
              <div class="regime-body">
                <div class="regime-name"><?= esc($regime['nom']) ?></div>
                <div class="regime-desc"><?= esc($regime['description']) ?></div>
                <div class="regime-meta">
                  <span class="tag green"><?= esc($objectifLabel ?? '') ?></span>
                  <span class="tag blue"><?= esc($regime['duree_semaines_calculee'] ?? $regime['duree_semaines']) ?> semaines</span>
                  <span class="tag <?= $variation < 0 ? 'red' : 'amber' ?>">
                    Variation <?= $variation > 0 ? '+' : '' ?><?= esc($regime['variation_poids']) ?> kg
                  </span>
                </div>
                <div class="composition-bar">
                  <div class="comp-label">
                    Composition : Viande <?= esc($regime['pourcentage_viande']) ?>% · Poisson <?= esc($regime['pourcentage_poisson']) ?>% · Volaille <?= esc($regime['pourcentage_volaille']) ?>%
                  </div>
                  <div class="comp-bar">
                    <div class="seg-meat" style="width:<?= esc($regime['pourcentage_viande']) ?>%"></div>
                    <div class="seg-fish" style="width:<?= esc($regime['pourcentage_poisson']) ?>%"></div>
                    <div class="seg-poultry" style="width:<?= esc($regime['pourcentage_volaille']) ?>%"></div>
                  </div>
                </div>
                <div class="regime-price">
                  <div>
                    <?php if ((int) ($user['est_gold'] ?? 0) === 1 && isset($regime['prix_initial'])): ?>
                      <div class="price-amount" style="font-size:14px; color: var(--slate-500); text-decoration: line-through;">
                        <?= number_format((float) ($regime['prix_initial']), 0, ',', ' ') ?> Ar
                      </div>
                      <div class="price-amount">
                        <?= number_format((float) ($regime['prix_calcule']), 0, ',', ' ') ?> Ar
                      </div>
                    <?php else: ?>
                      <div class="price-amount"><?= number_format((float) ($regime['prix_calcule']), 0, ',', ' ') ?> Ar</div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>Aucun regime trouve pour cet objectif.</p>
        <?php endif; ?>
      </div>

      <!-- BOUTON VALIDATION GLOBAL TOUT EN BAS -->
      <div style="display: flex; justify-content: flex-end; margin-top: 20px;">
        <button type="submit" class="btn-add">Valider mon choix</button>
      </div>
    </form>

  </div>
</div>

<!-- Style additionnel pour les checkboxes / radios -->
<style>
  .selection-checkbox, .selection-radio {
    margin-top: 12px;
    padding-top: 8px;
    border-top: 1px solid #e2e8f0;
    font-size: 14px;
  }
  .selection-checkbox label, .selection-radio label {
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .activity-item {
    margin-bottom: 1rem;
    padding: 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
  }
  .btn-add {
    background-color: #10b981;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
  }
</style>
