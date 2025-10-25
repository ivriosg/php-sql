-- 02_console_queries.sql — Consultas frecuentes

USE qr_app;

-- 1) Ver links creados
SELECT * FROM create_link ORDER BY id DESC;

-- 2) Ver métricas con URL (INNER JOIN 2 tablas)
SELECT
  m.id_link, cl.link, m.campaign_source, m.campaign_medium, m.campaign_name, m.visitas
FROM metrics m
INNER JOIN create_link cl ON cl.id = m.id_link
ORDER BY m.visitas DESC;

-- 3) Total de visitas por link
SELECT cl.id, cl.link, SUM(m.visitas) AS total_visitas
FROM create_link cl
INNER JOIN metrics m ON m.id_link = cl.id
GROUP BY cl.id, cl.link
ORDER BY total_visitas DESC;

-- 4) JOIN de 3 tablas: comparar log vs métricas
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
ORDER BY d.dia DESC, cl.link;
