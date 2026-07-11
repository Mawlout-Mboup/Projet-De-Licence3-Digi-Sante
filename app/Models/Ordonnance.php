<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Ordonnance extends Model
{
    protected string $table = 'ordonnance';

    protected string $primaryKey = 'id';

    public function getByDiagnostic(
        int $diagnosticId
    ): array
    {
        return $this->where(
            'diagnostic_id',
            $diagnosticId
        );
    }

    public function createOrdonnance(array $data): bool
    {
        return $this->create($data);
    }

    public function updateOrdonnance(
        int $id,
        array $data
    ): bool {

        return $this->update($id, $data);

    }

    public function deleteOrdonnance(
        int $id
    ): bool {

        return $this->delete($id);

    }

    public function total(): int
    {
        return $this->count();
    }
}