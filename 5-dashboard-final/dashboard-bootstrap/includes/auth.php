<?php
declare(strict_types=1);
session_start();
function login_required(): void {
  if (!isset($_SESSION['uid'])) {
    header('Location: /php-curso/5-dashboard-final/index.php');
    exit;
  }
}
