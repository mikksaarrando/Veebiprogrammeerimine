<?php
	require("functions.php");
	
	//kas pole sisse loginud
	if(!isset($_SESSION["userid"])){
		header("Location: login.php");
		exit();
	}
	
	//väljalogimine
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Andrus Rinde veebiprogrammeerimine</title>
</head>
<body>
	<h1>Foto</h1>
	<p>See leht on loodud õppetöö raames ning ei sisalda mingit tõsiseltvõetavat sisu.</p>
	<p><a href="?logout=1">Logi välja!</a></p>
	<p><a href="main.php">Pealeht</a></p>
	<hr>
	<h2>Kõik süsteemi kasutajad</h2>
	
	<hr>
	
</body>
</html>

