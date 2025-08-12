<?php
  require_once "config/db.php";
  session_start();

  $errors = [];

  if($_SERVER["REQUEST_METHOD"] === "POST") {
    $taskTitle = $_POST["taskTitle"] ?? "";
    $taskDesc = $_POST["taskDesc"] ?? "";
    $taskStatus = $_POST["taskStatus"] ?? "";
    $taskPriority = $_POST["taskPriority"] ?? "";
    $taskDueDate = $_POST["taskDueDate"] ?? "";

    if(empty($taskTitle)) {
      $errors[] = "Titre manquant";
    }
    if(empty($taskDesc)) {
      $errors[] = "Description manquante";
    }
    if(empty($taskStatus) || $taskPriority == "status") {
      $errors[] = "Choix du status manquant";
    }
    if(empty($taskPriority) || $taskPriority == "priority") {
      $errors[] = "Choix de priorité manquant";
    }
    if(empty($taskDueDate)) {
      $errors[] = "Date butoire manquante";
    }

    if(empty($errors)) {
      try {
        $pdo = dbLog();
        $userId = $_SESSION["user"]["id"];
        $insert = $pdo->prepare("INSERT INTO tasks(title, description, status, priority, due_date, user_id) VALUES (?, ?, ?, ?, ?, ?)");
        $insert->execute([$taskTitle, $taskDesc, $taskStatus, $taskPriority, $taskDueDate, $userId]);
        header("location: index.php");
        exit();
      } catch (PDOException $e) {
        $errors[] = "Erreur : $e";
      }
    }
  }
  if(!isset($_SESSION["user"])) {
    header("location: login.php");
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
        <h1>Ajouter une tâche</h1>
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
          <label for="taskTitle" class="form-label mt-4">Titre de la tâche :</label>
          <input type="text" class="form-control" id="taskTitle" name="taskTitle" placeholder="Titre de la tâche">
          <label for="taskDesc" class="form-label mt-4">Description de la tâche :</label>
          <textarea class="form-control" id="taskDesc" name="taskDesc"rows="3" placeholder="Description de la tâche"></textarea>
          <label for="taskStatus" class="form-label mt-4">Status</label>
          <select class="form-select" name="taskStatus" id="taskStatus">
            <option value="status">Status</option>
            <option value="à faire">à faire</option>
            <option value="en cours">en cours</option>
            <option value="terminée">terminée</option>
          </select>
          <label for="taskPriority" class="form-label mt-4">Priorité</label>
          <select class="form-select" name="taskPriority" id="taskPriority">
            <option value="priority">Priorité</option>
            <option value="basse">basse</option>
            <option value="moyenne">moyenne</option>
            <option value="haute">haute</option>
          </select>
          <label for="taskDueDate" class="form-label mt-4">Date butoire de la tâche :</label>
          <input type="date" class="form-control" id="taskDueDate" name="taskDueDate" placeholder="Date butoire de la tâche">
          <input type="submit" class="btn btn-primary mt-4" value="Créer"></input>
        </form>
      </div>
    </main>
  </body>
</html>
