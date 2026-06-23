# laravel-zero-support

Reusable base utilities shared by [Laravel Zero](https://laravel-zero.com) CLI tools. It provides cross-OS home/config directory resolution, opening URLs in the default browser, and secure JSON file writing - the small pieces of glue every CLI ends up reimplementing.

## Why

CLIs repeatedly need to: find where to store config across Windows/macOS/Linux, open a browser for an OAuth flow, and persist credentials to a JSON file with safe permissions. This package centralizes those concerns as tiny, dependency-free static helpers (only requires `php: ^8.2`).

## Installation

```bash
composer require jeffersongoncalves/laravel-zero-support
```

## Usage

```php
use JeffersonGoncalves\LaravelZero\Support\Os;
use JeffersonGoncalves\LaravelZero\Support\Browser;
use JeffersonGoncalves\LaravelZero\Support\Filesystem;

// Resolve directories (cross-OS)
$home   = Os::homeDir();          // e.g. /home/jeff or C:\Users\jeff
$config = Os::configDir();        // XDG_CONFIG_HOME or {home}/.config
$win    = Os::isWindows();        // bool

// Open a URL in the default browser
Browser::open('https://example.com'); // returns bool (true on success)

// Persist and read JSON safely
$path = $home.'/.my-cli/config.json';
Filesystem::writeJsonSecure($path, ['token' => 'secret']); // dir 0700, file 0600
$data = Filesystem::readJson($path);                       // array|null
```

## Public classes

| Class | Method | Description |
|-------|--------|-------------|
| `Os` | `homeDir(): string` | Home directory: `HOME` -> `USERPROFILE` -> `HOMEDRIVE`+`HOMEPATH` -> `getcwd()`, trailing slashes trimmed. |
| `Os` | `configDir(): string` | `XDG_CONFIG_HOME` if set, otherwise `homeDir().'/.config'`. |
| `Os` | `isWindows(): bool` | Whether `PHP_OS_FAMILY === 'Windows'`. |
| `Browser` | `open(string $url): bool` | Open URL in default browser (`start`/`open`/`xdg-open`). |
| `Filesystem` | `writeJsonSecure(string $path, array $data): void` | Create parent dir (0700), write pretty JSON, chmod 0600. |
| `Filesystem` | `readJson(string $path): ?array` | Decode JSON file to array, `null` if missing/invalid. |

## License

MIT
