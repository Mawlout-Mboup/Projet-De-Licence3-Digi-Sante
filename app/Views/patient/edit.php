<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$patient = $patient ?? ds_demo_patients()[0];

ds_app_start('Modifier patient', ($patient['prenom'] ?? '') . ' ' . ($patient['nom'] ?? ''));
?>

<form class="form-panel" action="<?= BASE_URL ?>/patient/update?id=<?= (int) ($patient['utilisateur_id'] ?? 0) ?>" method="POST">
    <div class="form-grid">
        <label>
            Profession
            <input type="text" name="profession" value="<?= ds_e($patient['profession'] ?? '') ?>">
        </label>
        <label>
            Adresse
            <input type="text" name="adresse" value="<?= ds_e($patient['adresse'] ?? '') ?>">
        </label>
        <label>
            Taille
            <input type="number" step="0.01" name="taille" value="<?= ds_e($patient['taille'] ?? '') ?>">
        </label>
        <label>
            Poids
            <input type="number" step="0.01" name="poids" value="<?= ds_e($patient['poids'] ?? '') ?>">
        </label>
        <button class="btn-primary full" type="submit">Mettre a jour</button>
    </div>
</form>

<?php ds_app_end(); ?>