<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion — Ordex CRM</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- ✅ Lien absolu vers Bootstrap (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- ✅ Style principal (ton style custom local) -->
  <link rel="stylesheet" href="/phpcrm-main/assets/css/style.css">
  
  <style>
  body {
    margin: 0;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: radial-gradient(1200px 600px at 80% 8%, rgba(59,130,246,.25), transparent 60%) , 
                linear-gradient(180deg, #0b1020 0%, #0f172a 60%, #0b1020 100%);
    color: #e5e7eb;
    font-family: Inter, system-ui, sans-serif;
  }

  .login-card {
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 16px;
    padding: 2.5rem;
    width: 100%;
    max-width: 380px;
    box-shadow: 0 10px 30px rgba(0,0,0,.4);
  }

  .login-card h1 {
    text-align: center;
    margin-bottom: 1.5rem;
    font-weight: 700;
  }

  .form-control {
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.15);
    color: #fff;
  }

  .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 .2rem rgba(59,130,246,.35);
  }

  .btn-gradient {
    background: linear-gradient(90deg, #3b82f6, #0ea5e9);
    border: none;
    color: #fff;
    font-weight: 700;
    border-radius: 12px;
    width: 100%;
  }

  .btn-gradient:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 22px rgba(59,130,246,.45);
  }
  </style>
</head>
<body>

  <div class="login-card">
    <h1><i class="bi bi-lock-fill"></i> Connexion</h1>

    <form method="post" action="index.php?page=login">
      <div class="mb-3">
        <label class="form-label">Nom d'utilisateur</label>
        <input type="text" name="username" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Mot de passe</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-gradient mt-2">Se connecter</button>
    </form>
  </div>

</body>
</html>

