<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

ds_app_start('Nouveau medecin', 'Ajouter un profil clinique');
?>

<form class="form-panel" action="<?= BASE_URL ?>/medecin/store" method="POST">
    <div class="form-grid">
        <label>
            ID utilisateur
            <input type="number" name="utilisateur_id" placeholder="Ex: 2" required>
        </label>
        <label>
            Numero ordre
            <input type="text" name="numero_ordre" value="ORD-2026-004" required>
        </label>
        <label>
            Specialite
            <select name="specialite_id" required>
                <option value="1">Medecine generale</option>
                <option value="2">Cardiologie</option>
                <option value="3">Pediatrie</option>
                <option value="4">Urgences</option>
            </select>
        </label>
        <label>
            Service
            <select name="service_id" required>
                <option value="1">Urgences</option>
                <option value="2">Cardiologie</option>
                <option value="3">Pediatrie</option>
                <option value="4">Medecine generale</option>
            </select>
        </label>
        <label>
            Disponibilite
            <select name="disponible">
                <option value="1">Disponible</option>
                <option value="0">Indisponible</option>
            </select>
        </label>
        <button class="btn-primary full" type="submit">Enregistrer le medecin</button>
    </div>
</form>

<?php ds_app_end(); ?>