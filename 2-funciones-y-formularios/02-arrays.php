<?php
$usuarios = [
  ['id' => 1, 'nombre' => 'Ana', 'email' => 'ana@example.com'],
  ['id' => 2, 'nombre' => 'Luis', 'email' => 'luis@example.com'],
  ['id' => 3, 'nombre' => 'María', 'email' => 'maria@example.com'],
  ['id' => 4, 'nombre' => 'Ivan<script>console.log("Hola desde la consola")</script>', 'email' => 'ivan@example.com'],
];

$buscar = trim($_GET['buscarDatos'] ?? '');
if ($buscar !== '') {
  $usuarios = array_values(array_filter($usuarios, fn($u) => stripos($u['nombre'], $buscar) !== false));
}
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Arrays</title>
</head>

<body>
  <h1>Listado temporal</h1>
  <form method="get">
    <label>Buscar: <input type="text" name="buscarDatos" value="<?php echo htmlspecialchars($buscar, ENT_QUOTES, 'UTF-8'); ?>"></label>
    <!-- <button type="submit">Filtrar</button> -->
    <input type="submit" value="Buscar datos">
  </form>
  <table border="1" cellpadding="6">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre protegido</th>
        <th>Nombre sin proteger</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($usuarios as $u): ?>
        <tr>
          <td><?php echo $u['id']; ?></td>
          <td><?php echo htmlspecialchars($u['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?php echo $u['nombre']; ?></td>
          <td><?php echo htmlspecialchars($u['email'], ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>

</html>