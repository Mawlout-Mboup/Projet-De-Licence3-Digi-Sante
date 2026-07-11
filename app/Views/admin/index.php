<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

ob_start();
?>
<a href="<?= BASE_URL ?>/medecin/create" class="btn-primary">
    <i class="fa-solid fa-plus"></i>
    Nouveau medecin
</a>
<?php
$actions = ob_get_clean();

ds_app_start('Administration', 'Pilotage global de Digi-Sante', $actions);
?>

<section class="metrics-grid">
    <?php ds_stat_card('fa-solid fa-users', 'Patients', $patients ?? 0, 'green', 'Dossiers'); ?>
    <?php ds_stat_card('fa-solid fa-user-doctor', 'Medecins', $medecins ?? 0, 'green', 'Equipe'); ?>
    <?php ds_stat_card('fa-solid fa-user-shield', 'Utilisateurs', $utilisateurs ?? 0, 'purple', 'Comptes'); ?>
    <?php ds_stat_card('fa-regular fa-bell', 'Alertes', $alertes ?? 0, 'red', 'Suivi'); ?>
</section>

<section class="split-grid">
    <article class="panel">
        <div class="panel-header">
            <div>
                <h2>Gestion administrative</h2>
                <p>Acces reserves au role administrateur.</p>
            </div>
            <?= ds_badge('ACTIF') ?>
        </div>

        <nav class="quick-tabs">
            <a href="<?= BASE_URL ?>/medecins"><i class="fa-solid fa-user-doctor"></i> Medecins</a>
            <a href="<?= BASE_URL ?>/patients"><i class="fa-solid fa-users"></i> Patients</a>
            <a href="<?= BASE_URL ?>/statistiques"><i class="fa-solid fa-chart-line"></i> Statistiques</a>
            <a href="<?= BASE_URL ?>/parametres"><i class="fa-solid fa-sliders"></i> Parametres</a>
        </nav>
    </article>

    <article class="panel">
        <div class="panel-header">
            <div>
                <h2>Etat de la plateforme</h2>
                <p>Modules disponibles et securises.</p>
            </div>
        </div>

        <div class="risk-list">
            <div class="risk-item"><span class="risk-dot"></span><div><strong>Authentification</strong><small>Connexion obligatoire pour les modules internes</small></div><?= ds_badge('ACTIF') ?></div>
            <div class="risk-item"><span class="risk-dot"></span><div><strong>Roles</strong><small>Admin, medecin et patient separes</small></div><?= ds_badge('VALIDE') ?></div>
            <div class="risk-item risk-warning"><span class="risk-dot"></span><div><strong>Diagnostics</strong><small><?= ds_e($diagnostics ?? 0) ?> elements suivis</small></div><?= ds_badge('EN_ATTENTE') ?></div>
        </div>
    </article>
</section>

<?php ds_app_end(); ?>
