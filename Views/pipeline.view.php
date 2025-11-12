<?php include __DIR__ . '/../sidebar.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Pipeline — <?= APP_NAME ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(180deg, #0b1020 0%, #0f172a 70%, #0b1020 100%);
      font-family: "Inter", "Segoe UI", sans-serif;
      color: #e5e7eb;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* ----------- SIDEBAR ----------- */
    .ordex-sidebar {
      width: 240px;
      background: rgba(15,23,42,0.92);
      backdrop-filter: blur(10px);
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 1050;
    }

    /* ----------- MAIN CONTENT ----------- */
    .main-content {
      margin-left: 240px;
      padding: 2rem;
      transition: margin 0.3s ease;
    }

    /* ----------- BOUTON DASHBOARD ----------- */
    .btn-dashboard {
      background: rgba(37,99,235,0.15);
      color: #60a5fa;
      border: 1px solid rgba(59,130,246,0.4);
      border-radius: 10px;
      padding: 10px 16px;
      font-weight: 600;
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }
    .btn-dashboard:hover {
      background: rgba(37,99,235,0.3);
      color: #93c5fd;
      text-decoration: none;
      transform: translateY(-2px);
    }

    /* ----------- PIPELINE ----------- */
    .pipeline {
      display: flex;
      gap: 28px;
      overflow-x: auto;
      padding: 20px;
      scrollbar-width: thin;
      scrollbar-color: #334155 transparent;
      flex-wrap: wrap;
    }

    .column {
      flex: 1 1 320px;
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.3);
      padding: 16px;
      transition: background 0.2s ease;
      min-width: 280px;
      max-width: 100%;
    }
    .column:hover { background: rgba(255,255,255,0.05); }
    .column h4 {
      text-align: center;
      color: #a5b4fc;
      margin-bottom: 1.2rem;
      font-weight: 700;
      letter-spacing: 0.3px;
    }

    .card {
      position: relative;
      background: linear-gradient(135deg, rgba(30,41,59,0.85), rgba(51,65,85,0.9));
      border-radius: 14px;
      margin-bottom: 14px;
      padding: 14px 16px;
      color: #e5e7eb;
      box-shadow: 0 6px 18px rgba(0,0,0,0.25);
      border: 1px solid rgba(255,255,255,0.06);
      cursor: grab;
      transition: all 0.25s ease;
      user-select: none;
    }
    .card:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(59,130,246,0.3);
      border-color: rgba(59,130,246,0.3);
    }

    .card h6 { font-weight: 700; color: #fff; margin-bottom: 6px; }
    .card small { display: block; font-size: 0.9rem; color: #94a3b8; }

    .btn-delete {
      position: absolute;
      top: 6px;
      right: 8px;
      border: none;
      background: transparent;
      color: #f87171;
      font-size: 1.3rem;
      cursor: pointer;
      opacity: 0.6;
      transition: all 0.2s ease;
    }
    .btn-delete:hover { opacity: 1; transform: scale(1.2); }

    .drag-over {
      border: 2px dashed #3b82f6;
      background-color: rgba(37,99,235,0.15);
    }

    ::-webkit-scrollbar { height: 10px; }
    ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }

    /* ----------- RESPONSIVE ----------- */
    @media (max-width: 1200px) {
      .main-content {
        margin-left: 0 !important;
        padding: 1rem;
      }
      .pipeline {
        flex-wrap: wrap;
        gap: 20px;
        padding: 10px;
      }
      .column {
        min-width: 100%;
      }
    }

    /* 📱 Cacher la sidebar sur smartphone et styliser le bouton dashboard */
    @media (max-width: 768px) {
      .ordex-sidebar { display: none !important; }
      .main-content { margin-left: 0 !important; }
      .btn-dashboard {
        display: inline-flex;
        justify-content: center;
        width: 100%;
        padding: 12px;
        font-size: 1rem;
      }
    }
  </style>
</head>

<body>
  <div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
      <a href="index.php?page=dashboard" class="btn-dashboard">
        <i class="bi bi-speedometer2"></i>
        <span>Tableau de bord</span>
      </a>
      <a href="index.php?page=creer_contact" class="btn btn-primary btn-lg">
        <i class="bi bi-person-plus-fill me-2"></i>Ajouter un client
      </a>
    </div>

    <div class="pipeline">
      <?php foreach ($stages as $stage): ?>
        <div class="column" data-stage="<?= htmlspecialchars($stage) ?>">
          <h4><?= htmlspecialchars($stage) ?></h4>
          <?php foreach ($fiches[$stage] as $row): ?>
            <div class="card" draggable="true" data-id="<?= $row['id'] ?>" data-link="index.php?page=fiche&id=<?= $row['id'] ?>">
              <button class="btn-delete" title="Supprimer cette fiche">&times;</button>
              <h6><?= htmlspecialchars($row['prenom']) . ' ' . htmlspecialchars($row['nom']) ?></h6>
              <small><i class="bi bi-briefcase me-1"></i><?= htmlspecialchars($row['profession']) ?></small>
              <small><i class="bi bi-envelope me-1"></i><?= htmlspecialchars($row['email']) ?></small>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <script>
    // 🔗 Redirection vers la fiche
    document.querySelectorAll('.card').forEach(card => {
      card.addEventListener('click', e => {
        if (e.target.classList.contains('btn-delete')) return;
        window.location.href = card.dataset.link;
      });
    });

    // 🧩 Drag & Drop
    let draggedCard = null;
    document.querySelectorAll('.card').forEach(card => {
      card.addEventListener('dragstart', () => {
        draggedCard = card;
        card.style.opacity = '0.6';
        setTimeout(() => card.classList.add('dragging'), 0);
      });
      card.addEventListener('dragend', () => {
        card.style.opacity = '1';
        card.classList.remove('dragging');
        draggedCard = null;
      });
    });

    document.querySelectorAll('.column').forEach(col => {
      col.addEventListener('dragover', e => {
        e.preventDefault();
        col.classList.add('drag-over');
      });
      col.addEventListener('dragleave', () => col.classList.remove('drag-over'));
      col.addEventListener('drop', e => {
        e.preventDefault();
        col.classList.remove('drag-over');
        if (draggedCard) {
          col.appendChild(draggedCard);
          const id = draggedCard.dataset.id;
          const newStage = col.dataset.stage;
          fetch('index.php?page=update_statut', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + id + '&statut=' + encodeURIComponent(newStage)
          })
          .then(res => res.text())
          .then(txt => console.log('✅ Statut mis à jour :', txt))
          .catch(err => console.error('❌ Erreur AJAX:', err));
        }
      });
    });

    // 🗑️ Suppression d’une fiche
    document.addEventListener('click', function(e) {
      if (e.target.classList.contains('btn-delete')) {
        e.stopPropagation();
        const card = e.target.closest('.card');
        const id = card.dataset.id;
        if (confirm("Supprimer définitivement cette fiche client ?")) {
          fetch('index.php?page=delete_fiche', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + id
          })
          .then(res => res.text())
          .then(response => {
            if (response.trim() === 'success') {
              card.style.opacity = '0';
              card.style.transform = 'scale(0.9)';
              setTimeout(() => card.remove(), 300);
            } else {
              alert("Erreur lors de la suppression : " + response);
            }
          })
          .catch(() => alert("Erreur de communication avec le serveur."));
        }
      }
    });
  </script>
</body>
</html>






