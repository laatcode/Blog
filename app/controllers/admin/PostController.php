<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogPost;
use App\Models\User;
use Sirius\Validation\Validator;

class PostController extends BaseController {

  public function getIndex() {
    $blogPosts = BlogPost::all();
    return $this->render('admin/posts.twig', [
      'blogPosts' => $blogPosts,
      'loggedUser' => parent::$loggedUser
    ]);
  }

  public function validatePost() {
    $validator = new Validator();
    $validator->add('title', 'required');
    $validator->add('content', 'required');

    return $validator->validate($_POST);
  }

  public function getCreate() {
    return $this->render('admin/insert-post.twig', [
      'loggedUser' => parent::$loggedUser
    ]);
  }

  public function postCreate() {
    $errors = [];
    $result = false;

    if ($this->validatePost()) {
      $blogPost = new BlogPost([
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'created_by' => $_SESSION['userId'],
        'updated_by' => parent::$loggedUser->id
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
      'loggedUser' => parent::$loggedUser
    ]);
  }

  public function getEdit($id) {
    $blogPost = BlogPost::find($id);
    return $this->render('admin/insert-post.twig', [
      'loggedUser' => parent::$loggedUser,
      'blogPost' => $blogPost
    ]);
  }

  public function postEdit($id) {
    $errors = [];
    $result = false;

    if ($this->validatePost()) {
      $blogPost = BlogPost::find($id);
      $blogPost->title = $_POST['title'];
      $blogPost->content = $_POST['content'];
      $blogPost->updated_by = parent::$loggedUser->id;

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
      'loggedUser' => parent::$loggedUser,
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
