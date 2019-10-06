<?php
	//データベース接続
	$dsn = 'mysql:dbname=tb210407db;host=localhost';
	$user = 'tb-210407';
	$password = 'ZnMkmJhwU7';
	$pdo = new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	$id = 1; //変更する投稿番号
	$name = "	(いいい)	";
	$comment = "	(おつかれした)	"; //変更したい名前、変更したいコメントは自分で決めること
	$sql = 'update tbtest set name=:name,comment=:comment where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
?>