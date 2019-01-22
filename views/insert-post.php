<?php
$result = false;

if(!empty($_POST)) {
  $sql = 'INSERT INTO blog_posts (title, content) VALUES (:title, :content)';
  $query = $pdo->prepare($sql);
  $result = $query->execute([
    'title' => $_POST['title'],
    'content' => $_POST['content']
  ]);
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Blog</title>
    <link rel="stylesheet" href="../CSS/bootstrap.min.css">
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
          <h2>New Posts</h2>
          <p>
            <a class="btn btn-secondary" href="posts.php">Back</a>
          </p>
          <?php
          if ($result) {
            echo '<div class="alert alert-success">Post Saved!</div>';
          }
          ?>
          <form action="" method="post">
            <div class="form-group">
              <label for="inputTitle">Title</label>
              <input class="form-control" type="text" name="title" id="inputTitle">
            </div>
            <textarea id="inputContent" class="form-control" name="content" rows="5"></textarea>
            <br>
            <input class="btn btn-primary" type="submit" value="Save">
          </form>
        </div>
        <div class="col-md-4">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <footer>
            This is a footer<br>
            <a href="index.php">Admin panel</a>
          </footer>
        </div>
      </div>
    </div>
  </body>
</html>
