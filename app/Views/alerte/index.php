<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$isDemo = empty($alertes);
$alertes = $isDemo ? ds_demo_alertes() : $alertes;

ob_start();
?>
<a href="<?= BASE_URL ?>/alerte/create" class="btn-primary">
    <i class="fa-solid fa-plus"></i>
    Nouvelle alerte
</a>
<?php
$actions = ob_get_clean();

ds_app_start('Gestion des alertes', count($alertes) . ' alertes cliniques', $actions);
?>

<section class="metrics-grid">
    <?php ds_stat_card('fa-regular fa-bell', 'Alertes total', count($alertes), 'green', 'Flux actif'); ?>
    <?php ds_stat_card('fa-solid fa-triangle-exclamation', 'Critiques', '1', 'red', 'Immediat'); ?>
    <?php ds_stat_card('fa-solid fa-clock', 'En charge', '1', 'yellow', 'Suivi'); ?>
    <?php ds_stat_card('fa-regular fa-circle-check', 'Resolues', '1', 'green', 'Clos'); ?>
</section>

<section class="workspace-grid">
    <article class="table-panel">
        <div class="panel-header" style="padding:20px;margin:0">
            <div>
                <h2>File des alertes</h2>
                <p>Traitement par priorite clinique.</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Alerte</th>
                    <th>Patient</th>
                    <th>Niveau</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alertes as $alerte): ?>
                    <tr>
                        <td>
                            <span class="row-title"><?= ds_e($alerte['titre'] ?? 'Alerte') ?></span>
                            <br>
                            <span class="muted"><?= ds_e($alerte['message'] ?? '') ?></span>
                        </td>
                        <td>PAT-<?= ds_e($alerte['patient_id'] ?? '-') ?></td>
                        <td><?= ds_badge($alerte['niveau'] ?? 'MOYEN') ?></td>
                        <td><?= ds_badge($alerte['statut'] ?? 'NOUVELLE') ?></td>
                        <td><?= ds_e($alerte['date_alerte'] ?? '') ?></td>
                        <td>
                            <div class="action-links">
                                <a href="<?= BASE_URL ?>/alerte/show?id=<?= (int) ($alerte['id'] ?? 0) ?>" aria-label="Voir">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a href="<?= BASE_URL ?>/alerte/prendre-en-charge?id=<?= (int) ($alerte['id'] ?? 0) ?>" aria-label="Prendre en charge">
                                    <i class="fa-solid fa-hand-holding-medical"></i>
                                </a>
                                <a href="<?= BASE_URL ?>/alerte/resoudre?id=<?= (int) ($alerte['id'] ?? 0) ?>" aria-label="Resoudre">
                                    <i class="fa-regular fa-circle-check"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </article>

    <aside class="panel">
        <div class="panel-header">
            <div>
                <h2>Regles de seuil</h2>
                <p>Detection automatique.</p>
            </div>
        </div>

        <div class="risk-list">
            <div class="risk-item risk-danger">
                <span class="risk-dot"></span>
                <div>
                    <strong>Temperature</strong>
                    <small>&gt; 38 C</small>
                </div>
                <?= ds_badge('CRITIQUE') ?>
            </div>
            <div class="risk-item risk-warning">
                <span class="risk-dot"></span>
                <div>
                    <strong>Pouls</strong>
                    <small>&gt; 100 bpm</small>
                </div>
                <?= ds_badge('MOYEN') ?>
            </div>
            <div class="risk-item">
                <span class="risk-dot"></span>
                <div>
                    <strong>Saturation</strong>
                    <small>&lt; 95%</small>
                </div>
                <?= ds_badge('ELEVE') ?>
            </div>
        </div>
    </aside>
</section>

<?php ds_app_end(); ?>
