use regime_db;

drop table activites_sportives;
drop table categorie_sport;
drop table intensite_sport;
drop table sport;

create table categorie_sport (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100)
);

create table intensite_sport (
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
    foreign key (id_categorie) references categorie_sport(id),
    foreign key (id_intensite) references intensite_sport(id)
);

-- Activités sportives (5 fournies + ajout)
insert into categorie_sport (nom) values 
('Cardio'),
('Renforcement musculaire'),
('Flexibilité'),
('Endurance'),
('HIIT');

insert into intensite_sport (nom) values 
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
