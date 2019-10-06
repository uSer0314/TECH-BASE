<html>
	<head>
		<meta charset="utf-8">
		<title>mission_5-1</title>
	</head>
	
	<body>
				
				<?php
					
					//データベース接続
					$dsn = 'データベース名';
					$user = 'ユーザ名';
					$password = 'パスワード';
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
					if(!empty($_POST["name"]) && !empty($_POST["comment"])) {		//入力された「名前」と「コメント」の両方が空でない場合
							
							if(empty($_POST["editingNo"])) {		//新規投稿判定(editingNo：hiddenで受け取った編集中の番号)
							
									$name = $_POST["name"];	 //送られてきた「名前」「コメント」「日付」「パスワード」を変数に代入
									$comment = $_POST["comment"]; 
									$date = date("Y/m/d H:i:s");
									$password = $_POST["password"];
									
									//ファイルに書き込む処理
									$sql = $pdo -> prepare("INSERT INTO Ttable (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
									
									//それぞれの変数内を参照
									$sql -> bindParam(':name', $name, PDO::PARAM_STR);
									$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
									$sql -> bindParam(':date', $date, PDO::PARAM_STR);
									$sql -> bindParam(':password', $password, PDO::PARAM_STR);
									
									$sql -> execute();	//実行
									
							}else if(!empty($_POST["editingNo"])) {		//既存投稿判定(editingNo：hiddenで受け取った編集中の番号)
							
									$id = $_POST["editingNo"]; //変更する投稿番号
									$name = $_POST["name"];	//送られてきた「名前」「コメント」「日付」「パスワード」を変数に代入
									$comment = $_POST["comment"];
									$date = date("Y/m/d H:i:s");
									
									//更新処理
									$sql = 'update Ttable set name=:name, comment=:comment, date=:date where id=:id';	//変数に実行結果を代入
									$stmt = $pdo->prepare($sql);
									
									//それぞれの変数内を参照
									$stmt -> bindParam(':id', $id, PDO::PARAM_INT);
									$stmt -> bindParam(':name', $name, PDO::PARAM_STR);
									$stmt -> bindParam(':comment', $comment, PDO::PARAM_STR);
									$stmt -> bindParam(':date', $date, PDO::PARAM_STR);
									
									$stmt->execute();	//実行
							
							}
					
					//削除フォーム
					}else if(!empty($_POST["deleteNo"])) {		//入力された削除番号が空でない場合
							
							if(!empty($_POST["delete_pass"])) {		//入力されたパスワードが空でない場合
							
							//削除番号とパスワードを変数に代入
							$id = $_POST["deleteNo"];
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
					}else if(!empty($_POST["editNo"])) {		//入力された編集番号が空でない場合
					
							if(!empty($_POST["edit_pass"])) {		//入力されたパスワードが空でない場合
								
								//編集番号とパスワードを変数に代入
								$id = $_POST["editNo"];
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
				
				<form action="mission_5-1.php" method="post">
				
				<!-- 投稿フォーム -->
				<p><label>【投稿フォーム】</label></p>
				<label>名前　　　：</label>
				<input type="text" name="name" value="<?php if(!empty($editing_name)) { echo $editing_name; } ?>"></br>	<!-- valueの中身は、編集したい名前を表示するためのもの -->
				<label>コメント　：</label>
				<input type="text" name="comment" value="<?php if(!empty($editing_comment)) { echo $editing_comment; } ?>"></br>	<!-- valueの中身は、編集したいコメントを表示するためのもの -->
				<input type="hidden" name="editingNo" value = "<?php if(!empty($_POST["editNo"])) { echo $_POST["editNo"]; } ?>"> <!-- 編集番号を保持するための箱「hidden」はテキストボックスを画面上に隠して用意するもの -->
				<label>パスワード：</label>
				<input type="text" name="password">
				<input type="submit" name="submit_send" value="送信">															  
				<br/>
				<br/>
				<!-- 削除フォーム -->
				<p><label>【削除フォーム】</label></p>
				<label>削除番号　：</label>
				<input type="text" name="deleteNo" ></br>
				<label>パスワード：</label>
				<input type="text" name="delete_pass">
				<input type="submit" name="submit_delete" value="削除">
				<br/>
				<br/>
				<!-- 編集フォーム -->
				<p><label>【編集フォーム】</label></p>
				<label>編集番号　：</label>
				<input type="text" name="editNo"></br>
				<label>パスワード：</label>
				<input type="text" name="edit_pass">
				<input type="submit" name="submit_edit" value="編集">
				<br/>
				<br/>
				<!-- テーブル内初期化 -->
				<p><label>【初期化フォーム】</label></p>
				<label>パスワード：</label>
				<input type="text" name="clear">
				<input type="submit" name="submit_trun" value="初期化"></br>
				<br/>
				<label>「082」</label>
				<br/>
				<br/>
				<hr/>
				
				</form>
				
				
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
			
	</body>
	
</html>
