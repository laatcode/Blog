<?php
$DBHost = 'localhost';
$DBName = 'laatcode';
$DBUser = 'laatcode';
$DBPassword = 'secret';

try {
  $pdo = new PDO("mysql:host=$DBHost;dbname=$DBName", $DBUser, $DBPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  createBlogPostsTable($pdo);
  createUsersTable($pdo);
  createAdminUser($pdo);

  echo "Script ejecutado con éxito";

} catch (\PDOException $e) {
  echo 'PDO Error: ' . $e->getMessage();
} catch (\Exception $e) {
 echo "Error: ".$e->getMessage();
}

function createBlogPostsTable($pdo) {
  $sql = 'CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(60) NOT NULL,
    img_src VARCHAR(80) NULL,
    content TEXT NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL);';

  $pdo->exec($sql);
}

function createUsersTable($pdo) {
  $sql = 'CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(60) NOT NULL,
    email VARCHAR(80) NOT NULL,
    password VARCHAR(120) NOT NULL,
    img_src VARCHAR(80) NULL,
    created_at DATETIME,
    updated_at DATETIME);';

  $pdo->exec($sql);
}

function createAdminUser($pdo) {
  $sql = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';
  $query = $pdo->prepare($sql);
  $result = $query->execute([
    'name' => 'Luis Angel Avila',
    'email' => 'luisangelavilatorres@gmail.com',
    'password' => password_hash('secret', PASSWORD_DEFAULT)
  ]);
}
 ?>
