<?php
function formulario()
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
