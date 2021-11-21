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
	<title>  Przglądaj bilans </title>
	<meta name="description" content ="Aplikacja pomoże ci zapanować nad swoim domowym budżetem"/>
	<meta name="keywords" content="budżet, planowanie wydatków, zestawienia budżetowe"/>
	<meta http-equiv="X-UA-Compatible" content ="IE=edge"/>
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
		
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet"> 
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="css/fontello.css" type="text/css"/>
	
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

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
				<li class="nav-item"><a class="nav-link active" href="expense.php">Dodaj wydatek</a></li>
				<li class="nav-item"><a class="nav-link" href="balance.php">Przeglądaj bilans</a></li>
				<li class="nav-item"><a class="nav-link" href="#">Ustawienia </a></li>
				<li class="nav-item"><a class="nav-link" href="logout.php"><i class="icon-logout"></i>Wyloguj się </a></li>
			</ul>
		</div>
	</nav>
		
	<div class="container">		
		<section>
			<div class="row"> 
				<form action="calculate.php" method ="post" class="mt-5 col-md-8 mx-md-auto" > 
					<label for="BParameters"> Parametry bilansu: </label>
					<select id="BParameters" name="BParameters" size="1" required>
						<option value=""> wybierz z listy </option>
						<option value="11" selected>bieżący miesiąc</option>
						<option value="21">poprzedni miesiąc</option>
						<option value="31">bieżący rok</option>
						<option value="41">zakres niestandardowy</option>
					</select>
						
					<div class="dates mt-3">
						<label>  Data od: <input type="date" name="Date1"  value="2020-01-01"></label>
						<label>  Data do: <input type="date" name="Date2" id="Date2" class="form__date"></label>	
					</div>
					
					<div class="mt-5">
						<input type="submit" value="Pokaż bilans">
					</div>
				</form>
				<?php
					if ((isset($_SESSION['Date1']))&&(isset($_SESSION['Date2']))){
						$Data1=$_SESSION['Date1'];
						$Data2=$_SESSION['Date2'];
						echo '<div class="col-md-8 mt-3 mx-md-auto"> Wyświetlam bilans dla zakresu od '.$Data1.' do '.$Data2.'</div>';
												
						require_once "config.php";
						mysqli_report(MYSQLI_REPORT_STRICT);

						$connection = new mysqli($host, $user, $password, $database);
						if($connection->connect_errno!=0) {
							throw new Exception (mysqli_connect_errno());
							}
							
						else{
							$ID = $_SESSION['ID'];
							$AllExpenseSum=0;
							$AllIncomeSum=0;
							
							// expense table
							$result=$connection->query("SELECT ecat.expenseCatName, SUM(exp.amount) FROM  expense_categories AS ecat, expenses AS exp WHERE userID='$ID' AND exp.data >='$Data1' AND exp.data<='$Data2' AND exp.amount>0  AND exp.categoryID=ecat.expenseCatID GROUP BY exp.categoryID ORDER BY SUM(exp.amount) DESC");
								
							echo '<div class="col-md-5 mt-3 mx-md-auto"> Tabela z wydatkami';
							echo '<table class="table mt-3" id="expenseTable">';
							echo '<thead>	<tr>';
							echo '<th scope="col">wydatek</th>';
							echo '<th scope="col">kwota [PLN]</th></tr></thead><tbody>';	
								
							$expNumber=$result->num_rows;
							for ($i=1; $i<=$expNumber; $i++){
								$categories=mysqli_fetch_assoc($result);
								$catName = $categories['expenseCatName'];
								$sum = number_format($categories['SUM(exp.amount)'],2, '.', '');
									
								echo '<tr><td>'.$catName.'</td>';
								echo '<td class="cell">'.$sum.'</td></tr>';
								$AllExpenseSum+=$sum;
							}
								echo '</tbody></table></div>';
									
							
							//income table
							$result2=$connection->query("SELECT icat.incomeCatName, SUM(inc.amount) FROM  income_categories AS icat, incomes AS inc WHERE userID='$ID' AND inc.data >='$Data1' AND inc.data<='$Data2' AND inc.amount>0  AND inc.categoryID=icat.incomeCatID GROUP BY inc.categoryID ORDER BY SUM(inc.amount) DESC");
							
							echo '<div class="col-md-5 mt-3"> ';
							echo '<div class="income"> Tabela z przychodami';
							echo '<table class="table mt-3">';
							echo '<thead><tr>';
							echo '<th scope="col">przychód</th>';
							echo  '<th scope="col">kwota [PLN]</th></tr></thead><tbody>';
							
							$incNumber=$result2->num_rows;
							for ($i=1; $i<=$incNumber; $i++){
								$categories2=mysqli_fetch_assoc($result2);
								$incName = $categories2['incomeCatName'];
								$incSum = number_format($categories2['SUM(inc.amount)'],2, '.', '');
								
								echo '<tr><td>'.$incName.'</td>';
								echo '<td class="cell">'.$incSum.'</td></tr>';
								$AllIncomeSum+=$incSum;
							}
							echo '</tbody></table></div>';
							
							// summary table
							echo '<div class=""><p >Jak ci idzie oszczędzanie:</p><p id="yourBudget">  </p>';
							echo '<table class="table mt-3" id="summaryTab">';
							echo '<tbody>	<tr>	<td>Przychody: </td>';
							echo '<td  class="cell" id="IncomeSum" >'.$AllIncomeSum.'</td></tr>';
							echo '<tr>	<td>Wydatki: </td>';
							echo '<td  class="cell" id="ExpenseSum" >'.$AllExpenseSum.'</td></tr>';
							echo '<tr>	<td>Bilans: </td>';
							echo '<td  class="cell" id="FinalBalance"> Bilans </td></tr></tbody></table></div></div>';
							
							//piechart
							echo '<div id="piechart" class="col-md-8 mx-md-auto"> wykres kołowy wydatków </div>';
							echo 	'<script> google.charts.load("current", {"packages":["corechart"]});';
							echo 'google.charts.setOnLoadCallback(drawChart);';

							echo 'function drawChart() { var data = google.visualization.arrayToDataTable([';
							echo '["Wydatek", "Kwota"],';
								$result3=$connection->query("SELECT ecat.expenseCatName, SUM(exp.amount) FROM  expense_categories AS ecat, expenses AS exp WHERE userID='$ID' AND exp.data >='$Data1' AND exp.data<='$Data2' AND exp.amount>0  AND exp.categoryID=ecat.expenseCatID GROUP BY exp.categoryID ORDER BY SUM(exp.amount) DESC");
							for ($i=1; $i<=$expNumber; $i++){
								$categories=mysqli_fetch_assoc($result3);
								$catName = $categories['expenseCatName'];
								$sum = number_format($categories['SUM(exp.amount)'],2, '.', '');
								echo '["'.$catName.'",'.$sum.'],';								
							}
							echo ']);';

							echo 'var options = {title: "Zestawienie wydatków",';
							echo 'backgroundColor: "#ecc9c2",';
							echo 'fontSize: 18,';
							echo 'fontName: "Lato",};';

							echo 'var chart = new google.visualization.PieChart(document.getElementById("piechart"));';
							echo 'chart.draw(data, options);}	</script>';
				
						}
							$connection->close();
							unset($_SESSION['Date1']);
							unset($_SESSION['Date2']);
					}
																				
					else {
						echo '<p class="h2 text-center mt-5 font-weight-bold"> Wybierz zakres dat </p>';
					}
				?>
		
			</div>
		</section>
	
		<footer> 
			<h3 class="h5 mt-4 text-center"> Wszelkie prawa zastrzeżone &copy; 2021 Dziękuję za wizytę!</h3>
		</footer>
	
	</div>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
	
	<script src="jquery-3.6.0.min.js"></script>
	<script src="work.js"></script>
	
</body>

</html>