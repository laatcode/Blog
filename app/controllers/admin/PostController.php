<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogPost;
use Sirius\Validation\Validator;

class PostController extends BaseController {

  public function getIndex() {
    $blogPosts = BlogPost::all();
    return $this->render('admin/posts.twig', ['blogPosts' => $blogPosts]);
  }

  public function getCreate() {
    return $this->render('admin/insert-post.twig');
  }

  public function postCreate() {
    $errors = [];
    $result = false;

    $validator = new Validator();
    $validator->add('title', 'required');
    $validator->add('content', 'required');

    if ($validator->validate($_POST)) {
      $blogPost = new BlogPost([
        'title' => $_POST['title'],
        'content' => $_POST['content']
      ]);

      if ($_FILES['img']) {
        $img_src = "post_images/" . uniqid() . $_FILES['img']['name'];
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
      'errors' => $errors
    ]);
  }

}


 ?>
