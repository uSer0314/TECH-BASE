<?php

	$filename = "mission_3-5.txt";	//テキストファイル作成

	//投稿フォーム
	if(!empty($_POST["name"]) && !empty($_POST["comment"])) {		//「名前」と「コメント」の入力判定

			//使用する変数の宣言
			$number = 1;	//投稿番号(初期設定)
			$name = $_POST["name"];
			$comment = $_POST["comment"];
			$date = date("Y/m/d H:i:s");
			$password = $_POST["password"];

			if(empty($_POST["editing_No"])) {	//新規投稿判定
					if(file_exists($filename) && count(file($filename)) !== 0) {	//ファイル存在、ファイル内に投稿があるか判定

						$file_array = file($filename);	//ファイル内の投稿を配列に代入
						$number = count(file($filename)) - 1;	//ファイル内の最後の投稿番号を取得
						$element = explode("<>",$file_array[$number]);	//最後の投稿を"<>"で分割し、配列に代入
						$next_number = $element[0] + 1;	//次の投稿番号の設定

					}

					//ファイル書き込み処理（追記）
					$fp = fopen($filename,"a");
					$format = $number."<>".$name."<>".$comment."<>".$date."<>".$password."<>";	//投稿フォーマット
					fwrite($fp,$format."\n");
					fclose($fp);

			}else if(!empty($_POST["editing_No"])) {	//既存投稿判定

					$file_array2 = file($filename);
					$fp = fopen($filename,"w");		//ファイルオープン（初期化）

					foreach($file_array2 as $value) {	//配列の要素数だけループ

						$element = explode("<>",$value);

						if($element[0] == $_POST["editing_No"]) {	//投稿番号と編集番号の一致判定

							//編集した「名前」と「コメント」の取得
							$element[1] = $_POST["name"];
							$element[2] = $_POST["comment"];

							$format2 = $element[0]."<>".$element[1]."<>".$element[2]."<>".$date."<>".$element[4]."<>";	//投稿フォーマット２
							fwrite($fp,$format2."\n");	//ファイルに書き込む

						}else if($element4[0] !== $_POST["editing_No"]) {	//投稿番号と編集番号が不一致
							fwrite($fp,$value);		//編集しない投稿の書き込み
						}

					}
					fclose($fp);
			}


//削除フォーム
}else if(!empty($_POST["delete_No"])) {		//削除番号入力判定
				if(!empty($_POST["delete_pass"])) {		//パスワード入力判定

					$file_array3 = file($filename);
					$fp = fopen($filename,"w");

					foreach($file_array2 as $value2) {	//配列の要素数(入っている中身)だけループ

						$element2 = explode("<>",$value2);

							if($element2[0] !== $_POST["delete_No"]){	//投稿番号と削除番号の一致判定
								fwrite($fp,$value2);	//ファイルに書き込む
							}else {	//投稿番号が一致した場合
								if(!empty($element2[4]) && $_POST["delete_pass"] == $element2[4]) {		//一致した投稿のパスワードが空、一致判定
									//処理なし
								}else {	//パスワードが空、一致しなかった場合
									fwrite($fp,$value2);		//ファイルに書き込む
								}
							}
					}
					fclose($fp);	//ファイルを閉じる
			}

	//編集フォーム
}else if(!empty($_POST["edit_No"])) {	//編集番号が空でない場合
					if(!empty($_POST["edit_pass"])) {	//パスワードが空でない場合

						$fp = fopen($filename,"r");	//ファイルオープン（読み取り専用）
						$file_array4 = file($filename);

						foreach($file_array4 as $value3) {

							$element3 = explode("<>",$value3);

							if($element3[0] == $_POST["edit_No"]) {	//投稿番号と編集番号一致判定
								if(!empty($element3[4]) && $_POST["edit_pass"] == $element3[4]) {		//一致した投稿のパスワードが空、一致判定

									//投稿フォームに表示する編集したい「名前」と「コメント」
									$editing_name = $element3[1];
									$editing_comment = $element3[2];

								}
							}
						}
						fclose($fp);	//ファイルを閉じる
					}
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>mission_3-5</title>
	</head>
	<body>
		<form action="mission_3-5.php" method="post">

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
				<hr/>

		</form>
	</body>
</html>

<?php
	//表示処理
	$filename = "mission_3-5.txt";

	if(file_exists($filename)) {
		$file_display = file($filename);		//ファイル内の投稿を配列に代入

		foreach($file_display as $value_d) {		//配列の要素数だけループ
			if(!empty($value4)) {	//配列の中身が空でないか判定（削除したときに配列が空になるため）

				$element_d = explode("<>",$value_d);
				$format_d = $element_d[0]." ".$element_d[1]." ".$element_d[2]." ".$element_d[3];	//投稿フォーマットの作成
				echo $format_d."<br>";
				echo "<hr>";

			}
		}
	}
?>
