<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Role extends Model
{
    protected string $table = 'role';

    protected string $primaryKey = 'id';

    public function administrateur(): array|false
    {
        return $this->firstWhere('nom', 'ADMIN');
    }

    public function medecin(): array|false
    {
        return $this->firstWhere('nom', 'MEDECIN');
    }

    public function patient(): array|false
    {
        return $this->firstWhere('nom', 'PATIENT');
    }

    public function findByName(string $nom): array|false
    {
        return $this->firstWhere('nom', strtoupper($nom));
    }
}