<?php

	//データベース接続
	$dsn = 'mysql:dbname=tb210407db;host=localhost';
	$user = 'tb-210407';
	$password = 'ZnMkmJhwU7';
	$pdo = new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	//テーブルの作成
	$sql = "CREATE TABLE IF NOT EXISTS Ttable" //テーブル名に予約語、ハイフンを使用できない
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "date char(32),"
	. "password char(32)"
	.");";
	$stmt = $pdo->query($sql);

	//投稿フォーム
	if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"])) {	//「名前」と「コメント」と「パスワード」の入力判定
			if(empty($_POST["editing_No"])) {	//新規投稿判定

					//変数の宣言
					$name = $_POST["name"];
					$comment = $_POST["comment"];
					$date = date("Y/m/d H:i:s");
					$password = $_POST["password"];

					//挿入処理
					$sql = $pdo -> prepare("INSERT INTO Ttable (name, comment, date, password) VALUES (:name, :comment, :date, :password)");

					$sql -> bindParam(':name', $name, PDO::PARAM_STR);
					$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
					$sql -> bindParam(':date', $date, PDO::PARAM_STR);
					$sql -> bindParam(':password', $password, PDO::PARAM_STR);

					$sql -> execute();	//実行

			}else if(!empty($_POST["editing_No"])) {	//既存投稿判定

					$id = $_POST["editing_No"]; //編集する投稿番号
					$name = $_POST["name"];
					$comment = $_POST["comment"];
					$date = date("Y/m/d H:i:s");

					//更新処理
					$sql = 'update Ttable set name=:name, comment=:comment, date=:date where id=:id';	//変数に実行結果を代入
					$stmt = $pdo->prepare($sql);

					$stmt -> bindParam(':id', $id, PDO::PARAM_INT);
					$stmt -> bindParam(':name', $name, PDO::PARAM_STR);
					$stmt -> bindParam(':comment', $comment, PDO::PARAM_STR);
					$stmt -> bindParam(':date', $date, PDO::PARAM_STR);

					$stmt->execute();

			}

	//削除フォーム
}else if(!empty($_POST["delete_No"])) {	//入力された削除番号が空でない場合
					if(!empty($_POST["delete_pass"])) {	//入力されたパスワードが空でない場合

						//削除番号とパスワードを変数に代入
						$id = $_POST["delete_No"];
						$password = $_POST["delete_pass"];

						//削除処理
						$sql = 'delete from Ttable where id=:id and password=:password';
						$stmt = $pdo->prepare($sql);

						//それぞれの変数内を参照
						$stmt->bindParam(':id', $id, PDO::PARAM_INT);
						$stmt -> bindParam(':password', $password, PDO::PARAM_STR);
						$stmt->execute();

						}

	//編集フォーム
}else if(!empty($_POST["edit_No"])) {		//入力された編集番号が空でない場合
					if(!empty($_POST["edit_pass"])) {		//入力されたパスワードが空でない場合

						//編集番号とパスワードを変数に代入
						$id = $_POST["edit_No"];
						$password = $_POST["edit_pass"];

						//編集目的の「名前」と「コメント」を表示する処理
						$sql = "SELECT * FROM Ttable where id=:id and password=:password";
						$stmt = $pdo->prepare($sql);

						//それぞれの変数内を参照
						$stmt->bindParam(':id', $id, PDO::PARAM_INT);
						$stmt -> bindParam(':password', $password, PDO::PARAM_STR);

						$stmt -> execute();	//実行

						$result = $stmt->fetchAll();	//表示処理の結果を取得し、配列に代入

						//目的の投稿の「名前」と「コメント」を変数に代入
						foreach($result as $row) {

							$editing_name = $row[1];
							$editing_comment = $row[2];

						}
					}

	//初期化フォーム
	}else if(!empty($_POST["clear"])) {

		$pass_defaults = "082";	//初期化デフォルトパスワード
		$password = $_POST["clear"];

		if($password == $pass_defaults) {	//初期化処理

			$sql = "TRUNCATE TABLE Ttable;";	//テーブルの中身を初期化する（：AUTO_INCREMENTの情報も削除）
			$stmt = $pdo->query($sql);

		}
	}

?>

<!DOCTYPE >
﻿<html>
	<head>
		<meta charset="utf-8">
		<title>mission_5-1</title>
	</head>
	<body>
				<form action="mission_5-1.php" method="post">

				<!-- 投稿フォーム -->
				<p><label>【投稿フォーム】</label></p>
				<label>名前　　　：</label>
				<input type="text" name="name" value="<?php if(!empty($editing_name)) { echo $editing_name; } ?>"></br>	<!-- valueの中身は、編集したい名前を表示するためのもの -->
				<label>コメント　：</label>
				<input type="text" name="comment" value="<?php if(!empty($editing_comment)) { echo $editing_comment; } ?>"></br>	<!-- valueの中身は、編集したいコメントを表示するためのもの -->
				<input type="hidden" name="editing_No" value = "<?php if(!empty($_POST["edit_No"])) { echo $_POST["edit_No"]; } ?>"> <!-- 編集番号を保持するための箱「hidden」はテキストボックスを画面上に隠して用意するもの -->
				<label>パスワード：</label>
				<input type="password" name="password">
				<input type="submit" name="submit_send" value="送信">
				<br/>
				<br/>
				<!-- 削除フォーム -->
				<p><label>【削除フォーム】</label></p>
				<label>削除番号　：</label>
				<input type="text" name="delete_No" ></br>
				<label>パスワード：</label>
				<input type="password" name="delete_pass">
				<input type="submit" name="submit_delete" value="削除">
				<br/>
				<br/>
				<!-- 編集フォーム -->
				<p><label>【編集フォーム】</label></p>
				<label>編集番号　：</label>
				<input type="text" name="edit_No"></br>
				<label>パスワード：</label>
				<input type="password" name="edit_pass">
				<input type="submit" name="submit_edit" value="編集">
				<br/>
				<br/>
				<!-- テーブル内初期化 -->
				<p><label>【初期化フォーム】</label></p>
				<label>パスワード：</label>
				<input type="password" name="clear">
				<input type="submit" name="submit_trun" value="初期化"></br>
				<br/>
				<label>初期化パスワード➡「082」</label>
				<br/>
				<br/>
				<hr/>

				</form>
	</body>

</html>

<?php
//表示処理
$sql = 'SELECT * FROM Ttable';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
	//$rowの中にはテーブルのカラム(列)名が入る
	echo $row['id'].' ';
	echo $row['name'].' ';
	echo $row['comment'].' ';
	echo $row['date'].'<br>';
	echo "<hr>";
}

?>
