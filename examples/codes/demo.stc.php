My name is <?php echo $name; ?>, age <?php echo $age; ?>. <?php if ($age > 18) {?> 已成年 <?php } else if ($age < 10) {?> 小毛孩 <?php }?>
Friends:
<?php foreach ($friends as $k => $v) {?>
- <?php echo $v?>
<?php }?>