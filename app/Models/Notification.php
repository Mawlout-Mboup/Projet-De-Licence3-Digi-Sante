<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Notification extends Model
{
    protected string $table = 'notification';

    protected string $primaryKey = 'id';

    public function getByUtilisateur(
        int $utilisateurId
    ): array {

        return $this->where(
            'utilisateur_id',
            $utilisateurId
        );

    }

    public function nonLues(
        int $utilisateurId
    ): array {

        $sql = "

            SELECT *

            FROM notification

            WHERE

                utilisateur_id = :id

                AND

                est_lue = 0

            ORDER BY created_at DESC

        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([

            'id' => $utilisateurId

        ]);

        return $stmt->fetchAll();

    }

    public function creer(
        array $data
    ): bool {

        return $this->create($data);

    }

    public function marquerCommeLue(
        int $id
    ): bool {

        return $this->update($id, [

            'est_lue' => 1,

            'date_lecture' => date('Y-m-d H:i:s')

        ]);

    }

    public function supprimer(
        int $id
    ): bool {

        return $this->delete($id);

    }

    public function total(): int
    {
        return $this->count();
    }
}