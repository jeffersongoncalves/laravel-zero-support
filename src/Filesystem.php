<?php

namespace JeffersonGoncalves\LaravelZero\Support;

class Filesystem
{
    /**
     * Write data as pretty JSON to $path with restrictive permissions.
     *
     * Creates the parent directory (0700) when missing, writes the file and
     * chmods it to 0600 so credentials are not world-readable.
     *
     * @param  array<mixed>  $data
     */
    public static function writeJsonSecure(string $path, array $data): void
    {
        $dir = dirname($path);

        if (! is_dir($dir)) {
            mkdir($dir, 0700, true);
        }

        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        chmod($path, 0600);
    }

    /**
     * Read and decode a JSON file as an associative array.
     *
     * Returns null when the file is missing or contains invalid JSON.
     *
     * @return array<mixed>|null
     */
    public static function readJson(string $path): ?array
    {
        if (! file_exists($path)) {
            return null;
        }

        $contents = file_get_contents($path);

        if ($contents === false) {
            return null;
        }

        $data = json_decode($contents, true);

        return is_array($data) ? $data : null;
    }
}
