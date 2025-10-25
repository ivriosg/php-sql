# Hoja de repaso rápido de PHP 8

- **Etiquetas estándar:** `<?php ... ?>`
- **Salida:** `echo`, `print`
- **Tipos escalares:** `int`, `float`, `string`, `bool`
- **Estructuras:** `if/else`, `switch`, `for`, `while`, `foreach`
- **Funciones:** `function nombre(tipo $arg): tipo { ... }`
- **Arrays:** indexados y asociativos (`$a = ['k' => 'v'];`)
- **Incluir archivos:** `require`, `include`, `require_once`, `include_once`
- **Superglobales:** `$_GET`, `$_POST`, `$_SERVER`, `$_SESSION`, `$_COOKIE`, `$_FILES`
- **PDO básico:**
```php
$pdo = new PDO('mysql:host=localhost;dbname=php_curso;charset=utf8mb4','root','', [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
```
- **Sesiones:** 
```php
session_start();
$_SESSION['usuario_id'] = 1;
session_destroy();
```
- **Buenas prácticas:**
  - Separar capa de vista (HTML) y lógica (PHP) con `includes/`
  - Validar entradas (filtros/regex) y usar sentencias preparadas
  - Escapar salida: `htmlspecialchars($str, ENT_QUOTES, 'UTF-8')`
