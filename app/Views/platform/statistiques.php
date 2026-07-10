<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

ds_app_start('Statistiques', 'Analyse operationnelle Digi-Sante');
?>

<section class="metrics-grid">
    <?php ds_stat_card('fa-solid fa-users', 'Patients suivis', '10', 'green', '+2 ce mois'); ?>
    <?php ds_stat_card('fa-regular fa-bell', 'Alertes', '7', 'red', '2 critiques'); ?>
    <?php ds_stat_card('fa-regular fa-clipboard', 'Diagnostics', '12', 'purple', '4 valides'); ?>
    <?php ds_stat_card('fa-regular fa-file-pdf', 'Rapports', '8', 'yellow', 'PDF'); ?>
</section>

<section class="split-grid">
    <article class="chart-card">
        <div class="panel-header">
            <div>
                <h2>Evolution des constantes</h2>
                <p>Derniers releves consolides.</p>
            </div>
        </div>
        <svg class="mini-chart" viewBox="0 0 360 150" role="img" aria-label="Evolution constantes">
            <path class="area" d="M20 110 L75 100 L130 90 L185 86 L240 70 L300 78 L340 62 L340 130 L20 130 Z"></path>
            <polyline points="20,110 75,100 130,90 185,86 240,70 300,78 340,62"></polyline>
        </svg>
    </article>

    <article class="chart-card">
        <div class="panel-header">
            <div>
                <h2>Alertes par niveau</h2>
                <p>Repartition clinique.</p>
            </div>
        </div>
        <svg class="mini-chart" viewBox="0 0 360 150" role="img" aria-label="Alertes par niveau">
            <polyline class="danger-line" points="30,120 90,70 150,96 210,50 270,82 330,44"></polyline>
            <polyline class="warning-line" points="30,128 90,112 150,100 210,88 270,94 330,74"></polyline>
        </svg>
    </article>
</section>

<section class="table-panel" style="margin-top:20px">
    <div class="panel-header" style="padding:20px;margin:0">
        <div>
            <h2>Indicateurs par module</h2>
            <p>Vue synthetique de la plateforme.</p>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Module</th>
                <th>Volume</th>
                <th>Priorite</th>
                <th>Tendance</th>
            </tr>
        </thead>
        <tbody>
            <tr><td class="row-title">Patients</td><td>10 dossiers</td><td><?= ds_badge('NORMAL') ?></td><td>+2 ce mois</td></tr>
            <tr><td class="row-title">Alertes</td><td>7 alertes</td><td><?= ds_badge('ATTENTION') ?></td><td>2 critiques</td></tr>
            <tr><td class="row-title">Diagnostics</td><td>12 analyses</td><td><?= ds_badge('EN_ATTENTE') ?></td><td>4 a valider</td></tr>
            <tr><td class="row-title">Rapports</td><td>8 PDF</td><td><?= ds_badge('VALIDE') ?></td><td>Archives</td></tr>
        </tbody>
    </table>
</section>

<?php ds_app_end(); ?>
