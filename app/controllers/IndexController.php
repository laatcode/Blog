<?php
namespace App\Controllers;

use App\Models\BlogPost;
use App\Models\User;
use App\Models\Comment;
use Sirius\Validation\Validator;

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

  public function getPost($id) {
    $blogPost = BlogPost::find($id);
    $comments = BlogPost::find($id)->comments;

    if (isset($_SESSION['userId'])) {
      $loggedUser = User::find($_SESSION['userId']);

      return $this->render('post.twig', [
        'blogPost' => $blogPost,
        'comments' => $comments,
        'loggedUser' => $loggedUser
      ]);
    }

    return $this->render('post.twig', [
      'blogPost' => $blogPost,
      'comments' => $comments
    ]);
  }

  public function postPost($postId){
    $errors = [];
    $result = false;

    $validator = new Validator();
    $validator->add('name', 'required');
    $validator->add('content', 'required');

    if ($validator->validate($_POST)) {
      $comment = new Comment();
      $comment->post_id = $postId;
      $comment->content = $_POST['content'];
      $comment->created_by = $_POST['name'];
      $comment->save();
      $result = true;
    }else {
      $errors = $validator->getMessages();
    }

    $blogPost = BlogPost::find($postId);
    $comments = BlogPost::find($postId)->comments;

    if (isset($_SESSION['userId'])) {
      $loggedUser = User::find($_SESSION['userId']);

      return $this->render('post.twig', [
        'blogPost' => $blogPost,
        'comments' => $comments,
        'loggedUser' => $loggedUser,
        'errors' => $errors,
        'result' => $result
      ]);
    }

    return $this->render('post.twig', [
      'blogPost' => $blogPost,
      'comments' => $comments,
      'errors' => $errors,
      'result' => $result
    ]);
  }
}


 ?>
