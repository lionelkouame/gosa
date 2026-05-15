# Domain Model — ApplicationRegistry

## Aggregate Root : Application

```
Application (Aggregate Root)
├── ApplicationId        Value Object — UUID v4, immuable
├── ApplicationName      Value Object — non vide, unique dans la galaxie
├── DomainCategory       Value Object — enum: ecommerce | booking | saas | crm | erp | other
├── Status               Value Object — enum: Draft | Published | Archived | Deprecated
├── Version              Value Object — SemVer (major.minor.patch), tous >= 0
├── Repository           Value Object — GitUrl (https) + LicenseType (mit | apache2 | gpl3…)
└── Domain Events émis
    ├── ApplicationRegistered   (à la création)
    ├── ApplicationPublished    (Draft → Published)
    ├── ApplicationArchived     (Published → Archived)
    ├── ApplicationDeprecated   (Published → Deprecated)
    └── NewVersionReleased      (à chaque nouvelle version)
```

---

## Règles métier (invariants)

1. `ApplicationName` doit être **unique** dans la galaxie — vérification via le Port `ApplicationRepositoryInterface`
2. `Version` doit respecter **strictement SemVer** — `1.0.0`, pas `v1.0`, pas `1.0`
3. Transitions de statut autorisées :
   ```
   Draft → Published
   Published → Archived
   Published → Deprecated
   Deprecated → Archived
   ```
   Toute autre transition lève `InvalidStatusTransition`
4. Un nom ou une URL Git vide lève une exception dès la construction du Value Object

---

## Ports (interfaces)

### `ApplicationRepositoryInterface` (sortant)
```php
interface ApplicationRepositoryInterface
{
    public function save(Application $application): void;
    public function findById(ApplicationId $id): ?Application;
    public function findByName(ApplicationName $name): ?Application;
    public function findAll(): array;
}
```

### `EventPublisherInterface` (sortant)
```php
interface EventPublisherInterface
{
    public function publish(DomainEvent ...$events): void;
}
```

---

## Use Cases

| Use Case | Acteur | Événement produit |
|----------|--------|-------------------|
| RegisterApplication | Contributeur | ApplicationRegistered |
| PublishApplication | Admin | ApplicationPublished |
| ArchiveApplication | Admin | ApplicationArchived |
| DeprecateApplication | Admin | ApplicationDeprecated |
| ReleaseNewVersion | Contributeur / CI | NewVersionReleased |
| GetApplicationById | Tous | — |
| BrowseApplications | Tous | — |
