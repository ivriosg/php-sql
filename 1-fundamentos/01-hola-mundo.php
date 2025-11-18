<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hola mundo PHP</title>
</head>

<body>
  <h1>Hola mundo desde PHP</h1>
  <p><?php echo "Fecha actual: " . date('Y-m-d H:i:s'); ?></p>
  <p><?php echo "Fecha actual: " . date('Y-m-d'); ?></p>
  <p><?php echo "Copyright  © " . date('Y'); ?></p>


  <?php phpinfo(); ?>
</body>

</html>