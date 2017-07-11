<?php 

	session_start();
	require_once "../planitInclude/dbconnection.php";
	if(!isset($_SESSION['loggedIn'])){
		header('Location: index.php');
		exit();
	}

	
	if(isset($_POST['category'])){
		if(($_POST['time']=='') || ($_POST['description']=='')){
			$_SESSION['e_edit']='<div class="error">Provide proper time and description.</div>';
		}else{

				$uname=$_SESSION['username'];
				$cat=$_POST['category'];
				$descr=$_POST['description'];
				$descr = htmlentities($descr,ENT_QUOTES,"UTF-8");


				$date=$_GET['date'];
				$time=$_POST['time'].':00';
				
				$sql="UPDATE tasks SET task='". $descr. "', time='". $_POST['time']. ":00', category='". $_POST['category']. "' WHERE id='". $_GET['id']. "'";
				mysqli_report(MYSQLI_REPORT_STRICT);

				try{//try to connect
					$connection=new mysqli($host,$db_user,$db_password,$db_name);
					if($connection->connect_errno!=0){
						//connection failed
						throw new Exception(mysqli_connect_errno());
					}else{
						//connection succeded
							if($connection->query($sql)){
								header('Location: anyday.php?date='. $date);
							}else{
								throw new Exception($connection->error);
							}
						$connection->close();
					}
				}catch(Exception $e){
					echo '<div class="error">Error while saving new task. Please try again later. </div>';
					echo "<div style=\"color: #ffffff;\">For developers: ". $e. "</div>";
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
						<h1>Edition</h1>
					<header>
					<main>
						<form method="post" id="adding">
								<div class="ad">
								Time:<br/><input type="time" name="time" value=<?php echo $_GET['time']; ?>><br/>
								</div>
								<div class="ad">
								Category:<br/><select name="category">
									<option>Me</option>
									<option>FamilyAndFriends</option>
									<option>WorkAndSchool</option>
								</select><br/>
								</div>
								<div class="ad">
								Description:<br/><textarea name="description"><?php echo $_GET['desc']; ?></textarea><br/>
								</div>
								<?php 
									if(isset($_SESSION['e_edit'])) {
										echo $_SESSION['e_edit'];
										unset($_SESSION['e_edit']);
									}
								 ?>
								<input type="submit" name="submit" value="Save">
								
						</form>
					</main>
				</div>
				

				<div style="clear:both;"></div>
				<footer>&copy; Damian Horna</footer>
	</div>
</body>
</html>