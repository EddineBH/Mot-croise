-- Créer la base de données
DROP TABLE mots_croises_db;
CREATE DATABASE IF NOT EXISTS mots_croises_db;

-- Utiliser la base de données créée
USE mots_croises_db;

-- Table pour les utilisateurs
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY, -- ID unique pour l'utilisateur
    pseudo VARCHAR(100) NOT NULL,      -- Pseudo de l'utilisateur
    email VARCHAR(255) NOT NULL UNIQUE, -- Email unique de l'utilisateur
    mot_de_passe VARCHAR(255) NOT NULL, -- Mot de passe de l'utilisateur
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Date d'inscription
);

-- Table pour les mots croisés
CREATE TABLE IF NOT EXISTS mots_croises (
    id INT AUTO_INCREMENT PRIMARY KEY,      -- ID unique pour chaque mot croisé
    taille INT NOT NULL,                    -- Taille du mot croisé (ex : 10x10)
    lettres TEXT NOT NULL,                  -- Les lettres du mot croisé, stockées sous forme de chaîne
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date de création du mot croisé
    niveau INT NOT NULL,                    -- Niveau de difficulté (facile, moyen, difficile)
    theme VARCHAR(255) NOT NULL,            -- Thème du mot croisé
    meilleur_temps INT DEFAULT NULL         -- Meilleur temps obtenu en secondes
);


-- Table pour lier un utilisateur à un mot croisé
CREATE TABLE IF NOT EXISTS utilisateur_mot_croise (
    id INT AUTO_INCREMENT PRIMARY KEY,    -- ID unique pour chaque relation utilisateur-mot croisé
    utilisateur_id INT,                   -- Référence à l'utilisateur
    mot_croise_id INT,                    -- Référence au mot croisé
    temps_resolution INT,                 -- Temps en secondes pris pour résoudre le mot croisé
    date_resolution TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date de résolution
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (mot_croise_id) REFERENCES mots_croises(id) ON DELETE CASCADE
);

INSERT INTO utilisateurs (pseudo, email, mot_de_passe) 
VALUES
    ('Utilisateur1', 'user1@example.com', 'password1'),
    ('Utilisateur2', 'user2@example.com', 'password2'),
    ('Utilisateur3', 'user3@example.com', 'password3');

INSERT INTO mots_croises (taille, lettres, niveau) 
VALUES
    (5, '[["H","E","L","L","O"],["A","P","P","L","E"],["C","R","O","S","S"],["W","O","R","D","S"],["T","E","S","T","S"]]', 1),
     (7, '[[A","H","A","T","G","P","T"],["P","Y","T","H","O","N","S"],["D","A","T","A","B","A","S"],["C","O","D","E","L","A","B"],["C","O","M","P","U","T","E"],["S","T","A","C","K","S","M"],["T","E","C","H","N","O","W"]]', 2), (7, '[["K","H","A","T","G","P","T"],["P","Y","T","H","O","N","S"],["D","A","T","A","B","A","S"],["C","O","D","E","L","A","B"],["C","O","M","P","U","T","E"],["S","T","A","C","K","S","M"],["T","E","C","H","N","O","W"]]', 2),
    (7, '[["C","H","A","T","G","P","T"],["P","Y","T","H","O","N","S"],["D","A","T","A","B","A","S"],["C","O","D","E","L","A","B"],["C","O","M","P","U","T","E"],["S","T","A","C","K","S","M"],["T","E","C","H","N","O","W"]]', 2);


INSERT INTO utilisateur_mot_croise (utilisateur_id, mot_croise_id, temps_resolution) 
VALUES
    (1, 1, 300), -- Utilisateur1 a résolu le mot croisé 1 en 300 secondes
    (2, 2, 600), -- Utilisateur2 a résolu le mot croisé 2 en 600 secondes
    (3, 1, 450); -- Utilisateur3 a résolu le mot croisé 1 en 450 secondes
