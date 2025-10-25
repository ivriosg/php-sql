<?php
declare(strict_types=1);
session_start();
function require_login(): void {
  if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
  }
}
