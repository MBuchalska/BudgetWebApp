<?php
session_start();
if($_SESSION['logged']==false){
	header('Location: index.php');
	exit();
}

$_SESSION['incomeadded']=false;

$ID = $_SESSION['ID'];
$amount = $_POST['incomevalue'];
$data = $_POST['incDate'];
$type = $_POST['whatIncome'];
$comment = $_POST['IncComment'];

require_once "config.php";
mysqli_report(MYSQLI_REPORT_STRICT);

$connection = new mysqli($host, $user, $password, $database);
if($connection->connect_errno!=0) {
throw new Exception (mysqli_connect_errno());
}

else{
$connection->query("INSERT INTO incomes VALUES (NULL, '$ID', '$type', '$data', '$amount', '$comment')");	
$_SESSION['incomeadded']=true;
header("Location: income.php");
}

?>