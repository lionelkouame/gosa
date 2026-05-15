# Contributing to GOSA

Thank you for your interest in contributing! Please take a moment to read these guidelines before opening an issue or a pull request.

---

## Code of Conduct

This project follows the [Contributor Covenant](CODE_OF_CONDUCT.md). By participating, you agree to uphold these standards.

---

## How to contribute

### Report a bug

Open an issue using the **Bug report** template. Include:
- Steps to reproduce
- Expected vs actual behavior
- PHP version, OS

### Suggest a feature

Open an issue using the **Feature request** template. Describe the use case and the expected outcome.

### Submit a pull request

1. Fork the repository
2. Create a branch from `main`: `git checkout -b feat/my-feature`
3. Make your changes
4. Run the full CI pipeline: `make ci`
5. Commit following [Conventional Commits](https://www.conventionalcommits.org)
6. Open a pull request against `main`

---

## Development setup

```bash
cp .env.example .env
make up
make install
make ci
```

See [`docs/setup/development.md`](docs/setup/development.md) for detailed guidelines.

---

## Architecture rules

GOSA uses Clean Architecture + DDD. Before contributing, read:

- [`docs/architecture/overview.md`](docs/architecture/overview.md)
- [`docs/domain/glossaire.md`](docs/domain/glossaire.md)

Key rules:
- **Domain** has zero external dependencies
- All external access goes through a **Port** (interface)
- Business logic lives in the Domain — never in Application or Infrastructure
- PHPStan level max must pass: `make stan`
- Code style must pass: `make lint`

---

## Commit conventions

We follow [Conventional Commits](https://www.conventionalcommits.org):

```
feat: add application archiving use case
fix: handle empty application name in Value Object
chore: update PHPStan to 2.x
docs: add ADR for event sourcing decision
test: add unit tests for Version value object
refactor: extract DomainEvent base class
```

---

## Questions?

Open a [Discussion](../../discussions) — we are happy to help.
