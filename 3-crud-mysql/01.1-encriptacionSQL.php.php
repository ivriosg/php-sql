<?php

declare(strict_types=1);

function esc(string $v): string
{
  return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}

// Detectar si Argon2id está disponible
$algDisponible = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_DEFAULT;

// Parámetros por defecto razonables (puedes ajustarlos)
$opts = [];
if ($algDisponible === PASSWORD_ARGON2ID) {
  // Ajusta estos valores según el entorno (ver recomendaciones abajo)
  $opts = [
    'memory_cost' => 1 << 17, // 128 MB
    'time_cost'   => 3,       // iteraciones
    'threads'     => 2
  ];
} else {
  // Fallback (bcrypt vía PASSWORD_DEFAULT)
  $opts = [
    'cost' => 12              // coste de bcrypt
  ];
}

$hash = null;
$algUsado = ($algDisponible === PASSWORD_ARGON2ID) ? 'Argon2id' : 'PASSWORD_DEFAULT (normalmente bcrypt)';
$params   = $opts;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // No muestres la contraseña en claro.
  $pwd = $_POST['password'] ?? '';
  // Límite de longitud defensivo para evitar abusos/DoS:
  if (mb_strlen($pwd, 'UTF-8') > 4096) {
    $error = 'La contraseña es demasiado larga.';
  } elseif ($pwd === '') {
    $error = 'La contraseña es obligatoria.';
  } else {
    $hash = password_hash($pwd, $algDisponible, $opts);
  }
}
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Hash de contraseñas: Argon2id / bcrypt</title>
  <style>
    body {
      font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
      margin: 1.5rem;
    }

    .card {
      border: 1px solid #e5e7eb;
      border-radius: .5rem;
      padding: 1rem;
      max-width: 900px;
      background: #fff
    }

    label {
      display: block;
      margin: .5rem 0
    }

    input[type=password] {
      width: 100%;
      padding: .5rem;
      border: 1px solid #d1d5db;
      border-radius: .375rem
    }

    button {
      padding: .5rem .9rem;
      border: 0;
      border-radius: .375rem;
      background: #2563eb;
      color: #fff;
      cursor: pointer
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem
    }

    th,
    td {
      border: 1px solid #e5e7eb;
      padding: .5rem;
      text-align: left;
      vertical-align: top
    }

    pre {
      white-space: pre-wrap;
      word-break: break-all
    }

    .muted {
      color: #6b7280;
      font-size: .9rem
    }

    .err {
      color: #b91c1c
    }
  </style>
</head>

<body>
  <h1>Ejercicio: Hash de contraseña con <?php echo esc($algUsado); ?></h1>

  <form method="post" class="card" novalidate>
    <label>Contraseña:
      <input type="password" name="password" required>
    </label>
    <button type="submit">Generar hash</button>
    <p class="muted">
      Algoritmo actual: <strong><?php echo esc($algUsado); ?></strong>.
      Parámetros: <code><?php echo esc(json_encode($params)); ?></code>
    </p>
    <?php if (!empty($error)): ?>
      <p class="err"><?php echo esc($error); ?></p>
    <?php endif; ?>
  </form>

  <?php if ($hash): ?>

    <div class="card">
      <h2>Resultado</h2>
      <table>
        <thead>
          <tr>
            <th>Campo</th>
            <th>Valor</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Hash para guardar en BD</td>
            <td>
              <pre><?php echo esc($hash); ?></pre>
            </td>
          </tr>
          <tr>
            <td>Cómo verificar (ejemplo)</td>
            <td>
              <pre><?php echo esc("\$ok = password_verify(\$input, \$hashGuardado);\nif (\$ok) { /* acceso concedido */ }"); ?></pre>
            </td>
          </tr>
        </tbody>
      </table>
      <p class="muted">
        Nota: Nunca guardes la contraseña en texto plano; guarda solo el hash. No vuelvas a imprimir la contraseña del usuario en la interfaz.
      </p>
    </div>

  <?php endif; ?>
</body>

</html>