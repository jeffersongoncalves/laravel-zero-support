<?php

namespace JeffersonGoncalves\LaravelZero\Support;

class Browser
{
    /**
     * Open the given URL in the system's default browser.
     *
     * Returns true when the launch command exits successfully.
     */
    public static function open(string $url): bool
    {
        $escaped = escapeshellarg($url);

        $command = match (PHP_OS_FAMILY) {
            'Windows' => "start \"\" {$escaped}",
            'Darwin' => "open {$escaped}",
            default => "xdg-open {$escaped}",
        };

        exec($command, $output, $exitCode);

        return $exitCode === 0;
    }
}
