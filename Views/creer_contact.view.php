<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Créer une fiche contact | Ordex CRM</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: "Inter", sans-serif;
      color: #212529;
    }

    .card {
      max-width: 650px;
      width: 100%;
      border: none;
      border-radius: 1rem;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
      animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .form-section {
      border-top: 1px solid #dee2e6;
      padding-top: 1.2rem;
      margin-top: 1.2rem;
    }

    .form-label i {
      color: #0d6efd;
      margin-right: 6px;
    }

    .form-control:focus {
      border-color: #0d6efd;
      box-shadow: 0 0 0 0.15rem rgba(13,110,253,.25);
    }

    .btn-primary {
      border-radius: 0.5rem;
      font-weight: 600;
      transition: all 0.2s ease-in-out;
    }

    .btn-primary:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(13,110,253,0.3);
    }

    .section-title {
      font-size: 1.1rem;
      font-weight: 600;
      color: #0d6efd;
      margin-bottom: 0.8rem;
      text-transform: uppercase;
    }
  </style>
</head>

<body>

  <div class="card p-4 mb-4">
    <h2 class="text-center mb-4">
      <i class="bi bi-person-lines-fill me-2"></i>Créer une fiche contact
    </h2>

    <form action="index.php?page=creer_contact" method="POST">
      <!-- le reste inchangé -->
      <div class="section-title">Informations personnelles</div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label"><i class="bi bi-person-fill"></i>Nom</label>
          <input type="text" name="nom" class="form-control" placeholder="Dupont" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label"><i class="bi bi-person"></i>Prénom</label>
          <input type="text" name="prenom" class="form-control" placeholder="Marie" required>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label"><i class="bi bi-envelope-fill"></i>Email</label>
          <input type="email" name="email" class="form-control" placeholder="exemple@email.com" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label"><i class="bi bi-telephone-fill"></i>Téléphone</label>
          <input type="tel" name="telephone" class="form-control" placeholder="06 12 34 56 78">
        </div>
      </div>

      <div class="form-section">
        <div class="section-title">Informations professionnelles</div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-briefcase-fill"></i>Profession</label>
            <input type="text" name="profession" class="form-control" placeholder="Avocat, artisan..." required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-building"></i>Société</label>
            <input type="text" name="societe" class="form-control" placeholder="Nom de l’entreprise">
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-diagram-3-fill"></i>Statut</label>
            <select name="statut" class="form-select" required>
              <option value="Prospect">Prospect</option>
              <option value="En cours">En cours</option>
              <option value="Gagné">Gagné</option>
              <option value="Perdu">Perdu</option>
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-globe"></i>Origine du contact</label>
            <select name="origine" class="form-select">
              <option value="Site web">Site web</option>
              <option value="Réseau">Réseau</option>
              <option value="Appel">Appel entrant</option>
              <option value="Autre">Autre</option>
            </select>
          </div>
        </div>
      </div>

      <div class="form-section">
        <div class="section-title">Notes et remarques</div>
        <div class="mb-3">
          <label class="form-label"><i class="bi bi-journal-text"></i>Notes</label>
          <textarea name="notes" class="form-control" rows="3" placeholder="Ajoutez des détails, préférences, historique..."></textarea>
        </div>
      </div>

      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-primary py-2">
          <i class="bi bi-save me-1"></i> Enregistrer la fiche
        </button>
      </div>
    </form>
  </div>

</body>
</html>

