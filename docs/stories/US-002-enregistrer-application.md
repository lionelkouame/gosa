# US-002 — Enregistrer une application dans la galaxie

**Statut :** À faire
**Priorité :** Haute — premier use case métier

---

## Story

En tant que **Contributeur**,
je veux enregistrer une application avec son nom, sa catégorie de domaine, son dépôt Git et sa version initiale,
afin que l'application existe dans la galaxie à l'état `Draft`.

---

## Critères d'acceptance

- [ ] Une application est créée avec le statut `Draft`
- [ ] Le nom est unique — si un doublon existe → `ApplicationAlreadyExists`
- [ ] La version respecte SemVer (`x.y.z`) — sinon → `InvalidVersion`
- [ ] L'URL Git commence par `https://` — sinon → `InvalidRepository`
- [ ] L'événement `ApplicationRegistered` est émis après l'enregistrement
- [ ] Tous les Value Objects rejettent les valeurs vides ou invalides à la construction

---

## Composants à implémenter

### Domain
- `ApplicationId` — Value Object (UUID)
- `ApplicationName` — Value Object
- `DomainCategory` — Value Object (enum backed string)
- `Status` — Value Object (enum backed string)
- `Version` — Value Object (SemVer)
- `Repository` — Value Object (GitUrl + LicenseType)
- `Application` — Aggregate Root
- `ApplicationRegistered` — Domain Event
- `ApplicationAlreadyExists` — Domain Exception
- `ApplicationRepositoryInterface` — Port sortant
- `EventPublisherInterface` — Port sortant

### Application
- `RegisterApplicationCommand` — DTO
- `RegisterApplicationHandler` — Handler

### Infrastructure (pour les tests)
- `InMemoryApplicationRepository` — Adapter de test

### Tests
- Tests unitaires de chaque Value Object
- Test unitaire de l'Aggregate `Application`
- Test du Handler `RegisterApplicationHandler`

---

## Ordre d'implémentation recommandé

1. Value Objects (Domain) + leurs tests unitaires
2. Domain Events
3. Exceptions métier
4. Ports (interfaces)
5. Aggregate `Application` + test
6. Command + Handler
7. `InMemoryApplicationRepository`
8. Test d'intégration du Handler
