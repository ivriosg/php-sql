<?php
$conexion = 'mysql:host=localhost;dbname=php_clasePHPcurso;charset=utf8mb4';
$userDB = 'clasePHP';
$passDB = 'OGH-14YgQ!lTMCM5';

try {
  $pdo = new PDO($conexion, $userDB, $passDB, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
  echo "Conexión exitosa";
} catch (PDOException $e) {
  http_response_code(500);
  echo "Error de conexión: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
  exit;
}
