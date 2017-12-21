<?php

error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('Asia/Shanghai');

spl_autoload_register(function($class)
{
    $file = null;
    if (0 === strpos($class,'Inhere\Stc\Examples\\')) {
        $path = str_replace('\\', '/', substr($class, strlen('Inhere\Stc\Examples\\')));
        $file = dirname(__DIR__) . "/examples/{$path}.php";
    } elseif (0 === strpos($class,'Inhere\Stc\Tests\\')) {
        $path = str_replace('\\', '/', substr($class, strlen('Inhere\Stc\Tests\\')));
        $file = __DIR__ . "/{$path}.php";
    } elseif (0 === strpos($class,'Inhere\Stc\\')) {
        $path = str_replace('\\', '/', substr($class, strlen('Inhere\Stc\\')));
        $file = dirname(__DIR__) . "/src/{$path}.php";
    }
    if ($file && is_file($file)) {
        include $file;
    }
});
