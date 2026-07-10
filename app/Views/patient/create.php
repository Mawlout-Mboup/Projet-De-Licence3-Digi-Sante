<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

ds_app_start('Nouveau patient', 'Creer une fiche de suivi medical');
?>

<form class="form-panel" action="<?= BASE_URL ?>/patient/store" method="POST">
    <div class="form-grid">
        <label>
            ID utilisateur
            <input type="number" name="utilisateur_id" placeholder="Ex: 3" required>
        </label>
        <label>
            Numero dossier
            <input type="text" name="numero_dossier" value="PAT-0011" required>
        </label>
        <label>
            Date naissance
            <input type="date" name="date_naissance" required>
        </label>
        <label>
            Sexe
            <select name="sexe" required>
                <option value="FEMME">Femme</option>
                <option value="HOMME">Homme</option>
            </select>
        </label>
        <label>
            Groupe sanguin
            <select name="groupe_sanguin">
                <option value="">Choisir</option>
                <option>O+</option>
                <option>O-</option>
                <option>A+</option>
                <option>A-</option>
                <option>B+</option>
                <option>B-</option>
                <option>AB+</option>
                <option>AB-</option>
            </select>
        </label>
        <label>
            Profession
            <input type="text" name="profession" placeholder="Profession">
        </label>
        <label class="full">
            Adresse
            <input type="text" name="adresse" placeholder="Ville, quartier">
        </label>
        <label>
            Taille
            <input type="number" step="0.01" name="taille" value="1.70">
        </label>
        <label>
            Poids
            <input type="number" step="0.01" name="poids" value="65">
        </label>
        <button class="btn-primary full" type="submit">Enregistrer le patient</button>
    </div>
</form>

<?php ds_app_end(); ?>
