<?php

use Composer\Autoload\ClassLoader;

/** @var ClassLoader $loader */
$loader = require __DIR__ . '/../vendor/autoload.php';

$loader->add('Docx\\Tests\\Sdk', __DIR__);
