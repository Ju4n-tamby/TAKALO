CREATE TABLE type_user(
    id_type_user INT PRIMARY KEY AUTO_INCREMENT,
    nom_type_user VARCHAR(50) NOT NULL
);
CREATE TABLE user(
    id_utilisateur INT PRIMARY KEY AUTO_INCREMENT,
    userename VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    id_type_user INT,
    FOREIGN KEY (id_type_user) REFERENCES type_user(id_type_user)
);

INSERT INTO type_user (nom_type_user) VALUES ('admin'), ('user');
INSERT INTO user (userename, password, id_type_user) VALUES ('admin', 'adminpassword', 1), ('user1', 'user1password', 2);
