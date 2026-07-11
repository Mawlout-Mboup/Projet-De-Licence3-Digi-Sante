<?php

declare(strict_types=1);

namespace App\Core;

class Validator
{
    private array $errors = [];

    public function __construct(private readonly array $data)
    {
    }

    public static function make(array $data): self
    {
        return new self($data);
    }

    public function required(string $field, string $message = ''): self
    {
        $value = trim((string) ($this->data[$field] ?? ''));

        if ($value === '') {
            $this->add($field, $message !== '' ? $message : 'Ce champ est obligatoire.');
        }

        return $this;
    }

    public function email(string $field, string $message = ''): self
    {
        $value = (string) ($this->data[$field] ?? '');

        if ($value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->add($field, $message !== '' ? $message : 'Adresse email invalide.');
        }

        return $this;
    }

    public function min(string $field, int $length, string $message = ''): self
    {
        $value = (string) ($this->data[$field] ?? '');

        if ($value !== '' && mb_strlen($value) < $length) {
            $this->add($field, $message !== '' ? $message : "Minimum {$length} caracteres.");
        }

        return $this;
    }

    public function numeric(string $field, string $message = ''): self
    {
        $value = $this->data[$field] ?? null;

        if ($value !== null && $value !== '' && !is_numeric($value)) {
            $this->add($field, $message !== '' ? $message : 'Valeur numerique attendue.');
        }

        return $this;
    }

    public function in(string $field, array $allowed, string $message = ''): self
    {
        $value = $this->data[$field] ?? null;

        if ($value !== null && !in_array($value, $allowed, true)) {
            $this->add($field, $message !== '' ? $message : 'Valeur non autorisee.');
        }

        return $this;
    }

    public function passes(): bool
    {
        return $this->errors === [];
    }

    public function fails(): bool
    {
        return !$this->passes();
    }

    public function errors(): array
    {
        return $this->errors;
    }

    private function add(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }
}
