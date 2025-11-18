<?php
/* Utilidades */
function limpiar(string $v): string
{
  return htmlspecialchars(trim($v), ENT_QUOTES, 'UTF-8');
}

function es_mayor_de_edad(int $edad): string
{
  return ($edad >= 18) ? '<p class="pass">Sí, es mayor de edad ✅</p>' : '<p class="alert">No, es menor de edad ❌</p>';
}

function validar_telefono(string $telefono): string
{
  $numeros = preg_replace('/[^0-9]+/', '', $telefono);
  // TODO Integrar las 2 validaciones
  // $numero = !preg_match('{10}', $numeros);
  return $numeros;
}

function validar_email(string $email): string
{
  $noComercial = ['gmail', 'yahoo', 'microsoft', 'udem'];
  $encontrado = false;

  foreach ($noComercial as $filtro) {
    if (str_contains($email, $filtro)) {
      $encontrado = true;
      break; // Salir del bucle si ya se encontró una coincidencia
    }
  }

  if ($encontrado) {
    echo "Tu correo: " . $email . "es válido.";
  } else {
    echo "El correo incluye el dominio @" . $filtro . ", es de uso público.";
  }
  return $encontrado;
}


function validar_nacionalidad(string $nacionalidad): string {
  $paises = ['México', 'USA', 'China', 'Guatemala', 'Costa Rica'];
  // La siguiente línea, es una bandera (booleano) para verificar el estatus 
  // de la búsqueda
  $encontrado = false;

  foreach ($paises as $pais) {
    if (str_contains($nacionalidad, $pais)) {
      $encontrado = true;
      break; 
    }
  }

  if ($encontrado) {
    echo "Puedes acceder al país";
  } else {
    echo "No puedes acceder al país";
  }
  return $encontrado;
}