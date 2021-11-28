<?php

	session_start();

	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: Logowanie.php');
		exit();
	}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Menu główne</title>
	<meta name="description" content="Rejestracja uzytkownika w aplikacji do finansow">
	<meta name="keywords" content="rejestracja, aplikacja, finanse, budzet, kontrolowanie">
	<meta name="author" content="Arkadiusz Matuszek">
	<meta http-equiv="X-Ua-compatible" content="IE=edge">
	
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="styleMenuGlowne.css">
	
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
						<a class="nav-link" href="Rejestracja.php"> Rejestracja</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="Logowanie.php"> Logowanie</a>
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
		
			<div class="container">
				
				<div class="row">
				
					<aside class="col-lg-4 bg-primary text-body p-4">
						
						<div class="pasekBoczny">
							<img src="img/uzytkownik.png" width="100" height="100">
						</div>
						<div class="daneUzytkownika">
						<h4>Aktualnie jesteś zalogowany jako:</br>
						<?php
							echo $_SESSION['username']."<br />";
							echo $_SESSION['email'];
						?>
						
						</h4>
						<a href="logout.php">
						<input type="submit" value="Wyloguj się">
						<?php
							$_SESSION['zalogowany']=false;

						?>
						</a>
						<a href="#"><input type="submit" value="Ustawienia"></a>
						

						</div>
					
					</aside>
					
					<div class="col-lg-8 ">
					
					<a href="#">
						<div class="pojemniczki">
							Dodaj przychód
							<a href="DodajPrzychod.php"><img src="img/plus.png" width="180" height="180"></a>
						</div>
						</a>
						
						<a href="#">
						<div class="pojemniczki">
							Dodaj wydatek
							<a href="DodajWydatek.php"><img src="img/minus.png" width="180" height="180"></a>
						</div>
						</a>
						
						<a href="#">
						<div class="pojemniczki">
							Przeglądaj bilans
							<a href="PrzegladajBilans.php"><img src="img/przegladaj.png" width="180" height="180"></a>
						</div>
						</a>
						
						
						
						
					
					</div>
				
				</div>
				
				
			</div>
		
		</article>
	
	</main>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>

</body>
</html>