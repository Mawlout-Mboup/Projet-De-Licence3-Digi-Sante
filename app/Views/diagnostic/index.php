<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$isDemo = empty($diagnostics);
$diagnostics = $isDemo ? ds_demo_diagnostics() : $diagnostics;

ob_start();
?>
<a href="<?= BASE_URL ?>/diagnostic/create" class="btn-primary">
    <i class="fa-solid fa-plus"></i>
    Nouveau diagnostic
</a>
<?php
$actions = ob_get_clean();

ds_app_start('Historique des diagnostics', count($diagnostics) . ' diagnostics medicaux', $actions);
?>

<section class="metrics-grid">
    <?php ds_stat_card('fa-regular fa-clipboard', 'Diagnostics', count($diagnostics), 'green', 'Total'); ?>
    <?php ds_stat_card('fa-solid fa-triangle-exclamation', 'Risque eleve', '1', 'red', 'Priorite'); ?>
    <?php ds_stat_card('fa-regular fa-circle-check', 'Valides', '1', 'green', 'Confirme'); ?>
    <?php ds_stat_card('fa-solid fa-box-archive', 'Archives', '1', 'purple', 'Historique'); ?>
</section>

<section class="table-panel">
    <form class="table-toolbar" action="<?= BASE_URL ?>/diagnostic/search" method="GET">
        <input type="text" name="q" placeholder="Rechercher par patient, titre, analyse...">
        <select aria-label="Gravite">
            <option>Gravite</option>
            <option>Faible</option>
            <option>Moyen</option>
            <option>Eleve</option>
            <option>Critique</option>
        </select>
        <select aria-label="Statut">
            <option>Statut</option>
            <option>En attente</option>
            <option>Valide</option>
            <option>Archive</option>
        </select>
        <button class="btn-soft" type="submit">Filtrer</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Patient</th>
                <th>Medecin</th>
                <th>Gravite</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($diagnostics as $diagnostic): ?>
                <tr>
                    <td>
                        <span class="row-title"><?= ds_e($diagnostic['titre'] ?? 'Diagnostic') ?></span>
                        <br>
                        <span class="muted"><?= ds_e(substr((string) ($diagnostic['description'] ?? ''), 0, 78)) ?></span>
                    </td>
                    <td>PAT-<?= ds_e((string) ($diagnostic['patient_id'] ?? '-')) ?></td>
                    <td>MED-<?= ds_e((string) ($diagnostic['medecin_id'] ?? '-')) ?></td>
                    <td><?= ds_badge($diagnostic['gravite'] ?? 'MOYEN') ?></td>
                    <td><?= ds_badge($diagnostic['statut'] ?? 'EN_ATTENTE') ?></td>
                    <td><?= ds_e($diagnostic['date_diagnostic'] ?? '') ?></td>
                    <td>
                        <div class="action-links">
                            <a href="<?= BASE_URL ?>/diagnostic/show?id=<?= (int) ($diagnostic['id'] ?? 0) ?>" aria-label="Voir">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/diagnostic/edit?id=<?= (int) ($diagnostic['id'] ?? 0) ?>" aria-label="Modifier">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/diagnostic/archive?id=<?= (int) ($diagnostic['id'] ?? 0) ?>" aria-label="Archiver">
                                <i class="fa-solid fa-box-archive"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php ds_app_end(); ?>
