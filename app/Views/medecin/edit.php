<?php

declare(strict_types=1);

require_once VIEW_PATH . '/components/platform.php';

$medecin = $medecin ?? [
    'utilisateur_id' => 2,
    'numero_ordre' => 'ORD-2026-001',
    'specialite_id' => 1,
    'service_id' => 4,
    'disponible' => 1,
    'prenom' => 'Amadou',
    'nom' => 'Fall'
];

ds_app_start('Modifier medecin', ($medecin['prenom'] ?? '') . ' ' . ($medecin['nom'] ?? ''));
?>

<form class="form-panel" action="<?= BASE_URL ?>/medecin/update?id=<?= (int) ($medecin['utilisateur_id'] ?? 0) ?>" method="POST">
    <div class="form-grid">
        <label>
            Numero ordre
            <input type="text" name="numero_ordre" value="<?= ds_e($medecin['numero_ordre'] ?? '') ?>">
        </label>
        <label>
            Specialite
            <select name="specialite_id">
                <?php foreach ([1 => 'Medecine generale', 2 => 'Cardiologie', 3 => 'Pediatrie', 4 => 'Urgences'] as $id => $name): ?>
                    <option value="<?= $id ?>" <?= (int) ($medecin['specialite_id'] ?? 0) === $id ? 'selected' : '' ?>><?= ds_e($name) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>
            Service
            <select name="service_id">
                <?php foreach ([1 => 'Urgences', 2 => 'Cardiologie', 3 => 'Pediatrie', 4 => 'Medecine generale'] as $id => $name): ?>
                    <option value="<?= $id ?>" <?= (int) ($medecin['service_id'] ?? 0) === $id ? 'selected' : '' ?>><?= ds_e($name) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>
            Disponibilite
            <select name="disponible">
                <option value="1" <?= !empty($medecin['disponible']) ? 'selected' : '' ?>>Disponible</option>
                <option value="0" <?= empty($medecin['disponible']) ? 'selected' : '' ?>>Indisponible</option>
            </select>
        </label>
        <button class="btn-primary full" type="submit">Mettre a jour</button>
    </div>
</form>

<?php ds_app_end(); ?>