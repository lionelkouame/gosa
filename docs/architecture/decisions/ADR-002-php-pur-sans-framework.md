# ADR-002 — PHP pur sans framework applicatif

**Date :** 2026-05-15
**Statut :** Accepté

---

## Contexte

La majorité des projets PHP s'appuient sur Symfony ou Laravel. Ces frameworks apportent de la productivité mais couplent le code au framework dès les premières lignes.

## Décision

GOSA est écrit en **PHP pur** — aucun framework dans les couches Domain et Application.

## Justification

- Le domaine ne doit dépendre de **rien** — c'est la règle fondamentale de la Clean Architecture
- Aucun `Container`, `Request`, `Response` ou annotation de framework dans `src/`
- Les adapters d'infrastructure peuvent utiliser des librairies tierces (PDO, Guzzle…) mais restent derrière des Ports
- Les tests unitaires du domaine s'exécutent **sans aucun bootstrap** d'infrastructure

## Conséquences

- Routing, DI container, HTTP kernel : écrits à la main ou via des micro-librairies
- Courbe d'entrée plus haute — compréhension fine de l'architecture requise
- Portabilité maximale : le domaine peut être réutilisé dans n'importe quel contexte
