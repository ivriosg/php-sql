<?php require __DIR__ . '/02-conexion.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id=?");
$stmt->execute([$id]);
$usuario = $stmt->fetch();

if (!$usuario) {
  http_response_code(404);
  echo "No encontrado";
  exit;
}

$errores = [];
$nombre = $usuario['nombre'];
$email = $usuario['email'];
$rol = $usuario['rol'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = trim($_POST['nombre'] ?? '');
  $email  = trim($_POST['email'] ?? '');
  $rol    = $_POST['rol'] ?? 'usuario';

  if ($nombre === '') $errores[] = 'Nombre obligatorio';
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = 'Email inválido';

  if (!$errores) {
    $stmt = $pdo->prepare("UPDATE usuarios SET nombre=?, email=?, rol=? WHERE id=?");
    $stmt->execute([$nombre, $email, $rol, $id]);
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
  <title>Editar usuario</title>
</head>

<body>
  <h1>Editar usuario</h1>
  <?php if ($errores): ?><ul><?php foreach ($errores as $e): ?><li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></li><?php endforeach; ?></ul><?php endif; ?>
  <form method="post">
    <label>Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>" required></label>
    <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" required></label>
    <label>Rol:
      <select name="rol">
        <option value="usuario" <?php echo $rol === 'usuario' ? 'selected' : ''; ?>>Usuario</option>
        <option value="admin" <?php echo $rol === 'admin' ? 'selected' : ''; ?>>Admin</option>
      </select>
    </label>
    <button type="submit">Actualizar</button>
  </form>
  <p><a href="03.1-listado.php">Volver</a></p>
</body>

</html>