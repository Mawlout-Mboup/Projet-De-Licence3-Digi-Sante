<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use PDO;

class Patient extends Model
{
    protected string $table = 'patient';

    protected string $primaryKey = 'utilisateur_id';

    public function findById(int $id): array|false
    {
        $sql = "

            SELECT

                p.*,

                u.prenom,

                u.nom,

                u.email,

                u.telephone,

                u.photo,

                u.statut

            FROM patient p

            INNER JOIN utilisateur u

                ON u.id = p.utilisateur_id

            WHERE

                p.utilisateur_id = :id

            LIMIT 1

        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([

            'id' => $id

        ]);

        return $stmt->fetch();
    }

    public function getAll(): array
    {
        $sql = "

            SELECT

                p.*,

                u.prenom,

                u.nom,

                u.email,

                u.telephone,

                u.photo,

                u.statut

            FROM patient p

            INNER JOIN utilisateur u

                ON u.id = p.utilisateur_id

            ORDER BY

                u.nom,

                u.prenom

        ";

        return $this->db
            ->query($sql)
            ->fetchAll();
    }

    public function createPatient(
        array $data
    ): bool {

        return $this->create($data);

    }

    public function updatePatient(
        int $id,
        array $data
    ): bool {

        return $this->update(
            $id,
            $data
        );

    }

    public function deletePatient(
        int $id
    ): bool {

        return $this->delete($id);

    }

    public function findByNumeroDossier(
        string $numero
    ): array|false {

        return $this->firstWhere(
            'numero_dossier',
            $numero
        );

    }

    public function numeroExiste(
        string $numero
    ): bool {

        return $this->findByNumeroDossier(
            $numero
        ) !== false;

    }
        public function rechercher(
        string $motCle
    ): array {

        $sql = "

            SELECT

                p.*,

                u.prenom,

                u.nom,

                u.email,

                u.telephone

            FROM patient p

            INNER JOIN utilisateur u

                ON u.id = p.utilisateur_id

            WHERE

                u.prenom LIKE :motcle

                OR

                u.nom LIKE :motcle

                OR

                u.email LIKE :motcle

                OR

                p.numero_dossier LIKE :motcle

            ORDER BY

                u.nom,

                u.prenom

        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([

            'motcle' => "%{$motCle}%"

        ]);

        return $stmt->fetchAll();

    }

    public function findByGroupeSanguin(
        string $groupe
    ): array {

        return $this->where(
            'groupe_sanguin',
            $groupe
        );

    }

    public function findBySexe(
        string $sexe
    ): array {

        return $this->where(
            'sexe',
            $sexe
        );

    }

    public function total(): int
    {
        return $this->count();
    }

    public function age(
        string $dateNaissance
    ): int {

        return (new \DateTime($dateNaissance))
            ->diff(new \DateTime())
            ->y;

    }

    public function getDossierMedical(
        int $patientId
    ): array|false {

        $sql = "

            SELECT *

            FROM dossier_medical

            WHERE patient_id=:id

            LIMIT 1

        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([

            'id' => $patientId

        ]);

        return $stmt->fetch();

    }

    public function getContactsUrgence(
        int $patientId
    ): array {

        $sql = "

            SELECT *

            FROM contact_urgence

            WHERE patient_id=:id

            ORDER BY nom

        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([

            'id' => $patientId

        ]);

        return $stmt->fetchAll();

    }
        public function getConstantes(
        int $patientId
    ): array {

        $sql = "

            SELECT *

            FROM constante_vitale

            WHERE patient_id = :id

            ORDER BY date_mesure DESC

        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([

            'id' => $patientId

        ]);

        return $stmt->fetchAll();

    }

    public function getDiagnostics(
        int $patientId
    ): array {

        $sql = "

            SELECT *

            FROM diagnostic

            WHERE patient_id = :id

            ORDER BY date_diagnostic DESC

        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([

            'id' => $patientId

        ]);

        return $stmt->fetchAll();

    }

    public function getConsultations(
        int $patientId
    ): array {

        $sql = "

            SELECT *

            FROM consultation

            WHERE patient_id = :id

            ORDER BY date_consultation DESC

        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([

            'id' => $patientId

        ]);

        return $stmt->fetchAll();

    }

    public function getRapports(
        int $patientId
    ): array {

        $sql = "

            SELECT *

            FROM rapport

            WHERE patient_id = :id

            ORDER BY date_generation DESC

        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([

            'id' => $patientId

        ]);

        return $stmt->fetchAll();

    }

    public function derniersPatients(
        int $limite = 10
    ): array {

        $sql = "

            SELECT

                p.*,

                u.prenom,

                u.nom

            FROM patient p

            INNER JOIN utilisateur u

                ON u.id = p.utilisateur_id

            ORDER BY

                p.created_at DESC

            LIMIT {$limite}

        ";

        return $this->db
            ->query($sql)
            ->fetchAll();

    }

    public function dashboard(): array
    {
        return [

            'total' => $this->total(),

            'nouveaux' => count(
                $this->derniersPatients(5)
            )

        ];
    }
}