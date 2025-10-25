# 01_console_insert.md — Insertar desde consola (y por qué la sintaxis)

La siguiente línea es cuando no tenemos PHPMyAdmin, como cultura general sirve, realmente se utiliza poco
salvo que trabajen con servidores mas robustos, casi todos los sistemas tienen una interfaz gráfica.

> Entra a MySQL:

```
mysql -u root -p
```

## Insertar LINKS base

Creamos un registro en la tabla `create_link` para identificar el **link** y su **UTM base** (source/medium/name).
Esto es el estándar para medir las campañas de publicidad en marketing digital, se hace de forma automática pero
aprender como funciona nos ayuda a ofrecer auditorias y vender servicios.

```sql
USE qr_app;

INSERT INTO create_link (link, campaign_source, campaign_medium, campaign_name)
VALUES ('https://mi-sitio.com/landing', 'google', 'cpc', 'campana_primavera');
```

### ¿Por qué así?

- Especificamos columnas para que el `INSERT` sea **explícito** y no dependa del orden.
- Los valores UTM nos permiten **juntar** métricas y logs de visitas.

## UPSERT de métricas (acumular visitas)

Utilizamos UPSERT para evitar código adicional, normalemente teníamos que buscar si el registro existía y despues lo actualizamos,
con la instrucción UPSERT, el sistema valida si existe y actualiza o crea un registro desde cero, esto ayuda a que el sistema
funcione de forma más eficiente.

`metrics` tiene un índice único `uk_metric (id_link, source, medium, name)`.
Eso permite usar **`ON DUPLICATE KEY UPDATE`**:

```sql
-- 1) Asegurar que exista el link y capturar su id con LAST_INSERT_ID
INSERT INTO create_link (link, campaign_source, campaign_medium, campaign_name)
VALUES ('https://mi-sitio.com/landing', 'google', 'cpc', 'campana_primavera')
ON DUPLICATE KEY UPDATE id = LAST_INSERT_ID(id);

-- El @ es una variable que utilizamos para no realizar consultas adicionale, de esta forma optimizamos el gasto de memoria
SET @id_link = LAST_INSERT_ID();

-- 2) Sumar visitas para tener métricas
INSERT INTO metrics (id_link, campaign_source, campaign_medium, campaign_name, visitas)
VALUES (@id_link, 'google', 'cpc', 'campana_primavera', 1)
ON DUPLICATE KEY UPDATE visitas = visitas + 1, updated_at = CURRENT_TIMESTAMP;
```

**¿Por qué `LAST_INSERT_ID(id)`?**  
Truco para recuperar el `id` aunque la fila **ya existiera**, sin otra consulta.

## Registrar detalle en log

```sql
INSERT INTO visits_log (id_link, campaign_source, campaign_medium, campaign_name, ip, user_agent)
VALUES (@id_link, 'google', 'cpc', 'campana_primavera', INET6_ATON('2001:db8::1'), 'Mozilla/5.0');
```
