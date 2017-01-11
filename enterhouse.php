<?php

require("functions.php");




if(isset($_POST["exithouse"])) {
	
	exitHouse($_SESSION["userId"]);
	header("Location: house.php");
	exit();
	
}




?>


Siin on hirmus

<form method="POST">

	<input type="submit" name="exithouse" value="Mine ära!">

</form>