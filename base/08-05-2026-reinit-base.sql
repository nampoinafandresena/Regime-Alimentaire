-- Méthode 1: Pour une table spécifique
ALTER TABLE utilisateurs AUTO_INCREMENT = 1;

-- Méthode 2: Pour toutes les tables après DELETE
SET FOREIGN_KEY_CHECKS = 0;
DELETE FROM code_users;
DELETE FROM achats_gold;
DELETE FROM utilisateurs_objectifs;
DELETE FROM donnees_sante;
DELETE FROM regimes_prix_duree;
DELETE FROM activites_sportives;
DELETE FROM codes_portefeuille;
DELETE FROM regimes;
DELETE FROM objectifs;
DELETE FROM utilisateurs;
SET FOREIGN_KEY_CHECKS = 1;

-- Réinitialiser tous les auto_increment
ALTER TABLE utilisateurs AUTO_INCREMENT = 1;
ALTER TABLE donnees_sante AUTO_INCREMENT = 1;
ALTER TABLE objectifs AUTO_INCREMENT = 1;
ALTER TABLE utilisateurs_objectifs AUTO_INCREMENT = 1;
ALTER TABLE regimes AUTO_INCREMENT = 1;
ALTER TABLE regimes_prix_duree AUTO_INCREMENT = 1;
ALTER TABLE activites_sportives AUTO_INCREMENT = 1;
ALTER TABLE codes_portefeuille AUTO_INCREMENT = 1;
ALTER TABLE code_users AUTO_INCREMENT = 1;
ALTER TABLE achats_gold AUTO_INCREMENT = 1;