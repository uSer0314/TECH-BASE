<html>
	<head>
		<title>mission_3-1</title>
		<meta charset="utf-8">
	</head>
	<body>
		<form action="mission_3-1.php" method="post">
		名前:<input type="text" name="name" value=""><br/>
		コメント:<input type="text" name="comment" value=""><br/>
		<input type="submit" value="送信">
	</form>
	
	<?php

	
	if(!empty($_POST["name"]) || !empty($_POST["comment"])) {	//名前またはコメントが空でないか判定
		$filename="mission_3-1.txt";
		$fp=fopen($filename,"a");

   		$num = count( file( $filename ) );	//ファイルのデータの行数を数えて$numに代入
   		$num++;	//次の投稿番号の取得
   		$date = date("Y/m/d H:i:s");	//現在日時を取得し、$dateに代入
   		
   		$format = $num."<>".$_POST["name"]."<>".$_POST["comment"]."<>".$date;	//保存フォーマットの作成
   	
		fwrite($fp,$format."\n");
		fclose($fp);
   	}
?>

	</body>
</html>

