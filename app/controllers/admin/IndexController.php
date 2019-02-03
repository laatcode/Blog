<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\User;

class IndexController extends BaseController {

  public function getIndex() {
    $user = User::find($_SESSION['userId']);

    return $this->render('admin/index.twig', [
      'user' => $user
    ]);
  }
}

 ?>
