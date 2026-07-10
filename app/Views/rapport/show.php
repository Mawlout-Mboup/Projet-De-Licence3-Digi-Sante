<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$rapport = $rapport ?? ds_demo_rapports()[0];

ds_app_start('Detail rapport', $rapport['titre'] ?? 'Rapport medical');
?>

<section class="workspace-grid">
    <article class="panel">
        <div class="panel-header">
            <div>
                <h2><?= ds_e($rapport['titre'] ?? 'Rapport') ?></h2>
                <p><?= ds_e($rapport['date_generation'] ?? '') ?></p>
            </div>
            <?= ds_badge($rapport['type'] ?? 'PDF') ?>
        </div>

        <p><?= nl2br(ds_e($rapport['contenu'] ?? 'Synthese clinique et recommandations medicales.')) ?></p>
    </article>

    <aside class="pdf-preview">
        <header>
            <strong>Digi-Sante</strong>
            <span>Document</span>
        </header>
        <h2><?= ds_e($rapport['titre'] ?? 'Rapport') ?></h2>
        <span class="pdf-line"></span>
        <span class="pdf-line short"></span>
        <span class="pdf-line"></span>
        <span class="pdf-line"></span>
    </aside>
</section>

<?php ds_app_end(); ?>
