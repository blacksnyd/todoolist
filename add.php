<?php
  require_once "config/db.php";

  if($_SERVER["REQUEST_METHOD"] === "POST") {
    $taskTitle = $_POST["taskTitle"] ?? "";
    $taskDesc = $_POST["taskDesc"] ?? "";
    $taskPriority = $_POST["taskPriority"] ?? "";
    $taskDueDate = $_POST["taskDueDate"] ?? "";

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
        <form method="post">
          <label for="taskTitle" class="form-label mt-4">Titre de la tâche :</label>
          <input type="text" class="form-control" id="taskTitle" name="taskTitle" placeholder="Titre de la tâche">
          <label for="taskDesc" class="form-label mt-4">Description de la tâche :</label>
          <textarea class="form-control" id="taskDesc" name="taskDesc"rows="3" placeholder="Description de la tâche"></textarea>
          <label for="taskPriority" class="form-label mt-4">Priorité</label>
          <select class="form-select" name="taskPriority" id="taskPriority">
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
