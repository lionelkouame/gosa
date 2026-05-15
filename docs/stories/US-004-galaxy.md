# US-004 — Implement the Galaxy concept

**Status:** To do
**Priority:** High

---

## Story

As a **contributor**,
I want to create galaxies and group open source applications inside them,
so that users can discover applications by thematic collection.

---

## Domain decision

**1 Application → N Galaxies** (many-to-many).
An application can appear in multiple galaxies. A galaxy owns the relationship — it holds a collection of `ApplicationId` references, not full `Application` objects (aggregates never hold references to other aggregates directly).

---

## Aggregate — `Galaxy`

```
Galaxy (Aggregate Root)
├── GalaxyId          Value Object — UUID v4, immutable
├── GalaxyName        Value Object — unique across all galaxies, non-empty
├── GalaxyDescription Value Object — optional text
├── Status            Value Object — enum: Draft | Published | Archived
├── ApplicationIds    Collection<ApplicationId> — references to ApplicationRegistry
└── Domain Events
    ├── GalaxyCreated
    ├── GalaxyPublished
    ├── GalaxyArchived
    ├── ApplicationAddedToGalaxy
    └── ApplicationRemovedFromGalaxy
```

---

## Business rules (invariants)

1. `GalaxyName` must be **unique** — checked via `GalaxyRepositoryInterface`
2. A Galaxy requires **at least 1 application** to transition `Draft → Published`
3. Status transitions allowed:
   ```
   Draft → Published
   Published → Archived
   ```
   Any other transition raises `InvalidGalaxyStatusTransition`
4. An `ApplicationId` already in the Galaxy raises `ApplicationAlreadyInGalaxy`
5. Removing an `ApplicationId` not in the Galaxy raises `ApplicationNotInGalaxy`
6. Removing an application from a Galaxy does **not** delete the application

---

## Cross-context communication

GalaxyRegistry must verify that an `ApplicationId` exists before adding it.
This is done via an **Anti-Corruption Layer** port — not by importing ApplicationRegistry directly.

```
GalaxyRegistry/Domain/Port/ApplicationExistenceCheckerInterface.php

interface ApplicationExistenceCheckerInterface {
    public function exists(ApplicationId $id): bool;
}
```

Implemented in Infrastructure by querying the ApplicationRegistry repository.

---

## Ports

```php
interface GalaxyRepositoryInterface
{
    public function save(Galaxy $galaxy): void;
    public function findById(GalaxyId $id): ?Galaxy;
    public function findByName(GalaxyName $name): ?Galaxy;
    public function findAll(): array;
}
```

---

## Use cases

| Use Case | Actor | Event produced |
|---|---|---|
| `CreateGalaxy` | Admin | GalaxyCreated |
| `PublishGalaxy` | Admin | GalaxyPublished |
| `ArchiveGalaxy` | Admin | GalaxyArchived |
| `AddApplicationToGalaxy` | Contributor | ApplicationAddedToGalaxy |
| `RemoveApplicationFromGalaxy` | Admin | ApplicationRemovedFromGalaxy |
| `GetGalaxyById` | All | — |
| `BrowseGalaxies` | All | — |

---

## Target directory structure

```
src/
    GalaxyRegistry/
        Domain/
            Model/
                Galaxy.php
            ValueObject/
                GalaxyId.php
                GalaxyName.php
                GalaxyDescription.php
                GalaxyStatus.php
            Event/
                GalaxyCreated.php
                GalaxyPublished.php
                GalaxyArchived.php
                ApplicationAddedToGalaxy.php
                ApplicationRemovedFromGalaxy.php
            Exception/
                GalaxyNameAlreadyExists.php
                ApplicationAlreadyInGalaxy.php
                ApplicationNotInGalaxy.php
                InvalidGalaxyStatusTransition.php
            Port/
                GalaxyRepositoryInterface.php
                ApplicationExistenceCheckerInterface.php   (ACL)
        Application/
            Command/
                CreateGalaxy.php
                CreateGalaxyHandler.php
                PublishGalaxy.php
                PublishGalaxyHandler.php
                ArchiveGalaxy.php
                ArchiveGalaxyHandler.php
                AddApplicationToGalaxy.php
                AddApplicationToGalaxyHandler.php
                RemoveApplicationFromGalaxy.php
                RemoveApplicationFromGalaxyHandler.php
            Query/
                GetGalaxyById.php
                GetGalaxyByIdHandler.php
                BrowseGalaxies.php
                BrowseGalaxiesHandler.php
        Infrastructure/
            Doctrine/
                DoctrineGalaxyRepository.php
                mapping/
                    Galaxy.xml                             (many-to-many join table)
            Symfony/
                ACL/
                    DoctrineApplicationExistenceChecker.php
    UI/
        Http/
            Controller/
                GalaxyController.php
```

---

## HTTP API

| Method | Route | Command / Query | Response |
|---|---|---|---|
| `POST` | `/galaxies` | `CreateGalaxy` | `201 Created` |
| `GET` | `/galaxies` | `BrowseGalaxies` | `200 OK` |
| `GET` | `/galaxies/{id}` | `GetGalaxyById` | `200` / `404` |
| `PUT` | `/galaxies/{id}/publish` | `PublishGalaxy` | `200` / `404` |
| `PUT` | `/galaxies/{id}/archive` | `ArchiveGalaxy` | `200` / `404` |
| `POST` | `/galaxies/{id}/applications` | `AddApplicationToGalaxy` | `200` / `404` |
| `DELETE` | `/galaxies/{id}/applications/{appId}` | `RemoveApplicationFromGalaxy` | `200` / `404` |

---

## Acceptance criteria

- [ ] `Galaxy` aggregate enforces all invariants (unit tests)
- [ ] `GalaxyName` uniqueness is checked via the port
- [ ] `Draft → Published` is blocked if ApplicationIds is empty
- [ ] An ApplicationId is verified to exist before being added (ACL port)
- [ ] All commands and queries have unit tests
- [ ] `DoctrineGalaxyRepository` persists the many-to-many relationship
- [ ] All HTTP endpoints return the correct status codes
- [ ] `make ci` passes

---

## References

- [Domain model — ApplicationRegistry](../domain/application-registry.md)
- [Architecture overview](../architecture/overview.md)
- [US-002 — Register application](./US-002-enregistrer-application.md)
- [US-003 — Symfony integration](./US-003-symfony-integration.md)
