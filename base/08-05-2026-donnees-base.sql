-- Utilisateurs (5 existants + ajout de gold et soldes variés)
INSERT INTO utilisateurs (nom, email, genre, mot_de_passe, role, est_gold, solde_portefeuille) VALUES 
('admin', 'admin@itu.mg', 'Homme', 'admin123', 'admin', FALSE, 0.00),
('Rojotiana', 'rojotiana@itu.mg', 'Femme', 'user123', 'user', TRUE, 15000.00),
('Feno', 'feno@itu.mg', 'Femme', 'user123', 'user', FALSE, 5000.00),
('Miora', 'miora@itu.mg', 'Femme', 'user123', 'user', FALSE, 12000.00),
('Rindra', 'rindra@itu.mg', 'Homme', 'user123', 'user', TRUE, 25000.00),
('Tahiry', 'tahiry@itu.mg', 'Homme', 'user123', 'user', FALSE, 0.00),
('Nantenaina', 'nantenaina@itu.mg', 'Femme', 'user123', 'user', TRUE, 30000.00),
('Fitia', 'fitia@itu.mg', 'Femme', 'user123', 'user', FALSE, 7500.00);

-- Données santé pour chaque utilisateur
INSERT INTO donnees_sante (id_utilisateur, taille_cm, poids_kg, date_mesure) VALUES 
(1, 175.00, 75.50, '2024-01-15 10:00:00'),
(2, 165.00, 68.00, '2024-01-10 09:30:00'),
(3, 180.00, 85.00, '2024-01-12 14:15:00'),
(4, 160.00, 55.00, '2024-01-14 11:00:00'),
(5, 170.00, 72.00, '2024-01-11 16:30:00'),
(6, 185.00, 90.00, '2024-01-13 08:45:00'),
(7, 162.00, 58.50, '2024-01-09 13:20:00'),
(8, 178.00, 80.00, '2024-01-16 10:30:00');

INSERT INTO donnees_sante (id_utilisateur, taille_cm, poids_kg, date_mesure) VALUES 
(7, 200.00, 50.00, '2024-02-15 10:00:00');  
-- Deuxième mesures pour certains (suivi)
INSERT INTO donnees_sante (id_utilisateur, taille_cm, poids_kg, date_mesure) VALUES 
(2, 165.00, 67.20, '2024-02-10 09:30:00'),
(3, 180.00, 83.50, '2024-02-12 14:15:00'),
(5, 170.00, 71.00, '2024-02-11 16:30:00');

-- Objectifs (déjà fournis, complétion)
INSERT INTO objectifs (libelle) VALUES 
('Augmenter son poids'), 
('Réduire son poids'), 
('Atteindre son IMC idéal');

-- Utilisateurs objectifs
INSERT INTO utilisateurs_objectifs (id_utilisateur, id_objectif, poids_cible, date_debut) VALUES 
(1, 2, 70.00, '2024-01-15'),  -- admin veut réduire à 70kg
(2, 3, 60.00, '2024-01-10'),  -- Rojotiana veut IMC idéal
(3, 2, 75.00, '2024-01-12'),  -- Feno veut réduire à 75kg
(4, 1, 58.00, '2024-01-14'),  -- Miora veut augmenter à 58kg
(5, 3, 75.00, '2024-01-11'),  -- Rindra veut IMC idéal
(6, 2, 80.00, '2024-01-13'),  -- Tahiry veut réduire
(7, 3, 55.00, '2024-01-09'),  -- Nantenaina veut IMC idéal
(8, 3, 80.00, '2024-01-16');  -- Fitia veut IMC idéal

-- Régimes (5 fournis + ajout de 2)
INSERT INTO regimes (nom, description, pourcentage_viande, pourcentage_poisson, pourcentage_volaille) VALUES 
('Carnivore Plus', 'Régime riche en protéines animales', 70, 10, 20),
('Oceanic', 'Régime basé sur les poissons', 10, 80, 10),
('Mixte Equilibre', 'Équilibre parfait entre toutes les protéines', 33, 33, 34),
('Volailles Legeres', 'Régime léger à base de volaille', 10, 10, 80),
('Proteine Max', 'Maximum de protéines pour la musculation', 50, 25, 25),
('Végétarien Renforcé', 'Alternatives végétales avec compléments', 0, 0, 0),
('Méditerranéen', 'Inspiration du régime méditerranéen', 25, 45, 30);

-- Régimes prix durée (chaque régime a plusieurs durées)
INSERT INTO regimes_prix_duree (id_regime, duree_semaines, variation_poids, prix) VALUES 
-- Régime 1: Carnivore Plus (prise de poids/masse musculaire)
(1, 4, 2.50, 50000),
(1, 8, 5.00, 90000),
(1, 12, 7.50, 120000),
(1, 16, 10.00, 150000),

-- Régime 2: Oceanic (perte de poids modérée)
(2, 4, -2.00, 55000),
(2, 8, -4.00, 100000),
(2, 12, -6.00, 135000),
(2, 16, -8.00, 160000),

-- Régime 3: Mixte Equilibre (variation selon durée)
(3, 4, -1.00, 45000),
(3, 8, -2.00, 85000),
(3, 12, -2.50, 110000),
(3, 16, -3.00, 130000),

-- Régime 4: Volailles Legeres (perte de poids douce)
(4, 4, -1.50, 40000),
(4, 8, -3.00, 75000),
(4, 12, -4.50, 100000),
(4, 16, -6.00, 120000),

