function syncObjCard(input) {
  const card = input.closest('.obj-card');
  if (input.checked) {
    card.classList.add('selected');
  } else {
    card.classList.remove('selected');
  }
}

function toggleObj(card) {
  const input = card.querySelector('input[type="checkbox"]');
  input.checked = !input.checked;
  syncObjCard(input);
}

function updateImc() {
  const taille = parseFloat(document.getElementById('taille_cm').value);
  const poids = parseFloat(document.getElementById('poids_kg').value);
  const valueEl = document.getElementById('imc-value');
  const subEl = document.getElementById('imc-sub');

  if (!taille || !poids) {
    valueEl.textContent = '---';
    subEl.textContent = 'Sera calcule apres inscription';
    return;
  }

  const imc = poids / ((taille / 100) * (taille / 100));
  const imcRounded = imc.toFixed(1);
  let label = 'Poids normal';

  if (imc < 18.5) {
    label = 'Insuffisance ponderale';
  } else if (imc >= 25 && imc < 30) {
    label = 'Surpoids';
  } else if (imc >= 30) {
    label = 'Obesite';
  }

  valueEl.textContent = imcRounded;
  subEl.textContent = label;
}

document.getElementById('taille_cm').addEventListener('input', updateImc);
document.getElementById('poids_kg').addEventListener('input', updateImc);
updateImc();
