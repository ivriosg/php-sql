<?php

declare(strict_types=1);
session_start();
$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $pass  = $_POST['pass'] ?? '';
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = 'Email inválido';
  if ($pass === '') $errores[] = 'Contraseña requerida';

  if (!$errores) {
    // Demo sin BD: usuario/clave fijos
    if ($email === 'test@example.com' && $pass === '123456') {
      $_SESSION['usuario'] = ['email' => $email, 'nombre' => 'Admin Demo'];
      if (isset($_POST['recordar'])) {
        // Guardamos datos de sesión por 30 días
        setcookie('recordar_email', $email, time() + 60 * 60 * 24 * 30, '/');
      }
      header('Location: perfil.php');
      exit;
    } else {
      $errores[] = 'Credenciales no válidas';
    }
  }
}
?>
<!doctype html>
<html lang="es_MX">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
</head>

<body>
  <h1>Iniciar sesión</h1>
  <?php if ($errores): ?><ul><?php foreach ($errores as $e): ?><li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></li><?php endforeach; ?></ul><?php endif; ?>
  <form method="post">
    <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($_COOKIE['recordar_email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required></label>
    <label>Contraseña: <input type="password" name="pass" required></label>
    <label><input type="checkbox" name="recordar"> Recordarme</label>
    <button type="submit">Entrar</button>
  </form>
  <p><a href="registro.php">Crear cuenta</a></p>
</body>

</html>