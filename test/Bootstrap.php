<?php

error_reporting(E_ALL | E_STRICT);

if (function_exists('xdebug_disable')) {
    xdebug_disable();
}

$file = __DIR__ . '/../vendor/autoload.php';
if (file_exists($file)) {
    $loader = require $file;
}

if (!isset($loader)) {
    throw new \RuntimeException(
        'vendor/autoload.php could not be found. Did you run `php composer.phar install`?'
    );
}

/** @var \Composer\Autoload\ClassLoader $loader */
$loader->add('MamuzBlogTest\\', __DIR__);

unset($file, $loader);
