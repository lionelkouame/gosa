# US-001 — Setup de l'environnement de développement

**Statut :** Terminée
**Priorité :** Fondatrice

---

## Story

En tant que **développeur**,
je veux un environnement de développement Docker complet et reproductible,
afin de pouvoir démarrer le projet sur n'importe quelle machine en une commande.

---

## Critères d'acceptance

- [ ] `make up` démarre FrankenPHP + PostgreSQL sans erreur
- [ ] `make install` installe les dépendances Composer dans le conteneur
- [ ] `make test` exécute la suite de tests (vide au départ, aucune erreur)
- [ ] `make stan` passe PHPStan level max sur `src/`
- [ ] `make lint` vérifie le style sans erreur
- [ ] `make ci` enchaîne lint + stan + test en une commande
- [ ] La structure hexagonale `src/ApplicationRegistry/{Domain,Application,Infrastructure}` est en place
- [ ] Le namespace `Gosa\ApplicationRegistry` est résolu via PSR-4

---

## Périmètre technique

| Élément | Choix |
|---------|-------|
| Serveur | FrankenPHP 1.x |
| PHP | 8.5 |
| Base de données | PostgreSQL 17 |
| Tests | PHPUnit 12 |
| Analyse statique | PHPStan level max |
| Style de code | PHP CS Fixer (PER-CS + strict_types) |

---

## Fichiers créés

```
Dockerfile
docker-compose.yml
composer.json
phpunit.xml
phpstan.neon
.php-cs-fixer.php
Makefile
.env.example
.gitignore
public/index.php
src/ApplicationRegistry/Domain/
src/ApplicationRegistry/Application/
src/ApplicationRegistry/Infrastructure/
tests/Unit/
tests/Integration/
docs/
```
