<div class="bo-content">
    <div class="page-header">
        <h2>Gestion des utilisateurs</h2>
        <p>CRUD complet + statistiques IMC, objectifs, statut Gold</p>
    </div>
    
    <!-- KPI stats -->
    <div class="kpi-row" id="kpiStats">
    <div class="kpi-card">
        <div class="kpi-label">
            <i class="fas fa-users" style="font-size: 1rem; margin-right: 8px;"></i> 
            Total utilisateurs
        </div>
        <div class="kpi-value"><?= $dataUser ?></div>
    </div>
    
    <div class="kpi-card">
        <div class="kpi-label">
            <i class="fas fa-crown" style="font-size: 1rem; margin-right: 8px; color: #e6a817;"></i> 
            Membres Gold
        </div>
        <div class="kpi-value"><?= $dataGold ?></div>
        <div class="kpi-trend">-15% sur régimes</div>
    </div>
    
    <div class="kpi-card">
        <div class="kpi-label">
            <i class="fas fa-coins" style="font-size: 1rem; margin-right: 8px;"></i> 
            Porte-monnaie total
        </div>
        <div class="kpi-value"><?= number_format($soldePortefeuille ?? 0, 2, ',', ' ') ?> €</div>
        <div class="kpi-trend">Fonds cumulés</div>
    </div>
    
    <div class="kpi-card">
        <div class="kpi-label">
            <i class="fas fa-chart-line" style="font-size: 1rem; margin-right: 8px;"></i> 
            IMC moyen
        </div>
        <div class="kpi-value"><?= number_format($imcMoyen ?? 0, 1) ?></div>
        <div class="kpi-trend">Normale ~18.5-25</div>
    </div>
