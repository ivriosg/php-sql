<?php
session_start();
if (!isset($_SESSION['vSESS'])) {
  header('Location: index.php');
  exit();
}
include_once 'functions/database.php';
$id_articulo = intval($_GET["id_articulo"]);


// Actualizar la información en la BD
$borrarART = $pdo->prepare("DELETE FROM articulos WHERE id = :id_articulo");
$borrarART->execute([':id_articulo' => $id_articulo]);

if ($borrarART->rowCount() > 0) {
  header('Location: listado.php');
  exit();
} else {
  echo "Error";
}
