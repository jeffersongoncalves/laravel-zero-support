<?php

use JeffersonGoncalves\LaravelZero\Support\Os;

afterEach(function () {
    putenv('HOME');
    putenv('USERPROFILE');
    putenv('XDG_CONFIG_HOME');
    unset($_SERVER['HOME'], $_SERVER['USERPROFILE'], $_SERVER['XDG_CONFIG_HOME']);
});

it('resolves home dir from HOME', function () {
    $_SERVER['HOME'] = '/home/jeff/';

    expect(Os::homeDir())->toBe('/home/jeff');
});

it('falls back to USERPROFILE when HOME missing', function () {
    unset($_SERVER['HOME']);
    $_SERVER['USERPROFILE'] = 'C:\\Users\\jeff\\';

    expect(Os::homeDir())->toBe('C:\\Users\\jeff');
});

it('uses XDG_CONFIG_HOME for configDir when set', function () {
    $_SERVER['XDG_CONFIG_HOME'] = '/custom/config/';

    expect(Os::configDir())->toBe('/custom/config');
});

it('falls back configDir to home/.config when XDG unset', function () {
    unset($_SERVER['XDG_CONFIG_HOME']);
    $_SERVER['HOME'] = '/home/jeff';

    expect(Os::configDir())->toBe('/home/jeff/.config');
});

it('reports windows status matching PHP_OS_FAMILY', function () {
    expect(Os::isWindows())->toBe(PHP_OS_FAMILY === 'Windows');
});
