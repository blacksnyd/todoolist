<?php
  require_once "config/db.php";

  $pdo = dbLog();
  $taskId =  $_GET["id"];
  $request = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
  $request->execute([$taskId]);
  $task = $request->fetch();
  var_dump($task);
