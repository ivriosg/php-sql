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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">Intranet</span>
    <div class="d-flex align-items-center text-white">
      <span class="me-3">Hola, <?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?></span>
      <a class="btn btn-outline-light btn-sm" href="logout.php">Salir</a>
    </div>
  </div>
</nav>
<div class="container my-4">
  <div class="row g-3">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Usuarios registrados</h5>
          <p class="display-6"><?php echo $total; ?></p>
          <a class="btn btn-primary" href="usuarios/listar.php">Administrar</a>
        </div>
      </div>
    </div>
  </div>
</div>
</body></html>
