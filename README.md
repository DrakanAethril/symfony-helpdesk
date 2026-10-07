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

## Récupérer le projet

Une seule fois, au début :

```console
git clone https://github.com/<compte>/symfony-helpdesk.git
cd symfony-helpdesk
```

## Se placer au début d'un chapitre

Tous les cours sont sur <https://formations.beaupeyrat.org/courses/sebthar>.

Chaque chapitre a sa commande. Elle récupère les derniers points de départ
publiés (`git fetch --tags`), puis crée une branche de travail à partir de
celui du chapitre. On peut le faire à tout moment, même sans avoir fait les
chapitres précédents.

Si votre travail en cours n'est pas encore validé, enregistrez-le d'abord
avec `git commit` (ou mettez-le de côté avec `git stash`).

### 01 · Symfony - Démarrer avec symfony-docker

Cours : <https://formations.beaupeyrat.org/courses/sebthar/symfony-demarrer-avec-symfony-docker>

Modèle symfony-docker seul : Symfony s'installe au premier démarrage.

```console
git fetch --tags && git switch -c cours-01 symfony-01-depart
```

### 02 · Symfony - Routes et contrôleurs

Cours : <https://formations.beaupeyrat.org/courses/sebthar/symfony-routes-et-controleurs>

Symfony 8 installé, page d'accueil par défaut.

```console
git fetch --tags && git switch -c cours-02 symfony-02-depart
```

### 03 · Symfony - Les templates Twig

Cours : <https://formations.beaupeyrat.org/courses/sebthar/symfony-les-templates-twig>

Contrôleurs et routes des tickets, données en dur.

```console
git fetch --tags && git switch -c cours-03 symfony-03-depart
```

### 04 · Symfony - Mettre en forme avec Tailwind CSS

Cours : <https://formations.beaupeyrat.org/courses/sebthar/symfony-mettre-en-forme-avec-tailwind-css>

Pages en Twig, mise en page commune, sans mise en forme.

```console
git fetch --tags && git switch -c cours-04 symfony-04-depart
```

### 05 · Symfony - Créer ses entités avec Doctrine

Cours : <https://formations.beaupeyrat.org/courses/sebthar/symfony-creer-ses-entites-avec-doctrine>

Pages mises en forme avec Tailwind CSS, données en dur.

```console
git fetch --tags && git switch -c cours-05 symfony-05-depart
```

### 06 · Symfony - Passer de PostgreSQL à MySQL

Cours : <https://formations.beaupeyrat.org/courses/sebthar/symfony-passer-de-postgresql-a-mysql>

Doctrine installé avec PostgreSQL, entités Ticket et Catégorie, première migration.

```console
git fetch --tags && git switch -c cours-06 symfony-06-depart
```

### 07 · Symfony - Lire et écrire avec Doctrine

Cours : <https://formations.beaupeyrat.org/courses/sebthar/symfony-lire-et-ecrire-avec-doctrine>

Base MySQL, migrations régénérées.

```console
git fetch --tags && git switch -c cours-07 symfony-07-depart
```

### 08 · Symfony - Les relations entre entités

Cours : <https://formations.beaupeyrat.org/courses/sebthar/symfony-les-relations-entre-entites>

Tickets lus et enregistrés en base, jeu de données de démonstration.

```console
git fetch --tags && git switch -c cours-08 symfony-08-depart
```

### 09 · Symfony - Les formulaires

Cours : <https://formations.beaupeyrat.org/courses/sebthar/symfony-les-formulaires>

Relations Ticket ↔ Catégorie et Ticket ↔ Matériel.

```console
git fetch --tags && git switch -c cours-09 symfony-09-depart
```

### 10 · Symfony - Valider les données

Cours : <https://formations.beaupeyrat.org/courses/sebthar/symfony-valider-les-donnees>

Formulaire « Déclarer un incident ».

```console
git fetch --tags && git switch -c cours-10 symfony-10-depart
```

### 11 · Symfony - L'authentification

Cours : <https://formations.beaupeyrat.org/courses/sebthar/symfony-l-authentification>

Règles de validation des tickets.

```console
git fetch --tags && git switch -c cours-11 symfony-11-depart
```

### 12 · Symfony - Rôles et autorisations

Cours : <https://formations.beaupeyrat.org/courses/sebthar/symfony-roles-et-autorisations>

Connexion des utilisateurs, auteur relié aux tickets.

```console
git fetch --tags && git switch -c cours-12 symfony-12-depart
```

### 13 · Symfony - Services et injection de dépendances

Cours : <https://formations.beaupeyrat.org/courses/sebthar/symfony-services-et-injection-de-dependances>

Droits par rôle, voter sur les tickets.

```console
git fetch --tags && git switch -c cours-13 symfony-13-depart
```

### 14 · Symfony - Exposer une API JSON

Cours : <https://formations.beaupeyrat.org/courses/sebthar/symfony-exposer-une-api-json>

Service de calcul du délai de résolution.

```console
git fetch --tags && git switch -c cours-14 symfony-14-depart
```

### Projet terminé

```console
git fetch --tags && git switch -c projet-termine symfony-fin
```

Les points de départ sont publiés au fur et à mesure des chapitres : si la
commande répond « invalid reference », ce chapitre n'est pas encore
disponible.

## Démarrer l'environnement

Après avoir changé de chapitre, reconstruire puis démarrer :

```console
docker compose build --pull --no-cache
docker compose up --wait
```

Ouvrir ensuite <https://localhost> et accepter le certificat de sécurité
généré localement. Pour arrêter : `docker compose down --remove-orphans`.

Toutes les commandes Symfony s'exécutent **dans le conteneur** :

```console
docker compose exec php bin/console about
docker compose exec php composer require …
```
