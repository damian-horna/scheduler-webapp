<?php 
session_start();
require "../planitInclude/dbconnection.php";
if(!isset($_SESSION['loggedIn'])){
		header('Location: index.php');
		exit();
	}

if($_POST['search']==""){
	
	mysqli_report(MYSQLI_REPORT_STRICT);

	try{//try to connect

		$connection=new mysqli($host,$db_user,$db_password,$db_name);
		if($connection->connect_errno!=0){
			//connection failed
			throw new Exception(mysqli_connect_errno());
		}else{
			$sql="SELECT id, title FROM notes WHERE user='". $_SESSION['username']. "' ORDER BY date";
			if ($res = @$connection->query($sql))
			{
				if ($res->num_rows > 0) {
				    while($row = $res->fetch_assoc()) {
				        echo "<div class=\"note\" style=\"cursor: pointer;\" id=\"". $row['id'] ."\">". $row['title']."</div>";
				    }
				}
				$res->free_result();
			}
		
			$connection->close();
		}

	}catch(Exception $e){
		echo '<div class="error">Error while loading notes. Please try again later. </div>';
		echo "For developers: ". $e;
	}							
}else{
	try{//try to connect

		$connection=new mysqli($host,$db_user,$db_password,$db_name);
		if($connection->connect_errno!=0){
			//connection failed
			throw new Exception(mysqli_connect_errno());
		}else{
			$descr = $_POST['search'];
			$descr = htmlentities($descr,ENT_QUOTES,"UTF-8");
			$sql="SELECT id, title FROM notes WHERE user='". $_SESSION['username']. "' AND ( note LIKE '%".$descr."%' OR title LIKE '%". $descr. "%' ) ORDER BY date";
			if ($res = @$connection->query($sql))
			{
				if ($res->num_rows > 0) {
				    while($row = $res->fetch_assoc()) {
				        echo "<div class=\"note\" style=\"cursor: pointer;\" id=\"". $row['id'] ."\">". $row['title']."</div>";
				    }
				}
				$res->free_result();
			}
		
			$connection->close();
		}

	}catch(Exception $e){
		echo '<div class="error">Error while loading notes. Please try again later. </div>';
		echo "For developers: ". $e;
	}				
}

 ?>