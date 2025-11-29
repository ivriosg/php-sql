<?php
require 'functions/index.php';
require 'functions/database.php';
?>
<!DOCTYPE html>
<html lang="es_MX">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de usuario</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = trim($_POST['nombre']);
  $telefono = trim($_POST['telefono']);
  $email = trim($_POST['email']);
  $pass = $_POST['password'];
  $hashPass = password_hash($pass, PASSWORD_DEFAULT);

  // Consultar si existe un registro previo
  $b_Usuario = $pdo->prepare("SELECT email FROM registros WHERE email = :email");
  $b_Usuario->execute([':email' => $email]);
  $resultado = $b_Usuario->fetch(PDO::FETCH_ASSOC);

  if ($resultado) {
    registro();
    echo '<script>toastr.error("Ya existe un registro con este correo electrónico", "Error")</script>';

    // TODO: Crear función para mostrar status en tiempo real
  } else {
    // Guardamos los datos del usuario en la BD
    $guardarDB = $pdo->prepare("INSERT INTO registros(nombre,telefono,email,passDB) VALUES(?,?,?,?)");
    $guardarDB->execute([$nombre, $telefono, $email, $hashPass]);

    header('Location: index.php');
  }

  /*
    Teléfono del usuario
    81-2936-6478
    +528129366478
    +52(1)8129366478
    regex()
    
    Formatear el contenido y guarlo de forma estandarizada
    Resultado final -> 8129366478
 */
} else {
?>

  <body>
    <style>
      form {
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        max-width: 50%;
        padding: 5rem 2rem;
        align-items: center;
      }

      input {
        width: 100%;
        margin-bottom: 0.5rem;
      }

      input[type="submit"] {
        margin-top: 1.5rem;
      }
    </style>
    <?php registro(); ?>
  </body>
  <script>
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": true,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
  </script>

</html>
<?php
}
?>