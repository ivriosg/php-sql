<?php
session_start();
if (!isset($_SESSION['vSESS'])) {
  header('Location: index.php');
  exit();
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

  <!-- CKEditor 5 -->
  <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/47.2.0/ckeditor5.css" />
  <script src="https://cdn.ckeditor.com/ckeditor5/47.2.0/ckeditor5.umd.js"></script>
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
        <form method="post" action="articulo.php">
          <label for="titulo">Título</label>
          <input type="text" name="titulo">

          <label for="contenido">Contenido</label>
          <textarea name="contenido" rows="20"></textarea>

          <label for="description">Metadescription</label>
          <textarea name="description" rows="5"></textarea>

          <script>
            $(document).ready(() => {
              const {
                ClassicEditor,
                Essentials,
                Bold,
                Italic,
                Font,
                Paragraph
              } = CKEDITOR;

              ClassicEditor
                .create($('#editor')[0], {
                  licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NjQzNzQzOTksImp0aSI6IjFlODQ2MzA2LWUzYTEtNGExOC04MWVhLWE4M2Q3YmE1MjliYSIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiLCJzaCJdLCJ3aGl0ZUxhYmVsIjp0cnVlLCJsaWNlbnNlVHlwZSI6InRyaWFsIiwiZmVhdHVyZXMiOlsiKiJdLCJ2YyI6Ijk3NTE5ZjcwIn0.iCiD5RA_eZqONQYKUIEvMf8pBxTExaYx2m0aQzxX-6-bBAco5WCkKtfhp0Wzp-8txelilCMuKbjEwIxols5AnA',
                  plugins: [Essentials, Bold, Italic, Font, Paragraph],
                  toolbar: [
                    'undo', 'redo', '|', 'bold', 'italic', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                  ]
                })
                .then(editor => {
                  // Editor initialized successfully.
                  console.log('CKEditor 5 initialized with jQuery!');
                })
                .catch(error => {
                  console.error('Error initializing CKEditor 5:', error);
                });
            });
          </script>
</body>

<label for="Keywords">Keywords</label>
<input type="text" name="keywords">

<label for="imagen">Imagen</label>
<input type="file" name="imagen" accept="image/png, image/jpeg" />

<label for="OG">OG Tipo</label>
<input type="text" name="og">

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


<?php echo 'Impresión de la fecha de hoy: ' . date('d M y');

$publicacion = new DateTime("now", new DateTimeZone("America/Mexico_City"));

echo '<br>' . $publicacion->format("Y-m-d\TH:i:sP") . '<br><br><br><br>';

?>



</body>

</html>