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
                <h3 id="formTitle">➕ Générer des codes</h3>
                <form id="codeForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nombre de codes</label>
                            <input type="number" id="codeNombre" name="nombre" value="10" min="1" max="100" required>
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

<script>
// ========== RESET FORMULAIRE ==========
function resetCodeForm() {
    document.getElementById('codeForm').reset();
    document.getElementById('codeNombre').value = 10;
    document.getElementById('codeMontant').value = 10000;
    
    const today = new Date();
    const nextYear = new Date(today.setFullYear(today.getFullYear() + 1));
    document.getElementById('codeExpiration').value = nextYear.toISOString().split('T')[0];
    
    document.getElementById('formTitle').innerHTML = '➕ Générer des codes';
}

// ========== GÉNÉRATION DES CODES ==========
function generateCodes() {
    const formData = {
        nombre: parseInt(document.getElementById('codeNombre').value),
        montant: parseFloat(document.getElementById('codeMontant').value),
        date_expiration: document.getElementById('codeExpiration').value || null
    };
    
    // Validation
    if (formData.nombre < 1 || formData.nombre > 100) {
        showNotification('Le nombre doit être entre 1 et 100', 'error');
        return;
    }
    
    if (isNaN(formData.montant) || formData.montant <= 0) {
        showNotification('Le montant doit être valide', 'error');
        return;
    }
    
    // Désactiver le bouton pendant l'envoi
    const submitBtn = document.querySelector('#codeForm .btn-save');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Génération...';
    
    // Envoyer la requête
    fetch('<?= base_url('bo/dashboard/code/generate') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            resetCodeForm();
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification(data.message || 'Erreur lors de la génération', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors de la génération', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
}

// ========== CRUD CODES ==========
function validerCode(id, code) {
    if(confirm(`Valider l'utilisation du code "${code}" ?`)) {
        fetch(`<?= base_url('bo/dashboard/code/valider') ?>/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur lors de la validation', 'error');
        });
    }
}

function invaliderCode(id, code) {
    if(confirm(`Invalider le code "${code}" ?`)) {
        fetch(`<?= base_url('bo/dashboard/code/invalider') ?>/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur lors de l\'invalidation', 'error');
        });
    }
}

function deleteCode(id, code) {
    if(confirm(`Supprimer définitivement le code "${code}" ?`)) {
        fetch(`<?= base_url('bo/dashboard/code/delete') ?>/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur lors de la suppression', 'error');
        });
    }
}

function voirCode(id) {
    fetch(`<?= base_url('bo/dashboard/code/get') ?>/${id}`, {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            const code = data.code;
            alert(`Code: ${code.code}\nMontant: ${Number(code.montant).toLocaleString()} Ar\nStatut: ${code.est_valide ? 'Actif' : 'Inactif'}\nExpiration: ${code.date_expiration || 'N/A'}`);
        } else {
            showNotification('Code non trouvé', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors du chargement', 'error');
    });
}

// ========== SOUMISSION DU FORMULAIRE ==========
document.getElementById('codeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    generateCodes();
});

// ========== NOTIFICATIONS ==========
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.style.cssText = `
        position: fixed; bottom: 20px; right: 20px; padding: 12px 20px;
        border-radius: 8px; color: white; font-weight: 500;
        z-index: 1000; animation: slideIn 0.3s ease-out;
        background-color: ${type === 'success' ? '#10b981' : '#ef4444'};
    `;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-in';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// ========== STYLES ==========
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>