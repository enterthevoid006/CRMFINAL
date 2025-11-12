<?php
  // Détection de la page active
  $currentPage = $_GET['page'] ?? 'dashboard';
?>
<aside class="ordex-sidebar <?= $currentPage === 'pipeline' ? 'sidebar-pipeline' : '' ?>" data-state="expanded" aria-label="Navigation principale">
  <div class="sb-brand">
    <a href="index.php?page=dashboard" class="brand-link">
      <div class="brand-logo">OX</div>
      <div class="brand-text">
        <strong>Ordex</strong><span>CRM</span>
      </div>
    </a>
    <button class="sb-toggle" type="button" aria-label="Réduire le menu">
      <i class="bi bi-layout-sidebar-inset"></i>
    </button>
  </div>

  <nav class="sb-nav">
    <a href="index.php?page=dashboard" class="sb-link <?= $currentPage==='dashboard' ? 'active' : '' ?>">
      <i class="bi bi-speedometer2"></i><span>Tableau de bord</span>
    </a>
    <a href="index.php?page=taches" class="sb-link <?= $currentPage==='taches' ? 'active' : '' ?>">
      <i class="bi bi-list-check"></i><span>Tâches du jour</span>
    </a>
    <a href="index.php?page=pipeline" class="sb-link <?= $currentPage==='pipeline' ? 'active' : '' ?>">
      <i class="bi bi-kanban"></i><span>Pipeline / Clients</span>
    </a>
    <a href="index.php?page=contacts" class="sb-link <?= $currentPage==='contacts' ? 'active' : '' ?>">
      <i class="bi bi-people"></i><span>Contacts</span>
    </a>
    <a href="index.php?page=agenda" class="sb-link <?= $currentPage==='agenda' ? 'active' : '' ?>">
      <i class="bi bi-calendar3"></i><span>Agenda</span>
    </a>
    <a href="index.php?page=mails" class="sb-link <?= $currentPage==='mails' ? 'active' : '' ?>">
      <i class="bi bi-envelope"></i><span>Mails</span>
    </a>
  </nav>

  <div class="sb-footer">
    <a href="index.php?page=settings" class="sb-link sb-mini <?= $currentPage==='settings' ? 'active' : '' ?>">
      <i class="bi bi-gear"></i><span>Paramètres</span>
    </a>
    <a href="index.php?page=logout" class="sb-link sb-mini <?= $currentPage==='logout' ? 'active' : '' ?>">
      <i class="bi bi-box-arrow-right"></i><span>Déconnexion</span>
    </a>
  </div>
</aside>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
  :root {
    --sb-w: 240px;
    --sb-w-collapsed: 84px;
    --sb-bg: linear-gradient(180deg,#0b1020 0%,#0f172a 70%,#0b1020 100%);
    --sb-border: rgba(255,255,255,.08);
    --txt: #e5e7eb;
    --muted: #94a3b8;
    --brand-grad: linear-gradient(135deg,#1d4ed8,#06b6d4);
    --active: #60a5fa;
    --hover: rgba(255,255,255,.06);
  }

  body { background: var(--sb-bg); }

  .ordex-sidebar {
    position: fixed;
    inset: 0 auto 0 0;
    width: var(--sb-w);
    background: linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.03));
    backdrop-filter: blur(12px);
    border-right: 1px solid var(--sb-border);
    box-shadow: 8px 0 30px rgba(0,0,0,.28);
    color: var(--txt);
    display: grid;
    grid-template-rows: auto 1fr auto;
    gap: 10px;
    padding: 14px 12px;
    z-index: 1000;
    transition: width .25s ease;
  }
  .ordex-sidebar[data-state="collapsed"] { width: var(--sb-w-collapsed); }

  .sb-brand {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    padding: 6px 4px 10px;
  }
  .brand-link {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    color: var(--txt);
  }
  .brand-logo {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: grid;
    place-items: center;
    font-weight: 900;
    background: var(--brand-grad);
    color: #fff;
    letter-spacing: 1px;
    box-shadow: 0 10px 26px rgba(59,130,246,.35);
  }
  .brand-text strong { display: block; letter-spacing: .6px; }
  .brand-text span { display: block; color: var(--muted); font-size: .85rem; margin-top: -2px; }

  .sb-toggle {
    border: 1px solid var(--sb-border);
    background: transparent;
    color: var(--txt);
    border-radius: 10px;
    padding: 8px 10px;
    cursor: pointer;
    transition: background .2s ease, transform .2s ease;
  }
  .sb-toggle:hover { background: var(--hover); transform: translateY(-1px); }

  .sb-nav { display: flex; flex-direction: column; gap: 6px; margin-top: 6px; }
  .sb-link {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    color: var(--txt);
    padding: 10px 12px;
    border-radius: 12px;
    border: 1px solid transparent;
    transition: background .2s ease, border-color .2s ease, transform .15s ease;
  }
  .sb-link i { font-size: 1.1rem; width: 22px; text-align: center; color: #cbd5e1; }
  .sb-link span { white-space: nowrap; }
  .sb-link:hover { background: var(--hover); transform: translateX(2px); }
  .sb-link.active {
    background: rgba(96,165,250,.12);
    border-color: rgba(96,165,250,.35);
    box-shadow: 0 6px 18px rgba(59,130,246,.22) inset, 0 6px 20px rgba(59,130,246,.15);
  }
  .sb-link.active i { color: var(--active); }

  .sb-footer {
    margin-top: auto;
    display: flex;
    flex-direction: column;
    gap: 6px;
    padding-top: 6px;
    border-top: 1px solid var(--sb-border);
  }

  /* 📱 Masquer la sidebar sur smartphone UNIQUEMENT dans la vue pipeline */
  @media (max-width: 768px) {
    .sidebar-pipeline {
      display: none !important;
    }
  }
</style>

<script>
  (function(){
    const sb = document.querySelector('.ordex-sidebar');
    const btn = sb?.querySelector('.sb-toggle');
    if (!sb || !btn) return;

    sb.querySelectorAll('.sb-link').forEach(link=>{
      const label = link.querySelector('span')?.textContent?.trim();
      if(label) link.setAttribute('data-title', label);
    });

    btn.addEventListener('click', ()=>{
      const state = sb.getAttribute('data-state');
      sb.setAttribute('data-state', state === 'collapsed' ? 'expanded' : 'collapsed');
      btn.setAttribute('aria-expanded', sb.getAttribute('data-state') === 'expanded');
    });
  })();
</script>




