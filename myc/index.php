<?php
require 'includes/conexion.php';
require 'includes/header.php';
require 'functions/index.php';
// TODO: Filtro para groserías: https://www.google.com/search?q=word+filter+php+espa%C3%B1ol&sca_esv=93a27070e35a51f2&ei=AUQraeGAINjjkPIP-8ihmQU&ved=0ahUKEwihhcHzhpiRAxXYMUQIHXtkKFMQ4dUDCBE&uact=5&oq=word+filter+php+espa%C3%B1ol&gs_lp=Egxnd3Mtd2l6LXNlcnAiGHdvcmQgZmlsdGVyIHBocCBlc3Bhw7FvbDIFEAAY7wUyBRAAGO8FMgUQABjvBTIFEAAY7wVIuwlQnQVYnQVwAXgBkAEAmAGWAaABlgGqAQMwLjG4AQPIAQD4AQGYAgKgAp8BwgIKEAAYsAMY1gQYR5gDAOIDBRIBMSBAiAYBkAYFkgcDMS4xoAeyArIHAzAuMbgHnAHCBwUwLjEuMcgHBQ&sclient=gws-wiz-serp
// TODO: Agregar funcionalidad para guardar en BD el registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $reserva = $_POST['reserva'];
  $f_reserva = $_POST['f_reserva'];
  $n_personas = $_POST['n_personas'];
  $nombre = trim($_POST['nombre']);
  $email = trim($_POST['email']);
  $telefono = trim($_POST['telefono']);
  $comentarios = trim($_POST['comentarios']);

  // TODO: Revisamos en el sistema si hay disponibilidad
  $buscarDB = $pdo->prepare("SELECT f_reserva FROM myc WHERE f_reserva = :f_reserva");
  $buscarDB->execute([':f_reserva' => $f_reserva]);
  $resultado = $buscarDB->fetch(PDO::FETCH_ASSOC);

  if ($resultado) {
    // TODO: Mostrar popup o popover de bootstrap si ya hay una reserva en la misma fecha
    echo alerta('danger', 'Error', 'Hubo un error al actualizar la BD');
  } else {
    echo alerta('success', 'Reservación exitosa', 'Tu solicitud fue procesada correctamente.');
    /*
        Ivan Rios
        ivriosg@gmail.com
        ------------------------------------------------------------
        Guardamos los datos en la tabla myc con status = pendiente
        ------------------------------------------------------------
        Confirmamos reserva
        UPDATE / PATCH con WHERE = ivriosg@gmail.com y status = confirmado
        ------------------------------------------------------------
        Confirmamos reserva
        UPDATE / PATCH con WHERE = ivriosg@gmail.com y status = cancelado
        */

    /* TODO:
        Si hay disponibilidad, preguntar si desean reserva en este momento, si confirman
        Agregar pupop o popover de bootstrap y obtener el valor del clic con JS

        TODO Ivan 
        ---------
        fetchAll() -> Mostrar horarios disponibles
        Horario | Reserva ahora -> BTN
        Acciones = Editar / Cancelar
      */

    // Insertamos la información en la tabla MYC de la BD
    $g_reserva = $pdo->prepare("INSERT INTO myc(reserva,f_reserva,n_personas,nombre,email,telefono,comentarios) VALUES(?,?,?,?,?,?,?)");
    $g_reserva->execute([$reserva, $f_reserva, $n_personas, $nombre, $email, $telefono, $comentarios]);

    // Si no confirman la reserva, guardamos la información en una tabla adicional reservas sin confirmar para tener métricas
    /* TODO: Crear tabla nueva
    $c_reserva = $pdo->prepare("INSERT INTO myc_cancelado(reserva,f_reserva,n_personas,nombre,email,telefono,comentarios) VALUES(?,?,?,?,?,?,?)");
    $c_reserva->execute([$reserva, $f_reserva, $n_personas, $nombre, $email, $telefono, $comentarios]);
    */
  }
}
// TODO: Verificar la disponibilidad en el sistema
?>
<form method="POST">
  <div class="mb-3">
    <label for="reserva" class="form-label">Tipo de Reserva</label>
    <select class="form-select" aria-label="Tipo de Reserva" name="reserva">
      <option>- Selecciona una opción -</option>
      <option value="Desayuno">Desayuno</option>
      <option value="Comida">Comidad</option>
    </select>
  </div>

  <div class="mb-3">
    <label for="f_reserva" class="form-label">Fecha de reserva</label>
    <input type="text" class="form-control" id="datepicker" name="f_reserva">
    <!-- <input type="date" class="form-control"> -->
  </div>

  <div class="mb-3">
    <label for="n_personas" class="form-label">Número de personas</label>
    <select class="form-select" aria-label="Número de personas" name="n_personas">
      <option>- Selecciona una opción -</option>
      <option value="1-4">1 - 4</option>
      <option value="5-9">5 - 9</option>
      <option value="10-15">10 - 15</option>
      <option value="16-20">16 - 20</option>
    </select>
  </div>

  <div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" class="form-control" name="nombre">
  </div>

  <div class="mb-3">
    <label for="email" class="form-label">Correo electrónico</label>
    <input type="email" class="form-control" aria-describedby="emailHelp" name="email" required>
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>

  <div class="mb-3">
    <label for="telefono" class="form-label">Teléfono</label>
    <input type="tel" class="form-control" name="telefono">
  </div>

  <div class="mb-3">
    <label for="comentarios" class="form-label">¿Alguna petición adicional?</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="comentarios"></textarea>
  </div>
  <input type="submit" class="btn btn-primary" value="Realizar consulta">
</form>

<?php include_once 'includes/footer.php'; ?>
<script>
  $(document).ready(function() {
    $('#datepicker').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
    });
  });

  document.addEventListener('DOMContentLoaded', () => {
    const toastLiveExample = document.getElementById('liveToast');

    if (toastLiveExample) {
      const shouldShow = toastLiveExample.getAttribute('data-show') === 'true';

      if (shouldShow) {
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
        toastBootstrap.show();
      }
    }
  });
</script>