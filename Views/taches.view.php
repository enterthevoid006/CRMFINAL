<?php include __DIR__ . '/../sidebar.php'; ?>
<?php function h($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');} ?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ordex CRM — Tâches du jour</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
:root {
  --bg: #0b1020;
  --bg2: #10172a;
  --card: rgba(255,255,255,0.05);
  --border: rgba(255,255,255,0.1);
  --text: #e5e7eb;
  --muted: #9aa4b2;
  --accent: #3b82f6;
  --accent2: #0ea5e9;
  --success: #10b981;
  --warning: #f59e0b;
  --danger: #ef4444;
}

body {
  background: radial-gradient(900px at 80% 10%, rgba(59,130,246,.25), transparent 60%) ,
              linear-gradient(180deg, var(--bg) 0%, var(--bg2) 100%);
  color: var(--text);
  font-family: 'Inter', sans-serif;
  min-height: 100vh;
  overflow-x: hidden;
}

/* 📱 Cacher la sidebar sur mobile */
@media (max-width: 768px) {
  .ordex-sidebar {
    display: none !important;
  }
}

.topbar {
  position: sticky;
  top: 0;
  z-index: 100;
  background: rgba(10,16,35,0.7);
  backdrop-filter: blur(12px);
  border-bottom: 1px solid var(--border);
  box-shadow: 0 2px 10px rgba(0,0,0,0.4);
}
.topbar .inner {
  max-width: 1100px;
  margin: auto;
  padding: 14px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.topbar h5 {
  font-weight: 600;
  color: var(--text);
}
.btn-ghost {
  color: var(--text);
  border: 1px solid var(--border);
  border-radius: 8px;
  transition: all .2s;
  font-weight: 500;
  background: transparent;
}
.btn-ghost:hover {
  background: var(--accent);
  color: #fff;
  border-color: var(--accent);
}

.wrap {
  max-width: 1100px;
  margin: 40px auto;
  padding: 0 16px;
}

.panel {
  border-radius: 16px;
  background: var(--card);
  border: 1px solid var(--border);
  box-shadow: 0 8px 24px rgba(0,0,0,0.4);
  padding: 28px;
  backdrop-filter: blur(12px);
}

.task-card {
  border: 1px solid var(--border);
  border-radius: 12px;
  padding: 18px;
  margin-bottom: 14px;
  background: rgba(255,255,255,0.03);
  display: flex;
  justify-content: space-between;
  align-items: center;
  transition: all .25s ease;
}
.task-card:hover {
  transform: translateY(-2px);
  border-color: var(--accent2);
  background: rgba(255,255,255,0.06);
}

.task-info strong {
  font-size: 1rem;
  color: var(--text);
}
.task-info small {
  color: var(--muted);
}

.status-badge {
  border-radius: 999px;
  padding: .35rem .8rem;
  font-size: .8rem;
  font-weight: 600;
  text-transform: capitalize;
  border: 1px solid transparent;
}
.status-en-attente {
  background: rgba(59,130,246,0.15);
  color: var(--accent2);
  border-color: rgba(59,130,246,0.3);
}
.status-en-cours {
  background: rgba(245,158,11,0.15);
  color: var(--warning);
  border-color: rgba(245,158,11,0.3);
}
.status-terminée {
  background: rgba(16,185,129,0.15);
  color: var(--success);
  border-color: rgba(16,185,129,0.3);
}

.btn-close-task {
  background: transparent;
  border: 1px solid var(--success);
  color: var(--success);
  border-radius: 8px;
  padding: 6px 10px;
  font-size: .9rem;
  font-weight: 500;
  transition: all .25s;
}
.btn-close-task:hover {
  background: var(--success);
  color: #fff;
}
.empty {
  text-align: center;
  padding: 60px 20px;
  color: var(--muted);
}
.empty i {
  font-size: 3rem;
  opacity: .25;
  display: block;
  margin-bottom: 12px;
}

.toast {
  background: var(--accent);
  color: #fff;
  border: none;
  border-radius: 12px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.3);
  animation: fadeIn .4s ease;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: none; }
}
.fade-up {
  animation: fadeUp .5s ease forwards;
  opacity: 0;
  transform: translateY(10px);
}
@keyframes fadeUp {
  to { opacity: 1; transform: none; }
}
</style>
</head>

<body>
  <div class="topbar">
    <div class="inner">
      <a href="index.php?page=pipeline" class="btn btn-sm btn-ghost"><i class="bi bi-kanban"></i> Pipeline</a>
      <h5 class="m-0"><i class="bi bi-calendar2-event me-2"></i>Tâches du <?= date('d/m/Y') ?></h5>
      <a href="index.php?page=dashboard" class="btn btn-sm btn-ghost"><i class="bi bi-speedometer2"></i> Tableau de bord</a>
    </div>
  </div>

  <div class="wrap fade-up">
    <div class="panel">
      <?php if (count($taches) > 0): ?>
        <?php foreach ($taches as $t): ?>
          <div class="task-card" data-id="<?= $t['id'] ?>">
            <div class="task-info">
              <strong><?= h($t['titre']) ?></strong><br>
              <small><?= nl2br(h($t['description'])) ?></small><br>
              <small><i class="bi bi-person-circle me-1"></i><?= h($t['prenom'].' '.$t['nom']) ?></small>
            </div>
            <div class="d-flex align-items-center gap-2">
              <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $t['statut'])) ?>">
                <?= h($t['statut']) ?>
              </span>
              <?php if (strtolower($t['statut']) !== 'terminée'): ?>
                <button class="btn-close-task" title="Clôturer cette tâche">
                  <i class="bi bi-check2-circle"></i>
                </button>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="empty">
          <i class="bi bi-calendar-x"></i>
          <p>Aucune tâche prévue pour aujourd’hui.<br><strong>Profite pour organiser ta journée sereinement.</strong></p>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Toast -->
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index:1100">
    <div id="toast" class="toast align-items-center text-bg-primary border-0" role="alert">
      <div class="d-flex">
        <div class="toast-body fw-semibold">
          <i class="bi bi-check2-circle me-2"></i>Tâche clôturée avec succès.
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  const toastEl = document.getElementById('toast');
  const toast = new bootstrap.Toast(toastEl, { delay: 2500 });

  document.querySelectorAll('.btn-close-task').forEach(btn => {
    btn.addEventListener('click', async () => {
      const card = btn.closest('.task-card');
      const id = card.dataset.id;

      btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
      btn.disabled = true;

      const res = await fetch('index.php?page=update_tache', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'id=' + id
      });
      const text = await res.text();

      if (text.trim() === 'success') {
        const badge = card.querySelector('.status-badge');
        badge.textContent = 'Terminée';
        badge.className = 'status-badge status-terminée';
        btn.remove();
        toast.show();
      } else {
        alert('Erreur : ' + text);
        btn.innerHTML = '<i class="bi bi-check2-circle"></i>';
        btn.disabled = false;
      }
    });
  });
  </script>
</body>
</html>


