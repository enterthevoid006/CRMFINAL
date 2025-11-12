<?php include __DIR__ . '/../sidebar.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Fiches enregistrées | Ordex CRM</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      display: flex;
      min-height: 100vh;
      background-color: #f8f9fa;
    }
    /* Barre latérale */
    .sidebar {
      width: 220px;
      background-color: #212529;
      color: white;
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      padding: 1.5rem 1rem;
    }
    .sidebar h3 {
      font-size: 1.4rem;
      text-align: center;
      margin-bottom: 2rem;
    }
    .sidebar a {
      display: block;
      color: #adb5bd;
      text-decoration: none;
      margin: 0.8rem 0;
      font-size: 1.1rem;
    }
    .sidebar a:hover {
      color: white;
    }
    /* Contenu principal */
    .main {
      margin-left: 240px;
      padding: 2rem;
      width: 100%;
    }
  </style>
</head>

<body>
  <div class="main">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Fiches enregistrées</h2>
      <a href="index.php?page=creer_contact" class="btn btn-primary">+ Ajouter une fiche</a>
    </div>

    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-success text-center">Fiche enregistrée avec succès ✅</div>
    <?php endif; ?>

    <div class="row">
      <?php if ($fiches && $fiches->num_rows > 0): ?>
        <?php while ($row = $fiches->fetch_assoc()): ?>
          <div class="col-md-4 mb-3">
            <div class="card shadow-sm p-3">
              <h5>
                <a href="index.php?page=fiche&id=<?= (int)$row['id'] ?>" class="text-decoration-none text-dark">
                  <?= htmlspecialchars($row['prenom']) . ' ' . htmlspecialchars($row['nom']) ?>
                </a>
              </h5>
              <p><b>Email :</b> <?= htmlspecialchars($row['email']) ?></p>
              <p><b>Profession :</b> <?= htmlspecialchars($row['profession']) ?></p>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-center text-muted">Aucune fiche enregistrée pour le moment.</p>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>

