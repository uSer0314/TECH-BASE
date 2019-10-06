<?php
//ミッション1-2-1
	$hensu = "hello world";
	$filename = "mission_1-2.txt";
	$fp = fopen($filename,"w");//「w」は大文字にしないこと
	fwrite($fp,$hensu);
	fclose($fp);
?>