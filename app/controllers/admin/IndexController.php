<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\User;

class IndexController extends BaseController {

  public function getIndex() {
    return $this->render('admin/index.twig', [
      'loggedUser' => parent::$loggedUser
    ]);
  }
}

 ?>
