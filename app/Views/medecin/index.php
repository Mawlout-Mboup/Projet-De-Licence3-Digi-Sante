<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$isDemo = empty($medecins);
$medecins = !$isDemo ? $medecins : [
    ['utilisateur_id' => 2, 'prenom' => 'Amadou', 'nom' => 'Fall', 'email' => 'medecin@digi-sante.sn', 'telephone' => '77 111 11 11', 'numero_ordre' => 'ORD-2026-001', 'specialite' => 'Medecine generale', 'service' => 'Cardiologie', 'disponible' => 1],
    ['utilisateur_id' => 6, 'prenom' => 'Aminata', 'nom' => 'Sow', 'email' => 'aminata.sow@example.sn', 'telephone' => '77 222 22 22', 'numero_ordre' => 'ORD-2026-002', 'specialite' => 'Urgences', 'service' => 'Urgences', 'disponible' => 1],
    ['utilisateur_id' => 7, 'prenom' => 'Ibrahima', 'nom' => 'Ndiaye', 'email' => 'ibrahima.ndiaye@example.sn', 'telephone' => '77 333 33 33', 'numero_ordre' => 'ORD-2026-003', 'specialite' => 'Pediatrie', 'service' => 'Pediatrie', 'disponible' => 0]
];

ob_start();
?>
<a href="<?= BASE_URL ?>/medecin/create" class="btn-primary">
    <i class="fa-solid fa-plus"></i>
    Nouveau medecin
</a>
<?php
$actions = ob_get_clean();

ds_app_start('Gestion des medecins', count($medecins) . ' profils cliniques', $actions);
?>

<section class="metrics-grid">
    <?php ds_stat_card('fa-solid fa-user-doctor', 'Medecins total', count($medecins), 'green', 'Equipe'); ?>
    <?php ds_stat_card('fa-regular fa-circle-check', 'Disponibles', '2', 'green', 'En service'); ?>
    <?php ds_stat_card('fa-solid fa-clock', 'Indisponibles', '1', 'yellow', 'Planning'); ?>
    <?php ds_stat_card('fa-solid fa-hospital', 'Services', '4', 'purple', 'Actifs'); ?>
</section>

<section class="table-panel">
    <form class="table-toolbar" action="<?= BASE_URL ?>/medecin/search" method="GET">
        <input type="text" name="q" placeholder="Rechercher un medecin, ordre, specialite...">
        <select aria-label="Service">
            <option>Service</option>
            <option>Cardiologie</option>
            <option>Urgences</option>
        </select>
        <select aria-label="Disponibilite">
            <option>Disponibilite</option>
            <option>Disponible</option>
            <option>Indisponible</option>
        </select>
        <button class="btn-soft" type="submit">Filtrer</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Medecin</th>
                <th>Email</th>
                <th>Telephone</th>
                <th>Ordre</th>
                <th>Specialite</th>
                <th>Service</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medecins as $medecin): ?>
                <tr>
                    <td class="row-title"><?= ds_e(($medecin['prenom'] ?? '') . ' ' . ($medecin['nom'] ?? '')) ?></td>
                    <td><?= ds_e($medecin['email'] ?? '') ?></td>
                    <td><?= ds_e($medecin['telephone'] ?? '') ?></td>
                    <td><?= ds_e($medecin['numero_ordre'] ?? '') ?></td>
                    <td><?= ds_e($medecin['specialite'] ?? '') ?></td>
                    <td><?= ds_e($medecin['service'] ?? '') ?></td>
                    <td><?= ds_badge(!empty($medecin['disponible']) ? 'DISPONIBLE' : 'INDISPONIBLE') ?></td>
                    <td>
                        <div class="action-links">
                            <a href="<?= BASE_URL ?>/medecin/show?id=<?= (int) ($medecin['utilisateur_id'] ?? 0) ?>" aria-label="Voir">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/medecin/edit?id=<?= (int) ($medecin['utilisateur_id'] ?? 0) ?>" aria-label="Modifier">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php ds_app_end(); ?>
