<html>
	<form action="mission_2-3.php" method="post">
		<input type="text" name="comment" value="コメント">
		<input type="submit" value="送信">
	</form>
</html>
<?php
	if(!empty($_POST["comment"])) {
		$filename="mission_2-3.txt";
		$fp=fopen($filename,"a");
		fwrite($fp,$_POST["comment"]."\n");
		fclose($fp);
	}
?>