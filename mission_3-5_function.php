<html>
	<head>
		<title>mission_3-5_function</title>
		<meta charset="utf-8">
	</head>
	<body>
		<?php
		
		//グローバル変数の準備
		global $nameE;			//編集対象の名前
		global $commentE;		//編集対象のコメント
		global $isEditing;		//編集フラグ
		
		//メイン
		if(!empty($_POST["name"]) && !empty($_POST["comment"])) {	//投稿処理分岐
				if(!empty($_POST["editingNo"])) {	//新規投稿か既存投稿
					$isEditing = true;	//既存編集フラグ
				}else {
					$isEditing = false;	//新規編集フラグ
				}
				Post();	//投稿フォーム関数呼び出し
				
			}else if(empty($_POST["name"]) && !empty($_POST["comment"])){	//名前が空の場合
				echo "名前が入力されていません";
			}else if(!empty($_POST["name"]) && empty($_POST["comment"])) {	//コメントが空の場合
				echo "コメントが入力されていません";
			}else if(!empty($_POST["deleteNo"])) {	//削除分岐処理
				Delete();	//削除フォーム関数
			}else if(!empty($_POST["editNo"]))	{	//編集分岐処理
				Edit();		//編集フォーム関数
			}
			

		 //投稿フォーム関数
		 function Post() {
		 		
		 		//グローバル変数呼び出し
		 		global $isEditing;	//編集フラグ呼び出し
		 		
				if(!empty($_POST["name"]) && !empty($_POST["comment"])) {	//名前かつコメントが空でないか判定
					
					$filename = "mission_3-5_function.txt";	//ファイル変数の定義
					$date = date("Y/m/d H:i:s");	//現在日時を取得し変数に代入
					$name = $_POST["name"];	//名前を取得し変数に代入
					$comment = $_POST["comment"];	//コメントを取得し変数に代入
					$fp = fopen($filename,"a");	//ファイルオープン(追加モード)
					$post = file($filename);	//ファイルを配列に代入
					$count = count(file($filename));	//ファイル内の行数を取得
					$num = 1;	//投稿番号初期化
					
					if($isEditing === false) {	//新規投稿判定
					
					if($count == 0 && empty($post)) {	//ファイルが空の場合
						fwrite($fp,$num."<>".$_POST["name"]."<>".$_POST["comment"]."<>".$date."<>".$_POST["pass_post"]."<>"."\n");	//一番目の投稿の書き込み
						
					} else {	//ファイルが空でない場合
						
						$i = count(file($filename))-1;	//ファイル内の最終行の添え字
						$ele = explode("<>",$post[$i]);	//ファイル内の最後行を区切る
						$num = $ele[0] +1;	//次の投稿番号の取得
									
			   			$format = $num."<>".$_POST["name"]."<>".$_POST["comment"]."<>".$date."<>".$_POST["pass_post"]."<>";	//保存フォーマットの作成
						fwrite($fp,$format."\n");	//テキストファイルに書き込み
					}
					fclose($fp);	//ファイルクローズ
					}
					
				
						
					if($isEditing) {	//既存編集
					
						$editing = file($filename);	//ファイルを配列に代入
						$fp = fopen($filename,"w");	//ファイルを開いて(初期化モード)して変数に代入
			
							for($i=0; $i < $count; $i++) {	//ファイル内の行数だけループ
							
								$el = explode("<>",$editing[$i]);
							
								if($el[0] == $_POST["editingNo"]) {	//編集番号と投稿番号が一致したとき
								
									$el[0] = $_POST["editingNo"];	//編集番号を配列に代入
									$el[1] = $_POST["name"];	//名前を配列に代入
									$el[2] = $_POST["comment"];	//コメントを配列に代入
									fwrite($fp,$el[0]."<>".$el[1]."<>".$el[2]."<>".$date."<>".$_POST["pass_post"]."<>"."\n");	//ファイルに書き込み
																	
								} else {	//編集番号と投稿番号が一致しないとき
									fwrite($fp,$el[0]."<>".$el[1]."<>".$el[2]."<>".$date."<>".$el[4]."<>"."\n");	//ファイルに書き込み
								}
							}
						fclose($fp);	//ファイルクローズ
										
					}
			}
			
			}
			
		 //削除フォーム関数
		 function Delete() {
		 	 	
			 if(!empty($_POST["deleteNo"])) {	//削除番号が空でないか判定
			 	$filename = "mission_3-5_function.txt";	//ファイル変数の定義
		 		if(count(file($filename)) >= $_POST["deleteNo"]) {
			 		$editAr = file($filename);
			 		for($j=0; $j < count(file($filename)); $j++) { //行数分だけループ
						$eA = explode("<>",$editAr[$j]);	//配列分割
						if($eA[0] == $_POST["deleteNo"]) {	//削除番号と投稿番号が一致したとき
							if($eA[4] == $_POST["pass_delete"]) {	//パスワードが一致したとき
								$count = count(file($filename));	//ファイル内の行数を取得
								$delete = file($filename);	//ファイルを読み込んで配列に代入
								$fp = fopen($filename,"w");	//ファイルオープン(初期化モード)
					
								for($i=0; $i < $count; $i++) {	//ファイル内の行数だけループ
									$el = explode("<>",$delete[$i]);	//配列を分割
									
									if($el[0] != $_POST["deleteNo"]) {	//削除番号と投稿番号が一致しないとき
										fwrite($fp,$el[0]."<>".$el[1]."<>".$el[2]."<>".$el[3]."<>".$el[4]."<>"."\n");	//ファイルに書き込み
									}else{	//削除番号と投稿番号が一致したとき
											//ファイルに書き込まない
									}
									
						 		}
						 		
								fclose($fp);	//ファイルクローズ
			 
			 					}else {
			 						echo "パスワードが正しくありません";
			 					}
			 
			 				}
			 
			 			}
			 
			 		}
			 
			 	}
		}
			
		//編集フォーム関数
		function Edit() {
			
			//グローバル変数呼び出し
			global $nameE;	//編集名前
			global $commentE;	//編集コメント
			
			
			//変数の初期化
			$nameE = "";
			$commentE = "";
			
				if(!empty($_POST["editNo"])) {	//編集番号が空でないとき
					$filename = "mission_3-5_function.txt";
					if(count(file($filename)) >= $_POST["editNo"]) {	//編集番号が行数以上指定されていないか
						
						$editAr = file($filename);	//ファイルを読み込んで配列に代入
						
						for($i=0; $i < count(file($filename)); $i++) {	//行数分だけループ
							
							$eA = explode("<>",$editAr[$i]);	//配列分割
							
							if($eA[0] == $_POST["editNo"]) {	//編集番号と投稿番号が一致したとき
								if($eA[4] == $_POST["pass_edit"]) {	//パスワードが一致したとき
									
									$filename = "mission_3-5.txt";	//ファイル変数の定義
									$date = date("Y/m/d H:i:s");	//日付変数
									$edit = file($filename);	//ファイルを読み込んで配列に代入
									$count = count(file($filename));	//ファイル内を行数を取得
									$fp = fopen($filename,"r+");	//ファイルオープン(読み書きモード)

									for($i=0; $i < $count; $i++) {	//ファイル内の行数だけループ
										$el = explode("<>",$edit[$i]);	//配列を分割

										if($el[0] == $_POST["editNo"]) {	//編集番号と投稿番号が一致したとき
											
											$nameE = $el[1];	//配列内の名前を変数に代入
											$commentE = $el[2];	//配列内のコメントを変数に代入

										}
										
									}

								}else {
									echo "パスワードが正しくありません";
								}
				
							}
				
						}
				
					}
				}	
		}
	?>
	
		<form action="mission_3-5_function.php" method="post">
		
【入力フォーム】<br/>
		
		名前：<input type="text" name="name" value="<?php global $nameE;	echo $nameE; ?>"><br/>
		コメント：<input type="text" name="comment" value="<?php global $commentE;	echo $commentE; ?>"><br>
		パスワード：<input type="password" name="pass_post" >
		<input type="hidden" name="editingNo" value = "<?php if(!empty($_POST["editNo"])) { echo $_POST["editNo"]; } ?>">
		<input type="submit" value="送信"><br/>
		<br/>
		
【削除フォーム】<br/>
	    削除対象番号：<input type="text" name="deleteNo" ><br/>
	    パスワード：<input type="password" name="pass_delete" >
	    <input type="submit" value="削除"><br/>
	    <br/>

【編集フォーム】<br/>
		編集対象番号:<input type="text" name="editNo" value=""><br/>
		パスワード：<input type="password" name="pass_edit" >
		<input type="submit" value="編集"><br/>
		<hr/>
		
		
		<?php
			//表示処理
			$Farray = file("mission_3-5_function.txt");
			foreach($Farray as $value) {
				$El = explode("<>",$value);
				echo $El[0]." ".$El[1]." ".$El[2]." ".$El[3]."<br>";
			}
		?>
	</form>
	</body>
</html>