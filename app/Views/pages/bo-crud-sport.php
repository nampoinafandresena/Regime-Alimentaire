  <div class="bo-content">
    <div class="page-header">
      <h2>Gestion des activités sportives</h2>
      <p>Créer, modifier ou supprimer les programmes sportifs</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 420px; gap: 24px;">
      <div>
        <div class="bo-table">
          <div class="bo-table-header">
            <h3>Liste des activités (8)</h3>
            <button class="btn-add-bo" onclick="resetForm()">+ Nouvelle activité</button>
          </div>
          <table id="sportsTable">
            <thead>
              <tr>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Calories/30min</th>
                <th>Fréquence</th>
                <th>Intensité</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="sportsTableBody">
              <tr data-id="1">
                <td><strong>Course à pied</strong></td>
                <td><span class="badge-category badge-cardio">🏃 Cardio</span></td>
                <td>450 cal</td>
                <td>3-5x/semaine</td>
                <td>Élevée</td>
                <td><div class="action-btns"><button class="btn-edit" onclick="editSport(1)">✏️ Éditer</button><button class="btn-del" onclick="deleteSport(1)">🗑️</button></div></td>
              </tr>
              <tr data-id="2">
                <td><strong>Natation</strong></td>
                <td><span class="badge-category badge-cardio">🏊 Cardio</span></td>
                <td>350 cal</td>
                <td>2-3x/semaine</td>
                <td>Modérée</td>
                <td><div class="action-btns"><button class="btn-edit" onclick="editSport(2)">✏️ Éditer</button><button class="btn-del" onclick="deleteSport(2)">🗑️</button></div></td>
              </tr>
              <tr data-id="3">
                <td><strong>Musculation</strong></td>
                <td><span class="badge-category badge-force">💪 Force</span></td>
                <td>300 cal</td>
                <td>3-4x/semaine</td>
                <td>Élevée</td>
                <td><div class="action-btns"><button class="btn-edit" onclick="editSport(3)">✏️ Éditer</button><button class="btn-del" onclick="deleteSport(3)">🗑️</button></div></td>
              </tr>
              <tr data-id="4">
                <td><strong>Yoga</strong></td>
                <td><span class="badge-category badge-flexibilite">🧘 Flexibilité</span></td>
                <td>180 cal</td>
                <td>2-4x/semaine</td>
                <td>Faible</td>
                <td><div class="action-btns"><button class="btn-edit" onclick="editSport(4)">✏️ Éditer</button><button class="btn-del" onclick="deleteSport(4)">🗑️</button></div></td>
              </tr>
              <tr data-id="5">
                <td><strong>Vélo / Cyclisme</strong></td>
                <td><span class="badge-category badge-plein-air">🌳 Plein air</span></td>
                <td>400 cal</td>
                <td>2-3x/semaine</td>
                <td>Modérée</td>
                <td><div class="action-btns"><button class="btn-edit" onclick="editSport(5)">✏️ Éditer</button><button class="btn-del" onclick="deleteSport(5)">🗑️</button></div></td>
              </tr>
              <tr data-id="6">
                <td><strong>Marche rapide</strong></td>
                <td><span class="badge-category badge-douceur">🚶 Douceur</span></td>
                <td>200 cal</td>
                <td>5-7x/semaine</td>
                <td>Faible</td>
                <td><div class="action-btns"><button class="btn-edit" onclick="editSport(6)">✏️ Éditer</button><button class="btn-del" onclick="deleteSport(6)">🗑️</button></div></td>
              </tr>
              <tr data-id="7">
                <td><strong>Pilates</strong></td>
                <td><span class="badge-category badge-flexibilite">🤸 Flexibilité</span></td>
                <td>200 cal</td>
                <td>2-3x/semaine</td>
                <td>Faible</td>
                <td><div class="action-btns"><button class="btn-edit" onclick="editSport(7)">✏️ Éditer</button><button class="btn-del" onclick="deleteSport(7)">🗑️</button></div></td>
              </tr>
              <tr data-id="8">
                <td><strong>CrossFit</strong></td>
                <td><span class="badge-category badge-force">🏋️ Force</span></td>
                <td>500 cal</td>
                <td>3-4x/semaine</td>
                <td>Élevée</td>
                <td><div class="action-btns"><button class="btn-edit" onclick="editSport(8)">✏️ Éditer</button><button class="btn-del" onclick="deleteSport(8)">🗑️</button></div></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Formulaire CRUD -->
      <div class="form-page">
        <div class="form-card" id="formCard">
          <h3 id="formTitle">✏️ Ajouter / Modifier un sport</h3>
          <div class="form-group">
            <label>Nom de l'activité</label>
            <input type="text" id="sportName" placeholder="Ex: Course à pied">
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea rows="3" id="sportDesc" placeholder="Description détaillée de l'activité..."></textarea>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Catégorie</label>
              <select id="sportCategory">
                <option value="cardio">🏃 Cardio</option>
                <option value="force">💪 Force</option>
                <option value="flexibilite">🧘 Flexibilité</option>
                <option value="plein-air">🌳 Plein air</option>
                <option value="douceur">🌸 Douceur</option>
              </select>
            </div>
            <div class="form-group">
              <label>Intensité</label>
              <select id="sportIntensity">
                <option value="faible">🍃 Faible</option>
                <option value="moyen">🌊 Modérée</option>
                <option value="eleve">⚡ Élevée</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Calories / 30 min</label>
              <input type="number" id="sportCalories" placeholder="450">
            </div>
            <div class="form-group">
              <label>Fréquence (par semaine)</label>
              <input type="text" id="sportFrequency" placeholder="3-5x/semaine">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Durée (minutes)</label>
              <input type="text" id="sportDuration" placeholder="30-45 min">
            </div>
            <div class="form-group">
              <label>Niveau requis</label>
              <select id="sportLevel">
                <option>Débutant</option>
                <option selected>Intermédiaire</option>
                <option>Avancé</option>
                <option>Tous niveaux</option>
              </select>
            </div>
          </div>
          <div class="form-actions">
            <button class="btn-cancel" onclick="resetForm()">Annuler</button>
            <button class="btn-save" onclick="saveSport()">Enregistrer</button>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
