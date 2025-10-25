<?php

declare(strict_types=1);


const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = 'root';
const DB_NAME = 'php_curso';
const CHARSET = 'utf8mb4';
const COLLATION = 'utf8mb4_unicode_ci';

function out(string $msg): void
{
  echo '<p>' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</p>';
}

try {
  $pdoServer = new PDO(
    'mysql:host=' . DB_HOST . ';charset=' . CHARSET,
    DB_USER,
    DB_PASS,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
  );

  $sqlCreateDb = sprintf(
    'CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET %s COLLATE %s',
    DB_NAME,
    CHARSET,
    COLLATION
  );
  $pdoServer->exec($sqlCreateDb);
  out("Base de datos creada (o ya existía): " . DB_NAME);

  $pdo = new PDO(
    'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . CHARSET,
    DB_USER,
    DB_PASS,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
  );

  $pdo->exec("
    USE php_curso;
    DROP TABLE IF EXISTS usuarios;
    CREATE TABLE usuarios (
      id INT AUTO_INCREMENT PRIMARY KEY,
      nombre VARCHAR(100) NOT NULL,
      email VARCHAR(120) NOT NULL UNIQUE,
      password_hash VARCHAR(255) NOT NULL,
      rol ENUM('admin','usuario') DEFAULT 'usuario',
      creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;
  ");
  out("Tabla 'usuarios' creada.");

  $adminNombre = 'Administrador';
  $adminEmail  = 'admin@correo.com';
  $adminPass   = 'admin';

  $hash = password_hash(
    $adminPass,
    PASSWORD_ARGON2ID,
    ['memory_cost' => 1 << 17, 'time_cost' => 3, 'threads' => 2]
  );

  $stmt = $pdo->prepare("
    INSERT INTO usuarios (nombre, email, password_hash, rol)
    VALUES (?, ?, ?, 'admin')
    ON DUPLICATE KEY UPDATE nombre=VALUES(nombre), password_hash=VALUES(password_hash), rol='admin'
  ");
  $stmt->execute([$adminNombre, $adminEmail, $hash]);
  out("Usuario demo listo: {$adminEmail} / {$adminPass} (hash Argon2id almacenado)");

  $flag = __DIR__ . '/.installed';
  if (!file_exists($flag)) {
    file_put_contents($flag, 'OK ' . date('c'));
  }
  out("Instalación completa ✅ (se creó .installed). Elimina autoload.php por seguridad.");
} catch (Throwable $e) {
  http_response_code(500);
  echo '<h1>Error de instalación</h1>';
  out($e->getMessage());
  exit;
}
