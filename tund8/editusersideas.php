<?php
	require("functions.php");
	require("editideafunctions.php");
	
	$notice = "";
	$ideas = "";
	
	//kui pole sisse logitud, liigume login lehele
	if(!isset($_SESSION["userid"])){
		header("Location: login.php");
		exit();
	}
	
	//väljalogimine
	if(isset($_GET["logout"])){
		session_destroy(); //lõpetab sessiooni
		header("Location: login.php");
		exit();
	}
	
	//kas vajutati mõtte salvestamise nuppu
	if(isset($_POST["ideaBtn"])){
		updateIdea($_POST["id"], test_input($_POST["idea"]), $_POST["ideaColor"]);
		header("Location: ?id=" .$_POST["id"]);
	}	
	
	if(isset($_GET["delete"])){
		deleteIdea($_GET["id"]);
		header("Location: usersideas.php");
		exit();
	}
	
	if(isset($_GET["id"])){
		$currentIdea = getSingleIdea($_GET["id"]);
	}
	

	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
		RAndo veebiprogemise asjad
	</title>
</head>
<body>
	
	<p>See veebileht on loodud õppetöö raames ning ei sisalda tõsiseltvõetavat sisu.</p>
	<p><a href="?logout=1">Logi välja</a></p>
	<p><a href="usersideas.php">tagasi mõtete lehele</a></p
	<h2>Head mõtted</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<!-- Peidetud sisend -->
		<input name="id" type="hidden" value="<?php echo $_GET["id"]; ?>">
		<label>Hea mõte: </label>
		<textarea name="idea"><?php echo $currentIdea->text; ?> </textarea>
		<br>
		<label>Mõttega seostuv värv: </label>
		<input name="ideaColor" type="color" value="<?php echo $currentIdea->color; ?>">
		<br>
		
		<input name="ideaBtn" type="submit" value="Salvesta mõte!"><span><?php echo $notice; ?></span>
	</form>
	<p><a href="?id=<?php echo $_GET["id"]; ?>&delete=true">Kustuta</a> see mõte!</p>
	
	<hr>

</body>
</html>