<?php

declare(strict_types=1);

// Función para escapar HTML
function esc(string $v): string
{
  return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}

$texto = '';
$salida = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $texto = $_POST['texto'] ?? '';
  $texto = trim($texto);

  if ($texto !== '') {
    $original = $texto;
    $sha256 = hash('sha256', $texto);
    $passwordHash = password_hash($texto, PASSWORD_DEFAULT);
    $demoKey = 'clave_demo_para_hmac_y_aes'; // cambiar en producción
    $hmac = hash_hmac('sha256', $texto, $demoKey);
    $claveBin = hash('sha256', $demoKey, true);
    $ivLen    = openssl_cipher_iv_length('aes-256-cbc');
    $iv       = random_bytes($ivLen);
    $cipherRaw = openssl_encrypt(
      $texto,
      'aes-256-cbc',
      $claveBin,
      OPENSSL_RAW_DATA,
      $iv
    );
    $cipherB64 = $cipherRaw !== false ? base64_encode($cipherRaw) : '(error al cifrar)';
    $ivB64     = base64_encode($iv);

    $salida = [
      ['Descripción' => 'String inicial (sin encriptar)', 'Resultado' => $original],
      ['Descripción' => 'SHA-256 (hex)',                   'Resultado' => $sha256],
      ['Descripción' => 'Hash de contraseña (password_hash)', 'Resultado' => $passwordHash],
      ['Descripción' => 'HMAC-SHA256 (clave demo)',        'Resultado' => $hmac],
      ['Descripción' => 'AES-256-CBC (ciphertext Base64)', 'Resultado' => $cipherB64],
      ['Descripción' => 'AES-256-CBC (IV Base64)',         'Resultado' => $ivB64],
    ];
  }
}
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Encriptación: tabla comparativa</title>
  <style>
    body {
      font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
      margin: 1.5rem;
    }

    .card {
      border: 1px solid #e5e7eb;
      border-radius: .5rem;
      padding: 1rem;
      max-width: 960px;
      background: #fff;
    }

    label {
      display: block;
      margin-bottom: .5rem;
    }

    input[type="text"] {
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
      cursor: pointer;
      margin-top: .5rem
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }

    th,
    td {
      border: 1px solid #e5e7eb;
      padding: .5rem;
      text-align: left;
      vertical-align: top
    }

    code,
    pre {
      font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
    }

    .muted {
      color: #6b7280;
      font-size: .9rem;
    }

    .note {
      margin-top: 1rem;
    }
  </style>
</head>

<body>
  <h1>Ejercicio: un input → múltiples técnicas de encriptación / hashing</h1>

  <form method="post" class="card" novalidate>
    <label>Texto a procesar:
      <input type="text" name="texto" value="<?php echo esc($texto); ?>" required placeholder="Escribe cualquier cadena...">
    </label>
    <button type="submit">Procesar</button>
    <p class="muted">Se mostrará el string original, SHA-256, hash de contraseña, HMAC y AES (cipher + IV).</p>
  </form>

  <?php if (is_array($salida)): ?>
    <div class="card">
      <h2>Resultados</h2>
      <table>
        <thead>
          <tr>
            <th>Descripción</th>
            <th>Resultado</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($salida as $fila): ?>
            <tr>
              <td><strong><?php echo esc($fila['Descripción']); ?></strong></td>
              <td>
                <pre><?php echo esc($fila['Resultado']); ?></pre>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="note">
        <h3>Notas rápidas</h3>
        <ul>
          <li><strong>String inicial:</strong> texto en claro (no seguro para guardar).</li>
          <li><strong>SHA-256:</strong> hash unidireccional general; útil para huellas, NO recomendado para contraseñas sin salt.</li>
          <li><strong>password_hash:</strong> estándar para contraseñas (usa salt y coste; se verifica con <code>password_verify</code>).</li>
          <li><strong>HMAC-SHA256:</strong> firma con clave compartida → garantiza integridad/autenticidad del mensaje (no cifra).</li>
          <li><strong>AES-256-CBC:</strong> cifrado simétrico (reversible) para confidencialidad; requiere **clave** y **IV**.</li>
        </ul>
        <p class="muted">En esta demo se usa una “clave demo” fija para HMAC/AES. En producción, usa claves seguras y manejo de secretos.</p>
      </div>
    </div>
  <?php endif; ?>
</body>

</html>