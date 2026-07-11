<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class HistoriqueConstante extends Model
{
    protected string $table = 'historique_constante';

    protected string $primaryKey = 'id';

    public function getByConstante(int $constanteId): array
    {
        return $this->where(
            'constante_id',
            $constanteId
        );
    }

    public function getByUtilisateur(int $utilisateurId): array
    {
        return $this->where(
            'utilisateur_id',
            $utilisateurId
        );
    }

    public function enregistrer(array $data): bool
    {
        return $this->create($data);
    }

    public function supprimer(int $id): bool
    {
        return $this->delete($id);
    }

    public function derniers(
        int $limite = 20
    ): array {

        $sql = "

            SELECT *

            FROM historique_constante

            ORDER BY date_modification DESC

            LIMIT {$limite}

        ";

        return $this->db
            ->query($sql)
            ->fetchAll();
    }

    public function total(): int
    {
        return $this->count();
    }
}