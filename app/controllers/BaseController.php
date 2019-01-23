<?php

namespace App\Controllers;

use Twig_Loader_Filesystem;

class BaseController {

  protected $templateEngine;

  public function __construct() {
    // Clase que utiliza twig para cargar los archivos del sistema. Este método recibe como parametro, la ruta en la que se encuentran las vistas a utilizar.
    $loader = new Twig_Loader_Filesystem('../views');

    // Permite almacenar la configuración de Twig
    $this->templateEngine = new \Twig_Enviroment($loader, [
      'debug' => true,
      'cache' => false
    ]);
  }

  public function render($fileName, $data = []) {
    // El método render carga el template pasado como primer argumento y lo renderea con las variables pasadas como segundo argumento
    return $this->templateEngine->render($fileName, $data);
  }
}


 ?>
