<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

ds_app_start('Parametres', 'Configuration de la plateforme et des seuils');
?>

<section class="split-grid">
    <article class="form-panel">
        <h2>Seuils cliniques</h2>
        <p>Valeurs utilisees pour detecter les alertes.</p>

        <form class="form-grid" action="<?= BASE_URL ?>/parametres" method="GET" style="margin-top:18px">
            <label>
                Temperature minimale
                <input type="number" step="0.1" value="36.0">
            </label>
            <label>
                Temperature maximale
                <input type="number" step="0.1" value="38.0">
            </label>
            <label>
                Pouls minimal
                <input type="number" value="60">
            </label>
            <label>
                Pouls maximal
                <input type="number" value="100">
            </label>
            <label>
                Glycemie maximale
                <input type="number" step="0.01" value="1.40">
            </label>
            <label>
                Saturation minimale
                <input type="number" value="95">
            </label>
            <button class="btn-primary full" type="submit">Enregistrer les seuils</button>
        </form>
    </article>

    <article class="panel">
        <div class="panel-header">
            <div>
                <h2>Preferences systeme</h2>
                <p>Options de fonctionnement.</p>
            </div>
        </div>

        <div class="settings-list">
            <label class="setting-row"><span><strong>Mode maintenance</strong><small>Desactive par defaut</small></span><input type="checkbox"></label>
            <label class="setting-row"><span><strong>Alertes automatiques</strong><small>Creation sur depassement</small></span><input type="checkbox" checked></label>
            <label class="setting-row"><span><strong>Export PDF</strong><small>Rapports de diagnostic</small></span><input type="checkbox" checked></label>
            <label class="setting-row"><span><strong>Journalisation</strong><small>Trace des actions sensibles</small></span><input type="checkbox" checked></label>
        </div>
    </article>
</section>

<section class="panel" style="margin-top:20px">
    <div class="panel-header">
        <div>
            <h2>Informations application</h2>
            <p>Parametres generaux.</p>
        </div>
        <?= ds_badge('ACTIF') ?>
    </div>

    <dl class="detail-list">
        <div><dt>Application</dt><dd>DIGI-SANTE</dd></div>
        <div><dt>Version</dt><dd>1.0.0</dd></div>
        <div><dt>Environnement</dt><dd>Development</dd></div>
        <div><dt>Timezone</dt><dd>Africa/Dakar</dd></div>
    </dl>
</section>

<?php ds_app_end(); ?>
