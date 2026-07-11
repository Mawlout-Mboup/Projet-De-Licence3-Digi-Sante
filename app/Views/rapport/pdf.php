<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$rapport = $rapport ?? ds_demo_rapports()[0];

ds_app_start('Apercu PDF', $rapport['titre'] ?? 'Rapport medical');
?>

<section class="pdf-preview pdf-document">
    <header>
        <strong>Digi-Sante</strong>
        <span>Rapport medical</span>
    </header>

    <h2><?= ds_e($rapport['titre'] ?? 'Rapport') ?></h2>
    <p class="muted">Patient PAT-<?= ds_e($rapport['patient_id'] ?? '-') ?> - Medecin MED-<?= ds_e($rapport['medecin_id'] ?? '-') ?></p>

    <span class="pdf-line"></span>
    <span class="pdf-line short"></span>
    <span class="pdf-line"></span>
    <span class="pdf-line"></span>

    <footer class="muted">Document genere par Digi-Sante</footer>
</section>

<?php ds_app_end(); ?>
