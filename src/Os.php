<?php

namespace JeffersonGoncalves\LaravelZero\Support;

class Os
{
    /**
     * Resolve the current user's home directory in a cross-OS way.
     *
     * Resolution order: HOME -> USERPROFILE -> HOMEDRIVE+HOMEPATH -> getcwd().
     * Any trailing slash or backslash is trimmed off.
     */
    public static function homeDir(): string
    {
        $home = match (true) {
            isset($_SERVER['HOME']) && $_SERVER['HOME'] !== '' => $_SERVER['HOME'],
            isset($_SERVER['USERPROFILE']) && $_SERVER['USERPROFILE'] !== '' => $_SERVER['USERPROFILE'],
            isset($_SERVER['HOMEDRIVE'], $_SERVER['HOMEPATH']) => $_SERVER['HOMEDRIVE'].$_SERVER['HOMEPATH'],
            default => getcwd() ?: '.',
        };

        return rtrim($home, '/\\');
    }

    /**
     * Resolve the base config directory.
     *
     * Uses XDG_CONFIG_HOME when set, otherwise falls back to homeDir().'/.config'.
     */
    public static function configDir(): string
    {
        $xdg = $_SERVER['XDG_CONFIG_HOME'] ?? null;

        if (is_string($xdg) && $xdg !== '') {
            return rtrim($xdg, '/\\');
        }

        return self::homeDir().'/.config';
    }

    /**
     * Whether the current platform is Windows.
     */
    public static function isWindows(): bool
    {
        return PHP_OS_FAMILY === 'Windows';
    }
}
