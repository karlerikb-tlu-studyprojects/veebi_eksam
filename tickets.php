<?php


require("functions.php");



if(isset($_POST["firstname"])) {
	
	purchaseTicket($_POST["firstname"]);
	getUserId();
	
}









?>

































 <!DOCTYPE html>
<html>
<head>

</head>
<body>

	<h3>Osta pilet</h3>
	<form method="POST">
		<label>Eesnimi</label><br>
		<input type="text" name="firstname" placeholder="Sisesta oma eesnimi">
		
		<br><br>
		
		<label>Hind</label><br>
		<input type="text" name="price" value="1€" disabled>
		
		<br><br>
		
		<input type="submit" name="purchase" value="Osta pilet">
		
		
	
	</form>
	
