<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class ParametreSysteme extends Model
{
    protected string $table = 'parametre_systeme';

    protected string $primaryKey = 'id';

    public function get(string $cle): mixed
    {
        $parametre = $this->firstWhere(
            'cle',
            $cle
        );

        return $parametre
            ? $parametre['valeur']
            : null;
    }

    public function set(
        string $cle,
        string $valeur
    ): bool {

        $parametre = $this->firstWhere(
            'cle',
            $cle
        );

        if ($parametre) {

            return $this->update(
                (int) $parametre['id'],
                [
                    'valeur' => $valeur
                ]
            );

        }

        return $this->create([

            'cle' => $cle,

            'valeur' => $valeur

        ]);
    }

    public function tous(): array
    {
        return $this->all();
    }
}