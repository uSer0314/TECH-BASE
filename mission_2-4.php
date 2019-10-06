<html>
	<form action="mission_2-4.php" method="post">
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
		
			foreach($array as $value) {	//配列の要素数だけループ
			echo $value."<br>";
	}
	}
?>