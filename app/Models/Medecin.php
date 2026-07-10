<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use PDO;

class Medecin extends Model
{
    protected string $table = 'medecin';

    protected string $primaryKey = 'utilisateur_id';

    public function getAll(): array
    {
        $sql = "

            SELECT

                m.*,

                u.prenom,

                u.nom,

                u.email,

                u.telephone,

                u.photo,

                u.statut,

                s.nom AS specialite,

                sv.nom AS service

            FROM medecin m

            INNER JOIN utilisateur u

                ON u.id = m.utilisateur_id

            INNER JOIN specialite s

                ON s.id = m.specialite_id

            INNER JOIN service sv

                ON sv.id = m.service_id

            ORDER BY

                u.nom,

                u.prenom

        ";

        return $this->db
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): array|false
    {
        $sql = "

            SELECT

                m.*,

                u.prenom,

                u.nom,

                u.email,

                u.telephone,

                u.photo,

                u.statut,

                s.nom AS specialite,

                sv.nom AS service

            FROM medecin m

            INNER JOIN utilisateur u

                ON u.id = m.utilisateur_id

            INNER JOIN specialite s

                ON s.id = m.specialite_id

            INNER JOIN service sv

                ON sv.id = m.service_id

            WHERE m.utilisateur_id = :id

            LIMIT 1

        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createMedecin(array $data): bool
    {
        return $this->create($data);
    }

    public function updateMedecin(
        int $id,
        array $data
    ): bool {

        return $this->update($id, $data);
    }

    public function deleteMedecin(
        int $id
    ): bool {

        return $this->delete($id);
    }

    public function numeroOrdreExiste(
        string $numero
    ): bool {

        return $this->firstWhere(
            'numero_ordre',
            $numero
        ) !== false;
    }

    public function rechercher(
        string $motCle
    ): array {

        $sql = "

            SELECT

                m.*,

                u.prenom,

                u.nom,

                u.email,

                s.nom AS specialite

            FROM medecin m

            INNER JOIN utilisateur u

                ON u.id = m.utilisateur_id

            INNER JOIN specialite s

                ON s.id = m.specialite_id

            WHERE

                u.prenom LIKE :motcle

                OR

                u.nom LIKE :motcle

                OR

                u.email LIKE :motcle

                OR

                m.numero_ordre LIKE :motcle

            ORDER BY

                u.nom,

                u.prenom

        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'motcle' => "%{$motCle}%"
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function disponibles(): array
    {
        return $this->where(
            'disponible',
            1
        );
    }

    public function indisponibles(): array
    {
        return $this->where(
            'disponible',
            0
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

            'disponibles' => count(
                $this->disponibles()
            ),

            'indisponibles' => count(
                $this->indisponibles()
            )

        ];
    }
}