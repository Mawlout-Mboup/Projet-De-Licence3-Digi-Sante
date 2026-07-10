<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Diagnostic extends Model
{
    protected string $table = 'diagnostic';

    protected string $primaryKey = 'id';

    public function findById(int $id): array|false
    {
        return $this->find($id);
    }

    public function getByPatient(
        int $patientId
    ): array {

        return $this->where(
            'patient_id',
            $patientId
        );

    }

    public function getByMedecin(
        int $medecinId
    ): array {

        return $this->where(
            'medecin_id',
            $medecinId
        );

    }

    public function createDiagnostic(
        array $data
    ): bool {

        return $this->create($data);

    }

    public function updateDiagnostic(
        int $id,
        array $data
    ): bool {

        return $this->update(
            $id,
            $data
        );

    }

    public function deleteDiagnostic(
        int $id
    ): bool {

        return $this->delete($id);

    }

    public function rechercher(
        string $motCle
    ): array {

        $sql = "

            SELECT *

            FROM diagnostic

            WHERE

                titre LIKE :motcle

                OR

                description LIKE :motcle

            ORDER BY date_diagnostic DESC

        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([

            'motcle' => "%{$motCle}%"

        ]);

        return $stmt->fetchAll();

    }
        public function parGravite(
        string $gravite
    ): array {

        return $this->where(
            'gravite',
            $gravite
        );

    }

    public function parStatut(
        string $statut
    ): array {

        return $this->where(
            'statut',
            $statut
        );

    }

    public function valider(
        int $id
    ): bool {

        return $this->update(
            $id,
            [
                'statut' => 'VALIDE'
            ]
        );

    }

    public function archiver(
        int $id
    ): bool {

        return $this->update(
            $id,
            [
                'statut' => 'ARCHIVE'
            ]
        );

    }

    public function total(): int
    {
        return $this->count();
    }

    public function dashboard(): array
    {
        return [

            'total' => $this->total(),

            'critiques' => count(
                $this->parGravite('CRITIQUE')
            ),

            'valides' => count(
                $this->parStatut('VALIDE')
            ),

            'archives' => count(
                $this->parStatut('ARCHIVE')
            )

        ];
    }
}