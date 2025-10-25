# Guía del proyecto – Dashboard de intranet

## Objetivo
Integrar login con sesiones, CRUD de usuarios y un panel con navegación.

## Estructura
- `index.php`: pantalla de login
- `dashboard.php`: panel principal (protegido)
- `usuarios/*.php`: CRUD conectado a MySQL (PDO)
- `includes/`: conexión y autenticación

## Acceso de prueba
- Email: `test@example.com`
- Contraseña: `123456` (se crea en `base-de-datos.sql`)

## Pasos
1. Importa `0-recursos/base-de-datos.sql` en phpMyAdmin.
2. Ajusta credenciales de BD en `includes/conexion.php`.
3. Abre `index.php`, inicia sesión y entra al dashboard.
