Memory Game – Projet PHP
Description

Ce projet est une version web du jeu Memory (jeu des paires), développée en PHP orienté objet dans le cadre de ma formation.
Le principe du jeu est de retourner les cartes deux par deux et d’essayer de retrouver toutes les paires en un minimum de coups.

Le site permet aussi d’enregistrer les scores des joueurs et d’afficher un classement des meilleurs résultats. Chaque joueur peut disposer d’un profil et consulter son historique de parties.

Fonctionnalités

Choix du nombre de paires (entre 3 et 12)

Mélange aléatoire des cartes

Comptage des coups pendant la partie

Détection des paires trouvées

Classement des dix meilleurs scores

Profil joueur avec historique des parties

Stockage des données en base MySQL

Utilisation des sessions PHP

Structure du code en programmation orientée objet

Structure du projet

Arborescence principale :

httpdocs/
 ├─ index.php
 ├─ game.php
 ├─ finish.php
 ├─ profile.php
 ├─ classes/
 │   ├─ Card.php
 │   ├─ Deck.php
 │   ├─ Game.php
 │   ├─ Player.php
 │   └─ DB.php
 └─ sql/
     └─ memory.sql

Technologies utilisées

PHP (POO)

MySQL / MariaDB

HTML / CSS

PDO pour la connexion à la base

Sessions PHP

Base de données

Deux tables principales sont utilisées.

Table players

id : identifiant du joueur

username : pseudo du joueur

created_at : date de création

Table scores

id : identifiant du score

player_id : clé étrangère vers players.id

pairs : nombre de paires jouées

moves : nombre de coups effectués

score : résultat (moves / pairs)

created_at : date de la partie

Le script SQL de création se trouve dans le dossier sql.

Installation en local

Cloner ou télécharger le projet

Copier les fichiers dans le dossier web (par exemple htdocs ou www)

Créer une base de données MySQL

Importer le fichier SQL fourni

Modifier le fichier classes/DB.php pour y mettre vos identifiants de connexion MySQL

Lancer le projet depuis un navigateur avec l’URL locale (par exemple http://localhost/memory
)

Déploiement sur Plesk

Le projet doit être placé dans le dossier httpdocs du domaine.

Il faut vérifier que :

le fichier index.php est bien directement dans httpdocs

les classes se trouvent dans httpdocs/classes

la base MySQL est créée dans Plesk

le fichier DB.php contient le bon nom de base, l’utilisateur et le mot de passe

Règles du jeu

Le joueur clique sur deux cartes pour les retourner.
Si les deux cartes sont identiques, la paire est validée.
Sinon, elles se retournent à nouveau.

La partie se termine lorsque toutes les paires ont été trouvées.

Un score est alors calculé selon la formule :

score = nombre de coups / nombre de paires

Plus le score est faible, meilleur est le résultat.

Espace joueur

Chaque joueur peut renseigner un pseudo.
Un profil est associé à ce pseudo et permet de consulter :

le nombre de parties jouées

l’historique des scores

le meilleur score

Un tableau affiche également les meilleurs joueurs.

Objectifs pédagogiques

Ce projet m’a permis de travailler sur :

la gestion des sessions PHP

la création et l’utilisation d’une base de données

la programmation orientée objet en PHP

la structuration d’un projet web

le déploiement d’un site sur un hébergement Plesk

le dépannage d’erreurs serveur et base de données
