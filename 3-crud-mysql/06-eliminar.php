<?php require __DIR__ . '/02-conexion.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("DELETE FROM usuarios WHERE id=?");
$stmt->execute([$id]);
header("Location: 03.1-listado.php");
exit;
