<?php
  require_once "config/db.php";
  session_start();

  $pdo = dbLog();
  $request = $pdo->prepare("SELECT * FROM tasks JOIN users ON tasks.user_id = users.id");
  $request->execute();
  $tasks = $request->fetchAll();

  if(isset($_GET["delete"]) && isset($_GET["id"])) {
    $taskId = $_GET["id"];
    $request = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
    $request->execute([$taskId]);
    header("location: index.php");
    exit();
  }
  if(isset($_GET["priority"]) ) {
    $priority = $_GET["priority"];
    $request = $pdo->prepare("SELECT * FROM tasks JOIN users ON tasks.user_id = users.id WHERE priority = ?");
    $request->execute([$priority]);
    $fetchAll = $request->fetchAll();
  }
  $displayTasks = (isset($_GET["priority"])) ? $fetchAll : $tasks;
?>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TodooList</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.2/css/all.css">
    <link rel="stylesheet" href="https://bootswatch.com/5/sketchy/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous" defer></script>

  </head>
  <body>
    <?php include "includes/header.php" ?>
    <main>
      <div class="content">
        <h1>Liste des tâches en cours</h1>
        <div class="filter">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Filtres</a>
          <div class="dropdown-menu" style="">
            <a class="dropdown-item" href="?priority=haute">Haute</a>
            <a class="dropdown-item" href="?priority=moyenne">Moyenne</a>
            <a class="dropdown-item" href="?priority=basse">Basse</a>
          </div>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Tâche</th>
              <th scope="col">Description</th>
              <th scope="col">Status</th>
              <th scope="col">Priorité</th>
              <th scope="col">À faire avant le</th>
              <th scope="col">Créer par</th>
              <th scope="col">Créer le</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($displayTasks as $task) { ?>
              <tr>
                <td><?= $task["title"] ?></td>
                <?php include "includes/modal_desc.php"; ?>
                <td><?= htmlspecialchars(substr($task["description"], 0, 40)) ?>...<a href="" class="text-info" data-toggle="modal" data-target="#<?= $task['id'] ?>">Voir plus</a></td>
                <td><?= htmlspecialchars($task["status"]) ?></td>
                <td><?= htmlspecialchars($task["priority"]) ?></td>
                <td><?= htmlspecialchars($task["due_date"]) ?></td>
                <td><?= htmlspecialchars($task["username"]) ?></td>
                <td><?= htmlspecialchars($task["created_at"]) ?></td>
                <td>
                  <div class="table-actions">
                    <a href="?delete=1&id=<?= $task["id"] ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                    <a href="update.php?id=<?= $task["id"] ?>" class="btn btn-info" onClick="alert('mon texte');"><i class="fa-solid fa-pen-to-square"></i></a>
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
