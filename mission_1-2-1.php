<?php
//�~�b�V����1-2-1
	$hensu = "hello world";
	$filename = "mission_1-2.txt";
	$fp = fopen($filename,"w");//�uw�v�͑啶���ɂ��Ȃ�����
	fwrite($fp,$hensu);
	fclose($fp);
?>