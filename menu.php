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
	<title>  Menu główne </title>
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
			<h1 class="h1 text-center my-4 font-weight-bold text-uppercase ">  Planuj z nami swój budżet! </h1>
		</header>
		
		
			<nav class="navbar navbar-dark bg-nav navbar-expand-md mx-auto">
			
			<a class="navbar-brand" href="menu.php"><i class="icon-dollar"></i> YourBudgetApp</a>
			
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Przełącznik nawigacji">
			<span class="navbar-toggler-icon"></span>
			</button>
			
				<div class="collapse navbar-collapse" id="menu" > 
					<ul class="navbar-nav mx-auto">
						<li class="nav-item"><a class="nav-link" href="income.php">Dodaj przychód </a></li>
						<li class="nav-item"><a class="nav-link" href="expense.html">Dodaj wydatek</a></li>
						<li class="nav-item"><a class="nav-link" href="balance.html">Przeglądaj bilans</a></li>
						<li class="nav-item"><a class="nav-link" href="#">Ustawienia </a></li>
						<li class="nav-item"><a class="nav-link" href="logout.php"><i class="icon-logout"></i>Wyloguj się </a></li>
					</ul>
				</div>
			</nav>
		
	<div class="container">		
			<section>
				<div class="row"> 
					<div class="col-md-8 mx-auto my-5">
						<?php
						echo  '<p> Witaj '.$_SESSION['login'].'!</p>'
						?>
						<p class="text-justify"> Witaj w aplikacji, która pomoże Ci prowadzić Twój domowy budżet. Dodawaj przychody i wydatki, przeglądaj zestawienia i dzięki temu naucz się oczszędzać.</p>
						<p class ="quote"> "Pieniądze czynią ludzi bogatymi, natomiast błędem jest sądzić, że czynią ich lepszymi albo nawet gorszymi. O ludziach świadczą ich uczynki oraz to, jaki ślad po sobie zostawiają" </p>
						<p class ="author"> Terry Pratchett, "Spryciarz z Londynu" </p>
					</div>
				</div>
			</section>
	
		<footer> 
			<h3 class="h5 mt-4 text-center">Wszelkie prawa zastrzeżone &copy; 2021 Dziękuję za wizytę!</h3>
		</footer>
	
	</div>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
	
</body>

</html>