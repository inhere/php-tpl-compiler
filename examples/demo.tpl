<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
  <p>展示模板文件视图</p>
  <p>{$name}</p>
  <p>{$age}</p>
  <?php echo ++$age; ?>
  <?php echo $this->name; ?>
  {if $age > 18}
    <p>已成年</p>
  {else if $age < 10}
    <p>小毛孩</p>
  {/if}
  {foreach $friends}
   <p>{^v} </p>
  {/foreach}

  {foreach $friends as $nk => $nv}
   <p>{$nv} </p>
  {/foreach}
</body>
</html>
