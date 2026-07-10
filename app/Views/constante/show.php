<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$constante = $constante ?? ds_demo_constantes()[0];

ds_app_start('Details des constantes', 'Mesure du ' . ($constante['date_mesure'] ?? ''));
?>

<section class="split-grid">
    <article class="panel">
        <div class="panel-header">
            <div>
                <h2>Releve vital</h2>
                <p>Patient PAT-<?= ds_e($constante['patient_id'] ?? '-') ?></p>
            </div>
            <?= ds_badge(((float) ($constante['temperature'] ?? 0) > 38) ? 'ATTENTION' : 'NORMAL') ?>
        </div>

        <dl class="detail-list">
            <div><dt>Temperature</dt><dd><?= ds_e($constante['temperature'] ?? '-') ?> C</dd></div>
            <div><dt>Tension</dt><dd><?= ds_e($constante['tension_systolique'] ?? '-') ?>/<?= ds_e($constante['tension_diastolique'] ?? '-') ?></dd></div>
            <div><dt>Pouls</dt><dd><?= ds_e($constante['pouls'] ?? '-') ?> bpm</dd></div>
            <div><dt>Saturation</dt><dd><?= ds_e($constante['saturation'] ?? '-') ?> %</dd></div>
            <div><dt>Glycemie</dt><dd><?= ds_e($constante['glycemie'] ?? '-') ?> g/L</dd></div>
            <div><dt>IMC</dt><dd><?= ds_e($constante['imc'] ?? '-') ?></dd></div>
        </dl>
    </article>

    <article class="chart-card">
        <h2>Courbe associee</h2>
        <p>Evolution indicative de la mesure.</p>
        <svg class="mini-chart" viewBox="0 0 360 150" role="img" aria-label="Courbe">
            <path class="area" d="M20 108 L80 90 L140 72 L210 80 L280 58 L340 70 L340 130 L20 130 Z"></path>
            <polyline points="20,108 80,90 140,72 210,80 280,58 340,70"></polyline>
        </svg>
        <p style="margin-top:16px"><?= nl2br(ds_e($constante['commentaire'] ?? '')) ?></p>
    </article>
</section>

<?php ds_app_end(); ?>
