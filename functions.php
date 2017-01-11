<?php



require("../../../config.php");
session_start();


function purchaseTicket($firstname) {
	
	$database = "if16_karlerik";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
			
	$stmt = $mysqli->prepare("INSERT INTO v_house (firstname, ticketsold) VALUES (?, NOW())");
	
	echo $mysqli->error;
	
	$stmt->bind_param("s", $firstname);
	
	if($stmt->execute()) {
		echo "salvestamine õnnestus";	
	} else {
		echo "ERROR ".$stmt->error;
	}
	
	$stmt->close();
	$mysqli->close();
}


function getUserId() {
	
	$database = "if16_karlerik";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
			
	$stmt = $mysqli->prepare("SELECT id, firstname FROM v_house ORDER BY id DESC LIMIT 1");
	
	echo $mysqli->error;
	$stmt->bind_result($id, $firstname);
	$stmt->execute();
	
	if($stmt->fetch()) {
		
		$_SESSION["userId"] = $id;
		$_SESSION["firstname"] = $firstname;
		
		header("Location: house.php");
		exit();
		
	}
	$stmt->close();
	$mysqli->close();	
}


function enterHouse($id) {
	
	$database = "if16_karlerik";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
			
	$stmt = $mysqli->prepare("UPDATE v_house SET entered = NOW() WHERE id = ?");
	echo $mysqli->error;
	
	$stmt->bind_param("s", $id);
	
	if($stmt->execute()) {
		echo "salvestamine õnnestus";	
	} else {
		echo "ERROR ".$stmt->error;
	}
	
	$stmt->close();
	$mysqli->close();
}



function exitHouse($id) {
	
	$database = "if16_karlerik";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
			
	$stmt = $mysqli->prepare("UPDATE v_house SET departured = NOW() WHERE id = ?");
	echo $mysqli->error;
	
	$stmt->bind_param("s", $id);
	
	if($stmt->execute()) {
		echo "salvestamine õnnestus";	
	} else {
		echo "ERROR ".$stmt->error;
	}
	
	$stmt->close();
	$mysqli->close();
}



function getSingleUserData($userid) {
	
	$database = "if16_karlerik";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	
	$stmt = $mysqli->prepare("SELECT id, firstname, entered, departured FROM v_house WHERE id = ?");
	echo $mysqli->error;
	
	$stmt->bind_param("s", $userid);
	$stmt->bind_result($id, $firstname, $entered, $departured);
	$stmt->execute();
	
	$singleUser = new StdClass();
		
	if($stmt->fetch()) {
		
		$singleUser->id = $id;
		$singleUser->firstname = $firstname;
		$singleUser->entered = $entered;
		$singleUser->departured = $departured;
		
	} else {
		echo "andmete kättesaamisel ilmnes tõrge";
	}
	$stmt->close();
	return $singleUser;
}


function exitCheck($userid) {
	
	$database = "if16_karlerik";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	
	$stmt = $mysqli->prepare("SELECT COUNT(*) AS exitcheck FROM v_house WHERE id = ? AND departured IS NULL");
	
	$stmt->bind_param("i", $userid);
	$stmt->bind_result($exitcheck);
	$stmt->execute();
	
	$exitCheck = new StdClass();
	
	if($stmt->fetch()) {
		
		$exitCheck->exitcheck = $exitcheck;
		
	} else {
		echo $stmt->error." Oli mingi kamm postcheckiga..";
	}
	$stmt->close();
	return $exitCheck;
	
}


function getHouseVisitors() {
	
	$database = "if16_karlerik";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	
	$stmt = $mysqli->prepare("SELECT firstname FROM v_house WHERE entered IS NOT NULL AND departured IS NULL");
	
	echo $mysqli->error;
	$stmt->bind_result($firstname);
	$stmt->execute();
	
	$result = array();
	while($stmt->fetch()) {
		$visitor = new StdClass();
		
		$visitor->firstname = $firstname;
		
		array_push($result, $visitor);
	}
	
	$stmt->close();
	$mysqli->close();
	
	return $result;
	
}




function getAllTickets() {
	
	$database = "if16_karlerik";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	
	$stmt = $mysqli->prepare("SELECT id, firstname, ticketsold, DAY(ticketsold) AS day FROM v_house");
	
	echo $mysqli->error;
	$stmt->bind_result($id, $firstname, $ticketsold, $day);
	$stmt->execute();
	
	$result = array();
	while($stmt->fetch()) {
		$ticket = new StdClass();
		
		$ticket->id = $id;
		$ticket->firstname = $firstname;
		$ticket->ticketsold = $ticketsold;
		$ticket->day = $day;
		
		array_push($result, $ticket);
	}
	
	$stmt->close();
	$mysqli->close();
	
	return $result;
	
}
	
	
	






























?>