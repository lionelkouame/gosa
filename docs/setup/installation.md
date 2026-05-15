# Installation

## Prérequis

- Docker >= 26
- Docker Compose >= 2.20
- Make

---

## Lancer le projet

```bash
# 1. Cloner le dépôt
git clone <url> gosa && cd gosa

# 2. Copier les variables d'environnement
cp .env.example .env

# 3. Démarrer les conteneurs
make up

# 4. Installer les dépendances PHP
make install

# 5. Vérifier que tout fonctionne
make ci
```

L'application est disponible sur [https://localhost](https://localhost)

---

## Commandes disponibles

| Commande | Description |
|----------|-------------|
| `make up` | Démarrer tous les conteneurs |
| `make down` | Arrêter les conteneurs |
| `make shell` | Ouvrir un shell dans le conteneur app |
| `make install` | Installer les dépendances Composer |
| `make test` | Lancer tous les tests |
| `make test-unit` | Tests unitaires uniquement |
| `make test-integration` | Tests d'intégration uniquement |
| `make coverage` | Rapport de couverture HTML dans `var/coverage/` |
| `make lint` | Vérifier le style de code (dry-run) |
| `make fix` | Corriger le style de code automatiquement |
| `make stan` | Analyse statique PHPStan (level max) |
| `make ci` | lint + stan + test (pipeline complet) |
