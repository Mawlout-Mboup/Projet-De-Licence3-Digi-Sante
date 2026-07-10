<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$constante = $constante ?? ds_demo_constantes()[0];

ds_app_start('Modifier constante', 'Mettre a jour le releve vital');
?>

<form class="form-panel" action="<?= BASE_URL ?>/constante/update?id=<?= (int) ($constante['id'] ?? 0) ?>" method="POST">
    <div class="form-grid">
        <label>
            Temperature
            <input type="number" step="0.1" name="temperature" value="<?= ds_e($constante['temperature'] ?? '') ?>">
        </label>
        <label>
            Pouls
            <input type="number" name="pouls" value="<?= ds_e($constante['pouls'] ?? '') ?>">
        </label>
        <label>
            Tension systolique
            <input type="number" name="tension_systolique" value="<?= ds_e($constante['tension_systolique'] ?? '') ?>">
        </label>
        <label>
            Tension diastolique
            <input type="number" name="tension_diastolique" value="<?= ds_e($constante['tension_diastolique'] ?? '') ?>">
        </label>
        <label>
            Saturation
            <input type="number" step="0.01" name="saturation" value="<?= ds_e($constante['saturation'] ?? '') ?>">
        </label>
        <label>
            Glycemie
            <input type="number" step="0.01" name="glycemie" value="<?= ds_e($constante['glycemie'] ?? '') ?>">
        </label>
        <label class="full">
            Commentaire
            <textarea name="commentaire"><?= ds_e($constante['commentaire'] ?? '') ?></textarea>
        </label>
        <button class="btn-primary full" type="submit">Mettre a jour</button>
    </div>
</form>

<?php ds_app_end(); ?>
