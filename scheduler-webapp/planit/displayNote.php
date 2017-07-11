<?php 

	session_start();
	require_once "../planitInclude/dbconnection.php";
	if(!isset($_SESSION['loggedIn'])){
		header('Location: index.php');
		exit();
	}

	$uname=$_SESSION['username'];
		
	$sql="SELECT * FROM notes WHERE id='".$_POST['id']. "'";
	mysqli_report(MYSQLI_REPORT_STRICT);

	try{//try to connect
		$connection=new mysqli($host,$db_user,$db_password,$db_name);
		if($connection->connect_errno!=0){
			//connection failed
			throw new Exception(mysqli_connect_errno());
		}else{
			//connection succeded
			if ($res = @$connection->query($sql))
				{
					if ($res->num_rows > 0) {
					    while($row = $res->fetch_assoc()) {
					    	$_SESSION['currentlyDisplayed'] = $row['id'];
					    	$date = date_format(new Datetime($row['date']),'Y-m-d');
					        echo "<div id=\"Nwrapper\"><div id=\"Ndate\">".$date. "</div><div id=\"Ntitle\">". $row['title']. "</div><div id=\"Ndesc\">".$row['note']."</div><div id=\"Nbtns\"><i id=\"editButton\" class=\"icon-edit-1\" ></i><i id=\"delButton\" class=\"icon-trash-empty\" ></i></div></div>";
					    }
					}
					$res->free_result();
				}else{
					throw new Exception($connection->error);
				}
			$connection->close();
		}
	}catch(Exception $e){
		echo '<div class="error">Error while displaying a new note. Please try again later. </div>';
		echo "For developers: ". $e;
	}
 ?>