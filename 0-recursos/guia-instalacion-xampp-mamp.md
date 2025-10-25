# Guía de instalación (XAMPP en Windows / MAMP en macOS)

## Windows (XAMPP)
1. Descarga XAMPP desde https://www.apachefriends.org/es/
2. Instala seleccionando Apache, MySQL y phpMyAdmin.
3. Inicia el panel de control y enciende **Apache** y **MySQL**.
4. Copia la carpeta `php-curso` dentro de `C:\xampp\htdocs\`.
5. Abre `http://localhost/php-curso/` en tu navegador.

## macOS (MAMP)
1. Descarga MAMP desde https://www.mamp.info/en/downloads/
2. Instala y abre MAMP, enciende **Apache** y **MySQL**.
3. Copia la carpeta `php-curso` dentro de `~/Applications/MAMP/htdocs/` o la ruta de htdocs configurada.
4. Abre `http://localhost:8888/php-curso/` (o el puerto que tengas).

## Ajustes recomendados
- PHP **8.0+**
- Zone time y charset en HTML: `<meta charset="utf-8">` y `<meta name="viewport" content="width=device-width, initial-scale=1">`
- En php.ini: activar `extension=pdo_mysql` si no viene habilitado.
