<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$constantes = !empty($constantes) ? $constantes : ds_demo_constantes();
$user = ds_user();
$isPatient = (int) ($user['role_id'] ?? 0) === 3;

ob_start();
?>
<a href="<?= BASE_URL ?>/constante/create" class="btn-primary">
    <i class="fa-solid fa-plus"></i>
    Nouvelle mesure
</a>
<?php
$actions = ob_get_clean();

ds_app_start('Constantes vitales', 'Saisie et historique des dernieres mesures', $actions);
?>

<?php $latest = $constantes[0] ?? ds_demo_constantes()[0]; ?>

<section class="metrics-grid">
    <?php ds_stat_card('fa-solid fa-temperature-half', 'Temperature', ($latest['temperature'] ?? '36.8') . ' C', 'green', '36.1 - 37.5 C'); ?>
    <?php ds_stat_card('fa-solid fa-wave-square', 'Tension', ($latest['tension_systolique'] ?? '120') . '/' . ($latest['tension_diastolique'] ?? '80'), 'green', '<130/85 mmHg'); ?>
    <?php ds_stat_card('fa-solid fa-heart-pulse', 'Pouls', ($latest['pouls'] ?? '72') . ' bpm', 'green', '60 - 100 bpm'); ?>
    <?php ds_stat_card('fa-solid fa-droplet', 'Glycemie', ($latest['glycemie'] ?? '0.98') . ' g/L', 'yellow', '0.7 - 1.4 g/L'); ?>
</section>

<section class="workspace-grid">
    <article class="form-panel">
        <h2><i class="fa-solid fa-plus"></i> Nouvelle mesure</h2>
        <form class="form-grid" action="<?= BASE_URL ?>/constante/store" method="POST" style="margin-top:18px">
            <?php if ($isPatient): ?>
                <input type="hidden" name="patient_id" value="<?= (int) ($user['id'] ?? 0) ?>">
            <?php else: ?>
                <label>
                    Patient
                    <input type="number" name="patient_id" value="<?= ds_e($latest['patient_id'] ?? '3') ?>" required>
                </label>
                <label>
                    Medecin
                    <input type="number" name="medecin_id" value="<?= (int) ($user['id'] ?? 2) ?>">
                </label>
            <?php endif; ?>
            <label>
                Temperature (C)
                <input type="number" step="0.1" name="temperature" value="36.8">
            </label>
            <label>
                Pouls (bpm)
                <input type="number" name="pouls" value="72">
            </label>
            <label>
                Tension systolique
                <input type="number" name="tension_systolique" value="120">
            </label>
            <label>
                Tension diastolique
                <input type="number" name="tension_diastolique" value="80">
            </label>
            <label>
                Saturation (%)
                <input type="number" step="0.01" name="saturation" value="98">
            </label>
            <label>
                Glycemie (g/L)
                <input type="number" step="0.01" name="glycemie" value="0.98">
            </label>
            <label class="full">
                Commentaire
                <textarea name="commentaire">Mesure saisie depuis Digi-Sante.</textarea>
            </label>
            <button class="btn-primary full" type="submit">Enregistrer les mesures</button>
        </form>
    </article>

    <div class="chart-grid">
        <article class="chart-card">
            <h2>Temperature</h2>
            <p>7 derniers jours</p>
            <svg class="mini-chart" viewBox="0 0 360 150" role="img" aria-label="Temperature">
                <polyline points="20,78 70,92 120,70 170,92 230,74 290,82 340,90"></polyline>
            </svg>
        </article>
        <article class="chart-card">
            <h2>Glycemie</h2>
            <p>7 derniers jours</p>
            <svg class="mini-chart" viewBox="0 0 360 150" role="img" aria-label="Glycemie">
                <polyline class="warning-line" points="20,94 80,76 135,68 190,92 248,72 305,88 340,82"></polyline>
            </svg>
        </article>
    </div>
</section>

<section class="table-panel" style="margin-top:20px">
    <div class="panel-header" style="padding:20px;margin:0">
        <div>
            <h2>Historique des mesures</h2>
            <p>Valeurs anormales signalees par statut.</p>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <?php if (!$isPatient): ?><th>Patient</th><?php endif; ?>
                <th>Date</th>
                <th>Temperature</th>
                <th>Tension</th>
                <th>Pouls</th>
                <th>Glycemie</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($constantes as $constante): ?>
                <?php
                $warning = (float) ($constante['temperature'] ?? 0) > 38 ||
                    (int) ($constante['pouls'] ?? 0) > 100 ||
                    (float) ($constante['glycemie'] ?? 0) > 1.4;
                ?>
                <tr>
                    <?php if (!$isPatient): ?>
                        <td class="row-title"><?= ds_e(($constante['prenom'] ?? 'Patient') . ' ' . ($constante['nom'] ?? '')) ?></td>
                    <?php endif; ?>
                    <td><?= ds_e($constante['date_mesure'] ?? '') ?></td>
                    <td><?= ds_e($constante['temperature'] ?? '-') ?> C</td>
                    <td><?= ds_e($constante['tension_systolique'] ?? '-') ?>/<?= ds_e($constante['tension_diastolique'] ?? '-') ?></td>
                    <td><?= ds_e($constante['pouls'] ?? '-') ?> bpm</td>
                    <td><?= ds_e($constante['glycemie'] ?? '-') ?> g/L</td>
                    <td><?= ds_badge($warning ? 'ATTENTION' : 'NORMAL') ?></td>
                    <td>
                        <div class="action-links">
                            <a href="<?= BASE_URL ?>/constante/show?id=<?= (int) ($constante['id'] ?? 0) ?>" aria-label="Voir">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                            <?php if (!$isPatient): ?>
                                <a href="<?= BASE_URL ?>/constante/edit?id=<?= (int) ($constante['id'] ?? 0) ?>" aria-label="Modifier">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php ds_app_end(); ?>
