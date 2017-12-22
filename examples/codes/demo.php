<?php

require dirname(dirname(__DIR__)) . '/tests/boot.php';

$dst = __DIR__ .'/demo.stc.php';
$tpl = <<<EOF
My name is {\$name}, age {\$age}. {if \$age > 18} 已成年 {else if \$age < 10} 小毛孩 {/if}
Friends:
{foreach \$friends}
- {^v}
{/foreach}
EOF;

$data = ['name' => 'tom', 'age' => 20, 'friends' => ['jack', 'rose']];

$cpr = new Inhere\Stc\Compiler;
$cpr->compile($tpl, $dst);

echo $cpr->render($data);
