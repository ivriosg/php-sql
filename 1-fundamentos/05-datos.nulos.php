<?php
function limpiar(string $v): string
{
  return htmlspecialchars(trim($v), ENT_QUOTES, 'UTF-8');
}
// Declaramos las variables que procesa el formulario
$datos = ['nombre' => '', 'email' => '', 'telefono' => ''];
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $datos['nombre'] = $_POST['nombre'] ?? '';
  $datos['email'] = $_POST['email'] ?? '';
  $datos['telefono'] = $_POST['telefono'] ?? '';

  if ($datos['nombre'] === '') $errores[] = 'El nombre es obligatorio.';
  if (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) $errores[] = 'El email es inválido.';
  if ($datos['telefono'] !== '' && !preg_match('/^[0-9\-\s]{7,15}$/', $datos['telefono'])) $errores[] = 'El teléfono inválido.';

  if (isset($datos)) {
    foreach ($datos as $dato => $single) {
      if (trim($single) === '') {
        echo ucfirst($dato) . " está vacío o nulo.<br>";
      }
    }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Validaciones</title>
</head>

<body>
  <h1>Revisar datos nulos</h1>

  <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$errores): ?>
    <table>
      <thead>
        <tr>
          <th>Campo del formulario</th>
          <th>Usuario</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($datos as $k => $v): ?>
          <tr>
            <td><?php echo $k; ?></td>
            <td><?php echo limpiar($v); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <?php if ($errores): ?>
      <ul>
        <?php foreach ($errores as $e): ?><li><?php echo limpiar($e); ?></li><?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <form method="post">
      <label>Nombre: <input type="text" name="nombre" value="<?php echo limpiar($datos['nombre']); ?>" required></label>
      <label>Email: <input type="email" name="email" value="<?php echo limpiar($datos['email']); ?>" required></label>
      <label>Teléfono: <input type="text" name="telefono" value="<?php echo limpiar($datos['telefono']); ?>"></label>
      <button type="submit">Validar</button>
    </form>
  <?php endif; ?>
</body>

</html>