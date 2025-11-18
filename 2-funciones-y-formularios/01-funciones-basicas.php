<?php

declare(strict_types=1);

// 🧩 Función 1: Suma tres números
function sumar(int $a, int $b, int $c): int
{
  return $a + $b + $c;
}

// 🧩 Función 2: Convierte texto a mayúsculas
function convertir_mayusculas(string $texto): string
{

  $utf8 = mb_strtoupper($texto, 'utf-8');
  $noutf8 = strtoupper($texto);
  // mb_strtoupper permite acentos
  // strtoupper no permite el utf-8 y marca error
  return $utf8 . " <br><h2>Este es la función sin UTF-8</h2><br> " . $noutf8;
}

// 🧩 Función 3: Verifica si una persona es mayor de edad
function es_mayor_de_edad(int $edad): string
{
  return ($edad >= 18) ? '<p class="pass">Sí, es mayor de edad ✅</p>' : '<p class="alert">No, es menor de edad ❌</p>';
}

// Valor por defecto
$accion = $_GET['accion'] ?? 'suma';
$resultado = null;
$errores = [];

// Procesamiento general
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($accion === 'suma') {
    $a = (int)($_POST['a'] ?? 0);
    $b = (int)($_POST['b'] ?? 0);
    $c = (int)($_POST['c'] ?? 0);
    $resultado = sumar($a, $b, $c);
  }

  if ($accion === 'mayusculas') {
    $texto = trim($_POST['texto'] ?? '');
    $resultado = convertir_mayusculas($texto);
  }

  if ($accion === 'edad') {
    $edad = (int)($_POST['edad'] ?? 0);
    $resultado = es_mayor_de_edad($edad);
  }
}
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ejemplo simple de funciones</title>
  <style>
    body {
      font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
      margin: 2rem;
    }

    .card {
      border: 1px solid #ddd;
      padding: 1rem;
      border-radius: .5rem;
      max-width: 400px;
    }

    label {
      display: block;
      margin-top: .5rem;
    }

    input,
    select {
      width: 100%;
      padding: .5rem;
      margin-top: .25rem;
    }

    button {
      margin-top: 1rem;
      padding: .5rem 1rem;
      background: #2563eb;
      color: #fff;
      border: 0;
      border-radius: .25rem;
    }
    .alert {
      background: red;
      color: #fff;
      padding: 1rem 2rem;
    }
    .pass {
      background: greenyellow;
      color: #000;
      padding: 1rem 2rem;
    }
  </style>
</head>

<body>
  <h1>Funciones simples en PHP</h1>

  <!-- Menú para elegir la función -->
  <form method="get">
    <label>Elige la función:
      <select name="accion" onchange="this.form.submit()">
        <option value="suma" <?php echo $accion === 'suma' ? 'selected' : ''; ?>>Sumar dos números</option>
        <option value="mayusculas" <?php echo $accion === 'mayusculas' ? 'selected' : ''; ?>>Convertir a mayúsculas</option>
        <option value="edad" <?php echo $accion === 'edad' ? 'selected' : ''; ?>>Verificar mayoría de edad</option>
      </select>
    </label>
  </form>

  <hr>

  <!-- Formulario dinámico -->
  <form method="post" class="card">
    <?php if ($accion === 'suma'): ?>
      <label>Primer número:
        <input type="number" name="a" required>
      </label>
      <label>Segundo número:
        <input type="number" name="b" required>
      </label>
      <label>Tercer número:
        <input type="number" name="c" required>
      </label>

    <?php elseif ($accion === 'mayusculas'): ?>
      <label>Texto:
        <input type="text" name="texto" required placeholder="Escribe algo aquí">
      </label>

    <?php elseif ($accion === 'edad'): ?>
      <label>Edad:
        <input type="number" name="edad" required min="0" placeholder="Ej. 20">
      </label>
    <?php endif; ?>

    <button type="submit">Procesar</button>
  </form>

  <?php if ($resultado !== null): ?>
    <h2>Resultado:</h2>
    <p><strong><?php echo $resultado; ?></strong></p>
  <?php endif; ?>
</body>

</html>