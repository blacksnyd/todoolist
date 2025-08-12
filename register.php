<?php
  require_once "config/db.php";
  session_start();

  $errors = [];

  if($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = htmlspecialchars(trim($_POST["username"])) ?? "";
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirmPassword"] ?? "";

    if(empty($username)) {
      $errors[] = "Pseudo manquant";
    }
    if(empty($password)) {
      $errors[] = "Mot de passe manquant";
    }
    if ($password !== $confirmPassword) {
      $errors[] = "Les mots de passes ne correspondent pas";
    }

    if(empty($errors)) {
      try {
        $pdo = dbLog();
        $check = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $check->execute([$username]);
        if($check->rowCount() > 0) {
          $errors[] = "Pseudo déjà pris";
        } else {
          $hashPassword = password_hash($password, PASSWORD_DEFAULT);
          $insert = $pdo->prepare("INSERT INTO users(username, password) VALUES (?,?)");
          $insert->execute([$username, $hashPassword]);
          $errors[] = "Inscription réussie";
        }
      } catch (PDOException $e) {
        $errors[] = "Erreur : $e";
      }
    }
  }
  if(isset($_SESSION["user"])) {
    header("location: index.php");
    exit();
  }
?>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TodooList</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.2/css/all.css">
    <link rel="stylesheet" href="https://bootswatch.com/5/sketchy/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous" defer></script>

  </head>
  <body>
    <?php include "includes/header.php" ?>
    <main>
      <div class="content">
        <h1>S'inscrire</h1>
        <?php if (!empty($errors)) { ?>
          <div class="alert alert-dismissible alert-danger">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <h4 class="alert-heading">Attention !</h4>
            <?php foreach ($errors as $error) { ?>
                <?= $error ?><br>
            <?php } ?>
          </div>
        <?php } ?>
        <form method="post">
          <label for="username" class="form-label mt-4">Pseudo :</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Titre de la tâche">
          <label for="password" class="form-label mt-4">Mot de passe :</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Titre de la tâche">
          <label for="confirmPassword" class="form-label mt-4">Mot de passe :</label>
          <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Titre de la tâche">

          <input type="submit" class="btn btn-primary mt-4" value="S'inscrire"></input>
        </form>
      </div>
    </main>
  </body>
</html>
