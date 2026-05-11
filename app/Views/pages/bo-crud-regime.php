<div class="bo-content">
    <div class="page-header">
        <h2>Gestion des régimes</h2>
        <p>Créer, modifier ou supprimer les programmes nutritionnels</p>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 24px;">
        <!-- Liste des régimes -->
        <div>
            <div class="bo-table">
                <div class="bo-table-header">
                    <h3>Liste des régimes</h3>
                    <div style="display: flex; gap: 12px;">
                        <form method="GET" action="<?= current_url() ?>" style="display: flex; gap: 12px;">
                            <input type="text" name="search" class="search-input" placeholder="Nom du régime" value="<?= esc($searchTerm ?? '') ?>">
                            <button type="submit" class="btn-add-bo" style="background: #3b82f6;"><i class="bi bi-search"></i> Rechercher</button>
                            <?php if(isset($searchTerm) && $searchTerm): ?>
                                <a href="<?= current_url() ?>" class="btn-add-bo" style="background: #6b7280;">Réinitialiser</a>
                            <?php endif; ?>
                        </form>
                        <button class="btn-add-bo" onclick="cancelEdit()">
                            <i class="bi bi-plus-circle-fill" style="font-size: 1.2rem; margin-right: 8px; color: var(--green-500);"></i> 
                             Nouveau régime
                            </button>
                    </div>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Durée</th>
                            <th>Variation poids</th>
                            <th>Prix</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($regimes)): ?>
                            <tr><td colspan="5" style="text-align: center; padding: 40px;">Aucun régime trouvé</td></tr>
                        <?php else: ?>
                            <?php foreach($regimes as $regime): ?>
                                <tr>
                                    <td><strong><?= esc($regime['nom']) ?></strong></td>
                                    <td><?= esc($regime['duree_semaines']) ?> semaines</td>
                                    <td style="<?= strpos($regime['variation_poids'], '+') === 0 ? 'color: var(--green-500);' : 'color: var(--red-400);' ?>">
                                        <?= $regime['variation_poids'] ?>
                                    </td>
                                    <td><?= number_format($regime['prix'], 0, ',', ' ') ?> Ar</td>
                                    <td>
                                        <div class="action-btns">
                                            <button class="btn-edit" onclick="editRegime(<?= $regime['id'] ?>)">
                                                <i class="bi bi-pencil-fill" style="color: #3b82f6;"></i> Éditer</button>
                                            <button class="btn-del" data-id="<?= $regime['id'] ?>" data-name="<?= esc($regime['nom']) ?>" onclick="deleteRegime(this)">
                                                <i class="bi bi-trash-fill" style="color: #ef4444;"></i> Supprimer</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="form-page">
            <div class="form-card">
                <h3 id="form-title"><i class="bi bi-plus-circle-fill" style="font-size: 1.2rem; margin-right: 8px; color: var(--green-500);"></i>  Nouveau régime</h3>
                <form id="regimeForm">
                    <input type="hidden" id="regimeId" name="id">
                    
                    <div class="form-group">
                        <label>Nom du régime</label>
                        <input type="text" id="regimeNom" name="nom" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Description</label>
                        <textarea id="regimeDescription" name="description" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Durée totale (semaines)</label>
                        <input type="number" id="regimeDuree" name="duree_semaines" min="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Objectif associé</label>
                        <select id="regimeObjectif" name="objectif">
                            <option value="Réduire poids">Réduire poids</option>
                            <option value="Augmenter poids">Augmenter poids</option>
                            <option value="IMC idéal">IMC idéal</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Variation poids (kg)</label>
                        <input type="number" id="regimeVariation" name="variation_poids" step="0.1" required>
                    </div>

                    <!-- Composition protéique -->
                    <div class="form-group">
                        <label>Composition protéique</label>
                        <div class="comp-inputs-buttons">
                            <div class="input-group-buttons">
                                <span class="input-label">🥩 Viande</span>
                                <div class="number-input">
                                    <button type="button" onclick="changeValue('meatInput', -1)">-</button>
                                    <input type="number" id="meatInput" name="pourcentage_viande" min="0" max="100" step="1" value="20">
                                    <button type="button" onclick="changeValue('meatInput', 1)">+</button>
                                </div>
                                <span class="input-val meat" id="meat-val">20%</span>
                            </div>
                            <div class="input-group-buttons">
                                <span class="input-label">🐟 Poisson</span>
                                <div class="number-input">
                                    <button type="button" onclick="changeValue('fishInput', -1)">-</button>
                                    <input type="number" id="fishInput" name="pourcentage_poisson" min="0" max="100" step="1" value="50">
                                    <button type="button" onclick="changeValue('fishInput', 1)">+</button>
                                </div>
                                <span class="input-val fish" id="fish-val">50%</span>
                            </div>
                            <div class="input-group-buttons">
                                <span class="input-label">🍗 Volaille</span>
                                <div class="number-input">
                                    <button type="button" onclick="changeValue('poultryInput', -1)">-</button>
                                    <input type="number" id="poultryInput" name="pourcentage_volaille" min="0" max="100" step="1" value="30">
                                    <button type="button" onclick="changeValue('poultryInput', 1)">+</button>
                                </div>
                                <span class="input-val poultry" id="poultry-val">30%</span>
                            </div>
                        </div>
                        <div class="comp-total ok" id="comp-total">Total : 100% ✓</div>
                    </div>
                    
                    <div class="form-group">
                        <label>Prix (Ar)</label>
                        <input type="number" id="regimePrix" name="prix" min="0" required>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="cancelEdit()">Annuler</button>
                        <button type="submit" class="btn-save">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// ========== GESTION DE LA COMPOSITION PROTÉIQUE ==========
