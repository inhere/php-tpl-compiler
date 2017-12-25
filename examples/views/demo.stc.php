<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
  <p>展示模板文件视图</p>
  <p><?=$name;?></p>
  <p><?=ucfirst($name);?></p>
  <p><?=$age;?></p>
  <p><?=$notExists ?? 'default';?></p>
  <?php echo ++$age; ?>

  <?php echo $name; ?>
  <?php if ($age > 18) {?>
    <p>已成年</p>
  <?php } else if ($age < 10) {?>
    <p>小毛孩</p>
  <?php }?>

  <h3>friends:</h3>

  <?php foreach ($friends as $k => $v) {?>
   <p><?=$v?> </p>
  <?php }?>
  <h3>friends:</h3>
  <?php foreach ($friends as $nk => $nv) {?>
   <p><?=$nv;?> </p>
  <?php }?>
</body>
</html>