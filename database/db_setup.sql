DROP DATABASE IF EXISTS digi_sante;

CREATE DATABASE digi_sante
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE digi_sante;

SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE,
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,

    role_id INT NOT NULL,

    prenom VARCHAR(100) NOT NULL,

    nom VARCHAR(100) NOT NULL,

    email VARCHAR(150) NULL UNIQUE,

    telephone VARCHAR(30),

    mot_de_passe VARCHAR(255) NOT NULL,

    photo VARCHAR(255) DEFAULT NULL,

    statut ENUM(
        'ACTIF',
        'INACTIF',
        'BLOQUE'
    ) DEFAULT 'ACTIF',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_utilisateur_telephone (telephone),

    CONSTRAINT fk_utilisateur_role
        FOREIGN KEY(role_id)
        REFERENCES role(id)
);

CREATE TABLE administrateur (

    utilisateur_id INT PRIMARY KEY,

    fonction VARCHAR(150),

    FOREIGN KEY(utilisateur_id)
        REFERENCES utilisateur(id)
        ON DELETE CASCADE

);

CREATE TABLE specialite (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nom VARCHAR(150) NOT NULL UNIQUE,

    description TEXT

);

CREATE TABLE service (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nom VARCHAR(150) NOT NULL UNIQUE,

    description TEXT

);

CREATE TABLE medecin (

    utilisateur_id INT PRIMARY KEY,

    numero_ordre VARCHAR(50) UNIQUE NOT NULL,

    specialite_id INT NOT NULL,

    service_id INT NOT NULL,

    disponible TINYINT(1) DEFAULT 1,

    FOREIGN KEY(utilisateur_id)
        REFERENCES utilisateur(id)
        ON DELETE CASCADE,

    FOREIGN KEY(specialite_id)
        REFERENCES specialite(id),

    FOREIGN KEY(service_id)
        REFERENCES service(id)

);

CREATE TABLE patient (

    utilisateur_id INT PRIMARY KEY,

    numero_dossier VARCHAR(50) UNIQUE NOT NULL,

    date_naissance DATE,

    sexe ENUM(
        'HOMME',
        'FEMME'
    ),

    groupe_sanguin VARCHAR(5),

    profession VARCHAR(150),

    adresse TEXT,

    taille DECIMAL(5,2),

    poids DECIMAL(5,2),

    FOREIGN KEY(utilisateur_id)
        REFERENCES utilisateur(id)
        ON DELETE CASCADE

);

SET FOREIGN_KEY_CHECKS = 1;

/*
|--------------------------------------------------------------------------
| DOSSIER MEDICAL
|--------------------------------------------------------------------------
*/

CREATE TABLE dossier_medical (

    id INT AUTO_INCREMENT PRIMARY KEY,

    patient_id INT NOT NULL UNIQUE,

    antecedents TEXT,

    allergies TEXT,

    traitements TEXT,

    observations TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_dossier_patient
        FOREIGN KEY (patient_id)
        REFERENCES patient(utilisateur_id)
        ON DELETE CASCADE

);

/*
|--------------------------------------------------------------------------
| CONTACT D'URGENCE
|--------------------------------------------------------------------------
*/

CREATE TABLE contact_urgence (

    id INT AUTO_INCREMENT PRIMARY KEY,

    patient_id INT NOT NULL,

    nom VARCHAR(100) NOT NULL,

    prenom VARCHAR(100),

    lien_parente VARCHAR(100),

    telephone VARCHAR(30) NOT NULL,

    email VARCHAR(150),

    adresse TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_contact_patient
        FOREIGN KEY (patient_id)
        REFERENCES patient(utilisateur_id)
        ON DELETE CASCADE

);

/*
|--------------------------------------------------------------------------
| CONSTANTES VITALES
|--------------------------------------------------------------------------
*/

