<html>
	<head>
		<meta charset="utf-8">
		<title>mission_3-5</title>
	</head>
	
	<body>
				
				<?php
					
					$filename = "mission_3-5.txt";	//テキストファイルを作成して変数に代入
					
					//投稿フォーム
					if(!empty($_POST["name"]) && !empty($_POST["comment"])) {		//入力された「名前」と「コメント」の両方が空でない場合
							
							$number = 1;	//投稿番号を初期設定
							$name = $_POST["name"];	//POST送信された名前を変数に代入
							$comment = $_POST["comment"];	//POST送信されたコメントを変数に代入
							$date = date("Y/m/d H:i:s");	//投稿した日付を取得し変数に代入
							$password = $_POST["password"];		//POST送信されたパスワードを変数に代入
							
							if(empty($_POST["editingNo"])) {		//新規投稿判定(editingNo：hiddenで受け取った編集中の番号)
							
									if(file_exists($filename) && count(file($filename)) !== 0) {	//ファイルが存在、またはファイル内の投稿があるか判定
										
										//存在、または投稿がある場合
										$file_array = file($filename);	//ファイル内の投稿を配列に代入
										$number = count(file($filename)) - 1;	/* ファイル内の最後の投稿の行数を取得(* 「- 1」をする理由は、
																				   配列の添え字は「0」始まりなので取得した数だと１多いから) */
										$element = explode("<>",$file_array[$number]);		//最後の投稿を"<>"で分割し、それぞれを配列に代入
										$number = $element[0] + 1;	//最後の投稿番号を取得し、次の投稿番号を設定する
											
									}
									
									//ファイルに書き込む処理
									$fp = fopen($filename,"a");		//ファイルを開いて変数に代入("a"は追記モード)
									$format = $number."<>".$name."<>".$comment."<>".$date."<>".$password."<>";	//投稿フォーマットを作成し変数に代入
									fwrite($fp,$format."\n");		//ファイルに投稿を書き込む("\n"は改行を意味する)
									fclose($fp);	//ファイルを閉じる
									
							
							}else if(!empty($_POST["editingNo"])) {		//既存投稿判定(editingNo：hiddenで受け取った編集中の番号)
									
									$file_array4 = file($filename);		//ファイル内の投稿を配列に代入
									$fp = fopen($filename,"w");		//ファイルを初期化して開く
									
									foreach($file_array4 as $value3) {	//配列の要素数だけループ
									
										$element4 = explode("<>",$value3);	//投稿を"<>"で分割し、それぞれを配列に代入
										
										if($element4[0] == $_POST["editingNo"]) {		//保持している編集番号と投稿番号が一致しているか判定
											
											//一致している場合
											$element4[1] = $_POST["name"];	//編集中の投稿の名前を、投稿フォームから送信されてきた名前で上書き
											$element4[2] = $_POST["comment"];	//編集中の投稿の名前を、投稿フォームから送信されてきたコメントで上書き
											
											$format2 = $element4[0]."<>".$element4[1]."<>".$element4[2]."<>".$date."<>".$element[4]."<>";	//投稿フォーマットの作成($dateは編集日時)
											fwrite($fp,$format2."\n");	//ファイル編集した投稿を書き込み
											
										}else if($element4[0] !== $_POST["editingNo"]) {	//保持している編集番号と投稿番号が一致していない場合
											
											fwrite($fp,$value3);		//編集していない投稿の書き込み
											
										}
									}
									
									fclose($fp);	//ファイルを閉じる
									
							}
							
							
					//削除フォーム		
					}else if(!empty($_POST["deleteNo"])) {		//入力された削除番号が空でない場合
							
							if(!empty($_POST["delete_pass"])) {		//入力されたパスワードが空でない場合
							
								$file_array2 = file($filename);		//ファイル内の投稿を配列に代入
								$fp = fopen($filename,"w");		//ファイルを開いて変数に代入("w"は初期化モード)
								
								foreach($file_array2 as $value) {	//配列の要素数(入っている中身)だけループ
									
									$element2 = explode("<>",$value);	/* 投稿を"<>"で分割し、それぞれを配列に代入
																		   (投稿番号、名前、コメント、日付)  */
										
										if($element2[0] !== $_POST["deleteNo"]){		//一致していない場合
											
											fwrite($fp,$value);	//ファイルに投稿を書き込む]
											
										}else {		//投稿番号が一致した場合
											
											if(!empty($element2[4]) && $_POST["delete_pass"] == $element2[4]) {		//一致した投稿のパスワードが空でない、かつパスワードが一致した場合
											
												//書き込まない
											
											}else {		//一致した投稿のパスワードが空、、またはパスワードが一致しなかった場合
											
												fwrite($fp,$value);		//ファイルに書き込む
												
											}
											
										}
									
								}
								
								fclose($fp);	//ファイルを閉じる
								
							}
							
					//編集フォーム		
					}else if(!empty($_POST["editNo"])) {		//入力された編集番号が空でない場合
					
							if(!empty($_POST["edit_pass"])) {		//入力されたパスワードが空でない場合
					
								$fp = fopen($filename,"r");			//ファイルを開く("r"は読み取りモード)
								$file_array3 = file($filename);		//ファイル内の投稿を配列に代入
								
								foreach($file_array3 as $value2) {	//配列の要素数だけループ
									
									$element3 = explode("<>",$value2);	// 投稿を"<>"で分割し、それぞれを配列に代入
									
									if($element3[0] == $_POST["editNo"]) {		//編集番号と投稿番号が一致しているか判定
									
										//一致している場合
										
										if(!empty($element3[4]) && $_POST["edit_pass"] == $element3[4]) {		//一致した投稿のパスワードが空でない、かつパスワードが一致した場合
										
											$editing_name = $element3[1];	//投稿フォームに表示する名前
											$editing_comment = $element3[2];	//投稿フォームに表示するコメント
											
										}
										
									}
									
								}
								
								fclose($fp);	//ファイルを閉じる
							
							}
					}
					
					
				?>
				
								
			<form action="mission_3-5.php" method="post">
			
				<!-- 投稿フォーム -->
				<p><label>【投稿フォーム】</label></p>
				<label>名前　　　：</label>
				<input type="text" name="name" value="<?php if(!empty($editing_name)) { echo $editing_name; } ?>"></br>	<!-- valueの中身は、編集したい名前を表示するためのもの -->
				<label>コメント　：</label>
				<input type="text" name="comment" value="<?php if(!empty($editing_comment)) { echo $editing_comment; } ?>"></br>	<!-- valueの中身は、編集したいコメントを表示するためのもの -->
				<input type="hidden" name="editingNo" value = "<?php if(!empty($_POST["editNo"])) { echo $_POST["editNo"]; } ?>"> <!-- 編集番号を保持するための箱「hidden」はテキストボックスを画面上に隠して用意するもの -->
				<label>パスワード：</label>
				<input type="password" name="password">
				<input type="submit" name="submit_send" value="送信">															  
				<br/>
				<br/>
				<!-- 削除フォーム -->
				<p><label>【削除フォーム】</label></p>
				<label>削除番号　：</label>
				<input type="text" name="deleteNo" ></br>
				<label>パスワード：</label>
				<input type="password" name="delete_pass">
				<input type="submit" name="submit_delete" value="削除">
				<br/>
				<br/>
				<!-- 編集フォーム -->
				<p><label>【編集フォーム】</label></p>
				<label>編集番号　：</label>
				<input type="text" name="editNo"></br>
				<label>パスワード：</label>
				<input type="password" name="edit_pass">
				<input type="submit" name="submit_edit" value="編集">
				<br/>
				<br/>
				<hr/>
			
			</form>
			
			
			<?php
				
				//表示処理
				
				$filename = "mission_3-5.txt";	//テキストファイルを作成
				
				if(file_exists($filename)) {
					
					$file_array5 = file($filename);		//ファイル内の投稿を配列に代入
					
					foreach($file_array5 as $value4) {		//配列の要素数だけループ
					
						if(!empty($value4)) {	//配列の中身が空でないか判定(削除したときに配列が空になるため)
						
							$element5 = explode("<>",$value4);		//"<>"を表示させないために配列を分割
							$format3 = $element5[0]." ".$element5[1]." ".$element5[2]." ".$element5[3];	//投稿フォーマットの作成("<>"なし)
							echo $format3."<br>";	//画面表示("<br>"は画面での改行)
							echo "<hr>";	//各投稿を区切る線
						
						}
						
					}
					
				}
			?>
	</body>
	
</html>