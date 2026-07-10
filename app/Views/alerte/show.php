<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$alerte = $alerte ?? ds_demo_alertes()[0];

ds_app_start('Detail alerte', $alerte['titre'] ?? 'Alerte');
?>

<section class="split-grid">
    <article class="panel">
        <div class="panel-header">
            <div>
                <h2><?= ds_e($alerte['titre'] ?? 'Alerte') ?></h2>
                <p><?= ds_e($alerte['date_alerte'] ?? '') ?></p>
            </div>
            <?= ds_badge($alerte['niveau'] ?? 'MOYEN') ?>
        </div>
        <p><?= nl2br(ds_e($alerte['message'] ?? '')) ?></p>
    </article>

    <article class="panel">
        <dl class="detail-list">
            <div><dt>Patient</dt><dd>PAT-<?= ds_e($alerte['patient_id'] ?? '-') ?></dd></div>
            <div><dt>Niveau</dt><dd><?= ds_badge($alerte['niveau'] ?? 'MOYEN') ?></dd></div>
            <div><dt>Statut</dt><dd><?= ds_badge($alerte['statut'] ?? 'NOUVELLE') ?></dd></div>
            <div><dt>Action</dt><dd>Prise en charge medecin</dd></div>
        </dl>
    </article>
</section>

<?php ds_app_end(); ?>
