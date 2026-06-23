<?php

use JeffersonGoncalves\LaravelZero\Support\Filesystem;

it('writes and reads json back (roundtrip)', function () {
    $path = sys_get_temp_dir().DIRECTORY_SEPARATOR.'lz-support-'.uniqid().DIRECTORY_SEPARATOR.'config.json';
    $data = ['username' => 'jeff', 'token' => 'secret', 'nested' => ['a' => 1]];

    Filesystem::writeJsonSecure($path, $data);

    expect(file_exists($path))->toBeTrue();
    expect(Filesystem::readJson($path))->toBe($data);

    @unlink($path);
    @rmdir(dirname($path));
});

it('returns null reading a nonexistent path', function () {
    $path = sys_get_temp_dir().DIRECTORY_SEPARATOR.'lz-support-missing-'.uniqid().'.json';

    expect(Filesystem::readJson($path))->toBeNull();
});

it('returns null reading invalid json', function () {
    $path = sys_get_temp_dir().DIRECTORY_SEPARATOR.'lz-support-invalid-'.uniqid().'.json';
    file_put_contents($path, '{ not valid json');

    expect(Filesystem::readJson($path))->toBeNull();

    @unlink($path);
});
