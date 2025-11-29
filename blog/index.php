<?php
session_start();
require 'functions/index.php';
require 'functions/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Verificando datos del formulario
  $email = trim($_POST['email']);
  $pass = $_POST['pass'];

  // Buscar en Base de Datos la información del usuario
  $buscarDB = $pdo->prepare("SELECT id, email, passDB FROM registros WHERE email = :email");
  $buscarDB->execute([':email' => $email]);
  /* Obtenemos la respuesta
    fetch() → Muestra solo 1 fila/resultado
	  fetchAll() → Muestra todas las filas
	  fetchColumn() → una columna específica
  */
  $resultado = $buscarDB->fetch(PDO::FETCH_ASSOC);

  /* 
    Verificamos la contraseña del usuario en texto plano VS la encriptación que hizo el sistema en el archivo
    registro.php con la funcion $hashPass = password_hash($pass, PASSWORD_DEFAULT);
  */
  if (password_verify($pass, $resultado['passDB'])) {
    $_SESSION['vSESS'] = $resultado['id'];
    header('Location: crear.php');
    exit;
  } else {
    echo 'Error: No pudimos encontrar tu registro.';
    iniciar_sesion();
  }

} else {
?>
  <!Doctype html>
  <html lang="es_MX">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
  </head>

  <body>
    <?php iniciar_sesion(); ?>
  </body>

  </html>
<?php
}
?>