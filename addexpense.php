<?php
session_start();
if($_SESSION['logged']==false){
	header('Location: index.php');
	exit();
}

$_SESSION['expAdded']=false;

$ID = $_SESSION['ID'];
$amount = $_POST['expencevalue'];
$data = $_POST['expDate'];
$way=$_POST['HowToPay'];
$type = $_POST['expCategory'];
$comment = $_POST['ExpComment'];

require_once "config.php";
mysqli_report(MYSQLI_REPORT_STRICT);

$connection = new mysqli($host, $user, $password, $database);
if($connection->connect_errno!=0) {
throw new Exception (mysqli_connect_errno());
}

else{
$connection->query("INSERT INTO expenses VALUES (NULL, '$ID', '$type', '$way', '$data', '$amount', '$comment')");	
$_SESSION['expAdded']=true;
header("Location: expense.php");
}

?>