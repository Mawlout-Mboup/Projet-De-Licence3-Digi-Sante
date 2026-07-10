<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$user = ds_user();
$isPatient = (int) ($user['role_id'] ?? 0) === 3;

ds_app_start('Nouvelle constante', 'Saisir une mesure patient');
?>

<form class="form-panel" action="<?= BASE_URL ?>/constante/store" method="POST">
    <div class="form-grid">
        <?php if ($isPatient): ?>
            <input type="hidden" name="patient_id" value="<?= (int) ($user['id'] ?? 0) ?>">
        <?php else: ?>
            <label>
                Patient
                <input type="number" name="patient_id" value="3" required>
            </label>
            <label>
                Medecin
                <input type="number" name="medecin_id" value="<?= (int) ($user['id'] ?? 2) ?>">
            </label>
        <?php endif; ?>
        <label>
            Temperature
            <input type="number" step="0.1" name="temperature" value="36.8">
        </label>
        <label>
            Pouls
            <input type="number" name="pouls" value="72">
        </label>
        <label>
            Tension systolique
            <input type="number" name="tension_systolique" value="120">
        </label>
        <label>
            Tension diastolique
            <input type="number" name="tension_diastolique" value="80">
        </label>
        <label>
            Saturation
            <input type="number" step="0.01" name="saturation" value="98">
        </label>
        <label>
            Glycemie
            <input type="number" step="0.01" name="glycemie" value="0.98">
        </label>
        <label>
            Poids
            <input type="number" step="0.01" name="poids" value="63.5">
        </label>
        <label>
            Taille
            <input type="number" step="0.01" name="taille" value="1.68">
        </label>
        <label class="full">
            Commentaire
            <textarea name="commentaire">Mesure normale.</textarea>
        </label>
        <button class="btn-primary full" type="submit">Enregistrer</button>
    </div>
</form>

<?php ds_app_end(); ?>