let currentEditId = null;

const sportsData = {
  1: { name: "Course à pied", desc: "Idéal pour brûler des calories et améliorer votre endurance cardiovasculaire.", category: "cardio", intensity: "eleve", calories: "450", frequency: "3-5x/semaine", duration: "30-45 min", level: "Intermédiaire" },
  2: { name: "Natation", desc: "Activité complète sans impact sur les articulations, idéale pour tous les âges.", category: "cardio", intensity: "moyen", calories: "350", frequency: "2-3x/semaine", duration: "30-60 min", level: "Tous niveaux" },
  3: { name: "Musculation", desc: "Renforcez votre masse musculaire, améliorez votre métabolisme de base.", category: "force", intensity: "eleve", calories: "300", frequency: "3-4x/semaine", duration: "45-60 min", level: "Intermédiaire" },
  4: { name: "Yoga", desc: "Améliorez votre souplesse, réduisez le stress et tonifiez votre corps.", category: "flexibilite", intensity: "faible", calories: "180", frequency: "2-4x/semaine", duration: "45-75 min", level: "Débutant" },
  5: { name: "Vélo / Cyclisme", desc: "Parfait pour explorer tout en faisant du sport, excellent pour le cardio.", category: "plein-air", intensity: "moyen", calories: "400", frequency: "2-3x/semaine", duration: "45-90 min", level: "Tous niveaux" },
  6: { name: "Marche rapide", desc: "Accessible à tous, idéal pour débuter une activité physique régulière.", category: "douceur", intensity: "faible", calories: "200", frequency: "5-7x/semaine", duration: "30-60 min", level: "Débutant" },
  7: { name: "Pilates", desc: "Renforcez vos muscles profonds, améliorez votre posture et votre équilibre.", category: "flexibilite", intensity: "faible", calories: "200", frequency: "2-3x/semaine", duration: "45-60 min", level: "Débutant" },
  8: { name: "CrossFit", desc: "Entraînement intense mêlant cardio et force pour des résultats rapides.", category: "force", intensity: "eleve", calories: "500", frequency: "3-4x/semaine", duration: "45-60 min", level: "Avancé" }
};

