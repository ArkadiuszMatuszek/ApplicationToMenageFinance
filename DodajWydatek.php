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
	
		
	if(isset($_POST['date_of_expense'])){
		$wszystko_OK = true;
		$date_of_expense = $_POST['date_of_expense'];
	}
	
	if(isset($_POST['payment_method_assigned_to_user_id'])){
		$wszystko_OK = true;
		$payment_method_assigned_to_user_id=$_POST['payment_method_assigned_to_user_id'];
	}
	
	if(isset($_POST['expense_category_assigned_to_user_id'])){
		$wszystko_OK = true;
		$expense_category_assigned_to_user_id=$_POST['expense_category_assigned_to_user_id'];
	}
	
	if(isset($_POST['expense_comment'])){
		$wszystko_OK = true;	
		$expense_comment = $_POST['expense_comment'];
	}
	
	
	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	try{
		
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}else{
			
			if($wszystko_OK==true){
				if($polaczenie->query("INSERT INTO expenses VALUES(NULL, '$user_id', '$expense_category_assigned_to_user_id', '$payment_method_assigned_to_user_id','$amount','$date_of_expense','$expense_comment')")){
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
				<div class="kafelka"><label>Kwota:  <br/><input type="number" name="amount"></label></div>
					<div class="kafelka"><label>Data: <br/><input type="date" name="date_of_expense" id="dateto1" class="form-control"></label></div>
				<div class="kafelka"><label>Sposób płatności:</label><br/>
					<div><label><input type="radio" name="payment_method_assigned_to_user_id" value="1" checked> Gotówka</label></div>
					<div><label><input type="radio" name="payment_method_assigned_to_user_id" value="2"> Karta debetowa</label></div>
					<div><label><input type="radio" name="payment_method_assigned_to_user_id" value="3"> Karta kredytowa</label></div>
				</div>
				
				<div class="kafelka">
					<label for="kategoria"> Kategoria: </label><br/>
					<select name="expense_category_assigned_to_user_id" id="kategoria">
						<option value="1">Jedzenie</option>
						<option value="2">Mieszkanie</option>
						<option value="3">Transport</option>
						<option value="4">Telekomunikacja</option>
						<option value="5"> Opieka zdrowotna</option>
						<option value="6">Ubranie</option>
						<option value=" 7" > Higiena</option>
						<option value="8" >Dzieci</option>
						<option value="9" >Rozrywka</option>
						<option value="10" >Wycieczka</option>
						<option value="11" >Szkolenia</option>
						<option value="12" >Książki</option>
						<option value="13" >Oszczędności</option>
						<option value="14" >Na złotą jesień, czyli emeryturę</option>
						<option value="15" > Spłata długów</option>
						<option value="16" >Darowizna</option>
						<option value="17" >Inne wydatki</option>
					</select>
					
				
				</div>
				
				<div class="kafelka"><label for="komentarz">Komentarz[opcjonalnie]:</label> <br/>
				<textarea name="expense_comment" id="komentarz"></textarea></div>
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