<?php 
	session_start();
	if(!isset($_SESSION['registered'])){
		header('Location: index.php');
		exit();
	}else{
		unset($_SESSION['registered']);
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


</head>
<body>
	<div class="container">
				<div class="newUsers">
					<h1>Welcome on PlanIT!</h1>
					<div class="newUsersGreeting">We're happy that you're with us. We'll help you organize your days, so that you could be as effective as possible. Click on the button below and log into your account!</div>
					<a id="firstLogin" href="index.php">Log in</a>
				</div>

				<footer>&copy; Damian Horna</footer>
	</div>
</body>
</html>