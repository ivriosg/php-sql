<?php
// public/track.php — Endpoint de tracking: asegura link, upserta métrica, registra log y redirige.
declare(strict_types=1);
require __DIR__ . '/includes/db.php';

function param(string $k, string $def=''): string {
  return isset($_GET[$k]) ? trim((string)$_GET[$k]) : $def;
}

$link = param('link');
$src  = param('utm_source');
$med  = param('utm_medium');
$name = param('utm_campaign');

if (!$link || !$src || !$med || !$name) {
  http_response_code(400);
  header('Content-Type: text/plain; charset=utf-8');
  echo "Faltan parámetros: link, utm_source, utm_medium, utm_campaign";
  exit;
}

$id = ensure_link_id($link, $src, $med, $name);
upsert_metric($id, $src, $med, $name);
log_visit($id, $src, $med, $name);

// Redirigir al link real (puedes añadir aquí tus propios parámetros)
header("Location: " . $link, true, 302);
exit;
