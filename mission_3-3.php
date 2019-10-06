<html>
	<head>
		<title>mission_3-3</title>
		<meta charset="utf-8">
	</head>
	<body>
		<form action="mission_3-3.php" method="post">
		
【入力フォーム】<br/>
		名前:    <input type="text" name="name" value=""><br/>
		コメント:<input type="text" name="comment" value="">
		<input type="submit" value="送信"><br/>
		<br/>
【削除番号指定用フォーム】<br/>
	    削除対象番号:<input type="text" name="deleteNo" value="">
	    <input type="submit" value="削除"> 
		<hr/>
	</form>
	
	<?php
		//メイン
		if(!empty($_POST["name"]) && !empty($_POST["comment"])) {
				Post();
			} else if(!empty($_POST["deleteNo"])) {
				Delete();	
			}
	
	
		//投稿フォーム関数
		function Post() {
			//echo "投稿フォーム<br>";
				if(!empty($_POST["name"]) && !empty($_POST["comment"])) {	//名前かつコメントが空でないか判定
					$filename = "mission_3-3.txt";
					$name = $_POST["name"];	//名前を取得し変数に代入
					$comment = $_POST["comment"];	//コメントを取得し変数に代入
					$date = date("Y/m/d H:i:s");	//現在日時を取得し変数に代入
					$fp = fopen($filename,"a");
					$post = file($filename);
					$count = count(file($filename));
					$num = 1;
					
					if($count == 0 && empty($post)) {
						fwrite($fp,$num."<>".$_POST["name"]."<>".$_POST["comment"]."<>".$date."\n");
						//echo "なし";
					}else {
						//echo "あり";
						$i = count(file($filename))-1;
						$ele = explode("<>",$post[$i]);	//一番最後の行を区切る
						$num = $ele[0] +1;	//一番最後の行番号の次番号を取得
											
			   			$format = $num."<>".$_POST["name"]."<>".$_POST["comment"]."<>".$date;	//保存フォーマットの作成
						fwrite($fp,$format."\n");	//ファイルに書き込み
					}	//配列の添え字
					$post = file($filename);	//配列の更新
					for($j=0; $j < $count+1; $j++) {
						echo $post[$j]."<br>";
					}
					fclose($fp);
					

					//echo $_POST["name"]."<br>";
					//echo "aaaa";
						}
			}
			
		//投稿削除フォーム関数
		 function Delete() {
		 //echo "削除フォーム";
				 if(!empty($_POST["deleteNo"])) {	//削除番号が空でないか判定
				 	$filename = "mission_3-3.txt";
					$count = count(file($filename));
					$delete = file($filename);	//ファイルを読み込んで変数に代入
					$fp = fopen($filename,"w");
						
						for($i = 0; $i < $count; $i++) {
							$el = explode("<>",$delete[$i]);
							
							if($el[0] != $_POST["deleteNo"]) {
								fwrite($fp,$el[0]."<>".$el[1]."<>".$el[2]."<>".$el[3]);
								
							}else{
							//echo "削除";
							}
							
				 		}
				 		$delete = file($filename);
				 		foreach($delete as $value) {
				 			echo $value."<br>";
				 		}
					fclose($fp);
				}
			}
?>

	</body>
</html>
