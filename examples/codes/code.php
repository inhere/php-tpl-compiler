<?php

require dirname(dirname(__DIR__)) . '/tests/boot.php';

$data = [
    'author' => 'inhere',
    'date' => date('Ymd'),
    'time' => date('H:i'),
    'fullCommand' => 'php some [opt]',
    'namespace' => 'Inhere\Stc\Examples',
    'parentClass' => 'SomeNamespace\SomeClass',
    'parentName' => 'SomeClass',
    'className' => 'NewClass',
    'properties' => '
    public $prop;
    ',
];

$cpr = new Inhere\Stc\Compiler;
$cpr->compileFile(__DIR__ .'/code.tpl', __DIR__ .'/code.stc.php');

echo $cpr->render($data);
