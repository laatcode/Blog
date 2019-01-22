<?php
// ini_set Permite inicializar valores de configuración
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
error_reporting(E_ALL);

require_once('../config.php');
require_once('../vendor/autoload.php');

// Se reemplaza el nombre del archivo (ej. index.php) con una cadena vacía para obtener el BaseDir
$baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
// Se concatena el host (localhost) con el basedir obtenido previamente
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . $baseDir;
define('BASE_URL', $baseUrl);

// En caso de que $_GET['route'] no tenga valor, se toma '/'
$route = $_GET['route'] ?? '/';

function render($fileName, $params = []){
  // El método ob_start hace que todas las salidas de PHP se vayan a un buffer interno
  ob_start();
  // Toma un arreglo asociativo y si los índices del arreglo son cadenas de caracteres, las convierte en variables públicas
  extract($params);
  include $fileName;
  // Trae los datos que están actualmente en el buffer y posteriormente lo limpia
  return ob_get_clean();
}


use Phroute\Phroute\RouteCollector;

$router = new RouteCollector();

$router->get('/admin', function (){
  return render('../views/admin/index.php');
});

$router->get('/', function () use ($pdo) {
  $query = $pdo->prepare("SELECT * from blog_posts ORDER BY id DESC");
  $query->execute();

  $blogPosts = $query->fetchAll(PDO::FETCH_ASSOC);
  return render('../views/index.php', ['blogPosts' => $blogPosts]);
});

$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $route);

echo $response;

 ?>
