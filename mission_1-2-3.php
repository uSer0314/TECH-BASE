<?php
//�~�b�V����1-2-3
	$hensu = "hello world";
	$filename = "mission_1-2.txt";
	$fp = fopen($filename,"a");//�ua�v�͑啶���ɂ��Ȃ�����
	fwrite($fp,$hensu);
	fclose($fp);
?>