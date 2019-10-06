<?php
//ミッション1-2-3
	$hensu = "hello world";
	$filename = "mission_1-2.txt";
	$fp = fopen($filename,"a");//「a」は大文字にしないこと
	fwrite($fp,$hensu);
	fclose($fp);
?>