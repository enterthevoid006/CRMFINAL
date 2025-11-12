<?php include __DIR__ . '/../sidebar.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Tableau de bord — Ordex CRM</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
      color: #e2e8f0;
      margin: 0;
    }
    .container { margin-left: 240px; padding: 2rem; }
    header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .btn-primary {
      background: linear-gradient(90deg, #2563eb, #3b82f6);
      border: none; border-radius: 10px;
      padding: 0.7rem 1.4rem; font-weight: 500;
      transition: 0.3s;
    }
    .btn-primary:hover { opacity: .9; transform: scale(1.02); }
    .card-stat {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(10px);
      border-radius: 14px; padding: 1.5rem;
      transition: 0.3s; box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }
    .card-stat:hover { transform: translateY(-4px); background: rgba(255,255,255,0.12); }
    .card-stat h3 { font-size: 2rem; font-weight: 600; color: #fff; }
    .card-stat p { color: #94a3b8; font-size: 0.95rem; margin-top: 0.5rem; }
    .table { background: rgba(255,255,255,0.05); color: #e2e8f0; border-radius: 12px; overflow: hidden; }
    thead { background-color: rgba(255,255,255,0.08); }
    tbody tr { cursor: pointer; }
    tbody tr:hover { background-color: rgba(255,255,255,0.1); }
    .badge { border-radius: 6px; padding: 0.4rem 0.6rem; font-size: 0.85rem; }
    .badge.Prospect { background-color: #f59e0b; color: white; }
    .badge.En\ cours { background-color: #3b82f6; color: white; }
    .badge.Gagné { background-color: #16a34a; color: white; }
    .badge.Perdu { background-color: #dc2626; color: white; }
  </style>
</head>

<body>
  <div class="container">
    <header>
      <h2 class="fw-bold text-light">Tableau de bord</h2>
      <!-- ✅ Lien correct (via front controller) -->
      <a href="index.php?page=creer_contact" class="btn btn-primary">+ Nouvelle fiche</a>
    </header>

    <div class="row text-center g-4 mb-4">
      <div class="col-md-2"><div class="card-stat"><h3><?= $stats['total_clients'] ?? 0 ?></h3><p>Total clients</p></div></div>
      <div class="col-md-2"><div class="card-stat"><h3><?= $stats['prospects'] ?? 0 ?></h3><p>Prospects</p></div></div>
      <div class="col-md-2"><div class="card-stat"><h3><?= $stats['encours'] ?? 0 ?></h3><p>En cours</p></div></div>
      <div class="col-md-2"><div class="card-stat"><h3><?= $stats['gagnes'] ?? 0 ?></h3><p>Gagnés</p></div></div>
      <div class="col-md-2"><div class="card-stat"><h3><?= $stats['perdus'] ?? 0 ?></h3><p>Perdus</p></div></div>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-md-6"><canvas id="pipelineChart"></canvas></div>
      <div class="col-md-6"><canvas id="monthlyChart"></canvas></div>
    </div>

    <h4 class="mt-5 mb-3 fw-semibold text-light">Derniers ajouts</h4>
    <table class="table align-middle">
      <thead>
        <tr><th>Nom</th><th>Email</th><th>Profession</th><th>Statut</th></tr>
      </thead>
      <tbody>
        <?php if (!empty($dernieres_fiches) && $dernieres_fiches->num_rows > 0): ?>
          <?php while ($fiche = $dernieres_fiches->fetch_assoc()): ?>
            <tr onclick="window.location.href='index.php?page=fiche&id=<?= $fiche['id'] ?>'">
              <td><?= htmlspecialchars($fiche['prenom'].' '.$fiche['nom']) ?></td>
              <td><?= htmlspecialchars($fiche['email']) ?></td>
              <td><?= htmlspecialchars($fiche['profession']) ?></td>
              <td><span class="badge <?= htmlspecialchars($fiche['statut']) ?>"><?= htmlspecialchars($fiche['statut']) ?></span></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="4" class="text-center text-muted py-4">Aucune fiche récente.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <script>
    // Données sécurisées avec valeurs par défaut
    const stats = {
      prospects: <?= (int)($stats['prospects'] ?? 0) ?>,
      encours:   <?= (int)($stats['encours'] ?? 0) ?>,
      gagnes:    <?= (int)($stats['gagnes'] ?? 0) ?>,
      perdus:    <?= (int)($stats['perdus'] ?? 0) ?>,
    };

    new Chart(document.getElementById('pipelineChart'), {
      type: 'doughnut',
      data: {
        labels: ['Prospects', 'En cours', 'Gagnés', 'Perdus'],
        datasets: [{
          data: [stats.prospects, stats.encours, stats.gagnes, stats.perdus],
          backgroundColor: ['#f59e0b','#3b82f6','#16a34a','#dc2626'],
          hoverOffset: 15,
        }]
      },
      options: {
        plugins: {
          legend: { labels: { color: '#fff' } },
          title: { display: true, text: 'Répartition du pipeline', color: '#fff' }
        },
        animation: { animateScale: true }
      }
    });

    new Chart(document.getElementById('monthlyChart'), {
      type: 'bar',
      data: {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
        datasets: [{
          label: 'Clients gagnés',
          data: [1, 2, 4, 3, 5, stats.gagnes],
          backgroundColor: '#3b82f6',
          borderRadius: 8
        }]
      },
      options: {
        plugins: {
          legend: { labels: { color: '#fff' } },
          title: { display: true, text: 'Évolution mensuelle des gains', color: '#fff' }
        },
        scales: {
          x: { ticks: { color: '#94a3b8' } },
          y: { ticks: { color: '#94a3b8' } }
        }
      }
    });
  </script>
</body>
</html>