function changeValue(inputId, delta) {
    let input = document.getElementById(inputId);
    let newValue = (parseInt(input.value) || 0) + delta;
    newValue = Math.min(100, Math.max(0, newValue));
    input.value = newValue;
    updateCompositionTotal();
}

function updateCompositionTotal() {
    let meat = parseInt(document.getElementById('meatInput').value) || 0;
    let fish = parseInt(document.getElementById('fishInput').value) || 0;
    let poultry = parseInt(document.getElementById('poultryInput').value) || 0;
    
    document.getElementById('meat-val').innerText = meat + '%';
    document.getElementById('fish-val').innerText = fish + '%';
    document.getElementById('poultry-val').innerText = poultry + '%';
    
    let total = meat + fish + poultry;
    let totalDiv = document.getElementById('comp-total');
    
    if(total === 100) {
        totalDiv.innerHTML = 'Total : 100% ✓';
        totalDiv.className = 'comp-total ok';
    } else if(total > 100) {
        totalDiv.innerHTML = 'Total : ' + total + '% (dépasse 100%) ⚠️';
        totalDiv.className = 'comp-total error';
    } else {
        totalDiv.innerHTML = 'Total : ' + total + '% (manque ' + (100 - total) + '%)';
        totalDiv.className = 'comp-total warning';
    }
    
    return total === 100;
}

