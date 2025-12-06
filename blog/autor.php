<!DOCTYPE html>
<html lang="es_MX" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservaciones - Miel y Canela</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
  <section class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md col-sm">

        <table class="table table-striped table-dark">
          <thead>
            <tr>
              <th scope="col">Nombre de la nota</th>
              <th scope="col">Fecha de publicación</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php
              include 'functions/database.php';

              $id_autor = intval($_GET["id_autor"]);
              // Consulta de SQL
              // Relacionamos las 2 tablas para tener el nombre del autor
              // $buscar = $pdo->prepare("SELECT titulo, publicacion FROM articulos WHERE id_autor = :id_autor;");
              $buscar = $pdo->prepare("SELECT a.id, a.id_autor, a.titulo, a.publicacion, r.nombre 
                                       FROM articulos a 
                                       INNER JOIN registros r 
                                       ON a.id_autor = r.id
                                       WHERE a.id_autor = :id_autor;");
              $buscar->execute(['id_autor' => $id_autor]);

              // Mostramos el resultado
              $res = $buscar->fetchAll(PDO::FETCH_ASSOC);
              // Imprimimos de forma dinámica los resultados, con la consulta de SQL
              echo '<h3>Notas del autor: ' . $res[0]['nombre'] . '</h3>';
              foreach ($res as $single) {
                echo '
                  <th scope="row">' . $single["titulo"] . '</th>
                    <td>' . $single["publicacion"] . '</td>
                  </tr>
                ';
              }
              ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>

</html>