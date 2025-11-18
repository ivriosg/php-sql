<?php

declare(strict_types=1);

/* Utilidades */
function limpiar(string $v): string
{
  return htmlspecialchars(trim($v), ENT_QUOTES, 'UTF-8');
}

/* 1) Función: Normalizar nombre (Mayúscula Inicial) */
function normalizar_nombre(string $nombre): string
{
  $nombre = trim(mb_strtolower($nombre, 'UTF-8'));
  return mb_convert_case($nombre, MB_CASE_TITLE, 'UTF-8');
}

/* 2) Función: Calcular descuento
   Devuelve un arreglo con: subtotal, descuento, total */
function calcular_descuento(float $precio, float $porcentaje): array
{
  if ($precio < 0) {
    $precio = 0.0;
  }
  if ($porcentaje < 0) {
    $porcentaje = 0.0;
  }
  $descuento = $precio * ($porcentaje / 100);
  $total = $precio - $descuento;
  return [
    'subtotal'  => $precio,
    'porcentaje' => $porcentaje,
    'descuento' => $descuento,
    'total'     => $total
  ];
}

/* 3) Función: Analizar texto
   Regresa conteos y la palabra más larga */
function analizar_texto(string $texto): array
{
  $t = trim($texto);
  $palabras = preg_split('/\s+/', $t, -1, PREG_SPLIT_NO_EMPTY) ?: [];
  $caracteres = mb_strlen($t, 'UTF-8');
  $palabra_mas_larga = '';
  foreach ($palabras as $p) {
    if (mb_strlen($p, 'UTF-8') > mb_strlen($palabra_mas_larga, 'UTF-8')) {
      $palabra_mas_larga = $p;
    }
  }
  return [
    'caracteres' => $caracteres,
    'palabras'   => count($palabras),
    'mas_larga'  => $palabra_mas_larga,
    'lista'      => $palabras,
  ];
}

/* Control de UI */
$acciones = [
  'normalizar' => 'Mayúscula a cada palabra',
  'descuento'  => 'Calcular descuento (POST)',
  'analizar'   => 'Analizar texto (POST)'
];

$accion = $_GET['accion'] ?? 'normalizar';

/* Resultados por acción */
$resultado = null;
$errores = [];

/* --- Procesamiento GET (normalizar) --- */
if ($accion === 'normalizar' && $_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['nombre'])) {
  $nombre = $_GET['nombre'] ?? '';
  if ($nombre === '') {
    $errores[] = 'El nombre es obligatorio.';
  } else {
    $resultado = normalizar_nombre($nombre);
  }
}

/* --- Procesamiento POST (descuento) --- */
if ($accion === 'descuento' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $precio = (float)($_POST['precio'] ?? 0);
  $porcentaje = (float)($_POST['porcentaje'] ?? 0);
  if ($precio <= 0)    $errores[] = 'El precio debe ser mayor a 0.';
  if ($porcentaje < 0) $errores[] = 'El porcentaje no puede ser negativo.';
  if (!$errores) {
    $resultado = calcular_descuento($precio, $porcentaje);
  }
}

/* --- Procesamiento POST (analizar) --- */
if ($accion === 'analizar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $texto = $_POST['texto'] ?? '';
  if (trim($texto) === '') $errores[] = 'Escribe algún texto para analizar.';
  if (!$errores) {
    $resultado = analizar_texto($texto);
  }
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
  <h1>Funciones PHP + Dropdown + GET/POST</h1>

  <!-- Selector principal (GET) -->
  <form method="get" class="card" style="margin-bottom:1rem;">
    <div class="row">
      <label>
        Elige una acción:
        <select name="accion" onchange="this.form.submit()">
          <?php foreach ($acciones as $key => $label): ?>
            <option value="<?php echo $key; ?>" <?php echo $accion === $key ? 'selected' : ''; ?>>
              <?php echo $label; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>
      <noscript><button type="submit">Cambiar</button></noscript>
    </div>
  </form>

  <?php if ($errores): ?>
    <div class="card errores">
      <strong>Revisa:</strong>
      <ul>
        <?php foreach ($errores as $e): ?><li><?php echo limpiar($e); ?></li><?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <!-- Formularios por acción -->
  <?php if ($accion === 'normalizar'): ?>
    <!-- GET -->
    <form method="get" class="card">
      <input type="hidden" name="accion" value="normalizar">
      <label>Nombre:
        <input type="text" name="nombre" value="<?php echo limpiar($_GET['nombre'] ?? ''); ?>">
      </label>
      <button type="submit">Agregar mayúscula a cada palabra</button>
    </form>

    <?php if ($resultado !== null): ?>
      <div class="card">
        <h2>Resultado</h2>
        <p><strong>Nombre normalizado:</strong> <?php echo limpiar((string)$resultado); ?></p>
      </div>
    <?php endif; ?>

  <?php elseif ($accion === 'descuento'): ?>
    <!-- POST -->
    <form method="post" class="card">
      <input type="hidden" name="accion" value="descuento">
      <label>Precio:
        <input type="number" name="precio" step="0.01" min="0" placeholder="ej. 1000" value="<?php echo limpiar($_POST['precio'] ?? ''); ?>">
      </label>
      <label>Porcentaje de descuento:
        <input type="number" name="porcentaje" step="0.01" min="0" max="10" placeholder="ej. 15" value="<?php echo limpiar($_POST['porcentaje'] ?? ''); ?>">
      </label>
      <button type="submit">Calcular (POST)</button>
      <p><small class="code">Usa método POST para no exponer valores sensibles en la URL.</small></p>
    </form>

    <?php if (is_array($resultado)): ?>
      <div class="card">
        <h2>Resumen</h2>
        <table>
          <tbody>
            <tr>
              <th>Subtotal</th>
              <td>$<?php echo number_format($resultado['subtotal'], 2); ?></td>
            </tr>
            <tr>
              <th>Descuento (<?php echo $resultado['porcentaje']; ?>%)</th>
              <td>-$<?php echo number_format($resultado['descuento'], 2); ?></td>
            </tr>
            <tr>
              <th>Total</th>
              <td><strong>$<?php echo number_format($resultado['total'], 2); ?></strong></td>
            </tr>
          </tbody>
        </table>
      </div>
    <?php endif; ?>

  <?php elseif ($accion === 'analizar'): ?>
    <!-- POST -->
    <form method="post" class="card">
      <input type="hidden" name="accion" value="analizar">
      <label>Texto a analizar:
        <textarea name="texto" rows="5" placeholder="Escribe un párrafo para realizar un conteo."><?php echo limpiar($_POST['texto'] ?? ''); ?></textarea>
      </label>
      <button type="submit">Continuar</button>
    </form>

    <?php if (is_array($resultado)): ?>
      <div class="card">
        <h2>Resultados del análisis</h2>
        <table>
          <tbody>
            <tr>
              <th>Caracteres</th>
              <td><?php echo (int)$resultado['caracteres']; ?></td>
            </tr>
            <tr>
              <th>Palabras</th>
              <td><?php echo (int)$resultado['palabras']; ?></td>
            </tr>
            <tr>
              <th>Palabra más larga</th>
              <td><?php echo limpiar($resultado['mas_larga']); ?></td>
            </tr>
          </tbody>
        </table>
        <?php if (!empty($resultado['lista'])): ?>
          <p><strong>Lista de palabras:</strong></p>
          <ul>
            <?php foreach ($resultado['lista'] as $p): ?>
              <li><?php echo limpiar($p); ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    <?php endif; ?>

  <?php endif; ?>
</body>

</html>