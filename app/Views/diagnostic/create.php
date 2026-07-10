<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

ob_start();
?>
<a href="<?= BASE_URL ?>/diagnostics" class="btn-soft">
    <i class="fa-solid fa-arrow-left"></i>
    Historique
</a>
<?php
$actions = ob_get_clean();

ds_app_start('Creer un diagnostic', 'Rediger un nouveau diagnostic medical', $actions);
?>

<form action="<?= BASE_URL ?>/diagnostic/store" method="POST" class="workspace-grid">
    <div class="single-column">
        <section class="form-panel">
            <h2><i class="fa-regular fa-user"></i> Informations patient</h2>
            <div class="form-grid" style="margin-top:18px">
                <label>
                    Patient
                    <input type="number" name="patient_id" value="3" required>
                </label>
                <label>
                    Medecin
                    <input type="number" name="medecin_id" value="<?= (int) (ds_user()['id'] ?? 2) ?>" required>
                </label>
                <label>
                    Consultation
                    <input type="number" name="consultation_id" value="1" required>
                </label>
                <label>
                    Date
                    <input type="date" value="<?= date('Y-m-d') ?>">
                </label>
            </div>
        </section>

        <section class="form-panel">
            <h2><i class="fa-solid fa-heart-pulse"></i> Constantes vitales</h2>
            <div class="form-grid" style="margin-top:18px">
                <label>
                    Temperature (C)
                    <input type="number" step="0.1" value="37.1">
                </label>
                <label>
                    Tension systolique
                    <input type="number" value="122">
                </label>
                <label>
                    Tension diastolique
                    <input type="number" value="82">
                </label>
                <label>
                    Pouls (bpm)
                    <input type="number" value="74">
                </label>
                <label>
                    Glycemie (g/L)
                    <input type="number" step="0.01" value="0.98">
                </label>
                <label>
                    Titre
                    <input type="text" name="titre" value="Surveillance clinique" required>
                </label>
            </div>
        </section>

        <section class="form-panel">
            <h2><i class="fa-regular fa-clipboard"></i> Analyse medicale</h2>
            <label style="margin-top:18px">
                Description
                <textarea name="description" required>Patient a surveiller. Constantes globalement stables avec controle recommande dans 48 heures.</textarea>
            </label>
        </section>
    </div>

    <aside class="single-column">
        <section class="panel">
            <div class="panel-header">
                <div>
                    <h2>Niveau de risque</h2>
                    <p>Evaluation clinique</p>
                </div>
            </div>

            <div class="risk-list">
                <label class="risk-item">
                    <span class="risk-dot"></span>
                    <span><strong>Faible</strong><small>Pas d'urgence medicale</small></span>
                    <input type="radio" name="gravite" value="FAIBLE">
                </label>
                <label class="risk-item risk-warning">
                    <span class="risk-dot"></span>
                    <span><strong>Modere</strong><small>Surveillance renforcee</small></span>
                    <input type="radio" name="gravite" value="MOYEN" checked>
                </label>
                <label class="risk-item risk-danger">
                    <span class="risk-dot"></span>
                    <span><strong>Eleve</strong><small>Consultation rapide</small></span>
                    <input type="radio" name="gravite" value="ELEVE">
                </label>
                <label class="risk-item risk-danger">
                    <span class="risk-dot"></span>
                    <span><strong>Critique</strong><small>Hospitalisation urgente</small></span>
                    <input type="radio" name="gravite" value="CRITIQUE">
                </label>
            </div>
        </section>

        <section class="panel">
            <input type="hidden" name="statut" value="EN_ATTENTE">
            <button class="btn-primary" type="submit" style="width:100%">
                <i class="fa-regular fa-circle-check"></i>
                Enregistrer le diagnostic
            </button>
            <a href="<?= BASE_URL ?>/rapports" class="btn-soft" style="width:100%;margin-top:12px">
                <i class="fa-regular fa-file-pdf"></i>
                Generer le PDF
            </a>
        </section>
    </aside>
</form>

<?php ds_app_end(); ?>
