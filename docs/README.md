# Documentation GOSA

**G**alaxie **O**pen **S**ource **A**pplication

---

## Structure

```
docs/
├── architecture/
│   ├── overview.md              Architecture hexagonale — règles et couches
│   ├── bounded-contexts.md      Carte des contextes délimités
│   └── decisions/
│       ├── ADR-001-frankenphp-php85.md
│       └── ADR-002-php-pur-sans-framework.md
│
├── domain/
│   ├── glossaire.md             Ubiquitous Language — termes métier ↔ code
│   └── application-registry.md  Domain model du contexte core
│
├── setup/
│   ├── installation.md          Démarrer le projet
│   └── development.md           Règles et patterns de développement
│
└── stories/
    ├── US-001-setup.md                     Environnement de développement
    └── US-002-enregistrer-application.md   Premier use case métier
```

---

## Par où commencer ?

1. [Architecture](./architecture/overview.md) — comprendre les règles
2. [Glossaire](./domain/glossaire.md) — parler le même langage
3. [Installation](./setup/installation.md) — lancer le projet
4. [US-001](./stories/US-001-setup.md) — ce qui est fait
5. [US-002](./stories/US-002-enregistrer-application.md) — prochaine étape
