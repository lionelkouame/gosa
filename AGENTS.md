# AGENTS.md — Rules for AI agents working on GOSA

This file is the single source of truth for any AI agent (Claude Code, Copilot, Cursor, etc.) contributing to this codebase. Read it entirely before writing any code.

---

## What is GOSA?

**G**alaxie **O**pen **S**ource **A**pplication — a federated registry of open source applications grouped into thematic galaxies. Think of it as a decentralized app store, built with PHP 8.5, FrankenPHP, PostgreSQL 17, and Symfony — with no compromise on architecture.

---

## Non-negotiable architecture rules

### 1. Dependency direction — never upward

```
+---------------------------------------------+
|  UI (Controllers, Console)                  |
|  Infrastructure (Doctrine, Messenger, ACL)  |
|  +---------------------------------------+  |
|  |  Application (Commands, Queries)      |  |
|  |  +---------------------------------+  |  |
|  |  |  Domain (pure PHP, no deps)     |  |  |
|  |  +---------------------------------+  |  |
|  +---------------------------------------+  |
+---------------------------------------------+
```

- **Domain** knows nothing about Symfony, Doctrine, HTTP, or any other framework/library
- **Application** knows nothing about Symfony. It only uses Domain objects and Ports (interfaces)
- **Infrastructure** implements Ports. It may use Symfony, Doctrine, etc.
- **UI** calls Application handlers via the Command/Query bus. It contains zero business logic

### 2. Every PHP file starts with

```php
<?php

declare(strict_types=1);
```

No exceptions.

### 3. All Value Objects are immutable

- No setters
- Construction via `private __construct` + named static factory (e.g. `::from()`, `::generate()`)
- Always provide an `equals(self $other): bool` method

```php
final class GalaxyName
{
    private function __construct(private readonly string $value) {}

    public static function from(string $value): self
    {
        if (empty(trim($value))) {
            throw new \InvalidArgumentException('GalaxyName cannot be empty.');
        }
        return new self($value);
    }

    public function value(): string { return $this->value; }

    public function equals(self $other): bool { return $this->value === $other->value; }
}
```

### 4. Aggregates publish Domain Events — never produce side effects directly

```php
// Inside an Aggregate method
$this->recordEvent(new ApplicationAddedToGalaxy($this->id, $applicationId));
```

The Application layer collects and publishes them via `EventPublisherInterface`.

### 5. Controllers are thin

A controller may only:
- Read the HTTP request
- Build a Command or Query from the request data
- Dispatch it via the bus
- Return an HTTP response

A controller must never:
- Instantiate a Domain object directly
- Contain conditional business logic
- Call a repository directly

### 6. Bounded contexts never call each other directly

Cross-context communication uses:
- **Domain Events** (async, fire-and-forget)
- **Anti-Corruption Layer ports** (sync, when a read is needed)

```php
// GalaxyRegistry/Domain/Port/ApplicationExistenceCheckerInterface.php
interface ApplicationExistenceCheckerInterface
{
    public function exists(ApplicationId $id): bool;
}
```

Implemented in `GalaxyRegistry/Infrastructure/Symfony/ACL/` — never in Domain or Application.

### 7. Doctrine mapping uses XML — never annotations on Domain classes

Domain classes must have zero Doctrine imports. All mapping lives in `Infrastructure/Doctrine/mapping/*.xml`.

### 8. PHPStan level max must pass

Run `make stan` before any commit. Suppressing errors with `@phpstan-ignore` is not allowed.

---

## Bounded contexts

| Context | Namespace | Path | Status |
|---|---|---|---|
| ApplicationRegistry | `Gosa\ApplicationRegistry` | `src/ApplicationRegistry/` | In progress |
| GalaxyRegistry | `Gosa\GalaxyRegistry` | `src/GalaxyRegistry/` | Planned |
| Federation | `Gosa\Federation` | `src/Federation/` | Future |

### ApplicationRegistry (Core context)

Manages the lifecycle of open source applications.

Aggregate: `Application`
Value Objects: `ApplicationId`, `ApplicationName`, `DomainCategory`, `Status`, `Version`, `Repository`
Events: `ApplicationRegistered`, `ApplicationPublished`, `ApplicationArchived`, `ApplicationDeprecated`, `NewVersionReleased`

### GalaxyRegistry

Groups applications into thematic galaxies. Holds `ApplicationId` references — never full `Application` objects.

