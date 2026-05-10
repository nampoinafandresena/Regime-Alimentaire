<div class="bo-content">
    <div class="page-header">
        <h2>Gestion des activités sportives</h2>
        <p>Créer, modifier ou supprimer les programmes sportifs</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 420px; gap: 24px;">
        <!-- Liste des activités -->
        <div>
            <div class="bo-table">
                <div class="bo-table-header">
                    <h3>Liste des activités (<?= count($sports ?? []) ?>)</h3>
                    <div style="display: flex; gap: 12px;">
                        <form method="GET" action="<?= current_url() ?>" style="display: flex; gap: 12px;">
                            <input type="text" name="search" class="search-input" placeholder="Rechercher..." value="<?= esc($searchTerm ?? '') ?>">
                            <select name="categorie" class="search-input">
                                <option value="">Toutes catégories</option>
                                <?php foreach($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= ($filtreCategorie ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                        <?= esc($cat['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <select name="intensite" class="search-input">
                                <option value="">Toutes intensités</option>
                                <?php foreach($intensites as $int): ?>
                                    <option value="<?= $int['id'] ?>" <?= ($filtreIntensite ?? '') == $int['id'] ? 'selected' : '' ?>>
                                        <?= esc($int['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn-add-bo" style="background: #3b82f6;">🔍 Filtrer</button>
                            <?php if(isset($searchTerm) && $searchTerm): ?>
                                <a href="<?= current_url() ?>" class="btn-add-bo" style="background: #6b7280;">Réinitialiser</a>
                            <?php endif; ?>
                        </form>
                        <button class="btn-add-bo" onclick="resetForm()">+ Nouvelle activité</button>
                    </div>
                </div>
                
                <table id="sportsTable">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>Calories/heure</th>
                            <th>Intensité</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sportsTableBody">
                        <?php if(empty($sports)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px;">
                                    Aucune activité sportive trouvée
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($sports as $sport): ?>
                                <tr data-id="<?= $sport['id'] ?>">
                                    <td><strong><?= esc($sport['nom']) ?></strong></td>
                                    <td>
                                        <span class="badge-category badge-<?= strtolower(str_replace(' ', '-', $sport['categorie'])) ?>">
                                            <?= esc($sport['categorie']) ?>
                                        </span>
                                    </td>
                                    <td><?= number_format($sport['variation_poids_par_heure'], 1) ?> cal/h</td>
                                    <td>
                                        <span class="badge-intensity intensity-<?= strtolower($sport['intensite']) ?>">
                                            <?= esc($sport['intensite']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            <button class="btn-edit" onclick="editSport(<?= $sport['id'] ?>)">✏️ Éditer</button>
                                            <button class="btn-del" onclick="deleteSport(<?= $sport['id'] ?>, '<?= esc($sport['nom']) ?>')">🗑️ Supprimer</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Formulaire CRUD -->
        <div class="form-page">
            <div class="form-card" id="formCard">
                <h3 id="formTitle">➕ Ajouter une activité</h3>
                <form id="sportForm">
                    <input type="hidden" id="sportId" name="id">
                    
                    <div class="form-group">
                        <label>Nom de l'activité</label>
                        <input type="text" id="sportName" name="nom" required placeholder="Ex: Course à pied">
                    </div>
                    
                    <div class="form-group">
                        <label>Description</label>
                        <textarea id="sportDesc" name="description" rows="3" placeholder="Description détaillée de l'activité..."></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Catégorie</label>
                            <select id="sportCategory" name="categorie" required>
                                <option value="">Sélectionner une catégorie</option>
                                <?php foreach($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= esc($cat['nom']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Intensité</label>
                            <select id="sportIntensity" name="intensite" required>
                                <option value="">Sélectionner une intensité</option>
                                <?php foreach($intensites as $int): ?>
                                    <option value="<?= $int['id'] ?>"><?= esc($int['nom']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Calories brûlées par heure (kg/semaine)</label>
                        <input type="number" id="sportCalories" name="variation_poids_par_heure" step="0.1" required placeholder="Ex: 0.5">
                        <small style="color: var(--slate-500);">Variation de poids estimée par heure d'activité (en kg)</small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="resetForm()">Annuler</button>
                        <button type="submit" class="btn-save">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/bo_crud_sport.js') ?>"></script>