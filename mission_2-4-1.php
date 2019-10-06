<html>
	<form action="mission_2-4-1.php" method="post">
		<input type="text" name="comment" value="コメント">
		<input type="submit" value="送信">
	</form>
</html>
<?php
	if(!empty($_POST["comment"])) {
	$filename="mission_2-4.txt";
	$fp=fopen($filename,"a");
	fwrite($fp,$_POST["comment"]."\n");
	fclose($fp);
	$array=file($filename);
	$i=0;
	foreach($array as $value) {
		if($i >= 3) { 
		break;
		}
		echo $value."<br>";
		$i++;
	}
	}
?>