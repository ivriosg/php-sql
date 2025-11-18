<!DOCTYPE html>
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $titulo = trim($_POST['titulo'] ?? '');
  $contenido = trim($_POST['contenido']);
  $description = trim($_POST['description']);
  $imagen = $_POST['imagen'];

  // Arreglo de palabra clave
  $keywords = trim($_POST['keywords'] ?? '');
  $arrayKW = explode(",", $keywords);

  // Limpiamos espacios extra alrededor de cada elemento
  $arrayKW = array_map('trim', $arrayKW);

  // Idioma para la página HTML
  $mainLang = trim($_POST['mainLang'] ?? '');

  // Separar el idioma por el guíon bajo (_)
  $mainFlag = substr($mainLang, 0, -3);

  // Obtener idioma alternativo.
  $altFlag = trim($_POST['altLang'] ?? '');
  $altFlag = substr($altFlag, 0, -3);

  $url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]/";
?>
  <html lang="<?php echo $mainLang; ?>">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>

    <!-- Meta básica -->
    <meta name="description" content="<?php echo $description; ?>">
    <meta name="keywords" content="<?php echo $keywords; ?>">

    <!-- Idiomas del sistema -->
    <link rel="alternate" href="<?php echo $url . $mainFlag; ?>" hreflang="<?php echo $mainFlag; ?>" />
    <?php
    if (trim($altFlag)) {
      /* Verificar si existe la variable $altFlag, si existe, mostrar link rel, de lo contrario ocultar la etiqueta */
      echo '<link rel="alternate" href="' . $url . $altFlag . '" hreflang="' . $altFlag . '" />';
    }
    ?>
    <!-- OG -->
    <meta property="og:title" content="<?php echo $titulo; ?>" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="<?php echo $url; ?>" />
    <meta property="og:image" content="" />

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $titulo; ?>">
    <meta name="twitter:description" content="<?php echo $description; ?>">
    <meta name="twitter:image" content="">

    <!-- Datos estructurados -->
    <!-- 
      Local Business
      Artículo
      Author
    -->
    <?php echo '
    <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "NewsArticle",
        "headline": "' . $titulo . '",
        "image": [
          "https://example.com/photos/1x1/photo.jpg",
          "https://example.com/photos/4x3/photo.jpg",
          "https://example.com/photos/16x9/photo.jpg"
        ],
        "datePublished": "2024-01-05T08:00:00+08:00",
        "dateModified": "2024-02-05T09:20:00+08:00",
        "author": [{
          "@type": "Person",
          "name": "Ivan Rios",
          "url": "http://localhost:8888/2025/clase/blog/profile/ivanrios"
        }]
      }
    </script>
    ';
    ?>


  </head>
  <?php
  ?>

  <body>
    <main>
      <article class="article - <?php echo $titulo; ?>">
        <p><?php echo $description; ?></p>

        <h1><?php echo $titulo; ?></h1>
        <img src="<?php echo $imagen; ?>">
        <?php var_dump($imagen); ?>
        <!-- 
          Ver integración de CKEditor 
          https://ckeditor.com/ckeditor-5/demo/feature-rich/
        -->
        <p><?php echo $contenido; ?></p>
      </article>
    </main>
  </body>

  </html>

<?php

} else {
  echo '<title>Página en blanco</title>';
  echo "Aquí no hay contenido dinámico.";
  // header('Location: index.php');

  // Redirección por falta de permisos
  // Variables de sesión o cookie
}
?>