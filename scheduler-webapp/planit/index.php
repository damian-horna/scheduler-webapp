<?php 
	session_start();
	if((isset($_SESSION['loggedIn'])) && ($_SESSION['loggedIn']==true)){
		header('Location: welcome.php');
		exit();
	}
 ?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>PlanIT</title>
	<meta name="description" content="Plan your day with our application. Become effective at what you're doing and forget about forgetting!" />
	<meta name="keywords" content="organizer, planner, plan, organize, day, scheduler, schedule" />
	<meta http-equiv="X-UA-Compatibile" content="IE=edge,chrome=1" />
	<link rel="stylesheet" href="css/fontello.css" type="text/css" />
	<link rel="stylesheet" href="style.css" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Lato&amp;subset=latin-ext" rel="stylesheet">
	<meta name="viewport" content="width=device-width">
</head>
<body>
	<div class="container">
		<header>
			<div class="logo">
				PlanIT
			</div>
		</header>
		<main>
			<div class="loginContent">
				<form action="login.php" method="post" class="login">
					<input type="text" name="username" placeholder="Username">
					<input type="password" name="password" placeholder="Password">
					<input type="submit" name="submit" value="Log in">
					<br/>
					<br/>
					<?php 
						if(isset($_SESSION['error'])) echo $_SESSION['error']. "<br/><br/>";
					 ?>
					<div class="registration">Don't have an account? Start today! It's totally free. <a href="register.php">Register here</a></div>
				</form>
			</div>
		</main>
		<footer>&copy; Damian Horna</footer>
	</div>
</body>
</html>