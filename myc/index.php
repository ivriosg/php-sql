<?php require 'includes/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es_MX" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reserva - Miel y Canela </title>
  <!-- TODO: Agregar metadatos para posicionamiento -->
  <!-- TODO: Agregar datos estructurados de LocalBusiness, Menú de alimentos -->

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
</head>

<body>

  <?php
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
      echo 'Error';
      // TODO: Mostrar popup o popover de bootstrap
    } else {

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
        Nombre = Ivan Rios
        Horario | Reserva ahora -> BTN
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

  <section class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8 col-sm">
<!--
      https://getbootstrap.com/docs/5.3/components/toasts/
        <button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>

        <div class="toast-container text-bg-primary position-fixed bottom-0 end-0 p-3">
          <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
              <strong class="me-auto">Bootstrap</strong>
              <small>11 mins ago</small>
              <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
              Hello, world! This is a toast message.
            </div>
          </div>
        </div>
-->
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
      </div>
    </div>

  </section>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>


  <!-- TODO: Configuración del componente: https://fkammer.github.io/ng-eternicode-datepicker/ -->
  <script>
    $(document).ready(function() {
      $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
      });
    });

    const toastTrigger = document.getElementById('liveToastBtn')
const toastLiveExample = document.getElementById('liveToast')

if (toastTrigger) {
  const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
  toastTrigger.addEventListener('click', () => {
    toastBootstrap.show()
  })
}
  </script>
</body>

</html>