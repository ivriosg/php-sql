<?php
$nombre = $_GET['nombre'] ?? null;
$edad = isset($_GET['edad']) ? (int)$_GET['edad'] : null;
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Variables y condicionales</title>
</head>

<body>
  <h1>Variables y condicionales</h1>
  <?php if ($nombre): ?>
    <p>Hola, <?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>.</p>
    <?php if ($edad !== null): ?>
      <p>Tienes <?php echo $edad; ?> años.</p>
      <p><?php echo $edad >= 18 ? "Eres mayor de edad" : "Eres menor de edad"; ?></p>
    <?php endif; ?>
  <?php else: ?>
    <form method="get">
      <label>Nombre: <input type="text" name="nombre" required></label>
      <label>Edad: <input type="number" name="edad" min="0"></label>
      <button type="submit">Enviar</button>
    </form>
  <?php endif; ?>
</body>

</html>