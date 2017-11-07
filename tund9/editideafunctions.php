<?php
	require("../../../config.php");
	$database ="if17_mikkrand";
	
	//ühe kindla mõtte lugemine
	function getSingleIdea($id) {
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT idea, color FROM vpuserideas WHERE id=?");
		$stmt->bind_param("i", $id);
		$stmt->bind_result($idea, $color);
		$stmt->execute(); 
		$ideaObjeact = new Stdclass();
		if($stmt->fetch()){
			$ideaObjeact->text = $idea;
			$ideaObjeact->color = $color;
		} else {
			//kui sellist mõtet ei leitud
			header("Location: usersideas.php");
			exit();
		}
		
	
		$stmt->close();
		$mysqli->close();
		return $ideaObjeact;
	}
	
	function updateIdea($id, $idea, $color){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);	
		$stmt = $mysqli->prepare("UPDATE vpuserideas SET idea=?, color=? WHERE id=?");
		$stmt->bind_param("ssi", $idea, $color, $id); 
		$stmt->execute();
		
		$stmt->close();
		$mysqli->close();
	}
	
	function deleteIdea($id) {
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);	
		$stmt= $mysqli->prepare("UPDATE vpuserideas SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		$stmt->execute;
		$stmt->close();
		$mysqli->close();
	}
?>