<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Utilisateur extends Model
{
    protected string $table = 'utilisateur';

    protected string $primaryKey = 'id';

    public function findById(int $id): array|false
    {
        return $this->find($id);
    }

    public function findByEmail(string $email): array|false
    {
        if (trim($email) === '') {
            return false;
        }

        return $this->firstWhere('email', $email);
    }

    public function findByTelephone(string $telephone): array|false
    {
        $telephone = trim($telephone);

        if ($telephone === '') {
            return false;
        }

        return $this->firstWhere('telephone', $telephone);
    }

    public function findByIdentifiant(string $identifiant): array|false
    {
        $identifiant = trim($identifiant);

        if ($identifiant === '') {
            return false;
        }

        $digits = preg_replace('/\D+/', '', $identifiant) ?? '';

        $sql = "
            SELECT *
            FROM {$this->table}
            WHERE email = :email_identifiant
               OR telephone = :telephone_identifiant
        ";

        $params = [
            'email_identifiant' => $identifiant,
            'telephone_identifiant' => $identifiant
        ];

        if ($digits !== '') {
            $sql .= "
               OR REPLACE(
                    REPLACE(
                        REPLACE(
                            REPLACE(
                                REPLACE(
                                    REPLACE(telephone, ' ', ''),
                                    '+',
                                    ''
                                ),
                                '-',
                                ''
                            ),
                            '.',
                            ''
                        ),
                        '(',
                        ''
                    ),
                    ')',
                    ''
                ) = :digits
            ";

            $params['digits'] = $digits;
        }

        $sql .= " LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetch();
    }

    public function emailExiste(string $email): bool
    {
        return $this->findByEmail($email) !== false;
    }

    public function telephoneExiste(string $telephone): bool
    {
        return $this->findByIdentifiant($telephone) !== false;
    }

    public function createUser(array $data): bool
    {
        if (array_key_exists('email', $data) && trim((string) $data['email']) === '') {
            $data['email'] = null;
        }

        if (array_key_exists('telephone', $data) && trim((string) $data['telephone']) === '') {
            $data['telephone'] = null;
        }

        $data['mot_de_passe'] = password_hash(
            $data['mot_de_passe'],
            PASSWORD_BCRYPT
        );

        $data['statut'] = 'ACTIF';

        return $this->create($data);
    }

    public function authenticate(
        string $identifiant,
        string $password
    ): array|false {

        $user = $this->findByIdentifiant($identifiant);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['mot_de_passe'])) {
            return false;
        }

        if ($user['statut'] !== 'ACTIF') {
            return false;
        }

        unset($user['mot_de_passe']);

        return $user;
    }

    public function updatePhoto(
        int $id,
        string $photo
    ): bool {

        return $this->update(
            $id,
            [
                'photo' => $photo
            ]
        );
    }

    public function updatePassword(
        int $id,
        string $password
    ): bool {

        return $this->update(
            $id,
            [
                'mot_de_passe' => password_hash(
                    $password,
                    PASSWORD_BCRYPT
                )
            ]
        );
    }

    public function activate(int $id): bool
    {
        return $this->update(
            $id,
            [
                'statut' => 'ACTIF'
            ]
        );
    }

    public function deactivate(int $id): bool
    {
        return $this->update(
            $id,
            [
                'statut' => 'INACTIF'
            ]
        );
    }

    public function byRole(int $roleId): array
    {
        return $this->where(
            'role_id',
            $roleId
        );
    }

    public function admins(): array
    {
        return $this->byRole(1);
    }

    public function medecins(): array
    {
        return $this->byRole(2);
    }

    public function patients(): array
    {
        return $this->byRole(3);
    }
}
