<?php
function limpiar(?string $v): ?string
{
  return $v ? htmlspecialchars(trim($v), ENT_QUOTES, 'UTF-8') : null;
}
