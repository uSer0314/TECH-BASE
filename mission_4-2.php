<?php
	//データベース接続
	$dsn = 'mysql:dbname=tb210407db;host=localhost';
	$user = 'tb-210407';
	$password = 'ZnMkmJhwU7';
	$pdo = new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	//テーブルの作成
	$sql = "CREATE TABLE IF NOT EXISTS "
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT"
	.");";
	$stmt = $pdo->query($sql);
?>