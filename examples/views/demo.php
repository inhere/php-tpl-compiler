<?php

require dirname(dirname(__DIR__)) . '/tests/boot.php';

$data = ['name' => 'tom', 'age' => 20, 'friends' => ['jack', 'rose']];

$cpr = new Inhere\Stc\Compiler;

$cpr->compileFile(__DIR__ .'/demo.tpl', __DIR__ .'/demo.stc.php');

// echo $cpr->render($data);
