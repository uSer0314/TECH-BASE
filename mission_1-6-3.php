<?php
	$Shiritori = array("しりとり","りんご","ごりら","らっぱ","ぱんだ");
	$memo = "";
	foreach($Shiritori as $value) {
		$memo = $memo.$value;
		echo $memo."<br>";
	}
?>
