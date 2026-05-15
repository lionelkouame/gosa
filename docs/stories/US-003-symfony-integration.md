# US-003 — Integrate Symfony while preserving Clean Architecture

**Status:** In progress
**Priority:** High

---

## Story

As a **developer**,
I want to integrate Symfony as an infrastructure and UI detail,
so that I benefit from its ecosystem (DI, Messenger, Doctrine, Console)
without coupling the Domain or Application layers to any framework.

---

## Guiding principle

> Symfony is a **detail**. It plugs into the outside of the hexagon.
> The Domain and Application layers must never import a Symfony class.

```
+---------------------------------------------+
|  UI (Symfony Controllers, Console Commands) |
|  Infrastructure (Doctrine, Messenger)       |
|  +---------------------------------------+  |
|  |  Application (Commands, Queries)      |  |
|  |  +---------------------------------+  |  |
|  |  |  Domain (pure PHP, no deps)     |  |  |
|  |  +---------------------------------+  |  |
|  +---------------------------------------+  |
+---------------------------------------------+
```

---

## Packages to add

| Package | Purpose | Layer |
|---|---|---|
| `symfony/framework-bundle` | Kernel, DI container, Router, HttpKernel | UI / Bootstrap |
| `symfony/messenger` | Command & Query bus — wires handlers automatically | Infrastructure |
| `doctrine/orm` | Implements `ApplicationRepositoryInterface` | Infrastructure |
| `doctrine/doctrine-bundle` | Doctrine integration with Symfony DI | Infrastructure |
| `symfony/console` | CLI commands | UI |
| `symfony/dotenv` | `.env` loading | Bootstrap |

---

## Target directory structure

```
config/
    packages/
        framework.yaml
        doctrine.yaml
        messenger.yaml
    routes/
        api.yaml
    services.yaml

src/
    Kernel.php
    ApplicationRegistry/
        Domain/                          (unchanged - pure PHP)
        Application/
            Command/
                RegisterApplication.php               (plain PHP, no Symfony)
                RegisterApplicationHandler.php        (#[AsMessageHandler] only)
            Query/
                GetApplicationById.php                (plain PHP, no Symfony)
                GetApplicationByIdHandler.php         (#[AsMessageHandler] only)
        Infrastructure/
            Doctrine/
                DoctrineApplicationRepository.php     (implements ApplicationRepositoryInterface)
            Symfony/
                Messenger/
                    MessengerEventPublisher.php       (implements EventPublisherInterface)
    UI/
        Http/
            Controller/
                ApplicationController.php             (thin, no business logic)
```

---

## Implementation steps

### 1 — Install packages

```bash
composer require symfony/framework-bundle symfony/messenger symfony/console symfony/dotenv
composer require doctrine/orm doctrine/doctrine-bundle
```

### 2 — Bootstrap

- Add `src/Kernel.php` (standard Symfony Kernel)
- Update `public/index.php` to boot the Symfony kernel
- Add `config/services.yaml` with autowiring + autoconfiguration enabled
- Bind `ApplicationRepositoryInterface` → `DoctrineApplicationRepository`
- Bind `EventPublisherInterface` → `MessengerEventPublisher`

### 3 — Messenger (Command/Query bus)

`config/packages/messenger.yaml`:

```yaml
framework:
  messenger:
    buses:
      command.bus: ~
      query.bus: ~
```

Handlers are auto-discovered via `#[AsMessageHandler]`.
Only Handlers get the attribute — Commands and Queries remain plain PHP classes.

### 4 — Doctrine

- Map Domain entities using **XML mapping** — no Doctrine annotations on Domain classes
- `DoctrineApplicationRepository` lives in `Infrastructure/Persistence/` and implements the Domain Port

### 5 — First controller

`ApplicationController` exposes:

| Method | Route | Dispatches | Response |
|---|---|---|---|
| `POST` | `/applications` | `RegisterApplication` command | `201 Created` |
| `GET` | `/applications/{id}` | `GetApplicationById` query | `200 OK` / `404 Not Found` |

Controller contract:

```php
// ✅ Allowed in a controller
$command = new RegisterApplication(...$request->toArray());
$this->commandBus->dispatch($command);

// ❌ Never in a controller
$application = new Application(...); // domain logic belongs in the Domain
```

### 6 — CI update

Update `Makefile` and `.github/workflows/ci.yml` to add a Symfony health-check:

```bash
php bin/console about
```

---

## Acceptance criteria

- [ ] `make ci` passes — lint + stan + test
- [ ] `php bin/console about` outputs the Symfony environment without error
- [ ] Domain classes have **zero** Symfony imports
- [ ] `Command` and `Query` classes have **zero** Symfony imports
- [ ] Only Handlers carry `#[AsMessageHandler]`
- [ ] `ApplicationRepositoryInterface` is bound via DI — never hardcoded
- [ ] `POST /applications` returns `201 Created`
- [ ] `GET /applications/{id}` returns `200 OK` or `404 Not Found`
- [ ] PHPStan level max still passes

---

## References

- [ADR-002 — PHP without framework](../architecture/decisions/ADR-002-php-pur-sans-framework.md) ← to update
- [Architecture overview](../architecture/overview.md)
- [Domain model — ApplicationRegistry](../domain/application-registry.md)
- [US-001 — Dev environment setup](./US-001-setup.md)
- [US-002 — Register an application](./US-002-enregistrer-application.md)
