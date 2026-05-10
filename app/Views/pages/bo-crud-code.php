<div class="bo-content">
    <div class="page-header">
        <h2>Codes porte-monnaie</h2>
        <p>Gérer les codes de recharge et valider les demandes</p>
    </div>
    
    <!-- Barre d'outils -->
    <div style="display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap;">
        <button class="btn-add-bo" onclick="openGenerateModal()">+ Générer des codes</button>
        <form method="GET" action="<?= current_url() ?>" style="display: flex; gap: 12px; flex: 1;">
            <input type="text" name="search" class="search-input" placeholder="Rechercher un code..." value="<?= esc($data['searchTerm'] ?? '') ?>" style="flex: 1;">
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

    <!-- KPI stats -->
    <div class="kpi-row">
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

    <!-- Liste des codes -->
    <div class="bo-table">
        <div class="bo-table-header">
            <h3>Tous les codes (<?= count($data['codes']) ?> affichés)</h3>
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

    <!-- Modal Générer des codes -->
    <div id="generateModal" class="form-overlay" style="display: none;">
        <div class="form-card-modal" style="max-width: 500px;">
            <span class="close-modal" onclick="closeGenerateModal()">&times;</span>
            <h3>Générer de nouveaux codes</h3>
            <form id="generateForm">
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
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeGenerateModal()">Annuler</button>
                    <button type="submit" class="btn-save">Générer les codes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// ========== GESTION DES MODALES ==========
function openGenerateModal() {
    const modal = document.getElementById('generateModal');
    if (modal) {
        modal.style.display = 'flex';
        // Debug
        console.log('Modal ouverte');
    } else {
        console.error('Modal #generateModal non trouvée dans le DOM');
        alert('Erreur: La modal n\'existe pas');
    }
}

function closeGenerateModal() {
    const modal = document.getElementById('generateModal');
    if (modal) {
        modal.style.display = 'none';
        // Réinitialiser le formulaire
        const form = document.getElementById('generateForm');
        if (form) {
            form.reset();
            // Remettre les valeurs par défaut
            const codeNombre = document.getElementById('codeNombre');
            const codeMontant = document.getElementById('codeMontant');
            const codeExpiration = document.getElementById('codeExpiration');
            
            if (codeNombre) codeNombre.value = 10;
            if (codeMontant) codeMontant.value = 10000;
            if (codeExpiration) {
                const today = new Date();
                const nextYear = new Date(today.setFullYear(today.getFullYear() + 1));
                codeExpiration.value = nextYear.toISOString().split('T')[0];
            }
        }
    }
}

// ========== CRUD CODES ==========
function generateCodes() {
    console.log('Function generateCodes appelée');
    
    // Récupérer les valeurs
    const nombreInput = document.getElementById('codeNombre');
    const montantSelect = document.getElementById('codeMontant');
    const expirationInput = document.getElementById('codeExpiration');
    
    if (!nombreInput || !montantSelect) {
        console.error('Champs du formulaire non trouvés');
        showNotification('Erreur technique', 'error');
        return;
    }
    
    const formData = {
        nombre: parseInt(nombreInput.value),
        montant: parseFloat(montantSelect.value),
        date_expiration: expirationInput ? expirationInput.value || null : null
    };
    
    console.log('Données à envoyer:', formData);
    
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
    const submitBtn = document.querySelector('#generateForm .btn-save');
    const originalText = submitBtn ? submitBtn.textContent : 'Générer';
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Génération...';
    }
    
    // Envoyer la requête
    fetch('<?= base_url('bo/dashboard/code/generate') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(formData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur HTTP: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Réponse:', data);
        if (data.success) {
            showNotification(data.message, 'success');
            closeGenerateModal();
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification(data.message || 'Erreur lors de la génération', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur détaillée:', error);
        showNotification('Erreur: ' + error.message, 'error');
    })
    .finally(() => {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });
}

// ========== INITIALISATION ==========
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM chargé - initialisation des événements');
    
    // Gérer la soumission du formulaire
    const generateForm = document.getElementById('generateForm');
    if (generateForm) {
        // Supprimer les anciens écouteurs pour éviter les doublons
        const newForm = generateForm.cloneNode(true);
        generateForm.parentNode.replaceChild(newForm, generateForm);
        
        newForm.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Formulaire soumis');
            generateCodes();
        });
        
        console.log('Formulaire initialisé');
    } else {
        console.error('Formulaire #generateForm non trouvé');
    }
    
    // Gérer la fermeture avec la touche Echap
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('generateModal');
            if (modal && modal.style.display === 'flex') {
                closeGenerateModal();
            }
        }
    });
});


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
                const row = document.querySelector(`tr[data-id="${id}"]`);
                if(row) row.remove();
                location.reload();
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
document.getElementById('generateForm').addEventListener('submit', function(e) {
    e.preventDefault();
    generateCodes();
});

// ========== NOTIFICATIONS ==========
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.style.cssText = `
        position: fixed; top: 20px; right: 20px; padding: 12px 20px;
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
    .form-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }
    .form-card-modal {
        background: white;
        border-radius: 16px;
        padding: 24px;
        width: 100%;
        position: relative;
    }
    .close-modal {
        position: absolute;
        top: 16px;
        right: 20px;
        font-size: 24px;
        cursor: pointer;
        color: #94a3b8;
    }
    .close-modal:hover { color: #475569; }
`;
document.head.appendChild(style);

// Fermer la modal en cliquant à l'extérieur
window.onclick = function(e) {
    const modal = document.getElementById('generateModal');
    if(e.target === modal) closeGenerateModal();
};
</script>