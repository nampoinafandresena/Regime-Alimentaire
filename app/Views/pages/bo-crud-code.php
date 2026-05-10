<div class="bo-content">
    <div class="page-header">
        <h2>Codes porte-monnaie</h2>
        <p>Gérer les codes de recharge et valider les demandes</p>
    </div>

    <!-- KPI stats -->
    <div class="kpi-row" style="margin-top: 24px;">
        <div class="kpi-card">
            <div class="kpi-label">Codes générés</div>
            <div class="kpi-value"><?= $data['totalCodes'] ?></div>
            <div class="kpi-trend">Total des codes</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Codes validés</div>
            <div class="kpi-value" style="color: var(--green-500);"><?= $data['validatedCodes'] ?></div>
            <div class="kpi-trend"><?= $data['totalCodes'] > 0 ? round(($data['validatedCodes'] / $data['totalCodes']) * 100, 1) : 0 ?>% du total</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Codes disponibles</div>
            <div class="kpi-value" style="color: var(--gold-500);"><?= $data['availableCodes'] ?></div>
            <div class="kpi-trend"><?= $data['totalCodes'] > 0 ? round(($data['availableCodes'] / $data['totalCodes']) * 100, 1) : 0 ?>% restants</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 420px; gap: 24px;">
        <!-- Liste des codes -->
        <div>
            <div class="bo-table">
                <div class="bo-table-header">
                    <h3>Tous les codes (<?= count($data['codes']) ?> affichés)</h3>
                    <div style="display: flex; gap: 12px;">
                        <form method="GET" action="<?= current_url() ?>" style="display: flex; gap: 12px;">
                            <input type="text" name="search" class="search-input" placeholder="Rechercher un code..." value="<?= esc($data['searchTerm'] ?? '') ?>">
                            <select name="statut" class="search-input">
                                <option value="">Tous les statuts</option>
                                <option value="valide" <?= ($data['statutFilter'] ?? '') === 'valide' ? 'selected' : '' ?>>Validés</option>
                                <option value="attente" <?= ($data['statutFilter'] ?? '') === 'attente' ? 'selected' : '' ?>>En attente</option>
                                <option value="expire" <?= ($data['statutFilter'] ?? '') === 'expire' ? 'selected' : '' ?>>Expirés</option>
                            </select>
                            <button type="submit" class="btn-add-bo" style="background: #3b82f6;">
                                <i class="bi bi-funnel-fill"></i> Filtrer
                            </button>
                            <?php if(isset($data['searchTerm']) && $data['searchTerm']): ?>
                                <a href="<?= current_url() ?>" class="btn-add-bo" style="background: #6b7280;">Réinitialiser</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Utilisateur</th>
                            <th>Date validation</th>
                            <th>Expiration</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($data['codes'])): ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px;">
                                    Aucun code trouvé
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($data['codes'] as $code): ?>
                                <tr>
                                    <td><strong><?= esc($code['code']) ?></strong></td>
                                    <td><?= number_format($code['montant'], 0, ',', ' ') ?> Ar</td>
                                    <td>
                                        <?php 
                                        $estValide = $code['est_valide'] == 1;
                                        $aEteUtilise = !empty($code['id_utilisateur']);
                                        $estExpire = $code['date_expiration'] && strtotime($code['date_expiration']) < time();
                                        
                                        if($estExpire && $estValide): ?>
                                            <span class="badge-status badge-inactive">Expiré</span>
                                        <?php elseif($aEteUtilise): ?>
                                            <span class="badge-status badge-active">Validé</span>
                                        <?php elseif($estValide): ?>
                                            <span class="badge-status badge-pending">En attente</span>
                                        <?php else: ?>
                                            <span class="badge-status badge-inactive">Inactif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($aEteUtilise): ?>
                                            <strong><?= esc($code['utilisateur_nom'] ?? '') ?></strong><br>
                                            <small><?= esc($code['utilisateur_email'] ?? '') ?></small>
                                        <?php else: ?>
                                            —
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($aEteUtilise): ?>
                                            <?= date('d/m/Y', strtotime($code['date_utilisation_code'])) ?>
                                        <?php else: ?>
                                            —
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($code['date_expiration']): ?>
                                            <span style="color: <?= strtotime($code['date_expiration']) < time() ? '#ef4444' : '#10b981' ?>">
                                                <?= date('d/m/Y', strtotime($code['date_expiration'])) ?>
                                            </span>
                                        <?php else: ?>
                                            —
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            <?php if(!$aEteUtilise && $estValide && !$estExpire): ?>
                                                <button class="btn-edit" onclick="validerCode(<?= $code['id'] ?>, '<?= esc($code['code']) ?>')">✅ Valider</button>
                                                <button class="btn-del" onclick="invaliderCode(<?= $code['id'] ?>, '<?= esc($code['code']) ?>')">❌ Invalider</button>
                                            <?php else: ?>
                                                <button class="btn-edit" onclick="voirCode(<?= $code['id'] ?>)">👁️ Voir</button>
                                            <?php endif; ?>
                                            <button class="btn-del" onclick="deleteCode(<?= $code['id'] ?>, '<?= esc($code['code']) ?>')">🗑️ Supprimer</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Formulaire CRUD pour générer des codes (comme le formulaire sport) -->
        <div class="form-page">
            <div class="form-card" id="formCard">
                <h3 id="formTitle">
                    <i class="bi bi-plus-circle-fill" style="font-size: 1.2rem; margin-right: 8px; color: var(--green-500);"></i> 
                    Générer des codes
                </h3>
                <form id="codeForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Label du code</label>
                            <input type="text" id="codeLabel" name="label" placeholder="Ex: COD10" required>
                        </div>
                        <div class="form-group">
                            <label>Valeur par code (Ar)</label>
                            <select id="codeMontant" name="montant" required>
                                <option value="5000">5 000 Ar</option>
                                <option value="10000" selected>10 000 Ar</option>
                                <option value="20000">20 000 Ar</option>
                                <option value="50000">50 000 Ar</option>
                                <option value="100000">100 000 Ar</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Date d'expiration (optionnel)</label>
                        <input type="date" id="codeExpiration" name="date_expiration" value="<?= date('Y-m-d', strtotime('+1 year')) ?>">
                        <small style="color: var(--slate-500);">Laissez vide pour une durée illimitée</small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="resetCodeForm()">Annuler</button>
                        <button type="submit" class="btn-save">Générer les codes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script src="/assets/js/bo_crud_code.js"></script>