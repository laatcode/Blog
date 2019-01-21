<?php
$query = $pdo->prepare("SELECT * from blog_posts ORDER BY id DESC");
$query->execute();

$blog_posts = $query->fetchAll(PDO::FETCH_ASSOC);
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Blog</title>
    <link rel="stylesheet" href="CSS/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1>Blog Title</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8">
          <?php foreach ($blog_posts as $blog_post){
            echo '<div class="blog-post">';
              echo "<h2>" . $blog_post['title'] . "</h2>";
              echo '<p>Jan 19, 2019 by <a href="#">Alex</a></p>';
              echo '<div class="blog-post-image">';
                echo '<img src="images/Keyboard.png" alt="image">';
              echo '</div>';
              echo '<div class="blog-post-content">';
                echo $blog_post['content'];
              echo "</div>";
            echo "</div>";
          }
          ?>
        </div>
        <div class="col-md-4">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <footer>
            This is a footer<br>
            <a href="admin/index.php">Admin panel</a>
          </footer>
        </div>
      </div>
    </div>
  </body>
</html>
