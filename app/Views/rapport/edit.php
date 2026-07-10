<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$rapport = $rapport ?? ds_demo_rapports()[0];

ds_app_start('Modifier rapport', $rapport['titre'] ?? 'Rapport');
?>

<form class="form-panel" action="<?= BASE_URL ?>/rapport/update?id=<?= (int) ($rapport['id'] ?? 0) ?>" method="POST">
    <div class="form-grid">
        <label>
            Titre
            <input type="text" name="titre" value="<?= ds_e($rapport['titre'] ?? '') ?>" required>
        </label>
        <label>
            Type
            <input type="text" name="type" value="<?= ds_e($rapport['type'] ?? 'Diagnostic PDF') ?>">
        </label>
        <label class="full">
            Contenu
            <textarea name="contenu"><?= ds_e($rapport['contenu'] ?? '') ?></textarea>
        </label>
        <button class="btn-primary full" type="submit">Mettre a jour</button>
    </div>
</form>

<?php ds_app_end(); ?>
