  <div class="bo-content">
    <div class="page-header"><h2>Codes porte-monnaie</h2><p>Gérer les codes de recharge et valider les demandes</p></div>
    <div style="display: flex; gap: 12px; margin-bottom: 24px;">
      <button class="btn-add-bo">+ Générer des codes</button>
      <div style="background:#fff; border: 1px solid var(--slate-200); border-radius: 8px; padding: 8px 16px; font-size:14px; color:var(--slate-500);">🔍 Rechercher un code…</div>
    </div>

    <div class="kpi-row">
      <div class="kpi-card"><div class="kpi-label">Codes générés</div><div class="kpi-value">150</div><div class="kpi-trend">15 séries de 10</div></div>
      <div class="kpi-card"><div class="kpi-label">Codes validés</div><div class="kpi-value" style="color: var(--green-500);">94</div><div class="kpi-trend">63% du total</div></div>
      <div class="kpi-card"><div class="kpi-label">Codes disponibles</div><div class="kpi-value" style="color: var(--gold-500);">56</div><div class="kpi-trend">37% restants</div></div>
    </div>

    <div class="bo-table">
      <div class="bo-table-header"><h3>Tous les codes (15 affichés)</h3></div>
      <table>
        <thead><tr><th>Code</th><th>Montant</th><th>Statut</th><th>Utilisateur</th><th>Date validation</th><th>Actions</th></tr></thead>
        <tbody>
          <tr><td><strong>NUTR-A1B2C3</strong></td><td>5 000 Ar</td><td><span class="badge-status badge-active">Validé</span></td><td>Marie Dupont</td><td>01/05/2026</td><td><div class="action-btns"><button class="btn-edit">Voir</button></div></td></tr>
          <tr><td><strong>NUTR-D4E5F6</strong></td><td>10 000 Ar</td><td><span class="badge-status badge-pending">En attente</span></td><td>—</td><td>—</td><td><div class="action-btns"><button class="btn-edit">Valider</button><button class="btn-del">Invalider</button></div></td></tr>
          <tr><td><strong>NUTR-G7H8I9</strong></td><td>5 000 Ar</td><td><span class="badge-status badge-inactive">Expiré</span></td><td>—</td><td>—</td><td><div class="action-btns"><button class="btn-edit">Voir</button></div></td></tr>
          <tr><td><strong>NUTR-J0K1L2</strong></td><td>20 000 Ar</td><td><span class="badge-status badge-active">Validé</span></td><td>Jean Rakoto</td><td>28/04/2026</td><td><div class="action-btns"><button class="btn-edit">Voir</button></div></td></tr>
          <tr><td><strong>NUTR-M3N4O5</strong></td><td>10 000 Ar</td><td><span class="badge-status badge-pending">En attente</span></td><td>—</td><td>—</td><td><div class="action-btns"><button class="btn-edit">Valider</button><button class="btn-del">Invalider</button></div></td></tr>
        </tbody>
      </table>
    </div>

    <div class="form-card">
      <h3>Générer de nouveaux codes</h3>
      <div class="form-row">
        <div class="form-group"><label>Nombre de codes</label><input type="number" value="10"></div>
        <div class="form-group"><label>Valeur par code (Ar)</label><select><option>5 000</option><option selected>10 000</option><option>20 000</option><option>50 000</option></select></div>
      </div>
      <div class="form-group"><label>Date d'expiration</label><input type="date" value="2026-12-31"></div>
      <button class="btn-save">Générer les codes</button>
    </div>
  </div>
