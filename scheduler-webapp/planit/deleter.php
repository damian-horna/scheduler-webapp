<?php 
	session_start();
	require_once "../planitInclude/dbconnection.php";
	if(!isset($_SESSION['loggedIn'])){
		header('Location: index.php');
		exit();
	}
	
	$sql="DELETE FROM tasks WHERE id='". $_GET['id']. "'";
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
			
 ?>