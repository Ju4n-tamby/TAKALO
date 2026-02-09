DROP DATABASE IF EXISTS Takalo;
CREATE DATABASE IF NOT EXISTS Takalo;
Use Takalo;
CREATE TABLE type_user(
    id_type_user INT PRIMARY KEY AUTO_INCREMENT,
    nom_type_user VARCHAR(50) NOT NULL
);
CREATE TABLE user(
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    id_type_user INT,
    FOREIGN KEY (id_type_user) REFERENCES type_user(id_type_user)
);

CREATE TABLE category(
    id_category INT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO type_user (nom_type_user) VALUES ('admin'), ('user');
INSERT INTO user (username, password, id_type_user) VALUES ('admin', 'adminpassword', 1), ('user1', 'user1password', 2);

INSERT INTO category (libelle) VALUES ('Electronics'), ('Books'), ('Clothing');