<?php 

	session_start();


	if((!isset($_POST['username'])) || (!isset($_POST['password']))){
		header('Location: index.php');
		exit();
	}

	require_once "../planitInclude/dbconnection.php";

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);

	if($connection->connect_errno!=0){
		echo "Error: ". $connection->connect_errno;
	}
	else{

		$username=$_POST['username'];
		$password=$_POST['password'];

		$username = htmlentities($username,ENT_QUOTES,"UTF-8");
		// $password = htmlentities($password ,ENT_QUOTES,"UTF-8");

		// $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";

		if($result = @$connection->query(sprintf("SELECT * FROM users WHERE username='%s'",mysqli_real_escape_string($connection,$username)))){

			if($result->num_rows==1){

				$row = $result->fetch_assoc();
				if(password_verify($password, $row['password'])){

					$_SESSION['loggedIn']=true;
					
					$_SESSION['username'] = $row['username'];
					$_SESSION['id']=$row['id'];

					unset($_SESSION['error']);

					$result->free_result();
					header('Location: welcome.php');
				}
				else{

				$_SESSION['error']="<span style=\"color:red;\">Wrong login or password!</span>";

				header('Location: index.php');

			}
			} 
			else{

				$_SESSION['error']="<span style=\"color: red;\">Wrong login or password!</span>";

				header('Location: index.php');

			}
		}

		$connection->close();
	}

?>