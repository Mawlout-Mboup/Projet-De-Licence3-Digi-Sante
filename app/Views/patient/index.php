<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$isDemo = empty($patients);
$patients = $isDemo ? ds_demo_patients() : $patients;

$criticalCount = 2;
$stableCount = max(count($patients) - $criticalCount, 0);

ob_start();
?>
<a href="<?= BASE_URL ?>/patient/create" class="btn-primary">
    <i class="fa-solid fa-plus"></i>
    Nouveau patient
</a>
<?php
$actions = ob_get_clean();

ds_app_start('Gestion des patients', count($patients) . ' patients - Donnees Digi-Sante', $actions);
?>

<section class="metrics-grid">
    <?php ds_stat_card('fa-solid fa-users', 'Patients total', count($patients), 'green', 'Actifs'); ?>
    <?php ds_stat_card('fa-solid fa-triangle-exclamation', 'Critiques', $criticalCount, 'red', 'Priorite'); ?>
    <?php ds_stat_card('fa-solid fa-wave-square', 'Surveillance', '4', 'yellow', 'A revoir'); ?>
    <?php ds_stat_card('fa-regular fa-circle-check', 'Stables', $stableCount, 'green', 'Normaux'); ?>
</section>

<section class="table-panel">
    <form class="table-toolbar" action="<?= BASE_URL ?>/patient/search" method="GET">
        <input type="text" name="q" placeholder="Rechercher par nom, dossier, condition...">
        <select aria-label="Statut">
            <option>Statut</option>
            <option>Stable</option>
            <option>Attention</option>
            <option>Critique</option>
        </select>
        <select aria-label="Medecin">
            <option>Medecin</option>
            <option>MED-0001</option>
            <option>MED-0002</option>
        </select>
        <button class="btn-soft" type="submit">Filtrer</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>N dossier</th>
                <th>Patient</th>
                <th>Sexe</th>
                <th>Age</th>
                <th>Condition</th>
                <th>Derniere visite</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($patients as $index => $patient): ?>
                <?php
                $birthDate = $patient['date_naissance'] ?? '1990-01-01';
                $age = (new DateTime($birthDate))->diff(new DateTime())->y;
                $status = $index === 1 ? 'CRITIQUE' : ($index % 2 === 0 ? 'ATTENTION' : 'STABLE');
                $condition = $index === 1 ? 'Diabete type 2' : ($index % 2 === 0 ? 'Hypertension arterielle' : 'Suivi general');
                ?>
                <tr>
                    <td class="row-title"><?= ds_e($patient['numero_dossier'] ?? ('PAT-' . str_pad((string) $index, 4, '0', STR_PAD_LEFT))) ?></td>
                    <td>
                        <strong><?= ds_e(($patient['prenom'] ?? '') . ' ' . ($patient['nom'] ?? '')) ?></strong>
                        <br>
                        <span class="muted"><?= ds_e($patient['email'] ?? '') ?></span>
                    </td>
                    <td><?= ds_badge($patient['sexe'] ?? 'N/A') ?></td>
                    <td><?= ds_e((string) $age) ?> ans</td>
                    <td><?= ds_e($condition) ?></td>
                    <td><?= ds_e(date('d/m/Y', strtotime('-' . $index . ' day'))) ?></td>
                    <td><?= ds_badge($status) ?></td>
                    <td>
                        <div class="action-links">
                            <a href="<?= BASE_URL ?>/patient/show?id=<?= (int) ($patient['utilisateur_id'] ?? 0) ?>" aria-label="Voir">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/patient/edit?id=<?= (int) ($patient['utilisateur_id'] ?? 0) ?>" aria-label="Modifier">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/constante/patient?patient=<?= (int) ($patient['utilisateur_id'] ?? 0) ?>" aria-label="Constantes">
                                <i class="fa-solid fa-heart-pulse"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php ds_app_end(); ?>