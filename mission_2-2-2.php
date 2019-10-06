<html>
	<form action="mission_2-2-2.php" method="post">
		<input type="text" name="comment" value="コメント">
		<input type="submit" value="送信">
	</form>
</html>
<?php
	if(!empty($_POST["comment"])) {
	$filename="mission_2-2.txt";
	$fp=fopen($filename,"w");
	fwrite($fp,$_POST["comment"]);
	fclose($fp);
	echo file_get_contents("$filename");
	}
?>