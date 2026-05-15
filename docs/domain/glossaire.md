# Ubiquitous Language — Glossaire GOSA

> Ce glossaire est la référence partagée entre le code et les discussions métier.
> Chaque terme ici doit avoir un équivalent exact dans le code.

---

## Termes du contexte ApplicationRegistry

| Terme métier | Classe PHP | Définition |
|--------------|-----------|------------|
| **Galaxie** | — | L'ensemble de la plateforme GOSA et de ses applications |
| **Application** | `Application` | Un domaine métier autonome et open source enregistré dans la galaxie |
| **Domaine** | `DomainCategory` | La catégorie métier d'une application (e-commerce, booking, crm…) |
| **Version** | `Version` | Numéro de release d'une application au format SemVer (x.y.z) |
| **Dépôt** | `Repository` | L'URL Git et la licence d'une application |
| **Statut** | `Status` | L'état de vie d'une application : Draft, Published, Archived, Deprecated |
| **Enregistrement** | `RegisterApplication` | L'acte d'ajouter une nouvelle application à la galaxie |
| **Publication** | `PublishApplication` | La validation qui rend une application visible publiquement |
| **Archivage** | `ArchiveApplication` | Le retrait d'une application du cycle actif |
| **Contributeur** | — | Acteur qui soumet ou met à jour une application |
| **Administrateur** | — | Acteur qui valide et modère la galaxie |

---

## Règles de langage

- On dit **"enregistrer"** une application (pas "créer", pas "ajouter")
- On dit **"publier"** (pas "activer", pas "approuver")
- On dit **"archiver"** (pas "supprimer", pas "désactiver")
- Une application est **"dépréciée"** avant d'être archivée si elle a des utilisateurs actifs
