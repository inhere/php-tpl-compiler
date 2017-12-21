<?php

require dirname(__DIR__) . '/tests/boot.php';


$data = ['name' => 'tom', 'age' => 20, 'friends' => ['jack', 'rose']];

$cpr = new Inhere\Stc\Compiler;

$cpr->compileFile(__DIR__ .'/demo.tpl', $data, __DIR__ .'/demo.stc.php');
