  <div class="bo-content">
    <div class="page-header"><h2>Gestion des régimes</h2><p>Créer, modifier ou supprimer les programmes nutritionnels</p></div>
    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 24px;">
      <div>
        <div class="bo-table">
          <div class="bo-table-header">
            <h3>Liste des régimes</h3>
            <form method="GET" action="<?= current_url() ?>" style="display: flex; gap: 12px;">
              <input type="text" name="search" class="search-input" placeholder="Nom du Regime" value="<?= esc($searchTerm ?? '') ?>">
              <button type="submit" class="btn-add-bo" style="background: #3b82f6;"><i class="bi bi-search"></i> Rechercher</button>
              <?php if(isset($searchTerm) && $searchTerm): ?>
                <a href="<?= current_url() ?>" class="btn-add-bo" style="background: #6b7280;">Réinitialiser</a>
                <?php endif; ?>
              </form>
              <button class="btn-add-bo" onclick="cancelEdit()">+ Nouveau régime</button>
            </div>
          <table>
            <thead><tr><th>Nom</th><th>Durée</th><th>Variation poids</th><th>Prix (4 sem.)</th><th>Actions</th></tr></thead>
            <tbody>
              <?php if(empty($regimes)): ?>
                <tr>
                  <td colspan="5" style="text-align: center; padding: 40px;">
                    Aucun régime trouvé
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach($regimes as $regime): ?>
                  <tr>
                    <td><strong><?= esc($regime['nom']) ?></strong></td>
                    <td><?= esc($regime['duree_semaines']) ?> semaines</td>
                    <td style="color: var(--red-400);">
                      <?php 
                        $variation = $regime['variation_poids'];
                        if(strpos($variation, '+') === 0) {
                          echo '<span style="color: var(--green-500);">' . $variation . '</span>';
                        } else {
                          echo $variation;
                        }
                      ?>
                    </td>
                    <td><?= number_format($regime['prix'], 0, ',', ' ') ?> Ar</td>
                    <td>
                      <div class="action-btns">
                        <button class="btn-edit" onclick="editRegime(<?= $regime['id'] ?>)">✏️ Éditer</button>
                        <button class="btn-del" 
                                data-id="<?= $regime['id'] ?>" 
                                data-name="<?= esc($regime['nom']) ?>"
                                onclick="deleteRegime(this)">
                          🗑️
                        </button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="form-page">
        <div class="form-card">
          <h3 id="form-title">✏️ Éditer un régime</h3>
          <form id="regimeForm">
            <input type="hidden" id="regimeId" name="id" value="">
            <div class="form-group">
              <label>Nom du régime</label>
              <input type="text" id="regimeNom" name="nom" value="" required>
            </div>
            <div class="form-group">
              <label>Description</label>
              <textarea id="regimeDescription" name="description" rows="3" required></textarea>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>Durée totale (semaines)</label>
                <input type="number" id="regimeDuree" name="duree_semaines" value="" min="1" required>
              </div>
              <div class="form-group">
                <label>Objectif associé</label>
                <select id="regimeObjectif" name="objectif">
                  <option value="Réduire poids">Réduire poids</option>
                  <option value="Augmenter poids">Augmenter poids</option>
                  <option value="IMC idéal">IMC idéal</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>Variation min (kg)</label>
                <input type="number" id="regimeVariationMin" name="variation_min" value="" step="0.1" required>
              </div>
              <div class="form-group">
                <label>Variation max (kg)</label>
                <input type="number" id="regimeVariationMax" name="variation_max" value="" step="0.1" required>
              </div>
            </div>
            <div class="form-group">
              <label>Composition protéique</label>
              <div class="comp-sliders">
                <div class="slider-group">
                  <span class="slider-label">🥩 Viande</span>
                  <input type="range" id="meatSlider" name="pourcentage_viande" min="0" max="100" value="20" oninput="updateComp(this,'meat-val')">
                  <span class="slider-val meat" id="meat-val">20%</span>
                </div>
                <div class="slider-group">
                  <span class="slider-label">🐟 Poisson</span>
                  <input type="range" id="fishSlider" name="pourcentage_poisson" min="0" max="100" value="50" oninput="updateComp(this,'fish-val')">
                  <span class="slider-val fish" id="fish-val">50%</span>
                </div>
                <div class="slider-group">
                  <span class="slider-label">🍗 Volaille</span>
                  <input type="range" id="poultrySlider" name="pourcentage_volaille" min="0" max="100" value="30" oninput="updateComp(this,'poultry-val')">
                  <span class="slider-val poultry" id="poultry-val">30%</span>
                </div>
              </div>
              <div class="comp-total ok" id="comp-total">Total : 100% ✓</div>
            </div>
            <div class="form-group">
              <label>Prix (Ar)</label>
              <input type="number" id="regimePrix" name="prix" value="" min="0" required>
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
</div>

<script>
function updateComp(el, targetId) {
  document.getElementById(targetId).textContent = el.value + '%';
  const sliders = document.querySelectorAll('#page-bo-crud input[type=range]');
  let total = 0;
  sliders.forEach(s => total += parseInt(s.value));
  const totalEl = document.getElementById('comp-total');
  totalEl.textContent = 'Total : ' + total + '% ' + (total === 100 ? '✓' : '⚠ doit être = 100%');
  totalEl.className = 'comp-total ' + (total === 100 ? 'ok' : 'warn');
}