-- Régime 5: Proteine Max (prise de poids pour sportifs)
(5, 4, 3.00, 60000),
(5, 8, 6.00, 110000),
(5, 12, 9.00, 150000),
(5, 16, 12.00, 180000),

-- Régime 6: Végétarien Renforcé (perte de poids progressive)
(6, 4, -1.80, 48000),
(6, 8, -3.50, 88000),
(6, 12, -5.00, 115000),
(6, 16, -6.50, 138000),

-- Régime 7: Méditerranéen (variation modérée selon durée)
(7, 4, -1.20, 52000),
(7, 8, -2.50, 95000),
(7, 12, -3.80, 125000),
(7, 16, -5.00, 145000);

-- Activités sportives (5 fournies + ajout)
INSERT INTO activites_sportives (nom, variation_poids_par_heure) VALUES 
('Course à pied', -0.30),
('Natation', -0.40),
('Musculation', 0.10),
('Yoga', -0.05),
('Cyclisme', -0.20),
('Football', -0.35),
('Randonnée', -0.15),
('CrossFit', 0.05);

-- Codes portefeuille (15 fournis + quelques-uns supplémentaires avec état invalide)
INSERT INTO codes_portefeuille (code, montant, est_valide) VALUES 
('RECH01', 5000, TRUE), 
('RECH02', 10000, TRUE), 
('RECH03', 20000, TRUE), 
('RECH04', 5000, TRUE), 
('RECH05', 10000, TRUE),
('RECH06', 20000, TRUE), 
('RECH07', 5000, TRUE), 
('RECH08', 10000, TRUE), 
('RECH09', 20000, TRUE), 
('RECH10', 5000, TRUE),
('RECH11', 10000, TRUE), 
('RECH12', 20000, TRUE), 
('RECH13', 5000, TRUE), 
('RECH14', 10000, TRUE), 
('RECH15', 50000, TRUE),
('GOLD100', 100000, TRUE),
('EXPIRED01', 25000, FALSE),
('EXPIRED02', 15000, FALSE),
('SPECIAL50', 50000, TRUE);

-- Utilisation des codes (code_users)
INSERT INTO code_users (id_code, id_utilisateur, date_utilisation_code) VALUES 
(1, 2, '2024-01-05 10:30:00'),  -- Rojotiana a utilisé RECH01
(2, 3, '2024-01-08 14:15:00'),  -- Feno a utilisé RECH02
(4, 4, '2024-01-10 09:00:00'),  -- Miora a utilisé RECH04
(5, 5, '2024-01-12 16:45:00'),  -- Rindra a utilisé RECH05
(7, 6, '2024-01-15 11:20:00'),  -- Tahiry a utilisé RECH07
(3, 2, '2024-01-20 13:30:00'),  -- Rojotiana a aussi utilisé RECH03
(16, 2, '2024-02-01 10:00:00'), -- Rojotiana a utilisé GOLD100
(8, 7, '2024-01-18 08:45:00');  -- Nantenaina a utilisé RECH08

-- Achats gold (utilisateurs premium)
INSERT INTO achats_gold (id_utilisateur, date_achat, montant_paye) VALUES 
(2, '2024-01-05 10:35:00', 29.99),   -- Rojotiana est devenue gold
(5, '2024-01-12 16:50:00', 29.99),   -- Rindra est devenue gold
(7, '2024-01-18 08:50:00', 29.99),   -- Nantenaina est devenue gold
(2, '2024-02-01 10:05:00', 29.99),   -- Rojotiana a renouvelé
(5, '2024-02-10 09:00:00', 29.99);   -- Rindra a renouvelé

-- Quelques transactions de portefeuille supplémentaires (via mises à jour)
UPDATE utilisateurs SET solde_portefeuille = 15000 + 5000 + 20000 + 100000 
WHERE id = 2 AND nom = 'Rojotiana';  -- Total: 140000 solde réel

UPDATE utilisateurs SET solde_portefeuille = 25000 + 10000 
WHERE id = 5 AND nom = 'Rindra';  -- Total: 35000

UPDATE utilisateurs SET solde_portefeuille = 30000 + 10000 
WHERE id = 7 AND nom = 'Nantenaina';  -- Total: 40000

UPDATE utilisateurs SET solde_portefeuille = 12000 WHERE id = 4;  -- Miora: 12000
UPDATE utilisateurs SET solde_portefeuille = 5000 WHERE id = 3;   -- Feno: 5000
UPDATE utilisateurs SET solde_portefeuille = 0 WHERE id = 6;      -- Tahiry: 0
UPDATE utilisateurs SET solde_portefeuille = 7500 WHERE id = 8;   -- Fitia: 7500

INSERT INTO options_gold (id, prix, description) VALUES 
(1, 29.99, 'Abonnement Gold pour 1 mois'),
(2, 79.99, 'Abonnement Gold pour 3 mois'),
(3, 149.99, 'Abonnement Gold pour 6 mois'),
(4, 279.99, 'Abonnement Gold pour 12 mois');


insert into choix_regimes_sport (id_utilisateur, id_regime, id_sport) values
(2, 1, 3),  -- Rojotiana a choisi Carnivore Plus et Musculation
(3, 2, 1),  -- Feno a choisi Oceanic et Course à pied
(4, 4, 4),  -- Miora a choisi Volailles Legeres et Yoga
(5, 5, 2),  -- Rindra a choisi Proteine Max et Natation
(6, 2, 1),  -- Tahiry a choisi Oceanic et Course à pied
(7, 6, 7),  -- Nantenaina a choisi Végétarien Renforcé et Randonnée
(8, 7, 8);  -- Fitia a choisi Méditerranéen et CrossFit