Aggregate: `Galaxy`
Value Objects: `GalaxyId`, `GalaxyName`, `GalaxyDescription`, `GalaxyStatus`
Events: `GalaxyCreated`, `GalaxyPublished`, `GalaxyArchived`, `ApplicationAddedToGalaxy`, `ApplicationRemovedFromGalaxy`
ACL Port: `ApplicationExistenceCheckerInterface`

### Federation (future)

ActivityPub federation between GOSA instances. Implements Inbox/Outbox, HTTP Signatures, WebFinger. The Domain and Application layers of other contexts are untouched.

---

## HTTP API — JSON-LD (ADR-003)

All API responses are JSON-LD. Every response must include `@context`, `@type`, and `@id`.

```json
{
  "@context": [
    "https://www.w3.org/ns/activitystreams",
    { "gosa": "https://gosa.dev/ns#" }
  ],
  "@type": "Collection",
  "@id": "https://gosa.example.com/galaxies/abc-123",
  "name": "Best ecommerce apps"
}
```

Domain events map to ActivityStreams 2.0:

| Domain event | ActivityStreams activity |
|---|---|
| `GalaxyCreated` | `Create` → `Collection` |
| `ApplicationRegistered` | `Create` → `gosa:Application` |
| `ApplicationAddedToGalaxy` | `Add` |
| `GalaxyPublished` | `Announce` |

---

## Symfony integration rules

- `#[AsMessageHandler]` is allowed **only on Handler classes** — never on Commands, Queries, or Domain objects
- Services are wired via autowiring — no manual service definitions unless strictly necessary
- Ports are bound to their implementations in `config/services.yaml`:

```yaml
Gosa\ApplicationRegistry\Domain\Port\ApplicationRepositoryInterface:
    class: Gosa\ApplicationRegistry\Infrastructure\Doctrine\DoctrineApplicationRepository
```

---

## Directory structure reference

```
src/
    Kernel.php
    {BoundedContext}/
        Domain/
            Model/         Aggregates, Entities
            ValueObject/   Value Objects
            Event/         Domain Events
            Exception/     Domain Exceptions
            Port/          Interfaces (Repository, Publisher, ACL...)
        Application/
            Command/       CommandClass + CommandHandlerClass (pairs)
            Query/         QueryClass + QueryHandlerClass (pairs)
        Infrastructure/
            Doctrine/      DoctrineXxxRepository + mapping/*.xml
            Symfony/
                Messenger/ Event publishers via Messenger
                ACL/       Anti-Corruption Layer implementations
    UI/
        Http/
            Controller/    Thin Symfony controllers

config/
    bundles.php
    services.yaml
    routes.yaml
    packages/
        framework.yaml
        doctrine.yaml
        messenger.yaml

tests/
    Unit/
        {BoundedContext}/
            Domain/        Pure domain unit tests (no infrastructure)
    Integration/
        {BoundedContext}/ Integration tests (real database)
```

---

## Commands reference

```bash
make up              # Start all containers (app + db)
make install         # composer install inside container
make test            # Run full test suite
make test-unit       # Unit tests only
make test-integration# Integration tests only
make lint            # Check code style (dry-run)
make fix             # Auto-fix code style
make stan            # PHPStan level max
make ci              # lint + stan + test (full pipeline)
make docs            # Start MkDocs on http://localhost:8080
```

---

## output.md convention

`output.md` at the project root is a **clipboard file** — it contains content ready to copy-paste (commit messages, issue bodies, summaries). It is rewritten on each use. Do not treat it as permanent documentation.

---

## Adding a new use case — checklist

- [ ] Create `Command.php` (immutable DTO, no Symfony imports)
- [ ] Create `CommandHandler.php` with `#[AsMessageHandler]`
- [ ] Handler loads aggregate via Port, calls domain method, persists, publishes events
- [ ] Add unit test in `tests/Unit/{Context}/Domain/`
- [ ] Run `make ci` — all green before committing
- [ ] Follow Conventional Commits for the commit message

---

## Key ADRs

| ADR | Decision |
|---|---|
| ADR-001 | FrankenPHP 1.x + PHP 8.5 as runtime |
| ADR-002 | No framework in Domain/Application layers |
| ADR-003 | JSON-LD + ActivityPub-compatible HTTP API |

Full ADRs in `docs/architecture/decisions/`.
