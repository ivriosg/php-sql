<?php require __DIR__ . '/02-conexion.php';

$errores = [];
$nombre = $email = $pass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = trim($_POST['nombre'] ?? '');
  $email  = trim($_POST['email'] ?? '');
  $pass   = $_POST['pass'] ?? '';

  if ($nombre === '') $errores[] = 'Nombre obligatorio';
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = 'Email inválido';
  if (strlen($pass) < 6) $errores[] = 'Contraseña mínima 6 caracteres';

  if (!$errores) {
    $stmt = $pdo->prepare("INSERT INTO usuarios(nombre,email,password_hash,rol) VALUES(?,?,SHA2(?,256),'usuario')");
    $stmt->execute([$nombre, $email, $pass]);
    header("Location: 03.1-listado.php");
    exit;
  }
}
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crear usuario</title>
</head>

<body>
  <h1>Crear usuario</h1>
  <?php if ($errores): ?><ul><?php foreach ($errores as $e): ?><li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></li><?php endforeach; ?></ul><?php endif; ?>
  <form method="post">
    <label>Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>" required></label>
    <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" required></label>
    <label>Contraseña: <input type="password" name="pass" required></label>
    <button type="submit">Guardar</button>
  </form>
  <p><a href="03.1-listado.php">Volver</a></p>
</body>

</html>