<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$alertes = $alertes ?? ['total' => count(ds_demo_alertes()), 'critiques' => 2, 'nouvelles' => 2, 'resolues' => 1];
$diagnostics = $diagnostics ?? ['total' => count(ds_demo_diagnostics()), 'critiques' => 1, 'valides' => 1, 'archives' => 1];
$patients = $patients ?? count(ds_demo_patients());
$medecins = $medecins ?? 4;

ob_start();
?>
<a href="<?= BASE_URL ?>/patients" class="btn-soft">
    <i class="fa-solid fa-users"></i>
    Patients
</a>
<a href="<?= BASE_URL ?>/medecins" class="btn-primary">
    <i class="fa-solid fa-user-doctor"></i>
    Medecins
</a>
<?php
$actions = ob_get_clean();

ds_app_start('Dashboard administrateur', 'Gouvernance des comptes, services et acces', $actions);
?>

<section class="metrics-grid">
    <?php ds_stat_card('fa-solid fa-users', 'Patients', $patients, 'green', 'Base active'); ?>
    <?php ds_stat_card('fa-solid fa-user-doctor', 'Medecins', $medecins, 'purple', 'Corps medical'); ?>
    <?php ds_stat_card('fa-regular fa-bell', 'Alertes', $alertes['total'] ?? 0, 'red', ($alertes['critiques'] ?? 0) . ' critiques'); ?>
    <?php ds_stat_card('fa-regular fa-clipboard', 'Diagnostics', $diagnostics['total'] ?? 0, 'yellow', ($diagnostics['valides'] ?? 0) . ' valides'); ?>
</section>

<section class="workspace-grid">
    <article class="panel">
        <div class="panel-header">
            <div>
                <h2>Patients recents</h2>
                <p>Controle rapide des dossiers et statuts.</p>
            </div>
            <a href="<?= BASE_URL ?>/patient/create" class="btn-soft">Ajouter</a>
        </div>

        <div class="table-panel">
            <table>
                <thead>
                    <tr>
                        <th>Dossier</th>
                        <th>Nom</th>
                        <th>Sexe</th>
                        <th>Ville</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice(ds_demo_patients(), 0, 5) as $patient): ?>
                        <tr>
                            <td class="row-title"><?= ds_e($patient['numero_dossier']) ?></td>
                            <td><?= ds_e($patient['prenom'] . ' ' . $patient['nom']) ?></td>
                            <td><?= ds_e($patient['sexe']) ?></td>
                            <td><?= ds_e($patient['adresse']) ?></td>
                            <td><?= ds_badge('ACTIF') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </article>

    <article class="panel">
        <div class="panel-header">
            <div>
                <h2>Qualite de suivi</h2>
                <p>Repartition operationnelle.</p>
            </div>
        </div>

        <div class="risk-list">
            <div class="risk-item">
                <span class="risk-dot"></span>
                <div>
                    <strong>Comptes actifs</strong>
                    <small>Authentification et sessions securisees</small>
                </div>
                <?= ds_badge('ACTIF') ?>
            </div>
            <div class="risk-item risk-warning">
                <span class="risk-dot"></span>
                <div>
                    <strong>Alertes en attente</strong>
                    <small><?= ds_e((string) ($alertes['nouvelles'] ?? 0)) ?> nouvelles alertes</small>
                </div>
                <?= ds_badge('NOUVELLE') ?>
            </div>
            <div class="risk-item">
                <span class="risk-dot"></span>
                <div>
                    <strong>Rapports disponibles</strong>
                    <small>Diagnostics exportables en PDF</small>
                </div>
                <?= ds_badge('VALIDE') ?>
            </div>
        </div>

        <nav class="quick-tabs" style="margin-bottom:0">
            <a href="<?= BASE_URL ?>/alertes"><i class="fa-regular fa-bell"></i> Alertes</a>
            <a href="<?= BASE_URL ?>/diagnostics"><i class="fa-regular fa-clipboard"></i> Diagnostics</a>
            <a href="<?= BASE_URL ?>/rapports"><i class="fa-regular fa-file-pdf"></i> Rapports PDF</a>
            <a href="<?= BASE_URL ?>/constantes"><i class="fa-solid fa-heart-pulse"></i> Constantes</a>
            <a href="<?= BASE_URL ?>/parametres"><i class="fa-solid fa-sliders"></i> Parametres</a>
        </nav>
    </article>
</section>

<?php ds_app_end(); ?>
