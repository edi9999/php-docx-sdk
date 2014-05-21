<?php
/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 4/25/14
 * Time: 6:52 PM
 */
use Composer\Autoload\ClassLoader;

/** @var ClassLoader $loader */
$loader = require __DIR__ . '/../vendor/autoload.php';

$loader->add('Docx\\Tests\\Sdk', __DIR__);
