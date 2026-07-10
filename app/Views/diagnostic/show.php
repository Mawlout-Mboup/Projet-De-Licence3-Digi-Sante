<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$diagnostic = $diagnostic ?? ds_demo_diagnostics()[0];

ds_app_start('Detail diagnostic', $diagnostic['titre'] ?? 'Diagnostic');
?>

<section class="split-grid">
    <article class="panel">
        <div class="panel-header">
            <div>
                <h2><?= ds_e($diagnostic['titre'] ?? 'Diagnostic') ?></h2>
                <p><?= ds_e($diagnostic['date_diagnostic'] ?? '') ?></p>
            </div>
            <?= ds_badge($diagnostic['gravite'] ?? 'MOYEN') ?>
        </div>

        <p><?= nl2br(ds_e($diagnostic['description'] ?? '')) ?></p>
    </article>

    <article class="panel">
        <dl class="detail-list">
            <div><dt>Patient</dt><dd>PAT-<?= ds_e($diagnostic['patient_id'] ?? '-') ?></dd></div>
            <div><dt>Medecin</dt><dd>MED-<?= ds_e($diagnostic['medecin_id'] ?? '-') ?></dd></div>
            <div><dt>Statut</dt><dd><?= ds_badge($diagnostic['statut'] ?? 'EN_ATTENTE') ?></dd></div>
            <div><dt>Rapport</dt><dd>PDF pret</dd></div>
        </dl>
    </article>
</section>

<?php ds_app_end(); ?>