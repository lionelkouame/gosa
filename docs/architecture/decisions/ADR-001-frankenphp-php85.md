# ADR-001 — FrankenPHP + PHP 8.5 comme serveur d'application

**Date :** 2026-05-15
**Statut :** Accepté

---

## Contexte

GOSA est un projet PHP pur sans framework. Il faut choisir un serveur d'application capable de servir du PHP moderne en développement et en production.

## Décision

Utilisation de **FrankenPHP** (basé sur Caddy) avec **PHP 8.5**.

## Justification

| Critère | Raison |
|---------|--------|
| PHP pur | FrankenPHP ne force aucun framework |
| Performance | Worker mode : le processus PHP persiste entre les requêtes |
| HTTPS automatique | Caddy gère les certificats TLS sans configuration |
| PHP 8.5 | Dernière version stable — typage strict maximal, enums, fibers |
| Image officielle | `dunglas/frankenphp` maintenu par Kévin Dunglas (core Symfony) |

## Conséquences

- Pas de Nginx ni PHP-FPM séparés
- Le `Caddyfile` est géré par FrankenPHP
- En worker mode (prod) : les classes PHP sont chargées une seule fois
