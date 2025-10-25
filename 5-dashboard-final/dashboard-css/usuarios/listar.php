<?php
require __DIR__.'/includes/auth.php';
require __DIR__.'/includes/conexion.php';
login_required();
$usuarios = $pdo->query("SELECT id, nombre, email, rol, creado_en FROM usuarios ORDER BY id DESC")->fetchAll();
?>
<!doctype html>
<html lang="es"><head>
<link rel="stylesheet" href="../css/styles.css">
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Usuarios</title>
</head><body>
<h1>Usuarios</h1>
<p><a href="crear.php">Crear</a> | <a href="../dashboard.php">Dashboard</a></p>
<table class="table">
<thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Creado</th><th>Acciones</th></tr></thead>
<tbody>
<?php foreach($usuarios as $u): ?>
<tr>
  <td><?php echo $u['id']; ?></td>
  <td><?php echo htmlspecialchars($u['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
  <td><?php echo htmlspecialchars($u['email'], ENT_QUOTES, 'UTF-8'); ?></td>
  <td><?php echo $u['rol']; ?></td>
  <td><?php echo $u['creado_en']; ?></td>
  <td>
    <a href="editar.php?id=<?php echo $u['id']; ?>">Editar</a> |
    <a href="eliminar.php?id=<?php echo $u['id']; ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
  </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</body></html>
