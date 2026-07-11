<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Prescription extends Model
{
    protected string $table = 'prescription';

    protected string $primaryKey = 'id';

    public function getByOrdonnance(
        int $ordonnanceId
    ): array
    {
        return $this->where(
            'ordonnance_id',
            $ordonnanceId
        );
    }

    public function createPrescription(array $data): bool
    {
        return $this->create($data);
    }

    public function updatePrescription(
        int $id,
        array $data
    ): bool {

        return $this->update($id, $data);

    }

    public function deletePrescription(
        int $id
    ): bool {

        return $this->delete($id);

    }

    public function total(): int
    {
        return $this->count();
    }
}