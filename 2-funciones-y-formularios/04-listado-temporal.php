<?php
// Simula una "BD" en memoria con un arreglo en la misma petición.
$usuarios = $_POST['usuarios'] ?? [];

if (isset($_POST['accion']) && $_POST['accion'] === 'agregar') {
  $usuarios[] = ['nombre' => $_POST['nombre'] ?? '', 'email' => $_POST['email'] ?? ''];
}
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Listado temporal</title>
</head>

<body>
  <h1>Listado temporal</h1>
  <form method="post">
    <input type="hidden" name="accion" value="agregar">
    <label>Nombre: <input type="text" name="nombre" required></label>
    <label>Email: <input type="email" name="email" required></label>
    <?php foreach ($usuarios as $i => $u): ?>
      <input type="hidden" name="usuarios[<?php echo $i; ?>][nombre]" value="<?php echo htmlspecialchars($u['nombre'], ENT_QUOTES, 'UTF-8'); ?>">
      <input type="hidden" name="usuarios[<?php echo $i; ?>][email]" value="<?php echo htmlspecialchars($u['email'], ENT_QUOTES, 'UTF-8'); ?>">
    <?php endforeach; ?>
    <button type="submit">Agregar</button>
  </form>

  <?php if ($usuarios): ?>
    <h2>Usuarios (en memoria)</h2>
    <table border="1" cellpadding="6">
      <thead>
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $i => $u): ?>
          <tr>
            <td><?php echo $i + 1; ?></td>
            <td><?php echo htmlspecialchars($u['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($u['email'], ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</body>

</html>