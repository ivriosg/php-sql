<?php
// public/includes/db.php
declare(strict_types=1);
require __DIR__ . '/config.php';

/**
 * Asegura la existencia de un link base y devuelve su id.
 * Implementa el truco LAST_INSERT_ID(id) para obtener el id aunque ya exista.
 */
function ensure_link_id(string $link, string $src, string $med, string $name): int {
  $sql = "INSERT INTO create_link (link, campaign_source, campaign_medium, campaign_name)
          VALUES (:link, :src, :med, :name)
          ON DUPLICATE KEY UPDATE id = LAST_INSERT_ID(id)";
  $st = pdo()->prepare($sql);
  $st->execute([':link'=>$link, ':src'=>$src, ':med'=>$med, ':name'=>$name]);
  return (int) pdo()->lastInsertId();
}

/** Upsert de métrica (acumula +1 visita) */
function upsert_metric(int $id_link, string $src, string $med, string $name): void {
  $sql = "INSERT INTO metrics (id_link, campaign_source, campaign_medium, campaign_name, visitas)
          VALUES (:id_link, :src, :med, :name, 1)
          ON DUPLICATE KEY UPDATE visitas = visitas + 1, updated_at = CURRENT_TIMESTAMP";
  $st = pdo()->prepare($sql);
  $st->execute([':id_link'=>$id_link, ':src'=>$src, ':med'=>$med, ':name'=>$name]);
}

/** Registrar visita en log (detallado) */
function log_visit(int $id_link, string $src, string $med, string $name): void {
  $ip = $_SERVER['REMOTE_ADDR'] ?? null;
  $ua = $_SERVER['HTTP_USER_AGENT'] ?? null;
  $sql = "INSERT INTO visits_log (id_link, campaign_source, campaign_medium, campaign_name, ip, user_agent)
          VALUES (:id_link, :src, :med, :name, INET6_ATON(:ip), :ua)";
  $st = pdo()->prepare($sql);
  $st->execute([':id_link'=>$id_link, ':src'=>$src, ':med'=>$med, ':name'=>$name, ':ip'=>$ip, ':ua'=>$ua]);
}
