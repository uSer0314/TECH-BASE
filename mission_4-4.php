<?php
	//データベース接続
	$dsn = 'mysql:dbname=tb210407db;host=localhost';
	$user = 'tb-210407';
	$password = 'ZnMkmJhwU7';
	$pdo = new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	$sql ='SHOW CREATE TABLE ';
	$result = $pdo -> query($sql);
	foreach ($result as $row){
		echo $row[1];
	}
	echo "<hr>";
?>