<?php
$errores = [];
$nombre = '';
$email = '';
$telefono = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = trim($_POST['nombre'] ?? '');
  $email = trim($_POST['email'] ?? '');

  if ($nombre === '') $errores[] = 'El nombre es obligatorio.';
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = 'El email no es válido.';
}
?>
<!doctype html>
<html lang="es-419">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Formulario básico</title>
</head>

<body>
  <h1>Formulario básico</h1>
  <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$errores): ?>
    <p>Gracias, <?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>.</p>
    <p>Te contactaremos en: <?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></p>
  <?php else: ?>
    <?php if ($errores): ?>
      <ul>
        <?php foreach ($errores as $e): ?>
          <li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <form method="post" novalidate>
      <label>Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>" required></label>
      <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" required></label>
      <button type="submit">Enviar</button>
    </form>
  <?php endif; ?>
</body>

</html>