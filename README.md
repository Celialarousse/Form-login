🏍️ BikePulse
Un catalogue de motos complet, sécurisé et responsive développé en PHP et MySQL.
BikePulse permet aux utilisateurs de consulter des fiches techniques de motos, et aux membres connectés de gérer le catalogue (ajout, modification, suppression).

----------------------------------------------------------------------------------------------------------------------------------

📌 Fonctionnalités
🔓 Accès public
        -Consultation de toutes les fiches motos
        -Recherche par marque ou modèle
        -Filtrage par type (Roadster, Sportive, Trail, Motocross, Custom)
        -Tri par année, puissance ou cylindrée
        -Page de détail par moto

🔐 Accès membres (connectés)
        -Inscription sécurisée avec confirmation du mot de passe
        -Connexion avec vérification des identifiants
        -Ajout d'une moto avec upload d'image
        -Modification d'une fiche existante
        -Suppression sécurisée (confirmation requise)
        -Déconnexion

🛡️ Sécurité
        -Mots de passe hashés avec password_hash / password_verify
        -Requêtes SQL préparées via PDO (protection contre les injections)
        -Protection CSRF sur tous les formulaires
        -Vérification du type MIME réel des images uploadées
        -Pages d'administration protégées par session

----------------------------------------------------------------------------------------------------------------------------------

🗂️ Structure du projet

Formulaire/
│
├── assets/
│   └── styles.css              # Feuille de style globale
│
├── auth/
│   ├── login.php               # Page de connexion
│   ├── login_process.php       # Traitement de la connexion
│   ├── logout.php              # Déconnexion
│   ├── signup.php              # Page d'inscription
│   └── signup_process.php      # Traitement de l'inscription
│
├── config/
│   ├── config.php              # Connexion PDO (ignoré par git)
│   └── config.example.php      # Modèle de configuration à copier
│
├── img/
│   ├── motocross-1280721_640.jpg
│   └── motoooo.jpg
│
├── motos/
│   ├── motos.php               # Liste des fiches motos
│   ├── moto_detail.php         # Détail d'une moto
│   ├── add_moto.php            # Formulaire d'ajout
│   ├── add_moto_process.php    # Traitement de l'ajout
│   ├── edit_moto.php           # Formulaire de modification
│   ├── edit_moto_process.php   # Traitement de la modification
│   └── delete_moto.php         # Traitement de la suppression
│
├── uploads/
│   └── motos/                  # Images uploadées des motos
│
├── home.php                    # Page d'accueil
├── test_login.php              # Test de connexion à la base de données
├── .gitignore                  # Fichiers ignorés par git
└── README.md                   # Ce fichier

----------------------------------------------------------------------------------------------------------------------------------

🛠️ Installation
Prérequis
    -PHP 7.4 ou supérieur
    -MySQL ou MariaDB
    -Un serveur web : Apache, Nginx ou Docker

----------------------------------------------------------------------------------------------------------------------------------

Étape 1 — Cloner le dépôt

    git clone https://github.com/ton-utilisateur/bikepulse.git
    cd bikepulse

Étape 2 — Configurer la base de données
Crée une base de données MySQL et exécute le schéma suivant :

    CREATE DATABASE db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

    USE db;

    CREATE TABLE utilisateurs (
        id          INT AUTO_INCREMENT PRIMARY KEY,
        nom         VARCHAR(100) NOT NULL,
        prenom      VARCHAR(100) NOT NULL,
        email       VARCHAR(150) NOT NULL UNIQUE,
        mot_de_passe VARCHAR(255) NOT NULL,
        is_active   TINYINT(1) NOT NULL DEFAULT 1,
        created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE motos (
        id          INT AUTO_INCREMENT PRIMARY KEY,
        marque      VARCHAR(100) NOT NULL,
        modele      VARCHAR(100) NOT NULL,
        type        ENUM('roadster','sportive','trail','motocross','custom') NOT NULL,
        annee       YEAR,
        cylindree   INT,
        puissance   INT,
        description TEXT,
        image       VARCHAR(255),
        created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

Étape 3 — Configurer la connexion
Copie le fichier exemple et remplis tes informations :

    cp config/config.example.php config/config.php

Puis édite config/config.php :

    $host = 'localhost';      // ou 'my_mysql' si Docker
    $db   = 'db';             // nom de ta base
    $user = 'ton_user';       // utilisateur MySQL
    $pass = 'ton_mot_de_passe';

Étape 4 — Créer le dossier d'uploads

    mkdir -p uploads/motos
    chmod 755 uploads/motos

Étape 5 — Lancer le projet
Avec Docker, si tu as un docker-compose.yml :

    docker-compose up -d

Avec PHP built-in server (développement local) :

    php -S localhost:8000

Puis ouvre http://localhost:8000/home.php


----------------------------------------------------------------------------------------------------------------------------------

🐳 Configuration Docker
Si tu utilises Docker, le nom du service MySQL dans config.php doit correspondre à celui de ton docker-compose.yml :

    $host = 'my_mysql'; // nom du service MySQL dans docker-compose.yml

Tu peux tester la connexion à tout moment en visitant :

    http://localhost/Formulaire/test_login.php

----------------------------------------------------------------------------------------------------------------------------------

🔒 Sécurité & bonnes pratiques
        -config.php est listé dans .gitignore — ne le commite jamais
        -Utilise config.example.php comme modèle pour les autres développeurs
        -En production, désactive l'affichage des erreurs PHP (display_errors = Off)
        -Assure-toi que le dossier uploads/motos/ n'est pas listable (directive Options -Indexes sur Apache)

----------------------------------------------------------------------------------------------------------------------------------

🚀 Technologies utilisées

Technologie :
    -PHP 7.4+ --> Back-end, sessions, logique métier
    -MySQL/MariaDB --> Base de données
    -PDO --> Accès sécurisé à la base de données
    -HTML5/CSS3 --> Interface utilisateur
    -Google Fonts --> Typographies (Bebas Neue, DM Sans)
    -Docker --> Environnement de développement

