<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class ContactUrgence extends Model
{
    protected string $table = 'contact_urgence';

    protected string $primaryKey = 'id';

    public function getByPatient(int $patientId): array
    {
        return $this->where(
            'patient_id',
            $patientId
        );
    }

    public function createContact(array $data): bool
    {
        return $this->create($data);
    }

    public function updateContact(
        int $id,
        array $data
    ): bool {

        return $this->update(
            $id,
            $data
        );

    }

    public function deleteContact(
        int $id
    ): bool {

        return $this->delete($id);

    }

    public function total(): int
    {
        return $this->count();
    }
}