<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use PDO;

class ConstanteVitale extends Model
{
    protected string $table = 'constante_vitale';

    protected string $primaryKey = 'id';

    public function getAll(): array
    {
        $sql = "

            SELECT

                c.*,

                u.prenom,

                u.nom

            FROM constante_vitale c

            INNER JOIN patient p

                ON p.utilisateur_id = c.patient_id

            INNER JOIN utilisateur u

                ON u.id = p.utilisateur_id

            ORDER BY c.date_mesure DESC

        ";

        return $this->db
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): array|false
    {
        return $this->find($id);
    }

    public function createConstante(array $data): bool
    {
        if (
            !empty($data['poids']) &&
            !empty($data['taille']) &&
            $data['taille'] > 0
        ) {
            $data['imc'] = round(
                $data['poids'] /
                ($data['taille'] * $data['taille']),
                2
            );
        }

        return $this->create($data);
    }

    public function updateConstante(
        int $id,
        array $data
    ): bool {

        if (
            !empty($data['poids']) &&
            !empty($data['taille']) &&
            $data['taille'] > 0
        ) {
            $data['imc'] = round(
                $data['poids'] /
                ($data['taille'] * $data['taille']),
                2
            );
        }

        return $this->update($id, $data);
    }

    public function deleteConstante(
        int $id
    ): bool {

        return $this->delete($id);
    }

    public function rechercherPatient(
        int $patient
    ): array {

        return $this->where(
            'patient_id',
            $patient
        );
    }

    public function critiques(): array
    {
        $sql = "

            SELECT *

            FROM constante_vitale

            WHERE

                temperature > 38

                OR

                pouls > 100

                OR

                saturation < 95

                OR

                glycemie > 1.40

            ORDER BY

                date_mesure DESC

        ";

        return $this->db
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function dashboard(): array
    {
        return [

            'total' => $this->count(),

            'critiques' => count(
                $this->critiques()
            )

        ];
    }
        public function total(): int
    {
        return $this->count();
    }

    public function dernieres(int $limite = 10): array
    {
        $sql = "

            SELECT

                c.*,

                u.prenom,

                u.nom

            FROM constante_vitale c

            INNER JOIN patient p

                ON p.utilisateur_id = c.patient_id

            INNER JOIN utilisateur u

                ON u.id = p.utilisateur_id

            ORDER BY

                c.date_mesure DESC

            LIMIT {$limite}

        ";

        return $this->db
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByPatient(int $patientId): array
    {
        $sql = "

            SELECT

                *

            FROM constante_vitale

            WHERE patient_id = :patient

            ORDER BY date_mesure DESC

        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([

            'patient' => $patientId

        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}