<html>
	<form action="mission_2-2-1.php" method="post">
		<input type="text" name="comment" value="コメント">
		<input type="submit" value="送信">
	</form>
</html>
<?php
	$comment=$_POST["comment"];
	$filename="mission_2-2.txt";
	$fp=fopen($filename,"w");
	fwrite($fp,$comment);
	fclose($fp);
	echo file_get_contents("$filename");
?>