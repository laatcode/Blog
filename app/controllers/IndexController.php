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

      if (isset($_SESSION['userId'])) {
        $comment->created_by = parent::$loggedUser->id;
        $comment->created_by_name = parent::$loggedUser->name;
      }else {
        $comment->created_by_name = $_POST['name'];
      }

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

  public function getNew_editor() {
    return $this->render('admin/insert-user.twig');
  }

  public function postNew_editor() {
    $errors = [];
    $result = false;

    $validator = new Validator();
    $validator->add('name', 'required');
    $validator->add('email', 'required');
    $validator->add('email', 'email');
    $validator->add('password', 'required');

    if ($validator->validate($_POST)) {
      $user = new User();
      $user->user_role = 2;
      $user->name = $_POST['name'];
      $user->email = $_POST['email'];
      $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $user->created_by = 1;
      $user->updated_by = 1;

      if ($_FILES['img']['name']) {
        $img_src = "images/profile_images/" . uniqid() . $_FILES['img']['name'];
        move_uploaded_file($_FILES['img']['tmp_name'], $img_src);
        $user->img_src = $img_src;
      }else {
        $user->img_src = 'images/profile_images/default.png';
      }

      $user->save();
      $user->created_by = $user->id;
      $user->updated_by = $user->id;
      $user->save();
      $result = true;
    }else {
      $errors = $validator->getMessages();
    }

    return $this->render('admin/insert-user.twig', [
      'result' => $result,
      'errors' => $errors
    ]);
  }
}
 ?>
