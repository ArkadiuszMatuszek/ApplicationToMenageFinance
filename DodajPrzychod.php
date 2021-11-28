<?php

session_start();

if (!isset($_SESSION['zalogowany']))
	{
		header('Location: Logowanie.php');
		exit();
	}
	
	$user_id = $_SESSION['id'];
	
	if(isset($_POST['amount'])){
		$wszystko_OK = true;	
		$amount = $_POST['amount'];
	
	if(isset($_POST['income_category_assigned_to_user_id'])){
		$wszystko_OK = true;
		$income_category_assigned_to_user_id=$_POST['income_category_assigned_to_user_id'];
	}
	
	if(isset($_POST['date_of_income'])){
		$wszystko_OK = true;	
		$date_of_income = $_POST['date_of_income'];
	}
	
	if(isset($_POST['income_comment'])){
		$wszystko_OK = true;	
		$income_comment = $_POST['income_comment'];
	}
	
	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	try{
		
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}else{
			
			if($wszystko_OK==true){
				if($polaczenie->query("INSERT INTO incomes VALUES(NULL, $user_id, '$income_category_assigned_to_user_id', '$amount','$date_of_income','$income_comment')")){
					$_SESSION['udanarejestracja']=true;
		
					
					
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
						<a class="nav-link" href="Rejestracja.php"> Rejestracja</a>
					</li>
					
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
				
				
						<a class="wylogujUzytkownika" href="logout.php"> Wyloguj <img src="img/wyloguj.png" width="30" height="30"></a>
				
				
				
				
			</div>
		
		</nav>
	
	</header>


	<main>
	
	<article>
	
		<div id="DodwaniePrzychodu">
			<form method="post">
				<aside class="col-lg-12">
					<div class="kafelka"><label>Kwota:  <br/><input type="number" name="amount"></label></div>
					
						<?php
							if(isset($_SESSION['e_amount'])){
								echo '<div class="error">'.$_SESSION['e_amount'].'</div>';
								unset($_SESSION['e_amount']);
							}
						?>
					
					<div class="kafelka"><label>Data: <br/><input type="date" name="date_of_income" id="dateto1" class="form-control"></label></div>
					<div class="kafelka"><label>Kategoria:</label><br/>
						<input type="radio" name="income_category_assigned_to_user_id"  value="1" checked> Wynagrodzenie<br />
						<input type="radio" name="income_category_assigned_to_user_id" value="2"> Odsetki bankowe<br />
						<input type="radio" name="income_category_assigned_to_user_id" value="3"> Sprzedaż na allegro<br />
						<input type="radio" name="income_category_assigned_to_user_id" value="4"> Inne
					</div>
					
					<div class="kafelka"><label for="komentarz">Komentarz[opcjonalnie]:</label> <br/>
					<textarea name="income_comment" id="komentarz" ></textarea></div>
					<div class="przycisk"><label><br/><input type="submit" value="Dodaj"></label></div>
					<div class="przycisk"><label><br/><input type="submit" value="Anuluj"></label></div>
				
			</form>
		</div>

	</article>
	
		
	
	</main>


	<script src="zegar.js"></script>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>

</body>
</html>