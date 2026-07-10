<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$stats = $stats ?? [
    'patients' => count(ds_demo_patients()),
    'medecins' => 4,
    'constantes' => count(ds_demo_constantes()),
    'diagnostics' => count(ds_demo_diagnostics()),
    'alertes' => count(ds_demo_alertes())
];

ob_start();
?>
<a href="<?= BASE_URL ?>/diagnostic/create" class="btn-primary">
    <i class="fa-solid fa-plus"></i>
    Nouveau diagnostic
</a>
<?php
$actions = ob_get_clean();

ds_app_start('Tableau de bord', 'Vue globale de la plateforme Digi-Sante', $actions);
?>

<section class="metrics-grid">
    <?php ds_stat_card('fa-solid fa-users', 'Patients suivis', $stats['patients'], 'green', '+2 ce mois'); ?>
    <?php ds_stat_card('fa-solid fa-user-doctor', 'Medecins actifs', $stats['medecins'], 'purple', 'Equipe clinique'); ?>
    <?php ds_stat_card('fa-solid fa-heart-pulse', 'Constantes', $stats['constantes'], 'yellow', 'Dernieres mesures'); ?>
    <?php ds_stat_card('fa-regular fa-bell', 'Alertes', $stats['alertes'], 'red', 'A prioriser'); ?>
</section>

<section class="workspace-grid">
    <article class="panel">
        <div class="panel-header">
            <div>
                <h2>Activite clinique</h2>
                <p>Lecture rapide des indicateurs vitaux recents.</p>
            </div>
            <a href="<?= BASE_URL ?>/constantes" class="btn-soft">Voir les mesures</a>
        </div>

        <div class="chart-grid">
            <article class="chart-card">
                <h2>Temperature</h2>
                <p>7 derniers jours</p>
                <svg class="mini-chart" viewBox="0 0 360 150" role="img" aria-label="Courbe temperature">
                    <path class="area" d="M20 110 L80 100 L140 92 L200 80 L260 86 L330 74 L330 130 L20 130 Z"></path>
                    <polyline points="20,110 80,100 140,92 200,80 260,86 330,74"></polyline>
                </svg>
            </article>

            <article class="chart-card">
                <h2>Tension arterielle</h2>
                <p>Seuils de surveillance</p>
                <svg class="mini-chart" viewBox="0 0 360 150" role="img" aria-label="Courbe tension">
                    <path class="area" d="M20 106 L86 98 L148 87 L214 84 L274 76 L330 83 L330 130 L20 130 Z"></path>
                    <polyline points="20,106 86,98 148,87 214,84 274,76 330,83"></polyline>
                </svg>
            </article>
        </div>
    </article>

    <article class="panel">
        <div class="panel-header">
            <div>
                <h2>Priorites</h2>
                <p>Alertes et diagnostics a traiter.</p>
            </div>
        </div>

        <div class="risk-list">
            <?php foreach (ds_demo_alertes() as $alerte): ?>
                <div class="risk-item <?= $alerte['niveau'] === 'CRITIQUE' ? 'risk-danger' : 'risk-warning' ?>">
                    <span class="risk-dot"></span>
                    <div>
                        <strong><?= ds_e($alerte['titre']) ?></strong>
                        <small><?= ds_e($alerte['message']) ?></small>
                    </div>
                    <?= ds_badge($alerte['niveau']) ?>
                </div>
            <?php endforeach; ?>
        </div>
    </article>
</section>

<?php ds_app_end(); ?>