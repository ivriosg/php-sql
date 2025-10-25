<?php

declare(strict_types=1);

/* Utilidades */
function limpiar(string $v): string
{
  return htmlspecialchars(trim($v), ENT_QUOTES, 'UTF-8');
}


?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Demo – Funciones con dropdown (GET/POST)</title>
  <style>
    body {
      font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
      margin: 1.5rem;
    }

    .row {
      display: grid;
      gap: .75rem;
      max-width: 680px;
    }

    label {
      display: block;
      margin-top: .5rem;
    }

    input[type="text"],
    input[type="number"],
    textarea,
    select {
      width: 100%;
      padding: .5rem;
      border: 1px solid #d1d5db;
      border-radius: .375rem;
    }

    button {
      padding: .5rem .9rem;
      border: 0;
      border-radius: .375rem;
      background: #2563eb;
      color: #fff;
    }

    .card {
      border: 1px solid #e5e7eb;
      border-radius: .5rem;
      padding: 1rem;
      background: #fff;
    }

    .errores {
      color: #b91c1c;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    th,
    td {
      border: 1px solid #e5e7eb;
      padding: .5rem;
      text-align: left;
    }

    small.code {
      font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
      color: #374151;
    }
  </style>
</head>

<body>
  <!-- 🧪 Ejercicio guiado de manipulación de datos -->
  <div class="card" style="margin-top:1rem;">
    <h2>Ejercicio: manipular una lista (explode → trim → unique → sort)</h2>
    <p>1) Recibe una cadena separada por comas, 2) conviértela a arreglo, 3) elimina duplicados,
      4) ordena alfabéticamente y 5) muéstrala en una tabla.</p>

    <?php
    // Solución de ejemplo (puedes pedir a tus alumnos que la escriban):
    $lista_bruta = $_POST['lista'] ?? '';
    $resultado_lista = null;

    if (isset($_POST['accion_ejercicio']) && $_POST['accion_ejercicio'] === 'limpiar_lista') {
      $items = array_map(fn($x) => trim($x), explode(',', $lista_bruta));
      $items = array_filter($items, fn($x) => $x !== '');
      $items = array_values(array_unique($items));
      sort($items, SORT_NATURAL | SORT_FLAG_CASE);
      $resultado_lista = $items;
    }
    ?>

    <form method="post">
      <input type="hidden" name="accion_ejercicio" value="limpiar_lista">
      <label>Ingresa elementos separados por coma:
        <input type="text" name="lista" placeholder="ej. Ana, luis, ana, Pedro, pedro" value="<?php echo limpiar($lista_bruta); ?>">
      </label>
      <button type="submit">Procesar lista</button>
    </form>

    <?php if (is_array($resultado_lista)): ?>
      <h3>Lista normalizada</h3>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Elemento</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($resultado_lista as $i => $item): ?>
            <tr>
              <td><?php echo $i + 1; ?></td>
              <td><?php echo limpiar($item); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <p><small class="code">Pista didáctica: juega con <code>explode</code>, <code>array_map</code>,
          <code>array_unique</code>, <code>sort</code> y <code>array_values</code>.</small></p>
    <?php endif; ?>
  </div>
</body>

</html>