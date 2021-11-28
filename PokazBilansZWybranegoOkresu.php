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
	
		$nowa_data1 = $_POST['data_poczatkowa'];
		$nowa_data2 = $_POST['data_koncowa'];
		
	if($nowa_data1 == "" || $nowa_data2 == ""){
		header('Location: PrzegladajBilansWybierzDate.php');
		exit();
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
					<option value="PrzegladajBilans.php"selected>Bieżacy miesiąc</option>
					<option value="PrzegladajBilansPoprzedniMiesiac.php">Poprzedni miesiąc</option>
					<option value="PrzegladajBilansBiezacyRok.php">Bieżacy rok</option>
					<option value="PrzegladajBilansWybierzDate.php" >Wybierz date</option>
				</select>
					
		</div>
		
			
	
	
		<div class="bilans">
		
		
		
<div class="tabele">
<div class="AktualniePrzegladaneDaty">
	Aktualnie przeglądany jest bilans z aktualnego miesiąca <br />
	Aktualny zakres dat to: <br />
	<?php
		echo $nowa_data1." - ";
		echo $nowa_data2."<br />";
	?>
	</div>
<table>
	<caption>
	
	<?php
		$sql = "SELECT SUM(amount) from incomes WHERE user_id='$user_id' AND date_of_income BETWEEN '$nowa_data1' AND '$nowa_data2'";
		$result = $polaczenie->query($sql);
		while($row = mysqli_fetch_array($result)){
			if($row['SUM(amount)']==""){
			echo "Brak zestawień z tego zakresu dat";
			}else{
		echo "Suma przychodów z wybranej daty:".$row['SUM(amount)']." zł";
		echo "</caption>
	<thead>
    <tr>
        <th>Kategoria</th>
        <th>Kwota</th>
        <th>Komentarz</th>
        <th>Data</th>
    </tr>
    </thead>
    <tbody>";
		}
		}
		?>
	<?php
	

		
		
$tablica[0] = "Wynagrodzenie";
$tablica[1] = "Odsetki bankowe";
$tablica[2] = "Sprzedaż na allegro";
$tablica[3] = "Inne";


		
		for($i=0; $i<=3; $i++){
		
	$sql = "SELECT * FROM incomes WHERE user_id='$user_id' AND income_category_assigned_to_user_id='$i' AND date_of_income BETWEEN '$nowa_data1' AND '$nowa_data2'";
			$result = $polaczenie->query($sql);
		while($row = mysqli_fetch_array($result)){
			echo "<tr>
         <td>";
			echo $tablica[$i-1];
		 echo "</td>
       <td>";
		echo $row['amount'];
		echo "</td>
        <td>";
			echo $row['income_comment'];
		echo "</td>
		<td>";
			echo $row['date_of_income'];
		echo "</td>
		
		</tr>";
		
		}
		}
	?>
    </tbody>
</table>
</div>

			
		</div>
		
		
		<div class="bilans">
			<div class="tabele">
<table>
	<caption>
	<?php
		$sql = "SELECT SUM(amount) from expenses WHERE user_id='$user_id' AND date_of_expense BETWEEN '$nowa_data1' AND '$nowa_data2'";
		$result = $polaczenie->query($sql);
		while($row = mysqli_fetch_array($result)){
			if($row['SUM(amount)']==""){
			echo "Brak zestawień z tego zakresu dat";
			}else{
		echo "Suma przychodów z wybranej daty: ".$row['SUM(amount)']." zł";
	echo "</caption>
	<thead>
    <tr>
        
        <th>Kategoria</th>
        <th>Kwota </th>
        <th>Komentarz</th>
        <th>Forma płatności</th>
        <th>Data</th>
    </tr>
    </thead>";
		
		}}
			
			
	?> 
        <?php

		
$tablica[0] = "Jedzenie";
$tablice[1] = "Mieszkanie";
$tablica[2] = "Transport";
$tablica[3] = "Telekomunikacja";
$tablica[4] = "Opieka zdrowotna";
$tablica[5] = "Ubranie";
$tablica[6] = "Higiena";
$tablica[7] = "Dzieci";
$tablica[8] = "Rozrywka";
$tablica[9] = "Wycieczka";
$tablica[10] = "Szkolenia";
$tablica[11] = "Książki";
$tablica[12] = "Oszczędności";
$tablica[13] = "Emerytura";
$tablica[14] = "Spłata długów";
$tablica[15] = "Darowizna";
$tablica[16] = "Inne wydatki";

		
		for($i=0; $i<=16; $i++){
		
	$sql = "SELECT * FROM expenses WHERE user_id='$user_id' AND expense_category_assigned_to_user_id='$i' AND date_of_expense BETWEEN '$nowa_data1' AND '$nowa_data2'";
			$result = $polaczenie->query($sql);
		while($row = mysqli_fetch_array($result)){
			echo "<tr>
         <td>";
				echo $tablica[$i-1];
		 echo "</td>
       <td>";
			echo $row['amount'];
		echo "</td>
        <td>";
			echo $row['expense_comment'];
		echo "</td>
		<td>";
			if($row['payment_method_assigned_to_user_id'] == '1'){
				echo "Gotówka";
			}else if($row['payment_method_assigned_to_user_id']=='2'){
				echo "Karta debetowa";
			}else{
				echo "Karta kredytowa"; 
			}
		echo "</td>
		<td>";
			echo $row['date_of_expense'];
		echo "</td>
		</tr>";
		}
		}
	?>
   
 
	
	
      
        
</table>
</div>
		</div>

	</article>
	
		
	
	</main>


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>

</body>
</html>