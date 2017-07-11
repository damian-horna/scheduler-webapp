<?php 
	session_start();
	if(!isset($_SESSION['loggedIn'])){
		header('Location: index.php');
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
	<script type="text/javascript" src="week.js "></script>

</head>
<body>
	<div class="container">

				<div class="sidebar">
					<div class="option"><a href="today.php"><i class="icon-stopwatch"></i><br/>Today</a></div>
					<div class="option"><a href="week.php" style="box-shadow: inset 0 0 30px #000;"><i class="icon-calendar-1"></i><br/>Week</a></div>
					<div class="option"><a href="month.php"><i class="icon-calendar"></i><br/>Month</a></div>
					<div class="option"><a href="notes.php"><i class="icon-edit"></i><br/>Notes</a></div>
					<div class="option"><a href="bills.php"><i class="icon-money"></i><br/>Bills</a></div>
					<div class="option"><a href="settings.php"><i class="icon-cog-alt"></i><br/>Settings</a></div>
				</div>

				<div class="todayContent">
						<h1>Next 7 days</h1>
						<div class="calendar" id="week">

							<div class="day" id=tile0>
								<a class="aweekdays" href=
									<?php  
										$today=new DateTime();  
										echo "\"anyday.php?date=". date_format($today, 'Y-m-d'). "\""; 
									?>>
									<div>Today</div>
									<div class="howManyT">
										<?php 

											function shownrs($today){
												return "
												<i style=\"color: #fc2d2d; font-size: 20px;\" class=\"icon-circle\">" . countTasks("WorkAndSchool",date_format($today, 'Y-m-d')) . "</i><br/>
												<i style=\"color: #7277ff; font-size: 20px;\" class=\"icon-circle\">". countTasks("FamilyAndFriends",date_format($today, 'Y-m-d')). "</i><br/>
												<i style=\"color: #15ff00; font-size: 20px;\" class=\"icon-circle\">". countTasks("Me",date_format($today, 'Y-m-d')). "</i><br/>";
											}
											echo shownrs($today);
										 ?>
									</div>
								</a>
							</div>

							<div class="day" id=tile1><a class="aweekdays" href=
								<?php  
									date_add($today,date_interval_create_from_date_string("1 days"));  
									echo "\"anyday.php?date=". date_format($today, 'Y-m-d'). "\""; 
								?>
								><div>Tomorrow</div><div class="howManyT"><?php echo shownrs($today); ?></div></a>
							</div>

							<?php
							for($i=2; $i<7; $i++){
								date_add($today,date_interval_create_from_date_string("1 days"));
								echo "<div class=\"day\" id=tile". $i. "> <a class=\"aweekdays\" href=\"anyday.php?date=". date_format($today, 'Y-m-d'). "\"><div>". date_format($today, 'l'). "</div><div class=\"howManyT\">". shownrs($today)."</div></a></div>";
							}
							?>
						</div>
				</div>

				<div style="clear:both;"></div>
				<footer>&copy; Damian Horna</footer>
	</div>
</body>
</html>

<?php 
function countTasks($cat,$dat){
require "../planitInclude/dbconnection.php";
$sql="SELECT COUNT(*) FROM tasks WHERE user='". $_SESSION['username'] ."'AND category='". $cat. "' AND date='". $dat. "'" ;
	mysqli_report(MYSQLI_REPORT_STRICT);

	try{//try to connect
		$connection=new mysqli($host,$db_user,$db_password,$db_name);
		if($connection->connect_errno!=0){
			//connection failed
			throw new Exception(mysqli_connect_errno());
		}else{
			//connection succeded
				if($res=@$connection->query($sql)){
					$arr=$res->fetch_array();
					$connection->close();
					return $arr[0];
				}else{
					throw new Exception($connection->error);
				}
			$connection->close();
		}
	}catch(Exception $e){
		echo '<div class="error">Unexpected error occured. Try another time. </div>';
		echo "For developers: ". $e;
	}
}
 ?>