<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Tâches — Ordex CRM</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* ====== BASE ====== */
body {
  background: linear-gradient(180deg, #0b1020 0%, #10172a 100%);
  color: #e5e7eb;
  font-family: "Inter", sans-serif;
  margin-left: 240px;
  min-height: 100vh;
}
@media(max-width:768px) { body { margin-left: 0; padding-top: 80px; } }

.container {
  max-width: 1200px;
  padding: 2rem;
}

/* ====== FILTER BAR ====== */
.filter-bar {
  display: flex;
  gap: 10px;
  margin-bottom: 25px;
  padding: 12px;
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 14px;
  backdrop-filter: blur(6px);
}

.filter-btn {
  padding: 8px 18px;
  border-radius: 8px;
  border: 1px solid rgba(255,255,255,0.15);
  background: rgba(255,255,255,0.06);
  color: #e5e7eb;
  cursor: pointer;
  transition: 0.2s;
}
.filter-btn:hover {
  background: rgba(255,255,255,0.12);
}
.filter-btn.active {
  background: #0ea5e9;
  border-color: #0ea5e9;
  color: #fff;
}

/* ====== SECTIONS ====== */
.section {
  margin-bottom: 2rem;
}

.section-title {
  font-size: 1.2rem;
  font-weight: 600;
  color: #0ea5e9;
  margin-bottom: 1rem;
}

/* ====== TASK CARDS ====== */
.task {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.09);
  border-radius: 12px;
  padding: 16px;
  margin-bottom: 12px;
  display: flex;
  justify-content: space-between;
  gap: 10px;
  transition: background .2s, transform .2s;
}
.task:hover {
  background: rgba(255,255,255,0.08);
  transform: translateY(-2px);
}

.task-title {
  font-weight: 600;
  font-size: 1rem;
}
.task-meta {
  font-size: .9rem;
  color: #94a3b8;
}

/* Badges */
.badge-today {
  background: #facc15; color: #000;
}
.badge-late {
  background: #ef4444;
}
.badge-next {
  background: #3b82f6;
}

</style>
</head>
<body>

