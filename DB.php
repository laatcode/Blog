<?php
$DBHost = 'localhost';
$DBName = 'laatcode';
$DBUser = 'laatcode';
$DBPassword = 'secret';

try {
  ini_set('date.timezone', 'America/Bogota');

  $pdo = new PDO("mysql:host=$DBHost;dbname=$DBName", $DBUser, $DBPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  createUsersTable($pdo);
  createBlogPostsTable($pdo);
  createCommentsTable($pdo);
  createAdminUser($pdo);

  if (!file_exists('logs')) {
    mkdir('logs', 0777);
  }

  if (!file_exists('images/post_images')) {
    mkdir('images/post_images', 0777, true);
  }

  if (!file_exists('images/profile_images')) {
    mkdir('images/profile_images', 0777, true);
  }

  echo "Script ejecutado con éxito";

} catch (\PDOException $e) {
  if ($e->getCode() == '23000') {
    echo "Script ejecutado con éxito.</br>Usuario inicial ya existe";
  }else {
    echo 'PDO Exception: ' . $e->getMessage();
  }
} catch (\Exception $e) {
 echo "Exception: ".$e->getMessage();
}

function createBlogPostsTable($pdo) {
  $sql = 'CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(60) NOT NULL,
    img_src VARCHAR(80) NULL,
    content TEXT NOT NULL,
    created_at DATETIME NOT NULL,
    created_by INT NOT NULL,
    FOREIGN KEY (created_by) REFERENCES users(id),
    updated_at DATETIME NOT NULL,
    updated_by INT NOT NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id));';

  $pdo->exec($sql);
}

function createUsersTable($pdo) {
  $sql = 'CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(60) NOT NULL,
    email VARCHAR(80) NOT NULL UNIQUE,
    password VARCHAR(120) NOT NULL,
    img_src VARCHAR(80) NULL,
    created_at DATETIME NOT NULL,
    created_by INT NOT NULL,
    FOREIGN KEY (created_by) REFERENCES users(id),
    updated_at DATETIME NOT NULL,
    updated_by INT NOT NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id));';

  $pdo->exec($sql);
}

function createAdminUser($pdo) {
  $datetime = new DateTime();
  $sql = 'INSERT INTO users (name, email, password, created_at, created_by, updated_at, updated_by) VALUES (:name, :email, :password, :created_at, :created_by, :updated_at, :updated_by)';
  $query = $pdo->prepare($sql);
  $result = $query->execute([
    'name' => 'Luis Angel Avila',
    'email' => 'luisangelavilatorres@gmail.com',
    'password' => password_hash('secret', PASSWORD_DEFAULT),
    'img_src' => 'images/profile_images/default.png',
    'created_at' => $datetime->format('Y-m-d H:i:s'),
    'created_by' => 1,
    'updated_at' => $datetime->format('Y-m-d H:i:s'),
    'updated_by' => 1,
  ]);
}

function createCommentsTable($pdo) {
  $sql = 'CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    content TEXT NOT NULL,
    created_by VARCHAR(60) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (post_id) REFERENCES blog_posts(id));';

  $pdo->exec($sql);
}
 ?>
