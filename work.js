//Balance - make date range visible in case of custom date range

var RangeOption = document.getElementById("BParameters");

RangeOption.addEventListener("click", function() {MakeDateRangeVisible()} );  

function MakeDateRangeVisible(){
	var DateRangeOption =document.getElementById("BParameters").value;
	
	if (DateRangeOption == 41) $('.dates').css('display', 'block');
	else  $('.dates').css('display', 'none');
}

// Balance - calculate the balance and show how is your budget

var table = document.getElementById("summaryTab");
var incomes = table.rows[0].cells[1].innerHTML;
var expenses = table.rows[1].cells[1].innerHTML;


var balance = incomes - expenses;
balance = balance.toFixed(2);
document.getElementById("FinalBalance").innerHTML = balance;

if (balance > 0) {
	document.getElementById("yourBudget").innerHTML="Doskonale! Zarabiasz więcej niż wydajesz!";
	$('#yourBudget').css('color','green');
}
else if (balance < 0){
	document.getElementById("yourBudget").innerHTML="Niedobrze. Trzeba zminiejszyć wydatki";
	$('#yourBudget').css('color','red');
}
else if (balance = 0) document.getElementById("yourBudget").innerHTML="Jesteś mistrzem prowadzenia budżetu!";


// Balance - generating the chart

google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

var data = google.visualization.arrayToDataTable([
          ['Wydatek', 'Kwota'],
          ['Jedzenie',     600],
          ['Mieszkanie',  1500],
          ['Transport',  150],
          ['Telekomunikacja', 50],
          ['Opieka zdrowotna',    250],
		  ['Ubrania', 80],
		  ['Higiena', 400],
		  ['Dzieci', 10],
		  ['Rozrywka', 1800],
		  ['Wycieczka', 50],
		  ['Szkolenia', 250],
		  ['Książki', 900],
		  ['Oszczędności', 1200],
		  ['Spłata długów', 10],
		  ['Darowizna', 500],
		  ['Inne wydatki', 30]
]);

var options = {
  title: 'Zestawienie wydatków',
  backgroundColor: '#ecc9c2',
  fontSize: 18,
  fontName: 'Lato',
};

var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
}
