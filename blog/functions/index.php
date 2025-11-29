<?php
function iniciar_sesion()
{
  echo '
    <h1>Iniciar sesión</h1>
    <form method="post">
      <label>Email:</label>
      <input type="email" name="email" value="" required>
      <label>Contraseña:</label> <input type="password" name="pass" required>
      <label><input type="checkbox" name="recordar"> Recordarme</label>
      <button type="submit">Entrar</button>
    </form>
    <p><a href="registro.php">Crear cuenta</a></p>
  ';
}

function registro() {
  echo '
    <form method="post">
      <label for="nombre">Nombre de usuario</label>
      <input type="text" name="nombre">
      <label for="telefono">Teléfono</label>
      <input type="text" name="telefono">
      <label for="email">Email</label>
      <input type="email" name="email">
      <label for="password">Contraseña</label>
      <input type="password" name="password">

      <input type="submit" value="Completar registro">
    </form>
  ';

}
