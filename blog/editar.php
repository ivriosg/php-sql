<?php
session_start();
if (!isset($_SESSION['vSESS'])) {
  header('Location: index.php');
  exit();
}
include_once 'functions/database.php';
$id_articulo = intval($_GET["id_articulo"]);

// Buscamos en la BD el artículo con el ID único
$buscarART = $pdo->prepare("SELECT * FROM articulos WHERE id = :id_articulo");
$buscarART->execute([':id_articulo' => $id_articulo]);
$resultado = $buscarART->fetch(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $titulo = trim($_POST['titulo'] ?? '');
  $contenido = trim($_POST['contenido']);
  $description = trim($_POST['description']);
  $imagen = $_POST['imagen'];

  // Actualizar la información en la BD
  $actualizarART = $pdo->prepare("UPDATE articulos SET titulo = :titulo, contenido = :contenido WHERE id = :id_articulo");
  $actualizarART->execute([':titulo' => $titulo, ':contenido' => $contenido, ':id_articulo' => $id_articulo]);

  if ($actualizarART->rowCount() > 0) {
    header('Location: listado.php');
    exit();
  } else {
    echo "Error";
  }
}
?>
<!DOCTYPE html>
<html lang="es_MX">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Creación de artículo</title>
  <!-- CSS -->
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
  <!-- Header -->
  <header>
    <a href="cerrar.php">Cerrar Sesión</a>
  </header>

  <!-- Main -->
  <main>
    <section class="formulario">
      <div>
        <form method="post">
          <label for="titulo">Título</label>
          <input type="text" name="titulo" value="<?php echo $resultado['titulo']; ?>">

          <label for="contenido">Contenido</label>
          <textarea name="contenido" rows="20">
            <?php echo $resultado['contenido']; ?>
          </textarea>

          <label for="description">Metadescription</label>
          <textarea name="description" rows="5">
            <?php echo $resultado['metadescription']; ?>
          </textarea>

          <label for="Keywords">Keywords</label>
          <input type="text" name="keywords" value="<?php echo $resultado['keywords']; ?>" readonly disabled>


          <label for="imagen">Imagen</label>
          <input type="file" name="imagen" accept="image/png, image/jpeg" />


          <label for="OG">OG Tipo</label>
          <input type="text" name="og" value="<?php echo $resultado['keywords']; ?>" readonly disabled>
          <!--
          <label for="description">Idioma Principal</label>
          <select name="mainLang">
            <option value="">--Seleccionar un idioma--</option>
            <option value="es_MX">Español - México</option>
            <option value="es_CO">Español - Colombia</option>
            <option value="en_GB">Inglés - Inglaterra</option>
            <option value="en_US">Inglés - USA</option>
          </select>

          <label for="description">Idioma Alternativo</label>
          <select name="altLang">
            <option value="">--Seleccionar un idioma--</option>
            <option value="es_MX">Español - México</option>
            <option value="es_CO">Español - Colombia</option>
            <option value="en_GB">Inglés - Inglaterra</option>
            <option value="en_US">Inglés - USA</option>
          </select>-->
          <input type="submit" value="Actualizar artículo">
        </form>
      </div>
    </section>
  </main>
  <!-- 
    - Título
  - Contenido 
  - Metadescription
  - OG
  - Twitter cards
  - Keywords
  - Idioma principal
  - Idioma alternativo
  - Datos estructurados
  - Autor
-->
  <!-- Aside -->

  <!-- Footer -->


  <?php echo 'Impresión de la fecha de hoy: ' . date('d M y');



  echo '<br>' . $publicacion->format("Y-m-d\TH:i:sP") . '<br><br><br><br>';

  ?>



</body>

</html>