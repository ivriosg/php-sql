<?php
// public/insert.php — Insertar link base desde formulario (y mostrar SQL equivalente)
declare(strict_types=1);
require __DIR__ . '/includes/db.php';

function esc(string $v): string { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $link = trim($_POST['link'] ?? '');
  $src  = trim($_POST['campaign_source'] ?? '');
  $med  = trim($_POST['campaign_medium'] ?? '');
  $name = trim($_POST['campaign_name'] ?? '');

  if ($link && $src && $med && $name) {
    $id = ensure_link_id($link, $src, $med, $name);
    $msg = "Link registrado con id #{$id}";
  } else {
    $msg = "Todos los campos son obligatorios.";
  }
}

// SQL equivalente para consola (didáctico)
$consoleSQL = "USE qr_app;\n\n"
  . "INSERT INTO create_link (link, campaign_source, campaign_medium, campaign_name)\n"
  . "VALUES ('https://mi-sitio.com/landing', 'google', 'cpc', 'campana_primavera')\n"
  . "ON DUPLICATE KEY UPDATE id = LAST_INSERT_ID(id);\n\n"
  . "SET @id_link = LAST_INSERT_ID();\n\n"
  . "INSERT INTO metrics (id_link, campaign_source, campaign_medium, campaign_name, visitas)\n"
  . "VALUES (@id_link, 'google', 'cpc', 'campana_primavera', 1)\n"
  . "ON DUPLICATE KEY UPDATE visitas = visitas + 1, updated_at = CURRENT_TIMESTAMP;\n";
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Insertar link base (create_link)</title>
<style>
body{font-family:system-ui,-apple-system,Segoe UI,Roboto,sans-serif;margin:1.5rem;}
.card{border:1px solid #e5e7eb;border-radius:.5rem;padding:1rem;max-width:860px;background:#fff}
label{display:block;margin:.5rem 0}
input{width:100%;padding:.5rem;border:1px solid #d1d5db;border-radius:.375rem}
button{padding:.5rem .9rem;border:0;border-radius:.375rem;background:#2563eb;color:#fff;cursor:pointer}
pre{white-space:pre-wrap;word-break:break-word;background:#f8fafc;padding:.75rem;border-radius:.375rem}
</style>
</head>
<body>
  <h1>Insertar link base (tabla create_link)</h1>
  <p>Este formulario usa <strong>PDO</strong>. Abajo verás el <strong>SQL equivalente</strong> para ejecutarlo en consola y entender la sintaxis.</p>

  <form method="post" class="card">
    <label>Link
      <input type="text" name="link" placeholder="https://mi-sitio.com/landing" required>
    </label>
    <label>campaign_source
      <input type="text" name="campaign_source" placeholder="google" required>
    </label>
    <label>campaign_medium
      <input type="text" name="campaign_medium" placeholder="cpc" required>
    </label>
    <label>campaign_name
      <input type="text" name="campaign_name" placeholder="campana_primavera" required>
    </label>
    <button type="submit">Guardar</button>
  </form>

  <?php if (!empty($msg)): ?>
    <p><strong><?php echo esc($msg); ?></strong></p>
  <?php endif; ?>

  <h2>SQL equivalente para consola</h2>
  <pre><?php echo esc($consoleSQL); ?></pre>
</body>
</html>
