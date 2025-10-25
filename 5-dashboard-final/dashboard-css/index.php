<?php
declare(strict_types=1);
session_start();
require __DIR__.'/includes/conexion.php';

$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $pass  = $_POST['pass'] ?? '';
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = 'Email inválido';
  if ($pass === '') $errores[] = 'Contraseña requerida';
  if (!$errores) {
    $stmt = $pdo->prepare("SELECT id, nombre, email FROM usuarios WHERE email=? AND password_hash=SHA2(?,256)");
    $stmt->execute([$email, $pass]);
    $u = $stmt->fetch();
    if ($u) {
      $_SESSION['uid'] = (int)$u['id'];
      $_SESSION['nombre'] = $u['nombre'];
      header('Location: dashboard.php');
      exit;
    } else {
      $errores[] = 'Credenciales incorrectas';
    }
  }
}
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>
<link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="container">
  <div class="card" style="max-width:420px;margin:3rem auto;">
    <h1 style="margin-top:0;">Intranet – Acceso</h1>
    <?php if ($errores): ?>
      <div class="card" style="background:#fee2e2;border-color:#fecaca;">
        <ul style="margin:0;"><?php foreach($errores as $e): ?><li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></li><?php endforeach; ?></ul>
      </div>
    <?php endif; ?>
    <form method="post" novalidate>
      <label>Email<br><input class="form-control" type="email" name="email" required></label><br>
      <label>Contraseña<br><input class="form-control" type="password" name="pass" required></label><br>
      <button class="btn" type="submit">Entrar</button>
    </form>
  </div>
</div>
</body></html>
