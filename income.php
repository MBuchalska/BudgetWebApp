<?php
session_start();
if($_SESSION['logged']==false){
	header('Location: index.php');
	exit();
}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<title>  Dodaj przychód </title>
	<meta name="description" content ="Aplikacja pomoże ci zapanować nad swoim domowym budżetem"/>
	<meta name="keywords" content="budżet, planowanie wydatków, zestawienia budżetowe"/>
	<meta http-equiv="X-UA-Compatible" content ="IE=edge"/>
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet"> 
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="css/fontello.css" type="text/css"/>
	

	
</head>

<body>
	
		<header>
			<h1 class="h1 text-center my-4 font-weight-bold text-uppercase ">  Dodawanie przychodu </h1>
		</header>
	
		<nav class="navbar navbar-dark bg-nav navbar-expand-md mx-auto">
			
			<a class="navbar-brand" href="menu.php"><i class="icon-dollar"></i> YourBudgetApp</a>
				
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Przełącznik nawigacji">
			<span class="navbar-toggler-icon"></span>
			</button>
				
			<div class="collapse navbar-collapse" id="menu" > 
				<ul class="navbar-nav mx-auto">
					<li class="nav-item"><a class="nav-link" href="income.php">Dodaj przychód </a></li>
					<li class="nav-item"><a class="nav-link active" href="expense.php">Dodaj wydatek</a></li>
					<li class="nav-item"><a class="nav-link" href="balance.html">Przeglądaj bilans</a></li>
					<li class="nav-item"><a class="nav-link" href="#">Ustawienia </a></li>
					<li class="nav-item"><a class="nav-link" href="logout.php"><i class="icon-logout"></i>Wyloguj się </a></li>
				</ul>
			</div>
		</nav>
		
	<div class="container">			
		<section>
			<div class="row">
				<?php
				if ($_SESSION['incomeadded']==true){
					echo '<p class="h2 text-center mt-5 font-weight-bold"> Przychód dodany do bazy </p>';
					$_SESSION['incomeadded']=false;
				}
				else echo '<p class="h2 text-center mt-5 font-weight-bold"> Uzupełnij formularz poniżej </p>';
				?>
				
				<form action="addincome.php" method="post" class="col-md-8 mx-md-auto fs-2">
					
						<p class="mt-5" ><label> Kwota przychodu:  <input type="number" name="incomevalue" step="0.01" required aria-label="Kwota przychodu"></label></p>
						
						<p class="mt-5"><label aria-label="Data">  Data: <input type="date" name="incDate" id="incDate" class="form__date" required ></label></p>
						<label class="mt-5 font-weight-bold "> Kategoria przychodu:</label>
						
						<?php
							require_once "config.php";
							mysqli_report(MYSQLI_REPORT_STRICT);

							$connection = new mysqli($host, $user, $password, $database);
							if($connection->connect_errno!=0) {
							throw new Exception (mysqli_connect_errno());
							}
							
							else{
								$ID = $_SESSION['ID'];
								$result=$connection->query("SELECT iset.categoryID, icat.incomeCatName FROM income_categories AS icat, income_settings AS iset WHERE iset.userID='$ID' AND iset.categoryID=icat.incomeCatID ORDER BY iset.categoryID ASC");
								
								$catNumber=$result->num_rows;
								
								for ($i=1; $i<=$catNumber; $i++){
									$categories=mysqli_fetch_assoc($result);
							
									$catID=$categories['categoryID'];
									$catName=$categories['incomeCatName'];			
									
									echo '<div class="form-check">';
									echo '<input class="form-check-input" type="radio" name="whatIncome" id="whatIncome'.$catID.'" value="'.$catID.'" required>';
									echo '<label class="form-check-label" for="whatIncome'.$catID.'" >';
									echo $catName;
									echo '</label></div>';
							
								}							
							}
							
						$connection->close();
						?>
						
							<input type="text" name="IncComment" placeholder="Komentarz do przychodu" onfocus="this.placeholder=''" onblur="this.placeholder='Komentarz'" class="mt-3"> 
							
						<div class="mt-5">
							<input type="submit" value="Dodaj">
							<input type="reset" value="Anuluj">
						</div>
					
				</form>
				
			</div>		
		</section>
		
		<footer> 
			<h3 class="h5 mt-4 text-center">Wszelkie prawa zastrzeżone &copy; 2021 Dziękuję za wizytę!</h3>
		</footer>
	
	</div>
	
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

	<script src="jquery-3.6.0.min.js"></script>
	<script src="work.js"></script>
	
</body>

</html>