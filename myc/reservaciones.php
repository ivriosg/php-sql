<?php
require_once 'includes/conexion.php';
require_once 'includes/header.php';
?>

<table class="table table-striped table-dark">
  <thead>
    <tr>
      <th scope="col">Tipo de reserva</th>
      <th scope="col">Fecha</th>
      <th scope="col"># personas</th>
      <th scope="col">Nombre</th>
      <th scope="col">Teléfono</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <?php
      // Contamos el número de registros existentes
      $contar = $pdo->query("SELECT COUNT(*) FROM myc");
      $total_registros = $contar->fetchColumn();

      // Configuramos el número de registros por página
      $registros_por_pagina = 2;

      // Obtenemos el total de páginas basado en la configuración anterior
      $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
      $offset = ($pagina_actual - 1) * $registros_por_pagina;
      $total_paginas = ceil($total_registros / $registros_por_pagina);

      // Consulta de SQL
      $buscarTodo = $pdo->prepare("SELECT * FROM myc ORDER BY id LIMIT :limit OFFSET :offset");
      $buscarTodo->bindValue(':limit', $registros_por_pagina, PDO::PARAM_INT);
      $buscarTodo->bindValue(':offset', $offset, PDO::PARAM_INT);
      $buscarTodo->execute();

      // Mostramos el resultado
      $res = $buscarTodo->fetchAll(PDO::FETCH_ASSOC);

      // Imprimimos de forma dinámica los resultados, con la consulta de SQL
      foreach ($res as $single) {
        echo '
          <th scope="row">' . $single["reserva"] . '</th>
            <td>' . $single["f_reserva"] . '</td>
            <td>' . $single["n_personas"] . '</td>
            <td>' . $single["nombre"] . '</td>
            <td>' . $single["telefono"] . '</td>
            <td class="text-center align-middle"><i class="bi bi-pencil-fill p-2"></i> <i class="bi bi-calendar-x text-danger"></i></td>
          </tr>
        ';
      }
      ?>
  </tbody>
</table>

<nav aria-label="Navegación de reservaciones">
  <ul class="pagination">
    <?php
    // Configuramos navegación dinámica para botones
    $anterior = $_GET['pagina'] - 1;
    $siguiente = $_GET['pagina'] + 1;
    echo "<li class='page-item'><a class='page-link' href='?pagina=$anterior' id='anterior'>Anterior</a></li>";
    for ($i = 1; $i <= $total_paginas; $i++) {
      echo "<li class='page-item'><a href='?pagina=$i' class='page-link'>$i</a> ";
    }
    echo "<li class='page-item'><a class='page-link' href='?pagina=$siguiente' id='siguiente'>Siguiente</a></li>";
    ?>
  </ul>
</nav>

<?php require_once 'includes/footer.php'; ?>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const totalPaginas = <?= (int) $total_paginas ?>;

    // Helper para obtener el parámetro "pagina" desde un href
    const getPaginaFromHref = (href) => {
      if (!href || !href.includes('?')) return null;
      const params = new URLSearchParams(href.split('?')[1]);
      const page = params.get('pagina');
      return page !== null ? Number(page) : null;
    };

    // Deshabilitar botón "Anterior"
    const linkAnterior = document.querySelector('#anterior');
    if (linkAnterior) {
      const paginaAnterior = getPaginaFromHref(linkAnterior.getAttribute('href'));

      if (paginaAnterior === null || paginaAnterior <= 0) {
        const liAnterior = linkAnterior.closest('.page-item');
        if (liAnterior) liAnterior.classList.add('disabled');
      }
    }

    // Deshabilitar botón "Siguiente"
    const linkSiguiente = document.querySelector('#siguiente');
    if (linkSiguiente) {
      const paginaSiguiente = getPaginaFromHref(linkSiguiente.getAttribute('href'));

      if (paginaSiguiente === null || paginaSiguiente > totalPaginas) {
        const liSiguiente = linkSiguiente.closest('.page-item');
        if (liSiguiente) liSiguiente.classList.add('disabled');
      }
    }
  });
</script>