<?php
$state = !empty($_GET['utm_campaign']) ? $_GET['utm_campaign'] : 'Psicología en Línea';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <!-- our project is using icons from Solid, Sharp Thin, Sharp Duotone Thin + Brands -->
  <link href="assets/css/fontawesome.css" rel="stylesheet" />
  <link href="assets/css/brands.css" rel="stylesheet" />
  <link href="assets/css/solid.css" rel="stylesheet" />
</head>

<body>
  <header>
    <div class="logo">
      <img src="https://placehold.co/200x90" alt="" />
    </div>
    <nav class="navbar">
      <ul>
        <li><a href="#">Link 1</a></li>
        <li><a href="#">Link 2</a></li>
        <li><a href="#">Link 3</a></li>
        <li><a href="#">Link 4</a></li>
      </ul>
    </nav>
    <div class="btn">
      <a href="#" class="btn">Agendar ahora</a>
    </div>
  </header>

  <main>
    <section class="hero">
      <div class="containter">
        <h1>
          <?php
          echo $state;
          ?>
        </h1>
      </div>
    </section>

  </main>

  <footer>
    <div class="container">
      <div class="footer__copy">
        <p>© Psicología en línea <?php echo date('Y'); ?></p>
      </div>
      <div class="footer__social">
        <a href="#"><i class="fa-brands fa-twitter-square"></i></a>
        <a href="#"><i class="fa-brands fa-facebook-square"></i></a>
      </div>
    </div>
  </footer>
</body>

</html>