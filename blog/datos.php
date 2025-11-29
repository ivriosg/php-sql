<?php
require 'functions/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Verificando datos del formulario
  $email = trim($_POST['email']);
  $nombre = $_POST['nombre'];

  // Buscar en Base de Datos la información del usuario
  $buscarDB = $pdo->prepare("SELECT * FROM registros WHERE email = :email AND nombre = :nombre");
  $buscarDB->execute([':email' => $email, ':nombre' => $nombre]);
  /* Obtenemos la respuesta
    fetch() → Muestra solo 1 fila/resultado
	  fetchAll() → Muestra todas las filas
	  fetchColumn() → una columna específica
  */

    $resultado = $buscarDB->fetchAll(PDO::FETCH_ASSOC);

  
} else {
?>
  <!Doctype html>
  <html lang="es_MX">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buscar información</title>
  </head>

  <body>
    <h1>Iniciar sesión</h1>
    <form method="post">
      <label>Email:</label>
      <input type="email" name="email" value="" required>
      <label>Nombre:</label> <input type="text" name="nombre" required>
      <button type="submit">Buscar información</button>
    </form>
  </body>

  </html>
<?php
}
?>