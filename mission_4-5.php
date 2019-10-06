<?php
	//データベース接続
	$dsn = 'mysql:dbname=tb210407db;host=localhost';
	$user = 'tb-210407';
	$password = 'ZnMkmJhwU7';
	$pdo = new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	$sql = $pdo -> prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$name = '	あああ	';
	$comment = '	あざます	'; //好きな名前、好きな言葉は自分で決めること
	$sql -> execute();
	
	echo "<hr>";
?>