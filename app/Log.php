<?php

namespace App;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log {

  private static $_logger = null;

  private static function getLogger() {
    if (!self::$_logger) {
      self::$_logger = new Logger('App Log');
    }

    return self::$_logger;
  }

  public static function logError($error) {
     // Push Hanler permite especificar el archivo donde se va a guardar el log,
     // A través de StreamHandler se especifica la ruta del archivo, seguida del tipo de log a guardar
    self::getLogger()->pushHandler(new StreamHandler('../logs/application.log', Logger::ERROR));
    // Permite guardar el Log
    self::getLogger()->addError($error);
  }

  public static function logInfo($info) {
    self::getLogger()->pushHandler(new StreamHandler('../logs/application.log', Logger::INFO));
    self::getLogger()->addInfo($info);
  }

}


 ?>
