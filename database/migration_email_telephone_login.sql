USE digi_sante;

ALTER TABLE utilisateur
    MODIFY email VARCHAR(150) NULL;

UPDATE utilisateur
SET email = NULL
WHERE email = '';

CREATE INDEX idx_utilisateur_telephone
    ON utilisateur (telephone);
