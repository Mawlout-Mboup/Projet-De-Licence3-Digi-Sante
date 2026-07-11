<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$alerte = $alerte ?? ds_demo_alertes()[0];

ds_app_start('Modifier alerte', $alerte['titre'] ?? 'Alerte');
?>

<form class="form-panel" action="<?= BASE_URL ?>/alerte/update?id=<?= (int) ($alerte['id'] ?? 0) ?>" method="POST">
    <div class="form-grid">
        <label>
            Niveau
            <select name="niveau">
                <?php foreach (['FAIBLE', 'MOYEN', 'ELEVE', 'CRITIQUE'] as $value): ?>
                    <option value="<?= $value ?>" <?= ($alerte['niveau'] ?? '') === $value ? 'selected' : '' ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>
            Statut
            <select name="statut">
                <?php foreach (['NOUVELLE', 'PRISE_EN_CHARGE', 'RESOLUE', 'FERMEE'] as $value): ?>
                    <option value="<?= $value ?>" <?= ($alerte['statut'] ?? '') === $value ? 'selected' : '' ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="full">
            Titre
            <input type="text" name="titre" value="<?= ds_e($alerte['titre'] ?? '') ?>">
        </label>
        <label class="full">
            Message
            <textarea name="message"><?= ds_e($alerte['message'] ?? '') ?></textarea>
        </label>
        <button class="btn-primary full" type="submit">Mettre a jour</button>
    </div>
</form>

<?php ds_app_end(); ?>
