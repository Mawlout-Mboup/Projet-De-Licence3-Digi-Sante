<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Administrateur extends Model
{
    protected string $table = 'administrateur';

    protected string $primaryKey = 'utilisateur_id';

    public function findByUser(int $userId): array|false
    {
        return $this->find($userId);
    }

    public function findByMatricule(string $matricule): array|false
    {
        return $this->firstWhere(
            'matricule',
            $matricule
        );
    }

    public function matriculeExiste(
        string $matricule
    ): bool {

        return $this->findByMatricule(
            $matricule
        ) !== false;

    }

    public function createAdmin(
        array $data
    ): bool {

        return $this->create($data);

    }

    public function updateFonction(
        int $id,
        string $fonction
    ): bool {

        return $this->update(
            $id,
            [
                'fonction' => $fonction
            ]
        );

    }

    public function total(): int
    {
        return $this->count();
    }
}