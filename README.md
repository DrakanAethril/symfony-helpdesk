# Helpdesk — projet fil rouge des cours Symfony

Application de gestion des demandes d'assistance de Norbelle, PME fictive de 80 salariés sur deux sites (Limoges et Brive) : les salariés
déclarent des incidents, les techniciens les prennent en charge, les
responsables suivent l'activité.

Le projet est construit cours après cours. Chaque cours part d'un **tag**
qui contient exactement l'état du projet au début du cours : on peut donc
reprendre à n'importe quel cours, même sans avoir fait les précédents.

L'environnement repose sur [symfony-docker](https://github.com/dunglas/symfony-docker)
(FrankenPHP, Symfony 8). La documentation du modèle est conservée dans
[`docs/`](docs/symfony-docker.md).

## Prérequis

- Docker Desktop (ou Docker Engine + Docker Compose 2.10 ou plus)
- Git
- Les ports **80** et **443** libres : arrêter WAMP, XAMPP, MAMP ou tout
  autre serveur web local avant de démarrer
- Sous Windows : cloner le projet **dans WSL** (`~/…` dans le terminal
  Ubuntu), pas dans `C:\Users\…`, sinon tout devient très lent

## Reprendre le projet au début d'un cours

```console
git clone https://github.com/<compte>/symfony-helpdesk.git
cd symfony-helpdesk
git switch -c mon-travail symfony-XX-depart
docker compose build --pull --no-cache
docker compose up --wait
```

Remplacer `XX` par le numéro du cours, puis ouvrir <https://localhost> et
accepter le certificat de sécurité généré localement.

Pour arrêter : `docker compose down --remove-orphans`.

Toutes les commandes Symfony s'exécutent **dans le conteneur** :

```console
docker compose exec php bin/console about
docker compose exec php composer require …
```

## Les points de départ

| Tag | Cours | État du projet au départ |
|---|---|---|
| `symfony-01-depart` | Symfony - Démarrer avec symfony-docker | Modèle symfony-docker seul : Symfony s'installe au premier `docker compose up` |
| `symfony-02-depart` | Symfony - Routes et contrôleurs | Symfony 8 installé, page d'accueil par défaut |
| `symfony-03-depart` | Symfony - Les templates Twig | Contrôleurs et routes des tickets, données en dur |
| `symfony-04-depart` | Symfony - Créer ses entités avec Doctrine | Pages en Twig, mise en page commune |
| `symfony-05-depart` | Symfony - Passer de PostgreSQL à MySQL | Doctrine installé avec PostgreSQL, entités Ticket et Catégorie, première migration |
| `symfony-06-depart` | Symfony - Lire et écrire avec Doctrine | Base MySQL, migrations régénérées |
| `symfony-07-depart` | Symfony - Les relations entre entités | Tickets lus et enregistrés en base, jeu de données de démonstration |
| `symfony-08-depart` | Symfony - Les formulaires | Relations Ticket ↔ Catégorie, Matériel, Utilisateur |
| `symfony-09-depart` | Symfony - Valider les données | Formulaire « Déclarer un incident » |
| `symfony-10-depart` | Symfony - L'authentification | Règles de validation des tickets |
| `symfony-11-depart` | Symfony - Rôles et autorisations | Connexion des salariés et techniciens |
| `symfony-12-depart` | Symfony - Services et injection de dépendances | Droits par rôle, voter sur les tickets |
| `symfony-13-depart` | Symfony - Exposer une API JSON | Service de calcul du délai de résolution |
| `symfony-fin` | — | Projet terminé |

Les tags sont ajoutés au fur et à mesure de la publication des cours.
