<?php

use Symfony\Component\Dotenv\Dotenv;
use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;

// Make environment variables stored in .env accessible via getenv(), $_ENV or $_SERVER.
(new Dotenv())->load('.env');

// Determine application environment ('dev' or 'prod').
$appEnv = getenv('APP_ENV');

$aggregator = new ConfigAggregator([
    // Include your config providers here.
    // ...

    // Load config according to chosen environment.
    //   - `dev.php`
    //   - `*.dev.php`
    //   - `prod.php`
    //   - `*.prod.php`
    new PhpFileProvider(realpath(__DIR__) . "/autoload/{,*.}{$appEnv}.php"),

    // Load application config according to environment:
    //   - `dev.global.php`,   `test.global.php`,   `prod.global.php`
    //   - `*.dev.global.php`, `*.test.global.php`, `*.prod.global.php`
    //   - `dev.local.php`,    `testlocal.php`,     `prod.local.php`
    //   - `*.dev.local.php`,  `*.test.local.php`,  `*.prod.local.php`
    new PhpFileProvider(realpath(__DIR__) . "/autoload/{{,*.}{$appEnv}.global,{,*.}{$appEnv}.local}.php"),
]);

return $aggregator->getMergedConfig();
