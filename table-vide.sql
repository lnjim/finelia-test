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