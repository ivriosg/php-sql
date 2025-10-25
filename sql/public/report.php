<?php
// public/report.php — Reportes con INNER JOIN (2 y 3 tablas)
declare(strict_types=1);
require __DIR__ . '/includes/db.php';

function esc(string $v): string { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

// Reporte 1: métricas + link
$q1 = pdo()->query("
  SELECT m.id_link, cl.link, m.campaign_source, m.campaign_medium, m.campaign_name, m.visitas
  FROM metrics m
  INNER JOIN create_link cl ON cl.id = m.id_link
  ORDER BY m.visitas DESC
");
$r1 = $q1->fetchAll();

// Reporte 2: totales por link
$q2 = pdo()->query("
  SELECT cl.id, cl.link, SUM(m.visitas) AS total_visitas
  FROM create_link cl
  INNER JOIN metrics m ON m.id_link = cl.id
  GROUP BY cl.id, cl.link
  ORDER BY total_visitas DESC
");
$r2 = $q2->fetchAll();

// Reporte 3: log vs métricas (3 tablas)
$q3 = pdo()->query("
WITH visitas_diarias AS (
  SELECT id_link, DATE(visited_at) AS dia, COUNT(*) AS visitas_log
  FROM visits_log
  GROUP BY id_link, DATE(visited_at)
)
SELECT
  d.dia,
  cl.link,
  COALESCE(d.visitas_log,0) AS visitas_en_log,
  COALESCE(mt.total_visitas,0) AS visitas_en_metricas
FROM visitas_diarias d
INNER JOIN create_link cl ON cl.id = d.id_link
LEFT JOIN (
  SELECT id_link, SUM(visitas) AS total_visitas
  FROM metrics
  GROUP BY id_link
) mt ON mt.id_link = cl.id
ORDER BY d.dia DESC, cl.link
");
$r3 = $q3->fetchAll();
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Reportes (INNER JOIN)</title>
<style>
body{font-family:system-ui,-apple-system,Segoe UI,Roboto,sans-serif;margin:1.5rem;}
h2{margin-top:1.25rem}
table{width:100%;border-collapse:collapse;margin-top:.75rem}
th,td{border:1px solid #e5e7eb;padding:.5rem;text-align:left}
.muted{color:#6b7280}
</style>
</head>
<body>
  <h1>Reportes (INNER JOIN)</h1>

  <h2>1) Métricas por UTM + Link (2 tablas)</h2>
  <table>
    <thead><tr><th>id_link</th><th>link</th><th>source</th><th>medium</th><th>campaign</th><th>visitas</th></tr></thead>
    <tbody>
      <?php foreach ($r1 as $row): ?>
      <tr>
        <td><?php echo esc((string)$row['id_link']); ?></td>
        <td><?php echo esc($row['link']); ?></td>
        <td><?php echo esc($row['campaign_source']); ?></td>
        <td><?php echo esc($row['campaign_medium']); ?></td>
        <td><?php echo esc($row['campaign_name']); ?></td>
        <td><?php echo esc((string)$row['visitas']); ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <h2>2) Totales por link</h2>
  <table>
    <thead><tr><th>id</th><th>link</th><th>total_visitas</th></tr></thead>
    <tbody>
      <?php foreach ($r2 as $row): ?>
      <tr>
        <td><?php echo esc((string)$row['id']); ?></td>
        <td><?php echo esc($row['link']); ?></td>
        <td><?php echo esc((string)$row['total_visitas']); ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <h2>3) Log vs Métricas por día (3 tablas)</h2>
  <table>
    <thead><tr><th>día</th><th>link</th><th>visitas_log</th><th>visitas_metricas</th></tr></thead>
    <tbody>
      <?php foreach ($r3 as $row): ?>
      <tr>
        <td><?php echo esc($row['dia']); ?></td>
        <td><?php echo esc($row['link']); ?></td>
        <td><?php echo esc((string)$row['visitas_en_log']); ?></td>
        <td><?php echo esc((string)$row['visitas_en_metricas']); ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <p class="muted">Tip: Genera tráfico abriendo <code>track.php?link=...</code> con UTM para poblar datos.</p>
</body>
</html>
