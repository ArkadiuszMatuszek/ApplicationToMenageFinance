<?php

	session_start();

	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: Logowanie.php');
		exit();
	}
	
	$user_id = $_SESSION['id'];
	
	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
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
	<link rel="stylesheet" href="bilanse.css">
	
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
							<a class="dropdown-item" href="PrzegladajBilansPoprzedniMiesiac.php">Poprzedni miesiąc</a> 
							<a class="dropdown-item" href="PrzegladajBilansBiezacyRok.php">Bieżący rok</a> 
							<a class="dropdown-item" href="PrzegladajBilansWybierzDate.php">Wybierz samodzielnie date</a>  
						
						</div>
						
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="#"> Kontakt</a>
					</li>
					
						</ul>
						<a class="wylogujUzytkownika" href="logout.php"> Wyloguj <img src="img/wyloguj.png" width="30" height="30"></a>
					
					
				
				
				
				
			</div>
		
		</nav>
	
	</header>


	<main>
	
	<article>
		<div id="wybieranieDaty">
			
				<select name="data" onchange="location = this.value;">
					<option value="PrzegladajBilans.php">Bieżacy miesiąc</option>
					<option value="PrzegladajBilansPoprzedniMiesiac.php">Poprzedni miesiąc</option>
					<option value="PrzegladajBilansBiezacyRok.php">Bieżacy rok</option>
					<option value="PrzegladajBilansWybierzDate.php" selected>Wybierz date</option>
				</select>
					
		</div>
		
			
	
	
		<div class="bilans">
		
		
		

					<form action="PokazBilansZWybranegoOkresu.php" method="post">
					<div class="kafelka"><label>Od: <br/><input type="date" name="data_poczatkowa" id="dateto1"></label></div>	
					<div class="kafelka"><label>Do: <br/><input type="date" name="data_koncowa" id="dateto1"></label></div>
					<div class="kafelka"><input type="submit" value="Pokaz dane"></div>
					</form>
					


		</div>

	</article>
	
		
	
	</main>


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>

</body>
</html>