# 🗄️ Schéma de la base de données

Diagramme entité-relation de l'application de ticketing.

```mermaid
erDiagram
    users {
        bigint id PK
        string name
        string email
        timestamp email_verified_at
        string password
        string remember_token
        timestamp created_at
        timestamp updated_at
    }

    projets {
        bigint id PK
        string nom_projet
        string client_name
        text description
        date date_debut
        date date_fin
        decimal budget
        string statut
        int temps_estime
        text technologies
        bigint createur_id FK
        timestamp created_at
        timestamp updated_at
    }

    tickets {
        bigint id PK
        string titre
        text description
        string type
        string priorite
        date delai
        string statut
        int temps_passe
        bigint projet_id FK
        bigint createur_id FK
        bigint assigne_a_id FK
        timestamp created_at
        timestamp updated_at
    }

    contacts {
        bigint id PK
        string prenom
        string nom
        string poste
        string entreprise
        string email
        string telephone
        text notes
        bigint user_id FK
        timestamp created_at
        timestamp updated_at
    }

    documents {
        bigint id PK
        string nom_document
        string nom_fichier
        string statut
        bigint user_id FK
        timestamp created_at
        timestamp updated_at
    }

    factures {
        bigint id PK
        string nom_facture
        string nom_fichier
        string statut
        bigint user_id FK
        timestamp created_at
        timestamp updated_at
    }

    projet_user {
        bigint id PK
        bigint projet_id FK
        bigint user_id FK
        timestamp created_at
        timestamp updated_at
    }

    ticket_user {
        bigint id PK
        bigint ticket_id FK
        bigint user_id FK
        string role
        timestamp created_at
        timestamp updated_at
    }

    password_reset_tokens {
        string email PK
        string token
        timestamp created_at
    }

    users ||--o{ projets : "createur_id (crée)"
    users ||--o{ tickets : "createur_id (crée)"
    users ||--o{ tickets : "assigne_a_id (assigné à)"
    users ||--o{ contacts : "user_id (possède)"
    users ||--o{ documents : "user_id (possède)"
    users ||--o{ factures : "user_id (possède)"

    projets ||--o{ tickets : "projet_id (contient)"

    projets ||--o{ projet_user : "projet_id"
    users ||--o{ projet_user : "user_id"

    tickets ||--o{ ticket_user : "ticket_id"
    users ||--o{ ticket_user : "user_id"
```

## Légende

| Symbole | Signification |
|---------|---------------|
| `PK`    | Clé primaire |
| `FK`    | Clé étrangère |
| `\|\|--o{` | Un à plusieurs (one-to-many) |

## Tables pivot

- **`projet_user`** — Relie les utilisateurs aux projets (collaborateurs). Permet les relations many-to-many entre `users` et `projets`.
- **`ticket_user`** — Relie les utilisateurs aux tickets avec un rôle (`lecteur` / `editeur`). Permet les relations many-to-many entre `users` et `tickets`.

## Valeurs énumérées

| Table | Colonne | Valeurs possibles | Défaut |
|-------|---------|-------------------|--------|
| `projets` | `statut` | `nouveau`, `en cours`, `terminé`, `archivé` | `nouveau` |
| `tickets` | `type` | `bug`, `feature`, `support` | `bug` |
| `tickets` | `priorite` | `low`, `medium`, `high`, `critical` | `medium` |
| `tickets` | `statut` | `Nouveau`, `En cours`, `Résolu`, `Fermé` | `Nouveau` |
| `ticket_user` | `role` | `lecteur`, `editeur` | `lecteur` |
| `documents` | `statut` | `en cours`, `validé`, `archivé` | `en cours` |
| `factures` | `statut` | `en cours`, `payée`, `en retard` | `en cours` |
