<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class JournalAction extends Model
{
    protected string $table = 'journal_action';

    protected string $primaryKey = 'id';

    public function enregistrer(array $data): bool
    {
        return $this->create($data);
    }

    public function getByUtilisateur(int $utilisateurId): array
    {
        return $this->where('utilisateur_id', $utilisateurId);
    }

    public function derniers(int $limite = 50): array
    {
        $sql = "

            SELECT *

            FROM journal_action

            ORDER BY created_at DESC

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