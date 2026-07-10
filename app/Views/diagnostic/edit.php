<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$diagnostic = $diagnostic ?? ds_demo_diagnostics()[0];

ds_app_start('Modifier diagnostic', $diagnostic['titre'] ?? 'Diagnostic');
?>

<form class="form-panel" action="<?= BASE_URL ?>/diagnostic/update?id=<?= (int) ($diagnostic['id'] ?? 0) ?>" method="POST">
    <div class="form-grid">
        <label>
            Titre
            <input type="text" name="titre" value="<?= ds_e($diagnostic['titre'] ?? '') ?>" required>
        </label>
        <label>
            Gravite
            <select name="gravite">
                <?php foreach (['FAIBLE', 'MOYEN', 'ELEVE', 'CRITIQUE'] as $value): ?>
                    <option value="<?= $value ?>" <?= ($diagnostic['gravite'] ?? '') === $value ? 'selected' : '' ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>
            Statut
            <select name="statut">
                <?php foreach (['EN_ATTENTE', 'VALIDE', 'ARCHIVE'] as $value): ?>
                    <option value="<?= $value ?>" <?= ($diagnostic['statut'] ?? '') === $value ? 'selected' : '' ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="full">
            Description
            <textarea name="description" required><?= ds_e($diagnostic['description'] ?? '') ?></textarea>
        </label>
        <button class="btn-primary full" type="submit">
            <i class="fa-regular fa-circle-check"></i>
            Mettre a jour
        </button>
    </div>
</form>

<?php ds_app_end(); ?>