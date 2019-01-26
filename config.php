<?php
$DBHost = 'localhost';
$DBName = 'dbtest';
$DBUser = 'dbtest';
$DBPassword = 'secret';

try {
  $pdo = new PDO("mysql:host=$DBHost;dbname=$DBName", $DBUser, $DBPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = 'CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(45) NULL,
    content VARCHAR(45) NULL);';
    $pdo->exec($sql);

} catch (\PDOException $e) {
  echo 'Error escrito: ' . $e->getMessage();
} catch (\Exception $e) {
 echo "General Error: ".$e->getMessage();
}

function createTable($pdo) {
  try {
    $sql = 'CREATE TABLE IF NOT EXISTS blog_posts (
      id INT AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(45) NULL,
      content VARCHAR(45) NULL);';
      $pdo->exec($sql);
  } catch (\Exception $e){
    echo $e.getMessage();
  }
}
 ?>
