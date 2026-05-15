# Guide de développement

## Règles absolues

1. **Zéro dépendance externe dans `src/ApplicationRegistry/Domain/`** — pas de PDO, pas de librairie tierce
2. **Tout Value Object est immuable** — pas de setter, construction via constructeur ou méthode statique nommée
3. **Tout Aggregate Root publie des Domain Events** — jamais d'effets de bord directs
4. **PHPStan level max doit passer** — aucune suppression d'erreur tolérée
5. **`declare(strict_types=1)`** en tête de chaque fichier PHP

---

## Ajouter un nouveau Use Case

```
src/ApplicationRegistry/Application/Command/
└── MonNouveauUseCase/
    ├── MonNouveauUseCaseCommand.php   ← DTO immuable (données en entrée)
    └── MonNouveauUseCaseHandler.php   ← logique applicative
```

Le Handler :
- Reçoit un Command (DTO)
- Appelle le Repository (Port) pour charger l'Aggregate
- Appelle une méthode sur l'Aggregate
- Persiste via le Repository
- Publie les Domain Events via EventPublisher

---

## Ajouter un nouveau Value Object

```php
<?php

declare(strict_types=1);

namespace Gosa\ApplicationRegistry\Domain\Model;

final class MonValueObject
{
    private function __construct(private readonly string $value) {}

    public static function from(string $value): self
    {
        if (empty(trim($value))) {
            throw new \InvalidArgumentException('...');
        }

        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
```

---

## Structure d'un test unitaire de domaine

```php
<?php

declare(strict_types=1);

namespace Gosa\Tests\Unit\ApplicationRegistry\Domain;

use PHPUnit\Framework\TestCase;

final class MonValueObjectTest extends TestCase
{
    public function test_it_rejects_empty_value(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        MonValueObject::from('');
    }
}
```

Les tests unitaires du domaine **n'ont besoin d'aucune infrastructure** — ils s'exécutent instantanément.
