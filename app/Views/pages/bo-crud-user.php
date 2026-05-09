
    <div class="bo-content">
        <div class="page-header">
            <h2>Gestion des utilisateurs</h2>
            <p>CRUD complet + statistiques IMC, objectifs, statut Gold (conformité projet S4)</p>
        </div>
        
        <!-- KPI stats -->
        <div class="kpi-row" id="kpiStats">
            <div class="kpi-card"><div class="kpi-label">👥 Total utilisateurs</div><div class="kpi-value" id="totalUsers">0</div><div class="kpi-trend">Minimum 5 requis ✓</div></div>
            <div class="kpi-card"><div class="kpi-label">⭐ Membres Gold</div><div class="kpi-value" id="goldCount">0</div><div class="kpi-trend">-15% sur régimes</div></div>
            <div class="kpi-card"><div class="kpi-label">💰 Porte-monnaie total</div><div class="kpi-value" id="totalWallet">0 €</div><div class="kpi-trend">Fonds cumulés</div></div>
            <div class="kpi-card"><div class="kpi-label">📊 IMC moyen</div><div class="kpi-value" id="avgImc">0</div><div class="kpi-trend">Normale ~18.5-25</div></div>
        </div>

        <!-- Graphiques IMC / Objectifs -->
        <div class="chart-stats">
            <div class="stat-chart-card"><h3 style="font-size: 1rem; margin-bottom: 12px;">Répartition des objectifs</h3><canvas id="goalChart" height="150" style="max-height: 180px;"></canvas></div>
            <div class="stat-chart-card"><h3 style="font-size: 1rem; margin-bottom: 12px;">Distribution IMC</h3><canvas id="imcChart" height="150" style="max-height: 180px;"></canvas></div>
        </div>

        <!-- Liste utilisateurs + CRUD -->
        <div class="bo-table">
            <div class="bo-table-header">
                <h3><i class="bi bi-people"></i> Liste des utilisateurs (min. 5 exigés)</h3>
                <div style="display: flex; gap: 12px;">
                    <input type="text" id="searchUser" class="search-input" placeholder="🔍 Nom, email...">
                    <button class="btn-add-bo" id="openAddUserModal"><i class="bi bi-person-plus"></i> Nouvel utilisateur</button>
                </div>
            </div>
            <div style="overflow-x: auto;">
                <table id="usersTable">
                    <thead>
                        <tr><th>ID</th><th>Nom complet</th><th>Email</th><th>Genre</th><th>Taille/Poids</th><th>IMC</th><th>Objectif</th><th>Wallet (€)</th><th>Statut</th><th>Actions</th></tr>
                    </thead>
                    <tbody id="usersTableBody"></tbody>
                </table>
            </div>
        </div>
        <p class="text-muted" style="font-size:12px; color:var(--slate-500); margin-top: 8px;"><i class="bi bi-info-circle"></i> Conformité projet : 5 utilisateurs, 15 codes (gérés séparément), CRUD complet, IMC dynamique, objectifs, option Gold</p>
    </div>

<!-- Modal CRUD Utilisateur -->
<div id="userModal" class="form-overlay">
    <div class="form-card-modal">
        <span class="close-modal" id="closeModalBtn">&times;</span>
        <h3 id="modalTitle">➕ Ajouter un utilisateur</h3>
        <input type="hidden" id="editUserId" value="">
        <div class="form-row">
            <div class="form-group"><label>Prénom & nom</label><input type="text" id="userName" placeholder="Alexandra Martin"></div>
            <div class="form-group"><label>Email</label><input type="email" id="userEmail" placeholder="exemple@mail.com"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Genre</label><select id="userGender"><option>Femme</option><option>Homme</option><option>Autre</option></select></div>
            <div class="form-group"><label>Âge</label><input type="number" id="userAge" placeholder="30"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Taille (cm)</label><input type="number" id="userHeight" placeholder="165" step="0.5"></div>
            <div class="form-group"><label>Poids (kg)</label><input type="number" id="userWeight" placeholder="68.5" step="0.1"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Objectif principal</label><select id="userGoal"><option value="reduce">⬇️ Réduire son poids</option><option value="increase">⬆️ Augmenter son poids</option><option value="ideal">🎯 Atteindre IMC idéal</option></select></div>
            <div class="form-group"><label>Porte-monnaie (€)</label><input type="number" id="userWallet" value="0" step="5"></div>
        </div>
        <div class="form-group"><label>Statut Gold</label><select id="userGold"><option value="false">Standard</option><option value="true">⭐ Gold (-15% régimes)</option></select></div>
        <div class="form-actions">
            <button class="btn-cancel" id="cancelModalBtn">Annuler</button>
            <button class="btn-save" id="saveUserBtn">Enregistrer</button>
        </div>
    </div>
</div>

