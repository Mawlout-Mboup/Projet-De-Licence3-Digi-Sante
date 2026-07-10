<?php

declare(strict_types=1);

if (!function_exists('digi_sante_pdf_filename')) {
    function digi_sante_pdf_filename(string $prefix, int|string $id): string
    {
        $safePrefix = preg_replace('/[^a-z0-9_-]+/i', '-', strtolower($prefix)) ?: 'rapport';

        return $safePrefix . '-' . $id . '-' . date('Ymd-His') . '.pdf';
    }
}