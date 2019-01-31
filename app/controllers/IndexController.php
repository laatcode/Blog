<?php
namespace App\Controllers;

use App\Models\BlogPost;

class IndexController extends BaseController {

  public function getIndex() {

    $blogPosts = BlogPost::query()->orderBy('id', 'desc')->get();

    if (isset($_SESSION['userId'])) {
      return $this->render('index.twig', [
        'blogPosts' => $blogPosts,
        'userId' => $_SESSION['userId']
      ]);
    }
    
    return $this->render('index.twig', [
      'blogPosts' => $blogPosts
    ]);
  }

  public function getPost() {
    $blogPost = BlogPost::where('id', $_GET['id'])->first();

    return $this->render('post.twig', [
      'blogPost' => $blogPost
    ]);
  }

}


 ?>
