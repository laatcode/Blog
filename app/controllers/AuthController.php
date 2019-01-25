<?php

namespace App\Controllers;

use Sirius\Validation\Validator;
use App\Models\User;

class AuthController extends BaseController {

  public function getLogin() {
    return $this->render('login.twig');
  }

  public function postLogin() {
    $validator = new Validator();
    $validator->add('email', 'required');
    $validator->add('email', 'email');
    $validator->add('password', 'required');

    if($validator->validate($_POST)) {
      $user = User::where('email', $_POST['email'])->first();
      if($user) {
        if (password_verify($_POST['password'], $user->password)) {
          $_SSESSION['userId'] = $user->id;
          header('Location:' . BASE_URL . 'admin');
          return null;
        }
      }

      $validator->addMessage('email', 'Username and/or password does not match');
    }

    $errors = $validator->getMessages();

    return $this->render('login.twig', [
      'errors' => $errors
    ]);
  }

}
 ?>
