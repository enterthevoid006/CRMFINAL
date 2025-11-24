<?php
if (!isset($fiche)) {
  die("<p style='color:white;'>❌ Erreur : aucune fiche trouvée.</p>");
}

if (!function_exists('h')) {
  function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}
if (!function_exists('initials')) {
  function initials($p, $n) { return strtoupper(mb_substr($p, 0, 1) . mb_substr($n, 0, 1)); }
}
if (!function_exists('statusColor')) {
  function statusColor($s) {
    return match (strtolower((string)$s)) {
      'prospect' => 'primary',
      'en cours' => 'warning',
      'gagné', 'client' => 'success',
      'perdu' => 'danger',
      default => 'secondary'
    };
  }
}

/** Helpers spécifiques aux tâches **/
if (!function_exists('format_due_label')) {
  function format_due_label(?string $date_echeance, ?string $statut = null): string {
    if (!$date_echeance) return '';
    try {
      $today = new DateTime('today');
      $d = new DateTime($date_echeance);
      $isDone = strtolower((string)$statut) === 'terminée';

      if (!$isDone) {
        if ($d < $today) {
          return '<span class="badge bg-danger"><i class="bi bi-exclamation-triangle-fill me-1"></i>En retard</span>';
        }
        if ($d->format('Y-m-d') === $today->format('Y-m-d')) {
          return '<span class="badge bg-warning text-dark"><i class="bi bi-calendar-day me-1"></i>Aujourd’hui</span>';
        }
      }
      return '<span class="badge bg-secondary"><i class="bi bi-calendar-event me-1"></i>'.h($d->format('d/m/Y')).'</span>';
    } catch (Throwable $e) {
      return '';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title><?= h($fiche['prenom'].' '.$fiche['nom']) ?> — Ordex CRM</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
:root {
  --bg: #0b1020;
  --bg2: #10172a;
  --card: rgba(255,255,255,0.05);
  --border: rgba(255,255,255,0.08);
  --text: #e5e7eb;
  --muted: #9aa4b2;
  --accent: #3b82f6;
  --accent2: #0ea5e9;
  --success: #10b981;
  --danger: #ef4444;
}
body {
  background: radial-gradient(900px at 80% 10%, rgba(59,130,246,.25), transparent 60%), 
              linear-gradient(180deg, var(--bg) 0%, var(--bg2) 100%);
  color: var(--text);
  font-family: "Inter", sans-serif;
  min-height: 100vh;
}
.container { max-width: 1200px; }
.card-glass {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 16px;
  box-shadow: 0 6px 24px rgba(0,0,0,0.4);
  backdrop-filter: blur(10px);
  transition: all .25s ease;
}
.card-glass:hover { border-color: var(--accent2); transform: translateY(-2px); }
.section-title {
  font-weight: 600;
  color: var(--accent2);
  border-bottom: 1px solid var(--border);
  margin-bottom: 1rem;
  padding-bottom: .5rem;
}
.btn-accent {
  background: linear-gradient(90deg, var(--accent), var(--accent2));
  border: none;
  color: #fff;
  font-weight: 600;
  border-radius: 10px;
  transition: all .2s ease;
  box-shadow: 0 4px 12px rgba(59,130,246,0.25);
}
.btn-accent:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(59,130,246,0.35);
}
textarea, input, select {
  background: rgba(255,255,255,0.05)!important;
  color: var(--text)!important;
  border: 1px solid rgba(255,255,255,0.12)!important;
  border-radius: 10px!important;
}
.block {
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 10px;
  padding: 12px 16px;
  margin-bottom: 10px;
  transition: background .2s ease;
  position: relative;
}
.block:hover { background: rgba(255,255,255,0.07); }
.small-muted { color: var(--muted); font-size: 0.9rem; }
.scroll-zone { max-height: 350px; overflow-y:auto; }
.avatar {
  width: 90px; height: 90px; border-radius: 50%;
  background: linear-gradient(135deg, var(--accent), var(--accent2));
  display:flex; align-items:center; justify-content:center;
  font-size:1.8rem; font-weight:800; color:#fff;
}
</style>
</head>

<body>

<div class="container py-5">

  <!-- HEADER -->
  <div class="card-glass p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

      <div class="d-flex align-items-center gap-4">
        <div class="avatar"><?= initials($fiche['prenom'], $fiche['nom']) ?></div>
        <div>
          <h1 class="h4 fw-bold mb-1"><?= h($fiche['prenom'].' '.$fiche['nom']) ?></h1>
          <div class="small-muted"><?= h($fiche['profession'] ?? '') ?></div>
          <span class="badge bg-<?= statusColor($fiche['statut']) ?> mt-1">
            <?= h($fiche['statut']) ?>
          </span>
        </div>
      </div>

      <div class="text-end">
        <a href="index.php?page=pipeline" class="btn btn-accent btn-sm">
          <i class="bi bi-arrow-left-circle me-1"></i> Retour au pipeline
        </a>
        <div class="small-muted mt-2">
          <i class="bi bi-clock-history"></i>
          Créé le <?= date("d/m/Y à H:i", strtotime($fiche['date_creation'])) ?>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4">

    <!-- ====================== COLONNE GAUCHE ======================= -->
    <div class="col-lg-6">

      <!-- NOTES -->
      <section class="card-glass p-4 mb-4">
        <h2 class="section-title"><i class="bi bi-journal-text me-2"></i>Notes</h2>

        <div class="scroll-zone mb-3">
          <?php if ($notes && $notes->num_rows > 0): ?>
            <?php while($n = $notes->fetch_assoc()): ?>

              <div class="block">

                <div><?= nl2br(h($n['contenu'])) ?></div>

                <!-- Bouton supprimer -->
                <form method="POST"
                      action="index.php?page=supprimer_note"
                      onsubmit="return confirm('Supprimer cette note ?');"
                      class="position-absolute top-0 end-0">

                  <input type="hidden" name="note_id" value="<?= (int)$n['id'] ?>">
                  <input type="hidden" name="fiche_id" value="<?= (int)$fiche['id'] ?>">

                  <button class="btn btn-sm btn-danger" style="padding:4px 8px;">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>

                <div class="text-end small-muted mt-3">
                  <i class="bi bi-clock"></i> <?= h($n['date_creation']) ?>
                </div>

              </div>

            <?php endwhile; ?>
          <?php else: ?>
            <p class="text-center small-muted py-3">Aucune note enregistrée.</p>
          <?php endif; ?>
        </div>

        <!-- AJOUTER UNE NOTE -->
        <form method="POST" action="index.php?page=ajouternote">
          <input type="hidden" name="fiche_id" value="<?= (int)$fiche['id'] ?>">
          <textarea name="contenu" rows="3" class="form-control mb-2" placeholder="Ajouter une note..." required></textarea>
          <button class="btn btn-accent w-100"><i class="bi bi-plus-lg"></i> Ajouter une note</button>
        </form>

      </section>

      <!-- DOCUMENTS -->
      <section class="card-glass p-4">
        <h2 class="section-title"><i class="bi bi-folder2-open me-2"></i>Documents</h2>
        <p class="text-center small-muted py-3">📂 Fonctionnalité prochainement…</p>
      </section>

    </div>

    <!-- ====================== COLONNE DROITE ======================= -->
    <div class="col-lg-6">

      <!-- TÂCHES -->
      <section class="card-glass p-4">
        <h2 class="section-title"><i class="bi bi-list-check me-2"></i>Tâches</h2>

        <div class="scroll-zone mb-3">
          <?php if ($taches && $taches->num_rows > 0): ?>
            <?php while($t = $taches->fetch_assoc()): ?>

              <div class="block d-flex justify-content-between align-items-start" id="task-<?= $t['id'] ?>">

                <div>
                  <div class="fw-semibold"><?= h($t['titre']) ?></div>

                  <?= format_due_label($t['date_echeance'], $t['statut']) ?>

                  <?php if (!empty($t['statut'])): ?>
                    <span class="badge <?= strtolower($t['statut']) === 'terminée' ? 'bg-success' : 'bg-primary' ?>">
                      <?= h($t['statut']) ?>
                    </span>
                  <?php endif; ?>

                  <?php if (!empty($t['description'])): ?>
                    <div class="small-muted"><?= nl2br(h($t['description'])) ?></div>
                  <?php endif; ?>

                  <div class="small-muted mt-2">
                    <i class="bi bi-clock"></i> Créée le <?= h($t['date_creation']) ?>
                    <?php if ($t['date_echeance']): ?>
                      • <i class="bi bi-calendar3"></i> Échéance <?= date("d/m/Y", strtotime($t['date_echeance'])) ?>
                    <?php endif; ?>
                  </div>
                </div>

                <div>
                  <?php if (strtolower($t['statut']) !== 'terminée'): ?>
                    <button class="btn btn-success btn-sm" onclick="terminerTache(<?= $t['id'] ?>)">
                      <i class="bi bi-check2"></i>
                    </button>
                  <?php else: ?>
                    <span class="badge bg-success">
                      <i class="bi bi-check2-circle me-1"></i>Terminée
                    </span>
                  <?php endif; ?>
                </div>

              </div>

            <?php endwhile; ?>
          <?php else: ?>
            <p class="text-center small-muted py-3">Aucune tâche enregistrée.</p>
          <?php endif; ?>
        </div>

        <!-- AJOUTER TÂCHE -->
        <form method="POST" action="index.php?page=ajouter_tache">
          <input type="hidden" name="fiche_id" value="<?= $fiche['id'] ?>">

          <input type="text" name="titre" class="form-control mb-2" placeholder="Titre" required>
          <textarea name="description" rows="2" class="form-control mb-2" placeholder="Description"></textarea>

          <div class="row g-2 mb-2">
            <div class="col-md-6">
              <label class="small-muted">Échéance</label>
              <input type="date" name="date_echeance" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-6">
              <label class="small-muted">Statut</label>
              <select name="statut" class="form-select">
                <option value="À faire">À faire</option>
                <option value="En cours">En cours</option>
                <option value="Terminée">Terminée</option>
              </select>
            </div>
          </div>

          <button class="btn btn-accent w-100">
            <i class="bi bi-plus-lg"></i> Ajouter une tâche
          </button>

        </form>

      </section>
    </div>

  </div>
</div>

<script>
function terminerTache(id) {
  fetch('index.php?page=update_tache', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'id=' + id + '&statut=Terminée'
  })
  .then(r => r.text())
  .then(resp => {
    if (resp.trim() === 'success') {
      const el = document.getElementById('task-'+id);
      el.querySelector('button').remove();
      el.querySelector('.text-nowrap').innerHTML += 
        '<span class="badge bg-success"><i class="bi bi-check2-circle"></i> Terminée</span>';
    }
  });
}
</script>

</body>
</html>

