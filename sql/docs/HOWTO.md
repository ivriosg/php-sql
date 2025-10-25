# HOWTO — Pasos para usar el kit

1. Importa `sql/00_create_db.sql` en MySQL.
2. Copia `public/` a `htdocs/qr_app/` (o configura tu virtual host).
3. Ajusta credenciales en `public/includes/config.php`.
4. Inserta un link base desde `insert.php` o por consola.
5. Simula visitas abriendo:

```
http://localhost/qr_app/track.php?link=https%3A%2F%2Fmi-sitio.com%2Flanding&utm_source=google&utm_medium=cpc&utm_campaign=campana_primavera
```

6. Revisa reportes en `report.php`.
