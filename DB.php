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
    img_src VARCHAR(60) NULL,
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
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL);';

  $pdo->exec($sql);
}
 ?>
