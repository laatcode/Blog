<?php
namespace App\Controllers;

use App\Models\BlogPost;
use App\Models\User;

class IndexController extends BaseController {

  public function getIndex() {

    $blogPosts = BlogPost::query()->orderBy('id', 'desc')->get();

    if (isset($_SESSION['userId'])) {
      $loggedUser = User::find($_SESSION['userId']);

      return $this->render('index.twig', [
        'blogPosts' => $blogPosts,
        'loggedUser' => $loggedUser
      ]);
    }

    return $this->render('index.twig', [
      'blogPosts' => $blogPosts
    ]);
  }

  public function getPost() {
    $blogPost = BlogPost::find($_GET['id']);

    if (isset($_SESSION['userId'])) {
      $loggedUser = User::find($_SESSION['userId']);

      return $this->render('post.twig', [
        'blogPost' => $blogPost,
        'loggedUser' => $loggedUser
      ]);
    }

    return $this->render('post.twig', [
      'blogPost' => $blogPost
    ]);
  }
}


 ?>
