<?php

declare(strict_types=1);
require 'funciones/index.php';

$resultado = null;
$errores = [];

// Validar por metodo 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $edad = (int)($_POST['edad'] ?? 0);
  $telefono = (string)($_POST['telefono'] ?? 0);
  $email = (string)($_POST['email'] == '');
  $nacionalidad = (string)($_POST['nacionalidad'] == '');

  $resultado = es_mayor_de_edad($edad) . "<br>" .
    validar_telefono($telefono) . "<br>" .
    validar_email($email) . "<br>" .
    validar_nacionalidad($nacionalidad);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<style>
  form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }
</style>

<body>

  <!-- 
✅ Formulario: Debe de solicitar datos personales, nombre, apellido, edad, teléfono, email y nacionalidad
✅ La información debe de validar que el usuario sea mayor de edad. 
TODO: Teléfono a 10 dígitos.
✅ Validación de email básica (HTML) y verificar si el email es comercial o no (@gmail, @yahoo, @microsoft != comercial)
TODO: Ver si podemos filtrar la nacionalidad por un array +52 = México +811 = Nombre de País 
-->

  <form method="post">
    <label for="nombre">Nombre
      <input type="text" name="nombre">
    </label>
    <label for="apellido">Apellido
      <input type="text" name="apellido">
    </label>
    <label for="edad">Edad
      <input type="number" name="edad" required>
    </label>
    <label for="telefono">Teléfono
      <input type="tel" name="telefono" required>
    </label>
    <label for="email">Email
      <input type="email" name="email" required>
    </label>
    <label for="nacionalidad">Nacionalidad
      <input type="text" name="nacionalidad" value="
      <?php

      if ($_POST['nacionalidad'] != NULL) {
        echo $_POST['nacionalidad'];
      }
      ?>
    ">
    </label>



    <input type="submit" value="Enviar datos">
  </form>

  <div class="resultados">
    <?php if ($resultado !== null): ?>
      <h2>Resultado:</h2>
      <p><strong><?php echo $resultado; ?></strong></p>
    <?php endif; ?>
  </div>
</body>

</html>