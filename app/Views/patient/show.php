<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$patient = $patient ?? ds_demo_patients()[0];
$constantes = !empty($constantes) ? $constantes : ds_demo_constantes();
$diagnostics = !empty($diagnostics) ? $diagnostics : ds_demo_diagnostics();

ob_start();
?>
<a href="<?= BASE_URL ?>/constante/create" class="btn-primary">
    <i class="fa-solid fa-plus"></i>
    Ajouter mesure
</a>
<?php
$actions = ob_get_clean();

ds_app_start('Fiche patient', ($patient['prenom'] ?? '') . ' ' . ($patient['nom'] ?? ''), $actions);
?>

<section class="workspace-grid">
    <article class="panel">
        <div class="panel-header">
            <div>
                <h2><?= ds_e(($patient['prenom'] ?? '') . ' ' . ($patient['nom'] ?? '')) ?></h2>
                <p><?= ds_e($patient['numero_dossier'] ?? 'PAT-0000') ?></p>
            </div>
            <?= ds_badge($patient['statut'] ?? 'ACTIF') ?>
        </div>

        <dl class="detail-list">
            <div><dt>Email</dt><dd><?= ds_e($patient['email'] ?? '-') ?></dd></div>
            <div><dt>Telephone</dt><dd><?= ds_e($patient['telephone'] ?? '-') ?></dd></div>
            <div><dt>Sexe</dt><dd><?= ds_e($patient['sexe'] ?? '-') ?></dd></div>
            <div><dt>Profession</dt><dd><?= ds_e($patient['profession'] ?? '-') ?></dd></div>
            <div><dt>Adresse</dt><dd><?= ds_e($patient['adresse'] ?? '-') ?></dd></div>
            <div><dt>Taille / Poids</dt><dd><?= ds_e($patient['taille'] ?? '-') ?> m / <?= ds_e($patient['poids'] ?? '-') ?> kg</dd></div>
        </dl>
    </article>

    <article class="chart-card">
        <h2>Evolution clinique</h2>
        <p>Courbe indicative des constantes recentes.</p>
        <svg class="mini-chart" viewBox="0 0 360 150" role="img" aria-label="Evolution patient">
            <path class="area" d="M20 105 L80 96 L140 80 L200 90 L260 72 L330 84 L330 130 L20 130 Z"></path>
            <polyline points="20,105 80,96 140,80 200,90 260,72 330,84"></polyline>
        </svg>
    </article>
</section>

<section class="split-grid" style="margin-top:20px">
    <article class="table-panel">
        <div class="panel-header" style="padding:20px;margin:0">
            <div>
                <h2>Constantes recentes</h2>
                <p>Derniers releves disponibles.</p>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Temperature</th>
                    <th>Tension</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($constantes, 0, 3) as $constante): ?>
                    <tr>
                        <td><?= ds_e($constante['date_mesure'] ?? '') ?></td>
                        <td><?= ds_e($constante['temperature'] ?? '-') ?> C</td>
                        <td><?= ds_e($constante['tension_systolique'] ?? '-') ?>/<?= ds_e($constante['tension_diastolique'] ?? '-') ?></td>
                        <td><?= ds_badge('NORMAL') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </article>

    <article class="table-panel">
        <div class="panel-header" style="padding:20px;margin:0">
            <div>
                <h2>Diagnostics</h2>
                <p>Suivi medical associe.</p>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Gravite</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($diagnostics, 0, 3) as $diagnostic): ?>
                    <tr>
                        <td><?= ds_e($diagnostic['titre'] ?? '') ?></td>
                        <td><?= ds_badge($diagnostic['gravite'] ?? 'MOYEN') ?></td>
                        <td><?= ds_badge($diagnostic['statut'] ?? 'EN_ATTENTE') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </article>
</section>

<?php ds_app_end(); ?>
