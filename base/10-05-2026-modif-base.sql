use regime_db;

drop table activites_sportives;

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

-- Activités sportives (5 fournies + ajout)
insert into sport_categorie (nom) values 
('Cardio'),
('Renforcement musculaire'),
('Flexibilité'),
('Endurance'),
('HIIT');

insert into sport_intensite (nom) values 
('Légère'),
('Modérée'),
('Intense');

insert into sport (nom, description, id_categorie, id_intensite, variation_poids_par_heure) values 
('Course à pied', 'Activité cardio qui brûle des calories rapidement.', 1, 3, -0.30),
('Natation', 'Exercice complet qui sollicite tout le corps.', 1, 2, -0.40),
('Musculation', 'Renforcement musculaire pour prise de masse ou tonification.', 2, 3, 0.10),
('Yoga', 'Activité de flexibilité et de relaxation.', 3, 1, -0.05),
('Cyclisme', 'Exercice d’endurance pour brûler des calories sur de longues distances.', 4, 2, -0.20),
('Football', 'Sport collectif avec des phases de sprint et d’endurance.', 1, 3, -0.35),
('Randonnée', 'Activité d’endurance en plein air.', 4, 1, -0.15),
('CrossFit', 'Entraînement à haute intensité combinant cardio et musculation.', 5, 3, 0.05);



-- requetes
SELECT 
    r.id,
    r.nom,
    COUNT(crs.id_regime) AS nombre_choix,
    ROUND(COUNT(crs.id_regime) * 100.0 / (SELECT COUNT(*) FROM choix_regimes_sport), 2) AS pourcentage
FROM regimes r
LEFT JOIN choix_regimes_sport crs ON r.id = crs.id_regime
GROUP BY r.id, r.nom
ORDER BY nombre_choix DESC;
-- => popularite d un regime aupres des users