<div class="container">

  <h1 class="mb-4"><i class="bi bi-list-check me-2"></i>Mes tâches</h1>

  <!-- 🔥 FILTER BAR -->
  <div class="filter-bar">
    <button class="filter-btn active" data-filter="today">Aujourd’hui</button>
    <button class="filter-btn" data-filter="upcoming">À venir</button>
    <button class="filter-btn" data-filter="past">Passées</button>
    <button class="filter-btn" data-filter="all">Toutes</button>
  </div>

  <!-- ==============================================================
      🔸 SECTION : TÂCHES DU JOUR
  ============================================================== -->
  <section class="section" data-section="today">
    <div class="section-title"><i class="bi bi-calendar-day me-2"></i>Tâches du jour</div>

    <?php if (!empty($tachesJour)): ?>
      <?php foreach ($tachesJour as $t): ?>
        <div class="task" id="task-<?= (int)$t['id'] ?>">

          <div>
            <div class="task-title"><?= htmlspecialchars($t['titre']) ?></div>
            <div class="task-meta">
              <?= htmlspecialchars($t['prenom']." ".$t['nom']) ?> —
              <span class="badge badge-today">Aujourd’hui</span>
              <?php if ($t['description']): ?><br><?= nl2br(htmlspecialchars($t['description'])) ?><?php endif; ?>
            </div>
          </div>

          <div class="d-flex gap-2">

            <!-- terminer -->
            <?php if (strtolower($t['statut']) !== 'terminée'): ?>
              <button class="btn btn-success btn-sm" onclick="terminerTache(<?= (int)$t['id'] ?>)">
                <i class="bi bi-check2"></i>
              </button>
            <?php else: ?>
              <span class="badge bg-success">Terminée</span>
            <?php endif; ?>

            <!-- supprimer -->
            <button class="btn btn-danger btn-sm" onclick="supprimerTache(<?= (int)$t['id'] ?>)">
              <i class="bi bi-trash"></i>
            </button>

          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-muted">Aucune tâche prévue aujourd’hui.</p>
    <?php endif; ?>
  </section>


  <!-- ==============================================================
      🔸 SECTION : TÂCHES À VENIR
  ============================================================== -->
  <section class="section" data-section="upcoming" style="display:none;">
    <div class="section-title"><i class="bi bi-calendar-event me-2"></i>Tâches à venir</div>

    <?php if (!empty($tachesAVenir)): ?>
      <?php foreach ($tachesAVenir as $t): ?>
        <div class="task" id="task-<?= (int)$t['id'] ?>">

          <div>
            <div class="task-title"><?= htmlspecialchars($t['titre']) ?></div>
            <div class="task-meta">
              <?= htmlspecialchars($t['prenom']." ".$t['nom']) ?> —
              <span class="badge badge-next"><?= date('d/m/Y', strtotime($t['date_echeance'])) ?></span>
              <?php if ($t['description']): ?><br><?= nl2br(htmlspecialchars($t['description'])) ?><?php endif; ?>
            </div>
          </div>

          <div class="d-flex gap-2">
            <?php if (strtolower($t['statut']) !== 'terminée'): ?>
              <button class="btn btn-success btn-sm" onclick="terminerTache(<?= (int)$t['id'] ?>)">
                <i class="bi bi-check2"></i>
              </button>
            <?php else: ?>
              <span class="badge bg-success">Terminée</span>
            <?php endif; ?>

            <button class="btn btn-danger btn-sm" onclick="supprimerTache(<?= (int)$t['id'] ?>)">
              <i class="bi bi-trash"></i>
            </button>
          </div>

        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-muted">Aucune tâche à venir.</p>
    <?php endif; ?>
  </section>


  <!-- ==============================================================
      🔸 SECTION : TÂCHES PASSÉES
  ============================================================== -->
  <section class="section" data-section="past" style="display:none;">
    <div class="section-title"><i class="bi bi-clock-history me-2"></i>Tâches passées</div>

    <?php if (!empty($tachesPassees)): ?>
      <?php foreach ($tachesPassees as $t): ?>
        <div class="task" id="task-<?= (int)$t['id'] ?>">

          <div>
            <div class="task-title"><?= htmlspecialchars($t['titre']) ?></div>
            <div class="task-meta">
              <?= htmlspecialchars($t['prenom']." ".$t['nom']) ?> —
              <span class="badge badge-late"><?= date('d/m/Y', strtotime($t['date_echeance'])) ?></span>
              <?php if ($t['description']): ?><br><?= nl2br(htmlspecialchars($t['description'])) ?><?php endif; ?>
            </div>
          </div>

          <div class="d-flex gap-2">
            <?php if (strtolower($t['statut']) !== 'terminée'): ?>
              <button class="btn btn-success btn-sm" onclick="terminerTache(<?= (int)$t['id'] ?>)">
                <i class="bi bi-check2"></i>
              </button>
            <?php else: ?>
              <span class="badge bg-success">Terminée</span>
            <?php endif; ?>

            <button class="btn btn-danger btn-sm" onclick="supprimerTache(<?= (int)$t['id'] ?>)">
              <i class="bi bi-trash"></i>
            </button>
          </div>

        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-muted">Aucune tâche passée.</p>
    <?php endif; ?>
  </section>

</div>


<!-- ==============================================================
     🔥  SCRIPT JS
============================================================== -->
<script>

/* ====== FILTER JS ====== */
document.querySelectorAll('.filter-btn').forEach(btn => {
  btn.addEventListener('click', () => {

    const filter = btn.dataset.filter;

    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    if (filter === "all") {
      document.querySelectorAll('[data-section]').forEach(sec => sec.style.display = "block");
    } else {
      document.querySelectorAll('[data-section]').forEach(sec => {
        sec.style.display = (sec.dataset.section === filter) ? "block" : "none";
      });
    }

  });
});


/* ====== API terminer tâche ====== */
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
  });
}


/* ====== API supprimer tâche ====== */
function supprimerTache(id) {

  if (!confirm("Supprimer définitivement cette tâche ?")) return;

  fetch('index.php?page=delete_tache', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'id=' + encodeURIComponent(id)
  })
  .then(r => r.text())
  .then(txt => {
    if (txt.trim() === "success") {
      document.getElementById("task-" + id).remove();
    } else {
      alert("Erreur: " + txt);
    }
  });

}

</script>

</body>
</html>
