<?php
session_start();
require 'functions/index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $checkEmail = 'admin@localhost.com';
  $checkPass = 'admin';
  
  $email = trim($_POST['email']);
  $pass = $_POST['pass'];

  $hashPass = password_hash($pass, PASSWORD_DEFAULT);

  if ($email === $checkEmail && $hashPass === $checkPass) {
    $_SESSION['vSESS'] = $email;
    header('Location: crear.php');
    exit;
  } else {
    formulario();
  }
  setcookie('mail', $email, time() + 3600);
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
    <?php formulario(); ?>
  </body>

  </html>
<?php
}
?>