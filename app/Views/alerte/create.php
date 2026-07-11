<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

ds_app_start('Nouvelle alerte', 'Creer une notification clinique');
?>

<form class="form-panel" action="<?= BASE_URL ?>/alerte/store" method="POST">
    <div class="form-grid">
        <label>
            Patient
            <input type="number" name="patient_id" value="3" required>
        </label>
        <label>
            Constante liee
            <input type="number" name="constante_id" value="1">
        </label>
        <label>
            Niveau
            <select name="niveau" required>
                <option value="FAIBLE">FAIBLE</option>
                <option value="MOYEN">MOYEN</option>
                <option value="ELEVE">ELEVE</option>
                <option value="CRITIQUE">CRITIQUE</option>
            </select>
        </label>
        <label>
            Statut
            <select name="statut">
                <option value="NOUVELLE">NOUVELLE</option>
                <option value="PRISE_EN_CHARGE">PRISE_EN_CHARGE</option>
                <option value="RESOLUE">RESOLUE</option>
            </select>
        </label>
        <label class="full">
            Titre
            <input type="text" name="titre" value="Anomalie de constantes vitales" required>
        </label>
        <label class="full">
            Message
            <textarea name="message" required>Une mesure depasse les seuils cliniques definis. Verification recommandee.</textarea>
        </label>
        <button class="btn-primary full" type="submit">
            <i class="fa-regular fa-bell"></i>
            Enregistrer l'alerte
        </button>
    </div>
</form>

<?php ds_app_end(); ?>
