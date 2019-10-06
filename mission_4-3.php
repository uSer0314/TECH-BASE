<?php
	//データベース接続
	$dname = 'データベース名';
	$user = 'ユーザ名';
	$password = 'パスワード';
	$pdo = new PDO($dname,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	$sql = 'SHOW TABLES';
	$result = $pdo -> query($sql);
	foreach ($result as $row) {
		echo $row[0]."<br>";
	}
	echo "<hr>";
?>
