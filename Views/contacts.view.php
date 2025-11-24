<style>
/* --- BASE STYLES & LAYOUT --- */
.contacts-wrapper {
  padding: 2rem 1.5rem;
  min-height: 100vh;
  /* Palette sombre inspirée par Tailwind CSS dark mode */
  background: #0f172a; 
  color: #e5e7eb;
  font-family: 'Inter', sans-serif;
}
a {
    text-decoration: none;
}

/* --- HEADER & ACTIONS --- */
.contacts-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
  flex-wrap: wrap;
  gap: 1.5rem;
}
.contacts-title {
  display: flex;
  align-items: center;
  gap: 12px;
}
.contacts-title i {
  font-size: 2rem;
  color: #3b82f6; /* Blue 500 */
}
.contacts-title h1 {
  font-size: 2rem;
  font-weight: 700;
  margin: 0;
}

/* Search bar design */
.contacts-actions {
  display: flex;
  align-items: center;
  gap: 1rem;
}
.contacts-search {
  display: flex;
  align-items: center;
  background: #1e293b; /* Slate 800 */
  border: 1px solid #334155; /* Slate 700 */
  border-radius: 0.75rem; /* rounded-xl */
  overflow: hidden;
  transition: all .25s ease;
}
.contacts-search input {
  background: transparent;
  border: none;
  outline: none;
  padding: 10px 16px;
  color: #e5e7eb;
  width: 280px;
}
.contacts-search input::placeholder {
    color: #94a3b8;
}
.contacts-search button {
  background: #1e293b;
  border: none;
  color: #94a3b8;
  padding: 10px 16px;
  cursor: pointer;
  transition: color .2s;
  height: 100%;
}
.contacts-search button:hover { color: #60a5fa; }

/* Create button design */
.btn-create {
  background: linear-gradient(135deg, #3b82f6, #06b6d4); /* Blue 500 to Cyan 500 */
  color: white;
  text-decoration: none;
  padding: 10px 18px;
  border-radius: 0.75rem;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 8px;
  box-shadow: 0 5px 15px rgba(59,130,246,.4);
  transition: transform .2s, box-shadow .2s;
  white-space: nowrap;
}
.btn-create:hover {
  transform: translateY(-1px);
  box-shadow: 0 8px 20px rgba(59,130,246,.55);
}

/* --- FILTER TABS (NEW) --- */
.contacts-filters {
    margin-bottom: 2rem;
    border-bottom: 2px solid #1e293b;
    display: flex;
    overflow-x: auto;
}
.filter-tab {
    padding: 10px 15px;
    color: #94a3b8;
    font-weight: 500;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    transition: all .2s;
    white-space: nowrap;
}
.filter-tab:hover {
    color: #cbd5e1;
}
.filter-tab.active {
    color: #3b82f6;
    border-bottom-color: #3b82f6;
    font-weight: 600;
}
/* Adjust specific tab colors */
.filter-tab[data-status="prospect"].active { border-bottom-color: #f59e0b; color: #f59e0b; } /* Amber */
.filter-tab[data-status="client"].active { border-bottom-color: #10b981; color: #10b981; } /* Emerald */
.filter-tab[data-status="fermé"].active { border-bottom-color: #ef4444; color: #ef4444; } /* Red */
.filter-tab[data-status="tous"].active { border-bottom-color: #3b82f6; color: #3b82f6; } /* Default Blue */


/* --- GRID / CARD LAYOUT --- */
.contacts-grid {
  display: grid;
  /* Responsive grid: min 300px width per card */
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
}

/* --- CARD DESIGN (REDESIGNED) --- */
.contact-card {
  background: #1e293b; /* Slate 800 */
  border: 1px solid #334155; /* Slate 700 */
  border-radius: 1rem; /* rounded-xl */
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  transition: all .3s ease;
  box-shadow: 0 5px 20px rgba(0,0,0,.4);
}
.contact-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 25px rgba(0,0,0,.5), 0 0 10px rgba(59,130,246,.2);
  border-color: #3b82f6;
}

/* Card Header: Avatar + Main Info */
.card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
    border-bottom: 1px dashed #334155;
    padding-bottom: 1rem;
}
.avatar {
  width: 56px;
  height: 56px;
  min-width: 56px; /* Fix width in flex layout */
  border-radius: 50%;
  /* Gradient pour l'avatar */
  background: linear-gradient(135deg, #1d4ed8, #60a5fa); 
  display: grid;
  place-items: center;
  color: white;
  font-weight: 700;
  font-size: 1.3rem;
  box-shadow: 0 4px 10px rgba(0,0,0,.3);
}
.contact-main-info h3 {
  font-size: 1.25rem;
  margin: 0;
  color: #f1f5f9;
  line-height: 1.2;
}
.contact-main-info .societe {
  font-size: 0.95rem;
  color: #94a3b8;
  margin-top: 4px;
}
.contact-main-info .societe i {
    color: #60a5fa;
    margin-right: 4px;
}

/* Card Details */
.card-details {
    margin-top: 1rem;
    flex-grow: 1; /* Pousse les actions vers le bas */
}
.card-details p {
    margin: 0.4rem 0;
    font-size: 0.9rem;
    color: #cbd5e1;
    display: flex;
    align-items: center;
}
.card-details p i {
    color: #60a5fa;
    margin-right: 8px;
    width: 20px;
    text-align: center;
}
.card-details .email {
    color: #94a3b8;
}

/* Status Pill */
.statut {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 10px;
  border-radius: 9999px; /* Full rounded */
  font-size: .8rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-top: 0.75rem;
}
.statut i {
    font-size: 0.5rem;
}
.statut.prospect { background: rgba(245,158,11,.15); color: #f59e0b; } /* Amber */
.statut.client { background: rgba(16,185,129,.15); color: #10b981; } /* Emerald */
.statut.fermé { background: rgba(239,68,68,.15); color: #ef4444; } /* Red */
.statut.autre { background: rgba(148,163,184,.15); color: #94a3b8; } /* Slate (Fallback) */


/* Actions */
.card-actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 1rem;
  margin-top: 1.5rem;
  border-top: 1px solid #334155; /* Slate 700 */
}
.actions-group a {
  background: #334155;
  color: #94a3b8;
  padding: 8px 10px;
  border-radius: 8px;
  margin-left: 8px;
  transition: all .2s ease;
  display: inline-flex;
  align-items: center;
}
.actions-group a:hover { 
    color: white; 
    background: #3b82f6; 
}
.actions-group a:first-child { margin-left: 0; }
.actions-group i {
    font-size: 1.1rem;
}

/* --- NO RESULTS --- */
.no-results {
  text-align: center;
  margin-top: 5rem;
  color: #94a3b8;
  padding: 2rem;
  border: 2px dashed #334155;
  border-radius: 1rem;
  grid-column: 1 / -1; /* Centrer dans le grid */
}
.no-results i {
  font-size: 3rem;
  margin-bottom: 1rem;
  color: #475569;
}
.no-results p {
    font-size: 1.1rem;
    margin: 0;
}

/* --- MEDIA QUERIES --- */
@media (max-width: 768px) {
    .contacts-wrapper {
        padding: 1.5rem;
    }
    .contacts-header {
        flex-direction: column;
        align-items: flex-start;
    }
    .contacts-actions {
        width: 100%;
        flex-direction: column;
        gap: 10px;
    }
    .contacts-search {
        width: 100%;
    }
    .contacts-search input {
        width: 100%;
    }
    .btn-create {
        width: 100%;
        justify-content: center;
    }
}
</style>

<!-- Assurez-vous d'avoir les icônes Bootstrap (ou équivalent) chargées -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> -->


<?php
// PHP logic to handle current filters
$current_search = htmlspecialchars($_GET['search'] ?? '');
$current_statut = htmlspecialchars(strtolower($_GET['statut'] ?? 'tous'));

// Fonction utilitaire pour générer l'URL de filtre
function getFilterUrl($statut, $search) {
    $url = "index.php?page=contacts";
    if ($statut && $statut !== 'tous') {
        $url .= "&statut=" . urlencode($statut);
    }
    if ($search) {
        $url .= "&search=" . urlencode($search);
    }
    return $url;
}

// Fonction utilitaire pour obtenir la couleur de statut
function getStatutClass($statut) {
    $status = strtolower($statut);
    if (in_array($status, ['prospect', 'client', 'fermé'])) {
        return $status;
    }
    return 'autre';
}

$statut_options = ['tous', 'prospect', 'client', 'fermé'];
?>

<main class="contacts-wrapper">
  <header class="contacts-header">
    <div class="contacts-title">
      <i class="bi bi-people-fill"></i>
      <h1>Gestion des Contacts (<?= $contacts->num_rows ?? 0 ?>)</h1>
    </div>

    <div class="contacts-actions">
      <!-- Search Form -->
      <form method="get" action="index.php" class="contacts-search">
        <input type="hidden" name="page" value="contacts">
        <input 
          type="text" 
          name="search" 
          placeholder="Rechercher nom, email, société..." 
          value="<?= $current_search ?>" 
        />
        <button type="submit" title="Rechercher"><i class="bi bi-search"></i></button>
      </form>

      <!-- Create Button -->
      <a href="index.php?page=creer_contact" class="btn-create">
        <i class="bi bi-person-plus-fill"></i> Nouveau contact
      </a>
    </div>
  </header>

  <!-- NOUVEAU: Barres de Filtres de Statut (UX amélioré) -->
  <nav class="contacts-filters">
    <?php foreach ($statut_options as $statut): 
        $display_name = ucfirst($statut);
        $isActive = ($current_statut === $statut) || ($current_statut === '' && $statut === 'tous');
    ?>
        <a 
          href="<?= getFilterUrl($statut, $current_search) ?>"
          class="filter-tab <?= $isActive ? 'active' : '' ?>"
          data-status="<?= $statut ?>"
        >
          <?= $display_name ?>
        </a>
    <?php endforeach; ?>
  </nav>
  

  <section class="contacts-grid">
    <?php if ($contacts->num_rows > 0): ?>
      <?php while ($c = $contacts->fetch_assoc()): 
        $firstNameInitial = strtoupper(substr($c['prenom'] ?? '?', 0, 1));
        $lastNameInitial = strtoupper(substr($c['nom'] ?? '?', 0, 1));
        $initials = $firstNameInitial . $lastNameInitial;
        $statutClass = getStatutClass($c['statut'] ?? 'Autre');
      ?>
        <article class="contact-card">
          <div class="card-header">
            <div class="avatar"><?= $initials ?></div>
            <div class="contact-main-info">
              <h3><?= htmlspecialchars($c['prenom'] . ' ' . $c['nom']) ?></h3>
              <p class="societe"><i class="bi bi-building"></i> <?= htmlspecialchars($c['societe'] ?? '—') ?></p>
            </div>
          </div>
          
          <div class="card-details">
            <p class="email"><i class="bi bi-envelope-fill"></i> <?= htmlspecialchars($c['email']) ?></p>
            <p class="phone"><i class="bi bi-phone-fill"></i> <?= htmlspecialchars($c['telephone'] ?? 'Non renseigné') ?></p>
            <p class="date"><i class="bi bi-calendar-event"></i> Créé le: <?= date('d/m/Y', strtotime($c['date_creation'] ?? 'now')) ?></p>

            <span class="statut <?= $statutClass ?>">
              <i class="bi bi-circle-fill"></i> <?= htmlspecialchars($c['statut'] ?? 'Autre') ?>
            </span>
          </div>

          <div class="card-actions">
            <!-- Action buttons -->
            <div class="actions-group">
              <a href="index.php?page=fiche&id=<?= $c['id'] ?>" title="Ouvrir la fiche" aria-label="Voir la fiche complète">
                <i class="bi bi-eye"></i>
              </a>
              <a href="mailto:<?= $c['email'] ?>" title="Envoyer un mail" aria-label="Envoyer un email">
                <i class="bi bi-envelope-open"></i>
              </a>
              <!-- Bouton de suppression (nécessite du JS pour le côté dynamique) -->
              <a href="#" class="delete-contact" data-id="<?= $c['id'] ?>" title="Supprimer le contact" aria-label="Supprimer">
                <i class="bi bi-trash3"></i>
              </a>
            </div>
            
            <a href="index.php?page=fiche&id=<?= $c['id'] ?>" class="btn-link" title="Détails">
                Détails <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </article>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="no-results">
        <i class="bi bi-person-x-fill"></i>
        <p>Aucun contact trouvé pour cette recherche ou ce filtre.</p>
        <p>Essayez de réinitialiser la recherche ou de changer de statut.</p>
      </div>
    <?php endif; ?>
  </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // NOUVEAU: Gestion des clics de suppression via JavaScript (simuler le dialogue)
    const deleteButtons = document.querySelectorAll('.delete-contact');

    deleteButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const contactId = e.currentTarget.getAttribute('data-id');
            const contactCard = e.currentTarget.closest('.contact-card');
            
            // Remplacer window.confirm() par un message d'alerte simulé ou un modal si possible
            if (confirm(`Êtes-vous sûr de vouloir supprimer le contact ID ${contactId} ?`)) {
                // Simuler l'appel AJAX de suppression
                console.log(`[ACTION] Suppression du contact ${contactId} demandée.`);
                
                // Ici, vous feriez une requête fetch ou XHR vers votre endpoint de suppression (ex: index.php?page=delete&id=...)
                // Exemple de requête (à décommenter et adapter) :
                /*
                fetch(`index.php?page=delete_contact&id=${contactId}`, { method: 'POST' })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            contactCard.remove(); // Supprime visuellement la carte
                            // Mettre à jour le compteur de contacts si besoin
                        } else {
                            alert('Erreur lors de la suppression: ' + (data.message || 'Erreur inconnue'));
                        }
                    })
                    .catch(error => console.error('Erreur réseau:', error));
                */

                // Pour l'exemple, nous allons juste masquer la carte après un court délai
                contactCard.style.opacity = '0.5';
                contactCard.style.pointerEvents = 'none';
                setTimeout(() => {
                   // contactCard.remove(); // Décommenter pour une suppression visuelle immédiate
                }, 500);
            }
        });
    });

    // Optionnel: Maintenir le paramètre de recherche dans l'URL lors du changement de statut
    const filterTabs = document.querySelectorAll('.filter-tab');
    const searchInput = document.querySelector('.contacts-search input[name="search"]');

    filterTabs.forEach(tab => {
        tab.addEventListener('click', (e) => {
            e.preventDefault();
            let href = e.currentTarget.href;
            const searchValue = searchInput.value.trim();

            if (searchValue) {
                // Ajoute le paramètre de recherche à l'URL du filtre
                if (href.includes('?')) {
                    href += `&search=${encodeURIComponent(searchValue)}`;
                } else {
                    href += `?search=${encodeURIComponent(searchValue)}`;
                }
            }
            window.location.href = href;
        });
    });
});
</script>