// ========== CRUD RÉGIMES ==========
function deleteRegime(button) {
    const regimeId = button.getAttribute('data-id');
    const regimeName = button.getAttribute('data-name');
    
    if(confirm(`Êtes-vous sûr de vouloir supprimer le régime "${regimeName}" définitivement ?`)) {
        button.disabled = true;
        button.innerHTML = '⏳';
        
        fetch(`<?= base_url('bo/dashboard/regime/delete') ?>/${regimeId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                button.closest('tr').remove();
                showNotification(data.message, 'success');
                if(document.querySelector('#regimeTable tbody tr') === null) {
                    location.reload();
                }
            } else {
                showNotification(data.message, 'error');
                button.disabled = false;
                button.innerHTML = '🗑️ Supprimer';
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur lors de la suppression', 'error');
            button.disabled = false;
            button.innerHTML = '🗑️ Supprimer';
        });
    }
}

function editRegime(id) {
    fetch(`<?= base_url('bo/dashboard/regime/get') ?>/${id}`, {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            const regime = data.regime;
            
            document.getElementById('regimeId').value = regime.id;
            document.getElementById('regimeNom').value = regime.nom;
            document.getElementById('regimeDescription').value = regime.description;
            document.getElementById('regimeDuree').value = regime.duree_semaines;
            document.getElementById('regimeVariation').value = regime.variation_poids;
            document.getElementById('regimePrix').value = regime.prix;
            document.getElementById('regimeObjectif').value = regime.objectif || 'Réduire poids';
            
            document.getElementById('meatInput').value = regime.pourcentage_viande || 20;
            document.getElementById('fishInput').value = regime.pourcentage_poisson || 50;
            document.getElementById('poultryInput').value = regime.pourcentage_volaille || 30;
            
            updateCompositionTotal();
            document.getElementById('form-title').textContent = '✏️ Éditer un régime';
            document.querySelector('.form-card').scrollIntoView({ behavior: 'smooth' });
        } else {
            showNotification(data.message || 'Erreur lors du chargement', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors du chargement du régime', 'error');
    });
}

function cancelEdit() {
    document.getElementById('regimeForm').reset();
    document.getElementById('regimeId').value = '';
    
    document.getElementById('meatInput').value = 20;
    document.getElementById('fishInput').value = 50;
    document.getElementById('poultryInput').value = 30;
    
    updateCompositionTotal();
    document.getElementById('form-title').textContent = ' Nouveau régime';
}

// ========== SOUMISSION DU FORMULAIRE ==========
document.getElementById('regimeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if(!updateCompositionTotal()) {
        showNotification('La composition protéique doit totaliser 100%', 'error');
        return;
    }
    
    const regimeId = document.getElementById('regimeId').value;
    const isEdit = regimeId && regimeId !== '';
    
    const formData = {
        nom: document.getElementById('regimeNom').value.trim(),
        description: document.getElementById('regimeDescription').value.trim(),
        duree_semaines: parseInt(document.getElementById('regimeDuree').value),
        variation_poids: parseFloat(document.getElementById('regimeVariation').value),
        prix: parseFloat(document.getElementById('regimePrix').value),
        objectif: document.getElementById('regimeObjectif').value,
        pourcentage_viande: parseInt(document.getElementById('meatInput').value),
        pourcentage_poisson: parseInt(document.getElementById('fishInput').value),
        pourcentage_volaille: parseInt(document.getElementById('poultryInput').value)
    };
    
    if(!formData.nom || !formData.description || !formData.duree_semaines || isNaN(formData.prix)) {
        showNotification('Veuillez remplir tous les champs obligatoires', 'error');
        return;
    }
    
    const submitBtn = this.querySelector('.btn-save');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Enregistrement...';
    
    const url = isEdit 
        ? `<?= base_url('bo/dashboard/regime/update') ?>/${regimeId}`
        : `<?= base_url('bo/dashboard/regime/create') ?>`;
    
    fetch(url, {
        method: isEdit ? 'PUT' : 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            showNotification(data.message, 'success');
            if(!isEdit) cancelEdit();
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification(data.message || 'Erreur lors de la sauvegarde', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors de la sauvegarde', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
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

// ========== INITIALISATION ==========
document.addEventListener('DOMContentLoaded', function() {
    updateCompositionTotal();
});

// Styles pour les animations
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
    .comp-inputs-buttons { display: flex; flex-direction: column; gap: 12px; }
    .input-group-buttons { display: flex; align-items: center; gap: 12px; padding: 8px; background: #f8fafc; border-radius: 8px; }
    .input-label { width: 80px; font-weight: 500; }
    .number-input { display: flex; align-items: center; gap: 5px; flex: 1; }
    .number-input button { width: 32px; height: 32px; border: 1px solid #cbd5e1; background: white; border-radius: 6px; cursor: pointer; }
    .number-input button:hover { background: #e2e8f0; }
    .number-input input { width: 70px; text-align: center; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; }
    .input-val { width: 50px; font-weight: 600; padding: 4px 8px; border-radius: 4px; text-align: center; }
    .input-val.meat { background: #fee2e2; color: #991b1b; }
    .input-val.fish { background: #e0f2fe; color: #075985; }
    .input-val.poultry { background: #fef9c3; color: #854d0e; }
    .comp-total { padding: 10px; border-radius: 8px; text-align: center; font-weight: 500; margin-top: 12px; }
    .comp-total.ok { background: #dcfce7; color: #166534; }
    .comp-total.error { background: #fee2e2; color: #991b1b; }
    .comp-total.warning { background: #fef9c3; color: #854d0e; }
`;
document.head.appendChild(style);
</script>