<script>
    // ---------- DONNÉES INITIALES : 5 utilisateurs minimum (exigence projet) ----------
    let users = [
        { id: 1, name: "Sophie Dubois", email: "sophie@example.com", gender: "Femme", age: 28, height: 162, weight: 58, goal: "reduce", wallet: 25.0, gold: false },
        { id: 2, name: "Thomas Leroy", email: "thomas@example.com", gender: "Homme", age: 35, height: 178, weight: 85, goal: "reduce", wallet: 12.5, gold: false },
        { id: 3, name: "Emma Rakoto", email: "emma.r@example.com", gender: "Femme", age: 24, height: 170, weight: 68, goal: "ideal", wallet: 40.0, gold: true },
        { id: 4, name: "Lucas Moreau", email: "lucas.m@example.com", gender: "Homme", age: 42, height: 182, weight: 95, goal: "reduce", wallet: 5.0, gold: false },
        { id: 5, name: "Chloé Bernard", email: "chloe.b@example.com", gender: "Femme", age: 31, height: 165, weight: 72, goal: "increase", wallet: 60.0, gold: true }
    ];
    let nextId = 6;

    // Helper IMC
    function calculateIMC(weightKg, heightCm) { let hM = heightCm / 100; let imc = weightKg / (hM * hM); return Math.round(imc * 10) / 10; }
    function getIMCCategory(imc) { if(imc < 18.5) return "Insuffisant"; if(imc < 25) return "Normal"; if(imc < 30) return "Surpoids"; return "Obésité"; }
    
    // Afficher tableau + KPI
    function refreshUsersTable() {
        const tbody = document.getElementById('usersTableBody');
        const searchTerm = document.getElementById('searchUser')?.value.toLowerCase() || '';
        let filtered = users.filter(u => u.name.toLowerCase().includes(searchTerm) || u.email.toLowerCase().includes(searchTerm));
        tbody.innerHTML = '';
        filtered.forEach(user => {
            const imc = calculateIMC(user.weight, user.height);
            const goalMap = { reduce: "⬇️ Réduire", increase: "⬆️ Augmenter", ideal: "🎯 IMC idéal" };
            const row = tbody.insertRow();
            row.innerHTML = `
                <td>${user.id}</td>
                <td><strong>${user.name}</strong></td>
                <td>${user.email}</td>
                <td>${user.gender}</td>
                <td>${user.height}cm / ${user.weight}kg</td>
                <td><span class="imc-badge">${imc} (${getIMCCategory(imc)})</span></td>
                <td>${goalMap[user.goal] || user.goal}</td>
                <td>${user.wallet.toFixed(2)} €</td>
                <td>${user.gold ? '<span class="badge-status badge-gold">⭐ Gold</span>' : '<span class="badge-status badge-silver">Standard</span>'}</td>
                <td class="action-btns">
                    <button class="btn-view" onclick="viewUser(${user.id})"><i class="bi bi-eye"></i> Voir</button>
                    <button class="btn-edit" onclick="editUser(${user.id})"><i class="bi bi-pencil"></i> Edit</button>
                    <button class="btn-del" onclick="deleteUser(${user.id})"><i class="bi bi-trash"></i> Del</button>
                </td>
            `;
        });
        updateKPIAndCharts();
    }

    // KPI et graphiques
    function updateKPIAndCharts() {
        const total = users.length;
        const golds = users.filter(u => u.gold === true).length;
        const totalWallet = users.reduce((sum, u) => sum + u.wallet, 0);
        const avgImcVal = users.reduce((sum, u) => sum + calculateIMC(u.weight, u.height), 0) / total;
        document.getElementById('totalUsers').innerText = total;
        document.getElementById('goldCount').innerText = golds;
        document.getElementById('totalWallet').innerHTML = totalWallet.toFixed(2) + " €";
        document.getElementById('avgImc').innerText = avgImcVal.toFixed(1);

        // Graphique objectifs
        const goalCounts = { reduce: 0, increase: 0, ideal: 0 };
        users.forEach(u => { goalCounts[u.goal]++; });
        if(window.goalChartInstance) window.goalChartInstance.destroy();
        const goalCtx = document.getElementById('goalChart').getContext('2d');
        window.goalChartInstance = new Chart(goalCtx, {
            type: 'doughnut',
            data: { labels: ['Réduire poids', 'Augmenter poids', 'IMC idéal'], datasets: [{ data: [goalCounts.reduce, goalCounts.increase, goalCounts.ideal], backgroundColor: ['#3aaa6b', '#e6a817', '#3b82f6'] }] },
            options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'bottom', labels: { font: { size: 10 } } } } }
        });
        // Répartition IMC catégories
        const imcCats = { faible:0, normal:0, surpoids:0, obese:0 };
        users.forEach(u => { let imc = calculateIMC(u.weight, u.height);
            if(imc < 18.5) imcCats.faible++;
            else if(imc < 25) imcCats.normal++;
            else if(imc < 30) imcCats.surpoids++;
            else imcCats.obese++;
        });
        if(window.imcChartInstance) window.imcChartInstance.destroy();
        const imcCtx = document.getElementById('imcChart').getContext('2d');
        window.imcChartInstance = new Chart(imcCtx, {
            type: 'bar',
            data: { labels: ['Insuffisant', 'Normal', 'Surpoids', 'Obésité'], datasets: [{ label: 'Nb utilisateurs', data: [imcCats.faible, imcCats.normal, imcCats.surpoids, imcCats.obese], backgroundColor: '#2d8f57', borderRadius: 8 }] },
            options: { responsive: true, maintainAspectRatio: true, scales: { y: { beginAtZero: true, stepSize: 1 } } }
        });
    }

    // CRUD operations
    function openModal(isEdit = false, userData = null) {
        const modal = document.getElementById('userModal');
        const title = document.getElementById('modalTitle');
        if(isEdit && userData) {
            title.innerText = '✏️ Modifier l\'utilisateur';
            document.getElementById('editUserId').value = userData.id;
            document.getElementById('userName').value = userData.name;
            document.getElementById('userEmail').value = userData.email;
            document.getElementById('userGender').value = userData.gender;
            document.getElementById('userAge').value = userData.age || '';
            document.getElementById('userHeight').value = userData.height;
            document.getElementById('userWeight').value = userData.weight;
            document.getElementById('userGoal').value = userData.goal;
            document.getElementById('userWallet').value = userData.wallet;
            document.getElementById('userGold').value = userData.gold ? "true" : "false";
        } else {
            title.innerText = '➕ Ajouter un utilisateur';
            document.getElementById('editUserId').value = '';
            document.getElementById('userName').value = '';
            document.getElementById('userEmail').value = '';
            document.getElementById('userGender').value = 'Femme';
            document.getElementById('userAge').value = '';
            document.getElementById('userHeight').value = '';
            document.getElementById('userWeight').value = '';
            document.getElementById('userGoal').value = 'reduce';
            document.getElementById('userWallet').value = '0';
            document.getElementById('userGold').value = 'false';
        }
        modal.classList.add('active');
    }
    function closeModal() { document.getElementById('userModal').classList.remove('active'); }
    function saveUser() {
        const id = document.getElementById('editUserId').value;
        const name = document.getElementById('userName').value.trim();
        const email = document.getElementById('userEmail').value.trim();
        const gender = document.getElementById('userGender').value;
        const age = parseInt(document.getElementById('userAge').value) || 0;
        const height = parseFloat(document.getElementById('userHeight').value);
        const weight = parseFloat(document.getElementById('userWeight').value);
        const goal = document.getElementById('userGoal').value;
        const wallet = parseFloat(document.getElementById('userWallet').value) || 0;
        const gold = document.getElementById('userGold').value === "true";
        if(!name || !email || isNaN(height) || isNaN(weight) || height <= 0 || weight <= 0) {
            alert("Veuillez remplir tous les champs obligatoires (nom, email, taille, poids valides)");
            return;
        }
        if(id) {
            const idx = users.findIndex(u => u.id == id);
            if(idx !== -1) {
                users[idx] = { ...users[idx], name, email, gender, age, height, weight, goal, wallet, gold };
            }
        } else {
            const newUser = { id: nextId++, name, email, gender, age, height, weight, goal, wallet, gold };
            users.push(newUser);
        }
        closeModal();
        refreshUsersTable();
    }
    function editUser(id) { const user = users.find(u => u.id === id); if(user) openModal(true, user); }
    function deleteUser(id) { if(confirm("Supprimer cet utilisateur définitivement ?")) { users = users.filter(u => u.id !== id); refreshUsersTable(); } }
    function viewUser(id) { const user = users.find(u => u.id === id); if(user) { alert(`👤 ${user.name}\n📧 ${user.email}\n📏 ${user.height}cm / ${user.weight}kg\n🎯 Objectif: ${user.goal}\n💰 Wallet: ${user.wallet}€\n⭐ Gold: ${user.gold ? "Oui (-15%)" : "Non"}`); } }

    // Event listeners & search
    document.getElementById('openAddUserModal').addEventListener('click', () => openModal(false));
    document.getElementById('closeModalBtn').addEventListener('click', closeModal);
    document.getElementById('cancelModalBtn').addEventListener('click', closeModal);
    document.getElementById('saveUserBtn').addEventListener('click', saveUser);
    document.getElementById('searchUser').addEventListener('input', () => refreshUsersTable());
    window.onclick = function(e) { if(e.target === document.getElementById('userModal')) closeModal(); };
    
    // init
    refreshUsersTable();
</script>
