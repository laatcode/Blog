<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\User;
use Sirius\Validation\Validator;

class UserController extends BaseController {

  public function getIndex(){
    $users = User::all();
    $user = User::find($_SESSION['userId']);

    return $this->render('admin/users.twig', [
      'users' => $users,
      'loggedUser' => $user
    ]);
  }

  public function getCreate() {
    $user = User::find($_SESSION['userId']);
    return $this->render('admin/insert-user.twig', [
      'loggedUser' => $user,
    ]);
  }

  public function postCreate() {
    $errors = [];
    $result = false;
    $loggedUser = User::find($_SESSION['userId']);

    $validator = new Validator();
    $validator->add('name', 'required');
    $validator->add('email', 'required');
    $validator->add('email', 'email');
    $validator->add('password', 'required');

    if ($validator->validate($_POST)) {
      $user = new User();
      $user->name = $_POST['name'];
      $user->email = $_POST['email'];
      $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $user->created_by = $loggedUser->id;
      $user->updated_by = $loggedUser->id;

      if ($_FILES['img']['name']) {
        $img_src = "images/profile_images/" . uniqid() . $_FILES['img']['name'];
        move_uploaded_file($_FILES['img']['tmp_name'], $img_src);
        $user->img_src = $img_src;
      }

      $user->save();
      $result = true;
    }else {
      $errors = $validator->getMessages();
    }

    return $this->render('admin/insert-user.twig', [
      'result' => $result,
      'errors' => $errors,
      'loggedUser' => $loggedUser
    ]);
  }

  public function getEdit($id) {
    $user = User::find($id);
    return $this->render('admin/insert-user.twig', [
      'user' => $user
    ]);
  }

  public function postEdit($id) {
    $errors = [];
    $result = false;
    $loggedUser = User::find($_SESSION['userId']);

    $validator = new Validator();
    $validator->add('name', 'required');
    $validator->add('email', 'required');
    $validator->add('email', 'email');

    if ($validator->validate($_POST)) {
      $user = User::find($id);
      $user->name = $_POST['name'];
      $user->email = $_POST['email'];
      $user->updated_by = $loggedUser->id;

      if ($_POST['password']) {
        $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      }

      if ($_FILES['img']['name']) {
        $img_src = "images/profile_images/" . uniqid() . $_FILES['img']['name'];
        move_uploaded_file($_FILES['img']['tmp_name'], $img_src);
        $user->img_src = $img_src;
      }

      $user->save();
      $result = true;
    }else {
      $errors = $validator->getMessages();
    }

    return $this->render('admin/insert-user.twig', [
      'result' => $result,
      'errors' => $errors,
      'loggedUser' => $loggedUser,
      'user' => $user
    ]);
  }
}

 ?>
