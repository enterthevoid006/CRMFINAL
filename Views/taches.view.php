<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Tâches — Ordex CRM</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
  background: linear-gradient(180deg, #0b1020 0%, #10172a 100%);
  color: #e5e7eb;
  font-family: "Inter", sans-serif;
  margin-left: 240px; /* espace pour la sidebar */
  min-height: 100vh;
}
@media(max-width:768px) { body { margin-left: 0; padding-top: 80px; } }

.container {
  max-width: 1100px;
  padding: 2rem;
}

.section {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 16px;
  padding: 1.5rem;
  margin-bottom: 2rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.35);
}

.section h2 {
  font-size: 1.2rem;
  font-weight: 600;
  color: #0ea5e9;
  margin-bottom: 1rem;
  border-bottom: 1px solid rgba(255,255,255,0.1);
  padding-bottom: .5rem;
}

.task {
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 10px;
  padding: 12px 16px;
  margin-bottom: 10px;
  display: flex;
  justify-content: space-between;
  align-items: start;
  gap: 10px;
  transition: background .2s;
}
.task:hover { background: rgba(255,255,255,0.07); }

.task-title {
  font-weight: 600;
  margin-bottom: 4px;
}
.task-meta {
  font-size: .9rem;
  color: #9aa4b2;
}
.badge-today { background: #facc15; color: #000; }
.badge-late { background: #ef4444; }
.badge-next { background: #3b82f6; }
.btn-sm { padding: .25rem .5rem; font-size: .85rem; }

</style>
</head>
<body>

<div class="container">
  <h1 class="mb-4"><i class="bi bi-list-check me-2"></i>Mes tâches</h1>

  <!-- 🔸 Tâches du jour -->
  <section class="section">
    <h2><i class="bi bi-calendar-day me-2"></i>Tâches du jour</h2>
    <?php if (!empty($tachesJour)): ?>
      <?php foreach ($tachesJour as $t): ?>
        <div class="task" id="task-<?= (int)$t['id'] ?>">
          <div>
            <div class="task-title"><?= htmlspecialchars($t['titre']) ?></div>
            <div class="task-meta">
              <?= htmlspecialchars($t['prenom'].' '.$t['nom']) ?> —
              Échéance : <span class="badge badge-today">Aujourd’hui</span>
              <?php if (!empty($t['description'])): ?><br><?= nl2br(htmlspecialchars($t['description'])) ?><?php endif; ?>
            </div>
          </div>
          <div>
            <?php if (strtolower($t['statut']) !== 'terminée'): ?>
              <button class="btn btn-success btn-sm" onclick="terminerTache(<?= (int)$t['id'] ?>)">
                <i class="bi bi-check2"></i>
              </button>
            <?php else: ?>
              <span class="badge bg-success">Terminée</span>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-muted">Aucune tâche prévue aujourd’hui.</p>
    <?php endif; ?>
  </section>

  <!-- 🔸 Tâches à venir -->
  <section class="section">
    <h2><i class="bi bi-calendar-event me-2"></i>Tâches à venir</h2>
    <?php if (!empty($tachesAVenir)): ?>
      <?php foreach ($tachesAVenir as $t): ?>
        <div class="task" id="task-<?= (int)$t['id'] ?>">
          <div>
            <div class="task-title"><?= htmlspecialchars($t['titre']) ?></div>
            <div class="task-meta">
              <?= htmlspecialchars($t['prenom'].' '.$t['nom']) ?> —
              <span class="badge badge-next"><?= date('d/m/Y', strtotime($t['date_echeance'])) ?></span>
              <?php if (!empty($t['description'])): ?><br><?= nl2br(htmlspecialchars($t['description'])) ?><?php endif; ?>
            </div>
          </div>
          <div>
            <?php if (strtolower($t['statut']) !== 'terminée'): ?>
              <button class="btn btn-success btn-sm" onclick="terminerTache(<?= (int)$t['id'] ?>)">
                <i class="bi bi-check2"></i>
              </button>
            <?php else: ?>
              <span class="badge bg-success">Terminée</span>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-muted">Aucune tâche à venir.</p>
    <?php endif; ?>
  </section>

  <!-- 🔸 Tâches passées -->
  <section class="section">
    <h2><i class="bi bi-clock-history me-2"></i>Tâches passées</h2>
    <?php if (!empty($tachesPassees)): ?>
      <?php foreach ($tachesPassees as $t): ?>
        <div class="task" id="task-<?= (int)$t['id'] ?>">
          <div>
            <div class="task-title"><?= htmlspecialchars($t['titre']) ?></div>
            <div class="task-meta">
              <?= htmlspecialchars($t['prenom'].' '.$t['nom']) ?> —
              <span class="badge badge-late"><?= date('d/m/Y', strtotime($t['date_echeance'])) ?></span>
              <?php if (!empty($t['description'])): ?><br><?= nl2br(htmlspecialchars($t['description'])) ?><?php endif; ?>
            </div>
          </div>
          <div>
            <?php if (strtolower($t['statut']) !== 'terminée'): ?>
              <button class="btn btn-success btn-sm" onclick="terminerTache(<?= (int)$t['id'] ?>)">
                <i class="bi bi-check2"></i>
              </button>
            <?php else: ?>
              <span class="badge bg-success">Terminée</span>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-muted">Aucune tâche passée.</p>
    <?php endif; ?>
  </section>
</div>

<script>
function terminerTache(id) {
  fetch('index.php?page=update_tache', {
    method: 'POST',
    headers: {'Content-Type':'application/x-www-form-urlencoded'},
    body: 'id=' + encodeURIComponent(id)
  })
  .then(r => r.text())
  .then(txt => {
    if (txt.trim() === 'success') location.reload();
    else alert('Erreur: ' + txt);
  })
  .catch(err => alert('Erreur réseau: ' + err));
}
</script>

</body>
</html>

