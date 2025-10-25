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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h1 class="h4 mb-3 text-center">Intranet – Acceso</h1>
          <?php if ($errores): ?>
            <div class="alert alert-danger"><ul class="mb-0"><?php foreach($errores as $e): ?><li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></li><?php endforeach; ?></ul></div>
          <?php endif; ?>
          <form method="post" novalidate>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input class="form-control" type="email" name="email" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Contraseña</label>
              <input class="form-control" type="password" name="pass" required>
            </div>
            <button class="btn btn-primary w-100" type="submit">Entrar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body></html>
