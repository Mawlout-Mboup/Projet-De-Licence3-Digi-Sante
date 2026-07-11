<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$users = $users ?? [
    ['prenom' => 'Admin', 'nom' => 'Digi-Sante', 'email' => 'admin@digi-sante.sn', 'role_id' => 1, 'statut' => 'ACTIF'],
    ['prenom' => 'Amadou', 'nom' => 'Fall', 'email' => 'medecin@digi-sante.sn', 'role_id' => 2, 'statut' => 'ACTIF'],
    ['prenom' => 'Fatou', 'nom' => 'Diop', 'email' => 'patient@digi-sante.sn', 'role_id' => 3, 'statut' => 'ACTIF']
];

ds_app_start('Utilisateurs', 'Comptes et roles de la plateforme');
?>

<section class="table-panel">
    <div class="panel-header" style="padding:20px;margin:0">
        <div>
            <h2>Liste des utilisateurs</h2>
            <p>Suivi des comptes administrateur, medecin et patient.</p>
        </div>
        <?= ds_badge('ACTIF') ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Role</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td class="row-title"><?= ds_e(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?></td>
                    <td><?= ds_e($user['email'] ?? '-') ?></td>
                    <td><?= ds_e(ds_role_name($user['role_id'] ?? null)) ?></td>
                    <td><?= ds_badge($user['statut'] ?? 'ACTIF') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php ds_app_end(); ?>
