# QR App Kit — PHP + MySQL (Consola y PHP)

- **SQL** para crear BD/tablas y practicar desde consola.
- **PHP** con `PDO` (insertar, upsert(actualización/inserción) de métricas, log de visitas, reportes con INNER JOIN).

## Estructura

```
qr_app_kit/
├─ sql/
│  ├─ 00_create_db.sql
│  ├─ 01_console_insert.md
│  ├─ 02_console_queries.sql
├─ public/
│  ├─ includes/
│  │  ├─ config.php
│  │  └─ db.php
│  ├─ insert.php
│  ├─ track.php
│  ├─ report.php
├─ docs/
│  └─ HOWTO.md
```

## Paso rápido

1. Importa `sql/00_create_db.sql` (phpMyAdmin o CLI).
2. Copia `public/` a tu `htdocs` como `qr_app/`.
3. Ajusta credenciales en `public/includes/config.php`.
4. Prueba `http://localhost/qr_app/insert.php`, `track.php` y `report.php`.
