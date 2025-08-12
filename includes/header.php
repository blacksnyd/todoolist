<header>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">TodooList</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor04" aria-controls="navbarColor04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarColor04">
        <ul class="navbar-nav me-auto">
          <?php if(isset($_SESSION["user"])) { ?>
            <li class="nav-item">
              <a class="nav-link" href="index.php">Mes tâches</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="add.php">Ajouter une tâche</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?logout">Déconnexion</a>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Se connecter</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="register.php">S'inscrire</a>
            </li>
          <?php } ?>
        </ul>
    </div>
  </nav>
</header>
<?php
  if(isset($_GET["logout"])) {
    unset($_SESSION["username"]);
    session_destroy();
    $_SESSION["errors"][] = "Vous avez été déconnecté";
    header("location: login.php");
    exit();
  }
