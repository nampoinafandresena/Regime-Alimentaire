<div class="bo-content">
    <div class="page-header">
        <h2>Gestion des utilisateurs</h2>
        <p>CRUD complet + statistiques IMC, objectifs, statut Gold</p>
    </div>
    
    <!-- KPI stats -->
    <div class="kpi-row" id="kpiStats">
        <div class="kpi-card"><div class="kpi-label">👥 Total utilisateurs</div><div class="kpi-value"><?= $dataUser ?></div></div>
        <div class="kpi-card"><div class="kpi-label">⭐ Membres Gold</div><div class="kpi-value"><?= $dataGold ?></div><div class="kpi-trend">-15% sur régimes</div></div>
        <div class="kpi-card"><div class="kpi-label">💰 Porte-monnaie total</div><div class="kpi-value"><?= number_format($soldePortefeuille ?? 0, 2, ',', ' ') ?> €</div><div class="kpi-trend">Fonds cumulés</div></div>
        <div class="kpi-card"><div class="kpi-label">📊 IMC moyen</div><div class="kpi-value"><?= number_format($imcMoyen ?? 0, 1) ?></div><div class="kpi-trend">Normale ~18.5-25</div></div>
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
                                    <a href="<?= base_url('backoffice/viewUser/' . $user['id']) ?>" class="btn-view">
                                        <i class="bi bi-eye"></i> Voir
                                    </a>
                                    <a href="<?= base_url('backoffice/editUserForm/' . $user['id']) ?>" class="btn-edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a href="<?= base_url('backoffice/deleteUser/' . $user['id']) ?>" 
                                       class="btn-del" 
                                       onclick="return confirm('Supprimer cet utilisateur définitivement ?')">
                                        <i class="bi bi-trash"></i> Del
                                    </a>
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
</script>