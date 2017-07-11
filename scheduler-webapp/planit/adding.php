<?php 

	session_start();
	require_once "../planitInclude/dbconnection.php";
	if(!isset($_SESSION['loggedIn'])){
		header('Location: index.php');
		exit();
	}

	
	if(isset($_POST['category'])){
		if(($_POST['time']=='') || ($_POST['description']=='')){
			$_SESSION['e_add']='<div class="error">Provide proper time and description.</div>';
		}else{

				$uname=$_SESSION['username'];
				$cat=$_POST['category'];
				$descr=$_POST['description'];
				$descr = htmlentities($descr,ENT_QUOTES,"UTF-8");


				$date=$_SESSION['properDate'];
				$time=$_POST['time'].':00';
				
				$sql="INSERT INTO tasks VALUES(NULL, '$uname', '$cat','$descr','$date','$time')";
				mysqli_report(MYSQLI_REPORT_STRICT);

				try{//try to connect
					$connection=new mysqli($host,$db_user,$db_password,$db_name);
					if($connection->connect_errno!=0){
						//connection failed
						throw new Exception(mysqli_connect_errno());
					}else{
						//connection succeded
							if($connection->query($sql)){
								header('Location: today.php');
							}else{
								throw new Exception($connection->error);
							}
						$connection->close();
					}
				}catch(Exception $e){
					echo '<div class="error">Error while saving new task. Please try again later. </div>';
					echo "For developers: ". $e;
				}
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


</head>
<body>
	<div class="container">

				<div class="sidebar">
					<div class="option"><a href="today.php"><i class="icon-stopwatch"></i><br/>Today</a></div>
					<div class="option"><a href="week.php"><i class="icon-calendar-1"></i><br/>Week</a></div>
					<div class="option"><a href="month.php"><i class="icon-calendar"></i><br/>Month</a></div>
					<div class="option"><a href="notes.php"><i class="icon-edit"></i><br/>Notes</a></div>
					<div class="option"><a href="bills.php"><i class="icon-money"></i><br/>Bills</a></div>
					<div class="option"><a href="settings.php"><i class="icon-cog-alt"></i><br/>Settings</a></div>
				</div>

				<div class="Addingcontent">
					<header>
						<h1>Addition of a new task</h1>
					<header>
					<main>
						<form method="post" id="adding">
								<div class="ad">
								Time:<br/><input type="time" name="time"><br/>
								</div>
								<div class="ad">
								Category:<br/><select name="category">
									<option>Me</option>
									<option>FamilyAndFriends</option>
									<option>WorkAndSchool</option>
								</select><br/>
								</div>
								<div class="ad">
								Description:<br/><textarea name="description"></textarea><br/>
								</div>
								<?php 
									if(isset($_SESSION['e_add'])) {
										echo $_SESSION['e_add'];
										unset($_SESSION['e_add']);
									}
								 ?>
								<input type="submit" name="submit" value="Add">
								
						</form>
					</main>
				</div>
				

				<div style="clear:both;"></div>
				<footer>&copy; Damian Horna</footer>
	</div>
</body>
</html>