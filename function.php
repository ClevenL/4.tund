<?php

	//functions.php
	session_start();
	
	$database = "if16_clevenl";
	
	function signup ($email, $password) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");
		
		//asendan kusimargi vaartustega
		//iga muutuja kohta 1 taht, mis tuupi muutuja on
		// s - string
		// i - integer
		// d - double/float
		$stmt->bind_param("ss", $email, $password);
		
		if ($stmt->execute()) {
			
			echo "salvestamine onnestus!";
		} else {
			echo "ERROR ".$stmt->error;
		}
	
	}
	
	function login ($email, $password) {
		
		$error = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		
			SELECT id, email, password, created
			FROM user_sample
			WHERE email = ?
		
		");
		
		$stmt->bind_param("s", $email);
		
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb) {
				echo "kasutaja ".$id." logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["email"] = $emailFromDb;
				
				header("Location: data.php");
				
			} else {
				$error = "parool vale";
			}
			
		} else {	
			
			$error = "sellise emailiga ".$email." kasutajat ei olnud";
		}
		
		return $error;
		
	}
	
	
	
	
	
	
	
	
	/*
	function sum ($x, $y) {
		
		return $x + $y;
	}
	
	function hello ($firstname, $lastname) {
		
		return "Tere tulemast ".$firstname." ".$lastname."!";
	}
	
	echo sum (5476567567,234234234);
	echo "<br>";
	$answer = sum (10,15);
	echo $answer;
	echo "<br>";
	echo hello ("Cleven", "Lehispuu");
	*/
	 
	
?>