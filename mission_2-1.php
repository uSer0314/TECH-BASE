<html>
	<form action="mission_2-1.php" method="post">
		<input type="text" name="comment" value="コメント">
		<input type="submit" value="送信">
	</form>
</html>
<?php
	$comment=$_POST["comment"];
	echo $comment."(送信内容)を受け付けました";
?>