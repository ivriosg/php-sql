<?php
require __DIR__ . '/includes/sesion.php';
require_login();
$u = $_SESSION['usuario'];
?>
<!doctype html>
<html lang="es_MX">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Perfil</title>
</head>

<body>
  <h1>Perfil</h1>
  <p>Bienvenido, <?php echo htmlspecialchars($u['nombre'] ?? 'Usuario', ENT_QUOTES, 'UTF-8'); ?> (<?php echo htmlspecialchars($u['email'], ENT_QUOTES, 'UTF-8'); ?>)</p>
  <p><a href="logout.php">Cerrar sesión</a></p>
</body>

</html>