  <div class="bo-content">
    <div class="page-header"><h2>Tableau de bord Admin</h2><p>Vue d'ensemble au <?= date('d/m/Y'); ?></p></div>
    <div class="kpi-row">
      <div class="kpi-card"><div class="kpi-label">Utilisateurs total</div><div class="kpi-value"><?= $dataUser; ?></div><div class="kpi-trend">↑ +12 ce mois</div></div>
      <div class="kpi-card"><div class="kpi-label">Abonnés Gold</div><div class="kpi-value"><?= $dataGold; ?></div><div class="kpi-trend">↑ +5 ce mois</div></div>
      <div class="kpi-card"><div class="kpi-label">Régimes</div><div class="kpi-value"><?= $dataRegimes; ?></div><div class="kpi-trend">↑ +23 ce mois</div></div>
      <div class="kpi-card"><div class="kpi-label">Codes validés</div><div class="kpi-value"><?= $dataCodes; ?></div><div class="kpi-trend">↑ +8 ce mois</div></div>
    </div>
    <div class="chart-row">
      <div class="chart-card">
        <h3>Inscriptions par semaine</h3>
        <div class="mock-chart">
          <div class="mock-bar b1"></div><div class="mock-bar b2"></div><div class="mock-bar b3"></div>
          <div class="mock-bar b4"></div><div class="mock-bar b5"></div><div class="mock-bar b6"></div>
          <div class="mock-bar b7"></div><div class="mock-bar b8"></div>
        </div>
        <div style="display:flex; justify-content:space-between; font-size:11px; color:var(--slate-400); margin-top:6px;">
          <span>Sem. 1</span><span>Sem. 2</span><span>Sem. 3</span><span>Sem. 4</span><span>Sem. 5</span><span>Sem. 6</span><span>Sem. 7</span><span>Sem. 8</span>
        </div>
      </div>
      <div class="chart-card">
        <h3>Objectifs populaires</h3>
        <div class="pie-mock"></div>
        <div class="pie-legend">
          <div class="pie-leg-item"><div class="pie-dot" style="background: var(--green-400)"></div>Réduire poids (45%)</div>
          <div class="pie-leg-item"><div class="pie-dot" style="background: var(--gold-400)"></div>IMC idéal (27%)</div>
          <div class="pie-leg-item"><div class="pie-dot" style="background: var(--blue-400)"></div>Augmenter poids (28%)</div>
        </div>
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
