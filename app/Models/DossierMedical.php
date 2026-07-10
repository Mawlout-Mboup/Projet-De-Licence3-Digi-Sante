<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class DossierMedical extends Model
{
    protected string $table = 'dossier_medical';

    protected string $primaryKey = 'id';

    public function getByPatient(
        int $patientId
    ): array|false {

        return $this->firstWhere(
            'patient_id',
            $patientId
        );

    }

    public function createDossier(
        array $data
    ): bool {

        return $this->create($data);

    }

    public function updateDossier(
        int $id,
        array $data
    ): bool {

        return $this->update(
            $id,
            $data
        );

    }

    public function deleteDossier(
        int $id
    ): bool {

        return $this->delete($id);

    }

    public function total(): int
    {
        return $this->count();
    }
}