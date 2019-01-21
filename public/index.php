<?php
// ini_set Permite inicializar valores de configuración
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
error_reporting(E_ALL);

require_once('../config.php');
require_once('../vendor/autoload.php');

$route = $_GET['route'] ?? '/';

use Phroute\Phroute\RouteCollector;

$router = new RouteCollector();
$router->get('/', function () use ($pdo) {
  $query = $pdo->prepare("SELECT * from blog_posts ORDER BY id DESC");
  $query->execute();

  $blog_posts = $query->fetchAll(PDO::FETCH_ASSOC);
  include '../views/index.php';
});

$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $route);

echo $response;

 ?>