function editSport(id) {
  currentEditId = id;
  const sport = sportsData[id];
  if (sport) {
    document.getElementById('sportName').value = sport.name;
    document.getElementById('sportDesc').value = sport.desc;
    document.getElementById('sportCategory').value = sport.category;
    document.getElementById('sportIntensity').value = sport.intensity;
    document.getElementById('sportCalories').value = sport.calories;
    document.getElementById('sportFrequency').value = sport.frequency;
    document.getElementById('sportDuration').value = sport.duration;
    document.getElementById('sportLevel').value = sport.level;
    document.getElementById('formTitle').innerHTML = '✏️ Modifier un sport';
  }
}

function deleteSport(id) {
  if (confirm('Supprimer cette activité sportive ?')) {
    const row = document.querySelector(`tr[data-id="${id}"]`);
    if (row) row.remove();
    delete sportsData[id];
  }
}

function saveSport() {
  const name = document.getElementById('sportName').value;
  const desc = document.getElementById('sportDesc').value;
  const category = document.getElementById('sportCategory').value;
  const intensity = document.getElementById('sportIntensity').value;
  const calories = document.getElementById('sportCalories').value;
  const frequency = document.getElementById('sportFrequency').value;
  const duration = document.getElementById('sportDuration').value;
  const level = document.getElementById('sportLevel').value;

  if (!name) {
    alert('Veuillez saisir un nom');
    return;
  }

  const categoryLabels = {
    cardio: '🏃 Cardio', force: '💪 Force', flexibilite: '🧘 Flexibilité',
    'plein-air': '🌳 Plein air', douceur: '🌸 Douceur'
  };
  const intensityLabels = { faible: 'Faible', moyen: 'Modérée', eleve: 'Élevée' };
  const badgeClasses = {
    cardio: 'badge-cardio', force: 'badge-force', flexibilite: 'badge-flexibilite',
    'plein-air': 'badge-plein-air', douceur: 'badge-douceur'
  };

  if (currentEditId && sportsData[currentEditId]) {
    // Update existing
    sportsData[currentEditId] = { name, desc, category, intensity, calories, frequency, duration, level };
    const row = document.querySelector(`tr[data-id="${currentEditId}"]`);
    if (row) {
      row.innerHTML = `
        <td><strong>${name}</strong></td>
        <td><span class="badge-category ${badgeClasses[category]}">${categoryLabels[category]}</span></td>
        <td>${calories} cal</td>
        <td>${frequency}</td>
        <td>${intensityLabels[intensity]}</td>
        <td><div class="action-btns"><button class="btn-edit" onclick="editSport(${currentEditId})">✏️ Éditer</button><button class="btn-del" onclick="deleteSport(${currentEditId})">🗑️</button></div></td>
      `;
    }
  } else {
    // Create new
    const newId = Date.now();
    sportsData[newId] = { name, desc, category, intensity, calories, frequency, duration, level };
    const tbody = document.getElementById('sportsTableBody');
    const newRow = document.createElement('tr');
    newRow.setAttribute('data-id', newId);
    newRow.innerHTML = `
      <td><strong>${name}</strong></td>
      <td><span class="badge-category ${badgeClasses[category]}">${categoryLabels[category]}</span></td>
      <td>${calories} cal</td>
      <td>${frequency}</td>
      <td>${intensityLabels[intensity]}</td>
      <td><div class="action-btns"><button class="btn-edit" onclick="editSport(${newId})">✏️ Éditer</button><button class="btn-del" onclick="deleteSport(${newId})">🗑️</button></div></td>
    `;
    tbody.appendChild(newRow);
  }
  resetForm();
}

function resetForm() {
  currentEditId = null;
  document.getElementById('sportName').value = '';
  document.getElementById('sportDesc').value = '';
  document.getElementById('sportCategory').value = 'cardio';
  document.getElementById('sportIntensity').value = 'moyen';
  document.getElementById('sportCalories').value = '';
  document.getElementById('sportFrequency').value = '';
  document.getElementById('sportDuration').value = '';
  document.getElementById('sportLevel').value = 'Intermédiaire';
  document.getElementById('formTitle').innerHTML = '➕ Ajouter un sport';
}
</script>
