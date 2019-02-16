<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogPost;
use App\Models\User;
use Sirius\Validation\Validator;

class PostController extends BaseController {

  public function getIndex() {
    $blogPosts = BlogPost::all();
    $user = User::find($_SESSION['userId']);
    return $this->render('admin/posts.twig', [
      'blogPosts' => $blogPosts,
      'loggedUser' => $user
    ]);
  }

  public function validatePost() {
    $validator = new Validator();
    $validator->add('title', 'required');
    $validator->add('content', 'required');

    return $validator->validate($_POST);
  }

  public function getCreate() {
    $user = User::find($_SESSION['userId']);
    return $this->render('admin/insert-post.twig', [
      'loggedUser' => $user
    ]);
  }

  public function postCreate() {
    $errors = [];
    $result = false;
    $user = User::find($_SESSION['userId']);

    if ($this.validatePost()) {
      $blogPost = new BlogPost([
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'created_by' => $_SESSION['userId']
      ]);

      if ($_FILES['img']['name']) {
        $img_src = "images/post_images/" . uniqid() . $_FILES['img']['name'];
        move_uploaded_file($_FILES['img']['tmp_name'], $img_src);
        $blogPost->img_src = $img_src;
      }

      $blogPost->save();
      $result = true;
    }else {
      $errors = $validator->getMessages();
    }

    return $this->render('admin/insert-post.twig', [
      'result' => $result,
      'errors' => $errors,
      'loggedUser' => $user
    ]);
  }

  public function getEdit($id) {
    $blogPost = BlogPost::find($id);
    $user = User::find($_SESSION['userId']);
    return $this->render('admin/edit-post.twig', [
      'loggedUser' => $user,
      'blogPost' => $blogPost
    ]);
  }

  public function postEdit($id) {
    $errors = [];
    $result = false;
    $user = User::find($_SESSION['userId']);

    if ($this->validatePost()) {
      $blogPost = BlogPost::find($id);
      $blogPost->title = $_POST['title'];
      $blogPost->content = $_POST['content'];

      if ($_FILES['img']['name']) {
        $img_src = "images/post_images/" . uniqid() . $_FILES['img']['name'];
        move_uploaded_file($_FILES['img']['tmp_name'], $img_src);
        $blogPost->img_src = $img_src;
      }

      $blogPost->save();
      $result = true;
    }else {
      $errors = $validator->getMessages();
    }

    return $this->render('admin/edit-post.twig', [
      'loggedUser' => $user,
      'errors' => $errors,
      'result' => $result,
      'blogPost' => $blogPost
    ]);
  }

  public function getDelete($id) {
    $blogPost = BlogPost::find($id);
    $blogPost->delete();
    header('Location:' . BASE_URL . 'admin/posts');
    return null;
  }

}


 ?>
