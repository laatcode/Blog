<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\User;

class ProfileController extends BaseController {

  public function getIndex() {
    return $this->render('admin/my-profile.twig', [
      'loggedUser' => parent::$loggedUser
    ]);
  }
}

 ?>
