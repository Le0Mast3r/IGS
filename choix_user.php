<?php
include './db.php';
session_start();
if (isset($_SESSION['email'])) {
  $email = $_SESSION['email'];
}
if (isset($_SESSION['email'])) {
  $sql = "SELECT email FROM t_employeur WHERE email='$email' LIMIT 1";
  $sql_fetch = mysqli_fetch_assoc(mysqli_query($conn, $sql));
  if ($sql_fetch) {
    header('location:./employeur/dashboard_employeur.php');
    exit();
  }

  $sql_2 = "SELECT email FROM t_employe WHERE email='$email' LIMIT 1";
  $sql_fetch_2 = mysqli_fetch_assoc(mysqli_query($conn, $sql_2));
  if ($sql_fetch_2) {
    header('location:./employe/dashboard_employe.php');
    exit();
  }

  $sql_3 = "SELECT email FROM t_client WHERE email='$email' LIMIT 1";
  $sql_fetch_3 = mysqli_fetch_assoc(mysqli_query($conn, $sql_3));
  if ($sql_fetch_3) {
    header('location:./client/dashboard_client.php');
    exit();
  }
}



?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="./style.css" />
  <title>Login IGS</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a81368914c.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>


  <div class="container">
    <!-- <img class="wave" src="img/wave.png"> -->
    <div class="img">
      <img src="img/bg.svg">
    </div>
    <div class="login-content">
      <form action="index.php">
        <img src="img/avatar.svg">
        <div class="mt-3">
          <h6 class="title">êtes-vous un employé, un employeur ou un client ?</h6>
        </div>


        <a href="./employeur/login_employeur.php" type="submit" class="btn">EMPLOYEUR</a>
        <a href="./employe/login_employe.php" type="submit" class="btn">EMPLOYÉ</a>
        <a href="./client/login_client.php" type="submit" class="btn">CLIENT</a>
        


      </form>
    </div>

    <nav class="navbar navbar-expand-lg fixed-top">
      <div class="w-3">
        <a href="./index.php">
          <img class="" id="brand-image" src="./img/igs.jpg" alt="" style="margin-top: 1px; height:1%; width:5%; float:left;">
        </a>
      </div>

      <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">

        <span class="navbar-toggler-icon">
          <i class="fa fa-bars"></i>
        </span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavId">
        <ul class="nav">

          <li class="nav-item">
            <a class="nav-link" href="./choix_user.php">Mon Compte</a>
          </li>

        </ul>
      </div>
    </nav>
  </div>


  <script type="text/javascript" src="js/main.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>