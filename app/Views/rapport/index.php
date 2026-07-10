<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$isDemo = empty($rapports);
$rapports = $isDemo ? ds_demo_rapports() : $rapports;

ob_start();
?>
<a href="<?= BASE_URL ?>/rapport/create" class="btn-primary">
    <i class="fa-solid fa-plus"></i>
    Nouveau rapport
</a>
<?php
$actions = ob_get_clean();

ds_app_start('Rapports medicaux PDF', count($rapports) . ' documents generes', $actions);
?>

<section class="metrics-grid">
    <?php ds_stat_card('fa-regular fa-file-pdf', 'Rapports', count($rapports), 'green', 'Total'); ?>
    <?php ds_stat_card('fa-solid fa-download', 'Telecharges', '12', 'purple', 'Ce mois'); ?>
    <?php ds_stat_card('fa-regular fa-clock', 'En attente', '2', 'yellow', 'A valider'); ?>
    <?php ds_stat_card('fa-regular fa-circle-check', 'Archives', '8', 'green', 'Dossier patient'); ?>
</section>

<section class="workspace-grid">
    <article class="table-panel">
        <div class="panel-header" style="padding:20px;margin:0">
            <div>
                <h2>Historique des rapports</h2>
                <p>Documents cliniques rattaches aux patients.</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Patient</th>
                    <th>Medecin</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rapports as $rapport): ?>
                    <tr>
                        <td class="row-title"><?= ds_e($rapport['titre'] ?? 'Rapport') ?></td>
                        <td>PAT-<?= ds_e($rapport['patient_id'] ?? '-') ?></td>
                        <td>MED-<?= ds_e($rapport['medecin_id'] ?? '-') ?></td>
                        <td><?= ds_badge($rapport['type'] ?? 'PDF') ?></td>
                        <td><?= ds_e($rapport['date_generation'] ?? '') ?></td>
                        <td>
                            <div class="action-links">
                                <a href="<?= BASE_URL ?>/rapport/show?id=<?= (int) ($rapport['id'] ?? 0) ?>" aria-label="Voir">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a href="<?= BASE_URL ?>/rapport/show?id=<?= (int) ($rapport['id'] ?? 0) ?>" aria-label="Telecharger">
                                    <i class="fa-solid fa-download"></i>
                                </a>
                                <a href="<?= BASE_URL ?>/rapport/edit?id=<?= (int) ($rapport['id'] ?? 0) ?>" aria-label="Modifier">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </article>

    <aside class="pdf-preview">
        <header>
            <strong>Digi-Sante</strong>
            <span>Rapport PDF</span>
        </header>
        <h2>Compte rendu clinique</h2>
        <span class="pdf-line"></span>
        <span class="pdf-line short"></span>
        <span class="pdf-line"></span>
        <span class="pdf-line"></span>
        <div class="split-grid">
            <span class="pdf-line"></span>
            <span class="pdf-line"></span>
        </div>
        <span class="pdf-line short"></span>
        <footer class="muted">Genere par le moteur de diagnostic Digi-Sante</footer>
    </aside>
</section>

<?php ds_app_end(); ?>
