# Architecture — Vue d'ensemble

## Principes fondamentaux

GOSA est construit sur trois piliers sans concession :

| Pilier | Description |
|--------|-------------|
| **Clean Architecture** | Le domaine ne dépend de rien. L'infrastructure dépend du domaine. |
| **Domain-Driven Design** | Le code reflète le langage métier. Ubiquitous Language strict. |
| **Architecture Hexagonale** | Le domaine est au centre. Tout accès externe passe par un Port. |

---

## La règle de dépendance

```
UI / Infra / Framework
        ↓
  Application (Use Cases)
        ↓
     Domain (cœur)
```

**Jamais vers le haut.** Le domaine ne connaît ni PDO, ni HTTP, ni aucun framework.

---

## Structure des couches

### Domain
- Aggregates, Entities, Value Objects
- Domain Events
- Ports (interfaces sortantes)
- Exceptions métier
- **Zéro dépendance externe**

### Application
- Commands + Handlers (écriture)
- Queries + Handlers (lecture)
- Orchestre le domaine, ne contient pas de logique métier

### Infrastructure
- Adapters des Ports (PDO, fichiers, APIs tierces)
- Implémentations techniques

### UI (à venir)
- HTTP (entrée web)
- CLI (console)
- Ces couches appellent les handlers applicatifs

---

## Bounded Contexts

Voir [bounded-contexts.md](./bounded-contexts.md)

---

## Décisions d'architecture (ADR)

Voir [decisions/](./decisions/)
