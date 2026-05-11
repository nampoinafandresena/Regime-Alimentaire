<div class="bo-content">
    <div class="page-header"><h2>Tableau de bord Admin</h2><p>Vue d'ensemble au <?= date('d/m/Y'); ?></p></div>
    <div class="kpi-row">
      <div class="kpi-card"><div class="kpi-label">Utilisateurs total</div><div class="kpi-value"><?= $dataUser; ?></div><div class="kpi-trend">↑ +12 ce mois</div></div>
      <div class="kpi-card"><div class="kpi-label">Abonnés Gold</div><div class="kpi-value"><?= $dataGold; ?></div><div class="kpi-trend">↑ +5 ce mois</div></div>
      <div class="kpi-card"><div class="kpi-label">Régimes</div><div class="kpi-value"><?= $dataRegimes; ?></div><div class="kpi-trend">↑ +23 ce mois</div></div>
      <div class="kpi-card"><div class="kpi-label">Codes validés</div><div class="kpi-value"><?= $dataCodes; ?></div><div class="kpi-trend">↑ +8 ce mois</div></div>
    </div>
    <div class="chart-row">
      <div class="chart-card chart-card--full">
        <h3>Popularité des régimes</h3>
        <?php if(empty($populateRegimes)): ?>
            <div style="text-align: center; padding: 40px; color: var(--slate-400);">
                Aucun régime à afficher
            </div>
        <?php else: ?>
            <div class="chart-card__canvas-wrapper">
                <canvas id="populariteRegimesChart"></canvas>
            </div>
        <?php endif; ?>
      </div>

      <div class="chart-card">
        <?php 
            $objectifColors = [
            'Réduire son poids' => '#3aaa6b',
            'Augmenter son poids' => '#e6a817', 
            'Atteindre IMC idéal' => '#7d3bf6',
            'default' => '#3d5ce7'
          ];
        ?>

        <h3>Objectifs populaires</h3>
    
        <?php if(empty($objectifsStats)): ?>
            <div style="text-align: center; padding: 40px; color: var(--slate-400);">
                Aucune donnée d'objectif disponible
            </div>
        <?php else: ?>

        <canvas id="objectifsPieChart" height="180" style="max-height: 180px;"></canvas>

        <?php
            foreach($objectifsStats as &$stat) {
                $stat['color'] = $objectifColors[$stat['libelle']] ?? $objectifColors['default'];
            }
            unset($stat);
        ?>

        
          <div class="objectifs-table" style="margin-top: 20px;">
              <table style="width: 100%; font-size: 13px;">
                  <thead>
                      <tr>
                          <th>Objectif</th>
                          <th>Nombre</th>
                          <th>Pourcentage</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach($objectifsStats as $stat): ?>
                          <tr>
                              <td>
                                  <div class="pie-dot" style="background: <?= $stat['color'] ?>; display: inline-block; margin-right: 8px;"></div>
                                  <?= $stat['libelle'] ?>
                              </td>
                              <td><?= $stat['total'] ?></td>
                              <td>
                                  <div style="display: flex; align-items: center; gap: 8px;">
                                      <div style="flex: 1; height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden;">
                                          <div style="width: <?= $stat['pourcentage'] ?>%; height: 100%; background: <?= $stat['color'] ?>; border-radius: 3px;"></div>
                                      </div>
                                      <span><?= $stat['pourcentage'] ?>%</span>
                                  </div>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
          </div>
          <?php endif; ?>
        </div>
    </div>
    <div class="bo-table">
      <div class="bo-table-header"><h3>Derniers utilisateurs inscrits</h3><a href="/bo/dashboard/user"><button class="btn-add-bo">Voir tous</button></a></div>
      <table>
        <thead><tr><th>Nom</th><th>Email</th><th>IMC</th><th>Objectif</th><th>Statut</th></tr></thead>
        <tbody>
          <?php foreach ($dataUserInfos as $user): ?>
            <tr>
              <td><?= $user['nom'] ?></td>
              <td><?= $user['email'] ?></td>
              <td><?= $user['imc'] ?></td>
              <td><?= $user['objectif'] ?></td>
              <td><span class="badge-status badge-active"><?= $user['statut'] ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Graphique en camembert des objectifs
const objectifsData = <?= json_encode($objectifsStats) ?>;
const regimesData = <?= json_encode($populateRegimes) ?>;

if(document.getElementById('populariteRegimesChart') && regimesData.length > 0) {
    const regimesCtx = document.getElementById('populariteRegimesChart').getContext('2d');
    
    // Extraire les données correctement
    const regimeLabels = regimesData.map(regime => regime.nom);
    const regimeNombreChoix = regimesData.map(regime => regime.nombre_choix || 0);
    const regimePourcentages = regimesData.map(regime => regime.pourcentage || 0);
    
    new Chart(regimesCtx, {
        type: 'bar',
        data: {
            labels: regimeLabels,
            datasets: [{
                label: 'Nombre de choix',
                data: regimeNombreChoix,
                backgroundColor: regimesData.map((_, index) => {
                    const colors = ['#3b82f6', '#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#0ea5e9', '#f97316'];
                    return colors[index % colors.length];
                }),
                borderRadius: 8,
                barPercentage: 0.7,
                categoryPercentage: 0.8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Nombre de choix',
                        font: { size: 12, weight: 'bold' }
                    },
                    grid: { color: '#e2e8f0' },
                    ticks: { stepSize: 1, precision: 0 }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Régimes',
                        font: { size: 12, weight: 'bold' }
                    },
                    ticks: { 
                        autoSkip: false, 
                        maxRotation: 45, 
                        minRotation: 0, 
                        font: { size: 11 } 
                    }
                }
            },
            plugins: {
                legend: { display: true, position: 'top' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed.y || 0;
                            const index = context.dataIndex;
                            const pourcentage = regimePourcentages[index] || 0;
                            return `Choix: ${value} (${pourcentage}% du total)`;
                        }
                    }
                }
            }
        }
    });
}

if(document.getElementById('objectifsPieChart') && objectifsData.length > 0) {
    const ctx = document.getElementById('objectifsPieChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: objectifsData.map(item => item.libelle),
            datasets: [{
                data: objectifsData.map(item => item.total),
                backgroundColor: objectifsData.map(item => item.color),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 10 } }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = objectifsData.reduce((sum, item) => sum + item.total, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} utilisateurs (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}
</script>

<style>
.pie-legend {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-top: 16px;
}

.pie-leg-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: var(--slate-600);
}

.pie-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.objectifs-table table {
    border-collapse: collapse;
}

.objectifs-table th,
.objectifs-table td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
}

.objectifs-table th {
    font-weight: 600;
    color: var(--slate-600);
}
</style>