<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Datos por default para iniciar sesión, no utilizar en producción
  $checkEmail = 'admin@localhost.com';
  $checkPass = 'admin';

  // Obtenemos los valores del formulario
  $email = trim($_POST['email']);
  $pass = $_POST['pass'];

  // Verificamos si los valores del usuario son identicos a los del sistema.
  if ($email === $checkEmail && $pass === $checkPass) {
    header('Location: crear.php');
    exit;
  } else {
    echo 'Los datos que ingresaste no coinciden.';
  }

  // Crear cookie con la información del campo mail que viene del formulario
  setcookie('mail', $email, time() + 3600);

  /* 
    Crear variable de sesión con la información del campo mail que viene del formulario
    Verifica si existe una sesión iniciada antes de que muestre la información.

    Si el usuario tiene una sesión activa -> Mostrara página privada con información segura
    Si el usuario NO tiene una sesión activa -> Mostrara página de login 
  */

  // $_SESSION['pass'] = $_POST['pass'];

  /*
  Cookie -> Voy a guardar información básica (NO SENSIBLE) en tu navegador para identificarte y medir las 
  acciones que realizas en mi sitio web. (Dark Mode/Light Mode, Tipografía, Apodo/Nickname), se procesa
  en el navegador (Customización / Preferencias de usuario / Recomendaciones)

  setcookie("Nombre de la cookie", "Valor asignado", tiempo de duración);

  Variable de Sesión -> Identificador único que verifica si el usuario cuenta con una sesióna activa
  nombre de usuario/email/UUID, se utiliza en entornos seguros, esto no es público, se procesa en el backend.
  Todas las variables de sesión se consumen en una Base de Datos (Control de usuarios)
*/
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
    <h1>Iniciar sesión</h1>
    <!-- <?php if ($errores): ?><ul><?php foreach ($errores as $e): ?><li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></li><?php endforeach; ?></ul><?php endif; ?> -->
    <form method="post">
      <label>Email:</label>
      <input type="email" name="email" value="" required>
      <label>Contraseña:</label> <input type="password" name="pass" required>
      <label><input type="checkbox" name="recordar"> Recordarme</label>
      <button type="submit">Entrar</button>
    </form>
    <p><a href="registro.php">Crear cuenta</a></p>
  </body>

  </html>
<?php
}

// $errores = [];
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   $email = trim($_POST['email'] ?? '');
//   $pass  = $_POST['pass'] ?? '';
//   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = 'Email inválido';
//   if ($pass === '') $errores[] = 'Contraseña requerida';

//   if (!$errores) {
//     // Demo sin BD: usuario/clave fijos
//     if ($email === 'test@example.com' && $pass === '123456') {
//       $_SESSION['usuario'] = ['email' => $email, 'nombre' => 'Admin Demo'];
//       if (isset($_POST['recordar'])) {
//         // Guardamos datos de sesión por 30 días
//         setcookie('recordar_email', $email, time() + 60 * 60 * 24 * 30, '/');
//       }
//       header('Location: perfil.php');
//       exit;
//     } else {
//       $errores[] = 'Credenciales no válidas';
//     }
//   }
// }
?>