<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $compiledPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'larahotel-test-views-' . uniqid();

        if (! is_dir($compiledPath)) {
            mkdir($compiledPath, 0777, true);
        }

        $app['config']->set('view.compiled', $compiledPath);

        return $app;
    }
}
