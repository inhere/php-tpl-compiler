<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
  <p>展示模板文件视图</p>
  <p><?php echo $name; ?></p>
  <p><?php echo $age; ?></p>
  <?php echo ++$age; ?>
  <?php echo $this->name; ?>
  <?php if ($age > 18) {?>
    <p>已成年</p>
  <?php } else if ($age < 10) {?>
    <p>小毛孩</p>
  <?php }?>
  <?php foreach ($friends as $k => $v) {?>
   <p><?php echo $v?> </p>
  <?php }?>

  <?php foreach ($friends as $nk => $nv) {?>
   <p><?php echo $nv; ?> </p>
  <?php }?>
</body>
</html>