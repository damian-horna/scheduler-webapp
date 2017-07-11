<?php 

session_start();

if(isset($_POST['email'])){
//Validation successful? Assume so
	$alrighty=true;

//login
$login = $_POST['login'];

//length of login
if(strlen($login)<3){
	$alrighty=false;
	$_SESSION['errorLogin'] = "Login should contain more than 2 characters.";
}elseif (strlen($login)>20) {
	$alrighty=false;
	$_SESSION['errorLogin'] = "Login should contain less than 21 characters.";
}

//alphanumeric?
if(ctype_alnum($login)==false){
	$alrighty=false;
	$_SESSION['errorLogin'] = "Login should contain only letters and digits.";
}

//email sanitization and validation
$email=$_POST['email'];
$email2=filter_var($email,FILTER_SANITIZE_EMAIL);
if(!(filter_var($email2,FILTER_SANITIZE_EMAIL)) || $email != $email2){
	$alrighty=false;
	$_SESSION['errorEmail']="Wrong e-mail adress.";
}

//password validation
$pass1=$_POST['password1'];
$pass2=$_POST['password2'];

//length of password
if(strlen($pass1)<8){
	$alrighty=false;
	$_SESSION['errorPassword']="Password should contain more than 7 characters.";
}elseif(strlen($pass1)>20){
	$alrighty=false;
	$_SESSION['errorPassword']="Password should contain less than 21 characters.";
}

//are both passwords the same?
if($pass1!=$pass2){
	$alrighty=false;
	$_SESSION['errorPassword']="Given passwords are different.";
}


//hashing the password
$hashedPass = password_hash($pass1, PASSWORD_DEFAULT);

//agreement
if(!isset($_POST['agreement'])){
	$alrighty=false;
	$_SESSION['errorAgreement']="Accept the terms of service.";
}

//CAPTCHA
$secretKey="6LcyBygUAAAAAOS6xnE_duNGXnAUiKjQSLbjQPJC";
$verification=file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='. $secretKey. '&response='. $_POST['g-recaptcha-response']);

$resp=json_decode($verification);

//captcha failed
if($resp->success==false){
	$alrighty=false;
	$_SESSION['errorCaptcha']="Prove that you're not a robot.";
}

//connecting to db in order to look for particular user
require_once "../planitInclude/dbconnection.php";
mysqli_report(MYSQLI_REPORT_STRICT);

try{//try to connect

	$connection=new mysqli($host,$db_user,$db_password,$db_name);
	if($connection->connect_errno!=0){
		//connection failed
		throw new Exception(mysqli_connect_errno());
	}else{
		//connection succeded
		//only one mail for one account
		$result = $connection->query("SELECT id FROM users WHERE email='$email'");

		//no email
		if(!($result)) throw new Exception($connection->error);
		//at least one
		$howManyEmails=$result->num_rows;
		if($howManyEmails>0){
			$alrighty=false;
			$_SESSION['errorEmail']="Given email is already in use.";
		}

		//unique username
		$result = $connection->query("SELECT id FROM users WHERE username='$login'");

		//no username
		if(!($result)) throw new Exception($connection->error);
		//at least one
		$howManyLogins=$result->num_rows;
		if($howManyLogins>0){
			$alrighty=false;
			$_SESSION['errorLogin']="Given login is already in use.";
		}

		if($alrighty){
			//every test passed
			if($connection->query("INSERT INTO users VALUES(NULL, '$login','$hashedPass','$email')")){
				$_SESSION['registered']=true;
				header('Location: welcomenew.php');
			}else{
				throw new Exception($connection->error);
			}
		}

		$connection->close();
	}

}catch(Exception $e){
	echo '<div class="error">An error has occured. Try to register later. </div>';
	// echo "For developers: ". $e;
}
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
	<script src='https://www.google.com/recaptcha/api.js'></script>
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
				<form class="registrationForm" method="post">
					<input type="text" name="login" placeholder="Login">
					<?php 
					if(isset($_SESSION['errorLogin'])){
						echo '<div class="error">'. $_SESSION['errorLogin']. '</div>';
						unset($_SESSION['errorLogin']);
					}
					 ?>
					<input type="text" name="email" placeholder="E-mail">
					<?php 
					if(isset($_SESSION['errorEmail'])){
						echo '<div class="error">'. $_SESSION['errorEmail']. '</div>';
						unset($_SESSION['errorEmail']);
					}
					 ?>
					<input type="password" name="password1" placeholder="Password">
					<?php 
					if(isset($_SESSION['errorPassword'])){
						echo '<div class="error">'. $_SESSION['errorPassword']. '</div>';
						unset($_SESSION['errorPassword']);
					}
					 ?>
					<input type="password" name="password2" placeholder="Confirm your password">
					<div id="rulez">
					<input type="checkbox" name="agreement"> I accept the <a href="#" style="display: inline;">terms of service</a>
					</div>
					<?php 
					if(isset($_SESSION['errorAgreement'])){
						echo '<div class="error">'. $_SESSION['errorAgreement']. '</div>';
						unset($_SESSION['errorAgreement']);
					}
					 ?>
					<div class="g-recaptcha" data-sitekey="6LcyBygUAAAAALQi0RZR3dhA_lAIz0L_2cgs0X1Z"></div>
					<?php 
					if(isset($_SESSION['errorCaptcha'])){
						echo '<div class="error">'. $_SESSION['errorCaptcha']. '</div>';
						unset($_SESSION['errorCaptcha']);
					}
					 ?>
					<input type="submit" name="submit" value="Sign up">
				</form>
			</div>
		</main>
		<footer>&copy; Damian Horna</footer>
	</div>
</body>
</html>