<?php
session_start();

$_SESSION['logged']=false;
unset($_SESSION['ID']);
unset($_SESSION['login']);
?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<title>  Planuj z nami swój budżet! </title>
	<meta name="description" content ="Aplikacja pomoże ci zapanować nad swoim domowym budżetem"/>
	<meta name="keywords" content="budżet, planowanie wydatków, zestawienia budżetowe"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet"> 
	<link rel="stylesheet" href="style.css">
	
	
</head>

<body>
		<header>
			<h1 class="h1 text-center my-4 font-weight-bold text-uppercase ">  Planuj z nami swój budżet! </h1>
		</header>
		
	<div class="container">	
		<section>
			<div class="row">
				<div class="col-md-6 bg-custom py-4 my-1" id="left"> 
					<p>Dziękujemy za skorzystanie z naszej aplikacji! </p>
					<p> Zapraszamy ponownie!</p>
					<p class="quote">"To nie pieniądze dają szczęście, ale to, co dzięki nim można zrobić ze swoim życiem." 
					<p class="author">Lois Frankel</p>
				</div>
				
				<div class="col-md-6 py-2 my-auto" id="right"> 
					<p> Kolejna sesja? </p>
					<p> Nie masz jeszcze konta?  <a href="register.php" class="font-weight-bold">  Zarejestruj się </a> </p>
					<p> Masz konto? <a href ="login.php" class="font-weight-bold"> Zaloguj się</a></p>
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