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
    created_by INT NOT NULL,
    FOREIGN KEY (created_by) REFERENCES users(id),
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
    created_at DATETIME NOT NULL,
    created_by INT NOT NULL,
    updated_at DATETIME NOT NULL);';

  $pdo->exec($sql);
}

function createAdminUser($pdo) {
  $datetime = new DateTime();
  $sql = 'INSERT INTO users (name, email, password, created_at, created_by, updated_at) VALUES (:name, :email, :password, :created_at, :created_by, :updated_at)';
  $query = $pdo->prepare($sql);
  $result = $query->execute([
    'name' => 'Luis Angel Avila',
    'email' => 'luisangelavilatorres@gmail.com',
    'password' => password_hash('secret', PASSWORD_DEFAULT),
    'created_at' => $datetime->format('Y-m-d H:i:s'),
    'created_by' => 1,
    'updated_at' => $datetime->format('Y-m-d H:i:s')
  ]);
}
 ?>
