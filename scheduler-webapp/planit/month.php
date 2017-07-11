<?php 
	session_start();
	if(!isset($_SESSION['loggedIn'])){
		header('Location: index.php');
		exit();
	}

	function shownrs($today){
		return 
		countTasks("WorkAndSchool",date_format($today, 'Y-m-d'));
	}

	function countTasks($cat,$dat){
		require "../planitInclude/dbconnection.php";
		$sql="SELECT COUNT(*) FROM tasks WHERE user='". $_SESSION['username'] ."' AND date='". $dat. "'" ;
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
				echo '<div class="error">Unexpeced error occured. Try another time. </div>';
				echo "For developers: ". $e;
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
	<script src="calendar.js"></script>

</head>
<body>
	<div class="container">

				<div class="sidebar">
					<div class="option"><a href="today.php"><i class="icon-stopwatch"></i><br/>Today</a></div>
					<div class="option"><a href="week.php"><i class="icon-calendar-1"></i><br/>Week</a></div>
					<div class="option"><a href="month.php" style="box-shadow: inset 0 0 30px #000;"><i class="icon-calendar"></i><br/>Month</a></div>
					<div class="option"><a href="notes.php"><i class="icon-edit"></i><br/>Notes</a></div>
					<div class="option"><a href="bills.php"><i class="icon-money"></i><br/>Bills</a></div>
					<div class="option"><a href="settings.php"><i class="icon-cog-alt"></i><br/>Settings</a></div>
				</div>

				<div class="todayContent">
						<h1 id="monthName" style="padding-bottom: 10px;">
							<?php  
							echo date('F Y');
							?>
						</h1>
						<div id="calendarMonth">
							<?php 

								$month = date('m');
								$month_bef=$month-1;
								$year = date('Y');
								$howManyDays = cal_days_in_month(CAL_GREGORIAN,$month ,$year);
								$bef= cal_days_in_month(CAL_GREGORIAN,$month_bef ,$year);
								$whatdate=new DateTime($year. '-'. $month. '-01');
								$no_first_day_of_month=date('N', strtotime('1-'.$month.'-'. $year));

								echo <<<END
								<div class="daywrapper">
								<div class="daycal">Monday</div>
								<div class="daycal">Tuesday</div>
								<div class="daycal">Wednesday</div>
								<div class="daycal">Thursday</div>
								<div class="daycal">Friday</div>
								<div class="daycal">Saturday</div>
								<div class="daycal">Sunday</div>
								</div>
END;

								for($j=$bef-($no_first_day_of_month-2); $j<=$bef; $j++){
									echo "<div class=\"dayOff\"><a class=\"amonthdaysoff\">
												<div style=\"font-size: 30px; padding-top: 20%;\">".$j. "
												</div>
											</a></div>";
								}
								for($i=1; $i<=$howManyDays; $i++){
									echo "<div class=\"day1\" id=\"block". $i. "\">
											<a class=\"amonthdays\" href=\"anyday.php?date=". date_format($whatdate, 'Y-m-d'). "\">
												<div style=\"font-size: 30px; padding-top: 20%;\">".$i. "
												</div>
											</a>
										</div>";
										date_add($whatdate,date_interval_create_from_date_string("1 days"));
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

 ?>