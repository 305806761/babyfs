<?php
$a = '宝宝玩英语&启蒙馆006';
$pattern = '|(＼d+)|';
if(preg_match_all($pattern,$a,$match)){
	echo "<pre>";
	print_r($match);
}else{
	echo "没有";
}





?>