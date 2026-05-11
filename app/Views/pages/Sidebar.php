  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('assets/CSS/Style.css') ?>">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<?php
  $uri = service('uri');
  $segment1 = $uri->getSegment(1);
  $currentSegment = $segment1 === 'index.php' ? ($uri->getSegment(2) ?? '') : ($segment1 ?? '');
  $nom = $user['nom'] ?? '';
  $email = $user['email'] ?? '';
  $genre = $user['genre'] ?? '';
  $isGold = (int) ($user['est_gold'] ?? 0) === 1;
  $initials = '';
  if ($nom !== '') {
    $parts = preg_split('/\s+/', trim($nom));
    $first = $parts[0] ?? '';
    $last = $parts[count($parts) - 1] ?? '';
    $initials = strtoupper(substr($first, 0, 1) . substr($last, 0, 1));
  }

  $objectifLabel = '';
  if (! empty($selectedObjectifIds)) {
    foreach ($objectifs as $obj) {
      if (in_array((int) $obj['id'], $selectedObjectifIds, true)) {
        $objectifLabel = $obj['libelle'];
        break;
      }
    }
  }
?>
<?php if (session()->getFlashdata('errors')): ?>
  <div class="flash flash-error" style="margin-top:16px;">
    <?php foreach (session()->getFlashdata('errors') as $message): ?>
      <div><?= esc($message) ?></div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
  <div class="flash" style="margin-top:16px; background:#e8f7ee; color:#1e6b3e; border:1px solid #bfe7cf;">
    <?= esc(session()->getFlashdata('success')) ?>
  </div>
<?php endif; ?>
 <div class="sidebar">
    <div class="sidebar-logo">Nutri<span>Path</span></div>
    <div class="sidebar-section">Menu</div>
    <!-- <a href="/dashboard" class="sidebar-item">
      <i class="fas fa-chart-line" style="font-size: 1.2rem; margin-right: 10px;"></i> Tableau de bord
    </a> -->
  <a href="/regimes" class="sidebar-item <?= $currentSegment === 'regimes' ? 'active' : '' ?>">
      <i class="fas fa-utensils" style="font-size: 1.2rem; margin-right: 10px;"></i> Régimes
    </a>
    <!-- <a href="/sports" class="sidebar-item">
      <i class="fas fa-dumbbell" style="font-size: 1.2rem; margin-right: 10px;"></i> Activités
    </a> -->
  <a href="/profil" class="sidebar-item <?= $currentSegment === 'profil' ? 'active' : '' ?>">
      <i class="fas fa-user-circle" style="font-size: 1.2rem; margin-right: 10px;"></i> Mon profil
    </a>
    <div class="sidebar-section" style="margin-top: 16px;">Compte</div>
    <a href="/logout" class="sidebar-item">
      <i class="fas fa-sign-out-alt" style="font-size: 1.2rem; margin-right: 10px;"></i> Se déconnecter
    </a>
    <div class="sidebar-footer">
      <div class="sidebar-user">
        <div class="avatar"><?= esc($initials) ?></div>
        <div class="avatar-info"><p><?= esc($nom) ?></p><span><?= ($user['est_gold'] ?? 0) ? 'Compte gold' : 'Compte standard' ?></span></div>
      </div>
    </div>
  </div>