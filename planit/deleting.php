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
	<meta name="viewport" content="width=device-width">
	<!-- <script src="dayOfWeek.js"> </script> -->

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

				<div class="todayContent">
						<h1 id="todayyy">
							<?php 
							$date=date('l, j F Y');
							echo $date;
							$date2=date('Y-m-d');
							$_SESSION['properDate'] = $date2;
							 ?>
						</h1>
						<div class="todayMenu">
							<div class="todayopt" id="addopt"> <a href="adding.php"><i class="icon-doc-add"></i></a></div>
							<div class="todayopt" id="editopt"><a href="editing.php"><i class="icon-edit-1"></i></a></div>
							<div class="todayopt" id="deleteopt" style="box-shadow: inset 0 0 40px #c90000;"><a href="deleting.php"><i class="icon-trash-empty"></i></a></div>
						</div>
						<div class="calendar" id="tasks">
							<?php

							

							require_once "../planitInclude/dbconnection.php";
							mysqli_report(MYSQLI_REPORT_STRICT);

							try{//try to connect

								$connection=new mysqli($host,$db_user,$db_password,$db_name);
								if($connection->connect_errno!=0){
									//connection failed
									throw new Exception(mysqli_connect_errno());
								}else{
									$sql="SELECT id, category, task, time FROM tasks WHERE user='". $_SESSION['username']. "' AND date='". $_SESSION['properDate']. "' ORDER BY time";
									if ($res = @$connection->query($sql))
									{
										if ($res->num_rows > 0) {
										    while($row = $res->fetch_assoc()) {
										        echo "<div class=\"deleteme\"><a id=\"todelete\" href=\"deleter.php?id=". $row['id']. "\"> <span style=\"text-align: center;\">".$row['time']. "</span><br/>". $row['task']. "</a></div>";
										    }
										}
										$res->free_result();
									}
								
									$connection->close();
								}

							}catch(Exception $e){
								echo '<div class="error">Error while saving new task. Please try again later. </div>';
								echo "For developers: ". $e;
							}
							?>

							</script>
						</div>

				</div>

				<div style="clear:both;"></div>
				<footer>&copy; Damian Horna</footer>
	</div>
</body>
</html>