<?php
namespace App\Controllers;

class IndexController extends BaseController {

  public function getIndex() {
    // La palabra global permite tomar una variable del scope superior
    global $pdo;

    $query = $pdo->prepare("SELECT * from blog_posts ORDER BY id DESC");
    $query->execute();

    $blogPosts = $query->fetchAll(\PDO::FETCH_ASSOC);
    return $this->render('index.twig', ['blogPosts' => $blogPosts]);
  }

}


 ?>
