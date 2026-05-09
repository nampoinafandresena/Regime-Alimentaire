  <div class="bo-content">
    <div class="page-header"><h2>Gestion des régimes</h2><p>Créer, modifier ou supprimer les programmes nutritionnels</p></div>
    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 24px;">
      <div>
        <div class="bo-table">
          <div class="bo-table-header"><h3>Liste des régimes (5)</h3><button class="btn-add-bo">+ Nouveau régime</button></div>
          <table>
            <thead><tr><th>Nom</th><th>Durée</th><th>Variation poids</th><th>Prix (4 sem.)</th><th>Actions</th></tr></thead>
            <tbody>
              <tr><td><strong>Méditerranéen</strong></td><td>12 semaines</td><td style="color: var(--red-400);">−4 à −8 kg</td><td>45 000 Ar</td><td><div class="action-btns"><button class="btn-edit">✏️ Éditer</button><button class="btn-del">🗑️</button></div></td></tr>
              <tr><td><strong>Protéiné Sport</strong></td><td>8 semaines</td><td style="color: var(--green-500);">+3 à +6 kg</td><td>52 000 Ar</td><td><div class="action-btns"><button class="btn-edit">✏️ Éditer</button><button class="btn-del">🗑️</button></div></td></tr>
              <tr><td><strong>Détox Marine</strong></td><td>6 semaines</td><td style="color: var(--red-400);">−3 à −5 kg</td><td>38 000 Ar</td><td><div class="action-btns"><button class="btn-edit">✏️ Éditer</button><button class="btn-del">🗑️</button></div></td></tr>
              <tr><td><strong>Équilibre Vital</strong></td><td>16 semaines</td><td style="color: var(--red-400);">−5 à −10 kg</td><td>60 000 Ar</td><td><div class="action-btns"><button class="btn-edit">✏️ Éditer</button><button class="btn-del">🗑️</button></div></td></tr>
              <tr><td><strong>Masse & Force</strong></td><td>12 semaines</td><td style="color: var(--green-500);">+5 à +12 kg</td><td>68 000 Ar</td><td><div class="action-btns"><button class="btn-edit">✏️ Éditer</button><button class="btn-del">🗑️</button></div></td></tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="form-page">
        <div class="form-card">
          <h3>✏️ Éditer un régime</h3>
          <div class="form-group"><label>Nom du régime</label><input type="text" value="Méditerranéen"></div>
          <div class="form-group"><label>Description</label><textarea rows="3">Riche en légumes frais, poissons et huile d'olive. Programme éprouvé pour une perte de poids durable.</textarea></div>
          <div class="form-row">
            <div class="form-group"><label>Durée totale (semaines)</label><input type="number" value="12"></div>
            <div class="form-group"><label>Objectif associé</label><select><option selected>Réduire poids</option><option>Augmenter poids</option><option>IMC idéal</option></select></div>
          </div>
          <div class="form-row">
            <div class="form-group"><label>Variation min (kg)</label><input type="number" value="-8"></div>
            <div class="form-group"><label>Variation max (kg)</label><input type="number" value="-4"></div>
          </div>
          <div class="form-group">
            <label>Composition protéique</label>
            <div class="comp-sliders">
              <div class="slider-group"><span class="slider-label">🥩 Viande</span><input type="range" min="0" max="100" value="20" oninput="updateComp(this,'meat-val')"><span class="slider-val meat" id="meat-val">20%</span></div>
              <div class="slider-group"><span class="slider-label">🐟 Poisson</span><input type="range" min="0" max="100" value="50" oninput="updateComp(this,'fish-val')"><span class="slider-val fish" id="fish-val">50%</span></div>
              <div class="slider-group"><span class="slider-label">🍗 Volaille</span><input type="range" min="0" max="100" value="30" oninput="updateComp(this,'poultry-val')"><span class="slider-val poultry" id="poultry-val">30%</span></div>
            </div>
            <div class="comp-total ok" id="comp-total">Total : 100% ✓</div>
          </div>
          <div class="form-group">
            <label>Tarifs selon la durée</label>
            <div class="price-table">
              <div class="price-row" style="background: var(--slate-50); font-weight:600;"><div class="price-cell">Durée</div><div class="price-cell">Prix (Ar)</div><div class="price-cell"></div></div>
              <div class="price-row"><div class="price-cell"><input value="2 semaines"></div><div class="price-cell"><input value="25 000"></div><div class="price-cell del">✕</div></div>
              <div class="price-row"><div class="price-cell"><input value="4 semaines"></div><div class="price-cell"><input value="45 000"></div><div class="price-cell del">✕</div></div>
              <div class="price-row"><div class="price-cell"><input value="8 semaines"></div><div class="price-cell"><input value="80 000"></div><div class="price-cell del">✕</div></div>
              <div class="price-row"><div class="price-cell"><input value="12 semaines"></div><div class="price-cell"><input value="110 000"></div><div class="price-cell del">✕</div></div>
            </div>
            <button class="add-row-btn">+ Ajouter une durée</button>
          </div>
          <div class="form-actions"><button class="btn-cancel">Annuler</button><button class="btn-save">Enregistrer</button></div>
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
</script>
