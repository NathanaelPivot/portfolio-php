DROP DATABASE IF EXISTS projetb2;

CREATE DATABASE IF NOT EXISTS projetb2;

CREATE USER IF NOT EXISTS 'projetb2'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON projetb2.* TO 'projetb2'@'localhost';

USE projetb2;

CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       username VARCHAR(50),
                       email VARCHAR(100),
                       password VARCHAR(255),
                       role ENUM('admin', 'user') DEFAULT 'user',
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

CREATE TABLE skills (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(255) NOT NULL,
                        description TEXT DEFAULT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

CREATE TABLE IF NOT EXISTS user_skills (
                                           id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL, -- Lien vers les utilisateurs
    skill_id INT NOT NULL, -- Lien vers les compétences
    level ENUM('débutant', 'intermédiaire', 'avancé', 'expert') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (skill_id) REFERENCES skills(id)
);


CREATE TABLE projects (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          user_id INT,
                          title VARCHAR(255),
                          description TEXT,
                          image_path VARCHAR(255),
                          link VARCHAR(255),
                          FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users (username, email, password, role)
VALUES ('admin', 'admin@example.com', '$2y$10$vT/q/xvjs.SE47Lejlpqx.zIITFSnPEDZZeZzmMv9Ok.jlTKYzSwS', 'admin');

INSERT INTO users (username, email, password, role)
VALUES ('user', 'user@example.com', '$2y$10$vT/q/xvjs.SE47Lejlpqx.zIITFSnPEDZZeZzmMv9Ok.jlTKYzSwS', 'user');

INSERT INTO skills (name, description) VALUES
                                           ('PHP', 'Langage de programmation backend.'),
                                           ('JavaScript', 'Langage utilisé pour le frontend et le backend.'),
                                           ('SQL', 'Langage de manipulation de données dans une base de données.');
