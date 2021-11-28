<?php

	session_start();
	
	if(isset($_POST['email'])){
		
		$wszystko_OK=true;
		
		$username = $_POST['username'];
		
		if((strlen($username))<3 || (strlen($username)>15)){
			$wszystko_OK = false;
			$_SESSION['e_username']="Imie musi posiadać od 3 do 15 znaków.";
		}
		
	if(ctype_alnum($username)==false){
		
		$wszystko_OK=false;
		$_SESSION['e_username']="Imie musi składać się tylko z liter.";
		
	}
	
	$email = $_POST['email'];
	$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
	
	if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email)){
		
		$wszystko_OK=false;
		$_SESSION['e_email']="Niepoprawny adres email";		
	}
	
	$password = $_POST['password'];
	
	if((strlen($password))<8 || (strlen($password)>20)){
		
		$wszystko_OK=false;
		$_SESSION['e_password']="Długość hasła powinna znajdować się w przedziale od 8 do 20 znaków";
		
	}
	
	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	try{
		
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}else{
			
			//sprawdzenie czy email juz istnieje?
			$rezultat = $polaczenie->query("SELECT id FROM users WHERE Email='$email'");
			
			if(!$rezultat) throw new Exception($polaczenie->error);
			
			$ile_takich_emaili = $rezultat->num_rows;
			
			if($ile_takich_emaili>0){
				$wszystko_OK=false;
		$_SESSION['e_email']="Istnieje juz konto przypisane do tego adresu email!";
			}
			 
			if($wszystko_OK==true){
				if($polaczenie->query("INSERT INTO users VALUES(NULL,'$username','$password','$email')")){
					$_SESSION['udanarejestracja']=true;
					header('Location MenuGlowne.php');
					
					
				}else{
					throw new Exception($polaczenie->error);
				}
			}
			
			
			$polaczenie->close();
		}
		
	}
	catch(Exception $e){
		echo 'Bład serwera! Przepraszamy za niedognosc i prosimy o rejestracje w innym terminie';
		echo '<br /> Informacja dev: '.$e;
	}
	
	
		
	
	}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Rejestracja</title>
	<meta name="description" content="Rejestracja uzytkownika w aplikacji do finansow">
	<meta name="keywords" content="rejestracja, aplikacja, finanse, budzet, kontrolowanie">
	<meta name="author" content="Arkadiusz Matuszek">
	<meta http-equiv="X-Ua-compatible" content="IE=edge">
	
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	
</head>

<body>
	
	<header>
		<nav class="navbar navbar-dark bg-primary navbar-expand-md">
			<a class="navbar-brand" href="#"><img src="img/portfel.png" width="30" height="30" class="d-inline-block mr-1 align-bottom" alt="">BudzetDomowy.pl</a>
			
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="mainmenu">
				
				<ul class="navbar-nav">
					
					
					<li class="nav-item">
						<a class="nav-link" href="Logowanie.php"> Logowanie</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="MenuGlowne.php"> Menu główne</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="DodajPrzychod.php"> Dodaj przychód</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="DodajWydatek.php"> Dodaj wydatek</a>
					</li>
					
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="PrzegladajBilans.php" data-toggle="dropdown" role="button" aria-expanded="false" id="submenu" aria=haspopup="true"> Przeglądaj bilans</a>
						
						<div class="dropdown-menu" aria=labelledby="submenu">
						
							<a class="dropdown-item" href="PrzegladajBilans.php">Bieżacy miesiąc</a> 
							<a class="dropdown-item" href="PrzegladajBilans.php">Poprzedni miesiąc</a> 
							<a class="dropdown-item" href="PrzegladajBilans.php">Bieżący rok</a> 
							<a class="dropdown-item" href="PrzegladajBilans.php">Wybierz samodzielnie date</a> 
						
						</div>
						
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="#"> Kontakt</a>
					</li>
					
				</ul>
				
				
				
			</div>
		
		</nav>
	
	</header>


	<main>
	
	<article>
		<div class="row">
		
			<form method="post">
			
				<label><input type="text" name="username" placeholder="Imie"></label>
				
				<?php
					if(isset($_SESSION['e_username'])){
						echo '<div class="error">'.$_SESSION['e_username'].'</div>';
						unset($_SESSION['e_username']);
					}
				?>
				
				<label><input type="text" name="email" placeholder="Adres email"></label>
				<?php
					if(isset($_SESSION['e_email'])){
						echo '<div class="error">'.$_SESSION['e_email'].'</div>';
						unset($_SESSION['e_email']);
					}
				?>
				
				<label><input type="password" name="password" placeholder="Hasło"></label>
				
				<?php
					if(isset($_SESSION['e_password'])){
						echo '<div class="error">'.$_SESSION['e_password'].'</div>';
						unset($_SESSION['e_password']);
					}
				?>
				<br/><br/>
				<input type="submit" value="Zarejestruj użytkownika">
				<div id="logowanieRejestracja"><a href="Logowanie.php">Posiadasz konto? Zaloguj się!</a></div>
				
			</form>
		</div>

	</article>
	
		
	
	</main>


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>

</body>
</html>