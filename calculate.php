<?php
session_start();
if($_SESSION['logged']==false){
	header('Location: index.php');
	exit();
}

$BalanceType = $_POST['BParameters'];

$monthNow=date('n');
$yearNow=date('Y');
					
if($monthNow==1) $monthPrev = 12;
else $monthPrev=$monthNow-1;
					
function LastDay ($parameter){
	if(($parameter==2)&&((($yearNow%4==0)&&($yearNow%100!=0))||($yearNow%400==0))) $lastDay=29;
	else if ($parameter==2) $lastDay =28;
	else if (($parameter==1)||($parameter==3)||($parameter==5)||($parameter==7)||($parameter==8)||($parameter==10)||($parameter==12)) $lastDay =31;
	else $lastDay =30;
						
	return $lastDay;
}
								
//setting starting and ending date
// this month
if($BalanceType==11){  
	$lastDay=LastDay($monthNow);
						
	$Date1=new DateTime($yearNow.'-'.$monthNow.'-01'); 
	$Date2=new DateTime($yearNow.'-'.$monthNow.'-'.$lastDay); 
	$Date1=$Date1->format('Y-m-d');
	$Date2=$Date2->format('Y-m-d');
	}

// revious month					
else if($BalanceType==21){
	$lastDay=LastDay($monthPrev);
						
	$Date1=new DateTime($yearNow.'-'.$monthPrev.'-01'); 
	$Date2=new DateTime($yearNow.'-'.$monthPrev.'-'.$lastDay); 
	$Date1=$Date1->format('Y-m-d');
	$Date2=$Date2->format('Y-m-d');
}

//this year
else if($BalanceType==31){
		
	$Date1=new DateTime($yearNow.'-01-01'); 
	$Date2=new DateTime($yearNow.'-12-31'); 
	$Date1=$Date1->format('Y-m-d');
	$Date2=$Date2->format('Y-m-d');
}

//user choice for date range					
else if($BalanceType==41){
	$lastDay=LastDay($monthPrev);
						
	$Date1=$_POST['Date1']; 
	$Date2=$_POST['Date2'];
	
	if($Date1>$Date2) {
	$temp=$Date1;
	$Date1=$Data2;
	$Date2=$temp;
	}
}

$_SESSION['Date1']=$Date1;
$_SESSION['Date2']=$Date2;
header("Location: balance.php");			

?>