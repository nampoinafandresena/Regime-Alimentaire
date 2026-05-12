// RESET FORMULAIRE
function resetCodeForm() {
    document.getElementById('codeForm').reset();
    document.getElementById('codeLabel').value = '';
    document.getElementById('codeMontant').value = 10000;
    
    const today = new Date();
    const nextYear = new Date(today.setFullYear(today.getFullYear() + 1));
    document.getElementById('codeExpiration').value = nextYear.toISOString().split('T')[0];
    
    document.getElementById('formTitle').innerHTML = 'Générer des codes';
}

// CRÉATION DES CODES
function createCodes() {
    const formData = {
        code: document.getElementById('codeLabel').value,
        montant: parseFloat(document.getElementById('codeMontant').value),
        date_expiration: document.getElementById('codeExpiration').value || null
    };
    
    // Validation
    if (formData.code.length < 2) {
        showNotification('Le nom du code doit faire au moins 2 caractères', 'error');
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
    fetch('/bo/dashboard/code/create', {
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

// CRUD CODES
function validerCode(id, code) {
    if(confirm(`Valider l'utilisation du code "${code}" ?`)) {
        fetch(`/bo/dashboard/code/valider/${id}`, {
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
        fetch(`/bo/dashboard/code/invalider/${id}`, {
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
        fetch(`/bo/dashboard/code/delete/${id}`, {
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
    fetch(`/bo/dashboard/code/get/${id}`, {
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

// SOUMISSION DU FORMULAIRE
document.getElementById('codeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    createCodes();
});

// document.head.appendChild(style);etTimeout(() => location.reload(), 1000);
//             } else {
//                 showNotification(data.message, 'error');
//             }
//         })
//         .catch(error => {
//             console.error('Erreur:', error);
//             showNotification('Erreur lors de la suppression', 'error');
//         });
//     }
// }

// NOTIFICATIONS
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

// STYLES
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