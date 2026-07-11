<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

ds_app_start('Nouveau rapport', 'Composer un document medical PDF');
?>

<form class="workspace-grid" action="<?= BASE_URL ?>/rapport/store" method="POST">
    <section class="form-panel">
        <h2>Informations du rapport</h2>
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
                Type
                <select name="type">
                    <option>Diagnostic PDF</option>
                    <option>Suivi patient</option>
                    <option>Synthese hebdomadaire</option>
                </select>
            </label>
            <label>
                Titre
                <input type="text" name="titre" value="Rapport clinique Digi-Sante" required>
            </label>
            <label class="full">
                Contenu
                <textarea name="contenu">Synthese des constantes vitales, evaluation clinique et recommandations medicales.</textarea>
            </label>
            <button class="btn-primary full" type="submit">
                <i class="fa-regular fa-file-pdf"></i>
                Enregistrer le rapport
            </button>
        </div>
    </section>

    <aside class="pdf-preview">
        <header>
            <strong>Digi-Sante</strong>
            <span>Apercu</span>
        </header>
        <h2>Rapport clinique Digi-Sante</h2>
        <span class="pdf-line"></span>
        <span class="pdf-line short"></span>
        <span class="pdf-line"></span>
        <span class="pdf-line"></span>
        <span class="pdf-line short"></span>
    </aside>
</form>

<?php ds_app_end(); ?>
