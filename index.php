<?php
  require_once "config/db.php";

  $pdo = dbLog();
  $request = $pdo->prepare("SELECT * FROM tasks");
  $request->execute();
  $tasks = $request->fetchAll();

  if(isset($_GET["delete"]) && isset($_GET["id"])) {
    $taskId = $_GET["id"];
    $request = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
    $request->execute([$taskId]);
    header("location: index.php");
    exit();
  }
  if(isset($_GET["filter"]) && isset($_GET["priority"]) ) {
    $priority = $_GET["priority"];
    $request = $pdo->prepare("SELECT * FROM tasks WHERE priority = ?");
    $request->execute([$priority]);
    $fetchAll = $request->fetchAll();
  }
  $displayTasks = (isset($_GET["filter"]) && isset($_GET["priority"])) ? $fetchAll : $tasks;
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
        <h1>Liste des tâches en cours</h1>
        <div class="filter">
          <a href="?filter=1&priority=haute" class="btn btn-danger">Haute</i></a>
          <a href="?filter=1&priority=moyenne" class="btn btn-warning">Moyenne</i></a>
          <a href="?filter=1&priority=basse" class="btn btn-info">Basse</i></a>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Tâche</th>
              <th scope="col">Description</th>
              <th scope="col">Status</th>
              <th scope="col">Priorité</th>
              <th scope="col">À faire avant le</th>
              <th scope="col">Créer le</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($displayTasks as $task) { ?>
                <tr>
                  <td><?= $task["title"] ?></td>
                  <td><?=  substr($task["description"], 0, 20) ?> Voir plus...</td>
                  <td><?= $task["status"] ?></td>
                  <td><?= $task["priority"] ?></td>
                  <td><?= $task["due_date"] ?></td>
                  <td><?= $task["created_at"] ?></td>
                  <td>
                    <div class="table-actions">
                      <a href="?delete=1&id=<?= $task["id"] ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                      <a href="update.php?id=<?= $task["id"] ?>" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
                    </div>
                  </td>
                </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </main>
  </body>
</html>
