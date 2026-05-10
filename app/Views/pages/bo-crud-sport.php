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

<script>
// ========== CRUD SPORTS ==========
function editSport(id) {
    fetch(`<?= base_url('bo/dashboard/sport/get') ?>/${id}`, {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            const sport = data.sport;
            document.getElementById('sportId').value = sport.id;
            document.getElementById('sportName').value = sport.nom;
            document.getElementById('sportDesc').value = sport.description || '';
            document.getElementById('sportCategory').value = sport.id_categorie;
            document.getElementById('sportIntensity').value = sport.id_intensite;
            document.getElementById('sportCalories').value = sport.variation_poids_par_heure;
            document.getElementById('formTitle').innerHTML = '✏️ Modifier une activité';
            
            // Faire défiler vers le formulaire
            document.querySelector('.form-card').scrollIntoView({ behavior: 'smooth' });
        } else {
            showNotification(data.message || 'Erreur lors du chargement', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors du chargement de l\'activité', 'error');
    });
}

function deleteSport(id, name) {
    if(confirm(`Supprimer définitivement l'activité "${name}" ?`)) {
        fetch(`<?= base_url('bo/dashboard/sport/delete') ?>/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const row = document.querySelector(`tr[data-id="${id}"]`);
                if(row) row.remove();
                showNotification(data.message, 'success');
                
                // Mettre à jour le compteur
                const count = document.querySelectorAll('#sportsTableBody tr:not(.no-data)').length;
                document.querySelector('.bo-table-header h3').innerHTML = `Liste des activités (${count})`;
                
                if(count === 0) {
                    document.getElementById('sportsTableBody').innerHTML = `
                        <tr class="no-data">
                            <td colspan="5" style="text-align: center; padding: 40px;">
                                Aucune activité sportive trouvée
                            </td>
                        </tr>
                    `;
                }
            } else {
                showNotification(data.message || 'Erreur lors de la suppression', 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur lors de la suppression', 'error');
        });
    }
}

function resetForm() {
    document.getElementById('sportForm').reset();
    document.getElementById('sportId').value = '';
    document.getElementById('formTitle').innerHTML = '➕ Ajouter une activité';
}

// ========== SOUMISSION DU FORMULAIRE ==========
document.getElementById('sportForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const sportId = document.getElementById('sportId').value;
    const isEdit = sportId && sportId !== '';
    
    const formData = {
        nom: document.getElementById('sportName').value.trim(),
        description: document.getElementById('sportDesc').value.trim(),
        id_categorie: document.getElementById('sportCategory').value,
        id_intensite: document.getElementById('sportIntensity').value,
        variation_poids_par_heure: parseFloat(document.getElementById('sportCalories').value)
    };
    
    if(!formData.nom || !formData.id_categorie || !formData.id_intensite || isNaN(formData.variation_poids_par_heure)) {
        showNotification('Veuillez remplir tous les champs obligatoires', 'error');
        return;
    }
    
    const submitBtn = this.querySelector('.btn-save');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Enregistrement...';
    
    const url = isEdit 
        ? `<?= base_url('bo/dashboard/sport/update') ?>/${sportId}`
        : `<?= base_url('bo/dashboard/sport/create') ?>`;
    
    fetch(url, {
        method: isEdit ? 'POST' : 'POST',
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

// ========== STYLES DYNAMIQUES ==========
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
    .badge-category, .badge-intensity {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    .badge-cardio { background: #dbeafe; color: #1e40af; }
    .badge-force { background: #fee2e2; color: #991b1b; }
    .badge-flexibilite { background: #e0e7ff; color: #3730a3; }
    .badge-plein-air { background: #dcfce7; color: #166534; }
    .badge-douceur { background: #fef9c3; color: #854d0e; }
    .intensity-faible { background: #dcfce7; color: #166534; }
    .intensity-modérée { background: #fef9c3; color: #854d0e; }
    .intensity-élevée { background: #fee2e2; color: #991b1b; }
`;
document.head.appendChild(style);
</script>