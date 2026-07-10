<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$medecin = $medecin ?? [
    'utilisateur_id' => 2,
    'prenom' => 'Amadou',
    'nom' => 'Fall',
    'email' => 'medecin@digi-sante.sn',
    'telephone' => '77 111 11 11',
    'numero_ordre' => 'ORD-2026-001',
    'specialite' => 'Medecine generale',
    'service' => 'Cardiologie',
    'disponible' => 1
];

ds_app_start('Fiche medecin', ($medecin['prenom'] ?? '') . ' ' . ($medecin['nom'] ?? ''));
?>

<section class="workspace-grid">
    <article class="panel">
        <div class="panel-header">
            <div>
                <h2>Dr <?= ds_e(($medecin['prenom'] ?? '') . ' ' . ($medecin['nom'] ?? '')) ?></h2>
                <p><?= ds_e($medecin['numero_ordre'] ?? '') ?></p>
            </div>
            <?= ds_badge(!empty($medecin['disponible']) ? 'DISPONIBLE' : 'INDISPONIBLE') ?>
        </div>

        <dl class="detail-list">
            <div><dt>Email</dt><dd><?= ds_e($medecin['email'] ?? '-') ?></dd></div>
            <div><dt>Telephone</dt><dd><?= ds_e($medecin['telephone'] ?? '-') ?></dd></div>
            <div><dt>Specialite</dt><dd><?= ds_e($medecin['specialite'] ?? '-') ?></dd></div>
            <div><dt>Service</dt><dd><?= ds_e($medecin['service'] ?? '-') ?></dd></div>
            <div><dt>Patients suivis</dt><dd>10</dd></div>
            <div><dt>Alertes traitees</dt><dd>7</dd></div>
        </dl>
    </article>

    <article class="panel">
        <div class="panel-header">
            <div>
                <h2>Activite</h2>
                <p>Charge clinique indicative.</p>
            </div>
        </div>
        <div class="risk-list">
            <div class="risk-item">
                <span class="risk-dot"></span>
                <div>
                    <strong>Diagnostics</strong>
                    <small>3 analyses recentes</small>
                </div>
                <?= ds_badge('VALIDE') ?>
            </div>
            <div class="risk-item risk-warning">
                <span class="risk-dot"></span>
                <div>
                    <strong>Alertes</strong>
                    <small>2 alertes a surveiller</small>
                </div>
                <?= ds_badge('ATTENTION') ?>
            </div>
        </div>
    </article>
</section>

<?php ds_app_end(); ?>