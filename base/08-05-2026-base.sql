DROP DATABASE regime_db;
CREATE DATABASE regime_db;
USE regime_db;

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    genre ENUM('Homme', 'Femme', 'Autre') DEFAULT 'Homme',
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    est_gold BOOLEAN DEFAULT FALSE, 
    solde_portefeuille DECIMAL(10, 2) DEFAULT 0.00 
);

CREATE TABLE donnees_sante (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT,
    taille_cm DECIMAL(5, 2),
    poids_kg DECIMAL(5, 2),
    date_mesure TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id)
);

CREATE TABLE objectifs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(50)
);

CREATE TABLE utilisateurs_objectifs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT,
    id_objectif INT,
    poids_cible DECIMAL(5, 2),
    date_debut DATE,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id),
    FOREIGN KEY (id_objectif) REFERENCES objectifs(id)
);

CREATE TABLE regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    description TEXT,
    pourcentage_viande DECIMAL(5, 2),
    pourcentage_poisson DECIMAL(5, 2),
    pourcentage_volaille DECIMAL(5, 2)
);

CREATE TABLE regimes_prix_duree (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_regime INT,
    duree_semaines INT,
    variation_poids DECIMAL(5, 2), 
    prix DECIMAL(10, 2),
    FOREIGN KEY (id_regime) REFERENCES regimes(id)
);

create table sport_categorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100)
);

create table sport_intensite (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100)
);

CREATE TABLE sport (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    description TEXT,
    id_categorie INT,
    id_intensite INT,
    variation_poids_par_heure DECIMAL(5, 2),
    foreign key (id_categorie) references sport_categorie(id),
    foreign key (id_intensite) references sport_intensite(id)
);


CREATE TABLE codes_portefeuille (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) UNIQUE,
    montant DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_expiration TIMESTAMP DEFAULT DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 30 DAY),
    est_valide BOOLEAN DEFAULT TRUE
);

CREATE TABLE code_users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_code INT,
    id_utilisateur INT,
    date_utilisation_code TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_code) REFERENCES codes_portefeuille(id),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id)
);

CREATE TABLE achats_gold (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT,
    date_achat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    montant_paye DECIMAL(10, 2),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id)
);

CREATE TABLE options_gold (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prix DECIMAL(10,2),
    description VARCHAR(255)
);


CREATE TABLE choix_regimes_sport (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT,
    id_regime INT,
    id_sport INT,
    prix_precis DECIMAL(10, 2),
    semaine_precis DECIMAL(6, 1),
    date_choix TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id),
    FOREIGN KEY (id_regime) REFERENCES regimes(id),
    FOREIGN KEY (id_sport) REFERENCES sport(id)

);



    