<?php
require __DIR__.'/includes/auth.php';
require __DIR__.'/includes/conexion.php';
login_required();
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("DELETE FROM usuarios WHERE id=?");
$stmt->execute([$id]);
header("Location: listar.php");
exit;
