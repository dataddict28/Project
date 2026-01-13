CREATE DATABASE IF NOT EXISTS faculte;
USE faculte;

CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  mot_de_passe VARCHAR(255) NOT NULL,
  role ENUM('admin', 'enseignant', 'etudiant') NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE enseignants (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT UNIQUE NOT NULL,
  specialite VARCHAR(100),
  telephone VARCHAR(20),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE cours (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR(100) NOT NULL,
  code VARCHAR(20) UNIQUE NOT NULL,
  description TEXT,
  enseignant_id INT NOT NULL,
  credits INT DEFAULT 3,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (enseignant_id) REFERENCES enseignants(id) ON DELETE CASCADE
);

CREATE TABLE etudiants (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT UNIQUE NOT NULL,
  numero_matricule VARCHAR(50) UNIQUE NOT NULL,
  date_naissance DATE,
  adresse TEXT,
  telephone VARCHAR(20),
  photo VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE inscriptions (
  id INT PRIMARY KEY AUTO_INCREMENT,
  etudiant_id INT NOT NULL,
  cours_id INT NOT NULL,
  date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_inscription (etudiant_id, cours_id),
  FOREIGN KEY (etudiant_id) REFERENCES etudiants(id) ON DELETE CASCADE,
  FOREIGN KEY (cours_id) REFERENCES cours(id) ON DELETE CASCADE
);

CREATE TABLE absences (
  id INT PRIMARY KEY AUTO_INCREMENT,
  etudiant_id INT NOT NULL,
  cours_id INT NOT NULL,
  date_absence DATE NOT NULL,
  statut ENUM('present', 'absent') NOT NULL DEFAULT 'absent',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_absence (etudiant_id, cours_id, date_absence),
  FOREIGN KEY (etudiant_id) REFERENCES etudiants(id) ON DELETE CASCADE,
  FOREIGN KEY (cours_id) REFERENCES cours(id) ON DELETE CASCADE
);

CREATE TABLE paiements (
  id INT PRIMARY KEY AUTO_INCREMENT,
  etudiant_id INT NOT NULL,
  montant DECIMAL(10,2) NOT NULL,
  date_paiement TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  statut ENUM('paye', 'non_paye') NOT NULL DEFAULT 'non_paye',
  FOREIGN KEY (etudiant_id) REFERENCES etudiants(id) ON DELETE CASCADE
);

ALTER TABLE etudiants ADD COLUMN semestre1_valide BOOLEAN DEFAULT FALSE;
ALTER TABLE etudiants ADD COLUMN semestre2_valide BOOLEAN DEFAULT FALSE;

INSERT INTO users (nom, email, mot_de_passe, role) VALUES 
('Administrateur', 'admin@faculte.com', '$2y$10$YbYYDKLHvFRJmKNcgXZLa.PkCgJN.aEAOvWqXcx3m1mCXPPgVGh7m', 'admin');
