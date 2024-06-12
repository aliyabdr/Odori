-- create_database.sql

-- Datenbank erstellen
CREATE DATABASE IF NOT EXISTS kleinanzeigenplattform;

-- Datenbank verwenden
USE kleinanzeigenplattform;

-- Tabelle users erstellen
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    benutzername VARCHAR(255) NOT NULL,
    passwort VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    plz VARCHAR(10),
    standort VARCHAR(255),
    profilbild TEXT,
    ueber_mich TEXT,
    erstellt_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabelle ads erstellen
CREATE TABLE IF NOT EXISTS ads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titel VARCHAR(255) NOT NULL,
    beschreibung TEXT NOT NULL,
    kategorie VARCHAR(255) NOT NULL,
    preis DECIMAL(10, 2) NOT NULL,
    preistyp VARCHAR(50) NOT NULL,
    bilder TEXT,
    status TINYINT(1) DEFAULT 1,
    erstellt_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE ads ADD user_id INT;
ALTER TABLE ads ADD FOREIGN KEY (user_id) REFERENCES users(id);
