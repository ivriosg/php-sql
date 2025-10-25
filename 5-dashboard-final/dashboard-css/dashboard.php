<?php
require __DIR__.'/includes/auth.php';
require __DIR__.'/includes/conexion.php';
login_required();
$nombre = $_SESSION['nombre'] ?? 'Usuario';
$total = (int)$pdo->query("SELECT COUNT(*) AS c FROM usuarios")->fetch()['c'];
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard</title>
<link rel="stylesheet" href="css/styles.css">
</head>
<body>
<nav class="navbar">
  <strong>Intranet</strong>
  <div>
    <span style="margin-right:.75rem;">Hola, <?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?></span>
    <a class="btn" href="logout.php">Salir</a>
  </div>
</nav>
<div class="container">
  <div class="card">
    <h2 style="margin-top:0;">Usuarios registrados</h2>
    <p style="font-size:2rem;margin:.25rem 0;"><?php echo $total; ?></p>
    <a class="btn" href="usuarios/listar.php">Administrar</a>
  </div>
</div>
</body></html>
