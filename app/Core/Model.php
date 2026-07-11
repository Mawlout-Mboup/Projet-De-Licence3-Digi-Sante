<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

abstract class Model
{
    protected PDO $db;

    protected string $table;

    protected string $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all(): array
    {
        $sql = "SELECT * FROM {$this->table}";

        return $this->db
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): array|false
    {
        $sql = "
            SELECT *
            FROM {$this->table}
            WHERE {$this->primaryKey} = :id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $columns = implode(', ', array_keys($data));

        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "
            INSERT INTO {$this->table}
            ({$columns})
            VALUES
            ({$placeholders})
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }

    public function update(
        int $id,
        array $data
    ): bool {

        $fields = [];

        foreach ($data as $column => $value) {
            $fields[] = "{$column} = :{$column}";
        }

        $sql = "
            UPDATE {$this->table}
            SET " . implode(', ', $fields) . "
            WHERE {$this->primaryKey} = :id
        ";

        $data['id'] = $id;

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $sql = "
            DELETE FROM {$this->table}
            WHERE {$this->primaryKey} = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function where(
        string $column,
        mixed $value
    ): array {

        $this->validateColumn($column);

        $sql = "
            SELECT *
            FROM {$this->table}
            WHERE {$column} = :value
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'value' => $value
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function firstWhere(
        string $column,
        mixed $value
    ): array|false {

        $this->validateColumn($column);

        $sql = "
            SELECT *
            FROM {$this->table}
            WHERE {$column} = :value
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'value' => $value
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function count(): int
    {
        return (int)$this->db
            ->query("SELECT COUNT(*) FROM {$this->table}")
            ->fetchColumn();
    }

    public function exists(
        string $column,
        mixed $value
    ): bool {

        return $this->firstWhere($column, $value) !== false;
    }

    public function lastInsertId(): int
    {
        return (int)$this->db->lastInsertId();
    }

    protected function validateColumn(string $column): void
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $column)) {
            throw new RuntimeException("Nom de colonne invalide : {$column}");
        }
    }
}