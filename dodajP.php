<?php

	session_start();
	
	if ((!isset($_POST['username'])) || (!isset($_POST['password'])))
	{
		header('Location: logowanie.php');
		exit();
	}

	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		
		$username = htmlentities($username, ENT_QUOTES, "UTF-8");
		$password = htmlentities($password, ENT_QUOTES, "UTF-8");
	
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM users WHERE username='%s' AND password='%s'",
		mysqli_real_escape_string($polaczenie,$username),
		mysqli_real_escape_string($polaczenie,$password))))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$_SESSION['zalogowany'] = true;
				
				$wiersz = $rezultat->fetch_assoc();
				$_SESSION['id'] = $wiersz['id'];
				$_SESSION['username'] = $wiersz['username'];
				$_SESSION['password'] = $wiersz['password'];
				$_SESSION['email']=$wiersz['email'];
				
				
				unset($_SESSION['blad']);
				$rezultat->free_result();
				header('Location: Logowanie.php');
				
			} else {
				
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: logowanie.php');
				
			}
			
		}
		
		$polaczenie->close();
	}
	
?>