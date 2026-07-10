<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Rapport extends Model
{
    protected string $table = 'rapport';

    protected string $primaryKey = 'id';

    public function findById(int $id): array|false
    {
        return $this->find($id);
    }

    public function getByPatient(int $patientId): array
    {
        return $this->where('patient_id', $patientId);
    }

    public function getByMedecin(int $medecinId): array
    {
        return $this->where('medecin_id', $medecinId);
    }

    public function creer(array $data): bool
    {
        return $this->create($data);
    }

    public function modifier(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    public function supprimer(int $id): bool
    {
        return $this->delete($id);
    }

    public function total(): int
    {
        return $this->count();
    }
}