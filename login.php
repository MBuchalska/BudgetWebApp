<?php
session_start();
$_SESSION['logged']=false;

if ((isset($_POST['login']))&&(isset($_POST['password']))){
	
	require_once "config.php";
	mysqli_report(MYSQLI_REPORT_STRICT);

	$connection = new mysqli($host, $user, $password, $database);
	if($connection->connect_errno!=0) {
		throw new Exception (mysqli_connect_errno());
	}

	else {
		//check if login and password characters are ok
		$login=$_POST['login'];
		$password=$_POST['password'];
		
		$login=htmlentities($login, ENT_QUOTES, "UTF-8");
		$password=htmlentities($password, ENT_QUOTES, "UTF-8");
		//$password_hash = password_hash($password, PASSWORD_DEFAULT);
		
		$result=$connection->query("SELECT * FROM users WHERE email='$login' OR userName='$login'");
		if(!$result) throw new Exception($connection->error);
		
		$HowManyUsers=$result->num_rows;
		
		if($HowManyUsers>0){
			//get user data from the database 
			$UserData=$result->fetch_assoc();
			
			if(password_verify($password, $UserData['password'])){
				$_SESSION['logged']=true;
				
				$_SESSION['ID']=$UserData['userID'];
				$_SESSION['login']=$UserData['userName'];
				
				$result->close();
				
				header('Location: menu.php');
			}
			
			else{
				$_SESSION['login_error']="Nieprawidłowy login lub hasło";
			}
		}
		
		else{
			$_SESSION['login_error']="Nieprawidłowy login lub hasło";
		}
		
		$connection->close();
	}
}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<title>  Logowanie </title>
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
		
	<div class="container">
		<section>
			<div class="row">
				<div class= "col-md-6 bg-custom py-4 my-1 mr-3" id="left"> 
					<p>Chcesz zaoszczędzić pieniądze, ale nie wiesz jak się do tego zabrać? </p>
					<p> Nasza aplikacja pomoże Ci uporządkować wydatki i ocenić możliwości oszczędzania</p>
					<p class="quote">"To nie pieniądze dają szczęście, ale to, co dzięki nim można zrobić ze swoim życiem." 
					<p class="author">Lois Frankel</p>
				</div>
				
				<div class= "col-md-6 my-auto" id="login"> 
					<form method="post">
						<p> Logowanie </p>
						
						<div class="input-group mb-3">
						  <span class="input-group-text " id="basic-addon1"> <i class="icon-user"></i></span>
						  <input type="text" name="login" placeholder="Podaj imię lub mail" onfocus="this.placeholder=''" onblur="this.placeholder='Podaj imię lub mail'" aria-label="Username" aria-describedby="basic-addon1" required >
						</div>
						 <?php
							if(isset($_SESSION['login_error'])){
								echo '<div class="error">'.$_SESSION['login_error'].'</div>';
								unset($_SESSION['login_error']);
							}
						?>
						
						<div class="input-group mb-3">
						  <span class="input-group-text " id="basic-addon3"> <i class="icon-lock"></i></span>
						  <input type="password" name="password" placeholder="Podaj hasło" onfocus="this.placeholder=''" onblur="this.placeholder='Podaj hasło'" aria-label="Username" aria-describedby="basic-addon3" required >
						</div>
						 <?php
							if(isset($_SESSION['login_error'])){
								echo '<div class="error">'.$_SESSION['login_error'].'</div>';
								unset($_SESSION['login_error']);
							}
						?>

						 
						<input type="submit" value="Zaloguj się">
						<input type="reset" value="Wyczyść formularz">
					</form>
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