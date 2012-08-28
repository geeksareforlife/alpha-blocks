<?php
$aCubes = array(
				array("E","T","I","C","G","Z"),
				array("E","T","I","U","B",""),
				array("E","T","I","L","M",""),
				array("E","T","D","F","P",""),
				array("E","H","O","I","A",""),
				array("E","H","O","I","A",""),
				array("E","H","O","I","Y",""),
				array("E","H","O","A","W",""),
				array("E","H","O","A","J",""),
				array("E","H","O","A","K",""),
				array("E","O","A","U","I","Y"),
				array("E","O","A","L","Q",""),
				array("N","R","T","D","F",""),
				array("N","R","T","V","G",""),
				array("N","R","I","S","M",""),
				array("N","R","S","Y","P",""),
				array("N","R","S","U","W",""),
				array("N","R","S","L","X",""),
				array("I","A","D","V","U","B"),
				array("I","A","D","C","L","G"),
				);

$aTestwords = array(
					"JAMES",
					"CAROLINE",
					"INTERNET",
					);

if (isset($_POST['words'])) {
	$sWords = $_POST['words'];
	if (strpos($sWords, "\n") !== false) {
		$aTestwords = array_map('strtoupper', array_map('trim', explode("\n", $sWords)));
	}
}
else {
	$sWords = "";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-gb">
<head>
<title>Cube Test Results</title>

<link href="cubetest.css" rel="stylesheet" type="text/css" media="screen" />

</head>
<body>

<h1>Cube Test Results</h1>

<form action="cubetest.php" method="POST">
<p>Enter words:</p>
<textarea rows="10" cols="60" name="words"><?php echo($sWords); ?></textarea><br />
<input type="submit" name="submit" value="submit" />

</form>

<?php

foreach ($aTestwords as $sTestword) {
	$aCubeList = makeWord($sTestword, $aCubes);
	$aWord = str_split($sTestword);
	?>
	<div class="word">
	<?php
	if ($aCubeList == false) {
		?>
		<p><?php echo($sTestword); ?> : Not possible</p>
		<?php
	}
	else {
		for ($i = 0; $i < count($aCubeList); $i++) {
		?>
		<div class="letter">
			<p class="cube"><?php echo(strtolower($aWord[$i])); ?></p>
			<p><?php echo($aCubeList[$i]); ?></p>
		</div>	
		<?php
		}
	}
		?>
	</div>
	<?php
}

?>


</body>
</html>

<?php

function makeWord($sWord, $aCubes) {
	
	$aCubeList = array();
	
	$aWord = str_split($sWord);
	$sLetter = array_shift($aWord);
	
	
	for ($i = 0; $i < count($aCubes); $i++) {
		if (in_array($sLetter, $aCubes[$i])) {
			$aNewCubes = $aCubes;
			$aNewCubes[$i] = array();
			if (count($aWord) > 0) {
				$aNewList = makeWord(implode("", $aWord), $aNewCubes);
			}
			else {
				$aNewList = array();
			}
			if ($aNewList === false) {
				continue;
			}
			else {
				$aCubeList = array_merge(array($i), $aNewList);
				#var_dump($aCubeList);
				break;
			}
		}
	}
	
	if ($aCubeList != array()) {
		return $aCubeList;
	}
	else {
		return false;
	}
}

?>

