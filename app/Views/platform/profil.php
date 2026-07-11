<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$user = $user ?? ds_user();
$role = ds_role_name($user['role_id'] ?? null);

ob_start();
?>
<a href="<?= BASE_URL ?>/parametres" class="btn-soft">
    <i class="fa-solid fa-sliders"></i>
    Parametres
</a>
<?php
$actions = ob_get_clean();

ds_app_start('Mon profil', 'Identite et acces utilisateur', $actions);
?>

<section class="workspace-grid">
    <article class="profile-card">
        <div class="profile-avatar">
            <?= ds_e(substr((string) ($user['prenom'] ?? 'D'), 0, 1)) ?><?= ds_e(substr((string) ($user['nom'] ?? 'S'), 0, 1)) ?>
        </div>
        <h2><?= ds_e(($user['prenom'] ?? 'Equipe') . ' ' . ($user['nom'] ?? 'Digi-Sante')) ?></h2>
        <p><?= ds_e($role) ?></p>
        <?= ds_badge('ACTIF') ?>

        <div class="profile-actions">
            <a href="<?= BASE_URL ?>/notifications" class="btn-soft">
                <i class="fa-regular fa-bell"></i>
                Notifications
            </a>
            <a href="<?= BASE_URL ?>/logout" class="btn-primary">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                Deconnexion
            </a>
        </div>
    </article>

    <article class="panel">
        <div class="panel-header">
            <div>
                <h2>Informations personnelles</h2>
                <p>Donnees principales du compte.</p>
            </div>
        </div>

        <dl class="detail-list">
            <div><dt>Prenom</dt><dd><?= ds_e($user['prenom'] ?? '-') ?></dd></div>
            <div><dt>Nom</dt><dd><?= ds_e($user['nom'] ?? '-') ?></dd></div>
            <div><dt>Email</dt><dd><?= ds_e($user['email'] ?? '-') ?></dd></div>
            <div><dt>Role</dt><dd><?= ds_e($role) ?></dd></div>
            <div><dt>Identifiant</dt><dd>#<?= ds_e($user['id'] ?? '-') ?></dd></div>
        </dl>
    </article>
</section>

<section class="split-grid" style="margin-top:20px">
    <article class="panel">
        <div class="panel-header">
            <div>
                <h2>Activite recente</h2>
                <p>Trace de consultation et actions.</p>
            </div>
        </div>
        <div class="risk-list">
            <div class="risk-item"><span class="risk-dot"></span><div><strong>Connexion</strong><small>Session ouverte sur Digi-Sante</small></div><?= ds_badge('ACTIF') ?></div>
            <div class="risk-item risk-warning"><span class="risk-dot"></span><div><strong>Diagnostic</strong><small>Analyse en attente de validation</small></div><?= ds_badge('EN_ATTENTE') ?></div>
        </div>
    </article>

    <article class="panel">
        <div class="panel-header">
            <div>
                <h2>Securite</h2>
                <p>Parametres rapides du compte.</p>
            </div>
        </div>
        <div class="settings-list">
            <label class="setting-row"><span><strong>Session securisee</strong><small>Controle actif</small></span><input type="checkbox" checked></label>
            <label class="setting-row"><span><strong>Notifications critiques</strong><small>Reception immediate</small></span><input type="checkbox" checked></label>
        </div>
    </article>
</section>

<?php ds_app_end(); ?>
