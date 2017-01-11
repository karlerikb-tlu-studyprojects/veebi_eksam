<?php

require("functions.php");







if(isset($_GET["logout"])) {
	session_destroy();
	header("Location: tickets.php");
	exit();
}



//echo "nimi: ".$_SESSION["firstname"];
//echo "<br>id: ".$_SESSION["userId"];




if(isset($_POST["enterhouse"])) {
	
	enterHouse($_SESSION["userId"]);
	header("Location: enterhouse.php");
	exit();	
}

$button = "";

//echo "button: ".$button;

$u = getSingleUserData($_SESSION["userId"]);

echo "<br>id: ".$u->id;
echo "<br>name: ".$u->firstname;
echo "<br>ent: ".$u->entered;
echo "<br>dep: ".$u->departured;




$check = exitCheck($_SESSION["userId"]);

//echo "check: ".$check->exitcheck;


if($check->exitcheck == 0) {
	
	$button = "disabled";
	
}









?>




 <!DOCTYPE html>
<html>
<head>

</head>
<body>


<h3><a href="?logout=1">Logi välja</a></h3>









<p>
Tere, <?php echo $_SESSION["firstname"]; ?>! Siit saad majja siseneda!

</p>



<form method="POST">

	<input type="submit" name="enterhouse" value="Sisene majja!" <?php echo $button; ?>>

</form>




<h3>Siin on näha kasutajaid kes on hetkel majas</h3>

<?php


$visitors = getHouseVisitors();


$html = "<table>";

	$html .= "<tr>";
		$html .= "<th>Eesnimi</th>";
	$html .= "</tr>";
	
	foreach($visitors as $v) {
		$html .= "<tr>";
			$html .= "<td>".$v->firstname."</td>";
		$html .= "</tr>";
	}
	$html .= "</table>";
	echo $html;

$html = "</table>";


?>


<h3>Kui hästi läheb näeb siin kõiki pileteid päevade lõikes</h3>

<?php


$allTickets = getAllTickets();


$html = "<table>";

	$html .= "<tr>";
		$html .= "<th>id</th>";
		$html .= "<th>Eesnimi</th>";
		$html .= "<th>Pilet müüdud</th>";
		$html .= "<th>Päev</th>";
	$html .= "</tr>";
	
	$purchaseDay = 0;
	
	foreach($allTickets as $t) {
		
		
		if($purchaseDay != $t->day) {
			
		$html .= "<tr>";
			$html .= "<td> - </td>";
			$html .= "<td> - </td>";
			$html .= "<td> - </td>";
			$html .= "<td> - </td>";
		$html .= "</tr>";
		
		$purchaseDay = $t->day;
		} 
		
		$html .= "<tr>";
			$html .= "<td>".$t->id."</td>";
			$html .= "<td>".$t->firstname."</td>";
			$html .= "<td>".$t->ticketsold."</td>";
			$html .= "<td>".$t->day."</td>";
		$html .= "</tr>";
			
		
	}
	
$html .= "</table>";
echo $html;




?>













































