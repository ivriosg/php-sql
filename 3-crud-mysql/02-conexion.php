<?php
declare(strict_types=1);
$dsn = 'mysql:host=localhost;dbname=php_curso;charset=utf8mb4';
$user = 'root';
$pass = 'root';

try {
  $pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
  echo "Conexión exitosa";
} catch (PDOException $e) {
  http_response_code(500);
  echo "Error de conexión: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
  exit;
}
