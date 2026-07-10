<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Specialite extends Model
{
    protected string $table = 'specialite';

    protected string $primaryKey = 'id';

    public function findById(int $id): array|false
    {
        return $this->find($id);
    }

    public function findByNom(string $nom): array|false
    {
        return $this->firstWhere('nom', $nom);
    }

    public function nomExiste(string $nom): bool
    {
        return $this->findByNom($nom) !== false;
    }

    public function createSpecialite(array $data): bool
    {
        return $this->create($data);
    }

    public function updateSpecialite(
        int $id,
        array $data
    ): bool {

        return $this->update($id, $data);

    }

    public function deleteSpecialite(int $id): bool
    {
        return $this->delete($id);
    }

    public function getAll(): array
    {
        return $this->all();
    }

    public function total(): int
    {
        return $this->count();
    }
}