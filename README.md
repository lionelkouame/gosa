# GOSA — Galaxie Open Source Application

> A curated registry of open source applications, built with PHP 8.5, FrankenPHP, and Domain-Driven Design — no framework.

[![CI](https://github.com/lionelkouame/gosa/actions/workflows/ci.yml/badge.svg)](https://github.com/lionelkouame/gosa/actions/workflows/ci.yml)
[![Coverage](https://codecov.io/gh/lionelkouame/gosa/branch/main/graph/badge.svg)](https://codecov.io/gh/lionelkouame/gosa)
[![PHP](https://img.shields.io/badge/PHP-8.5-777BB4?logo=php&logoColor=white)](https://www.php.net)
[![Symfony](https://img.shields.io/badge/Symfony-7.x-black?logo=symfony&logoColor=white)](https://symfony.com)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%20max-brightgreen)](https://phpstan.org)
[![Behat](https://img.shields.io/badge/Behat-BDD-5a5a5a)](https://behat.org)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)

---

## What is GOSA?

GOSA is a registry that lets contributors publish, discover, and track open source applications. It is built following **Clean Architecture**, **Domain-Driven Design**, and **Hexagonal Architecture** — deliberately without any framework.

---

## Requirements

- Docker >= 26
- Docker Compose >= 2.20
- Make

---

## Quick start

```bash
git clone https://github.com/lionelkouame/gosa.git && cd gosa
cp .env.example .env
make up
make install
make ci
```

The application is available at **https://localhost**.

---

## Available commands

| Command | Description |
|---------|-------------|
| `make up` | Start all containers |
| `make down` | Stop containers |
| `make shell` | Open a shell in the app container |
| `make install` | Install Composer dependencies |
| `make test` | Run all tests |
| `make test-unit` | Unit tests only |
| `make test-integration` | Integration tests only |
| `make coverage` | HTML coverage report in `var/coverage/` |
| `make lint` | Check code style (dry-run) |
| `make fix` | Auto-fix code style |
| `make stan` | Static analysis — PHPStan level max |
| `make ci` | lint + stan + test (full pipeline) |

---

## Architecture

GOSA is built on three non-negotiable pillars:

| Pillar | Description |
|--------|-------------|
| **Clean Architecture** | Domain depends on nothing. Infrastructure depends on Domain. |
| **Domain-Driven Design** | Code reflects the business language. Strict Ubiquitous Language. |
| **Hexagonal Architecture** | Domain at the center. Every external access goes through a Port. |

```
src/
└── ApplicationRegistry/
    ├── Domain/          # Aggregates, Value Objects, Ports, Events
    ├── Application/     # Commands, Queries, Handlers
    └── Infrastructure/  # Adapters, Persistence
```

Full documentation in [`docs/`](docs/README.md).

---

## Contributing

Contributions are welcome! Please read [CONTRIBUTING.md](CONTRIBUTING.md) before opening a pull request.

---

## License

MIT — see [LICENSE](LICENSE).
