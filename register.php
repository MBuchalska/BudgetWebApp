<?php
session_start();
if($_SESSION['logged']==true){
	header('Location: menu.php');
	exit();
}

$_SESSION['registercomplete']=false;

// check data and ad to database
if(isset($_POST['mail'])){
	$validation_OK=true;
		// sprawdzanie poprawności wpraowadzonych danych	
	
	// checking nick 
	$nick=$_POST['imie'];
	if((strlen($nick)<3)||(strlen($nick)>20)){
		$validation_OK=false;
		$_SESSION['e_nick']="Nick musi mieć od 3 do 20 znaków!";
	}
	
	if(ctype_alnum($nick)==false){
		$validation_OK=false;
		$_SESSION['e_nick']="Nick może się składać tylko z liter i cyfr (bez polskich znaków)";
	}	
	
	// checking and cleaning e-mail
	$email=$_POST['mail'];
	$emailB=filter_var($email, FILTER_SANITIZE_EMAIL);
		
	if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false)||($emailB!=$email)){
		$validation_OK=false;
		$_SESSION['e_email']="Podaj poprawny adres e-mail!";
	}
	
	// checking and hashing password
	$password = $_POST['haslo'];
	if((strlen($password)<8)||(strlen($password)>20)){
		$validation_OK=false;
		$_SESSION['e_password']="Haslo musi posiadać od 8 do 20 znaków!";
	}
	
	$password_hash = password_hash($password, PASSWORD_DEFAULT);
	
	// connecting database
	require_once "config.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	try{
		$connection = new mysqli($host, $user, $password, $database);
		if($connection->connect_errno!=0) {
			throw new Exception (mysqli_connect_errno());
		}
				
		else{
			// is this mail already in the base; there is no need for an unique nick this is a name 
			$result=$connection->query("SELECT userID FROM users WHERE email='$email'");
			if(!$result) throw new Exception($connection->error);
			
			$how_many_mails = $result->num_rows;
				if ($how_many_mails>0){
					$validation_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego maila";
				}

			$result1=$connection->query("SELECT userID FROM users WHERE userName='$nick'");
			if(!$result) throw new Exception($connection->error);
			
			$how_many_names = $result1->num_rows;
				if ($how_many_names>0){
					$validation_OK=false;
					$_SESSION['e_nick']="Użytkownik o takiej nazwie jest już zarejestrowany. Wybierz inną nazwę.";
				}
				
			// adding a new record to the base
			if($validation_OK==true){
				
				if ($connection->query("INSERT INTO users VALUES (NULL, '$nick', '$email', '$password_hash')")){
						//adding default settings for the user
						$result=$connection->query("SELECT userID FROM users WHERE email='$email'");
						$ID = $result->fetch_array(MYSQLI_NUM);
						
						for($i=1; $i<18; $i++){
							$connection->query("INSERT INTO expense_settings VALUES (NULL, '$ID[0]', '$i')");		
						}
						
						for($i=1; $i<5; $i++){
							$connection->query("INSERT INTO income_settings VALUES (NULL, '$ID[0]', '$i')");		
						}
						
						for($i=1; $i<4; $i++){
							$connection->query("INSERT INTO pay_method_settings VALUES (NULL, '$ID[0]', '$i')");		
						}
						
						//redirecting to welcoming page
						$_SESSION['registercomplete']=true;
						header("Location: welcome.php");
						}
					else{
						 throw new Exception($connection->error);
						}
				
			$connection->close();
			}
		}	
	}
		
	catch(Exception $e){
		echo '<span class = "error"> Błąd serwera. Przepraszamy za niedogodności " </span>';
		echo '<br/> Dev info:'.$e;
	}
}		
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<title>  Rejestracja </title>
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
				
				<div  class= "col-md-6 my-3" id="registration"> 
					<form method="post">
						<p> Rejestracja </p>
						<div class="input-group mb-3">
						  <span class="input-group-text " id="basic-addon1"> <i class="icon-user"></i></span>
						  <input type="text" name="imie" placeholder="Podaj imię" onfocus="this.placeholder=''" onblur="this.placeholder='Podaj nazwę użytkownika'" aria-label="Username" aria-describedby="basic-addon1" required >
						</div>
						<?php
							if(isset($_SESSION['e_nick'])){
								echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
								unset($_SESSION['e_nick']);
							}
						?>
						
						<div class="input-group mb-3">
						  <span class="input-group-text " id="basic-addon2"> <i class="icon-mail-alt"></i></span>
						  <input type="email" name="mail" placeholder="Podaj mail" onfocus="this.placeholder=''" onblur="this.placeholder='Podaj mail'" aria-label="Username" aria-describedby="basic-addon2" required >
						</div>
						<?php
							if(isset($_SESSION['e_email'])){
								echo '<div class="error">'.$_SESSION['e_email'].'</div>';
								unset($_SESSION['e_email']);
							}
						?>
						
						<div class="input-group mb-3">
						  <span class="input-group-text " id="basic-addon3"> <i class="icon-lock"></i></span>
						  <input type="password" name="haslo" placeholder="Podaj hasło" onfocus="this.placeholder=''" onblur="this.placeholder='Podaj hasło'" aria-label="Username" aria-describedby="basic-addon3" required >
						</div>
						<?php
							if(isset($_SESSION['e_password'])){
								echo '<div class="error">'.$_SESSION['e_password'].'</div>';
								unset($_SESSION['e_password']);
							}
						?>
						
						<input type="submit" value="Zarejestruj się">
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