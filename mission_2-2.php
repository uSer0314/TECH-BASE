<html>
	<form action="mission_2-2.php" method="post">
		<input type="text" name="comment" value="コメント">
		<input type="submit" value="送信">
	</form>
</html>
<?php
	if(!empty($_POST["comment"])) {	//コメントが空かどうか判定
		$filename="mission_2-2.txt";
		$fp=fopen($filename,"w");
		fwrite($fp,$_POST["comment"]);
		fclose($fp);
		
		if(file_get_contents("$filename") == "完成！") {	//コメントが「完成！」のとき「おめでとう！」を表示
			echo "おめでとう！";
		} else {
			echo file_get_contents("$filename");
		}
	}
?>