<!DOCTYPE html>
<html lang="es_MX">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Creación de artículo</title>

  <meta name="keywords" values="<?php echo $keywords[1], $keywords[2];?>">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <!-- Header -->

  <!-- Main -->
  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $titulo = trim($_GET['titulo'] ?? '');
    $contenido = isset($_GET['contenido']);
    $description = isset($_GET['description']);

    $keywords = trim($_GET['keywords'] ?? '');
    $arrayKW = explode(".", $keywords);
    $arrayKWDT = explode(",", $keywords);

    // TODO: Explicar array simple y su limpieza para evitar XSS


    // Limpiamos espacios extra alrededor de cada elemento
    $arrayKW = array_map('trim', $arrayKW);
    echo "Array separado por punto: ";
    var_dump($arrayKW);
    echo "<br> Array separado por coma: ";
    var_dump($arrayKWDT);

    echo "<br>" . "Texto en la posición 1 con el separador punto: " . $arrayKW[0];
    echo "<br><br><br>" . "Texto en la posición 1 con el separador coma: " . $arrayKWDT[4];

    // Control de errores con PHP + HTML + CSS
  }
  ?>

  <main>
    <section class="formulario">
      <div>
        <form method="get">
          <label for="titulo">Título</label>
          <input type="text" name="titulo">

          <label for="contenido">Contenido</label>
          <textarea name="contenido" rows="20"></textarea>

          <label for="imagen">Imagen</label>
          <input type="file" name="imagen" accept="image/png, image/jpeg" />

          <label for="description">Metadescription</label>
          <textarea name="description" rows="5"></textarea>

          <label for="OG">OG</label>
          <input type="text" name="og">

          <label for="Twitter">Twitter</label>
          <input type="text" name="twitter">

          <label for="Keywords">Keywords</label>
          <input type="text" name="keywords">

          <label for="description">Idioma Principal</label>
          <select name="main">
            <option value="">--Seleccionar un idioma--</option>
            <option value="es_MX">Español - México</option>
            <option value="es_CO">Español - Colombia</option>
            <option value="en_GB">Inglés - Inglaterra</option>
            <option value="en_US">Inglés - USA</option>
          </select>

          <label for="description">Idioma Alternativo</label>
          <select name="alt">
            <option value="">--Seleccionar un idioma--</option>
            <option value="es_MX">Español - México</option>
            <option value="es_CO">Español - Colombia</option>
            <option value="en_GB">Inglés - Inglaterra</option>
            <option value="en_US">Inglés - USA</option>
          </select>

          <input type="submit" value="Crear artículo">
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
</body>

</html>