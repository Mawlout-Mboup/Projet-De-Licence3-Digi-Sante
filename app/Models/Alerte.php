<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Alerte extends Model
{
    protected string $table = 'alerte';

    protected string $primaryKey = 'id';

    public function findById(int $id): array|false
    {
        return $this->find($id);
    }

    public function getByPatient(int $patientId): array
    {
        return $this->where('patient_id', $patientId);
    }

    public function getByStatut(string $statut): array
    {
        return $this->where('statut', $statut);
    }

    public function getByNiveau(string $niveau): array
    {
        return $this->where('niveau', $niveau);
    }

    public function createAlerte(array $data): bool
    {
        return $this->create($data);
    }

    public function updateAlerte(
        int $id,
        array $data
    ): bool {

        return $this->update($id, $data);

    }

    public function prendreEnCharge(
        int $id,
        int $utilisateurId
    ): bool {

        return $this->update($id, [

            'statut' => 'PRISE_EN_CHARGE',

            'traite_par' => $utilisateurId

        ]);

    }

    public function resoudre(int $id): bool
    {
        return $this->update($id, [

            'statut' => 'RESOLUE',

            'date_resolution' => date('Y-m-d H:i:s')

        ]);
    }

    public function fermer(int $id): bool
    {
        return $this->update($id, [

            'statut' => 'FERMEE'

        ]);
    }

    public function critiques(): array
    {
        return $this->where('niveau', 'CRITIQUE');
    }

    public function total(): int
    {
        return $this->count();
    }

    public function dashboard(): array
    {
        return [

            'total' => $this->total(),

            'critiques' => count($this->critiques()),

            'nouvelles' => count($this->getByStatut('NOUVELLE')),

            'resolues' => count($this->getByStatut('RESOLUE'))

        ];
    }
}