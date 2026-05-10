
(function() {
  var btn = document.getElementById('edit-profile-btn');
  var edit = document.getElementById('profil-edit');
  if (!btn || !edit) return;

  btn.addEventListener('click', function() {
    var isHidden = edit.style.display === 'none' || getComputedStyle(edit).display === 'none';
    if (isHidden) {
      edit.style.display = 'block';
      var summary = document.getElementById('objectifs-summary');
      var summaryTitle = document.getElementById('objectifs-summary-title');
      if (summary) summary.style.display = 'none';
      if (summaryTitle) summaryTitle.style.display = 'none';
      edit.scrollIntoView({ behavior: 'smooth' });
      btn.textContent = 'Fermer la modification';
    } else {
      edit.style.display = 'none';
      var summaryBack = document.getElementById('objectifs-summary');
      var summaryTitleBack = document.getElementById('objectifs-summary-title');
      if (summaryBack) summaryBack.style.display = 'flex';
      if (summaryTitleBack) summaryTitleBack.style.display = 'block';
      btn.textContent = '✏️ Modifier le profil';
      btn.scrollIntoView({ behavior: 'smooth' });
    }
  });
})();


(function() {
  var form = document.getElementById('redeem-form');
  var btn = document.getElementById('redeem-btn');
  var feedback = document.getElementById('redeem-feedback');
  var walletEl = document.getElementById('wallet-balance');
  if (!form) return;

  function formatNumber(n) {
    return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
  }

  form.addEventListener('submit', function(e) {
    e.preventDefault();
    feedback.textContent = '';
    btn.disabled = true;
    var fd = new FormData(form);

    fetch(form.action, {
      method: 'POST',
      body: fd,
      credentials: 'same-origin',
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
      .then(function(res) {
        return res.json().then(function(payload) {
          return { status: res.status, body: payload };
        });
      })
      .then(function(result) {
        btn.disabled = false;
        if (result.body && result.body.success) {
          feedback.style.color = '#0b6b3a';
          feedback.textContent = result.body.message || 'Code appliqué.';
          if (result.body.newBalance !== undefined) {
            var formatted = formatNumber(Math.round(result.body.newBalance));
            walletEl.textContent = formatted + ' Ar';
          }
          form.reset();
        } else {
          feedback.style.color = '#8b1d1d';
          var errs = result.body && result.body.errors ? result.body.errors : ['Erreur inconnue'];
          feedback.textContent = Array.isArray(errs) ? errs.join('; ') : errs;
        }
      })
      .catch(function(err) {
        btn.disabled = false;
        feedback.style.color = '#8b1d1d';
        feedback.textContent = 'Erreur réseau — réessaye.';
      });
  });
})();
