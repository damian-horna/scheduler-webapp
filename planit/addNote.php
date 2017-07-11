<?php 

	session_start();
	require_once "../planitInclude/dbconnection.php";
	if(!isset($_SESSION['loggedIn'])){
		header('Location: index.php');
		exit();
	}

	$uname=$_SESSION['username'];
	$descr=$_POST['descr'];
	$descr = htmlentities($descr,ENT_QUOTES,"UTF-8");
	$title=$_POST['title'];
	$title=htmlentities($title,ENT_QUOTES,"UTF-8");

	$date = date_format(new Datetime(), 'Y-m-d H:i:s');
	
	$sql="INSERT INTO notes VALUES(NULL, '$uname', '$title','$descr','$date')";
	mysqli_report(MYSQLI_REPORT_STRICT);

	try{//try to connect
		$connection=new mysqli($host,$db_user,$db_password,$db_name);
		if($connection->connect_errno!=0){
			//connection failed
			throw new Exception(mysqli_connect_errno());
		}else{
			//connection succeded
				if($connection->query($sql)){
					// header('Location: notes.php');
				}else{
					throw new Exception($connection->error);
				}
			$connection->close();
		}
	}catch(Exception $e){
		echo '<div class="error">Error while adding a new note. Please try again later. </div>';
		echo "For developers: ". $e;
	}
 ?>