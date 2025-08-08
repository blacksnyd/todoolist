<?php
function dbLog() {
  $host = "localhost";
  $dbname = "todoolist";
  $user = "root";
  $password = "root";
  $port = "8889";
  $charset = "utf8mb4";

  try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset;port=$port";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;

  } catch (PDOException $e) {
    die("Erreur de connexion à la db :".$e->getMessage());
  }
}
