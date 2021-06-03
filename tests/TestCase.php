<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function fixture(string $fileName)
    {
        return require __DIR__ . "/Fixtures/{$fileName}.php";
    }
}
