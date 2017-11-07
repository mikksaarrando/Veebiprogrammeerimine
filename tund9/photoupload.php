<?php
	require("../../../config.php");
	require("functions.php");
	$database ="if17_mikkrand";
	$notice = "";
	
	
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
	
	//Algab foto laadimise osa
	$target_dir = "../../pics/";
	$target_file = "";
	$uploadOk = 1;
	$imageFileType = "";
	$maxWidth = 600;
	$maxHeight = 400;
	$marginBottom =10;
	$marginRight = 10;
	//Kas vajutati nuppi
	if(isset($_POST["submit"])) {
			
			//kas file on valitud
			if(!empty($_FILES["fileToUpload"]["name"])){
			
			//fiktseerin nime laiendi
			$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
			
			//ajatempel
			$timestamp = microtime(1) * 10000;
			
			//fiktseerin nime
			$target_file = $target_dir . pathinfo(basename($_FILES["fileToUpload"]["name"]))["filename"] ."_" .$timestamp ."." .$imageFileType;
		
		//kas on pildidl failitüüp
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			$notice .= "Fail on pilt - " . $check["mime"] . ". ";
			$uploadOk = 1;
		} else {
			$notice .= "See pole pildifail. ";
			$uploadOk = 0;
		}
		
			//Kas selline pilt on juba üles laetud
		if (file_exists($target_file)) {
			$notice .= "Kahjuks on selle nimega pilt juba olemas. ";
			$uploadOk = 0;
		}
		
		//Piirame faili suuruse
		if ($_FILES["fileToUpload"]["size"] > 1000000) {
			$notice .= "Pilt on liiga suur! ";
			$uploadOk = 0;
		}
		
		//Piirame failitüüpe
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			$notice .= "Vabandust, vaid JPG, JPEG, PNG ja GIF failid on lubatud! ";
			$uploadOk = 0;
		}
		
		//Kas saab laadida?
		if ($uploadOk == 0) {
			$notice .= "Vabandust, pilti ei laetud üles! ";
		//Kui saab üles laadida
		} else {		
			/*if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				$notice .= "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti üles! ";
			} else {
				$notice .= "Vabandust, üleslaadimisel tekkis tõrge! ";
			} */
			
			//lähtudes faili formaadist, lookme pildi objekti
			if($imageFileType == "jpg" or $imageFileType == "jpeg"){
				$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
			}
			if($imageFileType == "png"){
				$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
			}
			if($imageFileType == "gif"){
				$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
			}
			
			//teeme kindlaks originaal suuruse
			$imageWidth = imagesx($myTempImage);
			$imageHeight = imagesy($myTempImage);
			if($imageWidth > $imageHeight){
				$sizeRatio = $imageWidth / $maxWidth;
			} else {
				$sizeRatio = $imageHeight / $maxHeight;	
			}
			//muudame suurust
			$myImage = resizeImage($myTempImage, $imageWidth, $imageHeight, round($imageWidth / $sizeRatio), round($imageHeight / $sizeRatio));
			
			//lisame vesimärgi
			$stamp = imagecreatefrompng("/home/mikkrand/public_html/Veebiprogrammeerimine/tund9/hmv_logo.png");
			$stampWidth = imagesx($stamp);
			$stampHeight = imagesy($stamp);
			$stampPosX = round($imageWidth / $sizeRatio) - $stampWidth - $marginRight;
			$stampPosY = round($imageHeight / $sizeRatio) - $stampHeight - $marginBottom;
			imagecopy($myImage, $stamp, $stampPosX, $stampPosY, 0, 0, $stampWidth, $stampHeight);
			
			//lisame teksti
			$textToImage = "Heade Mõtete veeb";
			$textColor = imagecolorallocatealpha($myImage, 255, 255, 255, 60); //0 ... 127
			imagettftext($myImage, 20, 0, 10, 25, $textColor, "../../graphics/ARIALBD.TTF", $textToImage);
			
			//faili salvestamine
			if($imageFileType == "jpg" or $imageFileType == "jpeg"){
				if(imagejpeg($myImage, $target_file, 90)){
					$notice = "Fail: " .$_FILES["fileToUpload"]["name"] ." laeti Üles!";
				} else {
				$notice = "faili üleslaadimine õnnestus!";
				}
			}
			
			if($imageFileType == "png"){
				if(imagepng($myImage, $target_file, 6)){
					$notice = "Fail: " .$_FILES["fileToUpload"]["name"] ." laeti Üles!";
				} else {
				$notice = "faili üleslaadimine õnnestus!";
				}
			}
			if($imageFileType == "gif"){
				if(imagegif($myImage, $target_file)){
					$notice = "Fail: " .$_FILES["fileToUpload"]["name"] ." laeti Üles!";
				} else {
				$notice = "faili üleslaadimine õnnestus!";
				}
			}
		} // kas saab laadida lõppeb
		 
			} else {
		
		}//kas fail oli valitud lõppeb
	}//if vajutati nuppu lõppeb
	
	function resizeimage($image, $origW, $origH, $w, $h){
		$newImage = imagecreatetruecolor($w, $h);
		imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $origW, $origH);
		return $newImage;
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

	<table>
	<tr>
	<td width="100" height="20"><p><a href="?logout=1">Logi välja</a></p></td>
	<td><p><a href="main.php">Pealeht</a></p></td>
	</tr>
	</table>
	<br>
	
		<p><b>Siin saab pilte üles laadida</b></p>
	<form action="photoupload.php" method="post" enctype="multipart/form-data">
	Vali pilt mida üles laadida:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Lae Üles" name="submit">
</form>

	
</body>
</html>