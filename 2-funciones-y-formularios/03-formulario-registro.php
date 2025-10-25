<?php
$usuarios = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usuarios[] = [
    'nombre' => trim($_POST['nombre'] ?? ''),
    'email'  => trim($_POST['email'] ?? '')
  ];
}
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro temporal</title>
</head>

<body>
  <h1>Registro temporal (Array)</h1>
  <form method="post">
    <label>Nombre: <input type="text" name="nombre" required></label>
    <label>Email: <input type="email" name="email" required></label>
    <button type="submit">Agregar</button>
  </form>
  <?php if ($usuarios): ?>
    <h2>Usuarios capturados</h2>
    <ul>
      <?php foreach ($usuarios as $u): ?>
        <li><?php echo htmlspecialchars($u['nombre'], ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars($u['email'], ENT_QUOTES, 'UTF-8'); ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</body>

</html>