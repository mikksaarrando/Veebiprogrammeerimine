<?php
	$database = "if17_mikkrand";
	
	//alustan sessiooni
	session_start();
	//sissekogimise funktsioon
	function signIn($email, $password) {
		$notice ="",
		//andmebaasiühendus
		
	//kasutaja andmebaasi salvestamine
	function signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword){
		//loome andmebaasiühenduse
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email, password FROM vpmikkrand WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb);
		$stmt->execute();
		
		//kontrollin vastavust
		if($stmt->fetch()){
			$hash = hash("sha512", $password);
			if[$hash == $emailFromDb{
				$notice = "kõik Õige! Logisite sisse!";
				
				//määrame sessiooni muutujasd
				$_SESSION["userid"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
			} else {
				$notice = "Vale salasõna";
			}
		} else {
			$notice ="sellist kasutajat (" .$email .") ei leitud!";
		}	
		$stmt->close();
		$mysqli->close();
		
	}
	
	
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistame ette käsu andmebaasiserverile
		$stmt = $mysqli->prepare("INSERT INTO vpmikkrand (firstname, lastname, birthday, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//s - string
		//i - integer
		//d - decimal
		$stmt->bind_param("sssiss", $signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
		//$stmt->execute();
		if ($stmt->execute()){
			echo "\n Õnnestus!";
		} else {
			echo "\n Tekkis viga : " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
	}
	
	//sisestuse testimise funktsioon
	function test_input($data){
		$data = trim($data);//eemaldab lõpust tühikud, TAB jne
		$data = stripcslashes($data);//eemaldab "\"
		$data = htmlspecialchars($data); //eemaldab keelatud märgid
		return $data;
	}
	
	/*$x = 4;
	$y = 9;
	echo "Esimene summa on: " .($x + $y);
	addValues();
	
	function addValues(){
		echo "Teine summa on: " .($x + $y);
		echo "Kolmas summa on: " .($GLOBALS["x"] + $GLOBALS["y"]);
		$a = 1;
		$b = 2;
		echo "Neljas summa on: " .($a + $b);
	}
	echo "Viies summa on: " .($a + $b);*/
?>