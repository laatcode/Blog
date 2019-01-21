<?php
// ini_set Permite inicializar valores de configuración
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
error_reporting(E_ALL);

require_once('../config.php');

$route = $_GET['route'] ?? '/';

switch ($route) {
  case '/':
    require '../index.php';
    break;

  case '/admin':
    require '../admin/index.php';
    break;

  case '/admin/posts':
    require '../admin/posts.php';
    break;
}
 ?>
