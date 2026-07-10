<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class HistoriqueConnexion extends Model
{
    protected string $table = 'historique_connexion';

    protected string $primaryKey = 'id';

    public function enregistrer(array $data): bool
    {
        return $this->create($data);
    }

    public function getByUtilisateur(int $utilisateurId): array
    {
        return $this->where(
            'utilisateur_id',
            $utilisateurId
        );
    }

    public function total(): int
    {
        return $this->count();
    }

    public function dernieres(
        int $limite = 20
    ): array {

        $sql = "

            SELECT *

            FROM historique_connexion

            ORDER BY date_connexion DESC

            LIMIT {$limite}

        ";

        return $this->db
            ->query($sql)
            ->fetchAll();
    }
}