<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$constantes = !empty($constantes) ? $constantes : ds_demo_constantes();

ob_start();
?>
<a href="<?= BASE_URL ?>/constante/create" class="btn-primary">
    <i class="fa-solid fa-plus"></i>
    Nouvelle mesure
</a>
<?php
$actions = ob_get_clean();

ds_app_start('Espace patient', 'Saisie et historique de vos constantes vitales', $actions);
?>

<section class="metrics-grid">
    <?php ds_stat_card('fa-solid fa-temperature-half', 'Temperature', '36.8 C', 'green', 'Normale'); ?>
    <?php ds_stat_card('fa-solid fa-wave-square', 'Tension', '120/80', 'green', 'Normale'); ?>
    <?php ds_stat_card('fa-solid fa-heart-pulse', 'Pouls', '72 bpm', 'green', 'Stable'); ?>
    <?php ds_stat_card('fa-solid fa-droplet', 'Glycemie', '0.98 g/L', 'yellow', 'A jeun'); ?>
</section>

<section class="workspace-grid">
    <article class="form-panel">
        <h2>Nouvelle mesure</h2>
        <p>Enregistrez vos constantes du jour.</p>
        <form class="form-grid" action="<?= BASE_URL ?>/constante/store" method="POST" style="margin-top:18px">
            <input type="hidden" name="patient_id" value="<?= (int) (ds_user()['id'] ?? 3) ?>">
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
                <textarea name="commentaire">Aucun symptome particulier.</textarea>
            </label>
            <button class="btn-primary full" type="submit">
                <i class="fa-regular fa-circle-check"></i>
                Enregistrer les mesures
            </button>
        </form>
    </article>

    <div class="chart-grid">
        <article class="chart-card">
            <h2>Temperature</h2>
            <p>7 derniers jours</p>
            <svg class="mini-chart" viewBox="0 0 360 150" role="img" aria-label="Temperature">
                <polyline points="20,82 70,92 120,70 170,92 230,74 290,82 340,90"></polyline>
            </svg>
        </article>
        <article class="chart-card">
            <h2>Tension</h2>
            <p>7 derniers jours</p>
            <svg class="mini-chart" viewBox="0 0 360 150" role="img" aria-label="Tension">
                <polyline points="20,94 80,82 135,66 190,88 248,70 305,92 340,80"></polyline>
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
                <th>Date</th>
                <th>Temperature</th>
                <th>Tension</th>
                <th>Pouls</th>
                <th>Glycemie</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($constantes as $constante): ?>
                <tr>
                    <td><?= ds_e($constante['date_mesure'] ?? '') ?></td>
                    <td class="row-title"><?= ds_e($constante['temperature'] ?? '-') ?> C</td>
                    <td><?= ds_e($constante['tension_systolique'] ?? '-') ?>/<?= ds_e($constante['tension_diastolique'] ?? '-') ?></td>
                    <td><?= ds_e($constante['pouls'] ?? '-') ?> bpm</td>
                    <td><?= ds_e($constante['glycemie'] ?? '-') ?> g/L</td>
                    <td><?= ds_badge(((float) ($constante['temperature'] ?? 0) > 38) ? 'ATTENTION' : 'NORMAL') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php ds_app_end(); ?>
