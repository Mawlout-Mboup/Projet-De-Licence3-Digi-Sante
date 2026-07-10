<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class RendezVous extends Model
{
    protected string $table = 'rendez_vous';

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

    public function getByStatut(string $statut): array
    {
        return $this->where('statut', $statut);
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

    public function confirmer(int $id): bool
    {
        return $this->update($id, [
            'statut' => 'CONFIRME'
        ]);
    }

    public function annuler(int $id): bool
    {
        return $this->update($id, [
            'statut' => 'ANNULE'
        ]);
    }

    public function terminer(int $id): bool
    {
        return $this->update($id, [
            'statut' => 'TERMINE'
        ]);
    }

    public function total(): int
    {
        return $this->count();
    }
}