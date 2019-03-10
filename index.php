<?php
use Illuminate\Database\Capsule\Manager as Capsule;

// ini_set Permite inicializar valores de configuración
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
error_reporting(E_ALL);

ini_set('date.timezone', 'America/Bogota');

require_once('vendor/autoload.php');

session_start();

// Se reemplaza el nombre del archivo (ej. index.php) con una cadena vacía para obtener el BaseDir
$baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
// Se concatena el host (localhost) con el basedir obtenido previamente
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . $baseDir;
define('BASE_URL', $baseUrl);

// En caso de que $_GET['route'] no tenga valor, se toma '/'
$route = $_GET['route'] ?? '/';

$dotenv = \Dotenv\Dotenv::create(__DIR__);
$dotenv->load();


$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => getEnv('DB_HOST'),
    'database'  => getEnv('DB_NAME'),
    'username'  => getEnv('DB_USER'),
    'password'  => getEnv('DB_PASS'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

use Phroute\Phroute\RouteCollector;

$router = new RouteCollector();

$router->filter('auth', function (){
  if (!isset($_SESSION['userId'])) {
    header('Location:' . BASE_URL . 'auth/login');
    return false;
  }
});

$router->controller('/auth', App\Controllers\AuthController::class);

$router->group(['before' => 'auth'], function ($router){
  $router->controller('/myprofile', App\Controllers\Admin\ProfileController::class);
  $router->controller('/admin', App\Controllers\Admin\IndexController::class);
  $router->controller('/admin/posts', App\Controllers\Admin\PostController::class);
  $router->controller('/admin/users', App\Controllers\Admin\UserController::class);
});
// ::class regresa el nombre de la clase, esto permite prevenir cometer errores de tipeo
$router->controller('/', App\Controllers\IndexController::class);

$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $route);

echo $response;

 ?>