</div>

    <!-- Graphiques IMC / Objectifs (avec Chart.js) -->
    <div class="chart-stats">
        <div class="stat-chart-card"><h3 style="font-size: 1rem; margin-bottom: 12px;">Répartition des objectifs</h3><canvas id="goalChart" height="150" style="max-height: 180px;"></canvas></div>
        <div class="stat-chart-card"><h3 style="font-size: 1rem; margin-bottom: 12px;">Distribution IMC</h3><canvas id="imcChart" height="150" style="max-height: 180px;"></canvas></div>
    </div>

    <!-- Formulaire de recherche -->
    <div class="bo-table">
        <div class="bo-table-header">
            <h3><i class="bi bi-people"></i> Liste des utilisateurs</h3>
            <div style="display: flex; gap: 12px;">
                <form method="GET" action="<?= current_url() ?>" style="display: flex; gap: 12px;">
                    <input type="text" name="search" class="search-input" placeholder="🔍 Nom, email..." value="<?= esc($searchTerm ?? '') ?>">
                    <button type="submit" class="btn-add-bo" style="background: #3b82f6;"><i class="bi bi-search"></i> Rechercher</button>
                    <?php if(isset($searchTerm) && $searchTerm): ?>
                        <a href="<?= current_url() ?>" class="btn-add-bo" style="background: #6b7280;">Réinitialiser</a>
                    <?php endif; ?>
                </form>
                <a href="<?= base_url('backoffice/addUserForm') ?>" class="btn-add-bo"><i class="bi bi-person-plus"></i> Nouvel utilisateur</a>
            </div>
        </div>
        <div style="overflow-x: auto;">
            <table id="usersTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom complet</th>
                        <th>Email</th>
                        <th>Genre</th>
                        <th>Taille/Poids</th>
                        <th>IMC</th>
                        <th>Objectif</th>
                        <th>Wallet (€)</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($dataUserInfos)): ?>
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 40px;">
                                Aucun utilisateur trouvé
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($dataUserInfos as $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><strong><?= esc($user['nom']) ?></strong></td>
                                <td><?= esc($user['email']) ?></td>
                                <td><?= esc($user['genre']) ?></td>
                                <td><?= esc($user['taille_poids']) ?></td>
                                <td>
                                    <span class="imc-badge">
                                        <?= $user['imc'] ?> 
                                        (<?= getIMCCategory($user['imc']) ?>)
                                    </span>
                                </td>
                                <td><?= esc($user['objectif']) ?></td>
                                <td><?= number_format($user['solde_portefeuille'], 2, ',', ' ') ?> €</td>
                                <td>
                                    <?php if($user['statut'] === 'Gold'): ?>
                                        <span class="badge-status badge-gold">⭐ Gold</span>
                                    <?php else: ?>
                                        <span class="badge-status badge-silver">Standard</span>
                                    <?php endif; ?>
                                </td>
                                <td class="action-btns">
                                    <!-- <a href="<?= base_url('backoffice/viewUser/' . $user['id']) ?>" class="btn-view">
                                        <i class="bi bi-eye"></i> Voir
                                    </a>
                                    <a href="<?= base_url('backoffice/editUserForm/' . $user['id']) ?>" class="btn-edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a> -->
                                    <button type="button" 
                                            class="btn-del" 
                                            data-id="<?= $user['id'] ?>" 
                                            data-name="<?= esc($user['nom']) ?>"
                                            onclick="deleteUser(this)">
                                        <i class="bi bi-trash"></i> Del
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if(isset($pager)): ?>
            <div class="pagination">
                <?= $pager->links() ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Graphiques uniquement (car ils nécessitent Chart.js)
const goalData = <?= json_encode($objectifStats ?? []) ?>;
const imcData = <?= json_encode($imcStats ?? []) ?>;

// Graphique objectifs
if(document.getElementById('goalChart')) {
    const goalCtx = document.getElementById('goalChart').getContext('2d');
    new Chart(goalCtx, {
        type: 'doughnut',
        data: {
            labels: ['Réduire poids', 'Augmenter poids', 'IMC idéal'],
            datasets: [{
                data: [goalData.reduce || 0, goalData.increase || 0, goalData.ideal || 0],
                backgroundColor: ['#3aaa6b', '#e6a817', '#3b82f6']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { position: 'bottom', labels: { font: { size: 10 } } } }
        }
    });
}

// Graphique IMC
if(document.getElementById('imcChart')) {
    const imcCtx = document.getElementById('imcChart').getContext('2d');
    new Chart(imcCtx, {
        type: 'bar',
        data: {
            labels: ['Insuffisant', 'Normal', 'Surpoids', 'Obésité'],
            datasets: [{
                label: 'Nb utilisateurs',
                data: [imcData.faible || 0, imcData.normal || 0, imcData.surpoids || 0, imcData.obese || 0],
                backgroundColor: '#2d8f57',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: { y: { beginAtZero: true, stepSize: 1 } }
        }
    });
}

// Fonction de suppression dynamique
function deleteUser(button) {
    const userId = button.getAttribute('data-id');
    const userName = button.getAttribute('data-name');
    
    if (confirm(`Êtes-vous sûr de vouloir supprimer l'utilisateur "${userName}" définitivement ?`)) {
        // Désactiver le bouton pendant la requête
        button.disabled = true;
        button.innerHTML = '<i class="bi bi-hourglass-split"></i> Suppression...';
        
        // Obtenir le token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                         document.querySelector('input[name="csrf_test_name"]')?.value || '';
        
        fetch(`<?= base_url('bo/dashboard/user/delete') ?>/${userId}`, {
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
                
                // Mettre à jour les statistiques si nécessaire
                updateStats();
            } else {
                showNotification(data.message, 'error');
                // Réactiver le bouton
                button.disabled = false;
                button.innerHTML = '<i class="bi bi-trash"></i> Del';
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur lors de la suppression', 'error');
            // Réactiver le bouton
            button.disabled = false;
            button.innerHTML = '<i class="bi bi-trash"></i> Del';
        });
    }
}

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

function updateStats() {
    // Recharger la page pour mettre à jour les statistiques
    // Ou implémenter une mise à jour AJAX des KPIs si nécessaire
    location.reload();
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