<?php
namespace App\Controllers;

use App\Models\BlogPost;
use App\Models\User;
use App\Models\Comment;
use Sirius\Validation\Validator;

class IndexController extends BaseController {

  public function getIndex() {
    $blogPosts = BlogPost::query()->orderBy('id', 'desc')->get();

    return $this->render('index.twig', [
      'blogPosts' => $blogPosts,
      'loggedUser' => parent::$loggedUser
    ]);
  }

  public function getPost($id) {
    $blogPost = BlogPost::find($id);
    $comments = BlogPost::find($id)->comments;

    return $this->render('post.twig', [
      'blogPost' => $blogPost,
      'comments' => $comments,
      'loggedUser' => parent::$loggedUser
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

    return $this->render('post.twig', [
      'blogPost' => $blogPost,
      'comments' => $comments,
      'loggedUser' => parent::$loggedUser,
      'errors' => $errors,
      'result' => $result
    ]);
  }

  public function getProfile($id) {
    $user = User::find($id);


    return $this->render('profile.twig', [
      'user' => $user,
      'blogPosts' => $user->posts,
      'loggedUser' => parent::$loggedUser
    ]);
  }
}
 ?>
