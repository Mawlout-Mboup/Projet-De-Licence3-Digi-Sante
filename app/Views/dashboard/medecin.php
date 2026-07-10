<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$alertes = !empty($alertes) ? $alertes : ds_demo_alertes();
$constantes = !empty($constantes) ? $constantes : ds_demo_constantes();

ob_start();
?>
<a href="<?= BASE_URL ?>/diagnostic/create" class="btn-primary">
    <i class="fa-solid fa-plus"></i>
    Nouveau diagnostic
</a>
<?php
$actions = ob_get_clean();

ds_app_start('Centre de surveillance', 'MED-0001 - Supervision en direct', $actions);
?>

<nav class="quick-tabs">
    <a href="<?= BASE_URL ?>/patients"><i class="fa-solid fa-users"></i> Mes patients</a>
    <a href="<?= BASE_URL ?>/alertes"><i class="fa-regular fa-bell"></i> Alertes</a>
    <a href="<?= BASE_URL ?>/diagnostic/create"><i class="fa-regular fa-clipboard"></i> Nouveau diagnostic</a>
    <a href="<?= BASE_URL ?>/rapports"><i class="fa-regular fa-file-pdf"></i> Rapports PDF</a>
    <a href="<?= BASE_URL ?>/dashboard"><i class="fa-solid fa-chart-line"></i> Statistiques</a>
</nav>

<section class="metrics-grid">
    <?php ds_stat_card('fa-solid fa-users', 'Patients suivis', '10', 'green', '+2 ce mois'); ?>
    <?php ds_stat_card('fa-solid fa-triangle-exclamation', 'Alertes critiques', '2', 'red', 'Immediat'); ?>
    <?php ds_stat_card('fa-regular fa-bell', 'Alertes moderees', '4', 'yellow', 'Surveiller'); ?>
    <?php ds_stat_card('fa-regular fa-clipboard', 'Diagnostics du jour', '1', 'purple', 'Aujourd hui'); ?>
</section>

<section class="workspace-grid">
    <div class="chart-grid">
        <article class="chart-card">
            <div class="panel-header">
                <div>
                    <h2><i class="fa-solid fa-temperature-half"></i> Temperature</h2>
                    <p>Normale : 36.1 - 37.5 C</p>
                </div>
                <strong class="status-danger">39.2 C</strong>
            </div>
            <svg class="mini-chart" viewBox="0 0 360 150" role="img" aria-label="Temperature patient">
                <path class="area" d="M20 105 L80 92 L140 84 L200 70 L260 64 L330 78 L330 130 L20 130 Z"></path>
                <polyline class="danger-line" points="20,105 80,92 140,84 200,70 260,64 330,78"></polyline>
            </svg>
        </article>

        <article class="chart-card">
            <div class="panel-header">
                <div>
                    <h2><i class="fa-solid fa-wave-square"></i> Tension arterielle</h2>
                    <p>Normale : &lt;130/85 mmHg</p>
                </div>
                <strong>165/95</strong>
            </div>
            <svg class="mini-chart" viewBox="0 0 360 150" role="img" aria-label="Tension patient">
                <path class="area" d="M20 100 L90 92 L154 86 L220 80 L278 70 L330 78 L330 130 L20 130 Z"></path>
                <polyline points="20,100 90,92 154,86 220,80 278,70 330,78"></polyline>
            </svg>
        </article>
    </div>

    <article class="panel">
        <div class="panel-header">
            <div>
                <h2>Alertes critiques</h2>
                <p>Patients a prioriser.</p>
            </div>
        </div>

        <div class="risk-list">
            <?php foreach ($alertes as $alerte): ?>
                <div class="risk-item <?= ($alerte['niveau'] ?? '') === 'CRITIQUE' ? 'risk-danger' : 'risk-warning' ?>">
                    <span class="risk-dot"></span>
                    <div>
                        <strong><?= ds_e($alerte['titre'] ?? 'Alerte') ?></strong>
                        <small><?= ds_e($alerte['message'] ?? ($alerte['date_alerte'] ?? '')) ?></small>
                    </div>
                    <?= ds_badge($alerte['niveau'] ?? 'MOYEN') ?>
                </div>
            <?php endforeach; ?>
        </div>
    </article>
</section>

<section class="table-panel" style="margin-top:20px">
    <div class="panel-header" style="padding:20px;margin:0">
        <div>
            <h2>Dernieres constantes</h2>
            <p>Flux recent des mesures patients.</p>
        </div>
        <a href="<?= BASE_URL ?>/constantes" class="btn-soft">Ouvrir</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Date</th>
                <th>Temperature</th>
                <th>Tension</th>
                <th>Pouls</th>
                <th>Saturation</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($constantes as $constante): ?>
                <?php
                $critical = (float) ($constante['temperature'] ?? 0) > 38 ||
                    (int) ($constante['pouls'] ?? 0) > 100 ||
                    (float) ($constante['saturation'] ?? 100) < 95;
                ?>
                <tr>
                    <td class="row-title"><?= ds_e(($constante['prenom'] ?? 'Patient') . ' ' . ($constante['nom'] ?? '')) ?></td>
                    <td><?= ds_e($constante['date_mesure'] ?? '') ?></td>
                    <td><?= ds_e($constante['temperature'] ?? '-') ?> C</td>
                    <td><?= ds_e($constante['tension_systolique'] ?? '-') ?>/<?= ds_e($constante['tension_diastolique'] ?? '-') ?></td>
                    <td><?= ds_e($constante['pouls'] ?? '-') ?> bpm</td>
                    <td><?= ds_e($constante['saturation'] ?? '-') ?> %</td>
                    <td><?= ds_badge($critical ? 'CRITIQUE' : 'NORMAL') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php ds_app_end(); ?>