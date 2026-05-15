# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [Unreleased]

### Added
- Project bootstrap: FrankenPHP 1.x, PHP 8.5, PostgreSQL 17 (Docker Compose)
- Hexagonal structure: `src/ApplicationRegistry/{Domain,Application,Infrastructure}`
- Tooling: PHPUnit 12, PHPStan level max, PHP CS Fixer (PER-CS)
- Makefile targets: `up`, `install`, `test`, `stan`, `lint`, `ci`
- Architecture documentation and ADRs
- User stories US-001 and US-002
