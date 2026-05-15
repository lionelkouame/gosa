## Issue #4 — Symfony UX Backoffice

GitHub: https://github.com/lionelkouame/gosa/issues/4

Stack: AssetMapper + Twig + UX Turbo + UX Live Component + UX Chart.js + Tailwind + ROLE_ADMIN

Routes:
  GET  /login              public
  GET  /backoffice         dashboard (ROLE_ADMIN)
  GET  /backoffice/applications
  GET  /backoffice/galaxies

Packages:
  symfony/asset-mapper symfony/asset symfony/twig-bundle
  symfony/ux-turbo symfony/ux-live-component
  symfony/ux-twig-component symfony/ux-chartjs
  symfony/security-bundle symfony/form
