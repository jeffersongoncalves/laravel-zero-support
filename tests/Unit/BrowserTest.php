<?php

use JeffersonGoncalves\LaravelZero\Support\Browser;

it('exposes a static open method returning bool', function () {
    $method = new ReflectionMethod(Browser::class, 'open');

    expect($method->isStatic())->toBeTrue();
    expect((string) $method->getReturnType())->toBe('bool');
});
