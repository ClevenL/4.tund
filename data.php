<?php
	//katsetus
	require("function.php");
	
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		
	}
	
	if (!isset($_SESSION["userId"])) {
		
		
		
		header("Location: login.php");
		
	}
	
	


?>

<h1>Data</h1>
<p>

	Tere tulemast <?=$_SESSION["email"];?>!

	<a href="?logout=1">Logi valja</a>

</p>