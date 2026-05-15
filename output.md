## feat: add Behat acceptance tests

### Context

GOSA already has PHPUnit for unit and integration tests. Behat adds a BDD
(Behavior-Driven Development) layer — tests written in plain English (Gherkin)
that describe business behavior from the outside. They serve as living
documentation and catch regressions at the use-case level.

### Packages to add

```bash
composer require --dev behat/behat friends-of-behat/symfony-extension behat/mink-extension friends-of-behat/mink-browserkit-driver
```

| Package | Role |
|---|---|
| `behat/behat` | Behat core |
| `friends-of-behat/symfony-extension` | Boots the Symfony kernel inside Behat |
| `behat/mink-extension` | HTTP-level interactions |
| `friends-of-behat/mink-browserkit-driver` | Symfony HttpKernel driver (no real browser needed) |

### Target structure

```
features/
    application_registry/
        register_application.feature
        publish_application.feature
    galaxy/
        create_galaxy.feature
        add_application_to_galaxy.feature

tests/
    Behat/
        Context/
            ApplicationRegistryContext.php
            GalaxyContext.php
        bootstrap.php

behat.yml
```

### Example feature file

```gherkin
# features/application_registry/register_application.feature

Feature: Register an open source application
  As a contributor
  I want to register an application in the registry
  So that it becomes discoverable in the galaxy

  Scenario: Successfully register a valid application
    Given no application named "OpenCart" exists
    When I register an application with name "OpenCart" and version "4.0.2"
    Then the application "OpenCart" should be in the registry with status "Draft"
    And an "ApplicationRegistered" event should have been published

  Scenario: Reject registration with an empty name
    When I try to register an application with an empty name
    Then I should get an error "ApplicationName cannot be empty"

  Scenario: Reject duplicate application name
    Given an application named "OpenCart" already exists
    When I try to register another application named "OpenCart"
    Then I should get an error "ApplicationName already exists"
```

### behat.yml

```yaml
default:
  suites:
    application_registry:
      paths: [ features/application_registry ]
      contexts: [ App\Tests\Behat\Context\ApplicationRegistryContext ]
    galaxy:
      paths: [ features/galaxy ]
      contexts: [ App\Tests\Behat\Context\GalaxyContext ]
  extensions:
    FriendsOfBehat\SymfonyExtension:
      bootstrap: tests/Behat/bootstrap.php
```

### Makefile target to add

```makefile
behat:
    docker compose exec app vendor/bin/behat

ci: lint stan test behat
```

### Acceptance criteria

- [ ] `make behat` runs without error
- [ ] Feature file for `RegisterApplication` use case (happy path + 2 error cases)
- [ ] Feature file for `CreateGalaxy` use case (happy path + 2 error cases)
- [ ] Feature file for `AddApplicationToGalaxy` (happy path + application not found)
- [ ] `make ci` includes behat
- [ ] Features are readable by a non-developer (plain English, no technical jargon)
- [ ] PHPStan still passes on Context classes

### References

- US-002 — Register application
- US-004 — Galaxy
- docs/architecture/overview.md