// Fonction de suppression dynamique des régimes
function deleteRegime(button) {
    const regimeId = button.getAttribute('data-id');
    const regimeName = button.getAttribute('data-name');
    
    if (confirm(`Êtes-vous sûr de vouloir supprimer le régime "${regimeName}" définitivement ?`)) {
        // Désactiver le bouton pendant la requête
        button.disabled = true;
        button.innerHTML = '⏳';
        
        // Obtenir le token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        
        fetch(`<?= base_url('bo/dashboard/regime/delete') ?>/${regimeId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Supprimer la ligne du tableau
                const row = button.closest('tr');
                row.remove();
                
                // Afficher un message de succès
                showNotification(data.message, 'success');
            } else {
                showNotification(data.message, 'error');
                // Réactiver le bouton
                button.disabled = false;
                button.innerHTML = '🗑️';
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur lors de la suppression', 'error');
            // Réactiver le bouton
            button.disabled = false;
            button.innerHTML = '🗑️';
        });
    }
}

// Fonction d'édition des régimes
function editRegime(id) {
    // Obtenir le token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    fetch(`<?= base_url('bo/dashboard/regime/get') ?>/${id}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const regime = data.regime;
            
            // Remplir le formulaire avec les données du régime
            document.getElementById('regimeId').value = regime.id;
            document.getElementById('regimeNom').value = regime.nom;
            document.getElementById('regimeDescription').value = regime.description;
            document.getElementById('regimeDuree').value = regime.duree_semaines;
            document.getElementById('regimePrix').value = regime.prix;
            
            // Gérer les variations de poids
            const variation = regime.variation_poids;
            if (variation && variation !== 'N/A') {
                const parts = variation.split(' à ');
                if (parts.length === 2) {
                    document.getElementById('regimeVariationMin').value = parts[0].replace('−', '-');
                    document.getElementById('regimeVariationMax').value = parts[1].replace('−', '-');
                }
            }
            
            // Composition protéique
            document.getElementById('meatSlider').value = regime.pourcentage_viande || 0;
            document.getElementById('fishSlider').value = regime.pourcentage_poisson || 0;
            document.getElementById('poultrySlider').value = regime.pourcentage_volaille || 0;
            
            // Mettre à jour les affichages des pourcentages
            updateComp(document.getElementById('meatSlider'), 'meat-val');
            updateComp(document.getElementById('fishSlider'), 'fish-val');
            updateComp(document.getElementById('poultrySlider'), 'poultry-val');
            
            // Changer le titre du formulaire
            document.getElementById('form-title').textContent = '✏️ Éditer un régime';
            
            // Faire défiler vers le formulaire
            document.querySelector('.form-card').scrollIntoView({ behavior: 'smooth' });
            
        } else {
            showNotification(data.message || 'Erreur lors du chargement du régime', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors du chargement du régime', 'error');
    });
}

// Fonction pour annuler l'édition
function cancelEdit() {
    // Vider le formulaire
    document.getElementById('regimeForm').reset();
    document.getElementById('regimeId').value = '';
    
    // Remettre les valeurs par défaut pour les sliders
    document.getElementById('meatSlider').value = 20;
    document.getElementById('fishSlider').value = 50;
    document.getElementById('poultrySlider').value = 30;
    
    // Mettre à jour les affichages
    updateComp(document.getElementById('meatSlider'), 'meat-val');
    updateComp(document.getElementById('fishSlider'), 'fish-val');
    updateComp(document.getElementById('poultrySlider'), 'poultry-val');
    
    // Changer le titre
    document.getElementById('form-title').textContent = '➕ Nouveau régime';
}

// Gestionnaire de soumission du formulaire
document.getElementById('regimeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const regimeId = formData.get('id');
    const isEdit = regimeId && regimeId !== '';
    
    // Validation basique
    const nom = formData.get('nom').trim();
    const description = formData.get('description').trim();
    const duree = parseInt(formData.get('duree_semaines'));
    const prix = parseFloat(formData.get('prix'));
    
    if (!nom || !description || !duree || isNaN(prix)) {
        showNotification('Veuillez remplir tous les champs obligatoires', 'error');
        return;
    }
    
    // Obtenir le token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    // Désactiver le bouton de soumission
    const submitBtn = this.querySelector('.btn-save');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Enregistrement...';
    
    // Préparer les données pour l'envoi
    const data = {
        nom: nom,
        description: description,
        duree_semaines: duree,
        prix: prix,
        pourcentage_viande: parseInt(formData.get('pourcentage_viande')),
        pourcentage_poisson: parseInt(formData.get('pourcentage_poisson')),
        pourcentage_volaille: parseInt(formData.get('pourcentage_volaille')),
        variation_min: parseFloat(formData.get('variation_min')),
        variation_max: parseFloat(formData.get('variation_max'))
    };
    
    const url = isEdit 
        ? `<?= base_url('bo/dashboard/regime/update') ?>/${regimeId}`
        : `<?= base_url('bo/dashboard/regime/create') ?>`;
    
    const method = isEdit ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            
            // Vider le formulaire si c'était une création
            if (!isEdit) {
                cancelEdit();
            }
            
            // Recharger la page pour mettre à jour la liste
            setTimeout(() => {
                location.reload();
            }, 1500);
            
        } else {
            showNotification(data.message || 'Erreur lors de la sauvegarde', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors de la sauvegarde', 'error');
    })
    .finally(() => {
        // Réactiver le bouton
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
});

// Fonction de notification
function showNotification(message, type) {
    // Créer une notification temporaire
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 1000;
        animation: slideIn 0.3s ease-out;
    `;
    
    if (type === 'success') {
        notification.style.backgroundColor = '#10b981';
    } else {
        notification.style.backgroundColor = '#ef4444';
    }
    
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Supprimer après 3 secondes
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-in';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Styles pour les notifications
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