CREATE TABLE constante_vitale (

    id INT AUTO_INCREMENT PRIMARY KEY,

    patient_id INT NOT NULL,

    medecin_id INT,

    temperature DECIMAL(4,1),

    tension_systolique SMALLINT,

    tension_diastolique SMALLINT,

    pouls SMALLINT,

    saturation DECIMAL(5,2),

    glycemie DECIMAL(5,2),

    poids DECIMAL(6,2),

    taille DECIMAL(5,2),

    imc DECIMAL(5,2),

    commentaire TEXT,

    date_mesure DATETIME DEFAULT CURRENT_TIMESTAMP,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_constante_patient
        FOREIGN KEY (patient_id)
        REFERENCES patient(utilisateur_id)
        ON DELETE CASCADE,

    CONSTRAINT fk_constante_medecin
        FOREIGN KEY (medecin_id)
        REFERENCES medecin(utilisateur_id)
        ON DELETE SET NULL

);

/*
|--------------------------------------------------------------------------
| HISTORIQUE DES CONSTANTES
|--------------------------------------------------------------------------
*/

CREATE TABLE historique_constante (

    id INT AUTO_INCREMENT PRIMARY KEY,

    constante_id INT NOT NULL,

    utilisateur_id INT NOT NULL,

    action VARCHAR(100) NOT NULL,

    ancienne_valeur TEXT,

    nouvelle_valeur TEXT,

    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_hist_constante
        FOREIGN KEY (constante_id)
        REFERENCES constante_vitale(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_hist_user
        FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateur(id)
        ON DELETE CASCADE

);

/*
|--------------------------------------------------------------------------
| CONSULTATION
|--------------------------------------------------------------------------
*/

CREATE TABLE consultation (

    id INT AUTO_INCREMENT PRIMARY KEY,

    patient_id INT NOT NULL,

    medecin_id INT NOT NULL,

    rendez_vous_id INT NULL,

    motif VARCHAR(255),

    observations TEXT,

    conclusion TEXT,

    date_consultation DATETIME NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_consultation_patient
        FOREIGN KEY (patient_id)
        REFERENCES patient(utilisateur_id)
        ON DELETE CASCADE,

    CONSTRAINT fk_consultation_medecin
        FOREIGN KEY (medecin_id)
        REFERENCES medecin(utilisateur_id)
        ON DELETE CASCADE

);

/*
|--------------------------------------------------------------------------
| DIAGNOSTIC
|--------------------------------------------------------------------------
*/

CREATE TABLE diagnostic (

    id INT AUTO_INCREMENT PRIMARY KEY,

    consultation_id INT NOT NULL,

    patient_id INT NOT NULL,

    medecin_id INT NOT NULL,

    titre VARCHAR(255) NOT NULL,

    description TEXT NOT NULL,

    gravite ENUM(
        'FAIBLE',
        'MOYEN',
        'ELEVE',
        'CRITIQUE'
    ) DEFAULT 'FAIBLE',

    statut ENUM(
        'EN_ATTENTE',
        'VALIDE',
        'ARCHIVE'
    ) DEFAULT 'EN_ATTENTE',

    date_diagnostic DATETIME DEFAULT CURRENT_TIMESTAMP,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_diag_consultation
        FOREIGN KEY (consultation_id)
        REFERENCES consultation(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_diag_patient
        FOREIGN KEY (patient_id)
        REFERENCES patient(utilisateur_id)
        ON DELETE CASCADE,

    CONSTRAINT fk_diag_medecin
        FOREIGN KEY (medecin_id)
        REFERENCES medecin(utilisateur_id)
        ON DELETE CASCADE

);

/*
|--------------------------------------------------------------------------
| ORDONNANCE
|--------------------------------------------------------------------------
*/

CREATE TABLE ordonnance (

    id INT AUTO_INCREMENT PRIMARY KEY,

    diagnostic_id INT NOT NULL,

    date_ordonnance DATETIME DEFAULT CURRENT_TIMESTAMP,

    observations TEXT,

    CONSTRAINT fk_ordonnance_diagnostic
        FOREIGN KEY (diagnostic_id)
        REFERENCES diagnostic(id)
        ON DELETE CASCADE

);

/*
|--------------------------------------------------------------------------
| PRESCRIPTION
|--------------------------------------------------------------------------
*/

CREATE TABLE prescription (

    id INT AUTO_INCREMENT PRIMARY KEY,

    ordonnance_id INT NOT NULL,

    medicament VARCHAR(255) NOT NULL,

    dosage VARCHAR(100),

    frequence VARCHAR(100),

    duree VARCHAR(100),

    instructions TEXT,

    CONSTRAINT fk_prescription_ordonnance
        FOREIGN KEY (ordonnance_id)
        REFERENCES ordonnance(id)
        ON DELETE CASCADE

);

/*
|--------------------------------------------------------------------------
| RENDEZ-VOUS
|--------------------------------------------------------------------------
*/

CREATE TABLE rendez_vous (

    id INT AUTO_INCREMENT PRIMARY KEY,

    patient_id INT NOT NULL,

    medecin_id INT NOT NULL,

    date_rendez_vous DATETIME NOT NULL,

    motif VARCHAR(255),

    statut ENUM(
        'EN_ATTENTE',
        'CONFIRME',
        'ANNULE',
        'TERMINE'
    ) DEFAULT 'EN_ATTENTE',

    observations TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_rdv_patient
        FOREIGN KEY (patient_id)
        REFERENCES patient(utilisateur_id)
        ON DELETE CASCADE,

    CONSTRAINT fk_rdv_medecin
        FOREIGN KEY (medecin_id)
        REFERENCES medecin(utilisateur_id)
        ON DELETE CASCADE

);

/*
|--------------------------------------------------------------------------
| ALERTES
|--------------------------------------------------------------------------
*/

CREATE TABLE alerte (

    id INT AUTO_INCREMENT PRIMARY KEY,

    patient_id INT NOT NULL,

    constante_id INT NULL,

    niveau ENUM(
        'FAIBLE',
        'MOYEN',
        'ELEVE',
        'CRITIQUE'
    ) NOT NULL,

    titre VARCHAR(255) NOT NULL,

    message TEXT NOT NULL,

    statut ENUM(
        'NOUVELLE',
        'PRISE_EN_CHARGE',
        'RESOLUE',
        'FERMEE'
    ) DEFAULT 'NOUVELLE',

    traite_par INT NULL,

    date_alerte DATETIME DEFAULT CURRENT_TIMESTAMP,

    date_resolution DATETIME NULL,

    CONSTRAINT fk_alerte_patient
        FOREIGN KEY (patient_id)
        REFERENCES patient(utilisateur_id)
        ON DELETE CASCADE,

    CONSTRAINT fk_alerte_constante
        FOREIGN KEY (constante_id)
        REFERENCES constante_vitale(id)
        ON DELETE SET NULL,

    CONSTRAINT fk_alerte_user
        FOREIGN KEY (traite_par)
        REFERENCES utilisateur(id)
        ON DELETE SET NULL

);

/*
|--------------------------------------------------------------------------
| NOTIFICATIONS
|--------------------------------------------------------------------------
*/

CREATE TABLE notification (

    id INT AUTO_INCREMENT PRIMARY KEY,

    utilisateur_id INT NOT NULL,

    titre VARCHAR(255) NOT NULL,

    message TEXT NOT NULL,

    est_lue TINYINT(1) DEFAULT 0,

    date_lecture DATETIME NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_notification_user
        FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateur(id)
        ON DELETE CASCADE

);

/*
|--------------------------------------------------------------------------
| RAPPORTS
|--------------------------------------------------------------------------
*/

CREATE TABLE rapport (

    id INT AUTO_INCREMENT PRIMARY KEY,

    patient_id INT NOT NULL,

    medecin_id INT NOT NULL,

    titre VARCHAR(255) NOT NULL,

    contenu LONGTEXT,

    type VARCHAR(100),

    date_generation DATETIME DEFAULT CURRENT_TIMESTAMP,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_rapport_patient
        FOREIGN KEY (patient_id)
        REFERENCES patient(utilisateur_id)
        ON DELETE CASCADE,

    CONSTRAINT fk_rapport_medecin
        FOREIGN KEY (medecin_id)
        REFERENCES medecin(utilisateur_id)
        ON DELETE CASCADE

);

/*
|--------------------------------------------------------------------------
| HISTORIQUE DES CONNEXIONS
|--------------------------------------------------------------------------
*/

CREATE TABLE historique_connexion (

    id INT AUTO_INCREMENT PRIMARY KEY,

    utilisateur_id INT NOT NULL,

    adresse_ip VARCHAR(45),

    navigateur VARCHAR(255),

    date_connexion DATETIME DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_connexion_utilisateur
        FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateur(id)
        ON DELETE CASCADE

);

/*
|--------------------------------------------------------------------------
| JOURNAL DES ACTIONS
|--------------------------------------------------------------------------
*/

CREATE TABLE journal_action (

    id INT AUTO_INCREMENT PRIMARY KEY,

    utilisateur_id INT NOT NULL,

    action VARCHAR(255) NOT NULL,

    description TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_journal_utilisateur
        FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateur(id)
        ON DELETE CASCADE

);

/*
|--------------------------------------------------------------------------
| PARAMÈTRES SYSTÈME
|--------------------------------------------------------------------------
*/

CREATE TABLE parametre_systeme (

    id INT AUTO_INCREMENT PRIMARY KEY,

    cle VARCHAR(100) NOT NULL UNIQUE,

    valeur TEXT NOT NULL,

    description VARCHAR(255),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

/*
|--------------------------------------------------------------------------
| DONNÉES DE BASE
|--------------------------------------------------------------------------
*/

INSERT INTO role (nom, description) VALUES
('Administrateur', 'Gestion complète du système'),
('Médecin', 'Personnel médical'),
('Patient', 'Patient de la plateforme');

INSERT INTO service (nom, description) VALUES
('Urgences', 'Service des urgences'),
('Cardiologie', 'Service de cardiologie'),
('Pédiatrie', 'Service de pédiatrie'),
('Médecine Générale', 'Consultations générales');

INSERT INTO specialite (nom, description) VALUES
('Médecine Générale', 'Médecin généraliste'),
('Cardiologie', 'Spécialiste du cœur'),
('Pédiatrie', 'Spécialiste des enfants'),
('Urgences', 'Médecin urgentiste');

/*
|--------------------------------------------------------------------------
| UTILISATEURS DE DÉMONSTRATION
|--------------------------------------------------------------------------
|
| Mot de passe :
| password
|
| Remplacez les hashes avant la production si nécessaire.
|--------------------------------------------------------------------------
*/

INSERT INTO utilisateur
(
    role_id,
    prenom,
    nom,
    email,
    telephone,
    mot_de_passe,
    statut
)
VALUES
(
    1,
    'Admin',
    'Digi',
    'admin@digi-sante.sn',
    '770000000',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'ACTIF'
),
(
    2,
    'Amadou',
    'Fall',
    'medecin@digi-sante.sn',
    '771111111',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'ACTIF'
),
(
    3,
    'Fatou',
    'Diop',
    'patient@digi-sante.sn',
    '772222222',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'ACTIF'
);

/*
|--------------------------------------------------------------------------
| ADMINISTRATEUR
|--------------------------------------------------------------------------
*/

INSERT INTO administrateur
(utilisateur_id, fonction)
VALUES
(1, 'Administrateur principal');

/*
|--------------------------------------------------------------------------
| MÉDECIN
|--------------------------------------------------------------------------
*/

INSERT INTO medecin
(
    utilisateur_id,
    numero_ordre,
    specialite_id,
    service_id,
    disponible
)
VALUES
(
    2,
    'ORD-2026-001',
    1,
    4,
    1
);

/*
|--------------------------------------------------------------------------
| PATIENT
|--------------------------------------------------------------------------
*/

INSERT INTO patient
(
    utilisateur_id,
    numero_dossier,
    date_naissance,
    sexe,
    groupe_sanguin,
    profession,
    adresse,
    taille,
    poids
)
VALUES
(
    3,
    'PAT-0001',
    '1998-05-14',
    'FEMME',
    'O+',
    'Étudiante',
    'Dakar',
    1.68,
    63.50
);

/*
|--------------------------------------------------------------------------
| PARAMÈTRES PAR DÉFAUT
|--------------------------------------------------------------------------
*/

INSERT INTO parametre_systeme
(cle, valeur, description)
VALUES
('app_name', 'DIGI-SANTE', 'Nom de l''application'),
('app_version', '1.0.0', 'Version'),
('maintenance', '0', 'Mode maintenance');