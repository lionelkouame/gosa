# Bounded Contexts

## Carte des contextes

```
┌─────────────────────────────────────────────────────┐
│                    GOSA Platform                    │
│                                                     │
│  ┌──────────────────────────┐                       │
│  │   ApplicationRegistry    │  ← Contexte CORE      │
│  │  (gestion de la galaxie) │                       │
│  └──────────────┬───────────┘                       │
│                 │ Domain Events                     │
│        ┌────────┴────────┐                          │
│        ▼                 ▼                          │
│  ┌──────────┐     ┌──────────────┐                  │
│  │ Booking  │     │  E-Commerce  │  ← Futurs BC     │
│  └──────────┘     └──────────────┘                  │
└─────────────────────────────────────────────────────┘
```

---

## ApplicationRegistry (Contexte Core)

**Responsabilité :** Gérer le cycle de vie des applications de la galaxie.

| Élément | Valeur |
|---------|--------|
| Namespace | `Gosa\ApplicationRegistry` |
| Chemin | `src/ApplicationRegistry/` |
| Statut | En développement |

### Aggregate Root
- `Application` — représente un domaine métier autonome dans la galaxie

### Événements produits
- `ApplicationRegistered`
- `ApplicationPublished`
- `ApplicationArchived`
- `ApplicationDeprecated`
- `NewVersionReleased`

---

## Règles d'intégration entre contextes

- Les contextes communiquent **uniquement via Domain Events** — jamais par appel direct
- Chaque contexte possède son propre modèle de données — pas de table partagée
- Un Anti-Corruption Layer (ACL) protège le Core des autres contextes
