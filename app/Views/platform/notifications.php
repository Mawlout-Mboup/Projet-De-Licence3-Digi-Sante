<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$notifications = [
    ['titre' => 'Alerte critique', 'message' => 'Temperature elevee detectee chez Awa Diop.', 'type' => 'CRITIQUE', 'date' => '2026-06-29 09:20'],
    ['titre' => 'Rapport genere', 'message' => 'Le rapport clinique PAT-0001 est pret.', 'type' => 'VALIDE', 'date' => '2026-06-29 10:15'],
    ['titre' => 'Nouvelle mesure', 'message' => 'Fatou Diop a ajoute ses constantes du jour.', 'type' => 'NORMAL', 'date' => '2026-06-29 08:30'],
    ['titre' => 'Diagnostic en attente', 'message' => 'Une analyse medicale doit etre validee.', 'type' => 'EN_ATTENTE', 'date' => '2026-06-28 17:45']
];

ds_app_start('Notifications', 'Flux des evenements cliniques et systeme');
?>

<section class="metrics-grid">
    <?php ds_stat_card('fa-regular fa-bell', 'Notifications', count($notifications), 'green', 'Total'); ?>
    <?php ds_stat_card('fa-solid fa-triangle-exclamation', 'Critiques', '1', 'red', 'Urgent'); ?>
    <?php ds_stat_card('fa-regular fa-clock', 'En attente', '1', 'yellow', 'A traiter'); ?>
    <?php ds_stat_card('fa-regular fa-circle-check', 'Lues', '2', 'green', 'Archivees'); ?>
</section>

<section class="workspace-grid">
    <article class="panel">
        <div class="panel-header">
            <div>
                <h2>Centre de notifications</h2>
                <p>Les evenements importants du suivi patient.</p>
            </div>
            <a class="btn-soft" href="<?= BASE_URL ?>/notifications?lus=1">
                <i class="fa-regular fa-circle-check"></i>
                Tout marquer lu
            </a>
        </div>

        <div class="risk-list">
            <?php foreach ($notifications as $notification): ?>
                <article class="risk-item <?= $notification['type'] === 'CRITIQUE' ? 'risk-danger' : ($notification['type'] === 'EN_ATTENTE' ? 'risk-warning' : '') ?>">
                    <span class="risk-dot"></span>
                    <div>
                        <strong><?= ds_e($notification['titre']) ?></strong>
                        <small><?= ds_e($notification['message']) ?></small>
                    </div>
                    <div style="display:grid;gap:6px;justify-items:end">
                        <?= ds_badge($notification['type']) ?>
                        <small class="muted"><?= ds_e($notification['date']) ?></small>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </article>

    <aside class="panel">
        <div class="panel-header">
            <div>
                <h2>Canaux actifs</h2>
                <p>Preferences de reception.</p>
            </div>
        </div>

        <div class="settings-list">
            <label class="setting-row">
                <span><strong>Alertes critiques</strong><small>Temps reel</small></span>
                <input type="checkbox" checked>
            </label>
            <label class="setting-row">
                <span><strong>Rapports PDF</strong><small>Generation de document</small></span>
                <input type="checkbox" checked>
            </label>
            <label class="setting-row">
                <span><strong>Connexions</strong><small>Securite du compte</small></span>
                <input type="checkbox">
            </label>
        </div>
    </aside>
</section>

<?php ds_app_end(); ?>
