// ========== CRUD SPORTS ==========
function editSport(id) {
    fetch(`/bo/dashboard/sport/get/${id}`, {
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
        fetch(`/bo/dashboard/sport/delete/${id}`, {
            method: 'POST',
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
        ? `/bo/dashboard/sport/update/${sportId}`
        : `/bo/dashboard/sport/create`;
    
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