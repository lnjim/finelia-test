DROP DATABASE IF EXISTS finelia_test;
CREATE DATABASE finelia_test;

use finelia_test;

CREATE TABLE Etudiant(
    id_etu INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL
);

CREATE TABLE Matiere(
    id_mat INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    UNIQUE(nom)
);

CREATE TABLE Note(
    id_note INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    valeur FLOAT NOT NULL,
    coefficient INT NOT NULL,
    etu_id INT NOT NULL,
    mat_id INT NOT NULL,
    FOREIGN KEY (etu_id) 
    	REFERENCES Etudiant(id_etu) 
    	ON DELETE CASCADE,
    FOREIGN KEY (mat_id) 
    	REFERENCES Matiere(id_mat) 
    	ON DELETE CASCADE
);

INSERT INTO Etudiant (nom, prenom)
VALUES
('bader', 'idriss'),
('reut', 'louis'),
('pomil', 'mike');

INSERT INTO Matiere (nom)
VALUES
('math'),
('informatique'),
('anglais');

INSERT INTO Note (valeur, coefficient, etu_id, mat_id)
VALUES
(13, 2, 1, 1),
(7, 2, 3, 1),
(15, 2, 2, 1),
(17, 2, 3, 2),
(12, 2, 1, 2),
(8, 2, 2, 2),
(10, 1, 2, 3),
(15, 1, 3, 3),
(12, 1, 1, 3);