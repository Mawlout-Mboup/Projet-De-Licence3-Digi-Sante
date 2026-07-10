# DIGI-SANTE

Plateforme medicale de surveillance des constantes vitales, gestion des alertes,
diagnostics et rapports PDF.

## Espaces

- Administrateur : gestion des medecins, patients, statistiques et parametres.
- Medecin : suivi des patients, constantes, alertes, diagnostics et rapports.
- Patient : saisie et consultation de ses constantes.

## Acces

- Connexion admin : `/public/login/admin`
- Connexion medecin : `/public/login/medecin`
- Connexion patient : `/public/login/patient`

Les modules internes demandent une connexion et redirigent vers l'espace du role connecte.

## Installation locale

1. Copier le dossier dans `C:\xampp\htdocs`.
2. Renommer le dossier comme souhaite, par exemple `DGS`.
3. Copier `.env.example` vers `.env`.
4. Verifier les identifiants MySQL dans `.env`.
5. Importer `database/db_setup.sql` dans MySQL.
6. Ouvrir `http://localhost/NOM_DU_DOSSIER/public`.

`APP_URL=auto` permet a l'application de fonctionner meme si le dossier est renomme.

## Connexion

La connexion accepte maintenant un email ou un numero de telephone.

Comptes de demonstration apres import SQL :

- Admin : `admin@digi-sante.sn` ou `770000000`
- Medecin : `medecin@digi-sante.sn` ou `771111111`
- Patient : `patient@digi-sante.sn` ou `772222222`
- Mot de passe : `password`

## Base deja existante

Si la base `digi_sante` existe deja, executer une seule fois :

```sql
source database/migration_email_telephone_login.sql;
```

Cela permet de creer un compte avec un email ou un telephone.

## GitHub

Le fichier `.env` local est ignore par Git. Publier le projet avec `.env.example`, puis configurer le vrai `.env` sur chaque machine ou serveur.
