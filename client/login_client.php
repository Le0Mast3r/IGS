<?php
require '../db.php';
session_start();


$email = $password = $password2 = $errors = "";

if (isset($_POST['submit'])) {
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	$password2 = md5($password);

	$sql_check = "SELECT * FROM t_client WHERE email = '$email' AND mot_de_passe = '$password2' LIMIT 1";
	$result_check = mysqli_query($conn, $sql_check);
	$client = mysqli_fetch_assoc($result_check);

	if (!empty($_POST['email']) && !empty($_POST['password'])) {
		if (strlen($password) >= 8) {
			if ($client) {
				if (strcmp($password2, $client['mot_de_passe']) == 0) {

					$_SESSION['email'] = $email;
					header('location: dashboard_client.php');
				} else {
					$errors = "mot de passe incorrecte!";
				}
			} else {
				$errors = "email ou mot de passe est incorrecte!";
			}
		} else {
			$errors = "le mot de passe doit comporter 8 caractères de plus!";
		}
	} else {
		$errors = "L'email et le mot de passe sont requis!";
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
	<link rel="stylesheet" href="../style.css" />
	<title>Login IGS</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>


	<div class="container">
		<!-- <img class="wave" src="../img/wave.png"> -->
		<div class="img">
			<img src="../img/bg.svg">
		</div>
		<div class="login-content">
			<form action="login_client.php" method="POST">
				<img src="../img/avatar.svg">
				<div class="mt-4">
					<h4 class="title">S'identifier</h4>
				</div>

				<?php if ($errors != "") : ?>
					<div class="alert alert-danger alert-dismissible fade show error-alert" role="alert">
						<?php echo $errors; ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif; ?>

				<div class="input-div one">
					<div class="i">
						<i class="fas fa-user"></i>
					</div>
					<div class="div">
						<h5>email</h5>
						<input type="email" name="email" class="input" />

					</div>
				</div>
				<div class="input-div pass">
					<div class="i">
						<i class="fas fa-lock"></i>
					</div>
					<div class="div">
						<h5>Mot de passe</h5>
						<input type="password" name="password" class="input" />

					</div>
				</div>
				<a href="#">Mot de passe oublié?</a>
				<button class="btn" name="submit" type="submit">S'identifier</button>



			</form>
		</div>

		<nav class="navbar navbar-expand-lg fixed-top">

			<div class="w-3">
				<a href="../index.php">
				<img class="" id="brand-image" src="../img/igs.jpg" alt="" style="margin-top: 1px; height:1%; width:5%; float:left;">
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
						<a class="nav-link" href="../choix_user.php">Mon Compte</a>
					</li>

				</ul>
			</div>
		</nav>
	</div>





	<script type="text/javascript" src="../js/main.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>